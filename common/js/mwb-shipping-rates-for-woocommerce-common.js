(function( $ ) {
	'use strict';

	/**
	 * All of the code for your common JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 $(function() {
		$( document.body ).on( 'updated_cart_totals', function(){
			jQuery(".button-primary woocommerce-save-button").trigger("click");
		});
		if('1' == msrfw_common_param.mwb_cart_page) 
		{
			window.onload = function() {
				if(!window.location.hash) {
					window.location = window.location + '#loaded';
					window.location.reload();
				}
			}
		}
	});
})( jQuery );
