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
            <td><span class="required">*</span>&nbsp;<label for="input-email"><?php echo $entry_email; ?></label></td>
            <td><?php if ($error_email) { ?>
              <input type="text" name="nochex_email" id="input-email" value="<?php echo $nochex_email; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_email; ?></span>
            <?php } else { ?>
              <input type="text" name="nochex_email" id="input-email" value="<?php echo $nochex_email; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-account"><?php echo $entry_account; ?></label></td>
            <td><select name="nochex_account" id="input-account">
              <?php if ($nochex_account == 'seller') { ?>
                <option value="seller" selected="selected"><?php echo $text_seller; ?></option>
              <?php } else { ?>
                <option value="seller"><?php echo $text_seller; ?></option>
              <?php } ?>
              <?php if ($nochex_account == 'merchant') { ?>
                <option value="merchant" selected="selected"><?php echo $text_merchant; ?></option>
              <?php } else { ?>
                <option value="merchant"><?php echo $text_merchant; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-merchant"><?php echo $entry_merchant; ?></label></td>
            <td><?php if ($error_merchant) { ?>
              <input type="text" name="nochex_merchant" id="input-merchant" value="<?php echo $nochex_merchant; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_merchant; ?></span>
            <?php } else { ?>
              <input type="text" name="nochex_merchant" id="input-merchant" value="<?php echo $nochex_merchant; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_template; ?></td>
            <td><?php if ($nochex_template) { ?>
              <input type="radio" name="nochex_template" id="input-template-yes" value="1" checked="checked" /><label for="input-template-yes"><?php echo $text_yes; ?></label>
              <input type="radio" name="nochex_template" id="input-template-no" value="0" /><label for="input-template-no"><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="nochex_template" id="input-template-yes" value="1" /><label for="input-template-yes"><?php echo $text_yes; ?></label>
              <input type="radio" name="nochex_template" id="input-template-no" value="0" checked="checked" /><label for="input-template-no"><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_test; ?></td>
            <td><?php if ($nochex_test) { ?>
              <input type="radio" name="nochex_test" id="input-test-yes" value="1" checked="checked" /><label for="input-test-yes"><?php echo $text_yes; ?></label>
              <input type="radio" name="nochex_test" id="input-test-no" value="0" /><label for="input-test-no"><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="nochex_test" id="input-test-yes" value="1" /><label for="input-test-yes"><?php echo $text_yes; ?></label>
              <input type="radio" name="nochex_test" id="input-test-no" value="0" checked="checked" /><label for="input-test-no"><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="nochex_total" id="input-total" value="<?php echo !empty($nochex_total) ? $nochex_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="nochex_total_max" id="input-total-max" value="<?php echo !empty($nochex_total_max) ? $nochex_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-order-status"><?php echo $entry_order_status; ?></label></td>
            <td><select name="nochex_order_status_id" id="input-order-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $nochex_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
            <td><select name="nochex_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $nochex_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label></td>
            <td><select name="nochex_status" id="input-status">
              <?php if ($nochex_status) { ?>
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
            <td><input type="text" name="nochex_sort_order" value="<?php echo $nochex_sort_order; ?>" id="input-sort-order" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>