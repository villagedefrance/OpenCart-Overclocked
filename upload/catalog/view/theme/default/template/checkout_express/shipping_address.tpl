<div style="margin-bottom:15px;">
  <h2><?php echo $text_checkout_shipping_address; ?></h2>
</div>
<?php if ($addresses) { ?>
  <input type="radio" name="shipping_address" value="existing" id="shipping-address-existing" checked="checked" />
  <label for="shipping-address-existing"><?php echo $text_address_existing; ?></label>
  <div id="shipping-existing">
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
  <p><input type="radio" name="shipping_address" value="new" id="shipping-address-new" />
    <label for="shipping-address-new"><?php echo $text_address_new; ?></label>
  </p>
<?php } ?>
<div id="shipping-new" style="display:<?php echo ($addresses) ? 'none' : 'block'; ?>;">
  <table class="form">
    <tr>
      <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
      <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
      <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" class="large-field" /></td>
    </tr>
    <tr>
      <td></td>
      <td><a onclick="$(this).hide();$('#company-express').show(500);"><?php echo $text_express_company_info; ?></a></td>
    </tr>
    <tr id="company-express" style="display:none;">
      <td><?php echo $entry_company; ?></td>
      <td><input type="text" name="company" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">* </span><?php echo $text_express_address; ?></td>
      <td><input type="text" name="address_1" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">* </span><?php echo $entry_country; ?></td>
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
      <td><span class="required">* </span><?php echo $entry_zone; ?></td>
      <td><select name="zone_id" id="express-zone" onchange="var city=$('#express-zone option:selected').text();
        if (!$('#express-zone option:selected').val()) { city=''; <?php if ($this->config->get('config_express_autofill')) { ?> document.getElementById('express-city').value=city; <?php } ?> }
        if (city) { $('#express-cities').show(500); } else { $('#express-cities').hide(100); }
        if (city && postcode_required) { $('#express-codes').show(500); } else { $('#express-codes').hide(100); }" class="large-field">
      </select></td>
    </tr>
    <tr id="express-cities" style="display:none;">
      <td><span class="required">* </span><?php echo $entry_city; ?></td>
      <td><input type="text" name="city" id="express-city" value="" class="large-field" /></td>
    </tr>
    <tr id="express-codes" style="display:none;">
      <td><span id="shipping-postcode-required" class="required">* </span><?php echo $entry_postcode; ?></td>
      <td><input type="text" name="postcode" value="<?php echo $postcode; ?>" class="large-field" /></td>
    </tr>
  </table>
</div>
<div class="buttons">
  <div class="left">
    <input type="button" value="<?php echo $button_express_go; ?>" id="button-shipping-address" class="button" />
  </div>
</div>

<script type="text/javascript"><!--
$('#shipping-address input[name=\'shipping_address\']').on('change', function() {
	if (this.value == 'new') {
		$('#shipping-existing').hide();
		$('#shipping-new').show(500);
	} else {
		$('#shipping-existing').show(500);
		$('#shipping-new').hide();
	}
});
//--></script>
<script type="text/javascript"><!--
var postcode_required = 0;

$('#shipping-address select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url:'index.php?route=checkout_express/checkout/country&country_id=' + this.value,
		dataType:'json',
		beforeSend:function() {
			$('#shipping-address select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete:function() {
			$('.wait').remove();
		},
		success:function(json) {
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

			$('#shipping-address select[name=\'zone_id\']').html(html);

			document.getElementById('express-city').value='';

			postcode_required = json['postcode_required'] == '1';

			<?php if ($this->config->get('config_express_postcode')) { ?>
				postcode_required = 1;
			<?php } ?>

			$('#express-zone').trigger('change');

			if (json['postcode_required'] == '1') {
				$('#shipping-postcode-required').show(500);
			} else {
				$('#shipping-postcode-required').hide(100);
			}
		},
		error:function (xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#shipping-address select[name=\'country_id\']').trigger('change');
//--></script>