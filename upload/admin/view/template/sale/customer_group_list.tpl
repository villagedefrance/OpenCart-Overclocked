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
            <td class="left"><?php if ($sort == 'cgd.name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'cg.approval') { ?>
              <a href="<?php echo $sort_approval; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_approval; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_approval; ?>"><?php echo $column_approval; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'cg.company_id_display') { ?>
              <a href="<?php echo $sort_company_id_display; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_company_id; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_company_id_display; ?>"><?php echo $column_company_id; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'cg.tax_id_display') { ?>
              <a href="<?php echo $sort_tax_id_display; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_tax_id; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_tax_id_display; ?>"><?php echo $column_tax_id; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
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
        <?php if ($customer_groups) { ?>
          <?php foreach ($customer_groups as $customer_group) { ?>
          <tr>
            <td style="text-align:center;"><?php if ($customer_group['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $customer_group['customer_group_id']; ?>" id="<?php echo $customer_group['customer_group_id']; ?>" class="checkbox" checked />
              <label for="<?php echo $customer_group['customer_group_id']; ?>"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $customer_group['customer_group_id']; ?>" id="<?php echo $customer_group['customer_group_id']; ?>" class="checkbox" />
              <label for="<?php echo $customer_group['customer_group_id']; ?>"><span></span></label>
            <?php } ?></td>
            <td class="left"><?php echo $customer_group['name']; ?></td>
            <td class="center"><?php echo $customer_group['approval']; ?></td>
            <td class="center"><?php echo $customer_group['company_id']; ?></td>
            <td class="center"><?php echo $customer_group['tax_id']; ?></td>
            <td class="center"><?php echo $customer_group['sort_order']; ?></td>
            <td class="right"><?php foreach ($customer_group['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
            <?php } ?></td>
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