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
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
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
        <a href="#tab-server"><?php echo $tab_server; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_url; ?><span class="help"><?php echo $help_url; ?></span></td>
            <td><?php if ($error_url) { ?>
              <input type="text" name="config_url" value="<?php echo $config_url; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_url; ?></span>
            <?php } else { ?>
              <input type="text" name="config_url" value="<?php echo $config_url; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_ssl; ?><span class="help"><?php echo $help_ssl; ?></span></td>
            <td><input type="text" name="config_ssl" value="<?php echo $config_ssl; ?>" size="40" /></td>
          </tr>
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
            <td><select name="config_template">
            <?php foreach ($templates as $template) { ?>
              <?php if ($template['name'] == $config_template) { ?>
                <option value="<?php echo $template['name']; ?>" selected="selected"><?php echo $template['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $template['name']; ?>"><?php echo $template['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td></td>
            <td><?php foreach ($templates as $template) { ?>
              <?php echo ($template['name'] == $config_template) ? '<img src="' . $template['image'] . '" alt="" style="border:1px solid #EEE;" />' : ''; ?>
            <?php } ?></td>
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
        </table>
      </div>
      <div id="tab-checkout">
        <h2><?php echo $text_checkout; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_cart_weight; ?><span class="help"><?php echo $help_cart_weight; ?></span></td>
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
            <td><?php echo $entry_guest_checkout; ?><span class="help"><?php echo $help_guest_checkout; ?></span></td>
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
        </table>
        <h2><?php echo $text_one_page; ?></h2>
        <div class="tooltip" style="margin:5px 0px 10px 0px;"><?php echo $info_one_page; ?></div>
        <table class="form">
          <tr>
            <td><?php echo $entry_one_page_checkout; ?><span class="help"><?php echo $help_one_page_checkout; ?></span></td>
            <td><?php if ($config_one_page_checkout) { ?>
              <input type="radio" name="config_one_page_checkout" value="1" id="one-page-checkout-on" class="radio" checked />
              <label for="one-page-checkout-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_one_page_checkout" value="0" id="one-page-checkout-off" class="radio" />
              <label for="one-page-checkout-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="config_one_page_checkout" value="1" id="one-page-checkout-on" class="radio" />
              <label for="one-page-checkout-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="config_one_page_checkout" value="0" id="one-page-checkout-off" class="radio" checked />
              <label for="one-page-checkout-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?>
            <?php if ($error_multiple_checkout) { ?>
              <span class="error"><?php echo $error_multiple_checkout; ?></span>
            <?php } ?></td>
          </tr>
        </table>
        <h2><?php echo $text_express; ?></h2>
        <div class="tooltip" style="margin:5px 0px 10px 0px;"><?php echo $info_express; ?></div>
        <table class="form">
          <tr>
            <td><?php echo $entry_express_checkout; ?><span class="help"><?php echo $help_express_checkout; ?></span></td>
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
          <tr>
            <td><?php echo $entry_checkout; ?><span class="help"><?php echo $help_checkout; ?></span></td>
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
            <td><?php echo $entry_order_status; ?><span class="help"><?php echo $help_order_status; ?></span></td>
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
        </table>
      </div>
      <div id="tab-option">
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
            <td><?php echo $entry_tax_default; ?><span class="help"><?php echo $help_tax_default; ?></span></td>
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
            <td><?php echo $entry_tax_customer; ?><span class="help"><?php echo $help_tax_customer; ?></span></td>
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
        <h2><?php echo $text_account; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_customer_group; ?><span class="help"><?php echo $help_customer_group; ?></span></td>
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
            <td><?php echo $entry_customer_group_display; ?><span class="help"><?php echo $help_customer_group_display; ?></span></td>
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
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_customer_price; ?><span class="help"><?php echo $help_customer_price; ?></span></td>
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
            <td><?php echo $entry_account; ?><span class="help"><?php echo $help_account; ?></span></td>
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
        <h2><?php echo $text_stock; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_stock_display; ?><span class="help"><?php echo $help_stock_display; ?></span></td>
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
            <td><?php echo $entry_stock_checkout; ?><span class="help"><?php echo $help_stock_checkout; ?></span></td>
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
        </table>
        <h2><?php echo $text_supplier; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_supplier_group; ?><span class="help"><?php echo $help_supplier_group; ?></span></td>
            <td><select name="config_supplier_group_id">
            <?php foreach ($supplier_groups as $supplier_group) { ?>
              <?php if ($supplier_group['supplier_group_id'] == $config_supplier_group_id) { ?>
                <option value="<?php echo $supplier_group['supplier_group_id']; ?>" selected="selected"><?php echo $supplier_group['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $supplier_group['supplier_group_id']; ?>"><?php echo $supplier_group['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
        </table>
      </div>
      <div id="tab-preference">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_catalog_limit; ?><span class="help"><?php echo $help_catalog_limit; ?></span></td>
            <td><?php if ($error_catalog_limit) { ?>
              <input type="text" name="config_catalog_limit" value="<?php echo $config_catalog_limit; ?>" size="3" class="input-error" />
              <span class="error"><?php echo $error_catalog_limit; ?></span>
            <?php } else { ?>
              <input type="text" name="config_catalog_limit" value="<?php echo $config_catalog_limit; ?>" size="3" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_lightbox; ?><span class="help"><?php echo $help_lightbox; ?></span></td>
            <td><select name="config_lightbox">
              <?php if (isset($config_lightbox)) { $selected = "selected"; ?>
                <option value="colorbox" <?php if ($config_lightbox == 'colorbox') { echo $selected; } ?>><?php echo $text_colorbox; ?> <?php echo $text_default; ?></option>
                <option value="fancybox" <?php if ($config_lightbox == 'fancybox') { echo $selected; } ?>><?php echo $text_fancybox; ?></option>
                <option value="magnific" <?php if ($config_lightbox == 'magnific') { echo $selected; } ?>><?php echo $text_magnific; ?></option>
                <option value="swipebox" <?php if ($config_lightbox == 'swipebox') { echo $selected; } ?>><?php echo $text_swipebox; ?></option>
                <option value="zoomlens" <?php if ($config_lightbox == 'zoomlens') { echo $selected; } ?>><?php echo $text_zoomlens; ?></option>
              <?php } else { ?>
                <option value="colorbox"><?php echo $text_colorbox; ?> <?php echo $text_default; ?></option>
                <option value="fancybox"><?php echo $text_fancybox; ?></option>
                <option value="magnific"><?php echo $text_magnific; ?></option>
                <option value="swipebox"><?php echo $text_swipebox; ?></option>
                <option value="zoomlens"><?php echo $text_zoomlens; ?></option>
              <?php } ?>
            </select></td>
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
            <td><?php echo $entry_icon; ?><span class="help"><?php echo $help_icon; ?></span></td>
            <td><div class="image"><img src="<?php echo $icon; ?>" alt="" id="thumb-icon" /><br />
              <input type="hidden" name="config_icon" value="<?php echo $config_icon; ?>" id="icon" />
              <a onclick="image_upload('icon', 'thumb-icon');" class="button-browse"></a><a onclick="$('#thumb-icon').attr('src', '<?php echo $no_image; ?>'); $('#icon').attr('value', '');" class="button-recycle"></a>
            </div></td>
          </tr>
        </table>
        <h2><?php echo $text_image_resize; ?></h2>
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_image_category; ?><span class="help"><?php echo $help_image_category; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_thumb; ?><span class="help"><?php echo $help_image_thumb; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_popup; ?><span class="help"><?php echo $help_image_popup; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_product; ?><span class="help"><?php echo $help_image_product; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_additional; ?><span class="help"><?php echo $help_image_additional; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_brand; ?><span class="help"><?php echo $help_image_brand; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_related; ?><span class="help"><?php echo $help_image_related; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_compare; ?><span class="help"><?php echo $help_image_compare; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_wishlist; ?><span class="help"><?php echo $help_image_wishlist; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_newsthumb; ?><span class="help"><?php echo $help_image_newsthumb; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_newspopup; ?><span class="help"><?php echo $help_image_newspopup; ?></span></td>
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
            <td><span class="required">*</span> <?php echo $entry_image_cart; ?><span class="help"><?php echo $help_image_cart; ?></span></td>
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
      <div id="tab-server">
        <table class="form">
          <tr>
            <td><?php echo $entry_secure; ?><span class="help"><?php echo $help_secure; ?></span></td>
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
$('select[name=\'config_country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=localisation/country/country&token=<?php echo $token; ?>&country_id=' + this.value,
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

			if (json['zone'] && json['zone'] != '') {
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
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>