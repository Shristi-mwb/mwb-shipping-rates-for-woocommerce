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
		$this->method_title       = __( 'MWB Shipping Rates', 'mwb-shipping-rates-for-woocommerce' );  // Title shown in admin.
		$this->method_description = __( 'MWB Shipping Method With Different Conditioning Rules For Shipping.', 'mwb-shipping-rates-for-woocommerce' ); // Description shown in admin.
		$this->instance_id        = absint( $instance_id );
	    $this->cost               = 0;
		$this->supports           = array(
			'shipping-zones',
			'instance-settings',
		);
		$this->init();
		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	 * init for your setting fields
	 *
	 */
	public  function init() {
				// Load the settings API
				$this->init_form_fields();
				$this->init_settings();
				$this->title       = $this->get_option( 'title' );
				$this->tax_status  = $this->get_option( 'tax_status' );
		        $this->cost        = $this->get_option( 'cost' );
				$this->enable_all_rules = $this->get_option( 't1' );
		}

	/**
	 * init setting for your setting fields
	 *
	 */	
	public function init_form_fields() { 
		$args = array(
			'hide_empty'      => false,
			'taxonomy'     => 'product_cat',
		);
		$cats = get_categories($args);
		//Convert the object into a simple array containing a list of categories.
		$categories[] =  '';
		foreach ($cats as $category) {
			$categories[] = __( $category->cat_name, 'mwb-shipping-rates-for-woocommerce' );
			
		}
		array_splice( $categories, 0 , 0, 'No Categories Selected' ); 
		unset($categories[1]);
		
	$this->instance_form_fields =
	 array(
		 'default_check' => array(
			'title' => __('Default', 'mwb-shipping-rates-for-woocommerce'),
			'type' => 'checkbox',
			'class'=>'default_check_class',
			'label' => __('Checkbox to set this shipping method as default selected option ', 'mwb-shipping-rates-for-woocommerce'),
			'default`' => 'yes'
		 ),
		 'visibility' => array(
			'title' => __('visibility', 'mwb-shipping-rates-for-woocommerce'),
			'type' => 'checkbox',
			'class'=>'visibility_class',
			'label' => __('visibile only to logged in user ', 'mwb-shipping-rates-for-woocommerce'),
			'default`' => 'no'
		 ),
		 'only_general_shipping_charge' => array(
			'title' => __('Enable only General Charge', 'mwb-shipping-rates-for-woocommerce'),
			'type' => 'checkbox',
			'class'=>'only_general_shipping_charge_class',
			'label' => __('', 'mwb-shipping-rates-for-woocommerce'),
			'default`' => 'yes'
		 ),
	 'title' => array(
			'title' => __( 'Shipping Title', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Title to be display on site', 'mwb-shipping-rates-for-woocommerce' ),
				'default' => __( 'MWB Shipping ', 'mwb-shipping-rates-for-woocommerce' ),
				'desc_tip' =>true,
				),
	 'cost' => array(
			'title' => __( 'Shipping Cost', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'general shipping cost', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
				),
		 'tax_status' => array(
				 'title' => __('Tax Status', 'mwb-shipping-rates-for-woocommerce'),
				 'type' => 'select',
				 'default' => 'taxable',
				 'description' => __( 'Taxation on shipping', 'mwb-shipping-rates-for-woocommerce' ),
				 'desc_tip' =>true,
				 'options' => array(
						 'taxable' => __('Taxable', 'mwb-shipping-rates-for-woocommerce'),
						 'notax' => __('Not Taxable', 'mwb-shipping-rates-for-woocommerce'),
				 )
				 ));
				 $this->instance_form_fields['expected_delivery_date'] = array(
					'title' => __( 'Expected Delivery Date', 'mwb-shipping-rates-for-woocommerce' ),
						'type' => 'text',
						'placeholder'=>'days',
						'description' => __( 'Expected delivery date for shipping ', 'mwb-shipping-rates-for-woocommerce' ),
						'class' =>'mwb_stop_text',
						'desc_tip' =>true,
		 );
				 $this->instance_form_fields['free_shipping'] = array(
		 'title' => __('Free Shipping', 'mwb-shipping-rates-for-woocommerce'),
		 'type' => 'checkbox',
		 'class' => 'mwb_free_shipping_check_'.$this->instance_id ,
		 'label' => __('Enable to apply conditional free shipping', 'mwb-shipping-rates-for-woocommerce'),
		 'default`' => 'no',
		 'description' => __( 'Free shipping will override the configuration mention below.', 'mwb-shipping-rates-for-woocommerce' ),
		 'desc_tip' =>true,
				 );
				 
				 if('yes' == $this->get_option('free_shipping')) {
				 $this->instance_form_fields['pre_discount_price'] = array(
			'title' => __('Pre Discount Price', 'mwb-shipping-rates-for-woocommerce'),
			'type' => 'checkbox',
			'label' => __('Checkbox to apply free shipping on pre-discounted price.', 'mwb-shipping-rates-for-woocommerce'),
			'description' => __( 'Apply conditinal free shipping on the pre-discounted price', 'mwb-shipping-rates-for-woocommerce' ),
			'desc_tip' =>true,
			'default`' => 'no',
				 );
				 $this->instance_form_fields['free_shipping_cond'] = array(
			 'title' => __('Free Shipping base on', 'mwb-shipping-rates-for-woocommerce'),
			 'type' => 'select',
			 'class' =>'custom_free_shipping_class',
			 'description' => __( 'Condition on which free shipping is allow', 'mwb-shipping-rates-for-woocommerce' ),
			 'default' => 'minimum_order',
			 'desc_tip' =>true,
			 'options' => array(
				   ''         => __( '--Select One--', 'mwb-shipping-rates-for-woocommerce' ),
					 'minimum_order' => __('Minimum Order', 'mwb-shipping-rates-for-woocommerce'),
					 'shipping_coupon' => __('Shipping Coupon', 'mwb-shipping-rates-for-woocommerce'),
			 )
			 );
			 $this->instance_form_fields['shipping_label'] = array(
				'title' => __( 'Free Shipping title', 'mwb-shipping-rates-for-woocommerce' ),
					'type' => 'text',
					'description' => __( 'Free Shipping label on site', 'mwb-shipping-rates-for-woocommerce' ),
					'default' => __( 'Mwb Free Shippping Applied', 'mwb-shipping-rates-for-woocommerce' ),
					'desc_tip' =>true,
			 );
			 $this->instance_form_fields['free_shipping_amount'] = array(
				 'title' => __( 'Free Shipping Amount', 'mwb-shipping-rates-for-woocommerce' ),
					 'type' => 'text',
					 'description' => __( 'Minimun amount for Free Shipping ', 'mwb-shipping-rates-for-woocommerce' ),
					 'class' =>'mwb_stop_text',
					 'desc_tip' =>true,
			 );
			}
			 $this->instance_form_fields['t1'] = array(
			'title' => __( '<h4>Apply Advanced Shipping rules</h4>', 'mwb-shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Apply Advanced Shipping rules',
			'description' => __( 'Advnace shipping rules for the shipping charge', 'mwb-shipping-rates-for-woocommerce' ),
			'desc_tip' =>true,

		 );		if ('yes' === $this->get_option('t1') ) {
		 $this->instance_form_fields[ 'general_shipping']= array(
			'title' => __( 'Include General Shipping Charges', 'mwb-shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to include general shipping charges applied above into advance charges.',
			
		 );
		$this->instance_form_fields['categories_wise'] = array(
			'title' => __( 'Categories Wise', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'multiselect',
				'description' => __( 'Categories to apply shipping charge ', 'mwb-shipping-rates-for-woocommerce' ),
				'options' => $categories,
				'desc_tip' =>true,
		 );
		 $this->instance_form_fields['price_categories_wise'] = array(
			'title' => __( 'Shipping charge by categories wise', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Shipping amount charge for selected categories per quantity wise.', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
		 );
		$this->instance_form_fields['range'] = array(
			'title' => __( 'Apply  Weight Range Rule', 'mwb-shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to enable weight range rule',
			'class' =>'',
			'description'  => __( 'Check to apply weight range rule.', 'mwb-shipping-rates-for-woocommerce' ),
		);
		$this->instance_form_fields['range_price'] = array(
			'title' => __( 'Apply Price Range Rule', 'mwb-shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to enable price range rule',
			'class' =>'',
			'description'  => __( 'Check to apply Price range rules.', 'mwb-shipping-rates-for-woocommerce' ),
		);
		$this->instance_form_fields['range_volume'] =array(
			'title' => __( 'Appy Volume Range Rule', 'mwb-shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to enable volume range rule',
			'class' =>'',
			'description'  => __( 'Check to apply Volume rules.', 'mwb-shipping-rates-for-woocommerce' ),
		);
		$this->instance_form_fields['max_weight_wise'] =  array(
			'title' => __( 'Maximun Weight (Kg)', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Maximum weight of the cart on which shipping charge applied. ', 'mwb-shipping-rates-for-woocommerce' ),
				'default' => __( '', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
		);
		$this->instance_form_fields['min_weight_wise'] = array(
			'title' => __( 'Minimum Weight (Kg)', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Minimum weight of the cart on which shipping charge applied. ', 'mwb-shipping-rates-for-woocommerce' ),
				'default' => __( '', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
		);
		$this->instance_form_fields ['price_weight_wise'] = array(
			'title' => __( 'Charge Weight Wise', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'shipping charge on selected weight of the cart. ', 'mwb-shipping-rates-for-woocommerce' ),
				'default' => __( '', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
		);
		$this->instance_form_fields['max_price'] = array(
			'title' => __( 'Maximum Price', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Minimum price of the cart on which shipping charge applied. ', 'mwb-shipping-rates-for-woocommerce' ),
				'default' => __( '', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
		);
		 $this->instance_form_fields['min_price'] =  array(
			'title' => __( 'Minimum Price', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Minimum price of the cart on which shipping charge applied. ', 'mwb-shipping-rates-for-woocommerce' ),
				'default' => __( '', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
		 );
		 $this->instance_form_fields['price_wise'] =  array(
			'title' => __( 'Charge Price Wise', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Charge the shipping cost on selected price of cart. ', 'mwb-shipping-rates-for-woocommerce' ),
				'default' => __( '', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
		 );
		 $this->instance_form_fields['max_volume_wise'] = array(
			'title' => __( 'Maximun Volume (cm<sup>3</sup>)', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Maximum vol. of the cart on which shipping charge applied. ', 'mwb-shipping-rates-for-woocommerce' ),
				'default' => __( '', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
		 );
		 $this->instance_form_fields['min_volume_wise'] = array(
			'title' => __( 'Minimum Volume (cm<sup>3</sup>)', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Minimum vol. of the cart on which shipping charge applied. ', 'mwb-shipping-rates-for-woocommerce' ),
				'default' => __( '', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
		 );
		 $this->instance_form_fields['volume_range_wise'] = array(
			'title' => __( 'Charge Volume Wise', 'mwb-shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'charge the shipping cost  on selected volume of the cart. ', 'mwb-shipping-rates-for-woocommerce' ),
				'default' => __( '', 'mwb-shipping-rates-for-woocommerce' ),
				'class' =>'mwb_stop_text',
				'desc_tip' =>true,
		 );	}
		 return $this->instance_form_fields;
	}

	/**
	 * Calculation for the shipping
	 *
	 * @param mixed $instance_id used to store instance.
	 * @return void
	 */
	public function calculate_shipping( $package = array()) {
		global $woocommerce;
				// As we are using instances for the cost and the title we need to take those values drom the instance_settings.
				
					$total_cart_weight      =  WC()->cart->get_cart_contents_weight();
					$total_cart_price	  = $woocommerce->cart->subtotal;
					$general_charges_enable   = $this->get_option('general_shipping');
					$cart_quantity = get_option('cat_count');
					$general_cost = $this->get_option( 'cost' );
					$intance_settings     =  $this->instance_settings;

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
					
	$items         = $woocommerce->cart->get_cart();
	$cart_prods_m3 = array();
		foreach ($items as $item => $values) { 
			$_product =  wc_get_product( $values['data']->get_id());
			$qty      = $values[ 'quantity' ];
			$length =$_product->get_length();
			$width = $_product->get_width();
			$height = $_product->get_height();
			if(empty($length))
			{
				$length  = 0;
			}
			if(empty($width))
			{
				$width  = 0;
			}
			if(empty($height))
			{
				$height  = 0;
			}
			$prod_m3  =$length* $width * $height * $qty;
		
			array_push($cart_prods_m3, $prod_m3);
			$total_cart_vol  = array_sum($cart_prods_m3);
		} 

		if('yes' === $this->get_option( 'only_general_shipping_charge' )){
			$this->add_rate( array(
						'id'      => $this->get_rate_id(),
						'label'   =>$this->get_option( 'title' ),
						'cost'    => $this->get_option( 'cost' ),
						'package' => $package,
						'taxes'   => false,
					)
				);
}
		if ('yes' === $this->enable_all_rules) {
			if ($total_cart_weight <= $max_weight && 'yes' === $range && $total_cart_weight >= $min_weight && !empty($min_weight) && !empty($max_weight)){

				if(!is_numeric($weight_shipping_charge)){
				$mwb_weight_charge_3 =0;
				} else{
					$mwb_weight_charge_3 =$weight_shipping_charge;
				}
			} else {
			$mwb_weight_charge_3 =0;
			}

			if ($total_cart_weight > $max_weight  && !empty($max_weight) && 'yes' !== $range) {

				if(!is_numeric($weight_shipping_charge)){
				$mwb_weight_charge_1 =0;
				} else{
					$mwb_weight_charge_1 =$weight_shipping_charge;
				}
			} else {
				$mwb_weight_charge_1 =0;
			}
			
			if ($total_cart_weight < $min_weight  && !empty($min_weight) && 'yes' !== $range) {
				if(!is_numeric($weight_shipping_charge)){
					$mwb_weight_charge_2 = 0;
					} else {
						$mwb_weight_charge_2 = $weight_shipping_charge;
					}
			} else {
				$mwb_weight_charge_2 = 0;
			}
///////////////////////////// Price Range ////////////////////////////////////
			if ($total_cart_price <= $max_price && 'yes' === $price_range && $total_cart_price >= $min_price && !empty($max_price) && !empty($min_price)){

	         if(!is_numeric($price_wise_charge)) {
             $mwb_price_charge_3 = 0;
			 }
			 else{
				$mwb_price_charge_3 = $price_wise_charge;
			 }
	
			} else {
				$mwb_price_charge_3 = 0 ;
			}

			if ($total_cart_price > $max_price  && !empty($max_price) && 'yes' !== $price_range) {

				if(!is_numeric($price_wise_charge)) {
					$mwb_price_charge_1 =0;
					}
					else{
					   $mwb_price_charge_1 = $price_wise_charge;
					}
			} else {
				$mwb_price_charge_1 =0;	
			}

			if ($total_cart_price < $min_price && !empty($min_price) && 'yes' !== $price_range) {

				if(!is_numeric($price_wise_charge)) {
					$mwb_price_charge_2 =0;
					}
					else{
					   $mwb_price_charge_2 = $price_wise_charge;
					}
			} else {
				$mwb_price_charge_2 = 0;
			}

/////////////////////////////////////////VOLUME/////////////
if($total_cart_vol <= $max_vol && 'yes' === $vol_range && $total_cart_vol >= $min_vol && !empty($max_vol) && !empty($min_vol)){
	if(!is_numeric($vol_wise_charge)){
     $mwb_volume_charge_3 = 0;
	} else{
		$mwb_volume_charge_3 = $vol_wise_charge;
	}
	} else{
		$mwb_volume_charge_3=0;
	}

if($total_cart_vol > $max_vol  && !empty($max_vol) && 'yes' !== $vol_range){

	if(!is_numeric($vol_wise_charge)){
		$mwb_volume_charge_1 = 0;
	   } else{
		   $mwb_volume_charge_1 = $vol_wise_charge;
	   }

}else{
	$mwb_volume_charge_1=0;
}

if($total_cart_vol < $min_vol && !empty($min_vol) && 'yes' !== $vol_range){

	if(!is_numeric($vol_wise_charge)){
		$mwb_volume_charge_2 = 0;
	   } else{
		   $mwb_volume_charge_2 = $vol_wise_charge;
	   }
}
else{
	$mwb_volume_charge_2 = 0;
}


if('yes' === $cart_categories && !empty($categories_wise_price)){
	$price_for_categories = $categories_wise_price * ($cart_quantity) ;
}else{
	$price_for_categories=0;
}

///////////////////////////////////////////////////////VOLUME END/////////////////
$cost = ($mwb_weight_charge_1 + $mwb_weight_charge_2 + $mwb_weight_charge_3 +  $mwb_price_charge_2 +  $mwb_price_charge_1 + $mwb_price_charge_3 + $mwb_volume_charge_1 +$mwb_volume_charge_2 + $mwb_volume_charge_3 + ($price_for_categories));
if('yes' === $general_charges_enable)

		{
			if(!is_numeric($general_cost)) {
				$general_cost = 0;
			}
			$cost = $cost + $general_cost;
		}
	$this->add_rate( array(
		'id'      => $this->get_rate_id(),
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
				'id'      => $this->get_rate_id(),
				'label'   => $free_shippping_lable,
				'cost'    =>  0,
				'package' => $package,
				'taxes'   => false,
		)
	);
	}		
	if ('shipping_coupon' === $min_order_cond  && 'yes' === $enable_free_shipping && 'yes' === $shipping_cond_check ) {
		$this->add_rate( array(
		  'id'      => $this->get_rate_id(),
		  'label'   =>$free_shippping_lable,
		  'cost'    => 0,
		  'package' => $package,
		  'taxes'   => false,
	  )
  );
  }
} 
	}

	/**
	 * Saving the field for your shipping 
	 *
	 */
	public function admin_options() {
		if ( ! $this->instance_id ) {
			echo '<h2>' . esc_html( $this->get_method_title() ) . '</h2>';
		}
		echo wp_kses_post( wpautop( $this->get_method_description() ) );
		echo $this->get_admin_options_html(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		update_option('visibility_check' , $this->get_option( 'visibility' ));
		update_option('default_shipping_check', $this->get_option( 'default_check' ));
		update_option('expected_days', $this->get_option( 'expected_delivery_date' ));
	
		}

	/**
	 * Generating the html for setting field
	 *
	 */
		public function get_admin_options_html() {
				$settings_html = $this->generate_settings_html( $this->init_form_fields(), false );
			    $mwb_shipping_table ='<table class="form-table">' . $settings_html . '</table>';
				return $mwb_shipping_table;
		}

}