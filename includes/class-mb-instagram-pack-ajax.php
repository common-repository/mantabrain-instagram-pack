<?php
defined('ABSPATH') || exit;

class MB_Instagram_Pack_Ajax
{

    private function admin_ajax_actions()
    {
        $actions = array();

        return $actions;

    }

    private function public_ajax_actions()
    {
        $actions = array(

            'load_more_profile',
        );
        return $actions;
    }

    private function validate_nonce($nonce_action = '', $nonce_value = '')
    {
        $debug_backtrace = debug_backtrace();

        if (@isset($debug_backtrace[1]['function'])) {

            $nonce_action = 'wp_mb_instagram_pack_' . $debug_backtrace[1]['function'] . '_nonce';

        }
        if (empty($nonce_value)) {
            $nonce_value = isset($_REQUEST['mb_instagram_pack_nonce']) ? $_REQUEST['mb_instagram_pack_nonce'] : '';
        }

        return wp_verify_nonce($nonce_value, $nonce_action);

    }

    private function ajax_error()
    {
        return array('message' => __('Something wrong, please try again.', 'mb-instagram-pack'), 'status' => false);
    }

    public function __construct()
    {
        $admin_actions = $this->admin_ajax_actions();

        $public_ajax_actions = $this->public_ajax_actions();

        $all_ajax_actions = array_unique(array_merge($admin_actions, $public_ajax_actions));

        foreach ($all_ajax_actions as $action) {
            add_action('wp_ajax_mb_instagram_pack_' . $action, array($this, $action));
            if (isset($public_ajax_actions[$action])) {
                add_action('wp_ajax_nopriv_mb_instagram_pack_' . $action, array($this, $action));
            }

        }


    }


    public function load_more_profile()
    {
        $status = $this->validate_nonce();

        if (!$status) {
            wp_send_json_error($this->ajax_error());
        }
        $last_post_id = isset($_POST['last_post_id']) ? sanitize_text_field($_POST['last_post_id']) : '';

        if (empty($last_post_id)) {

            wp_send_json_error();
        }
        $user_data = mb_instagram_pack_get_option('user_data', '');

        $id = $user_data['id'];

        $per_page_posts = mb_instagram_pack_get_option('per_page_posts', 10);

        $feed_data = MB_Instagram_Pack_API::instance()->get_user_media($id, $per_page_posts, $last_post_id);

        foreach ($feed_data as $data) {

            mb_instagram_pack_get_template('tmpl-feed-item.php', array(
                    'data' => $data,
                    'user_data' => $user_data
                )
            );
        }
        exit;
    }


}

new MB_Instagram_Pack_Ajax();