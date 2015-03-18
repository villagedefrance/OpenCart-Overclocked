<?php if (!isset($redirect)) { ?>
<div id="checkout" style="display:none;"></div>
<div id="payment-address" style="display:none;"></div>
<div id="shipping-address" style="display:none;"></div>
<div id="shipping-method" style="display:none;"></div>
<div id="payment-method" style="display:none;"></div>
<div style="margin-bottom:15px;">
  <h2><?php echo $text_checkout_confirm; ?></h2>
</div>
<div class="left" style="margin-bottom:25px;">
  <?php if ($shipping_firstname) { ?><?php echo $shipping_firstname; ?> <?php echo $shipping_lastname; ?><br /><?php } ?>
  <?php if ($shipping_company) { ?><?php echo $shipping_company; ?><br /><?php } ?>
  <?php if ($shipping_address_1) { ?><?php echo $shipping_address_1; ?><br /><?php } ?>
  <?php if ($shipping_address_2) { ?><?php echo $shipping_address_2; ?><br /><?php } ?>
  <?php if ($shipping_city) { ?><?php echo $shipping_city; ?><br /><?php } ?>
  <?php if ($shipping_postcode) { ?><?php echo $shipping_postcode; ?><br /><?php } ?>
  <?php if ($shipping_zone) { ?><?php echo $shipping_zone; ?><br /><?php } ?>
  <?php if ($shipping_country) { ?><?php echo $shipping_country; ?><?php } ?>
</div>
<div class="right" style="margin-bottom:25px;">
  <?php echo $shipping_method_selected; ?>
  <br /><br />
  <?php echo $payment_method_selected; ?>
  <br /><br />
  <?php echo $order_comment; ?>
  <br />
</div>
<div class="checkout-product">
  <table>
    <thead>
      <tr>
        <td class="name"><?php echo $column_name; ?></td>
        <td class="model"><?php echo $column_model; ?></td>
        <td class="quantity"><?php echo $column_quantity; ?></td>
        <td class="price"><?php echo $column_price; ?></td>
        <td class="total"><?php echo $column_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
        <?php if ($product['recurring']) { ?>
          <tr>
            <td colspan="5" style="border:none; line-height:18px; margin-left:10px;">
              <img src="catalog/view/theme/<?php echo $template; ?>/image/reorder.png" alt="" title="" style="float:left; margin-right:8px;" />
              <strong><?php echo $text_recurring_item; ?></strong>
              <?php echo $product['profile_description']; ?>
            </td>
          </tr>
        <?php } ?>
        <tr>
          <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
          <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?>
          <?php if ($product['recurring']) { ?>
            <br />
            &nbsp;<small> - <?php echo $text_payment_profile; ?>: <?php echo $product['profile_name']; ?></small>
          <?php } ?>
          </td>
          <td class="model"><?php echo $product['model']; ?></td>
          <td class="quantity"><?php echo $product['quantity']; ?></td>
          <td class="price"><?php echo $product['price']; ?></td>
          <td class="total"><?php echo $product['total']; ?></td>
        </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
        <tr>
          <td class="name"><?php echo $voucher['description']; ?></td>
          <td class="model"></td>
          <td class="quantity">1</td>
          <td class="price"><?php echo $voucher['amount']; ?></td>
          <td class="total"><?php echo $voucher['amount']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
        <tr>
          <td colspan="4" class="price"><b><?php echo $total['title']; ?>:</b></td>
          <td class="total"><?php echo $total['text']; ?></td>
        </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<div class="payment"><?php echo $payment; ?></div>
<?php } else { ?>

<script type="text/javascript"><!--
location = '<?php echo $redirect; ?>';
//--></script>

<?php } ?>