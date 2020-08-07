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

        self::readme($io, $rootDir, $package, $name);
        self::composer($io, $package, $name);

        $class = 'Cake\Codeception\Console\Installer';
        if (class_exists($class)) {
            $class::customizeCodeceptionBinary($event);
        }
    }

    /**
     * Copies README from assets, removes assets, and updates placeholder text
     *
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @param string $dir
     * @param string $package
     * @param string $name
     * @return void
     */
    public static function readme($io, string $dir, string $package, string $name): void
    {
        $readme = "$dir/assets/README.md";

        if (!file_exists($readme)) {
            $io->write("Error encountered modifying README `$readme` does not exist");

            return;
        }

        if (!copy($readme, 'README.md')) {
            $io->write("Unable to copy `$readme`, check permissions");
        }

        if (!unlink($readme)) {
            $io->write("Unable to remove `$readme`, remove assets/ manually");
        }

        rmdir("$dir/assets");

        if ($package == 'plugin') {
            return;
        }

        $contents = file_get_contents('README.md');
        $contents = str_replace('{PLUGIN_NAME}', $name, $contents);
        $contents = str_replace('{PACKAGE}', $package, $contents);

        if (!file_put_contents('README.md', $contents)) {
            $io->write("Unable to update contents of your README, check permissions");

            return;
        }

        $io->write("README updated");
    }

    /**
     * Update placeholder text in composer
     *
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @param string $package
     * @param string $name
     * @return void
     */
    public static function composer($io, string $package, string $name): void
    {
        if ($package == 'plugin') {
            return;
        }

        $pkg = 'mixerapi/' . $package;
        $ns = "MixerApi\\$name";

        $contents = file_get_contents('composer.json');
        $contents = str_replace('mixerapi/plugin', $pkg, $contents);
        $contents = str_replace('MixerApi\\', $ns, $contents);

        if (!file_put_contents('composer.json', $contents)) {
            $io->write("Unable to update contents of your composer.json, check permissions");
        }
    }
}