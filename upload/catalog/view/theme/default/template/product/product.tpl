<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php echo $breadcrumb['separator']; ?>
      <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="display:inline;">
        <a href="<?php echo $breadcrumb['href']; ?>" itemprop="url"><span itemprop="title"><?php echo $breadcrumb['text']; ?></span></a>
      </div>
    <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <div class="product-info">
    <?php if ($dob && $age_minimum > 0 && !$age_logged) { ?>
      <div class="attention" style="margin:0 0 15px 0;"><?php echo $text_age_restriction; ?></div>
    <?php } elseif ($dob && $age_minimum > 0 && !$age_checked) { ?>
      <div class="attention" style="margin:0 0 15px 0;"><?php echo $text_age_minimum; ?></div>
    <?php } ?>
    <?php if ($thumb || $images) { ?>
      <div class="left">
      <?php if ($lightbox == 'colorbox') { ?>
        <?php if ($thumb) { ?>
          <?php if ($stock_label_large) { ?>
            <div class="stock-large"><img src="<?php echo $stock_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$stock_label_large && $offers && $offer_label_large) { ?>
            <div class="offer-large"><img src="<?php echo $offer_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$stock_label_large && !$offers && $special_label_large) { ?>
            <div class="special-large"><img src="<?php echo $special_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if ($label) { ?>
            <div class="product-label" style="left:<?php echo $label_style; ?>px; margin:0 0 -<?php echo $label_height; ?>px 0;">
            <img src="<?php echo $label; ?>" alt="" /></div>
          <?php } ?>
          <div class="image">
            <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
          </div>
        <?php } ?>
        <?php if ($images) { ?>
          <div class="image-additional">
            <?php foreach ($images as $image) { ?>
              <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
            <?php } ?>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if ($lightbox == 'fancybox') { ?>
        <?php if ($thumb) { ?>
          <?php if ($stock_label_large) { ?>
            <div class="stock-large"><img src="<?php echo $stock_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$stock_label_large && $offers && $offer_label_large) { ?>
            <div class="offer-large"><img src="<?php echo $offer_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$stock_label_large && !$offers && $special_label_large) { ?>
            <div class="special-large"><img src="<?php echo $special_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if ($label) { ?>
            <div class="product-label" style="left:<?php echo $label_style; ?>px; margin:0 0 -<?php echo $label_height; ?>px 0;">
            <img src="<?php echo $label; ?>" alt="" /></div>
          <?php } ?>
          <div class="image">
            <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="fancybox" rel="gallery"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
          </div>
        <?php } ?>
        <?php if ($images) { ?>
          <div class="image-additional">
            <?php foreach ($images as $image) { ?>
              <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="fancybox" rel="gallery"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
            <?php } ?>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if ($lightbox == 'magnific') { ?>
        <?php if ($thumb) { ?>
          <?php if ($stock_label_large) { ?>
            <div class="stock-large"><img src="<?php echo $stock_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$stock_label_large && $offers && $offer_label_large) { ?>
            <div class="offer-large"><img src="<?php echo $offer_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$stock_label_large && !$offers && $special_label_large) { ?>
            <div class="special-large"><img src="<?php echo $special_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if ($label) { ?>
            <div class="product-label" style="left:<?php echo $label_style; ?>px; margin:0 0 -<?php echo $label_height; ?>px 0;">
            <img src="<?php echo $label; ?>" alt="" /></div>
          <?php } ?>
          <div class="image">
            <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="magnific"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
          </div>
        <?php } ?>
        <?php if ($images) { ?>
          <div class="image-additional">
            <?php foreach ($images as $image) { ?>
              <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="magnific"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
            <?php } ?>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if ($lightbox == 'viewbox') { ?>
        <?php if ($thumb) { ?>
          <?php if ($stock_label_large) { ?>
            <div class="stock-large"><img src="<?php echo $stock_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$stock_label_large && $offers && $offer_label_large) { ?>
            <div class="offer-large"><img src="<?php echo $offer_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$stock_label_large && !$offers && $special_label_large) { ?>
            <div class="special-large"><img src="<?php echo $special_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if ($label) { ?>
            <div class="product-label" style="left:<?php echo $label_style; ?>px; margin:0 0 -<?php echo $label_height; ?>px 0;">
            <img src="<?php echo $label; ?>" alt="" /></div>
          <?php } ?>
          <div class="image">
            <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="viewbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
          </div>
        <?php } ?>
        <?php if ($images) { ?>
          <div class="image-additional">
            <?php foreach ($images as $image) { ?>
              <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="viewbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
            <?php } ?>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if ($lightbox == 'zoomlens') { ?>
        <?php if ($thumb) { ?>
          <?php if ($stock_label_large) { ?>
            <div class="stock-large"><img src="<?php echo $stock_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$stock_label_large && $offers && $offer_label_large) { ?>
            <div class="offer-large"><img src="<?php echo $offer_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$stock_label_large && !$offers && $special_label_large) { ?>
            <div class="special-large"><img src="<?php echo $special_label_large; ?>" alt="" /></div>
          <?php } ?>
          <?php if ($label) { ?>
            <div class="product-label" style="left:<?php echo $label_style; ?>px; margin:0 0 -<?php echo $label_height; ?>px 0;">
            <img src="<?php echo $label; ?>" alt="" /></div>
          <?php } ?>
          <div class="simpleLens-gallery-container" id="zoom">
            <div class="simpleLens-container">
              <div class="simpleLens-big-image-container">
                <a class="simpleLens-lens-image" data-lens-image="<?php echo $zoom; ?>"><img src="<?php echo $thumb; ?>" class="simpleLens-big-image" alt="" /></a>
              </div>
            </div>
            <div class="simpleLens-thumbnails-container">
              <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="<?php echo $zoom; ?>" data-big-image="<?php echo $popup; ?>"><img src="<?php echo $gallery_thumb; ?>" alt="" /></a>
              <?php foreach ($images as $image) { ?>
                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="<?php echo $image['zoom']; ?>" data-big-image="<?php echo $image['popup']; ?>"><img src="<?php echo $image['thumb']; ?>" alt="" /></a>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if ($video_code) { ?>
        <div class="video">
          <iframe src="http://www.youtube.com/embed/<?php echo $video_code; ?>?html5=1" width="<?php echo $video_width; ?>" height="<?php echo $video_height; ?>"></iframe>
        </div>
        <div><a class="button button-resource"><i class="fa fa-info-circle"></i></a><br /></div>
      <?php } ?>
      </div>
    <?php } ?>
    <div class="right">
      <div class="description">
        <?php if ($manufacturer) { ?>
          <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
        <?php } ?>
        <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />
        <?php if ($barcode) { ?>
          <?php echo $barcode; ?>
        <?php } ?>
        <?php if ($product_fields) { ?>
          <?php foreach ($product_fields as $product_field) { ?>
            <span><?php echo $product_field['title']; ?>:</span> <?php echo $product_field['text']; ?><br />
          <?php } ?>
        <?php } ?>
        <?php if ($reward) { ?>
          <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
        <?php } ?>
        <?php if ($age_minimum > 0) { ?>
          <span><?php echo $text_age_band; ?></span> <?php echo $age_minimum; ?>+<br />
        <?php } ?>
        <span><?php echo $text_stock; ?></span>
        <?php if ($stock_remaining && $this->config->get($template . '_product_stock_low') && ($stock_quantity <= $this->config->get($template . '_product_stock_limit'))) { ?>
          <span style="color:#CC2626; font-weight:bold;"><?php echo $stock_remaining; ?></span><br />
        <?php } else { ?>
          <?php echo $stock; ?><br />
        <?php } ?>
        <?php if ($locations) { ?>
          <span><?php echo $text_location; ?></span>
          <?php for ($i = 0; $i < count($locations); $i++) { ?>
            <?php if (isset($locations[$i]['name'])) { ?>
              <?php echo ($i < (count($locations) - 1)) ? $locations[$i]['name'] . ', ' : $locations[$i]['name'] . '.'; ?>
            <?php } ?>
          <?php } ?>
        <?php } ?>
      </div>
      <?php if ($price && !$price_hide) { ?>
        <div class="price"><?php echo $text_price; ?>
        <?php if ($price_option) { ?>
          <span class="from"><?php echo $text_from; ?></span>&nbsp;
        <?php } ?>
        <?php if (!$special) { ?>
          <?php echo $price; ?>
        <?php } else { ?>
          <span class="price-old"><?php echo $price; ?></span> <span class="price-new"><?php echo $special; ?></span>
        <?php } ?>
        <br />
        <?php if ($tax) { ?>
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span><br />
        <?php } ?>
        <?php if ($points) { ?>
          <span class="reward"><?php echo $text_points; ?> <?php echo $points; ?></span><br />
        <?php } ?>
        <?php if ($discounts) { ?>
          <div class="discount">
          <?php foreach ($discounts as $discount) { ?>
            <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
          <?php } ?>
          </div>
        <?php } ?>
        </div>
      <?php } ?>
      <?php if ($profiles) { ?>
        <div class="option">
          <h2><span class="required">*</span> <?php echo $text_payment_profile; ?></h2>
          <br />
          <select name="profile_id">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($profiles as $profile) { ?>
              <option value="<?php echo $profile['profile_id']; ?>"><?php echo $profile['name']; ?></option>
            <?php } ?>
          </select>
          <br />
          <br />
          <span id="profile-description"></span>
          <br />
          <br />
        </div>
      <?php } ?>
      <?php if ($product_colors) { ?>
        <div class="color-range">
        <?php foreach ($product_colors as $product_color) { ?>
          <span class="color" style="background-color:#<?php echo $product_color['color']; ?>;"></span>
        <?php } ?><br />
        </div>
      <?php } ?>
      <?php if ($options) { ?>
        <div class="options">
          <h2><?php echo $text_option; ?></h2>
          <br />
          <?php foreach ($options as $option) { ?>
            <?php if ($option['type'] == 'select') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
                <span class="required">* </span>
              <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <select name="option[<?php echo $option['product_option_id']; ?>]">
                  <option value=""><?php echo $text_select; ?></option>
                  <?php foreach ($option['option_value'] as $option_value) { ?>
                    <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                      (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <br />
            <?php } ?>
            <?php if ($option['type'] == 'radio') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
                <span class="required">* </span>
              <?php } ?>
              <b><?php echo $option['name']; ?>:</b><br />
              <?php foreach ($option['option_value'] as $option_value) { ?>
                <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                <?php } ?>
                </label>
                <br />
              <?php } ?>
              </div>
              <br />
            <?php } ?>
            <?php if ($option['type'] == 'checkbox') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
                <span class="required">* </span>
              <?php } ?>
              <b><?php echo $option['name']; ?>:</b><br />
              <?php foreach ($option['option_value'] as $option_value) { ?>
                <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                <?php } ?>
                </label>
                <br />
              <?php } ?>
              </div>
              <br />
            <?php } ?>
            <?php if ($option['type'] == 'image') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
                <span class="required">* </span>
              <?php } ?>
              <b><?php echo $option['name']; ?>:</b><br />
              <table class="option-image">
                <?php foreach ($option['option_value'] as $option_value) { ?>
                <tr>
                  <td style="width:1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
                  <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price']) ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''; ?>" /></label></td>
                  <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                  </label></td>
                </tr>
                <?php } ?>
              </table>
              </div>
              <br />
            <?php } ?>
            <?php if ($option['type'] == 'text') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
                <span class="required">* </span>
              <?php } ?>
              <b><?php echo $option['name']; ?>:</b><br />
              <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
              </div>
              <br />
            <?php } ?>
            <?php if ($option['type'] == 'textarea') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
                <span class="required">* </span>
              <?php } ?>
              <b><?php echo $option['name']; ?>:</b><br />
              <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="30" rows="5"><?php echo $option['option_value']; ?></textarea>
              </div>
              <br />
            <?php } ?>
            <?php if ($option['type'] == 'file') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
                <span class="required">* </span>
              <?php } ?>
              <b><?php echo $option['name']; ?>:</b><br />
              <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
              <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
              </div>
              <br />
            <?php } ?>
            <?php if ($option['type'] == 'date') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
                <span class="required">* </span>
              <?php } ?>
              <b><?php echo $option['name']; ?>:</b><br />
              <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
              </div>
              <br />
            <?php } ?>
            <?php if ($option['type'] == 'time') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
                <span class="required">* </span>
              <?php } ?>
              <b><?php echo $option['name']; ?>:</b><br />
              <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
              </div>
              <br />
            <?php } ?>
            <?php if ($option['type'] == 'datetime') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
              <?php if ($option['required']) { ?>
                <span class="required">* </span>
              <?php } ?>
              <b><?php echo $option['name']; ?>:</b><br />
              <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
              </div>
              <br />
            <?php } ?>
          <?php } ?>
        </div>
      <?php } ?>
      <div class="cart">
        <div>
        <?php if ($dob && $age_minimum > 0 && !$age_logged) { ?>
          <a href="<?php echo $login_register; ?>" class="button"><?php echo $button_login; ?></a>
        <?php } elseif ($dob && $age_minimum > 0 && !$age_checked) { ?>
          <p class="hidden"></p>
        <?php } else { ?>
          <b class="sub-prod-count" onclick="subProductCount();"></b>
          <input type="text" name="quantity" id="quantity" class="quantity-input" size="2" value="<?php echo $minimum; ?>" readonly="readonly" />
          <b class="add-prod-count" onclick="addProductCount();"></b>
          <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
          <?php if ($is_quote) { ?>
            <a href="<?php echo $is_quote; ?>" class="button" style="margin-left:15px;"><?php echo $button_quote; ?></a>
          <?php } elseif (!$is_quote && !$stock_checkout && $stock_quantity <= 0) { ?>
            <span class="stock-status"> &nbsp; <i class="fa fa-clock-o"></i> <?php echo $stock; ?></span>
          <?php } elseif (!$is_quote && $stock_checkout && $stock_quantity <= 0) { ?>
            <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button-cart" />
          <?php } else { ?>
            <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button-cart" />
          <?php } ?>
        <?php } ?>
        <span id="price-button-add">
          <a onclick="addToWishList('<?php echo $product_id; ?>');" title="<?php echo $button_wishlist; ?>" class="button-add"><i class="fa fa-heart"></i></a>
          <a onclick="addToCompare('<?php echo $product_id; ?>');" title="<?php echo $button_compare; ?>" class="button-add"><i class="fa fa-random"></i></a>
        </span>
        </div>
        <?php if ($minimum > 1) { ?>
          <div class="minimum"><?php echo $text_minimum; ?></div>
        <?php } ?>
      </div>
      <?php if (($dob && $age_minimum > 0 && !$age_checked) || $is_quote || !$buy_now_button || ($stock_quantity <= 0)) { ?>
        <p class="hidden"></p>
       <?php } elseif (!$is_quote && $stock_checkout && $buy_now_button && $stock_quantity <= 0) { ?>
        <div id="buy-now" style="margin-bottom:20px;"><input type="button" value="<?php echo $button_buy_it_now; ?>" id="button-buy-it-now" class="button-buy-now" /></div>
      <?php } else { ?>
        <div id="buy-now" style="margin-bottom:20px;"><input type="button" value="<?php echo $button_buy_it_now; ?>" id="button-buy-it-now" class="button-buy-now" /></div>
      <?php } ?>
      <div id="cart-warnings"></div>
    <?php if ($review_status) { ?>
      <div class="review">
        <div class="rating" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
          <meta itemprop="value" content="<?php echo $rating; ?>" />
          <meta itemprop="best" content="5" />
          <img src="catalog/view/theme/<?php echo $template; ?>/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />
          <a onclick="goToReviews('<?php echo $product_id; ?>');" style="margin:0 15px;"><?php echo $reviews; ?></a>
          <a onclick="goToReviews('<?php echo $product_id; ?>');" title="<?php echo $text_write; ?>" class="button-add"><i class="fa fa-comments"></i></a>
        </div>
        <?php if (!$share_addthis) { ?>
        <div class="share">
          <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
            <a class="addthis_button_print"></a>
            <a class="addthis_button_email"></a>
            <a class="addthis_button_preferred_1"></a>
            <a class="addthis_button_preferred_2"></a>
            <a class="addthis_button_preferred_3"></a>
            <a class="addthis_button_compact"></a>
            <a class="addthis_counter addthis_bubble_style"></a>
          </div>
          <?php if ($addthis) { ?>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addthis; ?>"></script>
          <?php } else { ?>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script> 
          <?php } ?>
        </div>
        <?php } ?>
      </div>
    <?php } ?>
    </div>
  </div>
  <div class="panel-collapsed">
    <h3><?php echo $tab_description; ?><i class="fa"></i></h3>
    <div class="panel-content"><?php echo $description; ?></div>
  </div>
  <?php if ($attribute_groups) { ?>
    <div class="panel-collapsed">
      <h3><?php echo $tab_attribute; ?><i class="fa"></i></h3>
      <div class="panel-content">
        <div class="attribute">
        <?php foreach ($attribute_groups as $attribute_group) { ?>
          <div class="attribute-group">
            <?php echo $attribute_group['name']; ?>
          </div>
          <div class="attribute-list">
            <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
              <div>
                <div class="attribute-list-left"><?php echo $attribute['name']; ?></div>
                <div class="attribute-list-right"><?php echo html_entity_decode($attribute['text'], ENT_QUOTES, 'UTF-8'); ?></div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php if ($offers) { ?>
    <div class="panel-collapsed">
      <h3><?php echo $tab_offer; ?><i class="fa"></i></h3>
      <div class="panel-content">
        <div class="box-product">
          <?php foreach ($offers as $offer) { ?>
            <div>
            <?php if ($offer_label_medium) { ?>
              <div class="offer-medium"><img src="<?php echo $offer_label_medium; ?>" alt="" /></div>
            <?php } ?>
            <?php if ($offer['thumb']) { ?>
              <div class="image"><a href="<?php echo $offer['href']; ?>"><img src="<?php echo $offer['thumb']; ?>" alt="<?php echo $offer['name']; ?>" /></a></div>
            <?php } ?>
            <div class="name"><a href="<?php echo $offer['href']; ?>"><?php echo $offer['name']; ?></a></div>
            <div class="offer"><a href="<?php echo $offer['href']; ?>"><?php echo $offer['group']; ?></a></div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php if ($products) { ?>
    <div class="panel-collapsed">
      <h3><?php echo $tab_related; ?><i class="fa"></i></h3>
      <div class="panel-content">
        <div class="box-product">
        <?php foreach ($products as $product) { ?>
          <div>
            <?php if ($product['thumb']) { ?>
              <?php if ($product['stock_label']) { ?>
                <div class="stock-medium"><img src="<?php echo $product['stock_label']; ?>" alt="" /></div>
              <?php } ?>
              <?php if (!$product['stock_label'] && $product['offer']) { ?>
                <div class="offer-medium"><img src="<?php echo $product['offer_label']; ?>" alt="" /></div>
              <?php } ?>
              <?php if (!$product['stock_label'] && !$product['offer'] && $product['special']) { ?>
                <div class="special-medium"><img src="<?php echo $product['special_label']; ?>" alt="" /></div>
              <?php } ?>
              <?php if ($product['label']) { ?>
                <div class="product-label" style="left:<?php echo $product['label_style']; ?>px; margin:0 0 -<?php echo $product['label_style']; ?>px 0;">
                <img src="<?php echo $product['label']; ?>" alt="" height="<?php echo $product['label_style']; ?>" width="<?php echo $product['label_style']; ?>" /></div>
              <?php } ?>
              <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
            <?php } ?>
            <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
            <?php if ($product['price'] && !$price_hide) { ?>
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
            <?php if ($product['rating']) { ?>
              <div class="rating"><img src="catalog/view/theme/<?php echo $template; ?>/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
            <?php } ?>
            <?php if ($product['stock_remaining'] && $this->config->get($template . '_product_stock_low') && ($product['stock_quantity'] > 0) && ($product['stock_quantity'] <= $this->config->get($template . '_product_stock_limit'))) { ?>
              <div class="remaining"><?php echo $product['stock_remaining']; ?></div>
            <?php } ?>
            <div class="box-product-bottom">
              <?php if ($product['quote']) { ?>
                <div><a href="<?php echo $product['quote']; ?>" title="<?php echo $button_quote; ?>"><i class="fa fa-edit"></i></a></div>
              <?php } elseif (!$product['quote'] && !$stock_checkout && $product['stock_quantity'] <= 0) { ?>
                <div class="stock-status"><a title="<?php echo $product['stock_status']; ?>"><i class="fa fa-clock-o"></i></a></div>
              <?php } elseif (!$product['quote'] && $stock_checkout && $product['stock_quantity'] <= 0) { ?>
                <div><a onclick="addToCart('<?php echo $product['product_id']; ?>');" title="<?php echo $button_cart; ?>"><i class="fa fa-cart-arrow-down"></i></a></div>
              <?php } else { ?>
                <div><a onclick="addToCart('<?php echo $product['product_id']; ?>');" title="<?php echo $button_cart; ?>"><i class="fa fa-cart-arrow-down"></i></a></div>
              <?php } ?>
              <div><a onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $button_wishlist; ?>"><i class="fa fa-heart"></i></a></div>
              <div><a href="<?php echo $product['href']; ?>" title="<?php echo $button_view; ?>"><i class="fa fa-eye"></i></a></div>
            </div>
          </div>
        <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>
  <div id="reviews"></div>
  <?php if ($review_status) { ?>
    <div class="panel-collapsed">
      <h3><?php echo $tab_review; ?><i class="fa"></i></h3>
      <div class="panel-content">
        <div id="review"></div>
        <div id="add-review">
        <?php if ($review_allowed) { ?>
          <h2 id="review-title"><?php echo $text_write; ?></h2>
          <div class="review-element">
            <input type="text" name="name" placeholder="<?php echo $entry_name; ?>" value="" size="30" />
          </div>
          <div class="review-element">
            <textarea name="text" cols="40" rows="3" placeholder="<?php echo $entry_review; ?>"></textarea>
            <br /><?php echo $text_note; ?>
          </div>
          <div class="review-rating">
            <b><?php echo $entry_rating; ?></b>&nbsp;
            <img src="catalog/view/theme/<?php echo $template; ?>/image/thumbs-down.png" alt="<?php echo $entry_bad; ?>" title="<?php echo $entry_bad; ?>" />&nbsp;
            <input type="radio" name="rating" value="1" />&nbsp;
            <input type="radio" name="rating" value="2" />&nbsp;
            <input type="radio" name="rating" value="3" />&nbsp;
            <input type="radio" name="rating" value="4" />&nbsp;
            <input type="radio" name="rating" value="5" />&nbsp;
            <img src="catalog/view/theme/<?php echo $template; ?>/image/thumbs-up.png" alt="<?php echo $entry_good; ?>" title="<?php echo $entry_good; ?>" />
          </div>
          <div id="captcha-wrap">
            <div class="captcha-box">
              <div class="captcha-view">
                <img src="index.php?route=product/product/captcha" alt="" id="captcha-image" />
              </div>
            </div>
            <div class="captcha-text">
              <label><?php echo $entry_captcha; ?></label>
              <input type="text" name="captcha" id="captcha" value="<?php echo $captcha; ?>" autocomplete="off" />
            </div>
            <div class="captcha-action"><i class="fa fa-repeat"></i></div>
          </div>
          <br />
          <div><a id="button-review" class="button"><?php echo $button_continue; ?></a></div>
        <?php } else { ?>
          <?php if ($help_review_logged) { ?>
            <div class="attention"><?php echo $help_review_logged; ?></div>
          <?php } ?>
        <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php if ($tags) { ?>
    <div class="tags"><b><?php echo $text_tags; ?></b>
    <?php for ($i = 0; $i < count($tags); $i++) { ?>
      <?php if ($i < (count($tags) - 1)) { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
      <?php } else { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
      <?php } ?>
    <?php } ?>
   </div>
  <?php } ?>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

<?php if ($lightbox == 'colorbox') { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.3,
		rel: "colorbox"
	});
});
//--></script>
<?php } ?>

<?php if ($lightbox == 'fancybox') { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('a.fancybox').attr('rel', 'gallery').fancyboxPlus({
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		cyclic: true,
		speedIn: 500,
		speedOut: 150,
		overlayColor: '#666',
		overlayOpacity: 0.3,
		overlayShow: true,
		hideOnOverlayClick: true
	});
});
//--></script>
<?php } ?>

<?php if ($lightbox == 'magnific') { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.magnific').magnificPopup({
		type: 'image',
		gallery: { enabled:true }
	});
});
//--></script>
<?php } ?>

