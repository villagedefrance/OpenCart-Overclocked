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
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
    <form action="" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="10" class="left"><?php if ($sort == 'or.order_recurring_id') { ?>
              <a href="<?php echo $sort_order_recurring; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_order_recurring; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_order_recurring; ?>"><?php echo $entry_order_recurring; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'or.order_id') { ?>
              <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_order_id; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_order; ?>"><?php echo $entry_order_id; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'or.profile_reference') { ?>
              <a href="<?php echo $sort_payment_reference; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_payment_reference; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_payment_reference; ?>"><?php echo $entry_payment_reference; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'customer') { ?>
              <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_customer; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_customer; ?>"><?php echo $entry_customer; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'or.created') { ?>
              <a href="<?php echo $sort_created; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_date_created; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_created; ?>"><?php echo $entry_date_created; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'or.status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_status; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $entry_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $entry_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td class="left"><input type="text" name="filter_order_recurring_id" value="<?php echo $filter_order_recurring_id; ?>" size="4" /></td>
            <td class="left"><input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" size="6" /></td>
            <td class="left"><input type="text" name="filter_payment_reference" value="<?php echo $filter_payment_reference; ?>" /></td>
            <td class="left"><input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" /></td>
            <td class="left"><input type="text" name="filter_created" value="<?php echo $filter_created; ?>" class="date" /></td>
            <td class="left"><select name="filter_status">
              <?php foreach ($statuses as $status => $text) { ?>
                <?php if ($filter_status == $status) { ?>
                  <option value="<?php echo $status; ?>" selected="selected"><?php echo $text; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $status; ?>"><?php echo $text; ?></option>
                <?php } ?>
              <?php } ?>
              </select></td>
            <td class="right"><a onclick="filter();" class="button-filter"><?php echo $text_filter; ?></a></td>
          </tr>
          <?php if (!empty($profiles)) { ?>
            <?php foreach ($profiles as $profile) { ?>
            <tr>
              <td class="left"><?php echo $profile['order_recurring_id']; ?></td>
              <td class="left"><a href="<?php echo $profile['order_link']; ?>"><?php echo $profile['order_id']; ?></a></td>
              <td class="left"><?php echo $profile['profile_reference']; ?></td>
              <td class="left"><?php echo $profile['customer']; ?></td>
              <td class="center"><?php echo $profile['date_created']; ?></td>
              <?php if ($profile['status'] == 1) { ?>
                <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
              <?php } else { ?>
                <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
              <?php } ?>
              <td class="right">
                <?php foreach ($profile['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=sale/recurring&token=<?php echo $token; ?>';

	var filter_order_recurring_id = $('input[name=\'filter_order_recurring_id\']').prop('value');

	if (filter_order_recurring_id) {
		url += '&filter_order_recurring_id=' + encodeURIComponent(filter_order_recurring_id);
	}

	var filter_order_id = $('input[name=\'filter_order_id\']').prop('value');

	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}

	var filter_payment_reference = $('input[name=\'filter_payment_reference\']').prop('value');

	if (filter_payment_reference) {
		url += '&filter_payment_reference=' + encodeURIComponent(filter_payment_reference);
	}

	var filter_customer = $('input[name=\'filter_customer\']').prop('value');

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

	var filter_created = $('input[name=\'filter_created\']').prop('value');

	if (filter_created != '') {
		url += '&filter_created=' + encodeURIComponent(filter_created);
	}

	var filter_status = $('select[name=\'filter_status\']').prop('value');

	if (filter_status != '0') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	location = url;
}

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

<?php echo $footer; ?>