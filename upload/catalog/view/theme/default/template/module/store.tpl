<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content" style="text-align:center;">
    <div style="padding-bottom:5px;"><?php echo $text_selector; ?></div>
    <select name="store" onchange="location=this.value">
      <?php foreach ($stores as $store) { ?>
        <?php if ($store['store_id'] == $store_id) { ?>
          <option value="<?php echo $store['url']; ?>" selected="selected"><?php echo $store['name']; ?></option>
        <?php } else { ?>
          <option value="<?php echo $store['url']; ?>"><?php echo $store['name']; ?></option>
        <?php } ?>
      <?php } ?>
    </select>
    <?php if ($access) { ?>
      <div style="padding-top:10px;"><a href="admin/index.php?route=common/login" class="button"><?php echo $button_adminlogin; ?></a></div>
    <?php } ?>
  </div>
</div>
<?php } else { ?>
  <div style="margin-bottom:20px; text-align:center; padding-bottom:12px;">
    <div style="padding:5px;"><?php echo $text_selector; ?></div>
    <select name="store" onchange="location=this.value">
      <?php foreach ($stores as $store) { ?>
        <?php if ($store['store_id'] == $store_id) { ?>
          <option value="<?php echo $store['url']; ?>" selected="selected"><?php echo $store['name']; ?></option>
        <?php } else { ?>
          <option value="<?php echo $store['url']; ?>"><?php echo $store['name']; ?></option>
        <?php } ?>
      <?php } ?>
    </select>
    <?php if ($access) { ?>
      <div style="padding-top:10px;"><a href="admin/index.php?route=common/login" class="button"><?php echo $button_adminlogin; ?></a></div>
    <?php } ?>
  </div>
<?php } ?>