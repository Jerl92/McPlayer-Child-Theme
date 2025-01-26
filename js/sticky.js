

function topmenu($){
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
    var masthead = jQuery("#masthead").height();
    jQuery('#content').css('padding-top', masthead+'px');
    jQuery('#masthead').css('position', 'fixed');
    if (jQuery(window).scrollTop() > 0  ) {
      jQuery('#masthead').addClass('fixed-header-nav');
      jQuery('#masthead').css('padding','0');
    } 
    if (jQuery(window).scrollTop() == 0  ) {
      jQuery('#masthead').removeClass('fixed-header-nav');
      jQuery('#masthead').css('padding','15px 0 15px 0');
    }

    if($(document).scrollTop() > 0) {
      $('.site-title').stop().animate({
          fontSize:'1.5rem',
      },400);
      $('.main-navigation').stop().animate({
        paddingTop: '0px'
    },400);
    } else {
      $('.site-title').stop().animate({
        fontSize:'2rem',
      },400);
      $('.main-navigation').stop().animate({
        paddingTop: '4px'
      },400);
    }
  } else {
    jQuery('#masthead').css('position', 'static');
  }
}
   
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
        var masthead = jQuery("#masthead").height();
        jQuery('#content').css('padding-top', masthead+'px');
        jQuery('#masthead').css('position', 'fixed');
        if (jQuery(window).scrollTop() > 0  ) {
          jQuery('#masthead').addClass('fixed-header-nav');
          jQuery('#masthead').css('padding','0');
        } 
        if (jQuery(window).scrollTop() == 0  ) {
          jQuery('#masthead').removeClass('fixed-header-nav');
          jQuery('#masthead').css('padding','15px 0 15px 0');
        }

        if($(document).scrollTop() > 0) {
          $('.site-title').stop().animate({
              fontSize:'1.5rem',
          },400);
          $('.main-navigation').stop().animate({
            paddingTop: '0px'
        },400);
        } else {
          $('.site-title').stop().animate({
            fontSize:'2rem',
          },400);
          $('.main-navigation').stop().animate({
            paddingTop: '4px'
          },400);
        }
      } else {
        jQuery('#masthead').css('position', 'static');
      }
    });

    jQuery(window).on('orientationchange resize', function (event) {
      jQuery('#masthead').removeClass('fixed-header-nav');
      jQuery('#content').removeClass('fixed-content-nav');
      jQuery('.site-title').css('font-size','2rem');
      jQuery('#masthead').css('padding','15px 0 15px 0');
      $windowwidth = jQuery(window).width();
      if ($windowwidth >= 720) {
        var masthead = jQuery("#masthead").height();
        jQuery('#content').css('padding-top', masthead+'px');
        jQuery('#masthead').css('position', 'fixed');
      } else {
        jQuery('#content').css('padding-top', '0px');
        jQuery('#masthead').css('position', 'static');
      }
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
  topmenu($);
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