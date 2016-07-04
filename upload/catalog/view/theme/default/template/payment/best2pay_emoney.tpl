<form action="<?php echo $action; ?>" method="post">
  <input type="hidden" name="sector" value="<?php echo $sector; ?>" />
  <input type="hidden" name="id" value="<?php echo $id; ?>" />
  <input type="hidden" name="signature" value="<?php echo $signature; ?>" />
  <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
  <input type="hidden" name="lastname" value="<?php echo $lastname; ?>" />
  <input type="hidden" name="email" value="<?php echo $email; ?>" />

  <?php if ($commission_text) { echo '<p>' . $commission_text . '</p>'; } ?>
  
  <div class="buttons">
    <div class="right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="button" />
    </div>
  </div>
</form>