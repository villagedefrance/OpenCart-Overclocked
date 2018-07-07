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
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $supplier_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <div id="htabs" class="htabs">
      <a href="#tab-general"><?php echo $tab_general; ?></a>
      <?php if ($supplier_id) { ?>
        <a href="#tab-history"><?php echo $tab_history; ?></a>
        <a href="#tab-catalog"><?php echo $tab_catalog; ?></a>
      <?php } ?>
    </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
        <div id="vtabs" class="vtabs"><a href="#tab-supplier"><?php echo $tab_general; ?></a>
          <?php $address_row = 1; ?>
          <?php foreach ($addresses as $address) { ?>
            <a href="#tab-address-<?php echo $address_row; ?>" id="address-<?php echo $address_row; ?>"><?php echo $tab_address . ' ' . $address_row; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('#vtabs a:first').trigger('click'); $('#address-<?php echo $address_row; ?>').remove(); $('#tab-address-<?php echo $address_row; ?>').remove(); return false;" /></a>
            <?php $address_row++; ?>
          <?php } ?>
          <span id="address-add"><?php echo $button_add_address; ?>&nbsp;<img src="view/image/add.png" alt="" onclick="addAddress();" /></span></div>
          <div id="tab-supplier" class="vtabs-content">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_reference; ?></td>
              <td><?php if ($error_reference) { ?>
                <input type="text" name="reference" value="<?php echo $reference; ?>" size="30" class="input-error" />
                <span class="error"><?php echo $error_reference; ?></span>
              <?php } else { ?>
                <input type="text" name="reference" value="<?php echo $reference; ?>" size="30" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_company; ?></td>
              <td><?php if ($error_company) { ?>
                <input type="text" name="company" value="<?php echo $company; ?>" size="40" class="input-error" />
                <span class="error"><?php echo $error_company; ?></span>
              <?php } else { ?>
                <input type="text" name="company" value="<?php echo $company; ?>" size="40" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_account; ?></td>
              <td><input type="text" name="account" value="<?php echo $account; ?>" size="40" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_description; ?></td>
              <td><textarea name="description" cols="30" rows="5" style="width:250px;"></textarea></td>
            </tr>
            <tr>
              <td><?php echo $entry_contact; ?></td>
              <td><input type="text" name="contact" value="<?php echo $contact; ?>" size="40" /></td>
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
              <td><?php echo $entry_telephone; ?></td>
              <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_fax; ?></td>
              <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_supplier_group; ?></td>
              <td><select name="supplier_group_id">
                <?php foreach ($supplier_groups as $supplier_group) { ?>
                  <?php if ($supplier_group['supplier_group_id'] == $supplier_group_id) { ?>
                    <option value="<?php echo $supplier_group['supplier_group_id']; ?>" selected="selected"><?php echo $supplier_group['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $supplier_group['supplier_group_id']; ?>"><?php echo $supplier_group['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
            </tr>
            <tr class="highlighted">
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
          </table>
        </div>
        <?php $address_row = 1; ?>
        <?php foreach ($addresses as $address) { ?>
        <div id="tab-address-<?php echo $address_row; ?>" class="vtabs-content">
          <input type="hidden" name="address[<?php echo $address_row; ?>][address_id]" value="<?php echo $address['address_id']; ?>" />
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_company; ?></td>
              <td><?php if (isset($error_address_company[$address_row])) { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][company]" value="<?php echo $address['company']; ?>" size="40" class="input-error" />
                <span class="error"><?php echo $error_address_company[$address_row]; ?></span>
              <?php } else { ?>
                <input type="text" name="address[<?php echo $address_row; ?>][company]" value="<?php echo $address['company']; ?>" size="40" />
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
      <?php if ($supplier_id) { ?>
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
        <div id="tab-catalog">
          <div id="catalog-product"></div>
        </div>
      <?php } ?>
      </form>
    </div>
  </div>
</div>

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
	html += '      <td><span class="required">*</span> <?php echo $entry_company; ?></td>';
	html += '      <td><input type="text" name="address[' + address_row + '][company]" value="" size="40" /></td>';
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

	$('select[name=\'supplier_group_id\']').trigger('change');
}
//--></script>

<script type="text/javascript"><!--
$('#history .pagination').on('click', 'a', function() {
	$('#history').load(this.href);
	return false;
});

$('#history').load('index.php?route=sale/supplier/history&token=<?php echo $token; ?>&supplier_id=<?php echo $supplier_id; ?>');

$('body').on('click', '#button-history', function() {
	$.ajax({
		url: 'index.php?route=sale/supplier/history&token=<?php echo $token; ?>&supplier_id=<?php echo $supplier_id; ?>',
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
$('#catalog-product .pagination').on('click', 'a', function() {
	$('#catalog-product').load(this.href);
	return false;
});

$('#catalog-product').load('index.php?route=sale/supplier/product&token=<?php echo $token; ?>&supplier_id=<?php echo $supplier_id; ?>');
//--></script>

<script type="text/javascript"><!--
$('.htabs a').tabs();
$('.vtabs a').tabs();
//--></script>

<?php echo $footer; ?>