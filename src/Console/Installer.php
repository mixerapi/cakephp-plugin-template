<?php
declare(strict_types=1);

namespace MixerApi\Console;

if (!defined('STDIN')) {
    define('STDIN', fopen('php://stdin', 'r'));
}

use Composer\Script\Event;
use Cake\Utility\Inflector;

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
        $package = basename(dirname(dirname(__DIR__)));
        $name = Inflector::camelize($package);

        self::readme($rootDir, $package, $name);
        self::composer($package, $name);

        $class = 'Cake\Codeception\Console\Installer';
        if (class_exists($class)) {
            $class::customizeCodeceptionBinary($event);
        }
    }

    public static function readme($dir, $package, $name)
    {
        $readme = "$dir/assets/README.md";

        if (!file_exists($readme)) {
            return;
        }

        copy($readme, 'README.md');
        unlink($readme);
        rmdir("$dir/assets");

        $contents = file_get_contents('README.md');
        $contents = str_replace('{PLUGIN_NAME}', $name, $contents);
        $contents = str_replace('{PACKAGE}', $package, $contents);

        file_put_contents('README.md', $contents);
    }

    public static function composer($package, $name)
    {
        $pkg = 'mixerapi/' . $package;
        $ns = "MixerApi\\$name";

        $contents = file_get_contents('composer.json');
        $contents = str_replace('mixerapi/plugin', $pkg, $contents);
        $contents = str_replace('MixerApi\\', $ns, $contents);

        file_put_contents('composer.json', $contents);
    }
}