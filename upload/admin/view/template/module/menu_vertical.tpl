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
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="menu_vertical">
        <table class="form">
        <tbody>
          <tr>
            <td><a href="<?php echo $manager; ?>" class="button ripple"><i class="fa fa-reorder"></i> &nbsp; <?php echo $button_manager; ?></a></td>
            <td><b><i><?php echo $text_manage_menu; ?></i></b></td>
          </tr>
          <tr>
            <td><?php echo $entry_theme; ?></td>
            <td><?php if ($menu_vertical_theme) { ?>
              <input type="radio" name="menu_vertical_theme" value="1" id="theme-on" class="radio" checked />
              <label for="theme-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="menu_vertical_theme" value="0" id="theme-off" class="radio" />
              <label for="theme-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="menu_vertical_theme" value="1" id="theme-on" class="radio" />
              <label for="theme-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="menu_vertical_theme" value="0" id="theme-off" class="radio" checked />
              <label for="theme-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_title; ?></td>
            <td><?php foreach ($languages as $language) { ?>
              <input type="text" name="menu_vertical_title<?php echo $language['language_id']; ?>" id="menu_vertical_title<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'menu_vertical_title' . $language['language_id']}; ?>" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
            <?php } ?></td>
          </tr>
        </tbody>
        </table>
        <h3><?php echo $text_menus; ?></h3>
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><span class="required">*</span> <?php echo $entry_menu; ?></td>
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
              <select name="menu_vertical_module[<?php echo $module_row; ?>][menu_id]">
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
              <td class="left"><select name="menu_vertical_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
              <td class="left"><select name="menu_vertical_module[<?php echo $module_row; ?>][position]">
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
              <td class="left"><select name="menu_vertical_module[<?php echo $module_row; ?>][direction]">
                <?php if ($module['direction'] == 'ltr') { ?>
                  <option value="ltr" selected="selected"><?php echo $text_ltr; ?></option>
                <?php } else { ?>
                  <option value="ltr"><?php echo $text_ltr; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'rtl') { ?>
                  <option value="rtl" selected="selected"><?php echo $text_rtl; ?></option>
                <?php } else { ?>
                  <option value="rtl"><?php echo $text_rtl; ?></option>
                <?php } ?>
              </select></td>
              <td class="left"><select name="menu_vertical_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
              <td class="center"><input type="text" name="menu_vertical_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="center"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="6"></td>
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
	html += '    <td class="left">';
    <?php if ($menus) { ?>
	html += '    <select name="menu_vertical_module[' + module_row + '][menu_id]">';
	<?php foreach ($menus as $menu) { ?>
	html += '      <option value="<?php echo $menu['menu_id']; ?>"><?php echo addslashes($menu['title']); ?></option>';
	<?php } ?>
	html += '    </select>';
	<?php } else { ?>
	html += '      <?php echo $text_no_menu; ?>';
	<?php } ?>
	html += '    </td>';
	html += '    <td class="left"><select name="menu_vertical_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="menu_vertical_module[' + module_row + '][position]">';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="menu_vertical_module[' + module_row + '][direction]">';
	html += '      <option value="ltr" selected="selected"><?php echo $text_ltr; ?></option>';
	html += '      <option value="rtl"><?php echo $text_rtl; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="menu_vertical_module[' + module_row + '][status]">';
	html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '      <option value="0"><?php echo $text_disabled; ?></option>';
	html += '    </select></td>';
	html += '    <td class="center"><input type="text" name="menu_vertical_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="center"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}
//--></script>

<?php echo $footer; ?>