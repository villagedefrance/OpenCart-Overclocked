<?php if ($media_id) { ?>
<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content" style="padding-top:3px; text-align:center;">
  <?php if ($type == 'video') { ?>
    <video id="player-<?php echo $module; ?>" poster="<?php echo $poster; ?>" width="<?php echo $width; ?>" controls>
      <source src="<?php echo $media; ?>" type="<?php echo $mime_type; ?>" />
      <a href="<?php echo $media; ?>" download><?php echo $text_download; ?></a>
    </video>
    <samp><?php echo ($credit) ? '<br />' . $credit : ''; ?></samp>
  <?php } else { ?>
    <audio id="player-<?php echo $module; ?>" controls>
      <source src="<?php echo $media; ?>" type="<?php echo $mime_type; ?>" />
      <a href="<?php echo $media; ?>" download><?php echo $text_download; ?></a>
    </audio>
    <samp><?php echo ($credit) ? '<br />' . $credit : ''; ?></samp>
  <?php } ?>
  </div>
</div>
<?php } else { ?>
  <div style="margin-bottom:20px; padding-top:5px; text-align:center;">
  <?php if ($type == 'video') { ?>
    <video id="player-<?php echo $module; ?>" poster="<?php echo $poster; ?>" width="<?php echo $width; ?>" controls>
      <source src="<?php echo $media; ?>" type="<?php echo $mime_type; ?>" />
      <a href="<?php echo $media; ?>" download><?php echo $text_download; ?></a>
    </video>
    <samp><?php echo ($credit) ? '<br />' . $credit : ''; ?></samp>
  <?php } else { ?>
    <audio id="player-<?php echo $module; ?>" controls>
      <source src="<?php echo $media; ?>" type="<?php echo $mime_type; ?>" />
      <a href="<?php echo $media; ?>" download><?php echo $text_download; ?></a>
    </audio>
    <samp><?php echo ($credit) ? '<br />' . $credit : ''; ?></samp>
  <?php } ?>
  </div>
<?php } ?>

<script type="text/javascript"><!--
$(document).ready(function() {
	plyr.setup('#player-<?php echo $module; ?>', options {
		controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen'],
		iconUrl: '<?php echo $icons; ?>',
		clickToPlay: true
	});
});
//--></script>
<?php } ?>