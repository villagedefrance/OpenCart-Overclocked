<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div style="padding:0; text-align:center;">
    <div id="slideshow<?php echo $module; ?>" class="flexslider loading">
      <ul class="slides">
      <?php foreach ($banners as $banner) { ?>
        <?php if ($banner['link']) { ?>
          <li><a onclick="addClick('<?php echo $banner['banner_image_id']; ?>');" href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a></li>
        <?php } else { ?>
          <li><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></li>
        <?php } ?>
      <?php } ?>
	  </ul>
    </div>
  </div>
</div>
<?php } else { ?>
  <div style="padding:0; text-align:center; margin-bottom:10px;">
    <div id="slideshow<?php echo $module; ?>" class="flexslider loading">
      <ul class="slides">
      <?php foreach ($banners as $banner) { ?>
        <?php if ($banner['link']) { ?>
          <li><a onclick="addClick('<?php echo $banner['banner_image_id']; ?>');" href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a></li>
        <?php } else { ?>
          <li><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></li>
        <?php } ?>
      <?php } ?>
	  </ul>
    </div>
  </div>
<?php } ?>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#slideshow<?php echo $module; ?>').flexslider({
		animation: '<?php echo $animation; ?>',
		direction: '<?php echo $direction; ?>',
		animationSpeed: <?php echo $speed; ?>,
		slideshowSpeed: <?php echo $duration; ?>,
		animationLoop: true,
		controlNav: <?php echo $dots; ?>,
		directionNav: <?php echo $arrows; ?>,
		pauseOnHover: true,
		pauseOnAction: false,
		smoothHeight: false,
		useCSS: true,
		touch: true,
		start: function(slider) {
			slider.removeClass('loading');
		}
	});
});
//--></script>
