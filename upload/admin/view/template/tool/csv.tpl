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
        <a onclick="$('#csv-import').submit();" class="button-save"><?php echo $button_import; ?></a>
        <a onclick="$('#csv-export').submit();" class="button-save"><?php echo $button_export; ?></a>
        <a onclick="location = '<?php echo $refresh; ?>';" class="button"><?php echo $button_refresh; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $csv_import; ?>" method="post" enctype="multipart/form-data" id="csv-import">
        <h2><?php echo $heading_import; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_import; ?></td>
            <td><input type="file" name="csv_import" class="custom-input-class" /></td>
          </tr>
        </table>
      </form>
      <form action="<?php echo $csv_export; ?>" method="post" enctype="multipart/form-data" id="csv-export">
        <h2><?php echo $heading_export; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_export; ?></td>
            <td><select name="csv_export">
              <?php foreach ($tables as $table) { ?>
                <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
              <?php } ?>
            </select></td>
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
		placeholder: '<?php echo $text_import; ?>',
		buttonText: 'Select',
		allowedExts: ['csv'],
		width: 282
	});
});
//--></script>

<?php echo $footer; ?>