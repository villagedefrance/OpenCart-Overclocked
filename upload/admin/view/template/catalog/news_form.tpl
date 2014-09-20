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
      <h1><img src="view/image/review.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
        <a onclick="location='<?php echo $cancel; ?>';" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab_general"><?php echo $tab_general; ?></a>
        <a href="#tab_data"><?php echo $tab_data; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="newsform">
        <div id="tab_general">
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
                  <td><input name="news_description[<?php echo $language['language_id']; ?>][title]" size="80" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['title'] : ''; ?>" />
                    <?php if (isset($error_title[$language['language_id']])) { ?>
                      <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
                    <?php } ?>
                  </td>
                </tr>
                <tr>
                  <td><?php echo $entry_meta_description; ?></td>
                  <td><textarea name="news_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['meta_description'] : ''; ?></textarea></td>
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_description; ?></td>
                  <td><textarea name="news_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['description'] : ''; ?></textarea>
                    <?php if (isset($error_description[$language['language_id']])) { ?>
                      <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
                    <?php } ?>
                  </td>
                </tr>
              </table>
            </div>
          <?php } ?>
		</div>
		<div id="tab_data">
          <table class="form">
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td>
                <div id="store_ids" class="scrollbox" style="width:220px; height:60px; margin-bottom:5px;">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $news_store)) { ?>
                      <input type="checkbox" name="news_store[]" value="0" checked="checked" />
                      <?php echo $text_default; ?>
                    <?php } else { ?>
                      <input type="checkbox" name="news_store[]" value="0" />
                      <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                    <?php $class=($class=='even' ? 'odd' : 'even'); ?>
                    <div class="<?php echo $class; ?>">
                      <?php if (in_array($store['store_id'], $news_store)) { ?>
                        <input type="checkbox" name="news_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                      <?php } else { ?>
                        <input type="checkbox" name="news_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                      <?php } ?>
                    </div>
                  <?php } ?>
                </div>
                <a onclick="select_all('news_store', '1');"><?php echo $text_select_all; ?></a> | <a onclick="select_all('news_store', '0');"><?php echo $text_unselect_all; ?></a>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_keyword; ?></td>
              <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" size="40" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_image; ?></td>
              <td>
                <div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
                <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a>
                </div>
              </td>
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

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>

<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
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
function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding:3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin:0; display:block; width:100%; height:100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(text) {
						$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
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
var formblock;
var forminput;
 
formblock = document.getElementById('store_ids');
forminput = formblock.getElementsByTagName('input');
 
function select_all(name, value) {
	for (i = 0; i < forminput.length; i++) {
		var regex = new RegExp(name, "i");
		if (regex.test(forminput[i].getAttribute('name'))) {
			if (value == '1') {
				forminput[i].checked = true;
			} else {
				forminput[i].checked = false;
			}
		}
	}
}
//--></script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
//--></script>

<?php echo $footer; ?>