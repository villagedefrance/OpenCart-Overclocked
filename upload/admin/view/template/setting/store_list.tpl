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
      <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location='<?php echo $themes; ?>';" class="button-cancel ripple"><i class="fa fa-magic"></i> &nbsp; <?php echo $button_themes; ?></a>
        <a href="<?php echo $insert; ?>" class="button ripple"><?php echo $button_insert; ?></a>
        <a id="delete" class="button-delete ripple"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content-body">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="left"><?php echo $column_name; ?></td>
            <td class="left"><?php echo $column_template; ?></td>
            <td class="left"><?php echo $column_url; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($stores) { ?>
          <?php foreach ($stores as $store) { ?>
          <tr>
            <td style="text-align:center;"><?php if ($store['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $store['store_id']; ?>" id="<?php echo $store['store_id']; ?>" class="checkbox" checked />
              <label for="<?php echo $store['store_id']; ?>"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $store['store_id']; ?>" id="<?php echo $store['store_id']; ?>" class="checkbox" />
              <label for="<?php echo $store['store_id']; ?>"><span></span></label>
            <?php } ?></td>
            <td class="left"><?php echo $store['name']; ?></td>
            <td class="left"><?php echo ucfirst($store['template']); ?></td>
            <td class="left"><?php echo $store['url']; ?></td>
            <td class="right"><?php foreach ($store['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
            <?php } ?></td>
          </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </form>
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