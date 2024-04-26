

 
   jQuery(window).scroll(function(){
      $windowwidth = jQuery(window).width();
      var header = jQuery("#wpadminbar").height();

      if(header){
        if ($windowwidth >= 720) {
          if (jQuery(window).scrollTop() > 0) {
            jQuery('#masthead').css('top', '-135px');
          } else {
            jQuery('#masthead').css('top', '0px');
          }
        }
      }
      if ($windowwidth >= 720) {
        if (jQuery(window).scrollTop() > 0  ) {
          jQuery('#masthead').addClass('fixed-header-nav');
          jQuery('#content').addClass('fixed-content-nav');
          jQuery('.site-title').css('font-size','1.75rem');
          jQuery('#masthead').css('padding','0');
        } else {
          jQuery('#masthead').removeClass('fixed-header-nav');
          jQuery('#content').removeClass('fixed-content-nav');
          jQuery('.site-title').css('font-size','2rem');
          jQuery('#masthead').css('padding','15px 0 15px 0');
        }
      }
    });

    jQuery(window).on('orientationchange resize', function (event) {
      jQuery('#masthead').removeClass('fixed-header-nav');
      jQuery('#content').removeClass('fixed-content-nav');
      jQuery('.site-title').css('font-size','2rem');
      jQuery('#masthead').css('padding','15px 0 15px 0');
    });
  
function topmenucontainer($){
  $windowwidth = jQuery(window).width();
  if ($windowwidth >= 720) {
    jQuery('.top-navigation').css('width', 'auto');
    jQuery('#top-menu-container').css('width', 'auto');
    jQuery('#top-menu-container').css('float', 'right');
  } else {
    $topmenuwidth = jQuery('#top-menu').width();
    jQuery('#top-menu-container').css('width', $topmenuwidth+15);
    jQuery('#top-menu-container').css('float', 'right');
  }
}

jQuery(document).ready(function($) {
  topmenucontainer($);
});


jQuery( window ).on( "resize", function() {
  $windowwidth = jQuery(window).width();
  if ($windowwidth >= 720) {
    jQuery('.top-navigation').css('width', 'auto');
    jQuery('#top-menu-container').css('width', 'auto');
    jQuery('#top-menu-container').css('float', 'right');
    
  } else {
    $topmenuwidth = jQuery('#top-menu').width();
    jQuery('#top-menu-container').css('width', $topmenuwidth+15);
    jQuery('#top-menu-container').css('float', 'right');
  }
} );