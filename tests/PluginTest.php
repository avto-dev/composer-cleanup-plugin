<?php

declare(strict_types = 1);

namespace AvtoDev\Composer\Cleanup\Tests;

use Composer\Script\ScriptEvents;
use AvtoDev\Composer\Cleanup\Plugin;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Plugin::class)]
class PluginTest extends AbstractTestCase
{
    public function testConstants(): void
    {
        $this->assertSame('avto-dev/composer-cleanup-plugin', Plugin::SELF_PACKAGE_NAME);
    }

    public function testGetSubscribedEvents(): void
    {
        $subs = Plugin::getSubscribedEvents();

        $this->assertArrayHasKey(ScriptEvents::POST_AUTOLOAD_DUMP, $subs);
        $this->assertSame('cleanupAllPackages', $subs[ScriptEvents::POST_AUTOLOAD_DUMP]);
    }

    public function testMethodsAccess(): void
    {
        $this->assertTrue((new \ReflectionMethod(Plugin::class, 'cleanupAllPackages'))->isPublic());
        $this->assertTrue((new \ReflectionMethod(Plugin::class, 'handlePostPackageInstallEvent'))->isPublic());
        $this->assertTrue((new \ReflectionMethod(Plugin::class, 'handlePostPackageUpdateEvent'))->isPublic());
    }
}
