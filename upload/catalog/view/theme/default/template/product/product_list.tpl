<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if (!$hidecrumbs) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <h2><?php echo $ptotal; ?> <?php echo $text_total_products; ?> <?php echo $text_in; ?> <?php echo $ctotal; ?> <?php echo $text_total_categories; ?></h2>	
  <div class="product-page">
    <div class="left">
      <div class="head"><?php echo $text_title_product; ?> 1 <?php echo $text_to; ?> <?php echo $tritotal1; ?></div>
      <ul>
        <?php foreach ($products as $product) { ?>
          <?php if ($product['count'] <= $tritotal1) { ?>
            <li><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></li>
          <?php } ?>
        <?php } ?>
      </ul>
    </div>
    <div class="middle">
      <div class="head"><?php echo $text_title_product; ?> <?php echo $tritotal1; ?> <?php echo $text_to; ?> <?php echo $tritotal2; ?></div>
      <ul>
        <?php foreach ($products as $product) { ?>
          <?php if ($product['count'] > $tritotal1) { ?>
            <?php if ($product['count'] <= $tritotal2) { ?>
              <li><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></li>
            <?php } ?>
          <?php } ?>
        <?php } ?>
      </ul>
    </div>
    <div class="right">
      <div class="head"><?php echo $text_title_product; ?> <?php echo $tritotal2; ?> <?php echo $text_to; ?> <?php echo $ptotal; ?></div>		
      <ul>
        <?php foreach ($products as $product) { ?>
          <?php if ($product['count'] > $tritotal2) { ?>
            <li><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></li>
          <?php } ?>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>
<?php echo $footer; ?>