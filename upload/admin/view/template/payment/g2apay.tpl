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
            <td><span class="required">*</span>&nbsp;<label for="input-username"><?php echo $entry_username; ?><br /><span class="help"><?php echo $help_username; ?></span></label></td>
            <td><input type="text" name="g2apay_username" value="<?php echo $g2apay_username; ?>" id="input-username" />
              <?php if ($error_username) { ?>
              <span class="error"><?php echo $error_username; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-secret"><?php echo $entry_secret; ?></label></td>
            <td><input type="text" name="g2apay_secret" value="<?php echo $g2apay_secret; ?>" id="input-secret" />
              <?php if ($error_secret) { ?>
              <span class="error"><?php echo $error_secret; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-api-hash"><?php echo $entry_api_hash; ?></label></td>
            <td><input type="text" name="g2apay_api_hash" value="<?php echo $g2apay_api_hash; ?>" id="input-api-hash" size="80" />
              <?php if ($error_api_hash) { ?>
              <span class="error"><?php echo $error_api_hash; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><label for="input-environment"><?php echo $entry_environment; ?></label></td>
            <td><select name="g2apay_environment" id="input-environment">
              <?php if ($g2apay_environment) { ?>
                <option value="1" selected="selected"><?php echo $g2apay_environment_live; ?></option>
                <option value="0"><?php echo $g2apay_environment_test; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $g2apay_environment_live; ?></option>
                <option value="0" selected="selected"><?php echo $g2apay_environment_test; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-secret-token"><?php echo $entry_secret_token; ?><br /><span class="help"><?php echo $help_secret_token; ?></span></label></td>
            <td><input type="text" name="g2apay_secret_token" value="<?php echo $g2apay_secret_token; ?>" id="input-secret-token" size="80" />
          </tr>
          <tr>
            <td><label for="input-ipn-url"><?php echo $entry_ipn_url; ?><br /><span class="help"><?php echo $help_ipn_url; ?></span></label></td>
            <td><input type="text" readonly="readonly" name="g2apay_ipn_url" value="<?php echo $g2apay_ipn_url; ?>" id="input-ipn-url" size="80" />
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="g2apay_total" id="input-total" value="<?php echo !empty($g2apay_total) ? $g2apay_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="g2apay_total_max" id="input-total-max" value="<?php echo !empty($g2apay_total_max) ? $g2apay_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <td><select name="g2apay_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $g2apay_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-debug"><?php echo $entry_debug; ?><br /><span class="help"><?php echo $help_debug; ?></span></label></td>
            <td><select name="g2apay_debug" id="input-debug">
              <?php if ($g2apay_debug) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label>
            <td><select name="g2apay_status" id="input-status">
              <?php if ($g2apay_status) { ?>
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
            <td><input type="text" name="g2apay_sort_order" id="input-sort-order" value="<?php echo $g2apay_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </div>
      <div id="tab-order-status">
        <table class="form">
          <tr>
            <td><label for="input-order-status"><?php echo $entry_order_status; ?></label>
            <td><select name="g2apay_order_status_id" id="input-order-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $g2apay_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-complete-status"><?php echo $entry_complete_status; ?></label>
            <td><select name="g2apay_complete_status_id" id="input-complete-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $g2apay_complete_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-rejected-status"><?php echo $entry_rejected_status; ?></label>
            <td><select name="g2apay_rejected_status_id" id="input-rejected-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $g2apay_rejected_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-cancelled-status"><?php echo $entry_cancelled_status; ?></label>
            <td><select name="g2apay_cancelled_status_id" id="input-cancelled-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $g2apay_cancelled_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-pending-status"><?php echo $entry_pending_status; ?></label>
            <td><select name="g2apay_pending_status_id" id="input-pending-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $g2apay_pending_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-refunded-status"><?php echo $entry_refunded_status; ?></label>
            <td><select name="g2apay_refunded_status_id" id="input-refunded-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $g2apay_refunded_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-partially-refunded-status"><?php echo $entry_partially_refunded_status; ?></label>
            <td><select name="g2apay_partially_refunded_status_id" id="input-partially-refunded-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $g2apay_partially_refunded_status_id) { ?>
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