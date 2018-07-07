<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location='<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <table id="product-quantity" class="list">
        <thead>
        <tr>
          <td class="left"><?php echo $column_id; ?></td>
          <td class="left"><?php if ($sort == 'pd.name') { ?>
            <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'p.model') { ?>
            <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'p.price') { ?>
            <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'p.cost') { ?>
            <a href="<?php echo $sort_cost; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_cost; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_cost; ?>"><?php echo $column_cost; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'p.status') { ?>
            <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'p.quantity') { ?>
            <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="right"><?php echo $column_action; ?></td>
        </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
            <td><input type="text" name="filter_model" value="<?php echo $filter_model; ?>" /></td>
            <td class="right"><input type="text" name="filter_price" value="<?php echo $filter_price; ?>" size="10" /></td>
            <td></td>
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
            <td class="right"><input type="text" name="filter_quantity" value="<?php echo $filter_quantity; ?>" size="10" /></td>
            <td class="right"><a onclick="filter();" class="button-filter ripple"><?php echo $button_filter; ?></a></td>
          </tr>
        <?php if ($products) { ?>
          <?php foreach ($products as $product) { ?>
            <tr>
              <td class="center"><?php echo $product['product_id']; ?></td>
              <td class="left"><?php echo $product['name']; ?></td>
              <td class="left"><?php echo $product['model']; ?></td>
              <td class="right"><?php echo $product['price']; ?></td>
              <td class="right"><?php echo $product['cost']; ?></td>
              <?php if ($product['status'] == 1) { ?>
                <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
              <?php } else { ?>
                <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
              <?php } ?>
              <td class="right"><?php if ($product['quantity'] <= 0) { ?>
                <span style="color:#FF0000;"><?php echo $product['quantity']; ?></span>
              <?php } elseif ($product['quantity'] <= 9) { ?>
                <span style="color:#FFA500;"><?php echo $product['quantity']; ?></span>
              <?php } else { ?>
                <span style="color:#5DC15E;"><?php echo $product['quantity']; ?></span>
              <?php } ?></td>
              <td class="right"><?php foreach ($product['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>" class="button-form ripple"><?php echo $action['text']; ?></a>
              <?php } ?></td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    <?php if ($navigation_lo) { ?>
      <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/product_quantity&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').prop('value');

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_model = $('input[name=\'filter_model\']').prop('value'); 

	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}

	var filter_price = $('input[name=\'filter_price\']').prop('value');

	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}

	var filter_status = $('select[name=\'filter_status\']').prop('value');

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	var filter_quantity = $('input[name=\'filter_quantity\']').prop('value');

	if (filter_quantity) {
		url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
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
			url: 'index.php?route=report/product_quantity/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
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
			url: 'index.php?route=report/product_quantity/autocomplete&token=<?php echo $token; ?>&filter_model=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.model,
						value: item.product_id
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
//--></script>

<?php echo $footer; ?>