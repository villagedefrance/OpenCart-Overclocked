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
      <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $insert; ?>" class="button ripple"><?php echo $button_insert; ?></a>
        <a id="delete" class="button-delete ripple"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <form action="" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="left"><?php if ($sort == 'o.order_id') { ?>
              <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'customer') { ?>
              <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'o.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'o.date_modified') { ?>
              <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'o.total') { ?>
              <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td class="center"><input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" size="6" style="text-align:right;" /></td>
            <td class="left"><input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" /></td>
            <td class="left"><select name="filter_order_status_id">
              <option value="*"></option>
              <?php if ($filter_order_status_id == '0') { ?>
                <option value="0" selected="selected"><?php echo $text_missing; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_missing; ?></option>
              <?php } ?>
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
            <td class="left"><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" class="date" /></td>
            <td class="left"><input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" size="12" class="date" /></td>
            <td class="right"><input type="text" name="filter_total" value="<?php echo $filter_total; ?>" size="10" style="text-align:right;" /></td>
            <td class="right"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></td>
          </tr>
          <?php if ($orders) { ?>
            <?php foreach ($orders as $order) { ?>
            <tr>
              <td style="text-align:center;"><?php if ($order['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" id="<?php echo $order['order_id']; ?>" class="checkbox" checked />
                <label for="<?php echo $order['order_id']; ?>"><span></span></label>
              <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" id="<?php echo $order['order_id']; ?>" class="checkbox" />
                <label for="<?php echo $order['order_id']; ?>"><span></span></label>
              <?php } ?></td>
              <td class="center"><?php echo $order['order_id']; ?></td>
              <td class="left"><?php echo $order['customer']; ?></td>
              <td class="left"><?php echo $order['status']; ?></td>
              <td class="left"><?php echo $order['date_added']; ?></td>
              <td class="left"><?php echo $order['date_modified']; ?></td>
              <td class="right"><?php echo $order['total']; ?></td>
              <td class="right"><?php foreach ($order['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
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
    </form>
    <?php if ($navigation_lo) { ?>
      <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=sale/order&token=<?php echo $token; ?>';

	var filter_order_id = $('input[name=\'filter_order_id\']').prop('value');

	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}

	var filter_customer = $('input[name=\'filter_customer\']').prop('value');

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').prop('value');

	if (filter_order_status_id != '*') {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}

	var filter_date_added = $('input[name=\'filter_date_added\']').prop('value');

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_date_modified = $('input[name=\'filter_date_modified\']').prop('value');

	if (filter_date_modified) {
		url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
	}

	var filter_total = $('input[name=\'filter_total\']').prop('value');

	if (filter_total) {
		url += '&filter_total=' + encodeURIComponent(filter_total);
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
$(document).ready(function() {
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';

		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				currentCategory = item.category;
			}

			self._renderItemData(ul, item);
		});
	}
});

$('input[name=\'filter_customer\']').catcomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return [{
						category: item.customer_group,
						label: item.name,
						value: item.customer_id
					}]
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'filter_customer\']').val(ui.item.label);
		return false;
	},
	focus: function(event, ui) {
		return false;
	}
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