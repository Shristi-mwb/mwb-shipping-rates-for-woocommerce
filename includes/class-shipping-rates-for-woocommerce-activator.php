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

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Shipping_rates_for_woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function shipping_rates_for_woocommerce_activate() {
		update_option('srfw_radio_switch_shipping', 'on');
	}

}
