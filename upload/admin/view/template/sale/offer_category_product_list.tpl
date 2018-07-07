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
      <h1><img src="view/image/offer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $dashboard; ?>" class="button-cancel ripple"><i class="fa fa-arrow-left"></i> &nbsp; <?php echo $button_dashboard; ?></a>
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
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'discount') { ?>
              <a href="<?php echo $sort_discount; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_discount; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_discount; ?>"><?php echo $column_discount; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'type') { ?>
              <a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_type; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_type; ?>"><?php echo $column_type; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'logged') { ?>
              <a href="<?php echo $sort_logged; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_logged; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_logged; ?>"><?php echo $column_logged; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'date_start') { ?>
              <a href="<?php echo $sort_date_start; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_start; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_start; ?>"><?php echo $column_date_start; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'date_end') { ?>
              <a href="<?php echo $sort_date_end; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_end; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_end; ?>"><?php echo $column_date_end; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($offer_category_products) { ?>
          <?php foreach ($offer_category_products as $offer_category_product) { ?>
          <tr>
            <td style="text-align:center;"><?php if ($offer_category_product['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $offer_category_product['offer_category_product_id']; ?>" id="<?php echo $offer_category_product['offer_category_product_id']; ?>" class="checkbox" checked />
              <label for="<?php echo $offer_category_product['offer_category_product_id']; ?>"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $offer_category_product['offer_category_product_id']; ?>" id="<?php echo $offer_category_product['offer_category_product_id']; ?>" class="checkbox" />
              <label for="<?php echo $offer_category_product['offer_category_product_id']; ?>"><span></span></label>
            <?php } ?></td>
            <td class="left"><?php echo $offer_category_product['name']; ?></td>
            <td class="center"><?php echo $offer_category_product['discount']; ?></td>
            <td class="center"><?php echo $offer_category_product['type']; ?></td>
            <td class="center"><?php echo $offer_category_product['logged']; ?></td>
            <td class="left"><?php echo $offer_category_product['date_start']; ?></td>
            <td class="left"><?php echo $offer_category_product['date_end']; ?></td>
            <?php if ($offer_category_product['status'] == 1) { ?>
              <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
            <?php } else { ?>
              <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
            <?php } ?>
            <td class="right"><?php foreach ($offer_category_product['action'] as $action) { ?>
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