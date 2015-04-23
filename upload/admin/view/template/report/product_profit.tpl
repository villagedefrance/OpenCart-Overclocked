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
    </div>
    <div class="content">
	<?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <table class="form">
        <tr style="background:#F8F8F8;">
          <td><?php echo $entry_date_start; ?> <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?> <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td><?php echo $entry_status; ?>
          <select name="filter_order_status_id">
          <option value="0"><?php echo $text_all_status; ?></option>
          <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
          <?php } ?>
          </select></td>
          <td style="text-align:right;"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_year; ?></td>
            <td class="left"><?php echo $column_month; ?></td>
            <td class="right"><?php echo $column_price; ?></td>
            <td class="right"><?php echo $column_cost; ?></td>
            <td class="right"><?php echo $column_profit; ?> (%)</td>
            <td class="right"><?php echo $column_profit; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($products) { ?>
            <?php foreach ($products as $product) { ?>
			  <tr>
			    <td class="left"><?php echo $product['year']; ?></td>
			    <td class="left"><?php echo $product['month']; ?></td>
			    <td class="right"><?php echo $product['price']; ?></td>
			    <td class="right"><?php echo $product['cost']; ?></td>
			    <td class="right"><?php echo $product['percent_profit']; ?></td>
                <td class="right"><?php echo $product['profit']; ?></td>
              </tr>
            <?php } ?>
            <tr>
		      <td class="left" colspan="2" style="background-color:#F8F8F8;"></td>
		      <td class="right" style="background-color:#F8F8F8;"><b><?php echo $text_total; ?> <?php echo $column_price; ?></b></td>
		      <td class="right" style="background-color:#F8F8F8;"><b><?php echo $text_total; ?> <?php echo $column_cost; ?></b></td>
		      <td class="right" style="background-color:#F8F8F8;"><b><?php echo $text_total; ?> <?php echo $column_profit; ?> (%)</b></td>
		      <td class="right" style="background-color:#F8F8F8;"><b><?php echo $text_total; ?> <?php echo $column_profit; ?></b></td>
            </tr>
			<tr>
		      <td class="left" colspan="2"></td>
		      <td class="right"><?php echo $total_price; ?></td>
		      <td class="right"><?php echo $total_cost; ?></td>
		      <td class="right"><?php echo $total_percent_profit; ?></td>
		      <td class="right"><?php echo $total_profit; ?></td>
		    </tr>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=report/product_profit&token=<?php echo $token; ?>';

	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');

	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');

	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}

	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');

	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}

	location = url;
}
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<?php echo $footer; ?>