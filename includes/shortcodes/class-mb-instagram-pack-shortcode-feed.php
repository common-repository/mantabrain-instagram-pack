<?php
/**
 * Feed Shortcode
 *
 * Used on the checkout page, the checkout shortcode displays the checkout process.
 *
 * @package MB_Instagram_Pack/Shortcodes/Feed
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Shortcode checkout class.
 */
class MB_Instagram_Pack_Shortcode_Feed
{

    /**
     * Get the shortcode content.
     *
     * @param array $atts Shortcode attributes.
     * @return string
     */
    public static function get($atts)
    {
        return MB_Instagram_Pack_Shortcodes::shortcode_wrapper(array(__CLASS__, 'output'), $atts);
    }

    /**
     * Output the shortcode.
     *
     * @param array $atts Shortcode attributes.
     */
    public static function output($atts)
    {

        self::show_feed();

    }


    /**
     * Show the checkout.
     */
    private static function show_feed()
    {

        do_action('mb_instagram_pack_before_feed_template');

        $user_data = mb_instagram_pack_get_option('user_data', '');

        $is_valid_token = (boolean)mb_instagram_pack_get_option('is_valid_token', false);

        if ($is_valid_token) {

            $id = $user_data['id'];

            $per_page_posts = mb_instagram_pack_get_option('per_page_posts', 10);

            $feed_data = MB_Instagram_Pack_API::instance()->get_user_media($id, $per_page_posts);

            mb_instagram_pack_get_template('tmpl-feed.php', array(
                    'feed_data' => $feed_data,
                    'user_data' => $user_data
                )
            );

        } else {
            echo '<p style="font-size: 17px;font-style: italic;padding: 10px;background: wheat;color: #000;text-align: center;">' . __(' Instagram access token invalid, please contact your website administrator', 'mb-instagram-pack') . '</p>';
        }
        do_action('mb_instagram_pack_after_feed_template');


    }

    static function get_image_array($result_array = array())
    {
        $feed_data_array = array();

        foreach ($result_array['data'] as $single_result) {

            $images = isset($single_result['images']) ? $single_result['images'] : array();

            $feed_data = array();

            $feed_data['thumbnail'] = isset($images['low_resolution']) ? $images['low_resolution']['url'] : '';

            $feed_data['link'] = isset($single_result['link']) ? $single_result['link'] : '';

            $feed_data['likes'] = isset($single_result['likes']['count']) ? $single_result['likes']['count'] : 0;

            $feed_data['comments'] = isset($single_result['comments']['count']) ? $single_result['comments']['count'] : 0;

            array_push($feed_data_array, $feed_data);

        }
        return $feed_data_array;


    }

    static function get_user_data($result_array = array())
    {
        $user_data = isset($result_array['data']) ? $result_array['data'] : array();

        $user_data_first_index = isset($user_data[0]) ? $user_data[0] : array();

        $user_info = isset($user_data_first_index['user']) ? $user_data_first_index['user'] : array();

        return $user_info;

    }
}

