<?php

namespace vdeo\controllers;

class OptionsController extends PluginController {

    public function init() {
        $this->callRemoveActions();
        $this->callCustomFunctions();
    }

    public function callRemoveActions() {
        if (empty($this->options))
            return;

        foreach ($this->remove_actions as $action_name => $value) {
            if (in_array($action_name, array_keys($this->options))) {
                remove_action($value['action_name'], $action_name);
            }
        }
    }

    public function callCustomFunctions() {
        if (empty($this->options))
            return;

        foreach ($this->config_functions as $action_name => $action_value) {
            if (in_array($action_name, array_keys($this->options)) && method_exists($this, $action_name)) {
                call_user_func_array(array($this, $action_name), array($this->options[$action_name]));
            }
        }
    }

    // custom functions
    public function read_more_link($option) {
        add_filter('the_content_more_link', function() use ($option) {
            return '<a class="more-link" href="' . get_permalink() . '">' . $option . '</a>';
        });
    }

    public function delay_posting_rss($option) {
        add_filter('posts_where', function($where) use ($option) {
            global $wpdb;

            if (is_feed()) {
                $now = gmdate('Y-m-d H:i:s');
                $where .= " AND TIMESTAMPDIFF(MINUTE, $wpdb->posts.post_date_gmt, '$now') > $option ";
            }

            return $where;
        });
    }

    public function change_adminbar_logo($option) {
        add_filter('admin_head', function() use ($option) {
            echo '<style type="text/css">
		#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
                content: " ";
                background-image: url(' . $option . ') !important;
                background-size: contain;
                background-position: center;
                top: 2px;
                width: 32px;
	            height: 32px;
                position: absolute;
            }

            #wpadminbar #wp-admin-bar-wp-logo > a.ab-item {
                pointer-events: none;
                cursor: default;
            }   
	    </style>';
        });
    }

    public function replace_howdy($option) {
        add_filter('admin_bar_menu', function($wp_admin_bar) use ($option) {
            $my_account = $wp_admin_bar->get_node('my-account');

            $substring = mb_substr($my_account->title, mb_strpos($my_account->title, ', '));

            $wp_admin_bar->add_node(array(
                'id' => 'my-account',
                'title' => $option . $substring,
            ));
        });
    }

    public function security_url_query() {
        add_action('init', function() {
            global $user_ID;

            if ($user_ID) {
                if (!current_user_can('level_10')) {
                    if (strlen($_SERVER['REQUEST_URI']) > 255 || strpos($_SERVER['REQUEST_URI'], "eval(") || strpos($_SERVER['REQUEST_URI'], "CONCAT") || strpos($_SERVER['REQUEST_URI'], "UNION+SELECT") || strpos($_SERVER['REQUEST_URI'], "base64")) {

                        @header("HTTP/1.1 414 Request-URI Too Long");
                        @header("Status: 414 Request-URI Too Long");
                        @header("Connection: Close");

                        @exit;
                    }
                }
            }
        });
    }

    public function remove_footer_admin($option) {
        add_filter('admin_footer_text', function() use ($option) {
            return '<p>' . $option . '</p>';
        });
    }

    public function disable_hints() {
        add_filter('login_errors', function() {
            return __('Sorry, you enter incorrect data!', 'vd_eo_text_domain');
        });
    }

    public function stay_logged_in($option) {
        add_filter('auth_cookie_expiration', function($default) use ($option) {
            if ($option != "default" && isset($option)) {
                return $option;
            } else {
                return $default;
            }
        });
    }

    public function custom_admin_logo($option) {
        add_action('login_head', function() use ($option) {
            echo '<style type="text/css">	  
	          #login h1 a { 
	          background-image: url(' . $option . ') !important;
	          }	          
	        </style>';
        });
    }

    public function custom_dashboard_name() {
        add_action('admin_menu', array($this, 'custom_dashboard_name_function'));
        add_action('admin_head', array($this, 'custom_dashboard_name_function'));
    }

    public function custom_dashboard_name_function() {
        global $menu;

        $menu[2][0] = __($this->options['custom_dashboard_name'], 'vd_eo_text_domain');

        $GLOBALS['title'] = __($this->options['custom_dashboard_name'], 'vd_eo_text_domain');
    }

}
