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
        <?php echo $location['details']; ?>
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
        <?php echo $location['details']; ?>
      </div>
    <?php } ?>
  </div>
<?php } ?>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		width: 640,
		height: 480
	});
});
//--></script>
<?php } ?>