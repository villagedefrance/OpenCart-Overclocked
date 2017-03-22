<h2><?php echo $text_payment_info; ?></h2>
<div class="success" id="globalpay-transaction-msg" style="display:none;"></div>
<table class="form">
  <tr>
    <td><?php echo $text_order_ref; ?></td>
    <td><?php echo $globalpay_order['order_ref']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_order_total; ?></td>
    <td><?php echo $globalpay_order['total_formatted']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_total_captured; ?></td>
    <td id="globalpay-total-captured"><?php echo $globalpay_order['total_captured_formatted']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_capture_status; ?></td>
    <td id="capture-status">
      <?php if ($globalpay_order['capture_status'] == 1) { ?>
        <span class="capture-text"><?php echo $text_yes; ?></span>
      <?php } else { ?>
        <span class="capture-text"><?php echo $text_no; ?></span>&nbsp;&nbsp;
        <?php if ($globalpay_order['void_status'] == 0) { ?>
          <input type="text" id="capture-amount" value="<?php echo $globalpay_order['total']; ?>" size="10" />
          <a class="button" id="button-capture"><?php echo $button_capture; ?></a>&nbsp;<img src="view/image/loading.gif" alt="" id="img-loading-capture" style="display:none;" />
        <?php } ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_void_status; ?></td>
    <td id="void-status">
      <?php if ($globalpay_order['void_status'] == 1) { ?>
        <span class="void-text"><?php echo $text_yes; ?></span>
      <?php } else { ?>
        <span class="void-text"><?php echo $text_no; ?></span>&nbsp;&nbsp;
        <a class="button" id="button-void"><?php echo $button_void; ?></a>&nbsp;<img src="view/image/loading.gif" alt="" id="img-loading-void" style="display:none;" />
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_rebate_status; ?></td>
    <td id="rebate-status">
      <?php if ($globalpay_order['rebate_status'] == 1) { ?>
        <span class="rebate_text"><?php echo $text_yes; ?></span>
      <?php } else { ?>
        <span class="rebate_text"><?php echo $text_no; ?></span>&nbsp;&nbsp;
        <?php if ($globalpay_order['total_captured'] > 0 && $globalpay_order['void_status'] == 0) { ?>
          <input type="text" id="rebate-amount" size="10" />
          <a class="button" id="button-rebate"><?php echo $button_rebate; ?></a>&nbsp;<img src="view/image/loading.gif" alt="" id="img-loading-rebate" style="display:none;" />
        <?php } ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_transactions; ?>:</td>
    <td>
      <table class="list" id="globalpay-transactions">
        <thead>
          <tr>
            <td class="left"><strong><?php echo $text_column_date_added; ?></strong></td>
            <td class="left"><strong><?php echo $text_column_type; ?></strong></td>
            <td class="left"><strong><?php echo $text_column_amount; ?></strong></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($globalpay_order['transactions'] as $transaction) { ?>
            <tr>
              <td class="left"><?php echo $transaction['date_added']; ?></td>
              <td class="left"><?php echo $transaction['type']; ?></td>
              <td class="left"><?php echo $transaction['amount']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </td>
  </tr>
</table>

<script type="text/javascript"><!--
$("#button-void").click(function() {
  if (confirm('<?php echo $text_confirm_void; ?>')) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: {'order_id': '<?php echo $order_id; ?>' },
      url: 'index.php?route=payment/globalpay/void&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#button-void').hide();
        $('#img-loading-void').show();
        $('#globalpay-transaction-msg').hide();
      },
      success: function(data) {
        if (data.error == false) {
          html = '';
          html += '<tr>';
          html += '<td class="left">' + data.data.date_added + '</td>';
          html += '<td class="left">void</td>';
          html += '<td class="left">0.00</td>';
          html += '</tr>';

          $('.void-text').text('<?php echo $text_yes; ?>');
          $('#globalpay-transactions').append(html);
          $('#button-capture').hide();
          $('#capture-amount').hide();

          if (data.msg != '') {
            $('#globalpay-transaction-msg').empty().html(data.msg).fadeIn();
          }
        }

        if (data.error == true) {
          alert(data.msg);
          $('#button-void').show();
        }

        $('#img-loading-void').hide();
      }
    });
  }
});

$("#button-capture").click(function() {
  if (confirm('<?php echo $text_confirm_capture; ?>')) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: {'order_id' : '<?php echo $order_id; ?>', 'amount' : $('#capture-amount').val() },
      url: 'index.php?route=payment/globalpay/capture&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#button-capture').hide();
        $('#capture-amount').hide();
        $('#img-loading-capture').show();
        $('#globalpay-transaction-msg').hide();
      },
      success: function(data) {
        if (data.error == false) {
          html = '';
          html += '<tr>';
          html += '<td class="left">' + data.data.date_added + '</td>';
          html += '<td class="left">payment</td>';
          html += '<td class="left">' + data.data.amount + '</td>';
          html += '</tr>';

          $('#globalpay-transactions').append(html);
          $('#globalpay-total-captured').text(data.data.total_formatted);

          if (data.data.capture_status == 1) {
            $('#button-void').hide();
            $('.capture-text').text('<?php echo $text_yes; ?>');
          } else {
            $('#button-capture').show();
            $('#capture-amount').val('0.00');

            <?php if ($auto_settle == 2) { ?>
              $('#capture-amount').show();
            <?php } ?>
          }

          if (data.msg != '') {
            $('#globalpay-transaction-msg').empty().html(data.msg).fadeIn();
          }

          $('#button-rebate').show();
          $('#rebate-amount').val(0.00).show();
        }

        if (data.error == true) {
          alert(data.msg);
          $('#button-capture').show();
          $('#capture-amount').show();
        }

        $('#img-loading-capture').hide();
      }
    });
  }
});

$("#button-rebate").click(function() {
  if (confirm('<?php echo $text_confirm_rebate; ?>')) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: {'order_id': '<?php echo $order_id; ?>', 'amount' : $('#rebate-amount').val() },
      url: 'index.php?route=payment/globalpay/rebate&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#button-rebate').hide();
        $('#rebate-amount').hide();
        $('#img-loading-rebate').show();
        $('#globalpay-transaction-msg').hide();
      },
      success: function(data) {
        if (data.error == false) {
          html = '';
          html += '<tr>';
          html += '<td class="left">' + data.data.date_added + '</td>';
          html += '<td class="left">rebate</td>';
          html += '<td class="left">' + data.data.amount + '</td>';
          html += '</tr>';

          $('#globalpay-transactions').append(html);
          $('#globalpay-total-captured').text(data.data.total_captured);

          if (data.data.rebate_status == 1) {
            $('.rebate_text').text('<?php echo $text_yes; ?>');
          } else {
            $('#button-rebate').show();
            $('#rebate-amount').val(0.00).show();
          }

          if (data.msg != '') {
            $('#globalpay-transaction-msg').empty().html(data.msg).fadeIn();
          }
        }

        if (data.error == true) {
          alert(data.msg);
          $('#button-rebate').show();
        }

        $('#img-loading-rebate').hide();
      }
    });
  }
});
//--></script>