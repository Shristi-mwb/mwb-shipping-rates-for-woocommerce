<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $msrfw_mwb_msrfw_obj;
$msrfw_genaral_settings =
// desc - filter for trial.
apply_filters( 'msrfw_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-msrfw-gen-section-form">
	<div class="msrfw-secion-wrap">
		<?php
		$msrfw_general_html = $msrfw_mwb_msrfw_obj->mwb_msrfw_plug_generate_html( $msrfw_genaral_settings );
		echo esc_html( $msrfw_general_html );
		wp_nonce_field( 'admin_save_data', 'mwb_tabs_nonce' );
		?>
	</div>
</form>
