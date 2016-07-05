<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading <?php echo $header_shape; ?>-top <?php echo $header_color; ?>-skin"><?php echo $title; ?></div>
  <div class="box-content <?php echo $content_shape; ?>-bottom <?php echo $content_color; ?>-skin" style="text-align:center;">
    <select name="manufacturer" onchange="location=this.value">
      <option value="0"><?php echo $text_select; ?></option>
      <?php foreach ($manufacturers as $manufacturer) { ?>
        <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
          <option value="<?php echo $manufacturer['href']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
        <?php } else { ?>
          <option value="<?php echo $manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></option>
        <?php } ?>
      <?php } ?>
    </select>
  </div>
</div>
<?php } else { ?>
  <div class="<?php echo $content_shape; ?> <?php echo $content_color; ?>-skin" style="margin-bottom:20px; text-align:center; padding:12px 0px;">
    <select name="manufacturer" onchange="location=this.value">
      <option value="0"><?php echo $text_select; ?></option>
      <?php foreach ($manufacturers as $manufacturer) { ?>
        <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
          <option value="<?php echo $manufacturer['href']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
        <?php } else { ?>
          <option value="<?php echo $manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></option>
        <?php } ?>
      <?php } ?>
    </select>
  </div>
<?php } ?>