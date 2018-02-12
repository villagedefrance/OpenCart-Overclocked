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
<div style="page-break-after:always;">
  <div style="width:420px; border:1px dotted #CCC; padding:18px 0px 0px 18px;">
  <?php if ($logo) { ?>
    <img src="<?php echo $logo; ?>" alt="" />
  <?php } ?>
  <table class="store" style="width:400px;">
    <tr>
      <td><?php echo $order['store_url']; ?></td>
    </tr>
  </table>
  <table class="address" style="width:400px;">
    <tr class="heading">
      <td><b><?php echo $text_deliver_to; ?></b></td>
    </tr>
    <tr>
      <td>
        <b><?php echo $order['shipping_address']; ?></b><br /><br />
        <?php echo $text_phone; ?> <?php echo $order['telephone']; ?><br /><br />
        <?php if ($order['shipping_method']) { ?>
          <b><?php echo $order['shipping_method']; ?></b>
        <?php } ?>
      </td>
    </tr>
  </table>
  <?php if ($order['comment']) { ?>
  <table class="comment" style="width:400px;">
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