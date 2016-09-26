<h2><?php echo $text_instruction; ?></h2>
<div class="buttons" id="div-buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" />
  </div>
</div>

<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=payment/cod/confirm',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').prop('disabled', true);
			$('#div-buttons').before('<div class="attention"><img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /> <?php echo htmlspecialchars($text_wait, ENT_QUOTES, 'UTF-8'); ?></div>');
		},
		complete: function() {
			$('#button-confirm').prop('disabled', false);
			$('.attention').remove();
		},
		success: function() {
			location = '<?php echo $continue; ?>';
		}
	});
});
//--></script>