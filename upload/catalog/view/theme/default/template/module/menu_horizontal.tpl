<div style="margin-bottom:10px;">
<?php if ($menu_horizontal) { ?>
  <div id="menu-holder" class="menu-<?php echo $menu_theme; ?>">
  <div id="menu">
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
  <div>
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
  <div id="menu-phone">
  <ul>
  <li><a href="<?php echo $home; ?>" title=""><span class="home-icon"></span></a></li>
  <?php foreach ($menu_horizontal as $category) { ?>
  <?php if ($category['href']) { ?>
  <li><a href="<?php echo $category['href']; ?>" title=""><?php echo $category['name']; ?></a></li>
  <?php if ($category['children']) { ?>
  <li>
  <ul>
  <?php foreach ($category['children'] as $children) { ?>
  <?php if ($children['href']) { ?>
  <li><a href="<?php echo $children['href']; ?>" title=""><?php echo $children['name']; ?></a></li>
  <?php } ?>
  <?php } ?>
  </ul>
  </li>
  <?php } ?>
  <?php } else { ?>
  <li><a title=""><?php echo $category['name']; ?></a></li>
  <?php if ($category['children']) { ?>
  <li>
  <ul>
  <?php foreach ($category['children'] as $children) { ?>
  <?php if ($children['href']) { ?>
  <li><a href="<?php echo $children['href']; ?>" title=""><?php echo $children['name']; ?></a></li>
  <?php } ?>
  <?php } ?>
  </ul>
  </li>
  <?php } ?>
  <?php } ?>
  <?php } ?>
  </ul>
  </div>
  </div>
<?php } ?>
</div>

<script type="text/javascript"><!--
$('#menu-holder').prepend('<div id="menu-trigger"><img src="catalog/view/theme/default/image/menu-button-<?php echo $menu_theme; ?>.png" alt="" style="padding:3px 15px;" /></div>');
$('#menu-trigger').live('click', function(e) {
  e.preventDefault();
  $('#menu-phone').slideToggle();
});
//--></script>