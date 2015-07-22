<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
    <div class="slick_<?php echo $slick_theme; ?>_skin" id="carousel<?php echo $module; ?>">
      <?php foreach ($banners as $banner) { ?>
        <?php if ($banner['link']) { ?>
          <div><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a></div>
        <?php } else { ?>
          <div><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></div>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>
<?php } else { ?>
  <div style="margin-bottom:15px;">
    <div class="slick_<?php echo $slick_theme; ?>_skin" id="carousel<?php echo $module; ?>">
      <?php foreach ($banners as $banner) { ?>
        <?php if ($banner['link']) { ?>
          <div><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a></div>
        <?php } else { ?>
          <div><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></div>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
<?php } ?>

<script type="text/javascript"><!--
jQuery(document).ready(function($) {
	$('#carousel<?php echo $module; ?>').slick({
		arrows: true,
		prevArrow: '<a class="slick-prev"><span></span></a>',
		nextArrow: '<a class="slick-next"><span></span></a>',
		autoplay: <?php echo $auto; ?>,
		autoplaySpeed: 5000,
		pauseOnHover: true,
		slidesToShow: <?php echo $show; ?>,
		slidesToScroll: 1,
		easing: 'easeInOutExpo',
		infinite: true,
		speed: 800,
		rtl: false
	});
})(jQuery);
--></script>