<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a id="button-edit" class="button ripple" style="display:none;"><?php echo $button_edit_search; ?></a>
        <a id="button-search" class="button-save ripple"><?php echo $button_search; ?></a>
      </div>
    </div>
    <div class="content">
      <form id="form">
        <div id="search-input">
        <h2><?php echo $text_date_search; ?></h2>
        <table class="form">
          <tr>
            <td><label for="input-date-start"><?php echo $entry_date; ?></label></td>
            <td>
              <input type="text" id="input-date-start" name="date_start" value="<?php echo $date_start; ?>" size="12" class="date" placeholder="<?php echo $entry_date_start; ?>" />
              &nbsp;&nbsp;<?php echo $entry_date_to; ?>&nbsp;&nbsp;<input type="text" name="date_end" size="12" class="date" placeholder="<?php echo $entry_date_end; ?>" />
            </td>
          </tr>
        </table>
        <h2><?php echo $entry_transaction; ?></h2>
        <table class="form">
          <tr>
            <td><label for="input-transaction-type"><?php echo $entry_transaction; ?></label></td>
            <td>
              <?php echo $entry_transaction_type; ?>:
              <select name="transaction_class" id="input-transaction-type">
                <option value="All"><?php echo $entry_trans_all; ?></option>
                <option value="Sent"><?php echo $entry_trans_sent; ?></option>
                <option value="Received"><?php echo $entry_trans_received; ?></option>
                <option value="MassPay"><?php echo $entry_trans_masspay; ?></option>
                <option value="MoneyRequest"><?php echo $entry_trans_money_req; ?></option>
                <option value="FundsAdded"><?php echo $entry_trans_funds_add; ?></option>
                <option value="FundsWithdrawn"><?php echo $entry_trans_funds_with; ?></option>
                <option value="Referral"><?php echo $entry_trans_referral; ?></option>
                <option value="Fee"><?php echo $entry_trans_fee; ?></option>
                <option value="Subscription"><?php echo $entry_trans_subscription; ?></option>
                <option value="Dividend"><?php echo $entry_trans_dividend; ?></option>
                <option value="Billpay"><?php echo $entry_trans_billpay; ?></option>
                <option value="Refund"><?php echo $entry_trans_refund; ?></option>
                <option value="CurrencyConversions"><?php echo $entry_trans_conv; ?></option>
                <option value="BalanceTransfer"><?php echo $entry_trans_bal_trans; ?></option>
                <option value="Reversal"><?php echo $entry_trans_reversal; ?></option>
                <option value="Shipping"><?php echo $entry_trans_shipping; ?></option>
                <option value="BalanceAffecting"><?php echo $entry_trans_bal_affect; ?></option>
                <option value="ECheck"><?php echo $entry_trans_echeque; ?></option>
              </select>
              &nbsp;&nbsp;
              <?php echo $entry_transaction_status; ?>:
              <select name="status">
                <option value=""><?php echo $entry_status_all; ?></option>
                <option value="Pending"><?php echo $entry_status_pending; ?></option>
                <option value="Processing"><?php echo $entry_status_processing; ?></option>
                <option value="Success"><?php echo $entry_status_success; ?></option>
                <option value="Denied"><?php echo $entry_status_denied; ?></option>
                <option value="Reversed"><?php echo $entry_status_reversed; ?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="input-buyer-email"><?php echo $entry_email; ?></label></td>
            <td>
              <input maxlength="127" type="text" name="buyer_email" id="input-buyer-email" value="" placeholder="<?php echo $entry_email_buyer; ?>" />&nbsp;&nbsp;
              <input maxlength="127" type="text" name="merchant_email" value="" placeholder="<?php echo $entry_email_merchant; ?>" />
            </td>
          </tr>
          <tr>
            <td><label for="input-receipt-id"><?php echo $entry_receipt; ?></label></td>
            <td><input type="text" name="receipt_id" id="input-receipt-id" value="" maxlength="100" /></td>
          </tr>
          <tr>
            <td><label for="input-transaction-id"><?php echo $entry_transaction_id; ?></label></td>
            <td><input type="text" name="transaction_id" value="" id="input-transaction-id" maxlength="19" /></td>
          </tr>
          <tr>
            <td><label for="input-invoice-no"><?php echo $entry_invoice_no; ?></label></td>
            <td><input type="text" name="invoice_number" id="input-invoice-no" value="" maxlength="127" /></td>
          </tr>
          <tr>
            <td><label for="input-auction"><?php echo $entry_auction; ?></label></td>
            <td><input type="text" name="auction_item_number" id="input-auction" value="" /></td>
          </tr>
          <tr>
            <td><label for="input-amount"><?php echo $entry_amount; ?></label></td>
            <td>
              <input type="text" name="amount" id="input-amount" value="" size="6" />&nbsp;
              <select name="currency_code">
                <?php foreach ($currency_codes as $code) { ?>
                  <option <?php if ($code == $default_currency) { echo 'selected'; } ?>><?php echo $code; ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="input-recurring-id"><?php echo $entry_recurring_id; ?></label></td>
            <td><input type="text" name="recurring_id" id="input-recurring-id" value="" /></td>
          </tr>
        </table>
        <h2><?php echo $text_buyer_info; ?></h2>
        <table class="form">
          <tr>
            <td><label for="input-name-salutation"><?php echo $text_name; ?></label></td>
            <td>
              <input type="text" name="name_salutation" id="input-name-salutation" value="" placeholder="<?php echo $entry_salutation; ?>" />&nbsp;&nbsp;
              <input type="text" name="name_first" value="" placeholder="<?php echo $entry_firstname; ?>" />&nbsp;&nbsp;
              <input type="text" name="name_middle" value="" placeholder="<?php echo $entry_middlename; ?>" />&nbsp;&nbsp;
              <input type="text" name="name_last" value="" placeholder="<?php echo $entry_lastname; ?>" />
              <input type="text" name="name_suffix" value="" placeholder="<?php echo $entry_suffix; ?>" />
            </td>
          </tr>
        </table>
      </div>
    </form>
    <div id="search-box" style="display:none;">
      <div id="searching"><img src="view/image/loading.gif" alt="" />&nbsp;<?php echo $text_searching; ?></div>
      <div id="results"><table id="search-results" style="display:none;" class="list" ></table></div>
    </div>
  </div>
</div>

<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.min.js"></script>

<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
//--></script>

<script type="text/javascript"><!--
$('#button-search').on('click', function() {
  $.ajax({
    url: 'index.php?route=payment/pp_express/do_search&token=<?php echo $token; ?>',
    type: 'POST',
    dataType: 'json',
    data: $('#form').serialize(),
    beforeSend: function() {
      $('.success, .warning, .attention').remove();
      $('#search-input').hide();
      $('#button-search').hide();
      $('#button-edit').show();
      $('#search-box').show();
      $('#searching').show();
    },
  })
  .fail(function(jqXHR, textStatus, errorThrown) { alert('Status: ' + textStatus + '\r\nError: ' + errorThrown); })
  .done(function(json) {
    if ('error' in json) {
      $('.box').before('<div class="warning" style="display:none;">' + json['error'] + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
      $('.warning').fadeIn('normal');
    } else {
      var html = '';

      html += '<thead><tr>';
      html += '<td class="left"><?php echo $column_date; ?></td>';
      html += '<td class="left"><?php echo $column_type; ?></td>';
      html += '<td class="left"><?php echo $column_email; ?></td>';
      html += '<td class="left"><?php echo $column_name; ?></td>';
      html += '<td class="left"><?php echo $column_transid; ?></td>';
      html += '<td class="left"><?php echo $column_status; ?></td>';
      html += '<td class="left"><?php echo $column_currency; ?></td>';
      html += '<td class="right"><?php echo $column_amount; ?></td>';
      html += '<td class="right"><?php echo $column_fee; ?></td>';
      html += '<td class="right"><?php echo $column_netamt; ?></td>';
      html += '<td class="center"><?php echo $column_action; ?></td>';
      html += '</tr></thead>';

      if (json.result.length > 0) {
        $.each(json.result, function(index, element) {
          if ('L_LONGMESSAGE' in element) {
            $('.box').before('<div class="warning" style="display:none;">' + element.L_LONGMESSAGE + '<img src="view/image/close.png" alt="Close" class="close" /></div>');
            $('.warning').fadeIn('normal');
          } else {
            if (!('L_EMAIL' in element)) {
              element.L_EMAIL = '';
            }

            html += '<tr>';
            html += '<td class="left">' + element.L_TIMESTAMP + '</td>';
            html += '<td class="left">' + element.L_TYPE + '</td>';
            html += '<td class="left">' + element.L_EMAIL + '</td>';
            html += '<td class="left">' + element.L_NAME + '</td>';
            html += '<td class="left">' + element.L_TRANSACTIONID + '</td>';
            html += '<td class="left">' + element.L_STATUS + '</td>';
            html += '<td class="left">' + element.L_CURRENCYCODE + '</td>';
            html += '<td class="right">' + element.L_AMT + '</td>';
            html += '<td class="right">' + element.L_FEEAMT + '</td>';
            html += '<td class="right">' + element.L_NETAMT + '</td>';
            html += '<td class="center">';
            html += '<a href="<?php echo $view_link; ?>&transaction_id=' + element.L_TRANSACTIONID + '" class="button"><?php echo $text_view; ?></a>';
            html += '</td>';
            html += '</tr>';
          }
        });
      } else {
        html += '<td class="center" colspan="11"><?php echo $text_no_results; ?></td>';
      }

      if ('attention' in json) {
        $('.box').before('<div class="attention" style="display:none;">' + json['attention'] + '</div>');
        $('.attention').fadeIn('normal');
      }

      $('#search-results').append(html).fadeIn();
    }
  })
  .always(function() {
    $('#searching').hide();
  });
});

$('#button-edit').on('click', function() {
  $('.success, .warning, .attention').remove();
  $('#search-box').hide();
  $('#search-input').show();
  $('#button-edit').hide();
  $('#button-search').show();
  $('#searching').show();
  $('#search-results').empty().hide();
});
//--></script>

<?php echo $footer; ?>