<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/includes
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
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Shipping_rates_for_woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Shipping_rates_for_woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $srfw_onboard    To initializsed the object of class onboard.
	 */
	protected $srfw_onboard;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area,
	 * the public-facing side of the site and common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'SHIPPING_RATES_FOR_WOOCOMMERCE_VERSION' ) ) {

			$this->version = SHIPPING_RATES_FOR_WOOCOMMERCE_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'shipping-rates-for-woocommerce';

		$this->shipping_rates_for_woocommerce_dependencies();
		$this->shipping_rates_for_woocommerce_locale();
		if ( is_admin() ) {
			$this->shipping_rates_for_woocommerce_admin_hooks();
		} else {
			$this->shipping_rates_for_woocommerce_public_hooks();
		}
		$this->shipping_rates_for_woocommerce_common_hooks();

		$this->shipping_rates_for_woocommerce_api_hooks();


	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Shipping_rates_for_woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Shipping_rates_for_woocommerce_i18n. Defines internationalization functionality.
	 * - Shipping_rates_for_woocommerce_Admin. Defines all hooks for the admin area.
	 * - Shipping_rates_for_woocommerce_Common. Defines all hooks for the common area.
	 * - Shipping_rates_for_woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function shipping_rates_for_woocommerce_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-shipping-rates-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-shipping-rates-for-woocommerce-i18n.php';

		if ( is_admin() ) {

			// The class responsible for defining all actions that occur in the admin area.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-shipping-rates-for-woocommerce-admin.php';

			// The class responsible for on-boarding steps for plugin.
			if ( is_dir(  plugin_dir_path( dirname( __FILE__ ) ) . 'onboarding' ) && ! class_exists( 'Shipping_rates_for_woocommerce_Onboarding_Steps' ) ) {
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-shipping-rates-for-woocommerce-onboarding-steps.php';
			}

			if ( class_exists( 'Shipping_rates_for_woocommerce_Onboarding_Steps' ) ) {
				$srfw_onboard_steps = new Shipping_rates_for_woocommerce_Onboarding_Steps();
			}
		} else {

			// The class responsible for defining all actions that occur in the public-facing side of the site.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-shipping-rates-for-woocommerce-public.php';

		}

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'package/rest-api/class-shipping-rates-for-woocommerce-rest-api.php';

		/**
		 * This class responsible for defining common functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-shipping-rates-for-woocommerce-common.php';

		$this->loader = new Shipping_rates_for_woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Shipping_rates_for_woocommerce_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function shipping_rates_for_woocommerce_locale() {

		$plugin_i18n = new Shipping_rates_for_woocommerce_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function shipping_rates_for_woocommerce_admin_hooks() {

		$srfw_plugin_admin = new Shipping_rates_for_woocommerce_Admin( $this->srfw_get_plugin_name(), $this->srfw_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $srfw_plugin_admin, 'srfw_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $srfw_plugin_admin, 'srfw_admin_enqueue_scripts' );

		// Add settings menu for shipping-rates-for-woocommerce.
		$this->loader->add_action( 'admin_menu', $srfw_plugin_admin, 'srfw_options_page' );
		$this->loader->add_action( 'admin_menu', $srfw_plugin_admin, 'mwb_srfw_remove_default_submenu', 50 );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $srfw_plugin_admin, 'srfw_admin_submenu_page', 15 );
		$this->loader->add_filter( 'srfw_template_settings_array', $srfw_plugin_admin, 'srfw_admin_template_settings_page', 10 );
		$this->loader->add_filter( 'srfw_general_settings_array', $srfw_plugin_admin, 'srfw_admin_general_settings_page', 10 );

		// Saving tab settings.
		$this->loader->add_action( 'admin_init', $srfw_plugin_admin, 'srfw_admin_save_tab_settings' );
		$this->loader->add_action( 'admin_init', $srfw_plugin_admin, 'srfw_default_shipping_unchecked' );
		$this->loader->add_action( 'admin_init', $srfw_plugin_admin, 'srfw_visibility_shipping_unchecked' );
		

		//Ajax for conditional shipping.
		$this->loader->add_action( 'wp_ajax_shipping_coupon_action', $srfw_plugin_admin, 'srfw_shipping_coupon' , 10);
		$this->loader->add_action( 'wp_ajax_nopriv_shipping_coupon_action', $srfw_plugin_admin, 'srfw_shipping_coupon', 10 );
		
		//Ajax for visibility of  shipping. 
		$this->loader->add_action( 'wp_ajax_shipping_visibility', $srfw_plugin_admin, 'srfw_visibility_shipping_checked' , 10);
		$this->loader->add_action( 'wp_ajax_nopriv_shipping_visibility', $srfw_plugin_admin, 'srfw_visibility_shipping_checked',  10 );

		$this->loader->add_action( 'wp_ajax_expected_date', $srfw_plugin_admin, 'expected_date_delivery_fun' , 10);
		$this->loader->add_action( 'wp_ajax_nopriv_expected_date', $srfw_plugin_admin, 'expected_date_delivery_fun', 10 );

		$this->loader->add_action( 'wp_ajax_product_categories', $srfw_plugin_admin, 'product_shipping_categories' , 10);
		$this->loader->add_action( 'wp_ajax_nopriv_product_categories', $srfw_plugin_admin, 'product_shipping_categories', 10 );

		$this->loader->add_action( 'wp_ajax_show_advance_shipping_field', $srfw_plugin_admin, 'fun_show_advance_field' , 10);
		$this->loader->add_action( 'wp_ajax_nopriv_show_advance_shipping_field', $srfw_plugin_admin, 'fun_show_advance_field', 10 );

		$this->loader->add_action( 'wp_ajax_hide_advance_shipping_field', $srfw_plugin_admin, 'fun_hide_advance_field' , 10);
		$this->loader->add_action( 'wp_ajax_nopriv_hide_advance_shipping_field', $srfw_plugin_admin, 'fun_hide_advance_field', 10 );

		$this->loader->add_action( 'wp_ajax_show_free_shipping_field', $srfw_plugin_admin, 'fun_show_free_field' , 10);
		$this->loader->add_action( 'wp_ajax_nopriv_show_free_shipping_field', $srfw_plugin_admin, 'fun_show_free_field', 10 );

		$this->loader->add_action( 'wp_ajax_hide_free_shipping_field', $srfw_plugin_admin, 'fun_hide_free_field' , 10);
		$this->loader->add_action( 'wp_ajax_nopriv_hide_free_shipping_field', $srfw_plugin_admin, 'fun_hide_free_field', 10 );

	}

	/**
	 * Register all of the hooks related to the common functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function shipping_rates_for_woocommerce_common_hooks() {

		$srfw_plugin_common = new Shipping_rates_for_woocommerce_Common( $this->srfw_get_plugin_name(), $this->srfw_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $srfw_plugin_common, 'srfw_common_enqueue_styles' );

		$this->loader->add_action( 'wp_enqueue_scripts', $srfw_plugin_common, 'srfw_common_enqueue_scripts' );
		
		// Creating MWb shipping method.
		if ('on' === get_option( 'srfw_radio_switch_shipping')) {
		$this->loader->add_action( 'woocommerce_shipping_init', $srfw_plugin_common, 'mwb_shipping_rate_for_woocommerce_create_shipping_method' );
		$this->loader->add_filter( 'woocommerce_shipping_methods', $srfw_plugin_common, 'mwb_shipping_rate_for_woocommerce_add_shipping_method' );
		$this->loader->add_action( 'woocommerce_applied_coupon', $srfw_plugin_common, 'srfw_coupon_add_fun' );
		$this->loader->add_action( 'woocommerce_removed_coupon', $srfw_plugin_common, 'srfw_coupon_remove_fun' );
		$this->loader->add_action( 'woocommerce_before_cart', $srfw_plugin_common, 'shipping_rates_categories' );
		$this->loader->add_action( 'woocommerce_cart_updated', $srfw_plugin_common, 'shipping_rates_categories' );
		$this->loader->add_action( 'woocommerce_before_shipping_calculator', $srfw_plugin_common, 'expected_delivery_date_message' );
		$this->loader->add_action( 'woocommerce_review_order_before_payment', $srfw_plugin_common, 'expected_delivery_date_message' );
		$this->loader->add_action( 'woocommerce_before_thankyou', $srfw_plugin_common, 'expected_delivery_date_message' );
		$this->loader->add_filter( 'woocommerce_get_item_data', $srfw_plugin_common , 'displaying_cart_items_weight', 10, 2 );
		}
		// $this->loader->add_action( 'wp_ajax_shipping_coupon_action', $srfw_plugin_common, 'srfw_shipping_coupon' ,10);woocommerce_after_cart_item_name
		// $this->loader->add_action( 'wp_ajax_nopriv_shipping_coupon_action', $srfw_plugin_common, 'srfw_shipping_coupon',10 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality 
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function shipping_rates_for_woocommerce_public_hooks() {

		$srfw_plugin_public = new Shipping_rates_for_woocommerce_Public( $this->srfw_get_plugin_name(), $this->srfw_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $srfw_plugin_public, 'srfw_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $srfw_plugin_public, 'srfw_public_enqueue_scripts' );
		$this->loader->add_action( 'init', $srfw_plugin_public , 'auto_select_free_shipping_by_default' );
		$this->loader->add_filter( 'woocommerce_package_rates', $srfw_plugin_public , 'hide_shipping_for_unlogged_user', 10, 2 );
	}

	/**
	 * Register all of the hooks related to the api functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function shipping_rates_for_woocommerce_api_hooks() {

		$srfw_plugin_api = new Shipping_rates_for_woocommerce_Rest_Api( $this->srfw_get_plugin_name(), $this->srfw_get_version() );
		$this->loader->add_action( 'rest_api_init', $srfw_plugin_api, 'mwb_srfw_add_endpoint' );
	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function srfw_run() {
		$this->loader->srfw_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function srfw_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Shipping_rates_for_woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function srfw_get_loader() {
		return $this->loader;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Shipping_rates_for_woocommerce_Onboard    Orchestrates the hooks of the plugin.
	 */
	public function srfw_get_onboard() {
		return $this->srfw_onboard;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function srfw_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_srfw_plug tabs.
	 *
	 * @return  Array       An key=>value pair of shipping-rates-for-woocommerce tabs.
	 */
	public function mwb_srfw_plug_default_tabs() {

		$srfw_default_tabs = array();

		$srfw_default_tabs['shipping-rates-for-woocommerce-general'] = array(
			'title'       => esc_html__( 'General Setting', 'shipping-rates-for-woocommerce' ),
			'name'        => 'shipping-rates-for-woocommerce-general',
		);
		$srfw_default_tabs = apply_filters( 'mwb_srfw_plugin_standard_admin_settings_tabs', $srfw_default_tabs );

		$srfw_default_tabs['shipping-rates-for-woocommerce-system-status'] = array(
			'title'       => esc_html__( 'System Status', 'shipping-rates-for-woocommerce' ),
			'name'        => 'shipping-rates-for-woocommerce-system-status',
		);
		$srfw_default_tabs['shipping-rates-for-woocommerce-template'] = array(
			'title'       => esc_html__( 'Templates', 'shipping-rates-for-woocommerce' ),
			'name'        => 'shipping-rates-for-woocommerce-template',
		);
		$srfw_default_tabs['shipping-rates-for-woocommerce-overview'] = array(
			'title'       => esc_html__( 'Overview', 'shipping-rates-for-woocommerce' ),
			'name'        => 'shipping-rates-for-woocommerce-overview',
		);

		return $srfw_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_srfw_plug_load_template( $path, $params = array() ) {

		$srfw_file_path = SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . $path;

		if ( file_exists( $srfw_file_path ) ) {

			include $srfw_file_path;
		} else {

			/* translators: %s: file path */
			$srfw_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'shipping-rates-for-woocommerce' ), $srfw_file_path );
			$this->mwb_srfw_plug_admin_notice( $srfw_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $srfw_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_srfw_plug_admin_notice( $srfw_message, $type = 'error' ) {

		$srfw_classes = 'notice ';

		switch ( $type ) {

			case 'update':
			$srfw_classes .= 'updated is-dismissible';
			break;

			case 'update-nag':
			$srfw_classes .= 'update-nag is-dismissible';
			break;

			case 'success':
			$srfw_classes .= 'notice-success is-dismissible';
			break;

			default:
			$srfw_classes .= 'notice-error is-dismissible';
		}

		$srfw_notice  = '<div class="' . esc_attr( $srfw_classes ) . ' mwb-errorr-8">';
		$srfw_notice .= '<p>' . esc_html( $srfw_message ) . '</p>';
		$srfw_notice .= '</div>';

		echo wp_kses_post( $srfw_notice );
	}


	/**
	 * Show wordpress and server info.
	 *
	 * @return  Array $srfw_system_data       returns array of all wordpress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_srfw_plug_system_status() {
		global $wpdb;
		$srfw_system_status = array();
		$srfw_wordpress_status = array();
		$srfw_system_data = array();

		// Get the web server.
		$srfw_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$srfw_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'shipping-rates-for-woocommerce' );

		// Get the server's IP address.
		$srfw_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$srfw_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$srfw_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'shipping-rates-for-woocommerce' );

		// Get the server path.
		$srfw_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'shipping-rates-for-woocommerce' );

		// Get the OS.
		$srfw_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'shipping-rates-for-woocommerce' );

		// Get WordPress version.
		$srfw_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'shipping-rates-for-woocommerce' );

		// Get and count active WordPress plugins.
		$srfw_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'shipping-rates-for-woocommerce' );

		// See if this site is multisite or not.
		$srfw_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'shipping-rates-for-woocommerce' ) : __( 'No', 'shipping-rates-for-woocommerce' );

		// See if WP Debug is enabled.
		$srfw_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'shipping-rates-for-woocommerce' ) : __( 'No', 'shipping-rates-for-woocommerce' );

		// See if WP Cache is enabled.
		$srfw_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'shipping-rates-for-woocommerce' ) : __( 'No', 'shipping-rates-for-woocommerce' );

		// Get the total number of WordPress users on the site.
		$srfw_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'shipping-rates-for-woocommerce' );

		// Get the number of published WordPress posts.
		$srfw_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'shipping-rates-for-woocommerce' );

		// Get PHP memory limit.
		$srfw_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'shipping-rates-for-woocommerce' );

		// Get the PHP error log path.
		$srfw_system_status['php_error_log_patexpected_daysh'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'shipping-rates-for-woocommerce' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$srfw_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'shipping-rates-for-woocommerce' );

		// Get PHP max post size.
		$srfw_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'shipping-rates-for-woocommerce' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$srfw_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$srfw_system_status['php_architecture'] = '64-bit';
		} else {
			$srfw_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$srfw_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'shipping-rates-for-woocommerce' );

		// Show the number of processes currently running on the server.
		$srfw_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'shipping-rates-for-woocommerce' );

		// Get the memory usage.
		$srfw_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$srfw_system_status['is_windows'] = true;
			$srfw_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'shipping-rates-for-woocommerce' );
		}

		// Get the memory limit.
		$srfw_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'shipping-rates-for-woocommerce' );

		// Get the PHP maximum execution time.
		$srfw_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'shipping-rates-for-woocommerce' );

		// Get outgoing IP address.
		   global $wp_filesystem;
		   WP_Filesystem();
		   $file_data = $wp_filesystem->get_contents( 'http://ipecho.net/plain' );
   
		   $srfw_system_status['outgoing_ip'] = ! empty( $file_data ) ? $file_data : __( 'N/A (File data not set.)', 'shipping-rates-for-woocommerce' );

		$srfw_system_data['php'] = $srfw_system_status;
		$srfw_system_data['wp']  = $srfw_wordpress_status;

		return $srfw_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $srfw_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_srfw_plug_generate_html( $srfw_components = array() ) {
		if ( is_array( $srfw_components ) && ! empty( $srfw_components ) ) {
			foreach ( $srfw_components as $srfw_component ) {
				if ( ! empty( $srfw_component['type'] ) &&  ! empty( $srfw_component['id'] ) ) {
					switch ( $srfw_component['type'] ) {

						case 'hidden':
						case 'number':
						case 'email':add_filter( 'woocommerce_get_item_data', 'displaying_cart_items_weight', 10, 2 );
						case 'text':
						?>
						<div class="mwb-form-group mwb-srfw-<?php echo esc_attr($srfw_component['type']); ?>">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $srfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $srfw_component['title'] ) ? esc_html( $srfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
											<?php if ( 'number' != $srfw_component['type'] ) { ?>
												<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( isset( $srfw_component['placeholder'] ) ? esc_attr( $srfw_component['placeholder'] ) : '' ); ?></span>
											<?php } ?>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input
									class="mdc-text-field__input <?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?>" 
									name="<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : esc_html( $srfw_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $srfw_component['id'] ); ?>"
									type="<?php echo esc_attr( $srfw_component['type'] ); ?>"
									value="<?php echo ( isset( $srfw_component['value'] ) ? esc_attr( $srfw_component['value'] ) : '' ); ?>"
									placeholder="<?php echo ( isset( $srfw_component['placeholder'] ) ? esc_attr( $srfw_component['placeholder'] ) : '' ); ?>"
									>
								</label>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $srfw_component['description'] ) ? esc_attr( $srfw_component['description'] ) : '' ); ?></div>
								</div>
							</div>
						</div>
						<?php
						break;

						case 'password':
						?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $srfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $srfw_component['title'] ) ? esc_html( $srfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
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
									class="mdc-text-field__input <?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?> mwb-form__password" 
									name="<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : esc_html( $srfw_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $srfw_component['id'] ); ?>"
									type="<?php echo esc_attr( $srfw_component['type'] ); ?>"
									value="<?php echo ( isset( $srfw_component['value'] ) ? esc_attr( $srfw_component['value'] ) : '' ); ?>"
									placeholder="<?php echo ( isset( $srfw_component['placeholder'] ) ? esc_attr( $srfw_component['placeholder'] ) : '' ); ?>"
									>
									<i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing mwb-password-hidden" tabindex="0" role="button">visibility</i>
								</label>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $srfw_component['description'] ) ? esc_attr( $srfw_component['description'] ) : '' ); ?></div>
								</div>
							</div>
						</div>
						<?php
						break;

						case 'textarea':
						?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label class="mwb-form-label" for="<?php echo esc_attr( $srfw_component['id'] ); ?>"><?php echo ( isset( $srfw_component['title'] ) ? esc_html( $srfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea"  	for="text-field-hero-input">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
											<span class="mdc-floating-label"><?php echo ( isset( $srfw_component['placeholder'] ) ? esc_attr( $srfw_component['placeholder'] ) : '' ); ?></span>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<span class="mdc-text-field__resizer">
										<textarea class="mdc-text-field__input <?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?>" rows="2" cols="25" aria-label="Label" name="<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : esc_html( $srfw_component['id'] ) ); ?>" id="<?php echo esc_attr( $srfw_component['id'] ); ?>" placeholder="<?php echo ( isset( $srfw_component['placeholder'] ) ? esc_attr( $srfw_component['placeholder'] ) : '' ); ?>"><?php echo ( isset( $srfw_component['value'] ) ? esc_textarea( $srfw_component['value'] ) : '' ); // WPCS: XSS ok. ?></textarea>
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
								<label class="mwb-form-label" for="<?php echo esc_attr( $srfw_component['id'] ); ?>"><?php echo ( isset( $srfw_component['title'] ) ? esc_html( $srfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<div class="mwb-form-select">
									<select id="<?php echo esc_attr( $srfw_component['id'] ); ?>" name="<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : '' ); ?><?php echo ( 'multiselect' === $srfw_component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr( $srfw_component['id'] ); ?>" class="mdl-textfield__input <?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?>" <?php echo 'multiselect' === $srfw_component['type'] ? 'multiple="multiple"' : ''; ?> >
										<?php
										foreach ( $srfw_component['options'] as $srfw_key => $srfw_val ) {
											?>
											<option value="<?php echo esc_attr( $srfw_key ); ?>"
												<?php
												if ( is_array( $srfw_component['value'] ) ) {
													selected( in_array( (string) $srfw_key, $srfw_component['value'], true ), true );
												} else {
													selected( $srfw_component['value'], (string) $srfw_key );
												}
												?>
												>
												<?php echo esc_html( $srfw_val ); ?>
											</option>
											<?php
										}
										?>
									</select>
									<label class="mdl-textfield__label" for="octane"><?php echo esc_html( $srfw_component['description'] ); ?><?php echo ( isset( $srfw_component['description'] ) ? esc_attr( $srfw_component['description'] ) : '' ); ?></label>
								</div>
							</div>
						</div>

						<?php
						break;

						case 'checkbox':
						?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $srfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $srfw_component['title'] ) ? esc_html( $srfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control mwb-pl-4">
								<div class="mdc-form-field">
									<div class="mdc-checkbox">
										<input 
										name="<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : esc_html( $srfw_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $srfw_component['id'] ); ?>"
										type="checkbox"
										class="mdc-checkbox__native-control <?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?>"
										value="<?php echo ( isset( $srfw_component['value'] ) ? esc_attr( $srfw_component['value'] ) : '' ); ?>"
										<?php checked( $srfw_component['value'], '1' ); ?>
										/>
										<div class="mdc-checkbox__background">
											<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
												<path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
											</svg>
											<div class="mdc-checkbox__mixedmark"></div>
										</div>
										<div class="mdc-checkbox__ripple"></div>
									</div>
									<label for="checkbox-1"><?php echo ( isset( $srfw_component['description'] ) ? esc_attr( $srfw_component['description'] ) : '' ); ?></label>
								</div>
							</div>
						</div>
						<?php
						break;

						case 'radio':
						?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $srfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $srfw_component['title'] ) ? esc_html( $srfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control mwb-pl-4">
								<div class="mwb-flex-col">
									<?php
									foreach ( $srfw_component['options'] as $srfw_radio_key => $srfw_radio_val ) {
										?>
										<div class="mdc-form-field">
											<div class="mdc-radio">
												<input
												name="<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : esc_html( $srfw_component['id'] ) ); ?>"
												value="<?php echo esc_attr( $srfw_radio_key ); ?>"
												type="radio"
												class="mdc-radio__native-control <?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?>"
												<?php checked( $srfw_radio_key, $srfw_component['value'] ); ?>
												>
												<div class="mdc-radio__background">
													<div class="mdc-radio__outer-circle"></div>
													<div class="mdc-radio__inner-circle"></div>
												</div>
												<div class="mdc-radio__ripple"></div>
											</div>
											<label for="radio-1"><?php echo esc_html( $srfw_radio_val ); ?></label>
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
								<label for="" class="mwb-form-label"><?php echo ( isset( $srfw_component['title'] ) ? esc_html( $srfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<div>
									<div class="mdc-switch">
										<div class="mdc-switch__track"></div>
										<div class="mdc-switch__thumb-underlay">
											<div class="mdc-switch__thumb"></div>
											<input name="<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : esc_html( $srfw_component['id'] ) ); ?>" type="checkbox" id="<?php echo esc_html( $srfw_component['id'] ); ?>" value="on" class="mdc-switch__native-control <?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?>" role="switch" aria-checked="<?php if ( 'on' == $srfw_component['value'] ) echo 'true'; else echo 'false'; ?>"
											<?php checked( $srfw_component['value'], 'on' ); ?>
											>
										</div>
									</div>
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
								<button class="mdc-button mdc-button--raised" name= "<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : esc_html( $srfw_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $srfw_component['id'] ); ?>"> <span class="mdc-button__ripple"></span>
									<span class="mdc-button__label <?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?>"><?php echo ( isset( $srfw_component['button_text'] ) ? esc_html( $srfw_component['button_text'] ) : '' ); ?></span>
								</button>
							</div>
						</div>

						<?php
						break;

						case 'multi':
							?>
							<div class="mwb-form-group mwb-isfw-<?php echo esc_attr( $srfw_component['type'] ); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $srfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $srfw_component['title'] ) ? esc_html( $srfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
									</div>
									<div class="mwb-form-group__control">
									<?php
									foreach ( $srfw_component['value'] as $component ) {
										?>
											<label class="mdc-text-field mdc-text-field--outlined">
												<span class="mdc-notched-outline">
													<span class="mdc-notched-outline__leading"></span>
													<span class="mdc-notched-outline__notch">
														<?php if ( 'number' != $component['type'] ) { ?>
															<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( isset( $srfw_component['placeholder'] ) ? esc_attr( $srfw_component['placeholder'] ) : '' ); ?></span>
														<?php } ?>
													</span>
													<span class="mdc-notched-outline__trailing"></span>
												</span>
												<input 
												class="mdc-text-field__input <?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?>" 
												name="<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : esc_html( $srfw_component['id'] ) ); ?>"
												id="<?php echo esc_attr( $component['id'] ); ?>"
												type="<?php echo esc_attr( $component['type'] ); ?>"
												value="<?php echo ( isset( $srfw_component['value'] ) ? esc_attr( $srfw_component['value'] ) : '' ); ?>"
												placeholder="<?php echo ( isset( $srfw_component['placeholder'] ) ? esc_attr( $srfw_component['placeholder'] ) : '' ); ?>"
												<?php echo esc_attr( ( 'number' === $component['type'] ) ? 'max=10 min=0' : '' ); ?>
												>
											</label>
								<?php } ?>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $srfw_component['description'] ) ? esc_attr( $srfw_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
								<?php
							break;
						case 'color':
						case 'date':
						case 'file':
							?>
							<div class="mwb-form-group mwb-isfw-<?php echo esc_attr( $srfw_component['type'] ); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $srfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $srfw_component['title'] ) ? esc_html( $srfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<label class="mdc-text-field mdc-text-field--outlined">
										<input 
										class="<?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?>" 
										name="<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : esc_html( $srfw_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $srfw_component['id'] ); ?>"
										type="<?php echo esc_attr( $srfw_component['type'] ); ?>"
										value="<?php echo ( isset( $srfw_component['value'] ) ? esc_attr( $srfw_component['value'] ) : '' ); ?>"
										<?php echo esc_html( ( 'date' === $srfw_component['type'] ) ? 'max='. date( 'Y-m-d', strtotime( date( "Y-m-d", mktime() ) . " + 365 day" ) ) .' ' . 'min=' . date( "Y-m-d" ) . '' : '' ); ?>
										>
									</label>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $srfw_component['description'] ) ? esc_attr( $srfw_component['description'] ) : '' ); ?></div>
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
								name="<?php echo ( isset( $srfw_component['name'] ) ? esc_html( $srfw_component['name'] ) : esc_html( $srfw_component['id'] ) ); ?>"
								id="<?php echo esc_attr( $srfw_component['id'] ); ?>"
								class="<?php echo ( isset( $srfw_component['class'] ) ? esc_attr( $srfw_component['class'] ) : '' ); ?>"
								value="<?php echo esc_attr( $srfw_component['button_text'] ); ?>"
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
}
