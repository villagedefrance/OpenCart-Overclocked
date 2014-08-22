<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
    <?php echo $message; ?>
  </div>
</div>
<?php } else { ?>
<div style="margin-bottom:20px;">
  <?php echo $message; ?>
</div>
<?php } ?>