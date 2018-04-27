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
  <div class="box">
  <div class="heading">
    <h1><img src="view/image/download.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons">
      <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
      <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
      <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
    </div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_name; ?></td>
          <td><?php foreach ($languages as $language) { ?>
            <?php if (isset($error_name[$language['language_id']])) { ?>
              <input type="text" name="download_description[<?php echo $language['language_id']; ?>][name]" size="30" value="<?php echo isset($download_description[$language['language_id']]) ? $download_description[$language['language_id']]['name'] : ''; ?>" class="input-error" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
            <?php } else { ?>
              <input type="text" name="download_description[<?php echo $language['language_id']; ?>][name]" size="30" value="<?php echo isset($download_description[$language['language_id']]) ? $download_description[$language['language_id']]['name'] : ''; ?>" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
            <?php } ?>
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_filename; ?><span class="help"><?php echo $help_filename; ?></span></td>
          <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
            <input type="hidden" name="filename" value="<?php echo $filename; ?>" id="filename" />
            <a onclick="image_upload('filename', 'thumb');" class="button-browse"></a><a onclick="$('#thumb').attr('src', '<?php echo $no_file; ?>'); $('#filename').attr('value', '');" class="button-recycle"></a>
          </div>
          <?php if ($error_filename) { ?>
            <span class="error"><?php echo $error_filename; ?></span>
          <?php } ?>
          </td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_mask; ?><span class="help"><?php echo $help_mask; ?></span></td>
          <td><?php if ($error_mask) { ?>
            <input type="text" name="mask" value="<?php echo $mask; ?>" size="40" class="input-error" />
            <span class="error"><?php echo $error_mask; ?></span>
          <?php } else { ?>
            <input type="text" name="mask" value="<?php echo $mask; ?>" size="40" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_remaining; ?></td>
          <td><input type="text" name="remaining" value="<?php echo $remaining; ?>" size="6" /></td>
        </tr>
        <?php if ($download_id) { ?>
        <tr>
          <td><?php echo $entry_update; ?><span class="help"><?php echo $help_update; ?></span></td>
          <td>
            <input type="checkbox" name="update" value="1" id="push" class="checkbox" />
            <label for="push"><span></span></label>
          </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  </div>
</div>

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding:3px 0 0 0;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin:0; display:block; width:100%; height:100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function(event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: <?php echo ($this->browser->checkMobile()) ? 580 : 760; ?>,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>

<?php echo $footer; ?>