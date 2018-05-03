<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
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
  <div class="attention"><?php echo $text_delete_warning; ?></div>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" name="delete">
    <div class="content">
      <div class="content-info">
        <b><?php echo $text_delete_account; ?></b>
      </div>
      <br />
      <br />
      <table class="form">
        <tr>
          <td><span class="required">*</span> <b><?php echo $entry_password; ?></b></td>
          <td><input type="password" name="password" value="<?php echo $password; ?>" /></td>
        </tr>
      <?php if ($error_password) { ?>
        <tr>
          <td colspan="2"><span class="error"><?php echo $error_password; ?></span></td>
        </tr>
        <?php } ?>
      </table>
      <div id="captcha-wrap">
        <div class="captcha-box">
          <div class="captcha-view">
            <img src="<?php echo $captcha_image; ?>" alt="" id="captcha-image" />
          </div>
        </div>
        <div class="captcha-text">
          <label><?php echo $entry_captcha; ?></label>
          <input type="text" name="captcha" id="captcha" value="<?php echo $captcha; ?>" autocomplete="off" />
        </div>
        <div class="captcha-action"><i class="fa fa-repeat"></i></div>
      </div>
      <br />
    <?php if ($error_captcha) { ?>
      <span class="error"><?php echo $error_captcha; ?></span>
    <?php } ?>
    </div>
    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><i class="fa fa-arrow-left"></i> &nbsp; <?php echo $button_back; ?></a></div>
      <div class="right">
        <input type="submit" value="<?php echo $button_delete; ?>" class="button-danger" />
      </div>
    </div>
  </form>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

<script type="text/javascript"><!--
$('img#captcha-image').on('load', function(event) {
	$(event.target).show();
});
$('img#captcha-image').trigger('load');
//--></script>

<?php echo $footer; ?>