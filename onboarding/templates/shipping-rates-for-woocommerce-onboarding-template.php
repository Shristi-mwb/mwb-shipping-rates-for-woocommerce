<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Makewebbetter_Onboarding
 * @subpackage Makewebbetter_Onboarding/admin/onboarding
 */
global $srfw_mwb_srfw_obj;
$srfw_onboarding_form_fields = apply_filters( 'mwb_srfw_on_boarding_form_fields', array() );
?>

<?php if ( ! empty( $srfw_onboarding_form_fields ) ) : ?>
	<div class="mdc-dialog mdc-dialog--scrollable">
		<div class="mwb-srfw-on-boarding-wrapper-background mdc-dialog__container">
			<div class="mwb-srfw-on-boarding-wrapper mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
				<div class="mdc-dialog__content">
					<div class="mwb-srfw-on-boarding-close-btn">
						<a href="#"><span class="srfw-close-form material-icons mwb-srfw-close-icon mdc-dialog__button" data-mdc-dialog-action="close">clear</span></a>
					</div>

					<h3 class="mwb-srfw-on-boarding-heading mdc-dialog__title"><?php esc_html_e( 'Welcome to MakeWebBetter', 'shipping-rates-for-woocommerce' ); ?> </h3>
					<p class="mwb-srfw-on-boarding-desc"><?php esc_html_e( 'We love making new friends! Subscribe below and we promise to keep you up-to-date with our latest new plugins, updates, awesome deals and a few special offers.', 'shipping-rates-for-woocommerce' ); ?></p>

					<form action="#" method="post" class="mwb-srfw-on-boarding-form">
						<?php 
						$srfw_onboarding_html = $srfw_mwb_srfw_obj->mwb_srfw_plug_generate_html( $srfw_onboarding_form_fields );
						echo esc_html( $srfw_onboarding_html );
						?>
						<div class="mwb-srfw-on-boarding-form-btn__wrapper mdc-dialog__actions">
							<div class="mwb-srfw-on-boarding-form-submit mwb-srfw-on-boarding-form-verify ">
								<input type="submit" class="mwb-srfw-on-boarding-submit mwb-on-boarding-verify mdc-button mdc-button--raised" value="Send Us">
							</div>
							<div class="mwb-srfw-on-boarding-form-no_thanks">
								<a href="#" class="mwb-srfw-on-boarding-no_thanks mdc-button" data-mdc-dialog-action="discard"><?php esc_html_e( 'Skip For Now', 'shipping-rates-for-woocommerce' ); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="mdc-dialog__scrim"></div>
	</div>
<?php endif; ?>
