<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Shipping_rates_for_woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       shipping-rates-for-woocommerce
 * Plugin URI:        https://makewebbetter.com/product/shipping-rates-for-woocommerce/
 * Description:       Shipping rates for WooCommerce provide different shipping options.
 * Version:           1.0.0
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       shipping-rates-for-woocommerce
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to:      4.9.5
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Define plugin constants.
 *
 * @since             1.0.0
 */
function define_shipping_rates_for_woocommerce_constants() {

	shipping_rates_for_woocommerce_constants( 'SHIPPING_RATES_FOR_WOOCOMMERCE_VERSION', '1.0.0' );
	shipping_rates_for_woocommerce_constants( 'SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH', plugin_dir_path( __FILE__ ) );
	shipping_rates_for_woocommerce_constants( 'SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL', plugin_dir_url( __FILE__ ) );
	shipping_rates_for_woocommerce_constants( 'SHIPPING_RATES_FOR_WOOCOMMERCE_SERVER_URL', 'https://makewebbetter.com' );
	shipping_rates_for_woocommerce_constants( 'SHIPPING_RATES_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'shipping-rates-for-woocommerce' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function shipping_rates_for_woocommerce_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-shipping-rates-for-woocommerce-activator.php
 */
function activate_shipping_rates_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shipping-rates-for-woocommerce-activator.php';
	Shipping_rates_for_woocommerce_Activator::shipping_rates_for_woocommerce_activate();
	$mwb_srfw_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_srfw_active_plugin ) && ! empty( $mwb_srfw_active_plugin ) ) {
		$mwb_srfw_active_plugin['shipping-rates-for-woocommerce'] = array(
			'plugin_name' => __( 'shipping-rates-for-woocommerce', 'shipping-rates-for-woocommerce' ),
			'active' => '1',
		);
	} else {
		$mwb_srfw_active_plugin = array();
		$mwb_srfw_active_plugin['shipping-rates-for-woocommerce'] = array(
			'plugin_name' => __( 'shipping-rates-for-woocommerce', 'shipping-rates-for-woocommerce' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_srfw_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-shipping-rates-for-woocommerce-deactivator.php
 */
function deactivate_shipping_rates_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shipping-rates-for-woocommerce-deactivator.php';
	Shipping_rates_for_woocommerce_Deactivator::shipping_rates_for_woocommerce_deactivate();
	$mwb_srfw_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_srfw_deactive_plugin ) && ! empty( $mwb_srfw_deactive_plugin ) ) {
		foreach ( $mwb_srfw_deactive_plugin as $mwb_srfw_deactive_key => $mwb_srfw_deactive ) {
			if ( 'shipping-rates-for-woocommerce' === $mwb_srfw_deactive_key ) {
				$mwb_srfw_deactive_plugin[ $mwb_srfw_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_srfw_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_shipping_rates_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_shipping_rates_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-shipping-rates-for-woocommerce.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_shipping_rates_for_woocommerce() {
	define_shipping_rates_for_woocommerce_constants();

	$srfw_plugin_standard = new Shipping_rates_for_woocommerce();
	$srfw_plugin_standard->srfw_run();
	$GLOBALS['srfw_mwb_srfw_obj'] = $srfw_plugin_standard;
	$GLOBALS['error_notice']        = true;

}
run_shipping_rates_for_woocommerce();


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'shipping_rates_for_woocommerce_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function shipping_rates_for_woocommerce_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=shipping_rates_for_woocommerce_menu' ) . '">' . __( 'Settings', 'shipping-rates-for-woocommerce' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}

/**
 * Adding custom setting links at the plugin activation list.
 *
 * @param array  $links_array array containing the links to plugin.
 * @param string $plugin_file_name plugin file name.
 * @return array
*/
function shipping_rates_for_woocommerce_custom_settings_at_plugin_tab( $links_array, $plugin_file_name ) {
	if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
		$links_array[] = '<a href="#" target="_blank"><img src="' . esc_html( SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Demo.svg" class="mwb-info-img" alt="Demo image">'.__( 'Demo', 'shipping-rates-for-woocommerce' ).'</a>';
		$links_array[] = '<a href="#" target="_blank"><img src="' . esc_html( SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Documentation.svg" class="mwb-info-img" alt="documentation image">'.__( 'Documentation', 'shipping-rates-for-woocommerce' ).'</a>';
		$links_array[] = '<a href="#" target="_blank"><img src="' . esc_html( SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Support.svg" class="mwb-info-img" alt="support image">'.__( 'Support', 'shipping-rates-for-woocommerce' ).'</a>';
	}
	return $links_array;
}
add_filter( 'plugin_row_meta', 'shipping_rates_for_woocommerce_custom_settings_at_plugin_tab', 10, 2 );
