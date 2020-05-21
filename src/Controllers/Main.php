<?php
namespace Wpbp\Controllers;

if (!defined('ABSPATH')) {
	exit;
}

use Wpbp\Controllers\Db as DbController;
use Wpbp\Controllers\Backend as BackendController;
use Wpbp\Controllers\Shortcode as ShortcodeController;

/**
* class Main
*
* @package Wpbp\Controllers
* @since 1.0.0
*/
class Main
{
    /**
     * Function called to initialize plugin
     * @since 1.0.0
     */
    public function pluginStart()
    {
        add_action('plugins_loaded', [$this, 'pluginsLoadedActions']);
        add_action('init', [$this, 'init']);
        // init backend class
        $backend_controller = new BackendController();
        $backend_controller->init();
        // init shortcode class
        $shortcode_controller = new ShortcodeController();
        $shortcode_controller->init();
    }

    /**
     * Function called on init action
     *
     * @method init
     * @since 1.0.0
     */
    public function init() {
        // fix the headers already sent notice
        $this->output_buffer();
    }

    /**
     * Function to fix the headers already sent warning
     *
     * @method output_buffer
     * @since 1.0.0
     */
    public function output_buffer() {
    	ob_start();
    }

    /**
     * Function to load plugin translation files
     *
     * @method loadPluginTextdomain
     * @since 1.0.0
     */
    public function loadPluginTextdomain() {
        load_plugin_textdomain('wp-boilerplate-plugin-text-domain', false, '/languages');
    }

    /**
     * Function called via plugin installed hook
     *
     * @method pluginInstalledActions
     * @since 1.0.0
     */
    public function pluginInstalledActions() {
        // create db tables on plugin install
        $db_controller = new DbController();
        $db_controller->createTablesOnInstall();
    }

    /**
     * Function called via plugin uninstalled hook
     *
     * @method pluginUninstalledActions
     * @since 1.0.0
     */
    public function pluginUninstalledActions() {
        // in case you need to do something on plugin uninstall
    }

    /**
     * Function called via plugin loaded hook
     *
     * @method pluginsLoadedActions
     * @since 1.0.0
     */
    public function pluginsLoadedActions() {
        // load textdomain for i10n
        $this->loadPluginTextdomain();
        // update db
        $db_controller = new DbController();
        $db_controller->updateTablesOnPluginsLoaded();
    }
}
