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
  <a onclick="$('input[name=\'currency_code\']').attr('value', '<?php echo $currency['code']; ?>').submit(); $(this).parent().parent().parent().parent().submit();"><?php echo $currency['title']; ?></a>
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
	$('#currency-selector').hover(function() {
		$('#currency-option').slideDown(150);
	}, function() {
		$('#currency-option').slideUp(150);
	});
});
//--></script>
<?php } ?>