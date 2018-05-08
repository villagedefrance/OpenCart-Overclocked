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
  <h1><?php echo $heading_title; ?></h1>
  <p><?php echo $text_account_already; ?></p>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h2><?php echo $text_your_details; ?></h2>
    <div class="content">
      <table class="form" style="margin-bottom:0px;">
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
          <td><span class="required">* </span><strong><?php echo $entry_email; ?></strong></td>
          <td><input type="text" id="email" name="email" value="<?php echo $email; ?>" size="30" />
            <?php if ($error_email) { ?>
              <span class="error"><?php echo $error_email; ?></span>
            <?php } ?>
          </td>
        </tr>
        <tr <?php ($this->config->get('config_express_password') != 1) ? 'style="display:none;"' : ''; ?>>
          <td><?php echo $entry_password; ?></td>
          <td><input type="password" name="password" value="<?php echo $password; ?>" oninput="$('#auto-password').hide(100);" />
            <span id="auto-password" style="color:#AAA; <?php echo ($this->config->get('config_express_password') == 2) ? 'display:none;' : ''; ?>"><?php echo $text_express_generated; ?></span>
            <?php if ($error_password) { ?>
              <span class="error"><?php echo $error_password; ?></span>
            <?php } ?>
          </td>
        </tr>
        <tr <?php echo ($this->config->get('config_express_phone') == 0) ? 'style="display:none;"' : ''; ?>>
          <td><?php echo ($this->config->get('config_express_phone') == 2) ? '<span class="required">* </span>' : ''; ?><?php echo $entry_telephone; ?></td>
          <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" />
            <?php if ($error_telephone) { ?>
              <span class="error"><?php echo $error_telephone; ?></span>
            <?php } ?>
          </td>
        </tr>
        <tr style="display:<?php echo (count($customer_groups) > 1) ? 'table-row' : 'none'; ?>;">
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
        <tr id="company-name-display">
          <td><?php echo $entry_company; ?></td>
          <td><input type="text" name="company" value="<?php echo $company; ?>" size="30" /></td>
        </tr>
        <tr id="company-id-display">
          <td><span id="company-id-required" class="required">* </span><?php echo $entry_company_id; ?></td>
          <td><input type="text" name="company_id" value="<?php echo $company_id; ?>" />
          <?php if ($error_company_id) { ?>
            <span class="error"><?php echo $error_company_id; ?></span>
          <?php } ?></td>
        </tr>
        <tr id="tax-id-display">
          <td><span id="tax-id-required" class="required">* </span><?php echo $entry_tax_id; ?></td>
          <td><input type="text" name="tax_id" value="<?php echo $tax_id; ?>" />
          <?php if ($error_tax_id) { ?>
            <span class="error"><?php echo $error_tax_id; ?></span>
          <?php } ?></td>
        </tr>
        <?php if ($this->config->get('config_express_newsletter') == 2) { ?>
        <tr>
          <td><?php echo $entry_express_newsletter; ?></td>
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
        <?php } ?>
      </table>
    </div>
    <?php if ($text_agree) { ?>
      <div class="buttons">
        <div class="left"><?php echo $text_agree; ?>
          <?php if ($agree) { ?>
            <input type="checkbox" name="agree" value="1" checked="checked" />
          <?php } else { ?>
            <input type="checkbox" name="agree" value="1" />
          <?php } ?>
          <input type="submit" value="<?php echo $button_express_go; ?>" class="button" />
        </div>
      </div>
    <?php } else { ?>
      <div class="buttons">
        <div class="right">
          <input type="submit" value="<?php echo $button_express_go; ?>" class="button" />
        </div>
      </div>
    <?php } ?>
  </form>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

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
			$('#company-name-display').show(500);
            $('#company-id-display').show(500);
		} else {
			$('#company-name-display').hide(100);
			$('#company-id-display').hide(100);
		}

		if (customer_group[this.value]['company_id_required'] == '1') {
			$('#company-id-required').show(500);
		} else {
			$('#company-id-required').hide(100);
		}

		if (customer_group[this.value]['tax_id_display'] == '1') {
			$('#tax-id-display').show(500);
		} else {
			$('#tax-id-display').hide(100);
		}

		if (customer_group[this.value]['tax_id_required'] == '1') {
			$('#tax-id-required').show(500);
		} else {
			$('#tax-id-required').hide(100);
		}
	}
});

$('input[name=\'customer_group_id\']:checked').trigger('change');
//--></script>

<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=checkout_express/signup/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show(500);
			} else {
				$('#postcode-required').hide(100);
			}

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
$('.colorbox').colorbox({
	overlayClose: true,
	opacity: 0.3,
	width: 600,
	height: 480
});
//--></script>

<?php echo $footer; ?>