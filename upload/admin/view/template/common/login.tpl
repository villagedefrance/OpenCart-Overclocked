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
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <table style="width:100%;">
      <tr>
        <td style="text-align:center;" rowspan="4"><img src="view/image/theme/login.png" alt="<?php echo $text_login; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_username; ?><br />
          <input type="text" name="username" value="<?php echo $username; ?>" style="margin-top:4px;" />
          <br />
          <br />
          <?php echo $entry_password; ?><br />
          <input type="password" name="password" value="<?php echo $password; ?>" style="margin-top:4px;" />
          <?php if ($forgotten) { ?>
            <br /><br />
            <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
          <?php } ?>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="text-align:right;"><a onclick="$('#form').submit();" class="button"><?php echo $button_login; ?></a></td>
      </tr>
    </table>
    <?php if ($redirect) { ?>
      <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
    <?php } ?>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) { $('#form').submit(); }
});
//--></script>

<?php echo $footer; ?>