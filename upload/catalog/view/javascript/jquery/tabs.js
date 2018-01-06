/*
 tabs.js v1.0.2 | @villagedefrance | Overclocked Edition | GNU GPL3 Licensed
 ---------------------------------------------------------------------------
 Tabs.js file for development. Use minified version for production.
 ---------------------------------------------------------------------------
*/
;(function($) {
$.fn.tabs = function() {
	var selector = this;
	this.each(function() {
		var obj = $(this);
		$(obj.attr('href')).hide();
		$(obj).click(function() {
			$(selector).removeClass('selected');
			$(selector).each(function(i, element) {
				$($(element).attr('href')).hide();
			});
			$(this).addClass('selected');
			$($(this).attr('href')).show();
			return false;
		});
	});
	$(this).show();
	$(this).first().click();
};
})(jQuery);
