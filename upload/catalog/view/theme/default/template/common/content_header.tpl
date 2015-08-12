<?php foreach ($modules as $module) { ?>
<?php echo $module; ?>
<?php } ?>
<?php if ($error) { ?>
  <div class="warning"><?php echo $error; ?><img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>
<?php } ?>
<div id="notification"></div>