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
      <h1><img src="view/image/tax.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-setting"><?php echo $tab_setting; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="eutaxform">
        <div id="tab-general">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
              <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
            <div id="language<?php echo $language['language_id']; ?>">
              <table class="form">
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_eucountry; ?></td>
                  <td><input type="text" name="eucountry_description[<?php echo $language['language_id']; ?>][eucountry]" size="40" value="<?php echo isset($eucountry_description[$language['language_id']]) ? $eucountry_description[$language['language_id']]['eucountry'] : ''; ?>" />
                    <?php if (isset($error_eucountry[$language['language_id']])) { ?>
                      <span class="error"><?php echo $error_eucountry[$language['language_id']]; ?></span>
                    <?php } ?>
                  </td>
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_description; ?></td>
                  <td><textarea name="eucountry_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($eucountry_description[$language['language_id']]) ? $eucountry_description[$language['language_id']]['description'] : ''; ?></textarea>
                    <?php if (isset($error_description[$language['language_id']])) { ?>
                      <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
                    <?php } ?>
                  </td>
                </tr>
              </table>
            </div>
          <?php } ?>
        </div>
        <div id="tab-setting">
          <table class="form">
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td>
                <div id="store_ids" class="scrollbox" style="width:225px; height:60px; margin-bottom:5px;">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $eucountry_store)) { ?>
                      <input type="checkbox" name="eucountry_store[]" value="0" checked="checked" />
                      <?php echo $text_default; ?>
                    <?php } else { ?>
                      <input type="checkbox" name="eucountry_store[]" value="0" />
                      <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                    <div class="<?php echo $class; ?>">
                      <?php if (in_array($store['store_id'], $eucountry_store)) { ?>
                        <input type="checkbox" name="eucountry_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                      <?php } else { ?>
                        <input type="checkbox" name="eucountry_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                      <?php } ?>
                    </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="button-unselect"></a>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td><input type="text" name="code" value="<?php echo $code; ?>" size="3" maxlength="2" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_rate; ?></td>
              <td><input type="text" name="rate" value="<?php echo $rate; ?>" size="10" maxlength="7" /></td>
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
<?php } ?>
//--></script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
//--></script>

<?php echo $footer; ?>