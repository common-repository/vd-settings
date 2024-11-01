<?php

return array(
    \vdeo\controllers\PluginController::calledClassName() => array(
        'option_name' => 'vd_essential_settings',
        // list of actions for wp function remove_action()
        'remove_actions' => array(
            'wp_generator' => array(
                'type' => 'checkbox',
                'label' => __('Remove wp_generator', 'vd_eo_text_domain'),
                'value' => 'true',
                'annotation' => __('Remove displays the XHTML generator that is generated on the wp_head hook', 'vd_eo_text_domain'),
                'action_name' => 'wp_head'
            ),
            'rsd_link' => array(
                'type' => 'checkbox',
                'label' => __('Remove RSD Link', 'vd_eo_text_domain'),
                'value' => 'true',
                'annotation' => __('Remove Really Simple Discovery Link', 'vd_eo_text_domain'),
                'action_name' => 'wp_head'
            ),
            'adjacent_posts_rel_link_wp_head' => array(
                'type' => 'checkbox',
                'label' => __('Remove adjacent post links', 'vd_eo_text_domain'),
                'value' => 'true',
                'annotation' => __('Remove displays relational links for the posts adjacent to the current post for single post pages', 'vd_eo_text_domain'),
                'action_name' => 'wp_head'
            ),
            'feed_links' => array(
                'type' => 'checkbox',
                'label' => __('Remove RSS in posts and comments', 'vd_eo_text_domain'),
                'value' => 'true',
                'annotation' => __('Remove RSS in posts and comments', 'vd_eo_text_domain'),
                'action_name' => 'wp_head'
            ),
            'feed_links_extra' => array(
                'type' => 'checkbox',
                'label' => __('Remove RSS in archives and categories', 'vd_eo_text_domain'),
                'value' => 'true',
                'annotation' => __('Remove RSS in archives and categories', 'vd_eo_text_domain'),
                'action_name' => 'wp_head'
            ),
            'print_emoji_detection_script' => array(
                'type' => 'checkbox',
                'label' => __('Remove emoji script', 'vd_eo_text_domain'),
                'value' => 'true',
                'annotation' => __('Remove displays emoji script in front', 'vd_eo_text_domain'),
                'action_name' => 'wp_head'
            ),
            'print_emoji_styles' => array(
                'type' => 'checkbox',
                'label' => __('Remove emoji styles', 'vd_eo_text_domain'),
                'value' => 'true',
                'annotation' => __('Remove displays emoji styles in front', 'vd_eo_text_domain'),
                'action_name' => 'wp_print_styles'
            ),
        ),
        // wp action and filters with his own logic
        'config_functions' => array(
            'read_more_link' => array(
                'type' => 'text',
                'label' => __('Change text "Read more"', 'vd_eo_text_domain'),
                'value' => '',
                'annotation' => __('Function change text Read more link. Default : Read the full text', 'vd_eo_text_domain')
            ),
            'delay_posting_rss' => array(
                'type' => 'radio',
                'label' => __('Delay posting RSS feeds longer', 'vd_eo_text_domain'),
                'value' => array(
                    '30' => '30',
                    '60' => '60',
                    '120' => '120'
                ),
                'description' => 'Minutes',
                'annotation' => __('Delay posting to my RSS feeds longer', 'vd_eo_text_domain')
            ),
            'change_adminbar_logo' => array(
                'type' => 'media',
                'annotation' => __('Choose new image for admin bar logo', 'vd_eo_text_domain')
            ),
            'replace_howdy' => array(
                'type' => 'text',
                'label' => __('Change HOWDY in admin bar', 'vd_eo_text_domain'),
                'value' => '',
                'annotation' => __('Replace Howdy with Logged in as in WordPress bar', 'vd_eo_text_domain')
            ),
            'security_url_query' => array(
                'type' => 'checkbox',
                'label' => __('Security from URL-query', 'vd_eo_text_domain'),
                'value' => '',
                'annotation' => __('It checks for excessively long request strings (more than 255 characters) and for the presence of either the eval or base64 PHP functions in the URI. If one of these conditions is met, then the plug-in sends a 414 error to the browser', 'vd_eo_text_domain')
            ),
            'remove_footer_admin' => array(
                'type' => 'text',
                'label' => __('Change footer text', 'vd_eo_text_domain'),
                'value' => '',
                'annotation' => __('Change the footer text on WordPress admin dashboard', 'vd_eo_text_domain')
            ),
            'disable_hints' => array(
                'type' => 'checkbox',
                'label' => __('Disable WordPress Login Hints', 'vd_eo_text_domain'),
                'value' => '',
                'annotation' => __('Keeping your WordPress website secure is important and theres a little thing that will make a hackers life more difficult: not providing detailed error messages on the WordPress login page', 'vd_eo_text_domain')
            ),
            'stay_logged_in' => array(
                'type' => 'select',
                'label' => __('Stay logged in', 'vd_eo_text_domain'),
                'value' => array(
                    'default' => 'Default',
                    '3600' => '1 hour',
                    '86400' => '1 day',
                    '604800' => '1 week',
                    '1209600' => '2 weeks',
                    '2678400' => '1 months',
                    '15778800' => '6 months',
                    '31557600' => '1 year'
                ),
                'annotation' => __('Change extending the time of your WordPress login session', 'vd_eo_text_domain')
            ),
            'custom_admin_logo' => array(
                'type' => 'media',
                'annotation' => __('Change logo in admin login menu', 'vd_eo_text_domain')
            ),
            'custom_dashboard_name' => array(
                'type' => 'text',
                'label' => __('Change dashboard title', 'vd_eo_text_domain'),
                'value' => '',
                'annotation' => __('Change the dashboard name on WordPress admin', 'vd_eo_text_domain')
            ),
        )
    )
);
