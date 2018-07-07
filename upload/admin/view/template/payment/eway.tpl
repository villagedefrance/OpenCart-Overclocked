<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><label for="input-paymode"><?php echo $entry_paymode; ?></label></td>
            <td><select name="eway_paymode" id="input-paymode">
              <?php if ($eway_paymode == 'iframe') { ?>
                <option value="iframe" selected="selected"><?php echo $text_iframe; ?></option>
                <option value="transparent"><?php echo $text_transparent; ?></option>
              <?php } else { ?>
                <option value="iframe"><?php echo $text_iframe; ?></option>
                <option value="transparent" selected="selected"><?php echo $text_transparent; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-test"><?php echo $entry_test; ?><br /><span class="help"><?php echo $help_testmode; ?></span></label></td>
            <td><select name="eway_test" id="input-test">
              <?php if ($eway_test) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-username"><?php echo $entry_username; ?><br /><span class="help"><?php echo $help_username; ?></span></label></td>
            <td><input type="text" name="eway_username" value="<?php echo $eway_username; ?>" id="input-username" />
              <?php if ($error_username) { ?>
              <span class="error"><?php echo $error_username; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-password"><?php echo $entry_password; ?><br /><span class="help"><?php echo $help_password; ?></span></label></td>
            <td><input type="password" name="eway_password" value="<?php echo $eway_password; ?>" id="input-password" />
              <?php if ($error_password) { ?>
              <span class="error"><?php echo $error_password; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-transaction-method"><?php echo $entry_transaction_method; ?><br /><span class="help"><?php echo $help_transaction_method; ?></span></label></td>
            <td><select name="eway_transaction_method" id="input-transaction-method">
              <?php if ($eway_transaction_method == 'auth') { ?>
                <option value="payment"><?php echo $text_sale; ?></option>
                <option value="auth" selected="selected"><?php echo $text_authorisation; ?></option>
              <?php } else { ?>
                <option value="payment" selected="selected"><?php echo $text_sale; ?></option>
                <option value="auth"><?php echo $text_authorisation; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="eway_payment_type"><?php echo $entry_payment_type; ?></label>
            <td>
              <p>
                <input type="hidden" name="eway_payment_type[visa]" value="0" />
                <input type="checkbox" name="eway_payment_type[visa]" id="eway_payment_type" value="1" <?php echo (isset($eway_payment_type['visa']) && $eway_payment_type['visa'] == 1 ? 'checked="checked"' : '') ?> /> CC - Visa
              </p>
              <p>
                <input type="hidden" name="eway_payment_type[mastercard]" value="0" />
                <input type="checkbox" name="eway_payment_type[mastercard]" value="1" <?php echo (isset($eway_payment_type['mastercard']) && $eway_payment_type['mastercard'] == 1 ? 'checked="checked"' : '') ?> /> CC - MasterCard
              </p>
              <p>
                <input type="hidden" name="eway_payment_type[amex]" value="0" />
                <input type="checkbox" name="eway_payment_type[amex]" value="1" <?php echo (isset($eway_payment_type['amex']) && $eway_payment_type['amex'] == 1 ? 'checked="checked"' : '') ?> /> CC - Amex
              </p>
              <p>
                <input type="hidden" name="eway_payment_type[diners]" value="0" />
                <input type="checkbox" name="eway_payment_type[diners]" value="1" <?php echo (isset($eway_payment_type['diners']) && $eway_payment_type['diners'] == 1 ? 'checked="checked"' : '') ?> /> CC - Diners Club
              </p>
              <p>
                <input type="hidden" name="eway_payment_type[jcb]" value="0" />
                <input type="checkbox" name="eway_payment_type[jcb]" value="1" <?php echo (isset($eway_payment_type['jcb']) && $eway_payment_type['jcb'] == 1 ? 'checked="checked"' : '') ?> /> CC - JCB
              </p>
              <p>
                <input type="hidden" name="eway_payment_type[paypal]" value="0" />
                <input type="checkbox" name="eway_payment_type[paypal]" value="1" <?php echo (isset($eway_payment_type['paypal']) && $eway_payment_type['paypal'] == 1 ? 'checked="checked"' : '') ?> /> PayPal
              </p>
              <p>
                <input type="hidden" name="eway_payment_type[masterpass]" value="0" />
                <input type="checkbox" name="eway_payment_type[masterpass]" value="1" <?php echo (isset($eway_payment_type['masterpass']) && $eway_payment_type['masterpass'] == 1 ? 'checked="checked"' : '') ?> /> MasterPass
              </p>
              <!--
              <p>
                <input type="hidden" name="eway_payment_type[vme]" value="0" />
                <input type="checkbox" name="eway_payment_type[vme]" value="1" <?php echo (isset($eway_payment_type['vme']) && $eway_payment_type['vme'] == 1 ? 'checked="checked"' : '') ?> /> Visa Checkout
              </p>
              -->

              <?php if ($error_payment_type) { ?>
              <span class="error"><?php echo $error_payment_type; ?></span>
              <?php } ?></td>
            </td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <td><select name="eway_standard_geo_zone_id" id="input-geo-zone">
                <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?><?php if ($geo_zone['geo_zone_id'] == $eway_standard_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?><?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status"><?php echo $entry_order_status; ?></label>
            <td><select name="eway_order_status_id" id="input-order-status">
              <?php foreach ($order_statuses as $order_status) { ?><?php if ($order_status['order_status_id'] == $eway_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?><?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-refund"><?php echo $entry_order_status_refund; ?></label>
            <td><select name="eway_order_status_refunded_id" id="input-order-status-refund">
              <?php foreach ($order_statuses as $order_status) { ?><?php if ($order_status['order_status_id'] == $eway_order_status_refunded_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?><?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-auth"><?php echo $entry_order_status_auth; ?></label>
            <td><select name="eway_order_status_auth_id" id="input-order-status-auth">
              <?php foreach ($order_statuses as $order_status) { ?><?php if ($order_status['order_status_id'] == $eway_order_status_auth_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?><?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-fraud"><?php echo $entry_order_status_fraud; ?></label>
            <td><select name="eway_order_status_fraud_id" id="input-order-status-fraud">
              <?php foreach ($order_statuses as $order_status) { ?><?php if ($order_status['order_status_id'] == $eway_order_status_fraud_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?><?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="eway_total" id="input-total" value="<?php echo !empty($eway_total) ? $eway_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="eway_total_max" id="input-total-max" value="<?php echo !empty($eway_total_max) ? $eway_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label>
            <td><select name="eway_status" id="input-status">
              <?php if ($eway_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-sort-order"><?php echo $entry_sort_order; ?></label></td>
            <td><input type="text" name="eway_sort_order" id="input-sort-order" value="<?php echo $eway_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>