

 
   jQuery(window).scroll(function(){
      $windowwidth = jQuery(window).width();

      if ($windowwidth >= 765) {
        if (jQuery(window).scrollTop() > 0) {
          jQuery('#masthead').addClass('fixed-header-nav');
          jQuery('#content').addClass('fixed-content-nav');
          jQuery('.site-title').css('font-size','1.75rem');
          jQuery('#masthead').css('padding','0');
        }
        else {
          jQuery('#masthead').removeClass('fixed-header-nav');
          jQuery('#content').removeClass('fixed-content-nav');
          jQuery('.site-title').css('font-size','2rem');
          jQuery('#masthead').css('padding','15px 0 15px 0');
        }
      }
    });