<div id="header-shipping" style="margin-bottom:15px;">
  <h2><?php echo $text_checkout_shipping_method; ?></h2>
</div>
<?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($shipping_methods) { ?>
  <div id="shipping-text">
    <p><?php echo $text_shipping_method; ?></p>
  </div>
  <table class="radio">
    <?php $good = 0; ?>
    <?php foreach ($shipping_methods as $shipping_method) { ?>
      <?php if (!$shipping_method['error']) { ?>
        <?php foreach ($shipping_method['quote'] as $quote) { ?>
          <tr class="highlight">
            <td style="vertical-align:middle; padding:0;">
              <?php if ($quote['code'] == $code || !$code) { ?>
                <?php $good++; $code = $quote['code']; ?>
                <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" checked="checked" />
              <?php } else { ?>
                <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" />
              <?php } ?>
            </td>
            <td style="padding:0px;">
              <label style="padding:7px;" for="<?php echo $quote['code']; ?>"> <strong><?php echo $quote['title']; ?></strong> - <?php echo $quote['text']; ?></label>
            </td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="3"><div class="error"><?php echo $shipping_method['error']; ?></div></td>
        </tr>
      <?php } ?>
    <?php } ?>
  </table>
  <br />
<?php } ?>
<div id="shipping-comment" style="display:none;">
  <b><?php echo $text_comments; ?></b><br />
  <textarea name="comment" rows="4" style="width:400px;"><?php echo $comment; ?></textarea>
  <br />
  <br />
</div>
<div class="buttons">
  <div class="left">
    <input type="button" value="<?php echo $button_express_go; ?>" id="button-shipping-method" class="button" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a id="modify-address" onclick="$('#shipping-method .checkout-content').fadeOut(100); $('#shipping-address .checkout-content').fadeIn(500);" style="text-decoration:none;"><?php echo $text_your_address; ?></a>
  </div>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	if ($('#shipping-method :radio').size() == 1) {
		$('#shipping-method :radio').click();
	}
});
//--></script> 