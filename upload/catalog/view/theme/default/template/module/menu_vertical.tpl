<?php if ($menu_vertical) { ?>
<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
  <div id="menu_vertical_<?php echo $module; ?>" class="box-category">
  <ul>
  <?php foreach ($menu_vertical as $category) { ?>
  <li id="<?php echo $category['item_id']; ?>">
  <?php if ($category['href']) { ?>
  <a href="<?php echo $category['href']; ?>" title="" class="inactive"><?php echo $category['name']; ?></a>
  <?php } else { ?>
  <a title="" class="inactive"><?php echo $category['name']; ?></a>
  <?php } ?>
  <?php if ($category['children']) { ?>
  <ul class="children">
  <?php foreach ($category['children'] as $child) { ?>
  <li>
  <?php if ($child['href']) { ?>
  <a href="<?php echo $child['href']; ?>" title=""><span class="inactive"><?php echo $child['name']; ?></span></a>
  <?php } else { ?>
  <a title=""><span class="inactive"><?php echo $child['name']; ?></span></a>
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
<div style="margin-bottom:20px;">
  <div id="menu_vertical_<?php echo $module; ?>" class="box-category">
  <ul>
  <?php foreach ($menu_vertical as $category) { ?>
  <li id="<?php echo $category['item_id']; ?>">
  <?php if ($category['href']) { ?>
  <a href="<?php echo $category['href']; ?>" title="" class="inactive"><?php echo $category['name']; ?></a>
  <?php } else { ?>
  <a title="" class="inactive"><?php echo $category['name']; ?></a>
  <?php } ?>
  <?php if ($category['children']) { ?>
  <ul class="children">
  <?php foreach ($category['children'] as $child) { ?>
  <li>
  <?php if ($child['href']) { ?>
  <a href="<?php echo $child['href']; ?>" title=""><span class="inactive"><?php echo $child['name']; ?></span></a>
  <?php } else { ?>
  <a title=""><span class="inactive"><?php echo $child['name']; ?></span></a>
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
<?php foreach ($menu_vertical as $category) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#<?php echo $category['item_id']; ?>').on('click', function() {
		$('#<?php echo $category['item_id']; ?> a').toggleClass('active');
	});
});
//--></script>
<?php } ?>
<?php } ?>