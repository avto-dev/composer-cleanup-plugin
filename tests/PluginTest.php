<?php

declare(strict_types = 1);

namespace AvtoDev\Composer\Cleanup\Tests;

use ReflectionMethod;
use AvtoDev\Composer\Cleanup\Plugin;
use Composer\Installer\PackageEvents;

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

        $this->assertArrayHasKey(PackageEvents::POST_PACKAGE_INSTALL, $subs);
        $this->assertSame('handlePostPackageInstallEvent', $subs[PackageEvents::POST_PACKAGE_INSTALL]);

        $this->assertArrayHasKey(PackageEvents::POST_PACKAGE_UPDATE, $subs);
        $this->assertSame('handlePostPackageUpdateEvent', $subs[PackageEvents::POST_PACKAGE_UPDATE]);
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
