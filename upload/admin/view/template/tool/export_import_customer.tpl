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
        <a onclick="location = '<?php echo $refresh; ?>';" class="button"><?php echo $button_refresh; ?></a>
        <a onclick="location = '<?php echo $close; ?>';" class="button-cancel"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content">
      <div class="tooltip" style="margin:5px 0px 15px 0px;"><?php echo $help_function; ?></div>
      <form action="<?php echo $csv_export; ?>" method="post" enctype="multipart/form-data" id="export-customer">
        <h2><?php echo $heading_export; ?></h2>
        <table class="tool">
          <tr>
            <td><?php echo $entry_export; ?></td>
            <td><div class="scrollbox" style="height:220px; margin-bottom:5px;">
              <?php $class = 'odd'; ?>
              <?php foreach ($headers as $header) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <?php if (in_array($header, $export)) { ?>
                    <input type="checkbox" name="header[export][]" value="<?php echo $header; ?>" checked="checked" />
                    <?php echo $header; ?>
                  <?php } else { ?>
                    <input type="checkbox" name="header[export][]" value="<?php echo $header; ?>" />
                    <?php echo $header; ?>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
            <a onclick="$(this).parent().find(':checkbox').attr('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').attr('checked', false);" class="button-unselect"></a></td>
          </tr>
          <tr>
		    <td width="20%"></td>
            <td><a onclick="$('#export-customer').submit();" class="button-filter"><?php echo $button_export; ?></a></td>
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
    </div>
  </div>
</div>
<?php echo $footer; ?>