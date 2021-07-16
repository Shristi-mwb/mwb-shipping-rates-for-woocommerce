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
?>
<div class="mwb-overview__wrapper">
	<div class="mwb-overview__banner">
		<img src="<?php echo esc_html( MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL, 'mwb-shipping-rates-for-woocommerce' ); ?>admin/image/banner.png" alt="Overview banner image">
	</div>
	<div class="mwb-overview__content">
		<div class="mwb-overview__content-description">
			<h2><?php echo esc_html_e( 'What Is MWB Shipping Rates For WooCommerce?', 'mwb-shipping-rates-for-woocommerce' ); ?></h2>
			<p>
				<?php
				esc_html_e(
					'The MWB WooCommerce Shipping Rates plugin is a full-featured and extremely versatile plugin for setting numerous shipping ways with different shipping regulations and maximizing earnings from the shipping methods on offer.
                     MWB Shipping Rates for WooCommerce is used to calculate shipping rates based on the total weight of the order, the total price of all products in the cart, different product categories, and other factors. ',
					'mwb-shipping-rates-for-woocommerce'
				);
				?>
			</p>
			<h3><?php esc_html_e( 'As a store owner, you get to:', 'mwb-shipping-rates-for-woocommerce' ); ?></h3>
			<ul class="mwb-overview__features">
			<li><?php esc_html_e( 'This plugin makes it simple for your customers to access shipping rates.', 'mwb-shipping-rates-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Create a number of MWB shipping methods.', 'mwb-shipping-rates-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Customers can choose from a variety of shipping options.', 'mwb-shipping-rates-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Shipments should be deployed more strategically manner.', 'mwb-shipping-rates-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Shipping rates can be molded to optimize shipping', 'mwb-shipping-rates-for-woocommerce' ); ?></li>
			</ul>
		</div>
		<h2> <?php esc_html_e( 'The Free Plugin Benefits', 'mwb-shipping-rates-for-woocommerce' ); ?></h2>
		<div class="mwb-overview__keywords">
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/category-wise.png', 'mwb-shipping-rates-for-woocommerce' ); ?>" alt="Advanced-report image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php esc_html_e( '  Category Wise Shipping ', 'mwb-shipping-rates-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e(
								'Set shipping costs according to product categories. The delivery charges for Product Categories A, B, and C are the same. With the shipping costs for the Shipping category of the products in your cart, you can effortlessly estimate your total shipping cost.',
								'mwb-shipping-rates-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Weight-and-Volume-Wise-Shipping.png', 'mwb-shipping-rates-for-woocommerce' ); ?>" alt="Workflow image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php esc_html_e( ' Weight and Volume-Wise Shipping', 'mwb-shipping-rates-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
						<?php esc_html_e( 'You can easily determine delivery fees depending on the weight and volume of the cart. The use of different shipping costs based on weight and volume slab is a typical occurrence. You can define a delivery charge according to the weight and volume unit outside of the stated range.', 'mwb-shipping-rates-for-woocommerce' ); ?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
					<img src="<?php echo esc_html( MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Price-Range-Wise-Shipping.png', 'mwb-shipping-rates-for-woocommerce' ); ?>" alt="Price Range Wise Shipping">	
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Price Range Wise Shipping ', 'mwb-shipping-rates-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e(
								'The cost of shipping varies depending on the price of the cart range in between the given price.',
								'mwb-shipping-rates-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
					<img src="<?php echo esc_html( MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Conditional-Free-Shipping.png', 'mwb-shipping-rates-for-woocommerce' ); ?>" alt="Conditional Free Shipping">	
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Conditional Free Shipping ', 'mwb-shipping-rates-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e(
								'Configure the conditional rules to allow free shipping on the certain Condition of the cart applied.',
								'mwb-shipping-rates-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
					<img src="<?php echo esc_html( MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Support.png', 'mwb-shipping-rates-for-woocommerce' ); ?>" alt="support">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Support ', 'mwb-shipping-rates-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e(
								'Phone, Email & Skype support. Our Support is ready to assist you regarding any query, issue, or feature request and if that doesn`t help our Technical team will connect with you personally and have your query
							resolved',
								'mwb-shipping-rates-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
