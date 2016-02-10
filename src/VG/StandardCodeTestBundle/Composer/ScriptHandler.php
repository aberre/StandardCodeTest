<?php


namespace VG\StandardCodeTestBundle\Composer;
use Composer\Script\CommandEvent;


class ScriptHandler extends \Sensio\Bundle\DistributionBundle\Composer\ScriptHandler {

    /**
     * Install the app
     *
     * @param $event CommandEvent A instance
     */
    public static function installApp(CommandEvent $event) {
        $options = self::getOptions($event);
        $consoleDir = self::getConsoleDir($event, 'Install App');

        if (null === $consoleDir) {
            return;
        }
        static::executeCommand($event, $consoleDir, 'doctrine:schema:create');
        static::executeCommand($event, $consoleDir, 'vg:install');
    }
}