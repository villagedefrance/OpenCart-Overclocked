<h2><?php echo $text_credit_card; ?></h2>
<div class="content" id="payment">
  <table class="form">
<?php if (!empty($accepted_cards)) { ?>
    <tbody id="card-accepted">
    <tr>
      <td><strong><?php echo $text_card_accepted; ?></strong></td>
      <td>
        <ul>
          <?php if (in_array('mastercard', $accepted_cards)) { ?><li><?php echo $text_card_type_m; ?></li><?php } ?>
          <?php if (in_array('visa', $accepted_cards)) { ?><li><?php echo $text_card_type_v; ?></li><?php } ?>
          <?php if (in_array('diners', $accepted_cards)) { ?><li><?php echo $text_card_type_c; ?></li><?php } ?>
          <?php if (in_array('amex', $accepted_cards)) { ?><li><?php echo $text_card_type_a; ?></li><?php } ?>
          <?php if (in_array('maestro', $accepted_cards)) { ?><li><?php echo $text_card_type_ma; ?></li><?php } ?>
        </ul>
      </td>
    </tr>
    </tbody>
<?php } ?>
<?php if ($card_storage == 1 && count($stored_cards) > 0) { ?>
    <tbody id="card-existing">
    <tr>
      <td></td>
      <td>
        <?php $i = 0; ?>
        <?php foreach ($stored_cards as $card) { ?>
          <p><input type="radio" name="cc_choice" value="<?php echo $card['token']; ?>" class="stored_card" <?php echo $i == 0 ? 'checked="checked"' : ''; ?>/> <?php echo $card['card_type'] . ' xxxx ' . $card['digits'] . ', ' . $entry_cc_expire_date . ' ' . $card['expire_month'] . '/' . $card['expire_year']; ?></p>
          <?php $i++; ?>
        <?php } ?>
        <p><input type="radio" name="cc_choice" value="new" class="stored_card" /><?php echo $text_card_new; ?></p>
      </td>
    </tr>
    </tbody>
<?php } ?>
    <tbody id="card-info" style="display:none;">
      <tr>
        <td><span class="required">*</span>&nbsp;<label for="input-cc-name"><?php echo $entry_cc_name; ?></label></td>
        <td><input type="text" name="cc_name" value="" id="input-cc-name" /></td>
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
<?php if ($card_storage == 1) { ?>
      <tr>
        <td><label for="input-cc-save"><?php echo $entry_cc_save; ?></label></td>
        <td><input type="checkbox" name="cc_save" value="1" id="input-cc-save" /></td>
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
$('#button-confirm').on('click', function() {
  $.ajax({
    url: 'index.php?route=payment/firstdata_remote/send',
    type: 'POST',
    data: $('#payment_form').serialize(),
    dataType: 'json',
    beforeSend: function() {
      $('#firstdata-message-error').remove();
      $('#button-confirm').prop('disabled', true);
      $('#payment').before('<div id="firstdata-message-wait" class="attention"><img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /> <?php echo htmlspecialchars($text_wait, ENT_QUOTES, 'UTF-8'); ?></div>');
    },
    complete: function() {
      $('#button-confirm').prop('disabled', false);
      $('#firstdata-message-wait').remove();
    },
    success: function (json) {
      if (json['error']) {
        $('#payment').before('<div id="firstdata-message-error" class="warning"> ' + json['error'] + '</div>');
      }

      if (json['success']) {
        location = json['success'];
      }
    }
  });
});

$('.stored_card').on('change', function() {
  if ($(this).val() == 'new') {
    $('#card-info').slideDown();
  } else {
    $('#card-info').slideUp();
  }
});

$(document).ready(function() {
  <?php if ($card_storage == 0) { ?>
    $('#card-info').show();
  <?php } else { ?>
    var stored_cards = <?php echo count($stored_cards); ?>;
    if (stored_cards == 0) {
      $('#card-info').show();
    }
  <?php } ?>
});
//--></script>