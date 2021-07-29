<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $msrfw_mwb_msrfw_obj;
$msrfw_active_tab   = isset( $_GET['msrfw_tab'] ) ? sanitize_key( $_GET['msrfw_tab'] ) : 'mwb-shipping-rates-for-woocommerce-overview';
$msrfw_default_tabs = $msrfw_mwb_msrfw_obj->mwb_msrfw_plug_default_tabs();
?>
<header>
	<?php
		// desc - This hook is used for trial.
		do_action( 'mwb_msrfw_settings_saved_notice' );
	?>
	<div class="mwb-header-container mwb-bg-white mwb-r-8">
		<h1 class="mwb-header-title"><?php esc_html_e( 'MWB SHIPPING RATES FOR WOOCOMMERCE', 'mwb-shipping-rates-for-woocommerce' ); ?></h1>
		<a href="https://docs.makewebbetter.com/mwb-shipping-rates-for-woocommerce/?utm_source=shipping-backend&utm_medium=doc-cta&utm_campaign=shipping-org" target="_blank" class="mwb-link"><?php esc_html_e( 'Documentation', 'mwb-shipping-rates-for-woocommerce' ); ?></a>
		<span>|</span>
		<a href="https://makewebbetter.com/submit-query/" target="_blank" class="mwb-link"><?php esc_html_e( 'Support', 'mwb-shipping-rates-for-woocommerce' ); ?></a>
	</div>
</header>
<main class="mwb-main mwb-bg-white mwb-r-8">
	<nav class="mwb-navbar">
		<ul class="mwb-navbar__items">
			<?php
			if ( is_array( $msrfw_default_tabs ) && ! empty( $msrfw_default_tabs ) ) {
				foreach ( $msrfw_default_tabs as $msrfw_tab_key => $msrfw_default_tabs ) {

					$msrfw_tab_classes = 'mwb-link ';
					if ( ! empty( $msrfw_active_tab ) && $msrfw_active_tab === $msrfw_tab_key ) {
						$msrfw_tab_classes .= 'active';
					}
					?>
					<li>
						<a id="<?php echo esc_attr( $msrfw_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=mwb_shipping_rates_for_woocommerce_menu' ) . '&msrfw_tab=' . esc_attr( $msrfw_tab_key ) ); ?>" class="<?php echo esc_attr( $msrfw_tab_classes ); ?>"><?php echo esc_html( $msrfw_default_tabs['title'] ); ?></a>
					</li>
					<?php
				}
			}
			?>
		</ul>
	</nav>
	<section class="mwb-section">
		<div>
			<?php
				// desc - This hook is used for trial.
				do_action( 'mwb_msrfw_before_general_settings_form' );
				// if submenu is directly clicked on woocommerce.
			if ( empty( $msrfw_active_tab ) ) {
				$msrfw_active_tab = 'mwb_msrfw_plug_general';
			}

				// look for the path based on the tab id in the admin templates.
				$msrfw_default_tabs     = $msrfw_mwb_msrfw_obj->mwb_msrfw_plug_default_tabs();
				$msrfw_tab_content_path = $msrfw_default_tabs[ $msrfw_active_tab ]['file_path'];
				$msrfw_mwb_msrfw_obj->mwb_msrfw_plug_load_template( $msrfw_tab_content_path );
				// desc - This hook is used for trial.
				do_action( 'mwb_msrfw_after_general_settings_form' );
			?>
		</div>
	</section>
