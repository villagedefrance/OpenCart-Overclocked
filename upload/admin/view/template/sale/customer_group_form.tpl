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
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
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
            <td><?php foreach ($languages as $language) { ?>
              <?php if (isset($error_name[$language['language_id']])) { ?>
                <input type="text" name="customer_group_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($customer_group_description[$language['language_id']]) ? $customer_group_description[$language['language_id']]['name'] : ''; ?>" class="input-error" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
                <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
              <?php } else { ?>
                <input type="text" name="customer_group_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($customer_group_description[$language['language_id']]) ? $customer_group_description[$language['language_id']]['name'] : ''; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
              <?php } ?>
            <?php } ?></td>
          </tr>
          <?php foreach ($languages as $language) { ?>
          <tr>
            <td><?php echo $entry_description; ?></td>
            <td><textarea name="customer_group_description[<?php echo $language['language_id']; ?>][description]" cols="40" rows="5"><?php echo isset($customer_group_description[$language['language_id']]) ? $customer_group_description[$language['language_id']]['description'] : ''; ?></textarea>
            <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" align="top" /></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $entry_image; ?></td>
            <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
              <a onclick="image_upload('image', 'thumb');" class="button-browse"></a><a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');" class="button-recycle"></a>
            </div></td>
          </tr>
          <tr>
            <td><?php echo $entry_approval; ?></td>
            <td><?php if ($approval) { ?>
              <input type="radio" name="approval" value="1" id="approval-on" class="radio" checked />
              <label for="approval-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="approval" value="0" id="approval-off" class="radio" />
              <label for="approval-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="approval" value="1" id="approval-on" class="radio" />
              <label for="approval-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="approval" value="0" id="approval-off" class="radio" checked />
              <label for="approval-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_company_id_display; ?></td>
            <td><?php if ($company_id_display) { ?>
              <input type="radio" name="company_id_display" value="1" id="company-id-display-on" class="radio" checked />
              <label for="company-id-display-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="company_id_display" value="0" id="company-id-display-off" class="radio" />
              <label for="company-id-display-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="company_id_display" value="1" id="company-id-display-on" class="radio" />
              <label for="company-id-display-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="company_id_display" value="0" id="company-id-display-off" class="radio" checked />
              <label for="company-id-display-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_company_id_required; ?></td>
            <td><?php if ($company_id_required) { ?>
              <input type="radio" name="company_id_required" value="1" id="company-id-required-on" class="radio" checked />
              <label for="company-id-required-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="company_id_required" value="0" id="company-id-required-off" class="radio" />
              <label for="company-id-required-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="company_id_required" value="1" id="company-id-required-on" class="radio" />
              <label for="company-id-required-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="company_id_required" value="0" id="company-id-required-off" class="radio" checked />
              <label for="company-id-required-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax_id_display; ?></td>
            <td><?php if ($tax_id_display) { ?>
              <input type="radio" name="tax_id_display" value="1" id="tax-id-display-on" class="radio" checked />
              <label for="tax-id-display-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="tax_id_display" value="0" id="tax-id-display-off" class="radio" />
              <label for="tax-id-display-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="tax_id_display" value="1" id="tax-id-display-on" class="radio" />
              <label for="tax-id-display-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="tax_id_display" value="0" id="tax-id-display-off" class="radio" checked />
              <label for="tax-id-display-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax_id_required; ?></td>
            <td><?php if ($tax_id_required) { ?>
              <input type="radio" name="tax_id_required" value="1" id="tax-id-required-on" class="radio" checked />
              <label for="tax-id-required-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="tax_id_required" value="0" id="tax-id-required-off" class="radio" />
              <label for="tax-id-required-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="tax_id_required" value="1" id="tax-id-required-on" class="radio" />
              <label for="tax-id-required-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="tax_id_required" value="0" id="tax-id-required-off" class="radio" checked />
              <label for="tax-id-required-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
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