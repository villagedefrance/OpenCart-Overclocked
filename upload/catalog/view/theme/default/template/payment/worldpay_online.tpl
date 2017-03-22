<h2><?php echo $text_credit_card; ?></h2>
<div class="content" id="payment">
<?php if (!empty($existing_cards)) { ?>
  <table class="form" id="choose-card">
    <tbody>
      <tr>
        <td><label><?php echo $entry_card; ?></label></td>
        <td>
          <input type="radio" name="existing-card" id="card-existing-yes" value="1" class="radio" checked="checked" />
          <label for="card-existing-yes"><?php echo $entry_card_existing; ?></label>
          <input type="radio" name="existing-card" id="card-existing-no" value="0" class="radio" />
          <label for="card-existing-no"><?php echo $entry_card_new; ?></label>
        </td>
      </tr>
    </tbody>
  </table>
  <form id="payment-existing-form" action="<?php echo $form_submit; ?>" method="post" enctype="multipart/form-data">
  <table class="form" id="card-existing">
    <tbody>
      <tr>
        <td><span class="required">*</span>&nbsp;<label for="token"><?php echo $entry_cc_choice; ?></label></td>
        <td>
          <select name="token" data-worldpay-online="token">
          <?php foreach ($existing_cards as $existing_card) { ?>
            <option value="<?php echo $existing_card['token']; ?>"><?php echo $text_card_type . ' ' . $existing_card['type']; ?>, <?php echo $text_card_digits . ' ' . $existing_card['digits']; ?>, <?php echo $text_card_expiry . ' ' . $existing_card['expiry']; ?></option>
          <?php } ?>
          </select>
        </td>
        <td><input type="button" value="<?php echo $button_delete_card; ?>" id="button-delete" data-loading-text="<?php echo $text_loading; ?>" class="button" /></td>
      </tr>
      <tr>
        <td><span class="required">*</span>&nbsp;<label for="input-cc-cvc"><?php echo $entry_cc_cvc; ?></label></td>
        <td><input type="text" name="cc_cvc" id="input-cc-cvc" value="" size="4" /></td>
      </tr>
    </tbody>
  </table>
  <div class="buttons">
    <div class="right">
      <input type="submit" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="<?php echo $text_loading; ?>" class="button" />
    </div>
  </div>
  </form>
  <form style="display:none;" id="payment-new-form" action="<?php echo $form_submit; ?>" method="post" enctype="multipart/form-data">
  <table class="form" id="card-new">
    <tbody>
<?php } else { ?>
  <form id="payment-new-form" action="<?php echo $form_submit; ?>" method="post" enctype="multipart/form-data">
  <table class="form" id="card-new">
    <tbody>
<?php } ?>
      <tr>
        <td><div id="paymentDetailsHere" style="margin-left:3%;"></div></td>
      </tr>
<?php if ($worldpay_online_card) { ?>
      <tr>
        <td><label for="input-cc-save"><?php echo $entry_card_save; ?></label></td>
        <td><input type="checkbox" name="save-card" id="input-cc-save" value="1" /></td>
      </tr>
<?php } ?>
    </tbody>
  </table>
  <div class="buttons">
    <div class="right">
      <input type="submit" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="<?php echo $text_loading; ?>" class="button" />
    </div>
  </div>
  </form>
</div>
<div id="payment-errors">
</div>

<script type="text/javascript"><!--
// Load Worldpay.js and run script functions
$.getScript("<?php echo $worldpay_online_script; ?>", function(data, textStatus, jqxhr) {
  Worldpay.setClientKey("<?php echo $worldpay_online_client_key; ?>");

  // disable new card form if existing cards
<?php if (!empty($existing_cards)) { ?>
  $('#payment-new-form :input').prop('disabled', true);
<?php } ?>

  // Set if token is reusable, remove first value when Worldpay update
  Worldpay.reusable = true;
<?php if (isset($recurring_products)) { ?>
  Worldpay.reusable = true;
<?php } else { ?>
  $('input[name=\'save-card\']').on('change', function() {
    if ($(this).is(':checked')) {
      Worldpay.reusable = true;
    } else {
      Worldpay.reusable = false;
    }
  });
<?php } ?>

  Worldpay.templateSaveButton = false;
  Worldpay.useTemplate('payment-new-form', 'paymentDetailsHere', 'inline', function(obj) {
    var _el = document.createElement('input');
    _el.value = obj.token;
    _el.type = 'hidden';
    _el.name = 'token';
    document.getElementById('payment-new-form').appendChild(_el);
    document.getElementById('payment-new-form').submit();
  });

  // Submit form
  $('input[type=\'submit\']').on('click', function() {
    var existing = $('input[name=\'existing-card\']:checked').val();
    if (existing === '1') {
      var form = document.getElementById('payment-existing-form');
      Worldpay.useForm(form, function(status, response) {
        if (response.error || status != 200) {
          Worldpay.handleError(form, document.getElementById('payment-errors'), response.error);
        } else {
          form.submit();
        }
      }, true);
    } else {
      Worldpay.submitTemplateForm();
    }
  });
});

// Delete a card
$('#button-delete').on('click', function() {
  var token = $('select[name=\'token\'] option:selected');

  if (confirm('<?php echo $text_confirm_delete; ?>\n' + token.text())) {
    $.ajax({
      url: 'index.php?route=payment/worldpay_online/deleteCard',
      type: 'post',
      data: {token: token.val()},
      dataType: 'json',
      beforeSend: function() {
        $('#button-delete').prop('disabled', true);
        $('#payment').before('<div class="attention"><img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /> <?php echo htmlspecialchars($text_wait, ENT_QUOTES, 'UTF-8'); ?></div>');
      },
      complete: function() {
        $('#button-delete').prop('disabled', false);
        $('.attention').remove();
      },
      success: function(json) {
        if (json['error']) {
          alert(json['error']);
        }

        if (json['success']) {
          alert(json['success']);

          if (json['existing_cards']) {
            token.remove();
          } else {
            $('input[name=\'existing-card\'][value=0]').click();
            $('#choose-card').remove();
            $('#payment-existing-form').remove();
          }
        }
      }
    });
  }
});

// Enable or Disable forms based on exiting or new card option
$('input[name=\'existing-card\']').on('change', function() {
  if (this.value === '1') {
    $('#payment-existing-form').show();
    $('#payment-new-form').hide();
    $('#payment-new-form :input').prop('disabled', true);
    $('#payment-existing-form :input').prop('disabled', false);
  } else {
    $('#payment-existing-form').hide();
    $('#payment-new-form').show();
    $('#payment-new-form :input').prop('disabled', false);
    $('#payment-existing-form :input').prop('disabled', true);
  }
});
//--></script>