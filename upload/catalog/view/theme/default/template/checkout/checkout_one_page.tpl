<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div style="float:right;">
    <a href="<?php echo $one_page_cart; ?>" title="<?php echo $text_cart; ?>" style="margin-left:25px;"><img src="catalog/view/theme/<?php echo $template; ?>/image/cart.png" alt="<?php echo $text_cart; ?>" /></a>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if (!isset($this->session->data['order_id'])) { ?>
  <?php if ($wrapping_status || $this->config->get('config_one_page_coupon') || $this->config->get('config_one_page_voucher') || $reward_point) { ?>
    <div style="margin-bottom:15px;">
      <?php if ($wrapping_status) { ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <?php if (isset($this->session->data['wrapping'])) { ?>
            <input type="submit" name="remove_wrapping" value="<?php echo $button_wrapping_remove; ?>" class="button-wrap-remove" />
          <?php } else { ?>
            <input type="submit" name="add_wrapping" value="<?php echo $button_wrapping_add; ?>" class="button-wrap-add" />
          <?php } ?>
        </form>
      <?php } ?>
      <?php if ($this->config->get('config_one_page_coupon')) { ?>
        <a onclick="$('#coupon').show(500);$('#voucher').hide();$('#reward').hide();" class="button"><?php echo $text_one_page_coupon; ?></a>
      <?php } ?>
      <?php if ($this->config->get('config_one_page_voucher')) { ?>
        <a onclick="$('#voucher').show(500);$('#coupon').hide();$('#reward').hide();" class="button"><?php echo $text_one_page_voucher; ?></a>
      <?php } ?>
      <?php if ($show_point && $reward_point) { ?>
        <a onclick="$('#reward').show(500);$('#voucher').hide();$('#coupon').hide();" class="button"><?php echo $text_one_page_reward; ?></a>
      <?php } ?>
      <div id="coupon" class="content" style="margin-top:10px; margin-bottom:20px; display:none;">
        <img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" onclick="dismiss1('coupon');" class="close" />
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <?php echo $entry_coupon; ?>&nbsp;
          <input type="text" name="coupon" value="<?php echo $coupon; ?>" />
          <input type="hidden" name="next" value="coupon" />
          &nbsp;
          <input type="submit" value="<?php echo $button_coupon; ?>" class="button" />
        </form>
      </div>
      <div id="voucher" class="content" style="margin-top:10px; margin-bottom:20px; display:none;">
        <img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" onclick="dismiss2('voucher');" class="close" />
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <?php echo $entry_voucher; ?>&nbsp;
          <input type="text" name="voucher" value="<?php echo $voucher; ?>" />
          <input type="hidden" name="next" value="voucher" />
          &nbsp;
          <input type="submit" value="<?php echo $button_voucher; ?>" class="button" />
        </form>
      </div>
      <div id="reward" class="content" style="margin-top:10px; margin-bottom:20px; display:none;">
        <img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" onclick="dismiss3('reward');" class="close" />
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <?php echo $entry_reward; ?>&nbsp;
          <input type="text" name="reward" value="<?php echo $reward; ?>" />
          <input type="hidden" name="next" value="reward" />
          &nbsp;
          <input type="submit" value="<?php echo $button_reward; ?>" class="button" />
        </form>
      </div>
    </div>
  <?php } ?>
  <?php if (!empty($attention)) { ?>
    <div class="attention"><?php echo $attention; ?><img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>
  <?php } ?>
  <?php if (!empty($success)) { ?>
    <div class="success"><?php echo $success; ?><img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>
  <?php } ?>
  <?php if (!empty($error_warning)) { ?>
    <div class="warning"><?php echo $error_warning; ?><img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>
  <?php } ?>
  <?php } ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <div class="checkout-one-page">
      <div class="checkout-page-left">
        <table class="address-options">
          <tr>
            <td colspan="2"><h2><?php echo $text_checkout_payment_address; ?></h2></td>
          </tr>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <tr>
            <td colspan="2"><?php echo $entry_firstname; ?>: <b><?php echo $firstname; ?></b>
              <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
            </td>
          </tr>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="firstname" class="hidden">firstname</label>
              <input type="text" name="firstname" id="firstname" placeholder="<?php echo $entry_firstname; ?>" value="<?php echo $firstname; ?>" size="26" /> <span class="required">*</span>
            </td>
          </tr>
          <?php if ($error_firstname) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_firstname; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <tr>
            <td colspan="2"><?php echo $entry_lastname; ?>: <b><?php echo $lastname; ?></b>
              <input type="hidden" name="lastname" value="<?php echo $lastname; ?>" />
            </td>
          </tr>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="lastname" class="hidden">lastname</label>
              <input type="text" name="lastname" id="lastname" placeholder="<?php echo $entry_lastname; ?>" value="<?php echo $lastname; ?>" size="26" /> <span class="required">*</span>
            </td>
          </tr>
          <?php if ($error_lastname) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_lastname; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <tr>
            <td colspan="2"><?php echo $entry_email; ?>: <b><?php echo $email; ?></b>
              <input type="hidden" name="email" value="<?php echo $email; ?>" />
            </td>
          </tr>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="email" class="hidden">email</label>
              <input type="text" name="email" id="email" placeholder="<?php echo $entry_email; ?>" value="<?php echo $email; ?>" size="26" /> <span class="required">*</span>
            </td>
          </tr>
          <?php if ($error_email) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_email; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if ($one_page_phone) { ?>
          <?php if (isset($this->session->data['order_id'])) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_telephone; ?>: <b><?php echo $telephone; ?></b>
                <input type="hidden" name="telephone" value="<?php echo $telephone; ?>" />
              </td>
            </tr>
          <?php } else { ?>
            <tr>
              <td colspan="2"><label for="telephone" class="hidden">telephone</label>
                <input type="text" name="telephone" id="telephone" placeholder="<?php echo $entry_telephone; ?>" value="<?php echo $telephone; ?>" size="26" /> <span class="required">*</span>
              </td>
            </tr>
            <?php if ($error_telephone) { ?>
              <tr>
                <td colspan="2"><div class="error"><?php echo $error_telephone; ?></div></td>
              </tr>
            <?php } ?>
          <?php } ?>
        <?php } ?>
        <?php if ($one_page_fax) { ?>
          <?php if (isset($this->session->data['order_id'])) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_fax; ?>: <b><?php echo $fax; ?></b>
                <input type="hidden" name="fax" value="<?php echo $fax; ?>" />
              </td>
            </tr>
          <?php } else { ?>
            <tr>
              <td colspan="2"><label for="fax" class="hidden">fax</label>
                <input type="text" name="fax" id="fax" placeholder="<?php echo $entry_fax; ?>" value="<?php echo $fax; ?>" size="26" />
              </td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if ($one_page_gender) { ?>
          <?php if (isset($this->session->data['order_id'])) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_gender; ?>: <b><?php echo ($gender == 0) ? $text_male : $text_female; ?></b>
                <input type="hidden" name="gender" value="<?php echo $gender; ?>" />
              </td>
            </tr>
          <?php } else { ?>
            <tr>
              <td colspan="2"><?php if ($gender == 0) { ?>
                <input type="radio" name="gender" value="0" checked="checked" /><?php echo $text_male; ?>&nbsp;&nbsp;
                <input type="radio" name="gender" value="1" /><?php echo $text_female; ?>
              <?php } else { ?>
                <input type="radio" name="gender" value="0" /><?php echo $text_male; ?>&nbsp;&nbsp;
                <input type="radio" name="gender" value="1" checked="checked" /><?php echo $text_female; ?>
              <?php } ?></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if ($one_page_dob) { ?>
          <?php if (isset($this->session->data['order_id'])) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_date_of_birth; ?>: <b><?php echo $date_of_birth; ?></b>
                <input type="hidden" name="date_of_birth" value="<?php echo $date_of_birth; ?>" />
              </td>
            </tr>
          <?php } else { ?>
            <tr>
              <td colspan="2"><label for="date-of-birth" class="hidden">date of birth</label>
                <input type="text" name="date_of_birth" id="date-of-birth" placeholder="<?php echo $entry_date_of_birth; ?>" value="<?php echo $date_of_birth; ?>" size="26" /> <span class="required">*</span>
              </td>
            </tr>
            <?php if ($error_date_of_birth) { ?>
              <tr>
                <td colspan="2"><div class="error"><?php echo $error_date_of_birth; ?></div></td>
              </tr>
            <?php } ?>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($company) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_company; ?>: <b><?php echo $company; ?></b>
                <input type="hidden" name="company" value="<?php echo $company; ?>" />
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="company" class="hidden">company</label>
              <input type="text" name="company" id="company" placeholder="<?php echo $entry_company; ?>" value="<?php echo $company; ?>" size="26" />
            </td>
          </tr>
        <?php } ?>
          <tr>
            <td colspan="2"><div style="display:<?php echo (count($customer_groups) > 1 ? 'table-row' : 'none'); ?>;"> <?php echo $entry_customer_group; ?><br />
              <?php foreach ($customer_groups as $customer_group) { ?>
                <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
                  <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer-group-id<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                  <label for="customer-group-id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
                  <br />
                <?php } else { ?>
                  <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer-group-id<?php echo $customer_group['customer_group_id']; ?>" />
                  <label for="customer-group-id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
                  <br />
                <?php } ?>
              <?php } ?>
            </div></td>
          </tr>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($company_id) { ?>
            <tr id="company-id-display">
              <td colspan="2"><?php echo $entry_company_id; ?>: <b><?php echo $company_id; ?></b>
                <input type="hidden" name="company_id" value="<?php echo $company_id; ?>" />
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr id="company-id-display">
            <td colspan="2"><label for="company-id" class="hidden">company id</label>
              <input type="text" name="company_id" id="company-id" placeholder="<?php echo $entry_company_id; ?>" value="<?php echo $company_id; ?>" size="26" />
            </td>
          </tr>
          <?php if ($error_company_id) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_company_id; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <tr id="tax-id-display">
            <td colspan="2"><?php echo $entry_tax_id; ?>: <b><?php echo $tax_id; ?></b>
              <input type="hidden" name="tax_id" value="<?php echo $tax_id; ?>" />
            </td>
          </tr>
        <?php } else { ?>
          <tr id="tax-id-display">
            <td colspan="2"><label for="tax-id" class="hidden">tax id</label>
              <input type="text" name="tax_id" id="tax-id" placeholder="<?php echo $entry_tax_id; ?>" value="<?php echo $tax_id; ?>" size="26" />
            </td>
          </tr>
          <?php if ($error_tax_id) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_tax_id; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <tr>
            <td colspan="2"><?php echo $entry_address_1; ?>: <b><?php echo $address_1; ?></b>
              <input type="hidden" name="address_1" value="<?php echo $address_1; ?>" />
            </td>
          </tr>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="address-1" class="hidden">address 1</label>
              <input type="text" name="address_1" id="address-1" placeholder="<?php echo $entry_address_1; ?>" value="<?php echo $address_1; ?>" size="26" /> <span class="required">*</span>
            </td>
          </tr>
          <?php if ($error_address_1) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_address_1; ?></div></td>
            </tr>
          <?php }?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($address_2) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_address_2; ?>: <b><?php echo $address_2; ?></b>
                <input type="hidden" name="address_2" value="<?php echo $address_2; ?>" />
              </td>
            </tr>
          <?php }?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="address-2" class="hidden">address 2</label>
              <input type="text" name="address_2" id="address-2" placeholder="<?php echo $entry_address_2; ?>" value="<?php echo $address_2; ?>" size="26" />
            </td>
          </tr>
          <?php if ($error_address_1) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_address_1; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <tr>
            <td colspan="2"><?php echo $entry_city; ?>: <b><?php echo $city; ?></b>
              <input type="hidden" name="city" value="<?php echo $city; ?>" />
            </td>
          </tr>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="city" class="hidden">city</label>
              <input type="text" name="city" id="city" placeholder="<?php echo $entry_city; ?>" value="<?php echo $city; ?>" size="26" /> <span class="required">*</span>
            </td>
          </tr>
          <?php if ($error_city) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_city; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($postcode) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_postcode; ?>: <b><?php echo $postcode; ?></b>
                <input type="hidden" name="postcode" value="<?php echo $postcode; ?>" />
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="postcode" class="hidden">postcode</label>
              <input type="text" name="postcode" id="postcode" placeholder="<?php echo $entry_postcode; ?>" value="<?php echo $postcode; ?>" size="26" /> <span id="payment-postcode-required" class="required">*</span>
            </td>
          </tr>
          <?php if ($error_postcode) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_postcode; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <tr>
            <td colspan="2"><?php echo $entry_country; ?>: <b><?php echo $country_name; ?></b>
              <input type="hidden" name="country_id" value="<?php echo $country_id; ?>" />
            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo $entry_zone; ?>: <b><?php echo $zone_name; ?></b>
              <input type="hidden" name="zone_id" value="<?php echo $zone_id; ?>" />
            </td>
          </tr>
        <?php } else { ?>
          <tr>
            <td colspan="2"><select name="country_id">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $country_id) { ?>
                  <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo (strlen($country['name']) > 24) ? substr(strip_tags(html_entity_decode($country['name'], ENT_QUOTES, 'UTF-8')), 0, 22) . '..' : html_entity_decode($country['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php } else { ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo (strlen($country['name']) > 24) ? substr(strip_tags(html_entity_decode($country['name'], ENT_QUOTES, 'UTF-8')), 0, 22) . '..' : html_entity_decode($country['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <?php if ($error_country) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_country; ?></div></td>
            </tr>
          <?php } ?>
          <tr>
            <td colspan="2"><select name="zone_id"></select> <span class="required">*</span></td>
          </tr>
          <?php if ($error_zone) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_zone; ?></div></td>
            </tr>
          <?php }?>
        <?php }?>
        </table>
        <?php if (!isset($this->session->data['order_id'])) { ?>
          <div class="address-checkbox">
          <?php if ($check_shipping_address == 1) { ?>
            <input type="checkbox" name="check_shipping_address" value="1" checked="checked" /> <?php echo $entry_shipping; ?>
          <?php } else { ?>
            <input type="checkbox" name="check_shipping_address" value="1" /> <?php echo $entry_shipping; ?>
          <?php } ?>
          </div>
        <?php } else { ?>
          <div class="address-checkbox">
          <?php if ($check_shipping_address == 1) { ?>
            <h2><?php echo $entry_shipping; ?></h2>
          <?php } ?>
          </div>
        <?php } ?>
        <table class="address-options" id="shipping-address-display">
        <?php if ((!isset($this->session->data['order_id']) && $check_shipping_address == 1) || $check_shipping_address == 0) { ?>
          <tr>
            <td colspan="2"><h2><?php echo $text_checkout_shipping_address; ?></h2></td>
          </tr>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($check_shipping_address == 0) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_firstname; ?>: <b><?php echo $shipping_firstname; ?></b>
                <input type="hidden" name="shipping_firstname" value="<?php echo $shipping_firstname; ?>" />
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="shipping-firstname" class="hidden">shipping firstname</label>
              <input type="text" name="shipping_firstname" id="shipping-firstname" placeholder="<?php echo $entry_firstname; ?>" value="<?php echo $shipping_firstname; ?>" size="26" /> <span class="required">*</span>
            </td>
          </tr>
          <?php if ($error_shipping_firstname) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_shipping_firstname; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($check_shipping_address == 0) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_lastname; ?>: <b><?php echo $shipping_lastname; ?></b>
                <input type="hidden" name="shipping_lastname" value="<?php echo $shipping_lastname; ?>" />
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="shipping-lastname" class="hidden">shipping lastname</label>
              <input type="text" name="shipping_lastname" id="shipping-lastname" placeholder="<?php echo $entry_lastname; ?>" value="<?php echo $shipping_lastname; ?>" size="26" /> <span class="required">*</span>
            </td>
          </tr>
          <?php if ($error_shipping_lastname) { ?>
            <tr>
              <td valign="top" align="left" colspan="2"><div class="error"><?php echo $error_shipping_lastname; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($check_shipping_address == 0) { ?>
            <?php if ($shipping_company) { ?>
              <tr>
                <td colspan="2"><?php echo $entry_company; ?>: <b><?php echo $shipping_company; ?></b>
                  <input type="hidden" name="shipping_company" value="<?php echo $shipping_company; ?>" />
                </td>
              </tr>
            <?php } ?>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="shipping-company" class="hidden">shipping company</label>
              <input type="text" name="shipping_company" id="shipping-company" placeholder="<?php echo $entry_company; ?>" value="<?php echo $shipping_company; ?>" size="26" />
            </td>
          </tr>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($check_shipping_address == 0) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_address_1; ?>: <b><?php echo $shipping_address_1; ?></b>
                <input type="hidden" name="shipping_address_1" value="<?php echo $shipping_address_1; ?>" />
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="shipping-address-1" class="hidden">shipping address 1</label>
              <input type="text" name="shipping_address_1" id="shipping-address-1" placeholder="<?php echo $entry_address_1; ?>" value="<?php echo $shipping_address_1; ?>" size="26" /> <span class="required">*</span>
            </td>
          </tr>
          <?php if ($error_shipping_address_1) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_shipping_address_1; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($check_shipping_address == 0) { ?>
            <?php if ($shipping_address_2) { ?>
              <tr>
                <td colspan="2"><?php echo $entry_address_2; ?>: <b><?php echo $shipping_address_2; ?></b>
                  <input type="hidden" name="shipping_address_2" value="<?php echo $shipping_address_2; ?>" />
                </td>
              </tr>
            <?php } ?>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="shipping-address-2" class="hidden">shipping address 2</label>
              <input type="text" name="shipping_address_2" id="shipping-address-2" placeholder="<?php echo $entry_address_2; ?>" value="<?php echo $shipping_address_2; ?>" size="26" />
            </td>
          </tr>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($check_shipping_address == 0) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_city; ?>: <b><?php echo $shipping_city; ?></b>
                <input type="hidden" name="shipping_city" value="<?php echo $shipping_city; ?>" />
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="shipping-city" class="hidden">shipping city</label>
              <input type="text" name="shipping_city" id="shipping-city" placeholder="<?php echo $entry_city; ?>" value="<?php echo $shipping_city; ?>" size="26" /> <span class="required">*</span>
            </td>
          </tr>
          <?php if ($error_shipping_city) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_shipping_city; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($check_shipping_address == 0) { ?>
            <?php if ($shipping_postcode) { ?>
              <tr>
                <td colspan="2"><?php echo $entry_postcode; ?>: <b><?php echo $shipping_postcode; ?></b>
                  <input type="hidden" name="shipping_postcode" value="<?php echo $shipping_postcode; ?>" />
                </td>
              </tr>
            <?php } ?>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><label for="shipping-postcode" class="hidden">shipping postcode</label>
              <input type="text" name="shipping_postcode" id="shipping-postcode" placeholder="<?php echo $entry_postcode; ?>" value="<?php echo $shipping_postcode; ?>" size="26" /> <span id="payment-postcode-required" class="required">*</span>
            </td>
          </tr>
          <?php if ($error_shipping_postcode) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_shipping_postcode; ?></div></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php if (isset($this->session->data['order_id'])) { ?>
          <?php if ($check_shipping_address == 0) { ?>
            <tr>
              <td colspan="2"><?php echo $entry_country; ?>: <b><?php echo $shipping_country_name; ?></b>
                <input type="hidden" name="shipping_country_id" value="<?php echo $shipping_country_id; ?>" />
              </td>
            </tr>
            <tr>
              <td colspan="2"><?php echo $entry_zone; ?>: <b><?php echo $shipping_zone_name; ?></b>
                <input type="hidden" name="shipping_zone_id" value="<?php echo $shipping_zone_id; ?>" />
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="2"><select name="shipping_country_id">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $shipping_country_id) { ?>
                  <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo (strlen($country['name']) > 24) ? substr(strip_tags(html_entity_decode($country['name'], ENT_QUOTES, 'UTF-8')), 0, 22) . '..' : html_entity_decode($country['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php } else { ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo (strlen($country['name']) > 24) ? substr(strip_tags(html_entity_decode($country['name'], ENT_QUOTES, 'UTF-8')), 0, 22) . '..' : html_entity_decode($country['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <?php if ($error_shipping_country) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_shipping_country; ?></div><br /></td>
            </tr>
          <?php } ?>
          <tr>
            <td colspan="2"><select name="shipping_zone_id"></select> <span class="required">*</span></td>
          </tr>
          <?php if ($error_shipping_zone) { ?>
            <tr>
              <td colspan="2"><div class="error"><?php echo $error_shipping_zone; ?></div><br /></td>
            </tr>
          <?php } ?>
        <?php } ?>
        </table>
		<div class="address-checkbox"></div>
      </div>
      <div class="spacer"></div>
      <div class="checkout-page-right">
        <table class="order-options">
          <tr>
            <td><h2><?php echo $text_shipping_method; ?></h2></td>
            <td class="spacer"></td>
            <td><h2><?php echo $text_payment_method; ?></h2></td>
          </tr>
          <tr>
            <td id="shipping-method">
            <?php if (isset($this->session->data['order_id'])) { ?>
              <?php echo $this->session->data['shipping_method']['title']; ?> [ <b><?php echo $this->session->data['shipping_method']['text']; ?></b> ]<br /><br />
              <input type="hidden" name="shipping_method" value="<?php echo $shipping_method_code; ?>" />
            <?php } else { ?>
              <a onclick="refresh();" id="shipping-refresh" class="button" style="margin:0 5px 5px 5px;"><i class="fa fa-refresh"></i></a>
              <?php if ($shipping_methods) { ?>
                <?php if ($error_shipping_method) { ?>
                  <div class="attention" style="margin:5px 0;"><?php echo $error_shipping_method; ?></div>
                <?php } ?>
                <table id="shipping-lock" class="radio" style="margin-bottom:2px;">
                <?php foreach ($shipping_methods as $shipping_method) { ?>
                  <?php if (!$shipping_method['error']) { ?>
                    <?php foreach ($shipping_method['quote'] as $quote) { ?>
                    <tr class="highlight">
                      <td><?php if ($quote['code'] == $shipping_method_code) { ?>
                        <?php $code = $quote['code']; ?>
                        <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" checked="checked" />
                      <?php } else { ?>
                        <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" />
                      <?php } ?></td>
                      <td><label for="<?php echo $quote['code']; ?>"><?php echo $quote['title']; ?></label></td>
                      <td style="text-align:right;"><label for="<?php echo $quote['code']; ?>"><?php echo $quote['text']; ?></label></td>
                    </tr>
                    <?php } ?>
                  <?php } else { ?>
                    <tr>
                      <td colspan="3"><div class="error"><?php echo $shipping_method['error']; ?></div></td>
                    </tr>
                  <?php } ?>
                <?php } ?>
                </table>
              <?php } ?>
            <?php } ?>
            </td>
            <td class="spacer"></td>
            <td id="payment-method">
            <?php if (isset($this->session->data['order_id'])) { ?>
              <?php echo $this->session->data['payment_method']['title']; ?><br /><br />
                <input type="hidden" name="payment_method" value="<?php echo $payment_method_code; ?>" />
              <?php } else { ?>
                <?php if ($payment_methods) { ?>
                  <?php if ($error_payment_method) { ?>
                    <div class="attention" style="margin:5px 0;"><?php echo $error_payment_method; ?></div>
                  <?php } ?>
                  <table id="payment-lock" class="radio" style="margin-bottom:2px;">
                  <?php foreach ($payment_methods as $payment_method) { ?>
                    <?php $apply_paypal_fee = ((substr($payment_method['code'], 0, 3) == "pp_") || ($payment_method['code'] == "paypal_email")) ? true : false; ?>
                    <tr class="highlight">
                      <td><?php if ($payment_method['code'] == $payment_method_code) { ?>
                        <?php $code = $payment_method['code']; ?>
                        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" checked="checked" />
                      <?php } else { ?>
                        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" />
                      <?php } ?></td>
                      <td><?php if ($payment_images) { ?>
                        <?php foreach ($payment_images as $payment_image) { ?>
                          <?php if ($payment_image['payment'] == strtolower($payment_method['code'])) { ?>
                            <?php if ($payment_image['status']) { ?>
                              <label for="<?php echo $payment_method['code']; ?>"><img src="<?php echo $payment_image['image']; ?>" title="<?php echo $payment_method['title']; ?>" alt="<?php echo $payment_method['title']; ?>" />
                              <?php if ($paypal_fee && $apply_paypal_fee) { ?>
                                <span> + <?php echo $paypal_fee; ?></span>
                              <?php } ?>
                              </label>
                            <?php } else { ?>
                              <label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?>
                                <?php if ($paypal_fee) { ?>
                                  <span> + <?php echo $paypal_fee; ?></span>
                                <?php } ?>
                              </label>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>
                      <?php } else { ?>
                        <label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?>
                          <?php if ($paypal_fee) { ?>
                            <span> + <?php echo $paypal_fee; ?></span>
                          <?php } ?>
                        </label>
                      <?php } ?></td>
                    </tr>
                  <?php } ?>
                  </table>
                <?php } ?>
              <?php } ?>
              </td>
            </tr>
          </table>
          <div class="division"></div>
          <div id="checkout-one-cart"></div>
          <div style="margin-bottom:10px;">
          <?php if (!isset($this->session->data['order_id'])) { ?>
            <h2><?php echo $text_comments; ?></h2>
            <textarea name="comment" rows="4" style="width:100%;"><?php echo $comment; ?></textarea>
          <?php } else { ?>
            <?php if ($comment) { ?>
              <h2><?php echo $text_comments; ?></h2>
              <?php echo $comment; ?><br /><br />
            <?php } ?>
          <?php } ?>
          </div>
          <div>
          <?php if ($error_agree) { ?>
            <div class="attention" style="margin:5px 0;"><?php echo $error_agree; ?></div>
          <?php } ?>
          <?php if (!isset($this->session->data['order_id'])) { ?>
            <?php if ($text_agree) { ?>
              <div class="buttons">
                <div class="right"><?php echo $text_agree; ?>
                <?php if ($agree) { ?>
                  <input type="checkbox" name="agree" value="1" checked="checked" />
                <?php } else { ?>
                  <input type="checkbox" name="agree" value="1" />
                <?php } ?>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
          <?php if (!isset($this->session->data['order_id'])) { ?>
            <input type="submit" value="<?php echo $button_continue; ?>" id="button-order" class="button" style="float:right; margin-bottom:10px;" />
          <?php } ?>
          </div>
        </div>
      </div>
    </form>
    <div style="clear:both;">
    <?php if (isset($this->session->data['order_id'])) { ?>
      <div id="checkout-submit" class="payment"></div>
    <?php } ?>
    </div>
    <?php echo $content_bottom; ?>
  </div>
<?php echo $content_footer; ?>

<script type="text/javascript"><!--
var check_shipping_address = $('input[name=\'check_shipping_address\']').attr('checked');

if (check_shipping_address == 'checked') {
	$('#shipping-address-display').hide();
} else {
	$('#shipping-address-display').show();
}

$('input[name=\'check_shipping_address\']').on('click', function() {
	if ($(this).is(":checked")) {
		$('#shipping-address-display').hide();
	} else {
		$('#shipping-address-display').show();
	}
});
//--></script> 

<script type="text/javascript"><!--
$('input[name=\'customer_group_id\']:checked').on('change', function() {
	var customer_group = [];

<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group["company_id_display"]; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group["company_id_required"]; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group["tax_id_display"]; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group["tax_id_required"]; ?>';
<?php } ?>

	if (customer_group[this.value]) {
		if (customer_group[this.value]['company_id_display'] == '1') {
			$('#company-id-display').show();
		} else {
			$('#company-id-display').hide();
		}

		if (customer_group[this.value]['company_id_required'] == '1') {
			$('#company-id-required').show();
		} else {
			$('#company-id-required').hide();
		}

		if (customer_group[this.value]['tax_id_display'] == '1') {
			$('#tax-id-display').show();
		} else {
			$('#tax-id-display').hide();
		}

		if (customer_group[this.value]['tax_id_required'] == '1') {
			$('#tax-id-required').show();
		} else {
			$('#tax-id-required').hide();
		}
	}
});

$('input[name=\'customer_group_id\']:checked').trigger('change');
//--></script>

<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
	if (this.value == '') {
		return;
	}

	$.ajax({
		url: 'index.php?route=checkout/checkout_one_page/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('.attention, .error').remove();
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#payment-postcode-required').show();
			} else {
				$('#payment-postcode-required').hide();
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
						html += ' selected="selected"';
					}

					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');

$('select[name=\'country_id\']').on('change', function() {
	if ($(this).val() != <?php echo $country_id; ?>) {
		$('#shipping-refresh').fadeIn(500);

		$('#shipping-lock').hide();
		$('#payment-lock').hide();
	} else {
		$('#shipping-refresh').hide();

		$('#shipping-lock').show();
		$('#payment-lock').show();
	}
});

$('select[name=\'country_id\']').trigger('change');
//--></script>

<script type="text/javascript"><!--
$('select[name=\'shipping_country_id\']').on('change', function() {
	if (this.value == '') {
		return;
	}

	$.ajax({
		url: 'index.php?route=checkout/checkout_one_page/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('.attention, .error').remove();
			$('select[name=\'shipping_country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#payment-postcode-required').show();
			} else {
				$('#payment-postcode-required').hide();
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
						html += ' selected="selected"';
					}

					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('select[name=\'shipping_zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'shipping_country_id\']').trigger('change');

$('select[name=\'shipping_country_id\']').on('change', function() {
	if ($(this).val() != <?php echo $shipping_country_id; ?>) {
		$('#shipping-refresh').fadeIn(500);

		$('#shipping-lock').hide();
		$('#payment-lock').hide();
	} else {
		$('#shipping-refresh').hide();

		$('#shipping-lock').show();
		$('#payment-lock').show();
	}
});

$('select[name=\'shipping_country_id\']').trigger('change');
//--></script>

<script type="text/javascript"><!--
function refresh() {
	$('.attention, .error, .wait').remove();
	$('#form').append('<input type="hidden" id="refresh" name="refresh" value="1" />');
	$('#form').submit();
}
//--></script>

<script type="text/javascript"><!--
$('#checkout-one-cart').load('index.php?route=checkout/checkout_one_cart');

$('body').on('change', 'input[name=\'shipping_method\']:checked', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout_one_page/shippingMethod',
		type: 'post',
		data: 'shipping_method=' + $('input[name=\'shipping_method\']:checked').attr('value'),
		dataType: 'json',
		success: function(json) {
			if (json['code']) {
				$('#checkout-one-cart').load('index.php?route=checkout/checkout_one_cart');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('body').on('change', 'input[name=\'payment_method\']:checked', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout_one_page/paymentMethod',
		type: 'post',
		data: 'payment_method=' + $('input[name=\'payment_method\']:checked').attr('value'),
		dataType: 'json',
		success: function(json) {
			if (json['code']) {
				$('#checkout-one-cart').load('index.php?route=checkout/checkout_one_cart');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script> 

<?php if (isset($this->session->data['order_id'])) { ?>
<script type="text/javascript"><!--
$('#checkout-one-cart').load('index.php?route=checkout/checkout_one_cart');

$.ajax({
	url: 'index.php?route=checkout/checkout_one_page/checkoutSubmit',
	type: 'post',
	data: '',
	dataType: 'json',
	beforeSend: function() {
		$('.attention, .error').remove();
		$('#checkout-submit').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		$('#checkout-submit').attr('disabled', true);
	},
	complete: function() {
		$('#checkout-submit').attr('disabled', false);
		$('.wait').remove();
	},
	success: function(json) {
		$('#checkout-submit').html(json['payment']);
	},
	error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	}
});
//--></script>
<?php } ?>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-of-birth').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.3,
		width: 600,
		height: 480
	});
});
//--></script>

<script type="text/javascript"><!--
function dismiss1(coupon) {
	document.getElementById('coupon').style.display="none";
}
function dismiss2(voucher) {
	document.getElementById('voucher').style.display="none";
}
function dismiss3(reward) {
	document.getElementById('reward').style.display="none";
}
//--></script>

<?php echo $footer; ?>