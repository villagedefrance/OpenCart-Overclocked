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
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $affiliate_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
    </div>
  </div>
  <div class="content">
    <div id="htabs" class="htabs">
      <a href="#tab-general"><?php echo $tab_general; ?></a>
      <a href="#tab-payment"><?php echo $tab_payment; ?></a>
      <?php if ($affiliate_id) { ?>
        <a href="#tab-product"><?php echo $tab_product; ?></a>
        <a href="#tab-transaction"><?php echo $tab_transaction; ?></a>
      <?php } ?>
    </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
        <h2><?php echo $text_affiliate_detail; ?></h2>
        <table class="form">
          <tbody>
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
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
            <td><?php if ($error_telephone) { ?>
              <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="input-error" />
              <span class="error"><?php echo $error_telephone; ?></span>
            <?php } else { ?>
              <input type="text" name="telephone" value="<?php echo $telephone; ?>" />
            <?php } ?></td>
          </tr>
          <?php if ($show_fax) { ?>
          <tr>
            <td><?php echo $entry_fax; ?></td>
            <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
          </tr>
           <?php } ?>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_code; ?></td>
            <td><input type="code" name="code" value="<?php echo $code; ?>" />
            <?php if ($error_code) { ?>
              <span class="error"><?php echo $error_code; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_password; ?></td>
            <td><?php if ($error_password) { ?>
              <input type="password" name="password" value="<?php echo $password; ?>" class="input-error" />
              <span class="error"><?php echo $error_password; ?></span>
            <?php } else { ?>
              <input type="password" name="password" value="<?php echo $password; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_confirm; ?></td>
            <td><?php if ($error_confirm) { ?>
              <input type="password" name="confirm" value="<?php echo $confirm; ?>" class="input-error" />
              <span class="error"><?php echo $error_confirm; ?></span>
            <?php } else { ?>
              <input type="password" name="confirm" value="<?php echo $confirm; ?>" />
            <?php } ?></td>
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
          </tbody>
        </table>
        <h2><?php echo $text_affiliate_address; ?></h2>
        <table class="form">
          <tbody>
          <tr>
            <td><?php echo $entry_company; ?></td>
            <td><input type="text" name="company" value="<?php echo $company; ?>" size="40" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_website; ?></td>
            <td><input type="text" name="website" value="<?php echo $website; ?>" size="40" /></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
            <td><?php if ($error_address_1) { ?>
              <input type="text" name="address_1" value="<?php echo $address_1; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_address_1; ?></span>
            <?php } else { ?>
              <input type="text" name="address_1" value="<?php echo $address_1; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_address_2; ?></td>
            <td><input type="text" name="address_2" value="<?php echo $address_2; ?>" size="40" /></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_city; ?></td>
            <td><?php if ($error_city) { ?>
              <input type="text" name="city" value="<?php echo $city; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_city; ?></span>
            <?php } else { ?>
              <input type="text" name="city" value="<?php echo $city; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span id="postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></td>
            <td><?php if ($error_postcode) { ?>
              <input type="text" name="postcode" value="<?php echo $postcode; ?>" class="input-error" />
              <span class="error"><?php echo $error_postcode; ?></span>
            <?php } else { ?>
              <input type="text" name="postcode" value="<?php echo $postcode; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_country; ?></td>
            <td><?php if ($error_country) { ?>
              <select name="country_id" class="input-error">
                <option value="false"><?php echo $text_select; ?></option>
                <?php foreach ($countries as $country) { ?>
                  <?php if ($country['country_id'] == $country_id) { ?>
                    <option value="<?php echo $country['country_id']; ?>" selected="selected"> <?php echo $country['name']; ?> </option>
                  <?php } else { ?>
                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
              <span class="error"><?php echo $error_country; ?></span>
            <?php } else { ?>
              <select name="country_id">
                <option value="false"><?php echo $text_select; ?></option>
                <?php foreach ($countries as $country) { ?>
                  <?php if ($country['country_id'] == $country_id) { ?>
                    <option value="<?php echo $country['country_id']; ?>" selected="selected"> <?php echo $country['name']; ?> </option>
                  <?php } else { ?>
                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
            <td><?php if ($error_zone) { ?>
              <select name="zone_id" class="input-error">
              </select>
              <span class="error"><?php echo $error_zone; ?></span>
            <?php } else { ?>
              <select name="zone_id">
              </select>
            <?php } ?></td>
          </tr>
          </tbody>
        </table>
      </div>
      <div id="tab-payment">
        <table class="form">
          <tbody>
          <tr>
            <td><?php echo $entry_commission; ?></td>
            <td><input type="text" name="commission" value="<?php echo $commission; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax; ?></td>
            <td><input type="text" name="tax" value="<?php echo $tax; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_payment; ?></td>
            <td><?php if ($payment == 'cheque') { ?>
              <input type="radio" name="payment" value="cheque" id="cheque" class="checkbox" checked />
            <?php } else { ?>
              <input type="radio" name="payment" value="cheque" id="cheque" class="checkbox" />
            <?php } ?>
            <label for="cheque"><span></span><?php echo $text_cheque; ?></label> &nbsp;&nbsp;
            <?php if ($payment == 'paypal') { ?>
              <input type="radio" name="payment" value="paypal" id="paypal" class="checkbox" checked />
            <?php } else { ?>
              <input type="radio" name="payment" value="paypal" id="paypal" class="checkbox" />
            <?php } ?>
            <label for="paypal"><span></span><?php echo $text_paypal; ?></label> &nbsp;&nbsp;
            <?php if ($payment == 'bank') { ?>
              <input type="radio" name="payment" value="bank" id="bank" class="checkbox" checked />
            <?php } else { ?>
              <input type="radio" name="payment" value="bank" id="bank" class="checkbox" />
            <?php } ?>
            <label for="bank"><span></span><?php echo $text_bank; ?></label></td>
          </tr>
          </tbody>
          <tbody id="payment-cheque" class="payment">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_cheque; ?></td>
            <td><?php if ($error_cheque) { ?>
              <input type="text" name="cheque" value="<?php echo $cheque; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_cheque; ?></span>
            <?php } else { ?>
              <input type="text" name="cheque" value="<?php echo $cheque; ?>" size="40" />
            <?php } ?></td>
          </tr>
          </tbody>
          <tbody id="payment-paypal" class="payment">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_paypal; ?></td>
            <td><?php if ($error_paypal) { ?>
              <input type="text" name="paypal" value="<?php echo $paypal; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_paypal; ?></span>
            <?php } else { ?>
              <input type="text" name="paypal" value="<?php echo $paypal; ?>" size="40" />
            <?php } ?></td>
          </tr>
          </tbody>
          <tbody id="payment-bank" class="payment">
          <tr>
            <td><?php echo $entry_bank_name; ?></td>
            <td><input type="text" name="bank_name" value="<?php echo $bank_name; ?>" size="40" /></td>
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
            <td><span class="required">*</span> <?php echo $entry_bank_account_name; ?></td>
            <td><?php if ($error_bank_account_name) { ?>
              <input type="text" name="bank_account_name" value="<?php echo $bank_account_name; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_bank_account_name; ?></span>
            <?php } else { ?>
              <input type="text" name="bank_account_name" value="<?php echo $bank_account_name; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_bank_account_number; ?></td>
            <td><?php if ($error_bank_account_number) { ?>
              <input type="text" name="bank_account_number" value="<?php echo $bank_account_number; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_bank_account_number; ?></span>
            <?php } else { ?>
              <input type="text" name="bank_account_number" value="<?php echo $bank_account_number; ?>" size="40" />
            <?php } ?></td>
          </tr>
          </tbody>
        </table>
      </div>
      <?php if ($affiliate_id) { ?>
      <div id="tab-product">
        <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_product_id; ?></td>
            <td class="left"><?php echo $column_product; ?></td>
            <td class="left"><?php echo $column_date_added; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($products && $total_products > 0) { ?>
            <?php foreach ($products as $product) { ?>
              <tr>
                <td class="center"><?php echo $product['product_id']; ?></td>
                <td class="left"><?php echo $product['name']; ?></td>
                <td class="left"><?php echo $product['date_added']; ?></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="3"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
        </tbody>
        </table>
      </div>
      <div id="tab-transaction">
        <table class="form">
          <tbody>
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
          </tbody>
        </table>
        <div id="transaction"></div>
      </div>
      <?php } ?>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
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
$('#transaction .pagination').on('click', 'a', function() {
	$("#transaction").load(this.href);
	return false;
});

$("#transaction").load('index.php?route=sale/affiliate/transactions&token=<?php echo $token; ?>&affiliate_id=<?php echo $affiliate_id; ?>');

function addTransaction() {
	$.ajax({
		url: 'index.php?route=sale/affiliate/add_transaction&token=<?php echo $token; ?>&affiliate_id=<?php echo $affiliate_id; ?>',
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

function deleteTransaction(affiliate_transaction_id) {
	if (confirm('<?php echo addslashes($text_delete_transaction_confirm); ?>')) {
		$.ajax({
			url: 'index.php?route=sale/affiliate/delete_transaction&token=<?php echo $token; ?>&affiliate_id=<?php echo $affiliate_id; ?>',
			type: 'POST',
			data: {"affiliate_id":<?php echo (isset($affiliate_id) ? $affiliate_id : 0); ?>, "affiliate_transaction_id":affiliate_transaction_id},
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
$('.htabs a').tabs();
//--></script>

<?php echo $footer; ?>