<h2><?php echo $text_payment_info; ?></h2>
<div class="success" id="worldpay-online-transaction-msg" style="display:none;"></div>
<table class="form">
  <tr>
    <td><?php echo $text_order_ref; ?></td>
    <td  colspan="2"><?php echo $worldpay_online_order['order_code']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_order_total; ?></td>
    <td><?php echo $worldpay_online_order['total_formatted']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_total_released; ?></td>
    <td id="worldpay-online-total-released"><?php echo $worldpay_online_order['total_released_formatted']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_refund_status; ?></td>
    <td id="worldpay-online-refund-status">
    <?php if ($worldpay_online_order['refund_status'] == 1) { ?>
      <span class="refund_text"><?php echo $text_yes; ?></span>
    <?php } else { ?>
      <span class="refund_text"><?php echo $text_no; ?></span>&nbsp;&nbsp;
      <?php if ($worldpay_online_order['total_released'] > 0) { ?>
        <input type="text" name="worldpay_online_refund_amount" id="worldpay-online-refund-amount" width="10" />
        <a class="button" id="btn-refund"><?php echo $button_refund; ?></a>&nbsp;<img src="view/image/loading.gif" alt="" id="img-loading-refund" style="display:none;" />
      <?php } ?>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_transactions; ?>:</td>
    <td>
      <table class="list" id="worldpay-online-transactions">
        <thead>
          <tr>
            <td class="left"><strong><?php echo $text_column_date_added; ?></strong></td>
            <td class="left"><strong><?php echo $text_column_type; ?></strong></td>
            <td class="left"><strong><?php echo $text_column_amount; ?></strong></td>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($worldpay_online_order['transactions'])) { ?>
          <?php foreach ($worldpay_online_order['transactions'] as $transaction) { ?>
            <tr>
              <td class="left"><?php echo $transaction['date_added']; ?></td>
              <td class="left"><?php echo $transaction['type']; ?></td>
              <td class="left"><?php echo $transaction['amount']; ?></td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="3"><?php echo $text_no_results; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </td>
  </tr>
</table>

<script type="text/javascript"><!--
$('#btn-refund').click(function() {
  if ($('#worldpay-online-refund-amount').val() != '' && confirm('<?php echo $text_confirm_refund; ?>')) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      data: {
        'order_id': <?php echo $order_id; ?>,
        'amount': $('#worldpay-online-refund-amount').val()
      },
      url: 'index.php?route=payment/worldpay_online/refund&token=<?php echo $token; ?>',
      beforeSend: function() {
        $('#btn-refund').hide();
        $('#worldpay-online-refund-amount').hide();
        $('#img-loading-refund').show();
        $('#worldpay-online-transaction-msg').hide();
      },
      success: function(data) {
        if (data.error == false) {
          html = '';
          html += '<tr>';
          html += '<td class="left">' + data.data.created + '</td>';
          html += '<td class="left">refund</td>';
          html += '<td class="left">' + data.data.amount + '</td>';
          html += '</tr>';

          $('#worldpay-online-transactions').append(html);
          $('#worldpay-online-total-released').text(data.data.total_released);

          if (data.data.refund_status == 1) {
            $('.refund_text').text('<?php echo $text_yes; ?>');
          } else {
            $('#btn_refund').show();
            $('#refund_amount').val(0.00).show();
          }

          if (data.msg != '') {
            $('#worldpay-online-transaction-msg').empty().html(data.msg).fadeIn();
          }
        }

        if (data.error == true) {
          alert(data.msg);
          $('#btn-refund').show();
        }

        $('#img-loading-refund').hide();
      }
    });
  }
});
//--></script>