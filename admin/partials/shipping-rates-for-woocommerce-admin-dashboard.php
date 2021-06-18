<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $srfw_mwb_srfw_obj ,$error_notice;
$srfw_active_tab   = isset( $_GET['srfw_tab'] ) ? sanitize_key( $_GET['srfw_tab'] ) : 'shipping-rates-for-woocommerce-general';
$srfw_default_tabs = $srfw_mwb_srfw_obj->mwb_srfw_plug_default_tabs();
?>
<header>
	<div class="mwb-header-container mwb-bg-white mwb-r-8">
		<h1 class="mwb-header-title"><?php echo esc_attr( strtoupper( str_replace( '-', ' ', $srfw_mwb_srfw_obj->srfw_get_plugin_name() ) ) ); ?></h1>
		<a href="https://docs.makewebbetter.com/" target="_blank" class="mwb-link"><?php esc_html_e( 'Documentation', 'shipping-rates-for-woocommerce' ); ?></a>
		<span>|</span>
		<a href="https://makewebbetter.com/contact-us/" target="_blank" class="mwb-link"><?php esc_html_e( 'Support', 'invoice-system-for-woocommerce' ); ?></a>
	</div>
</header> 
<?php
if ( ! $error_notice ) { 
	$srfw_mwb_srfw_obj->mwb_srfw_plug_admin_notice( 'Settings Saved', 'success' );
}
?>
<main class="mwb-main mwb-bg-white mwb-r-8">
	<nav class="mwb-navbar">
		<ul class="mwb-navbar__items">
			<?php
			if ( is_array( $srfw_default_tabs ) && ! empty( $srfw_default_tabs ) ) {

				foreach ( $srfw_default_tabs as $srfw_tab_key => $srfw_default_tabs ) {

					$srfw_tab_classes = 'mwb-link ';

					if ( ! empty( $srfw_active_tab ) && $srfw_active_tab === $srfw_tab_key ) {
						$srfw_tab_classes .= 'active';
					}
					?>
					<li>
						<a id="<?php echo esc_attr( $srfw_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=shipping_rates_for_woocommerce_menu' ) . '&srfw_tab=' . esc_attr( $srfw_tab_key ) ); ?>" class="<?php echo esc_attr( $srfw_tab_classes ); ?>"><?php echo esc_html( $srfw_default_tabs['title'] ); ?></a>
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
				do_action( 'mwb_srfw_before_general_settings_form' );
						// if submenu is directly clicked on woocommerce.
				if ( empty( $srfw_active_tab ) ) {
					$srfw_active_tab = 'mwb_srfw_plug_general';
				}

						// look for the path based on the tab id in the admin templates.
				$srfw_tab_content_path = 'admin/partials/' . $srfw_active_tab . '.php';

				$srfw_mwb_srfw_obj->mwb_srfw_plug_load_template( $srfw_tab_content_path );

				do_action( 'mwb_srfw_after_general_settings_form' ); 
			?>
		</div>
	</section>
