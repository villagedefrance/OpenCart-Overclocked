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
      <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-store"><?php echo $tab_store; ?></a>
        <a href="#tab-local"><?php echo $tab_local; ?></a>
		<a href="#tab-checkout"><?php echo $tab_checkout; ?></a>
        <a href="#tab-option"><?php echo $tab_option; ?></a>
		<a href="#tab-preference"><?php echo $tab_preference; ?></a>
        <a href="#tab-image"><?php echo $tab_image; ?></a>
        <a href="#tab-ftp"><?php echo $tab_ftp; ?></a>
        <a href="#tab-mail"><?php echo $tab_mail; ?></a>
        <a href="#tab-server"><?php echo $tab_server; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><input type="text" name="config_name" value="<?php echo $config_name; ?>" size="40" />
            <?php if ($error_name) { ?>
              <span class="error"><?php echo $error_name; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_owner; ?></td>
            <td><input type="text" name="config_owner" value="<?php echo $config_owner; ?>" size="40" />
            <?php if ($error_owner) { ?>
              <span class="error"><?php echo $error_owner; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_address; ?></td>
            <td><textarea name="config_address" cols="40" rows="5"><?php echo $config_address; ?></textarea>
            <?php if ($error_address) { ?>
              <span class="error"><?php echo $error_address; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_email; ?></td>
            <td><input type="text" name="config_email" value="<?php echo $config_email; ?>" size="40" />
            <?php if ($error_email) { ?>
              <span class="error"><?php echo $error_email; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
            <td><input type="text" name="config_telephone" value="<?php echo $config_telephone; ?>" />
            <?php if ($error_telephone) { ?>
              <span class="error"><?php echo $error_telephone; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_fax; ?></td>
            <td><input type="text" name="config_fax" value="<?php echo $config_fax; ?>" /></td>
          </tr>
        </table>
      </div>
      <div id="tab-store">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_title; ?></td>
            <td><input type="text" name="config_title" value="<?php echo $config_title; ?>" size="40" />
            <?php if ($error_title) { ?>
              <span class="error"><?php echo $error_title; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_meta_description; ?></td>
            <td><textarea name="config_meta_description" cols="40" rows="5"><?php echo $config_meta_description; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_template; ?></td>
            <td><select name="config_template" onchange="$('#template').load('index.php?route=setting/setting/template&token=<?php echo $token; ?>&template=' + encodeURIComponent(this.value));">
            <?php foreach ($templates as $template) { ?>
              <?php if ($template == $config_template) { ?>
                <option value="<?php echo $template; ?>" selected="selected"><?php echo $template; ?></option>
              <?php } else { ?>
                <option value="<?php echo $template; ?>"><?php echo $template; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td></td>
            <td id="template"></td>
          </tr>
          <tr>
            <td><?php echo $entry_layout; ?></td>
            <td><select name="config_layout_id">
            <?php foreach ($layouts as $layout) { ?>
              <?php if ($layout['layout_id'] == $config_layout_id) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
        </table>
      </div>
      <div id="tab-local">
        <table class="form">
          <tr>
            <td><?php echo $entry_country; ?></td>
            <td><select name="config_country_id">
            <?php foreach ($countries as $country) { ?>
              <?php if ($country['country_id'] == $config_country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_zone; ?></td>
            <td><select name="config_zone_id">
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_language; ?></td>
            <td><select name="config_language">
            <?php foreach ($languages as $language) { ?>
              <?php if ($language['code'] == $config_language) { ?>
                <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_admin_language; ?></td>
            <td><select name="config_admin_language">
            <?php foreach ($languages as $language) { ?>
              <?php if ($language['code'] == $config_admin_language) { ?>
                <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_currency; ?></td>
            <td><select name="config_currency">
            <?php foreach ($currencies as $currency) { ?>
              <?php if ($currency['code'] == $config_currency) { ?>
                <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_currency_auto; ?></td>
            <td><?php if ($config_currency_auto) { ?>
              <input type="radio" name="config_currency_auto" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_currency_auto" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_currency_auto" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_currency_auto" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_length_class; ?></td>
            <td><select name="config_length_class_id">
            <?php foreach ($length_classes as $length_class) { ?>
              <?php if ($length_class['length_class_id'] == $config_length_class_id) { ?>
                <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_weight_class; ?></td>
            <td><select name="config_weight_class_id">
            <?php foreach ($weight_classes as $weight_class) { ?>
              <?php if ($weight_class['weight_class_id'] == $config_weight_class_id) { ?>
                <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
        </table>
        <h2><?php echo $text_location; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_our_location; ?></td>
            <td><?php if ($config_our_location) { ?>
              <input type="radio" name="config_our_location" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_our_location" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_our_location" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_our_location" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_location; ?></td>
            <td><input id="search_address" name="config_location" type="text" value="<?php echo isset($config_location) ? $config_location : ''; ?>" autocomplete="on" runat="server" size="80" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_latitude; ?></td>
            <td><input id="location_latitude" name="config_latitude" value="<?php echo isset($config_latitude) ? $config_latitude : ''; ?>" size="30" readonly="readonly" /> &deg; N</td>
          </tr>
          <tr>
            <td><?php echo $entry_longitude; ?></td>
            <td><input id="location_longitude" name="config_longitude" value="<?php echo isset($config_longitude) ? $config_longitude : ''; ?>" size="30" readonly="readonly" /> &deg; E</td>
          </tr>
          <tr>
            <td><?php echo $entry_contact_map; ?></td>
            <td><?php if ($config_contact_map) { ?>
              <input type="radio" name="config_contact_map" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_contact_map" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_contact_map" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_contact_map" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-checkout">
        <h2><?php echo $text_checkout; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_cart_weight; ?></td>
            <td><?php if ($config_cart_weight) { ?>
              <input type="radio" name="config_cart_weight" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_cart_weight" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_cart_weight" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_cart_weight" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_guest_checkout; ?></td>
            <td><?php if ($config_guest_checkout) { ?>
              <input type="radio" name="config_guest_checkout" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_guest_checkout" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_guest_checkout" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_guest_checkout" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_checkout; ?></td>
            <td><select name="config_checkout_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($informations as $information) { ?>
                <?php if ($information['information_id'] == $config_checkout_id) { ?>
                  <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_order_edit; ?></td>
            <td><input type="text" name="config_order_edit" value="<?php echo $config_order_edit; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_invoice_prefix; ?></td>
            <td><input type="text" name="config_invoice_prefix" value="<?php echo $config_invoice_prefix; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_auto_invoice; ?></td>
            <td><?php if ($config_auto_invoice) { ?>
              <input type="radio" name="config_auto_invoice" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_auto_invoice" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_auto_invoice" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_auto_invoice" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="config_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $config_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_complete_status; ?></td>
            <td><select name="config_complete_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $config_complete_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
        </table>
        <h2><?php echo $text_express; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_express_checkout; ?></td>
            <td><?php if ($config_express_checkout) { ?>
              <input type="radio" name="config_express_checkout" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_checkout" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_express_checkout" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_checkout" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo $info_express; ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_express_name; ?></td>
            <td><?php if ($config_express_name) { ?>
              <input type="radio" name="config_express_name" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_name" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_express_name" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_name" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_express_password; ?></td>
            <td><select name="config_express_password">
              <?php if (isset($config_express_password)) { $selected = "selected"; ?>
                <option value="0" <?php if ($config_express_password == '0') {echo $selected;} ?>><?php echo $text_no; ?></option>
                <option value="1" <?php if ($config_express_password == '1') {echo $selected;} ?>><?php echo $text_yes; ?></option>
				<option value="2" <?php if ($config_express_password == '2') {echo $selected;} ?>><?php echo $text_hide; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_no; ?></option>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="2"><?php echo $text_hide; ?></option>
              <?php } ?>
            </select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_express_phone; ?></td>
            <td><select name="config_express_phone">
              <?php if (isset($config_express_phone)) { $selected = "selected"; ?>
                <option value="0" <?php if ($config_express_phone == '0') {echo $selected;} ?>><?php echo $text_no; ?></option>
                <option value="1" <?php if ($config_express_phone == '1') {echo $selected;} ?>><?php echo $text_yes; ?></option>
				<option value="2" <?php if ($config_express_phone == '2') {echo $selected;} ?>><?php echo $text_required; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_no; ?></option>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="2"><?php echo $text_required; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_autofill; ?></td>
            <td><?php if ($config_express_autofill) { ?>
              <input type="radio" name="config_express_autofill" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_autofill" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_express_autofill" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_autofill" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_billing; ?></td>
            <td><?php if ($config_express_billing) { ?>
              <input type="radio" name="config_express_billing" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_billing" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_express_billing" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_billing" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_postcode; ?></td>
            <td><?php if ($config_express_postcode) { ?>
              <input type="radio" name="config_express_postcode" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_postcode" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_express_postcode" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_postcode" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_comment; ?></td>
            <td><?php if ($config_express_comment) { ?>
              <input type="radio" name="config_express_comment" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_comment" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_express_comment" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_comment" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_express_newsletter; ?></td>
            <td><select name="config_express_newsletter">
              <?php if (isset($config_express_newsletter)) { $selected = "selected"; ?>
                <option value="0" <?php if ($config_express_newsletter == '0') {echo $selected;} ?>><?php echo $text_no; ?></option>
                <option value="1" <?php if ($config_express_newsletter == '1') {echo $selected;} ?>><?php echo $text_yes; ?></option>
				<option value="2" <?php if ($config_express_newsletter == '2') {echo $selected;} ?>><?php echo $text_choice; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_no; ?></option>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="2"><?php echo $text_choice; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_coupon; ?></td>
            <td><?php if ($config_express_coupon) { ?>
              <input type="radio" name="config_express_coupon" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_coupon" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_express_coupon" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_coupon" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_voucher; ?></td>
            <td><?php if ($config_express_voucher) { ?>
              <input type="radio" name="config_express_voucher" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_voucher" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_express_voucher" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_express_voucher" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_express_point; ?></td>
            <td><select name="config_express_point">
              <?php if (isset($config_express_point)) { $selected = "selected"; ?>
                <option value="0" <?php if ($config_express_point == '0') {echo $selected;} ?>><?php echo $text_no; ?></option>
                <option value="1" <?php if ($config_express_point == '1') {echo $selected;} ?>><?php echo $text_yes; ?></option>
				<option value="2" <?php if ($config_express_point == '2') {echo $selected;} ?>><?php echo $text_automatic; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_no; ?></option>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="2"><?php echo $text_automatic; ?></option>
              <?php } ?>
            </select></td>
          </tr>
        </table>
      </div>
      <div id="tab-option">
        <h2><?php echo $text_items; ?></h2>
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_catalog_limit; ?></td>
            <td><input type="text" name="config_catalog_limit" value="<?php echo $config_catalog_limit; ?>" size="3" />
            <?php if ($error_catalog_limit) { ?>
              <span class="error"><?php echo $error_catalog_limit; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_admin_limit; ?></td>
            <td><input type="text" name="config_admin_limit" value="<?php echo $config_admin_limit; ?>" size="3" />
            <?php if ($error_admin_limit) { ?>
              <span class="error"><?php echo $error_admin_limit; ?></span>
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_product; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_product_count; ?></td>
            <td><?php if ($config_product_count) { ?>
              <input type="radio" name="config_product_count" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_product_count" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_product_count" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_product_count" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_review; ?></td>
            <td><?php if ($config_review_status) { ?>
              <input type="radio" name="config_review_status" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_review_status" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_review_status" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_review_status" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_download; ?></td>
            <td><?php if ($config_download) { ?>
              <input type="radio" name="config_download" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_download" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_download" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_download" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_tax; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_tax; ?></td>
            <td><?php if ($config_tax) { ?>
              <input type="radio" name="config_tax" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_tax" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_tax" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_tax" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_vat; ?></td>
            <td><?php if ($config_vat) { ?>
              <input type="radio" name="config_vat" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_vat" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_vat" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_vat" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax_default; ?></td>
            <td><select name="config_tax_default">
              <option value=""><?php echo $text_none; ?></option>
              <?php if ($config_tax_default == 'shipping') { ?>
                <option value="shipping" selected="selected"><?php echo $text_shipping; ?></option>
              <?php } else { ?>
                <option value="shipping"><?php echo $text_shipping; ?></option>
              <?php } ?>
              <?php if ($config_tax_default == 'payment') { ?>
                <option value="payment" selected="selected"><?php echo $text_payment; ?></option>
              <?php } else { ?>
                <option value="payment"><?php echo $text_payment; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax_customer; ?></td>
            <td><select name="config_tax_customer">
              <option value=""><?php echo $text_none; ?></option>
              <?php if ($config_tax_customer == 'shipping') { ?>
                <option value="shipping" selected="selected"><?php echo $text_shipping; ?></option>
              <?php } else { ?>
                <option value="shipping"><?php echo $text_shipping; ?></option>
              <?php } ?>
              <?php if ($config_tax_customer == 'payment') { ?>
                <option value="payment" selected="selected"><?php echo $text_payment; ?></option>
              <?php } else { ?>
                <option value="payment"><?php echo $text_payment; ?></option>
              <?php } ?>
            </select></td>
          </tr>
        </table>
        <h2><?php echo $text_stock; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_stock_display; ?></td>
            <td><?php if ($config_stock_display) { ?>
              <input type="radio" name="config_stock_display" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_stock_display" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_stock_display" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_stock_display" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_stock_warning; ?></td>
            <td><?php if ($config_stock_warning) { ?>
              <input type="radio" name="config_stock_warning" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_stock_warning" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_stock_warning" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_stock_warning" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_stock_checkout; ?></td>
            <td><?php if ($config_stock_checkout) { ?>
              <input type="radio" name="config_stock_checkout" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_stock_checkout" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_stock_checkout" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_stock_checkout" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_stock_status; ?></td>
            <td><select name="config_stock_status_id">
              <?php foreach ($stock_statuses as $stock_status) { ?>
                <?php if ($stock_status['stock_status_id'] == $config_stock_status_id) { ?>
                  <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
        </table>
        <h2><?php echo $text_account; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_customer_online; ?></td>
            <td><?php if ($config_customer_online) { ?>
              <input type="radio" name="config_customer_online" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customer_online" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_customer_online" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customer_online" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer_group; ?></td>
            <td><select name="config_customer_group_id">
            <?php foreach ($customer_groups as $customer_group) { ?>
              <?php if ($customer_group['customer_group_id'] == $config_customer_group_id) { ?>
                <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer_group_display; ?></td>
            <td><div class="scrollbox">
              <?php $class = 'odd'; ?>
              <?php foreach ($customer_groups as $customer_group) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <?php if (in_array($customer_group['customer_group_id'], $config_customer_group_display)) { ?>
                    <input type="checkbox" name="config_customer_group_display[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                    <?php echo $customer_group['name']; ?>
                  <?php } else { ?>
                    <input type="checkbox" name="config_customer_group_display[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                    <?php echo $customer_group['name']; ?>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
            <?php if ($error_customer_group_display) { ?>
              <span class="error"><?php echo $error_customer_group_display; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer_price; ?></td>
            <td><?php if ($config_customer_price) { ?>
              <input type="radio" name="config_customer_price" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customer_price" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_customer_price" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customer_price" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer_redirect; ?></td>
            <td><?php if ($config_customer_redirect) { ?>
              <input type="radio" name="config_customer_redirect" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customer_redirect" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_customer_redirect" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customer_redirect" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer_fax; ?></td>
            <td><?php if ($config_customer_fax) { ?>
              <input type="radio" name="config_customer_fax" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customer_fax" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_customer_fax" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customer_fax" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_account; ?></td>
            <td><select name="config_account_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($informations as $information) { ?>
                <?php if ($information['information_id'] == $config_account_id) { ?>
                  <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
        </table>
        <h2><?php echo $text_affiliate; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_affiliate; ?></td>
            <td><select name="config_affiliate_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($informations as $information) { ?>
                <?php if ($information['information_id'] == $config_affiliate_id) { ?>
                  <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_commission; ?></td>
            <td><input type="text" name="config_commission" value="<?php echo $config_commission; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_affiliate_fax; ?></td>
            <td><?php if ($config_affiliate_fax) { ?>
              <input type="radio" name="config_affiliate_fax" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_affiliate_fax" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_affiliate_fax" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_affiliate_fax" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_affiliate_disable; ?></td>
            <td><?php if ($config_affiliate_disable) { ?>
              <input type="radio" name="config_affiliate_disable" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_affiliate_disable" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_affiliate_disable" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_affiliate_disable" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_return; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_return; ?></td>
            <td><select name="config_return_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($informations as $information) { ?>
                <?php if ($information['information_id'] == $config_return_id) { ?>
                  <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_return_status; ?></td>
            <td><select name="config_return_status_id">
              <?php foreach ($return_statuses as $return_status) { ?>
                <?php if ($return_status['return_status_id'] == $config_return_status_id) { ?>
                  <option value="<?php echo $return_status['return_status_id']; ?>" selected="selected"><?php echo $return_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $return_status['return_status_id']; ?>"><?php echo $return_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_return_disable; ?></td>
            <td><?php if ($config_return_disable) { ?>
              <input type="radio" name="config_return_disable" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_return_disable" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_return_disable" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_return_disable" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_voucher; ?></h2>
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_voucher_min; ?></td>
            <td><input type="text" name="config_voucher_min" value="<?php echo $config_voucher_min; ?>" />
            <?php if ($error_voucher_min) { ?>
              <span class="error"><?php echo $error_voucher_min; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_voucher_max; ?></td>
            <td><input type="text" name="config_voucher_max" value="<?php echo $config_voucher_max; ?>" />
            <?php if ($error_voucher_max) { ?>
              <span class="error"><?php echo $error_voucher_max; ?></span>
            <?php } ?></td>
          </tr>
        </table>
      </div>
	  <div id="tab-preference">
		<h2><?php echo $text_administration; ?></h2>
        <table class="form">
          <tr>
		    <td><?php echo $entry_pagination_hi; ?></td>
            <td><?php if ($config_pagination_hi) { ?>
              <input type="radio" name="config_pagination_hi" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_pagination_hi" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_pagination_hi" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_pagination_hi" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?>
			<?php if ($error_preference_pagination) { ?>
              <span class="error"><?php echo $error_preference_pagination; ?></span>
            <?php } ?>
			</td>
          </tr>
		  <tr>
		    <td><?php echo $entry_pagination_lo; ?></td>
            <td><?php if ($config_pagination_lo) { ?>
              <input type="radio" name="config_pagination_lo" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_pagination_lo" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_pagination_lo" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_pagination_lo" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?>
			<?php if ($error_preference_pagination) { ?>
              <span class="error"><?php echo $error_preference_pagination; ?></span>
            <?php } ?>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_autocomplete_category; ?></td>
            <td><?php if ($config_autocomplete_category) { ?>
              <input type="radio" name="config_autocomplete_category" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_autocomplete_category" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_autocomplete_category" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_autocomplete_category" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_autocomplete_product; ?></td>
            <td><?php if ($config_autocomplete_product) { ?>
              <input type="radio" name="config_autocomplete_product" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_autocomplete_product" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_autocomplete_product" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_autocomplete_product" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_store_front; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_breadcrumbs; ?></td>
            <td><?php if ($config_breadcrumbs) { ?>
              <input type="radio" name="config_breadcrumbs" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_breadcrumbs" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_breadcrumbs" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_breadcrumbs" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_manufacturer_name; ?></td>
            <td><?php if ($config_manufacturer_name) { ?>
              <input type="radio" name="config_manufacturer_name" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_manufacturer_name" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_manufacturer_name" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_manufacturer_name" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_manufacturer_image; ?></td>
            <td><?php if ($config_manufacturer_image) { ?>
              <input type="radio" name="config_manufacturer_image" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_manufacturer_image" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_manufacturer_image" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_manufacturer_image" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_custom_menu; ?></td>
            <td><?php if ($config_custom_menu) { ?>
              <input type="radio" name="config_custom_menu" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_custom_menu" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_custom_menu" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_custom_menu" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_viewer; ?></td>
            <td><select name="config_viewer">
              <?php if (isset($config_viewer)) { $selected = "selected"; ?>
                <option value="colorbox" <?php if ($config_viewer == 'colorbox') {echo $selected;} ?>><?php echo $text_colorbox; ?> <?php echo $text_default; ?></option>
                <option value="magnific" <?php if ($config_viewer == 'magnific') {echo $selected;} ?>><?php echo $text_magnific; ?></option>
                <option value="zoomlens" <?php if ($config_viewer == 'zoomlens') {echo $selected;} ?>><?php echo $text_zoomlens; ?></option>
              <?php } else { ?>
                <option value="colorbox"><?php echo $text_colorbox; ?> <?php echo $text_default; ?></option>
                <option value="magnific"><?php echo $text_magnific; ?></option>
                <option value="zoomlens"><?php echo $text_zoomlens; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_offer_label; ?></td>
            <td><?php if ($config_offer_label) { ?>
              <input type="radio" name="config_offer_label" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_offer_label" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_offer_label" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_offer_label" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_price_free; ?></td>
            <td><?php if ($config_price_free) { ?>
              <input type="radio" name="config_price_free" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_price_free" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_price_free" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_price_free" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_captcha_font; ?></td>
            <td><select name="config_captcha_font">
            <?php foreach ($fontnames as $fontname) { ?>
              <?php if ($fontname == $config_captcha_font) { ?>
                <option value="<?php echo $fontname; ?>" selected="selected"><?php echo $fontname; ?></option>
              <?php } else { ?>
                <option value="<?php echo $fontname; ?>"><?php echo $fontname; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_news_addthis; ?></td>
            <td><?php if ($config_news_addthis) { ?>
              <input type="radio" name="config_news_addthis" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_news_addthis" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_news_addthis" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_news_addthis" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_news_chars; ?></td>
            <td><input type="text" name="config_news_chars" value="<?php echo $config_news_chars; ?>" size="5" /> <?php echo $text_characters; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_cookie_consent; ?></td>
            <td><?php if ($config_cookie_consent) { ?>
              <input type="radio" name="config_cookie_consent" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_cookie_consent" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_cookie_consent" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_cookie_consent" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_cookie_privacy; ?></td>
            <td><select name="config_cookie_privacy">
              <?php foreach ($informations as $information) { ?>
                <?php if ($information['information_id'] == $config_cookie_privacy) { ?>
                  <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_back_to_top; ?></td>
            <td><?php if ($config_back_to_top) { ?>
              <input type="radio" name="config_back_to_top" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_back_to_top" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_back_to_top" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_back_to_top" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-image">
        <table class="form">
          <tr>
            <td><?php echo $entry_logo; ?></td>
            <td><div class="image"><img src="<?php echo $logo; ?>" alt="" id="thumb-logo" />
            <input type="hidden" name="config_logo" value="<?php echo $config_logo; ?>" id="logo" />
            <br />
            <a onclick="image_upload('logo', 'thumb-logo');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb-logo').attr('src', '<?php echo $no_image; ?>'); $('#logo').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
          </tr>
          <tr>
            <td><?php echo $entry_icon; ?></td>
            <td><div class="image"><img src="<?php echo $icon; ?>" alt="" id="thumb-icon" />
            <input type="hidden" name="config_icon" value="<?php echo $config_icon; ?>" id="icon" />
            <br />
            <a onclick="image_upload('icon', 'thumb-icon');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb-icon').attr('src', '<?php echo $no_image; ?>'); $('#icon').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
          </tr>
        </table>
        <h2><?php echo $text_image_resize; ?></h2>
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_category; ?></td>
            <td><input type="text" name="config_image_category_width" value="<?php echo $config_image_category_width; ?>" size="3" />
              x
            <input type="text" name="config_image_category_height" value="<?php echo $config_image_category_height; ?>" size="3" />
            <?php if ($error_image_category) { ?>
              <span class="error"><?php echo $error_image_category; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_thumb; ?></td>
            <td><input type="text" name="config_image_thumb_width" value="<?php echo $config_image_thumb_width; ?>" size="3" />
              x
            <input type="text" name="config_image_thumb_height" value="<?php echo $config_image_thumb_height; ?>" size="3" />
            <?php if ($error_image_thumb) { ?>
              <span class="error"><?php echo $error_image_thumb; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_popup; ?></td>
            <td><input type="text" name="config_image_popup_width" value="<?php echo $config_image_popup_width; ?>" size="3" />
              x
            <input type="text" name="config_image_popup_height" value="<?php echo $config_image_popup_height; ?>" size="3" />
            <?php if ($error_image_popup) { ?>
              <span class="error"><?php echo $error_image_popup; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_product; ?></td>
            <td><input type="text" name="config_image_product_width" value="<?php echo $config_image_product_width; ?>" size="3" />
              x
            <input type="text" name="config_image_product_height" value="<?php echo $config_image_product_height; ?>" size="3" />
            <?php if ($error_image_product) { ?>
              <span class="error"><?php echo $error_image_product; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_additional; ?></td>
            <td><input type="text" name="config_image_additional_width" value="<?php echo $config_image_additional_width; ?>" size="3" />
              x
            <input type="text" name="config_image_additional_height" value="<?php echo $config_image_additional_height; ?>" size="3" />
            <?php if ($error_image_additional) { ?>
              <span class="error"><?php echo $error_image_additional; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_brand; ?></td>
            <td><input type="text" name="config_image_brand_width" value="<?php echo $config_image_brand_width; ?>" size="3" />
              x
            <input type="text" name="config_image_brand_height" value="<?php echo $config_image_brand_height; ?>" size="3" />
            <?php if ($error_image_brand) { ?>
              <span class="error"><?php echo $error_image_brand; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_related; ?></td>
            <td><input type="text" name="config_image_related_width" value="<?php echo $config_image_related_width; ?>" size="3" />
              x
            <input type="text" name="config_image_related_height" value="<?php echo $config_image_related_height; ?>" size="3" />
            <?php if ($error_image_related) { ?>
              <span class="error"><?php echo $error_image_related; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_compare; ?></td>
            <td><input type="text" name="config_image_compare_width" value="<?php echo $config_image_compare_width; ?>" size="3" />
              x
            <input type="text" name="config_image_compare_height" value="<?php echo $config_image_compare_height; ?>" size="3" />
            <?php if ($error_image_compare) { ?>
              <span class="error"><?php echo $error_image_compare; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_wishlist; ?></td>
            <td><input type="text" name="config_image_wishlist_width" value="<?php echo $config_image_wishlist_width; ?>" size="3" />
              x
            <input type="text" name="config_image_wishlist_height" value="<?php echo $config_image_wishlist_height; ?>" size="3" />
            <?php if ($error_image_wishlist) { ?>
              <span class="error"><?php echo $error_image_wishlist; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_newsthumb; ?></td>
            <td><input type="text" name="config_image_newsthumb_width" value="<?php echo $config_image_newsthumb_width; ?>" size="3" />
              x
            <input type="text" name="config_image_newsthumb_height" value="<?php echo $config_image_newsthumb_height; ?>" size="3" />
            <?php if ($error_image_newsthumb) { ?>
              <span class="error"><?php echo $error_image_newsthumb; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_newspopup; ?></td>
            <td><input type="text" name="config_image_newspopup_width" value="<?php echo $config_image_newspopup_width; ?>" size="3" />
              x
            <input type="text" name="config_image_newspopup_height" value="<?php echo $config_image_newspopup_height; ?>" size="3" />
            <?php if ($error_image_newspopup) { ?>
              <span class="error"><?php echo $error_image_newspopup; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_cart; ?></td>
            <td><input type="text" name="config_image_cart_width" value="<?php echo $config_image_cart_width; ?>" size="3" />
              x
            <input type="text" name="config_image_cart_height" value="<?php echo $config_image_cart_height; ?>" size="3" />
            <?php if ($error_image_cart) { ?>
              <span class="error"><?php echo $error_image_cart; ?></span>
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-ftp">
        <table class="form">
          <tr>
            <td><?php echo $entry_ftp_host; ?></td>
            <td><input type="text" name="config_ftp_host" value="<?php echo $config_ftp_host; ?>" size="30" />
            <?php if ($error_ftp_host) { ?>
              <span class="error"><?php echo $error_ftp_host; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_ftp_port; ?></td>
            <td><input type="text" name="config_ftp_port" value="<?php echo $config_ftp_port; ?>" />
            <?php if ($error_ftp_port) { ?>
              <span class="error"><?php echo $error_ftp_port; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_ftp_username; ?></td>
            <td><input type="text" name="config_ftp_username" value="<?php echo $config_ftp_username; ?>" size="30" />
            <?php if ($error_ftp_username) { ?>
              <span class="error"><?php echo $error_ftp_username; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_ftp_password; ?></td>
            <td><input type="text" name="config_ftp_password" value="<?php echo $config_ftp_password; ?>" />
            <?php if ($error_ftp_password) { ?>
              <span class="error"><?php echo $error_ftp_password; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_ftp_root; ?></td>
            <td><input type="text" name="config_ftp_root" value="<?php echo $config_ftp_root; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_ftp_status; ?></td>
            <td><?php if ($config_ftp_status) { ?>
              <input type="radio" name="config_ftp_status" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_ftp_status" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_ftp_status" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_ftp_status" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-mail">
        <table class="form">
          <tr>
            <td><?php echo $entry_mail_protocol; ?></td>
            <td><select name="config_mail_protocol">
              <?php if ($config_mail_protocol == 'mail') { ?>
                <option value="mail" selected="selected"><?php echo $text_mail; ?></option>
              <?php } else { ?>
                <option value="mail"><?php echo $text_mail; ?></option>
              <?php } ?>
              <?php if ($config_mail_protocol == 'smtp') { ?>
                <option value="smtp" selected="selected"><?php echo $text_smtp; ?></option>
              <?php } else { ?>
                <option value="smtp"><?php echo $text_smtp; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_mail_parameter; ?></td>
            <td><input type="text" name="config_mail_parameter" value="<?php echo $config_mail_parameter; ?>" size="30" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_smtp_host; ?></td>
            <td><input type="text" name="config_smtp_host" value="<?php echo $config_smtp_host; ?>" size="30" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_smtp_username; ?></td>
            <td><input type="text" name="config_smtp_username" value="<?php echo $config_smtp_username; ?>" size="30" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_smtp_password; ?></td>
            <td><input type="text" name="config_smtp_password" value="<?php echo $config_smtp_password; ?>" size="30" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_smtp_port; ?></td>
            <td><input type="text" name="config_smtp_port" value="<?php echo $config_smtp_port; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_smtp_timeout; ?></td>
            <td><input type="text" name="config_smtp_timeout" value="<?php echo $config_smtp_timeout; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_alert_mail; ?></td>
            <td><?php if ($config_alert_mail) { ?>
              <input type="radio" name="config_alert_mail" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_alert_mail" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_alert_mail" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_alert_mail" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_account_mail; ?></td>
            <td><?php if ($config_account_mail) { ?>
              <input type="radio" name="config_account_mail" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_account_mail" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_account_mail" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_account_mail" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_alert_emails; ?></td>
            <td><textarea name="config_alert_emails" cols="40" rows="5"><?php echo $config_alert_emails; ?></textarea></td>
          </tr>
        </table>
      </div>
      <div id="tab-server">
        <table class="form">
          <tr>
            <td><?php echo $entry_secure; ?></td>
            <td><?php if ($config_secure) { ?>
              <input type="radio" name="config_secure" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_secure" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_secure" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_secure" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_shared; ?></td>
            <td><?php if ($config_shared) { ?>
              <input type="radio" name="config_shared" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_shared" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_shared" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_shared" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_robots; ?></td>
            <td><textarea name="config_robots" cols="40" rows="5"><?php echo $config_robots; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_seo_url; ?></td>
            <td><?php if ($config_seo_url) { ?>
              <input type="radio" name="config_seo_url" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_seo_url" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_seo_url" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_seo_url" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_file_max_size; ?></td>
            <td><input type="text" name="config_file_max_size" value="<?php echo $config_file_max_size; ?>" /> bytes
            <?php if ($error_file_max_size) { ?>
              <span class="error"><?php echo $error_file_max_size; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_file_extension_allowed; ?></td>
            <td><textarea name="config_file_extension_allowed" cols="40" rows="5"><?php echo $config_file_extension_allowed; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_file_mime_allowed; ?></td>
            <td><textarea name="config_file_mime_allowed" cols="60" rows="5"><?php echo $config_file_mime_allowed; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_maintenance; ?></td>
            <td><?php if ($config_maintenance) { ?>
              <input type="radio" name="config_maintenance" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_maintenance" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_maintenance" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_maintenance" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_password; ?></td>
            <td><?php if ($config_password) { ?>
              <input type="radio" name="config_password" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_password" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_password" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_password" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_encryption; ?></td>
            <td><input type="text" name="config_encryption" value="<?php echo $config_encryption; ?>" size="40" />
            <?php if ($error_encryption) { ?>
              <span class="error"><?php echo $error_encryption; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_compression; ?></td>
            <td><input type="text" name="config_compression" value="<?php echo $config_compression; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_error_display; ?></td>
            <td><?php if ($config_error_display) { ?>
              <input type="radio" name="config_error_display" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_error_display" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_error_display" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_error_display" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_error_log; ?></td>
            <td><?php if ($config_error_log) { ?>
              <input type="radio" name="config_error_log" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_error_log" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="config_error_log" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_error_log" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_error_filename; ?></td>
            <td><input type="text" name="config_error_filename" value="<?php echo $config_error_filename; ?>" />
            <?php if ($error_error_filename) { ?>
              <span class="error"><?php echo $error_error_filename; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_addthis; ?></td>
            <td>#pubid=<input name="config_addthis" type="text" size="30" value="<?php echo $config_addthis; ?>" /></td>
          <tr>
          <tr>
            <td><?php echo $entry_google_analytics; ?></td>
            <td><textarea name="config_google_analytics" cols="40" rows="10"><?php echo $config_google_analytics; ?></textarea></td>
          </tr>
        </table>
      </div>
    </form>
    </div>
  </div>
</div>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>

<script type="text/javascript"><!--
function initialize() {
	var input = document.getElementById('search_address');
	var autocomplete = new google.maps.places.Autocomplete(input);
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		var place = autocomplete.getPlace();

		var lat = place.geometry.location.lat();
		var lon = place.geometry.location.lng();

		document.getElementById('location_latitude').value = lat;
		document.getElementById('location_longitude').value = lon;
	});
}
google.maps.event.addDomListener(window, 'load', initialize);
//--></script>

<script type="text/javascript"><!--
$('#template').load('index.php?route=setting/setting/template&token=<?php echo $token; ?>&template=' + encodeURIComponent($('select[name=\'config_template\']').attr('value')));
//--></script>

<script type="text/javascript"><!--
$('select[name=\'config_country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=setting/setting/country&token=<?php echo $token; ?>&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="view/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?php echo $config_zone_id; ?>') {
	      				html += ' selected="selected"';
					}

					html += '>' + json['zone'][i]['name'] + '</option>';
				}

			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('select[name=\'config_zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'config_country_id\']').trigger('change');
//--></script>

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding:3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin:0; display:block; width:100%; height:100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>