/**
 * jQuery printPage Plugin
 * version: 1.1
 * author: Cedric Dugas, http://www.position-absolute.com
 * licence: MIT
 *
 * Overclocked Edition © 2018 | Villagedefrance
 */

;(function($) {
	$.fn.printPage = function(options) {
	var pluginOptions = {
		url: false,
		attr: "href",
		message: "Please wait ..." 
    };

	$.extend(pluginOptions, options);

	this.on("click", function() {
		loadPrintDocument(this, pluginOptions);
		return false;
	});
	/**
	* Load & show message box, call iframe
	* param {jQuery} el - The button calling the plugin
	* param {Object} pluginOptions - options for this print button
	*/   
	function loadPrintDocument(el, pluginOptions) {
		$("body").append(components.messageBox(pluginOptions.message));
		$("#printMessageBox").css("opacity", 0);
		$("#printMessageBox").animate({opacity:1}, 300, function() { addIframeToPage(el, pluginOptions); });
	}
	/**
	* Inject iframe into document and attempt to hide, it, can't use display:none
	* You can't print if the element is not displayed
	* param {jQuery} el - The button calling the plugin
	* param {Object} pluginOptions - options for this print button
	*/
	function addIframeToPage(el, pluginOptions) {
		var url = (pluginOptions.url) ? pluginOptions.url : $(el).attr(pluginOptions.attr);

		if (!$('#printPage')[0]) {
			$("body").append(components.iframe(url));
			$('#printPage').on("load", function() {
				printIt();
			})
		} else {
			$('#printPage').attr("src", url);
		}
	}
	/*
	* Call the print browser functionality, focus is needed for IE
	*/
	function printIt() {
		frames["printPage"].focus();
		frames["printPage"].print();
		unloadMessage();
	}
	/*
	* Hide & Delete the message box with a small delay
	*/
	function unloadMessage() {
		$("#printMessageBox").delay(1000).animate({opacity:0}, 700, function() {
			$(this).remove();
		});
	}
	/*
	* Build html components
	*/
	var components = {
		iframe: function(url) {
			return '<iframe id="printPage" name="printPage" src=' + url + ' style="position:absolute; top:0; left:0; width:0; height:0; border:0; overflow:none; z-index:-1;"></iframe>';
		},
		messageBox: function(message) {
			return "<div id='printMessageBox' style='\
				position:fixed;\
				top:50%; left:50%;\
				text-align:center; line-height:90px;\
				margin:-50px 0 0 -155px;\
				width:310px; height:100px; font-size:16px; padding:10px; color:#333; font-family:Arial, Helvetica, sans-serif;\
				opacity:0;\
				background:#FFF;\
				border:2px solid #777;\
				border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px; -khtml-border-radius: 5px;\
				box-shadow:0px 0px 5px #999; -webkit-box-shadow:0px 0px 5px #999; -moz-box-shadow:0px 0px 5px #999;'>\
				" + message + "</div>";
			}
		}
	};
})(jQuery);
