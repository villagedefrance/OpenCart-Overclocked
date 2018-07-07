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
        <a href="#tab-advanced"><?php echo $tab_advanced; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-account">
        <table class="form">
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-merchant-id"><?php echo $entry_merchant_id; ?></label></td>
            <td><?php if ($error_merchant_id) { ?>
              <input type="text" name="firstdata_merchant_id" value="<?php echo $firstdata_merchant_id; ?>" id="input-merchant-id" class="input-error" />
                <span class="error"><?php echo $error_merchant_id; ?></span>
            <?php } else { ?>
              <input type="text" name="firstdata_merchant_id" value="<?php echo $firstdata_merchant_id; ?>" id="input-merchant-id" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-secret"><?php echo $entry_secret; ?></label></td>
            <td><?php if ($error_secret) { ?>
              <input type="text" name="firstdata_secret" value="<?php echo $firstdata_secret; ?>" id="input-secret" class="input-error" />
                <span class="error"><?php echo $error_secret; ?></span>
            <?php } else { ?>
              <input type="text" name="firstdata_secret" value="<?php echo $firstdata_secret; ?>" id="input-secret" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-live-demo"><?php echo $entry_live_demo; ?></label></td>
            <td><select name="firstdata_live_demo" id="input-live_demo">
              <?php if ($firstdata_live_demo) { ?>
                <option value="1" selected="selected"><?php echo $text_live; ?></option>
                <option value="0"><?php echo $text_demo; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_live; ?></option>
                <option value="0" selected="selected"><?php echo $text_demo; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><select name="firstdata_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $firstdata_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-debug"><?php echo $entry_debug; ?><br /><span class="help"><?php echo $help_debug; ?></span></label></td>
            <td><select name="firstdata_debug" id="input-debug">
              <?php if ($firstdata_debug) { ?>
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
            <td><select name="firstdata_status" id="input-status">
              <?php if ($firstdata_status) { ?>
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
            <td><input type="text" name="firstdata_total" id="input-total" value="<?php echo !empty($firstdata_total) ? $firstdata_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="firstdata_total_max" id="input-total-max" value="<?php echo !empty($firstdata_total_max) ? $firstdata_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-sort-order"><?php echo $entry_sort_order; ?></label></td>
            <td><input type="text" name="firstdata_sort_order" id="input-sort-order" value="<?php echo $firstdata_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </div>
      <div id="tab-order-status">
        <table class="form">
          <tr>
            <td><label for="input-order-status-success-settled"><?php echo $entry_status_success_settled; ?></label></td>
            <td><select name="firstdata_order_status_success_settled_id" id="input-order-status-success-settled">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $firstdata_order_status_success_settled_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-success-unsettled"><?php echo $entry_status_success_unsettled; ?></label></td>
            <td><select name="firstdata_order_status_success_unsettled_id" id="input-order-status-success-unsettled">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $firstdata_order_status_success_unsettled_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-decline"><?php echo $entry_status_decline; ?></label></td>
            <td><select name="firstdata_order_status_decline_id" id="input-order-status-decline">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $firstdata_order_status_decline_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status-void"><?php echo $entry_status_void; ?></label></td>
            <td><select name="firstdata_order_status_void_id" id="input-order-status-void">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $firstdata_order_status_void_id) { ?>
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
            <td><select name="firstdata_auto_settle" id="input-auto-settle">
              <option value="0" <?php echo ($firstdata_auto_settle == 0 ? ' selected' : ''); ?>><?php echo $text_settle_delayed; ?></option>
              <option value="1" <?php echo ($firstdata_auto_settle == 1 ? ' selected' : ''); ?>><?php echo $text_settle_auto; ?></option>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-card-store"><?php echo $entry_enable_card_store; ?></label>
            <td><select name="firstdata_card_storage" id="input-card-store">
              <?php if ($firstdata_card_storage) { ?>
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
      <div id="tab-advanced">
        <table class="form">
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-live-url"><?php echo $entry_live_url; ?></label></td>
            <td><?php if ($error_live_url) { ?>
              <input type="text" name="firstdata_live_url" value="<?php echo $firstdata_live_url; ?>" id="input-live-url" size="80" class="input-error" />
                <span class="error"><?php echo $error_live_url; ?></span>
            <?php } else { ?>
              <input type="text" name="firstdata_live_url" value="<?php echo $firstdata_live_url; ?>" id="input-live-url" size="80" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-demo-url"><?php echo $entry_demo_url; ?></label></td>
            <td><?php if ($error_demo_url) { ?>
              <input type="text" name="firstdata_demo_url" value="<?php echo $firstdata_demo_url; ?>" id="input-demo-url" size="80" class="input-error" />
                <span class="error"><?php echo $error_demo_url; ?></span>
            <?php } else { ?>
              <input type="text" name="firstdata_demo_url" value="<?php echo $firstdata_demo_url; ?>" id="input-demo-url" size="80" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-notify-url"><?php echo $text_notification_url; ?><br /><span class="help"><?php echo $help_notification; ?></span></label></td>
            <td><input type="text" name="firstdata_notify_url" value="<?php echo $notify_url; ?>" id="input-notify-url" size="80" /></td>
          </tr>
        </table>
      </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>

<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#tabs a:first').tab('show');
//--></script>