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
    <div id="tabs" class="htabs">
      <a href="#tab-account"><?php echo $tab_account; ?></a>
      <a href="#tab-order-status"><?php echo $tab_order_status; ?></a>
      <a href="#tab-payment"><?php echo $tab_payment; ?></a>
    </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-account">
        <table class="form">
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-merchant-id"><?php echo $entry_merchant_id; ?></label></td>
            <td><input type="text" name="firstdata_remote_merchant_id" value="<?php echo $firstdata_remote_merchant_id; ?>" id="input-merchant-id" />
            <?php if ($error_merchant_id) { ?>
              <span class="error"><?php echo $error_merchant_id; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-user-id"><?php echo $entry_user_id; ?></label></td>
            <td><input type="text" name="firstdata_remote_user_id" value="<?php echo $firstdata_remote_user_id; ?>" id="input-user-id" />
            <?php if ($error_user_id) { ?>
              <span class="error"><?php echo $error_user_id; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-password"><?php echo $entry_password; ?></label></td>
            <td><input type="password" name="firstdata_remote_password" value="<?php echo $firstdata_remote_password; ?>" id="input-password" />
            <?php if ($error_password) { ?>
              <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-certificate-path"><?php echo $entry_certificate_path; ?></label></td>
            <td><input type="text" name="firstdata_remote_certificate" value="<?php echo $firstdata_remote_certificate; ?>" id="input-certificate-path" />
            <?php if ($error_certificate) { ?>
              <span class="error"><?php echo $error_certificate; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-key-path"><?php echo $entry_certificate_key_path; ?></label></td>
            <td><input type="text" name="firstdata_remote_key" value="<?php echo $firstdata_remote_key; ?>" id="input-key-path" />
            <?php if ($error_key) { ?>
              <span class="error"><?php echo $error_key; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-key-pw"><?php echo $entry_certificate_key_pw; ?></label></td>
            <td><input type="text" name="firstdata_remote_key_pw" value="<?php echo $firstdata_remote_key_pw; ?>" id="input-key-pw" />
            <?php if ($error_key_pw) { ?>
              <span class="error"><?php echo $error_key_pw; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-ca-path"><?php echo $entry_certificate_ca_path; ?></label></td>
            <td><input type="text" name="firstdata_remote_ca" value="<?php echo $firstdata_remote_ca; ?>" id="input-ca-path" />
            <?php if ($error_ca) { ?>
              <span class="error"><?php echo $error_ca; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-debug"><?php echo $entry_debug; ?><br /><span class="help"><?php echo $help_debug; ?></span></label></td>
            <td><select name="firstdata_remote_debug" id="input-debug">
              <?php if ($firstdata_remote_debug) { ?>
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
            <td><input type="text" name="firstdata_remote_total" id="input-total" value="<?php echo !empty($firstdata_remote_total) ? $firstdata_remote_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="firstdata_remote_total_max" id="input-total-max" value="<?php echo !empty($firstdata_remote_total_max) ? $firstdata_remote_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <td><select name="firstdata_remote_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $firstdata_remote_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label>
            <td><select name="firstdata_remote_status" id="input-status">
            <?php if ($firstdata_remote_status) { ?>
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
            <td><input type="text" name="firstdata_remote_sort_order" id="input-sort-order" value="<?php echo $firstdata_remote_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </div>
      <div id="tab-order-status">
        <table class="form">
          <tr>
            <td><label for="input-order-status-success-settled"><?php echo $entry_status_success_settled; ?></label>
            <td><select name="firstdata_remote_order_status_success_settled_id" id="input-order-status-success-settled">
            <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $firstdata_remote_order_status_success_settled_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-success-unsettled"><?php echo $entry_status_success_unsettled; ?></label>
            <td><select name="firstdata_remote_order_status_success_unsettled_id" id="input-order-status-success-unsettled">
            <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $firstdata_remote_order_status_success_unsettled_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-decline"><?php echo $entry_status_decline; ?></label>
            <td><select name="firstdata_remote_order_status_decline_id" id="input-order-status-decline">
            <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $firstdata_remote_order_status_decline_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
        </table>
      </div>
      <div id="tab-payment">
        <table class="form">
          <tr>
            <td><label for="input-auto-settle"><?php echo $entry_auto_settle; ?><br /><span class="help"><?php echo $help_settle; ?></span></label>
            <td><select name="firstdata_remote_auto_settle" id="input-auto-settle">
            <?php if (!$firstdata_remote_auto_settle) { ?>
              <option value="0"><?php echo $text_settle_delayed; ?></option>
              <option value="1" selected="selected"><?php echo $text_settle_auto; ?></option>
            <?php } ?>
            <?php if ($firstdata_remote_auto_settle) { ?>
              <option value="0" selected="selected"><?php echo $text_settle_delayed; ?></option>
              <option value="1"><?php echo $text_settle_auto; ?></option>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-card-store"><?php echo $entry_enable_card_store; ?></label>
            <td><select name="firstdata_remote_card_storage" id="input-card-store">
            <?php if ($firstdata_remote_card_storage) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label><?php echo $entry_cards_accepted; ?></label>
            <td>
            <?php foreach ($cards as $card) { ?>
              <div class="checkbox">
              <label>
              <?php if (in_array($card['value'], $firstdata_remote_cards_accepted)) { ?>
                <input type="checkbox" name="firstdata_remote_cards_accepted[]" value="<?php echo $card['value']; ?>" checked="checked" />
                <?php echo $card['text']; ?>
              <?php } else { ?>
                <input type="checkbox" name="firstdata_remote_cards_accepted[]" value="<?php echo $card['value']; ?>" />
                <?php echo $card['text']; ?>
              <?php } ?>
              </label>
              </div>
            <?php } ?>
          </td>
        </tr>
      </table>
    </div>
    </form>
  </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#tabs a:first').tab('show');
//--></script>

<?php echo $footer; ?>