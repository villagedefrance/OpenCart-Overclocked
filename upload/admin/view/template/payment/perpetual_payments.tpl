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
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
        <table class="form">
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-auth-id"><?php echo $entry_auth_id; ?></label></td>
            <td><input type="text" name="perpetual_payments_auth_id" id="input-auth-id" value="<?php echo $perpetual_payments_auth_id; ?>" />
              <?php if ($error_auth_id) { ?>
              <span class="error"><?php echo $error_auth_id; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-auth-pass"><?php echo $entry_auth_pass; ?></label></td>
            <td><input type="password" name="perpetual_payments_auth_pass" id="input-auth-pass" value="<?php echo $perpetual_payments_auth_pass; ?>" />
              <?php if ($error_auth_pass) { ?>
              <span class="error"><?php echo $error_auth_pass; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-test"><?php echo $entry_test; ?><br /><span class="help"><?php echo $help_test; ?></label></td>
            <td><select name="perpetual_payments_test" id="input-test">
              <?php if ($perpetual_payments_test) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></label></td>
            <td><input type="text" name="perpetual_payments_total" id="input-total" value="<?php echo !empty($perpetual_payments_total) ? $perpetual_payments_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></label></td>
            <td><input type="text" name="perpetual_payments_total_max" id="input-total-max" value="<?php echo !empty($perpetual_payments_total_max) ? $perpetual_payments_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-order-status"><?php echo $entry_order_status; ?></label>
            <td><select name="perpetual_payments_order_status_id" id="input-order-status">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $perpetual_payments_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <td><select name="perpetual_payments_geo_zone_id" id="input-geo-zone">
                <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $perpetual_payments_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label>
            <td><select name="perpetual_payments_status" id="input-status">
              <?php if ($perpetual_payments_status) { ?>
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
            <td><input type="text" name="perpetual_payments_sort_order" id="input-sort-order" value="<?php echo $perpetual_payments_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>