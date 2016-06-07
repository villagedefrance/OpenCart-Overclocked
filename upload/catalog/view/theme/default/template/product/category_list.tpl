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
  <?php if ($categories) { ?>
  <h1><?php echo $heading_title; ?></h1>
  <div class="tier-page">
    <div class="left">
      <?php foreach ($categories as $category_1) { ?>
        <?php if ($category_1['count'] <= $cattotal1) { ?>
          <ul>
            <li class="head"><a href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></a></li>
          </ul>
          <?php if ($category_1['children']) { ?>
            <ul>
            <?php foreach ($category_1['children'] as $category_2) { ?>
              <li><a href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?></a>
              <?php if ($category_2['children']) { ?>
                <ul>
                <?php foreach ($category_2['children'] as $category_3) { ?>
                  <li><a href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?></a></li>
                <?php } ?>
                </ul>
              <?php } ?>
              </li>
            <?php } ?>
            </ul>
          <?php } ?>
        <?php } ?>
      <?php } ?>
    </div>
    <div class="middle">
      <?php foreach ($categories as $category_1) { ?>
        <?php if ($category_1['count'] > $cattotal1 && $category_1['count'] <= $cattotal2) { ?>
          <ul>
            <li class="head"><a href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></a></li>
          </ul>
          <?php if ($category_1['children']) { ?>
            <ul>
            <?php foreach ($category_1['children'] as $category_2) { ?>
              <li><a href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?></a>
              <?php if ($category_2['children']) { ?>
                <ul>
                <?php foreach ($category_2['children'] as $category_3) { ?>
                  <li><a href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?></a></li>
                <?php } ?>
                </ul>
              <?php } ?>
              </li>
            <?php } ?>
            </ul>
          <?php } ?>
        <?php } ?>
      <?php } ?>
    </div>
    <div class="right">
      <?php foreach ($categories as $category_1) { ?>
        <?php if ($category_1['count'] > $cattotal2) { ?>
          <ul>
            <li class="head"><a href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></a></li>
          </ul>
          <?php if ($category_1['children']) { ?>
            <ul>
            <?php foreach ($category_1['children'] as $category_2) { ?>
              <li><a href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?></a>
              <?php if ($category_2['children']) { ?>
                <ul>
                <?php foreach ($category_2['children'] as $category_3) { ?>
                  <li><a href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?></a></li>
                <?php } ?>
                </ul>
              <?php } ?>
              </li>
            <?php } ?>
            </ul>
          <?php } ?>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
  <?php } else { ?>
    <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>
<?php echo $footer; ?>