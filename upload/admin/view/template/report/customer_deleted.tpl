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
      <table id="customer-deleted" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_id; ?></td>
            <td class="left"><?php echo $column_name; ?></td>
            <td class="left"><?php echo $column_email; ?></td>
            <td class="left"><?php echo $column_orders; ?></td>
            <td class="left"><?php echo $column_date_added; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td class="left"><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
            <td class="left"><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
            <td class="left"><input type="text" name="filter_orders" value="<?php echo $filter_orders; ?>" /></td>
            <td style="text-align:right;"><a onclick="filter();" class="button-filter ripple"><?php echo $button_filter; ?></a></td>
          </tr>
          <?php if ($customers) { ?>
            <?php foreach ($customers as $customer) { ?>
            <tr>
              <td class="left"><?php echo $customer['customer_id']; ?></td>
              <td class="left"><?php echo $customer['name']; ?></td>
              <td class="left"><?php echo $customer['email']; ?></td>
              <td class="center"><?php echo $customer['orders']; ?></td>
              <td class="center"><?php echo $customer['date_added']; ?></td>
            </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=report/customer_deleted&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').prop('value');

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_email = $('input[name=\'filter_email\']').prop('value');

	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

	var filter_orders = $('input[name=\'filter_orders\']').prop('value');

	if (filter_orders) {
		url += '&filter_orders=' + encodeURIComponent(filter_orders);
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
			url: 'index.php?route=report/customer_deleted/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.customer_id
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
//--></script>

<?php echo $footer; ?>