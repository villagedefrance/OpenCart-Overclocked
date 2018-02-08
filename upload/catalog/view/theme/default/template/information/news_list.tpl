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
  <?php if ($news_data) { ?>
    <div class="content">
    <?php foreach ($news_data as $news) { ?>
      <div class="panel-collapsed">
        <h3><?php echo $news['title']; ?><i class="fa"></i></h3>
        <div class="panel-content">
          <?php echo $news['description']; ?><br /><br />
          <i class="fa fa-calendar"></i> &nbsp; <?php echo $news['date_added']; ?> - <?php echo $news['viewed']; ?> <?php echo $text_views; ?><br /><br />
          <a href="<?php echo $news['href']; ?>" class="button"><i class="fa fa-mail-forward"></i> &nbsp; <?php echo $button_read; ?></a>
        </div>
      </div>
    <?php } ?>
    </div>
  <?php } else { ?>
    <div class="content"><?php echo $text_no_results; ?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>
<?php echo $footer; ?>