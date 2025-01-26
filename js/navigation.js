/* global chichiScreenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

function scrolltosecondary($) {   
	jQuery(".playlistscroll").click(function() {
		$('html, body').animate({
			scrollTop: $("#secondary").offset().top
		}, 500);
	});
}

jQuery(document).ready(function($) {
	scrolltosecondary($);
});