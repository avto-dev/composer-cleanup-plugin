<?php

declare(strict_types = 1);

namespace AvtoDev\Composer\Cleanup\Tests;

use AvtoDev\Composer\Cleanup\Rules;

/**
 * @covers \AvtoDev\Composer\Cleanup\Rules
 */
class RulesTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetRules(): void
    {
        foreach (Rules::getPackageRules() as $key => $value) {
            $this->assertIsString($key);
            $this->assertIsArray($value);
        }
    }

    /**
     * @return void
     */
    public function testGetGlobalRules(): void
    {
        $rules = Rules::getGlobalRules();

        foreach ($rules as $rule) {
            $this->assertIsString($rule);
        }
    }

    /**
     * @return void
     */
    public function testWIP(): void
    {
        $this->markTestIncomplete('TODO: Write better tests');
    }
}
