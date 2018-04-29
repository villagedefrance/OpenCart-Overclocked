<?php if (!$logged) { ?>
<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
    <div style="text-align:left; padding:10px 5px;">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="module-account">
        <p>
          <?php echo $entry_email_address; ?><br />
          <input type="text" name="email" /><br />
          <br />
          <?php echo $entry_password; ?><br />
          <input type="password" name="password" /><br />
        </p>
        <p style="text-align:center;">
          <a onclick="$('#module-account').submit();" class="button"><i class="fa fa-sign-in"></i> &nbsp; <?php echo $button_login; ?></a>
        </p>
      </form>
      <div style="margin-top:15px; text-align:center;">
        <div><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>
        <div><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></div>
      </div>
    </div>
  </div>
</div>
<?php } else { ?>
<div style="margin-bottom:20px;">
  <div>
    <div style="text-align:left; padding:10px;">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="module-account">
        <p>
          <?php echo $entry_email_address; ?><br />
          <input type="text" name="email" /><br />
          <br />
          <?php echo $entry_password; ?><br />
          <input type="password" name="password" /><br />
        </p>
        <p style="text-align:center;">
          <a onclick="$('#module-account').submit();" class="button"><i class="fa fa-sign-in"></i> &nbsp; <?php echo $button_login; ?></a>
        </p>
      </form>
      <div style="margin-top:15px; text-align:center;">
        <div><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>
        <div><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php } ?>
<?php if ($logged && $mode != 0) { ?>
<?php if ($theme) { ?>
<div class="box">
  <div class="box-heading"><?php echo $title; ?></div>
  <div class="box-content">
    <?php if ($mode == 2) { ?>
      <div class="box-information">
        <ul>
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
          <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
          <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
          <?php if ($reward) { ?>
          <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
          <?php } ?>
          <?php if ($allow_return) { ?>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $addreturn; ?>"><?php echo $text_addreturn; ?></a></li>
          <?php } ?>
          <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
          <?php if ($profile_exist) { ?>
          <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
          <?php } ?>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>
      <div style="text-align:center; padding:10px 0;">
        <a href="<?php echo $logout; ?>" class="button"><i class="fa fa-sign-out"></i> &nbsp; <?php echo $button_logout; ?></a>
      </div>
    <?php } ?>
    <?php if ($mode == 1) { ?>
      <div style="text-align:center; padding:10px 0;">
        <a href="<?php echo $logout; ?>" class="button"><i class="fa fa-sign-out"></i> &nbsp; <?php echo $button_logout; ?></a>
      </div>
    <?php } ?>
  </div>
</div>
<?php } else { ?>
<div style="margin-bottom:20px;">
  <div>
    <?php if ($mode == 2) { ?>
      <div class="box-information">
        <ul>
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
          <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
          <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
          <?php if ($reward) { ?>
          <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
          <?php } ?>
          <?php if ($allow_return) { ?>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $addreturn; ?>"><?php echo $text_addreturn; ?></a></li>
          <?php } ?>
          <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
          <?php if ($profile_exist) { ?>
          <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
          <?php } ?>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>
      <div style="text-align:center; padding:10px 0;">
        <a href="<?php echo $logout; ?>" class="button"><i class="fa fa-sign-out"></i> &nbsp; <?php echo $button_logout; ?></a>
      </div>
    <?php } ?>
    <?php if ($mode == 1) { ?>
      <div style="text-align:center; padding:10px 0;">
        <a href="<?php echo $logout; ?>" class="button"><i class="fa fa-sign-out"></i> &nbsp; <?php echo $button_logout; ?></a>
      </div>
    <?php } ?>
  </div>
</div>
<?php } ?>
<?php } ?>

<script type="text/javascript"><!--
$('#module-account input').keydown(function(e) {
	if (e.keyCode == 13) { $('#module-account').submit(); }
});
//--></script>
