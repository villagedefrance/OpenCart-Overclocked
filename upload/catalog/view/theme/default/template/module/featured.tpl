<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
  <div class="box-product" style="text-align:center;">
    <?php foreach ($products as $product) { ?>
      <div>
        <?php if (!$label && $product['offer']) { ?>
          <div class="promo-medium"><img src="catalog/view/theme/<?php echo $template; ?>/image/labels/offer-45x45-<?php echo $lang; ?>.png" alt="" /></div>
        <?php } ?>
        <?php if ($product['thumb']) { ?>
          <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <?php if ($brand && $product['manufacturer']) { ?>
          <div class="brand"><?php echo $product['manufacturer']; ?></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
          <div class="price">
          <?php if ($product['price_option']) { ?>
            <span class="from"><?php echo $text_from; ?></span><br />
          <?php } ?>
          <?php if (!$product['special']) { ?>
            <?php echo $product['price']; ?>
          <?php } else { ?>
            <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
          </div>
        <?php } ?>
        <?php if ($product['age_minimum']) { ?>
          <span class="help">(<?php echo $product['age_minimum']; ?>+)</span>
        <?php } ?>
        <?php if ($model && $product['model']) { ?>
          <div><span style="font-size:9px;"><?php echo $text_model; ?></span> <?php echo $product['model']; ?><br /></div>
        <?php } ?>
        <?php if ($reward && $product['reward']) { ?>
          <div><span style="font-size:9px;"><?php echo $text_reward; ?></span> <?php echo $product['reward']; ?><br /></div>
        <?php } ?>
        <?php if ($point && $product['points']) { ?>
          <div><span class="reward" style="font-size:9px;"><?php echo $text_points; ?> <?php echo $product['points']; ?></span><br /></div>
        <?php } ?>
        <?php if ($review && $product['rating']) { ?>
          <div class="rating"><img src="catalog/view/theme/<?php echo $template; ?>/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <?php if ($viewproduct) { ?>
          <div style="padding:2px 0px;"><a href="<?php echo $product['href']; ?>" class="button"><?php echo $button_view; ?></a></div>
        <?php } ?>
        <?php if ($addproduct) { ?>
          <?php if ($product['quote']) { ?>
            <div class="cart"><a href="<?php echo $product['quote']; ?>" title="" class="button"><?php echo $button_quote; ?></a></div>
          <?php } else { ?>
            <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');" class="button" /></div>
          <?php } ?>
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
          <div class="promo-medium"><img src="catalog/view/theme/<?php echo $template; ?>/image/labels/offer-45x45-<?php echo $lang; ?>.png" alt="" /></div>
        <?php } ?>
        <?php if ($product['thumb']) { ?>
          <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <?php if ($brand && $product['manufacturer']) { ?>
          <div class="brand"><?php echo $product['manufacturer']; ?></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
          <div class="price">
          <?php if ($product['price_option']) { ?>
            <span class="from"><?php echo $text_from; ?></span><br />
          <?php } ?>
          <?php if (!$product['special']) { ?>
            <?php echo $product['price']; ?>
          <?php } else { ?>
            <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
          </div>
        <?php } ?>
        <?php if ($product['age_minimum']) { ?>
          <span class="help">(<?php echo $product['age_minimum']; ?>+)</span>
        <?php } ?>
        <?php if ($model && $product['model']) { ?>
          <div><span style="font-size:9px;"><?php echo $text_model; ?></span> <?php echo $product['model']; ?><br /></div>
        <?php } ?>
        <?php if ($reward && $product['reward']) { ?>
          <div><span style="font-size:9px;"><?php echo $text_reward; ?></span> <?php echo $product['reward']; ?><br /></div>
        <?php } ?>
        <?php if ($point && $product['points']) { ?>
          <div><span class="reward" style="font-size:9px;"><?php echo $text_points; ?> <?php echo $product['points']; ?></span><br /></div>
        <?php } ?>
        <?php if ($review && $product['rating']) { ?>
          <div class="rating"><img src="catalog/view/theme/<?php echo $template; ?>/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <?php if ($viewproduct) { ?>
          <div style="padding:2px 0px;"><a href="<?php echo $product['href']; ?>" class="button"><?php echo $button_view; ?></a></div>
        <?php } ?>
        <?php if ($addproduct) { ?>
          <?php if ($product['quote']) { ?>
            <div class="cart"><a href="<?php echo $product['quote']; ?>" title="" class="button"><?php echo $button_quote; ?></a></div>
          <?php } else { ?>
            <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');" class="button" /></div>
          <?php } ?>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
  </div>
<?php } ?>