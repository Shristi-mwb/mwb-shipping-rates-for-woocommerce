//code for datatable

// jQuery(document).ready(function() {
//     console.log('you entered');
//     jQuery('#msrfw-datatable').DataTable({
//         stateSave: true,
//         dom: '<"mwb-dt-buttons"fB>tr<"bottom"lip>',
//         "ordering": true, // enable ordering
   
        
//         buttons: [
//             'copyHtml5',
//             'excelHtml5',
//             'csvHtml5',
//         ],
//         language: {
//             "lengthMenu": 'Rows per page _MENU_',

//             paginate: { next: '<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.99984 0L0.589844 1.41L5.16984 6L0.589844 10.59L1.99984 12L7.99984 6L1.99984 0Z" fill="#8E908F"/></svg>', previous: '<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.00016 12L7.41016 10.59L2.83016 6L7.41016 1.41L6.00016 -1.23266e-07L0.000156927 6L6.00016 12Z" fill="#8E908F"/></svg>' }
//         },
//     });
// });

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
