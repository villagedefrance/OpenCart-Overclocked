<?php if($theme) { ?>
<div class="box">
	<div class="box-heading"><?php echo $title; ?></div>
	<div class="box-content" style="text-align:center;"> 
		<?php if($tagcloud) { ?>
			<?php echo $tagcloud; ?>
		<?php } else { ?>
			<?php echo $text_notags; ?>
		<?php } ?>
	</div>
</div>
<?php } else { ?>
	<div style="text-align:center; margin-bottom:20px;">
		<?php if($tagcloud) { ?>
			<?php echo $tagcloud; ?>
		<?php } else { ?>
			<?php echo $text_notags; ?>
		<?php } ?>
	</div>
<?php } ?>