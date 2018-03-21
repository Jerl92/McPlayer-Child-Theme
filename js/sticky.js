
function stickIt_($) {
  
  $.fn.ready();
	'use strict';
   
    // Create a clone of the site-header, right next to original.
    jQuery('.site-header').addClass('original').clone().insertAfter('.site-header').addClass('cloned').css('position','sticky').css('margin-top','0').css('z-index','500').removeClass('original').hide();

    var scrollIntervalID = setInterval(stickIt, 1);

    function stickIt($) {

      var orgElementPos = jQuery('.original').offset();
      var orgElementTop = 1;
      $wpAdminBar = jQuery("#wpadminbar");
      $windowwidth = jQuery(window).width();
      $wpAdminBarheight = jQuery("#wpadminbar").height();

      if ($windowwidth >= 765) {
        if (jQuery(window).scrollTop() >= (orgElementTop)) {
          // scrolled past the original position; now only show the cloned, sticky element.

          // Cloned element should always have same left position and width as original element.   
          var orgElement = jQuery('.original'),
          coordsOrgElement = orgElement.offset(),
          leftOrgElement = coordsOrgElement.left,
          widthOrgElement = orgElement.css('width');
          if ($wpAdminBar.length) {
            jQuery('.cloned').css('top', $wpAdminBarheight).css('width', '100%').show();
            jQuery('.original').hide();
          } else {
            jQuery('.cloned').css('top', 0).css('width', '100%').show();
            jQuery('.original').hide();
          }
          jQuery('.site-title').css('font-size','1.75rem');
        } else {
          if ($wpAdminBar.length) {
            // not scrolled past the site-header; only show the original site-header.
            jQuery('.cloned').hide();
            jQuery('.original').css('top', $wpAdminBarheight).css('width', '100%').show();
          } else {
            jQuery('.cloned').hide();
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

    var orgElementPos = jQuery('.original').offset();
    var orgElementTop = 1;
    $wpAdminBar = jQuery("#wpadminbar");
    $windowwidth = jQuery(window).width();
    $wpAdminBarheight = jQuery("#wpadminbar").height();

    if ($windowwidth >= 765) {
      if (jQuery(window).scrollTop() >= (orgElementTop)) {
        // scrolled past the original position; now only show the cloned, sticky element.

        // Cloned element should always have same left position and width as original element.   
        var orgElement = jQuery('.original');
        var coordsOrgElement = orgElement.offset();
        var leftOrgElement = coordsOrgElement.left;
        var widthOrgElement = orgElement.css('width');
        if ($wpAdminBar.length) {
          jQuery('.cloned').css('top', $wpAdminBarheight).css('width', '100%').show();
          jQuery('.original').hide();
        } else {
          jQuery('.cloned').css('top', 0).css('width', '100%').show();
          jQuery('.original').hide();
        }
        jQuery('.site-title').css('font-size','1.75rem');
      } else {
        if ($wpAdminBar.length) {
          // not scrolled past the site-header; only show the original site-header.
          jQuery('.cloned').hide();
          jQuery('.original').css('top', $wpAdminBarheight).css('width', '100%').show();
        } else {
          jQuery('.cloned').hide();
          jQuery('.original').css('top', 0).css('width', '100%').show();
        }
        jQuery('.site-title').css('font-size','2rem');
      }
    }
  }

  jQuery(window).resize(function($) {
    stickIt_resize($);
  });