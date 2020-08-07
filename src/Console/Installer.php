<?php
declare(strict_types=1);

namespace MixerApi\Console;

if (!defined('STDIN')) {
    define('STDIN', fopen('php://stdin', 'r'));
}

use Composer\Script\Event;

/**
 * Provides installation hooks for when this application is installed through
 * composer. Customize this class to suit your needs.
 */
class Installer
{
    /**
     * Does some routine installation tasks so people don't have to.
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @throws \Exception Exception raised by validator.
     * @return void
     */
    public static function postInstall(Event $event)
    {
        $io = $event->getIO();

        $rootDir = dirname(dirname(__DIR__));
        $readme = "$rootDir/assets/README.md";
        copy($readme, 'README.md');
        unlink($readme);
        rmdir("$rootDir/assets");

        $class = 'Cake\Codeception\Console\Installer';
        if (class_exists($class)) {
            $class::customizeCodeceptionBinary($event);
        }
    }
}