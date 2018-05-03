<h2><?php echo $text_credit_card; ?></h2>
<div class="content" id="payment">
  <table class="form">
<?php if (!empty($existing_cards)) { ?>
  <tbody>
    <tr>
      <td><label><?php echo $entry_card; ?></label></td>
      <td>
        <input type="radio" name="new-existing" id="card-existing-yes" value="0" class="radio" checked="checked" />
        <label for="card-existing-yes"><?php echo $entry_card_existing; ?></label>
        <input type="radio" name="new-existing" id="card-existing-no" value="" class="radio" />
        <label for="card-existing-no"><?php echo $entry_card_new; ?></label>
      </td>
    </tr>
  </tbody>
  <tbody id="card-existing">
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="Token"><?php echo $entry_cc_choice; ?></label></td>
      <td>
        <select name="Token">
        <?php foreach ($existing_cards as $existing_card) { ?>
          <option value="<?php echo $existing_card['token']; ?>"><?php echo $text_card_type . ' ' . $existing_card['type']; ?>, <?php echo $text_card_digits . ' ' . $existing_card['digits']; ?>, <?php echo $text_card_expiry . ' ' . $existing_card['expiry']; ?></option>
        <?php } ?>
        </select>
      </td>
      <td><input type="button" value="<?php echo $button_delete_card; ?>" id="button-delete" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="input-cc-cvv2"><?php echo $entry_cc_cvv2; ?></label></td>
      <td><input type="text" name="cc_cvv2" value="" id="input-cc-cvv2" /></td>
    </tr>
  </tbody>
  <tbody style="display:none;" id="card-new">
<?php } else { ?>
  <tbody id="card-new">
<?php } ?>
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="input-cc-owner"><?php echo $entry_cc_owner; ?></label></td>
      <td><input type="text" name="cc_owner" value="" id="input-cc-owner" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="input-cc-type"><?php echo $entry_cc_type; ?></label></td>
      <td>
        <select name="cc_type" id="input-cc-type">
        <?php foreach ($cards as $card) { ?>
          <option value="<?php echo $card['value']; ?>"><?php echo $card['text']; ?></option>
        <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="input-cc-number"><?php echo $entry_cc_number; ?></label></td>
      <td><input type="text" name="cc_number" value="" id="input-cc-number" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="input-cc-expire-date"><?php echo $entry_cc_expire_date; ?></label></td>
      <td><select name="cc_expire_date_month" id="input-cc-expire-date">
        <?php foreach ($months as $month) { ?>
          <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
        <?php } ?>
      </select>
        /
      <select name="cc_expire_date_year">
        <?php foreach ($year_expire as $year) { ?>
          <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="input-cc-cvv2"><?php echo $entry_cc_cvv2; ?></label></td>
      <td><input type="text" name="cc_cvv2" value="" id="input-cc-cvv2" size="3" /></td>
    </tr>
<?php if ($sagepay_direct_card) { ?>
    <tr>
      <td><label for="input-cc-save"><?php echo $entry_card_save; ?></label></td>
      <td><input type="checkbox" name="CreateToken" value="1" id="input-cc-save" /></td>
    </tr>
<?php } ?>
  </tbody>
  </table>
</div>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="<?php echo $text_loading; ?>" class="button" />
  </div>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
<?php if (!empty($existing_cards)) { ?>
  $('#card-new input').prop('disabled', true);
  $('#card-new select').prop('disabled', true);
<?php } ?>
});
//--></script>

<script type="text/javascript"><!--
$('input[name=\'new-existing\']').on('change', function() {
  if (this.value === '0') {
    $('#card-existing').show();
    $('#card-new').hide();
    $('#card-new input').prop('disabled', true);
    $('#card-new select').prop('disabled', true);
    $('#card-existing select').prop('disabled', false);
    $('#card-existing input').prop('disabled', false);
  } else {
    $('#card-existing').hide();
    $('#card-new').show();
    $('#card-new input').prop('disabled', false);
    $('#card-new select').prop('disabled', false);
    $('#card-existing select').prop('disabled', true);
    $('#card-existing input').prop('disabled', true);
  }
});
//--></script>

<script type="text/javascript"><!--
$('body').on('click', '#button-confirm', function() {
  $.ajax({
    url: 'index.php?route=payment/sagepay_direct/send',
    type: 'post',
    data: $('#card-new :input[type=\'text\']:enabled, #card-new select:enabled, #card-new :input[type=\'checkbox\']:checked:enabled, #payment select:enabled, #card-existing :input:enabled'),
    dataType: 'json',
    cache: false,
    beforeSend: function() {
      $('#button-confirm').prop('disabled', true);
        $('#payment').before('<div class="attention"><img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /> <?php echo htmlspecialchars($text_wait, ENT_QUOTES, 'UTF-8'); ?></div>');
      },
      complete: function() {
        $('#button-confirm').prop('disabled', false);
        $('.attention').remove();
      },
      success: function(json) {
        if (json['ACSURL']) {
          $('#3dauth').remove();

          html = '<form action="' + json['ACSURL'] + '" method="post" id="3dauth">';
          html += '  <input type="hidden" name="MD" value="' + json['MD'] + '" />';
          html += '  <input type="hidden" name="PaReq" value="' + json['PaReq'] + '" />';
          html += '  <input type="hidden" name="TermUrl" value="' + json['TermUrl'] + '" />';
          html += '</form>';

          $('#payment').after(html);

          $('#3dauth').submit();
        }

        if (json['error']) {
          alert(json['error']);
        }

        if (json['redirect']) {
          location = json['redirect'];
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
  });
});
//--></script>

<script type="text/javascript"><!--
$('body').on('click', '#button-delete', function() {
  if (confirm('<?php echo $text_confirm_delete; ?>')) {
    $.ajax({
      url: 'index.php?route=payment/sagepay_direct/delete',
      type: 'post',
      data: $('#card-existing :input[name=\'Token\']'),
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
          $.ajax({
            url: 'index.php?route=checkout/confirm',
            dataType: 'html',
            success: function(html) {
              $('#confirm .checkout-content').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
          });
        }
      }
    });
  }
});
//--></script>