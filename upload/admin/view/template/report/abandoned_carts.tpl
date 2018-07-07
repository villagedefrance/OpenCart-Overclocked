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
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a id="button-recover" form="form" formaction="<?php echo $recover; ?>" title="<?php echo $button_recover; ?>" class="button-save ripple"><i class="fa fa-paper-plane"></i> &nbsp; <?php echo $button_recover; ?></a>
        <a id="button-delete" form="form" formaction="<?php echo $delete; ?>" title="<?php echo $button_delete; ?>" class="button-delete ripple"><i class="fa fa-trash-o"></i> &nbsp; <?php echo $button_delete; ?></a>
        <a onclick="location='<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="center"><?php if ($sort == 'o.order_id') { ?>
              <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'o.total') { ?>
              <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'o.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'o.ip') { ?>
              <a href="<?php echo $sort_ip; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ip; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_ip; ?>"><?php echo $column_ip; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'o.abandoned') { ?>
              <a href="<?php echo $sort_abandoned; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_abandoned; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_abandoned; ?>"><?php echo $column_abandoned; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td></td>
            <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:right;"><a onclick="filter();" class="button-filter ripple"><?php echo $button_filter; ?></a></td>
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
            <td class="left"><?php echo $order['name']; ?></td>
            <td class="right"><?php echo $order['total']; ?></td>
            <td class="center"><?php echo $order['date_added']; ?></td>
            <td class="center"><?php echo $order['ip']; ?></td>
            <td class="center"><?php echo ($order['abandoned'] == '1') ? '<span class="passed"><a title="' . $text_reminder . '" style="color:#FFF;"><i class="fa fa-check"></i></a></span>' : '<span class="disabled"><i class="fa fa-hourglass-half"></i></span>'; ?></td>
            <td class="right"><?php foreach ($order['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
            <?php } ?></td>
          </tr>
          <?php if ($order['abandoned'] == '0' && $order['duplicate_count'] > 1) { ?>
          <tr style="line-height:16px; vertical-align:top;">
            <td><img src="view/image/attention.png" alt="" style="padding:3px 0 0 2px;" /></td>
            <td colspan="7"><?php echo $order['duplicate']; ?></td>
          </tr>
          <?php } ?>
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
	url = 'index.php?route=report/abandoned_carts&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').prop('value');

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
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
$('#button-recover').on('click', function() {
	$('#form').attr('action', this.getAttribute('formaction'));
	$('#form').submit();
});

$('#button-delete').on('click', function() {
	$('#form').attr('action', this.getAttribute('formaction'));
	$('#form').submit();
});
//--></script>

<?php echo $footer; ?>