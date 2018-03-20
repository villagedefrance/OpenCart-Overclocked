<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
    <div class="box-manufacturer">
    <?php if ($colorcloud) { ?>
      <?php echo $colorcloud; ?>
    <?php } else { ?>
      <?php echo $text_no_colors; ?>
    <?php } ?>
    </div>
  </div>
</div>
<?php } else { ?>
  <div style="margin-bottom:20px;">
    <div class="box-manufacturer">
    <?php if ($colorcloud) { ?>
      <?php echo $colorcloud; ?>
    <?php } else { ?>
      <?php echo $text_no_colors; ?>
    <?php } ?>
    </div>
  </div>
<?php } ?>