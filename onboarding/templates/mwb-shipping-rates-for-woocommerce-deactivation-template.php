<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/admin/onboarding
 */

global $pagenow, $msrfw_mwb_msrfw_obj;
if ( empty( $pagenow ) || 'plugins.php' != $pagenow ) {
	return false;
}
$mwb_plugin_name                = ! empty( explode( '/', plugin_basename( __FILE__ ) ) ) ? explode( '/', plugin_basename( __FILE__ ) )[0] : '';
$mwb_plugin_deactivation_id     = $mwb_plugin_name . '-no_thanks_deactive';
$mwb_plugin_onboarding_popup_id = $mwb_plugin_name . '-onboarding_popup';
$msrfw_onboarding_form_deactivate = 
//desc - filter for trial.
apply_filters('mwb_msrfw_deactivation_form_fields', array());

?>
<?php if ( ! empty( $msrfw_onboarding_form_deactivate ) ) : ?>
	<div id="<?php echo esc_attr( $mwb_plugin_onboarding_popup_id ); ?>" class="mdc-dialog mdc-dialog--scrollable <? echo 
	//desc - filter for trial.
	apply_filters('mwb_stand_dialog_classes', 'mwb-shipping-rates-for-woocommerce' )?>">
		<div class="mwb-msrfw-on-boarding-wrapper-background mdc-dialog__container">
			<div class="mwb-msrfw-on-boarding-wrapper mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
				<div class="mdc-dialog__content">
					<div class="mwb-msrfw-on-boarding-close-btn">
						<a href="#">
							<span class="msrfw-close-form material-icons mwb-msrfw-close-icon mdc-dialog__button" data-mdc-dialog-action="close">clear</span>
						</a>
					</div>

					<h3 class="mwb-msrfw-on-boarding-heading mdc-dialog__title"></h3>
					<p class="mwb-msrfw-on-boarding-desc"><?php esc_html_e( 'May we have a little info about why you are deactivating?', 'mwb-shipping-rates-for-woocommerce' ); ?></p>
					<form action="#" method="post" class="mwb-msrfw-on-boarding-form">
						<?php 
						$msrfw_onboarding_deactive_html = $msrfw_mwb_msrfw_obj->mwb_msrfw_plug_generate_html( $msrfw_onboarding_form_deactivate );
						echo esc_html( $msrfw_onboarding_deactive_html );
						?>
						<div class="mwb-msrfw-on-boarding-form-btn__wrapper mdc-dialog__actions">
							<div class="mwb-msrfw-on-boarding-form-submit mwb-msrfw-on-boarding-form-verify ">
								<input type="submit" class="mwb-msrfw-on-boarding-submit mwb-on-boarding-verify mdc-button mdc-button--raised" value="Send Us">
							</div>
							<div class="mwb-msrfw-on-boarding-form-no_thanks">
								<a href="#" id="<?php echo esc_attr( $mwb_plugin_deactivation_id ); ?>" class="<? echo 
								//desc - filter for trial.
								apply_filters('mwb_stand_no_thank_classes', 'mwb-shipping-rates-for-woocommerce-no_thanks' )?> mdc-button"><?php esc_html_e( 'Skip and Deactivate Now', 'mwb-shipping-rates-for-woocommerce' ); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="mdc-dialog__scrim"></div>
	</div>
<?php endif; ?>
