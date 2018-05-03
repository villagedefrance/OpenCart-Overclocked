<form action="<?php echo $action; ?>" method="post" id="okpay-checkout">
  <input type="hidden" name="ok_receiver" value="<?php echo $ok_receiver; ?>" />
  <input type="hidden" name="ok_return_success" value="<?php echo $ok_return_success; ?>" />
  <input type="hidden" name="ok_return_fail" value="<?php echo $ok_return_fail; ?>" />
  <input type="hidden" name="ok_ipn" value="<?php echo $ok_ipn; ?>" />
  <input type="hidden" name="ok_invoice" value="<?php echo $ok_invoice; ?>" />
  <input type="hidden" name="ok_currency" value="<?php echo $ok_currency; ?>" />
  <input type="hidden" name="ok_item_1_price" value="<?php echo $ok_item_1_price; ?>" />
  <input type="hidden" name="ok_item_1_name" value="<?php echo $ok_item_1_name; ?>" />
</form>
<div class="buttons">
  <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
  <div class="right"><a id="button-confirm" onclick="" class="button"><?php echo $button_confirm; ?></a></div>
</div>

<script type="text/javascript"><!--
$('body').on('click', '#button-confirm', function() {
  $('#okpay-checkout').submit();
});
//--></script>