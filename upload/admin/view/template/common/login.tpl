<?php echo $header; ?>
<div id="content">
  <div class="box-login">
    <div class="content-login">
    <?php if ($success) { ?>
      <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error_warning) { ?>
      <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <h1><img src="view/image/theme/lockscreen.png" alt="" /> <?php echo $text_login; ?></h1>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
      <div class="leftside">
        <img src="view/image/theme/login.png" alt="<?php echo $text_login; ?>" />
      </div>
      <div class="rightside">
        <div style="margin:5px 0px;"><?php echo $entry_username; ?></div>
        <div>
          <input type="text" name="username" value="<?php echo $username; ?>" />
        </div>
        <div style="margin:5px 0px;"><?php echo $entry_password; ?></div>
        <div>
          <input type="password" name="password" value="<?php echo $password; ?>" />
        </div>
        <?php if ($forgotten) { ?>
          <div style="margin:5px 0px;">
            <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
          </div>
        <?php } ?>
      </div>
      <div class="validate">
        <a onclick="$('form').submit();" class="button-filter"><?php echo $button_login; ?></a>
      </div>
    <?php if ($redirect) { ?>
      <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
    <?php } ?>
    </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>