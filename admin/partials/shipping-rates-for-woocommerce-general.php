<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $srfw_mwb_srfw_obj;
$srfw_genaral_settings = apply_filters( 'srfw_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-srfw-gen-section-form">
	<div class="srfw-secion-wrap">
		<?php
		$srfw_general_html = $srfw_mwb_srfw_obj->mwb_srfw_plug_generate_html( $srfw_genaral_settings );
		echo esc_html( $srfw_general_html );
		?>
	</div>
</form>