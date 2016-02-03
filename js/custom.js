$(document).ready(function() {
  "use strict";

  $(document).on('click',function(){
    $('.collapse').collapse('hide');
  })

  jQuery("#form").submit(function() {
    var str = jQuery(this).serialize();                  
    jQuery.ajax({
  
      type: "POST",
      url: "php/sendmail.php",
      data: str,
      success: function(msg){
        var result;
        if(msg === "OK"){
          result = "<div class='alert-success'>Your message has been successfully sent! Thank you!</div>";
          var yPos = jQuery("#form").offset().top;
          yPos=yPos-100;
          jQuery("#form").animate({ height: '0px' }, 1000, function() {
              jQuery(this).hide();
          });
        }
        else {
          result = msg;
        }
        jQuery('.submit_note').html(result);
      }                    
    });                  
    return false;
  });
  
});

var onloadCallback = function() {
  grecaptcha.render('recaptcha-widget', {
    'sitekey' : '6LcyRxcTAAAAAMbov7A8BD5V9zsTqtzIY_NATANn',
    'theme' : 'light',
    'size' : 'normal'
  });
};
      