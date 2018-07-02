<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="content-info">
  <h1><?php echo $heading_title; ?></h1>
    <?php if ($news_info) { ?>
      <div class="info">
      <?php if ($thumb) { ?>
        <div class="image">
        <?php if ($lightbox == 'colorbox') { ?>
          <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
        <?php } ?>
        <?php if ($lightbox == 'fancybox') { ?>
          <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="fancybox" rel="gallery"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
        <?php } ?>
        <?php if ($lightbox == 'magnific') { ?>
          <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="magnific"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
        <?php } ?>
        <?php if ($lightbox == 'viewbox') { ?>
          <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="viewbox"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
        <?php } ?>
        </div>
        <?php } ?>
        <div class="article">
          <?php echo $description; ?>
        </div>
      </div>
      <?php if ($news_addthis) { ?>
        <div style="margin:25px 0;">
          <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
            <a class="addthis_button_email"></a>
            <a class="addthis_button_print"></a>
            <a class="addthis_button_preferred_1"></a>
            <a class="addthis_button_preferred_2"></a>
            <a class="addthis_button_preferred_3"></a>
            <a class="addthis_button_preferred_4"></a>
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
      <?php if ($downloads) { ?>
        <div style="clear:left;"></div>
        <div class="box">
          <div class="box-heading"><?php echo $text_related_download; ?></div>
          <div class="box-content">
            <div class="news-download">
              <ul>
              <?php foreach ($downloads as $download) { ?>
                <li>
                  <a href="<?php echo $download['href']; ?>" class="button"><i class="fa fa-download"></i> &nbsp; <?php echo $button_download; ?></a> &nbsp; <strong><?php echo $download['name']; ?></strong> &nbsp; <?php echo $download['size']; ?> &nbsp; (<?php echo $download['date_added']; ?>)
                </li>
              <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if ($products) { ?>
        <div class="box">
          <div class="box-heading"><?php echo $text_related_product; ?></div>
          <div class="box-content">
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
                <div class="image">
                  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a>
                </div>
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
    </div>
    <div class="buttons">
      <div class="right">
        <a onclick="location='<?php echo $news; ?>'" class="button"><?php echo $button_news; ?></a>
        <a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a>
      </div>
    </div>
  <?php } else { ?>
    <div class="buttons">
      <div class="center"><?php echo $text_no_results; ?></div>
      <div class="right">
        <a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a>
      </div>
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
		opacity: 0.5,
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

<?php echo $footer; ?>