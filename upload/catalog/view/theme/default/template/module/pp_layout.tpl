<a href="<?php echo $payment_url; ?>" title="PayPal Express Checkout" style="text-decoration:none;">
  <?php if ($is_mobile == true) { ?>
    <img src="catalog/view/theme/default/image/payment/paypal_express_mobile.png" style="margin:10px; float:right; <?php echo $pp_ready; ?>" alt="PayPal Express Checkout" title="PayPal Express Checkout" />
  <?php } else { ?>
    <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png" style="<?php echo $pp_ready; ?>" alt="Check out with PayPal" />
  <?php } ?>
</a>