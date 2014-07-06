<?php if($theme) { ?>
<div class="box">
	<div class="box-heading"><?php echo $title; ?></div>
	<div class="box-content">
		<?php if ($default) { ?>
			<div class="welcome">
				<?php echo $heading_title; ?>
			</div>
		<?php } ?>
		<?php echo $message; ?>
	</div>
</div>
<?php } else { ?>
<div style="margin-bottom:20px;">
	<?php if ($default) { ?>
		<div class="welcome">
			<?php echo $heading_title; ?>
		</div>
	<?php } ?>
	<?php echo $message; ?>
</div>
<?php } ?>