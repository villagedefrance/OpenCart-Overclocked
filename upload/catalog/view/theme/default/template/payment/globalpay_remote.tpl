<h2><?php echo $text_credit_card; ?></h2>
<div class="content" id="payment">
  <table class="form">
  <tbody id="card-new">
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="input-cc-type"><?php echo $entry_cc_type; ?></label></td>
      <td>
        <select name="cc_type" id="input-cc-type">
        <?php foreach ($cards as $card) { ?>
          <option value="<?php echo $card['code']; ?>"><?php echo $card['text']; ?></option>
        <?php } ?>
        </select>
      </td>
    </tr>
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
    <tr>
      <td><label for="input-cc-issue"><?php echo $entry_cc_issue; ?><br /><span class="help"><?php echo $help_issue; ?></span></label></td>
      <td><input type="text" name="cc_issue" value="" id="input-cc-issue" /></td>
    </tr>
  </tbody>
  </table>
</div>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="<?php echo $text_loading; ?>" class="button" />
  </div>
</div>

<script type="text/javascript"><!--
$('body').on('click', '#button-confirm', function() {
  $.ajax({
    url: 'index.php?route=payment/globalpay_remote/send',
    type: 'post',
    data: $('#payment :input'),
    dataType: 'json',
    beforeSend: function() {
      $('#globalpay-message-error').remove();
      $('#button-confirm').prop('disabled', true);
      $('#payment').before('<div id="globalpay-message-wait" class="attention"><img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /> <?php echo htmlspecialchars($text_wait, ENT_QUOTES, 'UTF-8'); ?></div>');
    },
    complete: function() {
      $('#button-confirm').prop('disabled', false);
      $('.attention').remove();
    },
    success: function(json) {
      // if 3ds redirect instruction
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
        $('#payment').before('<div id="globalpay-message-error" class="warning"><img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /> ' + json['error'] + '</div>');
        $('#button-confirm').prop('disabled', false);
        $('#globalpay-message-wait').remove();
      }

      if (json['success']) {
        location = json['success'];
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});
//--></script>