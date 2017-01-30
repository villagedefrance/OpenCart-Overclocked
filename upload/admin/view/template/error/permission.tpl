<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <div class="box">
  <div class="heading">
    <h1><img src="view/image/error.png" alt="" /> <?php echo $heading_title; ?></h1>
  </div>
  <div class="content-body">
    <div class="toolbox"><?php echo $text_permission; ?></div>
  </div>
  </div>
</div>
<?php echo $footer; ?>