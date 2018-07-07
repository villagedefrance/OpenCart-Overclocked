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
  <div class="attention"><?php echo $text_ip_message; ?></div>
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
        <a href="#tab-api"><?php echo $tab_api; ?></a>
        <a href="#tab-account"><?php echo $tab_account; ?></a>
        <a href="#tab-order-status"><?php echo $tab_order_status; ?></a>
        <a href="#tab-payment"><?php echo $tab_payment; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-api">
        <table class="form">
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-merchant-id"><?php echo $entry_merchant_id; ?></label></td>
            <td><?php if ($error_merchant_id) { ?>
              <input type="text" name="globalpay_remote_merchant_id" id="input-merchant-id" value="<?php echo $globalpay_remote_merchant_id; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_merchant_id; ?></span>
            <?php } else { ?>
              <input type="text" name="globalpay_remote_merchant_id" id="input-merchant-id" value="<?php echo $globalpay_remote_merchant_id; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-secret"><?php echo $entry_secret; ?></label></td>
            <td><?php if ($error_secret) { ?>
              <input type="password" name="globalpay_remote_secret" id="input-secret" value="<?php echo $globalpay_remote_secret; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_secret; ?></span>
            <?php } else { ?>
              <input type="password" name="globalpay_remote_secret" id="input-secret" value="<?php echo $globalpay_remote_secret; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-rebate-password"><?php echo $entry_rebate_password; ?></label></td>
            <td><input type="password" name="globalpay_remote_rebate_password" id="input-rebate-password" value="<?php echo $globalpay_remote_rebate_password; ?>" size="30" /></td>
          </td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
            <td><select name="globalpay_remote_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $globalpay_remote_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-debug"><?php echo $entry_debug; ?><br /><span class="help"><?php echo $help_debug; ?></span></label></td>
            <td><select name="globalpay_remote_debug" id="input-debug">
              <?php if ($globalpay_remote_debug) { ?>
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
            <td><select name="globalpay_remote_status" id="input-status">
              <?php if ($globalpay_remote_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-card"><?php echo $entry_card_data_status; ?><br /><span class="help"><?php echo $help_card_data_status; ?></span></label></td>
            <td><select name="globalpay_remote_card_data_status" id="input-card">
              <?php if ($globalpay_remote_card_data_status) { ?>
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
            <td><input type="text" name="globalpay_remote_total" id="input-total" value="<?php echo !empty($globalpay_remote_total) ? $globalpay_remote_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="globalpay_remote_total_max" id="input-total-max" value="<?php echo !empty($globalpay_remote_total_max) ? $globalpay_remote_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-sort-order"><?php echo $entry_sort_order; ?></label></td>
            <td><input type="text" name="globalpay_remote_sort_order" id="input-sort-order" value="<?php echo $globalpay_remote_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </div>
      <div id="tab-account">
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $text_card_type; ?></td>
              <td class="center"><?php echo $text_enabled; ?></td>
              <td class="center"><?php echo $text_use_default; ?></td>
              <td class="left"><?php echo $text_subaccount; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="left"><?php echo $text_card_visa; ?></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[visa][enabled]" value="1" <?php if (isset($globalpay_remote_account['visa']['enabled']) && $globalpay_remote_account['visa']['enabled'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[visa][default]" value="1" <?php if (isset($globalpay_remote_account['visa']['default']) && $globalpay_remote_account['visa']['default'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="right"><input type="text" name="globalpay_remote_account[visa][merchant_id]" value="<?php echo isset($globalpay_remote_account['visa']['merchant_id']) ? $globalpay_remote_account['visa']['merchant_id'] : ''; ?>" /></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_card_master; ?></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[mc][enabled]" value="1" <?php if (isset($globalpay_remote_account['mc']['enabled']) && $globalpay_remote_account['mc']['enabled'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[mc][default]" value="1" <?php if (isset($globalpay_remote_account['mc']['default']) && $globalpay_remote_account['mc']['default'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="right"><input type="text" name="globalpay_remote_account[mc][merchant_id]" value="<?php echo isset($globalpay_remote_account['mc']['merchant_id']) ? $globalpay_remote_account['mc']['merchant_id'] : ''; ?>" /></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_card_amex; ?></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[amex][enabled]" value="1" <?php if (isset($globalpay_remote_account['amex']['enabled']) && $globalpay_remote_account['amex']['enabled'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[amex][default]" value="1" <?php if (isset($globalpay_remote_account['amex']['default']) && $globalpay_remote_account['amex']['default'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="right"><input type="text" name="globalpay_remote_account[amex][merchant_id]" value="<?php echo isset($globalpay_remote_account['amex']['merchant_id']) ? $globalpay_remote_account['amex']['merchant_id'] : ''; ?>" /></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_card_switch; ?></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[switch][enabled]" value="1" <?php if (isset($globalpay_remote_account['switch']['enabled']) && $globalpay_remote_account['switch']['enabled'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[switch][default]" value="1" <?php if (isset($globalpay_remote_account['switch']['default']) && $globalpay_remote_account['switch']['default'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="right"><input type="text" name="globalpay_remote_account[switch][merchant_id]" value="<?php echo isset($globalpay_remote_account['switch']['merchant_id']) ? $globalpay_remote_account['switch']['merchant_id'] : ''; ?>" /></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_card_laser; ?></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[laser][enabled]" value="1" <?php if (isset($globalpay_remote_account['laser']['enabled']) && $globalpay_remote_account['laser']['enabled'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[laser][default]" value="1" <?php if (isset($globalpay_remote_account['laser']['default']) && $globalpay_remote_account['laser']['default'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="right"><input type="text" name="globalpay_remote_account[laser][merchant_id]" value="<?php echo isset($globalpay_remote_account['laser']['merchant_id']) ? $globalpay_remote_account['laser']['merchant_id'] : ''; ?>" /></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_card_diners; ?></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[diners][enabled]" value="1" <?php if (isset($globalpay_remote_account['diners']['enabled']) && $globalpay_remote_account['diners']['enabled'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="center"><input type="checkbox" name="globalpay_remote_account[diners][default]" value="1" <?php if (isset($globalpay_remote_account['diners']['default']) && $globalpay_remote_account['diners']['default'] == 1) { echo 'checked="checked" '; } ?> /></td>
              <td class="right"><input type="text" name="globalpay_remote_account[diners][merchant_id]" value="<?php echo isset($globalpay_remote_account['diners']['merchant_id']) ? $globalpay_remote_account['diners']['merchant_id'] : ''; ?>" /></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div id="tab-order-status">
        <table class="form">
          <tr>
            <td><label for="input-order-status-success-settled"><?php echo $entry_status_success_settled; ?></label></td>
            <td><select name="globalpay_remote_order_status_success_settled_id" id="input-order-status-success-settled">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $globalpay_remote_order_status_success_settled_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-success-unsettled"><?php echo $entry_status_success_unsettled; ?></label></td>
            <td><select name="globalpay_remote_order_status_success_unsettled_id" id="input-order-status-success-unsettled">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $globalpay_remote_order_status_success_unsettled_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-decline"><?php echo $entry_status_decline; ?></label></td>
            <td><select name="globalpay_remote_order_status_decline_id" id="input-order-status-decline">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $globalpay_remote_order_status_decline_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-decline-pending"><?php echo $entry_status_decline_pending; ?></label></td>
            <td><select name="globalpay_remote_order_status_decline_pending_id" id="input-order-status-decline-pending">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $globalpay_remote_order_status_decline_pending_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-decline-stolen"><?php echo $entry_status_decline_stolen; ?></label></td>
            <td><select name="globalpay_remote_order_status_decline_stolen_id" id="input-order-status-decline-stolen">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $globalpay_remote_order_status_decline_stolen_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-decline-bank"><?php echo $entry_status_decline_bank; ?></label></td>
            <td><select name="globalpay_remote_order_status_decline_bank_id" id="input-order-status-decline-bank">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $globalpay_remote_order_status_decline_bank_id) { ?>
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
            <td><label for="input-auto-settle"><?php echo $entry_auto_settle; ?></label></td>
            <td><select name="globalpay_remote_auto_settle" id="input-auto-settle">
              <option value="0" <?php echo ($globalpay_remote_auto_settle == 0 ? ' selected' : ''); ?>><?php echo $text_settle_delayed; ?></option>
              <option value="1" <?php echo ($globalpay_remote_auto_settle == 1 ? ' selected' : ''); ?>><?php echo $text_settle_auto; ?></option>
              <option value="2" <?php echo ($globalpay_remote_auto_settle == 2 ? ' selected' : ''); ?>><?php echo $text_settle_multi; ?></option>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-tss-check"><?php echo $entry_tss_check; ?></label></td>
            <td><select name="globalpay_remote_tss_check" id="input-tss-check">
              <?php if ($globalpay_remote_tss_check) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-3d"><?php echo $entry_3d; ?></label></td>
            <td><select name="globalpay_remote_3d" id="input-3d">
              <?php if ($globalpay_remote_3d) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-liability"><?php echo $entry_liability_shift; ?><br /><span class="help"><?php echo $help_liability; ?></span></label></td>
            <td><select name="globalpay_remote_liability" id="input-liability">
              <?php if ($globalpay_remote_liability) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select></td>
          </tr>
        </table>
      </div>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>