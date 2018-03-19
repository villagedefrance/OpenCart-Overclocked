<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="icon" type="image/png" href="docicon.png" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" media="screen, print" />
</head>
<body>
<?php foreach ($orders as $order) { ?>
<div class="documents">
  <?php if ($logo) { ?>
    <img src="<?php echo $logo; ?>" alt="" style="padding:15px 0 0 5px;" />
  <?php } ?>
  <h1><?php echo $text_pick_list; ?></h1>
  <table class="store">
    <tr>
      <td class="top-left">
        <b><?php echo $order['store_name']; ?></b><br />
        <?php echo $order['store_address']; ?><br /><br />
        <img src="view/image/location/phone.png" alt="" height="14" width="14" /> <?php echo $order['store_telephone']; ?><br />
        <?php if ($order['store_fax']) { ?>
          <img src="view/image/location/fax.png" alt="" height="14" width="14" /> <?php echo $text_fax; ?> <?php echo $order['store_fax']; ?><br />
        <?php } ?>
        <img src="view/image/location/mail.png" alt="" height="14" width="14" /> <?php echo $order['store_email']; ?><br />
        <img src="view/image/location/global.png" alt="" height="14" width="14" /> <?php echo $order['store_url']; ?><br />
        <?php if ($order['store_company_id']) { ?>
          <img src="view/image/location/company.png" alt="" height="14" width="14" /> <?php echo $order['store_company_id']; ?><br />
        <?php } ?>
        <?php if ($order['store_company_tax_id']) { ?>
          <img src="view/image/location/tax.png" alt="" height="14" width="14" /> <?php echo $order['store_company_tax_id']; ?><br />
        <?php } ?>
      </td>
      <td class="top-right">
        <table>
          <tr>
            <td><b><?php echo $text_date_added; ?></b></td>
            <td><?php echo $order['date_added']; ?></td>
          </tr>
          <?php if ($order['invoice_no']) { ?>
          <tr>
            <td><b><?php echo $text_invoice_no; ?></b></td>
            <td><?php echo $order['invoice_no']; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td><b><?php echo $text_order_id; ?></b></td>
            <td><?php echo $order['order_id']; ?></td>
          </tr>
          <tr>
            <td><b><?php echo $text_payment_method; ?></b></td>
            <td><?php echo $order['payment_method']; ?></td>
          </tr>
          <?php if ($order['shipping_method']) { ?>
          <tr>
            <td><b><?php echo $text_shipping_method; ?></b></td>
            <td><?php echo $order['shipping_method']; ?></td>
          </tr>
          <?php } ?>
        </table>
      </td>
    </tr>
  </table>
  <table class="address">
    <tr class="heading">
      <td width="50%"><b><?php echo $text_to; ?></b></td>
      <td width="50%"><b><?php echo $text_ship_to; ?></b></td>
    </tr>
    <tr>
      <td>
        <?php echo $order['payment_address']; ?><br/><br/>
        <img src="view/image/location/phone.png" alt="" height="14" width="14" /> <?php echo $order['telephone']; ?><br/>
        <?php if ($order['payment_company']) { ?>
          <img src="view/image/location/company.png" alt="" height="14" width="14" /> <?php echo $order['payment_company']; ?><br/>
        <?php } ?>
        <?php if ($order['payment_company_id']) { ?>
          <img src="view/image/location/tax.png" alt="" height="14" width="14" /> <?php echo $order['payment_company_id']; ?><br/>
        <?php } ?>
      </td>
      <td><?php echo $order['shipping_address']; ?></td>
    </tr>
  </table>
  <table class="product">
    <tr class="heading">
      <td class="left"><b><?php echo $column_location; ?></b></td>
      <td class="left"><b><?php echo $column_product; ?></b></td>
      <td class="left"><b><?php echo $column_model; ?></b></td>
      <td class="center"><b><?php echo $column_quantity; ?></b></td>
      <td class="left"><b><?php echo $column_status_picked; ?></b></td>
      <td class="left" width="20%"><b><?php echo $column_status_backordered; ?></b></td>
    </tr>
    <?php foreach ($order['product'] as $product) { ?>
    <tr>
      <td class="left"><?php foreach ($product['location'] as $product_bin) { ?>
        <?php echo ($product_bin) ? $product_bin : '---'; ?>
      <?php } ?></td>
      <td class="left"><?php echo $product['name']; ?>
        <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
        <?php } ?>
      </td>
      <td class="left"><?php echo $product['barcode']; ?><?php echo $product['model']; ?></td>
      <td class="center"><?php echo $product['quantity']; ?></td>
      <td></td>
      <td></td>
    </tr>
    <?php } ?>
  </table>
  <?php if ($order['comment']) { ?>
  <table class="comment">
    <tr class="heading">
      <td><b><?php echo $column_comment; ?></b></td>
    </tr>
    <tr>
      <td><?php echo $order['comment']; ?></td>
    </tr>
  </table>
  <?php } ?>
  <table class="delivery">
    <tr class="heading">
      <td width="50%"><b><?php echo $text_shipping_collection; ?></b></td>
      <td width="50%"><b><?php echo $text_customer_reception; ?></b></td>
    </tr>
    <tr>
      <td>
        <?php echo $text_collection_reference; ?><br /><br />
        <?php echo $text_collection_date; ?><br /><br />
        <?php echo $text_collection_time; ?><br /><br />
        <?php echo $text_collection_name; ?><br /><br />
        <?php echo $text_collection_sign; ?><br /><br />
      </td>
      <td>
        <?php echo $text_reception_name; ?><br /><br />
        <?php echo $text_reception_sign; ?><br /><br />
        <?php echo $text_reception_date; ?><br /><br />
        <?php echo $text_reception_condition; ?><br /><br />
      </td>
    </tr>
  </table>
  <table class="bank">
    <tr>
      <td class="center"><span><?php echo $order['store_name']; ?> <?php echo $text_copyrights; ?></span></td>
    </tr>
  <table>
</div>
<?php } ?>
</body>
</html>