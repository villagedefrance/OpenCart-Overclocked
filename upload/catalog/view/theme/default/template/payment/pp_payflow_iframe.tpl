<?php if (!empty($error)) { ?>
  <div class="warning"><?php echo $error; ?></div>
<?php } elseif (!empty($attention)) { ?>
  <div class="attention"><?php echo $attention; ?></div>
<?php } else { ?>
  <?php if (isset($checkout_method) && $checkout_method == 'iframe') { ?>
    <iframe src="<?php echo $iframe_url; ?>" width="490" height="565" border="0" frameborder="0" scrolling="no" allowtransparency="true"></iframe>
  <?php } else { ?>
    <div class="buttons">
      <div class="right">
        <a class="button" href="<?php echo $iframe_url; ?>"><?php echo $button_confirm; ?></a>
      </div>
    </div>
  <?php } ?>
<?php } ?>