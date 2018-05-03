<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div style="float:right;">
  <?php if ($logged && $shipping_required) { ?>
    <a href="<?php echo $express_address; ?>" title="<?php echo $text_your_address; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/address.png" alt="<?php echo $text_your_address; ?>" /></a>
  <?php } ?>
    <a href="<?php echo $express_cart; ?>" title="<?php echo $text_cart; ?>" style="margin-left:25px;"><img src="catalog/view/theme/<?php echo $template; ?>/image/cart.png" alt="<?php echo $text_cart; ?>" /></a>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($wrapping_status || $this->config->get('config_express_coupon') || $this->config->get('config_express_voucher') || $reward_point) { ?>
    <div style="margin-bottom:10px;">
      <?php if ($wrapping_status) { ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <?php if (isset($this->session->data['wrapping'])) { ?>
            <input type="submit" name="remove_wrapping" value="<?php echo $button_wrapping_remove; ?>" class="button-wrap-remove" />
          <?php } else { ?>
            <input type="submit" name="add_wrapping" value="<?php echo $button_wrapping_add; ?>" class="button-wrap-add" />
          <?php } ?>
        </form>
      <?php } ?>
      <?php if ($this->config->get('config_express_coupon')) { ?>
        <a onclick="$('#coupon').show(500);$('#voucher').hide();$('#reward').hide();" class="button"><?php echo $text_express_coupon; ?></a>
      <?php } ?>
      <?php if ($this->config->get('config_express_voucher')) { ?>
        <a onclick="$('#voucher').show(500);$('#coupon').hide();$('#reward').hide();" class="button"><?php echo $text_express_voucher; ?></a>
      <?php } ?>
      <?php if ($show_point && $reward_point) { ?>
        <a onclick="$('#reward').show(500);$('#voucher').hide();$('#coupon').hide();" class="button"><?php echo $text_express_reward; ?></a>
      <?php } ?>
      <div id="coupon" class="content" style="margin-top:10px; margin-bottom:20px; display:none;">
        <img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" onclick="dismiss1('coupon');" class="close" />
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <?php echo $entry_coupon; ?>&nbsp;
          <input type="text" name="coupon" value="<?php echo $coupon; ?>" />
          <input type="hidden" name="next" value="coupon" />
          &nbsp;
          <input type="submit" value="<?php echo $button_coupon; ?>" class="button" />
        </form>
      </div>
      <div id="voucher" class="content" style="margin-top:10px; margin-bottom:20px; display:none;">
        <img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" onclick="dismiss2('voucher');" class="close" />
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <?php echo $entry_voucher; ?>&nbsp;
          <input type="text" name="voucher" value="<?php echo $voucher; ?>" />
          <input type="hidden" name="next" value="voucher" />
          &nbsp;
          <input type="submit" value="<?php echo $button_voucher; ?>" class="button" />
        </form>
      </div>
      <div id="reward" class="content" style="margin-top:10px; margin-bottom:20px; display:none;">
        <img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" onclick="dismiss3('reward');" class="close" />
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <?php echo $entry_reward; ?>&nbsp;
          <input type="text" name="reward" value="<?php echo $reward; ?>" />
          <input type="hidden" name="next" value="reward" />
          &nbsp;
          <input type="submit" value="<?php echo $button_reward; ?>" class="button" />
        </form>
      </div>
    </div>
  <?php } ?>
  <?php if (!empty($attention)) { ?>
    <div class="attention"><?php echo $attention; ?><img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>
  <?php } ?>
  <?php if (!empty($success)) { ?>
    <div class="success"><?php echo $success; ?><img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>
  <?php } ?>
  <?php if (!empty($error_warning)) { ?>
    <div class="warning"><?php echo $error_warning; ?><img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>
  <?php } ?>
  <div class="checkout" style="margin-top:20px;">
    <div id="checkout">
      <div class="checkout-heading" style="display:none;"><?php echo $text_checkout_option; ?></div>
      <div class="checkout-content"></div>
    </div>
    <?php if (!$logged) { ?>
      <div id="payment-address">
        <div class="checkout-heading" style="display:none;"><span><?php echo $text_checkout_account; ?></span></div>
        <div class="checkout-content"></div>
      </div>
    <?php } else { ?>
      <div id="payment-address">
        <div class="checkout-heading" style="display:none;"><span><?php echo $text_checkout_payment_address; ?></span></div>
        <div class="checkout-content"></div>
      </div>
    <?php } ?>
    <?php if ($shipping_required) { ?>
      <div id="shipping-address">
        <div class="checkout-heading" style="display:none;"><?php echo $text_checkout_shipping_address; ?></div>
        <div class="checkout-content"></div>
      </div>
      <div id="shipping-method">
        <div class="checkout-heading" style="display:none;"><?php echo $text_checkout_shipping_method; ?></div>
        <div class="checkout-content" style="padding:0; overflow:hidden;"></div>
      </div>
    <?php } ?>
    <div id="payment-method">
      <div class="checkout-heading" style="display:none;"><?php echo $text_checkout_payment_method; ?></div>
      <div class="checkout-content" style="padding:0; overflow:hidden;"></div>
    </div>
    <div id="confirm">
      <div class="checkout-heading" style="display:none;"><?php echo $text_checkout_confirm; ?></div>
      <div class="checkout-content"></div>
    </div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

