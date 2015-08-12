<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get('default_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
  <h2><?php echo $text_password; ?></h2>
  <div class="content">
    <table class="form">
      <tr>
        <td><span class="required">*</span> <?php echo $entry_password; ?></td>
        <td><input type="password" name="password" id="password1" value="<?php echo $password; ?>" />
        <?php if ($error_password) { ?>
          <span class="error"><?php echo $error_password; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
        <td><input type="password" name="confirm" id="password2" value="<?php echo $confirm; ?>" />
        <?php if ($error_confirm) { ?>
          <span class="error"><?php echo $error_confirm; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td></td>
        <td><div id="pass-info" style="line-height:16px;"></div></td>
      </tr>
    </table>
  </div>
  <div class="buttons">
    <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
    <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
  </div>
  </form>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

<script type="text/javascript"><!--
$(document).ready(function() {
    var password1 = $('#password1');
    var password2 = $('#password2');
    var passwordsInfo = $('#pass-info');

    passwordStrengthCheck(password1, password2, passwordsInfo);
});

function passwordStrengthCheck(password1, password2, passwordsInfo) {
	$(password2).on('keyup', function(e) {
		if (password1.val() === password2.val()) {
			passwordsInfo.removeClass().addClass('match').html('<?php echo $text_match; ?>');
		}
	});
}
//--></script>

<?php echo $footer; ?>