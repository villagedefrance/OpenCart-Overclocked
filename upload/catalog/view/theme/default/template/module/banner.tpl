<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content" style="padding:0 0 10px 0; overflow:hidden;">
    <div id="banner<?php echo $module; ?>" class="banner" style="padding:0;">
      <?php foreach ($banners as $banner) { ?>
        <?php if ($banner['link']) { ?>
          <div><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></a></div>
        <?php } else { ?>
          <div><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></div>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>
<?php } else { ?>
<div style="margin-bottom:20px; padding:10px 0; overflow:hidden;">
  <div id="banner<?php echo $module; ?>" class="banner" style="padding:0;">
    <?php foreach ($banners as $banner) { ?>
      <?php if ($banner['link']) { ?>
        <div><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></a></div>
      <?php } else { ?>
        <div><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" id="<?php echo $banner['banner_image_id']; ?>" /></div>
      <?php } ?>
    <?php } ?>
  </div>
</div>
<?php } ?>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#banner<?php echo $module; ?> div:first-child').css('display', 'block');
});
var banner = function() {
	$('#banner<?php echo $module; ?>').cycle({
		timeout: <?php echo $timeout; ?>,
		speed: <?php echo $speed; ?>,
		pause: <?php echo $pause; ?>,
		before: function(current, next) {
			$(next).parent().height($(next).outerHeight());
		}
	});
}
setTimeout(banner, 2000);
//--></script>
