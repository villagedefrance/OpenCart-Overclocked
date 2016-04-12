<?php if (count($languages) > 1) { ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
  <div id="language">
  <div id="language-selector">
  <?php foreach ($languages as $language) { ?>
  <?php if ($language['code'] == $language_code) { ?>
  <span class="language-selected"><?php echo $language['name']; ?></span>
  <?php } ?>
  <?php } ?>
  <div id="language-option" style="display:none;">
  <?php foreach ($languages as $language) { ?>
    <a id="language-selection" onclick="$('input[name=\'language_code\']').attr('value', '<?php echo $language['code']; ?>').submit(); $(this).parent().parent().parent().parent().submit();"><?php echo $language['name']; ?></a>
  <?php } ?>
  </div>
  </div>
  <input type="hidden" name="language_code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
  </div>
</form>

<script type="text/javascript"><!--
$(document).ready(function() {
	language_width = $('#language-option').width();
	$('#language-selector').css('width', (language_width + 10) + 'px');
	$('#language-selector').on('mouseenter touchstart touchend', function() {
		$('#language-selection').click(function(event) {
			event.preventDefault();
		});
		$('#language-option').slideDown(150);
	});
	$('#language-option').on('mouseleave touchmove', function() {
		$('#language-option').slideUp(150);
	});
});
//--></script>

<?php } ?>