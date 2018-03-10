<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
    <div class="box-manufacturer">
    <?php foreach ($manufacturers as $manufacturer) { ?>
      <?php if ($manufacturer['image']) { ?>
        <div class="image"><a href="<?php echo $manufacturer['href']; ?>" title="<?php echo $manufacturer['name']; ?>"><img src="<?php echo $manufacturer['image']; ?>" alt="<?php echo $manufacturer['name']; ?>" /></a></div>
      <?php } else { ?>
        <div><a href="<?php echo $manufacturer['href']; ?>" title="<?php echo $manufacturer['name']; ?>"><?php echo $manufacturer['name']; ?></a></div>
      <?php } ?>
    <?php } ?>
    </div>
  </div>
</div>
<?php } else { ?>
  <div style="margin-bottom:20px;">
    <div class="box-manufacturer">
    <?php foreach ($manufacturers as $manufacturer) { ?>
      <?php if ($manufacturer['image']) { ?>
        <div class="image"><a href="<?php echo $manufacturer['href']; ?>" title="<?php echo $manufacturer['name']; ?>"><img src="<?php echo $manufacturer['image']; ?>" alt="<?php echo $manufacturer['name']; ?>" /></a></div>
      <?php } else { ?>
        <div><a href="<?php echo $manufacturer['href']; ?>" title="<?php echo $manufacturer['name']; ?>"><?php echo $manufacturer['name']; ?></a></div>
      <?php } ?>
    <?php } ?>
    </div>
  </div>
<?php } ?>