<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content" style="text-align:center;"> 
    <?php echo $code; ?>
  </div>
</div>
<?php } else { ?>
  <div style="text-align:center; margin-bottom:20px;">
    <?php echo $code; ?>
  </div>
<?php } ?>