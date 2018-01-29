<h2><?php echo $text_payment_info; ?></h2>
<div id="paypal-transaction"></div>
<table class="form" id="table-payment-info">
  <tr>
    <td><?php echo $text_payment_status; ?></td>
    <td id="capture-status"><?php echo ($paypal_order['complete'] ? $text_complete : $text_incomplete); ?></td>
  </tr>
  <tr>
    <td><?php echo $text_amount_captured; ?></td>
    <td id="paypal-captured"><?php echo $paypal_order['captured']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_amount_refunded; ?></td>
    <td id="paypal-refunded"><?php echo $paypal_order['refunded']; ?></td>
  </tr>
  <tr id="tr-paypal-remaining" <?php echo ($paypal_order['complete'] == 0) ? 'style="display:none;"' : ''; ?>>
    <td><?php echo $text_amount_remaining; ?></td>
    <td id="paypal-remaining"><?php echo $paypal_order['remaining']; ?></td>
  </tr>
<?php if ($paypal_order['complete'] == 0) { ?>
  <tr class="paypal-capture">
    <td><?php echo $entry_capture_amount; ?></td>
    <td>
      <p><input type="text" size="10" name="paypal_capture_amount" id="paypal-capture-amount" value="<?php echo $paypal_order['remaining_raw']; ?>" /></p>
      <p>
        <input type="checkbox" name="paypal_capture_complete" id="paypal-capture-complete" value="1" />&nbsp;<label for="paypal-capture-complete"><?php echo $entry_capture_complete; ?></label>
        <a class="button-save" id="button-capture" onclick="doCapture();"><?php echo $button_capture; ?></a>
      </p>
    </td>
  </tr>
<?php } ?>
<!-- *** FOR FUTURE USE ***
<?php if ($paypal_order['complete'] == 0) { ?>
  <tr class="paypal-reauthorize">
    <td><?php echo $entry_reauthorize_amount; ?></td>
    <td>
      <p>
        <input type="text" size="10" name="paypal_reauthorize_amount" id="paypal-reauthorize-amount" value="<?php echo $paypal_order['remaining_raw']; ?>" />
        <a class="button" id="button-reauthorize" onclick="doReauthorise();"><?php echo $button_reauthorize; ?></a>
      </p>
    </td>
  </tr>
<?php } ?>
-->
</table>

<script type="text/javascript"><!--
$('#paypal-transaction').load('index.php?route=payment/pp_payflow_iframe/transaction&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

function doCapture() {
	var amt = parseFloat($('#paypal-capture-amount').val());

	if (isNaN(amt) || amt < 0) {  // 0 used for completion
		alert('<?php echo addslashes($error_capture_amount); ?>');
	} else {
		$.ajax({
			url: 'index.php?route=payment/pp_payflow_iframe/do_capture&token=<?php echo $token; ?>',
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
        $('#paypal-transaction').before('<div class="warning" style="display:none;">' + json['error'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
        $('.warning').fadeIn('slow');
      }

      if ('success' in json) {
        $('#paypal-transaction').before('<div class="success" style="display:none;">' + json['success'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
        $('.success').fadeIn('slow');

        if ('to_display' in json) {
          $('#paypal-captured').text(json['to_display']['captured']);
          $('#paypal-refunded').text(json['to_display']['refunded']);
          $('#paypal-remaining').text(json['to_display']['remaining']);
          $('#paypal-capture-amount').val(json['to_display']['remaining_raw']);
          $('#paypal-reauthorize-amount').val(json['to_display']['remaining_raw']);
        }

        if ('complete' in json) {
          $('a[id*=\'button-void-\']').hide();
          $('#capture-status').text(json['complete']);
          $('#tr-paypal-remaining').show();
          $('.paypal-capture').remove();
          $('.paypal-reauthorize').remove();
        }
      }

      $('#paypal-transaction').load('index.php?route=payment/pp_payflow_iframe/transaction&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');
    })
		.always(function() {
			$('.loading').remove();
			$('#button-capture').show();
		});
	}
}

function doVoid(pnref) {
	if (confirm('<?php echo addslashes($msg_void_confirm); ?>')) {
		$.ajax({
			url: 'index.php?route=payment/pp_payflow_iframe/do_void&token=<?php echo $token; ?>',
			type: 'POST',
			dataType: 'json',
			data: {
			  'order_id': <?php echo $order_id; ?>,
			  'pnref': pnref
			},
			beforeSend: function() {
        $('.success, .warning, .attention').remove();
				$('#button-void-' + pnref).hide();
				$('#button-void-' + pnref).after('<img src="view/image/loading.gif" alt="Loading..." class="loading" id="img-loading-void" />');
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

        if ('to_display' in json) {
          $('#paypal-captured').text(json['to_display']['captured']);
          $('#paypal-refunded').text(json['to_display']['refunded']);
          $('#paypal-remaining').text(json['to_display']['remaining']);
          $('#paypal-capture-amount').val(json['to_display']['remaining_raw']);
          $('#paypal-reauthorize-amount').val(json['to_display']['remaining_raw']);
        }

        if ('complete' in json) {
          $('a[id*=\'button-void-\']').hide();
          $('#capture-status').text(json['complete']);
          $('#tr-paypal-remaining').show();
          $('.paypal-capture').remove();
          $('.paypal-reauthorize').remove();
        }
      }

      $('#paypal-transaction').load('index.php?route=payment/pp_payflow_iframe/transaction&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');
		})
		.always(function() {
			$('.loading').remove();
			$('#button-void-' + pnref).show();
		});
	}
}

function doReauthorise() {
	var amt = parseFloat($('#paypal-reauthorize-amount').val());

	if (isNaN(amt) || amt <= 0) {
		alert('<?php echo addslashes($error_reauthorize_amount); ?>');
	} else {
  	if (confirm('<?php echo addslashes($msg_reauthorize_confirm); ?>')) {
  		$.ajax({
  			url: 'index.php?route=payment/pp_payflow_iframe/do_reauthorize&token=<?php echo $token; ?>',
  			type: 'POST',
  			dataType: 'json',
  			data: {
  			  'order_id':<?php echo $order_id; ?>,
  			  'amount': amt
        },
  			beforeSend: function() {
  				$('.success, .warning, .attention').remove();
  				$('#button-reauthorize').hide();
  				$('#button-reauthorize').after('<img src="view/image/loading.gif" alt="Loading..." class="loading" id="img-loading-reauthorize" />');
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

  			$('#paypal-transaction').load('index.php?route=payment/pp_payflow_iframe/transaction&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');
  		})
  		.always(function() {
  			$('.loading').remove();
  			$('#button-reauthorize').show();
  		});
  	}
  }
}
//--></script>