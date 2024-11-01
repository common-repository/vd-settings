<?php

namespace vdeo\components;

use vdeo\controllers\OptionsController;

class Plugin {

    const VERSION = '1.0.4';
    const NAME = 'Essential Options';
    const SHORT_NAME = 'vd_eo';

    public static $config;
    public static $path;
    public static $url;

    /**
     * @var Lang
     */
    public static $options_controllers;
    
    
    public static function run($config) {
        if (isset($config)) {
            self::$config = $config;
            Plugin::$options_controllers = new OptionsController();
        }
    }

}
