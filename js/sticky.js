

 
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


    jQuery(document).ready(function() {
      var windowHeight = jQuery(window).height();
      var documentHeight = jQuery(document).height();
      var windowwidth = jQuery(document).width();
      var sidebar = jQuery('#secondary').height();
      var primary = jQuery('#primary').height();

      if (windowwidth > 720) {
        jQuery('#secondary').css('overflow', 'scroll');
        if (primary < sidebar) {
          jQuery(document).height(primary);
        } else {
          jQuery(document).height(sidebar);
        }
      }
    });

    jQuery(window).resize(function() {
      var windowHeight = jQuery(window).height();
      var documentHeight = jQuery(document).height();
      var windowwidth = jQuery(document).width();
      var sidebar = jQuery('#secondary').height();
      var primary = jQuery('#primary').height();

      if (windowwidth > 720) {
        if (primary < sidebar) {
          jQuery('#secondary').css('overflow', 'scroll');
          jQuery(document).height(primary);
        } else {
          jQuery(document).height(sidebar);
        }
      }
    });