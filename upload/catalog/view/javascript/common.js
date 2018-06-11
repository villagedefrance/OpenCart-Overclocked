/*
 Common v1.0.4 | @villagedefrance | Overclocked Edition | GNU GPL3 Licensed
 ---------------------------------------------------------------------------
 Common.js file for development. Use minified version for production.
 ---------------------------------------------------------------------------
*/
$(document).ready(function() {
	// Standard Search
	$('.button-search').on('click', function() {
		url = $('base').prop('href') + 'index.php?route=product/search';
		var search = $('input[name=\'search\']').prop('value');
		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}
		location = url;
	});

	$('#header input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').prop('href') + 'index.php?route=product/search';
			var search = $('input[name=\'search\']').prop('value');
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			location = url;
		}
	});

	// Ajax Cart
	$('#cart').on('click', '.heading', function() {
		$('#cart').load('index.php?route=module/cart');
		$('#cart').addClass("active");
		$('#cart').find('.content').stop(false, true).slideDown('slow');
		$('#cart').mouseleave(function() {
			$('#cart').removeClass("active");
			$('#cart').find('.content').stop(false, true).slideUp('slow');
			$('#cart').off('.heading');
		});
	});

	// Mega Menu
	$('#menu > ul > li').hover(
		function() {
			$(this).addClass("active");
			$(this).find('div').stop(false, true).slideDown('slow');
		},
		function() {
			$(this).removeClass("active");
			$(this).find('div').stop(false, true).slideUp('slow');
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

	// Close X Classes remove
	$('.success, .warning, .attention, .tooltip').on('click', 'img', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});

	// Success Class remove
	$('body').on('click', '.success', function() {
		$(this).fadeOut('slow');
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

// Banner Tracking
function addClick(banner_image_id) {
	$.ajax({
		url: 'index.php?route=common/footer/add',
		type: 'post',
		data: 'banner_image_id=' + banner_image_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .tooltip').remove();
			if (json['success']) {
				$('#notification').html('<div class="success" style="display:none;">' + json['success'] + '</div>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) { }
	});
}

// Add to Cart / Wishlist / Compare
function addToCart(product_id, quantity) {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .tooltip, .error').remove();
			if (json['redirect']) {
				location = json['redirect'];
			}
			if (json['success']) {
				$('#notification').html('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');
				$('#cart-total').html(json['total']);
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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
				$('#notification').html('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');
				$('#wishlist-total').html(json['total']);
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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
				$('#notification').html('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');
				$('#compare-total').html(json['total']);
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

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
		scrollTop: $('#reviews').position().top -= 30
	}, 'slow');
	return false;
}
