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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/image.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_name; ?></td>
          <td><?php if ($error_name) { ?>
            <input type="text" name="name" value="<?php echo $name; ?>" size="30" class="input-error" />
            <span class="error"><?php echo $error_name; ?></span>
          <?php } else { ?>
            <input type="text" name="name" value="<?php echo $name; ?>" size="30" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_payment; ?></td>
          <td><?php if ($error_payment) { ?>
            <select name="payment" class="input-error">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($payment_methods as $payment_method) { ?>
                <?php if ($payment_method['filename'] == $payment) { ?>
                  <option value="<?php echo $payment_method['filename']; ?>" selected="selected"><?php echo $payment_method['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $payment_method['filename']; ?>"><?php echo $payment_method['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
            <span class="error"><?php echo $error_payment; ?></span>
          <?php } else { ?>
            <select name="payment">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($payment_methods as $payment_method) { ?>
                <?php if ($payment_method['filename'] == $payment) { ?>
                  <option value="<?php echo $payment_method['filename']; ?>" selected="selected"><?php echo $payment_method['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $payment_method['filename']; ?>"><?php echo $payment_method['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          <?php } ?>
          </td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_image; ?></td>
          <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
            <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
            <a onclick="image_upload('image', 'thumb');" class="button-browse"></a><a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');" class="button-recycle"></a>
          </div>
          <?php if ($error_image) { ?>
            <span class="error"><?php echo $error_image; ?></span>
          <?php } ?>
          </td>
        </tr>
        <tr class="highlighted">
          <td><?php echo $entry_status; ?></td>
          <td><select name="status">
            <?php if ($status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
        </tr>
      </table>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding:3px 0 0 0;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin:0; display:block; width:100%; height:100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function(event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: <?php echo ($this->browser->checkMobile()) ? 580 : 760; ?>,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>

<?php echo $footer; ?>