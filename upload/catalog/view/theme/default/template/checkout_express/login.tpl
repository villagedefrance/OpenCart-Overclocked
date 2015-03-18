<div id="login">
  <div style="margin-bottom:15px;">
    <h2><?php echo $text_checkout_account; ?></h2>
  </div>
  <?php echo $entry_express_email; ?>
  <input type="text" id="email" name="email" value="" size="30" />
  <span id="express-hide1" style="display:none; text-align:left;">
    <br />
    <br />
	<?php echo $text_express_hello; ?> <b><span id="express-name"></span></b> !
	<br />
    <br />
    <?php echo $entry_express_password; ?>
    <input type="password" name="password" value="" />
  </span>
  <span id="express-hide2" style="display:none; margin-left:10px;">
    <a href="<?php echo $forgotten; ?>" style="text-decoration:none;"><?php echo $text_express_remind; ?></a>
  </span>
  <br />
  <br />
  <br />
  <div class="buttons">
    <div class="left">
      <input type="submit" value="<?php echo $button_express_go; ?>" id="button-express" class="button" />
    </div>
  </div>
</div>