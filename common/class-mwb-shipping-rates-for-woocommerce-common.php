<?php
/**
 * The common functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/common
 */

/**
 * The common functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the common stylesheet and JavaScript.
 * namespace mwb_shipping_rates_for_woocommerce_common.
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/common
 */
class Mwb_Shipping_Rates_For_Woocommerce_Common {
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
	 * Register the stylesheets for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function msrfw_common_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . 'common', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'common/css/mwb-shipping-rates-for-woocommerce-common.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function msrfw_common_enqueue_scripts() {
		wp_register_script( $this->plugin_name . 'common', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'common/js/mwb-shipping-rates-for-woocommerce-common.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name . 'common', 'msrfw_common_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name . 'common' );
	}

	/**
	 * validating makewebbetter license
	 *
	 * @since    1.0.0
	 */

	public function mwb_msrfw_validate_license_key() {
	
		$mwb_msrfw_purchase_code = sanitize_text_field( $_POST['purchase_code'] );
		$api_params = array(
			'slm_action'        => 'slm_activate',
			'secret_key'        => MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_SPECIAL_SECRET_KEY,
			'license_key'       => $mwb_msrfw_purchase_code,
			'_registered_domain' => $_SERVER['SERVER_NAME'],
			'item_reference'    => urlencode( MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_ITEM_REFERENCE ),
			'product_reference' => 'MWBPK-2965',

		);

		$query = esc_url_raw( add_query_arg( $api_params, MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_LICENSE_SERVER_URL ) );
		// $ch = curl_init();
		// curl_setopt( $ch, CURLOPT_URL, $query );
		// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		// curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
		// curl_setopt( $ch, CURLOPT_SSL_VERIFYSTATUS, false );
		// $mwb_msrfw_response = curl_exec( $ch );
		// curl_close($ch);

		$mwb_msrfw_response = wp_remote_get(
			$query,
			array(
				'timeout' => 20,
				'sslverify' => false,
			)
		);

		if ( is_wp_error( $mwb_msrfw_response ) ) {
			echo json_encode(
				array(
					'status' => false,
					'msg' => __(
						'An unexpected error occurred. Please try again.',
						'mwb-shipping-rates-for-woocommerce'
					),
				)
			);
		} else {
			$mwb_msrfw_license_data = json_decode( wp_remote_retrieve_body( $mwb_msrfw_response ) );

			if ( isset( $mwb_msrfw_license_data->result ) && $mwb_msrfw_license_data->result == 'success' ) {
				update_option( 'mwb_msrfw_license_key', $mwb_msrfw_purchase_code );
				update_option( 'mwb_msrfw_license_check', true );

				echo json_encode(
					array(
						'status' => true,
						'msg' => __(
							'Successfully Verified. Please Wait.',
							'mwb-shipping-rates-for-woocommerce'
						),
					)
				);
			} else {
				echo json_encode(
					array(
						'status' => false,
						'msg' => $mwb_msrfw_license_data->message,
					)
				);
			}
		}
		wp_die();
	}

	/**
	 * Creating shipping method for WooCommerce.
	 *
	 * @param array $methods an array of shipping methods.
	 *
	 * @since 1.0.0
	 */
	public function mwb_shipping_rate_for_woocommerce_create_shipping_method( $methods ) {

		if ( ! class_exists( 'Mwb_Shipping_rate_method' ) ) {
			/**
			 * Custom shipping class for Shipping.
			 */
		
			require_once plugin_dir_path( __FILE__ ) . '/classes/class-mwb-shipping-rate-method.php'; // Including class file.
			new Mwb_Shipping_rate_method();
			
			
		}
	}
	/**
	 * Adding membership shipping method.
	 *
	 * @param array $methods an array of shipping methods.
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function mwb_shipping_rate_for_woocommerce_add_shipping_method( $methods ) {
		$methods['mwb_shipping_rate'] = 'Mwb_Shipping_rate_method';

		return $methods;
		
	}
	
	/**
	 * Adding coupon shipping method.
	 *
	 * @since 1.0.0
	 */
	public function srfw_coupon_add_fun() { 
	$applied_coupons = WC()->cart->get_applied_coupons();

		foreach ( $applied_coupons as $coupon_code ) {

	$coupon = new WC_Coupon($coupon_code);

			if ($coupon->get_free_shipping()) {
	 update_option('shipping_coupon', 'yes');
			}
		}
	}

	 /**
	 * Removing coupon shipping method.
	 *
	 * @since 1.0.0
	 */
	public function srfw_coupon_remove_fun() {
		update_option('shipping_coupon', 'no');
	}

	/**
	 * Expected delivery  shipping method.
	 *
	 * @since 1.0.0
	 */
	public function  expected_delivery_date_message() {
	global $Date;
	$days_checker = get_option('expected_days');
		if (!empty($days_checker)) {
	$expec_date = date('l jS \of F ', strtotime($Date . ' + ' . $days_checker . 'days'));
	_e( '<div id=" mwb_delivery_message">Expected to be delivered by ' . $expec_date . '</div>', 'mwb-shipping-rates-for-woocommerce');
		}
	}

	/**
	 * Weighting display delivery  shipping method.
	 *
	 * @since 1.0.0
	 */
	public function displaying_cart_items_weight( $item_data, $cart_item ) {
	$item_weight = $cart_item['data']->get_weight();
	$item_data[] = array(
		'key'       => __('Weight', 'woocommerce'),
		'value'     => $item_weight,
		'display'   => $item_weight . ' ' . get_option('woocommerce_weight_unit'),
	);

	return $item_data;
	}

	/**
	 * Selecting categories of the product  shipping method.
	 *
	 * @since 1.0.0
	 */
	public function shipping_rates_categories() {
	$shipping_prod_cat = get_option('product_categories');
	$shipping_ar       = explode(',', $shipping_prod_cat[0]);
    $cat_count = 0; 
	$cat_in_cart = false;
	   
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
 
			foreach ($shipping_ar as $x=>$val){
		if ( has_term( $val, 'product_cat', $cart_item['product_id'] ) ) {
		$cat_in_cart = true;
		$cat_count += $cart_item['quantity'];
				}
			}

		}
		if ( $cat_in_cart ) {
	update_option('shipping_cart','yes');
	update_option('cat_count',$cat_count);
		} else {
	update_option('shipping_cart','no');
		}
		if ( 'No Categories Selected' === $shipping_prod_cat[0] ) {	
		update_option('shipping_cart', 'no');
		}
	}
}
