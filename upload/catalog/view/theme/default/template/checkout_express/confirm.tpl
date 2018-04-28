<?php if (!isset($redirect)) { ?>
<div style="margin-bottom:15px;">
  <h2><?php echo $text_checkout_confirm; ?></h2>
</div>
<div class="checkout-content">
  <div class="left" style="margin-bottom:25px;">
    <?php echo ($shipping_firstname && $shipping_lastname) ? $shipping_firstname . ' ' . $shipping_lastname . '<br />' : ''; ?>
    <?php echo ($shipping_company) ? $shipping_company . '<br />' : ''; ?>
    <?php echo ($shipping_address_1) ? $shipping_address_1 . '<br />' : ''; ?>
    <?php echo ($shipping_address_2) ? $shipping_address_2 . '<br />' : ''; ?>
    <?php echo ($shipping_city) ? $shipping_city . '<br />' : ''; ?>
    <?php echo ($shipping_postcode) ? $shipping_postcode . '<br />' : ''; ?>
    <?php echo ($shipping_zone) ? $shipping_zone . '<br />' : ''; ?>
    <?php echo ($shipping_country) ? $shipping_country : ''; ?>
  </div>
  <div class="right" style="margin-bottom:25px;">
    <?php echo $shipping_method_selected; ?>
    <br /><br />
    <?php echo $payment_method_selected; ?>
    <br /><br />
    <?php echo $order_comment; ?>
    <br />
  </div>
</div>
<div class="checkout-product">
  <table>
    <thead>
      <tr>
        <td class="name"><?php echo $column_name; ?></td>
        <td class="model"><?php echo $column_model; ?></td>
        <td class="quantity"><?php echo $column_quantity; ?></td>
        <td class="price"><?php echo $column_price; ?></td>
      <?php if ($tax_breakdown) { ?>
        <td class="price"><?php echo $column_tax_value; ?></td>
        <td class="price"><?php echo $column_tax_percent; ?></td>
      <?php } ?>
        <td class="total"><?php echo $column_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php $tax_colspan_plus = $tax_colspan + 1; ?>
      <?php foreach ($products as $product) { ?>
        <?php if ($product['recurring']) { ?>
          <tr>
            <td colspan="<?php echo $tax_colspan_plus; ?>" style="border:none; line-height:18px; margin-left:10px;">
              <img src="catalog/view/theme/<?php echo $template; ?>/image/reorder.png" alt="" title="" style="float:left; margin-right:8px;" />
              <strong><?php echo $text_recurring_item; ?></strong>
              <?php echo $product['profile_description']; ?>
            </td>
          </tr>
        <?php } ?>
        <tr>
          <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a><?php echo $product['age_minimum']; ?>
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
        <?php if ($tax_breakdown) { ?>
          <td class="price"><?php echo $product['tax_value']; ?></td>
          <td class="price"><?php echo $product['tax_percent']; ?>%</td>
        <?php } ?>
          <td class="total"><?php echo $product['total']; ?></td>
        </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
        <tr>
          <td colspan="2" class="name"><?php echo $voucher['description']; ?></td>
          <td colspan="2" class="model"></td>
          <td class="quantity">1</td>
          <td class="price"><?php echo $voucher['amount']; ?></td>
          <td class="total"><?php echo $voucher['amount']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
        <tr>
          <td colspan="<?php echo $tax_colspan; ?>" class="price"><b><?php echo $total['title']; ?>:</b></td>
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