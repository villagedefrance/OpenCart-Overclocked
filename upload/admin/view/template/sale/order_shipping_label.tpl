<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" media="screen" />
</head>
<body>
<?php foreach ($orders as $order) { ?>
<div style="page-break-after:always;">
  <div style="width:400px; border:1px dotted #CCC; padding:18px 0px 0px 18px;">
  <?php if (!empty($logo)) { ?>
    <img src="<?php echo $logo; ?>" alt="" />
  <?php } ?>
  <table class="store" style="width:380px;">
    <tr>
      <td><?php echo $order['store_url']; ?></td>
    </tr>
  </table>
  <table class="address" style="width:380px;">
    <tr class="heading">
      <td><b><?php echo $text_deliver_to; ?></b></td>
    </tr>
    <tr>
      <td>
        <b><?php echo $order['shipping_address']; ?></b><br /><br />
        <?php echo $text_email; ?> <?php echo $order['email']; ?><br/>
        <?php echo $text_phone; ?> <?php echo $order['telephone']; ?><br /><br />
        <?php if ($order['shipping_method']) { ?>
          <b><?php echo $order['shipping_method']; ?></b>
        <?php } ?>
      </td>
    </tr>
  </table>
  <?php if ($order['comment']) { ?>
  <table class="comment" style="width:380px;">
    <tr class="heading">
      <td><b><?php echo $column_comment; ?></b></td>
    </tr>
    <tr>
      <td><?php echo $order['comment']; ?></td>
    </tr>
  </table>
  <?php } ?>
  </div>
</div>
<?php } ?>
</body>
</html>