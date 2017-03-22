<h2><?php echo $text_payment_info; ?></h2>
<div class="success" id="g2apay-transaction-msg" style="display:none;"></div>
<table class="form">
  <tr>
    <td><?php echo $text_order_ref; ?></td>
    <td><?php echo $g2apay_order['g2apay_transaction_id']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_order_total; ?></td>
    <td><?php echo $g2apay_order['total_formatted']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_total_released; ?></td>
    <td id="g2apay-total-released"><?php echo $g2apay_order['total_released_formatted']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_refund_status; ?></td>
    <td id="refund_status">
      <?php if ($g2apay_order['refund_status'] == 1) { ?>
        <span class="refund_text"><?php echo $text_yes; ?></span>
      <?php } else { ?>
        <span class="refund_text"><?php echo $text_no; ?></span>&nbsp;&nbsp;
        <?php if ($g2apay_order['total_released'] > 0) { ?>
          <input type="text" width="10" id="g2apay-refund-amount" />
          <a class="button" id="btn-refund"><?php echo $btn_refund; ?></a>&nbsp;<img src="view/image/loading.gif" alt="" id="img-loading-refund" style="display:none;" />
        <?php } ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_transactions; ?>:</td>
    <td>
      <table class="list" id="g2apay-transactions">
      <thead>
        <tr>
        <td class="left"><strong><?php echo $text_column_date_added; ?></strong></td>
        <td class="left"><strong><?php echo $text_column_type; ?></strong></td>
        <td class="left"><strong><?php echo $text_column_amount; ?></strong></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($g2apay_order['transactions'] as $transaction) { ?>
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
$('#btn-refund').click(function() {
  if ($('#g2apay-refund-amount').val() != '' && confirm('<?php echo $text_confirm_refund; ?>')) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: {
        'order_id': <?php echo $order_id; ?>,
        'amount': $('#g2apay-refund-amount').val()
      },
      url: 'index.php?route=payment/g2apay/refund&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#btn-refund').hide();
        $('#g2apay-refund-amount').hide();
        $('#img-loading-refund').show();
        $('#g2apay-transaction-msg').hide();
      },
      success: function(data) {
        if (data.error == false) {
          html = '';
          html += '<tr>';
          html += '<td class="left">' + data.data.date_added + '</td>';
          html += '<td class="left">refund</td>';
          html += '<td class="left">' + data.data.amount + '</td>';
          html += '</tr>';

          $('#g2apay-transactions').append(html);
          $('#g2apay-total-released').text(data.data.total_released);

          if (data.data.refund_status == 1) {
            $('.refund_text').text('<?php echo $text_yes; ?>');
          } else {
            $('#btn-refund').show();
            $('#g2apay-refund-amount').val(0.00).show();
          }

          if (data.msg != '') {
            $('#g2apay-transaction-msg').empty().html(data.msg).fadeIn();
          }
        }

        if (data.error == true) {
          alert(data.msg);
          $('#btn-refund').show();
          $('#g2apay-refund-amount').show();
        }

        $('#img-loading-refund').hide();
      }
    });
  }
});
//--></script>