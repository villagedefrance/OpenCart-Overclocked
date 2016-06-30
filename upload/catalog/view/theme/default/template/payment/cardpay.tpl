<form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" id="cardpay_form">
  <input type="hidden" name="orderXML" value="<?php echo $orderXML; ?>" />  
  <input type="hidden" name="sha512" value="<?php echo $sha512; ?>" />
  <!--img alt="CardPay processing" src="<!--?php echo $logo; ?>"/-->
</form>
<div class="buttons">
  <div class="right"><a onclick="$('#cardpay_form').submit();" class="button"><?php echo $button_confirm; ?></a></div>
</div>