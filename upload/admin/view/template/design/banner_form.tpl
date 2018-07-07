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
      <h1><img src="view/image/banner.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_name; ?></td>
          <td><?php if ($error_name) { ?>
            <input type="text" name="name" value="<?php echo $name; ?>" size="30" class="input-error" />
            <span class="error"><?php echo $error_name; ?></span>
          <?php } else { ?>
            <input type="text" name="name" value="<?php echo $name; ?>" size="30" />
          <?php } ?></td>
        </tr>
        <tr class="highlighted">
          <td><?php echo $entry_status; ?></td>
          <td><select name="status">
            <?php if ($status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><?php echo $text_link; ?></td>
          <td><?php echo $text_info; ?></td>
        </tr>
      </table>
      <table id="images" class="list">
        <thead>
          <tr>
            <td class="left"><span class="required">*</span> <?php echo $entry_title; ?></td>
            <td class="left"><span class="required">*</span> <?php echo $entry_image; ?></td>
            <td class="left"><?php echo $entry_link; ?></td>
            <td class="left"><?php echo $entry_external_link; ?></td>
            <td class="left"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>
        <?php $image_row = 0; ?>
        <?php foreach ($banner_images as $banner_image) { ?>
        <tbody id="image-row<?php echo $image_row; ?>">
          <tr>
            <td class="left"><?php foreach ($languages as $language) { ?>
              <input type="text" name="banner_image[<?php echo $image_row; ?>][banner_image_description][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($banner_image['banner_image_description'][$language['language_id']]) ? $banner_image['banner_image_description'][$language['language_id']]['title'] : ''; ?>" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
              <?php if (isset($error_banner_image[$image_row][$language['language_id']])) { ?>
                <span class="error"><?php echo $error_banner_image[$image_row][$language['language_id']]; ?></span>
              <?php } ?>
            <?php } ?></td>
            <td class="center"><div class="image"><img src="<?php echo $banner_image['thumb']; ?>" alt="" id="thumb<?php echo $image_row; ?>" /><br />
              <input type="hidden" name="banner_image[<?php echo $image_row; ?>][image]" value="<?php echo $banner_image['image']; ?>" id="image<?php echo $image_row; ?>" />
              <a onclick="image_upload('image<?php echo $image_row; ?>', 'thumb<?php echo $image_row; ?>');" class="button-browse"></a><a onclick="$('#thumb<?php echo $image_row; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $image_row; ?>').attr('value', '');" class="button-recycle"></a>
            </div>
            <?php if (isset($error_image[$image_row])) { ?>
              <span class="error"><?php echo $error_image[$image_row]; ?></span>
            <?php } ?>
            </td>
            <td class="left"><input type="text" name="banner_image[<?php echo $image_row; ?>][link]" value="<?php echo $banner_image['link']; ?>" size="40" /></td>
            <td class="center"><select name="banner_image[<?php echo $image_row; ?>][external_link]">
              <?php if ($banner_image['external_link']) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select></td>
            <td class="center"><input type="text" name="banner_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $banner_image['sort_order']; ?>" size="2" /></td>
            <td class="center"><a onclick="$('#image-row<?php echo $image_row; ?>').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>
          </tr>
        </tbody>
        <?php $image_row++; ?>
        <?php } ?>
        <tfoot>
          <tr>
            <td colspan="5"></td>
            <td class="center"><a onclick="addImage();" class="button"><?php echo $button_add_banner; ?></a></td>
          </tr>
        </tfoot>
      </table>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
	html  = '<tbody id="image-row' + image_row + '">';
	html += '  <tr>';
	html += '    <td class="left">';
	<?php foreach ($languages as $language) { ?>
	html += '      <input type="text" name="banner_image[' + image_row + '][banner_image_description][<?php echo $language['language_id']; ?>][title]" value="" /> <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />'; 
	<?php } ?>
	html += '    </td>';
	html += '    <td class="center"><div class="image"><img src="<?php echo $no_image; ?>" alt="" id="thumb' + image_row + '" /><br />';
	html += '      <input type="hidden" name="banner_image[' + image_row + '][image]" value="" id="image' + image_row + '" />';
	html += '      <a onclick="image_upload(\'image' + image_row + '\', \'thumb' + image_row + '\');" class="button-browse"></a><a onclick="$(\'#thumb' + image_row + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#image' + image_row + '\').attr(\'value\', \'\');" class="button-recycle"></a>';
	html += '    </div></td>';
	html += '    <td class="left"><input type="text" name="banner_image[' + image_row + '][link]" value="" size="40" /></td>';
	html += '    <td class="center"><select name="banner_image[' + image_row + '][external_link]">';
	html += '      <option value="1"><?php echo $text_yes; ?></option>';
	html += '      <option value="0" selected="selected"><?php echo $text_no; ?></option>';
	html += '    </select></td>';
	html += '    <td class="center"><input type="text" name="banner_image[' + image_row + '][sort_order]" value="0" size="2" /></td>';
	html += '    <td class="center"><a onclick="$(\'#image-row' + image_row  + '\').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#images > tfoot').before(html);

	image_row++;
};
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.3,
		width: <?php echo ($this->browser->checkMobile()) ? 580 : 760; ?>,
		height: 400
	});
});
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