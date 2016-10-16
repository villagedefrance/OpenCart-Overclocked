<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_refund; ?></h1>
      <div class="buttons">
        <?php if ($cancel) { ?>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
        <?php } ?>
      </div>
    </div>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_transaction_reference; ?></td>
          <td><?php echo $transaction_reference; ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_transaction_amount; ?></td>
          <td><?php echo $transaction_amount; ?></td>
        </tr>
        <tr>
          <td><label for="paypal-refund-amount"><?php echo $entry_refund_amount; ?></label></td>
          <td>
            <input type="text" name="amount" id="input-refund-amount" value="0.00" />
            <a class="button" onclick="refund();" id="button-refund"><?php echo $button_refund; ?></a>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function refund() {
  var amount = $('#input-refund-amount').val();

  $.ajax({
    type: 'POST',
    dataType: 'json',
    data: {
      'transaction_reference': '<?php echo $transaction_reference; ?>',
      'amount': amount
    },
    url: 'index.php?route=payment/pp_payflow_iframe/do_refund&token=<?php echo $token; ?>',
    beforeSend: function() {
      $('#button-refund').hide();
      $('#button-refund').after('<img src="view/image/loading.gif" alt="" class="loading" />');
    },
  })
  .fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
  .done(function(data) {
    if ('error' in data) {
      alert(data.error);
    } else {
      alert(data.success);
      $('#input-refund-amount').val('0.00');
    }
  })
  .always(function() {
    $('.loading').remove();
    $('#button-refund').show();
  });
}
//--></script>

<?php echo $footer; ?>