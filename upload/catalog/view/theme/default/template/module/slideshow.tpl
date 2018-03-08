<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div style="<?php echo $track_style; ?>">
    <div class="slick_skin" id="slideshow<?php echo $module; ?>">
    <?php foreach ($banners as $banner) { ?>
      <?php if ($banner['link']) { ?>
        <div class="carousel-swipe tracked"><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></a></div>
      <?php } else { ?>
        <div class="carousel-swipe tracked"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></div>
      <?php } ?>
    <?php } ?>
    </div>
  </div>
</div>
<?php } else { ?>
<div style="<?php echo $track_style; ?>">
  <div class="slick_skin" id="slideshow<?php echo $module; ?>">
    <?php foreach ($banners as $banner) { ?>
      <?php if ($banner['link']) { ?>
        <div class="carousel-swipe tracked"><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></a></div>
      <?php } else { ?>
        <div class="carousel-swipe tracked"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></div>
      <?php } ?>
    <?php } ?>
  </div>
</div>
<?php } ?>

<script type="text/javascript"><!--
jQuery(document).ready(function() {
	$('#slideshow<?php echo $module; ?>').slick({
		arrows: <?php echo $arrows; ?>,
		autoplay: <?php echo $auto; ?>,
		autoplaySpeed: <?php echo $duration; ?>,
		pauseOnHover: true,
		slidesToScroll: 1,
		infinite: true,
		speed: <?php echo $speed; ?>,
		easing: 'easeInOutExpo',
		vertical: <?php echo $vertical; ?>,
		fade: <?php echo $fade; ?>,
		dots: <?php echo $dots; ?>,
		mobileFirst: true,
		swipe: true
	});
	$('.carousel-swipe').on('swipe', function(event, slick, direction) {
		console.log(direction);
	});
})(jQuery);
--></script>
