<?php

namespace 14mb1v45h\MalwareScanner;

use 14mb1v45h\MalwareScanner\Admin\AdminPage;
use 14mb1v45h\MalwareScanner\Core\Scanner;
use 14mb1v45h\MalwareScanner\Core\YaraIntegration;
use 14mb1v45h\MalwareScanner\Core\Activator;
use 14mb1v45h\MalwareScanner\Core\Deactivator;

class Init
{
    /**
     * Store all the classes that will be registered.
     *
     * @return array List of classes
     */
    public static function get_services() {
        return [
            AdminPage::class,
            Scanner::class,
            YaraIntegration::class,
        ];
    }

    /**
     * Loop through the classes, initialize them,
     * and call the `register()` method if it exists.
     */
    public static function register_services() {
        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class.
     *
     * @param string $class Class from the services array
     * @return object Instance of the class
     */
    private static function instantiate($class) {
        // Special case for YaraIntegration class to pass required argument
        if ($class === YaraIntegration::class) {
            $yara_rules_path = plugin_dir_path(__FILE__) . 'rules/malware_rules.yar';
            return new $class($yara_rules_path);
        }

        // For other classes, instantiate as usual
        return new $class();
    }

    /**
     * Plugin activation hook.
     */
    public static function activate() {
        Activator::activate();
    }

    /**
     * Plugin deactivation hook.
     */
    public static function deactivate() {
        Deactivator::deactivate();
    }
}