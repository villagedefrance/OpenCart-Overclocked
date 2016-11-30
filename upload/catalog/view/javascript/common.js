$(document).ready(function() {
	// Standard Search
	$('.button-search').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
		var search = $('input[name=\'search\']').attr('value');
		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}
		location = url;
	});

	$('#header input[name=\'search\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			var search = $('input[name=\'search\']').attr('value');
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			location = url;
		}
	});

	// Ajax Cart
	$('#cart > .heading a').live('click', function() {
		$('#cart').addClass('active');
		$('#cart').load('index.php?route=module/cart #cart > *');
		$('#cart').live('mouseleave', function() {
			$(this).removeClass('active');
		});
	});

	// Mega Menu
	$('#menu > ul > li').hover(
		function() {
			$(this).addClass("active");
			$(this).find('div').stop(false, true).slideDown({
				duration: 300,
				easing: "easeOutExpo"
			});
		},
		function() {
			$(this).removeClass("active");
			$(this).find('div').stop(false, true).slideUp({
				duration: 100,
				easing: "easeOutExpo"
			});
		}
	);

	$('#menu ul > li > a + div').each(function(index, element) {
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();
		i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());
		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});

	// IE10 Fixes
	if ($.browser.msie && $.browser.version == 10) {
		$('#menu > ul > li').bind('mouseover', function() {
			$(this).addClass('active');
		});
		$('#menu > ul > li').bind('mouseout', function() {
			$(this).removeClass('active');
		});
	}

	$('.success img, .warning img, .attention img, .tooltip img').live('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});
});

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

// Ajax Search
function doLiveSearch(ev, keywords) {
	if (ev.keyCode == 38 || ev.keyCode == 40) {
		return false;
	}

	$('#livesearch').remove();
	updown = -1;

	if (keywords == '' || keywords.length < 3) {
		return false;
	}

	keywords = encodeURI(keywords);

	$.ajax({
		url: $('#hidden').attr('href') + 'index.php?route=product/search/livesearch&keyword=' + keywords,
		dataType: 'json',
		content: this,
		success: function(result) {
			if (result.length > 0) {
				var eList = document.createElement('ul');
				var eListElem;
				var eListImage;
				var eLink;

				eList.id = 'livesearch';

				for (var i in result) {
					eListElem = document.createElement('li');
					eLink = document.createElement('a');
					$(function() {
						eListImage = document.createElement('img');
						$(eListImage).load(function() {
							$(this).show();
						})

						eListImage.src=result[i].image;
						eLink.appendChild(eListImage);
					});

					eLink.appendChild(document.createTextNode(result[i].name));

					if (typeof(result[i].href) != 'undefined') {
						eLink.href = result[i].href;
					} else {
						eLink.href = $('#hidden').attr('href') + 'index.php?route=product/product&product_id=' + result[i].product_id;
					}

					eListElem.appendChild(eLink);
					eList.appendChild(eListElem);
				}

				if ($('#livesearch').length > 0) {
					$('#livesearch').remove();
				}

				$('#search').append(eList);
			}
		}
	});

	return true;
}

function upDownEvent(ev) {
	var elem = document.getElementById('livesearch');

	if (elem) {
		var length = elem.childNodes.length - 1;

		if (updown != -1 && typeof(elem.childNodes[updown]) != 'undefined') {
			$(elem.childNodes[updown]).removeClass('highlighted');
		}

		if (ev.keyCode == 38) {
			updown = (updown > 0) ? --updown : updown;
		} else if (ev.keyCode == 40) {
			updown = (updown < length) ? ++updown : updown;
		}

		if (updown >= 0 && updown <= length) {
			$(elem.childNodes[updown]).addClass('highlighted');

			var text = elem.childNodes[updown].childNodes[0].text;

			if (typeof(text) == 'undefined') {
				text = elem.childNodes[updown].childNodes[0].innerText;
			}

			$('#search').find('[name=\'search\']').first().val(new String(text).replace(/(\s\(.*?\))$/, ''));
		}
	}

	return false;
}

var updown = -1;

$(document).ready(function() {
	$('#search').find('[name=\'search\']').first().keyup(function(ev) {
		doLiveSearch(ev, this.value);
	}).focus(function(ev) {
		doLiveSearch(ev, this.value);
	}).keydown(function(ev) {
		upDownEvent(ev);
	}).blur(function() {
		window.setTimeout("$('#livesearch').slideUp(400); updown=0;", 400);
	});

	$(document).bind('keydown', function(ev) {
		try {
			if (ev.keyCode == 13 && $('.highlighted').length > 0) {
				document.location.href = $('.highlighted').find('a').first().attr('href');
			}
		}
		catch(e) {}
	});
});

// Product Quantity +/-
function addProductCount() {
	var q = parseInt($('#quantity').val());
	if (q > 0) {
		$('#quantity').val(q + 1);
	}
	return false;
}

function subProductCount() {
	var q = parseInt($('#quantity').val());
	if (q > 1) {
		$('#quantity').val(q - 1);
	}
	return false;
}

// Go to Reviews
function goToReviews(product_id) {
	$('a[href=\'#tab-review\']').trigger('click');
	$('html, body').animate({
		scrollTop: $('#tabs').position().top -= 30
	}, 'slow');
	return false;
}

// Add to Cart / Wishlist / Compare
function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .tooltip, .error').remove();
			if (json['redirect']) {
				location = json['redirect'];
			}
			if (json['success']) {
				$('#notification').html('<div class="success" style="display:none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				$('.success').fadeIn('slow');
				$('#cart-total').html(json['total']);
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		}
	});
}

function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .tooltip').remove();
			if (json['success']) {
				$('#notification').html('<div class="success" style="display:none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				$('.success').fadeIn('slow');
				$('#wishlist-total').html(json['total']);
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		}
	});
}

function addToCompare(product_id) {
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .tooltip').remove();
			if (json['success']) {
				$('#notification').html('<div class="success" style="display:none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				$('.success').fadeIn('slow');
				$('#compare-total').html(json['total']);
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		}
	});
}

// Success Remove Onclick
$(document).ready(function() {
	$('.success').live('click', function() {
		$(this).fadeOut('slow');
	});
});

// Prevent Right Click
document.onselectstart = new Function('return false');
document.oncontextmenu = new Function('return false');

$('img').mousedown(function() {
	return false;
});
