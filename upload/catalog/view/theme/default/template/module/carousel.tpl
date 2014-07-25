<?php if($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content" style="list-style:none;">
    <div id="carousel<?php echo $module; ?>">
      <ul class="jcarousel-skin-opencart">
      <?php foreach ($banners as $banner) { ?>
        <li><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></li>
      <?php } ?>
      </ul>
    </div>
  </div>
</div>
<?php } else { ?>
  <div style="margin-bottom:20px; list-style:none;">
    <div id="carousel<?php echo $module; ?>">
      <ul class="jcarousel-skin-opencart">
      <?php foreach ($banners as $banner) { ?>
        <li><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></li>
      <?php } ?>
      </ul>
    </div>
  </div>
<?php } ?>

<script type="text/javascript"><!--
jQuery(document).ready(function() {
	jQuery('#carousel<?php echo $module; ?> ul').jcarousel({
		vertical: false,
		visible: <?php echo $limit; ?>,
		scroll: <?php echo $scroll; ?>,
		auto: <?php echo $auto; ?>,
		wrap: '<?php echo $wrap; ?>'
	});
});
//--></script>