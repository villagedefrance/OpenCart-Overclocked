<?php if ($connection_exist) { ?>
<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
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
  <div style="margin-bottom:20px;">
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