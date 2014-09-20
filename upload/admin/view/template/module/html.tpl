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
        <a href="#tab-1"><span><?php echo $tab_code; ?> 1</span></a>
        <a href="#tab-2"><span><?php echo $tab_code; ?> 2</span></a>
        <a href="#tab-3"><span><?php echo $tab_code; ?> 3</span></a>
        <a href="#tab-4"><span><?php echo $tab_code; ?> 4</span></a>
        <a href="#tab-5"><span><?php echo $tab_code; ?> 5</span></a>
        <a href="#tab-6"><span><?php echo $tab_code; ?> 6</span></a>
        <a href="#tab-7"><span><?php echo $tab_code; ?> 7</span></a>
        <a href="#tab-8"><span><?php echo $tab_code; ?> 8</span></a>
        <a href="#tab-9"><span><?php echo $tab_code; ?> 9</span></a>
        <a href="#tab-10"><span><?php echo $tab_code; ?> 10</span></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form"  name="html">
        <div id="tab-1" style="clear:both;">
          <table class="form">
            <tr>
              <td><?php echo $entry_theme; ?></td>
              <td><?php if ($html_theme1) { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme1" value="1" checked="checked" />
                <?php echo $text_no; ?><input type="radio" name="html_theme1" value="0" />
              <?php } else { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme1" value="1" />
                <?php echo $text_no; ?><input type="radio" name="html_theme1" value="0" checked="checked" />
              <?php } ?></td>
            </tr>
          <?php foreach ($languages as $language) { ?>
            <tr>
              <td><?php echo $entry_title; ?></td>
              <td>
                <input type="text" name="html_title1<?php echo $language['language_id']; ?>" id="html_title1<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'html_title1' . $language['language_id']}; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              </td>
            </tr>
          <?php } ?>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><textarea name="html_code1" cols="40" rows="10"><?php echo isset(${'html_code1'}) ? ${'html_code1'} : ''; ?></textarea></td>
            </tr>
          </table>
        </div><!--tab-1-->
        <div id="tab-2" style="clear:both;">
          <table class="form">
            <tr>
              <td><?php echo $entry_theme; ?></td>
              <td><?php if ($html_theme2) { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme2" value="1" checked="checked" />
                <?php echo $text_no; ?><input type="radio" name="html_theme2" value="0" />
              <?php } else { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme2" value="1" />
                <?php echo $text_no; ?><input type="radio" name="html_theme2" value="0" checked="checked" />
              <?php } ?></td>
            </tr>
          <?php foreach ($languages as $language) { ?>
            <tr>
              <td><?php echo $entry_title; ?></td>
              <td>
                <input type="text" name="html_title2<?php echo $language['language_id']; ?>" id="html_title2<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'html_title2' . $language['language_id']}; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              </td>
            </tr>
          <?php } ?>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><textarea name="html_code2" cols="40" rows="10"><?php echo isset(${'html_code2'}) ? ${'html_code2'} : ''; ?></textarea></td>
            </tr>
          </table>
        </div><!--tab-2-->
        <div id="tab-3" style="clear:both;">
          <table class="form">
            <tr>
              <td><?php echo $entry_theme; ?></td>
              <td><?php if ($html_theme3) { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme3" value="1" checked="checked" />
                <?php echo $text_no; ?><input type="radio" name="html_theme3" value="0" />
              <?php } else { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme3" value="1" />
                <?php echo $text_no; ?><input type="radio" name="html_theme3" value="0" checked="checked" />
              <?php } ?></td>
            </tr>
          <?php foreach ($languages as $language) { ?>
            <tr>
              <td><?php echo $entry_title; ?></td>
              <td>
                <input type="text" name="html_title3<?php echo $language['language_id']; ?>" id="html_title3<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'html_title3' . $language['language_id']}; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              </td>
            </tr>
          <?php } ?>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><textarea name="html_code3" cols="40" rows="10"><?php echo isset(${'html_code3'}) ? ${'html_code3'} : ''; ?></textarea></td>
            </tr>
          </table>
        </div><!--tab-3-->
        <div id="tab-4" style="clear:both;">
          <table class="form">
            <tr>
              <td><?php echo $entry_theme; ?></td>
              <td><?php if ($html_theme4) { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme4" value="1" checked="checked" />
                <?php echo $text_no; ?><input type="radio" name="html_theme4" value="0" />
              <?php } else { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme4" value="1" />
                <?php echo $text_no; ?><input type="radio" name="html_theme4" value="0" checked="checked" />
              <?php } ?></td>
            </tr>
          <?php foreach ($languages as $language) { ?>
            <tr>
              <td><?php echo $entry_title; ?></td>
              <td>
                <input type="text" name="html_title4<?php echo $language['language_id']; ?>" id="html_title4<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'html_title4' . $language['language_id']}; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              </td>
            </tr>
          <?php } ?>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><textarea name="html_code4" cols="40" rows="10"><?php echo isset(${'html_code4'}) ? ${'html_code4'} : ''; ?></textarea></td>
            </tr>
          </table>
        </div><!--tab-4-->
        <div id="tab-5" style="clear:both;">
          <table class="form">
            <tr>
              <td><?php echo $entry_theme; ?></td>
              <td><?php if ($html_theme5) { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme5" value="1" checked="checked" />
                <?php echo $text_no; ?><input type="radio" name="html_theme5" value="0" />
              <?php } else { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme5" value="1" />
                <?php echo $text_no; ?><input type="radio" name="html_theme5" value="0" checked="checked" />
              <?php } ?></td>
            </tr>
          <?php foreach ($languages as $language) { ?>
            <tr>
              <td><?php echo $entry_title; ?></td>
              <td>
                <input type="text" name="html_title5<?php echo $language['language_id']; ?>" id="html_title5<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'html_title5' . $language['language_id']}; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              </td>
            </tr>
          <?php } ?>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><textarea name="html_code5" cols="40" rows="10"><?php echo isset(${'html_code5'}) ? ${'html_code5'} : ''; ?></textarea></td>
            </tr>
          </table>
        </div><!--tab-5-->
        <div id="tab-6" style="clear:both;">
          <table class="form">
            <tr>
              <td><?php echo $entry_theme; ?></td>
              <td><?php if ($html_theme6) { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme6" value="1" checked="checked" />
                <?php echo $text_no; ?><input type="radio" name="html_theme6" value="0" />
              <?php } else { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme6" value="1" />
                <?php echo $text_no; ?><input type="radio" name="html_theme6" value="0" checked="checked" />
              <?php } ?></td>
            </tr>
          <?php foreach ($languages as $language) { ?>
            <tr>
              <td><?php echo $entry_title; ?></td>
              <td>
                <input type="text" name="html_title6<?php echo $language['language_id']; ?>" id="html_title6<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'html_title6' . $language['language_id']}; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              </td>
            </tr>
          <?php } ?>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><textarea name="html_code6" cols="40" rows="10"><?php echo isset(${'html_code6'}) ? ${'html_code6'} : ''; ?></textarea></td>
            </tr>
          </table>
        </div><!--tab-6-->
        <div id="tab-7" style="clear:both;">
          <table class="form">
            <tr>
              <td><?php echo $entry_theme; ?></td>
              <td><?php if ($html_theme7) { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme7" value="1" checked="checked" />
                <?php echo $text_no; ?><input type="radio" name="html_theme7" value="0" />
              <?php } else { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme7" value="1" />
                <?php echo $text_no; ?><input type="radio" name="html_theme7" value="0" checked="checked" />
              <?php } ?></td>
            </tr>
          <?php foreach ($languages as $language) { ?>
            <tr>
              <td><?php echo $entry_title; ?></td>
              <td>
                <input type="text" name="html_title7<?php echo $language['language_id']; ?>" id="html_title7<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'html_title7' . $language['language_id']}; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              </td>
            </tr>
          <?php } ?>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><textarea name="html_code7" cols="40" rows="10"><?php echo isset(${'html_code7'}) ? ${'html_code7'} : ''; ?></textarea></td>
            </tr>
          </table>
        </div><!--tab-7-->
        <div id="tab-8" style="clear:both;">
          <table class="form">
            <tr>
              <td><?php echo $entry_theme; ?></td>
              <td><?php if ($html_theme8) { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme8" value="1" checked="checked" />
                <?php echo $text_no; ?><input type="radio" name="html_theme8" value="0" />
              <?php } else { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme8" value="1" />
                <?php echo $text_no; ?><input type="radio" name="html_theme8" value="0" checked="checked" />
              <?php } ?></td>
            </tr>
          <?php foreach ($languages as $language) { ?>
            <tr>
              <td><?php echo $entry_title; ?></td>
              <td>
                <input type="text" name="html_title8<?php echo $language['language_id']; ?>" id="html_title8<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'html_title8' . $language['language_id']}; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              </td>
            </tr>
          <?php } ?>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><textarea name="html_code8" cols="40" rows="10"><?php echo isset(${'html_code8'}) ? ${'html_code8'} : ''; ?></textarea></td>
            </tr>
          </table>
        </div><!--tab-8-->
        <div id="tab-9" style="clear:both;">
          <table class="form">
            <tr>
              <td><?php echo $entry_theme; ?></td>
              <td><?php if ($html_theme9) { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme9" value="1" checked="checked" />
                <?php echo $text_no; ?><input type="radio" name="html_theme9" value="0" />
              <?php } else { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme9" value="1" />
                <?php echo $text_no; ?><input type="radio" name="html_theme9" value="0" checked="checked" />
              <?php } ?></td>
            </tr>
          <?php foreach ($languages as $language) { ?>
            <tr>
              <td><?php echo $entry_title; ?></td>
              <td>
                <input type="text" name="html_title9<?php echo $language['language_id']; ?>" id="html_title9<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'html_title9' . $language['language_id']}; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              </td>
            </tr>
          <?php } ?>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><textarea name="html_code9" cols="40" rows="10"><?php echo isset(${'html_code9'}) ? ${'html_code9'} : ''; ?></textarea></td>
            </tr>
          </table>
        </div><!--tab-9-->
        <div id="tab-10" style="clear:both;">
          <table class="form">
            <tr>
              <td><?php echo $entry_theme; ?></td>
              <td><?php if ($html_theme10) { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme10" value="1" checked="checked" />
                <?php echo $text_no; ?><input type="radio" name="html_theme10" value="0" />
              <?php } else { ?>
                <?php echo $text_yes; ?><input type="radio" name="html_theme10" value="1" />
                <?php echo $text_no; ?><input type="radio" name="html_theme10" value="0" checked="checked" />
              <?php } ?></td>
            </tr>
          <?php foreach ($languages as $language) { ?>
            <tr>
              <td><?php echo $entry_title; ?></td>
              <td>
                <input type="text" name="html_title10<?php echo $language['language_id']; ?>" id="html_title10<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'html_title10' . $language['language_id']}; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              </td>
            </tr>
          <?php } ?>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><textarea name="html_code10" cols="40" rows="10"><?php echo isset(${'html_code10'}) ? ${'html_code10'} : ''; ?></textarea></td>
            </tr>
          </table>
        </div><!--tab-10-->
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_tab_id; ?></td>
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
              <td class="left"><select name="html_module[<?php echo $module_row; ?>][tab_id]">
                <?php for ($i = 1; $i <= 10; $i++) { ?>
                  <?php if ($module['tab_id'] == 'tab' . $i) { ?>
                    <option value="tab<?php echo $i; ?>" selected="selected"><?php echo $tab_code; ?> <?php echo $i; ?></option>
                  <?php } else { ?>
                    <option value="tab<?php echo $i; ?>"><?php echo $tab_code; ?>  <?php echo $i; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
              <td class="left"><select name="html_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select></td>
              <td class="left"><select name="html_module[<?php echo $module_row; ?>][position]">
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
              <td class="left"><select name="html_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
              <td class="center">
                <input type="text" name="html_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
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

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>

<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('html_code1', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
CKEDITOR.replace('html_code2', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
CKEDITOR.replace('html_code3', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
CKEDITOR.replace('html_code4', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
CKEDITOR.replace('html_code5', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
CKEDITOR.replace('html_code6', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
CKEDITOR.replace('html_code7', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
CKEDITOR.replace('html_code8', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
CKEDITOR.replace('html_code9', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
CKEDITOR.replace('html_code10', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="html_module[' + module_row + '][tab_id]">';
	<?php for ($i = 1; $i <= 10; $i++) { ?>
	html += '      <option value="tab<?php echo $i; ?>"><?php echo $tab_code; ?>  <?php echo $i; ?></option>';
	<?php } ?>
	html += '    </td>';
	html += '    <td class="left"><select name="html_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="html_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="html_module[' + module_row + '][status]">';
	html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '      <option value="0"><?php echo $text_disabled; ?></option>';
	html += '    </select></td>';
	html += '    <td class="center"><input type="text" name="html_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="center"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button-delete"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}
//--></script>

<script type="text/javascript"><!--
$(function() { $('#tabs a').tabs(); });
//--></script>

<?php echo $footer; ?>