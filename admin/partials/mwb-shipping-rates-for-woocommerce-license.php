<?php
?>
<div class="mwb-msrfw-wrap">
<h2><?php _e( 'Your License', 'mwb-shipping-rates-for-woocommerce' ); ?></h2>
<div class="mwb_msrfw_license_text">
	<p>
	<?php
	esc_html_e( 'This is the License Activation Panel. After purchasing extension from MakeWebBetter you will get the purchase code of this extension. Please verify your purchase below so that you can use feature of this plugin.', 'mwb-shipping-rates-for-woocommerce' );
	?>
	</p>
	<form id="mwb_msrfw_license_form"> 
		<table class="mwb-msrfw-form-table">
			<tr>
			<th scope="row"><label for="puchase-code"><?php esc_html_e( 'Purchase Code : ', 'mwb-shipping-rates-for-woocommerce' ); ?></label></th>
			<td>
				<input type="text" id="mwb_msrfw_license_key" name="purchase-code" required="" size="30" class="mwb-msrfw-purchase-code" value="" placeholder="<?php _e( 'Enter your code here...', 'mwb-shipping-rates-for-woocommerce' ); ?>">
				<!-- <div id="mwb_license_ajax_loader"><img src="<?php //echo 'images/spinner.gif'; ?>"></div>-->
			</td>
			</tr>
		</table>
		<p id="mwb_msrfw_license_activation_status"></p>
		<p class="submit">
		<button id="mwb_msrfw_license_activate" required="" class="button-primary woocommerce-save-button" name="mwb_msrfw_license_settings"><?php esc_html_e( 'Validate', 'mwb-shipping-rates-for-woocommerce' ); ?></button>
		</p>
	</form>
</div>
</div>
