<?php

declare(strict_types = 1);

namespace AvtoDev\Composer\Cleanup;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Util\Filesystem;
use Composer\Script\ScriptEvents;
use Composer\Installer\PackageEvent;
use Composer\Plugin\PluginInterface;
use Symfony\Component\Finder\Finder;
use Composer\Package\PackageInterface;
use Composer\Script\Event as ScriptEvent;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\DependencyResolver\Operation\InstallOperation;

final class Plugin implements PluginInterface, EventSubscriberInterface
{
    public const SELF_PACKAGE_NAME         = 'avto-dev/composer-cleanup-plugin';
    private const PACKAGE_TYPE_METAPACKAGE = 'metapackage';

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        // Nothing to do here, as all features are provided through event listeners
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function deactivate(Composer $composer, IOInterface $io): void
    {
        // Nothing to do here
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function uninstall(Composer $composer, IOInterface $io): void
    {
        // Nothing to do here
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::POST_AUTOLOAD_DUMP => 'cleanupAllPackages',
        ];
    }

    /**
     * @param ScriptEvent $event
     *
     * @return void
     */
    public static function cleanupAllPackages(ScriptEvent $event): void
    {
        $start_time           = \microtime(true);
        $io                   = $event->getIO();
        $composer             = $event->getComposer();
        $installation_manager = $composer->getInstallationManager();

        $fs = new Filesystem();

        $rules = new Rules();

        /** @var string $vendor_dir */
        $vendor_dir = $composer->getConfig()->get('vendor-dir');

        $saved_size_bytes = self::cleanFiles(
            $fs,
            $io,
            $vendor_dir,
            $rules->getGlobalRules(),
            $rules->getExcludedGlobalRules(),
        );

        // Loop over all installed packages
        foreach ($composer->getRepositoryManager()->getLocalRepository()->getPackages() as $package) {
            if (self::isMetapackage($package)) {
                continue;
            }

            $package_name = $package->getName();
            $install_path = $installation_manager->getInstallPath($package) ?: '';

            if ($rules_list = $rules->findIncludedByPackageName($package_name)) {
                $excluded_rules = $rules->findExcludedByPackageName($package_name);
                $saved_size_bytes += self::cleanFiles(
                    $fs,
                    $io,
                    $install_path,
                    $rules_list,
                    $excluded_rules
                );
            }
        }

        $io->write(\sprintf(
            '<info>%s:</info> Cleanup done in %01.3f seconds (<comment>%d Kb</comment> saved)',
            self::SELF_PACKAGE_NAME,
            \microtime(true) - $start_time,
            $saved_size_bytes / 1024
        ));
    }

    /**
     * @param PackageEvent $event
     *
     * @return void
     */
    public static function handlePostPackageInstallEvent(PackageEvent $event): void
    {
        $operation = $event->getOperation();

        if ($operation instanceof InstallOperation) {
            self::cleanupPackage($operation->getPackage(), $event->getIO(), $event->getComposer());
        }
    }

    /**
     * @param PackageEvent $event
     *
     * @return void
     */
    public static function handlePostPackageUpdateEvent(PackageEvent $event): void
    {
        $operation = $event->getOperation();

        if ($operation instanceof UpdateOperation) {
            self::cleanupPackage($operation->getTargetPackage(), $event->getIO(), $event->getComposer());
        }
    }

    /**
     * @param PackageInterface $package
     * @param IOInterface      $io
     * @param Composer         $composer
     *
     * @return void
     */
    protected static function cleanupPackage(PackageInterface $package, IOInterface $io, Composer $composer): void
    {
        if (self::isMetapackage($package)) {
            return;
        }

        $rules            = new Rules();
        $fs               = new Filesystem();
        $saved_size_bytes = 0;
        $package_rules    = $rules->findIncludedByPackageName($package->getName());

        $install_path = $composer->getInstallationManager()->getInstallPath($package) ?: '';

        // use global rules at first
        $saved_size_bytes += self::cleanFiles($fs, $io, $install_path, $rules->getGlobalRules(),$rules->getExcludedGlobalRules());

        // then check for individual package rule
        if ($package_rules) {
            $excluded_rules = $rules->findExcludedByPackageName($package->getName());

            $saved_size_bytes += self::cleanFiles($fs, $io, $install_path, $package_rules, $excluded_rules);
        }

        if ($saved_size_bytes > 1024 * 32 || $io->isVerbose() || $io->isVeryVerbose()) {
            $io->write(\sprintf('    ↳ Cleanup done: <comment>%d Kb</comment> saved', $saved_size_bytes / 1024));
        }
    }

    /**
     * @param Filesystem    $fs
     * @param IOInterface   $io
     * @param string        $package_path
     * @param array<string> $included_rules
     * @param array<string> $excluded_rules
     *
     * @return int
     */
    private static function cleanFiles(Filesystem $fs, IOInterface $io, string $package_path, array $included_rules, array $excluded_rules): int
    {
        $finder = new Finder();

        $iterator = $finder
            ->in($package_path)
            ->path($included_rules)
            ->notPath($excluded_rules)
            ->ignoreDotFiles(false)
            ->sortByType()
            ->reverseSorting();

        $saved_size_bytes = 0;

        /** @var \SplFileInfo $item */
        foreach ($iterator as $item) {
            try {
                if (! $item->isDir() || $fs->isDirEmpty($item->getPathname())) {
                    $saved_size_bytes += $fs->size($item->getPathname());
                    $fs->remove($item->getPathname());
                }
            } catch (\Throwable $e) {
                $io->writeError(\sprintf(
                    '<info>%s:</info> Error occurred: %s',
                    self::SELF_PACKAGE_NAME,
                    $e->getMessage()
                ));
            }
        }

        return $saved_size_bytes;
    }

    /**
     * Metapackage is an empty package that contains requirements and will trigger their installation,
     * but contains no files and will not write anything to the filesystem.
     *
     * @param PackageInterface $package
     *
     * @return bool
     */
    private static function isMetapackage(PackageInterface $package): bool
    {
        return $package->getType() === self::PACKAGE_TYPE_METAPACKAGE;
    }
}
