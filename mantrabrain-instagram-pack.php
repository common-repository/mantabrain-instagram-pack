<?php
/**
 * Plugin Name:       Mantrabrain Instagram Pack
 * Plugin URI:        https://wordpress.org/plugins/mantrabrain-instagram-pack/
 * Description:       Display your instagram feed using this [instagram_pack_feed] shortcode.
 * Version:           1.0.0
 * Author:            Mantrabrain
 * Author URI:        https://mantrabrain.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mb-instagram-pack
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define MB_INSTAGRAM_PACK_PLUGIN_FILE.
if (!defined('MB_INSTAGRAM_PACK_FILE')) {
    define('MB_INSTAGRAM_PACK_FILE', __FILE__);
}

// Define MB_INSTAGRAM_PACK_VERSION.
if (!defined('MB_INSTAGRAM_PACK_VERSION')) {
    define('MB_INSTAGRAM_PACK_VERSION', '1.0.0');
}

// Define MB_INSTAGRAM_PACK_PLUGIN_URI.
if (!defined('MB_INSTAGRAM_PACK_PLUGIN_URI')) {
    define('MB_INSTAGRAM_PACK_PLUGIN_URI', plugins_url('', MB_INSTAGRAM_PACK_FILE));
}

// Define MB_INSTAGRAM_PACK_PLUGIN_DIR.
if (!defined('MB_INSTAGRAM_PACK_PLUGIN_DIR')) {
    define('MB_INSTAGRAM_PACK_PLUGIN_DIR', plugin_dir_path(MB_INSTAGRAM_PACK_FILE));
}


// Include the main MB_Instagram_Pack class.
if (!class_exists('MB_Instagram_Pack')) {
    include_once dirname(__FILE__) . '/includes/class-mb-instagram-pack.php';
}


/**
 * Main instance of MB_Instagram_Pack.
 *
 * Returns the main instance of MB_Instagram_Pack to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return MB_Instagram_Pack
 */
function mb_instagram_pack_instance()
{
    return MB_Instagram_Pack::instance();
}

// Global for backwards compatibility.
$GLOBALS['mb-instagram-pack-instance'] = mb_instagram_pack_instance();
