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
        <a onclick="location='<?php echo $refresh; ?>';" class="button ripple"><i class="fa fa-refresh"></i> &nbsp; <?php echo $button_refresh; ?></a>
        <a onclick="location='<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content-body">
      <div class="tooltip" style="margin:5px 0 15px 0;"><?php echo $help_function; ?></div>
      <form action="<?php echo $csv_import; ?>" method="post" enctype="multipart/form-data" id="import-raw">
        <h2><?php echo $heading_import; ?></h2>
        <table class="tool">
          <tr>
            <td width="20%"><?php echo $entry_import; ?></td>
            <td><input type="file" name="csv_import" class="custom-input-class" /></td>
          </tr>
          <tr>
            <td width="20%"></td>
            <td><a onclick="$('#import-raw').submit();" class="button-filter animated fadeIn ripple"><i class="fa fa-upload"></i> &nbsp;&nbsp; <?php echo $button_import; ?></a></td>
          </tr>
        </table>
      </form>
      <form action="<?php echo $csv_export; ?>" method="post" enctype="multipart/form-data" id="export-raw">
        <h2><?php echo $heading_export; ?></h2>
        <table class="tool">
          <tr>
            <td width="20%"><?php echo $entry_export; ?></td>
            <td><select name="csv_export">
              <?php foreach ($tables as $table) { ?>
                <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td width="20%"></td>
            <td><a onclick="$('#export-raw').submit();" class="button-filter animated fadeIn ripple"><i class="fa fa-download"></i> &nbsp;&nbsp; <?php echo $button_export; ?></a></td>
          </tr>
        </table>
        <h2><?php echo $heading_parameter; ?></h2>
        <table class="form">
          <tr>
            <td colspan="2"><?php echo $text_spreadsheet; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_charset; ?></td>
            <td>Unicode UTF-8</td>
          </tr>
          <tr>
            <td><?php echo $text_delimiter; ?></td>
            <td>;</td>
          </tr>
          <tr>
            <td><?php echo $text_enclosure; ?></td>
            <td>"</td>
          </tr>
          <tr>
            <td><?php echo $text_escaped; ?></td>
            <td>"</td>
          </tr>
          <tr>
            <td><?php echo $text_ending; ?></td>
            <td>"/n"</td>
          </tr>
        </table>
      </form>
      <div class="attention" style="margin:35px 0 5px 0;"><?php echo $help_caution; ?></div>
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