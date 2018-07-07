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
      <h1><img src="view/image/country.png" alt="" /> <?php echo $heading_title; ?></h1>
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
          <td><span class="required">*</span> <?php echo $entry_address; ?></td>
          <td><?php if ($error_address) { ?>
            <textarea name="address" cols="40" rows="5" class="input-error"><?php echo $address; ?></textarea>
            <span class="error"><?php echo $error_address; ?></span>
          <?php } else { ?>
            <textarea name="address" cols="40" rows="5"><?php echo $address; ?></textarea>
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
          <td><?php if ($error_telephone) { ?>
            <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="input-error" />
            <span class="error"><?php echo $error_telephone; ?></span>
          <?php } else { ?>
            <input type="text" name="telephone" value="<?php echo $telephone; ?>" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_image; ?></td>
          <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
            <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
            <a onclick="image_upload('image', 'thumb');" class="button-browse"></a><a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');" class="button-recycle"></a>
            </div>
            <?php if ($error_image) { ?>
              <span class="error"><?php echo $error_image; ?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
          <td><?php echo $entry_latitude; ?></td>
          <td><input id="location_latitude" name="latitude" value="<?php echo isset($latitude) ? $latitude : ''; ?>" size="30" /> &deg; N</td>
        </tr>
        <tr>
          <td><?php echo $entry_longitude; ?></td>
          <td><input id="location_longitude" name="longitude" value="<?php echo isset($longitude) ? $longitude : ''; ?>" size="30" /> &deg; E</td>
        </tr>
        <tr>
          <td><?php echo $entry_open; ?></td>
          <td><textarea name="open" cols="40" rows="5"><?php echo $open; ?></textarea></td>
        </tr>
        <tr>
          <td><?php echo $entry_comment; ?></td>
          <td><textarea name="comment" cols="40" rows="5"><?php echo $comment; ?></textarea></td>
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
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
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