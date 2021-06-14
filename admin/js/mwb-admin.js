(function( $ ) {
	'use strict';
// 	/**
// 	 * All of the code for your admin-facing JavaScript source
// 	 * should reside in this file.
// 	 *
// 	 * Note: It has been assumed you will write jQuery code here, so the
// 	 * $ function reference has been prepared for usage within the scope
// 	 * of this function.
// 	 *
// 	 * This enables you to define handlers, for when the DOM is ready:
// 	 *
// 	 * $(function() {
// 	 *
// 	 * });
// 	 *
// 	 * When the window is loaded:
// 	 *
// 	 * $( window ).load(function() {
// 	 *
// 	 * });
// 	 *
// 	 * ...and/or other possibilities.
// 	 *
// 	 * Ideally, it is not considered best practise to attach more than a
// 	 * single DOM-ready or window-load handler for a particular page.
// 	 * Although scripts in the WordPress core, Plugins and Themes may be
// 	 * practising this, we should strive to set a better example in our own work.
// 	 */
$(document).ready(function () {
  $('#woocommerce_mwb_shipping_rate_free_shipping').on('click',function()
  {
    if($('#woocommerce_mwb_shipping_rate_free_shipping').is(':checked')){
     $(this).parent().parent().parent().parent().nextAll().slideDown();
    }
    else
    {
      $('#woocommerce_mwb_shipping_rate_free_shipping').parent().parent().parent().parent().nextAll().hide();
    }
  });

  if($('.default_check_class').is(':checked')) {
    $.ajax({
      type:'POST',
      dataType: 'text',
      url: srfw_shipping_param.ajaxurl,
  
      data: {
          'action':'shipping_coupon_action',
          'srfw_ajax_nonce':srfw_shipping_param.license_nonce,
      },
    
      success:function( response ) {
        // alert(response);
      }
     
  });
  }

  if($('.default_check_class').not(':checked').length)
  {
     $(document).ready(function () {
      createCookie("default_check", 'false', "1");
    });
    
    function createCookie(name, value, days) {
      var expires;
      if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
      }
      else {
        expires = "";
      }
      document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
    }
  }

  if($('.visibility_class').is(':checked')) {
  //  alert('it is visible');
   $.ajax({
    type:'POST',
    dataType: 'text',
    url: srfw_shipping_param.ajaxurl,

    data: {
        'action':'shipping_visibility',
        'srfw_ajax_nonce':srfw_shipping_param.license_nonce,
    },
  
    success:function( response ) {
      // alert(response);
    }
});
 //  createMyCookie("visibility_check", 'true', "10");
}
  if($('.visibility_class').not(':checked').length)
  {
    createMyCookie("visibility_check", 'false', "10");
  }

  function createMyCookie(name, value, days) {
    var expires;
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toGMTString();
    }
    else {
      expires = "";
    }
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
  }

// alert($('#woocommerce_mwb_shipping_rate_expected_delivery_date').val());
$('#woocommerce_mwb_shipping_rate_expected_delivery_date').on('input', function() {
  var delivery_days =$('#woocommerce_mwb_shipping_rate_expected_delivery_date').val();
  $.ajax({
    type:'POST',
    dataType: 'text',
    url: srfw_shipping_param.ajaxurl,

    data: {
        'action':'expected_date',
        'srfw_ajax_nonce':srfw_shipping_param.license_nonce,
        'expected_days':delivery_days,
    },
  
    success:function( response ) {
      // alert(response);
    }
});
//   var delivery_days =$('#woocommerce_mwb_shipping_rate_expected_delivery_date').val();
// createMyCookie("days", delivery_days, "1"); woocommerce_mwb_shipping_rate_delivery_method_wise
});


$('#woocommerce_mwb_shipping_rate_t1').on('click',function()
{
  if($('#woocommerce_mwb_shipping_rate_t1').is(':checked')){
   $(this).parent().parent().parent().parent().nextAll().slideDown();
  }
  if($('#woocommerce_mwb_shipping_rate_t1').not(':checked').length)
  {
    $('#woocommerce_mwb_shipping_rate_t1').parent().parent().parent().parent().nextAll().hide();
  }
});

$('#woocommerce_mwb_shipping_rate_categories_wise').on('click',function()
{
  var select_button_text = $('#woocommerce_mwb_shipping_rate_categories_wise option:selected')
                .toArray().map(item => item.text).join();

console.log(select_button_text);
$.ajax({
  type:'POST',
  dataType: 'text',
  url: srfw_shipping_param.ajaxurl,

  data: {
      'action':'pinki',
      'srfw_ajax_nonce':srfw_shipping_param.license_nonce,
      'cat':select_button_text,
  },

  success:function( response ) {
    // alert("fiklorelr");
  }
});
})
// var selected=[];
//  $('#woocommerce_mwb_shipping_rate_categories_wise :selected').each(function(){
//      selected[$(this).val()]=$(this).text();
//     });
// console.log(selected);
// $('#woocommerce_mwb_shipping_rate_delivery_method_wise').insertAfter('<h2>POINTER</h2>');



//    if($('#woocommerce_mwb_shipping_rate_free_shipping').is(':checked')) custom_free_shipping_class
//    {
//      alert('nothing to show');
//      $('#woocommerce_mwb_shipping_rate_free_shipping_cond').show();
//    }
//    else{
//     $('#woocommerce_mwb_shipping_rate_free_shipping_cond').hide();
    
//    }

// $('#woocommerce_mwb_shipping_rate_free_shipping_cond').on('change',function()
// 		{
// 			alert('free shipping condition');   
// 		})
	 });
	})( jQuery );   
