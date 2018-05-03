<?php if (!empty($error)) { ?>
  <div class="warning"><?php echo $error; ?></div>
<?php } elseif (!empty($attention)) { ?>
  <div class="attention"><?php echo $attention; ?></div>
<?php } else { ?>
  <?php if ($checkout_method == 'iframe') { ?>
    <iframe name="hss_iframe" width="570px" height="540px" style="border:0 solid #DDDDDD; margin-left:210px;" scrolling="no" src="<?php echo ($this->config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=payment/pp_pro_iframe/create'; ?>"></iframe>
  <?php } else { ?>
    <form action="<?php echo $url; ?>" method="post" name="ppform" id="ppform">
      <input type="hidden" name="cmd" value="_s-xclick" />
      <input type="hidden" name="hosted_button_id" value="<?php echo $code; ?>" />
    </form>
<script type="text/javascript"><!--
  $('#ppform').submit();
//--></script>
  <?php } ?>
<?php } ?>