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
      <h1><img src="view/image/voucher.png" alt="" /> <?php echo $heading_title; ?></h1>
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
              <td class="left"><?php if ($sort == 'v.code') { ?>
                <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
              <?php } else { ?>
                <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
              <?php } ?></td>
              <td class="left"><?php if ($sort == 'v.from_name') { ?>
                <a href="<?php echo $sort_from; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_from; ?></a>
              <?php } else { ?>
                <a href="<?php echo $sort_from; ?>"><?php echo $column_from; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
              <?php } ?></td>
              <td class="left"><?php if ($sort == 'v.to_name') { ?>
                <a href="<?php echo $sort_to; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_to; ?></a>
              <?php } else { ?>
                <a href="<?php echo $sort_to; ?>"><?php echo $column_to; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
              <?php } ?></td>
              <td class="left"><?php if ($sort == 'v.amount') { ?>
                <a href="<?php echo $sort_amount; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_amount; ?></a>
              <?php } else { ?>
                <a href="<?php echo $sort_amount; ?>"><?php echo $column_amount; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
              <?php } ?></td>
              <td class="left"><?php if ($sort == 'theme') { ?>
                <a href="<?php echo $sort_theme; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_theme; ?></a>
              <?php } else { ?>
                <a href="<?php echo $sort_theme; ?>"><?php echo $column_theme; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
              <?php } ?></td>
              <td class="left"><?php if ($sort == 'v.date_added') { ?>
                <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
                <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
              <?php } ?></td>
              <td class="left"><?php if ($sort == 'v.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
              <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
              <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php if ($vouchers) { ?>
            <?php foreach ($vouchers as $voucher) { ?>
              <tr>
                <td style="text-align:center;"><?php if ($voucher['selected']) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $voucher['voucher_id']; ?>" id="<?php echo $voucher['voucher_id']; ?>" class="checkbox" checked />
                  <label for="<?php echo $voucher['voucher_id']; ?>"><span></span></label>
                <?php } else { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $voucher['voucher_id']; ?>" id="<?php echo $voucher['voucher_id']; ?>" class="checkbox" />
                  <label for="<?php echo $voucher['voucher_id']; ?>"><span></span></label>
                <?php } ?></td>
                <td class="left"><?php echo $voucher['code']; ?></td>
                <td class="left"><?php echo $voucher['from']; ?></td>
                <td class="left"><?php echo $voucher['to']; ?></td>
                <td class="center"><?php echo $voucher['amount']; ?></td>
                <td class="center"><?php echo $voucher['theme']; ?></td>
                <td class="center"><?php echo $voucher['date_added']; ?></td>
                <?php if ($voucher['status'] == 1) { ?>
                  <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
                <?php } else { ?>
                  <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
                <?php } ?>
                <td class="right"><a onclick="sendVoucher('<?php echo $voucher['voucher_id']; ?>');" class="button-save"><?php echo $text_send; ?></a>
                <?php foreach ($voucher['action'] as $action) { ?>
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
function sendVoucher(voucher_id) {
	$.ajax({
		url: 'index.php?route=sale/voucher/send&token=<?php echo $token; ?>&voucher_id=' + voucher_id,
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('.success, .warning').remove();
			$('.box').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('.attention').remove();
		},
		success: function(json) {
			if (json['error']) {
				$('.box').before('<div class="warning">' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('.box').before('<div class="success">' + json['success'] + '</div>');
			}
		}
	});
}
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