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
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="left"><?php if ($sort == 'sgd.name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'sg.order_method') { ?>
              <a href="<?php echo $sort_order_method; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_method; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_order_method; ?>"><?php echo $column_order_method; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'sg.payment_method') { ?>
              <a href="<?php echo $sort_payment_method; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_payment_method; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_payment_method; ?>"><?php echo $column_payment_method; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'cg.sort_order') { ?>
              <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($supplier_groups) { ?>
          <?php foreach ($supplier_groups as $supplier_group) { ?>
          <tr>
            <td style="text-align:center;"><?php if ($supplier_group['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $supplier_group['supplier_group_id']; ?>" id="<?php echo $supplier_group['supplier_group_id']; ?>" class="checkbox" checked />
              <label for="<?php echo $supplier_group['supplier_group_id']; ?>"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $supplier_group['supplier_group_id']; ?>" id="<?php echo $supplier_group['supplier_group_id']; ?>" class="checkbox" />
              <label for="<?php echo $supplier_group['supplier_group_id']; ?>"><span></span></label>
            <?php } ?></td>
            <td class="left"><?php echo $supplier_group['name']; ?></td>
            <td class="left"><?php echo $supplier_group['order_method']; ?></td>
			<td class="left"><?php echo $supplier_group['payment_method']; ?></td>
            <td class="center"><?php echo $supplier_group['sort_order']; ?></td>
            <td class="right"><?php foreach ($supplier_group['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
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
    </form>
    <?php if ($navigation_lo) { ?>
      <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
    </div>
  </div>
</div>

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