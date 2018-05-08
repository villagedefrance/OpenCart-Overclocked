<div class="left">
  <h2><?php echo $text_your_details; ?></h2>
  <span class="required">*</span> <?php echo $entry_firstname; ?><br />
  <input type="text" name="firstname" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_lastname; ?><br />
  <input type="text" name="lastname" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_email; ?><br />
  <input type="text" name="email" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_telephone; ?><br />
  <input type="text" name="telephone" value="" class="large-field" />
  <br />
  <br />
  <?php if ($show_fax) { ?>
    <?php echo $entry_fax; ?><br />
    <input type="text" name="fax" value="" class="large-field" />
  <br />
  <br />
  <?php } ?>
  <?php if ($show_gender) { ?>
    <?php echo $entry_gender; ?><br />
    <?php if ($gender) { ?>
      <input type="radio" name="gender" value="1" checked="checked" /><?php echo $text_female; ?>
      <input type="radio" name="gender" value="0" /><?php echo $text_male; ?>
    <?php } else { ?>
      <input type="radio" name="gender" value="1" /><?php echo $text_female; ?>
      <input type="radio" name="gender" value="0" checked="checked" /><?php echo $text_male; ?>
    <?php } ?>
  <br />
  <br />
  <?php } ?>
  <?php if ($show_dob) { ?>
  <span class="required">*</span> <?php echo $entry_date_of_birth; ?><br />
  <input type="text" name="date_of_birth" value="" id="date-of-birth" size="12" />
  <?php } ?>
  <br />
  <br />
  <h2><?php echo $text_your_password; ?></h2>
  <span class="required">*</span> <?php echo $entry_password; ?><br />
  <input type="password" name="password" id="password1" value="" size="30" />
  <span id="check" class="hidden"></span>
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_confirm; ?> <br />
  <input type="password" name="confirm" id="password2" value="" size="30" />&nbsp;
  <span id="match" class="hidden"></span>
  <br />
  <br />
  <br />
</div>
<div class="right">
  <h2><?php echo $text_your_address; ?></h2>
  <?php echo $entry_company; ?><br />
  <input type="text" name="company" value="" class="large-field" />
  <br />
  <br />
  <div style="display: <?php echo (count($customer_groups) > 1 ? 'table-row' : 'none'); ?>;">
    <?php echo $entry_customer_group; ?><br />
    <?php foreach ($customer_groups as $customer_group) { ?>
      <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
        <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
        <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
        <br />
      <?php } else { ?>
        <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" />
        <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
        <br />
      <?php } ?>
    <?php } ?>
    <br />
  </div>
  <div id="company-id-display"><span id="company-id-required" class="required">*</span> <?php echo $entry_company_id; ?><br />
    <input type="text" name="company_id" value="" class="large-field" />
    <br />
    <br />
  </div>
  <div id="tax-id-display"><span id="tax-id-required" class="required">*</span> <?php echo $entry_tax_id; ?><br />
    <input type="text" name="tax_id" value="" class="large-field" />
    <br />
    <br />
  </div>
  <span class="required">*</span> <?php echo $entry_address_1; ?><br />
  <input type="text" name="address_1" value="" class="large-field" />
  <br />
  <br />
  <?php echo $entry_address_2; ?><br />
  <input type="text" name="address_2" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_city; ?><br />
  <input type="text" name="city" value="" class="large-field" />
  <br />
  <br />
  <span id="payment-postcode-required" class="required">*</span> <?php echo $entry_postcode; ?><br />
  <input type="text" name="postcode" value="<?php echo $postcode; ?>" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_country; ?><br />
  <select name="country_id" class="large-field">
    <option value=""><?php echo $text_select; ?></option>
    <?php foreach ($countries as $country) { ?>
      <?php if ($country['country_id'] == $country_id) { ?>
        <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
      <?php } else { ?>
        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
      <?php } ?>
    <?php } ?>
  </select>
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_zone; ?><br />
  <select name="zone_id" class="large-field">
  </select>
  <br />
  <br />
  <br />
</div>
<div style="clear:both; padding-top:15px; border-top:1px solid #EEE;">
  <input type="checkbox" name="newsletter" value="1" id="newsletter" />
  <label for="newsletter"><?php echo $entry_newsletter; ?></label>
  <br />
  <?php if ($shipping_required) { ?>
    <input type="checkbox" name="shipping_address" value="1" id="shipping" checked="checked" />
    <label for="shipping"><?php echo $entry_shipping; ?></label>
    <br />
  <?php } ?>
  <br />
  <br />
</div>
<?php if ($text_agree) { ?>
  <div class="buttons">
    <div class="right"><?php echo $text_agree; ?>
      <input type="checkbox" name="agree" value="1" />
      <input type="button" value="<?php echo $button_continue; ?>" id="button-register" class="button" />
    </div>
  </div>
<?php } else { ?>
  <div class="buttons">
    <div class="right">
      <input type="button" value="<?php echo $button_continue; ?>" id="button-register" class="button" />
    </div>
  </div>
<?php } ?>

<script type="text/javascript"><!--
$('#payment-address input[name=\'customer_group_id\']:checked').on('change', function() {
	var customer_group = [];

<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
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

$('#payment-address input[name=\'customer_group_id\']:checked').trigger('change');
//--></script>

<script type="text/javascript"><!--
$('#payment-address select[name=\'country_id\']').on('change', function() {
	if (this.value == '') return;
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#payment-address select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
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

			$('#payment-address select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#payment-address select[name=\'country_id\']').trigger('change');
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#password1').on('keyup', function() {
		$('#check').html(checkStrength($('#password1').val()));
	});

	function checkStrength(password1) {
		var strength = 0;

		if (password1.length < 4) {
			$('#check').removeClass().addClass('short');
			return '<img src="catalog/view/theme/<?php echo $template; ?>/image/account/password-short.png" alt="" />';
		}

		if (password1.length > 4) { strength += 1; };
		if (password1.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) { strength += 1; };
		if (password1.match(/([a-zA-Z])/) && password1.match(/([0-9])/)) { strength += 1; };
		if (password1.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) { strength += 1; };
		if (password1.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/)) { strength += 1; };

		if (strength < 2) {
			$('#check').removeClass().addClass('weak');
			return '<img src="catalog/view/theme/<?php echo $template; ?>/image/account/password-weak.png" alt="" />';
		} else if (strength == 2) {
			$('#check').removeClass().addClass('good');
			return '<img src="catalog/view/theme/<?php echo $template; ?>/image/account/password-good.png" alt="" />';
		} else {
			$('#check').removeClass().addClass('strong');
			return '<img src="catalog/view/theme/<?php echo $template; ?>/image/account/password-strong.png" alt="" />';
		}
	}
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	var password1 = $('#password1');
	var password2 = $('#password2');

	$(password2).on('keyup', function() {
		if (password1.val() && password2.val() === password1.val()) {
			$('#match').removeClass().addClass('match').html('<img src="catalog/view/theme/<?php echo $template; ?>/image/account/tick.png" alt="" />');
		} else {
			$('#match').removeClass('match').addClass('hidden').html('');
		}
	});
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-of-birth').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<script type="text/javascript"><!--
$('.colorbox').colorbox({
	overlayClose: true,
	opacity: 0.3,
	width: 600,
	height: 480
});
//--></script>