<script type="text/javascript"><!--
$('#checkout .checkout-content input[name=\'account\']').on('change', function() {
	if ($(this).attr('value') == 'register') {
		$('#payment-address .checkout-heading span').html('<?php echo $text_checkout_account; ?>');
	} else {
		$('#payment-address .checkout-heading span').html('<?php echo $text_checkout_payment_address; ?>');
	}
});

$('.checkout-heading').on('click', 'a', function() {
	$('.checkout-content').fadeOut(100);

	$(this).parent().parent().find('.checkout-content').fadeIn(500);
});

<?php if (!$logged) { ?> 
$(document).ready(function() {
	<?php if (isset($quickconfirm)) { ?>
		quickConfirm();
	<?php } else { ?>
		$.ajax({
			url: 'index.php?route=checkout_express/login',
			dataType: 'html',
			success: function(html) {
				$('#checkout .checkout-content').html(html);
				$('#checkout .checkout-content').fadeIn(100);

				$('#email').focus();
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	<?php } ?>
});
<?php } ?>

<?php if ($logged) { ?>
	<?php if ($express_billing) { ?>
		$(document).ready(function() {
		<?php if (isset($quickconfirm)) { ?>
			quickConfirm();
		<?php } else { ?>
			$.ajax({
				url: 'index.php?route=checkout_express/payment_address',
				dataType: 'html',
				success: function(html) {
					$('#payment-address .checkout-content').html(html);
					$('#payment-address .checkout-content').fadeIn(100);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		<?php } ?>
		});
	<?php } else { ?>
		$(document).ready(function() {
		<?php if (isset($quickconfirm)) { ?>
			quickConfirm();
		<?php } else { ?>
			$.ajax({
				url: 'index.php?route=checkout_express/<?php if ($shipping_required) { ?>shipping_address<?php } else { ?>payment_method<?php } ?>',
				dataType: 'html',
				success: function(html) {
				<?php if ($shipping_required) { ?>
					$('#shipping-address .checkout-content').html(html);
					$('#shipping-address .checkout-content').fadeIn(100);
				<?php } else { ?>
					$('#payment-method .checkout-content').html(html);
					$('#payment-method .checkout-content').fadeIn(100);
				<?php } ?>
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		<?php } ?>
		});
	<?php } ?>
<?php } ?>

// Checkout Express
$('body').on('click', '#button-express', function() {
	$.ajax({
		url: 'index.php?route=checkout_express/login/validate',
		type: 'post',
		data: $('#checkout #login :input'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-express').attr('disabled', true);
			$('#button-express').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-express').attr('disabled', false);
			$('.wait').remove();
		},
		success: function(json) {
			$('.attention, .warning, .error').remove();

			if (json['name']) {
				$('.wait').remove();
				$('#express-name').html(json['name']);
				$('#express-hide1').fadeIn(500);
				$('#express-hide2').fadeIn(500);
			}

			if (json['mail']) {
				$.ajax({
					url: 'index.php?route=checkout_express/register&mail=' + json['mail'],
					dataType: 'html',
					beforeSend: function() {
						$('#button-account').attr('disabled', true);
						$('#button-account').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
					},
					complete: function() {
						$('#button-account').attr('disabled', false);
						$('.wait').remove();
					},
					success: function(html) {
						$('.attention, .warning, .error').remove();

						$('#payment-address .checkout-content').html(html);

						$('#checkout .checkout-content').fadeOut(100);

						$('#payment-address .checkout-content').fadeIn(500);

						$('.checkout-heading').remove();
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}

			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				$('.wait').remove();
				$('#checkout .checkout-content').prepend('<div class="warning" style="display:none;">' + json['error']['warning'] + '</div>');

				$('.warning').fadeIn(500);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Account
$('body').on('click', '#button-account', function() {
	$.ajax({
		url: 'index.php?route=checkout_express/' + $('input[name=\'account\']:checked').attr('value'),
		dataType: 'html',
		beforeSend: function() {
			$('#button-account').attr('disabled', true);
			$('#button-account').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-account').attr('disabled', false);
			$('.wait').remove();
		},
		success: function(html) {
			$('.attention, .warning, .error').remove();

			$('#payment-address .checkout-content').html(html);

			$('#checkout .checkout-content').fadeOut(100);

			$('#payment-address .checkout-content').fadeIn(500);

			$('.checkout-heading').remove();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});

	if (0) {
		$.ajax({
			url: 'index.php?route=checkout_express/register',
			dataType: 'html',
			beforeSend: function() {
				$('#button-account').attr('disabled', true);
				$('#button-account').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
			},
			complete: function() {
				$('#button-account').attr('disabled', false);
				$('.wait').remove();
			},
			success: function(html) {
				$('.warning, .error').remove();

				$('#payment-address .checkout-content').html(html);

				$('#checkout .checkout-content').fadeOut(100);

				$('#payment-address .checkout-content').fadeIn(100);

				$('.checkout-heading').remove();
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});

// Login
$('body').on('click', '#button-login', function() {
	$.ajax({
		url: 'index.php?route=checkout_express/login/validate',
		type: 'post',
		data: $('#checkout #login :input'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-login').attr('disabled', true);
			$('#button-login').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-login').attr('disabled', false);
			$('.wait').remove();
		},
		success: function(json) {
			$('.attention, .warning, .error').remove();

			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				$('#checkout .checkout-content').prepend('<div class="warning" style="display:none;">' + json['error']['warning'] + '</div>');

				$('.warning').fadeIn(500);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Register
$('body').on('click', '#button-register', function() {
	Registration();
});

function Registration() {
	$.ajax({
		url: 'index.php?route=checkout_express/register/validate',
		type: 'post',
		data: $('#payment-address input[type=\'text\'], #payment-address input[type=\'password\'], #payment-address input[type=\'checkbox\']:checked, #payment-address input[type=\'radio\']:checked, #payment-address input[type=\'hidden\'], #payment-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-register').attr('disabled', true);
			$('#button-register').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-register').attr('disabled', false);
			$('.wait').remove();
		},
		success: function(json) {
			$('.attention, .warning, .error').remove();

			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#payment-address .checkout-content').prepend('<div class="warning" style="display:none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>');

					$('.warning').fadeIn(500);
				}

				if (json['error']['firstname']) {
					$('#payment-address input[name=\'firstname\'] + br').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}

				if (json['error']['lastname']) {
					$('#payment-address input[name=\'lastname\'] + br').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}

				if (json['error']['email']) {
					$('#payment-address input[name=\'email\'] + br').after('<span class="error">' + json['error']['email'] + '</span>');
				}

				if (json['error']['telephone']) {
					$('#payment-address input[name=\'telephone\'] + br').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}

				if (json['error']['company_id']) {
					$('#payment-address input[name=\'company_id\'] + br').after('<span class="error">' + json['error']['company_id'] + '</span>');
				}

				if (json['error']['tax_id']) {
					$('#payment-address input[name=\'tax_id\'] + br').after('<span class="error">' + json['error']['tax_id'] + '</span>');
				}

				if (json['error']['address_1']) {
					$('#payment-address input[name=\'address_1\'] + br').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}

				if (json['error']['city']) {
					$('#payment-address input[name=\'city\'] + br').after('<span class="error">' + json['error']['city'] + '</span>');
				}

				if (json['error']['postcode']) {
					$('#payment-address input[name=\'postcode\'] + br').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}

				if (json['error']['country']) {
					$('#payment-address select[name=\'country_id\'] + br').after('<span class="error">' + json['error']['country'] + '</span>');
				}

				if (json['error']['zone']) {
					$('#payment-address select[name=\'zone_id\'] + br').after('<span class="error">' + json['error']['zone'] + '</span>');
				}

				if (json['error']['password']) {
					$('#payment-address input[name=\'password\'] + br').after('<span class="error">' + json['error']['password'] + '</span>');
				}

				if (json['error']['confirm']) {
					$('#payment-address input[name=\'confirm\'] + br').after('<span class="error">' + json['error']['confirm'] + '</span>');
				}

			} else {
			<?php if ($shipping_required) { ?>
				var shipping_address = $('#payment-address input[name=\'shipping_address\']:checked').attr('value');

				if (shipping_address) {
					$.ajax({
						url: 'index.php?route=checkout_express/shipping_method',
						dataType: 'html',
						success: function(html) {
							$('#shipping-method .checkout-content').html(html);

							$('#payment-address .checkout-content').fadeOut(100);

							$('#shipping-method .checkout-content').fadeIn(500);

							$('.wait').remove();

							$.ajax({
								url: 'index.php?route=checkout/shipping_address',
								dataType: 'html',
								success: function(html) {
									$('#shipping-address .checkout-content').html(html);
								},
								error: function(xhr, ajaxOptions, thrownError) {
									alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
								}
							});
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				} else {
					$.ajax({
						url: 'index.php?route=checkout_express/shipping_address',
						dataType: 'html',
						success: function(html) {
							$('#shipping-address .checkout-content').html(html);

							$('#payment-address .checkout-content').fadeOut(100);

							$('#shipping-address .checkout-content').fadeIn(500);

							$('.wait').remove();
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				}
			<?php } else { ?>
				$.ajax({
					url: 'index.php?route=checkout_express/payment_method',
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);

						$('#payment-address .checkout-content').fadeOut(100);

						$('#payment-method .checkout-content').fadeIn(500);

						$('.wait').remove();
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			<?php } ?>
				$.ajax({
					url: 'index.php?route=checkout_express/payment_address',
					dataType: 'html',
					success: function(html) {
						$('#payment-address .checkout-content').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

// Payment Address
$('body').on('click', '#button-payment-address', function() {
	$.ajax({
		url: 'index.php?route=checkout_express/payment_address/validate',
		type: 'post',
		data: $('#payment-address input[type=\'text\'], #payment-address input[type=\'password\'], #payment-address input[type=\'checkbox\']:checked, #payment-address input[type=\'radio\']:checked, #payment-address input[type=\'hidden\'], #payment-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-payment-address').attr('disabled', true);
			$('#button-payment-address').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-payment-address').attr('disabled', false);
			$('.wait').remove();
		},
		success: function(json) {
			$('.attention, .warning, .error').remove();

			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#payment-address .checkout-content').prepend('<div class="warning" style="display:none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>');

					$('.warning').fadeIn(500);
				}

				if (json['error']['firstname']) {
					$('#payment-address input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}

				if (json['error']['lastname']) {
					$('#payment-address input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}

				if (json['error']['telephone']) {
					$('#payment-address input[name=\'telephone\']').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}

				if (json['error']['company_id']) {
					$('#payment-address input[name=\'company_id\']').after('<span class="error">' + json['error']['company_id'] + '</span>');
				}

				if (json['error']['tax_id']) {
					$('#payment-address input[name=\'tax_id\']').after('<span class="error">' + json['error']['tax_id'] + '</span>');
				}

				if (json['error']['address_1']) {
					$('#payment-address input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}

				if (json['error']['city']) {
					$('#payment-address input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
				}

				if (json['error']['postcode']) {
					$('#payment-address input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}

				if (json['error']['country']) {
					$('#payment-address select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}

				if (json['error']['zone']) {
					$('#payment-address select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}

			} else {
			<?php if ($shipping_required) { ?>
				$.ajax({
					url: 'index.php?route=checkout_express/shipping_address',
					dataType: 'html',
					success: function(html) {
						$('#shipping-address .checkout-content').html(html);

						$('#payment-address .checkout-content').fadeOut(100);

						$('#shipping-address .checkout-content').fadeIn(500);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			<?php } else { ?>
				$.ajax({
					url: 'index.php?route=checkout_express/payment_method',
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);

						$('#payment-address .checkout-content').fadeOut(100);

						$('#payment-method .checkout-content').fadeIn(500);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			<?php } ?>
				$.ajax({
					url: 'index.php?route=checkout_express/payment_address',
					dataType: 'html',
					success: function(html) {
						$('#payment-address .checkout-content').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Shipping Address
$('body').on('click', '#button-shipping-address', function() {
	$.ajax({
		url: 'index.php?route=checkout_express/shipping_address/validate',
		type: 'post',
		data: $('#shipping-address input[type=\'text\'], #shipping-address input[type=\'password\'], #shipping-address input[type=\'checkbox\']:checked, #shipping-address input[type=\'radio\']:checked, #shipping-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-shipping-address').attr('disabled', true);
			$('#button-shipping-address').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-shipping-address').attr('disabled', false);
			$('.wait').remove();
		},
		success: function(json) {
			$('.attention, .warning, .error').remove();

			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#shipping-address .checkout-content').prepend('<div class="warning" style="display:none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>');

					$('.warning').fadeIn(500);
				}

				if (json['error']['firstname']) {
					$('#shipping-address input[name=\'firstname\'] + br').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}

				if (json['error']['lastname']) {
					$('#shipping-address input[name=\'lastname\'] + br').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}

				if (json['error']['email']) {
					$('#shipping-address input[name=\'email\'] + br').after('<span class="error">' + json['error']['email'] + '</span>');
				}

				if (json['error']['telephone']) {
					$('#shipping-address input[name=\'telephone\'] + br').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}

				if (json['error']['address_1']) {
					$('#shipping-address input[name=\'address_1\'] + br').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}

				if (json['error']['city']) {
					$('#shipping-address input[name=\'city\'] + br').after('<span class="error">' + json['error']['city'] + '</span>');
				}

				if (json['error']['postcode']) {
					$('#shipping-address input[name=\'postcode\'] + br').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}

				if (json['error']['country']) {
					$('#shipping-address select[name=\'country_id\'] + br').after('<span class="error">' + json['error']['country'] + '</span>');
				}

				if (json['error']['zone']) {
					$('#shipping-address select[name=\'zone_id\'] + br').after('<span class="error">' + json['error']['zone'] + '</span>');
				}

			} else {
				$.ajax({
					url: 'index.php?route=checkout_express/shipping_method',
					dataType: 'html',
					success: function(html) {
						$('#shipping-method .checkout-content').html(html);

						$('#shipping-address .checkout-content').fadeOut(100);

						$('#shipping-method .checkout-content').fadeIn(500);

						$.ajax({
							url: 'index.php?route=checkout_express/shipping_address',
							dataType: 'html',
							success: function(html) {
								$('#shipping-address .checkout-content').html(html);
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						});
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('body').on('click', '#button-shipping-method', function() {
	$.ajax({
		url: 'index.php?route=checkout_express/shipping_method/validate',
		type: 'post',
		data: $('#shipping-method input[type=\'radio\']:checked, #shipping-method textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-shipping-method').attr('disabled', true);
			$('#button-shipping-method').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-shipping-method').attr('disabled', false);
			$('.wait').remove();
		},
		success: function(json) {
			$('.attention, .warning, .error').remove();

			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#shipping-method .checkout-content').prepend('<div class="warning" style="display:none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>');

					$('.warning').fadeIn(500);
				}
			} else {
				$.ajax({
					url: 'index.php?route=checkout_express/payment_method',
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);

						$('#shipping-method .checkout-content').fadeOut(100);

						$('#payment-method .checkout-content').fadeIn(500);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('body').on('click', '#button-payment-method', function() {
	$.ajax({
		url: 'index.php?route=checkout_express/payment_method/validate',
		type: 'post',
		data: $('#payment-method input[type=\'radio\']:checked, #payment-method input[type=\'checkbox\']:checked, #payment-method textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-payment-method').attr('disabled', true);
			$('#button-payment-method').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-payment-method').attr('disabled', false);
			$('.wait').remove();
		},
		success: function(json) {
			$('.attention, .warning, .error').remove();

			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#payment-method .checkout-content').prepend('<div class="warning" style="display:none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>');

					$('.warning').fadeIn(500);
				}
			} else {
				$.ajax({
					url: 'index.php?route=checkout_express/confirm',
					dataType: 'html',
					success: function(html) {
						$('#confirm .checkout-content').html(html);

						$('#payment-method .checkout-content').fadeOut(100);

						$('#confirm .checkout-content').fadeIn(500);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function quickConfirm(module) {
	$.ajax({
		url: 'index.php?route=checkout_express/confirm',
		dataType: 'html',
		success: function(html) {
			$('#confirm .checkout-content').html(html);
			$('#confirm .checkout-content').fadeIn(500);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
//--></script>

<script type="text/javascript"><!--
function dismiss1(coupon) {
	document.getElementById('coupon').style.display="none";
}
function dismiss2(voucher) {
	document.getElementById('voucher').style.display="none";
}
function dismiss3(reward) {
	document.getElementById('reward').style.display="none";
}
//--></script>

<?php echo $footer; ?>