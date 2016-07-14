<?php if ($news) { ?>
<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading <?php echo $header_shape; ?> <?php echo $header_color; ?>"><?php echo $title; ?></div>
  <div class="box-content <?php echo $content_shape; ?> <?php echo $content_color; ?>">
    <?php foreach ($news as $news_story) { ?>
      <div class="box-news">
        <h4><?php echo $news_story['title']; ?></h4>
        <?php if ($news_story['image']) { ?>
          <a href="<?php echo $news_story['href']; ?>"><img src="<?php echo $news_story['image']; ?>" alt="<?php echo $news_story['title']; ?>" /></a>
        <?php } ?>
        <?php echo $news_story['description']; ?>
        <a href="<?php echo $news_story['href']; ?>" class="read"><?php echo $text_more; ?></a>
        <span><?php echo $news_story['posted']; ?></span>
      </div>
    <?php } ?>
    <?php if ($show_button) { ?>
      <div style="text-align:center;">
        <a href="<?php echo $news_list; ?>" class="button"><?php echo $button_list; ?></a>
      </div>
    <?php } ?>
  </div>
</div>
<?php } else { ?>
<div class="<?php echo $content_shape; ?> <?php echo $content_color; ?>" style="margin-bottom:20px;">
  <?php foreach ($news as $news_story) { ?>
    <div class="box-news">
      <h4><?php echo $news_story['title']; ?></h4>
      <?php if ($news_story['image']) { ?>
        <a href="<?php echo $news_story['href']; ?>"><img src="<?php echo $news_story['image']; ?>" alt="<?php echo $news_story['title']; ?>" /></a>
      <?php } ?>
      <?php echo $news_story['description']; ?>
      <a href="<?php echo $news_story['href']; ?>" class="read"><?php echo $text_more; ?></a>
      <span><?php echo $news_story['posted']; ?></span>
    </div>
  <?php } ?>
  <?php if ($show_button) { ?>
    <div style="text-align:center;">
      <a href="<?php echo $news_list; ?>" class="button"><?php echo $button_list; ?></a>
    </div>
  <?php } ?>
</div>
<?php } ?>
<?php } ?>