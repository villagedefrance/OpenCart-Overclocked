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
      <h1><img src="view/image/manufacturer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <div id="tabs" class="htabs">
      <a href="#tab-general"><?php echo $tab_general; ?></a>
    </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_name; ?></td>
          <td><?php foreach ($languages as $language) { ?>
            <input type="text" name="manufacturer_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($manufacturer_description[$language['language_id']]) ? $manufacturer_description[$language['language_id']]['name'] : ''; ?>" size="40" />
            <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
            <?php if (isset($error_name[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
            <?php } ?>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_store; ?></td>
          <td><div id="store_ids" class="scrollbox" style="width:220px; height:80px; margin-bottom:5px;">
            <?php $class = 'even'; ?>
            <div class="<?php echo $class; ?>">
              <?php if (in_array(0, $manufacturer_store)) { ?>
                <input type="checkbox" name="manufacturer_store[]" value="0" checked="checked" />
                <?php echo $text_default; ?>
              <?php } else { ?>
                <input type="checkbox" name="manufacturer_store[]" value="0" />
                <?php echo $text_default; ?>
              <?php } ?>
            </div>
            <?php foreach ($stores as $store) { ?>
              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
              <div class="<?php echo $class; ?>">
                <?php if (in_array($store['store_id'], $manufacturer_store)) { ?>
                  <input type="checkbox" name="manufacturer_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                  <?php echo $store['name']; ?>
                <?php } else { ?>
                  <input type="checkbox" name="manufacturer_store[]" value="<?php echo $store['store_id']; ?>" />
                  <?php echo $store['name']; ?>
                <?php } ?>
              </div>
            <?php } ?>
          </div>
          <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> | <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_keyword; ?></td>
          <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" size="40" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_image; ?></td>
          <td style="vertical-align:top;"><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" />
            <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" /><br />
            <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a>
          </div></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
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

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding:3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin:0; display:block; width:100%; height:100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>