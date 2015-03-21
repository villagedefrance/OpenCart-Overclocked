<?php echo $header; ?>
<h1>1<span style="font-size:16px;">/4</span> - <?php echo $heading_step_1; ?></h1>
<div id="column-right">
  <ul>
    <li><b><?php echo $text_license; ?></b></li>
    <li><?php echo $text_installation; ?></li>
    <li><?php echo $text_configuration; ?></li>
    <li><?php echo $text_finished; ?></li>
  </ul>
</div>
<div id="content">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<div class="terms">
      <?php echo $text_terms; ?>
    </div>
	<div class="buttons">
      <div class="right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
	</div>
</form>
</div>
<?php echo $footer; ?>