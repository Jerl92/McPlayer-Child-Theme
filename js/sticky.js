

 
   jQuery(window).scroll(function(){
      $windowwidth = jQuery(window).width();
      var header = $("#wpadminbar").height();

      if(header){
        if ($windowwidth >= 765) {
          if (jQuery(window).scrollTop() > 0) {
            jQuery('#masthead').css('top', '-135px');
          } else {
            jQuery('#masthead').css('top', '0px');
          }
        }
      }
      if ($windowwidth >= 765) {
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
  
function topmenucontainer($){
  $windowwidth = jQuery(window).width();
  if ($windowwidth >= 765) {
    jQuery('.top-navigation').css('width', 'auto');
    jQuery('#top-menu-container').css('width', 'auto');
    jQuery('#top-menu-container').css('float', 'right');
  } else {
    jQuery('.top-navigation').css('width', '75%');
    $topmenuwidth = jQuery('#top-menu').width();
    jQuery('#top-menu-container').css('width', $topmenuwidth);
    jQuery('#top-menu-container').css('float', 'right');
  }
}

jQuery(document).ready(function($) {
  topmenucontainer($);
});


$( window ).on( "resize", function() {
  $windowwidth = jQuery(window).width();
  if ($windowwidth >= 765) {
    jQuery('.top-navigation').css('width', 'auto');
    jQuery('#top-menu-container').css('width', 'auto');
    jQuery('#top-menu-container').css('float', 'right');
  } else {
    jQuery('.top-navigation').css('width', '75%');
    $topmenuwidth = jQuery('#top-menu').width();
    jQuery('#top-menu-container').css('width', $topmenuwidth);
    jQuery('#top-menu-container').css('float', 'right');
  }
} );