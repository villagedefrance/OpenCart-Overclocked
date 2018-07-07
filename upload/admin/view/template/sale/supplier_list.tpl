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
            <td class="left"><?php if ($sort == 's.reference') { ?>
              <a href="<?php echo $sort_reference; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_reference; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_reference; ?>"><?php echo $column_reference; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 's.company') { ?>
              <a href="<?php echo $sort_company; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_company; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_company; ?>"><?php echo $column_company; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 's.email') { ?>
              <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 's.supplier_group') { ?>
              <a href="<?php echo $sort_supplier_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_supplier_group; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_supplier_group; ?>"><?php echo $column_supplier_group; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 's.status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 's.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php echo $column_date_modified; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td><input type="text" name="filter_reference" value="<?php echo $filter_reference; ?>" /></td>
            <td><input type="text" name="filter_company" value="<?php echo $filter_company; ?>" /></td>
            <td><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
            <td><select name="filter_supplier_group_id">
              <option value="*"></option>
              <?php foreach ($supplier_groups as $supplier_group) { ?>
                <?php if ($supplier_group['supplier_group_id'] == $filter_supplier_group_id) { ?>
                  <option value="<?php echo $supplier_group['supplier_group_id']; ?>" selected="selected"><?php echo $supplier_group['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $supplier_group['supplier_group_id']; ?>"><?php echo $supplier_group['name']; ?></option>
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
            <td class="center"><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date" /></td>
            <td></td>
            <td style="text-align:right;"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></td>
          </tr>
        <?php if ($suppliers) { ?>
          <?php foreach ($suppliers as $supplier) { ?>
          <tr>
            <td style="text-align:center;"><?php if ($supplier['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $supplier['supplier_id']; ?>" id="<?php echo $supplier['supplier_id']; ?>" class="checkbox" checked />
              <label for="<?php echo $supplier['supplier_id']; ?>"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $supplier['supplier_id']; ?>" id="<?php echo $supplier['supplier_id']; ?>" class="checkbox" />
              <label for="<?php echo $supplier['supplier_id']; ?>"><span></span></label>
            <?php } ?></td>
            <td class="left"><?php echo $supplier['reference']; ?></td>
            <td class="left"><?php echo $supplier['company']; ?></td>
            <td class="left"><?php echo $supplier['email']; ?></td>
            <td class="left"><?php echo $supplier['supplier_group']; ?></td>
            <?php if ($supplier['status'] == 1) { ?>
              <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
            <?php } else { ?>
              <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
            <?php } ?>
            <td class="center"><?php echo $supplier['date_added']; ?></td>
            <td class="center"><?php echo $supplier['date_modified']; ?></td>
            <td class="right"><?php foreach ($supplier['action'] as $action) { ?>
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
    </form>
    <?php if ($navigation_lo) { ?>
      <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=sale/supplier&token=<?php echo $token; ?>';

	var filter_reference = $('input[name=\'filter_reference\']').prop('value');

	if (filter_reference) {
		url += '&filter_reference=' + encodeURIComponent(filter_reference);
	}

	var filter_company = $('select[name=\'filter_company\']').prop('value');

	if (filter_company) {
		url += '&filter_company=' + encodeURIComponent(filter_company);
	}

	var filter_email = $('input[name=\'filter_email\']').prop('value');

	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

	var filter_supplier_group_id = $('select[name=\'filter_supplier_group_id\']').prop('value');

	if (filter_supplier_group_id != '*') {
		url += '&filter_supplier_group_id=' + encodeURIComponent(filter_supplier_group_id);
	}

	var filter_status = $('select[name=\'filter_status\']').prop('value');

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
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