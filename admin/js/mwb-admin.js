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
      $('#woocommerce_mwb_shipping_rate_free_shipping').parent().parent().parent().parent().next().hide();
      $('#woocommerce_mwb_shipping_rate_free_shipping').parent().parent().parent().parent().next().next().hide();
      $('#woocommerce_mwb_shipping_rate_free_shipping').parent().parent().parent().parent().next().next().next().hide();
      $('#woocommerce_mwb_shipping_rate_free_shipping').parent().parent().parent().parent().next().next().next().next().hide();
      
    }
  });


  $('#woocommerce_mwb_shipping_rate_free_shipping').on('change',function()
  {
    if($('#woocommerce_mwb_shipping_rate_free_shipping').is(':checked')){
      $.ajax({
        type:'POST',
        dataType: 'text',
        url: srfw_shipping_param.ajaxurl,
      
        data: {
            'action':'show_free_shipping_field',
            'srfw_ajax_nonce':srfw_shipping_param.shipping_nonce,
            'show_free_shipping':'yes',
        },
        success:function( response ) {
        $( ".woocommerce-save-button" ).trigger( "click" );
        }
    });
     }
    if($('#woocommerce_mwb_shipping_rate_free_shipping').not(':checked').length)
  {
    $.ajax({
      type:'POST',
      dataType: 'text',
      url: srfw_shipping_param.ajaxurl,
  
      data: {
          'action':'hide_free_shipping_field',
          'srfw_ajax_nonce':srfw_shipping_param.shipping_nonce,
          'hide_free_shipping':'no',
      },
    
      success:function( response ) {
      }
  });
  }
  });

  if($('.default_check_class').is(':checked')) {
    $.ajax({
      type:'POST',
      dataType: 'text',
      url: srfw_shipping_param.ajaxurl,
  
      data: {
          'action':'shipping_coupon_action',
          'srfw_ajax_nonce':srfw_shipping_param.shipping_nonce,
      },
    
      success:function( response ) {
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
   $.ajax({
    type:'POST',
    dataType: 'text',
    url: srfw_shipping_param.ajaxurl,

    data: {
        'action':'shipping_visibility',
        'srfw_ajax_nonce':srfw_shipping_param.shipping_nonce,
    },
  
    success:function( response ) {
    }
});
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


$('#woocommerce_mwb_shipping_rate_expected_delivery_date').on('input', function() {
  var delivery_days =$('#woocommerce_mwb_shipping_rate_expected_delivery_date').val();
  $.ajax({
    type:'POST',
    dataType: 'text',
    url: srfw_shipping_param.ajaxurl,

    data: {
        'action':'expected_date',
        'srfw_ajax_nonce':srfw_shipping_param.shipping_nonce,
        'expected_days':delivery_days,
    },
  
    success:function( response ) {
    }
});
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


$('#woocommerce_mwb_shipping_rate_t1').on('change',function()
{
  if($('#woocommerce_mwb_shipping_rate_t1').is(':checked')){
    $.ajax({
      type:'POST',
      dataType: 'text',
      url: srfw_shipping_param.ajaxurl,
  
      data: {
          'action':'show_advance_shipping_field',
          'srfw_ajax_nonce':srfw_shipping_param.shipping_nonce,
          'show':'yes',
      },
    
      success:function( response ) {
        // alert(response);
        $( ".woocommerce-save-button" ).trigger( "click" );
      }
  });
  }
  if($('#woocommerce_mwb_shipping_rate_t1').not(':checked').length)
  {
    $.ajax({
      type:'POST',
      dataType: 'text',
      url: srfw_shipping_param.ajaxurl,
  
      data: {
          'action':'hide_advance_shipping_field',
          'srfw_ajax_nonce':srfw_shipping_param.shipping_nonce,
          'hide':'no',
      },
    
      success:function( response ) {

      }
  });
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
      'action':'product_categories',
      'srfw_ajax_nonce':srfw_shipping_param.shipping_nonce,
      'cat':select_button_text,
  },

  success:function( response ) {
  }
});
})

$(".mwb_stop_text").on('keypress',function (e) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
  if (!regex.test(key)) {
     e.preventDefault();
     return false;
  }
});
	 });
	})( jQuery );   
