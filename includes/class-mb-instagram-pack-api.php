<?php
defined('ABSPATH') || exit;

final class MB_Instagram_Pack_API
{

    private $api_url = 'https://api.instagram.com/v1/';

    /**
     * The single instance of the class.
     *
     * @var MB_Instagram_Pack_API
     * @since 1.0.0
     */
    protected static $_instance = null;


    /**
     * Main MB_Instagram_Pack_API Instance.
     *
     * Ensures only one instance of MB_Instagram_Pack_API is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @see mb_aec_addons()
     * @return MB_Instagram_Pack_API - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cloning is forbidden.', 'mb-instagram-pack'), '1.0.0');
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, __('Unserializing instances of this class is forbidden.', 'mb-instagram-pack'), '1.0.0');
    }

    /**
     * Auto-load in-accessible properties on demand.
     *
     * @param mixed $key Key name.
     * @return mixed
     */
    public function __get($key)
    {
        if (in_array($key, array(''), true)) {
            return $this->$key();
        }
    }


    public function get_user_media_endpoint($id)
    {
        return $this->api_url . 'users/' . $id . '/media/recent/';
    }


    public function get_user_data_endpoint()
    {
        return $this->api_url . 'users/self/';
    }

    public function get_access_token()
    {
        return mb_instagram_pack_get_option('access_token', '');
    }

    public function get_user_from_token($access_token = '')
    {
        $access_token = empty($access_token) ? $this->get_access_token() : $access_token;

        $api_url = $this->get_user_data_endpoint() . '?access_token=' . $access_token;

        $args = array(
            'timeout' => 60,
            'sslverify' => false
        );
        $result_array = array();

        $result = wp_remote_get($api_url, $args);

        try {
            $result_json = isset($result['body']) ? $result['body'] : "{}";

            $result_array = json_decode($result_json, true);

        } catch (Exception $e) {

        }
        return $result_array;
    }


    public function get_user_media($user_id, $count = 10, $last_post_id = '')
    {

        $url = $this->get_user_media_endpoint($user_id) . '?access_token=' . $this->get_access_token() . '&count=' . $count;


        if (!empty($last_post_id)) {

            $url .= '&max_id=' . $last_post_id;
        }

        $args = array(
            'timeout' => 60,
            'sslverify' => false
        );
        $result = wp_remote_get($url, $args);


        $result_array = array();

        $result_body = isset($result['body']) ? $result['body'] : "{}";

        try {
            $result_array = json_decode($result_body, true);

        } catch (Exception $e) {
            echo $e->getMessage();
        }


        $feed_data = $this->get_post_array($result_array);

        return $feed_data;

    }

    private function get_post_array($result_array = array())
    {
        $feed_data_array = array();
        if (!isset($result_array['data'])) {
            return $feed_data_array;
        }

        foreach ($result_array['data'] as $single_result) {

            $images = isset($single_result['images']) ? $single_result['images'] : array();

            $feed_data = array();

            $feed_data['thumbnail'] = isset($images['low_resolution']) ? $images['low_resolution']['url'] : '';

            $feed_data['link'] = isset($single_result['link']) ? $single_result['link'] : '';

            $feed_data['likes'] = isset($single_result['likes']['count']) ? $single_result['likes']['count'] : 0;

            $feed_data['comments'] = isset($single_result['comments']['count']) ? $single_result['comments']['count'] : 0;

            $feed_data['id'] = isset($single_result['id']) ? $single_result['id'] : '';

            array_push($feed_data_array, $feed_data);

        }
        return $feed_data_array;


    }


}