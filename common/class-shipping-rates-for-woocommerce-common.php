<?php
/**
 * The common functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/common
 */

/**
 * The common functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the common stylesheet and JavaScript.
 * namespace shipping_rates_for_woocommerce_common.
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/common
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Shipping_rates_for_woocommerce_Common {
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
	 * Register the stylesheets for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function srfw_common_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . 'common', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'common/src/scss/shipping-rates-for-woocommerce-common.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function srfw_common_enqueue_scripts() {
		wp_register_script( $this->plugin_name . 'common', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'common/src/js/shipping-rates-for-woocommerce-common.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name . 'common', 'srfw_common_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name . 'common' );
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
	
	public function srfw_coupon_add_fun() { 
	$applied_coupons = WC()->cart->get_applied_coupons();

	foreach( $applied_coupons as $coupon_code ){

	$coupon = new WC_Coupon($coupon_code);

	if($coupon->get_free_shipping()){
	//   var_dump($coupon);
	 update_option('shipping_coupon','yes');
	//  var_dump(WC()->cart->get_applied_coupons());
	//  die();
	}
}
}
public function srfw_coupon_remove_fun() {
		update_option('shipping_coupon','no');
}

public function  expected_delivery_date_message()
{
	global $woocommerce , $product;
	$days_checker=get_option('expected_days');
	if(!empty($days_checker)){
	$expec_date = date('l jS \of F ', strtotime($Date. ' + '. $days_checker .'days'));
	echo '<h4><i>'.'Expected to be delivered by '. $expec_date.'<i></h4>';
	}

// 	$shipping_prod_cat=get_option('product_categories');
// 	$shipping_ar = explode(',', $shipping_prod_cat[0]);
// 	// var_dump($shipping_ar);

	
// 	$cat_in_cart = false;
	   
// 	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
 
// 	foreach($shipping_ar as $x=>$val){
// 	if ( has_term( $val, 'product_cat', $cart_item['product_id'] ) ) {
// 		$cat_in_cart = true;
// 	}
// 	}
// }
	
// 	if ( $cat_in_cart ) {
// 	update_option('shipping_cart','yes');
// 	} else {
// 	update_option('shipping_cart','no');
// 	}
}

public function displaying_cart_items_weight( $item_data, $cart_item ) {
	$item_weight = $cart_item['data']->get_weight();
	$item_data[] = array(
		'key'       => __('Weight', 'woocommerce'),
		'value'     => $item_weight,
		'display'   => $item_weight . ' ' . get_option('woocommerce_weight_unit')
	);

	return $item_data;
}

public function shipping_rates_categories() {
	$shipping_prod_cat=get_option('product_categories');
	$shipping_ar = explode(',', $shipping_prod_cat[0]);
	// var_dump($shipping_ar);

	
	$cat_in_cart = false;
	   
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
 
	foreach($shipping_ar as $x=>$val){
	if ( has_term( $val, 'product_cat', $cart_item['product_id'] ) ) {
		$cat_in_cart = true;
	}
	}
}
if ( $cat_in_cart ) {
	update_option('shipping_cart','yes');
	} else {
	update_option('shipping_cart','no');
	}
}


}
