<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link    https://makewebbetter.com/
 * @since   1.0.0
 * @package Mwb_Shipping_Rates_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       MWB Shipping Rates For WooCommerce
 * Plugin URI:        https://makewebbetter.com/product/mwb-shipping-rates-for-woocommerce/
 * Description:       Your Basic Plugin
 * Version:           1.0.0
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       mwb-shipping-rates-for-woocommerce
 * Domain Path:       /languages
 *
 * WC Requires at least: 4.0.0
 * WC tested up to: 5.3.0
 * WP Requires at least: 5.1.0
 * WP Tested up to: 5.7.2
 * Requires PHP: 7.2 or Higher
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if (! defined('ABSPATH') ) {
    die;
}

$activated = true;

if (function_exists('is_multisite') && is_multisite () ) 
{
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( !is_plugin_active( 'woocommerce/woocommerce.php' ))
	{
		$activated = false;
	}
}
else   
{
	if (!in_array( 'woocommerce/woocommerce.php' ,  apply_filters( 'active_plugins' , get_option( 'active_plugins' ) ) ) )	  
	{
		$activated = false;
	}
		else	{
		$activated = true;
	}
}
if ( $activated )
{

/**
 * Define plugin constants.
 *
 * @since 1.0.0
 */
function define_mwb_shipping_rates_for_woocommerce_constants()
{

    mwb_shipping_rates_for_woocommerce_constants('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_VERSION', '1.0.0');
    mwb_shipping_rates_for_woocommerce_constants('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH', plugin_dir_path(__FILE__));
    mwb_shipping_rates_for_woocommerce_constants('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL', plugin_dir_url(__FILE__));
    mwb_shipping_rates_for_woocommerce_constants('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_SERVER_URL', 'https://makewebbetter.com');
    mwb_shipping_rates_for_woocommerce_constants('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'MWB Shipping Rates For WooCommerce');
}

/**
 * Define mwb-site update feature.
 * 
 * @since 1.0.0
 */
function auto_update_mwb_shipping_rates_for_woocommerce()
{
    $mwb_msrfw_license_key = get_option('mwb_msrfw_license_key', '');
    if (! defined('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_SPECIAL_SECRET_KEY') ) {
        define('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_SPECIAL_SECRET_KEY', '59f32ad2f20102.74284991');
    }

    if (! defined('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_LICENSE_SERVER_URL') ) {
        define('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_LICENSE_SERVER_URL', 'https://makewebbetter.com');
    }

    if (! defined('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_ITEM_REFERENCE') ) {
        define('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'MWB Shipping Rates For WooCommerce');
    }
    mwb_shipping_rates_for_woocommerce_constants('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_BASE_FILE', __FILE__);
    mwb_shipping_rates_for_woocommerce_constants('MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_LICENSE_KEY', $mwb_msrfw_license_key);
    include_once 'mwb-update.php';
}

/**
 * Callable function for defining plugin constants.
 *
 * @param String $key   Key for contant.
 * @param String $value value for contant.
 * @since 1.0.0
 */
function mwb_shipping_rates_for_woocommerce_constants( $key, $value )
{

    if (! defined($key) ) {

        define($key, $value);
    }
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mwb-shipping-rates-for-woocommerce-activator.php
 */
function activate_mwb_shipping_rates_for_woocommerce()
{
    if (! wp_next_scheduled('mwb_msrfw_check_license_daily') ) {
        wp_schedule_event(time(), 'daily', 'mwb_msrfw_check_license_daily');
    }

    include_once plugin_dir_path(__FILE__) . 'includes/class-mwb-shipping-rates-for-woocommerce-activator.php';
    Mwb_Shipping_Rates_For_Woocommerce_Activator::mwb_shipping_rates_for_woocommerce_activate();
    $mwb_msrfw_active_plugin = get_option('mwb_all_plugins_active', false);
    if (is_array($mwb_msrfw_active_plugin) && ! empty($mwb_msrfw_active_plugin) ) {
        $mwb_msrfw_active_plugin['mwb-shipping-rates-for-woocommerce'] = array(
        'plugin_name' => __('MWB Shipping Rates For WooCommerce', 'mwb-shipping-rates-for-woocommerce'),
        'active' => '1',
        );
    } else {
        $mwb_msrfw_active_plugin = array();
        $mwb_msrfw_active_plugin['mwb-shipping-rates-for-woocommerce'] = array(
        'plugin_name' => __('MWB Shipping Rates For WooCommerce', 'mwb-shipping-rates-for-woocommerce'),
        'active' => '1',
        );
    }
    update_option('mwb_all_plugins_active', $mwb_msrfw_active_plugin);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mwb-shipping-rates-for-woocommerce-deactivator.php
 */
function deactivate_mwb_shipping_rates_for_woocommerce()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-mwb-shipping-rates-for-woocommerce-deactivator.php';
    Mwb_Shipping_Rates_For_Woocommerce_Deactivator::mwb_shipping_rates_for_woocommerce_deactivate();
    $mwb_msrfw_deactive_plugin = get_option('mwb_all_plugins_active', false);
    if (is_array($mwb_msrfw_deactive_plugin) && ! empty($mwb_msrfw_deactive_plugin) ) {
        foreach ( $mwb_msrfw_deactive_plugin as $mwb_msrfw_deactive_key => $mwb_msrfw_deactive ) {
            if ('mwb-shipping-rates-for-woocommerce' === $mwb_msrfw_deactive_key ) {
                $mwb_msrfw_deactive_plugin[ $mwb_msrfw_deactive_key ]['active'] = '0';
            }
        }
    }
    update_option('mwb_all_plugins_active', $mwb_msrfw_deactive_plugin);
}

register_activation_hook(__FILE__, 'activate_mwb_shipping_rates_for_woocommerce');
register_deactivation_hook(__FILE__, 'deactivate_mwb_shipping_rates_for_woocommerce');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-mwb-shipping-rates-for-woocommerce.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_mwb_shipping_rates_for_woocommerce()
{
    define_mwb_shipping_rates_for_woocommerce_constants();
    //auto_update_mwb_shipping_rates_for_woocommerce();
    $msrfw_plugin_standard = new Mwb_Shipping_Rates_For_Woocommerce();
    $msrfw_plugin_standard->msrfw_run();
    $GLOBALS['msrfw_mwb_msrfw_obj'] = $msrfw_plugin_standard;

}
run_mwb_shipping_rates_for_woocommerce();


// Add settings link on plugin page.
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'mwb_shipping_rates_for_woocommerce_settings_link');

/**
 * Settings link.
 *
 * @since 1.0.0
 * @param Array $links Settings link array.
 */
function mwb_shipping_rates_for_woocommerce_settings_link( $links )
{

    $my_link = array(
    '<a href="' . admin_url('admin.php?page=mwb_shipping_rates_for_woocommerce_menu') . '">' . __('Settings', 'mwb-shipping-rates-for-woocommerce') . '</a>',
    );
    return array_merge($my_link, $links);
}

/**
 * Adding custom setting links at the plugin activation list.
 *
 * @param  array  $links_array      array containing the links to plugin.
 * @param  string $plugin_file_name plugin file name.
 * @return array
 */
function mwb_shipping_rates_for_woocommerce_custom_settings_at_plugin_tab( $links_array, $plugin_file_name )
{
    if (strpos($plugin_file_name, basename(__FILE__)) ) {
        $links_array[] = '<a href="#" target="_blank"><img src="' . esc_html(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL) . 'admin/image/Demo.svg" class="mwb-info-img" alt="Demo image">'.__('Demo', 'mwb-shipping-rates-for-woocommerce').'</a>';
        $links_array[] = '<a href="#" target="_blank"><img src="' . esc_html(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL) . 'admin/image/Documentation.svg" class="mwb-info-img" alt="documentation image">'.__('Documentation', 'mwb-shipping-rates-for-woocommerce').'</a>';
        $links_array[] = '<a href="#" target="_blank"><img src="' . esc_html(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL) . 'admin/image/Support.svg" class="mwb-info-img" alt="support image">'.__('Support', 'mwb-shipping-rates-for-woocommerce').'</a>';
    }
    return $links_array;
}
add_filter('plugin_row_meta', 'mwb_shipping_rates_for_woocommerce_custom_settings_at_plugin_tab', 10, 2);

} 
else 
{
	/**
	 * Show warning message if woocommerce is not install
	 * @since 1.0.0
	 * @name iasfw_plugin_error_notices()
	 * @author makewebbetter<webmaster@makewebbetter.com>
	 * @link http://www.makewebbetter.com/
	 */

	function msrfw_plugin_error_notices(){ ?>
	<div class="error notice is-dismissible">
		<p><?php _e( ' Woocommerce is not activated, Please activate Woocommerce first to install MWB Shipping Rates For Woocomerce . ' , 'mwb-shipping-rates-for-woocommerce' ); ?></p>
	</div>
	<style>
		#message{display:none;}
	</style>
	<?php 
	} 
add_action( 'admin_init', 'msrfw_plugin_deactivate' );  

		/**
		 * Call Admin notices
		* 
		* @name iasfw_plugin_deactivate()
		* @author makewebbetter<webmaster@makewebbetter.com>
		* @link http://www.makewebbetter.com/
		*/ 	
	function msrfw_plugin_deactivate(){

			deactivate_plugins( plugin_basename( __FILE__ ) );
			add_action( 'admin_notices', 'msrfw_plugin_error_notices' );
	}
}