<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace shipping_rates_for_woocommerce_public.
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Shipping_rates_for_woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
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
	public function srfw_public_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'public/src/scss/shipping-rates-for-woocommerce-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function srfw_public_enqueue_scripts() {

		wp_register_script( $this->plugin_name, SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'public/src/js/shipping-rates-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'srfw_public_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name );

	}

	/**
	 * Setting the default shipping option.
	 *
	 * @since    1.0.0
	 */
	function auto_select_free_shipping_by_default() {
		if('true' === get_option('default_shipping_check')) {
		if ( isset(WC()->session) && ! WC()->session->has_session() )
			WC()->session->set_customer_session_cookie( true );
	
		// Check if "free shipping" is already set
		if ( strpos( WC()->session->get('chosen_shipping_methods')[0], 'mwb_shipping_rate' ) !== false )
			return;
	
		// Loop through shipping methods
		foreach( WC()->session->get('shipping_for_package_0')['rates'] as $key => $rate ){
			if( $rate->method_id === 'mwb_shipping_rate' ){
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
	public function hide_shipping_for_unlogged_user( $rates , $package ) {
      $checker = get_current_user_id();
		if ( 'true' === get_option('visibility_check') ) { 
			if(0 === $checker){
			foreach( $rates as $rate_id => $rate_val ) { 
				if ( 'mwb_shipping_rate' === $rate_val->get_method_id() ) { 
					unset( $rates[ $rate_id ] );
				} 
			} 
		   }
		} 
		return $rates; 
		}

}