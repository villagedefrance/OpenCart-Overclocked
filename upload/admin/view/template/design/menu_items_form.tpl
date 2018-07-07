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
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
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
              <td><span class="required">*</span> <?php echo $entry_name; ?></td>
              <td><?php if (isset($error_name[$language['language_id']])) { ?>
                <input type="text" name="menu_item_description[<?php echo $language['language_id']; ?>][name]" size="40" value="<?php echo isset($menu_item_description[$language['language_id']]) ? $menu_item_description[$language['language_id']]['name'] : ''; ?>" class="input-error" />
                <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
              <?php } else { ?>
                <input type="text" name="menu_item_description[<?php echo $language['language_id']; ?>][name]" size="40" value="<?php echo isset($menu_item_description[$language['language_id']]) ? $menu_item_description[$language['language_id']]['name'] : ''; ?>" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_meta_description; ?></td>
              <td><textarea name="menu_item_description[<?php echo $language['language_id']; ?>][meta_description]" id="meta-description<?php echo $language['language_id']; ?>" data-limit="156" cols="40" rows="5"><?php echo isset($menu_item_description[$language['language_id']]) ? $menu_item_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
              <span id="remaining<?php echo $language['language_id']; ?>"></span></td>
            </tr>
            <tr>
              <td><?php echo $entry_meta_keyword; ?></td>
              <td><textarea name="menu_item_description[<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="5"><?php echo isset($menu_item_description[$language['language_id']]) ? $menu_item_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea></td>
            </tr>
          </table>
        </div>
        <?php } ?>
      </div>
      <div id="tab-data">
        <table class="form">
          <tr>
            <td><?php echo $entry_parent; ?></td>
            <td><select name="parent_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($menu_items as $menu_item) { ?>
                <?php if ($menu_item['menu_item_id'] == $parent_id) { ?>
                  <option value="<?php echo $menu_item['menu_item_id']; ?>" selected="selected"><?php echo $menu_item['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $menu_item['menu_item_id']; ?>"><?php echo $menu_item['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_link; ?></td>
            <td><input type="text" name="link" value="<?php echo $link; ?>" size="70" /><br /><br />
            <?php echo $text_info; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_external_link; ?></td>
            <td><?php if ($external_link) { ?>
              <input type="radio" name="external_link" value="1" id="external_link-on" class="radio" checked />
              <label for="external_link-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="external_link" value="0" id="external_link-off" class="radio" />
              <label for="external_link-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="external_link" value="1" id="external_link-on" class="radio" />
              <label for="external_link-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="external_link" value="0" id="external_link-off" class="radio" checked />
              <label for="external_link-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="3" /></td>
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

<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
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

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.3,
		width: <?php echo ($this->browser->checkMobile()) ? 580 : 760; ?>,
		height: 400
	});
});
//--></script>

<?php echo $footer; ?>