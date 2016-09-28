<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading <?php echo $header_shape; ?> <?php echo $header_color; ?>"><?php echo $title; ?></div>
  <div style="margin:0px; padding:0px; overflow:hidden;">
    <div class="camera_<?php echo $camera_theme; ?> camera_wrap" id="camera_wrap<?php echo $module; ?>">
    <?php foreach ($banners as $banner) { ?>
      <?php if ($banner['link']) { ?>
        <div data-src="<?php echo $banner['image']; ?>" data-thumb="<?php echo $banner['image']; ?>" data-link="<?php echo $banner['link']; ?>"></div>
      <?php } else { ?>
        <div data-src="<?php echo $banner['image']; ?>" data-thumb="<?php echo $banner['image']; ?>"></div>
      <?php } ?>
    <?php } ?>
    </div>
  </div>
</div>
<?php } else { ?>
<div style="margin-bottom:20px; padding:0px; overflow:hidden;">
  <div class="camera_<?php echo $camera_theme; ?> camera_wrap" id="camera_wrap<?php echo $module; ?>">
    <?php foreach ($banners as $banner) { ?>
      <?php if ($banner['link']) { ?>
        <div data-src="<?php echo $banner['image']; ?>" data-thumb="<?php echo $banner['image']; ?>" data-link="<?php echo $banner['link']; ?>"></div>
      <?php } else { ?>
        <div data-src="<?php echo $banner['image']; ?>" data-thumb="<?php echo $banner['image']; ?>"></div>
      <?php } ?>
    <?php } ?>
  </div>
</div>
<?php } ?>

<script type="text/javascript"><!--
jQuery(document).ready(function() {
	$('#camera_wrap<?php echo $module; ?>').camera({
		height: '<?php echo $ratio; ?>%',
		fx: 'random',
		playPause: <?php echo $camera_playpause; ?>,
		pagination: <?php echo $camera_pagination; ?>,
		thumbnails: <?php echo $camera_thumbnails; ?>,
		overlayer: true,
		loader: true,
		hover: true,
		time: 6000,
		transPeriod: 1000
	});
})(jQuery);
--></script>
