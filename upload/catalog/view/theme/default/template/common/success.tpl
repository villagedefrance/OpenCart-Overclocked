<?php echo $header; ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php echo $text_message; ?>
  <div class="image-links">
    <a href="<?php echo $this->url->link('common/home'); ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/64x64/home.png" alt="" /></a>
	<a href="<?php echo $this->url->link('account/account', '', 'SSL'); ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/64x64/document.png" alt="" /></a>
	<a href="<?php echo $this->url->link('account/download', '', 'SSL'); ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/64x64/download.png" alt="" /></a>
	<a href="<?php echo $this->url->link('checkout/cart'); ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/64x64/cart.png" alt="" /></a>
  </div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>