<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace mwb_shipping_rates_for_woocommerce_public.
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/public
 */
class Mwb_Shipping_Rates_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function msrfw_public_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'public/css/mwb-shipping-rates-for-woocommerce-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function msrfw_public_enqueue_scripts() {

		wp_register_script( $this->plugin_name, MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'public/js/mwb-shipping-rates-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'msrfw_public_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name );

	}

	/**
	 * Setting the default shipping option.
	 *
	 * @since    1.0.0
	 */
	public function auto_select_free_shipping_by_default() {
		if ('yes' === get_option('default_shipping_check')) {
			if ( isset(WC()->session) && ! WC()->session->has_session() ) {
			WC()->session->set_customer_session_cookie( true );
			}
		// Check if "free shipping" is already set
		if ( strpos( WC()->session->get('chosen_shipping_methods')[0], 'mwb_shipping_rate' ) !== false ) {
			return;
			}
	
		// Loop through shipping methods
			foreach ( WC()->session->get('shipping_for_package_0')['rates'] as $key => $rate ) {
				if ( 'mwb_shipping_rate' === $rate->method_id) {
				// Set "Free shipping" method
				WC()->session->set( 'chosen_shipping_methods', array($rate->id) );
				return;
				}
			}
		}
	}

	/**
	 * Setting the visibility shipping option.
	 *
	 * @since    1.0.0
	 */
	public function hide_shipping_for_unlogged_user( $rates, $package ) {
				$package;
		if ( 'on' === get_option('msrfw_radio_switch_visibility')) { 

			foreach ( $rates as $rate_id => $rate_val ) { 
				if ( 'mwb_shipping_rate' === $rate_val->get_method_id() ) { 
					if (!is_user_logged_in() ) {
					unset( $rates[ $rate_id ] );
					}
				} 
			}
		}
		return $rates;
		
	}

}
