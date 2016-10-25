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
        <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="htabs" class="htabs">
        <a href="#tab-settings"><?php echo $tab_settings; ?></a>
        <a href="#tab-order-status"><?php echo $tab_order_status; ?></a>
      <?php if ($pp_pro_iframe_debug) { ?>
        <a href="#tab-debug-log"><?php echo $tab_debug_log; ?></a>
      <?php } ?>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-settings">
        <table class="form">
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-user"><?php echo $entry_user; ?></label></td>
            <td><?php if ($error_user) { ?>
              <input type="text" name="pp_pro_iframe_user" id="input-user" value="<?php echo $pp_pro_iframe_user; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_user; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_pro_iframe_user" id="input-user" value="<?php echo $pp_pro_iframe_user; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-password"><?php echo $entry_password; ?></label></td>
            <td><?php if ($error_password) { ?>
              <input type="text" name="pp_pro_iframe_password" id="input-password" value="<?php echo $pp_pro_iframe_password; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_password; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_pro_iframe_password" id="input-password" value="<?php echo $pp_pro_iframe_password; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-signature"><?php echo $entry_signature; ?></label></td>
            <td><?php if ($error_signature) { ?>
              <input type="text" name="pp_pro_iframe_sig" id="input-signature" value="<?php echo $pp_pro_iframe_sig; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_signature; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_pro_iframe_sig" id="input-signature" value="<?php echo $pp_pro_iframe_sig; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-live-demo"><?php echo $entry_test; ?><br /><span class="help"><?php echo $help_test; ?></span></label></td>
            <td><select name="pp_pro_iframe_test" id="input-live-demo">
              <?php if ($pp_pro_iframe_test) { ?>
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
            <td><select name="pp_pro_iframe_debug" id="input-debug">
              <?php if ($pp_pro_iframe_debug) { ?>
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
            <td><select name="pp_pro_iframe_transaction_method" id="input-transaction">
              <?php if ($pp_pro_iframe_transaction_method == 'authorization') { ?>
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
            <td><select name="pp_pro_iframe_checkout_method">
              <?php if ($pp_pro_iframe_checkout_method == 'iframe') { ?>
                <option value="iframe" selected="selected"><?php echo $text_iframe; ?></option>
                <option value="redirect"><?php echo $text_redirect; ?></option> 
              <?php } else { ?>
                <option value="iframe"><?php echo $text_iframe; ?></option>
                <option value="redirect" selected="selected"><?php echo $text_redirect; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="pp_pro_iframe_total" id="input-total" value="<?php echo $pp_pro_iframe_total; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="pp_pro_iframe_total_max" id="input-total-max" value="<?php echo $pp_pro_iframe_total_max; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
            <td><select name="pp_pro_iframe_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $pp_pro_iframe_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label></td>
            <td><select name="pp_pro_iframe_status" id="input-status">
              <?php if ($pp_pro_iframe_status) { ?>
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
            <td><input type="text" name="pp_pro_iframe_sort_order" id="input-sort-order" value="<?php echo $pp_pro_iframe_sort_order; ?>" size="1" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_ipn_url; ?></td>
            <td><?php echo $ipn_url; ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-order-status">
        <table class="form">
          <tr>
            <td><label for="input-canceled-reversal-status"><?php echo $entry_canceled_reversal_status; ?></label></td>
            <td><select name="pp_pro_iframe_canceled_reversal_status_id" id="input-canceled-reversal-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_pro_iframe_canceled_reversal_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-completed-status"><?php echo $entry_completed_status; ?></label></td>
            <td><select name="pp_pro_iframe_completed_status_id" id="input-completed-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_pro_iframe_completed_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-denied-status"><?php echo $entry_denied_status; ?></label></td>
            <td><select name="pp_pro_iframe_denied_status_id" id="input-denied-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_pro_iframe_denied_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-expired-status"><?php echo $entry_expired_status; ?></label></td>
            <td><select name="pp_pro_iframe_expired_status_id" id="input-expired-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_pro_iframe_expired_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-failed-status"><?php echo $entry_failed_status; ?></label></td>
            <td><select name="pp_pro_iframe_failed_status_id" id="input-failed-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_pro_iframe_failed_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-pending-status"><?php echo $entry_pending_status; ?></label></td>
            <td><select name="pp_pro_iframe_pending_status_id" id="input-pending-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_pro_iframe_pending_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-processed-status"><?php echo $entry_processed_status; ?></label></td>
            <td><select name="pp_pro_iframe_processed_status_id" id="input-processed-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_pro_iframe_processed_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-refunded-status"><?php echo $entry_refunded_status; ?></label></td>
            <td><select name="pp_pro_iframe_refunded_status_id" id="input-refunded-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_pro_iframe_refunded_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-reversed-status"><?php echo $entry_reversed_status; ?></label></td>
            <td><select name="pp_pro_iframe_reversed_status_id" id="input-reversed-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_pro_iframe_reversed_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-voided-status"><?php echo $entry_voided_status; ?></label></td>
            <td><select name="pp_pro_iframe_voided_status_id" id="input-voided-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_pro_iframe_voided_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
        </table>
      </div>
      <?php if ($pp_pro_iframe_debug) { ?>
      <div id="tab-debug-log">
        <div class="report">
          <div class="left"><img src="view/image/log.png" alt="" /></div>
        <?php if ($debug_log) { ?>
          <div class="right"><a href="<?php echo $debug_clear; ?>" class="button-filter"><?php echo $button_debug_clear; ?></a></div>
          <div class="right"><a href="<?php echo $debug_download; ?>" class="button-filter"><?php echo $button_debug_download; ?></a></div>
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