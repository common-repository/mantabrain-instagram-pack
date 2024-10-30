<?php
/**
 * Admin View: Settings
 *
 * @package AgencyEcommerceAddons
 */

if (!defined('ABSPATH')) {
    exit;
}


$tab_exists = isset($tabs[$current_tab]) || has_action('mb_instagram_pack_sections_' . $current_tab) || has_action('mb_instagram_pack_settings_' . $current_tab) || has_action('mb_instagram_pack_settings_tabs_' . $current_tab);
$current_tab_label = isset($tabs[$current_tab]) ? $tabs[$current_tab] : '';

/*echo '<pre>';
print_r($tab_exists);
exit;*/
if (!$tab_exists) {
    wp_safe_redirect(admin_url('admin.php?page=mb-instagram-pack'));
    exit;
}
?>
<div class="wrap mb-instagram-pack">
    <form method="<?php echo esc_attr(apply_filters('mb_instagram_pack_settings_form_method_tab_' . $current_tab, 'post')); ?>"
          id="mainform" action="" enctype="multipart/form-data">
        <nav class="nav-tab-wrapper mb-instagram-pack-nav-tab-wrapper">
            <?php

            foreach ($tabs as $slug => $label) {
                echo '<a href="' . esc_html(admin_url('admin.php?page=mb-instagram-pack&tab=' . esc_attr($slug))) . '" class="nav-tab ' . ($current_tab === $slug ? 'nav-tab-active' : '') . '">' . esc_html($label) . '</a>';
            }

            do_action('mb_instagram_pack_settings_tabs');

            ?>
        </nav>
        <h1 class="screen-reader-text"><?php echo esc_html($current_tab_label); ?></h1>
        <?php
        do_action('mb_instagram_pack_sections_' . $current_tab);

        self::show_messages();

        do_action('mb_instagram_pack_settings_' . $current_tab);
        do_action('mb_instagram_pack_settings_tabs_' . $current_tab); // @deprecated hook. @todo remove in 4.0.
        ?>
        <p class="submit">
            <?php if (empty($GLOBALS['hide_save_button'])) : ?>
                <button name="save" class="button-primary mb-instagram-pack-save-button" type="submit"
                        value="<?php esc_attr_e('Save changes', 'mb-instagram-pack'); ?>"><?php esc_html_e('Save changes', 'mb-instagram-pack'); ?></button>
            <?php endif; ?>
            <?php wp_nonce_field('mb-instagram-pack'); ?>
        </p>
    </form>
</div>
