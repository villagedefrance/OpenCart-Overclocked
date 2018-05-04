<h2><?php echo $text_payment_info; ?></h2>
<div class="success" id="bluepay-hosted-transaction-msg" style="display:none;"></div>
<table class="form">
  <tr>
    <td><?php echo $text_order_ref; ?></td>
    <td><?php echo $bluepay_hosted_order['transaction_id']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_order_total; ?></td>
    <td><?php echo $bluepay_hosted_order['total_formatted']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_total_released; ?></td>
    <td id="bluepay-hosted-total-released"><?php echo $bluepay_hosted_order['total_released_formatted']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_release_status; ?></td>
    <td id="release_status"><?php if ($bluepay_hosted_order['release_status'] == 1) { ?>
      <span class="release-text"><?php echo $text_yes; ?></span>
    <?php } else { ?>
      <span class="release-text"><?php echo $text_no; ?></span>&nbsp;&nbsp;
      <?php if ($bluepay_hosted_order['void_status'] == 0) { ?>
      <input type="text" width="10" id="release-amount" value="<?php echo $bluepay_hosted_order['total']; ?>" />
      <a class="button" id="button-release"><?php echo $button_release; ?></a> <img src="view/image/loading.gif" alt="" id="img-loading-release" style="display:none;" />
      <?php } ?>
    <?php } ?></td>
  </tr>
  <tr>
    <td><?php echo $text_void_status; ?></td>
    <td id="void_status"><?php if ($bluepay_hosted_order['void_status'] == 1) { ?>
      <span class="void-text"><?php echo $text_yes; ?></span>
    <?php } elseif ($bluepay_hosted_order['void_status'] == 0 && $bluepay_hosted_order['release_status'] == 1 && $bluepay_hosted_order['rebate_status'] != 1) { ?>
      <span class="void-text"><?php echo $text_no; ?></span>&nbsp;&nbsp; <a class="button" id="button-void"><?php echo $button_void; ?></a> <img src="view/image/loading.gif" alt="" id="img-loading-void" style="display:none;" />
    <?php } else { ?>
      <span class="void-text"><?php echo $text_no; ?></span>
    <?php } ?></td>
  </tr>
  <tr>
    <td><?php echo $text_rebate_status; ?></td>
    <td id="rebate_status"><?php if ($bluepay_hosted_order['rebate_status'] == 1) { ?>
      <span class="rebate-text"><?php echo $text_yes; ?></span>
      <?php } else { ?>
      <span class="rebate-text"><?php echo $text_no; ?></span>&nbsp;&nbsp;
      <?php if ($bluepay_hosted_order['total_released'] > 0 && $bluepay_hosted_order['void_status'] == 0) { ?>
      <input type="text" width="10" id="rebate-amount" />
      <a class="button" id="button-rebate"><?php echo $button_rebate; ?></a> <img src="view/image/loading.gif" alt="" id="img-loading-rebate" style="display:none;" />
      <?php } ?>
    <?php } ?></td>
  </tr>
  <tr>
    <td><?php echo $text_transactions; ?>:</td>
    <td>
      <table class="table table-striped table-bordered" id="bluepay-hosted-transactions">
        <thead>
          <tr>
            <td class="left"><strong><?php echo $text_column_date_added; ?></strong></td>
            <td class="left"><strong><?php echo $text_column_type; ?></strong></td>
            <td class="left"><strong><?php echo $text_column_amount; ?></strong></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($bluepay_hosted_order['transactions'] as $transaction) { ?>
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
      url: 'index.php?route=payment/bluepay_hosted/void&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#button-void').hide();
        $('#img-loading-void').show();
        $('#bluepay-hosted-transaction-msg').hide();
      },
      success: function(data) {
        if (data.error == false) {
          var html = '';
          html += '<tr>';
          html += '<td class="left">' + data.data.date_added + '</td>';
          html += '<td class="left">void</td>';
          html += '<td class="left">' + data.data.total + '</td>';
          html += '</tr>';

          $('.void-text').text('<?php echo $text_yes; ?>');
          $('.rebate-text').text('<?php echo $text_no; ?>');
          $('#bluepay-hosted-transactions').append(html);
          $('#button-release').hide();
          $('#release-amount').hide();
          $('#button-rebate').hide();
          $('#rebate-amount').hide();

          if (data.msg != '') {
            $('#bluepay-hosted-transaction-msg').empty().html(data.msg).fadeIn();
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
      url: 'index.php?route=payment/bluepay_hosted/release&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#button-release').hide();
        $('#release-amount').hide();
        $('#img-loading-release').show();
        $('#bluepay-hosted-transaction-msg').hide();
      },
      success: function(data) {
        if (data.error == false) {
          var html = '';
          html += '<tr>';
          html += '<td class="left">' + data.data.date_added + '</td>';
          html += '<td class="left">payment</td>';
          html += '<td class="left">' + data.data.amount + '</td>';
          html += '</tr>';

          $('#bluepay-hosted-transactions').append(html);
          $('#bluepay-hosted-total-released').text(data.data.total);

          if (data.data.release_status == 1) {
            $('.void-text').after('<a style="margin-left:10px;" id="button-void" class="button btn btn-primary"><?php echo htmlspecialchars($button_void, ENT_QUOTES, 'UTF-8'); ?></a>');
            $('.rebate-text').after('<input style="margin-left: 10px;" width="10" type="text" id="rebate-amount"><a style="margin-left:5px;" id="button-rebate" class="button"><?php echo htmlspecialchars($button_rebate, ENT_QUOTES, 'UTF-8'); ?></a>');
            $('.release-text').text('<?php echo $text_yes; ?>');
            $('#rebate-amount').val(0.00).show();
          } else {
            $('#button-release').show();
            $('#release-amount').val(0.00);
          }

          if (data.msg != '') {
            $('#bluepay-hosted-transaction-msg').empty().html(data.msg).fadeIn();
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
      url: 'index.php?route=payment/bluepay_hosted/rebate&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#button-rebate').hide();
        $('#rebate-amount').hide();
        $('#img-loading-rebate').show();
        $('#bluepay-hosted-transaction-msg').hide();
      },
      success: function(data) {
        if (data.error == false) {
          var html = '';
          html += '<tr>';
          html += '<td class="left">' + data.data.date_added + '</td>';
          html += '<td class="left">rebate</td>';
          html += '<td class="left">' + data.data.amount + '</td>';
          html += '</tr>';

          $('#bluepay-hosted-transactions').append(html);
          $('#bluepay-hosted-total-released').text(data.data.total_released);

          if (data.data.rebate_status == 1) {
            $('.rebate-text').text('<?php echo $text_yes; ?>');
            $('#button-void').hide();
          } else {
            $('#button-rebate').show();
            $('#rebate-amount').show();
          }

          if (data.msg != '' && data.msg != undefined) {
            $('#bluepay-hosted-transaction-msg').empty().html(data.msg).fadeIn();
          }
        }

        if (data.error == true) {
          alert(data.msg);
          $('#button-rebate').show();
          $('#rebate-amount').show();
        }

        $('#img-loading-rebate').hide();
      }
    });
  }
});
//--></script>