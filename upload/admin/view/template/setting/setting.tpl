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
        <a href="#tab-media"><?php echo $tab_media; ?></a>
        <a href="#tab-server"><?php echo $tab_server; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><?php if ($error_name) { ?>
              <input type="text" name="config_name" value="<?php echo $config_name; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_name; ?></span>
            <?php } else { ?>
              <input type="text" name="config_name" value="<?php echo $config_name; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_owner; ?></td>
            <td><?php if ($error_owner) { ?>
              <input type="text" name="config_owner" value="<?php echo $config_owner; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_owner; ?></span>
            <?php } else { ?>
              <input type="text" name="config_owner" value="<?php echo $config_owner; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_address; ?></td>
            <td><?php if ($error_address) { ?>
              <textarea name="config_address" cols="40" rows="5" class="input-error"><?php echo $config_address; ?></textarea>
              <span class="error"><?php echo $error_address; ?></span>
            <?php } else { ?>
              <textarea name="config_address" cols="40" rows="5"><?php echo $config_address; ?></textarea>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_email; ?></td>
            <td><?php if ($error_email) { ?>
              <input type="text" name="config_email" value="<?php echo $config_email; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_email; ?></span>
            <?php } else { ?>
              <input type="text" name="config_email" value="<?php echo $config_email; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_email_noreply; ?></td>
            <td><?php if ($error_email_noreply) { ?>
              <input type="text" name="config_email_noreply" value="<?php echo $config_email_noreply; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_email_noreply; ?></span>
            <?php } else { ?>
              <input type="text" name="config_email_noreply" value="<?php echo $config_email_noreply; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
            <td><?php if ($error_telephone) { ?>
              <input type="text" name="config_telephone" value="<?php echo $config_telephone; ?>" class="input-error" />
              <span class="error"><?php echo $error_telephone; ?></span>
            <?php } else { ?>
              <input type="text" name="config_telephone" value="<?php echo $config_telephone; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_fax; ?></td>
            <td><input type="text" name="config_fax" value="<?php echo $config_fax; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_company_id; ?></td>
            <td><input type="text" name="config_company_id" value="<?php echo $config_company_id; ?>" size="40" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_company_tax_id; ?></td>
            <td><input type="text" name="config_company_tax_id" value="<?php echo $config_company_tax_id; ?>" size="40" /></td>
          </tr>
        </table>
      </div>
      <div id="tab-store">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_title; ?></td>
            <td><?php if ($error_title) { ?>
              <input type="text" name="config_title" value="<?php echo $config_title; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_title; ?></span>
            <?php } else { ?>
              <input type="text" name="config_title" value="<?php echo $config_title; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_meta_description; ?></td>
            <td><textarea name="config_meta_description" id="meta-description" data-limit="156" cols="40" rows="5"><?php echo isset($config_meta_description) ? $config_meta_description : ''; ?></textarea>
            <span id="remaining"></span></td>
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
              <input type="radio" name="config_currency_auto" value="1" id="currency-auto-on" class="radio" checked />
              <label for="currency-auto-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_currency_auto" value="0" id="currency-auto-off" class="radio" />
              <label for="currency-auto-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_currency_auto" value="1" id="currency-auto-on" class="radio" />
              <label for="currency-auto-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_currency_auto" value="0" id="currency-auto-off" class="radio" checked />
              <label for="currency-auto-off"><span><span></span></span><?php echo $text_no; ?></label>
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
        <h2><?php echo $text_datetime; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_date_format; ?></td>
            <td><select name="config_date_format">
              <?php foreach ($date_formats as $date_format) { ?>
                <?php if ($config_date_format == $date_format['format']) { ?>
                  <option value="<?php echo $date_format['format']; ?>" selected="selected"><?php echo $date_format['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $date_format['format']; ?>"><?php echo $date_format['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_time_offset; ?></td>
            <td><select name="config_time_offset">
              <?php foreach ($time_offsets as $time_offset) { ?>
                <?php if ($config_time_offset == $time_offset) { ?>
                  <option value="<?php echo $time_offset; ?>" selected="selected"><?php echo $time_offset; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $time_offset; ?>"><?php echo $time_offset; ?></option>
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
              <input type="radio" name="config_our_location" value="1" id="our-location-on" class="radio" checked />
              <label for="our-location-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_our_location" value="0" id="our-location-off" class="radio" />
              <label for="our-location-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_our_location" value="1" id="our-location-on" class="radio" />
              <label for="our-location-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_our_location" value="0" id="our-location-off" class="radio" checked />
              <label for="our-location-off"><span><span></span></span><?php echo $text_no; ?></label>
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
              <input type="radio" name="config_contact_map" value="1" id="contact-map-on" class="radio" checked />
              <label for="contact-map-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_contact_map" value="0" id="contact-map-off" class="radio" />
              <label for="contact-map-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_contact_map" value="1" id="contact-map-on" class="radio" />
              <label for="contact-map-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_contact_map" value="0" id="contact-map-off" class="radio" checked />
              <label for="contact-map-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-checkout">
        <table class="form">
          <tr>
            <td><?php echo $entry_cart_weight; ?></td>
            <td><?php if ($config_cart_weight) { ?>
              <input type="radio" name="config_cart_weight" value="1" id="cart-weight-on" class="radio" checked />
              <label for="cart-weight-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_cart_weight" value="0" id="cart-weight-off" class="radio" />
              <label for="cart-weight-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_cart_weight" value="1" id="cart-weight-on" class="radio" />
              <label for="cart-weight-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_cart_weight" value="0" id="cart-weight-off" class="radio" checked />
              <label for="cart-weight-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_guest_checkout; ?></td>
            <td><?php if ($config_guest_checkout) { ?>
              <input type="radio" name="config_guest_checkout" value="1" id="guest-checkout-on" class="radio" checked />
              <label for="guest-checkout-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_guest_checkout" value="0" id="guest-checkout-off" class="radio" />
              <label for="guest-checkout-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_guest_checkout" value="1" id="guest-checkout-on" class="radio" />
              <label for="guest-checkout-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_guest_checkout" value="0" id="guest-checkout-off" class="radio" checked />
              <label for="guest-checkout-off"><span><span></span></span><?php echo $text_no; ?></label>
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
            <td><?php echo $entry_invoice_prefix; ?></td>
            <td><input type="text" name="config_invoice_prefix" value="<?php echo $config_invoice_prefix; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_auto_invoice; ?></td>
            <td><?php if ($config_auto_invoice) { ?>
              <input type="radio" name="config_auto_invoice" value="1" id="auto-invoice-on" class="radio" checked />
              <label for="auto-invoice-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_auto_invoice" value="0" id="auto-invoice-off" class="radio" />
              <label for="auto-invoice-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_auto_invoice" value="1" id="auto-invoice-on" class="radio" />
              <label for="auto-invoice-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_auto_invoice" value="0" id="auto-invoice-off" class="radio" checked />
              <label for="auto-invoice-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_order_edit; ?></td>
            <td><input type="text" name="config_order_edit" value="<?php echo $config_order_edit; ?>" size="3" /></td>
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
        <div class="tooltip" style="margin:5px 0px 10px 0px;"><?php echo $info_express; ?></div>
        <table class="form">
          <tr>
            <td><?php echo $entry_express_checkout; ?></td>
            <td><?php if ($config_express_checkout) { ?>
              <input type="radio" name="config_express_checkout" value="1" id="express-checkout-on" class="radio" checked />
              <label for="express-checkout-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_checkout" value="0" id="express-checkout-off" class="radio" />
              <label for="express-checkout-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_express_checkout" value="1" id="express-checkout-on" class="radio" />
              <label for="express-checkout-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_checkout" value="0" id="express-checkout-off" class="radio" checked />
              <label for="express-checkout-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        </table>
        <table class="form">
          <tr>
            <td><?php echo $entry_express_name; ?></td>
            <td><?php if ($config_express_name) { ?>
              <input type="radio" name="config_express_name" value="1" id="express-name-on" class="radio" checked />
              <label for="express-name-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_name" value="0" id="express-name-off" class="radio" />
              <label for="express-name-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_express_name" value="1" id="express-name-on" class="radio" />
              <label for="express-name-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_name" value="0" id="express-name-off" class="radio" checked />
              <label for="express-name-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_password; ?></td>
            <td><select name="config_express_password">
              <?php if (isset($config_express_password)) { $selected = "selected"; ?>
                <option value="0" <?php if ($config_express_password == '0') { echo $selected; } ?>><?php echo $text_no; ?></option>
                <option value="1" <?php if ($config_express_password == '1') { echo $selected; } ?>><?php echo $text_yes; ?></option>
                <option value="2" <?php if ($config_express_password == '2') { echo $selected; } ?>><?php echo $text_hide; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_no; ?></option>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="2"><?php echo $text_hide; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_autofill; ?></td>
            <td><?php if ($config_express_autofill) { ?>
              <input type="radio" name="config_express_autofill" value="1" id="express-autofill-on" class="radio" checked />
              <label for="express-autofill-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_autofill" value="0" id="express-autofill-off" class="radio" />
              <label for="express-autofill-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_express_autofill" value="1" id="express-autofill-on" class="radio" />
              <label for="express-autofill-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_autofill" value="0" id="express-autofill-off" class="radio" checked />
              <label for="express-autofill-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_phone; ?></td>
            <td><select name="config_express_phone">
              <?php if (isset($config_express_phone)) { $selected = "selected"; ?>
                <option value="0" <?php if ($config_express_phone == '0') { echo $selected; } ?>><?php echo $text_no; ?></option>
                <option value="1" <?php if ($config_express_phone == '1') { echo $selected; } ?>><?php echo $text_yes; ?></option>
                <option value="2" <?php if ($config_express_phone == '2') { echo $selected; } ?>><?php echo $text_required; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_no; ?></option>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="2"><?php echo $text_required; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_billing; ?></td>
            <td><?php if ($config_express_billing) { ?>
              <input type="radio" name="config_express_billing" value="1" id="express-billing-on" class="radio" checked />
              <label for="express-billing-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_billing" value="0" id="express-billing-off" class="radio" />
              <label for="express-billing-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_express_billing" value="1" id="express-billing-on" class="radio" />
              <label for="express-billing-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_billing" value="0" id="express-billing-off" class="radio" checked />
              <label for="express-billing-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_postcode; ?></td>
            <td><?php if ($config_express_postcode) { ?>
              <input type="radio" name="config_express_postcode" value="1" id="express-postcode-on" class="radio" checked />
              <label for="express-postcode-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_postcode" value="0" id="express-postcode-off" class="radio" />
              <label for="express-postcode-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_express_postcode" value="1" id="express-postcode-on" class="radio" />
              <label for="express-postcode-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_postcode" value="0" id="express-postcode-off" class="radio" checked />
              <label for="express-postcode-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_comment; ?></td>
            <td><?php if ($config_express_comment) { ?>
              <input type="radio" name="config_express_comment" value="1" id="express-comment-on" class="radio" checked />
              <label for="express-comment-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_comment" value="0" id="express-comment-off" class="radio" />
              <label for="express-comment-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_express_comment" value="1" id="express-comment-on" class="radio" />
              <label for="express-comment-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_comment" value="0" id="express-comment-off" class="radio" checked />
              <label for="express-comment-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_newsletter; ?></td>
            <td><select name="config_express_newsletter">
              <?php if (isset($config_express_newsletter)) { $selected = "selected"; ?>
                <option value="0" <?php if ($config_express_newsletter == '0') { echo $selected; } ?>><?php echo $text_no; ?></option>
                <option value="1" <?php if ($config_express_newsletter == '1') { echo $selected; } ?>><?php echo $text_yes; ?></option>
                <option value="2" <?php if ($config_express_newsletter == '2') { echo $selected; } ?>><?php echo $text_choice; ?></option>
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
              <input type="radio" name="config_express_coupon" value="1" id="express-coupon-on" class="radio" checked />
              <label for="express-coupon-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_coupon" value="0" id="express-coupon-off" class="radio" />
              <label for="express-coupon-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_express_coupon" value="1" id="express-coupon-on" class="radio" />
              <label for="express-coupon-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_coupon" value="0" id="express-coupon-off" class="radio" checked />
              <label for="express-coupon-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_voucher; ?></td>
            <td><?php if ($config_express_voucher) { ?>
              <input type="radio" name="config_express_voucher" value="1" id="express-voucher-on" class="radio" checked />
              <label for="express-voucher-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_voucher" value="0" id="express-voucher-off" class="radio" />
              <label for="express-voucher-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_express_voucher" value="1" id="express-voucher-on" class="radio" />
              <label for="express-voucher-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_express_voucher" value="0" id="express-voucher-off" class="radio" checked />
              <label for="express-voucher-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_express_point; ?></td>
            <td><select name="config_express_point">
              <?php if (isset($config_express_point)) { $selected = "selected"; ?>
                <option value="0" <?php if ($config_express_point == '0') { echo $selected; } ?>><?php echo $text_no; ?></option>
                <option value="1" <?php if ($config_express_point == '1') { echo $selected; } ?>><?php echo $text_yes; ?></option>
                <option value="2" <?php if ($config_express_point == '2') { echo $selected; } ?>><?php echo $text_automatic; ?></option>
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
        <table class="form">
          <tr>
            <td><?php echo $entry_product_count; ?></td>
            <td><?php if ($config_product_count) { ?>
              <input type="radio" name="config_product_count" value="1" id="product-count-on" class="radio" checked />
              <label for="product-count-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_product_count" value="0" id="product-count-off" class="radio" />
              <label for="product-count-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_product_count" value="1" id="product-count-on" class="radio" />
              <label for="product-count-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_product_count" value="0" id="product-count-off" class="radio" checked />
              <label for="product-count-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_review; ?></td>
            <td><?php if ($config_review_status) { ?>
              <input type="radio" name="config_review_status" value="1" id="review-status-on" class="radio" checked />
              <label for="review-status-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_review_status" value="0" id="review-status-off" class="radio" />
              <label for="review-status-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_review_status" value="1" id="review-status-on" class="radio" />
              <label for="review-status-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_review_status" value="0" id="review-status-off" class="radio" checked />
              <label for="review-status-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_download; ?></td>
            <td><?php if ($config_download) { ?>
              <input type="radio" name="config_download" value="1" id="download-on" class="radio" checked />
              <label for="download-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_download" value="0" id="download-off" class="radio" />
              <label for="download-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_download" value="1" id="download-on" class="radio" />
              <label for="download-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_download" value="0" id="download-off" class="radio" checked />
              <label for="download-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_tax; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_tax; ?></td>
            <td><?php if ($config_tax) { ?>
              <input type="radio" name="config_tax" value="1" id="tax-on" class="radio" checked />
              <label for="tax-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_tax" value="0" id="tax-off" class="radio" />
              <label for="tax-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_tax" value="1" id="tax-on" class="radio" />
              <label for="tax-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_tax" value="0" id="tax-off" class="radio" checked />
              <label for="tax-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_vat; ?></td>
            <td><?php if ($config_vat) { ?>
              <input type="radio" name="config_vat" value="1" id="vat-on" class="radio" checked />
              <label for="vat-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_vat" value="0" id="vat-off" class="radio" />
              <label for="vat-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_vat" value="1" id="vat-on" class="radio" />
              <label for="vat-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_vat" value="0" id="vat-off" class="radio" checked />
              <label for="vat-off"><span><span></span></span><?php echo $text_no; ?></label>
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
              <input type="radio" name="config_stock_display" value="1" id="stock-display-on" class="radio" checked />
              <label for="stock-display-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_stock_display" value="0" id="stock-display-off" class="radio" />
              <label for="stock-display-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_stock_display" value="1" id="stock-display-on" class="radio" />
              <label for="stock-display-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_stock_display" value="0" id="stock-display-off" class="radio" checked />
              <label for="stock-display-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_stock_warning; ?></td>
            <td><?php if ($config_stock_warning) { ?>
              <input type="radio" name="config_stock_warning" value="1" id="stock-warning-on" class="radio" checked />
              <label for="stock-warning-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_stock_warning" value="0" id="stock-warning-off" class="radio" />
              <label for="stock-warning-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_stock_warning" value="1" id="stock-warning-on" class="radio" />
              <label for="stock-warning-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_stock_warning" value="0" id="stock-warning-off" class="radio" checked />
              <label for="stock-warning-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_stock_checkout; ?></td>
            <td><?php if ($config_stock_checkout) { ?>
              <input type="radio" name="config_stock_checkout" value="1" id="stock-checkout-on" class="radio" checked />
              <label for="stock-checkout-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_stock_checkout" value="0" id="stock-checkout-off" class="radio" />
              <label for="stock-checkout-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_stock_checkout" value="1" id="stock-checkout-on" class="radio" />
              <label for="stock-checkout-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_stock_checkout" value="0" id="stock-checkout-off" class="radio" checked />
              <label for="stock-checkout-off"><span><span></span></span><?php echo $text_no; ?></label>
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
              <input type="radio" name="config_customer_online" value="1" id="customer-online-on" class="radio" checked />
              <label for="customer-online-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_online" value="0" id="customer-online-off" class="radio" />
              <label for="customer-online-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_customer_online" value="1" id="customer-online-on" class="radio" />
              <label for="customer-online-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_online" value="0" id="customer-online-off" class="radio" checked />
              <label for="customer-online-off"><span><span></span></span><?php echo $text_no; ?></label>
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
            <td><span class="required">*</span> <?php echo $entry_customer_group_display; ?></td>
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
              <input type="radio" name="config_customer_price" value="1" id="customer-price-on" class="radio" checked />
              <label for="customer-price-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_price" value="0" id="customer-price-off" class="radio" />
              <label for="customer-price-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_customer_price" value="1" id="customer-price-on" class="radio" />
              <label for="customer-price-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_price" value="0" id="customer-price-off" class="radio" checked />
              <label for="customer-price-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer_redirect; ?></td>
            <td><?php if ($config_customer_redirect) { ?>
              <input type="radio" name="config_customer_redirect" value="1" id="customer-redirect-on" class="radio" checked />
              <label for="customer-redirect-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_redirect" value="0" id="customer-redirect-off" class="radio" />
              <label for="customer-redirect-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_customer_redirect" value="1" id="customer-redirect-on" class="radio" />
              <label for="customer-redirect-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_redirect" value="0" id="customer-redirect-off" class="radio" checked />
              <label for="customer-redirect-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer_fax; ?></td>
            <td><?php if ($config_customer_fax) { ?>
              <input type="radio" name="config_customer_fax" value="1" id="customer-fax-on" class="radio" checked />
              <label for="customer-fax-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_fax" value="0" id="customer-fax-off" class="radio" />
              <label for="customer-fax-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_customer_fax" value="1" id="customer-fax-on" class="radio" />
              <label for="customer-fax-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_fax" value="0" id="customer-fax-off" class="radio" checked />
              <label for="customer-fax-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer_gender; ?></td>
            <td><?php if ($config_customer_gender) { ?>
              <input type="radio" name="config_customer_gender" value="1" id="customer-gender-on" class="radio" checked />
              <label for="customer-gender-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_gender" value="0" id="customer-gender-off" class="radio" />
              <label for="customer-gender-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_customer_gender" value="1" id="customer-gender-on" class="radio" />
              <label for="customer-gender-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_gender" value="0" id="customer-gender-off" class="radio" checked />
              <label for="customer-gender-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer_dob; ?></td>
            <td><?php if ($config_customer_dob) { ?>
              <input type="radio" name="config_customer_dob" value="1" id="customer-dob-on" class="radio" checked />
              <label for="customer-dob-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_dob" value="0" id="customer-dob-off" class="radio" />
              <label for="customer-dob-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_customer_dob" value="1" id="customer-dob-on" class="radio" />
              <label for="customer-dob-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_customer_dob" value="0" id="customer-dob-off" class="radio" checked />
              <label for="customer-dob-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_picklist_status; ?></td>
            <td><?php if ($config_picklist_status) { ?>
              <input type="radio" name="config_picklist_status" value="1" id="picklist_status-on" class="radio" checked />
              <label for="picklist_status-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_picklist_status" value="0" id="picklist_status-off" class="radio" />
              <label for="picklist_status-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_picklist_status" value="1" id="picklist_status-on" class="radio" />
              <label for="picklist_status-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_picklist_status" value="0" id="picklist_status-off" class="radio" checked />
              <label for="picklist_status-off"><span><span></span></span><?php echo $text_no; ?></label>
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
              <input type="radio" name="config_affiliate_fax" value="1" id="affiliate-fax-on" class="radio" checked />
              <label for="affiliate-fax-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_affiliate_fax" value="0" id="affiliate-fax-off" class="radio" />
              <label for="affiliate-fax-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_affiliate_fax" value="1" id="affiliate-fax-on" class="radio" />
              <label for="affiliate-fax-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_affiliate_fax" value="0" id="affiliate-fax-off" class="radio" checked />
              <label for="affiliate-fax-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_affiliate_disable; ?></td>
            <td><?php if ($config_affiliate_disable) { ?>
              <input type="radio" name="config_affiliate_disable" value="1" id="affiliate-disable-on" class="radio" checked />
              <label for="affiliate-disable-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_affiliate_disable" value="0" id="affiliate-disable-off" class="radio" />
              <label for="affiliate-disable-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_affiliate_disable" value="1" id="affiliate-disable-on" class="radio" />
              <label for="affiliate-disable-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_affiliate_disable" value="0" id="affiliate-disable-off" class="radio" checked />
              <label for="affiliate-disable-off"><span><span></span></span><?php echo $text_no; ?></label>
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
              <input type="radio" name="config_return_disable" value="1" id="return-disable-on" class="radio" checked />
              <label for="return-disable-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_return_disable" value="0" id="return-disable-off" class="radio" />
              <label for="return-disable-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_return_disable" value="1" id="return-disable-on" class="radio" />
              <label for="return-disable-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_return_disable" value="0" id="return-disable-off" class="radio" checked />
              <label for="return-disable-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_voucher; ?></h2>
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_voucher_min; ?></td>
            <td><?php if ($error_voucher_min) { ?>
              <input type="text" name="config_voucher_min" value="<?php echo $config_voucher_min; ?>" class="input-error" />
              <span class="error"><?php echo $error_voucher_min; ?></span>
            <?php } else { ?>
              <input type="text" name="config_voucher_min" value="<?php echo $config_voucher_min; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_voucher_max; ?></td>
            <td><?php if ($error_voucher_max) { ?>
              <input type="text" name="config_voucher_max" value="<?php echo $config_voucher_max; ?>" class="input-error" />
              <span class="error"><?php echo $error_voucher_max; ?></span>
            <?php } else { ?>
              <input type="text" name="config_voucher_max" value="<?php echo $config_voucher_max; ?>" />
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-preference">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_catalog_limit; ?></td>
            <td><?php if ($error_catalog_limit) { ?>
              <input type="text" name="config_catalog_limit" value="<?php echo $config_catalog_limit; ?>" size="3" class="input-error" />
              <span class="error"><?php echo $error_catalog_limit; ?></span>
            <?php } else { ?>
              <input type="text" name="config_catalog_limit" value="<?php echo $config_catalog_limit; ?>" size="3" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_admin_limit; ?></td>
            <td><?php if ($error_admin_limit) { ?>
              <input type="text" name="config_admin_limit" value="<?php echo $config_admin_limit; ?>" size="3" class="input-error" />
              <span class="error"><?php echo $error_admin_limit; ?></span>
            <?php } else { ?>
              <input type="text" name="config_admin_limit" value="<?php echo $config_admin_limit; ?>" size="3" />
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_forms; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_pagination_hi; ?></td>
            <td><?php if ($config_pagination_hi) { ?>
              <input type="radio" name="config_pagination_hi" value="1" id="pagination-hi-on" class="radio" checked />
              <label for="pagination-hi-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_pagination_hi" value="0" id="pagination-hi-off" class="radio" />
              <label for="pagination-hi-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_pagination_hi" value="1" id="pagination-hi-on" class="radio" />
              <label for="pagination-hi-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_pagination_hi" value="0" id="pagination-hi-off" class="radio" checked />
              <label for="pagination-hi-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?>
            <?php if ($error_preference_pagination) { ?>
              <span class="error"><?php echo $error_preference_pagination; ?></span>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_pagination_lo; ?></td>
            <td><?php if ($config_pagination_lo) { ?>
              <input type="radio" name="config_pagination_lo" value="1" id="pagination-lo-on" class="radio" checked />
              <label for="pagination-lo-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_pagination_lo" value="0" id="pagination-lo-off" class="radio" />
              <label for="pagination-lo-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_pagination_lo" value="1" id="pagination-lo-on" class="radio" />
              <label for="pagination-lo-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_pagination_lo" value="0" id="pagination-lo-off" class="radio" checked />
              <label for="pagination-lo-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?>
            <?php if ($error_preference_pagination) { ?>
              <span class="error"><?php echo $error_preference_pagination; ?></span>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_autocomplete_category; ?></td>
            <td><?php if ($config_autocomplete_category) { ?>
              <input type="radio" name="config_autocomplete_category" value="1" id="autocomplete-category-on" class="radio" checked />
              <label for="autocomplete-category-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_autocomplete_category" value="0" id="autocomplete-category-off" class="radio" />
              <label for="autocomplete-category-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_autocomplete_category" value="1" id="autocomplete-category-on" class="radio" />
              <label for="autocomplete-category-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_autocomplete_category" value="0" id="autocomplete-category-off" class="radio" checked />
              <label for="autocomplete-category-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_autocomplete_product; ?></td>
            <td><?php if ($config_autocomplete_product) { ?>
              <input type="radio" name="config_autocomplete_product" value="1" id="autocomplete-product-on" class="radio" checked />
              <label for="autocomplete-product-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_autocomplete_product" value="0" id="autocomplete-product-off" class="radio" />
              <label for="autocomplete-product-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_autocomplete_product" value="1" id="autocomplete-product-on" class="radio" />
              <label for="autocomplete-product-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_autocomplete_product" value="0" id="autocomplete-product-off" class="radio" checked />
              <label for="autocomplete-product-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_autocomplete_offer; ?></td>
            <td><?php if ($config_autocomplete_offer) { ?>
              <input type="radio" name="config_autocomplete_offer" value="1" id="autocomplete-offer-on" class="radio" checked />
              <label for="autocomplete-offer-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_autocomplete_offer" value="0" id="autocomplete-offer-off" class="radio" />
              <label for="autocomplete-offer-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_autocomplete_offer" value="1" id="autocomplete-offer-on" class="radio" />
              <label for="autocomplete-offer-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_autocomplete_offer" value="0" id="autocomplete-offer-off" class="radio" checked />
              <label for="autocomplete-offer-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_product; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_lightbox; ?></td>
            <td><select name="config_lightbox">
              <?php if (isset($config_lightbox)) { $selected = "selected"; ?>
                <option value="colorbox" <?php if ($config_lightbox == 'colorbox') { echo $selected; } ?>><?php echo $text_colorbox; ?> <?php echo $text_default; ?></option>
                <option value="swipebox" <?php if ($config_lightbox == 'swipebox') { echo $selected; } ?>><?php echo $text_swipebox; ?></option>
                <option value="magnific" <?php if ($config_lightbox == 'magnific') { echo $selected; } ?>><?php echo $text_magnific; ?></option>
                <option value="zoomlens" <?php if ($config_lightbox == 'zoomlens') { echo $selected; } ?>><?php echo $text_zoomlens; ?></option>
              <?php } else { ?>
                <option value="colorbox"><?php echo $text_colorbox; ?> <?php echo $text_default; ?></option>
                <option value="swipebox"><?php echo $text_swipebox; ?></option>
                <option value="magnific"><?php echo $text_magnific; ?></option>
                <option value="zoomlens"><?php echo $text_zoomlens; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_offer_label; ?></td>
            <td><?php if ($config_offer_label) { ?>
              <input type="radio" name="config_offer_label" value="1" id="offer-label-on" class="radio" checked />
              <label for="offer-label-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_offer_label" value="0" id="offer-label-off" class="radio" />
              <label for="offer-label-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_offer_label" value="1" id="offer-label-on" class="radio" />
              <label for="offer-label-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_offer_label" value="0" id="offer-label-off" class="radio" checked />
              <label for="offer-label-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_share_addthis; ?></td>
            <td><?php if ($config_share_addthis) { ?>
              <input type="radio" name="config_share_addthis" value="1" id="share-addthis-on" class="radio" checked />
              <label for="share-addthis-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_share_addthis" value="0" id="share-addthis-off" class="radio" />
              <label for="share-addthis-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_share_addthis" value="1" id="share-addthis-on" class="radio" />
              <label for="share-addthis-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_share_addthis" value="0" id="share-addthis-off" class="radio" checked />
              <label for="share-addthis-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_price_free; ?></td>
            <td><?php if ($config_price_free) { ?>
              <input type="radio" name="config_price_free" value="1" id="price-free-on" class="radio" checked />
              <label for="price-free-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_price_free" value="0" id="price-free-off" class="radio" />
              <label for="price-free-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_price_free" value="1" id="price-free-on" class="radio" />
              <label for="price-free-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_price_free" value="0" id="price-free-off" class="radio" checked />
              <label for="price-free-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_captcha; ?></h2>
        <table class="form">
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
        </table>
        <h2><?php echo $text_cookies; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_cookie_consent; ?></td>
            <td><?php if ($config_cookie_consent) { ?>
              <input type="radio" name="config_cookie_consent" value="1" id="cookie-consent-on" class="radio" checked />
              <label for="cookie-consent-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_cookie_consent" value="0" id="cookie-consent-off" class="radio" />
              <label for="cookie-consent-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_cookie_consent" value="1" id="cookie-consent-on" class="radio" />
              <label for="cookie-consent-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_cookie_consent" value="0" id="cookie-consent-off" class="radio" checked />
              <label for="cookie-consent-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_cookie_theme; ?></td>
            <td><select name="config_cookie_theme">
              <?php if (isset($config_cookie_theme)) { $selected = "selected"; ?>
                <option value="dark" <?php if ($config_cookie_theme == 'dark') { echo $selected; } ?>><?php echo $text_black; ?> <?php echo $text_default; ?></option>
                <option value="light" <?php if ($config_cookie_theme == 'light') { echo $selected; } ?>><?php echo $text_white; ?></option>
              <?php } else { ?>
                <option value="dark"><?php echo $text_black; ?> <?php echo $text_default; ?></option>
                <option value="light"><?php echo $text_white; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_cookie_position; ?></td>
            <td><select name="config_cookie_position">
              <?php if (isset($config_cookie_position)) { $selected = "selected"; ?>
                <option value="top" <?php if ($config_cookie_position == 'top') { echo $selected; } ?>><?php echo $text_top; ?> <?php echo $text_default; ?></option>
                <option value="bottom" <?php if ($config_cookie_position == 'bottom') { echo $selected; } ?>><?php echo $text_bottom; ?></option>
              <?php } else { ?>
                <option value="top"><?php echo $text_top; ?> <?php echo $text_default; ?></option>
                <option value="bottom"><?php echo $text_bottom; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_cookie_privacy; ?></td>
            <td><select name="config_cookie_privacy">
              <?php foreach ($information_pages as $information) { ?>
                <?php if ($information['information_id'] == $config_cookie_privacy) { ?>
                  <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_cookie_age; ?></td>
            <td><input type="text" name="config_cookie_age" value="<?php echo $config_cookie_age; ?>" size="5" /></td>
          </tr>
        </table>
        <h2><?php echo $text_news; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_news_addthis; ?></td>
            <td><?php if ($config_news_addthis) { ?>
              <input type="radio" name="config_news_addthis" value="1" id="news-addthis-on" class="radio" checked />
              <label for="news-addthis-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_news_addthis" value="0" id="news-addthis-off" class="radio" />
              <label for="news-addthis-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_news_addthis" value="1" id="news-addthis-on" class="radio" />
              <label for="news-addthis-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_news_addthis" value="0" id="news-addthis-off" class="radio" checked />
              <label for="news-addthis-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_news_chars; ?></td>
            <td><input type="text" name="config_news_chars" value="<?php echo $config_news_chars; ?>" size="5" /> <?php echo $text_characters; ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-image">
        <table class="form">
          <tr>
            <td><?php echo $entry_logo; ?></td>
            <td><div class="image"><img src="<?php echo $logo; ?>" alt="" id="thumb-logo" /><br />
              <input type="hidden" name="config_logo" value="<?php echo $config_logo; ?>" id="logo" />
              <a onclick="image_upload('logo', 'thumb-logo');" class="button-browse"></a><a onclick="$('#thumb-logo').attr('src', '<?php echo $no_image; ?>'); $('#logo').attr('value', '');" class="button-recycle"></a>
            </div></td>
          </tr>
          <tr>
            <td><?php echo $entry_icon; ?></td>
            <td><div class="image"><img src="<?php echo $icon; ?>" alt="" id="thumb-icon" /><br />
              <input type="hidden" name="config_icon" value="<?php echo $config_icon; ?>" id="icon" />
              <a onclick="image_upload('icon', 'thumb-icon');" class="button-browse"></a><a onclick="$('#thumb-icon').attr('src', '<?php echo $no_image; ?>'); $('#icon').attr('value', '');" class="button-recycle"></a>
            </div></td>
          </tr>
        </table>
        <h2><?php echo $text_image_resize; ?></h2>
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_category; ?></td>
            <td><?php if ($error_image_category) { ?>
              <input type="text" name="config_image_category_width" value="<?php echo $config_image_category_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_category_height" value="<?php echo $config_image_category_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_category; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_category_width" value="<?php echo $config_image_category_width; ?>" size="3" /> x
              <input type="text" name="config_image_category_height" value="<?php echo $config_image_category_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_thumb; ?></td>
            <td><?php if ($error_image_thumb) { ?>
              <input type="text" name="config_image_thumb_width" value="<?php echo $config_image_thumb_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_thumb_height" value="<?php echo $config_image_thumb_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_thumb; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_thumb_width" value="<?php echo $config_image_thumb_width; ?>" size="3" /> x
              <input type="text" name="config_image_thumb_height" value="<?php echo $config_image_thumb_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_popup; ?></td>
            <td><?php if ($error_image_popup) { ?>
              <input type="text" name="config_image_popup_width" value="<?php echo $config_image_popup_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_popup_height" value="<?php echo $config_image_popup_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_popup; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_popup_width" value="<?php echo $config_image_popup_width; ?>" size="3" /> x
              <input type="text" name="config_image_popup_height" value="<?php echo $config_image_popup_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_product; ?></td>
            <td><?php if ($error_image_product) { ?>
              <input type="text" name="config_image_product_width" value="<?php echo $config_image_product_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_product_height" value="<?php echo $config_image_product_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_product; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_product_width" value="<?php echo $config_image_product_width; ?>" size="3" /> x
              <input type="text" name="config_image_product_height" value="<?php echo $config_image_product_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_additional; ?></td>
            <td><?php if ($error_image_additional) { ?>
              <input type="text" name="config_image_additional_width" value="<?php echo $config_image_additional_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_additional_height" value="<?php echo $config_image_additional_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_additional; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_additional_width" value="<?php echo $config_image_additional_width; ?>" size="3" /> x
              <input type="text" name="config_image_additional_height" value="<?php echo $config_image_additional_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_brand; ?></td>
            <td><?php if ($error_image_brand) { ?>
              <input type="text" name="config_image_brand_width" value="<?php echo $config_image_brand_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_brand_height" value="<?php echo $config_image_brand_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_brand; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_brand_width" value="<?php echo $config_image_brand_width; ?>" size="3" /> x
              <input type="text" name="config_image_brand_height" value="<?php echo $config_image_brand_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_related; ?></td>
            <td><?php if ($error_image_related) { ?>
              <input type="text" name="config_image_related_width" value="<?php echo $config_image_related_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_related_height" value="<?php echo $config_image_related_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_related; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_related_width" value="<?php echo $config_image_related_width; ?>" size="3" /> x
              <input type="text" name="config_image_related_height" value="<?php echo $config_image_related_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_compare; ?></td>
            <td><?php if ($error_image_compare) { ?>
              <input type="text" name="config_image_compare_width" value="<?php echo $config_image_compare_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_compare_height" value="<?php echo $config_image_compare_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_compare; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_compare_width" value="<?php echo $config_image_compare_width; ?>" size="3" /> x
              <input type="text" name="config_image_compare_height" value="<?php echo $config_image_compare_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_wishlist; ?></td>
            <td><?php if ($error_image_wishlist) { ?>
              <input type="text" name="config_image_wishlist_width" value="<?php echo $config_image_wishlist_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_wishlist_height" value="<?php echo $config_image_wishlist_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_wishlist; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_wishlist_width" value="<?php echo $config_image_wishlist_width; ?>" size="3" /> x
              <input type="text" name="config_image_wishlist_height" value="<?php echo $config_image_wishlist_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_newsthumb; ?></td>
            <td><?php if ($error_image_newsthumb) { ?>
              <input type="text" name="config_image_newsthumb_width" value="<?php echo $config_image_newsthumb_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_newsthumb_height" value="<?php echo $config_image_newsthumb_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_newsthumb; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_newsthumb_width" value="<?php echo $config_image_newsthumb_width; ?>" size="3" /> x
              <input type="text" name="config_image_newsthumb_height" value="<?php echo $config_image_newsthumb_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_newspopup; ?></td>
            <td><?php if ($error_image_newspopup) { ?>
              <input type="text" name="config_image_newspopup_width" value="<?php echo $config_image_newspopup_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_newspopup_height" value="<?php echo $config_image_newspopup_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_newspopup; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_newspopup_width" value="<?php echo $config_image_newspopup_width; ?>" size="3" /> x
              <input type="text" name="config_image_newspopup_height" value="<?php echo $config_image_newspopup_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_cart; ?></td>
            <td><?php if ($error_image_cart) { ?>
              <input type="text" name="config_image_cart_width" value="<?php echo $config_image_cart_width; ?>" size="3" class="input-error" /> x
              <input type="text" name="config_image_cart_height" value="<?php echo $config_image_cart_height; ?>" size="3" class="input-error" /> px
              <span class="error"><?php echo $error_image_cart; ?></span>
            <?php } else { ?>
              <input type="text" name="config_image_cart_width" value="<?php echo $config_image_cart_width; ?>" size="3" /> x
              <input type="text" name="config_image_cart_height" value="<?php echo $config_image_cart_height; ?>" size="3" /> px
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-ftp">
        <table class="form">
          <tr>
            <td><?php echo $entry_ftp_status; ?></td>
            <td><?php if ($config_ftp_status) { ?>
              <input type="radio" name="config_ftp_status" value="1" id="ftp-status-on" class="radio" checked />
              <label for="ftp-status-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_ftp_status" value="0" id="ftp-status-off" class="radio" />
              <label for="ftp-status-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_ftp_status" value="1" id="ftp-status-on" class="radio" />
              <label for="ftp-status-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_ftp_status" value="0" id="ftp-status-off" class="radio" checked />
              <label for="ftp-status-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_ftp_host; ?></td>
            <td><?php if ($error_ftp_host) { ?>
              <input type="text" name="config_ftp_host" value="<?php echo $config_ftp_host; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_ftp_host; ?></span>
            <?php } else { ?>
              <input type="text" name="config_ftp_host" value="<?php echo $config_ftp_host; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_ftp_port; ?></td>
            <td><?php if ($error_ftp_port) { ?>
              <input type="text" name="config_ftp_port" value="<?php echo $config_ftp_port; ?>" class="input-error" />
              <span class="error"><?php echo $error_ftp_port; ?></span>
            <?php } else { ?>
              <input type="text" name="config_ftp_port" value="<?php echo $config_ftp_port; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_ftp_username; ?></td>
            <td><?php if ($error_ftp_username) { ?>
              <input type="text" name="config_ftp_username" value="<?php echo $config_ftp_username; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_ftp_username; ?></span>
            <?php } else { ?>
              <input type="text" name="config_ftp_username" value="<?php echo $config_ftp_username; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_ftp_password; ?></td>
            <td><?php if ($error_ftp_password) { ?>
              <input type="text" name="config_ftp_password" value="<?php echo $config_ftp_password; ?>" class="input-error" />
              <span class="error"><?php echo $error_ftp_password; ?></span>
            <?php } else { ?>
              <input type="text" name="config_ftp_password" value="<?php echo $config_ftp_password; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_ftp_root; ?></td>
            <td><input type="text" name="config_ftp_root" value="<?php echo $config_ftp_root; ?>" /></td>
          </tr>
        </table>
      </div>
      <div id="tab-mail">
        <table class="form">
          <tbody>
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
          </tbody>
          <tbody id="protocol-mail" class="protocol">
          <tr>
            <td><?php echo $entry_mail_parameter; ?></td>
            <td><input type="text" name="config_mail_parameter" value="<?php echo $config_mail_parameter; ?>" size="30" /></td>
          </tr>
          </tbody>
          <tbody id="protocol-smtp" class="protocol">
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
          </tbody>
          <tr>
            <td><?php echo $entry_alert_mail; ?></td>
            <td><?php if ($config_alert_mail) { ?>
              <input type="radio" name="config_alert_mail" value="1" id="alert-mail-on" class="radio" checked />
              <label for="alert-mail-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_alert_mail" value="0" id="alert-mail-off" class="radio" />
              <label for="alert-mail-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_alert_mail" value="1" id="alert-mail-on" class="radio" />
              <label for="alert-mail-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_alert_mail" value="0" id="alert-mail-off" class="radio" checked />
              <label for="alert-mail-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_account_mail; ?></td>
            <td><?php if ($config_account_mail) { ?>
              <input type="radio" name="config_account_mail" value="1" id="account-mail-on" class="radio" checked />
              <label for="account-mail-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_account_mail" value="0" id="account-mail-off" class="radio" />
              <label for="account-mail-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_account_mail" value="1" id="account-mail-on" class="radio" />
              <label for="account-mail-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_account_mail" value="0" id="account-mail-off" class="radio" checked />
              <label for="account-mail-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_alert_emails; ?></td>
            <td><textarea name="config_alert_emails" cols="40" rows="5"><?php echo $config_alert_emails; ?></textarea></td>
          </tr>
        </table>
      </div>
      <div id="tab-media">
        <table class="form">
          <tr>
            <td><?php echo $entry_facebook; ?></td>
            <td><input name="config_facebook" type="text" size="60" value="<?php echo $config_facebook; ?>" /></td>
          <tr>
          <tr>
            <td><?php echo $entry_twitter; ?></td>
            <td><input name="config_twitter" type="text" size="60" value="<?php echo $config_twitter; ?>" /></td>
          <tr>
          <tr>
            <td><?php echo $entry_google; ?></td>
            <td><input name="config_google" type="text" size="60" value="<?php echo $config_google; ?>" /></td>
          <tr>
          <tr>
            <td><?php echo $entry_pinterest; ?></td>
            <td><input name="config_pinterest" type="text" size="60" value="<?php echo $config_pinterest; ?>" /></td>
          <tr>
          <tr>
            <td><?php echo $entry_skype; ?></td>
            <td><input name="config_skype" type="text" size="50" value="<?php echo $config_skype; ?>" /></td>
          <tr>
          <tr>
            <td><?php echo $entry_addthis; ?></td>
            <td>#pubid=<input name="config_addthis" type="text" size="30" value="<?php echo $config_addthis; ?>" /></td>
          <tr>
        </table>
        <h2><?php echo $text_verification; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_meta_google; ?></td>
            <td><input type="text" name="config_meta_google" value="<?php echo $config_meta_google; ?>" size="50" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_meta_bing; ?></td>
            <td><input type="text" name="config_meta_bing" value="<?php echo $config_meta_bing; ?>" size="50" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_meta_yandex; ?></td>
            <td><input type="text" name="config_meta_yandex" value="<?php echo $config_meta_yandex; ?>" size="50" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_meta_baidu; ?></td>
            <td><input type="text" name="config_meta_baidu" value="<?php echo $config_meta_baidu; ?>" size="50" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_meta_alexa; ?></td>
            <td><input type="text" name="config_meta_alexa" value="<?php echo $config_meta_alexa; ?>" size="50" /></td>
          </tr>
        </table>
        <h2><?php echo $text_analytic; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_google_analytics; ?></td>
            <td><textarea name="config_google_analytics" cols="40" rows="10"><?php echo $config_google_analytics; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_alexa_analytics; ?></td>
            <td><textarea name="config_alexa_analytics" cols="40" rows="10"><?php echo $config_alexa_analytics; ?></textarea></td>
          </tr>
        </table>
        <div>
          <table width="100%">
            <tr>
              <td>
                <a onclick="window.open('<?php echo $google_web; ?>');" title="Google Webmaster Tools"><img src="view/image/engines/google-web.gif" alt="Google" /></a> &nbsp;
                <a onclick="window.open('<?php echo $bing_web; ?>');" title="Bing Webmaster Tools"><img src="view/image/engines/bing-web.gif" alt="Bing" /></a> &nbsp;
                <a onclick="window.open('<?php echo $yandex_web; ?>');" title="Yandex Webmaster Tools"><img src="view/image/engines/yandex-web.gif" alt="Yandex" /></a> &nbsp;
                <a onclick="window.open('<?php echo $baidu_web; ?>');" title="Baidu Webmaster Tools"><img src="view/image/engines/baidu-web.gif" alt="Baidu" /></a> &nbsp;
                <a onclick="window.open('<?php echo $alexa_web; ?>');" title="Alexa Analytics"><img src="view/image/engines/alexa-web.gif" alt="Alexa" /></a> &nbsp;
              </td>
            </tr>
          </table>
        </div>
        <div class="tooltip" style="margin:5px 0px 10px 0px;"><?php echo $info_meta_name; ?></div>
      </div>
      <div id="tab-server">
        <table class="form">
          <tr>
            <td><?php echo $entry_maintenance; ?></td>
            <td><?php if ($config_maintenance) { ?>
              <input type="radio" name="config_maintenance" value="1" id="maintenance-on" class="radio" checked />
              <label for="maintenance-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_maintenance" value="0" id="maintenance-off" class="radio" />
              <label for="maintenance-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_maintenance" value="1" id="maintenance-on" class="radio" />
              <label for="maintenance-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_maintenance" value="0" id="maintenance-off" class="radio" checked />
              <label for="maintenance-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_seo_url; ?></td>
            <td><?php if ($config_seo_url) { ?>
              <input type="radio" name="config_seo_url" value="1" id="seo-url-on" class="radio" checked />
              <label for="seo-url-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_seo_url" value="0" id="seo-url-off" class="radio" />
              <label for="seo-url-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_seo_url" value="1" id="seo-url-on" class="radio" />
              <label for="seo-url-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_seo_url" value="0" id="seo-url-off" class="radio" checked />
              <label for="seo-url-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_seo_url_cache; ?></td>
            <td><?php if ($config_seo_url_cache) { ?>
              <input type="radio" name="config_seo_url_cache" value="1" id="seo-cache-on" class="radio" checked />
              <label for="seo-cache-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_seo_url_cache" value="0" id="seo-cache-off" class="radio" />
              <label for="seo-cache-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_seo_url_cache" value="1" id="seo-cache-on" class="radio" />
              <label for="seo-cache-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_seo_url_cache" value="0" id="seo-cache-off" class="radio" checked />
              <label for="seo-cache-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_encryption; ?></td>
            <td><?php if ($error_encryption) { ?>
              <input type="text" name="config_encryption" value="<?php echo $config_encryption; ?>" size="42" class="input-error" />
              <span class="error"><?php echo $error_encryption; ?></span>
            <?php } else { ?>
              <input type="text" name="config_encryption" value="<?php echo $config_encryption; ?>" size="42" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_compression; ?></td>
            <td><input type="text" name="config_compression" value="<?php echo $config_compression; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_error_display; ?></td>
            <td><?php if ($config_error_display) { ?>
              <input type="radio" name="config_error_display" value="1" id="error-display-on" class="radio" checked />
              <label for="error-display-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_error_display" value="0" id="error-display-off" class="radio" />
              <label for="error-display-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_error_display" value="1" id="error-display-on" class="radio" />
              <label for="error-display-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_error_display" value="0" id="error-display-off" class="radio" checked />
              <label for="error-display-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_error_log; ?></td>
            <td><?php if ($config_error_log) { ?>
              <input type="radio" name="config_error_log" value="1" id="error-log-on" class="radio" checked />
              <label for="error-log-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_error_log" value="0" id="error-log-off" class="radio" />
              <label for="error-log-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_error_log" value="1" id="error-log-on" class="radio" />
              <label for="error-log-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_error_log" value="0" id="error-log-off" class="radio" checked />
              <label for="error-log-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_error_filename; ?></td>
            <td><?php if ($error_error_filename) { ?>
              <input type="text" name="config_error_filename" value="<?php echo $config_error_filename; ?>" class="input-error" />
              <span class="error"><?php echo $error_error_filename; ?></span>
            <?php } else { ?>
              <input type="text" name="config_error_filename" value="<?php echo $config_error_filename; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_mail_filename; ?></td>
            <td><?php if ($error_mail_filename) { ?>
              <input type="text" name="config_mail_filename" value="<?php echo $config_mail_filename; ?>" class="input-error" />
              <span class="error"><?php echo $error_mail_filename; ?></span>
            <?php } else { ?>
              <input type="text" name="config_mail_filename" value="<?php echo $config_mail_filename; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_quote_filename; ?></td>
            <td><?php if ($error_quote_filename) { ?>
              <input type="text" name="config_quote_filename" value="<?php echo $config_quote_filename; ?>" class="input-error" />
              <span class="error"><?php echo $error_quote_filename; ?></span>
            <?php } else { ?>
              <input type="text" name="config_quote_filename" value="<?php echo $config_quote_filename; ?>" />
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_security; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_secure; ?></td>
            <td><?php if ($config_secure) { ?>
              <input type="radio" name="config_secure" value="1" id="secure-on" class="radio" checked />
              <label for="secure-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_secure" value="0" id="secure-off" class="radio" />
              <label for="secure-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_secure" value="1" id="secure-on" class="radio" />
              <label for="secure-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_secure" value="0" id="secure-off" class="radio" checked />
              <label for="secure-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_shared; ?></td>
            <td><?php if ($config_shared) { ?>
              <input type="radio" name="config_shared" value="1" id="shared-on" class="radio" checked />
              <label for="shared-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_shared" value="0" id="shared-off" class="radio" />
              <label for="shared-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_shared" value="1" id="shared-on" class="radio" />
              <label for="shared-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_shared" value="0" id="shared-off" class="radio" checked />
              <label for="shared-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_robots; ?></td>
            <td><textarea name="config_robots" cols="40" rows="5"><?php echo $config_robots; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_password; ?></td>
            <td><?php if ($config_password) { ?>
              <input type="radio" name="config_password" value="1" id="password-on" class="radio" checked />
              <label for="password-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_password" value="0" id="password-off" class="radio" />
              <label for="password-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_password" value="1" id="password-on" class="radio" />
              <label for="password-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_password" value="0" id="password-off" class="radio" checked />
              <label for="password-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_ban_page; ?></td>
            <td><select name="config_ban_page">
              <?php if (isset($config_ban_page)) { $selected = "selected"; ?>
                <option value="search" <?php if ($config_ban_page == 'search') { echo $selected; } ?>><?php echo $text_search_page; ?></option>
                <option value="block" <?php if ($config_ban_page == 'block') { echo $selected; } ?>><?php echo $text_block_page; ?></option>
              <?php } else { ?>
                <option value="search"><?php echo $text_search_page; ?></option>
                <option value="block"><?php echo $text_block_page; ?></option>
              <?php } ?>
            </select></td>
          </tr>
        </table>
        <h2><?php echo $text_upload; ?></h2>
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_file_max_size; ?></td>
            <td><?php if ($error_file_max_size) { ?>
              <input type="text" name="config_file_max_size" value="<?php echo $config_file_max_size; ?>" class="input-error" /> bytes
              <span class="error"><?php echo $error_file_max_size; ?></span>
            <?php } else { ?>
              <input type="text" name="config_file_max_size" value="<?php echo $config_file_max_size; ?>" /> bytes
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
        </table>
      </div>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#meta-description').on('load propertychange keyup input paste', function() {
		var limit = $(this).data("limit");
		var remain = limit - $(this).val().length;
		if (remain <= 0) {
			$(this).val($(this).val().substring(0, limit));
		}
		$('#remaining').text((remain <= 0) ? 0 : remain);
	});

	$('#meta-description').trigger('load');
});
//--></script>

<script type="text/javascript"><!--
$('#template').load('index.php?route=setting/setting/template&token=<?php echo $token; ?>&template=' + encodeURIComponent($('select[name=\'config_template\']').attr('value')));
//--></script>

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
		width: 760,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>

<script type="text/javascript"><!--
$('select[name=\'config_mail_protocol\']').bind('change', function() {
	$('.protocol').hide();
	$('#protocol-' + this.value).show();
});

$('select[name=\'config_mail_protocol\']').trigger('change');
//--></script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>