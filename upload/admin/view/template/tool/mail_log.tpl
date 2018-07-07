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
        <?php if ($mail_log) { ?>
          <a href="<?php echo $clear; ?>" class="button ripple"><i class="fa fa-refresh"></i> &nbsp; <?php echo $button_clear; ?></a>
          <a href="<?php echo $download; ?>" class="button-save ripple"><i class="fa fa-download"></i> &nbsp; <?php echo $button_download; ?></a>
        <?php } ?>
        <a href="<?php echo $cancel; ?>" class="button-cancel animated fadeIn ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content-body">
      <textarea wrap="off" class="log"><?php echo $mail_log; ?></textarea>
    </div>
  </div>
</div>
<?php echo $footer; ?>