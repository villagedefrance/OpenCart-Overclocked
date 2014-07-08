<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if ($error_install) { ?>
    <div class="warning"><?php echo $error_install; ?></div>
  <?php } ?>
  <?php if ($error_image) { ?>
    <div class="warning"><?php echo $error_image; ?></div>
  <?php } ?>
  <?php if ($error_image_cache) { ?>
    <div class="warning"><?php echo $error_image_cache; ?></div>
  <?php } ?>
  <?php if ($error_cache) { ?>
    <div class="warning"><?php echo $error_cache; ?></div>
  <?php } ?>
  <?php if ($error_download) { ?>
    <div class="warning"><?php echo $error_download; ?></div>
  <?php } ?>
  <?php if ($error_logs) { ?>
    <div class="warning"><?php echo $error_logs; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/home.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <div class="overview">
        <div class="dashboard-heading"><?php echo $text_overview; ?></div>
        <div class="dashboard-content">
          <table>
            <tr>
              <td><?php echo $text_total_sale; ?></td>
              <td><?php echo $total_sale; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_sale_year; ?></td>
              <td><?php echo $total_sale_year; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_sale_month; ?></td>
              <td><?php echo $total_sale_month; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_order; ?></td>
              <td><?php echo $total_order; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_customer; ?></td>
              <td><?php echo $total_customer; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_customer_approval; ?></td>
              <td><?php echo $total_customer_approval; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_review; ?></td>
              <td><?php echo $total_review; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_review_approval; ?></td>
              <td><?php echo $total_review_approval; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_affiliate; ?></td>
              <td><?php echo $total_affiliate; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_affiliate_approval; ?></td>
              <td><?php echo $total_affiliate_approval; ?></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="statistic">
        <div class="range"><?php echo $entry_range; ?>
        <select id="range" onchange="getSalesChart(this.value)">
          <option value="day"><?php echo $text_day; ?></option>
          <option value="week"><?php echo $text_week; ?></option>
          <option value="month"><?php echo $text_month; ?></option>
          <option value="year"><?php echo $text_year; ?></option>
        </select>
        </div>
        <div class="dashboard-heading"><?php echo $text_statistics; ?></div>
        <div class="dashboard-content">
          <div id="report" style="width:500px; height:190px; margin:auto;"></div> 
        </div>
      </div>
      <div class="latest">
        <div class="dashboard-heading"><?php echo $text_latest; ?></div>
        <div class="dashboard-content">
        <div id="latest_tabs" class="htabs">
          <a href="#tab-latest-order"><?php echo $tab_order; ?></a>
          <?php if ($customers) { ?>
            <a href="#tab-latest-customer"><?php echo $tab_customer; ?></a>
          <?php } ?>
          <?php if ($reviews) { ?>
            <a href="#tab-latest-review"><?php echo $tab_review; ?></a>
          <?php } ?>
          <?php if ($affiliates) { ?>
            <a href="#tab-latest-affiliate"><?php echo $tab_affiliate; ?></a>
          <?php } ?>
        </div>
        <div id="tab-latest-order" class="htabs-content">
          <table class="list">
          <thead>
            <tr>
              <td class="center"><?php echo $column_order; ?></td>
              <td class="left"><?php echo $column_customer; ?></td>
              <td class="left"><?php echo $column_date_added; ?></td>
              <td class="left"><?php echo $column_status; ?></td>
              <td class="right"><?php echo $column_total; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php if ($orders) { ?>
            <?php foreach ($orders as $order) { ?>
            <tr>
              <td class="center"><?php echo $order['order_id']; ?></td>
              <td class="left"><?php echo $order['customer']; ?></td>
              <td class="left"><?php echo $order['date_added']; ?></td>
              <td class="left"><?php echo $order['status']; ?></td>
              <td class="right"><?php echo $order['total']; ?></td>
              <td class="right"><?php foreach ($order['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
              <?php } ?></td>
            </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
          </tbody>
          </table>
        </div>
        <?php if ($customers) { ?>
        <div id="tab-latest-customer" class="htabs-content">
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $column_customer; ?></td>
              <td class="left"><?php echo $column_email; ?></td>
              <td class="left"><?php echo $column_customer_group; ?></td>
              <td class="left"><?php echo $column_approved; ?></td>
              <td class="left"><?php echo $column_newsletter; ?></td>
              <td class="left"><?php echo $column_status; ?></td>
              <td class="right"><?php echo $column_date_added; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php if ($customers) { ?>
            <?php foreach ($customers as $customer) { ?>
            <tr>
              <td class="left"><?php echo $customer['name']; ?></td>
              <td class="left"><?php echo $customer['email']; ?></td>
              <td class="left"><?php echo $customer['customer_group']; ?></td>
              <td class="left"><?php echo $customer['approved']; ?></td>
              <td class="left"><?php echo $customer['newsletter']; ?></td>
              <td class="left"><?php echo $customer['status']; ?></td>
              <td class="right"><?php echo $customer['date_added']; ?></td>
              <td class="right"><?php foreach ($customer['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
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
        </div>
        <?php } ?>
        <?php if ($reviews) { ?>
        <div id="tab-latest-review" class="htabs-content">
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $column_product; ?></td>
              <td class="left"><?php echo $column_author; ?></td>
              <td class="left"><?php echo $column_rating; ?></td>
              <td class="left"><?php echo $column_status; ?></td>
              <td class="right"><?php echo $column_date_added; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php if ($reviews) { ?>
          <?php foreach ($reviews as $review) { ?>
            <tr>
              <td class="left"><?php echo $review['name']; ?></td>
              <td class="left"><?php echo $review['author']; ?></td>
              <td class="left"><?php echo $review['rating']; ?></td>
              <td class="left"><?php echo $review['status']; ?></td>
              <td class="right"><?php echo $review['date_added']; ?></td>
              <td class="right"><?php foreach ($review['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
              <?php } ?></td>
            </tr>
          <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>
        <?php } ?>
        <?php if ($affiliates) { ?>
        <div id="tab-latest-affiliate" class="htabs-content">
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $column_affiliate; ?></td>
              <td class="left"><?php echo $column_email; ?></td>
              <td class="left"><?php echo $column_approved; ?></td>
              <td class="left"><?php echo $column_status; ?></td>
              <td class="right"><?php echo $column_date_added; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php if ($affiliates) { ?>
            <?php foreach ($affiliates as $affiliate) { ?>
            <tr>
              <td class="left"><?php echo $affiliate['name']; ?></td>
              <td class="left"><?php echo $affiliate['email']; ?></td>
              <td class="left"><?php echo $affiliate['approved']; ?></td>
              <td class="left"><?php echo $affiliate['status']; ?></td>
              <td class="right"><?php echo $affiliate['date_added']; ?></td>
              <td class="right"><?php foreach ($affiliate['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
              <?php } ?></td>
            </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>
        <?php } ?>
        </div>
    </div>
  </div>
</div>

<!--[if IE]>
<script type="text/javascript" src="view/javascript/jquery/flot/excanvas.min.js"></script>
<![endif]-->

<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.min.js"></script>

<script type="text/javascript"><!--
function getSalesChart(range) {
	$.ajax({
		type: 'get',
		url: 'index.php?route=common/home/chart&token=<?php echo $token; ?>&range=' + range,
		dataType: 'json',
		async: false,
		success: function(json) {
			var option = {
				shadowSize: 0,
				lines: {
					show: true,
					fill: true,
					lineWidth: 1
				},
				grid: {
					backgroundColor: '#FFFFFF'
				},
				xaxis: {
					ticks: json.xaxis
				}
			}

			$.plot($('#report'), [json.order, json.customer], option);
		}
	});
}

getSalesChart($('#range').val());
//--></script>

<script type="text/javascript"><!--
$('#latest_tabs a').tabs();
//--></script>

<?php echo $footer; ?>