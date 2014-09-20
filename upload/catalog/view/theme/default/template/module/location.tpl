<?php if ($store_locations) { ?>
<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
    <div class="box-news">
    <?php foreach ($locations as $location) { ?>
      <?php if ($location['thumb']) { ?>
        <img src="<?php echo $location['thumb']; ?>" alt="<?php echo $location['name']; ?>" />
      <?php } ?>
      <h4><?php echo $location['name']; ?></h4>
      <p><?php echo $location['address']; ?></p>
      <?php echo $text_telephone; ?> <?php echo $location['telephone']; ?><br />
      <?php echo $text_latitude; ?> <?php echo $location['latitude']; ?><br />
      <?php echo $text_longitude; ?> <?php echo $location['longitude']; ?><br />
    <?php } ?>
    </div>
  </div>
</div>
<?php } else { ?>
  <div style="margin-bottom:20px;">
    <div class="box-news">
    <?php foreach ($locations as $location) { ?>
      <?php if ($location['thumb']) { ?>
        <img src="<?php echo $location['thumb']; ?>" alt="<?php echo $location['name']; ?>" />
      <?php } ?>
      <h4><?php echo $location['name']; ?></h4>
      <p><?php echo $location['address']; ?></p>
      <?php echo $text_telephone; ?> <?php echo $location['telephone']; ?><br />
      <?php echo $text_latitude; ?> <?php echo $location['latitude']; ?><br />
      <?php echo $text_longitude; ?> <?php echo $location['longitude']; ?><br />
    <?php } ?>
    </div>
  </div>
<?php } ?>
<?php } ?>