<?php echo $header_login; ?>
<div id="content-login">
  <div class="box-login animated fadeIn">
    <div class="content-login">
    <h2 style="margin:20px 0 30px 15px;"><?php echo $heading_title; ?></h2>
    <div class="tooltip" style="margin:15px 10px 5px 10px;"><?php echo $text_password; ?></div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="reset">
      <div style="margin:10px 0 10px 0;"><?php echo $entry_password; ?></div>
      <div style="margin:0 0 15px 0;">
        <input type="password" name="password" value="<?php echo $password; ?>" />
      </div>
    <?php if ($error_password) { ?>
      <span class="error"><?php echo $error_password; ?></span>
    <?php } ?>
      <div style="margin:10px 0 10px 0;"><?php echo $entry_confirm; ?></div>
      <div style="margin:0 0 20px 0;">
        <input type="password" name="confirm" value="<?php echo $confirm; ?>" />
      </div>
    <?php if ($error_confirm) { ?>
      <span class="error"><?php echo $error_confirm; ?></span>
    <?php } ?>
      <div class="validate animated fadeIn">
        <a onclick="$('#reset').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </form>
    </div>
  </div>
</div>
<?php echo $footer_login; ?>