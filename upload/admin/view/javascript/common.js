/*
 Common v1.0.4 | @villagedefrance | Overclocked Edition | GNU GPL3 Licensed
 ---------------------------------------------------------------------------
 Common.js file for development. Use minified version for production.
 ---------------------------------------------------------------------------
*/
function getURLVar(key) {
	var value = [];
	var query = String(document.location).split('?');
	if (query[1]) {
		var part = query[1].split('&');
		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

// Save and Continue
function apply() {
	$('#form').append('<input type="hidden" id="apply" name="apply" value="1" />');
	$('#form').submit();
}

// Success and Tooltip Remove
$(document).ready(function() {
	$('body').on('click', '.success', function() {
		$(this).fadeOut('slow');
	});
	$('body').on('click', '.tooltip', function() {
		$(this).fadeOut('slow');
	});
});
