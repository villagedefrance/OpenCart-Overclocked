<div id="quantity-notifications"></div>
<table id="quantity-table" class="form-modal">
  <tr>
    <td><?php echo $entry_qt_selected; ?></td>
    <td><select name="qt_selected">
      <option value="1" selected="selected"><?php echo $text_selected_yes; ?></option>
      <option value="0"><?php echo $text_selected_no; ?></option>
    </select></td>
  </tr>
  <tr>
    <td><span class="required">*</span> <?php echo $entry_qt_quantity; ?></td>
    <td><input type="text" name="qt_quantity" value="" size="12" /></td>
  </tr>
  <tr>
    <td><?php echo $entry_qt_minimum; ?></td>
    <td><input type="text" name="qt_minimum" value="" size="6" /></td>
  </tr>
</table>
<div style="margin:20px; text-align:right;">
  <img src="view/image/loading.gif" alt="" id="img-quantity-update" style="display:none;" /> 
  <a id="button-quantity-update" class="button ripple" style="font-size:12px; color:#FFF;"><?php echo $button_submit; ?></a>
</div>

<script type="text/javascript"><!--
$('body').on('click', '#button-quantity-update', function() {
	$('#quantity-notifications').html('');
	$('#img-quantity-update').show();
	$('div.success').remove();

	$.ajax({
		url:'index.php?route=catalog/product/updateQuantity&token=<?php echo $token; ?>',
		type:'post',
		dataType: 'json',
		data: $.param($('#update-quantity-dialog').find('input[type="text"], input[type="hidden"], select')) + '&' + $('#form').serialize(),
		success: function(json) {
			$('#img-quantity-update').hide();

			if (json['success']) {
				$('#update-quantity-dialog').dialog('close');

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
				$('#quantity-notifications').html('<div class="warning">' + error + '</div>');
			} else {
				alert('Unsupported response!');
			}
		},
		failure: function() {
			$('#img-quantity-update').hide();
			alert('Ajax failure!');
		}
	});
});
//--></script>