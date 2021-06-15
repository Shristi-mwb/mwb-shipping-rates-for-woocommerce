<?php

/**
 * Register new Shipping Method for WooCommerce.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/includes
 */

/**
 * This class defines all code necessary to add a new shiiping method.
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Shipping_rate_method extends WC_Shipping_Method {
	/**
	 * Constructor for your shipping class
	 *
	 * @param mixed $instance_id used to store instance.
	 * @return void
	 */
	public function __construct( $instance_id = 0 ) {

		$this->id                 = 'mwb_shipping_rate'; // Id for your shipping method. Should be uunique.
		$this->method_title       = __( 'MWB Shipping Rates', 'shipping-rates-for-woocommerce' );  // Title shown in admin.
		$this->method_description = __( 'MWB Shipping Method With Different Conditioning Rules For Shipping.', 'shipping-rates-for-woocommerce' ); // Description shown in admin.
		$this->instance_id        = absint( $instance_id );
		$this->title              = __( 'MWB Shipping Rates', 'shipping-rates-for-woocommerce' );
		$this->zones_settings     = $this->id . 'zones_settings';
		$this->rates_settings     = $this->id . 'rates_settings';
		$this->enabled            = 'yes'; // For alwayes enable
		$this->supports           = array(
			'shipping-zones',
			'instance-settings',
		);
		$this->option_key = $this->id . '_mwb_shipping_rates';//The key for wordpress options
		$this->jem_shipping_methods_option = 'mwb_rate_shipping_methods_' . $this->instance_id;
		$this->init();
		$this->cost  = $this->get_option( 'cost' );
	}

	public  function init() {
				// Load the settings API
				$this->init_form_fields();
				$this->init_settings();
				add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
		}
	public function init_form_fields() { 
		$args = array(
			'hide_empty'      => false,
		    'taxonomy'     => 'product_cat',
		);
		$cats = get_categories($args);
		//Convert the object into a simple array containing a list of categories.
		$categories[] =  '';
		foreach($cats as $category) {
			$categories[] = __( $category->cat_name, 'shipping-rates-for-woocommerce' );
			
		}
		array_splice( $categories, 0 , 0, 'No Categories Selected' ); 
		unset($categories[1]);
		
	$this->instance_form_fields =
	 array(
		 'default_check' => array(
			'title' => __('Default', 'shipping-rates-for-woocommerce'),
			'type' => 'checkbox',
			'class'=>'default_check_class',
			'label' => __('Checkbox to set this shipping method as default selected option ', 'shipping-rates-for-woocommerce'),
			'default`' => 'yes'
		 ),
		 'visibility' => array(
			'title' => __('visibility', 'shipping-rates-for-woocommerce'),
			'type' => 'checkbox',
			'class'=>'visibility_class',
			'label' => __('visibile only to logged in user ', 'shipping-rates-for-woocommerce'),
			'default`' => 'no'
		 ),
	 'title' => array(
			'title' => __( 'Shipping Title', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Title to be display on site', 'shipping-rates-for-woocommerce' ),
				'default' => __( 'MWB Shipping ', 'shipping-rates-for-woocommerce' )
				),
	 'cost' => array(
			'title' => __( 'Shipping Cost', 'shipping-rates-for-woocommerce' ),
				'type' => 'number',
				'description' => __( 'general shipping cost', 'shipping-rates-for-woocommerce' ),
				),

		 'tax_status' => array(
				 'title' => __('Tax Status', 'shipping-rates-for-woocommerce'),
				 'type' => 'select',
				 'default' => 'taxable',
				 'options' => array(
						 'taxable' => __('Taxable', 'shipping-rates-for-woocommerce'),
						 'notax' => __('Not Taxable', 'shipping-rates-for-woocommerce'),
				 )
				 ));
				 $this->instance_form_fields['expected_delivery_date'] = array(
					'title' => __( 'Expected Delivery Date', 'shipping-rates-for-woocommerce' ),
						'type' => 'text',
						'placeholder'=>'days',
						'description' => __( 'Expected delivery date for shipping ', 'shipping-rates-for-woocommerce' ),
		 );
				 $this->instance_form_fields['free_shipping'] = array(
		 'title' => __('Free Shipping', 'shipping-rates-for-woocommerce'),
		 'type' => 'checkbox',
		 'label' => __('Enable to apply conditional free shipping', 'shipping-rates-for-woocommerce'),
		 'default`' => 'no',
		 'description' => __( 'Free shipping will override the configuration mention below.', 'shipping-rates-for-woocommerce' ),
				 );
				 
				 if('yes' == get_option('free_shipping_field')){
				 $this->instance_form_fields['pre_discount_price'] = array(
			'title' => __('Pre Discount Price', 'shipping-rates-for-woocommerce'),
			'type' => 'checkbox',
			'label' => __('Checkbox to apply free shipping on pre-discounted price.', 'shipping-rates-for-woocommerce'),
			'default`' => 'no'
				 );
				 $this->instance_form_fields['free_shipping_cond'] = array(
			 'title' => __('Free Shipping base on', 'shipping-rates-for-woocommerce'),
			 'type' => 'select',
			 'class' =>'custom_free_shipping_class',
			 'default' => 'minimum_order',
			 'options' => array(
				   ''           => __( '--Select One--','shipping-rates-for-woocommerce' ),
					 'minimum_order' => __('Minimum Order', 'shipping-rates-for-woocommerce'),
					 'shipping_coupon' => __('Shipping Coupon', 'shipping-rates-for-woocommerce'),
			 )
			 );
			 $this->instance_form_fields['shipping_label'] = array(
				'title' => __( 'Free Shipping title', 'shipping-rates-for-woocommerce' ),
					'type' => 'text',
					'description' => __( 'Free Shipping label on site', 'shipping-rates-for-woocommerce' ),
					'default' => __( 'Mwb Free Shippping Applied', 'shipping-rates-for-woocommerce' )
			 );
			 $this->instance_form_fields['free_shipping_amount'] = array(
				 'title' => __( 'Free Shipping Amount', 'shipping-rates-for-woocommerce' ),
					 'type' => 'number',
					 'description' => __( 'Minmun amount for Free Shipping ', 'shipping-rates-for-woocommerce' ),
			 );
			}
			 $this->instance_form_fields['t1'] = array(
			'title' => __( '<h3>Apply Advanced Shipping rules</h3>', 'shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Apply Advanced Shipping rules',
			'class' =>'',
		 );
		 if('yes' === get_option('advance_shipping_field')){
		 $this->instance_form_fields[ 'general_shipping']= array(
			'title' => __( 'Include General Shipping Charges', 'shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to include general shipping charges applied above into advance charges.',
		 );
		
		$this->instance_form_fields['categories_wise'] = array(
			'title' => __( 'Categories Wise', 'shipping-rates-for-woocommerce' ),
				'type' => 'multiselect',
				'description' => __( 'Categories to apply shipping charge ', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' ),
				'options' => $categories,
		 );
		 $this->instance_form_fields['price_categories_wise'] = array(
			'title' => __( 'Shipping charge by categories wise', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Shipping charge for selected categories', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 );

		$this->instance_form_fields['range'] = array(
			'title' => __( '<h4>Apply  Weight Range Rule</h4>', 'shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to enable weight range rule',
			'class' =>'',
			'description'  => __( 'Check to apply weight range rule.', 'shipping-rates-for-woocommerce' ),
		);

		$this->instance_form_fields['range_price'] = array(
			'title' => __( '<h4>Apply Price Range Rule</h4>', 'shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to enable price range rule',
			'class' =>'',
			'description'  => __( 'Check to apply Price rules.', 'shipping-rates-for-woocommerce' ),
		);
		$this->instance_form_fields['range_volume'] =array(
			'title' => __( '<h4>Appy Volume Range Rule</h4>', 'shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to enable volume range rule',
			'class' =>'',
			'description'  => __( 'Check to apply Volume rules.', 'shipping-rates-for-woocommerce' ),
		);
		$this->instance_form_fields['max_weight_wise'] =  array(
			'title' => __( 'Maximun Weight (Kg)', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Maximum weight of the cart on which shipping charge applied ', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		);
		$this->instance_form_fields['min_weight_wise'] = array(
			'title' => __( 'Minimum Weight (Kg)', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Minimum weight of the cart on which shipping charge applied ', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		);
		$this->instance_form_fields ['price_weight_wise'] = array(
			'title' => __( 'Charge Weight Wise', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'shipping charge on selected weight of the cart', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		);
		$this->instance_form_fields['max_price'] = array(
			'title' => __( 'Maximum Price', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Minimum price of the cart on which shipping charge applied ', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		);
		 $this->instance_form_fields['min_price'] =  array(
			'title' => __( 'Minimum Price', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Minimum price of the cart on which shipping charge applied ', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 );
		 $this->instance_form_fields['price_wise'] =  array(
			'title' => __( 'Charge Price Wise', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Charge the shipping cost on selected price of cart', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 );
		 $this->instance_form_fields['max_volume_wise'] = array(
			'title' => __( 'Maximun Volume (cm<sup>3</sup>)', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Maximum vol. of the cart on which shipping charge applied ', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 );
		 $this->instance_form_fields['min_volume_wise'] = array(
			'title' => __( 'Minimum Volume (cm<sup>3</sup>)', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Minimum vol. of the cart on which shipping charge applied ', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 );
		 $this->instance_form_fields['volume_range_wise'] = array(
			'title' => __( 'Charge Volume Wise', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'charge the shipping cost  on selected volume of the cart', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 );
		 }
}

	public function calculate_shipping( $package = array()) {
		global $woocommerce;
				// As we are using instances for the cost and the title we need to take those values drom the instance_settings.
			 		$total_cart_weight    =  WC()->cart->get_cart_contents_weight();
					$total_cart_price	  = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
					$general_charges_enable   = $this->get_option('general_shipping');
					$intance_settings     =  $this->instance_settings;
					$enable_all_rules = $this->get_option( 't1' );
					$max_weight = $this->get_option( 'max_weight_wise' );
					$min_weight = $this->get_option( 'min_weight_wise' );
					$max_price = $this->get_option( 'max_price' );
					$min_price = $this->get_option( 'min_price' );
					$price_wise_charge = $this->get_option( 'price_wise' );

					$max_vol = $this->get_option( 'max_volume_wise' );
					$min_vol = $this->get_option( 'min_volume_wise' );
					$vol_wise_charge = $this->get_option('volume_range_wise');
					$weight_shipping_charge = $this->get_option( 'price_weight_wise' );
					$enable_free_shipping = $this->get_option( 'free_shipping' );
					$min_amount           = $this->get_option( 'free_shipping_amount' );

					$categories_wise_price   = $this->get_option( 'price_categories_wise' );
					$free_shippping_lable   = $this->get_option( 'shipping_label' );
					$pre_discount_price     = $this->get_option( 'pre_discount_price' );
					$min_order_cond         = $this->get_option( 'free_shipping_cond' );
					$cart_total_after_disc  = $package['contents_cost'];
					$cart_total_before_disc = $package['cart_subtotal'];
					$shipping_cond_check    = get_option( 'shipping_coupon');
					$cart_categories        = get_option('shipping_cart');
  					$range = $this->get_option( 'range' );
					$price_range = $this->get_option('range_price');
					$vol_range = $this->get_option('range_volume');
					
	$items = $woocommerce->cart->get_cart();
    $cart_prods_m3 = array();
        foreach($items as $item => $values) { 
            $_product =  wc_get_product( $values['data']->get_id());
			$qty     = $values['quantity'];
            $prod_m3 = $_product->get_length() * 
                       $_product->get_width() * 
                       $_product->get_height()*
					   $qty;
        
            array_push($cart_prods_m3, $prod_m3);
			$total_cart_vol  = array_sum($cart_prods_m3);
			
        } 
            
		
if('yes' === $enable_all_rules)
{
	if($total_cart_weight <= $max_weight && 'yes' === $range && $total_cart_weight >= $min_weight && !empty($min_weight) && !empty($max_weight)){

				$w3=$weight_shipping_charge;
		} else{
			$w3=0;
		}
	if($total_cart_weight > $max_weight  && !empty($max_weight) && 'yes' !== $range){
		$w1 = $weight_shipping_charge;
}
else{
	$w1=0;
}
if($total_cart_weight < $min_weight  && !empty($min_weight) && 'yes' !== $range){
		$w2 = $weight_shipping_charge;
}  
else{
	$w2=0;
}

///////////////////////////// Price Range //////////////////////////////////
if($total_cart_price <= $max_price && 'yes' === $price_range && $total_cart_price >= $min_price && !empty($max_price) && !empty($min_price)){

	$p3 = $price_wise_charge;
	
	}

	else{
		$p3=0;
	}

if($total_cart_price > $max_price  && !empty($max_price) && 'yes' !== $price_range){

       $p1 = $price_wise_charge;
}
else{
	$p1=0;	
}

if($total_cart_price < $min_price && !empty($min_price) && 'yes' !== $price_range){

 $p2 = $price_wise_charge;
}
else{
	$p2=0;
}
/////////////////////////////////////////VOLUME/////////////

if($total_cart_vol <= $max_vol && 'yes' === $vol_range && $total_cart_vol >= $min_vol && !empty($max_vol) && !empty($min_vol)){
	$volume_3 = $vol_wise_charge;
	} else{
		$volume_3=0;
	}

if($total_cart_vol > $max_vol  && !empty($max_vol) && 'yes' !== $vol_range){

       $volume_1 = $vol_wise_charge;

}else{
	$volume_1=0;
}

if($total_cart_vol < $min_vol && !empty($min_vol) && 'yes' !== $vol_range){

 $volume_2 = $vol_wise_charge;
}
else{
	$volume_2=0;
}


if('yes' === $cart_categories && !empty($categories_wise_price)){
	$price_for_categories = $categories_wise_price;
}else{
	$price_for_categories=0;
}

///////////////////////////////////////////////////////VOLUME END
$cost = $w1 + $w2 +$w3 + $p1 + $p2 + $p3 + $volume_1 +$volume_2 + $volume_3 + $price_for_categories;
if('yes' === $general_charges_enable)
		{
			$cost = $cost + $this->get_option( 'cost' );
		}
	$this->add_rate( array(
		'id'      => $this->id,
		'label'   =>$this->get_option( 'title' ),
		'cost'    => $cost,
		'package' => $package,
		'taxes'   => false,
	)
);
}

if('yes' === $enable_free_shipping){
	if ( 'yes' === $pre_discount_price ) {
		$cart_total = $cart_total_before_disc;
	} else {
		$cart_total = $cart_total_after_disc;
	}
	if ( $min_amount <= $cart_total && 'minimum_order' === $min_order_cond  && 'yes' === $enable_free_shipping ) {
			$this->add_rate( array(
				'id'      => $this->id,
				'label'   => $free_shippping_lable,
				'cost'    =>  0,
				'package' => $package,
				'taxes'   => false,
			)
		);
	} if ('shipping_coupon' === $min_order_cond  && 'yes' === $enable_free_shipping && 'yes' === $shipping_cond_check ) {
		  $this->add_rate( array(
			'id'      => $this->id,
			'label'   =>$free_shippping_lable,
			'cost'    => 0,
			'package' => $package,
			'taxes'   => false,
		)
	);
	}		
}

// elseif('yes' === $general_charges_enable) {
// 					$this->add_rate( array(
// 								'id'      => $this->id,
// 								'label'   =>$this->get_option( 'title' ),
// 								'cost'    => $this->get_option( 'cost' ),
// 								'package' => $package,
// 								'taxes'   => false,
// 							)
// 						);
// 		}
	}

}