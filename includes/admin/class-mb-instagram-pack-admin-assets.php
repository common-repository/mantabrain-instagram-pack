<?php
if (!class_exists('MB_Instagram_Pack_Admin_Assets')) {
    class MB_Instagram_Pack_Admin_Assets
    {
        function __construct()
        {
            add_action('admin_enqueue_scripts', array($this, 'load_admin_scripts'));

        }

        public function load_admin_scripts($hook)
        {

            // Register Only Script
            wp_register_script('mb-instagram-pack-select2js', MB_INSTAGRAM_PACK_PLUGIN_URI . '/assets/lib/select2/js/select2.min.js', false, MB_INSTAGRAM_PACK_VERSION);

            // Register Only Styles
            wp_register_style('mb-instagram-pack-select2css', MB_INSTAGRAM_PACK_PLUGIN_URI . '/assets/lib/select2/css/select2.min.css', false, MB_INSTAGRAM_PACK_VERSION);

            // Other Register and Enqueue
            wp_register_style('mb-instagram-pack-admin-style', MB_INSTAGRAM_PACK_PLUGIN_URI . '/assets/admin/css/admin-style.css', array('mb-instagram-pack-select2css'), MB_INSTAGRAM_PACK_VERSION);
            wp_enqueue_style('mb-instagram-pack-admin-style');


            wp_register_script('mb-instagram-pack-admin-script', MB_INSTAGRAM_PACK_PLUGIN_URI . '/assets/admin/js/admin-script.js', array('mb-instagram-pack-select2js'), MB_INSTAGRAM_PACK_VERSION);
            wp_enqueue_script('mb-instagram-pack-admin-script');

        }

    }

}
return new MB_Instagram_Pack_Admin_Assets();