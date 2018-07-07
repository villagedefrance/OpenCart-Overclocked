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
        <a href="#tab-general"><?php echo $tab_settings; ?></a>
        <a href="#tab-order-status"><?php echo $tab_order_status; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
        <table class="form">
          <tr>
            <td><span class="required">*</span>&nbsp;<?php echo $entry_service_key; ?></td>
            <td><?php if ($error_service_key) { ?>
              <input type="text" name="worldpay_online_service_key" value="<?php echo $worldpay_online_service_key; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_service_key; ?></span>
            <?php } else { ?>
              <input type="text" name="worldpay_online_service_key" value="<?php echo $worldpay_online_service_key; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<?php echo $entry_client_key; ?></td>
            <td><?php if ($error_client_key) { ?>
              <input type="text" name="worldpay_online_client_key" value="<?php echo $worldpay_online_client_key; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_client_key; ?></span>
            <?php } else { ?>
              <input type="text" name="worldpay_online_client_key" value="<?php echo $worldpay_online_client_key; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="worldpay_online_total" id="input-total" value="<?php echo !empty($worldpay_online_total) ? $worldpay_online_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="worldpay_online_total_max" id="input-total-max" value="<?php echo !empty($worldpay_online_total_max) ? $worldpay_online_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-card"><?php echo $entry_card; ?></label></td>
            <td><select name="worldpay_online_card" id="input-card">
              <?php if ($worldpay_online_card) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-secret-token"><?php echo $entry_secret_token; ?><br /><span class="help"><?php echo $help_secret_token; ?></span></label></td>
            <td><input type="text" name="worldpay_online_secret_token" id="input-secret-token" value="<?php echo $worldpay_online_secret_token; ?>" size="60" /></td>
          </tr>
          <tr>
            <td><label for="input-webhook-url"><?php echo $entry_webhook_url; ?><br /><span class="help"><?php echo $help_webhook_url; ?></span></label></td>
            <td><input type="text" readonly name="worldpay_online_webhook_url" id="input-webhook-url" value="<?php echo $worldpay_online_webhook_url; ?>" size="80" /></td>
          </tr>
          <tr>
            <td><label for="input-cron-job-url"><?php echo $entry_cron_job_url; ?><br /><span class="help"><?php echo $help_cron_job_url; ?></span></label></td>
            <td><input type="text" readonly name="worldpay_online_cron_job_url" id="input-cron-job-url" value="<?php echo $worldpay_online_cron_job_url ?>" size="80" /></td>
          </tr>
        <?php if ($worldpay_online_last_cron_job_run) { ?>
          <tr>
            <td><?php echo $entry_last_cron_job_run; ?></td>
            <td><?php echo $worldpay_online_last_cron_job_run; ?></td>
          </tr>
        <?php } ?>
          <tr>
            <td><label for="input-order-status"><?php echo $entry_order_status; ?></label></td>
            <td><select name="worldpay_online_order_status_id" id="input-order-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $worldpay_online_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
            <td><select name="worldpay_online_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $worldpay_online_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-debug"><?php echo $entry_debug; ?><br /><span class="help"><?php echo $help_debug; ?></span></label></td>
            <td><select name="worldpay_online_debug" id="input-debug">
              <?php if ($worldpay_online_debug) { ?>
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
            <td><select name="worldpay_online_status" id="input-status">
              <?php if ($worldpay_online_status) { ?>
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
            <td><input type="text" name="worldpay_online_sort_order" value="<?php echo $worldpay_online_sort_order; ?>" id="input-sort-order" size="1" /></td>
          </tr>
        </table>
      </div>
      <div id="tab-order-status">
        <table class="form">
          <tr>
            <td><label for="input-entry-success-status"><?php echo $entry_success_status; ?></label>
            <td><select name="worldpay_online_entry_success_status_id" id="input-entry-success-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $worldpay_online_entry_success_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-entry-failed-status"><?php echo $entry_failed_status; ?></label>
            <td><select name="worldpay_online_entry_failed_status_id" id="input-entry-failed-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $worldpay_online_entry_failed_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-entry-settled-status"><?php echo $entry_settled_status; ?></label>
            <td><select name="worldpay_online_entry_settled_status_id" id="input-entry-settled-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $worldpay_online_entry_settled_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-entry-refunded-status"><?php echo $entry_refunded_status; ?></label>
            <td><select name="worldpay_online_entry_refunded_status_id" id="input-entry-refunded-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $worldpay_online_entry_refunded_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-entry-partially-refunded-status"><?php echo $entry_partially_refunded_status; ?></label>
            <td><select name="worldpay_online_entry_partially_refunded_status_id" id="input-entry-partially-refunded-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $worldpay_online_entry_partially_refunded_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-entry-charged-back-status"><?php echo $entry_charged_back_status; ?></label>
            <td><select name="worldpay_online_entry_charged_back_status_id" id="input-entry-charged-back-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $worldpay_online_entry_charged_back_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-entry-information-requested-status"><?php echo $entry_information_requested_status; ?></label>
            <td><select name="worldpay_online_entry_information_requested_status_id" id="input-entry-information-requested-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $worldpay_online_entry_information_requested_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-entry-information-supplied-status"><?php echo $entry_information_supplied_status; ?></label>
            <td><select name="worldpay_online_entry_information_supplied_status_id" id="input-entry-information-supplied-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $worldpay_online_entry_information_supplied_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-entry-chargeback-reversed-status"><?php echo $entry_chargeback_reversed_status; ?></label>
            <td><select name="worldpay_online_entry_chargeback_reversed_status_id" id="input-entry-chargeback-reversed-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $worldpay_online_entry_chargeback_reversed_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
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
$('#tabs a:first').tab('show');
//--></script>

<?php echo $footer; ?>