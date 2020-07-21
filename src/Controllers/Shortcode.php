<?php
namespace Wpbp\Controllers;

if (!defined('ABSPATH')) {
	exit;
}

/**
* Class Shortcode
*
* @package Wpbp\Controllers
* @subpackage Controllers
* @since 1.0.0
*/
class Shortcode
{
	/**
	 * Init shortcode function
	 *
	 * @method init
	 * @since 1.0.0
	 */
	public function init()
	{
		add_shortcode('wp-boilerplate-plugin', [$this, 'displayShortcode']);

		add_action('wp_enqueue_scripts', [$this, 'shortcodeRegisterScripts']);

		add_action('wp_ajax_wpbp_ajax_example', [$this, 'ajaxExampleMethod']);
		add_action('wp_ajax_nopriv_wpbp_ajax_example', [$this, 'ajaxExampleMethod']);
	}

	/**
	 * Function to display shortcode
	 *
	 * @method displayShortcode
	 * @since 1.0.0
	 * @param  array $attr
	 * @param  string $content
	 * @return string
	 */
	public function displayShortcode($attr, $content = null)
	{
		$attributes = shortcode_atts([
			'class'  => '',
			'id' => 0,
		], $attr);

		$this->shortcodeEnqueue();

		ob_start();
		include WPBP_PATH . 'src/Views/fe-shortcode.php';
		return ob_get_clean();
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @method shortcodeEnqueue
	 * @since 1.0.0
	 */
	public function shortcodeEnqueue()
	{
		wp_enqueue_script('wpbp-scripts');
		wp_enqueue_style('wpbp-style');
	}

	/**
	 * Register scripts and styles
	 *
	 * @method shortcodeRegisterScripts
	 * @since 1.0.0
	 */
	public function shortcodeRegisterScripts()
	{
		// clear cache and get the last modified file time
		clearstatcache(true, WPBP_PATH . 'assets/dist/js/frontend.min.js');
		$js_filemtime = filemtime(WPBP_PATH . 'assets/dist/js/frontend.min.js');
		wp_register_script('wpbp-scripts', WPBP_URL . 'assets/dist/js/frontend.min.js?' . $js_filemtime, ['jquery'], WPBP_VERSION, true);

		$ajax_url = admin_url('admin-ajax.php');
		$data = [
			'some_variable' => 'some string'
		];

		wp_localize_script(
			'wpbp-scripts',
			'wpbp_data',
			[
				'ajax_url' => $ajax_url,
				'data' => $data,
				'messages' => [
					'success_message' => esc_html__('This is a success message.', 'wp-boilerplate-plugin-text-domain'),
					'warning_message' => esc_html__('This is a warning message.', 'wp-boilerplate-plugin-text-domain')
				]
			]
		);

		// style
		// clear cache and get the last modified file time
		clearstatcache(true, WPPTD_PATH . 'assets/dist/css/frontend.min.css');
		$css_filemtime = filemtime(WPPTD_PATH . 'assets/dist/css/frontend.min.css');
		wp_register_style('wpbp-style', WPPTD_URL . 'assets/dist/css/frontend.min.css?' . $css_filemtime);
	}

	/**
	 * Demo function to handle ajax requests (requests via js fetch method)
	 *
	 * @method ajaxExampleMethod
	 * @since 1.0.0
	 */
	public function ajaxExampleMethod()
	{
		$request = json_decode(file_get_contents('php://input'), true);
		if (!isset($request['nonce']) || !wp_verify_nonce($request['nonce'], 'wpbp_nonce')) {
			$data = [
				'success' => false,
				'message' => esc_html__('Invalid nonce', 'wp-boilerplate-plugin-text-domain'),
			];
		} else {
			$data = [
				'success' => true,
				'message' => '',
			];
		}

		wp_send_json($data);
	}
}
