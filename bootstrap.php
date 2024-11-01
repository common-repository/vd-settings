<?php
/*
  Plugin Name: Viaduct Essential Options
  Description: Viaduct Essential Options is a small plugin which helps admins to easily enable some of the options without manually adding them into functions.php
  Version: 1.0.4
  Author: Viaduct.pro
  Text Domain: vd_eo_text_domain
 */

namespace vdeo;

use vdeo\components\Plugin;

if (!defined('WPINC')) {
    die;
}

function autoload($class) {
    $class = ltrim($class, '\\');
    if (strpos($class, __NAMESPACE__) !== 0) {
        return;
    }

    $class = str_replace(__NAMESPACE__, '', $class);

    $path = plugin_dir_path(__FILE__) . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    require_once( $path );
}

spl_autoload_register(__NAMESPACE__ . '\\autoload');

Plugin::$path = plugin_dir_path(__FILE__);
Plugin::$url = plugin_dir_url(__FILE__);
Plugin::run(require_once plugin_dir_path(__FILE__) . 'config' . DIRECTORY_SEPARATOR . 'config.php');