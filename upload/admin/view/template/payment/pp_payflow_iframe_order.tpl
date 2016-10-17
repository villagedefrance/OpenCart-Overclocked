<h2><?php echo $text_payment_info; ?></h2>
<table class="form">
  <tr>
    <td><?php echo $entry_capture_status; ?></td>
    <td id="capture-status">
      <?php if ($complete) { ?>
        <?php echo $text_complete; ?>
      <?php } else { ?>
        <?php echo $text_incomplete; ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $entry_capture; ?></td>
    <td id="complete-entry">
      <?php if ($complete) { ?>
        -
      <?php } else { ?>
        <p><input type="checkbox" name="capture_complete" id="input-capture-complete" value="1" />&nbsp;<?php echo $entry_complete_capture; ?></p>
        <p>
          <input type="text" size="10" name="capture_amount" id="input-capture-amount" value="0.00" />
          <a class="button" onclick="doCapture();" id="button-capture"><?php echo $button_capture; ?></a>
        </p>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $entry_void; ?></td>
    <td id="reauthorise-entry">
      <?php if ($complete) { ?>
        -
      <?php } else { ?>
        <a class="button" id="button-void" onclick="doVoid();"><?php echo $button_void; ?></a>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $entry_transactions; ?></td>
    <td>
      <table class="list" id="transaction-table">
        <thead>
          <tr>
            <td class="left"><?php echo $column_transaction_id; ?></td>
            <td class="left"><?php echo $column_transaction_type; ?></td>
            <td class="left"><?php echo $column_amount; ?></td>
            <td class="left"><?php echo $column_time; ?></td>
            <td class="left"><?php echo $column_actions; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($transactions as $transaction) { ?>
          <tr>
            <td class="left"><?php echo $transaction['transaction_reference']; ?></td>
            <td class="left"><?php echo $transaction['transaction_type']; ?></td>
            <td class="left"><?php echo number_format($transaction['amount'], 2); ?></td>
            <td class="left"><?php echo $transaction['time']; ?></td>
            <td class="left">
              <?php foreach ($transaction['actions'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['title']; ?></a>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </td>
  </tr>
</table>

<script type="text/javascript"><!--
function markAsComplete() {
	$('#capture-status').html('<?php echo addslashes($text_complete); ?>');
	$('#complete-entry, #reauthorise-entry').html('-');
}

function doVoid() {
	if (confirm('<?php echo addslashes($text_confirm_void); ?>')) {
		$.ajax({
			type: 'POST',
			dataType: 'json',
			data: {'order_id':<?php echo $order_id; ?> },
			url: 'index.php?route=payment/pp_payflow_iframe/do_void&token=<?php echo $token; ?>',
			beforeSend: function() {
				$('#button-void').hide();
				$('#button-void').after('<img src="view/image/loading.gif" alt="Loading..." class="loading" id="img-loading-void" />');
			},
		})
		.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
		.done(function(data) {
			if ('error' in data) {
				alert(data.error);
			} else {
				var html = '';

				html += '<tr>';
				html += ' <td class="left">' + data.success.transaction_reference + '</td>';
				html += ' <td class="left">' + data.success.transaction_type + '</td>';
				html += ' <td class="left">' + data.success.amount + '</td>';
				html += ' <td class="left">' + data.success.time + '</td>';
				html += ' <td class="left"></td>';
				html += '</tr>';

				$('#transaction-table tbody').append(html);

				markAsComplete();
			}
		})
		.always(function() {
			$('.loading').remove();
			$('#button-void').show();
		});
	}
}

function doCapture() {
	var amt = $('#input-capture-amount').val();

	if (amt == '' || amt == 0) {
		alert('<?php echo addslashes($error_capture); ?>');
		return false;
	} else {
		var captureComplete;

		if ($('#input-capture-complete').is(':checked')) {
			captureComplete = 1;
		} else {
			captureComplete = 0;
		}

		$.ajax({
			url: 'index.php?route=payment/pp_payflow_iframe/do_capture&token=<?php echo $token; ?>',
			type: 'POST',
			data: {
				'order_id': <?php echo $order_id; ?>,
				'amount': amt,
				'complete': captureComplete
			},
			dataType: 'json',
			beforeSend: function() {
				$('#button-capture').hide();
				$('#button-capture').after('<img src="view/image/loading.gif" alt="Loading..." class="loading" id="img-loading-capture" />');
			},
		})
		.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
		.done(function(data) {
			if ('error' in data) {
				alert(data.error);
			} else {
				var html = '';

				html += '<tr>';
				html += ' <td class="left">' + data.success.transaction_reference + '</td>';
				html += ' <td class="left">' + data.success.transaction_type + '</td>';
				html += ' <td class="left">' + data.success.amount + '</td>';
				html += ' <td class="left">' + data.success.time + '</td>';
				html += ' <td class="left">';

				$.each(data.success.actions, function(index, value) {
					html += ' [<a href="' + value.href + '">' + value.title + '</a>] ';
				});

				html += '</td>';
				html += '</tr>';

				$('#transaction-table tbody').append(html);

				if (captureComplete == 1) {
					markAsComplete();
				}
			}
		})
		.always(function() {
			$('.loading').remove();
			$('#button-capture').show();
		});
	}
}
//--></script>