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
  <?php if ($categories) { ?>
    <p><b><?php echo $text_index; ?></b>
    <?php foreach ($categories as $category) { ?>
      &nbsp;&nbsp;&nbsp;<a href="index.php?route=product/manufacturer#<?php echo $category['name']; ?>"><b><?php echo $category['name']; ?></b></a>
    <?php } ?>
    </p>
    <?php foreach ($categories as $category) { ?>
      <div class="manufacturer-list">
        <div class="manufacturer-heading"><?php echo $category['name']; ?><a id="<?php echo $category['name']; ?>"></a></div>
        <div class="manufacturer-content">
          <?php if ($category['manufacturer']) { ?>
            <?php for ($i = 0; $i < count($category['manufacturer']);) { ?>
            <ul>
              <?php $j = $i + ceil(count($category['manufacturer']) / 4); ?>
              <?php for (; $i < $j; $i++) { ?>
                <?php if (isset($category['manufacturer'][$i]) && ($category['manufacturer'][$i]['status'])) { ?>
                  <?php if ($category['manufacturer'][$i]['image'] && $this->config->get($template . '_manufacturer_image')) { ?>
                    <li><a href="<?php echo $category['manufacturer'][$i]['href']; ?>" title="<?php echo $category['manufacturer'][$i]['name']; ?>"><img src="<?php echo $category['manufacturer'][$i]['image']; ?>" alt="" /></a></li>
                  <?php } else { ?>
                    <li><a href="<?php echo $category['manufacturer'][$i]['href']; ?>" title=""><?php echo $category['manufacturer'][$i]['name']; ?></a></li>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
            </ul>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
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