<?php if($theme) { ?>
<div class="box">
	<div class="box-heading"><?php echo $title; ?></div>
	<div class="box-content">
		<div class="slideshow">
			<div id="slideshow<?php echo $module; ?>" class="nivoSlider" style="margin-left:auto; margin-right:auto; width:<?php echo $width; ?>px; height:<?php echo $height; ?>px;">
				<?php foreach ($banners as $banner) { ?>
				<?php if ($banner['link']) { ?>
					<a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a>
				<?php } else { ?>
					<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
				<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php } else { ?>
	<div style="margin-bottom:20px;">
		<div class="slideshow">
			<div id="slideshow<?php echo $module; ?>" class="nivoSlider" style="margin-left:auto; margin-right:auto; width:<?php echo $width; ?>px; height:<?php echo $height; ?>px;">
				<?php foreach ($banners as $banner) { ?>
				<?php if ($banner['link']) { ?>
					<a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a>
				<?php } else { ?>
					<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
				<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#slideshow<?php echo $module; ?>').nivoSlider({
		effect: '<?php echo $effect; ?>',
		animSpeed: 500,
		pauseTime: <?php echo $delay; ?>,
		pauseOnHover: <?php echo $pause; ?>,
		directionNav: <?php echo $arrows; ?>,
		directionNavHide: <?php echo $autohide; ?>,
		controlNav: <?php echo $controls; ?>
	});
});
//--></script>