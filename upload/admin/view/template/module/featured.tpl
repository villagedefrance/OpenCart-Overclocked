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
        <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
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
          <tr>
            <td><?php echo $entry_theme; ?></td>
            <td><?php if ($featured_theme) { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_theme" value="1" checked="checked" />
              <?php echo $text_no; ?><input type="radio" name="featured_theme" value="0" />
            <?php } else { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_theme" value="1" />
              <?php echo $text_no; ?><input type="radio" name="featured_theme" value="0" checked="checked" />
            <?php } ?></td>
          </tr>
        <?php foreach ($languages as $language) { ?>
          <tr>
            <td><?php echo $entry_title; ?></td>
            <td>
              <input type="text" name="featured_title<?php echo $language['language_id']; ?>" id="featured_title<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'featured_title' . $language['language_id']}; ?>" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
            </td>
          </tr>
        <?php } ?>
          <tr style="background:#FCFCFC;">
            <td><?php echo $entry_product; ?></td>
            <td><input type="text" name="product" value="" size="30" /></td>
          </tr>
          <tr style="background:#FCFCFC;">
            <td>&nbsp;</td>
            <td>
              <div class="scrollbox" id="featured-product" style="height:180px;">
                <?php $class = 'odd'; ?>
                <?php foreach ($products as $product) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="featured-product<?php echo $product['product_id']; ?>" class="<?php echo $class; ?>"><?php echo $product['name']; ?> <img src="view/image/delete.png" alt="" />
                    <input type="hidden" value="<?php echo $product['product_id']; ?>" />
                  </div>
                <?php } ?>
              </div>
              <input type="hidden" name="featured_product" value="<?php echo $featured_product; ?>" />
			</td>
          </tr>
        </table>
        </div>
        <div id="tab-2" style="clear:both;">
        <table class="form">
          <tr>
            <td><?php echo $entry_brand; ?></td> 
            <td><?php if ($featured_brand) { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_brand" value="1" checked="checked" />
              <?php echo $text_no; ?><input type="radio" name="featured_brand" value="0" />
            <?php } else { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_brand" value="1" />
              <?php echo $text_no; ?><input type="radio" name="featured_brand" value="0" checked="checked" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_model; ?></td> 
            <td><?php if ($featured_model) { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_model" value="1" checked="checked" />
              <?php echo $text_no; ?><input type="radio" name="featured_model" value="0" />
            <?php } else { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_model" value="1" />
              <?php echo $text_no; ?><input type="radio" name="featured_model" value="0" checked="checked" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_reward; ?></td> 
            <td><?php if ($featured_reward) { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_reward" value="1" checked="checked" />
              <?php echo $text_no; ?><input type="radio" name="featured_reward" value="0" />
            <?php } else { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_reward" value="1" />
              <?php echo $text_no; ?><input type="radio" name="featured_reward" value="0" checked="checked" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_point; ?></td> 
            <td><?php if ($featured_point) { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_point" value="1" checked="checked" />
              <?php echo $text_no; ?><input type="radio" name="featured_point" value="0" />
            <?php } else { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_point" value="1" />
              <?php echo $text_no; ?><input type="radio" name="featured_point" value="0" checked="checked" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_review; ?></td> 
            <td><?php if ($featured_review) { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_review" value="1" checked="checked" />
              <?php echo $text_no; ?><input type="radio" name="featured_review" value="0" />
            <?php } else { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_review" value="1" />
              <?php echo $text_no; ?><input type="radio" name="featured_review" value="0" checked="checked" />
            <?php } ?></td>
          </tr>
          <tr style="background:#FCFCFC;">
            <td><?php echo $entry_viewproduct; ?></td> 
            <td><?php if ($featured_viewproduct) { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_viewproduct" value="1" checked="checked" />
              <?php echo $text_no; ?><input type="radio" name="featured_viewproduct" value="0" />
            <?php } else { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_viewproduct" value="1" />
              <?php echo $text_no; ?><input type="radio" name="featured_viewproduct" value="0" checked="checked" />
            <?php } ?></td>
          </tr>
          <tr style="background:#FCFCFC;">
            <td><?php echo $entry_addproduct; ?></td> 
            <td><?php if ($featured_addproduct) { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_addproduct" value="1" checked="checked" />
              <?php echo $text_no; ?><input type="radio" name="featured_addproduct" value="0" />
            <?php } else { ?>
              <?php echo $text_yes; ?><input type="radio" name="featured_addproduct" value="1" />
              <?php echo $text_no; ?><input type="radio" name="featured_addproduct" value="0" checked="checked" />
            <?php } ?></td>
          </tr>
        </table>
        </div>
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_image; ?></td>
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
                <a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button-delete"><?php echo $button_remove; ?></a>
              </td>
            </tr>
          </tbody>
        <?php $module_row++; ?>
        <?php } ?>
          <tfoot>
            <tr>
              <td colspan="5"></td>
              <td class="center"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
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
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="featured_module[' + module_row + '][status]">';
	html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '      <option value="0"><?php echo $text_disabled; ?></option>';
	html += '    </select></td>';
	html += '    <td class="center"><input type="text" name="featured_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="center"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button-delete"><?php echo $button_remove; ?></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}
//--></script>

<script type="text/javascript"><!--
$(function() {$('#tabs a').tabs();});
//--></script>

<?php echo $footer; ?>