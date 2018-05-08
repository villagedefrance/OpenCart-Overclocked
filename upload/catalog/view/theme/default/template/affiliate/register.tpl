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
  <p><?php echo $text_signup; ?></p>
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
    </table>
  </div>
  <h2><?php echo $text_your_address; ?></h2>
  <div class="content">
    <table class="form">
      <tr>
        <td><?php echo $entry_company; ?></td>
        <td><input type="text" name="company" value="<?php echo $company; ?>" size="30" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_website; ?></td>
        <td><input type="text" name="website" value="<?php echo $website; ?>" size="30" /></td>
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
          <option value="false"><?php echo $text_select; ?></option>
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
  <h2><?php echo $text_payment; ?></h2>
  <div class="content">
    <table class="form">
      <tbody>
        <tr>
          <td><?php echo $entry_tax; ?></td>
          <td><input type="text" name="tax" value="<?php echo $tax; ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_payment; ?></td>
          <td><?php if ($payment == 'cheque') { ?>
            <input type="radio" name="payment" value="cheque" id="cheque" checked="checked" />
          <?php } else { ?>
            <input type="radio" name="payment" value="cheque" id="cheque" />
          <?php } ?>
          <label for="cheque"><?php echo $text_cheque; ?></label>
          <?php if ($payment == 'paypal') { ?>
            <input type="radio" name="payment" value="paypal" id="paypal" checked="checked" />
          <?php } else { ?>
            <input type="radio" name="payment" value="paypal" id="paypal" />
          <?php } ?>
          <label for="paypal"><?php echo $text_paypal; ?></label>
          <?php if ($payment == 'bank') { ?>
            <input type="radio" name="payment" value="bank" id="bank" checked="checked" />
          <?php } else { ?>
            <input type="radio" name="payment" value="bank" id="bank" />
          <?php } ?>
          <label for="bank"><?php echo $text_bank; ?></label></td>
        </tr>
      </tbody>
      <tbody id="payment-cheque" class="payment">
        <tr>
          <td><?php echo $entry_cheque; ?></td>
          <td><input type="text" name="cheque" value="<?php echo $cheque; ?>" size="30" /></td>
        </tr>
      </tbody>
      <tbody id="payment-paypal" class="payment">
        <tr>
          <td><?php echo $entry_paypal; ?></td>
          <td><input type="text" name="paypal" value="<?php echo $paypal; ?>" size="30" /></td>
        </tr>
      </tbody>
      <tbody id="payment-bank" class="payment">
        <tr>
          <td><?php echo $entry_bank_name; ?></td>
          <td><input type="text" name="bank_name" value="<?php echo $bank_name; ?>" size="30" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_bank_branch_number; ?></td>
          <td><input type="text" name="bank_branch_number" value="<?php echo $bank_branch_number; ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_bank_swift_code; ?></td>
          <td><input type="text" name="bank_swift_code" value="<?php echo $bank_swift_code; ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_bank_account_name; ?></td>
          <td><input type="text" name="bank_account_name" value="<?php echo $bank_account_name; ?>" size="30" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_bank_account_number; ?></td>
          <td><input type="text" name="bank_account_number" value="<?php echo $bank_account_number; ?>" /></td>
        </tr>
      </tbody>
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

<script type="text/javascript"><!--
$('img#captcha-image').on('load', function(event) {
	$(event.target).show();
});
$('img#captcha-image').trigger('load');
//--></script>

<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=affiliate/register/country&country_id=' + this.value,
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
$('input[name=\'payment\']').on('change', function() {
	$('.payment').hide();
	$('#payment-' + this.value).show();
});

$('input[name=\'payment\']:checked').trigger('change');
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
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.3,
		width: 600,
		height: 480
	});
});
//--></script>

<?php echo $footer; ?>