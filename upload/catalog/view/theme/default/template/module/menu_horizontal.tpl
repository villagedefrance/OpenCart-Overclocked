<div style="margin-bottom:10px;">
<?php if ($menu_horizontal) { ?>
  <div id="menu-holder" class="<?php echo $menu_class; ?>">
  <div id="menu" class="<?php echo $mod_shape; ?> <?php echo $mod_color; ?>">
  <ul>
  <?php if ($menu_home) { ?>
  <li><a href="<?php echo $home; ?>" title=""><span class="home-icon"></span></a></li>
  <?php } ?>
  <?php foreach ($menu_horizontal as $category) { ?>
  <?php if ($category['href']) { ?>
  <li><a href="<?php echo $category['href']; ?>" title=""><?php echo $category['name']; ?><?php if ($category['children']) { ?><span></span><?php } ?></a>
  <?php } else { ?>
  <li><a title=""><?php echo $category['name']; ?><?php if ($category['children']) { ?><span></span><?php } ?></a>
  <?php } ?>
  <?php if ($category['children']) { ?>
  <div class="<?php echo $mod_shape; ?>-bottom <?php echo $mod_color; ?>">
  <?php if (count($category['children']) <= $column_limit) { ?>
  <?php for ($i = 0; $i < count($category['children']);) { ?>
  <ul>
  <?php $j = $i + ceil(count($category['children'])); ?>
  <?php for (; $i < $j; $i++) { ?>
  <?php if (isset($category['children'][$i])) { ?>
  <?php if ($category['children'][$i]['href']) { ?>
  <li><a <?php echo $i == (count($category['children']) - 1) ? " class='last-submenu-item'" : ''; ?> href="<?php echo $category['children'][$i]['href']; ?>" title=""><span><?php echo $category['children'][$i]['name']; ?></span></a></li>
  <?php } else { ?>
  <li><a <?php echo $i == (count($category['children']) - 1) ? " class='last-submenu-item'" : ''; ?> title=""><span><?php echo $category['children'][$i]['name']; ?></span></a></li>
  <?php } ?>
  <?php } ?>
  <?php } ?>
  </ul>
  <?php } ?>
  <?php } else { ?>
  <?php for ($i = 0; $i < count($category['children']);) { ?>
  <ul>
  <?php $j = $i + ceil(count($category['children']) / $column_number); ?>
  <?php for (; $i < $j; $i++) { ?>
  <?php if (isset($category['children'][$i])) { ?>
  <?php if ($category['children'][$i]['href']) { ?>
  <li><a <?php echo $i == (count($category['children']) - 1) ? " class='last-submenu-item'" : ''; ?> href="<?php echo $category['children'][$i]['href']; ?>" title=""><span><?php echo $category['children'][$i]['name']; ?></span></a></li>
  <?php } else { ?>
  <li><a <?php echo $i == (count($category['children']) - 1) ? " class='last-submenu-item'" : ''; ?> title=""><span><?php echo $category['children'][$i]['name']; ?></span></a></li>
  <?php } ?>
  <?php } ?>
  <?php } ?>
  </ul>
  <?php } ?>
  <?php } ?>
  </div>
  <?php } ?>
  </li>
  <?php } ?>
  </ul>
  </div>
  <!-- Menu Phone -->
  <div id="menu-phone" class="box-phone">
  <ul>
  <?php foreach ($menu_horizontal as $category) { ?>
  <li id="menu-horizontal-<?php echo $category['item_id']; ?>">
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
</div>

<script type="text/javascript"><!--
$('#menu-holder').prepend('<div id="menu-trigger" class="<?php echo $mod_shape; ?> <?php echo $mod_color; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/menu/menu-button-<?php echo ($menu_theme == 'light') ? 'dark' : 'light'; ?>.png" alt="" style="padding:3px 15px;" /></div>');
$('body').on('click', '#menu-trigger', function(e) {
	e.preventDefault();
	$('#menu-phone').slideToggle();
});
//--></script>

<?php foreach ($menu_horizontal as $category) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#menu-horizontal-<?php echo $category['item_id']; ?>').on('click', function() {
		$('#menu-horizontal-<?php echo $category['item_id']; ?> a').toggleClass('active');
	});
});
//--></script>
<?php } ?>
