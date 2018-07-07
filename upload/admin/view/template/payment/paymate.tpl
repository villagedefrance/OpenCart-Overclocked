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
            <td><span class="required">*</span>&nbsp;<label for="input-username"><?php echo $entry_username; ?></label></td>
            <td><?php if ($error_username) { ?>
              <input type="text" name="paymate_username" id="input-username" value="<?php echo $paymate_username; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_username; ?></span>
            <?php } else { ?>
              <input type="text" name="paymate_username" id="input-username" value="<?php echo $paymate_username; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-password"><?php echo $entry_password; ?><br /><span class="help"><?php echo $help_password; ?></span></label></td>
            <td><?php if ($error_password) { ?>
              <input type="text" name="paymate_password" id="input-password" value="<?php echo $paymate_password; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_password; ?></span>
            <?php } else { ?>
              <input type="text" name="paymate_password" id="input-password" value="<?php echo $paymate_password; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_test; ?></td>
            <td><?php if ($paymate_test) { ?>
              <input type="radio" name="paymate_test" id="input-test-yes" value="1" checked="checked" /><label for="input-test-yes"><?php echo $text_yes; ?></label>
            <?php } else { ?>
              <input type="radio" name="paymate_test" id="input-test-yes" value="1" /><label for="input-test-yes"><?php echo $text_yes; ?></label>
            <?php } ?>
            <?php if (!$paymate_test) { ?>
              <input type="radio" name="paymate_test" id="input-test-no" value="0" checked="checked" /><label for="input-test-no"><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="paymate_test" id="input-test-no" value="0" /><label for="input-test-no"><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="paymate_total" id="input-total" value="<?php echo !empty($paymate_total) ? $paymate_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="paymate_total_max" id="input-total-max" value="<?php echo !empty($paymate_total_max) ? $paymate_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-order-status"><?php echo $entry_order_status; ?></label></td>
            <td><select name="paymate_order_status_id" id="input-order-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $paymate_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
            <td><select name="paymate_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $paymate_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label></td>
            <td><select name="paymate_status" id="input-status">
              <?php if ($paymate_status) { ?>
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
            <td><input type="text" name="paymate_sort_order" value="<?php echo $paymate_sort_order; ?>" id="input-sort-order" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>