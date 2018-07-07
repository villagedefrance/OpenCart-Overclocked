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
      <h1><img src="view/image/product.png" alt="" /> <?php echo $product_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_supplier; ?></td>
            <td><select name="supplier_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($suppliers as $supplier) { ?>
                <?php if ($supplier['supplier_id'] == $supplier_id) { ?>
                  <option value="<?php echo $supplier['supplier_id']; ?>" selected="selected"><?php echo $supplier['company']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $supplier['supplier_id']; ?>"><?php echo $supplier['company']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
            <?php if ($new_entry) { ?>
              &nbsp;<a onclick="location='<?php echo $new_supplier; ?>';" class="button-filter"><?php echo $button_new_supplier; ?></a>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><?php if ($error_name) { ?>
              <input type="text" name="name" value="<?php echo $name; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_name; ?></span>
            <?php } else { ?>
              <input type="text" name="name" value="<?php echo $name; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_model; ?></td>
            <td><?php if ($error_model) { ?>
              <input type="text" name="model" value="<?php echo $model; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_model; ?></span>
            <?php } else { ?>
              <span><?php echo $barcode; ?></span><br />
              <input type="text" name="model" value="<?php echo $model; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_manufacturer; ?><?php echo $text_autocomplete; ?></td>
            <td>
              <input type="text" name="manufacturer" value="<?php echo $manufacturer; ?>" /><input type="hidden" name="manufacturer_id" value="<?php echo $manufacturer_id; ?>" />
              <?php if ($new_entry) { ?>
                &nbsp;<a onclick="location='<?php echo $new_manufacturer; ?>';" class="button-filter"><?php echo $button_new_manufacturer; ?></a>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_image; ?></td>
            <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
              <a onclick="image_upload('image', 'thumb');" class="button-browse"></a><a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');" class="button-recycle"></a>
            </div></td>
          </tr>
          <tr>
            <td><?php echo $entry_price; ?></td>
            <td><input type="text" name="price" value="<?php echo $price; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax_class; ?></td>
            <td><select name="tax_class_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_unit; ?></td>
            <td><input type="text" name="unit" value="<?php echo $unit; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_color; ?></td>
            <td><input type="text" name="color" value="<?php echo $color; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_size; ?></td>
            <td><input type="text" name="size" value="<?php echo $size; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_quantity; ?></td>
            <td><input type="text" name="quantity" value="<?php echo $quantity; ?>" size="8" /></td>
          </tr>
        </table>
        <h2><?php echo $heading_dimension; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_dimension; ?></td>
            <td>
              <input type="text" name="length" value="<?php echo $length; ?>" size="12" /> x 
              <input type="text" name="width" value="<?php echo $width; ?>" size="12" /> x 
              <input type="text" name="height" value="<?php echo $height; ?>" size="12" />
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_length; ?></td>
            <td><select name="length_class_id">
              <?php foreach ($length_classes as $length_class) { ?>
                <?php if ($length_class['length_class_id'] == $length_class_id) { ?>
                  <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_weight; ?></td>
            <td><input type="text" name="weight" value="<?php echo $weight; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_weight_class; ?></td>
            <td><select name="weight_class_id">
              <?php foreach ($weight_classes as $weight_class) { ?>
                <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>
                  <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
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
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';

		$.each(items, function(index, item) {
			if (item['category'] != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item['category'] + '</li>');
				currentCategory = item['category'];
			}

			self._renderItemData(ul, item);
		});
	}
});

// Manufacturer
$('input[name=\'manufacturer\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					'manufacturer_id': 0,
					'name': '<?php echo $text_none; ?>'
				});
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.manufacturer_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'manufacturer\']').attr('value', ui.item.label);
		$('input[name=\'manufacturer_id\']').attr('value', ui.item.value);

		return false;
	},
	focus: function(event, ui) {
		return false;
	}
});

$('body').on('click', '#manufacturer div img', function() {
	$(this).parent().remove();

	$('#manufacturer div:odd').attr('class', 'odd');
	$('#manufacturer div:even').attr('class', 'even');
});
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
					success: function(text) {
						$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
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

<?php echo $footer; ?>