<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="icon" type="image/png" href="admin/docicon.png" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $template; ?>/stylesheet/invoice.css" media="screen, print" />
</head>
<body>
<div class="documents">
  <?php if ($logo) { ?>
    <img src="<?php echo $logo; ?>" alt="" style="padding:15px 0 0 5px;" />
  <?php } ?>
  <h1><?php echo $heading_order; ?></h1>
  <table class="store">
    <tr>
      <td class="top-left">
        <b><?php echo $store_name; ?></b><br />
        <?php echo $store_address; ?><br /><br />
        <img src="catalog/view/theme/<?php echo $template; ?>/image/location/phone.png" alt="" height="14" width="14" /> <?php echo $store_telephone; ?><br />
      <?php if ($store_fax) { ?>
        <img src="catalog/view/theme/<?php echo $template; ?>/image/location/fax.png" alt="" height="14" width="14" /> <?php echo $store_fax; ?><br />
      <?php } ?>
        <img src="catalog/view/theme/<?php echo $template; ?>/image/location/mail.png" alt="" height="14" width="14" /> <?php echo $store_email; ?><br />
        <img src="catalog/view/theme/<?php echo $template; ?>/image/location/global.png" alt="" height="14" width="14" /> <?php echo $store_url; ?><br />
      <?php if ($store_company_id) { ?>
        <img src="catalog/view/theme/<?php echo $template; ?>/image/location/company.png" alt="" height="14" width="14" /> <?php echo $store_company_id; ?><br />
      <?php } ?>
      <?php if ($store_company_tax_id) { ?>
        <img src="catalog/view/theme/<?php echo $template; ?>/image/location/tax.png" alt="" height="14" width="14" /> <?php echo $store_company_tax_id; ?><br />
      <?php } ?>
      </td>
      <td class="top-right">
        <table>
          <tr>
            <td><b><?php echo $text_date_added; ?></b></td>
            <td><?php echo $date_added; ?></td>
          </tr>
        <?php if ($invoice_no) { ?>
          <tr>
            <td><b><?php echo $text_invoice_no; ?></b></td>
            <td><?php echo $invoice_no; ?></td>
          </tr>
        <?php } ?>
          <tr>
            <td><b><?php echo $text_order_id; ?></b></td>
            <td><?php echo $order_id; ?></td>
          </tr>
          <tr>
            <td><b><?php echo $text_payment_method; ?></b></td>
            <td><?php echo $payment_method; ?></td>
          </tr>
        <?php if ($shipping_method) { ?>
          <tr>
            <td><b><?php echo $text_shipping_method; ?></b></td>
            <td><?php echo $shipping_method; ?></td>
          </tr>
        <?php } ?>
        </table>
      </td>
    </tr>
  </table>
  <table class="address">
    <tr class="heading">
      <td width="50%"><b><?php echo $text_payment_address; ?></b></td>
      <td width="50%"><b><?php echo $text_shipping_address; ?></b></td>
    </tr>
    <tr>
      <td>
        <?php echo $payment_address; ?><br/><br/>
        <img src="catalog/view/theme/<?php echo $template; ?>/image/location/phone.png" alt="" height="14" width="14" /> <?php echo $telephone; ?><br />
        <img src="catalog/view/theme/<?php echo $template; ?>/image/location/mail.png" alt="" height="14" width="14" /> <?php echo $email; ?><br />
        <?php if ($payment_company) { ?>
          <img src="catalog/view/theme/<?php echo $template; ?>/image/location/company.png" alt="" height="14" width="14" /> <?php echo $payment_company; ?><br />
        <?php } ?>
        <?php if ($payment_company_id) { ?>
          <img src="catalog/view/theme/<?php echo $template; ?>/image/location/tax.png" alt="" height="14" width="14" /> <?php echo $payment_company_id; ?><br />
        <?php } ?>
      </td>
      <td><?php echo $shipping_address; ?></td>
    </tr>
  </table>
  <table class="product">
    <tr class="heading">
      <td class="left"><b><?php echo $column_name; ?></b></td>
      <td class="left"><b><?php echo $column_model; ?></b></td>
      <td class="center"><b><?php echo $column_quantity; ?></b></td>
      <td class="right"><b><?php echo $column_price; ?></b></td>
    <?php if ($tax_breakdown) { ?>
      <td class="right"><b><?php echo $column_tax_value; ?></b></td>
      <td class="right"><b><?php echo $column_tax_percent; ?></b></td>
    <?php } ?>
      <td class="right"><b><?php echo $column_total; ?></b></td>
    </tr>
  <?php foreach ($products as $product) { ?>
    <tr>
      <td class="left"><?php echo $product['name']; ?>
        <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
        <?php } ?>
      </td>
      <td class="left"><?php echo $product['model']; ?></td>
      <td class="center"><?php echo $product['quantity']; ?></td>
      <td class="right"><?php echo $product['price']; ?></td>
    <?php if ($tax_breakdown) { ?>
      <td class="right"><?php echo $product['tax_value']; ?></td>
      <td class="right"><?php echo $product['tax_percent']; ?>%</td>
    <?php } ?>
      <td class="right"><?php echo $product['total']; ?></td>
    </tr>
  <?php } ?>
  <?php foreach ($vouchers as $voucher) { ?>
    <tr>
      <td class="left"><?php echo $voucher['description']; ?></td>
      <td class="left"></td>
      <td class="right">1</td>
      <td class="right"><?php echo $voucher['amount']; ?></td>
    <?php if ($tax_breakdown) { ?>
      <td class="right">0.00</td>
      <td class="right">0%</td>
    <?php } ?>
      <td class="right"><?php echo $voucher['amount']; ?></td>
    </tr>
  <?php } ?>
  <?php foreach ($totals as $total) { ?>
    <tr>
      <td class="right" colspan="<?php echo $tax_colspan; ?>"><b><?php echo $total['title']; ?>:</b></td>
      <td class="right"><?php echo $total['text']; ?></td>
    </tr>
  <?php } ?>
  </table>
  <table class="bank">
    <tr>
      <td class="center"><span><b><?php echo $text_damages; ?></b></span></td>
    </tr>
  <?php if (isset($bank_name) && isset($bank_sort_code) && isset($bank_account)) { ?>
    <tr>
      <td class="center"><span><?php echo $text_bank_name; ?> <?php echo $bank_name; ?> - <?php echo $text_bank_account; ?> <?php echo $bank_sort_code; ?> <?php echo $bank_account; ?></span></td>
    </tr>
  <?php } ?>
    <tr>
      <td class="center"><span><?php echo $store_name; ?> <?php echo $text_copyrights; ?></span></td>
    </tr>
  <table>
</div>
</body>
</html>