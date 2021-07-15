//JS for MWB Shipping Rates For Woocoommerce
(function( $ ) {
	'use strict';


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
      $( ".woocommerce-save-button" ).trigger( "click" );
     }
     
    if($('#woocommerce_mwb_shipping_rate_free_shipping').not(':checked').length)
  {}
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
    $( ".woocommerce-save-button" ).trigger( "click" );
  }
  if($('#woocommerce_mwb_shipping_rate_t1').not(':checked').length)
  {}
});

$('#woocommerce_mwb_shipping_rate_categories_wise').on('click',function()
{
  var select_button_text = $('#woocommerce_mwb_shipping_rate_categories_wise option:selected')
                .toArray().map(item => item.text).join();
            
$.ajax({
  type:'POST',
  dataType: 'text',
  url: msrfw_shipping_param.ajaxurl,

  data: {
      'action':'product_categories',
      'msrfw_ajax_nonce':msrfw_shipping_param.shipping_nonce,
      'cat':select_button_text,
  },

  success:function( response ) {
  }
});
})

$(".mwb_stop_text").on('keypress',function (e) {
  var regex = new RegExp("^[0-9.]+$");
  var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
  if (!regex.test(key)) {
     e.preventDefault();
     return false;
  }
});
//////////////Range Select condition////////////////
$( ".woocommerce-save-button" ).on( "click", function (){
if($('#woocommerce_mwb_shipping_rate_max_weight_wise').val() && $('#woocommerce_mwb_shipping_rate_min_weight_wise').val()){
  if($('#woocommerce_mwb_shipping_rate_range').not(':checked')){
    $('#woocommerce_mwb_shipping_rate_range').prop('required',true);
  }
  else{
    $('#woocommerce_mwb_shipping_rate_range').prop('required',false);
  }
}
else{
  $('#woocommerce_mwb_shipping_rate_range').prop('required',false);
}

if($('#woocommerce_mwb_shipping_rate_max_price').val() && $('#woocommerce_mwb_shipping_rate_min_price').val()){
  
  if($('#woocommerce_mwb_shipping_rate_range_price').not(':checked')){
    $('#woocommerce_mwb_shipping_rate_range_price').prop('required',true);
  }
  else{
    $('#woocommerce_mwb_shipping_rate_range_price').prop('required',false);
  }
}
else{
  $('#woocommerce_mwb_shipping_rate_range_price').prop('required',false);
}

if($('#woocommerce_mwb_shipping_rate_max_volume_wise').val() && $('#woocommerce_mwb_shipping_rate_min_volume_wise').val()){
  
  if($('#woocommerce_mwb_shipping_rate_range_volume').not(':checked')){
    $('#woocommerce_mwb_shipping_rate_range_volume').prop('required',true);
  }
  else{
    $('#woocommerce_mwb_shipping_rate_range_volume').prop('required',false);
  }
}
else{
  $('#woocommerce_mwb_shipping_rate_range_volume').prop('required',false);
}

});
$('.is-dismissible').fadeOut(1500);
	 });
	})( jQuery );   
