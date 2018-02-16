<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
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
        <td><span class="required">*</span> <?php echo $entry_old_password; ?></td>
        <td><input type="password" name="old_password" readonly value="<?php echo $old_password; ?>" onfocus="this.removeAttribute('readonly');" />
        <?php if ($error_password_required) { ?>
          <span class="error"><?php echo $error_password_required; ?></span>
        <?php } ?>
        <?php if ($error_old_password) { ?>
          <span class="error"><?php echo $error_old_password; ?></span>
        <?php } ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td><a href="<?php echo $forgotten; ?>" title="" class="button"><?php echo $text_forgotten; ?></a></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_password; ?></td>
        <td><input type="password" name="password" id="password1" value="<?php echo $password; ?>" />
        <span id="check" class="hidden"></span>
        <?php if ($error_password) { ?>
          <span class="error"><?php echo $error_password; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
        <td><input type="password" name="confirm" id="password2" value="<?php echo $confirm; ?>" />&nbsp;
        <span id="match" class="hidden"></span>
        <?php if ($error_confirm) { ?>
          <span class="error"><?php echo $error_confirm; ?></span>
        <?php } ?></td>
      </tr>
    </table>
  </div>
  <div class="buttons">
    <div class="left"><a href="<?php echo $back; ?>" class="button"><i class="fa fa-arrow-left"></i> &nbsp; <?php echo $button_back; ?></a></div>
    <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
  </div>
  </form>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#password1').on('keyup', function() {
		$('#check').html(checkStrength($('#password1').val()));
	});

	function checkStrength(password1) {
		var strength = 0;

		if (password1.length < 4) {
			$('#check').removeClass().addClass('short');
			return '<img src="catalog/view/theme/<?php echo $template; ?>/image/account/password-short.png" alt="" />';
		}

		if (password1.length > 4) { strength += 1; };
		if (password1.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) { strength += 1; };
		if (password1.match(/([a-zA-Z])/) && password1.match(/([0-9])/)) { strength += 1; };
		if (password1.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) { strength += 1; };
		if (password1.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/)) { strength += 1; };

		if (strength < 2) {
			$('#check').removeClass().addClass('weak');
			return '<img src="catalog/view/theme/<?php echo $template; ?>/image/account/password-weak.png" alt="" />';
		} else if (strength == 2) {
			$('#check').removeClass().addClass('good');
			return '<img src="catalog/view/theme/<?php echo $template; ?>/image/account/password-good.png" alt="" />';
		} else {
			$('#check').removeClass().addClass('strong');
			return '<img src="catalog/view/theme/<?php echo $template; ?>/image/account/password-strong.png" alt="" />';
		}
	}
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	var password1 = $('#password1');
	var password2 = $('#password2');

	$(password2).on('keyup', function() {
		if (password1.val() && password2.val() === password1.val()) {
			$('#match').removeClass().addClass('match').html('<img src="catalog/view/theme/<?php echo $template; ?>/image/account/tick.png" alt="" />');
		} else {
			$('#match').removeClass('match').addClass('hidden').html('');
		}
	});
});
//--></script>

<?php echo $footer; ?>