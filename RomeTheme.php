<?php

/**
 * Plugin Name:       Rometheme For Elementor
 * Description:       The Advanced Addons for Elementor 
 * Version:           1.0.0
 * Author:            Rometheme
 * Author URI: 	  	  https://rometheme.net/
 * License : 		  GPLv3 or later
 * 
 * Rometheme For Elementor is Addons for Elementor Page Builder.
 * it Included 250+ Template Kit, Header Footer Builder and Widget ready to use.
 */

define("ROMETHEME_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));

class RomeTheme
{

	function __construct()
	{
		require_once self::plugin_dir() . 'libs/notice/notice.php';
		add_action('admin_menu', [$this, 'rometheme_add_menu']);
		add_action('plugins_loaded', array($this, 'init'), 100);
	}

	public function isCompatible()
	{
		if (!did_action('elementor/loaded')) {
			add_action('admin_head', array($this, 'missing_elementor'));
			return false;
		}

		return true;
	}

	function init()
	{
		if ($this->isCompatible()) {
			require_once self::plugin_dir() . '/plugin.php';
			\RomethemePlugin\Plugin::register_autoloader();
			\RomethemePlugin\Plugin::load_header_footer();
			add_action('admin_enqueue_scripts', [$this, 'register_style']);
			add_action('elementor/widgets/register', [\RomethemePlugin\Plugin::class, 'register_widget']);
			add_action('elementor/elements/categories_registered', [\RomethemePlugin\Plugin::class, 'add_elementor_widget_categories']);
			add_action('elementor/frontend/before_enqueue_styles', [\RomethemePlugin\Plugin::class, 'register_widget_styles']);
			add_action('elementor/frontend/before_register_scripts', [\RomethemePlugin\Plugin::class, 'register_widget_scripts']);
			add_action('elementor/editor/before_enqueue_styles', [\RomethemePlugin\Plugin::class, 'register_widget_styles']);
			add_action('elementor/editor/before_register_scripts', [\RomethemePlugin\Plugin::class, 'register_widget_scripts']);
		}
	}

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	static function min_el_version()
	{
		return '3.0.0';
	}


	/**
	 * Plugin file
	 *
	 * @since 1.0.0
	 * @var string plugins's root file.
	 */
	static function plugin_file()
	{
		return __FILE__;
	}

	/**
	 * Plugin url
	 *
	 * @since 1.0.0
	 * @var string plugins's root url.
	 */
	static function plugin_url()
	{
		return trailingslashit(plugin_dir_url(__FILE__));
	}
	/**
	 * Plugin dir
	 *
	 * @since 1.0.0
	 * @var string plugins's root directory.
	 */
	static function plugin_dir()
	{
		return trailingslashit(plugin_dir_path(__FILE__));
	}

	/**
	 * Plugin's module directory.
	 *
	 * @since 1.0.0
	 * @var string module's root directory.
	 */
	static function module_dir()
	{
		return self::plugin_dir() . 'modules/';
	}

	/**
	 * Plugin's module url.
	 *
	 * @since 1.0.0
	 * @var string module's root url.
	 */
	static function module_url()
	{
		return self::plugin_url() . 'modules/';
	}

	/**
	 * Plugin's Widget directory.
	 *
	 * @since 1.0.0
	 * @var string widget's root directory.
	 */
	static function widget_dir()
	{
		return self::plugin_dir() . 'widgets/';
	}

	/**
	 * Plugin's widget url.
	 *
	 * @since 1.0.0
	 * @var string widget's root url.
	 */
	static function widget_url()
	{
		return self::plugin_url() . 'widgets/';
	}


	function rometheme_add_menu()
	{
		add_menu_page(
			'romethemekit-plugin',
			'Rometheme Kit',
			'manage_options',
			'romethemekit',
			array($this, 'romethemekit_cal'),
			$this->plugin_url() . 'view/rometheme.svg',
			20
		);
	}

	function romethemekit_cal()
	{
		require self::plugin_dir() . 'view/welcome.php';
	}

	function register_style()
	{
		$screen = get_current_screen();
		if ($screen->id == 'toplevel_page_romethemekit') {
			wp_enqueue_style('style.css', self::plugin_url() . 'bootstrap/css/bootstrap.css');
		}
	}

	public function missing_elementor()
	{
		$btn = array(
			'default_class' => 'button',
			'class'         => 'button-primary ', // button-primary button-secondary button-small button-large button-link
		);

		if (file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php')) {
			$btn['text'] = esc_html__('Activate Elementor', 'romethemekit-plugin');
			$btn['url']  = wp_nonce_url('plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php');
		} else {
			$btn['text'] = esc_html__('Install Elementor', 'romethemekit-plugin');
			$btn['url']  = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__('%1$s requires %2$s to work properly. Please install and activate it first.', 'romethemekit-plugin'),
			'<strong>' . esc_html__('Rometheme for Elementor', 'romethemekit-plugin') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'romethemekit-plugin') . '</strong>'
		);

		\Oxaim\Libs\Notice::instance('romethemekit-plugin', 'unsupported-elementor-version')
			->set_type('error')
			->set_message($message)
			->set_button($btn)
			->call();
	}
}

new RomeTheme();
