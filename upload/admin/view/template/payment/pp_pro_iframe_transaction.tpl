<table class="list" id="table-paypal-transactions">
  <thead>
    <tr>
      <td class="left"><strong><?php echo $column_transaction_id; ?></strong></td>
      <td class="left"><strong><?php echo $column_amount; ?></strong></td>
      <td class="left"><strong><?php echo $column_type; ?></strong></td>
      <td class="left"><strong><?php echo $column_status; ?></strong></td>
      <td class="left"><strong><?php echo $column_pending_reason; ?></strong></td>
      <td class="left"><strong><?php echo $column_created; ?></strong></td>
      <td class="left"><strong><?php echo $column_actions; ?></strong></td>
    </tr>
  </thead>
  <tbody>
  <?php if (!empty($transactions)) { ?>
    <?php foreach ($transactions as $transaction) { ?>
    <tr>
      <td class="left"><?php echo $transaction['transaction_id']; ?></td>
      <td class="left"><?php echo $transaction['amount']; ?></td>
      <td class="left"><?php echo $transaction['payment_type']; ?></td>
      <td class="left"><?php echo $transaction['payment_status']; ?></td>
      <td class="left"><?php echo $transaction['pending_reason']; ?></td>
      <td class="left"><?php echo $transaction['created']; ?></td>
      <td class="left">
      <?php if ($transaction['transaction_id']) { ?>
        <a href="<?php echo $transaction['view']; ?>" class="button"><?php echo $button_view; ?></a>
        <?php if ($transaction['payment_type'] == 'instant' && ($transaction['payment_status'] == 'Completed' || $transaction['payment_status'] == 'Partially-Refunded')) { ?>
        &nbsp;<a href="<?php echo $transaction['refund']; ?>" class="button-delete"><?php echo $button_refund; ?></a>
        <?php } ?>
      <?php } else { ?>
        <a onclick="resendTransaction(this); return false;" href="<?php echo $transaction['resend']; ?>" class="button-repair"><?php echo $button_resend; ?></a>
      <?php } ?>
      </td>
    </tr>
    <?php } ?>
  <?php } else { ?>
    <tr>
      <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>

<script type="text/javascript"><!--
function resendTransaction(element) {
	$.ajax({
		type: 'GET',
		dataType: 'json',
		url: $(element).attr('href'),
		beforeSend: function() {
			$('.success, .warning, .attention').remove();
			$(element).hide();
			$(element).after('<img src="view/image/loading.gif" alt="Loading..." class="loading" />');
		},
	})
	.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
	.done(function(json) {
		if ('error' in json) {
			$('#paypal-transaction').before('<div class="warning" style="display:none;">' + json['error'] + '</div>');
			$('.warning').fadeIn('normal');
		}

		if ('success' in json) {
			$('#paypal-transaction').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
			$('.success').fadeIn('normal').sleep(250);

			location.reload();
		}
	})
	.always(function() {
		$('.loading').remove();
		$(element).show();
	});
}
//--></script>