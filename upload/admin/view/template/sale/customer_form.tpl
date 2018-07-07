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
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $customer_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <div id="htabs" class="htabs">
      <a href="#tab-general"><?php echo $tab_general; ?></a>
      <?php if ($customer_id) { ?>
        <a href="#tab-history"><?php echo $tab_history; ?></a>
        <a href="#tab-purchase"><?php echo $tab_purchase; ?></a>
        <a href="#tab-transaction"><?php echo $tab_transaction; ?></a>
        <a href="#tab-reward"><?php echo $tab_reward; ?></a>
      <?php } ?>
      <a href="#tab-ip"><?php echo $tab_ip; ?></a>
    </div>
  <?php if ($customer_deleted) { ?>
    <div class="attention"><?php echo $customer_warning; ?></div>
  <?php } ?>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
        <div id="vtabs" class="vtabs"><a href="#tab-customer"><?php echo $tab_general; ?></a>
          <?php $address_row = 1; ?>
          <?php foreach ($addresses as $address) { ?>
            <a href="#tab-address-<?php echo $address_row; ?>" id="address-<?php echo $address_row; ?>"><?php echo $tab_address . ' ' . $address_row; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('#vtabs a:first').trigger('click'); $('#address-<?php echo $address_row; ?>').remove(); $('#tab-address-<?php echo $address_row; ?>').remove(); return false;" /></a>
            <?php $address_row++; ?>
          <?php } ?>
          <span id="address-add"><?php echo $button_add_address; ?>&nbsp;<img src="view/image/add.png" alt="" onclick="addAddress();" /></span></div>
          <div id="tab-customer" class="vtabs-content">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
              <td><?php if ($error_firstname) { ?>
                <input type="text" name="firstname" value="<?php echo $firstname; ?>" size="30" class="input-error" />
                <span class="error"><?php echo $error_firstname; ?></span>
              <?php } else { ?>
                <input type="text" name="firstname" value="<?php echo $firstname; ?>" size="30" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
              <td><?php if ($error_lastname) { ?>
                <input type="text" name="lastname" value="<?php echo $lastname; ?>" size="30" class="input-error" />
                <span class="error"><?php echo $error_lastname; ?></span>
              <?php } else { ?>
                <input type="text" name="lastname" value="<?php echo $lastname; ?>" size="30" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_email; ?></td>
              <td><?php if ($error_email) { ?>
                <input type="text" name="email" value="<?php echo $email; ?>" size="40" class="input-error" />
                <span class="error"><?php echo $error_email; ?></span>
              <?php } else { ?>
                <input type="text" name="email" value="<?php echo $email; ?>" size="40" />
              <?php  } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
              <td><?php if ($error_telephone) { ?>
                <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="input-error" />
                <span class="error"><?php echo $error_telephone; ?></span>
              <?php } else { ?>
                <input type="text" name="telephone" value="<?php echo $telephone; ?>" />
              <?php  } ?></td>
            </tr>
            <?php if ($show_fax) { ?>
            <tr>
              <td><?php echo $entry_fax; ?></td>
              <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
            </tr>
            <?php } ?>
            <?php if ($show_gender) { ?>
            <tr>
              <td><?php echo $entry_gender; ?></td>
              <td><?php if ($gender) { ?>
                <input type="radio" name="gender" value="1" id="gender-on" class="radio" checked />
                <label for="gender-on"><span><span></span></span><?php echo $text_female; ?></label>
                <input type="radio" name="gender" value="0" id="gender-off" class="radio" />
                <label for="gender-off"><span><span></span></span><?php echo $text_male; ?></label>
              <?php } else { ?>
                <input type="radio" name="gender" value="1" id="gender-on" class="radio" />
                <label for="gender-on"><span><span></span></span><?php echo $text_female; ?></label>
                <input type="radio" name="gender" value="0" id="gender-off" class="radio" checked />
                <label for="gender-off"><span><span></span></span><?php echo $text_male; ?></label>
              <?php } ?></td>
            </tr>
            <?php } ?>
            <?php if ($show_dob) { ?>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_date_of_birth; ?></td>
              <td><?php if ($error_date_of_birth) { ?>
                <input type="text" name="date_of_birth" value="<?php echo $date_of_birth; ?>" id="date-of-birth" size="12" class="input-error" />
                <span class="form-icon"><img src="view/image/calendar.png" alt="" /></span>
                <span class="error"><?php echo $error_date_of_birth; ?></span>
              <?php } else { ?>
                <input type="text" name="date_of_birth" value="<?php echo $date_of_birth; ?>" id="date-of-birth" size="12" />
                <span class="form-icon"><img src="view/image/calendar.png" alt="" /></span>
              <?php } ?></td>
            </tr>
            <?php } ?>
            <tr>
              <td><span class="<?php echo $is_required; ?>">*</span> <?php echo $entry_password; ?></td>
              <td><?php if ($error_password) { ?>
                <input type="password" name="password" value="<?php echo $password; ?>" class="input-error" />
                <span class="error"><?php echo $error_password; ?></span>
              <?php } else { ?>
                <input type="password" name="password" value="<?php echo $password; ?>" />
              <?php  } ?></td>
            </tr>
            <tr>
              <td><span class="<?php echo $is_required; ?>">*</span> <?php echo $entry_confirm; ?></td>
              <td><?php if ($error_confirm) { ?>
                <input type="password" name="confirm" value="<?php echo $confirm; ?>" class="input-error" />
                <span class="error"><?php echo $error_confirm; ?></span>
              <?php } else { ?>
                <input type="password" name="confirm" value="<?php echo $confirm; ?>" />
              <?php  } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_newsletter; ?></td>
              <td><select name="newsletter">
                <?php if ($newsletter) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_customer_group; ?></td>
              <td><select name="customer_group_id">
                <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_approved; ?></td>
              <td><select name="approved">
                <?php if ($approved) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
          </table>
        </div>
        <?php $address_row = 1; ?>
        <?php foreach ($addresses as $address) { ?>
        <div id="tab-address-<?php echo $address_row; ?>" class="vtabs-content">
          <input type="hidden" name="address[<?php echo $address_row; ?>][address_id]" value="<?php echo $address['address_id']; ?>" />
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
              <td><?php if (isset($error_address_firstname[$address_row])) { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][firstname]" value="<?php echo $address['firstname']; ?>" size="30" class="input-error" />
                <span class="error"><?php echo $error_address_firstname[$address_row]; ?></span>
              <?php } else { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][firstname]" value="<?php echo $address['firstname']; ?>" size="30" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
              <td><?php if (isset($error_address_lastname[$address_row])) { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][lastname]" value="<?php echo $address['lastname']; ?>" size="30" class="input-error" />
                <span class="error"><?php echo $error_address_lastname[$address_row]; ?></span>
              <?php } else { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][lastname]" value="<?php echo $address['lastname']; ?>" size="30" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_company; ?></td>
              <td><input type="text" name="address[<?php echo $address_row; ?>][company]" value="<?php echo $address['company']; ?>" size="40" /></td>
            </tr>
            <tr class="company-id-display">
              <td><?php echo $entry_company_id; ?></td>
              <td><input type="text" name="address[<?php echo $address_row; ?>][company_id]" value="<?php echo $address['company_id']; ?>" size="30" /></td>
            </tr>
            <tr class="tax-id-display">
              <td><?php echo $entry_tax_id; ?></td>
              <td><?php if (isset($error_address_tax_id[$address_row])) { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][tax_id]" value="<?php echo $address['tax_id']; ?>" size="30" class="input-error" />
                <span class="error"><?php echo $error_address_tax_id[$address_row]; ?></span>
              <?php } else { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][tax_id]" value="<?php echo $address['tax_id']; ?>" size="30" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
              <td><?php if (isset($error_address_address_1[$address_row])) { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][address_1]" value="<?php echo $address['address_1']; ?>" size="40" class="input-error" />
                <span class="error"><?php echo $error_address_address_1[$address_row]; ?></span>
              <?php } else { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][address_1]" value="<?php echo $address['address_1']; ?>" size="40" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_address_2; ?></td>
              <td><input type="text" name="address[<?php echo $address_row; ?>][address_2]" value="<?php echo $address['address_2']; ?>" size="40" /></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_city; ?></td>
              <td><?php if (isset($error_address_city[$address_row])) { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][city]" value="<?php echo $address['city']; ?>" size="30" class="input-error" />
                <span class="error"><?php echo $error_address_city[$address_row]; ?></span>
              <?php } else { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][city]" value="<?php echo $address['city']; ?>" size="30" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><span id="postcode-required<?php echo $address_row; ?>" class="required">*</span> <?php echo $entry_postcode; ?></td>
              <td><?php if (isset($error_address_postcode[$address_row])) { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][postcode]" value="<?php echo $address['postcode']; ?>" class="input-error" />
                <span class="error"><?php echo $error_address_postcode[$address_row]; ?></span>
              <?php } else { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][postcode]" value="<?php echo $address['postcode']; ?>" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_country; ?></td>
              <td><?php if (isset($error_address_country[$address_row])) { ?>
                <select name="address[<?php echo $address_row; ?>][country_id]" onchange="country(this, '<?php echo $address_row; ?>', '<?php echo $address['zone_id']; ?>');" class="input-error">
                  <option value=""><?php echo $text_select; ?></option>
                  <?php foreach ($countries as $country) { ?>
                    <?php if ($country['country_id'] == $address['country_id']) { ?>
                      <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
                <span class="error"><?php echo $error_address_country[$address_row]; ?></span>
              <?php } else { ?>
                <select name="address[<?php echo $address_row; ?>][country_id]" onchange="country(this, '<?php echo $address_row; ?>', '<?php echo $address['zone_id']; ?>');">
                  <option value=""><?php echo $text_select; ?></option>
                  <?php foreach ($countries as $country) { ?>
                    <?php if ($country['country_id'] == $address['country_id']) { ?>
                      <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
              <td><?php if (isset($error_address_zone[$address_row])) { ?>
                <select name="address[<?php echo $address_row; ?>][zone_id]" class="input-error">
                </select>
                <span class="error"><?php echo $error_address_zone[$address_row]; ?></span>
              <?php } else { ?>
                <select name="address[<?php echo $address_row; ?>][zone_id]">
                </select>
              <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_default; ?></td>
              <td><?php if (($address['address_id'] == $address_id) || !$addresses) { ?>
                <input type="radio" name="address[<?php echo $address_row; ?>][default]" value="<?php echo $address_row; ?>" id="default-address<?php echo $address_row; ?>" class="radio" checked />
                <label for="default-address<?php echo $address_row; ?>"><span><span></span></span></label>
              <?php } else { ?>
                <input type="radio" name="address[<?php echo $address_row; ?>][default]" value="<?php echo $address_row; ?>" id="default-address<?php echo $address_row; ?>" class="radio" />
                <label for="default-address<?php echo $address_row; ?>"><span><span></span></span></label>
              <?php } ?></td>
            </tr>
          </table>
        </div>
        <?php $address_row++; ?>
      <?php } ?>
      </div>
      <?php if ($customer_id) { ?>
      <div id="tab-history">
        <div id="history"></div>
          <table class="form">
            <tr>
              <td><?php echo $entry_comment; ?></td>
              <td><textarea name="comment" cols="40" rows="8" style="width:99%;"></textarea></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align:right;"><a id="button-history" class="button ripple"><?php echo $button_add_history; ?></a></td>
            </tr>
          </table>
        </div>
        <div id="tab-purchase">
          <div id="purchase"></div>
        </div>
        <div id="tab-transaction">
          <table class="form">
            <tr>
              <td><?php echo $entry_description; ?></td>
              <td><input type="text" name="description" value="" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_amount; ?></td>
              <td><input type="text" name="amount" value="" /></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align:right;"><a id="button-transaction" class="button ripple" onclick="addTransaction();"><?php echo $button_add_transaction; ?></a></td>
            </tr>
          </table>
          <div id="transaction"></div>
        </div>
        <div id="tab-reward">
          <table class="form">
            <tr>
              <td><?php echo $entry_description; ?></td>
              <td><input type="text" name="description" value="" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_points; ?></td>
              <td><input type="text" name="points" value="" /></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align:right;"><a id="button-reward" class="button ripple" onclick="addRewardPoints();"><?php echo $button_add_reward; ?></a></td>
            </tr>
          </table>
          <div id="reward"></div>
        </div>
      <?php } ?>
        <div id="tab-ip">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $column_ip; ?></td>
                <td class="left"><?php echo $column_date_added; ?></td>
                <td class="left"><?php echo $column_total; ?></td>
                <td class="left"><?php echo $column_firewall; ?></td>
                <td class="right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
            <?php if ($ips) { ?>
              <?php foreach ($ips as $ip) { ?>
              <tr>
                <td class="center"><a onclick="window.open('http://www.geoiptool.com/en/?IP=<?php echo $ip['ip']; ?>');"><?php echo $ip['ip']; ?></a></td>
                <td class="center"><?php echo $ip['date_added']; ?></td>
                <td class="center"><a href="<?php echo $ip['filter_ip']; ?>" title=""><?php echo $ip['total']; ?></a></td>
                <td class="center"><?php echo $ip['blocked_ip']; ?></td>
                <td class="right"><?php if ($ip['ban_ip']) { ?>
                  <a id="<?php echo str_replace('.', '-', $ip['ip']); ?>" onclick="removeBanIP('<?php echo $ip['ip']; ?>');" class="button"><?php echo $text_remove_ban_ip; ?></a>
                <?php } else { ?>
                  <a id="<?php echo str_replace('.', '-', $ip['ip']); ?>" onclick="addBanIP('<?php echo $ip['ip']; ?>');" class="button"><?php echo $text_add_ban_ip; ?></a>
                <?php } ?></td>
              </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('select[name=\'customer_group_id\']').on('change', function() {
	var customer_group = [];

<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
<?php } ?>

	if (customer_group[this.value]) {
		if (customer_group[this.value]['company_id_display'] == '1') {
			$('.company-id-display').show();
		} else {
			$('.company-id-display').hide();
		}

		if (customer_group[this.value]['tax_id_display'] == '1') {
			$('.tax-id-display').show();
		} else {
			$('.tax-id-display').hide();
		}
	}
});

$('select[name=\'customer_group_id\']').trigger('change');
//--></script>

<script type="text/javascript"><!--
function country(element, index, zone_id) {
  if (element.value != '') {
		$.ajax({
			url: 'index.php?route=localisation/country/country&token=<?php echo $token; ?>&country_id=' + element.value,
			dataType: 'json',
			beforeSend: function() {
				$('select[name=\'address[' + index + '][country_id]\']').after('<span class="wait">&nbsp;<img src="view/image/loading.gif" alt="" /></span>');
			},
			complete: function() {
				$('.wait').remove();
			},
			success: function(json) {
				if (json['postcode_required'] == '1') {
					$('#postcode-required' + index).show();
				} else {
					$('#postcode-required' + index).hide();
				}

				html = '<option value=""><?php echo $text_select; ?></option>';

				if (json['zone'] && json['zone'] != '') {
					for (i = 0; i < json['zone'].length; i++) {
						html += '<option value="' + json['zone'][i]['zone_id'] + '"';

						if (json['zone'][i]['zone_id'] == zone_id) {
							html += ' selected="selected"';
						}

						html += '>' + json['zone'][i]['name'] + '</option>';
					}
				} else {
					html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
				}

				$('select[name=\'address[' + index + '][zone_id]\']').html(html);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

$('select[name$=\'[country_id]\']').trigger('change');
//--></script>

<script type="text/javascript"><!--
var address_row = <?php echo $address_row; ?>;

function addAddress() {
	html  = '<div id="tab-address-' + address_row + '" class="vtabs-content" style="display:none;">';
	html += '  <input type="hidden" name="address[' + address_row + '][address_id]" value="" />';
	html += '  <table class="form">';
	html += '    <tr>';
	html += '      <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>';
	html += '      <td><input type="text" name="address[' + address_row + '][firstname]" value="" size="30" /></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>';
	html += '      <td><input type="text" name="address[' + address_row + '][lastname]" value="" size="30" /></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_company; ?></td>';
	html += '      <td><input type="text" name="address[' + address_row + '][company]" value="" size="40" /></td>';
	html += '    </tr>';
	html += '    <tr class="company-id-display">';
	html += '      <td><?php echo $entry_company_id; ?></td>';
	html += '      <td><input type="text" name="address[' + address_row + '][company_id]" value="" size="30" /></td>';
	html += '    </tr>';
	html += '    <tr class="tax-id-display">';
	html += '      <td><?php echo $entry_tax_id; ?></td>';
	html += '      <td><input type="text" name="address[' + address_row + '][tax_id]" value="" size="30" /></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>';
	html += '      <td><input type="text" name="address[' + address_row + '][address_1]" value="" size="40" /></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_address_2; ?></td>';
	html += '      <td><input type="text" name="address[' + address_row + '][address_2]" value="" size="40" /></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><span class="required">*</span> <?php echo $entry_city; ?></td>';
	html += '      <td><input type="text" name="address[' + address_row + '][city]" value="" size="30" /></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><span id="postcode-required' + address_row + '" class="required">*</span> <?php echo $entry_postcode; ?></td>';
	html += '      <td><input type="text" name="address[' + address_row + '][postcode]" value="" /></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><span class="required">*</span> <?php echo $entry_country; ?></td>';
	html += '      <td><select name="address[' + address_row + '][country_id]" onchange="country(this, \'' + address_row + '\', \'0\');">';
	html += '         <option value=""><?php echo $text_select; ?></option>';
	<?php foreach ($countries as $country) { ?>
	html += '         <option value="<?php echo $country['country_id']; ?>"><?php echo addslashes($country['name']); ?></option>';
	<?php } ?>
	html += '      </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><span class="required">*</span> <?php echo $entry_zone; ?></td>';
	html += '      <td><select name="address[' + address_row + '][zone_id]"><option value="false"><?php echo $this->language->get('text_none'); ?></option></select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_default; ?></td>';
	html += '      <td><input type="radio" name="address[' + address_row + '][default]" value="' + address_row + '" id="default-address' + address_row + '" class="radio" />';
	html += '      <label for="default-address' + address_row + '"><span><span></span></span></label></td>';
	html += '    </tr>';
	html += '  </table>';
	html += '</div>';

	$('#tab-general').append(html);

	$('select[name=\'address[' + address_row + '][country_id]\']').trigger('change');

	$('#address-add').before('<a href="#tab-address-' + address_row + '" id="address-' + address_row + '"><?php echo $tab_address; ?> ' + address_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'#vtabs a:first\').trigger(\'click\'); $(\'#address-' + address_row + '\').remove(); $(\'#tab-address-' + address_row + '\').remove(); return false;" /></a>');

	$('.vtabs a').tabs();

	$('#address-' + address_row).trigger('click');

	address_row++;

	$('select[name=\'customer_group_id\']').trigger('change');
}
//--></script>

<script type="text/javascript"><!--
$('#history .pagination').on('click', 'a', function() {
	$('#history').load(this.href);
	return false;
});

$('#history').load('index.php?route=sale/customer/history&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>');

$('body').on('click', '#button-history', function() {
	$.ajax({
		url: 'index.php?route=sale/customer/history&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>',
		type: 'post',
		dataType: 'html',
		data: 'comment=' + encodeURIComponent($('#tab-history textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-history').attr('disabled', true);
			$('#history').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-history').attr('disabled', false);
			$('.attention').remove();
			$('#tab-history textarea[name=\'comment\']').val('');
		},
		success: function(html) {
			$('#history').html(html);
			$('#tab-history input[name=\'comment\']').val('');
		}
	});
});
//--></script>

<script type="text/javascript"><!--
$('#purchase .pagination').on('click', 'a', function() {
	$('#purchase').load(this.href);
	return false;
});

$('#purchase').load('index.php?route=sale/customer/purchase&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>');
//--></script>

<script type="text/javascript"><!--
$('#transaction .pagination').on('click', 'a', function() {
	$('#transaction').load(this.href);
	return false;
});

$('#transaction').load('index.php?route=sale/customer/transactions&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>');

function addTransaction() {
	$.ajax({
		url: 'index.php?route=sale/customer/add_transaction&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>',
		type: 'POST',
		dataType: 'html',
		data: 'description=' + encodeURIComponent($("#tab-transaction input[name='description']").val()) + '&amount=' + encodeURIComponent($("#tab-transaction input[name='amount']").val()),
		beforeSend: function() {
			$(".success, .warning").remove();
			$("#button-transaction").attr('disabled', true);
			$("#transaction").before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
	})
	.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
	.done(function(html) {
		$("#transaction").html(html);

		$("#tab-transaction input[name='amount']").val('');
		$("#tab-transaction input[name='description']").val('');
	})
	.always(function() {
		$(".attention").remove();
		$("#button-transaction").attr('disabled', false);
	});
}

function deleteTransaction(customer_transaction_id) {
	if (confirm('<?php echo addslashes($text_delete_transaction_confirm); ?>')) {
		$.ajax({
			url: 'index.php?route=sale/customer/delete_transaction&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>',
			type: 'POST',
			data: {"customer_id":<?php echo (isset($customer_id) ? $customer_id : 0); ?>, "customer_transaction_id":customer_transaction_id},
			dataType: 'html',
			beforeSend: function() {
				$(".success, .warning").remove();
				$("#column-delete-transaction").html('<img src="view/image/loading.gif" alt="" />');
			},
		})
		.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
		.done(function(html) {
			$("#transaction").html(html);
		})
		.always(function() {
			$("#column-delete-transaction").html('<img src="view/image/bin-closed.png" alt="" />');
		});
	}
}
//--></script>

<script type="text/javascript"><!--
$('#reward .pagination').on('click', 'a', function() {
	$('#reward').load(this.href);
	return false;
});

$('#reward').load('index.php?route=sale/customer/rewards&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>');

function addRewardPoints() {
	$.ajax({
		url: 'index.php?route=sale/customer/add_reward&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>',
		type: 'POST',
		dataType: 'html',
		data: 'description=' + encodeURIComponent($("#tab-reward input[name='description']").val()) + '&points=' + encodeURIComponent($("#tab-reward input[name='points']").val()),
		beforeSend: function() {
			$(".success, .warning").remove();
			$("#button-reward").attr('disabled', true);
			$("#reward").before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
	})
	.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
	.done(function(html) {
		$("#reward").html(html);

		$("#tab-reward input[name='points']").val('');
		$("#tab-reward input[name='description']").val('');
	})
	.always(function() {
		$(".attention").remove();
		$("#button-reward").attr('disabled', false);
	});
}

function deleteReward(customer_reward_id) {
	if (confirm('<?php echo addslashes($text_delete_reward_confirm); ?>')) {
		$.ajax({
			url: 'index.php?route=sale/customer/delete_reward&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>',
			type: 'POST',
			data: {"customer_id":<?php echo (isset($customer_id) ? $customer_id : 0); ?>, "customer_reward_id":customer_reward_id},
			dataType: 'html',
			beforeSend: function() {
				$(".success, .warning").remove();
				$("#column-delete-reward").html('<img src="view/image/loading.gif" alt="" />');
			},
		})
		.fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
		.done(function(html) {
			$("#reward").html(html);
		})
		.always(function() {
			$("#column-delete-reward").html('<img src="view/image/bin-closed.png" alt="" />');
		});
	}
}

function addBanIP(ip) {
	var id = ip.replace(/\./g, '-');

	$.ajax({
		url: 'index.php?route=sale/customer/addbanip&token=<?php echo $token; ?>',
		type: 'post',
		dataType: 'json',
		data: 'ip=' + encodeURIComponent(ip),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('.box').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
		},
		success: function(json) {
			$('.attention').remove();

			if (json['error']) {
				$('.box').before('<div class="warning" style="display:none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				$('.box').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');

				$('#' + id).replaceWith('<a id="' + id + '" onclick="removeBanIP(\'' + ip + '\');"><?php echo $text_remove_ban_ip; ?></a>');
			}
		}
	});
}

function removeBanIP(ip) {
	var id = ip.replace(/\./g, '-');

	$.ajax({
		url: 'index.php?route=sale/customer/removebanip&token=<?php echo $token; ?>',
		type: 'post',
		dataType: 'json',
		data: 'ip=' + encodeURIComponent(ip),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('.box').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		success: function(json) {
			$('.attention').remove();

			if (json['error']) {
				$('.box').before('<div class="warning" style="display:none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				$('.box').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');

				$('#' + id).replaceWith('<a id="' + id + '" onclick="addBanIP(\'' + ip + '\');"><?php echo $text_add_ban_ip; ?></a>');
			}
		}
	});
};
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-of-birth').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<script type="text/javascript"><!--
$('.htabs a').tabs();
$('.vtabs a').tabs();
//--></script>

<?php echo $footer; ?>