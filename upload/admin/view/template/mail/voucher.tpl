<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $title; ?></title>
<style type="text/css">
body {
	color: #000;
	font-family: Arial, Helvetica, sans-serif;
}
body, td, th, input, textarea, select, a {
	font-size: 12px;
}
p {
	margin-top: 0px;
	margin-bottom: 20px;
}
a, a:visited, a b {
	color: #378DC1;
	text-decoration: underline;
	cursor: pointer;
}
a:hover {
	text-decoration: none;
}
a img {
	border: none;
}
#container {
	width: 680px;
}
</style>
</head>
<body>
<div id="container">
  <div style="float:right; margin-left:20px;">
    <a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $store_name; ?>" /></a>
  </div>
  <div>
    <p><?php echo $text_greeting; ?></p>
    <p><?php echo $text_from; ?></p>
    <?php if ($message) { ?>
      <p><?php echo $text_message; ?></p>
      <p><?php echo $message; ?></p>
    <?php } ?>
    <p><?php echo $text_redeem; ?></p>
    <p><a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><?php echo $store_url; ?></a></p>
    <p><?php echo $text_footer; ?></p>
  </div>
</div>
</body>
</html>