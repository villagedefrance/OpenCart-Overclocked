<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $title; ?></title>
</head>
<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;">
<div style="width:680px;">
  <a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" style="margin-bottom:20px; border:none;" /></a>
  <h3 style="margin-top:0; margin-bottom:20px;"><?php echo $text_greeting; ?></h3>
  <p><?php echo $text_login; ?> <a href="<?php echo $login_link; ?>"><?php echo $login_link; ?></a></p>
  <p><b><?php echo $text_express_login; ?></b> <?php echo $login; ?></p>
  <p><b><?php echo $text_express_password; ?></b> <span style="color:#800000;"><?php echo $password; ?></span></p>
  <p><?php echo $text_services; ?></p>
  <p style="font-style:italic;"><?php echo $text_sign; ?></p>
</div>
</body>
</html>