<?php echo $header; ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <div class="content-info">
    <div class="info">
      <?php if ($image) { ?>
        <div class="image">
          <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
        </div>
      <?php } ?>
      <?php echo $description; ?>
    </div>
    <?php if ($news_addthis) { ?>
      <div style="margin:25px 0px;">
        <div class="addthis_toolbox addthis_default_style">
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
  </div>
  <div class="buttons">
    <div class="right">
      <a onclick="location='<?php echo $news; ?>'" class="button"><?php echo $button_news; ?></a>
      <a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a>
    </div>
  </div>
  <?php echo $content_bottom; ?>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.5,
		rel: "colorbox"
	});
});
//--></script>

<?php echo $footer; ?>