<?php if ($lightbox == 'viewbox') { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.viewbox').viewbox({
		setTitle: true,
		margin: 20,
		resizeDuration: 300,
		openDuration: 200,
		closeDuration: 200,
		closeButton: true,
		navButtons: true,
		closeOnSideClick: true,
		nextOnContentClick: true
	});
});
//--></script>
<?php } ?>

<?php if ($lightbox == 'zoomlens') { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#zoom .simpleLens-thumbnails-container img').click(function(event) {
		event.preventDefault();
		return false;
	});
	$('#zoom .simpleLens-thumbnails-container img').simpleGallery();
	$('#zoom .simpleLens-big-image').simpleLens();
});
//--></script>
<?php } ?>

<script type="text/javascript"><!--
$('select[name="profile_id"], input[name="quantity"]').change(function() {
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name="product_id"], input[name="quantity"], select[name="profile_id"]'),
		dataType: 'json',
		beforeSend: function() {
			$('#profile-description').html('');
		},
		success: function(json) {
			$('.success, .warning, .attention, .tooltip, .error').remove();

			if (json['success']) {
				$('#profile-description').html(json['success']);
			}
		}
	});
});

$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .tooltip, .error').remove();

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}

				if (json['error']['quantity']) {
					$('#cart-warnings').after('<div class="warning" style="margin:5px 0;">' + json['error']['quantity'] + '<img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>');
				}

				if (json['error']['profile']) {
					$('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
				}
			}

			if (json['success']) {
				$('#notification').html('<div class="success" style="display:none;">' + json['success'] + '<img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>');
				$('.success').fadeIn('slow');
				$('#cart-total').html(json['total']);
				$('html, body').animate({ scrollTop:0 }, 800);
			}
		}
	});
});

