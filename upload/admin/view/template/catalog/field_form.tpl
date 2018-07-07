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
      <h1><img src="view/image/product-field.png" alt="" /> <?php echo $field_title; ?></h1>
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
                <input type="text" name="field_description[<?php echo $language['language_id']; ?>][title]" size="50" value="<?php echo isset($field_description[$language['language_id']]) ? $field_description[$language['language_id']]['title'] : ''; ?>" class="input-error" />
                <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
              <?php } else { ?>
                <input type="text" name="field_description[<?php echo $language['language_id']; ?>][title]" size="50" value="<?php echo isset($field_description[$language['language_id']]) ? $field_description[$language['language_id']]['title'] : ''; ?>" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_description; ?></td>
              <td><textarea name="field_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($field_description[$language['language_id']]) ? $field_description[$language['language_id']]['description'] : ''; ?></textarea>
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