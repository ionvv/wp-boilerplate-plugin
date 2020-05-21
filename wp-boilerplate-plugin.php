<?php
/**
 * Plugin Name: WP Boilerplate Plugin
 * Plugin URI: https://github.com/ionvv/wp-boilerplate-plugin
 * Description: WordPress Boilerplate Plugin
 * Author: Ion Vrinceanu | Pixolette
 * Version: 1.0.0
 * Author URI: https://pixolette.com
 * Text Domain: wp-boilerplate-plugin-text-domain
 * Domain Path: /languages/
 */

if (!defined('ABSPATH')) {
	exit;
}
// Define Contsants
// WPBP stands for WP Boilerplate Plugin
define( 'WPBP_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPBP_URL', plugin_dir_url( __FILE__ ) );
define( 'WPBP_BASENAME', plugin_basename( __FILE__ ) );
// plugin info
define( 'WPBP_NAME', 'WP Boilerplate Plugin' );
define( 'WPBP_VERSION', '1.0.0' );

require 'vendor/autoload.php';

use Wpbp\Controllers\Main as MainController;

$main_controller = new MainController();
$main_controller->pluginStart();

register_activation_hook( __FILE__, [ new MainController(), 'pluginInstalledActions' ] );
register_deactivation_hook( __FILE__, [ new MainController(), 'pluginUninstalledActions' ] );
