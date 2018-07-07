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
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('form').attr('action','<?php echo $approve; ?>'); $('form').submit();" class="button-save ripple"><?php echo $button_approve; ?></a>
        <a href="<?php echo $insert; ?>" class="button ripple"><?php echo $button_insert; ?></a>
        <a id="delete" class="button-delete ripple"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form" name="customer">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'c.email') { ?>
              <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'customer_group') { ?>
              <a href="<?php echo $sort_customer_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_group; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_customer_group; ?>"><?php echo $column_customer_group; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'c.status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'c.approved') { ?>
              <a href="<?php echo $sort_approved; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_approved; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_approved; ?>"><?php echo $column_approved; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'c.ip') { ?>
              <a href="<?php echo $sort_ip; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ip; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_ip; ?>"><?php echo $column_ip; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'c.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php echo $column_login; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
            <td><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
            <td><select name="filter_customer_group_id">
              <option value="*"></option>
              <?php foreach ($customer_groups as $customer_group) { ?>
                <?php if ($customer_group['customer_group_id'] == $filter_customer_group_id) { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
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
            <td class="center"><select name="filter_approved">
              <option value="*"></option>
              <?php if ($filter_approved) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
              <?php } ?>
              <?php if (!is_null($filter_approved) && !$filter_approved) { ?>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } else { ?>
                <option value="0"><?php echo $text_no; ?></option>
              <?php } ?>
            </select></td>
            <td class="center"><input type="text" name="filter_ip" value="<?php echo $filter_ip; ?>" /></td>
            <td class="center"><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date" /></td>
            <td></td>
            <td style="text-align:right;"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></td>
          </tr>
        <?php if ($customers) { ?>
          <?php foreach ($customers as $customer) { ?>
          <tr>
            <td style="text-align:center;"><?php if ($customer['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" id="<?php echo $customer['customer_id']; ?>" class="checkbox" checked />
              <label for="<?php echo $customer['customer_id']; ?>"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" id="<?php echo $customer['customer_id']; ?>" class="checkbox" />
              <label for="<?php echo $customer['customer_id']; ?>"><span></span></label>
            <?php } ?></td>
            <td class="left"><?php echo $customer['name']; ?><?php if ($show_dob) { echo '(' . $customer['age'] . ')'; } ?></td>
            <td class="left"><?php echo $customer['email']; ?></td>
            <td class="left"><?php echo $customer['customer_group']; ?></td>
            <?php if ($customer['status'] == 2) { ?>
              <td class="center"><span class="deleted"><?php echo $text_deleted; ?></span></td>
            <?php } elseif ($customer['status'] == 1) { ?>
              <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
            <?php } else { ?>
              <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
            <?php } ?>
            <td class="center"><?php echo $customer['approved'] ? '<img src="view/image/success.png" alt="' . $text_yes . '" />' : '<img src="view/image/warning.png" alt="' . $text_no . '" />'; ?></td>
            <td class="center"><?php echo $customer['ip']; ?>&nbsp;<?php echo $customer['blocked_ip']; ?></td>
            <td class="center"><?php echo $customer['date_added']; ?></td>
            <td class="left"><select onchange="((this.value !== '') ? window.open('index.php?route=sale/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $customer['customer_id']; ?>&store_id=' + this.value) : null); this.value = '';">
              <option value=""><?php echo $text_select; ?></option>
              <option value="0"><?php echo $text_default; ?></option>
              <?php foreach ($stores as $store) { ?>
                <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
              <?php } ?>
            </select></td>
            <td class="right"><?php foreach ($customer['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
            <?php } ?></td>
          </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=sale/customer&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').prop('value');

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_email = $('input[name=\'filter_email\']').prop('value');

	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

	var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').prop('value');

	if (filter_customer_group_id != '*') {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}

	var filter_status = $('select[name=\'filter_status\']').prop('value');

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	var filter_approved = $('select[name=\'filter_approved\']').prop('value');

	if (filter_approved != '*') {
		url += '&filter_approved=' + encodeURIComponent(filter_approved);
	}

	var filter_ip = $('input[name=\'filter_ip\']').prop('value');

	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}

	var filter_date_added = $('input[name=\'filter_date_added\']').prop('value');

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
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
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
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