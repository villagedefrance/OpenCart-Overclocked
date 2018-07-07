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
      <h1><img src="view/image/category.png" alt="" /> <?php echo $category_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <div id="tabs" class="htabs">
      <a href="#tab-general"><?php echo $tab_general; ?></a>
      <a href="#tab-data"><?php echo $tab_data; ?></a>
      <a href="#tab-design"><?php echo $tab_design; ?></a>
    </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <div id="tab-general">
      <div id="languages" class="htabs">
        <?php foreach ($languages as $language) { ?>
          <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
        <?php } ?>
      </div>
      <?php foreach ($languages as $language) { ?>
      <div id="language<?php echo $language['language_id']; ?>">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><?php if (isset($error_name[$language['language_id']])) { ?>
              <input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" size="40" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" class="input-error" />
              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
            <?php } else { ?>
              <input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" size="40" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_meta_description; ?><span class="help"><?php echo $help_meta_description; ?></span></td>
            <td><textarea name="category_description[<?php echo $language['language_id']; ?>][meta_description]" id="meta-description<?php echo $language['language_id']; ?>" data-limit="156" cols="40" rows="5"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
            <span id="remaining<?php echo $language['language_id']; ?>"></span></td>
          </tr>
          <tr>
            <td><?php echo $entry_meta_keyword; ?><span class="help"><?php echo $help_meta_keyword; ?></span></td>
            <td><textarea name="category_description[<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="5"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_description; ?></td>
            <td><textarea name="category_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea></td>
          </tr>
        </table>
      </div>
      <?php } ?>
    </div>
    <div id="tab-data">
      <table class="form">
      <?php if ($autocomplete_off) { ?>
        <tr>
          <td><?php echo $entry_parent; ?></td>
          <td><select name="parent_id">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($categories as $category) { ?>
              <?php if ($category['category_id'] == $parent_id) { ?>
                <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
      <?php } else { ?>
        <tr>
          <td><?php echo $entry_parent; ?><?php echo $text_autocomplete; ?></td>
          <td><input type="text" name="path" value="<?php echo $path; ?>" size="40" />
            <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
          </td>
        </tr>
      <?php } ?>
      <?php if ($autocomplete_off) { ?>
        <tr>
          <td><?php echo $entry_filter; ?></td>
          <td><div class="scrollbox" style="width:350px; height:153px; margin-bottom:5px;">
            <?php $class = 'odd'; ?>
            <?php foreach ($filters as $filter) { ?>
              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
              <div class="<?php echo $class; ?>">
                <?php $category_filter_id = array(); ?>
                <?php foreach ($category_filters as $category_filter) { $category_filter_id[] = $category_filter['filter_id']; } ?>
                <?php if (in_array($filter['filter_id'], $category_filter_id)) { ?>
                  <input type="checkbox" name="category_filter[]" value="<?php echo $filter['filter_id']; ?>" checked="checked" />
                  <?php echo $filter['name']; ?>
                <?php } else { ?>
                  <input type="checkbox" name="category_filter[]" value="<?php echo $filter['filter_id']; ?>" />
                  <?php echo $filter['name']; ?>
                <?php } ?>
              </div>
            <?php } ?>
          </div>
          <a onclick="$(this).parent().find(':checkbox').attr('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').attr('checked', false);" class="button-unselect"></a>
          </td>
        </tr>
      <?php } else { ?>
        <tr>
          <td><?php echo $entry_filter; ?><?php echo $text_autocomplete; ?></td>
          <td><input type="text" name="filter" value="" size="40" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div id="category-filter" class="scrollbox">
            <?php $class = 'odd'; ?>
            <?php foreach ($category_filters as $category_filter) { ?>
              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
              <div id="category-filter<?php echo $category_filter['filter_id']; ?>" class="<?php echo $class; ?>"><?php echo $category_filter['name']; ?><img src="view/image/delete.png" alt="" />
                <input type="hidden" name="category_filter[]" value="<?php echo $category_filter['filter_id']; ?>" />
              </div>
            <?php } ?>
          </div></td>
        </tr>
      <?php } ?>
        <tr>
          <td><?php echo $entry_store; ?></td>
          <td><div id="store_ids" class="scrollbox-store">
            <?php $class = 'even'; ?>
            <div class="<?php echo $class; ?>">
              <?php if (in_array(0, $category_store)) { ?>
                <input type="checkbox" name="category_store[]" value="0" checked="checked" />
                <?php echo $text_default; ?>
              <?php } else { ?>
                <input type="checkbox" name="category_store[]" value="0" />
                <?php echo $text_default; ?>
              <?php } ?>
            </div>
            <?php foreach ($stores as $store) { ?>
              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
              <div class="<?php echo $class; ?>">
                <?php if (in_array($store['store_id'], $category_store)) { ?>
                  <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                  <?php echo $store['name']; ?>
                <?php } else { ?>
                  <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" />
                  <?php echo $store['name']; ?>
                <?php } ?>
              </div>
            <?php } ?>
          </div>
          <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="button-unselect"></a>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_keyword; ?><span class="help"><?php echo $help_keyword; ?></span></td>
          <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" size="40" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_image; ?></td>
          <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
            <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
            <a onclick="image_upload('image', 'thumb');" class="button-browse"></a><a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');" class="button-recycle"></a>
          </div>
          <?php if ($error_image) { ?>
            <span class="error"><?php echo $error_image; ?></span>
          <?php } ?>
          </td>
        </tr>
        <tr style="display:none;">
          <td><?php echo $entry_top; ?><span class="help"><?php echo $help_top; ?></span></td>
          <td><?php if ($top) { ?>
            <input type="checkbox" name="top" value="1" checked="checked" />
          <?php } else { ?>
            <input type="checkbox" name="top" value="1" />
          <?php } ?></td>
        </tr>
        <tr style="display:none;">
          <td><?php echo $entry_column; ?><span class="help"><?php echo $help_column; ?></span></td>
          <td><input type="text" name="column" value="<?php echo $column; ?>" size="1" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
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
      </table>
    </div>
    <div id="tab-design">
      <table class="list">
      <thead>
        <tr>
          <td class="left"><?php echo $column_store; ?></td>
          <td class="left"><?php echo $column_layout; ?></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="left"><?php echo $text_default; ?></td>
          <td class="left"><select name="category_layout[0][layout_id]">
            <option value=""><?php echo $text_none; ?></option>
            <?php foreach ($layouts as $layout) { ?>
              <?php if (isset($category_layout[0]) && $category_layout[0] == $layout['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
              <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
      </tbody>
      <?php foreach ($stores as $store) { ?>
      <tbody>
        <tr>
          <td class="left"><?php echo $store['name']; ?></td>
          <td class="left"><select name="category_layout[<?php echo $store['store_id']; ?>][layout_id]">
            <option value=""><?php echo $text_none; ?></option>
            <?php foreach ($layouts as $layout) { ?>
              <?php if (isset($category_layout[$store['store_id']]) && $category_layout[$store['store_id']] == $layout['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
              <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
      </tbody>
      <?php } ?>
      </table>
    </div>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>

<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});

$(document).ready(function() {
	$('#meta-description<?php echo $language['language_id']; ?>').on('load propertychange keyup input paste', function() {
		var limit = $(this).data("limit");
		var remain = limit - $(this).val().length;
		if (remain <= 0) {
			$(this).val($(this).val().substring(0, limit));
		}
		$('#remaining<?php echo $language['language_id']; ?>').text((remain <= 0) ? 0 : remain);
	});

	$('#meta-description<?php echo $language['language_id']; ?>').trigger('load');
});
<?php } ?>
//--></script>

<script type="text/javascript"><!--
$('input[name=\'path\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					'category_id': 0,
					'name': '<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.category_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'path\']').val(ui.item.label);
		$('input[name=\'parent_id\']').val(ui.item.value);

		return false;
	},
	focus: function(event, ui) {
		return false;
	}
});
//--></script>

<script type="text/javascript"><!--
$('input[name=\'filter\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.filter_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#category-filter' + ui.item.value).remove();

		$('#category-filter').append('<div id="category-filter' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="category_filter[]" value="' + ui.item.value + '" /></div>');

		$('#category-filter div:odd').attr('class', 'odd');
		$('#category-filter div:even').attr('class', 'even');

		return false;
	},
	focus: function(event, ui) {
		return false;
	}
});

$('#category-filter div img').live('click', function() {
	$(this).parent().remove();

	$('#category-filter div:odd').attr('class', 'odd');
	$('#category-filter div:even').attr('class', 'even');
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

<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
//--></script>

<?php echo $footer; ?>