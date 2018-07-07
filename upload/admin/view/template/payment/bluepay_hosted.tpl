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
            <td><span class="required">*</span>&nbsp;<label for="input-account-name"><?php echo $entry_account_name; ?></label></td>
            <td><?php if ($error_account_name) { ?>
              <input type="text" name="bluepay_hosted_account_name" value="<?php echo $bluepay_hosted_account_name; ?>" name="input-account-name" class="input-error" />
              <span class="error"><?php echo $error_account_name; ?></span>
            <?php } else { ?>
              <input type="text" name="bluepay_hosted_account_name" value="<?php echo $bluepay_hosted_account_name; ?>" name="input-account-name" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-account-id"><?php echo $entry_account_id; ?></label></td>
            <td><?php if ($error_account_id) { ?>
              <input type="text" name="bluepay_hosted_account_id" value="<?php echo $bluepay_hosted_account_id; ?>" id="input-account-id" class="input-error" />
              <span class="error"><?php echo $error_account_id; ?></span>
            <?php } else { ?>
              <input type="text" name="bluepay_hosted_account_id" value="<?php echo $bluepay_hosted_account_id; ?>" id="input-account-id" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-secret-key"><?php echo $entry_secret_key; ?></label></td>
            <td><?php if ($error_secret_key) { ?>
              <input type="text" name="bluepay_hosted_secret_key" value="<?php echo $bluepay_hosted_secret_key; ?>" id="input-secret-key" class="input-error" />
              <span class="error"><?php echo $error_secret_key; ?></span>
            <?php } else { ?>
              <input type="text" name="bluepay_hosted_secret_key" value="<?php echo $bluepay_hosted_secret_key; ?>" id="input-secret-key" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-test"><?php echo $entry_test; ?></label></td>
            <td><select name="bluepay_hosted_test" id="input-test">
              <?php if ($bluepay_hosted_test == 'test') { ?>
                <option value="test" selected="selected"><?php echo $text_test; ?></option>
              <?php } else { ?>
                <option value="test"><?php echo $text_test; ?></option>
              <?php } ?>
              <?php if ($bluepay_hosted_test == 'live') { ?>
                <option value="live" selected="selected"><?php echo $text_live; ?></option>
              <?php } else { ?>
                <option value="live"><?php echo $text_live; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-transaction"><?php echo $entry_transaction; ?><br /><span class="help"><?php echo $help_transaction; ?></span></label></td>
            <td><select name="bluepay_hosted_transaction" id="input-transaction">
              <?php if ($bluepay_hosted_transaction == 'SALE') { ?>
                <option value="SALE" selected="selected"><?php echo $text_sale; ?></option>
              <?php } else { ?>
                <option value="SALE"><?php echo $text_sale; ?></option>
              <?php } ?>
              <?php if ($bluepay_hosted_transaction == 'AUTH') { ?>
                <option value="AUTH" selected="selected"><?php echo $text_authenticate; ?></option>
              <?php } else { ?>
                <option value="AUTH"><?php echo $text_authenticate; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-amex"><?php echo $entry_card_amex; ?></label></td>
            <td><select name="bluepay_hosted_amex" id="input-amex">
              <?php if ($bluepay_hosted_amex) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-discover"><?php echo $entry_card_discover; ?></label></td>
            <td><select name="bluepay_hosted_discover" id="input-discover">
              <?php if ($bluepay_hosted_discover) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="bluepay_hosted_total" id="input-total" value="<?php echo !empty($bluepay_hosted_total) ? $bluepay_hosted_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="bluepay_hosted_total_max" id="input-total-max" value="<?php echo !empty($bluepay_hosted_total_max) ? $bluepay_hosted_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-order-status"><?php echo $entry_order_status; ?></label></td>
            <td><select name="bluepay_hosted_order_status_id" id="input-order-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $bluepay_hosted_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
            <td><select name="bluepay_hosted_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $bluepay_hosted_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-debug"><?php echo $entry_debug; ?><br /><span class="help"><?php echo $help_debug; ?></span></label></td>
            <td><select name="bluepay_hosted_debug" id="input-debug">
              <?php if ($bluepay_hosted_debug) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label></td>
            <td><select name="bluepay_hosted_status" id="input-status">
              <?php if ($bluepay_hosted_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
        </table>
      </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>