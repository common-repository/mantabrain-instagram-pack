<?php
/**
 * Shortcodes
 *
 * @package MB_Instagram_Pack/Classes
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

/**
 * MB_Instagram_Pack Shortcodes class.
 */
class MB_Instagram_Pack_Shortcodes
{

    /**
     * Init shortcodes.
     */
    public static function init()
    {

        $shortcodes = array(

            'instagram_pack_feed' => __CLASS__ . '::feed',
        );

        foreach ($shortcodes as $shortcode => $function) {
            add_shortcode(apply_filters("{$shortcode}_shortcode_tag", $shortcode), $function);
        }


    }

    /**
     * Shortcode Wrapper.
     *
     * @param string[] $function Callback function.
     * @param array $atts Attributes. Default to empty array.
     * @param array $wrapper Customer wrapper data.
     *
     * @return string
     */
    public static function shortcode_wrapper(
        $function,
        $atts = array(),
        $wrapper = array(
            'class' => 'mb-instagram-pack',
            'before' => null,
            'after' => null,
        )
    )
    {
        ob_start();

        // @codingStandardsIgnoreStart
        echo empty($wrapper['before']) ? '<div class="' . esc_attr($wrapper['class']) . '">' : $wrapper['before'];
        call_user_func($function, $atts);
        echo empty($wrapper['after']) ? '</div>' : $wrapper['after'];
        // @codingStandardsIgnoreEnd

        return ob_get_clean();
    }

    /**
     * Checkout page shortcode.
     *
     * @param array $atts Attributes.
     * @return string
     */
    public static function feed($atts)
    {
        return self::shortcode_wrapper(array('MB_Instagram_Pack_Shortcode_Feed', 'output'), $atts);
    }

}
