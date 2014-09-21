<?php if ($store_locations) { ?>
<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
    <?php foreach ($locations as $location) { ?>
	  <div class="box-news">
        <?php if ($location['thumb']) { ?>
          <img src="<?php echo $location['thumb']; ?>" alt="<?php echo $location['name']; ?>" />
        <?php } ?>
        <h4><?php echo $location['name']; ?></h4>
        <p><?php echo $location['address']; ?></p>
        <p><?php echo $text_telephone; ?> <?php echo $location['telephone']; ?></p>
        <?php if ($location['open']) { ?>
          <p><?php echo $location['open']; ?></p>
        <?php } ?>
        <?php if ($location['comment']) { ?>
          <p><?php echo $location['comment']; ?></p>
        <?php } ?>
        <?php echo $text_latitude; ?> <?php echo $location['latitude']; ?>&deg; N<br />
        <?php echo $text_longitude; ?> <?php echo $location['longitude']; ?>&deg; E<br />
      </div>
    <?php } ?>
  </div>
</div>
<?php } else { ?>
  <div style="margin-bottom:20px;">
    <?php foreach ($locations as $location) { ?>
	  <div class="box-news">
        <?php if ($location['thumb']) { ?>
          <img src="<?php echo $location['thumb']; ?>" alt="<?php echo $location['name']; ?>" />
        <?php } ?>
        <h4><?php echo $location['name']; ?></h4>
        <p><?php echo $location['address']; ?></p>
        <p><?php echo $text_telephone; ?> <?php echo $location['telephone']; ?></p>
        <?php if ($location['open']) { ?>
          <p><?php echo $location['open']; ?></p>
        <?php } ?>
        <?php if ($location['comment']) { ?>
          <p><?php echo $location['comment']; ?></p>
        <?php } ?>
        <?php echo $text_latitude; ?> <?php echo $location['latitude']; ?>&deg; N<br />
        <?php echo $text_longitude; ?> <?php echo $location['longitude']; ?>&deg; E<br />
      </div>
    <?php } ?>
  </div>
<?php } ?>
<?php } ?>