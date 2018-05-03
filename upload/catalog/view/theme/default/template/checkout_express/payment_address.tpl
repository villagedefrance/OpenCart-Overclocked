<div style="margin-bottom:15px;">
  <h2><?php echo $text_checkout_payment_address; ?></h2>
</div>
<?php if ($addresses) { ?>
  <input type="radio" name="payment_address" value="existing" id="payment-address-existing" checked="checked" />
  <label for="payment-address-existing"><?php echo $text_address_existing; ?></label>
  <div id="payment-existing">
    <select name="address_id" style="width:100%; margin-bottom:15px;" size="5">
    <?php foreach ($addresses as $address) { ?>
      <?php if ($address['address_id'] == $address_id) { ?>
        <option value="<?php echo $address['address_id']; ?>" selected="selected"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?></option>
      <?php } else { ?>
        <option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?></option>
      <?php } ?>
    <?php } ?>
    </select>
  </div>
  <p><input type="radio" name="payment_address" value="new" id="payment-address-new" />
    <label for="payment-address-new"><?php echo $text_address_new; ?></label>
  </p>
<?php } ?>
<div id="payment-new" style="display:<?php echo ($addresses) ? 'none' : 'block'; ?>;">
  <table class="form">
    <tr>
      <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
      <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
      <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" class="large-field" /></td>
    </tr>
    <?php if (!$company_id_required) { ?>
    <tr>
      <td></td>
      <td><a onclick="$(this).hide(100);$('#company_row').show(500);$('#company_row2').show(500);$(this).hide(100);"><?php echo $text_express_company_info; ?></a></td>
    </tr>
    <?php } ?>
    <tr id="company_row" <?php if (!$company_id_required) { ?>style="display:none;"<?php } ?>>
      <td><?php echo $entry_company; ?></td>
      <td><input type="text" name="company" value="" class="large-field" /></td>
    </tr>
    <?php if ($company_id_display) { ?>
    <tr id="company_row2" <?php if (!$company_id_required) { ?>style="display:none;"<?php } ?>>
      <td><?php if ($company_id_required) { ?><span class="required">*</span> <?php } ?><?php echo $entry_company_id; ?></td>
      <td><input type="text" name="company_id" value="" class="large-field" /></td>
    </tr>
    <?php } ?>
    <?php if ($tax_id_display) { ?>
    <tr>
      <td><?php if ($tax_id_required) { ?><span class="required">*</span> <?php } ?><?php echo $entry_tax_id; ?></td>
      <td><input type="text" name="tax_id" value="" class="large-field" /></td>
    </tr>
    <?php } ?>
    <tr>
      <td><span class="required">*</span> <?php echo $text_express_address; ?></td>
      <td><input type="text" name="address_1" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_country; ?></td>
      <td><select name="country_id" class="large-field">
        <option value=""><?php echo $text_select; ?></option>
        <?php foreach ($countries as $country) { ?>
          <?php if ($country['country_id'] == $country_id) { ?>
            <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
          <?php } else { ?>
            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
          <?php } ?>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
      <td><select name="zone_id" id="zone" onchange="var city=$('#zone option:selected').text();
        if (!$('#zone option:selected').val()) { city=''; <?php if ($this->config->get('config_express_autofill')) { ?> document.getElementsByName('city')[0].value=city; <?php } ?> }
        if (city) { $('#cities').show(500); } else { $('#cities').hide(100); }
        if (city && postcode_required) { $('#codes').show(500); } else { $('#codes').hide(100); }" class="large-field">
      </select></td>
    </tr>
    <tr id="cities" style="display:none;">
      <td><span class="required">* </span><?php echo $entry_city; ?></td>
      <td><input type="text" name="city" value="" class="large-field" /></td>
    </tr>
    <tr id="codes" style="display:none">
      <td><span id="payment-postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></td>
      <td><input type="text" name="postcode" value="" class="large-field" /></td>
    </tr>
  </table>
</div>
<br/>
<div class="buttons">
  <div class="left">
    <input type="button" value="<?php echo $button_express_go; ?>" id="button-payment-address" class="button" />
  </div>
</div>

<script type="text/javascript"><!--
$('#payment-address input[name=\'payment_address\']').on('change', function() {
	if (this.value == 'new') {
		$('#payment-existing').hide();
		$('#payment-new').show(500);
	} else {
		$('#payment-existing').show(500);
		$('#payment-new').hide();
	}
});
//--></script>

<script type="text/javascript"><!--
var postcode_required = 0;

$('#payment-address select[name=\'country_id\']').on('change', function() {
	if (this.value == '') {
		return;
	}

	$.ajax({
		url: 'index.php?route=checkout_express/checkout/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#payment-address select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
			var html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] != '') {
				for (var i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
						html += ' selected="selected"';
					}

					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('#payment-address select[name=\'zone_id\']').html(html);

			document.getElementsByName('city')[0].value='';

			var postcode_required = json['postcode_required'] == '1';

			<?php if ($this->config->get('config_express_postcode')) { ?>
				postcode_required = 1;
			<?php } ?>

			$('#payment-address select[name=\'zone_id\']').trigger('change');

			if (json['postcode_required'] == '1') {
				$('#payment-postcode-required').show(500);
			} else {
				$('#payment-postcode-required').hide(100);
			}
		},
		error:function (xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#payment-address select[name=\'country_id\']').trigger('change');
//--></script>