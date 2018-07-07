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
        <a onclick="location = '<?php echo $insert; ?>'" class="button-save ripple"><?php echo $button_insert; ?></a>
        <a id="delete" class="button-delete ripple"><?php echo $button_delete; ?></a>
        <a onclick="location = '<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form" name="eutaxlist">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="left"><?php echo $column_flag; ?></td>
            <td class="left"><?php if ($sort == 'ecd.eucountry') { ?>
              <a href="<?php echo $sort_eucountry; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eucountry; ?> (<?php echo $totaleucountries; ?>)</a>
            <?php } else { ?>
              <a href="<?php echo $sort_eucountry; ?>"><?php echo $column_eucountry; ?> (<?php echo $totaleucountries; ?>)&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'ec.code') { ?>
              <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'ec.rate') { ?>
              <a href="<?php echo $sort_rate; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rate; ?>
            <?php } else { ?>
              <a href="<?php echo $sort_rate; ?>"><?php echo $column_rate; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'ec.status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?>
            <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($eucountries) { ?>
          <?php foreach ($eucountries as $eucountry_story) { ?>
            <tr>
              <td style="text-align:center;"><?php if ($eucountry_story['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $eucountry_story['eucountry_id']; ?>" id="<?php echo $eucountry_story['eucountry_id']; ?>" class="checkbox" checked />
                <label for="<?php echo $eucountry_story['eucountry_id']; ?>"><span></span></label>
              <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $eucountry_story['eucountry_id']; ?>" id="<?php echo $eucountry_story['eucountry_id']; ?>" class="checkbox" />
                <label for="<?php echo $eucountry_story['eucountry_id']; ?>"><span></span></label>
              <?php } ?></td>
              <td class="center"><img src="view/image/flags/<?php echo $eucountry_story['flag']; ?>.png" alt="<?php echo $eucountry_story['eucountry']; ?>" style="padding-top:4px;" /></td>
              <td class="left"><?php echo $eucountry_story['eucountry']; ?></td>
              <td class="left"><?php echo $eucountry_story['code']; ?></td>
              <td class="left"><?php echo $eucountry_story['rate']; ?></td>
              <td class="left"><?php echo $eucountry_story['status']; ?></td>
              <td class="right">
                <?php foreach ($eucountry_story['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr class="even">
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