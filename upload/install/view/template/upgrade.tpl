<?php echo $header; ?>
<h1><?php echo $heading_upgrade; ?></h1>
<div id="column-right">
  <ul>
    <li><b><?php echo $text_upgrade; ?></b></li>
    <li><?php echo $text_finished; ?></li>
  </ul>
</div>
<div id="content">
  <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" name="upgrade">
    <fieldset>
      <p><b><?php echo $text_follow_steps; ?></b></p>
      <ol>
        <li><?php echo $text_clear_cookie; ?></li>
        <li><?php echo $text_admin_page; ?></li>
        <li><?php echo $text_admin_user; ?></li>
        <li><?php echo $text_admin_setting; ?></li>
        <li><?php echo $text_store_front; ?></li>
      </ol>
	  <br />
	  <p><?php echo $text_be_patient; ?></p>
    </fieldset>
    <div class="buttons">
      <div class="right"><input type="submit" value="<?php echo $button_upgrade; ?>" id="loader" class="button" /></div>
    </div>
  </form>
</div>
<?php echo $footer; ?> 