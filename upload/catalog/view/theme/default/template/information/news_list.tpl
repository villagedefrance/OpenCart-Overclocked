<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get('default_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($news_data) { ?>
    <div class="product-filter">
      <div class="display"><img src="catalog/view/theme/<?php echo $template; ?>/image/page-list-active.png" alt="" /> <a onclick="display('grid');"><img src="catalog/view/theme/<?php echo $template; ?>/image/page-grid-off.png" alt="" /></a></div>
      <div class="limit"><?php echo $text_limit; ?>
        <select onchange="location=this.value;">
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
        <select onchange="location=this.value;">
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
    <br />
    <div class="product-list">
      <?php foreach ($news_data as $news) { ?>
        <div>
          <div class="right">
            <div class="read"><a href="<?php echo $news['href']; ?>" class="button"><?php echo $button_read; ?></a></div>
          </div>
          <?php if ($news['image']) { ?>
            <div class="image"><a href="<?php echo $news['href']; ?>"><img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>" /></a></div>
          <?php } ?>
          <div class="title"><a href="<?php echo $news['href']; ?>" style="text-decoration:none;"><?php echo $news['title']; ?></a></div>
          <div class="description"><?php echo $news['description']; ?></div>
          <div class="date"><?php echo $news['date_added']; ?> - <?php echo $news['viewed']; ?> <?php echo $text_views; ?></div>
        </div>
      <?php } ?>
    </div>
    <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
    <div class="content"><?php echo $text_no_results; ?></div>
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
			html  = '<div class="right">';

			var read = $(element).find('.read').html();

			if (read != null) {
				html += '<div class="read">' + read + '</div>';
			}

			html += '</div>';
			html += '<div class="left">';

			var image = $(element).find('.image').html();

			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}

			html += '<div class="title">' + $(element).find('.title').html() + '</div>';

			var description = $(element).find('.description').html();

			html += '<div class="description">' + description + '</div>';

			var date = $(element).find('.date').html();

			if (date != null) {
				html += '<div class="date" style="font-size:10px;">' + date + '</div>';
			}

			html += '</div>';

			$(element).html(html);
		});

		$('.display').html('<img src="catalog/view/theme/<?php echo $template; ?>/image/page-list-active.png" alt="" /> <a onclick="display(\'grid\');"><img src="catalog/view/theme/<?php echo $template; ?>/image/page-grid-off.png" alt="" /></a>');

		$.totalStorage('display', 'list');

	} else {
		$('.product-list').attr('class', 'product-grid');

		$('.product-grid > div').each(function(index, element) {
			html = '';

			var image = $(element).find('.image').html();

			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}

			html += '<div class="title">' + $(element).find('.title').html() + '</div>';

			var description = $(element).find('.description').html();

			html += '<div class="description">' + description + '</div>';

			var date = $(element).find('.date').html();

			if (date != null) {
				html += '<div class="date" style="font-size:10px;">' + date + '</div>';
			}

			var read = $(element).find('.read').html();

			if (read != null) {
				html += '<div class="read" style="text-align:center;">' + read + '</div>';
			}

			$(element).html(html);
		});

		$('.display').html('<a onclick="display(\'list\');"><img src="catalog/view/theme/<?php echo $template; ?>/image/page-list-off.png" alt="" /></a> <img src="catalog/view/theme/<?php echo $template; ?>/image/page-grid-active.png" alt="" /></a>');

		$.totalStorage('display', 'grid');
	}
}

view = $.totalStorage('display');

if (view) {
	display(view);
} else {
	display('list');
}
//--></script>

<?php echo $footer; ?>