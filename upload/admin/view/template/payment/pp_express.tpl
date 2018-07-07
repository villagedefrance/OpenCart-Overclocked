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
        <a href="<?php echo $search; ?>" class="button ripple"><?php echo $button_search; ?></a>
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div class="tooltip"><a data-paypal-button="true" target="PPFrame" href="<?php echo $signup; ?>"><?php echo $text_signup; ?></a></div>
      <div class="tooltip"><a data-paypal-button="true" target="PPFrame" href="<?php echo $sandbox; ?>"><?php echo $text_sandbox; ?></a></div>
      <div id="htabs" class="htabs">
        <a href="#tab-api"><?php echo $tab_api; ?></a>
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-order-status"><?php echo $tab_order_status; ?></a>
        <a href="#tab-checkout-customization"><?php echo $tab_checkout_customisation; ?></a>
      <?php if ($pp_express_debug) { ?>
        <a href="#tab-debug-log"><?php echo $tab_debug_log; ?></a>
      <?php } ?>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div class="toggler" style="padding-bottom:10px;">
        <fieldset><p><?php echo $text_info; ?></p></fieldset>
      </div>
      <div id="tab-api">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <label for="input-username"><?php echo $entry_username; ?></label></td>
            <td><?php if (isset($errors['username'])) { ?>
              <input type="text" name="pp_express_username" id="input-username" value="<?php echo $pp_express_username; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $errors['username']; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_express_username" id="input-username" value="<?php echo $pp_express_username; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <label for="input-password"><?php echo $entry_password; ?></label></td>
            <td><?php if (isset($errors['password'])) { ?>
              <input type="text" name="pp_express_password" id="input-password" value="<?php echo $pp_express_password; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $errors['password']; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_express_password" id="input-password" value="<?php echo $pp_express_password; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <label for="input-signature"><?php echo $entry_signature; ?></label></td>
            <td><?php if (isset($errors['signature'])) { ?>
              <input type="text" name="pp_express_signature" id="input-signature" value="<?php echo $pp_express_signature; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $errors['signature']; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_express_signature" id="input-signature" value="<?php echo $pp_express_signature; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span style="color:#111;">*</span> <label for="input-sandbox-username"><?php echo $entry_sandbox_username; ?></label></td>
            <td><?php if (isset($errors['sandbox_username'])) { ?>
              <input type="text" name="pp_express_sandbox_username" id="input-sandbox-username" value="<?php echo $pp_express_sandbox_username; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $errors['sandbox_username']; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_express_sandbox_username" id="input-sandbox-username" value="<?php echo $pp_express_sandbox_username; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span style="color:#111;">*</span> <label for="input-sandbox-password"><?php echo $entry_sandbox_password; ?></label></td>
            <td><?php if (isset($errors['sandbox_password'])) { ?>
              <input type="text" name="pp_express_sandbox_password" id="input-sandbox-password" value="<?php echo $pp_express_sandbox_password; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $errors['sandbox_password']; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_express_sandbox_password" id="input-sandbox-password" value="<?php echo $pp_express_sandbox_password; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span style="color:#111;">*</span> <label for="input-sandbox-signature"><?php echo $entry_sandbox_signature; ?></label></td>
            <td><?php if (isset($errors['sandbox_signature'])) { ?>
              <input type="text" name="pp_express_sandbox_signature" id="input-sandbox-signature" value="<?php echo $pp_express_sandbox_signature; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $errors['sandbox_signature']; ?></span>
            <?php } else { ?>
              <input type="text" name="pp_express_sandbox_signature" id="input-sandbox-signature" value="<?php echo $pp_express_sandbox_signature; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_ipn_url; ?><br /><span class="help"><?php echo $help_ipn_url; ?></span></td>
            <td><?php echo $ipn_url; ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-general">
        <table class="form">
          <tr>
            <td><label for="input-live-demo"><?php echo $entry_test; ?><br /><span class="help"><?php echo $help_test; ?></span></label></td>
            <td><select name="pp_express_test" id="input-live-demo">
              <?php if ($pp_express_test) { ?>
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
            <td><select name="pp_express_debug" id="input-debug">
              <?php if ($pp_express_debug) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-currency"><?php echo $entry_currency; ?><br /><span class="help"><?php echo $help_currency; ?></label></td>
            <td><select name="pp_express_currency" id="input-currency">
              <?php foreach ($currencies as $currency) { ?>
                <?php if ($currency == $pp_express_currency) { ?>
                  <option value="<?php echo $currency; ?>" selected="selected"><?php echo $currency; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $currency; ?>"><?php echo $currency; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-recurring-cancel"><?php echo $entry_recurring_cancel; ?><br /><span class="help"><?php echo $help_recurring_cancel; ?></span></label></td>
            <td><select name="pp_express_recurring_cancel" id="input-recurring-cancel">
              <?php if ($pp_express_recurring_cancel) { ?>
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
            <td><select name="pp_express_transaction_method" id="input-transaction">
              <?php if ($pp_express_transaction_method == 'authorization') { ?>
                <option value="sale"><?php echo $text_sale; ?></option>
                <option value="authorization" selected="selected"><?php echo $text_authorization; ?></option>
              <?php } else { ?>
                <option value="sale" selected="selected"><?php echo $text_sale; ?></option>
                <option value="authorization"><?php echo $text_authorization; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="pp_express_total" id="input-total" value="<?php echo !empty($pp_express_total) ? $pp_express_total : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total-max"><?php echo $entry_total_max; ?><br /><span class="help"><?php echo $help_total_max; ?></span></label></td>
            <td><input type="text" name="pp_express_total_max" id="input-total-max" value="<?php echo !empty($pp_express_total_max) ? $pp_express_total_max : '0.00'; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-geo-zone"><?php echo $entry_geo_zone; ?></label></td>
            <td><select name="pp_express_geo_zone_id" id="input-geo-zone">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $pp_express_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label></td>
            <td><select name="pp_express_status" id="input-status">
              <?php if ($pp_express_status) { ?>
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
            <td><input type="text" name="pp_express_sort_order" id="input-sort-order" value="<?php echo $pp_express_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </div>
      <div id="tab-order-status">
        <table class="form">
          <tr>
            <td><label for="input-canceled-reversal-status"><?php echo $entry_canceled_reversal_status; ?></label></td>
            <td><select name="pp_express_canceled_reversal_status_id" id="input-canceled-reversal-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_express_canceled_reversal_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-completed-status"><?php echo $entry_completed_status; ?></label></td>
            <td><select name="pp_express_completed_status_id" id="input-completed-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_express_completed_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-denied-status"><?php echo $entry_denied_status; ?></label></td>
            <td><select name="pp_express_denied_status_id" id="input-denied-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_express_denied_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-expired-status"><?php echo $entry_expired_status; ?></label></td>
            <td><select name="pp_express_expired_status_id" id="input-expired-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_express_expired_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-failed-status"><?php echo $entry_failed_status; ?></label></td>
            <td><select name="pp_express_failed_status_id" id="input-failed-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_express_failed_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-pending-status"><?php echo $entry_pending_status; ?></label></td>
            <td><select name="pp_express_pending_status_id" id="input-pending-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_express_pending_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-processed-status"><?php echo $entry_processed_status; ?></label></td>
            <td><select name="pp_express_processed_status_id" id="input-processed-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_express_processed_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-refunded-status"><?php echo $entry_refunded_status; ?></label></td>
            <td><select name="pp_express_refunded_status_id" id="input-refunded-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_express_refunded_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-reversed-status"><?php echo $entry_reversed_status; ?></label></td>
            <td><select name="pp_express_reversed_status_id" id="input-reversed-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_express_reversed_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><label for="input-voided-status"><?php echo $entry_voided_status; ?></label></td>
            <td><select name="pp_express_voided_status_id" id="input-voided-status">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $pp_express_voided_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
        </table>
      </div>
      <div id="tab-checkout-customization">
        <table class="form">
          <tr>
            <td><label for="input-allow-note"><?php echo $entry_allow_note; ?><br /><span class="help"><?php echo $help_allow_note; ?></span></label></td>
            <td><select name="pp_express_allow_note" id="input-allow-note">
              <?php if ($pp_express_allow_note) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_border_colour; ?><br /><span class="help"><?php echo $help_border_colour; ?></span></td>
            <td>#<input type="text" name="pp_express_border_colour" value="<?php echo $pp_express_border_colour; ?>" size="7" maxlength="6" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_header_colour; ?><br /><span class="help"><?php echo $help_header_colour; ?></span></td>
            <td>#<input type="text" name="pp_express_header_colour" value="<?php echo $pp_express_header_colour; ?>" size="7" maxlength="6" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_page_colour; ?><br /><span class="help"><?php echo $help_page_colour; ?></span></td>
            <td>#<input type="text" name="pp_express_page_colour" value="<?php echo $pp_express_page_colour; ?>" size="7" maxlength="6" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_logo; ?><span class="help"><?php echo $help_logo; ?></span></td>
            <td style="vertical-align:top;">
              <div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" />
                <input type="hidden" name="pp_express_logo" value="<?php echo $pp_express_logo; ?>" id="image" /><br />
                <a onclick="image_upload('image', 'thumb');" class="button-browse"></a><a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');" class="button-recycle"></a>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <?php if ($pp_express_debug) { ?>
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
(function(d, s, id) {
	var js, ref = d.getElementsByTagName(s)[0];

	if (!d.getElementById(id)) {
		js = d.createElement(s);
		js.id = id;
		js.async = true;
		js.src = "https://www.paypal.com/webapps/merchantboarding/js/lib/lightbox/partner.js";

		ref.parentNode.insertBefore(js, ref);
	}
}(document, "script", "paypal-js"));
//--></script>

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding:3px 0 0 0;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin:0; display:block; width:100%; height:100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function(event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: <?php echo ($this->browser->checkMobile()) ? 580 : 760; ?>,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>

<script type="text/javascript"><!--
$('#htabs a').tabs();
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.toggler').hide().before('<a id="<?php echo 'toggler'; ?>" class="button" style="margin:15px auto;"><i class="fa fa-info-circle"></i> &nbsp; <?php echo $button_info; ?></a>');
	$('#<?php echo 'toggler'; ?>').click(function() {
		$('.toggler').slideToggle(600);
		return false;
	});
});
//--></script>

<?php echo $footer; ?>