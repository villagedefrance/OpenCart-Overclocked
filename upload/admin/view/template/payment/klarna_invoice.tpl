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
  <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
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
      <div id="htabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general ?></a>
        <a href="#tab-log"><?php echo $tab_log ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general"><a onclick="window.open(\'https://klarna.com/sell-with-klarna\');" style="float:right;"><img src="view/image/payment/klarna.png" alt="" /></a>
        <div id="vtabs" class="vtabs">
          <?php foreach ($countries as $country) { ?>
            <a href="#tab-<?php echo $country['code']; ?>"><?php echo $country['name']; ?></a>
          <?php } ?>
        </div>
        <?php foreach ($countries as $country) { ?>
        <div id="tab-<?php echo $country['code']; ?>" class="vtabs-content">
          <table class="form">
            <tr>
              <td><label for="input-merchant"><?php echo $entry_merchant; ?><br /><span class="help"><?php echo $help_merchant; ?></span></label></td>
              <td><input type="text" name="klarna_invoice[<?php echo $country['code']; ?>][merchant]" id="input-merchant" value="<?php echo isset($klarna_invoice[$country['code']]) ? $klarna_invoice[$country['code']]['merchant'] : ''; ?>" size="40" /></td>
            </tr>
            <tr>
              <td><label for="input-secret"><?php echo $entry_secret; ?><br /><span class="help"><?php echo $help_secret; ?></span></label></td>
              <td><input type="text" name="klarna_invoice[<?php echo $country['code']; ?>][secret]" id="input-secret" value="<?php echo isset($klarna_invoice[$country['code']]) ? $klarna_invoice[$country['code']]['secret'] : ''; ?>" size="40" /></td>
            </tr>
            <tr>
              <td><label for="input-server"><?php echo $entry_server; ?></label></td>
              <td><select name="klarna_invoice[<?php echo $country['code']; ?>][server]" id="input-server">
                <?php if (isset($klarna_invoice[$country['code']]) && $klarna_invoice[$country['code']]['server'] == 'live') { ?>
                  <option value="live" selected="selected"><?php echo $text_live; ?></option>
                <?php } else { ?>
                  <option value="live"><?php echo $text_live; ?></option>
                <?php } ?>
                <?php if (isset($klarna_invoice[$country['code']]) && $klarna_invoice[$country['code']]['server'] == 'beta') { ?>
                  <option value="beta" selected="selected"><?php echo $text_beta; ?></option>
                <?php } else { ?>
                  <option value="beta"><?php echo $text_beta; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
              <td><input type="text" name="klarna_invoice[<?php echo $country['code']; ?>][total]" id="input-total" value="<?php echo isset($klarna_invoice[$country['code']]) ? $klarna_invoice[$country['code']]['total'] : ''; ?>" /></td>
            </tr>
            <tr>
              <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
              <td><input type="text" name="klarna_invoice[<?php echo $country['code']; ?>][total_max]" id="input-total-max" value="<?php echo isset($klarna_invoice[$country['code']]) ? $klarna_invoice[$country['code']]['total_max'] : ''; ?>" /></td>
            </tr>
            <tr>
              <td><label for="input-pending-status"><?php echo $entry_pending_status; ?></label></td>
              <td><select name="klarna_invoice[<?php echo $country['code']; ?>][pending_status_id]" id="input-pending-status">
                <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if (isset($klarna_invoice[$country['code']]) && $order_status['order_status_id'] == $klarna_invoice[$country['code']]['pending_status_id']) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><label for="input-accepted-status"><?php echo $entry_accepted_status; ?></label></td>
              <td><select name="klarna_invoice[<?php echo $country['code']; ?>][accepted_status_id]" id="input-accepted-status">
                <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if (isset($klarna_invoice[$country['code']]) && $order_status['order_status_id'] == $klarna_invoice[$country['code']]['accepted_status_id']) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
              <td><select name="klarna_invoice[<?php echo $country['code']; ?>][geo_zone_id]" id="input-geo-zone">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                  <?php if (isset($klarna_invoice[$country['code']]) && $geo_zone['geo_zone_id'] == $klarna_invoice[$country['code']]['geo_zone_id']) {  ?>
                    <option value="<?php echo $geo_zone['geo_zone_id'] ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id'] ?>"><?php echo $geo_zone['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><label for="input-status"><?php echo $entry_status; ?></label></td>
              <td><select name="klarna_invoice[<?php echo $country['code']; ?>][status]" id="input-status">
                <?php if (isset($klarna_invoice[$country['code']]) && $klarna_invoice[$country['code']]['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><label for="input-sort-order"><?php echo $entry_sort_order ?></label></td>
              <td><input type="text" name="klarna_invoice[<?php echo $country['code']; ?>][sort_order]" id="input-sort-order" value="<?php echo isset($klarna_invoice[$country['code']]) ? $klarna_invoice[$country['code']]['sort_order'] : ''; ?>" size="3" /></td>
            </tr>
          </table>
        </div>
        <?php } ?>
      </div>
      <div id="tab-log">
        <table class="form">
          <tr>
            <td><textarea wrap="off" style="width:98%; height:300px; padding:5px; border:1px solid #CCC; background: #FFF; overflow:scroll;"><?php echo $log; ?></textarea></td>
          </tr>
          <tr>
            <td style="text-align:right;"><a href="<?php echo $clear; ?>" class="button-form"><?php echo $button_clear; ?></a></td>
          </tr>
        </table>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#htabs a').tabs();
$('#vtabs a').tabs();
//--></script>

<?php echo $footer; ?>