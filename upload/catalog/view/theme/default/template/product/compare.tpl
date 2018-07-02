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
    <table class="compare-info">
      <thead>
        <tr>
          <td class="compare-product" colspan="<?php echo count($products) + 1; ?>"><?php echo $text_product; ?></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $text_name; ?></td>
          <?php foreach ($products as $product) { ?>
            <td class="name"><a href="<?php echo $products[$product['product_id']]['href']; ?>"><?php echo $products[$product['product_id']]['name']; ?></a></td>
          <?php } ?>
        </tr>
        <tr>
          <td><?php echo $text_image; ?></td>
        <?php foreach ($products as $product) { ?>
          <td>
          <?php if ($products[$product['product_id']]['thumb']) { ?>
            <?php if ($products[$product['product_id']]['stock_label']) { ?>
              <div class="stock-medium"><img src="<?php echo $products[$product['product_id']]['stock_label']; ?>" alt="" /></div>
            <?php } ?>
            <?php if (!$products[$product['product_id']]['stock_label'] && $products[$product['product_id']]['offer']) { ?>
              <div class="offer-medium"><img src="<?php echo $products[$product['product_id']]['offer_label']; ?>" alt="" /></div>
            <?php } ?>
            <?php if (!$products[$product['product_id']]['stock_label'] && !$products[$product['product_id']]['offer'] && $products[$product['product_id']]['special']) { ?>
              <div class="special-medium"><img src="<?php echo $products[$product['product_id']]['special_label']; ?>" alt="" /></div>
            <?php } ?>
            <?php if ($products[$product['product_id']]['label']) { ?>
              <div class="product-label">
                <img src="<?php echo $products[$product['product_id']]['label']; ?>" alt="" height="<?php echo $products[$product['product_id']]['label_style']; ?>" width="<?php echo $products[$product['product_id']]['label_style']; ?>" style="margin:0 0 -<?php echo $products[$product['product_id']]['label_style']; ?>px <?php echo ($products[$product['product_id']]['label_style'] * 2); ?>px;" />
              </div>
            <?php } ?>
            <a href="<?php echo $products[$product['product_id']]['href']; ?>"><img src="<?php echo $products[$product['product_id']]['thumb']; ?>" alt="<?php echo $products[$product['product_id']]['name']; ?>" /></a>
          <?php } ?>
          </td>
        <?php } ?>
        </tr>
        <tr>
          <td><?php echo $text_price; ?></td>
        <?php foreach ($products as $product) { ?>
          <td><?php if ($products[$product['product_id']]['price'] && !$price_hide) { ?>
            <?php if (!$products[$product['product_id']]['special']) { ?>
              <?php echo $products[$product['product_id']]['price']; ?>
            <?php } else { ?>
              <span class="price-old"><?php echo $products[$product['product_id']]['price']; ?></span> <span class="price-new"><?php echo $products[$product['product_id']]['special']; ?></span>
            <?php } ?>
          <?php } ?></td>
        <?php } ?>
        </tr>
        <tr>
          <td><?php echo $text_model; ?></td>
          <?php foreach ($products as $product) { ?>
            <td><?php echo $products[$product['product_id']]['model']; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td><?php echo $text_manufacturer; ?></td>
          <?php foreach ($products as $product) { ?>
            <td><?php echo $products[$product['product_id']]['manufacturer']; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td><?php echo $text_availability; ?></td>
          <?php foreach ($products as $product) { ?>
            <td><?php echo $products[$product['product_id']]['availability']; ?><br />
            <?php if ($products[$product['product_id']]['stock_remaining'] && $this->config->get($template . '_product_stock_low') && ($products[$product['product_id']]['stock_quantity'] > 0) && ($products[$product['product_id']]['stock_quantity'] <= $this->config->get($template . '_product_stock_limit'))) { ?>
              <div style="color:#CC2626; font-weight:bold;"><?php echo $products[$product['product_id']]['stock_remaining']; ?></div>
            <?php } ?>
            </td>
          <?php } ?>
        </tr>
        <tr>
          <td><?php echo $text_offer; ?></td>
          <?php foreach ($products as $product) { ?>
            <?php if ($products[$product['product_id']]['offer']) { ?>
              <td><a href="<?php echo $products[$product['product_id']]['offer_href']; ?>" style="text-decoration:none;"><?php echo $products[$product['product_id']]['offer_description']; ?></a></td>
            <?php } else { ?>
              <td><?php echo $text_no_offer; ?></td>
            <?php } ?>
          <?php } ?>
        </tr>
        <?php if ($review_status) { ?>
          <tr>
            <td><?php echo $text_rating; ?></td>
            <?php foreach ($products as $product) { ?>
              <td><img src="catalog/view/theme/<?php echo $template; ?>/image/stars-<?php echo $products[$product['product_id']]['rating']; ?>.png" alt="<?php echo $products[$product['product_id']]['reviews']; ?>" /><br />
              <?php echo $products[$product['product_id']]['reviews']; ?></td>
            <?php } ?>
          </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_summary; ?></td>
          <?php foreach ($products as $product) { ?>
            <td class="description"><?php echo $products[$product['product_id']]['description']; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td><?php echo $text_weight; ?></td>
          <?php foreach ($products as $product) { ?>
            <td><?php echo $products[$product['product_id']]['weight']; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td><?php echo $text_dimension; ?></td>
          <?php foreach ($products as $product) { ?>
            <td><?php echo $products[$product['product_id']]['length']; ?> x <?php echo $products[$product['product_id']]['width']; ?> x <?php echo $products[$product['product_id']]['height']; ?></td>
          <?php } ?>
        </tr>
      </tbody>
    <?php foreach ($attribute_groups as $attribute_group) { ?>
      <thead>
        <tr>
          <td class="compare-attribute" colspan="<?php echo count($products) + 1; ?>"><?php echo $attribute_group['name']; ?></td>
        </tr>
      </thead>
      <?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
        <tbody>
          <tr>
            <td><?php echo $attribute['name']; ?></td>
            <?php foreach ($products as $product) { ?>
              <?php if (isset($products[$product['product_id']]['attribute'][$key])) { ?>
                <td><?php echo html_entity_decode($products[$product['product_id']]['attribute'][$key], ENT_QUOTES, 'UTF-8'); ?></td>
              <?php } else { ?>
                <td></td>
              <?php } ?>
            <?php } ?>
          </tr>
        </tbody>
      <?php } ?>
    <?php } ?>
      <tr>
        <td></td>
        <?php foreach ($products as $product) { ?>
          <?php if ($products[$product['product_id']]['quote']) { ?>
            <td><a href="<?php echo $products[$product['product_id']]['quote']; ?>" title="" class="button"><i class="fa fa-edit"></i> &nbsp; <?php echo $button_quote; ?></a></td>
          <?php } elseif (!$products[$product['product_id']]['quote'] && !$stock_checkout && $products[$product['product_id']]['stock_quantity'] <= 0) { ?>
            <td><span class="stock-status"> &nbsp; <i class="fa fa-clock-o"></i> <?php echo $products[$product['product_id']]['stock_status']; ?></span></td>
          <?php } elseif (!$products[$product['product_id']]['quote'] && $stock_checkout && $products[$product['product_id']]['stock_quantity'] <= 0) { ?>
            <td><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $products[$product['product_id']]['product_id']; ?>');" class="button" /></td>
          <?php } else { ?>
            <td><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $products[$product['product_id']]['product_id']; ?>');" class="button" /></td>
          <?php } ?>
        <?php } ?>
      </tr>
      <tr>
        <td></td>
        <?php foreach ($products as $product) { ?>
          <td class="remove"><a href="<?php echo $products[$product['product_id']]['remove']; ?>" class="button-danger"><i class="fa fa-close"></i> &nbsp; <?php echo $button_remove; ?></a></td>
        <?php } ?>
      </tr>
    </table>
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