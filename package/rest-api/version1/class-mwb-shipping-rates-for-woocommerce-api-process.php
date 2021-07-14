<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Mwb_Shipping_Rates_For_Woocommerce_Api_Process' ) ) {

	/**
	 * The plugin API class.
	 *
	 * This is used to define the functions and data manipulation for custom endpoints.
	 *
	 * @since      1.0.0
	 * @package    Mwb_Shipping_Rates_For_Woocommerce
	 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/includes
	 */
	class Mwb_Shipping_Rates_For_Woocommerce_Api_Process {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

		}

		/**
		 * Define the function to process data for custom endpoint.
		 *
		 * @since    1.0.0
		 * @param   Array $msrfw_request  data of requesting headers and other information.
		 * @return  Array $mwb_msrfw_rest_response    returns processed data and status of operations.
		 */
		public function mwb_msrfw_default_process( $msrfw_request ) {
			$mwb_msrfw_rest_response = array();

			// Write your custom code here.

			$mwb_msrfw_rest_response['status'] = 200;
			$mwb_msrfw_rest_response['data'] = $msrfw_request->get_headers();
			return $mwb_msrfw_rest_response;
		}
	}
}
