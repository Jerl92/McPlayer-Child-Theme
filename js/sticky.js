
function stickIt_($) {
  
  $.fn.ready();
	'use strict';
   
    // Create a clone of the site-header, right next to original.
    $('.site-header').addClass('original').clone().insertAfter('.site-header').addClass('cloned').css('position','sticky').css('margin-top','0').css('z-index','500').removeClass('original').hide();

    scrollIntervalID = setInterval(stickIt, 1);

    function stickIt() {

      var orgElementPos = $('.original').offset();
      orgElementTop = 1;
      $wpAdminBar = $("#wpadminbar");
      $windowwidth = $(window).width();
      $wpAdminBarheight = $("#wpadminbar").height();

      if ($windowwidth >= 765) {
        if ($(window).scrollTop() >= (orgElementTop)) {
          // scrolled past the original position; now only show the cloned, sticky element.

          // Cloned element should always have same left position and width as original element.   
          orgElement = $('.original');
          coordsOrgElement = orgElement.offset();
          leftOrgElement = coordsOrgElement.left;
          widthOrgElement = orgElement.css('width');
          if ($wpAdminBar.length) {
            $('.cloned').css('top', $wpAdminBarheight).css('width', '100%').show();
            $('.original').hide();
          } else {
            $('.cloned').css('top', 0).css('width', '100%').show();
            $('.original').hide();
          }
          $('.site-title').css('font-size','1.75rem');
        } else {
          if ($wpAdminBar.length) {
            // not scrolled past the site-header; only show the original site-header.
            $('.cloned').hide();
            $('.original').css('top', $wpAdminBarheight).css('width', '100%').show();
          } else {
            $('.cloned').hide();
            $('.original').css('top', 0).css('width', '100%').show();
          }
          $('.site-title').css('font-size','2rem');
        }
      }
    }
  }

  jQuery(document).ready(function($) {
    stickIt_($);
  });

  jQuery(window).resize(function($) {
    stickIt_($);
  });
