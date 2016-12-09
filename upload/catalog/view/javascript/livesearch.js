/*
 Ajax Search v1.0.0 | @villagedefrance | Overclocked Edition | GNU GPL3 Licensed
*/
function doLiveSearch(ev, keywords) {
	if (ev.keyCode == 38 || ev.keyCode == 40) {
		return false;
	}

	$('#livesearch').remove();
	updown = -1;

	if (keywords == '' || keywords.length < 2) {
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
		window.setTimeout("$('#livesearch').hide(); updown=0;", 400);
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
