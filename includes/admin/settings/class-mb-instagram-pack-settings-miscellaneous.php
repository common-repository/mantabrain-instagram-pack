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

if (class_exists('MB_Instagram_Pack_Settings_Miscellaneous', false)) {
    return new MB_Instagram_Pack_Settings_Miscellaneous();
}

/**
 * MB_Instagram_Pack_Settings_Miscellaneous.
 */
class MB_Instagram_Pack_Settings_Miscellaneous extends MB_Instagram_Pack_Admin_Settings_Base
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->id = 'miscellaneous';
        $this->label = __('Miscellaneous', 'mb-instagram-pack');

        parent::__construct();
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

        $settings = apply_filters(
            'mb_instagram_pack_miscellaneous_settings',
            array(
                array(
                    'title' => __('Miscellaneous', 'mb-instagram-pack'),
                    'type' => 'title',
                    'desc' => '',
                    'id' => 'miscellaneous_options',
                ),
                array(
                    'type' => 'sectionend',
                    'id' => 'miscellaneous_options',
                ),

            )
        );


        return apply_filters('mb_instagram_pack_get_settings_' . $this->id, $settings, $current_section);
    }
}

return new MB_Instagram_Pack_Settings_Miscellaneous();
