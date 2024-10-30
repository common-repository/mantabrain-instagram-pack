<?php
if (!class_exists('MB_Instagram_Pack_Assets')) {
    class MB_Instagram_Pack_Assets
    {
        function __construct()
        {
            add_action('wp_enqueue_scripts', array($this, 'scripts'));

        }

        public function scripts($hook)
        {

            // Other Register and Enqueue
            wp_register_style('mb-instagram-pack-font-awesome', MB_INSTAGRAM_PACK_PLUGIN_URI . '/assets/lib/font-awesome/css/font-awesome.css', false, MB_INSTAGRAM_PACK_VERSION);
            wp_enqueue_style('mb-instagram-pack-font-awesome');

            // Other Register and Enqueue
            wp_register_style('mb-instagram-pack-style', MB_INSTAGRAM_PACK_PLUGIN_URI . '/assets/css/mb-instagram-pack.css', false, MB_INSTAGRAM_PACK_VERSION);
            wp_enqueue_style('mb-instagram-pack-style');


            wp_register_script('mb-instagram-pack-script', MB_INSTAGRAM_PACK_PLUGIN_URI . '/assets/js/mb-instagram-pack.js', array('jquery'), MB_INSTAGRAM_PACK_VERSION);
            wp_enqueue_script('mb-instagram-pack-script');

            $mb_instagram_pack_params = array(

                'ajax_url' => admin_url('admin-ajax.php'),
                'load_more_profile_params' => array(
                    'load_more_profile_action' => 'mb_instagram_pack_load_more_profile',
                    'load_more_profile_nonce' => wp_create_nonce('wp_mb_instagram_pack_load_more_profile_nonce')
                )
            );

            wp_localize_script('mb-instagram-pack-script', 'mb_instagram_pack_params', $mb_instagram_pack_params);
        }

    }

}
return new MB_Instagram_Pack_Assets();