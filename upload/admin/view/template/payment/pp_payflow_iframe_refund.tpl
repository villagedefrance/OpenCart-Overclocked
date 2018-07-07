<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if (!empty($error)) { ?>
    <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <?php if (!empty($attention)) { ?>
    <div class="attention"><?php echo $attention; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <?php if ($cancel) { ?>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
        <?php } ?>
      </div>
    </div>
    <div class="content">
      <table class="form">
      <tbody>
        <tr>
          <td><?php echo $entry_transaction_reference; ?></td>
          <td><?php echo $transaction_reference; ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_transaction_amount; ?></td>
          <td><?php echo $transaction_amount; ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_transaction_already_refunded; ?></td>
          <td><?php echo $transaction_already_refunded; ?></td>
        </tr>
        <tr>
          <td><label for="input-refund-amount"><?php echo $entry_refund_amount; ?></label></td>
          <td>
            <input type="text" name="refund_amount" id="input-refund-amount" value="0.00" />
          </td>
        </tr>
      </tbody>
      </table>
      <a class="button ripple" id="button-refund" onclick="doRefund()" style="float:right;"><?php echo $button_refund; ?></a>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function doRefund() {
  var amt = parseFloat($('#input-refund-amount').val());

  if (isNaN(amt) || amt <= 0) {
    alert('<?php echo addslashes($error_positive_amount); ?>');
  } else {
    $.ajax({
      url: 'index.php?route=payment/pp_payflow_iframe/do_refund&token=<?php echo $token; ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        'order_id': <?php echo $order_id; ?>,
        'transaction_reference': '<?php echo addslashes($transaction_reference); ?>',
        'amount': amt
      },
      beforeSend: function() {
        $('.success, .warning, .attention').remove();
        $('#button-refund').hide();
        $('#button-refund').after('<img src="view/image/loading.gif" alt="Loading..." class="loading" id="img-loading-refund" style="float:right;" />');
      },
    })
    .fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
    .done(function(json) {
      if ('error' in json) {
        $('.box').before('<div class="warning" style="display:none;">' + json['error'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
        $('.warning').fadeIn('slow');
      }

      if ('success' in json) {
        $('.box').before('<div class="success" style="display:none;">' + json['success'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
        $('.success').fadeIn('slow').delay(250);

        window.location.href = '<?php echo addslashes(html_entity_decode($cancel, ENT_QUOTES, 'UTF-8')); ?>';
      }
    })
    .always(function() {
      $('.loading').remove();
      $('#button-refund').show();
    });
  }
}
//--></script>

<?php echo $footer; ?>
