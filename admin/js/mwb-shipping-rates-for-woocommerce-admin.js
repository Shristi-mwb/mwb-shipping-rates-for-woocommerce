(function($) {
  "use strict";

  /**
   * All of the code for your admin-facing JavaScript source
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
  $(document).ready(function() {
    const MDCText = mdc.textField.MDCTextField;
    const textField = [].map.call(
      document.querySelectorAll(".mdc-text-field"),
      function(el) {
        return new MDCText(el);
      }
    );
    const MDCRipple = mdc.ripple.MDCRipple;
    const buttonRipple = [].map.call(
      document.querySelectorAll(".mdc-button"),
      function(el) {
        return new MDCRipple(el);
      }
    );
    const MDCSwitch = mdc.switchControl.MDCSwitch;
    const switchControl = [].map.call(
      document.querySelectorAll(".mdc-switch"),
      function(el) {
        return new MDCSwitch(el);
      }
    );

    $(".mwb-password-hidden").on('click',function() {
      if ($(".mwb-form__password").attr("type") == "text") {
        $(".mwb-form__password").attr("type", "password");
      } else {
        $(".mwb-form__password").attr("type", "text");
      }
    });
  });

  $(window).load(function() {
    // add select2 for multiselect.
    if ($(document).find(".mwb-defaut-multiselect").length > 0) {
      $(document)
        .find(".mwb-defaut-multiselect")
        .select2();
    }
  });
})(jQuery);
// License.
jQuery(document).ready(function($) {
  $("#mwb_msrfw_license_key").on("click", function(e) {
    $("#mwb_msrfw_license_activation_status").html("");
  });

  $("form#mwb_msrfw_license_form").on("submit", function(e) {
    e.preventDefault();

    var license_key = $("#mwb_msrfw_license_key").val();
    mwb_msrfw_send_license_request(license_key);
  });

  function mwb_msrfw_send_license_request(license_key) {
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: msrfw_admin_param.ajaxurl,
      data: {
        action: "mwb_msrfw_validate_license_key",
        purchase_code: license_key,
      },

      success: function(data) {
        if (data.status == true) {
          $("#mwb_msrfw_license_activation_status").css("color", "#42b72a");

          jQuery("#mwb_msrfw_license_activation_status").html(data.msg);

          location = msrfw_admin_param.msrfw_admin_param_location;
        } else {
          $("#mwb_msrfw_license_activation_status").css("color", "#ff3333");

          jQuery("#mwb_msrfw_license_activation_status").html(data.msg);

          jQuery("#mwb_msrfw_license_key").val("");
        }
      },
    });
  }
});
