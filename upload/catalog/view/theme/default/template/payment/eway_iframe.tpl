<?php if (isset($error)) { ?>
  <div class="warning">Payment Error: <?php echo $error; ?></div>
<?php } else { ?>
  <?php if (isset($text_testing)) { ?>
    <div class="attention"><?php echo $text_testing; ?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right">
      <input type="button" class="button" id="button-confirm" value="<?php echo $button_pay; ?>" data-loading-text="<?php echo $text_loading; ?>" />&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" id="img-loading-confirm" style="display:none;" />
    </div>
  </div>

<script type="text/javascript" src="https://secure.ewaypayments.com/scripts/eCrypt.js"></script>

<script type="text/javascript"><!--
/* eWAY Rapid IFrame config object */
var eWAYConfig = {
	sharedPaymentUrl: "<?php echo $SharedPaymentUrl; ?>"
};

/* eWAY Rapid IFrame callback */
function resultCallback(result, transactionID, errors) {
	if (result == "Complete") {
		window.location.href = "<?php echo $callback; ?>";
	} else if (result == "Error") {
		$('#img-loading-confirm').hide();
		alert("There was a problem completing the payment: " + result);
	} else {
		$('#img-loading-confirm').hide();
	}
}

$('#button-confirm').click(function() {
	$('#img-loading-confirm').show();
	eCrypt.showModalPayment(eWAYConfig, resultCallback);
});
//--></script>
<?php } ?>