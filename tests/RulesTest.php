<?php

declare(strict_types = 1);

namespace AvtoDev\Composer\Cleanup\Tests;

use AvtoDev\Composer\Cleanup\Rules;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

#[CoversClass(Rules::class)]

class RulesTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetRules(): void
    {
        $rules = new Rules();

        $included_rules = $rules->findIncludedByPackageName('unisharp/laravel-filemanager');

        $expected = [
            'tests',
            'docs',
            'src/lang/ar', 'src/lang/az', 'src/lang/bg', 'src/lang/de', 'src/lang/el', 'src/lang/eu', 'src/lang/fa', 'src/lang/fr', 'src/lang/he', 'src/lang/hu', 'src/lang/id', 'src/lang/it', 'src/lang/ka',
            'src/lang/nl', 'src/lang/pl', 'src/lang/pt', 'src/lang/pt-BR', 'src/lang/ro', 'src/lang/rs', 'src/lang/sv', 'src/lang/tr', 'src/lang/uk', 'src/lang/vi', 'src/lang/zh-CN', 'src/lang/zh-TW',
        ];
        $this->assertEquals($expected, $included_rules);

    }

    public function testGetGlobalRules(): void
    {
        $rules = new Rules();

        foreach ($rules->getGlobalRules() as $rule) {
            $this->assertIsString($rule);
        }
    }

    public function testGetExcludedGlobalRules(): void
    {
        $rules = new Rules();

        $this->assertEquals([], $rules->getExcludedGlobalRules());
    }

    public function testFindByPackageNameWithUnset(): void
    {
        $rules = new class extends Rules {
            public function getOverrideRules(): array
            {
                return [
                    'excluded_packages' => [
                        'unisharp/laravel-filemanager' => null,
                    ],
                ];
            }
        };

        $this->assertEquals([], $rules->findIncludedByPackageName('unisharp/laravel-filemanager'));
        $this->assertEquals([], $rules->findExcludedByPackageName('unisharp/laravel-filemanager'));
    }

    public function testFindIncludedByPackageName(): void
    {
        $rules = new class extends Rules {
            public function getOverrideRules(): array
            {
                return [
                    'excluded_packages' => [
                        'unisharp/laravel-filemanager' => [
                            'src/lang',
                        ],
                    ],
                ];
            }
        };

        $this->assertEquals(['src/lang'], $rules->findExcludedByPackageName('unisharp/laravel-filemanager'));
    }

    public function testFindIncludedByPackageNameWithEmpty(): void
    {
        $rules = new class extends Rules {
            public function getOverrideRules(): array
            {
                return [
                    'excluded_packages' => [
                        'unisharp/laravel-filemanager' => [
                            'src/lang' => [],
                        ],
                    ],
                ];
            }
        };

        $this->assertEquals(['src/lang'], $rules->findExcludedByPackageName('unisharp/laravel-filemanager'));
    }

    public function testWithNoFile(): void
    {
        $this->expectException(FileNotFoundException::class);

        new class extends Rules {
            protected const VENDOR_RULES = 'foo';
        };
    }

    public function testWithOverrideFile(): void
    {
        $rules = new class extends Rules {
            protected const OVERRIDE_RULES = __DIR__ . \DIRECTORY_SEPARATOR . '../.clean_rules.php';

            public function getVendorRules(): array
            {
                return parent::getVendorRules();
            }

            public function getOverrideRules(): array
            {
                return parent::getOverrideRules();
            }
        };
        $this->assertEquals($rules->getOverrideRules(), $rules->getVendorRules());
    }
}
