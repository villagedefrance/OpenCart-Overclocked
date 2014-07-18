<?php echo $header; ?>
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <h2><?php echo $text_my_account; ?></h2>
  <div class="content">
    <div class="box-information">
      <ul>
        <li><a href="<?php echo $edit; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/account.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_edit; ?></span></a></li>
        <li><a href="<?php echo $password; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/password.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_password; ?></span></a></li>
        <li><a href="<?php echo $address; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/address.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_address; ?></span></a></li>
        <li><a href="<?php echo $wishlist; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/wishlist.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_wishlist; ?></span></a></li>
      </ul>
    </div>
  </div>
  <h2><?php echo $text_my_orders; ?></h2>
  <div class="content">
    <div class="box-information">
      <ul>
        <li><a href="<?php echo $order; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/order.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_order; ?></span></a></li>
        <li><a href="<?php echo $download; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/download.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_download; ?></span></a></li>
        <?php if ($reward) { ?>
          <li><a href="<?php echo $reward; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/reward.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_reward; ?></span></a></li>
        <?php } ?>
        <li><a href="<?php echo $return; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/return.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_return; ?></span></a></li>
        <li><a href="<?php echo $addreturn; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/addreturn.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_addreturn; ?></span></a></li>
        <li><a href="<?php echo $transaction; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/transaction.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_transaction; ?></span></a></li>
        <li><a href="<?php echo $recurring; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/recurring.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_recurring; ?></span></a></li>
      </ul>
    </div>
  </div>
  <h2><?php echo $text_my_newsletter; ?></h2>
  <div class="content">
    <div class="box-information">
      <ul>
        <li><a href="<?php echo $newsletter; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/newsletter.png" alt="" /><span style="padding-left:20px; font-size:15px;"><?php echo $text_newsletter; ?></span></a></li>
      </ul>
    </div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?> 