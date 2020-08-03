<?php
declare(strict_types=1);

namespace MixerApi\Console;

if (!defined('STDIN')) {
    define('STDIN', fopen('php://stdin', 'r'));
}

use Cake\Utility\Security;
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

        static::updateComposer($rootDir, $io);
        static::updateReadme($rootDir, $io);

        $class = 'Cake\Codeception\Console\Installer';
        if (class_exists($class)) {
            $class::customizeCodeceptionBinary($event);
        }
    }

    public static function updateComposer($dir, $appName, $packageName, $io)
    {
        $file = $dir . '/composer.json';
        $content = file_get_contents($file);
        $content = str_replace(
            'mixerapi/cakephp-plugin-template',
            "mixerapi/$packageName",
            $content,
            $count
        );

        $content = str_replace(
            'CakePHP skeleton plugin',
            "MixerApi plugin",
            $content,
            $count
        );

        $content = str_replace(
            'MixerApi' . '/\\/',
            'MixerApi' . '/\\/' . $appName . '/\\/',
            $content,
            $count
        );

        $content = str_replace(
            'https://github.com/mixerapi/cakephp-plugin-template',
            'https://github.com/mixerapi/' . $packageName,
            $content,
            $count
        );

        $result = file_put_contents($file, $content);
        if ($result) {
            $io->write('Updated ' . $file);

            return;
        }
        $io->write('Unable to update ' . $file);
    }

    public static function updateReadme($dir, $pluginName, $packageName, $io)
    {
        $file = $dir . DS . 'README.md';
        unlink($file);
        copy($dir . DS . 'assets' . DS . 'README.md', $file);

        $file = $dir . DS . 'README.md';
        $content = file_get_contents($file);
        $content = str_replace(
            '{PLUGIN_NAME}',
            "$pluginName",
            $content,
            $count
        );

        $content = str_replace(
            '{PACKAGE_NAME}',
            "$packageName",
            $content,
            $count
        );

        $result = file_put_contents($file, $content);
        if ($result) {
            $io->write('Updated ' . $file);

            return;
        }
        $io->write('Unable to update ' . $file);
    }
}