$('#button-buy-it-now').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('.success, .warning, .attention, .error').remove();
			$('#button-buy-it-now').attr('disabled', true);
			$('#button-buy-it-now').after('<span><img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" class="loading" style="padding-left:10px;" /></span>');
		},
		complete: function() {
			$('#button-buy-it-now').attr('disabled', false);
			$('.loading').remove();
		},
		success: function(json) {
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}

				if (json['error']['quantity']) {
					$('#cart-warnings').after('<div class="warning" style="margin:5px 0;">' + json['error']['quantity'] + '<img src="catalog/view/theme/<?php echo $template; ?>/image/close.png" alt="" class="close" /></div>');
				}

				if (json['error']['profile']) {
					$('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
				}
			}

			if (json['success']) {
				$('#cart-total').html(json['total']);
				window.location = '<?php echo $buy_it_now; ?>';
			}
		}
	});
});
//--></script>

<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-slider-access.min.js"></script> 

<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.time').timepicker({
	timeFormat: 'HH:mm',
	addSliderAccess: true,
	sliderAccessArgs: { touchonly: false }
});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'HH:mm',
	addSliderAccess: true,
	sliderAccessArgs: { touchonly: false }
});
//--></script>

<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.min.js"></script>

<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" class="loading" style="padding-left:5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);

		$('.error').remove();

		if (json['success']) {
			alert(json['success']);

			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}

		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}

		$('.loading').remove();
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>

