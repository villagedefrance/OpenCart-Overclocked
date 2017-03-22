<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo $stylesheet; ?>" />
</head>
<body>
  <?php if (!empty($error)) { ?>
    <div class="warning"><?php echo $error; ?></div>
  <?php } elseif (!empty($attention)) { ?>
    <div class="attention"><?php echo $attention; ?></div>
  <?php } else { ?>
    <form action="<?php echo $url; ?>" method="post" name="ppform" id="ppform">
      <input type="hidden" name="cmd" value="_s-xclick" />
      <input type="hidden" name="hosted_button_id" value="<?php echo $code; ?>" />
      <p style="text-align:center;">
        <input type="image" src="<?php echo ($this->config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER) . 'catalog/view/theme/<?php echo $template; ?>/image/loading.gif'; ?>" border="0" name="submit" alt="Loading..." style="margin-left:auto; margin-right:auto;" />
        <span style="font-family:arial; font-size:12px; font-weight:bold;"><?php echo $text_secure_connection; ?></span>
      </p>
      <img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
    </form>
<script type="text/javascript"><!--
  document.forms["ppform"].submit();
//--></script>
  <?php } ?>
</body>
</html>