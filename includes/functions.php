<?php
defined('ABSPATH') || exit;
global $mb_instagram_pack_global_options;
// Load Helpers
if (!function_exists('mb_instagram_pack_get_option')) {

    function mb_instagram_pack_get_option($option_key = '', $default = '', $is_all_option = false)
    {

        $option_value_array = $mb_instagram_pack_options = get_option('mb_instagram_pack_options', array());

        if ($is_all_option) {
            return $option_value_array;
        }

        if (isset($option_value_array[$option_key])) {

            return $option_value_array[$option_key];
        }
        return $default;
    }

}

if (!function_exists('mb_instagram_pack_update_option')) {

    function mb_instagram_pack_update_option($update_options = array(), $is_all_option = false)
    {

        $option_value_array = $mb_instagram_pack_options = get_option('mb_instagram_pack_options', array());

        foreach ($update_options as $name => $value) {

            $option_value_array [$name] = $value;
        }

        update_option('mb_instagram_pack_options', $option_value_array);


    }

}


if (!function_exists('mb_instagram_pack_get_template')) {

    function mb_instagram_pack_get_template($template_name, $args = array(), $template_path = '', $default_path = '')
    {
        $cache_key = sanitize_key(implode('-', array('template', $template_name, $template_path, $default_path)));
        $template = (string)wp_cache_get($cache_key, 'mb-instagram-pack');

        if (!$template) {
            $template = mb_instagram_pack_locate_template($template_name, $template_path, $default_path);
            wp_cache_set($cache_key, $template, 'mb-instagram-pack');
        }
        // Allow 3rd party plugin filter template file from their plugin.
        $filter_template = apply_filters('mb_instagram_pack_get_template', $template, $template_name, $args, $template_path, $default_path);

        if ($filter_template !== $template) {
            if (!file_exists($filter_template)) {
                /* translators: %s template */
                _doing_it_wrong(__FUNCTION__, sprintf(__('%s does not exist.', 'mb-instagram-pack'), '<code>' . $template . '</code>'), '1.0.1');
                return;
            }
            $template = $filter_template;
        }

        $action_args = array(
            'template_name' => $template_name,
            'template_path' => $template_path,
            'located' => $template,
            'args' => $args,
        );

        if (!empty($args) && is_array($args)) {
            if (isset($args['action_args'])) {
                _doing_it_wrong(
                    __FUNCTION__,
                    __('action_args should not be overwritten when calling mb_instagram_pack_get_template.', 'mb-instagram-pack'),
                    '1.0.0'
                );
                unset($args['action_args']);
            }
            extract($args); // @codingStandardsIgnoreLine
        }

        do_action('mb_instagram_pack_before_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args']);

        include $action_args['located'];

        do_action('mb_instagram_pack_after_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args']);
    }
}

if (!function_exists('mb_instagram_pack_locate_template')) {
    function mb_instagram_pack_locate_template($template_name, $template_path = '', $default_path = '')
    {
        if (!$template_path) {
            $template_path = mb_instagram_pack_instance()->template_path();
        }

        if (!$default_path) {
            $default_path = mb_instagram_pack_instance()->plugin_template_path();
        }

        // Look within passed path within the theme - this is priority.
        $template = locate_template(
            array(
                trailingslashit($template_path) . $template_name,
                $template_name,
            )
        );

        // Get default template/.
        if (!$template) {
            $template = $default_path . $template_name;
        }
        // Return what we found.
        return apply_filters('mb_instagram_pack_locate_template', $template, $template_name, $template_path);
    }
}

if (!function_exists('mb_instagram_pack_get_template_part')) {

    function mb_instagram_pack_get_template_part($slug, $name = '')
    {
        $path = "{$slug}.php";

        if ('' !== $name) {

            $path = "{$slug}-{$name}.php";
        }
        $template = mb_instagram_pack_locate_template($path, false, false);

        require $template;

    }

}
