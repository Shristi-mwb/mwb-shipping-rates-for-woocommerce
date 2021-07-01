<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/includes
 */
class Mwb_Shipping_Rates_For_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since 1.0.0
	 * @var   Mwb_Shipping_Rates_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $msrfw_onboard    To initializsed the object of class onboard.
	 */
	protected $msrfw_onboard;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area,
	 * the public-facing side of the site and common side of the site.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		if (defined('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_VERSION') ) {

			$this->version = MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'mwb-shipping-rates-for-woocommerce';

		$this->mwb_shipping_rates_for_woocommerce_dependencies();
		$this->mwb_shipping_rates_for_woocommerce_locale();
		if (is_admin() ) {
			$this->mwb_shipping_rates_for_woocommerce_admin_hooks();
		} else {
			$this->mwb_shipping_rates_for_woocommerce_public_hooks();
		}
		$this->mwb_shipping_rates_for_woocommerce_common_hooks();

		$this->mwb_shipping_rates_for_woocommerce_api_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mwb_Shipping_Rates_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Mwb_Shipping_Rates_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - Mwb_Shipping_Rates_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Mwb_Shipping_Rates_For_Woocommerce_Common. Defines all hooks for the common area.
	 * - Mwb_Shipping_Rates_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 1.0.0
	 */
	private function mwb_shipping_rates_for_woocommerce_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mwb-shipping-rates-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mwb-shipping-rates-for-woocommerce-i18n.php';

		if (is_admin() ) {

			// The class responsible for defining all actions that occur in the admin area.
			include_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-mwb-shipping-rates-for-woocommerce-admin.php';

			// The class responsible for on-boarding steps for plugin.
			if (is_dir(plugin_dir_path(dirname(__FILE__)) . 'onboarding') && ! class_exists('Mwb_Shipping_Rates_For_Woocommerce_Onboarding_Steps') ) {
				include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mwb-shipping-rates-for-woocommerce-onboarding-steps.php';
			}

			if (class_exists('Mwb_Shipping_Rates_For_Woocommerce_Onboarding_Steps') ) {
				$msrfw_onboard_steps = new Mwb_Shipping_Rates_For_Woocommerce_Onboarding_Steps();
			}
		} else {

			// The class responsible for defining all actions that occur in the public-facing side of the site.
			include_once plugin_dir_path(dirname(__FILE__)) . 'public/class-mwb-shipping-rates-for-woocommerce-public.php';

		}

		include_once plugin_dir_path(dirname(__FILE__)) . 'package/rest-api/class-mwb-shipping-rates-for-woocommerce-rest-api.php';

		/**
		 * This class responsible for defining common functionality
		 * of the plugin.
		 */
		include_once plugin_dir_path(dirname(__FILE__)) . 'common/class-mwb-shipping-rates-for-woocommerce-common.php';

		$this->loader = new Mwb_Shipping_Rates_For_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mwb_Shipping_Rates_For_Woocommerce_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since 1.0.0
	 */
	private function mwb_shipping_rates_for_woocommerce_locale() {

		$plugin_i18n = new Mwb_Shipping_Rates_For_Woocommerce_I18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

	}

	/**
	 * Define the name of the hook to save admin notices for this plugin.
	 *
	 * @since 1.0.0
	 */
	private function mwb_saved_notice_hook_name() {
		$mwb_plugin_name                            = ! empty(explode('/', plugin_basename(__FILE__))) ? explode('/', plugin_basename(__FILE__))[0] : '';
		$mwb_plugin_settings_saved_notice_hook_name = $mwb_plugin_name . '_settings_saved_notice';
		return $mwb_plugin_settings_saved_notice_hook_name;
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function mwb_shipping_rates_for_woocommerce_admin_hooks() {
		$msrfw_plugin_admin = new Mwb_Shipping_Rates_For_Woocommerce_Admin($this->msrfw_get_plugin_name(), $this->msrfw_get_version());

		$this->loader->add_action('admin_enqueue_scripts', $msrfw_plugin_admin, 'msrfw_admin_enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $msrfw_plugin_admin, 'msrfw_admin_enqueue_scripts');

		// Add settings menu for MWB Shipping Rates For WooCommerce.
		$this->loader->add_action('admin_menu', $msrfw_plugin_admin, 'msrfw_options_page');
		$this->loader->add_action('admin_menu', $msrfw_plugin_admin, 'mwb_msrfw_remove_default_submenu', 50);

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter('mwb_add_plugins_menus_array', $msrfw_plugin_admin, 'msrfw_admin_submenu_page', 15);
		$this->loader->add_filter('msrfw_general_settings_array', $msrfw_plugin_admin, 'msrfw_admin_general_settings_page', 10);

		// Saving tab settings.
		$this->loader->add_action('mwb_msrfw_settings_saved_notice', $msrfw_plugin_admin, 'msrfw_admin_save_tab_settings');
		$this->loader->add_action( 'wp_ajax_product_categories', $msrfw_plugin_admin, 'product_shipping_categories' , 10);
		$this->loader->add_action( 'wp_ajax_nopriv_product_categories', $msrfw_plugin_admin, 'product_shipping_categories', 10 );
	}

	/**
	 * Register all of the hooks related to the common functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function mwb_shipping_rates_for_woocommerce_common_hooks() {

		$msrfw_plugin_common = new Mwb_Shipping_Rates_For_Woocommerce_Common($this->msrfw_get_plugin_name(), $this->msrfw_get_version());

		$this->loader->add_action('wp_enqueue_scripts', $msrfw_plugin_common, 'msrfw_common_enqueue_styles');

		$this->loader->add_action('wp_enqueue_scripts', $msrfw_plugin_common, 'msrfw_common_enqueue_scripts');
		
		if ('on' === get_option( 'msrfw_radio_switch_demo')) {
			$this->loader->add_action( 'woocommerce_shipping_init', $msrfw_plugin_common, 'mwb_shipping_rate_for_woocommerce_create_shipping_method' );
			$this->loader->add_filter( 'woocommerce_shipping_methods', $msrfw_plugin_common, 'mwb_shipping_rate_for_woocommerce_add_shipping_method' );
			$this->loader->add_action( 'woocommerce_applied_coupon', $msrfw_plugin_common, 'srfw_coupon_add_fun' );
			$this->loader->add_action( 'woocommerce_removed_coupon', $msrfw_plugin_common, 'srfw_coupon_remove_fun' );
			$this->loader->add_action( 'woocommerce_before_cart', $msrfw_plugin_common, 'shipping_rates_categories' );
			$this->loader->add_action( 'woocommerce_update_cart_action_cart_updated', $msrfw_plugin_common, 'shipping_rates_categories' );
			$this->loader->add_action( 'woocommerce_before_shipping_calculator', $msrfw_plugin_common, 'expected_delivery_date_message' );
			$this->loader->add_action( 'woocommerce_review_order_before_payment', $msrfw_plugin_common, 'expected_delivery_date_message' );
			$this->loader->add_action( 'woocommerce_before_thankyou', $msrfw_plugin_common, 'expected_delivery_date_message' );
			$this->loader->add_filter( 'woocommerce_get_item_data', $msrfw_plugin_common , 'displaying_cart_items_weight', 10, 2 );
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function mwb_shipping_rates_for_woocommerce_public_hooks() {

		$msrfw_plugin_public = new Mwb_Shipping_Rates_For_Woocommerce_Public($this->msrfw_get_plugin_name(), $this->msrfw_get_version());

		$this->loader->add_action('wp_enqueue_scripts', $msrfw_plugin_public, 'msrfw_public_enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $msrfw_plugin_public, 'msrfw_public_enqueue_scripts');
		 
		$this->loader->add_action( 'init', $msrfw_plugin_public , 'auto_select_free_shipping_by_default' , 10 );
		$this->loader->add_action( 'woocommerce_before_cart', $msrfw_plugin_public , 'auto_select_free_shipping_by_default' , 10 );
		$this->loader->add_action( 'woocommerce_customer_save_address', $msrfw_plugin_public , 'auto_select_free_shipping_by_default', 10 );
		$this->loader->add_filter( 'woocommerce_package_rates', $msrfw_plugin_public , 'hide_shipping_for_unlogged_user', 10, 2 );
	}

	/**
	 * Register all of the hooks related to the api functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function mwb_shipping_rates_for_woocommerce_api_hooks() {

		$msrfw_plugin_api = new Mwb_Shipping_Rates_For_Woocommerce_Rest_Api($this->msrfw_get_plugin_name(), $this->msrfw_get_version());

		$this->loader->add_action('rest_api_init', $msrfw_plugin_api, 'mwb_msrfw_add_endpoint');

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function msrfw_run() {
		$this->loader->msrfw_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  1.0.0
	 * @return string    The name of the plugin.
	 */
	public function msrfw_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return Mwb_Shipping_Rates_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function msrfw_get_loader() {
		return $this->loader;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return Mwb_Shipping_Rates_For_Woocommerce_Onboard    Orchestrates the hooks of the plugin.
	 */
	public function msrfw_get_onboard() {
		return $this->msrfw_onboard;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since  1.0.0
	 * @return string    The version number of the plugin.
	 */
	public function msrfw_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_msrfw_plug tabs.
	 *
	 * @return Array       An key=>value pair of MWB Shipping Rates For WooCommerce tabs.
	 */
	public function mwb_msrfw_plug_default_tabs() {
				  $msrfw_default_tabs = array();
					
					 $msrfw_default_tabs['mwb-shipping-rates-for-woocommerce-overview'] = array(
				'title'       => esc_html__('Overview', 'mwb-shipping-rates-for-woocommerce'),
				'name'        => 'mwb-shipping-rates-for-woocommerce-overview',
				'file_path'   => MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-shipping-rates-for-woocommerce-overview.php'
				);
					  $msrfw_default_tabs['mwb-shipping-rates-for-woocommerce-general'] = array(
			'title'       => esc_html__('General Setting', 'mwb-shipping-rates-for-woocommerce'),
			'name'        => 'mwb-shipping-rates-for-woocommerce-general',
			'file_path'   => MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-shipping-rates-for-woocommerce-general.php'
			);
				$msrfw_default_tabs['mwb-shipping-rates-for-woocommerce-system-status'] = array(
			'title'       => esc_html__('System Status', 'mwb-shipping-rates-for-woocommerce'),
			'name'        => 'mwb-shipping-rates-for-woocommerce-system-status',
			'file_path'   => MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-shipping-rates-for-woocommerce-system-status.php'
			);
	
		$msrfw_default_tabs = 
		//desc - filter for trial.
		apply_filters('mwb_msrfw_plugin_standard_admin_settings_tabs', $msrfw_default_tabs);

		return $msrfw_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since 1.0.0
	 * @param string $path   path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_msrfw_plug_load_template( $path, $params = array() ) {
		if (file_exists($path) ) {

			include $path;
		} else {

			/* translators: %s: file path */
			$msrfw_notice = sprintf(esc_html__('Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'mwb-shipping-rates-for-woocommerce'), $path);
			$this->mwb_msrfw_plug_admin_notice($msrfw_notice, 'error');
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param string $msrfw_message Message to display.
	 * @param string $type        notice type, accepted values - error/update/update-nag.
	 * @since 1.0.0
	 */
	public static function mwb_msrfw_plug_admin_notice( $msrfw_message, $type = 'error' ) {

		$msrfw_classes = 'notice';

		switch ( $type ) {

			case 'update':
			$msrfw_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
			$msrfw_classes .= 'update-nag is-dismissible';
			break;

			case 'success':
			$msrfw_classes .= 'notice-success is-dismissible';
				break;

			default:
			$msrfw_classes .= 'notice-error is-dismissible';
		}

		$msrfw_notice  = '<div class="' . esc_attr($msrfw_classes) . '">';
		$msrfw_notice .= '<p>' . esc_html($msrfw_message) . '</p>';
		$msrfw_notice .= '</div>';

		echo wp_kses_post($msrfw_notice);
	}

	/**
	 * Show WordPress and server info.
	 *
	 * @return Array $msrfw_system_data       returns array of all WordPress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_msrfw_plug_system_status() {
		global $wpdb;
				$msrfw_system_status = array();
			 $msrfw_wordpress_status = array();
				  $msrfw_system_data = array();

		// Get the web server.
		$msrfw_system_status['web_server'] = isset($_SERVER['SERVER_SOFTWARE']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_SOFTWARE'])) : '';

		// Get PHP version.
		$msrfw_system_status['php_version'] = function_exists('phpversion') ? phpversion() : __('N/A (phpversion function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// Get the server's IP address.
		$msrfw_system_status['server_ip'] = isset($_SERVER['SERVER_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_ADDR'])) : '';

		// Get the server's port.
		$msrfw_system_status['server_port'] = isset($_SERVER['SERVER_PORT']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_PORT'])) : '';

		// Get the uptime.
		$msrfw_system_status['uptime'] = function_exists('exec') ? @exec('uptime -p') : __('N/A (make sure exec function is enabled)', 'mwb-shipping-rates-for-woocommerce');

		// Get the server path.
		$msrfw_system_status['server_path'] = defined('ABSPATH') ? ABSPATH : __('N/A (ABSPATH constant not defined)', 'mwb-shipping-rates-for-woocommerce');

		// Get the OS.
		$msrfw_system_status['os'] = function_exists('php_uname') ? php_uname('s') : __('N/A (php_uname function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// Get WordPress version.
		$msrfw_wordpress_status['wp_version'] = function_exists('get_bloginfo') ? get_bloginfo('version') : __('N/A (get_bloginfo function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// Get and count active WordPress plugins.
		$msrfw_wordpress_status['wp_active_plugins'] = function_exists('get_option') ? count(get_option('active_plugins')) : __('N/A (get_option function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// See if this site is multisite or not.
		$msrfw_wordpress_status['wp_multisite'] = function_exists('is_multisite') && is_multisite() ? __('Yes', 'mwb-shipping-rates-for-woocommerce') : __('No', 'mwb-shipping-rates-for-woocommerce');

		// See if WP Debug is enabled.
		$msrfw_wordpress_status['wp_debug_enabled'] = defined('WP_DEBUG') ? __('Yes', 'mwb-shipping-rates-for-woocommerce') : __('No', 'mwb-shipping-rates-for-woocommerce');

		// See if WP Cache is enabled.
		$msrfw_wordpress_status['wp_cache_enabled'] = defined('WP_CACHE') ? __('Yes', 'mwb-shipping-rates-for-woocommerce') : __('No', 'mwb-shipping-rates-for-woocommerce');

		// Get the total number of WordPress users on the site.
		$msrfw_wordpress_status['wp_users'] = function_exists('count_users') ? count_users() : __('N/A (count_users function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// Get the number of published WordPress posts.
		$msrfw_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __('0', 'mwb-shipping-rates-for-woocommerce');

		// Get PHP memory limit.
		$msrfw_system_status['php_memory_limit'] = function_exists('ini_get') ? (int) ini_get('memory_limit') : __('N/A (ini_get function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// Get the PHP error log path.
		$msrfw_system_status['php_error_log_path'] = ! ini_get('error_log') ? __('N/A', 'mwb-shipping-rates-for-woocommerce') : ini_get('error_log');

		// Get PHP max upload size.
		$msrfw_system_status['php_max_upload'] = function_exists('ini_get') ? (int) ini_get('upload_max_filesize') : __('N/A (ini_get function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// Get PHP max post size.
		$msrfw_system_status['php_max_post'] = function_exists('ini_get') ? (int) ini_get('post_max_size') : __('N/A (ini_get function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// Get the PHP architecture.
		if (PHP_INT_SIZE === 4 ) {
			$msrfw_system_status['php_architecture'] = '32-bit';
		} elseif (PHP_INT_SIZE === 8 ) {
			$msrfw_system_status['php_architecture'] = '64-bit';
		} else {
			$msrfw_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$msrfw_system_status['server_hostname'] = function_exists('gethostname') ? gethostname() : __('N/A (gethostname function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// Show the number of processes currently running on the server.
		$msrfw_system_status['processes'] = function_exists('exec') ? @exec('ps aux | wc -l') : __('N/A (make sure exec is enabled)', 'mwb-shipping-rates-for-woocommerce');

		// Get the memory usage.
		$msrfw_system_status['memory_usage'] = function_exists('memory_get_peak_usage') ? round(memory_get_peak_usage(true) / 1024 / 1024, 2) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if (stristr(PHP_OS, 'win') ) {
				   $msrfw_system_status['is_windows'] = true;
			$msrfw_system_status['windows_cpu_usage'] = function_exists('exec') ? @exec('wmic cpu get loadpercentage /all') : __('N/A (make sure exec is enabled)', 'mwb-shipping-rates-for-woocommerce');
		}

		// Get the memory limit.
		$msrfw_system_status['memory_limit'] = function_exists('ini_get') ? (int) ini_get('memory_limit') : __('N/A (ini_get function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// Get the PHP maximum execution time.
		$msrfw_system_status['php_max_execution_time'] = function_exists('ini_get') ? ini_get('max_execution_time') : __('N/A (ini_get function does not exist)', 'mwb-shipping-rates-for-woocommerce');

		// Get outgoing IP address.
		global $wp_filesystem;  //  global object of WordPress filesystem.
		WP_Filesystem(); // intialise new file system object.
		$file_data                          = $wp_filesystem->get_contents( 'http://ipecho.net/plain' ) ;// retrieve the file data. 
		$msrfw_system_status['outgoing_ip'] = ! empty( $file_data ) ? $file_data : __( 'N/A (File data not set.)', 'mwb-shipping-rates-for-woocommerce' );

		$msrfw_system_data['php'] = $msrfw_system_status;
		$msrfw_system_data['wp']  = $msrfw_wordpress_status;

		return $msrfw_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param string $msrfw_components html to display.
	 * @since 1.0.0
	 */
	public function mwb_msrfw_plug_generate_html( $msrfw_components = array() ) {
		if (is_array($msrfw_components) && ! empty($msrfw_components) ) {
			foreach ( $msrfw_components as $msrfw_component ) {
				if (! empty($msrfw_component['type']) && ! empty($msrfw_component['id']) ) {
					switch ( $msrfw_component['type'] ) {

						case 'hidden':
						case 'number':
						case 'email':
						case 'text':
							?>
						<div class="mwb-form-group mwb-msrfw-<?php echo esc_attr($msrfw_component['type']); ?>">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr($msrfw_component['id']); ?>" class="mwb-form-label"><?php echo ( isset($msrfw_component['title']) ? esc_html($msrfw_component['title']) : '' ); // phpcs:ignore Standard.Category.SniffName.ErrorCode. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
						<?php if ('number' !== $msrfw_component['type'] ) { ?>
												<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( isset($msrfw_component['placeholder']) ? esc_attr($msrfw_component['placeholder']) : '' ); ?></span>
						<?php } ?>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input
									class="mdc-text-field__input <?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?>" 
									name="<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?>"
									id="<?php echo esc_attr($msrfw_component['id']); ?>"
									type="<?php echo esc_attr($msrfw_component['type']); ?>"
									value="<?php echo ( isset($msrfw_component['value']) ? esc_attr($msrfw_component['value']) : '' ); ?>"
									placeholder="<?php echo ( isset($msrfw_component['placeholder']) ? esc_attr($msrfw_component['placeholder']) : '' ); ?>"
									>
								</label>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset($msrfw_component['description']) ? esc_attr($msrfw_component['description']) : '' ); ?></div>
								</div>
							</div>
						</div>
						<?php
							break; 
						case 'password':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr($msrfw_component['id']); ?>" class="mwb-form-label"><?php echo ( isset($msrfw_component['title']) ? esc_html($msrfw_component['title']) : '' ); // phpcs:ignore Standard.Category.SniffName.ErrorCode. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input 
									class="mdc-text-field__input <?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?> mwb-form__password" 
									name="<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?>"
									id="<?php echo esc_attr($msrfw_component['id']); ?>"
									type="<?php echo esc_attr($msrfw_component['type']); ?>"
									value="<?php echo ( isset($msrfw_component['value']) ? esc_attr($msrfw_component['value']) : '' ); ?>"
									placeholder="<?php echo ( isset($msrfw_component['placeholder']) ? esc_attr($msrfw_component['placeholder']) : '' ); ?>"
									>
									<i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing mwb-password-hidden" tabindex="0" role="button">visibility</i>
								</label>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset($msrfw_component['description']) ? esc_attr($msrfw_component['description']) : '' ); ?></div>
								</div>
							</div>
						</div>
						<?php
							break;

						case 'textarea':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label class="mwb-form-label" for="<?php echo esc_attr($msrfw_component['id']); ?>"><?php echo ( isset($msrfw_component['title']) ? esc_html($msrfw_component['title']) : '' ); // phpcs:ignore Standard.Category.SniffName.ErrorCode. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea"      for="text-field-hero-input">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
											<span class="mdc-floating-label"><?php echo ( isset($msrfw_component['placeholder']) ? esc_attr($msrfw_component['placeholder']) : '' ); ?></span>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<span class="mdc-text-field__resizer">
										<textarea class="mdc-text-field__input <?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?>" rows="2" cols="25" aria-label="Label" name="<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?>" id="<?php echo esc_attr($msrfw_component['id']); ?>" placeholder="<?php echo ( isset($msrfw_component['placeholder']) ? esc_attr($msrfw_component['placeholder']) : '' ); ?>"><?php echo ( isset($msrfw_component['value']) ? esc_textarea($msrfw_component['value']) : '' ); // phpcs:ignore Standard.Category.SniffName.ErrorCode. ?></textarea>
									</span>
								</label>
							</div>
						</div>
							<?php
							break;

						case 'select':
						case 'multiselect':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label class="mwb-form-label" for="<?php echo esc_attr($msrfw_component['id']); ?>"><?php echo ( isset($msrfw_component['title']) ? esc_html($msrfw_component['title']) : '' ); // phpcs:ignore Standard.Category.SniffName.ErrorCode. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<div class="mwb-form-select">
									<select id="<?php echo esc_attr($msrfw_component['id']); ?>" name="<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?><?php echo ( 'multiselect' === $msrfw_component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr($msrfw_component['id']); ?>" class="mdl-textfield__input <?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?>" <?php echo 'multiselect' === $msrfw_component['type'] ? 'multiple="multiple"' : ''; ?> >
						<?php
							foreach ( $msrfw_component['options'] as $msrfw_key => $msrfw_val ) {
								?>
											<option value="<?php echo esc_attr($msrfw_key); ?>"
												<?php
												if (is_array($msrfw_component['value']) ) {
													selected(in_array((string) $msrfw_key, $msrfw_component['value'], true), true);
												} else {
																   selected($msrfw_component['value'], (string) $msrfw_key);
												}
												?>
												>
												<?php echo esc_html($msrfw_val); ?>
											</option>
									<?php
							}
							?>
									</select>
									<label class="mdl-textfield__label" for="<?php echo esc_attr($msrfw_component['id']); ?>"><?php echo esc_html($msrfw_component['description']); ?><?php echo ( isset($msrfw_component['description']) ? esc_attr($msrfw_component['description']) : '' ); ?></label>
								</div>
							</div>
						</div>

							<?php
							break;

						case 'checkbox':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr($msrfw_component['id']); ?>" class="mwb-form-label"><?php echo ( isset($msrfw_component['title']) ? esc_html($msrfw_component['title']) : '' ); //phpcs:ignore Standard.Category.SniffName.ErrorCode. ?></label>
							</div>
							<div class="mwb-form-group__control mwb-pl-4">
								<div class="mdc-form-field">
									<div class="mdc-checkbox">
										<input 
										name="<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?>"
										id="<?php echo esc_attr($msrfw_component['id']); ?>"
										type="checkbox"
										class="mdc-checkbox__native-control <?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?>"
										value="<?php echo ( isset($msrfw_component['value']) ? esc_attr($msrfw_component['value']) : '' ); ?>"
						<?php checked($msrfw_component['value'], '1'); ?>
										/>
										<div class="mdc-checkbox__background">
											<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
												<path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
											</svg>
											<div class="mdc-checkbox__mixedmark"></div>
										</div>
										<div class="mdc-checkbox__ripple"></div>
									</div>
									<label for="checkbox-1"><?php echo ( isset($msrfw_component['description']) ? esc_attr($msrfw_component['description']) : '' ); ?></label>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'radio':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr($msrfw_component['id']); ?>" class="mwb-form-label"><?php echo ( isset($msrfw_component['title']) ? esc_html($msrfw_component['title']) : '' ); // phpcs:ignore Standard.Category.SniffName.ErrorCode. ?></label>
							</div>
							<div class="mwb-form-group__control mwb-pl-4">
								<div class="mwb-flex-col">
						<?php
							foreach ( $msrfw_component['options'] as $msrfw_radio_key => $msrfw_radio_val ) {
								?>
										<div class="mdc-form-field">
											<div class="mdc-radio">
												<input
												name="<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?>"
												value="<?php echo esc_attr($msrfw_radio_key); ?>"
												type="radio"
												class="mdc-radio__native-control <?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?>"
							<?php checked($msrfw_radio_key, $msrfw_component['value']); ?>
												>
												<div class="mdc-radio__background">
													<div class="mdc-radio__outer-circle"></div>
													<div class="mdc-radio__inner-circle"></div>
												</div>
												<div class="mdc-radio__ripple"></div>
											</div>
											<label for="radio-1"><?php echo esc_html($msrfw_radio_val); ?></label>
										</div>    
							<?php
							}
							?>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'radio-switch':
							?>

						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="" class="mwb-form-label"><?php echo ( isset($msrfw_component['title']) ? esc_html($msrfw_component['title']) : '' ); // phpcs:ignore Standard.Category.SniffName.ErrorCode. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<div>
									<div class="mdc-switch">
										<div class="mdc-switch__track"></div>
										<div class="mdc-switch__thumb-underlay">
											<div class="mdc-switch__thumb"></div>
											<input name="<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?>" type="checkbox" id="<?php echo esc_html($msrfw_component['id']); ?>" value="on" class="mdc-switch__native-control <?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?>" role="switch" aria-checked="
						<?php
							if ('on' === $msrfw_component['value'] ) {
							echo 'true';
							} else {
							echo 'false';
							}
							?>
											"
											<?php checked($msrfw_component['value'], 'on'); ?>
											>
										</div>
									</div>
								</div>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset($msrfw_component['description']) ? esc_attr($msrfw_component['description']) : '' ); ?></div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'button':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label"></div>
							<div class="mwb-form-group__control">
								<button class="mdc-button mdc-button--raised" name= "<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?>"
									id="<?php echo esc_attr($msrfw_component['id']); ?>"> <span class="mdc-button__ripple"></span>
									<span class="mdc-button__label <?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?>"><?php echo ( isset($msrfw_component['button_text']) ? esc_html($msrfw_component['button_text']) : '' ); ?></span>
								</button>
							</div>
						</div>

							<?php
							break;

						case 'multi':
							?>
							<div class="mwb-form-group mwb-msrfw-<?php echo esc_attr($msrfw_component['type']); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr($msrfw_component['id']); ?>" class="mwb-form-label"><?php echo ( isset($msrfw_component['title']) ? esc_html($msrfw_component['title']) : '' ); // phpcs:ignore Standard.Category.SniffName.ErrorCode. ?></label>
									</div>
									<div class="mwb-form-group__control">
						<?php
							foreach ( $msrfw_component['value'] as $component ) {
								?>
											<label class="mdc-text-field mdc-text-field--outlined">
												<span class="mdc-notched-outline">
													<span class="mdc-notched-outline__leading"></span>
													<span class="mdc-notched-outline__notch">
							<?php if ('number' !== $component['type'] ) { ?>
															<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( isset($msrfw_component['placeholder']) ? esc_attr($msrfw_component['placeholder']) : '' ); ?></span>
							<?php } ?>
													</span>
													<span class="mdc-notched-outline__trailing"></span>
												</span>
												<input 
												class="mdc-text-field__input <?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?>" 
												name="<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?>"
												id="<?php echo esc_attr($component['id']); ?>"
												type="<?php echo esc_attr($component['type']); ?>"
												value="<?php echo ( isset($msrfw_component['value']) ? esc_attr($msrfw_component['value']) : '' ); ?>"
												placeholder="<?php echo ( isset($msrfw_component['placeholder']) ? esc_attr($msrfw_component['placeholder']) : '' ); ?>"
							<?php echo esc_attr(( 'number' === $component['type'] ) ? 'max=10 min=0' : ''); ?>
												>
											</label>
						<?php } ?>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset($msrfw_component['description']) ? esc_attr($msrfw_component['description']) : '' ); ?></div>
									</div>
								</div>
							</div>
								<?php
							break;
						case 'color':
						case 'date':
						case 'file':
							?>
							<div class="mwb-form-group mwb-msrfw-<?php echo esc_attr($msrfw_component['type']); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr($msrfw_component['id']); ?>" class="mwb-form-label"><?php echo ( isset($msrfw_component['title']) ? esc_html($msrfw_component['title']) : '' ); // phpcs:ignore Standard.Category.SniffName.ErrorCode. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<label>
										<input 
										class="<?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?>" 
										name="<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?>"
										id="<?php echo esc_attr($msrfw_component['id']); ?>"
										type="<?php echo esc_attr($msrfw_component['type']); ?>"
										value="<?php echo ( isset($msrfw_component['value']) ? esc_attr($msrfw_component['value']) : '' ); ?>"
									<?php echo esc_html(( 'date' === $msrfw_component['type'] ) ? 'max=' . gmdate('Y-m-d', strtotime(gmdate('Y-m-d', mktime()) . ' + 365 day')) . 'min=' . gmdate('Y-m-d') . '' : ''); ?>
										>
									</label>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset($msrfw_component['description']) ? esc_attr($msrfw_component['description']) : '' ); ?></div>
									</div>
								</div>
							</div>
							<?php
							break;

						case 'submit':
							?>
						<tr valign="top">
							<td scope="row">
								<input type="submit" class="button button-primary" 
								name="<?php echo ( isset($msrfw_component['name']) ? esc_html($msrfw_component['name']) : esc_html($msrfw_component['id']) ); ?>"
								id="<?php echo esc_attr($msrfw_component['id']); ?>"
								class="<?php echo ( isset($msrfw_component['class']) ? esc_attr($msrfw_component['class']) : '' ); ?>"
								value="<?php echo esc_attr($msrfw_component['button_text']); ?>"
								/>
							</td>
						</tr>
							<?php
							break;

						default:
							break;
					}
				}
			}
		}
	}

	// public static variable to be accessed in this plugin.
	public static $lic_callback_function = 'check_lcns_validity';

	// public static variable to be accessed in this plugin.
	public static $lic_ini_callback_function = 'check_lcns_initial_days';

	/**
	 * Validate the use of features of this plugin.
	 *
	 * @since 1.0.0
	 */
	public static function check_lcns_validity() {

		$mwb_msrfw_lcns_key = get_option('mwb_msrfw_license_key', '');

		$mwb_msrfw_lcns_status = get_option('mwb_msrfw_license_check', '');

		if ($mwb_msrfw_lcns_key && true === $mwb_msrfw_lcns_status ) {

			return true;
		} else {

			return false;
		}
	}

	/**
	 * Validate the use of features of this plugin for initial days.
	 *
	 * @since 1.0.0
	 */
	public static function check_lcns_initial_days() {

		$thirty_days = get_option('mwb_msrfw_activated_timestamp', 0);

		$current_time = current_time('timestamp');

		$day_count = ( $thirty_days - $current_time ) / ( 24 * 60 * 60 );

		return $day_count;
	}
}
