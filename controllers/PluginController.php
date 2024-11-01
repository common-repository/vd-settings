<?php

namespace vdeo\controllers;

use vdeo\components\Plugin;

class PluginController {

    public $remove_actions;
    public $config_functions;
    public $options;
    public $option_name;

    public function __construct() {
        if (!empty(Plugin::$config[self::selfClassName()])) {
            $this->configure($this, Plugin::$config[self::selfClassName()]);
        }

        add_action('admin_enqueue_scripts', array($this, 'wpActionAdminEnqueueScripts'));
        add_action('admin_menu', array($this, 'wpActionAdminMenu'));

        $this->options = get_option($this->option_name);

        $save = filter_input(INPUT_POST, 'vd_eo_save');
        if (!is_null($save)) {
            $this->setOptions();
        }

        $this->init();
    }

    public function init() {
        
    }

    public function setOptions() {
        $options = filter_input(INPUT_POST, Plugin::SHORT_NAME, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        if (isset($_FILES)) {
            foreach ($_FILES as $key => $value) {
                if (!array_key_exists($key, $this->config_functions) || empty($value['name']))
                    continue;

                $options[$key] = $this->uploadFile($value);
            }
        }

        update_option($this->option_name, array_filter($options));
        $this->options = $options;
    }

    public function wpActionAdminEnqueueScripts() {
        wp_enqueue_style(Plugin::SHORT_NAME, Plugin::$url . 'views/css/style.css');
        wp_enqueue_style('thickbox');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');        
        wp_enqueue_script(Plugin::SHORT_NAME . 'upload-js', Plugin::$url . 'views/js/upload.js', [], '', true);
    }

    public function wpActionAdminMenu() {
        add_options_page('Essential Options', 'Essential Options', 'read', 'vd-essential-options.php', function() {
            $config = array_merge($this->remove_actions, $this->config_functions);

            echo $this->render('form', array(
                'config' => $config,
                'options' => $this->options
            ));
        });
    }

    public function configure($object, $properties) {
        foreach ($properties as $name => $value)
            $object->$name = $value;

        return $object;
    }

    public function render($view, $params) {
        $file = Plugin::$path . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
        if (file_exists($file)) {
            ob_start();
            ob_implicit_flush(false);
            extract($params, EXTR_OVERWRITE);
            require( $file );

            return ob_get_clean();
        } else {
            return '';
        }
    }

    public function uploadFile($file) {
        if (!function_exists('wp_get_current_user')) {
            include(ABSPATH . "wp-includes/pluggable.php");
        }
        require_once( ABSPATH . 'wp-admin/includes/admin.php' );

        $file_return = wp_handle_upload($file, array('test_form' => false));

        if (isset($file_return['error']) || isset($file_return['upload_error_handler'])) {
            return '';
        } else {
            $filename = $file_return['file'];

            $attachment = array(
                'post_mime_type' => $file_return['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                'post_content' => '',
                'post_status' => 'inherit',
                'guid' => $file_return['url']
            );

            $attachment_id = wp_insert_attachment($attachment, $file_return['url']);

            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $filename);
            wp_update_attachment_metadata($attachment_id, $attachment_data);

            if (0 < intval($attachment_id)) {
                return $attachment_id;
            }
        }

        return '';
    }

    public static function calledClassName() {
        return get_called_class();
    }

    public static function selfClassName() {
        return get_class();
    }

}
