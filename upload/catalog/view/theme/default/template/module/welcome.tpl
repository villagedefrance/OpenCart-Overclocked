<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading <?php echo $header_shape; ?>-top <?php echo $header_color; ?>-skin"><?php echo $title; ?></div>
  <div class="box-content <?php echo $content_shape; ?>-bottom <?php echo $content_color; ?>-skin">
    <?php echo $message; ?>
  </div>
</div>
<?php } else { ?>
<div class="<?php echo $content_shape; ?> <?php echo $content_color; ?>-skin" style="margin-bottom:20px;">
  <?php echo $message; ?>
</div>
<?php } ?>