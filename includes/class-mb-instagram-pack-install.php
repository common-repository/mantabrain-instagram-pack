<?php
/**
 * MB_Instagram_Pack install setup
 *
 * @package MB_Instagram_Pack
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Main MB_Instagram_Pack_Install Class.
 *
 * @class MB_Instagram_Pack
 */
final class MB_Instagram_Pack_Install
{

    public static function install()
    {
        $mb_instagram_pack_version = get_option('mb_instagram_pack_plugin_version');

        if (empty($mb_instagram_pack_version)) {
            self::install_content_and_options();
            self::add_cap();
        } else {
            update_option('mb_instagram_pack_plugin_version', MB_INSTAGRAM_PACK_VERSION);
        }

    }

    private static function install_content_and_options()
    {
        $pages = array(

            array(
                'post_content' => '[instagram_pack_feed]',
                'post_title' => 'Instagram Pack Feed Page',
                'post_status' => 'publish',
                'post_type' => 'page',
            ),
        );

        foreach ($pages as $page) {

            $page_id = wp_insert_post($page);

            /* if ($page['post_title'] == 'MB_Instagram_Pack Checkout') {
                 update_option('mb_instagram_pack_checkout_page', $page_id);
             }
             if ($page['post_title'] == 'MB_Instagram_Pack Thank You') {
                 update_option('mb_instagram_pack_thankyou_page', $page_id);
             }*/

        }

        $options = array(); // Default Options goes here

        foreach ($options as $option_key => $option_value) {

            update_option($option_key, $option_value);
        }

    }

    public static function add_cap()
    {
        global $wp_roles;

        $wp_roles->add_cap('administrator', 'manage_mb_instagram_pack_options');
    }

    public static function init()
    {

    }


}

MB_Instagram_Pack_Install::init();