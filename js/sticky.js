
function stickIt_($) {
  
  $.fn.ready();
	'use strict';
   
    // Create a clone of the site-header, right next to original.
    $('.site-header').addClass('original').clone().insertAfter('.site-header').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','500').removeClass('original').hide();

    scrollIntervalID = setInterval(stickIt, 1);


    function stickIt() {

      var orgElementPos = $('.original').offset();
      orgElementTop = 1;               
      $wpAdminBar = $('#wpadminbar');
      $windowwidth = $(window).width();

      if ($windowwidth >= 450) {
        if ($(window).scrollTop() >= (orgElementTop)) {
          // scrolled past the original position; now only show the cloned, sticky element.

          // Cloned element should always have same left position and width as original element.     
          orgElement = $('.original');
          coordsOrgElement = orgElement.offset();
          leftOrgElement = coordsOrgElement.left;  
          widthOrgElement = orgElement.css('width');
          if ($wpAdminBar.length) {
            $('.cloned').css('left',leftOrgElement+'px').css('top',32).css('width',widthOrgElement).show();
            $('.original').css('visibility','hidden');
          } else {
            $('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
            $('.original').css('visibility','hidden');
          }
          $('.site-title').css('font-size','1.75rem');
        } else {
          // not scrolled past the site-header; only show the original site-header.
          $('.cloned').hide();
          $('.original').css('visibility','visible');
          $('.site-title').css('font-size','2rem');
        }
      }
    }
  }

  jQuery(document).ready(function($) {
    stickIt_($);
  });