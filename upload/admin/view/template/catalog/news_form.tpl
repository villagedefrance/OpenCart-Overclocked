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
      <h1><img src="view/image/review.png" alt="" /> <?php echo $news_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a onclick="location='<?php echo $cancel; ?>';" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-data"><?php echo $tab_data; ?></a>
        <a href="#tab-related"><?php echo $tab_related; ?></a>
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
                <input type="text" name="news_description[<?php echo $language['language_id']; ?>][title]" size="60" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['title'] : ''; ?>" class="input-error" />
                <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
              <?php } else { ?>
                <input type="text" name="news_description[<?php echo $language['language_id']; ?>][title]" size="60" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['title'] : ''; ?>" />
              <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_meta_description; ?><span class="help"><?php echo $help_meta_description; ?></span></td>
              <td><textarea name="news_description[<?php echo $language['language_id']; ?>][meta_description]" id="meta-description<?php echo $language['language_id']; ?>" data-limit="156" cols="40" rows="5"><?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
              <span id="remaining<?php echo $language['language_id']; ?>"></span></td>
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
      <div id="tab-data">
        <table class="form">
          <tr>
            <td><?php echo $entry_image; ?><span class="help"><?php echo $help_image; ?></span></td>
            <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
              <a onclick="image_upload('image', 'thumb');" class="button-browse"></a><a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');" class="button-recycle"></a>
            </div>
            <?php if ($error_image) { ?>
              <span class="error"><?php echo $error_image; ?></span>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_keyword; ?><span class="help"><?php echo $help_keyword; ?></span></td>
            <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" size="40" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_download; ?></td>
            <td>
              <div id="download-ids" class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($downloads as $download) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($download['news_download_id'], $news_download)) { ?>
                      <input type="checkbox" name="news_download[]" value="<?php echo $download['news_download_id']; ?>" checked="checked" />
                      <?php echo $download['name']; ?>
                    <?php } else { ?>
                      <input type="checkbox" name="news_download[]" value="<?php echo $download['news_download_id']; ?>" />
                      <?php echo $download['name']; ?>
                    <?php } ?>
                  </div>
                <?php } ?>
              </div><br />
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="button-unselect"></a>
            <?php if ($new_entry) { ?>
              &nbsp;<a onclick="location = '<?php echo $new_download; ?>';" class="button-filter" style="margin-top:0;"><?php echo $button_new_download; ?></a>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_store; ?><span class="help"><?php echo $help_store; ?></span></td>
            <td>
              <div id="store_ids" class="scrollbox-store">
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
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="button-unselect"></a>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_lightbox; ?><span class="help"><?php echo $help_lightbox; ?></span></td>
            <td><select name="lightbox">
              <?php if (isset($lightbox)) { $selected = "selected"; ?>
                <option value="magnific" <?php if ($lightbox == 'magnific') { echo $selected; } ?>>Magnific (<?php echo $text_default; ?>)</option>
                <option value="fancybox" <?php if ($lightbox == 'fancybox') { echo $selected; } ?>>FancyBox</option>
                <option value="colorbox" <?php if ($lightbox == 'colorbox') { echo $selected; } ?>>ColorBox</option>
                <option value="viewbox" <?php if ($lightbox == 'viewbox') { echo $selected; } ?>>Viewbox</option>
              <?php } else { ?>
                <option value="magnific">Magnific (<?php echo $text_default; ?>)</option>
                <option value="fancybox">FancyBox</option>
                <option value="colorbox">Colorbox</option>
                <option value="viewbox">Viewbox</option>
              <?php } ?>
            </select></td>
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
      <div id="tab-related">
        <table class="form">
          <tr>
            <td><?php echo $entry_related_method; ?><span class="help"><?php echo $help_related_method; ?></span></td>
            <td><select name="related" onchange="getRelatedMethod(this.value);">
              <option value="product_wise" <?php if ($related == 'product_wise') { echo "selected='selected'"; } ?>><?php echo $entry_product_wise; ?></option>
              <option value="category_wise" <?php if ($related == 'category_wise') { echo "selected='selected'"; } ?>><?php echo $entry_category_wise; ?></option>
              <option value="manufacturer_wise" <?php if ($related == 'manufacturer_wise') { echo "selected='selected'"; } ?>><?php echo $entry_manufacturer_wise; ?></option>
            </select></td>
          </tr>
          <tr id="product-wise" style="display:none;">
            <td><?php echo $entry_product; ?></td>
            <td>
              <table>
                <tr>
                  <td><?php echo $entry_product_search; ?><br /><input type="text" name="product" value="" /></td>
                  <td>&nbsp;&nbsp;</td>
                  <td> 
                    <div id="product-wise-list" class="scrollbox">
                      <?php $class = 'odd'; ?>
                      <?php if (isset($products)) { ?>
                        <?php foreach ($products as $product) { ?>
                          <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                          <div id="product-wise-list<?php echo $product['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $product['name']; ?><img src="view/image/delete.png" alt="" />
                            <input type="hidden" name="product_wise[]" value="<?php echo $product['product_id']; ?>" />
                          </div>
                        <?php } ?>
                      <?php } ?>	
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr id="category-wise" style="display:none;">
            <td><?php echo $entry_category; ?></td>
            <td>
              <div id="category-ids" class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($default_categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="category_wise[]" value="<?php echo $category['category_id']; ?>" <?php if (isset($category_ids)) { for ($i = 0; $i < count($category_ids); $i++) { if ($category_ids[$i] == $category['category_id']) { echo "checked='checked'"; } } } ?> />                    
                    <?php echo $category['name']; ?> 
                  </div>
                <?php } ?>
              </div><br />
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="button-unselect"></a>
            </td>
          </tr>
          <tr id="manufacturer-wise" style="display:none;">
            <td><?php echo $entry_manufacturer; ?></td>
            <td>
              <div id="manufacturer-ids" class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($default_manufacturers as $manufacturer) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="manufacturer_wise[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" <?php if (isset($manufacturer_ids)) { for ($i = 0; $i < count($manufacturer_ids); $i++) { if ($manufacturer_ids[$i] == $manufacturer['manufacturer_id']) { echo "checked='checked'"; } } } ?> />                    
                    <?php echo $manufacturer['name']; ?>
                  </div>
                <?php } ?>
              </div><br />
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="button-unselect"></a>
            </td>
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
function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding:3px 0 0 0;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin:0; display:block; width:100%; height:100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function(event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: <?php echo ($this->browser->checkMobile()) ? 580 : 760; ?>,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>

<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#product-wise-list' + ui.item.value).remove();
		$('#product-wise-list').append('<div id="product-wise-list' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="product_wise[]" value="' + ui.item.value + '" /></div>');
		$('#product-wise-list div:odd').attr('class', 'odd');
		$('#product-wise-list div:even').attr('class', 'even');

		$('input[name=\'product\']').val('');
		return false;
	}
});

