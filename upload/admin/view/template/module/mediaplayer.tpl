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
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location = '<?php echo $library; ?>';" class="button ripple"><i class="fa fa-video-camera"></i> &nbsp; <?php echo $button_library; ?></a>
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="mediaplayer">
        <table class="form">
        <tbody>
          <tr>
            <td><?php echo $entry_theme; ?></td>
            <td><?php if ($mediaplayer_theme) { ?>
              <input type="radio" name="mediaplayer_theme" value="1" id="theme-on" class="radio" checked />
              <label for="theme-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="mediaplayer_theme" value="0" id="theme-off" class="radio" />
              <label for="theme-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="mediaplayer_theme" value="1" id="theme-on" class="radio" />
              <label for="theme-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="mediaplayer_theme" value="0" id="theme-off" class="radio" checked />
              <label for="theme-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_title; ?></td>
            <td><?php foreach ($languages as $language) { ?>
              <input type="text" name="mediaplayer_title<?php echo $language['language_id']; ?>" id="mediaplayer_title<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'mediaplayer_title' . $language['language_id']}; ?>" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_image; ?></td>
            <td><div class="image"><img src="<?php echo $mediaplayer_thumb; ?>" alt="" id="thumb" /><br />
              <input type="hidden" name="mediaplayer_image" value="<?php echo $mediaplayer_image; ?>" id="image" />
              <a onclick="image_upload('image', 'thumb');" class="button-browse"></a><a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');" class="button-recycle"></a>
            </div>
            <?php if ($error_image) { ?>
              <span class="error"><?php echo $error_image; ?></span>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $text_entry_help; ?></td>
            <td><?php echo $text_help; ?></td>
          </tr>
        </tbody>
        </table>
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_media; ?></td>
              <td class="left"><?php echo $entry_dimension; ?></td>
              <td class="left"><?php echo $entry_layout; ?></td>
              <td class="left"><?php echo $entry_position; ?></td>
              <td class="left"><?php echo $entry_status; ?></td>
              <td class="center"><?php echo $entry_sort_order; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $module_row = 0; ?>
          <?php foreach ($modules as $module) { ?>
            <tbody id="module-row<?php echo $module_row; ?>">
              <tr>
                <td class="left"><select name="mediaplayer_module[<?php echo $module_row; ?>][media_id]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($medias as $media) { ?>
                    <?php if ($media['media_id'] == $module['media_id']) { ?>
                      <option value="<?php echo $media['media_id']; ?>" selected="selected"><?php echo $media['name']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $media['media_id']; ?>"><?php echo $media['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select></td>
                <td class="left">
                  <input type="text" name="mediaplayer_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" /> x 
                  <input type="text" name="mediaplayer_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" /> px
                </td>
                <td class="left"><select name="mediaplayer_module[<?php echo $module_row; ?>][layout_id]">
                  <?php foreach ($layouts as $layout) { ?>
                    <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                      <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select></td>
                <td class="left"><select name="mediaplayer_module[<?php echo $module_row; ?>][position]">
                  <?php if ($module['position'] == 'content_header') { ?>
                    <option value="content_header" selected="selected"><?php echo $text_content_header; ?></option>
                  <?php } else { ?>
                    <option value="content_header"><?php echo $text_content_header; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'content_top') { ?>
                    <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                  <?php } else { ?>
                    <option value="content_top"><?php echo $text_content_top; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'content_bottom') { ?>
                    <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                  <?php } else { ?>
                    <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'content_footer') { ?>
                    <option value="content_footer" selected="selected"><?php echo $text_content_footer; ?></option>
                  <?php } else { ?>
                    <option value="content_footer"><?php echo $text_content_footer; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_left') { ?>
                    <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                  <?php } else { ?>
                    <option value="column_left"><?php echo $text_column_left; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_right') { ?>
                    <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                  <?php } else { ?>
                    <option value="column_right"><?php echo $text_column_right; ?></option>
                  <?php } ?>
                </select></td>
                <td class="left"><select name="mediaplayer_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
                <td class="center">
                  <input type="text" name="mediaplayer_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
                </td>
                <td class="center">
                  <a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a>
                </td>
              </tr>
            </tbody>
            <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="6" class="script">Powered by <?php echo $mediaplayer_plugin; ?> <?php echo $mediaplayer_version; ?></td>
              <td class="center"><a onclick="addModule();" class="button ripple"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="mediaplayer_module[' + module_row + '][media_id]">';
	html += '      <option value="0"><?php echo $text_none; ?></option>';
	<?php foreach ($medias as $media) { ?>
	html += '      <option value="<?php echo $media['media_id']; ?>"><?php echo $media['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left">';
	html += '      <input type="text" name="mediaplayer_module[' + module_row + '][image_width]" value="480" size="3" /> x ';
	html += '      <input type="text" name="mediaplayer_module[' + module_row + '][image_height]" value="320" size="3" /> px';
	html += '    </td>';
	html += '    <td class="left"><select name="mediaplayer_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="mediaplayer_module[' + module_row + '][position]">';
	html += '      <option value="content_header"><?php echo $text_content_header; ?></option>';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="content_footer"><?php echo $text_content_footer; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="mediaplayer_module[' + module_row + '][status]">';
	html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '      <option value="0"><?php echo $text_disabled; ?></option>';
	html += '    </select></td>';
	html += '    <td class="center"><input type="text" name="mediaplayer_module[' + module_row + '][sort_order]" value="1" size="3" /></td>';
	html += '    <td class="center"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}
//--></script>

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