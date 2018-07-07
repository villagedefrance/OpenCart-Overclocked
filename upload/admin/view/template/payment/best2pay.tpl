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
            <td><span class="required">*</span> <?php echo $entry_sector; ?></td>
            <td><input type="text" name="best2pay_sector" value="<?php echo $best2pay_sector; ?>" />
            <?php if ($error_sector) { ?>
              <span class="error"><?php echo $error_sector; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_password; ?></td>
            <td><input type="text" name="best2pay_password" value="<?php echo $best2pay_password; ?>" />
            <?php if ($error_password) { ?>
              <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_callback; ?></td>
            <td><textarea name="best2pay_callback" cols="40" rows="5"><?php echo $callback; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_currency; ?></td>
            <td><select name="best2pay_currency">
              <?php foreach ($currencies as $currency) { ?>
                <?php if ($currency['code'] == $best2pay_currency) { ?>
                  <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_commission; ?></td>
            <td><input type="text" name="best2pay_commission" value="<?php echo $best2pay_commission; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_commission_pay; ?></td>
            <td><select name="best2pay_commission_pay">
              <?php if ($best2pay_commission_pay == '0') { ?>
                <option value="0" selected="selected"><?php echo $text_seller; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_seller; ?></option>
              <?php } ?>
              <?php if ($best2pay_commission_pay == '1') { ?>
                <option value="1" selected="selected"><?php echo $text_buyer; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_buyer; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_test; ?></td>
            <td><select name="best2pay_test">
              <?php if ($best2pay_test == '0') { ?>
                <option value="0" selected="selected"><?php echo $text_off; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_off; ?></option>
              <?php } ?>
              <?php if ($best2pay_test == '1') { ?>
                <option value="1" selected="selected"><?php echo $text_on; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_on; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_total; ?></td>
            <td><input type="text" name="best2pay_total" value="<?php echo $best2pay_total; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="best2pay_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $best2pay_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="best2pay_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $best2pay_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="best2pay_status">
              <?php if ($best2pay_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="best2pay_sort_order" value="<?php echo $best2pay_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 