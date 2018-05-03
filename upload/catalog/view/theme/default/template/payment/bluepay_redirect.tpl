<h2><?php echo $text_credit_card; ?></h2>
<div class="content" id="payment">
  <table class="form">
<?php if (!empty($existing_cards)) { ?>
  <tbody>
    <tr>
      <td><label><?php echo $entry_card; ?></label></td>
      <td>
        <input type="radio" name="new-existing" id="card-existing-yes" value="existing" class="radio" checked="checked"/>
        <label for="card-existing-yes"><?php echo $entry_card_existing; ?></label>
        <input type="radio" name="new-existing" id="card-existing-no" value="new" class="radio" />
        <label for="card-existing-no"><?php echo $entry_card_new; ?></label>
      </td>
    </tr>
  </tbody>
  <tbody id="card-existing">
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="Token"><?php echo $entry_cc_choice; ?></label></td>
      <td>
        <select name="RRNO">
        <?php foreach ($existing_cards as $existing_card) { ?>
          <option value="<?php echo $existing_card['token']; ?>"><?php echo $text_card_type . ' ' . $existing_card['type']; ?>, <?php echo $text_card_digits . ' ' . $existing_card['digits']; ?>, <?php echo $text_card_expiry . ' ' . $existing_card['expiry']; ?></option>
        <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="input-cc-cvv2"><?php echo $entry_cc_cvv2; ?></label></td>
      <td><input type="text" name="CVCCVV2" value="" id="input-cc-cvv2" size="3" /></td>
    </tr>
  </tbody>
  <tbody style="display: none" id="card-new">
<?php } else { ?>
  <tbody id="card-new">
<?php } ?>
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="input-cc-number"><?php echo $entry_cc_number; ?></label></td>
      <td><input type="text" name="CC_NUM" value="" id="input-cc-number" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="input-cc-expire-date"><?php echo $entry_cc_expire_date; ?></label></td>
      <td><select name="CC_EXPIRES_MONTH" id="input-cc-expire-date">
        <?php foreach ($months as $month) { ?>
          <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
        <?php } ?>
      </select>
        /
      <select name="CC_EXPIRES_YEAR">
        <?php foreach ($year_expire as $year) { ?>
          <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td><label for="input-cc-cvv2"><?php echo $entry_cc_cvv2; ?></label></td>
      <td><input type="text" name="CVCCVV2" value="" id="input-cc-cvv2" size="3" /></td>
    </tr>
<?php if ($bluepay_redirect_card) { ?>
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
  if (this.value === 'existing') {
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
    url: 'index.php?route=payment/bluepay_redirect/send',
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
      if (json['error']) {
        alert(json['error']);
      }

      if (json['redirect']) {
        location = json['redirect'];
      }
    }
  });
});
//--></script>