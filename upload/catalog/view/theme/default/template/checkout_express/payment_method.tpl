<div id="header-payment" style="margin-bottom:15px;">
  <h2><?php echo $text_checkout_payment_method; ?></h2>
</div>
<?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
  <div id="payment-text">
    <p><?php echo $text_payment_method; ?></p>
  </div>
  <table class="radio">
    <?php foreach ($payment_methods as $payment_method) { ?>
      <?php $paypal_fee = ((substr($payment_method['code'], 0, 3) == "pp_") || ($payment_method['code'] == "paypal_email")) ? "$paypal_fee_fee" : ""; ?>
      <tr class="highlight">
        <td>
          <?php if ($payment_method['code'] == $code || !$code) { ?>
            <?php $code = $payment_method['code']; ?>
            <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" checked="checked" />
          <?php } else { ?>
            <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" />
          <?php } ?>
        </td>
        <td>
          <?php if ($payment_images) { ?>
            <?php foreach ($payment_images as $payment_image) { ?>
              <?php if ($payment_image['payment'] == strtolower($payment_method['code'])) { ?>
                <?php if ($payment_image['status']) { ?>
                  <label for="<?php echo $payment_method['code']; ?>"><img src="<?php echo $payment_image['image']; ?>" title="<?php echo $payment_method['title']; ?>" alt="<?php echo $payment_method['title']; ?>" />
                    <?php if ($paypal_fee) { ?>
                      <span> + <?php echo $paypal_fee; ?></span>
                    <?php } ?>
                  </label>
                <?php } else { ?>
                  <label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?>
                    <?php if ($paypal_fee) { ?>
                      <span> + <?php echo $paypal_fee; ?></span>
                    <?php } ?>
                  </label>
                <?php } ?>
              <?php } ?>
            <?php } ?>
          <?php } else { ?>
            <label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?>
              <?php if ($paypal_fee) { ?>
                <span> + <?php echo $paypal_fee; ?></span>
              <?php } ?>
            </label>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </table>
  <br />
<?php } ?>
<div id="express-comment" <?php $this->config->get('config_express_comment') ? 'style="display:none;"' : ''; ?>>
  <b><?php echo $text_comments; ?></b><br />
  <textarea name="comment" rows="5" style="width:310px;"><?php echo $comment; ?></textarea>
  <br />
  <br />
</div>
<?php if ($text_agree) { ?>
  <div class="buttons">
    <div class="right"><?php echo $text_agree; ?>
      <?php if ($agree || (!$this->config->get('config_express_comment') && (count($payment_methods) == 1))) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
      <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
      <?php } ?>
      <input type="button" value="<?php echo $button_express_go; ?>" id="button-payment-method" class="button" />
    </div>
  </div>
<?php } else { ?>
  <div class="buttons">
    <div class="right">
      <input type="button" value="<?php echo $button_express_go; ?>" id="button-payment-method" class="button" />
    </div>
  </div>
<?php } ?>

<?php if (!$this->config->get('config_express_comment')) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	if ($('#payment-method :radio').size() == 1) {
		$('#payment-method :radio').click();
	}
});
//--></script>
<?php } ?>

<script type="text/javascript"><!--
$('.colorbox').colorbox({
	width: 640,
	height: 480
});
//--></script>