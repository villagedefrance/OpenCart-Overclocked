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
            <td><span class="required">*</span>&nbsp;<label for="input-merchant"><?php echo $entry_merchant; ?></label></td>
            <td><?php if ($error_merchant) { ?>
              <input type="text" name="worldpay_merchant" id="input-merchant" value="<?php echo $worldpay_merchant; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_merchant; ?></span>
            <?php } else { ?>
              <input type="text" name="worldpay_merchant" id="input-merchant" value="<?php echo $worldpay_merchant; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-password"><?php echo $entry_password; ?><br /><span class="help"><?php echo $help_password; ?></span></label></td>
            <td><?php if ($error_password) { ?>
              <input type="text" name="worldpay_password" id="input-password" value="<?php echo $worldpay_password; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_password; ?></span>
            <?php } else { ?>
              <input type="text" name="worldpay_password" id="input-password" value="<?php echo $worldpay_password; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-callback"><?php echo $entry_callback; ?><br /><span class="help"><?php echo $help_callback; ?></span></label></td>
            <td><textarea name="worldpay_callback" id="input-callback" cols="40" rows="5" readonly="readonly"><?php echo $callback; ?></textarea></td>
          </tr>
          <tr>
            <td><label for="input-test"><?php echo $entry_test; ?></label></td>
            <td><select name="worldpay_test" id="input-test">
              <?php if ($worldpay_test == '0') { ?>
                <option value="0" selected="selected"><?php echo $text_off; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_off; ?></option>
              <?php } ?>
              <?php if ($worldpay_test == '100') { ?>
                <option value="100" selected="selected"><?php echo $text_successful; ?></option>
              <?php } else { ?>
                <option value="100"><?php echo $text_successful; ?></option>
              <?php } ?>
              <?php if ($worldpay_test == '101') { ?>
                <option value="101" selected="selected"><?php echo $text_declined; ?></option>
              <?php } else { ?>
                <option value="101"><?php echo $text_declined; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="worldpay_total" id="input-total" value="<?php echo !empty($worldpay_total) ? $worldpay_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="worldpay_total_max" id="input-total-max" value="<?php echo !empty($worldpay_total_max) ? $worldpay_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-order-status"><?php echo $entry_order_status; ?></label></td>
            <td><select name="worldpay_order_status_id" id="input-order-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $worldpay_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
            <td><select name="worldpay_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $worldpay_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label></td>
            <td><select name="worldpay_status" id="input-status">
              <?php if ($worldpay_status) { ?>
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
            <td><input type="text" name="worldpay_sort_order" id="input-sort-order" value="<?php echo $worldpay_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>