$('#product-wise-list div').on('click', 'img', function() {
	$(this).parent().remove();

	$('#product-wise-list div:odd').attr('class', 'odd');
	$('#product-wise-list div:even').attr('class', 'even');
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
<?php if ($related == 'product_wise') { ?>
	$("#product-wise").css({display: "table-row"});
	$("#category-wise").css({display: "none"});
	$("#manufacturer-wise").css({display: "none"});
<?php } elseif ($related == 'category_wise') { ?>
	$("#product-wise").css({display: "none"});
	$("#category-wise").css({display: "table-row"});
	$("#manufacturer-wise").css({display: "none"});
<?php } elseif ($related == 'manufacturer_wise') { ?>
	$("#product-wise").css({display: "none"});
	$("#category-wise").css({display: "none"});
	$("#manufacturer-wise").css({display: "table-row"});
<?php } ?>
});
//--></script>

<script type="text/javascript"><!--
function getRelatedMethod(value) {
	if (value == 'product_wise') {
		$("#product-wise").css({display: "table-row"});
		$("#category-wise").css({display: "none"});
		$("#manufacturer-wise").css({display: "none"});
	} else if (value == 'category_wise') {
		$("#product-wise").css({display: "none"});
		$("#category-wise").css({display: "table-row"});
		$("#manufacturer-wise").css({display: "none"});
	} else if (value == 'manufacturer_wise') {
		$("#product-wise").css({display: "none"});
		$("#category-wise").css({display: "none"});
		$("#manufacturer-wise").css({display: "table-row"});
	}
}
//--></script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
//--></script>

<?php echo $footer; ?>