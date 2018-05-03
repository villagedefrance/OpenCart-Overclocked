<h2><?php echo $text_credit_card; ?></h2>
<div class="content" id="payment">
  <table class="form">
<?php if (!empty($cards)) { ?>
  <tbody>
    <tr>
      <td><label><?php echo $entry_card; ?></label></td>
      <td>
        <input type="radio" name="CreateToken" id="card-existing-yes" value="0" class="radio" checked="checked" />
        <label for="card-existing-yes"><?php echo $entry_card_existing; ?></label>
        <input type="radio" name="CreateToken" id="card-existing-no" value="" class="radio" />
        <label for="card-existing-no"><?php echo $entry_card_new; ?></label>
      </td>
    </tr>
  </tbody>
  <tbody id="card-existing">
    <tr>
      <td><span class="required">*</span>&nbsp;<label for="Token"><?php echo $entry_cc_choice; ?></label></td>
      <td>
        <select name="Token">
        <?php foreach ($cards as $card) { ?>
          <option value="<?php echo $card['token']; ?>"><?php echo $text_card_type . ' ' . $card['type']; ?>, <?php echo $text_card_digits . ' ' . $card['digits']; ?>, <?php echo $text_card_expiry . ' ' . $card['expiry']; ?></option>
        <?php } ?>
        </select>
      </td>
      <td><input type="button" value="<?php echo $button_delete_card; ?>" id="button-delete" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger" /></td>
    </tr>
  </tbody>
  <tbody style="display:none;" id="card-save">
    <tr>
      <td><label for="input-cc-save"><?php echo $entry_card_save; ?></label></td>
      <td><input type="checkbox" name="CreateToken" value="1" id="input-cc-save" disabled /></td>
    </tr>
  </tbody>
<?php } elseif ($sagepay_server_card) { ?>
  <tbody>
    <tr>
      <td><label><?php echo $entry_card; ?></label></td>
      <td>
        <input type="radio" name="CreateToken" id="card-existing-no" value="" class="radio" checked="checked" />
        <label for="card-existing-no"><?php echo $entry_card_new; ?></label>
      </td>
    </tr>
  </tbody>
  <tbody id="card-save">
    <tr>
      <td><label for="input-cc-save"><?php echo $entry_card_save; ?></label></td>
      <td><input type="checkbox" name="CreateToken" value="1" id="input-cc-save" /></td>
    </tr>
  </tbody>
<?php } ?>
  </table>
</div>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="<?php echo $text_loading; ?>" class="button" />
  </div>
</div>

<script type="text/javascript"><!--
$('input[name=\'CreateToken\']').on('change', function() {
  if (this.value === '0') {
    $('#card-existing').show();
    $('#card-save').hide();
    $('#card-existing select').prop('disabled', false);
    $('#card-save :input').prop('disabled', true);
  } else {
    $('#card-existing').hide();
    $('#card-save').show();
    $('#card-existing select').prop('disabled', true);
    $('#card-save :input').prop('disabled', false);
  }
});
//--></script>

<script type="text/javascript"><!--
$('body').on('click', '#button-confirm', function() {
  $.ajax({
    url: 'index.php?route=payment/sagepay_server/send',
    type: 'post',
    data: $('#card-existing :input:checked, #card-save :input:enabled, #payment select:enabled'),
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
      if (json['redirect']) {
        html = '<form action="' + json['redirect'] + '" method="post" id="redirect">';
        html += '  <input type="hidden" name="Status" value="' + json['Status'] + '" />';
        html += '  <input type="hidden" name="StatusDetail" value="' + json['StatusDetail'] + '" />';
        html += '</form>';

        $('#payment').after(html);

        $('#redirect').submit();
      }

      if (json['error']) {
        $('#payment').before('<div id="sagepay_message_error" class="warning"> ' + json['error'] + '</div>');
      }
    }
  });
});
//--></script>

<script type="text/javascript"><!--
$('body').on('click', '#button-delete', function() {
  if (confirm('<?php echo $text_confirm_delete; ?>')) {
    $.ajax({
      url: 'index.php?route=payment/sagepay_server/delete',
      type: 'post',
      data: $('#card-existing :input[name=\'Token\']'),
      dataType: 'json',
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