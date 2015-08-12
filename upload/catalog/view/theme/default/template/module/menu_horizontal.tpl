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
  <li><a<?php echo $i == (count($category['children']) - 1) ? " class='last-submenu-item'" : ''; ?> href="<?php echo $category['children'][$i]['href']; ?>" title=""><span><?php echo $category['children'][$i]['name']; ?></span></a></li>
  <?php } else { ?>
  <li><a<?php echo $i == (count($category['children']) - 1) ? " class='last-submenu-item'" : ''; ?> title=""><span><?php echo $category['children'][$i]['name']; ?></span></a></li>
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
  <li><a<?php echo $i == (count($category['children']) - 1) ? " class='last-submenu-item'" : ''; ?> href="<?php echo $category['children'][$i]['href']; ?>" title=""><span><?php echo $category['children'][$i]['name']; ?></span></a></li>
  <?php } else { ?>
  <li><a<?php echo $i == (count($category['children']) - 1) ? " class='last-submenu-item'" : ''; ?> title=""><span><?php echo $category['children'][$i]['name']; ?></span></a></li>
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
  </div>
  <div id="menu-phone">
  <div id="menu-phone-button"><img src="catalog/view/theme/default/image/menu-button-<?php echo $menu_theme; ?>.png" alt="" />
    <select id="menu-phone-select" name="phone-select" onchange="location=this.value">
      <?php foreach ($menu_horizontal as $category) { ?>
        <?php if ($category['href']) { ?>
          <option value="<?php echo $category['href']; ?>" title=""><?php echo $category['name']; ?></option>
          <?php if ($category['children']) { ?>
            <?php foreach ($category['children'] as $children) { ?>
              <?php if ($children['href']) { ?>
                <option value="<?php echo $children['href']; ?>" title=""> &#8226; <?php echo $children['name']; ?></option>
              <?php } ?>
            <?php } ?>
          <?php } ?>
        <?php } else { ?>
          <option value="" title=""><?php echo $category['name']; ?></option>
        <?php } ?>
      <?php } ?>
    </select>
  </div>
  </div>
<?php } ?>
<script type="text/javascript"><!--
$('#menu-phone-button').live('click', function(e) {
	e.preventDefault();
    $('#menu-phone-select').fadeIn(300);
});
//--></script>
</div>