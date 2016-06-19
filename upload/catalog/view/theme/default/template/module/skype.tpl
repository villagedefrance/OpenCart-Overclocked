<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading <?php echo $header_shape; ?>-top <?php echo $header_color; ?>-skin"><?php echo $title; ?></div>
  <div class="box-content <?php echo $content_shape; ?>-bottom <?php echo $content_color; ?>-skin" style="text-align:center;">
    <script type="text/javascript" src="http://www.skypeassets.com/i/scom/js/skype-uri.js"></script>
    <div id="SkypeButton_Call_<?php echo $skypename; ?>_1">
      <script type="text/javascript"><!--
       Skype.ui({
        "name": "<?php echo $mode; ?>",
        "element": "SkypeButton_Call_<?php echo $skypename; ?>_1",
        "participants": ["<?php echo $skypename; ?>"],
        "imageSize": 32
      });
      //--></script>
    </div>
  </div>
</div>
<?php } else { ?>
  <div class="<?php echo $content_shape; ?> <?php echo $content_color; ?>-skin" style="margin-bottom:20px; text-align:center;">
    <script type="text/javascript" src="http://www.skypeassets.com/i/scom/js/skype-uri.js"></script>
    <div id="SkypeButton_Call_<?php echo $skypename; ?>_1">
      <script type="text/javascript"><!--
       Skype.ui({
        "name": "<?php echo $mode; ?>",
        "element": "SkypeButton_Call_<?php echo $skypename; ?>_1",
        "participants": ["<?php echo $skypename; ?>"],
        "imageSize": 32
      });
      //--></script>
    </div>
  </div>
<?php } ?>