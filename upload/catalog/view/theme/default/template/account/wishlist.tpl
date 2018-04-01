<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?><img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($products) { ?>
    <div class="wishlist-info">
      <table>
        <thead>
          <tr>
            <td class="image"><?php echo $column_image; ?></td>
            <td class="name"><?php echo $column_name; ?></td>
            <td class="model"><?php echo $column_model; ?></td>
            <td class="stock"><?php echo $column_stock; ?></td>
            <td class="price"><?php echo $column_price; ?></td>
            <td class="action"><?php echo $column_action; ?></td>
          </tr>
        </thead>
      <?php foreach ($products as $product) { ?>
        <tbody id="wishlist-row<?php echo $product['product_id']; ?>">
          <tr>
            <td class="image">
            <?php if (!$label && $product['offer']) { ?>
              <div class="promo-small"><img src="catalog/view/theme/<?php echo $template; ?>/image/labels/offer-30x30-<?php echo $lang; ?>.png" alt="" /></div>
            <?php } ?>
            <?php if ($product['thumb']) { ?>
              <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
            <?php } ?></td>
            <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></td>
            <td class="model"><?php echo $product['model']; ?></td>
            <td class="stock"><?php echo $product['stock']; ?></td>
            <td class="price"><?php if ($product['price']) { ?>
              <?php if (!$product['special']) { ?>
                <?php echo $product['price']; ?>
              <?php } else { ?>
                <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
              <?php } ?>
            <?php } ?></td>
            <td class="action">
              <?php if ($product['quote']) { ?>
                <a href="<?php echo $product['quote']; ?>" title=""><img src="catalog/view/theme/<?php echo $template; ?>/image/account/quote.png" alt="" /></a>
              <?php } elseif (!$product['quote'] && $product['stock_quantity'] <= 0) { ?>
                <img src="catalog/view/theme/<?php echo $template; ?>/image/account/cart-no-stock.png" alt="<?php echo $product['stock_status']; ?>" title="<?php echo $product['stock_status']; ?>" />
              <?php } else { ?>
                <img src="catalog/view/theme/<?php echo $template; ?>/image/account/cart-add.png" alt="<?php echo $button_cart; ?>" title="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" />
              <?php } ?>
              &nbsp;&nbsp;
              <a href="<?php echo $product['remove']; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /></a>
            </td>
          </tr>
        </tbody>
      <?php } ?>
      </table>
    </div>
    <div class="buttons">
      <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
    </div>
  <?php } else { ?>
    <div class="content"><?php echo $text_empty; ?></div>
    <div class="buttons">
      <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
    </div>
  <?php } ?>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>
<?php echo $footer; ?>