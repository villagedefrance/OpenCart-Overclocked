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
  <h1><?php echo $text_order; ?></h1>
  <table class="store">
    <tr>
      <td>
        <?php echo $store_name; ?><br />
        <?php echo $store_address; ?><br />
        <?php echo $text_telephone; ?> <?php echo $store_telephone; ?><br />
      <?php if ($store_fax) { ?>
        <?php echo $text_fax; ?> <?php echo $store_fax; ?><br />
      <?php } ?>
        <?php echo $store_email; ?><br />
      <?php if ($store_company_id) { ?>
        <span style="font-size:12px;"><?php echo $store_company_id; ?></span><br />
      <?php } ?>
      <?php if ($store_company_tax_id) { ?>
        <span style="font-size:12px;"><?php echo $store_company_tax_id; ?></span><br />
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
        <?php echo $email; ?><br/>
        <?php echo $text_telephone; ?>&nbsp;<?php echo $telephone; ?>
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
      <td class="right"><b><?php echo $column_tax_value; ?></b></td>
      <td class="right"><b><?php echo $column_tax_percent; ?></b></td>
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
      <td class="right"><?php echo $product['tax_value']; ?></td>
      <td class="right"><?php echo $product['tax_percent']; ?>%</td>
      <td class="right"><?php echo $product['total']; ?></td>
    </tr>
  <?php } ?>
  <?php foreach ($vouchers as $voucher) { ?>
    <tr>
      <td class="left"><?php echo $voucher['description']; ?></td>
      <td class="left"></td>
      <td class="right">1</td>
      <td class="right"><?php echo $voucher['amount']; ?></td>
      <td class="right">0.00</td>
      <td class="right">0%</td>
      <td class="right"><?php echo $voucher['amount']; ?></td>
    </tr>
  <?php } ?>
  <?php foreach ($totals as $total) { ?>
    <tr>
      <td class="right" colspan="6"><b><?php echo $total['title']; ?>:</b></td>
      <td class="right"><?php echo $total['text']; ?></td>
    </tr>
  <?php } ?>
  </table>
<?php if ($comment) { ?>
  <table class="comment">
    <tr class="heading">
      <td><b><?php echo $column_comment; ?></b></td>
    </tr>
    <tr>
      <td><?php echo $comment; ?></td>
    </tr>
  </table>
<?php } ?>
<?php if ($histories) { ?>
  <table class="history">
    <tr class="heading">
      <td><b><?php echo $column_date_added; ?></b></td>
      <td><b><?php echo $column_status; ?></b></td>
      <td><b><?php echo $column_comment; ?></b></td>
    </tr>
  <?php foreach ($histories as $history) { ?>
    <tr>
      <td><?php echo $history['date_added']; ?></td>
      <td><?php echo $history['status']; ?></td>
      <td><?php echo $history['comment']; ?></td>
    </tr>
  <?php } ?>
  </table>
<?php } ?>
</div>
</body>
</html>