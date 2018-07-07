<div id="price-notifications"></div>
<table id="price-table" class="form-modal">
  <tr>
    <td><?php echo $entry_px_selected; ?></td>
    <td><select name="px_selected">
      <option value="1" selected="selected"><?php echo $text_selected_yes; ?></option>
      <option value="0"><?php echo $text_selected_no; ?></option>
    </select></td>
  </tr>
  <tr>
    <td><span class="required">*</span> <?php echo $entry_px_price; ?></td>
    <td><input type="text" name="px_price" value="" size="15" /></td>
  </tr>
</table>
<div style="margin:20px; text-align:right;">
  <img src="view/image/loading.gif" alt="" id="img-price-update" style="display:none;" /> 
  <a id="button-price-update" class="button ripple" style="font-size:12px; color:#FFF;"><?php echo $button_submit; ?></a>
</div>

<script type="text/javascript"><!--
$('body').on('click', '#button-price-update', function() {
	$('#price-notifications').html('');
	$('#img-price-update').show();
	$('div.success').remove();

	$.ajax({
		url:'index.php?route=sale/supplier_product/updatePrice&token=<?php echo $token; ?>',
		type:'post',
		dataType: 'json',
		data: $.param($('#update-price-dialog').find('input[type="text"], input[type="hidden"], select')) + '&' + $('#form').serialize(),
		success: function(json) {
			$('#img-price-update').hide();

			if (json['success']) {
				$('#update-price-dialog').dialog('close');

				$('.box').before('<div class="success">' + json['success'] + '</div>');
			} else if (json['error']) {
				var error = '';

				if (json['error'] instanceof Array) {
					for (var i=0; i<json['error'].length; i++) {
						error += '<div>' + json['error'][i] + '</div>';
					}
				} else {
					error = json['error'];
				}
				$('#price-notifications').html('<div class="warning">' + error + '</div>');
			} else {
				alert('Unsupported response!');
			}
		},
		failure: function() {
			$('#img-price-update').hide();
			alert('Ajax failure!');
		}
	});
});
//--></script>