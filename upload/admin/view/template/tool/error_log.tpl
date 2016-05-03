<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/log.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <?php if ($error_log) { ?>
          <a href="<?php echo $clear; ?>" class="button"><?php echo $button_clear; ?></a>
          <a href="<?php echo $download; ?>" class="button-save"><?php echo $button_download; ?></a>
        <?php } ?>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <textarea wrap="off" class="log"><?php echo $error_log; ?></textarea>
    </div>
  </div>
</div>
<?php echo $footer; ?>