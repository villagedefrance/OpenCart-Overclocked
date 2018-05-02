<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div style="<?php echo $track_style; ?>">
    <div class="slick_skin" id="carousel<?php echo $module; ?>">
      <?php foreach ($banners as $banner) { ?>
        <?php if ($banner['link']) { ?>
          <div class="carousel-swipe"><a onclick="addClick('<?php echo $banner['banner_image_id']; ?>');" href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a></div>
        <?php } else { ?>
          <div class="carousel-swipe"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></div>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>
<?php } else { ?>
  <div style="<?php echo $track_style; ?>">
    <div class="slick_skin" id="carousel<?php echo $module; ?>">
      <?php foreach ($banners as $banner) { ?>
        <?php if ($banner['link']) { ?>
          <div class="carousel-swipe"><a onclick="addClick('<?php echo $banner['banner_image_id']; ?>');" href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a></div>
        <?php } else { ?>
          <div class="carousel-swipe"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></div>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
<?php } ?>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#carousel<?php echo $module; ?>').slick({
		arrows: true,
		autoplay: <?php echo $auto; ?>,
		autoplaySpeed: <?php echo $duration; ?>,
		pauseOnHover: true,
		slidesToScroll: 1,
		infinite: true,
		speed: <?php echo $speed; ?>,
		easing: 'easeInOutExpo',
		mobileFirst: true,
		swipe: true,
		rtl: false,
		dots: false,
		responsive: [
		{ breakpoint: 1440, settings: { slidesToShow: <?php echo $show_1440; ?> } },
		{ breakpoint: 1280, settings: { slidesToShow: <?php echo $show_1280; ?> } },
		{ breakpoint: 960, settings: { slidesToShow: <?php echo $show_960; ?> } },
		{ breakpoint: 640, settings: { slidesToShow: <?php echo $show_640; ?> } },
		{ breakpoint: 480, settings: { slidesToShow: <?php echo $show_480; ?> } },
		{ breakpoint: 320, settings: { slidesToShow: <?php echo $show_320; ?> } } ]
	});
	$('.carousel-swipe').on('swipe', function(event, slick, direction) {
		console.log(direction);
	});
});
--></script>
