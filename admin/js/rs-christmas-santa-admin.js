(function( $ ) {
	'use strict';
 
	jQuery(document).ready(function() {


	// pop up santa
	 // Initial check: if any radio button is checked on page load, add the highlight class to its parent
	jQuery('#rs_popup-display-chirsmas label input[type=radio]').each(function() {
	    if (jQuery(this).is(':checked')) {
	        jQuery(this).parent().parent().parent().addClass('highlight');
	    }
	});

	// Event listener for change
	jQuery('#rs_popup-display-chirsmas label input[type=radio]').change(function() {
	    // Remove the highlight class from all parent label elements
	    jQuery('#rs_popup-display-chirsmas .rs_popup-display').removeClass('highlight');

	    // If this radio button is checked, add the highlight class to its parent label
	    if (jQuery(this).is(':checked')) {
	        jQuery(this).parent().parent().parent().addClass('highlight');
	    }
	});

	// countdown santa
	 // Initial check: if any radio button is checked on page load, add the highlight class to its parent
	jQuery('#rs_christmas_santa_countdown_type label input[type=radio]').each(function() {
	    if (jQuery(this).is(':checked')) {
	        jQuery(this).parent().parent().parent().addClass('highlight');
	    }
	});

	// Event listener for change
	jQuery('#rs_christmas_santa_countdown_type label input[type=radio]').change(function() {
	    // Remove the highlight class from all parent label elements
	    jQuery('#rs_christmas_santa_countdown_type .rs_popup-display').removeClass('highlight');

	    // If this radio button is checked, add the highlight class to its parent label
	    if (jQuery(this).is(':checked')) {
	        jQuery(this).parent().parent().parent().addClass('highlight');
	    }
	});


	});

  })( jQuery );

