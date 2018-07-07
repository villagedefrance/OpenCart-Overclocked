<?php echo $header_login; ?>
<?php if ($logged) { ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/user.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#forgotten').submit();" class="button-save ripple"><?php echo $button_reset; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <div class="tooltip" style="margin:15px 0 5px 0;"><?php echo $text_email; ?></div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="forgotten">
      <table class="form">
        <tr>
          <td><?php echo $entry_email; ?></td>
          <td><input type="text" name="email" value="<?php echo $email; ?>" size="40" /></td>
        </tr>
      </table>
    </form>
    </div>
  </div>
</div>
<?php } else { ?>
<div id="content-login">
  <div class="box-login animated fadeIn">
    <div class="content-login">
    <h2 style="margin:20px 0 30px 15px;"><?php echo $heading_title; ?></h2>
    <?php if ($error_warning) { ?>
      <div class="warning" style="margin:10px;"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="tooltip" style="margin:15px 10px 5px 10px;"><?php echo $text_email; ?></div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="forgotten">
      <div style="margin:10px 0 10px 0;"><?php echo $entry_email; ?></div>
      <div style="margin:0 0 30px 0;">
        <input type="text" name="email" value="<?php echo $email; ?>" size="40" />
      </div>
      <div class="validate animated fadeIn">
        <a onclick="$('#forgotten').submit();" class="button-save ripple"><?php echo $button_reset; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </form>
    </div>
  </div>
</div>
<?php } ?>
<?php echo $footer_login; ?>