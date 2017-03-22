<form action="<?php echo $action; ?>" method="POST" id="globalpay_form_redirect">
  <input type=hidden name="MERCHANT_ID" value="<?php echo $merchant_id; ?>" />
  <input type=hidden name="ORDER_ID" value="<?php echo $order_id; ?>" />
  <input type=hidden name="CURRENCY" value="<?php echo $currency; ?>" />
  <input type=hidden name="AMOUNT" value="<?php echo $amount; ?>" />
  <input type=hidden name="TIMESTAMP" value="<?php echo $timestamp; ?>" />
  <input type=hidden name="SHA1HASH" value="<?php echo $hash; ?>" />
  <input type=hidden name="AUTO_SETTLE_FLAG" value="<?php echo $settle; ?>" />
  <input type=hidden name="RETURN_TSS" value="<?php echo $tss; ?>" />
  <input type=hidden name="BILLING_CODE" value="<?php echo $billing_code; ?>" />
  <input type=hidden name="BILLING_CO" value="<?php echo $payment_country; ?>" />
  <input type=hidden name="SHIPPING_CODE" value="<?php echo $shipping_code; ?>" />
  <input type=hidden name="SHIPPING_CO" value="<?php echo $shipping_country; ?>" />
  <input type=hidden name="MERCHANT_RESPONSE_URL" value="<?php echo $response_url; ?>" />
  <input type=hidden name="COMMENT1" value="OpenCart Overclocked" />
<?php if ($card_select == true) { ?>
  <fieldset id="payment">
    <div>
      <label for="input-cc-type"><?php echo $text_select_card; ?>&nbsp;<?php echo $entry_cc_type; ?></label>
      <div><select name="ACCOUNT" id="input-cc-type">
        <?php foreach ($cards as $card) { ?>
          <option value="<?php echo $card['account']; ?>"><?php echo $card['type']; ?></option>
        <?php } ?>
      </select></div>
    </div>
  </fieldset>
<?php } ?>
  <div class="buttons">
    <div class="right">
      <input type="submit" id="button-confirm" value="<?php echo $button_confirm; ?>" class="button" />
    </div>
  </div>
</form>