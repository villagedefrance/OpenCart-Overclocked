<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location='<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content-body">
      <form action="<?php echo $restore; ?>" method="post" enctype="multipart/form-data" id="restore">
        <h2><?php echo $heading_restore; ?></h2>
        <table class="tool">
          <tr>
            <td width="20%"><?php echo $entry_restore; ?></td>
            <td><input type="file" name="import" class="custom-input-class" /></td>
          </tr>
          <tr>
            <td width="20%"></td>
            <td><a onclick="$('#restore').submit();" class="button-filter animated fadeIn"><i class="fa fa-upload"></i> &nbsp;&nbsp; <?php echo $button_restore; ?></a></td>
          </tr>
        </table>
      </form>
      <form action="<?php echo $backup; ?>" method="post" enctype="multipart/form-data" id="backup">
        <h2><?php echo $heading_backup; ?></h2>
        <table class="tool">
          <tr>
            <td width="20%"><?php echo $entry_backup; ?></td>
            <td><div class="scrollbox" style="height:220px; margin-bottom:5px;">
              <?php $class='odd'; ?>
              <?php foreach ($tables as $table) { ?>
                <?php $class=($class == 'even') ? 'odd' : 'even'; ?>
                <div class="<?php echo $class; ?>">
                  <input type="checkbox" name="backup[]" value="<?php echo $table; ?>" checked="checked" />
                <?php echo $table; ?></div>
              <?php } ?>
            </div>
            <a onclick="$(this).parent().find(':checkbox').attr('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').attr('checked', false);" class="button-unselect"></a></td>
          </tr>
          <tr>
            <td width="20%"></td>
            <td><a onclick="$('#backup').submit();" class="button-filter animated fadeIn"><i class="fa fa-download"></i> &nbsp;&nbsp; <?php echo $button_backup; ?></a></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript" src="view/javascript/jquery/sfi/js/jquery.simplefileinput.min.js"></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.custom-input-class').simpleFileInput({
		placeholder: '<?php echo $text_restore; ?>',
		buttonText: 'Select',
		allowedExts: ['sql'],
		width: 282
	});
});
//--></script>

<?php echo $footer; ?>