<h2><?php echo $text_payment_info; ?></h2>
<div class="success" id="sagepay-server-transaction-msg" style="display:none;"></div>
<table class="form">
  <tr>
    <td><?php echo $text_order_ref; ?></td>
    <td><?php echo $sagepay_server_order['VendorTxCode']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_order_total; ?></td>
    <td><?php echo $sagepay_server_order['total_formatted']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_total_released; ?></td>
    <td id="sagepay-server-total-released"><?php echo $sagepay_server_order['total_released_formatted']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_release_status; ?></td>
    <td id="release-status">
      <?php if ($sagepay_server_order['release_status'] == 1) { ?>
        <span class="release-text"><?php echo $text_yes; ?></span>
      <?php } else { ?>
        <span class="release-text"><?php echo $text_no; ?></span>&nbsp;&nbsp;
        <?php if ($sagepay_server_order['void_status'] == 0) { ?>
          <input type="text" width="10" id="release-amount" value="<?php echo $sagepay_server_order['total']; ?>"/>
          <a class="button" id="button-release"><?php echo $button_release; ?></a>&nbsp;<img src="view/image/loading.gif" alt="" id="img-loading-release" style="display:none;" />
        <?php } ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_void_status; ?></td>
    <td id="void-status">
      <?php if ($sagepay_server_order['void_status'] == 1) { ?>
        <span class="void-text"><?php echo $text_yes; ?></span>
      <?php } elseif ($sagepay_server_order['void_status'] == 0 && $sagepay_server_order['release_status'] != 1 && $sagepay_server_order['rebate_status'] != 1) { ?>
        <span class="void-text"><?php echo $text_no; ?></span>&nbsp;&nbsp; <a class="button" id="button-void"><?php echo $button_void; ?></a>&nbsp;<img src="view/image/loading.gif" alt="" id="img-loading-void" style="display:none;" />
      <?php } else { ?>
        <span class="void-text"><?php echo $text_no; ?></span>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_rebate_status; ?></td>
    <td id="rebate-status">
     <?php if ($sagepay_server_order['rebate_status'] == 1) { ?>
        <span class="rebate-text"><?php echo $text_yes; ?></span>
      <?php } else { ?>
        <span class="rebate-text"><?php echo $text_no; ?></span>&nbsp;&nbsp;
      <?php if ($sagepay_server_order['total_released'] > 0 && $sagepay_server_order['void_status'] == 0) { ?>
        <input type="text" width="10" id="rebate-amount" />
        <a class="button" id="button-rebate"><?php echo $button_rebate; ?></a>&nbsp;<img src="view/image/loading.gif" alt="" id="img-loading-rebate" style="display:none;" />
      <?php } ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_transactions; ?>:</td>
    <td><table class="list" id="sagepay-server-transactions">
        <thead>
          <tr>
            <td class="left"><strong><?php echo $text_column_date_added; ?></strong></td>
            <td class="left"><strong><?php echo $text_column_type; ?></strong></td>
            <td class="left"><strong><?php echo $text_column_amount; ?></strong></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sagepay_server_order['transactions'] as $transaction) { ?>
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
      data: {'order_id': <?php echo $order_id; ?>},
      url: 'index.php?route=payment/sagepay_server/void&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#button-void').hide();
        $('#img-loading-void').show();
        $('#sagepay-server-transaction-msg').hide();
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
          $('#sagepay-server-transactions').append(html);
          $('#button-release').hide();
          $('#release-amount').hide();

          if (data.msg != '') {
            $('#sagepay-server-transaction-msg').empty().html(data.msg).fadeIn();
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

$("#button-release").click(function() {
  if (confirm('<?php echo $text_confirm_release; ?>')) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: {'order_id': <?php echo $order_id; ?>, 'amount': $('#release-amount').val()},
      url: 'index.php?route=payment/sagepay_server/release&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#button-release').hide();
        $('#release-amount').hide();
        $('#img-loading-release').show();
        $('#sagepay-server-transaction-msg').hide();
      },
      success: function(data) {
        if (data.error == false) {
          html = '';
          html += '<tr>';
          html += '<td class="left">' + data.data.date_added + '</td>';
          html += '<td class="left">payment</td>';
          html += '<td class="left">' + data.data.amount + '</td>';
          html += '</tr>';

          $('#sagepay-server-transactions').append(html);
          $('#sagepay-server-total-released').text(data.data.total);

          if (data.data.release_status == 1) {
            $('#button-void').hide();
            $('.release-text').text('<?php echo $text_yes; ?>');
          } else {
            $('#button-release').show();
            $('#release-amount').val(0.00);

            <?php if ($auto_settle == 2) { ?>
              $('#release-amount').show();
            <?php } ?>
          }

          if (data.msg != '') {
            $('#sagepay-server-transaction-msg').empty().html(data.msg).fadeIn();
          }

          $('#button-rebate').show();
          $('#rebate-amount').val(0.00).show();
        }

        if (data.error == true) {
          alert(data.msg);
          $('#button-release').show();
          $('#release-amount').show();
        }

        $('#img-loading-release').hide();
      }
    });
  }
});

$("#button-rebate").click(function() {
  if (confirm('<?php echo $text_confirm_rebate; ?>')) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: {'order_id': <?php echo $order_id; ?>, 'amount': $('#rebate-amount').val()},
      url: 'index.php?route=payment/sagepay_server/rebate&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#button-rebate').hide();
        $('#rebate-amount').hide();
        $('#img-loading-rebate').show();
        $('#sagepay-server-transaction-msg').hide();
      },
      success: function(data) {
        if (data.error == false) {
          html = '';
          html += '<tr>';
          html += '<td class="left">' + data.data.date_added + '</td>';
          html += '<td class="left">rebate</td>';
          html += '<td class="left">' + data.data.amount + '</td>';
          html += '</tr>';

          $('#sagepay-server-transactions').append(html);
          $('#sagepay-server-total-released').text(data.data.total_released);

          if (data.data.rebate_status == 1) {
            $('.rebate-text').text('<?php echo $text_yes; ?>');
          } else {
            $('#button-rebate').show();
            $('#rebate-amount').val(0.00).show();
          }

          if (data.msg != '') {
            $('#sagepay-server-transaction-msg').empty().html(data.msg).fadeIn();
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