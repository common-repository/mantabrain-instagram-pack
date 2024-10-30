<?php
/**
 * MB_Instagram_Pack admin setup
 *
 * @package MB_Instagram_Pack
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Main MB_Instagram_Pack_Admin Class.
 *
 * @class MB_Instagram_Pack
 */
final class MB_Instagram_Pack_Admin
{

    /**
     * The single instance of the class.
     *
     * @var MB_Instagram_Pack_Admin
     * @since 1.0.0
     */
    protected static $_instance = null;


    /**
     * Main MB_Instagram_Pack_Admin Instance.
     *
     * Ensures only one instance of MB_Instagram_Pack_Admin is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return MB_Instagram_Pack_Admin - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    /**
     * MB_Instagram_Pack Constructor.
     */
    public function __construct()
    {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0.0
     */
    private function init_hooks()
    {

        add_action('admin_menu', array($this, 'admin_menu'));

        add_action('mb_instagram_pack_update_options_general', array($this, 'save_instagram_options'));

        add_filter('plugin_action_links_' . MB_INSTAGRAM_PACK_FILE, array($this, 'settings_link'), 10, 2);


    }

    function settings_link($links, $file)
    {
        $settings_link = '<a href="' . admin_url('admin.php?page=mb-instagram-pack') . '">' . __('Settings', 'mb-instagram-pack') . '</a>';

        array_unshift($links, $settings_link);

        return $links;
    }

    function admin_menu()
    {

        $cap = current_user_can('manage_mb_instagram_pack_options') ? 'manage_mb_instagram_pack_options' : 'manage_options';

        add_menu_page(
            __('Instagram Pack Setting Page', 'mb-instagram-pack'),
            __('Instagram', 'mb-instagram-pack'),
            $cap,
            'mb-instagram-pack',
            array($this, 'settings_page_init')
        );
        $settings_page = add_submenu_page(
            'settings.php',
            __('Settings', 'mb-instagram-pack'),
            __('Settings', 'mb-instagram-pack'),
            $cap,
            'mb-instagram-pack',
            array($this, 'settings')
        );

        add_action('load-' . $settings_page, array($this, 'settings_page_init'));
    }

    public function settings()
    {

        MB_Instagram_Pack_Admin_Settings::output();


    }

    public function settings_page_init()
    {

        global $current_tab, $current_section;

        // Include settings pages.
        MB_Instagram_Pack_Admin_Settings::get_settings_pages();

        // Get current tab/section.
        $current_tab = empty($_GET['tab']) ? 'general' : sanitize_title(wp_unslash($_GET['tab'])); // WPCS: input var okay, CSRF ok.
        $current_section = empty($_REQUEST['section']) ? '' : sanitize_title(wp_unslash($_REQUEST['section'])); // WPCS: input var okay, CSRF ok.

        // Save settings if data has been posted.
        if ('' !== $current_section && apply_filters("mb_instagram_pack_save_settings_{$current_tab}_{$current_section}", !empty($_POST['save']))) { // WPCS: input var okay, CSRF ok.
            MB_Instagram_Pack_Admin_Settings::save();
        } elseif ('' === $current_section && apply_filters("mb_instagram_pack_save_settings_{$current_tab}", !empty($_POST['save']))) { // WPCS: input var okay, CSRF ok.
            MB_Instagram_Pack_Admin_Settings::save();
        }

        // Add any posted messages.
        if (!empty($_GET['mb_instagram_pack_error'])) { // WPCS: input var okay, CSRF ok.
            MB_Instagram_Pack_Admin_Settings::add_error(wp_kses_post(wp_unslash($_GET['mb_instagram_pack_error']))); // WPCS: input var okay, CSRF ok.
        }

        if (!empty($_GET['mb_instagram_pack_message'])) { // WPCS: input var okay, CSRF ok.
            MB_Instagram_Pack_Admin_Settings::add_message(wp_kses_post(wp_unslash($_GET['mb_instagram_pack_message']))); // WPCS: input var okay, CSRF ok.
        }

        do_action('mb_instagram_pack_settings_page_init');


    }

    public function save_instagram_options()
    {
        global $mb_instagram_pack_global_options;

        $mb_instagram_pack_options = mb_instagram_pack_get_option('mb_instagram_pack_options', array(), true);

        $is_valid_token = isset($mb_instagram_pack_options['is_valid_token']) ? (boolean)$mb_instagram_pack_options['is_valid_token'] : false;

        $return_uri = admin_url('admin.php?page=mb-instagram-pack');

        $is_token_change = @$mb_instagram_pack_options['access_token'] != @$mb_instagram_pack_global_options['access_token'] ? true : false;

        /*$access_token = isset($_GET['access_token']) ? sanitize_text_field($_GET['access_token']) : '';

        $website_token_from_api = isset($_GET['website_token']) ? sanitize_text_field($_GET['website_token']) : '';

        $website_token = sha1('website_token' . $return_uri . $access_token);*/

        //if (!empty($access_token) && $website_token === $website_token_from_api) {

        if (!$is_valid_token || $is_token_change) {

            $access_token = isset($mb_instagram_pack_options['access_token']) ? $mb_instagram_pack_options['access_token'] : '';//'1574536848.1677ed0.3d87306f533542f090612e177032140a';

            $user_data = array();

            try {

                $result_body = MB_Instagram_Pack_API::instance()->get_user_from_token($access_token);

                $user_data = isset($result_body['data']['id']) ? $result_body['data'] : array();

                if (count($user_data) > 0) {

                    $mb_instagram_pack_options['is_valid_token'] = true;


                } else {

                    $mb_instagram_pack_options['is_valid_token'] = false;

                }

            } catch (Exception $e) {

                $mb_instagram_pack_options['is_valid_token'] = false;
            }
            $mb_instagram_pack_options['user_data'] = $user_data;

            $mb_instagram_pack_options['access_token'] = $access_token;

            update_option('mb_instagram_pack_options', $mb_instagram_pack_options);

            wp_safe_redirect($return_uri);
        }
     }

    /**
     * Include required core files used in admin.
     */
    public function includes()
    {

        include_once MB_INSTAGRAM_PACK_ABSPATH . 'includes/admin/class-mb-instagram-pack-admin-assets.php';

    }


}
