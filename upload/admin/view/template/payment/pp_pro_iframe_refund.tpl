<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if (!empty($error)) { ?>
    <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <?php if (!empty($attention)) { ?>
    <div class="attention"><?php echo $attention; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <?php if ($cancel) { ?>
          <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
        <?php } ?>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <input type="hidden" name="amount_original" value="<?php echo $amount_original; ?>" />
          <input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>" />
          <tr>
            <td><label for="input-transaction-id"><?php echo $entry_transaction_id; ?></label></td>
            <td><input type="text" name="transaction_id" id="input-transaction-id" value="<?php echo $transaction_id; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-refund-full"><?php echo $entry_full_refund; ?></label></td>
            <td>
              <input type="hidden" name="refund_full" value="0" />
              <input type="checkbox" name="refund_full" id="input-refund-full" value="1" <?php echo ($refund_available == '') ? 'checked="checked"' : ''; ?> onchange="refundAmount();" />
            </td>
          </tr>
          <tr <?php echo ($refund_available == '') ? 'style="display:none;"' : ''; ?> id="partial-amount-row">
            <td><label for="input-refund-amount"><?php echo $entry_amount; ?></label></td>
            <td><input type="text" name="amount" id="input-refund-amount" value="<?php echo ($refund_available != '') ? $refund_available : ''; ?>" />&nbsp;<?php echo $currency_code; ?></td>
          </tr>
          <tr>
            <td><label for="input-refund-message"><?php echo $entry_message; ?></label></td>
            <td><textarea name="refund_message" id="input-refund-message" cols="40" rows="5"></textarea></td>
          </tr>
        </table>
        <a onclick="$('#form').submit();" class="button ripple" id="button-refund" style="float:right;"><?php echo $button_refund; ?></a>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function refundAmount() {
	if ($('#input-refund-full').prop('checked') == true) {
		$('#partial-amount-row').hide();
	} else {
		$('#partial-amount-row').show();
	}
}

$('#form').on('submit', function(e) {
	var full = ($('#input-refund-full').prop('checked') == true ? 1 : 0);
	var amt = $('#input-refund-amount').val();
	e.preventDefault();

	if ($('#input-transaction-id').val() == '') {
		alert('<?php echo addslashes($error_transaction_id); ?>');
	} else {
		$.ajax({
			url: $(this).attr('action'),
			type: $(this).attr('method'),
			dataType: 'json',
			data: {
				'transaction_id': $('#input-transaction-id').val(),
				'refund_full': full,
				'amount': amt,
				'amount_original': '<?php echo $amount_original; ?>',
				'currency_code': '<?php echo addslashes($currency_code); ?>',
				'refund_message': $('#input-refund-message').val(),
			},
			beforeSend: function() {
				$('.success, .warning, .attention').remove();
				$('#button-refund').hide();
				$('#button-refund').after('<img src="view/image/loading.gif" alt="Loading..." class="loading" id="img-loading-refund" style="float:right;" />');
			},
		})
		.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
		.done(function(json) {
			if ('error' in json) {
				$('.box').before('<div class="warning" style="display:none;">' + json['error'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
				$('.warning').fadeIn('slow');
			}

			if ('success' in json) {
				$('.box').before('<div class="warning" style="display:none;">' + json['success'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
				$('.success').fadeIn('slow').sleep(250);

				window.location = '<?php echo addslashes($cancel); ?>';
			}
		})
		.always(function() {
			$('.loading').remove();
			$('#button-refund').show();
		});
	}
});
//--></script>

<?php echo $footer; ?>