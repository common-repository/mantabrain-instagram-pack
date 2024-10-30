<?php
/**
 * MB_Instagram_Pack Miscellaneous Settings
 *
 * @package MB_Instagram_Pack/Admin
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('MB_Instagram_Pack_Settings_General', false)) {
    return new MB_Instagram_Pack_Settings_General();
}

/**
 * MB_Instagram_Pack_Settings_General.
 */
class MB_Instagram_Pack_Settings_General extends MB_Instagram_Pack_Admin_Settings_Base
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->id = 'general';
        $this->label = __('General', 'mb-instagram-pack');

        parent::__construct();
    }

    /**
     * Get sections.
     *
     * @return array
     */
    public function get_sections()
    {
        $sections = array(
            '' => __('General', 'mb-instagram-pack'),
            'pages' => __('Pages', 'mb-instagram-pack'),
        );

        return apply_filters('mb_instagram_pack_get_sections_' . $this->id, $sections);
    }

    /**
     * Output the settings.
     */
    public function output()
    {
        global $current_section;

        $settings = $this->get_settings($current_section);

        MB_Instagram_Pack_Admin_Settings::output_fields($settings);
    }

    /**
     * Save settings.
     */
    public function save()
    {
        global $current_section;

        $settings = $this->get_settings($current_section);
        MB_Instagram_Pack_Admin_Settings::save_fields($settings);

        if ($current_section) {
            do_action('mb_instagram_pack_update_options_' . $this->id . '_' . $current_section);
        }
    }

    /**
     * Get settings array.
     *
     * @param string $current_section Current section name.
     * @return array
     */
    public function get_settings($current_section = '')
    {
        if ('pages' === $current_section) {
            $settings = apply_filters(
                'mb_instagram_pack_settings_general_pages',
                array(/*array(
                        'title' => __('Page Settings', 'mb-instagram-pack'),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'mb_instagram_pack_pages_options',
                    ),

                    array(
                        'title' => __('Checkout Page', 'mb-instagram-pack'),
                        'desc' => __('Checkout page for tour booking', 'mb-instagram-pack'),
                        'id' => 'mb_instagram_pack_checkout_page',
                        'type' => 'link',
                        'href' => 'https://google.com',
                        'default' => 'Instagram',
                    ),
                    array(
                        'title' => __('Thank you page', 'mb-instagram-pack'),
                        'desc' => __('Thank you page after tour booking', 'mb-instagram-pack'),
                        'id' => 'mb_instagram_pack_thankyou_page',
                        'type' => 'single_select_page',
                    ),
                    array(
                        'title' => __('Terms and conditions page', 'mb-instagram-pack'),
                        'desc' => __('Page for your terms and condition.', 'mb-instagram-pack'),
                        'id' => 'mb_instagram_pack_termsandconditions_page',
                        'type' => 'single_select_page',
                    ),

                    array(
                        'type' => 'sectionend',
                        'id' => 'mb_instagram_pack_pages_options',
                    ),*/

                )
            );

        } else {

            $website_token = sha1('website_token' . site_url());

            $token_url = 'https://api.instagram.com/oauth/authorize/?client_id=d5277d635c664bd4b0b0d5d7ee27d10d&scope=basic+public_content&redirect_uri=https://api.mantrabrain.com/plugins/instagram-token.php?return_uri=' . admin_url('admin.php?page=mb-instagram-pack') . '&response_type=code&state=' . admin_url('admin.php?page=mb-instagram-pack') . '&hl=en&website_token=' . $website_token;

            $token_url = 'https://instagram.pixelunion.net/';

            $settings = apply_filters(
                'mb_instagram_pack_settings_general_general',
                array(
                    array(
                        'title' => __('General Settings', 'mb-instagram-pack'),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'mb_instagram_pack_general_options',
                    ),
                    array(
                        'title' => '',
                        'desc' => __('Click here to get instagram token from here and paste it to Access Token Box and save it and add this [instagram_pack_feed] shortcode into your page,posts or widgets.', 'mb-instagram-pack'),
                        'id' => 'mb_instagram_pack_currency',
                        'default' => __('Click here to get instagram access token', 'mb-instagram-pack'),
                        'type' => 'link',
                        'href' => $token_url,
                        'target' => '_blank'
                    ),
                    array(
                        'title' => __('Access Token', 'mb-instagram-pack'),
                        'desc' => __('Instagram Access Token.', 'mb-instagram-pack'),
                        'id' => 'access_token',
                        'type' => 'text',
                    ),
                    array(
                        'title' => __('Instagram Gallery Grid', 'mb-instagram-pack'),
                        'desc' => __('Select grid for instagram feed', 'mb-instagram-pack'),
                        'id' => 'instagram_pack_feed_grid',
                        'default' => 3,
                        'type' => 'select',
                        'options' => array(
                            '1' => 1,
                            '2' => 2,
                            '3' => 3,
                            '4' => 4,
                        )
                    ),
                    array(
                        'title' => __('Per Page Posts', 'mb-instagram-pack'),
                        'desc' => __('Per Page Posts', 'mb-instagram-pack'),
                        'id' => 'per_page_posts',
                        'type' => 'number',
                        'default' => 10,
                    ),
                    array(
                        'title' => __('Hide post like counter', 'mb-instagram-pack'),
                        'desc' => __('Click here to hide post like counter for individual post', 'mb-instagram-pack'),
                        'id' => 'hide_post_like_count',
                        'type' => 'checkbox',
                    ), array(
                    'title' => __('Hide post comment counter', 'mb-instagram-pack'),
                    'desc' => __('Click here to hide post comment counter for individual post', 'mb-instagram-pack'),
                    'id' => 'hide_comment_count',
                    'type' => 'checkbox',
                ), array(
                    'title' => __('Load More Text', 'mb-instagram-pack'),
                    'desc' => __('Load more text button label', 'mb-instagram-pack'),
                    'id' => 'load_more_text',
                    'type' => 'text',
                    'default' => __('Load more..', 'mb-instagram-pack'),
                ), array(
                    'title' => __('Load More Loading Text', 'mb-instagram-pack'),
                    'desc' => __('Load more loading text button label', 'mb-instagram-pack'),
                    'id' => 'load_more_loading_text',
                    'type' => 'text',
                    'default' => __('Loading...', 'mb-instagram-pack'),
                ), array(
                    'title' => __('Follow text', 'mb-instagram-pack'),
                    'desc' => __('Follow text button label', 'mb-instagram-pack'),
                    'id' => 'follow_text',
                    'type' => 'text',
                    'default' => __('Follow', 'mb-instagram-pack'),
                ), array(
                    'type' => 'sectionend',
                    'id' => 'mb_instagram_pack_general_options',
                ),

                )

            );
        }

        return apply_filters('mb_instagram_pack_get_settings_' . $this->id, $settings, $current_section);
    }
}

return new MB_Instagram_Pack_Settings_General();
