<?php if ($connection_exist) { ?>
<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading <?php echo $header_shape; ?> <?php echo $header_color; ?>"><?php echo $title; ?></div>
  <div class="box-content <?php echo $content_shape; ?> <?php echo $content_color; ?>">
    <div class="box-information">
      <ul>
      <?php foreach ($connections_li as $connection_li) { ?>
        <li><a onclick="window.open('<?php echo $connection_li['route']; ?>');" title=""><i class="fa <?php echo $connection_li['icon']; ?>"></i> &nbsp; <?php echo $connection_li['title']; ?></a></li>
      <?php } ?>
      </ul>
    </div>
  </div>
</div>
<?php } else { ?>
  <div class="<?php echo $content_shape; ?> <?php echo $content_color; ?>" style="margin-bottom:20px;">
    <div class="box-information">
      <ul>
      <?php foreach ($connections_li as $connection_li) { ?>
        <li><a onclick="window.open('<?php echo $connection_li['route']; ?>');" title=""><i class="fa <?php echo $connection_li['icon']; ?>"></i> &nbsp; <?php echo $connection_li['title']; ?></a></li>
      <?php } ?>
      </ul>
    </div>
  </div>
<?php } ?>
<?php } ?>