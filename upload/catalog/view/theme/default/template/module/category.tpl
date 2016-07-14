<?php if ($categories) { ?>
<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading <?php echo $header_shape; ?> <?php echo $header_color; ?>"><?php echo $title; ?></div>
  <div class="box-content <?php echo $content_shape; ?> <?php echo $content_color; ?>">
  <div class="box-category">
  <ul>
  <?php foreach ($categories as $category) { ?>
  <li>
  <?php if ($category['category_id'] == $category_id) { ?>
  <a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
  <?php } else { ?>
  <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
  <?php } ?>
  <?php if ($category['children']) { ?>
  <ul>
  <?php foreach ($category['children'] as $child) { ?>
  <li>
  <?php if ($child['category_id'] == $child_id) { ?>
  <a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
  <?php } else { ?>
  <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
  <?php } ?>
  </li>
  <?php } ?>
  </ul>
  <?php } ?>
  </li>
  <?php } ?>
  </ul>
  </div>
  </div>
</div>
<?php } else { ?>
<div class="<?php echo $content_shape; ?> <?php echo $content_color; ?>" style="margin-bottom:20px;">
  <div class="box-category">
  <ul>
  <?php foreach ($categories as $category) { ?>
  <li>
  <?php if ($category['category_id'] == $category_id) { ?>
  <a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
  <?php } else { ?>
  <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
  <?php } ?>
  <?php if ($category['children']) { ?>
  <ul>
  <?php foreach ($category['children'] as $child) { ?>
  <li>
  <?php if ($child['category_id'] == $child_id) { ?>
  <a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
  <?php } else { ?>
  <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
  <?php } ?>
  </li>
  <?php } ?>
  </ul>
  <?php } ?>
  </li>
  <?php } ?>
  </ul>
  </div>
</div>
<?php } ?>
<?php } ?>