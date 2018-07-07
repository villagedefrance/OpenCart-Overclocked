<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php if (!empty($errors)) { ?>
  <div class="warning">
  <?php foreach ($errors as $error) { ?>
    <?php echo $error; ?><br />
  <?php } ?>
  </div>
<?php } ?>
<?php if (!empty($success)) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="window.open('https://manager.paypal.com');" class="button ripple"><?php echo $button_pp_manager; ?></a>
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content"> 
      <div id="htabs" class="htabs">
        <a href="#tab-api"><?php echo $tab_api; ?></a>
        <a href="#tab-general"><?php echo $tab_general; ?></a>
      <?php if ($pp_payflow_iframe_debug) { ?>
        <a href="#tab-debug-log"><?php echo $tab_debug_log; ?></a>
      <?php } ?>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-api">
        <table class="form">
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-partner"><?php echo $entry_partner; ?><br /><span class="help"><?php echo $help_partner; ?></span></label></td>
            <td><?php if (isset($errors['partner'])) { ?>
              <input type="text" name="pp_payflow_iframe_partner" id="input-partner" value="<?php echo $pp_payflow_iframe_partner; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $errors['partner']; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_payflow_iframe_partner" id="input-partner" value="<?php echo $pp_payflow_iframe_partner; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-vendor"><?php echo $entry_vendor; ?><br /><span class="help"><?php echo $help_vendor; ?></span></label></td>
            <td><?php if (isset($errors['vendor'])) { ?>
              <input type="text" name="pp_payflow_iframe_vendor" id="input-vendor" value="<?php echo $pp_payflow_iframe_vendor; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $errors['vendor'] ?></span>
            <?php } else { ?>
              <input type="text" name="pp_payflow_iframe_vendor" id="input-vendor" value="<?php echo $pp_payflow_iframe_vendor; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-username"><?php echo $entry_username; ?><br /><span class="help"><?php echo $help_username; ?></span></label></td>
            <td><?php if (isset($errors['username'])) { ?>
              <input type="text" name="pp_payflow_iframe_username" id="input-username" value="<?php echo $pp_payflow_iframe_username; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $errors['username']; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_payflow_iframe_username" id="input-username" value="<?php echo $pp_payflow_iframe_username; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-password"><?php echo $entry_password; ?></label></td>
            <td><?php if (isset($errors['password'])) { ?>
              <input type="text" name="pp_payflow_iframe_password" id="input-password" value="<?php echo $pp_payflow_iframe_password; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $errors['password']; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_payflow_iframe_password" id="input-password" value="<?php echo $pp_payflow_iframe_password; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_cancel_url; ?></td>
            <td><?php echo $cancel_url; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_error_url; ?></td>
            <td><?php echo $error_url; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_return_url; ?></td>
            <td><?php echo $return_url; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_silent_post_url; ?></td>
            <td><?php echo $silent_post_url; ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-general">
        <table class="form">
          <tr>
            <td><label for="input-live-demo"><?php echo $entry_test; ?><br /><span class="help"><?php echo $help_test; ?></span></label></td>
            <td><select name="pp_payflow_iframe_test" id="input-live-demo">
              <?php if ($pp_payflow_iframe_test) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-debug"><?php echo $entry_debug; ?><br /><span class="help"><?php echo $help_debug; ?></span></label></td>
            <td><select name="pp_payflow_iframe_debug" id="input-debug">
              <?php if ($pp_payflow_iframe_debug) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-transaction"><?php echo $entry_transaction_method; ?><br /><span class="help"><?php echo $help_transaction_method; ?></span></label></td>
            <td><select name="pp_payflow_iframe_transaction_method" id="input-transaction">
              <?php if ($pp_payflow_iframe_transaction_method == 'authorization') { ?>
                <option value="sale"><?php echo $text_sale; ?></option>
                <option value="authorization" selected="selected"><?php echo $text_authorization; ?></option>
              <?php } else { ?>
                <option value="sale" selected="selected"><?php echo $text_sale; ?></option>
                <option value="authorization"><?php echo $text_authorization; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_checkout_method; ?><br /><span class="help"><?php echo $help_checkout_method; ?></span></td>
            <td><select name="pp_payflow_iframe_checkout_method">
              <?php if ($pp_payflow_iframe_checkout_method == 'iframe') { ?>
                <option value="iframe" selected="selected"><?php echo $text_iframe; ?></option>
                <option value="redirect"><?php echo $text_redirect; ?></option>
              <?php } else { ?>
                <option value="iframe"><?php echo $text_iframe; ?></option>
                <option value="redirect" selected="selected"><?php echo $text_redirect; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-timeout"><?php echo $entry_timeout; ?><br /><span class="help"><?php echo $help_timeout; ?></span></label></td>
            <td><input type="text" name="pp_payflow_iframe_timeout" id="input-timeout" value="<?php echo $pp_payflow_iframe_timeout; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="pp_payflow_iframe_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_payflow_iframe_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="pp_payflow_iframe_total" id="input-total" value="<?php echo $pp_payflow_iframe_total; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="pp_payflow_iframe_total_max" id="input-total-max" value="<?php echo $pp_payflow_iframe_total_max; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
            <td><select name="pp_payflow_iframe_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $pp_payflow_iframe_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label></td>
            <td><select name="pp_payflow_iframe_status" id="input-status">
              <?php if ($pp_payflow_iframe_status) { ?>
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
            <td><input type="text" name="pp_payflow_iframe_sort_order" id="input-sort-order" value="<?php echo $pp_payflow_iframe_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </div>
      <?php if ($pp_payflow_iframe_debug) { ?>
      <div id="tab-debug-log">
        <div class="report">
          <div class="left"><img src="view/image/log.png" alt="" /></div>
        <?php if ($debug_log) { ?>
          <div class="right"><a href="<?php echo $debug_clear; ?>" class="button-filter ripple"><?php echo $button_debug_clear; ?></a></div>
          <div class="right"><a href="<?php echo $debug_download; ?>" class="button-filter ripple"><?php echo $button_debug_download; ?></a></div>
        <?php } ?>
        </div>
        <textarea wrap="off" class="log"><?php echo $debug_log; ?></textarea>
      </div>
      <?php } ?>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#htabs a').tabs();
//--></script>

<?php echo $footer; ?>