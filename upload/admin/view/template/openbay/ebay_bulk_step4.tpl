<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $url_return; ?>" class="button"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <?php if (!empty($error_warning)) { ?>
        <div class="warning"><?php echo $error_upload_fail; ?></div>
      <?php } else { ?>
        <div class="success"><?php echo $success; ?></div>
      <?php } ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>