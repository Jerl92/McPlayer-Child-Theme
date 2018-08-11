
function stickIt_($) {
  
  $.fn.ready();
	'use strict';
   
    // Create a clone of the site-header, right next to original.
    jQuery('.site-header').addClass('original').clone().insertAfter('.site-header').addClass('cloned').css('position','fixed').css('margin-top','0').css('z-index','500').removeClass('original').hide();

    setInterval(stickIt, 1);

    function stickIt($) {

      $wpAdminBar = jQuery("#wpadminbar");
      $windowwidth = jQuery(window).width();
      $wpAdminBarheight = jQuery("#wpadminbar").height();

      if ($windowwidth >= 765) {
        if (jQuery(window).scrollTop() > 0) {
          // scrolled past the original position; now only show the cloned, sticky element.

          // Cloned element should always have same left position and width as original element.   
          if ($wpAdminBar.length) {
            jQuery('.cloned').css('top', $wpAdminBarheight).css('width', '100%').show();
            jQuery('.site-content').css('padding-top', '92px');
            jQuery('.original').hide();
          } else {
            jQuery('.cloned').css('top', 0).css('width', '100%').show();
            jQuery('.site-content').css('padding-top', '92px');
            jQuery('.original').hide();
          }
          jQuery('.site-title').css('font-size','1.75rem');
        } else {
          if ($wpAdminBar.length) {
            // not scrolled past the site-header; only show the original site-header.
            jQuery('.cloned').hide();
            jQuery('.site-content').css('padding-top', 0);
            jQuery('.original').css('top', $wpAdminBarheight).css('width', '100%').show();
          } else {
            jQuery('.cloned').hide();
            jQuery('.site-content').css('padding-top', 0);
            jQuery('.original').css('top', 0).css('width', '100%').show();
          }
          jQuery('.site-title').css('font-size','2rem');
        }
      }
    }
  }

  jQuery(document).ready(function($) {
    stickIt_($);
  });

  
  function stickIt_resize($) {

    $wpAdminBar = jQuery("#wpadminbar");
    $windowwidth = jQuery(window).width();
    $wpAdminBarheight = jQuery("#wpadminbar").height();

    if ($windowwidth >= 765) {
      if (jQuery(window).scrollTop() > 0) {
        // scrolled past the original position; now only show the cloned, sticky element.

        // Cloned element should always have same left position and width as original element.   
        if ($wpAdminBar.length) {
          jQuery('.cloned').css('top', $wpAdminBarheight).css('width', '100%').show();
          jQuery('.site-content').css('padding-top', '92px');
          jQuery('.original').hide();
        } else {
          jQuery('.cloned').css('top', 0).css('width', '100%').show();
          jQuery('.site-content').css('padding-top', '92px');
          jQuery('.original').hide();
        }
        jQuery('.site-title').css('font-size','1.75rem');
      } else {
        if ($wpAdminBar.length) {
          // not scrolled past the site-header; only show the original site-header.
          jQuery('.cloned').hide();
          jQuery('.site-content').css('padding-top', 0);
          jQuery('.original').css('top', $wpAdminBarheight).css('width', '100%').show();
        } else {
          jQuery('.cloned').hide();
          jQuery('.site-content').css('padding-top', 0);
          jQuery('.original').css('top', 0).css('width', '100%').show();
        }
        jQuery('.site-title').css('font-size','2rem');
      }
    }
  }

  jQuery(window).resize(function($) {
    stickIt_resize($);
  });