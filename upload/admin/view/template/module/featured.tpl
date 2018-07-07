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
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-1"><span><?php echo $tab_general; ?></span></a>
        <a href="#tab-2"><span><?php echo $tab_options; ?></span></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="featured">	
        <div id="tab-1" style="clear:both;">
        <table class="form">
        <tbody>
          <tr>
            <td><?php echo $entry_theme; ?></td>
            <td><?php if ($featured_theme) { ?>
              <input type="radio" name="featured_theme" value="1" id="theme-on" class="radio" checked />
              <label for="theme-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_theme" value="0" id="theme-off" class="radio" />
              <label for="theme-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="featured_theme" value="1" id="theme-on" class="radio" />
              <label for="theme-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_theme" value="0" id="theme-off" class="radio" checked />
              <label for="theme-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_title; ?></td>
            <td><?php foreach ($languages as $language) { ?>
              <input type="text" name="featured_title<?php echo $language['language_id']; ?>" id="featured_title<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'featured_title' . $language['language_id']}; ?>" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
            <?php } ?></td>
          </tr>
          <tr class="highlighted">
            <td><?php echo $entry_product; ?></td>
            <td><input type="text" name="product" value="" size="30" /></td>
          </tr>
          <tr class="highlighted">
            <td>&nbsp;</td>
            <td>
              <div class="scrollbox" id="featured-product" style="height:180px;">
                <?php $class='odd'; ?>
                <?php foreach ($products as $product) { ?>
                  <?php $class=($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="featured-product<?php echo $product['product_id']; ?>" class="<?php echo $class; ?>"><?php echo $product['name']; ?> <img src="view/image/delete.png" alt="" />
                    <input type="hidden" value="<?php echo $product['product_id']; ?>" />
                  </div>
                <?php } ?>
              </div>
              <input type="hidden" name="featured_product" value="<?php echo $featured_product; ?>" />
            </td>
          </tr>
        <tbody>
        </table>
        </div>
        <div id="tab-2" style="clear:both;">
        <table class="form">
          <tr>
            <td><?php echo $entry_brand; ?></td>
            <td><?php if ($featured_brand) { ?>
              <input type="radio" name="featured_brand" value="1" id="brand-on" class="radio" checked />
              <label for="brand-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_brand" value="0" id="brand-off" class="radio" />
              <label for="brand-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="featured_brand" value="1" id="brand-on" class="radio" />
              <label for="brand-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_brand" value="0" id="brand-off" class="radio" checked />
              <label for="brand-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_model; ?></td>
            <td><?php if ($featured_model) { ?>
              <input type="radio" name="featured_model" value="1" id="model-on" class="radio" checked />
              <label for="model-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_model" value="0" id="model-off" class="radio" />
              <label for="model-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="featured_model" value="1" id="model-on" class="radio" />
              <label for="model-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_model" value="0" id="model-off" class="radio" checked />
              <label for="model-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_reward; ?></td>
            <td><?php if ($featured_reward) { ?>
              <input type="radio" name="featured_reward" value="1" id="reward-on" class="radio" checked />
              <label for="reward-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_reward" value="0" id="reward-off" class="radio" />
              <label for="reward-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="featured_reward" value="1" id="reward-on" class="radio" />
              <label for="reward-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_reward" value="0" id="reward-off" class="radio" checked />
              <label for="reward-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_point; ?></td>
            <td><?php if ($featured_point) { ?>
              <input type="radio" name="featured_point" value="1" id="point-on" class="radio" checked />
              <label for="point-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_point" value="0" id="point-off" class="radio" />
              <label for="point-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="featured_point" value="1" id="point-on" class="radio" />
              <label for="point-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_point" value="0" id="point-off" class="radio" checked />
              <label for="point-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_review; ?></td>
            <td><?php if ($featured_review) { ?>
              <input type="radio" name="featured_review" value="1" id="review-on" class="radio" checked />
              <label for="review-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_review" value="0" id="review-off" class="radio" />
              <label for="review-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="featured_review" value="1" id="review-on" class="radio" />
              <label for="review-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_review" value="0" id="review-off" class="radio" checked />
              <label for="review-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr class="highlighted">
            <td><?php echo $entry_viewproduct; ?></td>
            <td><?php if ($featured_viewproduct) { ?>
              <input type="radio" name="featured_viewproduct" value="1" id="viewproduct-on" class="radio" checked />
              <label for="viewproduct-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_viewproduct" value="0" id="viewproduct-off" class="radio" />
              <label for="viewproduct-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="featured_viewproduct" value="1" id="viewproduct-on" class="radio" />
              <label for="viewproduct-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_viewproduct" value="0" id="viewproduct-off" class="radio" checked />
              <label for="viewproduct-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr class="highlighted">
            <td><?php echo $entry_addproduct; ?></td>
            <td><?php if ($featured_addproduct) { ?>
              <input type="radio" name="featured_addproduct" value="1" id="addproduct-on" class="radio" checked />
              <label for="addproduct-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_addproduct" value="0" id="addproduct-off" class="radio" />
              <label for="addproduct-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="featured_addproduct" value="1" id="addproduct-on" class="radio" />
              <label for="addproduct-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="featured_addproduct" value="0" id="addproduct-off" class="radio" checked />
              <label for="addproduct-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        </table>
        </div>
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><span class="required">*</span> <?php echo $entry_image; ?></td>
              <td class="left"><?php echo $entry_layout; ?></td>
              <td class="left"><?php echo $entry_position; ?></td>
              <td class="left"><?php echo $entry_status; ?></td>
              <td class="left"><?php echo $entry_sort_order; ?></td>
              <td></td>
            </tr>
          </thead>
        <?php $module_row = 0; ?>
        <?php foreach ($modules as $module) { ?>
          <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
              <td class="left">
                <input type="text" name="featured_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" /> x 
                <input type="text" name="featured_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" /> px
                <?php if (isset($error_image[$module_row])) { ?>
                  <span class="error"><?php echo $error_image[$module_row]; ?></span>
                <?php } ?>
              </td>
              <td class="left"><select name="featured_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
              <td class="left"><select name="featured_module[<?php echo $module_row; ?>][position]">
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
              <td class="left"><select name="featured_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
              <td class="center">
                <input type="text" name="featured_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
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
              <td colspan="5"></td>
              <td class="center"><a onclick="addModule();" class="button ripple"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#featured-product' + ui.item.value).remove();

		$('#featured-product').append('<div id="featured-product' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" value="' + ui.item.value + '" /></div>');

		$('#featured-product div:odd').attr('class', 'odd');
		$('#featured-product div:even').attr('class', 'even');

		data = $.map($('#featured-product input'), function(element) {
			return $(element).attr('value');
		});

		$('input[name=\'featured_product\']').attr('value', data.join());

		return false;
	}
});

$('#featured-product div img').live('click', function() {
	$(this).parent().remove();

	$('#featured-product div:odd').attr('class', 'odd');
	$('#featured-product div:even').attr('class', 'even');

	data = $.map($('#featured-product input'), function(element) {
		return $(element).attr('value');
	});

	$('input[name=\'featured_product\']').attr('value', data.join());
});
//--></script>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left">';
	html += '      <input type="text" name="featured_module[' + module_row + '][image_width]" value="120" size="3" /> x ';
	html += '      <input type="text" name="featured_module[' + module_row + '][image_height]" value="120" size="3" /> px';
	html += '    </td>';
	html += '    <td class="left"><select name="featured_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="featured_module[' + module_row + '][position]">';
	html += '      <option value="content_header"><?php echo $text_content_header; ?></option>';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="content_footer"><?php echo $text_content_footer; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="featured_module[' + module_row + '][status]">';
	html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '      <option value="0"><?php echo $text_disabled; ?></option>';
	html += '    </select></td>';
	html += '    <td class="center"><input type="text" name="featured_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="center"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button-delete ripple"><?php echo $button_remove; ?></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}
//--></script>

<script type="text/javascript"><!--
$(function() {
	$('#tabs a').tabs();
});
//--></script>

<?php echo $footer; ?>