<script type="text/javascript"><!--
$('img#captcha-image').on('load', function(event) {
	$(event.target).show();
});
$('img#captcha-image').trigger('load');
//--></script>

<script type="text/javascript"><!--
$('#review .pagination').on('click', 'a', function() {
	$('#review').fadeOut('slow');
	$('#review').load(this.href);
	$('#review').fadeIn('slow');

	return false;
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/<?php echo $template; ?>/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
			$('#captcha').attr('src', 'index.php?route=product/product/captcha');
			$('input[name=\'captcha\']').val('');
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}

			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
$('.review-rating input:radio').wrap('<span></span>').parent()
	.on('mouseenter touchstart touchend', function() {
		$(this).css({
			'background': '#EAFBFF',
			'padding': '1px 0 5px 0',
			'border-radius': '9px',
			'outline': 'none',
			'cursor': 'pointer'
		});
	})
	.on('mouseleave', function() {
		$(this).css({
			'background': 'transparent'
		});
	});
});
//--></script>

<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/confirm/jquery-confirm.min.css" />

<script type="text/javascript" src="catalog/view/javascript/jquery/confirm/jquery-confirm.min.js"></script>

<script type="text/javascript"><!--
$('a.button-resource').confirm({
	title: '<?php echo $gdpr_resource; ?>',
	content: '<?php echo $dialog_resource; ?>',
	icon: 'fa fa-question-circle',
	theme: 'light',
	useBootstrap: false,
	boxWidth: 300,
	animation: 'zoom',
	closeAnimation: 'scale',
	opacity: 0.1,
	buttons: {
		ok: function() { }
	}
});
//--></script>

<?php echo $footer; ?>