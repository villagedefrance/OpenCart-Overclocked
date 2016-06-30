<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
  <?php } else { ?>
    <?php if ($available) { ?>
      <div class="success"><?php echo $available; ?></div>
    <?php } ?>
    <div class="box">
      <div class="heading">
        <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
        <div class="buttons"><a href="<?php echo $url_return; ?>" class="button"><?php echo $button_cancel; ?></a><a onclick="$('#category-form').submit();" class="button"><?php echo $button_continue; ?></a></div>
      </div>
      <div class="content">
        <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="category-form">
          <table class="list">
            <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php echo $text_category; ?></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category) { ?>
            <tr>
              <td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $category['category_id']; ?>" <?php echo in_array($category['category_id'], $selected_categories) ? 'checked="checked" ' : ''; ?>/></td>
              <td class="left"><?php echo $category['name']; ?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  <?php } ?>
</div>
<?php echo $footer; ?>