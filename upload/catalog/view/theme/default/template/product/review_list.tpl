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
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($reviews) { ?>
    <div class="product-filter">
      <div class="display"><img src="catalog/view/theme/<?php echo $template; ?>/image/page-list-active.png" alt="" /> <a onclick="display('grid');"><img src="catalog/view/theme/<?php echo $template; ?>/image/page-grid-off.png" alt="" /></a></div>
      <div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><i class="fa fa-random"></i><span class="hide-tablet"> &nbsp;<?php echo $text_compare; ?></span></a></div>
      <div class="limit"><?php echo $text_limit; ?>
        <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
          <?php if ($limits['value'] == $limit) { ?>
            <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
          <?php } else { ?>
            <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
          <?php } ?>
        <?php } ?>
        </select>
      </div>
      <div class="sort"><?php echo $text_sort; ?>
        <select onchange="location = this.value;">
        <?php foreach ($sorts as $sorts) { ?>
          <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
          <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
          <?php } ?>
        <?php } ?>
        </select>
      </div>
    </div>
    <div class="product-list">	
    <?php foreach ($reviews as $review) { ?>
      <div>
        <?php if ($review['thumb']) { ?>
          <?php if ($review['stock_label']) { ?>
            <div class="stock-medium"><img src="<?php echo $review['stock_label']; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$review['stock_label'] && $review['offer']) { ?>
            <div class="offer-medium"><img src="<?php echo $review['offer_label']; ?>" alt="" /></div>
          <?php } ?>
          <?php if (!$review['stock_label'] && !$review['offer'] && $review['special']) { ?>
            <div class="special-medium"><img src="<?php echo $review['special_label']; ?>" alt="" /></div>
          <?php } ?>
          <?php if ($review['label']) { ?>
            <div class="product-label">
              <img src="<?php echo $review['label']; ?>" alt="" height="<?php echo $review['label_style']; ?>" width="<?php echo $review['label_style']; ?>" style="margin:0 0 -<?php echo $review['label_style']; ?>px <?php echo ($review['label_style'] * 2); ?>px;" />
            </div>
          <?php } ?>
          <div class="image"><a href="<?php echo $review['href']; ?>"><img src="<?php echo $review['thumb']; ?>" alt="<?php echo $review['name']; ?>" /></a></div>
        <?php } ?>
      <?php if ($review['price'] && !$price_hide) { ?>
        <div class="price">
        <?php if ($review['price_option']) { ?>
          <span class="from"><?php echo $text_from; ?></span><br />
        <?php } ?>
        <?php if (!$review['special']) { ?>
          <?php echo $review['price']; ?>
        <?php } else { ?>
          <span class="price-old"><?php echo $review['price']; ?></span> <span class="price-new"><?php echo $review['special']; ?></span>
        <?php } ?>
        <?php if ($review['tax']) { ?>
          <br />
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $review['tax']; ?></span>
        <?php } ?>
        <?php if ($review['age_minimum']) { ?>
          <span class="help">(<?php echo $review['age_minimum']; ?>+)</span>
        <?php } ?>
        </div>
      <?php } ?>
        <div class="addons">
          <a onclick="addToWishList('<?php echo $review['product_id']; ?>');" title="<?php echo $button_wishlist; ?>" class="button-add"><i class="fa fa-heart"></i></a>
          <a onclick="addToCompare('<?php echo $review['product_id']; ?>');" title="<?php echo $button_compare; ?>" class="button-add"><i class="fa fa-random"></i></a>
          <a href="<?php echo $review['href']; ?>" title="<?php echo $button_view; ?>" class="button-add"><i class="fa fa-eye"></i></a>
        </div>
        <div class="cart">
        <?php if ($dob && $review['age_minimum'] && !$review['age_logged']) { ?>
          <a href="<?php echo $login_register; ?>" class="button"><?php echo $button_login; ?></a>
        <?php } elseif ($dob && $review['age_minimum'] && !$review['age_checked']) { ?>
          <p class="hidden"></p>
        <?php } else { ?>
          <?php if ($review['quote']) { ?>
            <a href="<?php echo $review['quote']; ?>" title="" class="button"><?php echo $button_quote; ?></a>
          <?php } elseif (!$review['quote'] && !$stock_checkout && $review['stock_quantity'] <= 0) { ?>
            <span class="stock-status"><?php echo $review['stock_status']; ?></span>
          <?php } elseif (!$review['quote'] && $stock_checkout && $review['stock_quantity'] <= 0) { ?>
            <input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" />
          <?php } else { ?>
            <input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $review['product_id']; ?>');" class="button" />
          <?php } ?>
        <?php } ?>
        </div>
        <div class="name">
          <a href="<?php echo $review['href']; ?>"><?php echo $review['name']; ?></a>
          <?php if ($review['age_minimum']) { ?>
            <span class="help">(<?php echo $review['age_minimum']; ?>+)</span>
          <?php } ?>
        </div>
        <div class="description">&#8220;<?php echo $review['text']; ?>&#8221;</div>
        <div class="author"><?php echo $review['author']; ?></div>
        <div class="date"><?php echo $review['date_added']; ?></div>
        <div class="rating">
          <img src="catalog/view/theme/<?php echo $template; ?>/image/stars-<?php echo $review['rating']; ?>.png" alt="<?php echo $review['reviews']; ?>" />
        </div>
        <?php if ($review['stock_remaining'] && $this->config->get($template . '_product_stock_low') && ($review['stock_quantity'] > 0) && ($review['stock_quantity'] <= $this->config->get($template . '_product_stock_limit'))) { ?>
          <div class="remaining"><?php echo $review['stock_remaining']; ?></div>
        <?php } ?>
      </div>
    <?php } ?>
    </div>
    <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
    <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

