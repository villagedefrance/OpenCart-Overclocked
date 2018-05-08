<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <p><?php echo $text_account_already; ?></p>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
  <h2><?php echo $text_your_details; ?></h2>
  <div class="content">
    <table class="form">
      <tr>
        <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
        <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" size="30" />
        <?php if ($error_firstname) { ?>
          <span class="error"><?php echo $error_firstname; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
        <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" size="30" />
        <?php if ($error_lastname) { ?>
          <span class="error"><?php echo $error_lastname; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_email; ?></td>
        <td><input type="text" name="email" value="<?php echo $email; ?>" size="30" />
        <?php if ($error_email) { ?>
          <span class="error"><?php echo $error_email; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
        <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" />
        <?php if ($error_telephone) { ?>
          <span class="error"><?php echo $error_telephone; ?></span>
        <?php } ?></td>
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
          <input type="radio" name="gender" value="1" checked="checked" /><?php echo $text_female; ?>
          <input type="radio" name="gender" value="0" /><?php echo $text_male; ?>
        <?php } else { ?>
          <input type="radio" name="gender" value="1" /><?php echo $text_female; ?>
          <input type="radio" name="gender" value="0" checked="checked" /><?php echo $text_male; ?>
        <?php } ?></td>
      </tr>
      <?php } ?>
      <?php if ($show_dob) { ?>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_date_of_birth; ?></td>
        <td><input type="text" name="date_of_birth" value="<?php echo $date_of_birth; ?>" id="date-of-birth" size="12" />
        <?php if ($error_date_of_birth) { ?>
          <span class="error"><?php echo $error_date_of_birth; ?></span>
        <?php } ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <h2><?php echo $text_your_address; ?></h2>
  <div class="content">
    <table class="form">
      <tr>
        <td><?php echo $entry_company; ?></td>
        <td><input type="text" name="company" value="<?php echo $company; ?>" size="30" /></td>
      </tr>
      <tr style="display: <?php echo (count($customer_groups) > 1 ? 'table-row' : 'none'); ?>;">
        <td><?php echo $entry_customer_group; ?></td>
        <td><?php foreach ($customer_groups as $customer_group) { ?>
          <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
            <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
            <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
            <br />
          <?php } else { ?>
            <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" />
            <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
            <br />
          <?php } ?>
        <?php } ?></td>
      </tr>      
      <tr id="company-id-display">
        <td><span id="company-id-required" class="required">*</span> <?php echo $entry_company_id; ?></td>
        <td><input type="text" name="company_id" value="<?php echo $company_id; ?>" />
        <?php if ($error_company_id) { ?>
          <span class="error"><?php echo $error_company_id; ?></span>
        <?php } ?></td>
      </tr>
      <tr id="tax-id-display">
        <td><span id="tax-id-required" class="required">*</span> <?php echo $entry_tax_id; ?></td>
        <td><input type="text" name="tax_id" value="<?php echo $tax_id; ?>" />
        <?php if ($error_tax_id) { ?>
          <span class="error"><?php echo $error_tax_id; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
        <td><input type="text" name="address_1" value="<?php echo $address_1; ?>" size="30" />
        <?php if ($error_address_1) { ?>
          <span class="error"><?php echo $error_address_1; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_address_2; ?></td>
        <td><input type="text" name="address_2" value="<?php echo $address_2; ?>" size="30" /></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_city; ?></td>
        <td><input type="text" name="city" value="<?php echo $city; ?>" size="30" />
        <?php if ($error_city) { ?>
          <span class="error"><?php echo $error_city; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span id="postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></td>
        <td><input type="text" name="postcode" value="<?php echo $postcode; ?>" />
        <?php if ($error_postcode) { ?>
          <span class="error"><?php echo $error_postcode; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_country; ?></td>
        <td><select name="country_id">
          <option value=""><?php echo $text_select; ?></option>
          <?php foreach ($countries as $country) { ?>
            <?php if ($country['country_id'] == $country_id) { ?>
              <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
            <?php } else { ?>
              <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
            <?php } ?>
          <?php } ?>
        </select>
        <?php if ($error_country) { ?>
          <span class="error"><?php echo $error_country; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
        <td><select name="zone_id">
        </select>
        <?php if ($error_zone) { ?>
          <span class="error"><?php echo $error_zone; ?></span>
        <?php } ?></td>
      </tr>
    </table>
  </div>
  <h2><?php echo $text_your_password; ?></h2>
  <div class="content">
    <table class="form">
      <tr>
        <td><span class="required">*</span> <?php echo $entry_password; ?></td>
        <td><input type="password" name="password" id="password1" value="<?php echo $password; ?>" />
        <span id="check" class="hidden"></span>
        <?php if ($error_password) { ?>
          <span class="error"><?php echo $error_password; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
        <td><input type="password" name="confirm" id="password2" value="<?php echo $confirm; ?>" />&nbsp;
        <span id="match" class="hidden"></span>
        <?php if ($error_confirm) { ?>
          <span class="error"><?php echo $error_confirm; ?></span>
        <?php } ?></td>
      </tr>
    </table>
  </div>
  <h2><?php echo $text_newsletter; ?></h2>
  <div class="content">
    <table class="form">
      <tr>
        <td><?php echo $entry_newsletter; ?></td>
        <td><?php if ($newsletter) { ?>
          <input type="radio" name="newsletter" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="newsletter" value="0" />
          <?php echo $text_no; ?>
        <?php } else { ?>
          <input type="radio" name="newsletter" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="newsletter" value="0" checked="checked" />
          <?php echo $text_no; ?>
        <?php } ?></td>
      </tr>
    </table>
  </div>
  <?php if ($account_captcha) { ?>
    <br />
    <div id="captcha-wrap">
      <div class="captcha-box">
        <div class="captcha-view">
          <img src="<?php echo $captcha_image; ?>" alt="" id="captcha-image" />
        </div>
      </div>
      <div class="captcha-text">
        <label><?php echo $entry_captcha; ?></label>
        <input type="text" name="captcha" id="captcha" value="<?php echo $captcha; ?>" autocomplete="off" />
      </div>
      <div class="captcha-action"><i class="fa fa-repeat"></i></div>
    </div>
    <br />
    <?php if ($error_captcha) { ?>
      <span class="error"><?php echo $error_captcha; ?></span>
    <?php } ?>
  <?php } ?>
  <?php if ($text_agree) { ?>
    <div class="buttons">
      <div class="right"><?php echo $text_agree; ?>
        <?php if ($agree) { ?>
          <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
          <input type="checkbox" name="agree" value="1" />
        <?php } ?>
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
  <?php } else { ?>
    <div class="buttons">
      <div class="right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
  <?php } ?>
  </form>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

<?php if ($account_captcha) { ?>
<script type="text/javascript"><!--
$('img#captcha-image').on('load', function(event) {
	$(event.target).show();
});
$('img#captcha-image').trigger('load');
//--></script>
<?php } ?>

<script type="text/javascript"><!--
$('input[name=\'customer_group_id\']:checked').on('change', function() {
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

$('input[name=\'customer_group_id\']:checked').trigger('change');
//--></script>

<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=account/register/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
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
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.3,
		width: 600,
		height: 480
	});
});
//--></script>

<?php echo $footer; ?>