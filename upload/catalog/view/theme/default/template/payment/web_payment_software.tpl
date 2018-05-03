<h2><?php echo $text_credit_card; ?></h2>
<div class="content" id="payment">
  <table class="form">
    <tr>
      <td><label for="input-cc-owner"><?php echo $entry_cc_owner; ?></label></td>
      <td><input type="text" name="cc_owner" id="input-cc-owner" value="" /></td>
    </tr>
    <tr>
      <td><label for="input-cc-number"><?php echo $entry_cc_number; ?></label></td>
      <td><input type="text" name="cc_number" id="input-cc-number" value="" /></td>
    </tr>
    <tr>
      <td><label for="input-cc-expire-date"><?php echo $entry_cc_expire_date; ?></label></td>
      <td>
        <select name="cc_expire_date_month" id="input-cc-expire-date">
          <?php foreach ($months as $month) { ?>
            <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
          <?php } ?>
        </select>
        /
        <select name="cc_expire_date_year">
          <?php foreach ($year_expire as $year) { ?>
            <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="input-cc-cvv2"><?php echo $entry_cc_cvv2; ?></label></td>
      <td><input type="text" name="cc_cvv2" id="input-cc-cvv2" value="" size="3" /></td>
    </tr>
  </table>
</div>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" />
  </div>
</div>

<script type="text/javascript"><!--
$('body').on('click', '#button-confirm', function() {
  $.ajax({
    url: 'index.php?route=payment/web_payment_software/send',
    type: 'post',
    data: $('#payment :input'),
    dataType: 'json',
    cache: false,
    beforeSend: function() {
      $('#button-confirm').prop('disabled', true);
      $('#payment').before('<div class="attention"><img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
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