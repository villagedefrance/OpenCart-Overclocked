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
      <h1><img src="view/image/tax.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $tax_classes; ?>" class="button-cancel ripple"><?php echo $button_classes; ?></a>
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
            <td class="left"><?php if ($sort == 'tr.name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'tr.rate') { ?>
              <a href="<?php echo $sort_rate; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rate; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_rate; ?>"><?php echo $column_rate; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'tr.type') { ?>
              <a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_type; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_type; ?>"><?php echo $column_type; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td> 
            <td class="left"><?php if ($sort == 'gz.name') { ?>
              <a href="<?php echo $sort_geo_zone; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_geo_zone; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_geo_zone; ?>"><?php echo $column_geo_zone; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td> 
            <td class="left"><?php if ($sort == 'tr.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'tr.date_modified') { ?>
              <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($tax_rates) { ?>
          <?php foreach ($tax_rates as $tax_rate) { ?>
          <tr>
            <td style="text-align:center;"><?php if ($tax_rate['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $tax_rate['tax_rate_id']; ?>" id="<?php echo $tax_rate['tax_rate_id']; ?>" class="checkbox" checked />
              <label for="<?php echo $tax_rate['tax_rate_id']; ?>"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $tax_rate['tax_rate_id']; ?>" id="<?php echo $tax_rate['tax_rate_id']; ?>" class="checkbox" />
              <label for="<?php echo $tax_rate['tax_rate_id']; ?>"><span></span></label>
            <?php } ?></td>
            <td class="left"><?php echo $tax_rate['name']; ?></td>
            <td class="right"><?php echo $tax_rate['rate']; ?></td>
            <td class="center"><?php echo $tax_rate['type']; ?></td>
            <td class="center"><?php echo $tax_rate['geo_zone']; ?></td>
            <td class="center"><?php echo $tax_rate['date_added']; ?></td>
            <td class="center"><?php echo $tax_rate['date_modified']; ?></td>
            <td class="right"><?php foreach ($tax_rate['action'] as $action) { ?>
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