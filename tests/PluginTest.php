<?php

declare(strict_types = 1);

namespace AvtoDev\Composer\Cleanup\Tests;

use ReflectionMethod;
use Composer\Script\ScriptEvents;
use AvtoDev\Composer\Cleanup\Plugin;

/**
 * @covers \AvtoDev\Composer\Cleanup\Plugin
 */
class PluginTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testConstants(): void
    {
        $this->assertSame('avto-dev/composer-cleanup-plugin', Plugin::SELF_PACKAGE_NAME);
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $subs = Plugin::getSubscribedEvents();

        $this->assertArrayHasKey(ScriptEvents::POST_AUTOLOAD_DUMP, $subs);
        $this->assertSame('cleanupAllPackages', $subs[ScriptEvents::POST_AUTOLOAD_DUMP]);
    }

    /**
     * @return void
     */
    public function testMethodsAccess(): void
    {
        $this->assertTrue((new ReflectionMethod(Plugin::class, 'cleanupAllPackages'))->isPublic());
        $this->assertTrue((new ReflectionMethod(Plugin::class, 'handlePostPackageInstallEvent'))->isPublic());
        $this->assertTrue((new ReflectionMethod(Plugin::class, 'handlePostPackageUpdateEvent'))->isPublic());
    }

    /**
     * @return void
     */
    public function testWIP(): void
    {
        $this->markTestIncomplete('TODO: Write better tests');
    }
}