<script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');

		$('.product-list > div').each(function(index, element) {
			html = '<div>';

			var image = $(element).find('.image').html();

			if (image != null) {
				var stock = $(element).find('.stock-medium').html();

				if (stock != null) {
					html += '<div class="stock-medium">' + stock + '</div>';
				}

				var offer = $(element).find('.offer-medium').html();

				if (offer != null) {
					html += '<div class="offer-medium">' + offer + '</div>';
				}

				var special = $(element).find('.special-medium').html();

				if (special != null) {
					html += '<div class="special-medium">' + special + '</div>';
				}

				var label = $(element).find('.product-label').html();

				if (label != null) {
					html += '<div class="product-label">' + label + '</div>';
				}

				html += '<div class="image">' + image + '</div>';
			}

			var price = $(element).find('.price').html();

			if (price != null) {
				html += '<div class="price">' + price + '</div>';
			}

			html += '<div class="addons">' + $(element).find('.addons').html() + '</div>';
			html += '<div class="cart">' + $(element).find('.cart').html() + '</div>';
			
			html += '<div class="name">' + $(element).find('.name').html() + '</div>';

			var text = $(element).find('.description').html();

			html += '<div class="description">' + text + '</div>';

			var author = $(element).find('.author').html();

			if (author != null) {
				html += '<div class="author">' + author + '</div>';
			}

			var date = $(element).find('.date').html();

			if (date != null) {
				html += '<div class="date">' + date + '</div>';
			}

			var remaining = $(element).find('.remaining').html();

			if (remaining != null) {
				html += '<div class="remaining">' + remaining + '</div>';
			}

			var rating = $(element).find('.rating').html();

			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}

			html += '</div>';

			$(element).html(html);
		});

		$('.display').html('<img src="catalog/view/theme/<?php echo $template; ?>/image/page-list-active.png" alt="" /> <a onclick="display(\'grid\');"><img src="catalog/view/theme/<?php echo $template; ?>/image/page-grid-off.png" alt="" /></a>');

		localStorage.setItem('display', 'list');

	} else {
		$('.product-list').attr('class', 'product-grid');

		$('.product-grid > div').each(function(index, element) {
			html = '<div>';

			var image = $(element).find('.image').html();

			if (image != null) {
				var stock = $(element).find('.stock-medium').html();

				if (stock != null) {
					html += '<div class="stock-medium">' + stock + '</div>';
				}

				var offer = $(element).find('.offer-medium').html();

				if (offer != null) {
					html += '<div class="offer-medium">' + offer + '</div>';
				}

				var special = $(element).find('.special-medium').html();

				if (special != null) {
					html += '<div class="special-medium">' + special + '</div>';
				}

				var label = $(element).find('.product-label').html();

				if (label != null) {
					html += '<div class="product-label">' + label + '</div>';
				}

				html += '<div class="image">' + image + '</div>';
			}

			html += '<div class="name">' + $(element).find('.name').html() + '</div>';

			var text = $(element).find('.description').html();

			html += '<div class="description">' + text + '</div>';

			var author = $(element).find('.author').html();

			if (author != null) {
				html += '<div class="author">' + author  + '</div>';
			}

			var date = $(element).find('.date').html();

			if (date != null) {
				html += '<div class="date">' + date + '</div>';
			}

			var remaining = $(element).find('.remaining').html();

			if (remaining != null) {
				html += '<div class="remaining">' + remaining + '</div>';
			}

			var rating = $(element).find('.rating').html();

			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}

			var price = $(element).find('.price').html();

			if (price != null) {
				html += '<div class="price">' + price + '</div>';
			}

			html += '<div class="addons">' + $(element).find('.addons').html() + '</div>';
			html += '<div class="cart">' + $(element).find('.cart').html() + '</div>';

			html += '</div>';

			$(element).html(html);
		});

		$('.display').html('<a onclick="display(\'list\');"><img src="catalog/view/theme/<?php echo $template; ?>/image/page-list-off.png" alt="" /></a> <img src="catalog/view/theme/<?php echo $template; ?>/image/page-grid-active.png" alt="" /></a>');

		localStorage.setItem('display', 'grid');
	}
}

view = localStorage.getItem('display');

if (view) {
	display(view);
} else {
	display('list');
}
//--></script> 

<?php echo $footer; ?>