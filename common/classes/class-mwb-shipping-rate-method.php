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
		$this->method_title       = __( 'MWB Shipping', 'shipping-rates-for-woocommerce' );  // Title shown in admin.
		$this->method_description = __( 'MWB Shipping method add diffrent shipping conditions.', 'shipping-rates-for-woocommerce' ); // Description shown in admin.
		$this->instance_id        = absint( $instance_id );
		$this->title              = __( 'MWB Shipping', 'shipping-rates-for-woocommerce' );
		$this->zones_settings     = $this->id . 'zones_settings';
		$this->rates_settings     = $this->id . 'rates_settings';
		$this->enabled            = 'yes'; // For alwayes enable
		$this->supports           = array(
			'shipping-zones',
			// 'settings', //use this for separate settings page
			'instance-settings',
			 //'instance-settings-modal',
		);
		$this->option_key = $this->id . '_mwb_shipping_rates';   //The key for wordpress options
		$this->jem_shipping_methods_option = 'mwb_rate_shipping_methods_' . $this->instance_id;
		$this->init();
		// $this->title = $this->get_option( 'title' );
		$this->cost  = $this->get_option( 'cost' );
	}

	public  function init() {
				// Load the settings API
				$this->init_form_fields();
				$this->init_settings();
				// $this->create_select_arrays();
				// $this->init_custom_settings();
				// Save settings in admin if you have any defined
				add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );

		}
	public function init_form_fields() { 
		$args = array(
			'hide_empty'      => false,
		    'taxonomy'     => 'product_cat',
		);
		$cats = get_categories($args);
		// Convert the object into a simple array containing a list of categories.
		$categories[] =  '';
		foreach($cats as $category) {
			$categories[] = __( $category->cat_name, 'shipping-rates-for-woocommerce' );
			
		}
		
	$this->instance_form_fields =
	 array(
		 'default_check' => array(
			'title' => __('Default', 'shipping-rates-for-woocommerce'),
			'type' => 'checkbox',
			'class'=>'default_check_class',
			'label' => __('Checkbox to set this shipping method as default selected option ', 'shipping-rates-for-woocommerce'),
			'default`' => 'no'
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
				'description' => __( 'Cost of shipping', 'shipping-rates-for-woocommerce' ),
				),

		 'tax_status' => array(
				 'title' => __('Tax Status', 'shipping-rates-for-woocommerce'),
				 'type' => 'select',
				 'default' => 'taxable',
				 'options' => array(
						 'taxable' => __('Taxable', 'shipping-rates-for-woocommerce'),
						 'notax' => __('Not Taxable', 'shipping-rates-for-woocommerce'),
				 )
		 ),
		 'free_shipping' => array(
		 'title' => __('<h3>Free Shipping</h3>', 'shipping-rates-for-woocommerce'),
		 'type' => 'checkbox',
		 'label' => __('Enable to apply conditional free shipping', 'shipping-rates-for-woocommerce'),
		 'default`' => 'no'
		 ),
		 'pre_discount_price' => array(
			'title' => __('Pre Discount Price', 'shipping-rates-for-woocommerce'),
			'type' => 'checkbox',
			'label' => __('Checkbox to apply free shipping on pre-discounted price.', 'shipping-rates-for-woocommerce'),
			'default`' => 'no'
			)
		 ,
		 'free_shipping_cond'=> array(
			 'title' => __('Free Shipping base on', 'shipping-rates-for-woocommerce'),
			 'type' => 'select',
			 'class' =>'custom_free_shipping_class',
			 'default' => 'minimum_order',
			 'options' => array(
				   ''           => __( '--Select One--','shipping-rates-for-woocommerce' ),
					 'minimum_order' => __('Minimum Order', 'shipping-rates-for-woocommerce'),
					 'shipping_coupon' => __('Shipping Coupon', 'shipping-rates-for-woocommerce'),
			 )
			 ),
			 'shipping_label' => array(
				'title' => __( 'Free Shipping label', 'shipping-rates-for-woocommerce' ),
					'type' => 'text',
					'description' => __( 'Free Shipping label on site', 'shipping-rates-for-woocommerce' ),
					'default' => __( 'Free Shippping ', 'shipping-rates-for-woocommerce' )
					)
			 ,
			 'free_shipping_amount' => array(
				 'title' => __( 'Free Shipping Amount', 'shipping-rates-for-woocommerce' ),
					 'type' => 'number',
					 'description' => __( 'Minmun amount for Free Shipping ', 'shipping-rates-for-woocommerce' ),
					 ),
			'expected_delivery_date' => array(
						'title' => __( 'Expected Delivery Date', 'shipping-rates-for-woocommerce' ),
							'type' => 'text',
							'placeholder'=>'days',
							'description' => __( 'Expected delivery date for shipping ', 'shipping-rates-for-woocommerce' ),
							),
			// 'delivery_method_wise'=> array(
			// 					'title' => __('Delivery Method Wise', 'shipping-rates-for-woocommerce'),
			// 					'type' => 'select',
			// 					'class' =>'delivery_method_wise_class',
			// 					'options' => array(
			// 						  ''           => __( '--Select One--','shipping-rates-for-woocommerce' ),
			// 							'one_day' => __('One Delivery', 'shipping-rates-for-woocommerce'),
			// 							'next_day' => __('Next Day Delivery', 'shipping-rates-for-woocommerce'),
			// 					)
			// )
	// 'condition' => array(
	//        'title' => __( 'Select Condition', 'shipping-rates-for-woocommerce' ),
	//        'type'  => 'select',
	//        'description'  => __( 'This is select field demo follow same structure for further use.', 'shipping-rates-for-woocommerce' ),
	//        'value' => '',
	//        'class' => 'srfw-select-class',
	//        'placeholder' => __( 'Select C', 'shipping-rates-for-woocommerce' ),
	//        'options' => array(
	//          '' => __( 'Select option', 'shipping-rates-for-woocommerce' ),
	//          'Category' => __( 'Category', 'shipping-rates-for-woocommerce' ),
	//          'Weight' => __( 'Weight', 'shipping-rates-for-woocommerce' ),
	//          'Cart Total' => __( 'Cart Total', 'shipping-rates-for-woocommerce' ),
	//          'Price Range' => __( 'Price Range', 'shipping-rates-for-woocommerce' ),
	//          'Delevary Method' => __( 'Delivery Method', 'shipping-rates-for-woocommerce' ),
	//          'Free Shipping' => __( 'Free Shipping', 'shipping-rates-for-woocommerce' ),
	//        ),
	//      ),
	// ,
		 't1' =>array(
			'title' => __( '<h3>Apply Advanced Shipping rules</h3>', 'shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Apply Advanced Shipping rules',
			'class' =>'',
			// 'description'  => __( 'Check to apply advanced shipping rules.', 'shipping-rates-for-woocommerce' ),
		 ),
		 'general_shipping' =>array(
			'title' => __( 'Include General Shipping Charges', 'shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to include general shipping charges applied above into advance charges.',
			'class' =>'',
			// 'description'  => __( 'Check to apply advanced shipping rules.', 'shipping-rates-for-woocommerce' ),
		 ),
		 'apply_all' =>array(
			'title' => __( ' Apply All Conditional Shipping', 'shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to aplly all advanced selected conditonal shipping',
			'class' =>'',
			// 'description'  => __( 'Check to apply advanced shipping rules.', 'shipping-rates-for-woocommerce' ),
		 ),
		//  'product_wise' => array(
		// 	'title' => __( 'Product Wise', 'shipping-rates-for-woocommerce' ),
		// 		'type' => 'text',
		// 		'description' => __( '', 'shipping-rates-for-woocommerce' ),
		// 		'default' => __( '', 'shipping-rates-for-woocommerce' )
		//  ),
		//  'price_product_wise' => array(
		// 	'title' => __( 'Price Product Wise', 'shipping-rates-for-woocommerce' ),
		// 		'type' => 'text',
		// 		'description' => __( 'Shipping charge for selected product', 'shipping-rates-for-woocommerce' ),
		// 		'default' => __( '', 'shipping-rates-for-woocommerce' )
		//  ),
		 'categories_wise' => array(
			'title' => __( 'Categories Wise', 'shipping-rates-for-woocommerce' ),
				'type' => 'multiselect',
				'description' => __( 'Free Shipping label on site', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' ),
				'options' => $categories,
		 ),
		 'price_categories_wise' => array(
			'title' => __( 'Price Categories Wise', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Shipping charge for selected categories', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 ),
		//  't2' =>array(
		// 	'title' => __( '<h4>Apply Advanced Shipping rules Product Specific</h4>', 'shipping-rates-for-woocommerce' ),
		// 	'type'  => 'checkbox',
		// 	'label' =>'Apply Advanced Shipping rules Per Product',
		// 	'class' =>'',
		// 	//'description'  => __( 'Check to apply advanced shipping rules.', 'shipping-rates-for-woocommerce' ),
		//  ),
		'range' =>array(
			'title' => __( '<h4>Apply Enable Range Rule</h4>', 'shipping-rates-for-woocommerce' ),
			'type'  => 'checkbox',
			'label' =>'Check to enable range rule',
			'class' =>'',
			// 'description'  => __( 'Check to apply advanced shipping rules.', 'shipping-rates-for-woocommerce' ),
		 ),
		 'max_weight_wise' => array(
			'title' => __( 'Maximun Weight', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Free Shipping label on site', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 ),
		 'min_weight_wise' => array(
			'title' => __( 'Minimum Weight', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Free Shipping label on site', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 ),
		 'price_weight_wise' => array(
			'title' => __( 'Price Weight Wise', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Shipping charge for selected Weight', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 ),
		 'max_price' => array(
			'title' => __( 'Maximum Price', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Free Shipping label on site', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 ),
		 'min_price' => array(
			'title' => __( 'Minimum Price', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Free Shipping label on site', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 ),
		 'price_wise' => array(
			'title' => __( 'Charge Price Wise', 'shipping-rates-for-woocommerce' ),
				'type' => 'text',
				'description' => __( 'Charge the shipping cost on selected price range', 'shipping-rates-for-woocommerce' ),
				'default' => __( '', 'shipping-rates-for-woocommerce' )
		 ),
		//  'max_price_wise' => array(
		// 	'title' => __( 'Maximun Price', 'shipping-rates-for-woocommerce' ),
		// 		'type' => 'text',
		// 		'description' => __( 'Free Shipping label on site', 'shipping-rates-for-woocommerce' ),
		// 		'default' => __( '', 'shipping-rates-fohttp://localhost:10049/wp-admin/admin.php?page=wc-settings&tab=shipping&instance_id=3r-woocommerce' )
		//  ),
		//  'min_price_wise' => array(
		// 	'title' => __( 'Minimum Price', 'shipping-rates-for-woocommerce' ),
		// 		'type' => 'text',
		// 		'description' => __( 'Free Shipping label on site', 'shipping-rates-for-woocommerce' ),
		// 		'default' => __( '', 'shipping-rates-for-woocommerce' )
		//  ),
		//  'price_price_range_wise' => array(
		// 	'title' => __( 'Price Range Wise', 'shipping-rates-for-woocommerce' ),
		// 		'type' => 'text',
		// 		'description' => __( 'Shipping charge for selected price range', 'shipping-rates-for-woocommerce' ),
		// 		'default' => __( '', 'shipping-rates-for-woocommerce' )
		//  ),
	 );
}

	public function calculate_shipping( $package = array()) {
		global $woocommerce;
				// As we are using instances for the cost and the title we need to take those values drom the instance_settings.
			 		$total_cart_weight    =  WC()->cart->get_cart_contents_weight();
					$total_cart_price	  = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
					$general_charges_enable   = $this->get_option('general_shipping');
					$intance_settings     =  $this->instance_settings;
					$enable_all_rules = $this->get_option( 'apply_all' );
					$max_weight = $this->get_option( 'max_weight_wise' );
					$min_weight = $this->get_option( 'min_weight_wise' );
					$max_price = $this->get_option( 'max_price' );
					$min_price = $this->get_option( 'min_price' );
					$price_wise_charge = $this->get_option( 'price_wise' );
					$weight_shipping_charge = $this->get_option( 'price_weight_wise' );
					$enable_free_shipping = $this->get_option( 'free_shipping' );
					$min_amount           = $this->get_option( 'free_shipping_amount' );

					$free_shippping_lable   = $this->get_option( 'shipping_label' );
					$pre_discount_price     = $this->get_option( 'pre_discount_price' );
					$min_order_cond         = $this->get_option( 'free_shipping_cond' );
					$cart_total_after_disc  = $package['contents_cost'];
					$cart_total_before_disc = $package['cart_subtotal'];
					$shipping_cond_check    = get_option( 'shipping_coupon');
  					$range = $this->get_option( 'range' );
                    
					//   $max_price_wise_charge=0;
					//   $min_price_wise_charge=0;
					//   $range_wise_charge =0;
					//   $max_weight_wise_charge = 0;
					//   $min_weight_wise_charge =0;
					//   $range_weight_wise_charge = 0;
					
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
		} elseif ('shipping_coupon' === $min_order_cond  && 'yes' === $enable_free_shipping && 'yes' === $shipping_cond_check ) {
						  $this->add_rate( array(
							'id'      => $this->id,
							'label'   =>$free_shippping_lable,
							'cost'    => 0,
							'package' => $package,
							'taxes'   => false,
						)
					);
		} 
		////////////////////////////////////Weigth Range Pricing///////////////////////////////
		elseif($total_cart_weight > $max_weight  && !empty($max_weight) && 'yes' !== $range){

			if('yes' === $general_charges_enable)
			{
				$weight_shipping_charge = $weight_shipping_charge + $this->get_option( 'cost' );
			}
            // $max_weight_wise_charge=$max_weight_wise_charge + $weight_shipping_charge;
			$this->add_rate( array(
				'id'      => $this->id,
				'label'   =>$this->get_option( 'title' ),
				'cost'    =>$weight_shipping_charge,
				'package' => $package,
				'taxes'   => false,
			)
		);
}elseif($total_cart_weight < $min_weight  && !empty($min_weight) && 'yes' !== $range){

	if('yes' === $general_charges_enable)
			{
				$weight_shipping_charge = $weight_shipping_charge + $this->get_option( 'cost' );
			}
			// $min_weight_wise_charge=$min_weight_wise_charge + $weight_shipping_charge;
	$this->add_rate( array(
		'id'      => $this->id,
		'label'   =>'Minimum Wala',
		'cost'    =>$weight_shipping_charge,
		'package' => $package,
		'taxes'   => false,
	)
);
}  elseif($total_cart_weight < $max_weight && 'yes' === $range && $total_cart_weight > $min_weight && !empty($min_weight) && !empty($max_weight)){

	if('yes' === $general_charges_enable)
			{
				$weight_shipping_charge = $weight_shipping_charge + $this->get_option( 'cost' );
			}

			// $range_weight_wise_charge = $range_weight_wise_charge + $weight_shipping_charge;
          
		$this->add_rate( array(
		'id'      => $this->id,
		'label'   =>'Range',
		'cost'    =>$weight_shipping_charge,
		'package' => $package,
		'taxes'   => false,
	)
);
}
////////////////////////Weight Range Pricing End Here///////////////////////////////////
///////////////////////////// Price Range ////////////////////////////////////
elseif($total_cart_price > $max_price  && !empty($max_price) && 'yes' !== $range){

	if('yes' === $general_charges_enable)
	{
		$price_wise_charge = $price_wise_charge + $this->get_option( 'cost' );
	}

	// $max_price_wise_charge = $max_price_wise_charge + $price_wise_charge;

	$this->add_rate( array(
		'id'      => $this->id,
		'label'   =>$this->get_option( 'title' ),
		'cost'    =>$price_wise_charge,
		'package' => $package,
		'taxes'   => false,
	)
);
}elseif($total_cart_price < $min_price && !empty($min_price) && 'yes' !== $range){

if('yes' === $general_charges_enable)
	{
		$price_wise_charge = $price_wise_charge + $this->get_option( 'cost' );
	}

	// $min_price_wise_charge = $min_price_wise_charge + $price_wise_charge;

$this->add_rate( array(
'id'      => $this->id,
'label'   =>'Minimum Wala',
'cost'    =>$price_wise_charge,
'package' => $package,
'taxes'   => false,
)
);
}

elseif($total_cart_price < $max_price && 'yes' === $range && $total_cart_price > $min_price){

if('yes' === $general_charges_enable)
	{
		$price_wise_charge = $price_wise_charge + $this->get_option( 'cost' );
	}

	// $range_wise_charge = $range_wise_charge + $price_wise_charge;

$this->add_rate( array(
'id'      => $this->id,
'label'   =>'Range',
'cost'    =>$price_wise_charge,
'package' => $package,
'taxes'   => false,
)
);
}
//////////////////////////////Price Range End Here////////////////////////////////////////////////////////////////
elseif('yes' === $enable_all_rules)
{
	
//    $price = $max_price_wise_charge+ $min_price_wise_charge + $range_wise_charge;
//    $weight= $max_price_wise_charge + $min_price_wise_charge + $range_weight_wise_charge;
//    $total = $price +
// 	$this->add_rate( array(
// 		'id'      => $this->id,
// 		'label'   =>$this->get_option( 'title' ),
// 		'cost'    => $this->get_option( 'cost' ),
// 		'package' => $package,
// 		'taxes'   => false,
// 	)
// );

}
else {
	
							$this->add_rate( array(
								'id'      => $this->id,
								'label'   =>$this->get_option( 'title' ),
								'cost'    => $this->get_option( 'cost' ),
								'package' => $package,
								'taxes'   => false,
							)
						);
		}
	}

}
