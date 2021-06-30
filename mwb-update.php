<?php
if (! defined('ABSPATH') ) {
	exit; // Exit if accessed directly.
}

if (! class_exists('Mwb_mwb_shipping_rates_for_woocommerce_update') ) {
	class Mwb_mwb_shipping_rates_for_woocommerce_update
	{

		public function __construct()
		{
			// register_activation_hook(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_BASE_FILE, array( $this, 'mwb_check_activation' ));
			// add_action('mwb_mwb_shipping_rates_for_woocommerce_check_event', array( $this, 'mwb_check_update' ));
			// add_filter('http_request_args', array( $this, 'mwb_updates_exclude' ), 5, 2);
			// register_deactivation_hook(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_BASE_FILE, array( $this, 'mwb_check_deactivation' ));

			// $plugin_update = get_option('mwb_msrfw_plugin_update', 'false');
			// if ('true' === $plugin_update ) {

				// To add view details content in plugin update notice on plugins page.
				// add_action('install_plugins_pre_plugin-information', array( $this, 'mwb_msrfw_details' ));
				// To add plugin update notice after plugin update message.
				// add_action('in_plugin_update_message-mwb-shipping-rates-for-woocommerce/mwb-shipping-rates-for-woocommerce.php', array( $this, 'mwb_msrfw_in_plugin_update_notice' ), 10, 2);
			// }

		}

		public function mwb_check_deactivation()
		{
			wp_clear_scheduled_hook('mwb_mwb_shipping_rates_for_woocommerce_check_event');
		}

		public function mwb_check_activation()
		{
			wp_schedule_event(time(), 'daily', 'mwb_mwb_shipping_rates_for_woocommerce_check_event');
		}

		public function mwb_msrfw_details()
		{

			global $tab;

			// change $_REQUEST['plugin] to your plugin slug name.
			if ($tab == 'plugin-information' && $_REQUEST['plugin'] == 'mwb-shipping-rates-for-woocommerce' ) {

				$data = $this->get_plugin_update_data();

				if (is_wp_error($data) || empty($data) ) {

					return;
				}

				if (! empty($data['body']) ) {

					$all_data = json_decode($data['body'], true);

					if (! empty($all_data) && is_array($all_data) ) {

						$this->create_html_data($all_data);

						wp_die();
					}
				}
			}
		}

		public function get_plugin_update_data() {

			// replace with your plugin url.
			// $url = 'https://makewebbetter.com/pluginupdates/mwb-shipping-rates-for-woocommerce/mwb-update.php';
			$postdata = array(
				'action' => 'check_update',
				'license_code' => MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_LICENSE_KEY,
			);

			$args = array(
				'method' => 'POST',
				'body' => $postdata,
			);

			$data = wp_remote_post( $url, $args );

			return $data;
		}

		// render HTML content.
		public function create_html_data( $all_data ) {
			?>
			<style>
				#TB_window{
					top : 4% !important;
				}
				.mwb_msrfw_banner > img {
					width: 50%;
				}
				.mwb_msrfw_banner > h1 {
					margin-top: 0px;
				}
				.mwb_msrfw_banner {
					text-align: center;
				}
				.mwb_msrfw_description > h4 {
					background-color: #3779B5;
					padding: 5px;
					color: #ffffff;
					border-radius: 5px;
				}
				.mwb_msrfw_changelog_details > h4 {
					background-color: #3779B5;
					padding: 5px;
					color: #ffffff;
					border-radius: 5px;
				}
			</style>
			<div class="mwb_msrfw_details_wrapper">
				<div class="mwb_msrfw_banner">
					<h1><?php echo $all_data['name'] . ' ' . $all_data['version']; ?></h1>
					<img src="<?php echo $all_data['banners']['logo']; ?>"> 
				</div>

				<div class="mwb_msrfw_description">
					<h4><?php _e( 'Plugin Description', 'mwb-shipping-rates-for-woocommerce' ); ?></h4>
					<span><?php echo $all_data['sections']['description']; ?></span>
				</div>
				<div class="mwb_msrfw_changelog_details">
					<h4><?php _e( 'Plugin Change Log', 'mwb-shipping-rates-for-woocommerce' ); ?></h4>
					<span><?php echo $all_data['sections']['changelog']; ?></span>
				</div> 
			</div>
			<?php
		}

		public function mwb_msrfw_in_plugin_update_notice()
		{

			$data = $this->get_plugin_update_data();

			if (is_wp_error($data) || empty($data) ) {

				return;
			}

			if (isset($data['body']) ) {

				$all_data = json_decode($data['body'], true);

				if (is_array($all_data) && ! empty($all_data['sections']['update_notice']) ) {

					?>

					<style type="text/css">
						#mwb-shipping-rates-for-woocommerce-update .dummy {
							display: none;
						}

						#mwb_msrfw_in_plugin_update_div p:before {
							content: none;
						}

						#mwb_msrfw_in_plugin_update_div {
							border-top: 1px solid #ffb900;
							margin-left: -13px;
							padding-left: 20px;
							padding-top: 10px;
							padding-bottom: 5px;
						}

						#mwb_msrfw_in_plugin_update_div ul {
							list-style-type: decimal;
							padding-left: 20px;
						}

					</style>

					<?php

					echo '</p><div id="mwb_msrfw_in_plugin_update_div">' . $all_data['sections']['update_notice'] . '</div><p class="dummy">';
				}
			}
		}

		public function mwb_check_update()
		{
			global $wp_version;
			$update_check_msrfw = 'https://makewebbetter.com/pluginupdates/mwb-shipping-rates-for-woocommerce/mwb-update.php';
			$plugin_folder = plugin_basename(dirname(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_BASE_FILE));
			$plugin_file = basename(( MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_BASE_FILE ));
			if (defined('WP_INSTALLING') ) {
				return false;
			}
			$postdata = array(
			'action' => 'check_update',
			'license_key' => MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_LICENSE_KEY,
			);

			$args = array(
			'method' => 'POST',
			'body' => $postdata,
			);

			$response = wp_remote_post($update_check_msrfw, $args);

			if (is_wp_error($response) || empty($response['body']) ) {

				return;
			}

			list($version, $url) = explode('~', $response['body']);

			if ($this->mwb_plugin_get('Version') >= $version ) {

				update_option('mwb_msrfw_plugin_update', 'false');

				return false;
			}

			update_option('mwb_msrfw_plugin_update', 'true');

			$plugin_transient = get_site_transient('update_plugins');
			$a = array(
			'slug' => $plugin_folder,
			'new_version' => $version,
			'url' => $this->mwb_plugin_get('AuthorURI'),
			'package' => $url,
			);
			$o = (object) $a;
			$plugin_transient->response[ $plugin_folder . '/' . $plugin_file ] = $o;
			set_site_transient('update_plugins', $plugin_transient);
		}

		public function mwb_updates_exclude( $r, $url )
		{
			if (0 !== strpos($url, 'http://api.wordpress.org/plugins/update-check') ) {
				return $r;
			}
			$plugins = unserialize($r['body']['plugins']);
			if (! empty($plugins->plugins) ) {
				unset($plugins->plugins[ plugin_basename(__FILE__) ]);
			}
			if (! empty($plugins->active) ) {
				unset($plugins->active[ array_search(plugin_basename(__FILE__), $plugins->active) ]);
			}
			$r['body']['plugins'] = serialize($plugins);
			return $r;
		}

		// Returns current plugin info.
		public function mwb_plugin_get( $i ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$plugin_folder = get_plugins( '/' . plugin_basename( dirname( MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_BASE_FILE ) ) );
			$plugin_file = basename( ( MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_BASE_FILE ) );
			return $plugin_folder[ $plugin_file ][ $i ];
		}
	}
	new Mwb_mwb_shipping_rates_for_woocommerce_update();
}