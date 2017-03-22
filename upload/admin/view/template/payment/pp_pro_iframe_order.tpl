<h2><?php echo $text_payment_info; ?></h2>
<div id="paypal-transaction"></div>
<table class="form" id="table-payment-info">
  <tr>
    <td><?php echo $text_capture_status; ?></td>
    <td id="capture-status"><?php echo $paypal_order['capture_status']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_amount_authorised; ?></td>
    <td>
      <?php echo $paypal_order['total']; ?>
      <?php if ($paypal_order['capture_status'] != 'Complete') { ?>
        &nbsp;&nbsp;&nbsp;<a class="button-delete" id="button-void"><?php echo $button_void; ?></a>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_amount_captured; ?></td>
    <td id="paypal-captured"><?php echo $paypal_order['captured']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_amount_refunded; ?></td>
    <td id="paypal-refunded"><?php echo $paypal_order['refunded']; ?></td>
  </tr>
  <?php if ($paypal_order['capture_status'] != 'Complete') { ?>
  <tr class="paypal-capture">
    <td><?php echo $entry_capture_amount; ?></td>
    <td>
      <p><input type="checkbox" name="paypal_capture_complete" id="paypal-capture-complete" value="1" />&nbsp;<label for="paypal-capture-complete"><?php echo $entry_capture_complete; ?></label></p>
      <p>
        <input type="text" size="10" name="paypal_capture_amount" id="paypal-capture-amount" value="<?php echo $paypal_order['remaining']; ?>" />
        <a class="button-save" id="button-capture"><?php echo $button_capture; ?></a>
      </p>
    </td>
  </tr>
  <?php } ?>
  <?php if ($paypal_order['capture_status'] != 'Complete') { ?>
  <tr class="paypal-reauthorise">
    <td><?php echo $text_reauthorise; ?></td>
    <td><a class="button" id="button-reauthorise"><?php echo $button_reauthorise; ?></a></td>
  </tr>
  <?php } ?>
</table>

<script type="text/javascript"><!--
$('#paypal-transaction').load('index.php?route=payment/pp_pro_iframe/transaction&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

$('#button-capture').on('click', function() {
	var amt = $('#paypal-capture-amount').val();

	if (amt == '' || amt <= 0) {
		alert('<?php echo addslashes($error_capture_amt); ?>');
	} else {
		$.ajax({
			url: 'index.php?route=payment/pp_pro_iframe/do_capture&token=<?php echo $token; ?>',
			type: 'POST',
			dataType: 'json',
			data: {
				'order_id': <?php echo $order_id; ?>,
				'complete': ($('#paypal-capture-complete').prop('checked') == true ? 1 : 0),
				'amount': amt
			},
			beforeSend: function() {
				$('.success, .warning, .attention').remove();
				$('#button-capture').hide();
				$('#button-capture').after('<img src="view/image/loading.gif" alt="Loading..." class="loading" id="img-loading-capture" />');
			},
		})
		.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
		.done(function(json) {
			if ('error' in json) {
				$('#paypal-transaction').before('<div class="warning" style="display:none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if ('success' in json) {
				$('#paypal-transaction').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');

				$('#paypal-captured').text(json['captured']);
				$('#paypal-capture-amount').val(json['remaining']);

				if ('capture_status' in json) {
					$('#capture-status').text(json['capture_status']);
					$('#button-void').remove();
					$('.paypal-capture').remove();
				}
			}

			$('#paypal-transaction').load('index.php?route=payment/pp_pro_iframe/transaction&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');
		})
		.always(function() {
			$('.loading').remove();
			$('#button-capture').show();
		});
	}
});

$('#button-void').on('click', function() {
	if (confirm('<?php echo addslashes($text_confirm_void); ?>')) {
		$.ajax({
			url: 'index.php?route=payment/pp_pro_iframe/do_void&token=<?php echo $token; ?>',
			type: 'POST',
			dataType: 'json',
			data: { 'order_id':<?php echo $order_id; ?> },
			beforeSend: function() {
				$('.success, .warning, .attention').remove();
				$('#button-void').hide();
				$('#button-void').after('<img src="view/image/loading.gif" alt="Loading..." class="loading" id="img-loading-void" />');
			},
		})
		.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
		.done(function(json) {
			if ('error' in json) {
				$('#paypal-transaction').before('<div class="warning" style="display:none;">' + json['error'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
				$('.warning').fadeIn('slow');
			}

			if ('success' in json) {
				$('#paypal-transaction').before('<div class="success" style="display:none;">' + json['success'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
				$('.success').fadeIn('slow');

				if ('capture_status' in json) {
					$('#capture-status').text(json['capture_status']);
					$('#button-void').remove();
					$('.paypal-capture').remove();
				}
			}

			$('#paypal-transaction').load('index.php?route=payment/pp_pro_iframe/transaction&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');
		})
		.always(function() {
			$('.loading').remove();
			$('#button-void').show();
		});
	}
});

$('#button-reauthorise').on('click', function() {
	if (confirm('<?php echo addslashes($text_confirm_reauthorise); ?>')) {
		$.ajax({
			url: 'index.php?route=payment/pp_pro_iframe/do_reauthorise&token=<?php echo $token; ?>',
			type: 'POST',
			dataType: 'json',
			data: { 'order_id':<?php echo $order_id; ?> },
			beforeSend: function() {
				$('.success, .warning, .attention').remove();
				$('#button-reauthorise').hide();
				$('#button-reauthorise').after('<img src="view/image/loading.gif" alt="Loading..." class="loading" id="img-loading-reauthorise" />');
			},
		})
		.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
		.done(function(json) {
			if ('error' in json) {
				$('#paypal-transaction').before('<div class="warning" style="display:none;">' + json['error'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
				$('.warning').fadeIn('slow');
			}

			if ('success' in json) {
				$('#paypal-transaction').before('<div class="success" style="display:none;">' + json['success'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
				$('.success').fadeIn('slow');
			}

			$('#paypal-transaction').load('index.php?route=payment/pp_pro_iframe/transaction&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');
		})
		.always(function() {
			$('.loading').remove();
			$('#button-reauthorise').show();
		});
	}
});
//--></script>