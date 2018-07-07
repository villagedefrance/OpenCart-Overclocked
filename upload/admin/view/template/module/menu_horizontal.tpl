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
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="menu_horizontal">
        <table class="form">
        <tbody>
          <tr>
            <td><a href="<?php echo $manager; ?>" class="button ripple"><i class="fa fa-reorder"></i> &nbsp; <?php echo $button_manager; ?></a></td>
            <td><b><i><?php echo $text_manage_menu; ?></i></b></td>
          </tr>
          <tr>
            <td><?php echo $entry_theme; ?></td>
            <td><?php if ($menu_horizontal_theme == 'light') { ?>
              <input type="radio" name="menu_horizontal_theme" value="light" id="light" class="checkbox" checked="checked" />
            <?php } else { ?>
              <input type="radio" name="menu_horizontal_theme" value="light" id="light" class="checkbox" />
            <?php } ?>
            <label for="light"><?php echo $text_light; ?>&nbsp;&nbsp;<span></span></label>
            <?php if ($menu_horizontal_theme == 'dark') { ?>
              <input type="radio" name="menu_horizontal_theme" value="dark" id="dark" class="checkbox" checked="checked" />
            <?php } else { ?>
              <input type="radio" name="menu_horizontal_theme" value="dark" id="dark" class="checkbox" />
            <?php } ?>
            <label for="dark"><?php echo $text_dark; ?>&nbsp;&nbsp;<span></span></label>
            <?php if ($menu_horizontal_theme == 'custom') { ?>
              <input type="radio" name="menu_horizontal_theme" value="custom" id="custom" class="checkbox" checked="checked" />
            <?php } else { ?>
              <input type="radio" name="menu_horizontal_theme" value="custom" id="custom" class="checkbox" />
            <?php } ?>
            <label for="custom"><?php echo $text_custom; ?>&nbsp;&nbsp;<span></span></label>
            </td>
          </tr>
        </tbody>
        <tbody id="theme-custom" class="menu-theme">
          <tr class="highlighted">
            <td><?php echo $entry_header_color; ?></td>
            <td><select name="menu_horizontal_header_color">
              <?php foreach ($skins as $skin) { ?>
                <?php if ($skin['skin'] == $menu_horizontal_header_color) { ?>
                  <option value="<?php echo $skin['skin']; ?>" style="background-color:<?php echo $skin['color']; ?>; padding:2px 4px;" selected="selected"><?php echo $skin['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $skin['skin']; ?>" style="background-color:<?php echo $skin['color']; ?>; padding:2px 4px;"><?php echo $skin['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr class="highlighted">
            <td><?php echo $entry_header_shape; ?></td>
            <td><select name="menu_horizontal_header_shape">
              <?php foreach ($shapes as $shape) { ?>
                <?php if ($shape['shape'] == $menu_horizontal_header_shape) { ?>
                  <option value="<?php echo $shape['shape']; ?>" selected="selected"><?php echo $shape['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $shape['shape']; ?>"><?php echo $shape['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td><?php echo $entry_column_limit; ?></a></td>
            <td><input type="text" name="menu_horizontal_column_limit" value="<?php echo $menu_horizontal_column_limit; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_column_number; ?></a></td>
            <td><input type="text" name="menu_horizontal_column_number" value="<?php echo $menu_horizontal_column_number; ?>" size="3" /></td>
          </tr>
        <tbody>
        </table>
        <h3><?php echo $text_menus; ?></h3>
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><span class="required">*</span> <?php echo $entry_menu; ?></td>
              <td class="left"><?php echo $entry_home; ?></td>
              <td class="left"><?php echo $entry_layout; ?></td>
              <td class="left"><?php echo $entry_position; ?></td>
              <td class="left"><?php echo $entry_direction; ?></td>
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
              <?php if ($menus) { ?>
              <select name="menu_horizontal_module[<?php echo $module_row; ?>][menu_id]">
                <?php foreach ($menus as $menu) { ?>
                  <?php if ($menu['menu_id'] == $module['menu_id']) { ?>
                    <option value="<?php echo $menu['menu_id']; ?>" selected="selected"><?php echo $menu['title']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $menu['menu_id']; ?>"><?php echo $menu['title']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
              <?php } else { ?>
                <?php echo $text_no_menu; ?>
              <?php } ?>
              <?php if (isset($error_menu[$module_row])) { ?>
                <span class="error"><?php echo $error_menu[$module_row]; ?></span>
              <?php } ?>
              </td>
              <td class="left"><?php echo $text_icon; ?> &nbsp;
                <input type="checkbox" name="menu_horizontal_module[<?php echo $module_row; ?>][home]" value="1" <?php if (isset($module['home'])) { echo 'checked="checked"'; } ?> />
              </td>
              <td class="left"><select name="menu_horizontal_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
              <td class="left"><select name="menu_horizontal_module[<?php echo $module_row; ?>][position]">
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
              </select></td>
              <td class="left"><select name="menu_horizontal_module[<?php echo $module_row; ?>][direction]">
                <?php if ($module['direction']) { ?>
                  <option value="1" selected="selected"><?php echo $text_ltr; ?></option>
                  <option value="0"><?php echo $text_rtl; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_ltr; ?></option>
                  <option value="0" selected="selected"><?php echo $text_rtl; ?></option>
                <?php } ?>
              </select></td>
              <td class="left"><select name="menu_horizontal_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
              <td class="center"><input type="text" name="menu_horizontal_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="center"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="7"></td>
              <td class="center"><a onclick="addModule();" class="button ripple"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('input[name=\'menu_horizontal_theme\']').bind('change', function() {
	$('.menu-theme').hide();
	$('#theme-' + this.value).show();
});

$('input[name=\'menu_horizontal_theme\']:checked').trigger('change');
//--></script>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left">';
    <?php if ($menus) { ?>
	html += '    <select name="menu_horizontal_module[' + module_row + '][menu_id]">';
	<?php foreach ($menus as $menu) { ?>
	html += '      <option value="<?php echo $menu['menu_id']; ?>"><?php echo addslashes($menu['title']); ?></option>';
	<?php } ?>
	html += '    </select>';
	<?php } else { ?>
	html += '  <?php echo $text_no_menu; ?>';
	<?php } ?>
	html += '    </td>';
	html += '    <td class="left">';
	html += '      <?php echo $text_icon; ?> &nbsp;<input type="checkbox" name="menu_horizontal_module[' + module_row + '][home]" value="1" />';
	html += '    </td>';
	html += '    <td class="left"><select name="menu_horizontal_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="menu_horizontal_module[' + module_row + '][position]">';
	html += '      <option value="content_header"><?php echo $text_content_header; ?></option>';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="content_footer"><?php echo $text_content_footer; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="menu_horizontal_module[' + module_row + '][direction]">';
	html += '      <option value="1" selected="selected"><?php echo $text_ltr; ?></option>';
	html += '      <option value="0"><?php echo $text_rtl; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="menu_horizontal_module[' + module_row + '][status]">';
	html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '      <option value="0"><?php echo $text_disabled; ?></option>';
	html += '    </select></td>';
	html += '    <td class="center"><input type="text" name="menu_horizontal_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="center"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}
//--></script>

<?php echo $footer; ?>