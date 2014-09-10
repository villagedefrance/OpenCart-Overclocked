<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
    <div class="box-product" style="text-align:center;">
    <?php foreach ($products as $product) { ?>
      <div>
        <?php if (!$label && $product['offer']) { ?>
          <div class="promo-medium"><?php echo $text_offer; ?></div>
        <?php } ?>
        <?php if ($product['thumb']) { ?>
          <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
          <div class="price">
          <?php if (!$product['special']) { ?>
            <?php echo $product['price']; ?>
          <?php } else { ?>
            <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
          </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
          <div class="rating"><img src="catalog/view/theme/<?php echo $template; ?>/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <?php if ($viewproduct) { ?>
          <div style="padding:2px 0px;"><a href="<?php echo $product['href']; ?>" class="button"><?php echo $button_view; ?></a></div>
        <?php } ?>
        <?php if ($addproduct) { ?>
          <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
        <?php } ?>
      </div>
    <?php } ?>
    </div>
  </div>
</div>
<?php } else { ?>
  <div style="margin-bottom:20px;">
    <div class="box-product" style="text-align:center;">
    <?php foreach ($products as $product) { ?>
      <div>
        <?php if (!$label && $product['offer']) { ?>
          <div class="promo-medium"><?php echo $text_offer; ?></div>
        <?php } ?>
        <?php if ($product['thumb']) { ?>
          <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
          <div class="price">
          <?php if (!$product['special']) { ?>
            <?php echo $product['price']; ?>
          <?php } else { ?>
            <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
          </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
          <div class="rating"><img src="catalog/view/theme/<?php echo $template; ?>/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <?php if ($viewproduct) { ?>
          <div style="padding:2px 0px;"><a href="<?php echo $product['href']; ?>" class="button"><?php echo $button_view; ?></a></div>
        <?php } ?>
        <?php if ($addproduct) { ?>
          <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
        <?php } ?>
      </div>
    <?php } ?>
    </div>
  </div>
<?php } ?>