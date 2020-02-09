<?php

declare(strict_types = 1);

namespace AvtoDev\Composer\Cleanup;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Util\Filesystem;
use Composer\Plugin\PluginInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\Script\Event as ScriptEvent;
use Composer\EventDispatcher\EventSubscriberInterface;

final class Plugin implements PluginInterface, EventSubscriberInterface
{
    public const SELF_PACKAGE_NAME = 'avto-dev/composer-cleanup-plugin';

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        // Nothing to do here, as all features are provided through event listeners
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            PackageEvents::POST_PACKAGE_INSTALL => 'cleanup',
            PackageEvents::POST_PACKAGE_UPDATE  => 'cleanup',
        ];
    }

    /**
     * Cleanup executing.
     *
     * @param PackageEvent|ScriptEvent $composer_event
     *
     * @return void
     */
    public static function cleanup($composer_event): void
    {
        $io            = $composer_event->getIO();
        $composer      = $composer_event->getComposer();
        $fs            = new Filesystem;
        $global_rules  = Rules::getGlobalRules();
        $package_rules = Rules::getPackageRules();

        $installation_manager = $composer->getInstallationManager();

        $saved_size_bytes = 0;
        $start_time       = \microtime(true);

        // Loop over all installed packages
        foreach ($composer->getRepositoryManager()->getLocalRepository()->getPackages() as $package) {
            $package_name = $package->getName();
            $install_path = $installation_manager->getInstallPath($package);

            $saved_size_bytes += self::makeClean($install_path, $global_rules, $fs, $io);

            // Try to extract defined targets for a package
            if (isset($package_rules[$package_name])) {
                $saved_size_bytes += self::makeClean($install_path, $package_rules[$package_name], $fs, $io);
            }
        }

        if ($saved_size_bytes > 0) {
            $io->write(\sprintf(
                '<info>%s:</info> Cleanup done in %01.3f seconds (<comment>%d Kb</comment> saved)',
                self::SELF_PACKAGE_NAME,
                \microtime(true) - $start_time,
                $saved_size_bytes / 1024
            ));
        }
    }

    /**
     * @param string        $package_path
     * @param array<string> $rules
     * @param Filesystem    $fs
     * @param IOInterface   $io
     *
     * @return int
     */
    private static function makeClean(string $package_path, array $rules, Filesystem $fs, IOInterface $io): int
    {
        $saved_size_bytes = 0;

        foreach ($rules as $rule) {
            $paths = \glob($package_path . DIRECTORY_SEPARATOR . \ltrim(\trim($rule), '\\/'), \GLOB_ERR);

            if (\is_array($paths)) {
                foreach ($paths as $path) {
                    try {
                        $path_size = $fs->size($path);

                        if ($fs->remove($path)) {
                            $saved_size_bytes += $path_size;
                        }
                    } catch (\Throwable $e) {
                        $io->write(\sprintf(
                            '<info>%s:</info> Error occurred: <error>%s</error>',
                            self::SELF_PACKAGE_NAME,
                            $e->getMessage()
                        ));
                    }
                }
            }
        }

        return $saved_size_bytes;
    }
}
