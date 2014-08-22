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
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="slideshow">
        <table class="form">
          <tr>
            <td><?php echo $entry_theme; ?></td>
            <td><?php if ($slideshow_theme) { ?>
              <?php echo $text_yes; ?><input type="radio" name="slideshow_theme" value="1" checked="checked" />
              <?php echo $text_no; ?><input type="radio" name="slideshow_theme" value="0" />
            <?php } else { ?>
              <?php echo $text_yes; ?><input type="radio" name="slideshow_theme" value="1" />
              <?php echo $text_no; ?><input type="radio" name="slideshow_theme" value="0" checked="checked" />
            <?php } ?></td>
          </tr>
        <?php foreach ($languages as $language) { ?>
          <tr>
            <td><?php echo $entry_title; ?></td>
            <td>
              <input type="text" name="slideshow_title<?php echo $language['language_id']; ?>" id="slideshow_title<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'slideshow_title' . $language['language_id']}; ?>" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
            </td>
          </tr>
        <?php } ?>
          <tr>
            <td><?php echo $entry_pause; ?></td>
            <td><select name="slideshow_pause">
              <?php if ($slideshow_pause) { ?>
                <option value="1" selected="selected"><?php echo $text_true; ?></option>
                <option value="0"><?php echo $text_false; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_true; ?></option>
                <option value="0" selected="selected"><?php echo $text_false; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_arrows; ?></td>
            <td><select name="slideshow_arrows">
              <?php if ($slideshow_arrows) { ?>
                <option value="1" selected="selected"><?php echo $text_true; ?></option>
                <option value="0"><?php echo $text_false; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_true; ?></option>
                <option value="0" selected="selected"><?php echo $text_false; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_autohide; ?></td>
            <td><select name="slideshow_autohide">
              <?php if ($slideshow_autohide) { ?>
                <option value="1" selected="selected"><?php echo $text_true; ?></option>
                <option value="0"><?php echo $text_false; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_true; ?></option>
                <option value="0" selected="selected"><?php echo $text_false; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_controls; ?></td>
            <td><select name="slideshow_controls">
              <?php if ($slideshow_controls) { ?>
                <option value="1" selected="selected"><?php echo $text_true; ?></option>
                <option value="0"><?php echo $text_false; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_true; ?></option>
                <option value="0" selected="selected"><?php echo $text_false; ?></option>
              <?php } ?>
            </select></td>
          </tr>
        </table>
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_banner; ?></td>
              <td class="left"><?php echo $entry_dimension; ?></td>
              <td class="left"><?php echo $entry_effect; ?></td>
              <td class="left"><?php echo $entry_delay; ?></td>
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
              <td class="left"><select name="slideshow_module[<?php echo $module_row; ?>][banner_id]">
                <?php foreach ($banners as $banner) { ?>
                  <?php if ($banner['banner_id'] == $module['banner_id']) { ?>
                    <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
              <td class="left">
                <input type="text" name="slideshow_module[<?php echo $module_row; ?>][width]" value="<?php echo $module['width']; ?>" size="3" /> x 
                <input type="text" name="slideshow_module[<?php echo $module_row; ?>][height]" value="<?php echo $module['height']; ?>" size="3" /> px
                <?php if (isset($error_dimension[$module_row])) { ?>
                  <span class="error"><?php echo $error_dimension[$module_row]; ?></span>
                <?php } ?>
              </td>
              <td class="left"><select name="slideshow_module[<?php echo $module_row; ?>][effect]">
                <?php if ($module['effect']) {$selected = "selected"; ?>
                  <option value="random" <?php if ($module['effect'] == 'random') {echo $selected;} ?>>Random</option>
                  <option value="fade" <?php if ($module['effect'] == 'fade') {echo $selected;} ?>>Fade</option>
                  <option value="fold" <?php if ($module['effect'] == 'fold') {echo $selected;} ?>>Fold</option>
                  <option value="boxRandom" <?php if ($module['effect'] == 'boxRandom') {echo $selected;} ?>>BoxRandom</option>
                  <option value="boxRain" <?php if ($module['effect'] == 'boxRain') {echo $selected;} ?>>BoxRain</option>
                  <option value="boxRainReverse" <?php if ($module['effect'] == 'boxRainReverse') {echo $selected;} ?>>BoxRainReverse</option>
                  <option value="boxRainGrow" <?php if ($module['effect'] == 'boxRainGrow') {echo $selected;} ?>>BoxRainGrow</option>
                  <option value="sliceDown" <?php if ($module['effect'] == 'sliceDown') {echo $selected;} ?>>SliceDown</option>
                  <option value="sliceDownRight" <?php if ($module['effect'] == 'sliceDownRight') {echo $selected;} ?>>SliceDownRight</option>
                  <option value="sliceDownLeft" <?php if ($module['effect'] == 'sliceDownLeft') {echo $selected;} ?>>SliceDownLeft</option>
                  <option value="sliceUp" <?php if ($module['effect'] == 'sliceUp') {echo $selected;} ?>>SliceUp</option>
                  <option value="sliceUpRight" <?php if ($module['effect'] == 'sliceUpRight') {echo $selected;} ?>>SliceUpRight</option>
                  <option value="sliceUpLeft" <?php if ($module['effect'] == 'sliceUpLeft') {echo $selected;} ?>>SliceUpLeft</option>
                  <option value="sliceUpDown" <?php if ($module['effect'] == 'sliceUpDown') {echo $selected;} ?>>SliceUpDown</option>
                <?php } else { ?>
                  <option selected="selected"></option>
                  <option value="random" selected>Random</option>
                  <option value="fade">Fade</option>
                  <option value="fold">Fold</option>
                  <option value="boxRandom">BoxRandom</option>
                  <option value="boxRain">BoxRain</option>
                  <option value="boxRainReverse">BoxRainReverse</option>
                  <option value="boxRainGrow">BoxRainGrow</option>
                  <option value="sliceDown">SliceDown</option>
                  <option value="sliceDownRight">SliceDownRight</option>
                  <option value="sliceDownLeft">SliceDownLeft</option>
                  <option value="sliceUp">SliceUp</option>
                  <option value="sliceUpRight">SliceUpRight</option>
                  <option value="sliceUpLeft">SliceUpLeft</option>
                  <option value="sliceUpDown">SliceUpDown</option>
                <?php } ?>
              </select></td>
              <td class="left"><select name="slideshow_module[<?php echo $module_row; ?>][delay]">
                <?php if ($module['delay']) {$selected = "selected"; ?>
                  <option value="2000" <?php if ($module['delay'] == '2000') {echo $selected;} ?>>2000</option>
                  <option value="3000" <?php if ($module['delay'] == '3000') {echo $selected;} ?>>3000</option>
                  <option value="4000" <?php if ($module['delay'] == '4000') {echo $selected;} ?>>4000</option>
                  <option value="5000" <?php if ($module['delay'] == '5000') {echo $selected;} ?>>5000</option>
                  <option value="6000" <?php if ($module['delay'] == '6000') {echo $selected;} ?>>6000</option>
                  <option value="7000" <?php if ($module['delay'] == '7000') {echo $selected;} ?>>7000</option>
                  <option value="8000" <?php if ($module['delay'] == '8000') {echo $selected;} ?>>8000</option>
                  <option value="9000" <?php if ($module['delay'] == '9000') {echo $selected;} ?>>9000</option>
                  <option value="10000" <?php if ($module['delay'] == '10000') {echo $selected;} ?>>10000</option>
                  <option value="11000" <?php if ($module['delay'] == '11000') {echo $selected;} ?>>11000</option>
                  <option value="12000" <?php if ($module['delay'] == '12000') {echo $selected;} ?>>12000</option>
                <?php } else { ?>
                  <option selected="selected"></option>
                  <option value="2000">2000</option>
                  <option value="3000">3000</option>
                  <option value="4000">4000</option>
                  <option value="5000" selected>5000</option>
                  <option value="6000">6000</option>
                  <option value="7000">7000</option>
                  <option value="8000">8000</option>
                  <option value="9000">9000</option>
                  <option value="10000">10000</option>
                  <option value="11000">11000</option>
                  <option value="12000">12000</option>
                <?php } ?>
              </select> ms</td>
              <td class="left"><select name="slideshow_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
              <td class="left"><select name="slideshow_module[<?php echo $module_row; ?>][position]">
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
              <td class="left"><select name="slideshow_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
              <td class="center">
                <input type="text" name="slideshow_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
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
              <td colspan="8"></td>
              <td class="center"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
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
	html += '    <td class="left"><select name="slideshow_module[' + module_row + '][banner_id]">';
	<?php foreach ($banners as $banner) { ?>
	html += '      <option value="<?php echo $banner['banner_id']; ?>"><?php echo addslashes($banner['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left">';
	html += '      <input type="text" name="slideshow_module[' + module_row + '][width]" value="480" size="3" /> x ';
	html += '      <input type="text" name="slideshow_module[' + module_row + '][height]" value="180" size="3" /> px';
	html += '    </td>';
	html += '    <td class="left"><select name="slideshow_module[' + module_row + '][effect]">';
	html += '      <option value="random" selected>Random</option>';
	html += '      <option value="fade">Fade</option>';
	html += '      <option value="fold">Fold</option>';
	html += '      <option value="boxRandom">BoxRandom</option>';
	html += '      <option value="boxRain">BoxRain</option>';
	html += '      <option value="boxRainReverse">BoxRainReverse</option>';
	html += '      <option value="boxRainGrow">BoxRainGrow</option>';
	html += '      <option value="sliceDown">SliceDown</option>';
	html += '      <option value="sliceDownRight">SliceDownRight</option>';
	html += '      <option value="sliceDownLeft">SliceDownLeft</option>';
	html += '      <option value="sliceUp">SliceUp</option>';
	html += '      <option value="sliceUpRight">SliceUpRight</option>';
	html += '      <option value="sliceUpLeft">SliceUpLeft</option>';
	html += '      <option value="sliceUpDown">SliceUpDown</option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="slideshow_module[' + module_row + '][delay]">';
	html += '      <option value="2000">2000</option>';
	html += '      <option value="3000">3000</option>';
	html += '      <option value="4000">4000</option>';
	html += '      <option value="5000" selected>5000</option>';
	html += '      <option value="6000">6000</option>';
	html += '      <option value="7000">7000</option>';
	html += '      <option value="8000">8000</option>';
	html += '      <option value="9000">9000</option>';
	html += '      <option value="10000">10000</option>';
	html += '      <option value="11000">11000</option>';
	html += '      <option value="12000">12000</option>';
	html += '    </select> ms</td>';
	html += '    <td class="left"><select name="slideshow_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="slideshow_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="slideshow_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="center"><input type="text" name="slideshow_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="center"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button-delete"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}
//--></script>

<?php echo $footer; ?>