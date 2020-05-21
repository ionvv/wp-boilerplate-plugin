<?php
namespace Wpbp\Controllers;

if (!defined('ABSPATH')) {
	exit;
}

use Wpptd\Models\Shortcode as ShortcodeModel;

/**
* Class Backend
*
* @package Wpbp\Controllers
* @since 1.0.0
*/
class Backend
{
    /**
     * Init function
     *
     * @method init
     * @since 1.0.0
     */
    public function init()
    {
        //admin pages
        add_action('admin_menu', [$this, 'adminPageInit']);
        add_action('admin_enqueue_scripts', [$this, 'adminEnqueue']);
    }

    /**
     * Admin pages
     *
     * @method adminPageInit
     * @since 1.0.0
     */
    public function adminPageInit()
    {
        add_menu_page('WP Boilerplate Plugin', 'WP Boilerplate Plugin', 'manage_options', 'wpbp', [$this, 'initShortcodesPage'], 'dashicons-warning');
        add_submenu_page('wpbp', 'Shortcodes', 'Shortcodes', 'manage_options', 'wpbp', [$this, 'initShortcodesPage'], 1);
        add_submenu_page('wpbp', 'Settings', 'Settings', 'manage_options', 'wpbp-settings', [$this, 'initSettingsPage'], 4);
    }

    /**
     * Enqueue admin scripts
     *
     * @method adminEnqueue
     * @since 1.0.0
     */
    function adminEnqueue()
    {
		wp_register_style('wpbp-backend-css', WPBP_URL . 'assets/dist/css/backend.min.css', [], WPBP_VERSION);
		wp_register_script('wpbp-backend-js', WPBP_URL . 'assets/dist/js/backend.min.js', ['jquery', 'media-upload'], WPBP_VERSION);
	}

    /**
     * Admin shortcodes page
     *
     * @method initShortcodesPage
     * @since 1.0.0
     */
    function initShortcodesPage()
    {
        wp_enqueue_style('wpbp-backend-css');
        wp_enqueue_script('wpbp-backend-js');

        // inlcude the view file
        include WPBP_PATH . 'src/Views/be-shortcode.php';
    }

    function initSettingsPage()
    {
        wp_enqueue_style('wpbp-backend-css');
        wp_enqueue_script('wpbp-backend-js');

        // include view file
        include WPBP_PATH . 'src/Views/be-settings.php';
    }
}
