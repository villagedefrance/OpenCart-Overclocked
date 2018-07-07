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
            <td><span class="required">*</span>&nbsp;<label for="input-vendor"><?php echo $entry_vendor; ?></label></td>
            <td><?php if ($error_vendor) { ?>
              <input type="text" name="sagepay_direct_vendor" value="<?php echo $sagepay_direct_vendor; ?>" id="input-vendor" size="40" class="input-error" />
              <span class="error"><?php echo $error_vendor; ?></span>
            <?php } else { ?>
              <input type="text" name="sagepay_direct_vendor" value="<?php echo $sagepay_direct_vendor; ?>" id="input-vendor" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-test"><?php echo $entry_test; ?></label></td>
            <td><select name="sagepay_direct_test" id="input-test">
              <?php if ($sagepay_direct_test == 'sim') { ?>
                <option value="sim" selected="selected"><?php echo $text_sim; ?></option>
              <?php } else { ?>
                <option value="sim"><?php echo $text_sim; ?></option>
              <?php } ?>
              <?php if ($sagepay_direct_test == 'test') { ?>
                <option value="test" selected="selected"><?php echo $text_test; ?></option>
              <?php } else { ?>
                <option value="test"><?php echo $text_test; ?></option>
              <?php } ?>
              <?php if ($sagepay_direct_test == 'live') { ?>
                <option value="live" selected="selected"><?php echo $text_live; ?></option>
              <?php } else { ?>
                <option value="live"><?php echo $text_live; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-transaction"><?php echo $entry_transaction; ?><br /><span class="help"><?php echo $help_transaction; ?></span></label></td>
            <td><select name="sagepay_direct_transaction" id="input-transaction">
              <?php if ($sagepay_direct_transaction == 'PAYMENT') { ?>
                <option value="PAYMENT" selected="selected"><?php echo $text_payment; ?></option>
              <?php } else { ?>
                <option value="PAYMENT"><?php echo $text_payment; ?></option>
              <?php } ?>
              <?php if ($sagepay_direct_transaction == 'DEFERRED') { ?>
                <option value="DEFERRED" selected="selected"><?php echo $text_defered; ?></option>
              <?php } else { ?>
                <option value="DEFERRED"><?php echo $text_defered; ?></option>
              <?php } ?>
              <?php if ($sagepay_direct_transaction == 'AUTHENTICATE') { ?>
                <option value="AUTHENTICATE" selected="selected"><?php echo $text_authenticate; ?></option>
              <?php } else { ?>
                <option value="AUTHENTICATE"><?php echo $text_authenticate; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="sagepay_direct_total" value="<?php echo !empty($sagepay_direct_total) ? $sagepay_direct_total : '0.00'; ?>" id="input-total" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="sagepay_direct_total_max" value="<?php echo !empty($sagepay_direct_total_max) ? $sagepay_direct_total_max : '0.00'; ?>" id="input-total-max" /></td>
          </tr>
          <tr>
            <td><label for="input-card"><?php echo $entry_card; ?></label></td>
            <td><select name="sagepay_direct_card" id="input-card">
              <?php if ($sagepay_direct_card) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-order-status"><?php echo $entry_order_status; ?></label></td>
            <td><select name="sagepay_direct_order_status_id" id="input-order-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $sagepay_direct_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
            <td><select name="sagepay_direct_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $sagepay_direct_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-debug"><?php echo $entry_debug; ?><br /><span class="help"><?php echo $help_debug; ?></span></label></td>
            <td><select name="sagepay_direct_debug" id="input-debug">
              <?php if ($sagepay_direct_debug) { ?>
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
            <td><select name="sagepay_direct_status" id="input-status">
              <?php if ($sagepay_direct_status) { ?>
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
            <td><input type="text" name="sagepay_direct_sort_order" value="<?php echo $sagepay_direct_sort_order; ?>" id="input-sort-order" size="1" /></td>
          </tr>
          <tr>
            <td><label for="sagepay-direct-cron-job-token"><?php echo $entry_cron_job_token; ?><br /><span class="help"><?php echo $help_cron_job_token; ?></span></label></td>
            <td><input type="text" name="sagepay_direct_cron_job_token" value="<?php echo $sagepay_direct_cron_job_token; ?>" id="sagepay-direct-cron-job-token" size="80" /></td>
          </tr>
          <tr>
            <td><label for="input-cron-job-url"><?php echo $entry_cron_job_url; ?><br /><span class="help"><?php echo $help_cron_job_url; ?></span></label></td>
            <td><input type="text" name="sagepay_direct_cron_job_url" value="<?php echo $sagepay_direct_cron_job_url ?>" id="input-cron-job-url" size="80" /></td>
          </tr>
          <?php if ($sagepay_direct_last_cron_job_run) { ?>
          <tr>
            <td><?php echo $entry_last_cron_job_run; ?></td>
            <td><?php echo $sagepay_direct_last_cron_job_run; ?></td>
          </tr>
          <?php } ?>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>