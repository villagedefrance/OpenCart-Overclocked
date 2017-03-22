<h2><?php echo $text_credit_card; ?></h2>
<form action="" method="POST" id="payment-form">
<span class="payment-errors error"></span>
<div class="content" id="payment">
  <table class="form">
    <tr>
      <td><?php echo $entry_cc_owner; ?></td>
      <td><input type="text" name="cc_owner" data-stripe="name" value="" size="30" /></td>
    </tr>
    <tr>
      <td><?php echo $entry_cc_number; ?></td>
      <td><input type="text" name="cc_number" id="cc_number" data-stripe="number" value="" size="35" /></td>
    </tr>
    <tr>
      <td><?php echo $entry_cc_expire_date; ?></td>
      <td><select name="cc_expire_date_month" data-stripe="exp-month">
        <?php foreach ($months as $month) { ?>
          <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
        <?php } ?>
      </select>
        /
      <select name="cc_expire_date_year" data-stripe="exp-year">
        <?php foreach ($year_expire as $year) { ?>
          <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td><?php echo $entry_cc_cvv2; ?></td>
      <td><input type="text" name="cc_cvv2" data-stripe="cvc" value="" size="3" /></td>
    </tr>
    <tr>
      <td colspan="2">
        <img src="catalog/view/theme/<?php echo $template; ?>/image/payment/stripe-cc-logos.png" alt="" />
      </td>
    </tr>
  </table>
</div>
<div class="buttons">
  <div class="right">
    <input type="submit" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" />
  </div>
</div>
</form>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript"><!--
function wait_for_stripe_to_load() {
  if (window.Stripe) {
    Stripe.setPublishableKey('<?php echo $stripe_payments_publish_key; ?>');
  } else {
    setTimeout(function() { wait_for_stripe_to_load() }, 50);
  }
}
wait_for_stripe_to_load();

var stripeResponseHandler = function(status, response) {
  var $form = $('#payment-form');

  if (response.error) {
    $form.find('.payment-errors').text(response.error.message);
    $form.find('button').prop('disabled', false);
    $('.attention').remove();
  } else {
    var token = response.id;
    $.ajax({
      url: 'index.php?route=payment/stripe_payments/send',
      type: 'post',
      data: 'stripeToken=' + token,
      dataType: 'json',
      complete: function() {
        $('.attention').remove();
      },
      success: function(json) {
        if (json['error']) {
          $form.find('.payment-errors').text(json['error']);
          $form.find('button').prop('disabled', false);
        }

        if (json['success']) {
          location = json['success'];
        }
      }
    });
  }
};

jQuery(function($) {
  $('#payment-form').submit(function(e) {
    var $form = $(this);
    $form.find('button').prop('disabled', true);
    $form.find('.payment-errors').text('');
    $('#payment').before('<div class="attention"><img src="<?php echo $this->config->get('config_ssl'); ?>catalog/view/theme/" . $template . "/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
    Stripe.card.createToken($form, stripeResponseHandler);
    return false;
  });

  $('#cc_number').on('input propertychange', function() {
    var cctype = Stripe.card.cardType($(this).val());
    cctype = cctype.replace(/\s/g, '').toLowerCase();
    $('#payment-form .credit-cards').removeClass().addClass('credit-cards ' + cctype);
  });
});
//--></script>