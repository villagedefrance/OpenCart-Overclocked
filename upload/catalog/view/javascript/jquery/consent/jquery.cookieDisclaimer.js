/*
 *  jQueryCookieDisclaimer - v1.1.0
 *  "jQuery Cookie Disclaimer Bar"
 *  http://factory.brainleaf.eu/jqueryCookieDisclaimer
 *
 *  Made by BRAINLEAF Communication
 *  Released Under GNU/GPL License
 *  (c)2014-2015 by BRAINLEAF Communication
 *
 *  BugReport/Assistence: https://github.com/Gix075/jqueryCookieDisclaimer/issues
 */

;(function($, window, document, undefined) {
	"use strict";

	var pluginName = "cookieDisclaimer",
            
	defaults = {
		layout: "bar", // bar, modal
		position: "top", // top, middle, bottom
		style: "dark", // dark, light
		title: "Cookie Disclaimer", // this is the modal title (not used on layout "bar")
		text: "To browse this site you need to accept our cookie policy.", // "bar" and "modal" text
		cssPosition: "fixed", // fixed, absolute, relative
		onAccepted: "",
		acceptBtn: {
			text: "I Accept", // accept btn text
			cssClass: "cdbtn cookie", // accept btn class
			cssId: "cookieAcceptBtn", // univocal accept btn ID
			onAfter: "" // callback after accept button click
		},
		policyBtn: {
			active: true, // this option is for activate "cookie policy page button link"
			text: "Read More", // policypage btn text
			link: "#", // cookie policy page URL
			linkTarget: "_blank", // policypage btn link target
			cssClass: "cdbtn privacy", // policypage btn class
			cssId: "policyPageBtn", // univocal policypage btn ID
			onClick: "" // function on click
		},
		cookie: {
			name: "cookieDisclaimer",
			val: "confirmed",
			path: "/",
			expire: 365
		}
	};

	// constructor
	function Plugin(element, options) {
		this.element = element;
		this.settings = $.extend(true, defaults, options);
		this._defaults = defaults;
		this._name = pluginName;
		this.init();
	}

	$.extend(Plugin.prototype, {
		init: function() {
			this.cookieHunter();
			this.cookieKillerButton();
			if (this.settings.policyBtn.onClick != "") {
				this.policyOnClick();
			}
		},

		/* DISCLAIMER BAR */
		makeBarMarkup: function() {
			switch (this.settings.layout) {
				case "bar":
					var barMarkup = '<div id="jQueryCookieDisclaimer" class="cdbar '+this.settings.style+' '+this.settings.position+' '+this.settings.cssPosition+'">';

					barMarkup += '  <div class="cdbar-text">'+this.settings.text+'</div>';
					barMarkup += '  <div class="cdbar-buttons">';
					if (this.settings.policyBtn.active != false) {
					barMarkup += '    <a id="'+this.settings.policyBtn.cssId+'" href="'+this.settings.policyBtn.link+'" class="'+this.settings.policyBtn.cssClass+'" target="'+this.settings.policyBtn.linkTarget+'">'+this.settings.policyBtn.text+'</a>';
					}
					barMarkup += '    <button id="'+this.settings.acceptBtn.cssId+'" class="'+this.settings.acceptBtn.cssClass+' cdbar-cookie-accept">'+this.settings.acceptBtn.text+'</button>';
					barMarkup += '  </div>';
					barMarkup += '</div>';
					break;

				case "modal":
					var barMarkup = '<div id="jQueryCookieDisclaimer" class="cdmodal '+this.settings.style+' '+this.settings.position+'">';

					barMarkup += '  <div class="cdmodal-box">';
					barMarkup += '    <div class="cdmodal-box-inner">';
					barMarkup += '      <div class="cdmodal-text">';
					barMarkup += '        <h3>'+this.settings.title+'</h3>';
					barMarkup += '        <p>'+this.settings.text+'</p>';
					barMarkup += '        </div>';
					barMarkup += '        <div class="cdmodal-buttons">';
					if (this.settings.policyBtn.active != false) {
					barMarkup += '          <a href="'+this.settings.policyBtn.link+'" class="'+this.settings.policyBtn.cssClass+'">'+this.settings.policyBtn.text+'</a>';
					}
					barMarkup += '          <button class="'+this.settings.acceptBtn.cssClass+' cdbar-cookie-accept">'+this.settings.acceptBtn.text+'</button>';
					barMarkup += '        </div>';
					barMarkup += '      </div>';
					barMarkup += '    </div>';
					barMarkup += '  </div>';
					break;
				}

			if (this.settings.position == "bottom") {
				$('body').append(barMarkup); 
			} else {
				$('body').prepend(barMarkup); 
			}

			this.cookieListner();
		},
                
		/* COOKIE EXISTANCE CHECK  */
		cookieHunter: function() {
			if ($.cookie(this.settings.cookie.name) != this.settings.cookie.val) {
				this.makeBarMarkup();
			} else {
				if (this.settings.onAccepted != "") {
					this.settings.onAccepted();
				}
			}
		},
            
		/* ACCEPT COOKIE POLICY BUTTON */
		cookieListner: function() {
			var plugin = this;

			$('.cdbar-cookie-accept').on('click', function(e) {
				e.preventDefault();
				$.cookie(plugin.settings.cookie.name, plugin.settings.cookie.val, { expires: plugin.settings.cookie.expire, path: plugin.settings.cookie.path }); 
				$('#jQueryCookieDisclaimer').fadeOut();
				$('#jQueryCookieDisclaimer').promise().done(function() {
					plugin.settings.acceptBtn.onAfter();
				});
			});
		},
                
		/* POLICY PAGE BUTTON ON CLICK FUNCTION */
		policyOnClick: function() {
			var plugin = this;

			$('#'+plugin.settings.policyBtn.cssId).on('click', function(e) {
				e.preventDefault();
				plugin.settings.policyBtn.onClick();
			});
		},
            
		/* COOKIES LIST */
		cookiesList: function(out, element) {
			var cookiesList = document.cookie.split(';'),
				cookiesListString = document.cookie,
				cookieListOutput = "";
                    
			switch (out) {
				case "array":
					cookieListOutput = cookiesList;
					break;
				case "string":
					cookieListOutput = cookiesListString;
					break;
				case "html":
					cookieListOutput = '<ul class="cd-cookieslist">';
					for (var i = 1; i <= cookiesList.length; i++) {
						cookieListOutput += '<li>' + cookiesList[i-1] + '</li>';
					}
					cookieListOutput += '</ul>'; 
					if (element != undefined && element !="") {
						$(element).html(cookieListOutput);
						return true;
					}
					break;
				default:
					cookieListOutput = cookiesList;                            
					break;
				}

			console.log("cookieList as " + out + " : " + cookieListOutput);
			return cookieListOutput;
		},
            
		/* COOKIE KILLER */
		cookieKiller: function() {
			if ($.cookie(this.settings.cookie.name) != undefined) {
				$.removeCookie(this.settings.cookie.name, { path: this.settings.cookie.path });
				this.cookieHunter();
			} else {
				alert('Sorry, but there are no cookie named ' + this.settings.cookie.name);
			}
		},
                
		/* COOKIE KILLER BUTTON */
		cookieKillerButton: function() {
			var plugin = this;

			$('.cdbar-cookie-kill').on('click', function(e) {
				e.preventDefault();
				plugin.cookieKiller();
			});
		}
	});

	$.fn[ pluginName ] = function(options) {
		return this.each(function() {
			if (!$.data(this, "plugin_" + pluginName)) {
				$.data(this, "plugin_" + pluginName, new Plugin(this, options));
			}
		});
	};

})( jQuery, window, document );