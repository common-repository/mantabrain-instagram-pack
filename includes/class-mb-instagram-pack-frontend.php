<?php
/**
 * MB_Instagram_Pack frontend setup
 *
 * @package MB_Instagram_Pack
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Main MB_Instagram_Pack_Frontend Class.
 *
 * @class MB_Instagram_Pack
 */
final class MB_Instagram_Pack_Frontend
{

    /**
     * The single instance of the class.
     *
     * @var MB_Instagram_Pack_Frontend
     * @since 1.0.0
     */
    protected static $_instance = null;


    /**
     * Main MB_Instagram_Pack_Frontend Instance.
     *
     * Ensures only one instance of MB_Instagram_Pack_Frontend is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return MB_Instagram_Pack_Frontend - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * MB_Instagram_Pack Constructor.
     */
    public function __construct()
    {
        $this->includes();
        $this->init_hooks();
        do_action('mb_instagram_pack_frontend_loaded');
    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0.0
     */
    private function init_hooks()
    {


    }


    /**
     * Include required core files used in frontend.
     */
    public function includes()
    {
        include_once MB_INSTAGRAM_PACK_ABSPATH . 'includes/class-mb-instagram-pack-assets.php';


    }


}
