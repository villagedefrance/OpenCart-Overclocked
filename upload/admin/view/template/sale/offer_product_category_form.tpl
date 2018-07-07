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
      <h1><img src="view/image/offer.png" alt="" /> <?php echo $heading_title; ?></h1>
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
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><?php if ($error_name) { ?>
              <input type="text" name="name" value="<?php echo $name; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_name; ?></span>
            <?php } else { ?>
              <input type="text" name="name" value="<?php echo $name; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_type; ?></td>
            <td><select name="type">
              <?php if ($type == 'P') { ?>
                <option value="P" selected="selected"><?php echo $text_percent; ?></option>
              <?php } else { ?>
                <option value="P"><?php echo $text_percent; ?></option>
              <?php } ?>
              <?php if ($type == 'F') { ?>
                <option value="F" selected="selected"><?php echo $text_fixed; ?></option>
              <?php } else { ?>
                <option value="F"><?php echo $text_fixed; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_discount; ?></td>
            <td><input type="text" name="discount" value="<?php echo $discount; ?>" />
            <?php if ($error_percent) { ?>
              <span class="error"><?php echo $error_percent; ?></span>
            <?php } ?>
            <?php if ($error_price) { ?>
              <span class="error"><?php echo $error_price; ?> (<?php echo $lowest_price; ?>)</span>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_logged; ?></td>
            <td><?php if ($logged) { ?>
              <input type="radio" name="logged" value="1" id="logged-on" class="radio" checked />
              <label for="logged-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="logged" value="0" id="logged-off" class="radio" />
              <label for="logged-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="logged" value="1" id="logged-on" class="radio" />
              <label for="logged-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="logged" value="0" id="logged-off" class="radio" checked />
              <label for="logged-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        <?php if ($autocomplete_off) { ?>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_product_one; ?></td>
            <td><?php if ($error_product) { ?>
              <select name="product_one" class="input-error">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($products as $product) { ?>
                  <?php if ($product['product_id'] == $product_one) { ?>
                    <option value="<?php echo $product['product_id']; ?>" selected="selected"><?php echo $product['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
              <span class="error"><?php echo $error_product; ?></span>
            <?php } else { ?>
              <select name="product_one">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($products as $product) { ?>
                  <?php if ($product['product_id'] == $product_one) { ?>
                    <option value="<?php echo $product['product_id']; ?>" selected="selected"><?php echo $product['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            <?php } ?></td>
          </tr>
        <?php } else { ?>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_product_one; ?><?php echo $text_autocomplete; ?></td>
            <td><?php if ($error_product) { ?>
              <input type="text" name="product_one_name" value="<?php echo $product_one_name; ?>" size="30" class="input-error" />
              <input type="hidden" name="product_one" value="<?php echo $product_one; ?>" />
              <span class="error"><?php echo $error_product; ?></span>
            <?php } else { ?>
              <input type="text" name="product_one_name" value="<?php echo $product_one_name; ?>" size="30" />
              <input type="hidden" name="product_one" value="<?php echo $product_one; ?>" />
            <?php } ?></td>
          </tr>
        <?php } ?>
        <?php if ($autocomplete_off) { ?>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_category_two; ?></td>
            <td><?php if ($error_category) { ?>
              <select name="category_two" class="input-error">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($categories as $category) { ?>
                  <?php if ($category['category_id'] == $category_two) { ?>
                    <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
              <span class="error"><?php echo $error_category; ?></span>
            <?php } else { ?>
              <select name="category_two">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($categories as $category) { ?>
                  <?php if ($category['category_id'] == $category_two) { ?>
                    <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            <?php } ?></td>
          </tr>
        <?php } else { ?>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_category_two; ?><?php echo $text_autocomplete; ?></td>
            <td><?php if ($error_category) { ?>
              <input type="text" name="category_two_name" value="<?php echo $category_two_name; ?>" size="30" class="input-error" />
              <input type="hidden" name="category_two" value="<?php echo $category_two; ?>" />
              <span class="error"><?php echo $error_category; ?></span>
            <?php } else { ?>
              <input type="text" name="category_two_name" value="<?php echo $category_two_name; ?>" size="30" />
              <input type="hidden" name="category_two" value="<?php echo $category_two; ?>" />
            <?php } ?>
            </td>
          </tr>
        <?php } ?>
          <tr>
            <td><?php echo $entry_date_start; ?></td>
            <td><input type="text" name="date_start" value="<?php echo $date_start; ?>" id="date-start" size="12" />
            <span class="form-icon"><img src="view/image/calendar.png" alt="" /></span></td>
          </tr>
          <tr>
            <td><?php echo $entry_date_end; ?></td>
            <td><input type="text" name="date_end" value="<?php echo $date_end; ?>" id="date-end" size="12" />
            <span class="form-icon"><img src="view/image/calendar.png" alt="" /></span></td>
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

$('input[name=\'product_one_name\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/offer_product_category/autocompletePro&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					'product_id': 0,
					'name': '<?php echo $text_none; ?>'
				});

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
		$('input[name=\'product_one_name\']').attr('value', ui.item.label);
		$('input[name=\'product_one\']').attr('value', ui.item.value);

		return false;
	},
	focus: function(event, ui) {
		return false;
	}
});

$('input[name=\'category_two_name\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/offer_product_category/autocompleteCat&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					'category_id': 0,
					'name': '<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.category_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'category_two_name\']').attr('value', ui.item.label);
		$('input[name=\'category_two\']').attr('value', ui.item.value);

		return false;
	},
	focus: function(event, ui) {
		return false;
	}
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<?php echo $footer; ?>