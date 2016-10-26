<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if ($error != '') { ?>
    <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <?php if ($attention != '') { ?>
    <div class="attention"><?php echo $attention; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_refund; ?></h1>
      <div class="buttons">
        <?php if ($cancel) { ?>
          <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
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
            <td><input type="text" name="transaction_id" value="<?php echo $transaction_id; ?>" id="input-transaction-id" /></td>
          </tr>
          <tr>
            <td><label for="refund-full""><?php echo $entry_full_refund; ?></label></td>
            <td>
              <input type="hidden" name="refund_full" value="0" />
              <input type="checkbox" name="refund_full" id="refund-full" value="1" <?php echo ($refund_available == '') ? 'checked="checked"' : ''; ?> onchange="refundAmount();" />
            </td>
          </tr>
          <tr <?php echo ($refund_available == '') ? 'style="display:none;"' : ''; ?> id="partial-amount-row">
            <td><label for="paypal-refund-amount"><?php echo $entry_amount; ?></label></td>
            <td><input type="text" name="amount" id="paypal-refund-amount" value="<?php echo ($refund_available != '') ? $refund_available : ''; ?>" /></td>
          </tr>
          <tr>
            <td><label for="paypal-refund-message"><?php echo $entry_message; ?></label></td>
            <td><textarea name="refund_message" id="paypal-refund-message" cols="40" rows="5"></textarea></td>
          </tr>
        </table>
        <a onclick="$('#form').submit();" class="button" style="float:right;"><?php echo $button_refund; ?></a>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function refundAmount() {
	if ($('#refund-full').prop('checked') == true) {
		$('#partial-amount-row').hide();
	} else {
		$('#partial-amount-row').show();
	}
}
//--></script>

<?php echo $footer; ?>