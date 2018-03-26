<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content" style="text-align:center;">
    <?php if ($tagcloud) { ?>
      <?php echo $tagcloud; ?>
    <?php } else { ?>
      <?php echo $text_no_tags; ?>
    <?php } ?>
  </div>
</div>
<?php } else { ?>
  <div style="margin-bottom:20px; text-align:center;">
    <?php if ($tagcloud) { ?>
      <?php echo $tagcloud; ?>
    <?php } else { ?>
      <?php echo $text_no_tags; ?>
    <?php } ?>
  </div>
<?php } ?>