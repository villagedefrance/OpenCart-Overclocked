<form action="<?php echo $action; ?>" method="post">
  <input type="hidden" name="sector" value="<?php echo $sector; ?>" />
  <input type="hidden" name="id" value="<?php echo $id; ?>" />
  <input type="hidden" name="signature" value="<?php echo $signature; ?>" />

  <?php if ($commission_text) { echo '<p>' . $commission_text . '</p>'; } ?>
  
  <div class="buttons">
    <div class="right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="button" />
    </div>
  </div>
</form>