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
      <div class="report">
        <div class="left"><i class="fa fa-search" style="font-size:19px;"></i></div>
        <div class="left"><em><?php echo $entry_date_start; ?></em> <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /> <img src="view/image/calendar.png" alt="" /></div>
        <div class="left"><em><?php echo $entry_date_end; ?></em> <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /> <img src="view/image/calendar.png" alt="" /></div>
        <div class="left"><em><?php echo $entry_status; ?></em> <select name="filter_order_status_id">
          <option value="0"><?php echo $text_all_status; ?></option>
          <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
          <?php } ?>
        </select></div>
        <div class="right"><a onclick="filter();" class="button-filter ripple"><?php echo $button_filter; ?></a></div>
      </div>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_customer; ?></td>
            <td class="left"><?php echo $column_email; ?></td>
            <td class="left"><?php echo $column_customer_group; ?></td>
            <td class="left"><?php echo $column_status; ?></td>
            <td class="right"><?php echo $column_orders; ?></td>
            <td class="right"><?php echo $column_products; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($customers) { ?>
          <?php foreach ($customers as $customer) { ?>
          <tr>
            <td class="left"><?php echo $customer['customer']; ?></td>
            <td class="left"><?php echo $customer['email']; ?></td>
            <td class="left"><?php echo $customer['customer_group']; ?></td>
          <?php if ($customer['status'] == 2) { ?>
            <td class="center"><span class="deleted"><?php echo $text_deleted; ?></span></td>
          <?php } elseif ($customer['status'] == 1) { ?>
            <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
          <?php } else { ?>
            <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
          <?php } ?>
            <td class="right"><?php echo $customer['orders']; ?></td>
            <td class="right"><?php echo $customer['products']; ?></td>
            <td class="right"><?php echo $customer['total']; ?></td>
            <td class="right"><?php foreach ($customer['action'] as $action) { ?>
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
	url = 'index.php?route=report/customer_order&token=<?php echo $token; ?>';

	var filter_date_start = $('input[name=\'filter_date_start\']').prop('value');

	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').prop('value');

	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}

	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').prop('value');

	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
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
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<?php echo $footer; ?>