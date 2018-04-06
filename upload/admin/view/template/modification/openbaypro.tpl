<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/modification.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $close; ?>" class="button-cancel"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content">
      <div class="tooltip" style="margin:10px 0;"><?php echo $text_installed; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>