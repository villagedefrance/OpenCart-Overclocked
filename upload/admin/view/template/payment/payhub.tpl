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
            <td><span class="required">*</span> <?php echo $entry_org_id; ?></td>
            <td><?php if ($error_org_id) { ?>
              <input type="text" name="payhub_org_id" value="<?php echo $payhub_org_id; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_org_id; ?></span>
            <?php } else { ?>
              <input type="text" name="payhub_org_id" value="<?php echo $payhub_org_id; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_username; ?></td>
            <td><?php if ($error_username) { ?>
              <input type="text" name="payhub_username" value="<?php echo $payhub_username; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_username; ?></span>
            <?php } else { ?>
              <input type="text" name="payhub_username" value="<?php echo $payhub_username; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_password; ?></td>
            <td><?php if ($error_password) { ?>
              <input type="text" name="payhub_password" value="<?php echo $payhub_password; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_password; ?></span>
            <?php } else { ?>
              <input type="text" name="payhub_password" value="<?php echo $payhub_password; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_terminal_id; ?></td>
            <td><?php if ($error_terminal_id) { ?>
              <input type="text" name="payhub_terminal_id" value="<?php echo $payhub_terminal_id; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_terminal_id; ?></span>
            <?php } else { ?>
              <input type="text" name="payhub_terminal_id" value="<?php echo $payhub_terminal_id; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_mode; ?></td>
            <td><select name="payhub_mode">
              <?php if ($payhub_mode == 'live') { ?>
                <option value="live" selected="selected"><?php echo $text_live; ?></option>
              <?php } else { ?>
                <option value="live"><?php echo $text_live; ?></option>
              <?php } ?>
              <?php if ($payhub_mode == 'test') { ?>
                <option value="test" selected="selected"><?php echo $text_test; ?></option>
              <?php } else { ?>
                <option value="test"><?php echo $text_test; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_cards_accepted; ?></td>
            <td><input type="text" name="payhub_cards_accepted" value="<?php echo $payhub_cards_accepted; ?>" />
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_invoice_prefix; ?></td>
            <td><?php if ($error_invoice_prefix) { ?>
              <input type="text" name="payhub_invoice_prefix" value="<?php echo $payhub_invoice_prefix; ?>" class="input-error" />
              <span class="error"><?php echo $error_invoice_prefix; ?></span>
            <?php } else { ?>
              <input type="text" name="payhub_invoice_prefix" value="<?php echo $payhub_invoice_prefix; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?></label></td>
            <td><input type="text" name="payhub_total" id="input-total" value="<?php echo !empty($payhub_total) ? $payhub_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?></label></td>
            <td><input type="text" name="payhub_total_max" id="input-total-max" value="<?php echo !empty($payhub_total_max) ? $payhub_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="payhub_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $payhub_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="payhub_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $payhub_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="payhub_status">
              <?php if ($payhub_status) { ?>
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
            <td><input type="text" name="payhub_sort_order" value="<?php echo $payhub_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 