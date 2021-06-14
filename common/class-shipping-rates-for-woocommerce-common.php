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
	
	public function srfw_coupon_add_fun()
	{ 
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
public function srfw_coupon_remove_fun()
	{

		update_option('shipping_coupon','no');
		// $applied_coupons = WC()->cart->get_applied_coupons();

		// foreach( $applied_coupons as $coupon_code ){
	
		// $coupon = new WC_Coupon($coupon_code);
		// $coupon->get_free_shipping();
		// if( $coupon->get_free_shipping()){
		// 	update_option('shipping_coupon','no');
		// 	}
			// else{
			// 	update_option('shipping_coupon','no');
			// }
	// }

	
}

public function  expected_delivery_date_message()
{
    global $woocommerce , $product;
	$i=get_option('expected_days');
	if(!empty($i)){
	// $Date =date('Y-m-d');
$expec_date = date('l jS \of F ', strtotime($Date. ' + '. $i .'days'));
echo '<h4><i>'.'Expected to be delivered by '. $expec_date.'<i></h4>';
	}
	// echo  number_format(WC()->cart->get_cart_subtotal(),1,'.','');
	$amount = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
	echo $amount;
	
	

	$items = $woocommerce->cart->get_cart();
    $cart_prods_m3 = array();

        //LOOP ALL THE PRODUCTS IN THE CART
        foreach($items as $item => $values) { 
            $_product =  wc_get_product( $values['data']->get_id());
            //GET GET PRODUCT M3 
            $prod_m3 = $_product->get_length() * 
                       $_product->get_width() * 
                       $_product->get_height();
            //MULTIPLY BY THE CART ITEM QUANTITY
            //DIVIDE BY 1000000 (ONE MILLION) IF ENTERING THE SIZE IN CENTIMETERS
            // $prod_m3 = ($prod_m3 * $values['quantity']) / 1000000;
            //PUSH RESULT TO ARRAY
            array_push($cart_prods_m3, $prod_m3);
        } 

    echo "Total of M3 in the cart: " . array_sum($cart_prods_m3).'<br>';
	// var_dump(get_option('product_categories'));
	$i=get_option('product_categories');
	$fruits_ar = explode(',', $i[0]);
	var_dump($fruits_ar);
	foreach( WC()->cart->get_cart() as $cart_item ){
		// compatibility with WC +3
		if( version_compare( WC_VERSION, '3.0', '<' ) ){
			echo $product_id = $cart_item['data']->id; // Before version 3.0
		} else {
			 $product_id = $cart_item['data']->get_id().'<br>'; // For version 3 or more
		
		}
	}
	$terms = get_the_terms( 12, 'product_cat' );
foreach ($terms as $term) {
   $product_cat = $term->name;
}
echo $product_cat ;



	// echo $terms = get_the_terms( $product->get_id(), 'product_cat' );
	// // Retrieve object containing all of the categories.
    // $cats = get_categories();

    // // Convert the object into a simple array containing a list of categories.
    // $categories[] =  '';
    // foreach($cats as $category) {
    //     $categories[] = __( $category->cat_name, 'hs_textdomain' );
    // }

    // // Return the array.
    // print_r($categories);
	// $woocommerce->cart->cart_contents_weight ;
	// $item_weight = $cart_item['data']->get_weight();
	// die();
	// echo get_the_date();
	// echo date('l jS \of F Y');
	// var_dump(WC()->cart->get_cart());
    // $session_cart = WC()->session->applied_coupons;
// 	$applied_coupons = WC()->cart->get_applied_coupons();

// 		foreach( $applied_coupons as $coupon_code ){
	
// 		$coupon = new WC_Coupon($coupon_code);
// 	echo '<pre>';
// 	print_r($coupon->get_free_shipping());
// die();
// 		}
// die();
}

function displaying_cart_items_weight( $item_data, $cart_item ) {
    $item_weight = $cart_item['data']->get_weight();
    $item_data[] = array(
        'key'       => __('Weight', 'woocommerce'),
        'value'     => $item_weight,
        'display'   => $item_weight . ' ' . get_option('woocommerce_weight_unit')
    );

    return $item_data;
}

}
