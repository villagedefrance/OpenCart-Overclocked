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
      <h1><img src="view/image/information.png" alt="" /> <?php echo $information_title; ?></h1>
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
              <td><span class="required">*</span> <?php echo $entry_title; ?></td>
              <td><?php if (isset($error_title[$language['language_id']])) { ?>
                <input type="text" name="information_description[<?php echo $language['language_id']; ?>][title]" size="50" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['title'] : ''; ?>" class="input-error" />
                <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
              <?php } else { ?>
                <input type="text" name="information_description[<?php echo $language['language_id']; ?>][title]" size="50" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['title'] : ''; ?>" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_meta_description; ?><span class="help"><?php echo $help_meta_description; ?></span></td>
              <td><textarea name="information_description[<?php echo $language['language_id']; ?>][meta_description]" id="meta-description<?php echo $language['language_id']; ?>" data-limit="156" cols="40" rows="5"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
              <span id="remaining<?php echo $language['language_id']; ?>"></span></td>
            </tr>
            <tr>
              <td><?php echo $entry_meta_keyword; ?><span class="help"><?php echo $help_meta_keyword; ?></span></td>
              <td><textarea name="information_description[<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="5"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_description; ?></td>
              <td><textarea name="information_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['description'] : ''; ?></textarea>
              <?php if (isset($error_description[$language['language_id']])) { ?>
                <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
              <?php } ?></td>
            </tr>
          </table>
          </div>
        <?php } ?>
      </div>
      <div id="tab-data">
        <table class="form">
          <tr>
            <td><?php echo $entry_store; ?></td>
            <td><div id="store_ids" class="scrollbox-store">
              <?php $class = 'even'; ?>
              <div class="<?php echo $class; ?>">
                <?php if (in_array(0, $information_store)) { ?>
                  <input type="checkbox" name="information_store[]" value="0" checked="checked" />
                  <?php echo $text_default; ?>
                <?php } else { ?>
                  <input type="checkbox" name="information_store[]" value="0" />
                  <?php echo $text_default; ?>
                <?php } ?>
              </div>
              <?php foreach ($stores as $store) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <?php if (in_array($store['store_id'], $information_store)) { ?>
                    <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                  <?php } else { ?>
                    <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" />
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
          <tr style="display:none;">
            <td><?php echo $entry_bottom; ?><span class="help"><?php echo $help_bottom; ?></span></td>
            <td><?php if ($bottom == 1) { ?>
              <input type="checkbox" name="bottom" value="1" id="bottom-on" class="checkbox" checked />
              <label for="bottom-on"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="bottom" value="1" id="bottom-off" class="checkbox" />
              <label for="bottom-off"><span></span></label>
            <?php } ?></td>
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
            <td class="left"><?php echo $entry_store; ?></td>
            <td class="left"><?php echo $entry_layout; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="left"><?php echo $text_default; ?></td>
            <td class="left"><select name="information_layout[0][layout_id]">
              <option value=""><?php echo $text_none; ?></option>
              <?php foreach ($layouts as $layout) { ?>
                <?php if (isset($information_layout[0]) && $information_layout[0] == $layout['layout_id']) { ?>
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
            <td class="left"><select name="information_layout[<?php echo $store['store_id']; ?>][layout_id]">
              <option value=""><?php echo $text_none; ?></option>
              <?php foreach ($layouts as $layout) { ?>
                <?php if (isset($information_layout[$store['store_id']]) && $information_layout[$store['store_id']] == $layout['layout_id']) { ?>
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
$('#tabs a').tabs();
$('#languages a').tabs();
//--></script>

<?php echo $footer; ?>