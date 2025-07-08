<?php

declare(strict_types = 1);

namespace AvtoDev\Composer\Cleanup;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Rules
{
    protected const VENDOR_RULES          = __DIR__ . \DIRECTORY_SEPARATOR . '../clean_rules.php';
    protected const OVERRIDE_RULES        = __DIR__ . \DIRECTORY_SEPARATOR . '../../../../clean_rules.php';
    private const INCLUDED_GLOBAL_FIELD   = 'global';
    private const EXCLUDED_GLOBAL_FIELD   = 'excluded_global';
    private const INCLUDED_PACKAGES_FIELD = 'packages';
    private const EXCLUDED_PACKAGES_FIELD = 'excluded_packages';

    /**
     * @var array{global: array<string>, packages: array<string, array<int|string,array<string>>>,excluded_global: array<string>, excluded_packages: array<string, array<int|string,array<string>>|null>}
     */
    private array $full_rules_list;

    public function __construct()
    {
        /** @phpstan-ignore-next-line */
        $this->full_rules_list = \array_merge_recursive($this->getVendorRules(), $this->getOverrideRules());
    }

    /**
     * @return array<string>
     */
    public function getGlobalRules(): mixed
    {
        return $this->full_rules_list[self::INCLUDED_GLOBAL_FIELD] ?? [];
    }

    /**
     * @return array<string>
     */
    public function getExcludedGlobalRules(): mixed
    {
        return $this->full_rules_list[self::EXCLUDED_GLOBAL_FIELD] ?? [];
    }

    /**
     * @param string $package_name
     *
     * @return array<string>
     */
    public function findIncludedByPackageName(string $package_name): array
    {
        // Return empty list if package is fully excluded
        if ($this->findExcludedByPackageName($package_name) === null) {
            return [];
        }

        return $this->getFlattenList($this->full_rules_list[self::INCLUDED_PACKAGES_FIELD][$package_name] ?? []);
    }

    /**
     * @param string $package_name
     *
     * @return array<string>|null
     */
    public function findExcludedByPackageName(string $package_name): ?array
    {
        $excluded_rules_exists = \array_key_exists($package_name, $this->full_rules_list[self::EXCLUDED_PACKAGES_FIELD]);

        if ($excluded_rules_exists) {
            $excluded_rules = $this->full_rules_list[self::EXCLUDED_PACKAGES_FIELD][$package_name];

            return \is_array($excluded_rules)
                ? $this->getFlattenList($excluded_rules)
                : null;
        }

        return [];
    }

    /**
     * @return array<string, array<int|string,array<string>>>
     */
    protected function getVendorRules(): array
    {
        if (\file_exists($clean_rules = static::VENDOR_RULES)) {
            return require $clean_rules;
        }

        throw new FileNotFoundException('Cannot find rules list');
    }

    /**
     * @return array<string, array<int|string,array<string>>>
     */
    protected function getOverrideRules(): array
    {
        if (\file_exists($clean_rules = static::OVERRIDE_RULES)) {
            return require $clean_rules;
        }

        return [];
    }

    /**
     * @param array<mixed> $rules
     * @param string       $path
     *
     * @return array<string>
     */
    private function getFlattenList(array $rules, string $path = ''): array
    {
        $results = [];

        foreach ($rules as $path_name => $package_rule) {
            if (\is_array($package_rule) && $package_rule !== []) {
                $results = \array_merge($results, $this->getFlattenList($package_rule, $path . $path_name . '/'));
            } else {
                if ((array) $package_rule === []) {
                    $package_rule = $path_name;
                }
                $results[] = \trim($path . $package_rule, '/');
            }
        }

        return $results;
    }
}
