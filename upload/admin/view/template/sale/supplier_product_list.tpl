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
  <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').attr('action','<?php echo $enabled; ?>'); $('#form').submit();" class="button-save ripple"><?php echo $button_enable; ?></a>
        <a onclick="$('#form').attr('action','<?php echo $disabled; ?>'); $('#form').submit();" class="button-cancel ripple"><?php echo $button_disable; ?></a>
        <a href="<?php echo $insert; ?>" class="button ripple"><?php echo $button_insert; ?></a>
        <a onclick="$('#form').attr('action','<?php echo $copy; ?>'); $('#form').submit();" class="button ripple"><?php echo $button_copy; ?></a>
        <a id="delete" class="button-delete ripple"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content-body">
      <div class="report">
        <div class="left"><img src="view/image/product-add.png" alt="" /></div>
        <div class="left"><a id="price-button" class="button-filter"><?php echo $button_update_price; ?></a></div>
        <div class="right"><a onclick="location='<?php echo $refresh; ?>';" class="button-filter"><?php echo $button_refresh; ?></a></div>
      </div>
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
        <tr>
          <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
          <label for="check-all"><span></span></label></td>
          <td class="left"><?php echo $column_id; ?></td>
          <td class="left"><?php echo $column_image; ?></td>
          <td class="left"><?php if ($sort == 'sp.name') { ?>
            <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'sp.model') { ?>
            <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'supplier') { ?>
            <a href="<?php echo $sort_supplier; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_supplier; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_supplier; ?>"><?php echo $column_supplier; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'sp.price') { ?>
            <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'sp.status') { ?>
            <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="right"><?php echo $column_action; ?></td>
        </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td></td>
            <td></td>
            <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
            <td><input type="text" name="filter_model" value="<?php echo $filter_model; ?>" /></td>
			<td><input type="text" name="filter_supplier" value="<?php echo $filter_supplier; ?>" /></td>
            <td class="right"><input type="text" name="filter_price" value="<?php echo $filter_price; ?>" size="10" /></td>
            <td class="center"><select name="filter_status">
              <option value="*"></option>
              <?php if ($filter_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
              <?php } ?>
              <?php if (!is_null($filter_status) && !$filter_status) { ?>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
            <td class="right"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></td>
          </tr>
          <?php if ($supplier_products) { ?>
            <?php foreach ($supplier_products as $supplier_product) { ?>
            <tr>
              <td style="text-align:center;"><?php if ($supplier_product['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $supplier_product['supplier_product_id']; ?>" id="<?php echo $supplier_product['supplier_product_id']; ?>" class="checkbox" checked />
                <label for="<?php echo $supplier_product['supplier_product_id']; ?>"><span></span></label>
              <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $supplier_product['supplier_product_id']; ?>" id="<?php echo $supplier_product['supplier_product_id']; ?>" class="checkbox" />
                <label for="<?php echo $supplier_product['supplier_product_id']; ?>"><span></span></label>
              <?php } ?></td>
              <td class="center"><?php echo $supplier_product['supplier_product_id']; ?></td>
              <td class="center"><img src="<?php echo $supplier_product['image']; ?>" alt="<?php echo $supplier_product['name']; ?>" style="padding:1px; border:1px solid #DDD;" /></td>
              <td class="left"><?php echo $supplier_product['name']; ?></td>
              <td class="left"><?php echo $supplier_product['barcode']; ?><?php echo $supplier_product['model']; ?></td>
              <td class="left"><?php echo $supplier_product['supplier']; ?></td>
              <td class="right"><?php echo $supplier_product['price']; ?></td>
              <?php if ($supplier_product['status'] == 1) { ?>
                <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
              <?php } else { ?>
                <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
              <?php } ?>
              <td class="right"><?php foreach ($supplier_product['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
              <?php } ?></td>
            </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
        </tbody>
        </table>
        <div id="update-price-dialog" style="display:none;"></div>
      </form>
      <?php if ($navigation_lo) { ?>
        <div class="pagination"><?php echo $pagination; ?></div>
      <?php } ?>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=sale/supplier_product&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').prop('value');

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_model = $('input[name=\'filter_model\']').prop('value'); 

	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}

	var filter_supplier = $('input[name=\'filter_supplier\']').prop('value');

	if (filter_supplier) {
		url += '&filter_supplier=' + encodeURIComponent(filter_supplier);
	}

	var filter_price = $('input[name=\'filter_price\']').prop('value');

	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}

	var filter_status = $('select[name=\'filter_status\']').prop('value');

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	location = url;
}
//--></script>

<script type="text/javascript"><!--
window.addEventListener("keydown", function(event) {
	if (event.defaultPrevented) {
		return;
	}

	switch (event.key) {
	case "Enter": filter();
		break;
	default:
		return;
	}

	event.preventDefault();
}, true);
//--></script>

<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/supplier_product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.supplier_product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'filter_name\']').val(ui.item.label);
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'filter_model\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/supplier_product/autocomplete&token=<?php echo $token; ?>&filter_model=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.model,
						value: item.supplier_product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'filter_model\']').val(ui.item.label);
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'filter_supplier\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/supplier_product/autocomplete&token=<?php echo $token; ?>&filter_supplier=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.supplier,
						value: item.supplier_product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'filter_supplier\']').val(ui.item.label);
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>

<script type="text/javascript"><!--
$('body').on('click', '#price-button', function() {
	$.ajax({
		url: 'index.php?route=sale/supplier_product/updatePrice&token=<?php echo $token; ?>',
		dataType: 'json',
		type: 'get',
		success: function(json) {
			$('.success, .warning, .attention, .error').remove();

			if (json['html']) {
				$('#update-price-dialog').html(json['html']);
				$('#update-price-dialog').dialog({
					title: '<?php echo $text_price_title; ?>',
					width: 760,
					height: 400,
					resizable: false,
					modal: true
				});
			} else {
				alert('Invalid response!');
			}
		},
		failure: function() {
			alert('Ajax error!');
		}
	});
});
//--></script>

<script type="text/javascript"><!--
$('#delete').on('click', function() {
	$.confirm({
		title: '<?php echo $text_confirm_delete; ?>',
		content: '<?php echo $text_confirm; ?>',
		icon: 'fa fa-question-circle',
		theme: 'light',
		useBootstrap: false,
		boxWidth: 580,
		animation: 'zoom',
		closeAnimation: 'scale',
		opacity: 0.1,
		buttons: {
			confirm: function() {
				$('form').submit();
			},
			cancel: function() { }
		}
	});
});
//--></script>

<?php echo $footer; ?>