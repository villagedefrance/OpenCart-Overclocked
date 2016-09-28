<?php if (count($currencies) > 1) { ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
  <div id="currency">
  <div id="currency-selector">
  <?php foreach ($currencies as $currency) { ?>
  <?php if ($currency['code'] == $currency_code) { ?>
  <span class="currency-selected"><?php echo $currency['title']; ?></span>
  <?php } ?>
  <?php } ?>
  <div id="currency-option" style="display:none;">
  <?php foreach ($currencies as $currency) { ?>
    <a class="currency-selection" onclick="$('input[name=\'currency_code\']').attr('value', '<?php echo $currency['code']; ?>').submit(); $(this).parent().parent().parent().parent().submit();"><?php echo $currency['title']; ?></a>
  <?php } ?>
  </div>
  </div>
  <input type="hidden" name="currency_code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
  </div>
</form>

<script type="text/javascript"><!--
$(document).ready(function() {
	currency_width = $('#currency-option').width();
	$('#currency-selector').css('width', (currency_width + 10) + 'px');
	var timer, options = $("#currency-option");
	function showOptions() { options.slideDown(200); }
	function hideOptions() { options.slideUp(200); }
	$('#currency-selector').on('mouseenter touchstart touchend', function() {
		timer = setTimeout(function() { hideOptions(); }, 3000);
		$('.currency-selection').click(function(event) {
			event.preventDefault();
			hideOptions();
			window.clearTimeout(timer);
		});
		showOptions();
	});
	$('#currency-option').on('mouseleave', function() {
		hideOptions();
		window.clearTimeout(timer);
	});
});
//--></script>
<?php } ?>