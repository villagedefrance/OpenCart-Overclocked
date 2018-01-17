(function($) {
	$.extend($.tree.plugins, {
		"rtl" : {
			defaults : {
				attribute : "data"
			},
			callbacks : {
				onload : function() {
					this.container.css("direction","rtl").children("ul:eq(0)").removeClass("ltr").addClass("rtl");
				},
				oninit : function() {
					if (!$.tree.plugins.rtl.css) {
						var css = '.tree .rtl li.last { float:right; } #jstree-dragged .rtl { margin:0; padding:0; } #jstree-marker.marker_rtl { width:40px; background-position:right center; } /* RTL modification */ .tree .rtl, .tree .rtl ul { margin:0 10px 0 0; } .tree .rtl li { padding:0 10px 0 0; } .tree .rtl li a, .tree .rtl li span { padding:1px 4px 1px 4px; } .tree > .rtl > li { display:table; } .tree .rtl ins { margin:0 0 0 4px; }';

						if (/msie/.test(u) && !/opera/.test(u)) {
							if (parseInt(v) == 6) css += '#jstree-dragged .rtl { width:20px; } .tree .rtl li.last { margin-top: expression( (this.previousSibling && /open/.test(this.previousSibling.className) ) ? "-2px" : "0"); } .marker_rtl { width:40px; background-position:right center; } ';
							if (parseInt(v) == 7) css += '.tree .rtl li.last { float:none; } #jstree-dragged .rtl { width:200px; }';
						}

						if (/mozilla/.test(u) && !/(compatible|webkit)/.test(u) && v.indexOf("1.8") == 0) {
							css += '.tree .rtl li a { display:inline; float:right; }';
						}

						$.tree.plugins.rtl.css = this.add_sheet({ str : css });
					}
				}
			}
		}
	});
})(jQuery);
