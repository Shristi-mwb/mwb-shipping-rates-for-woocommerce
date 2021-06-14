<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Shipping_rates_for_woocommerce_Api_Process' ) ) {

	/**
	 * The plugin API class.
	 *
	 * This is used to define the functions and data manipulation for custom endpoints.
	 *
	 * @since      1.0.0
	 * @package    Hydroshop_Api_Management
	 * @subpackage Hydroshop_Api_Management/includes
	 * @author     MakeWebBetter <makewebbetter.com>
	 */
	class Shipping_rates_for_woocommerce_Api_Process {

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
		 * @param   Array $srfw_request  data of requesting headers and other information.
		 * @return  Array $mwb_srfw_rest_response    returns processed data and status of operations.
		 */
		public function mwb_srfw_default_process( $srfw_request ) {
			$mwb_srfw_rest_response = array();

			// Write your custom code here.

			$mwb_srfw_rest_response['status'] = 200;
			$mwb_srfw_rest_response['data'] = $srfw_request->get_headers();
			return $mwb_srfw_rest_response;
		}
	}
}
