<?php if ($notifications) { ?>
  <li id="admin-notification" class="right hide-tablet"><a class="top"><?php echo $text_notification; ?> &nbsp; <span class="admin-notify" style="background-color:#5DC15E;"><?php echo $alerts_complete; ?></span> <span class="admin-notify" style="background-color:#F2B155;"><?php echo $alerts_attention; ?></span> <span class="admin-notify" style="background-color:#DE5954;"><?php echo $alerts_warning; ?></span></a>
    <ul class="inner">
    <?php if ($notification_order) { ?>
      <li><a href="<?php echo $order; ?>" style="font-weight:bold; font-size:14px;"><?php echo ($icons) ? '<i class="fa fa-shopping-cart"></i>' : ''; ?><?php echo $text_order; ?></a></li>
    <?php } ?>
    <?php if ($notification_pending) { ?>
      <li><a href="<?php echo $pending_status; ?>"><span class="admin-notify-li" style="background-color:#F2B155;"><?php echo $pending_status_total; ?></span> &nbsp;<?php echo $text_pending_status; ?></a></li>
    <?php } ?>
    <?php if ($notification_complete) { ?>
      <li><a href="<?php echo $complete_status; ?>"><span class="admin-notify-li" style="background-color:#5DC15E;"><?php echo $complete_status_total; ?></span> &nbsp;<?php echo $text_complete_status; ?></a></li>
    <?php } ?>
    <?php if ($allow_return && $notification_return) { ?>
      <li><a href="<?php echo $return; ?>"><span class="admin-notify-li" style="background-color:#DE5954;"><?php echo $return_total; ?></span> &nbsp;<?php echo $text_return; ?></a></li>
    <?php } ?>
    <?php if ($notification_customer) { ?>
      <li><a href="<?php echo $customer; ?>" style="font-weight:bold; font-size:14px;"><?php echo ($icons) ? '<i class="fa fa-user"></i>' : ''; ?><?php echo $text_customer; ?></a></li>
    <?php } ?>
    <?php if ($allow_online && $notification_online) { ?>
      <li><a href="<?php echo $online; ?>"><span class="admin-notify-li" style="background-color:#5DC15E;"><?php echo $online_total; ?></span> &nbsp;<?php echo $text_online; ?></a></li>
    <?php } ?>
    <?php if ($notification_deleted) { ?>
      <li><a href="<?php echo $deleted; ?>"><span class="admin-notify-li" style="background-color:#F2B155;"><?php echo $deleted_total; ?></span> &nbsp;<?php echo $text_deleted; ?></a></li>
    <?php } ?>
    <?php if ($notification_approval) { ?>
      <li><a href="<?php echo $customer_approval; ?>"><span class="admin-notify-li" style="background-color:#DE5954;"><?php echo $customer_total; ?></span> &nbsp;<?php echo $text_approval; ?></a></li>
    <?php } ?>
    <?php if ($notification_product) { ?>
      <li><a href="<?php echo $product; ?>" style="font-weight:bold; font-size:14px;"><?php echo ($icons) ? '<i class="fa fa-cube"></i>' : ''; ?><?php echo $text_product; ?></a></li>
    <?php } ?>
    <?php if ($notification_stock) { ?>
      <li><a href="<?php echo $product_outstock; ?>"><span class="admin-notify-li" style="background-color:#DE5954;"><?php echo $product_total; ?></span> &nbsp;<?php echo $text_stock; ?></a></li>
    <?php } ?>
    <?php if ($notification_low) { ?>
      <li><a href="<?php echo $product_lowstock; ?>"><span class="admin-notify-li" style="background-color:#F2B155;"><?php echo $product_total_low; ?></span> &nbsp;<?php echo $text_low_stock; ?></a></li>
    <?php } ?>
    <?php if ($allow_review && $notification_review) { ?>
      <li><a href="<?php echo $review; ?>"><span class="admin-notify-li" style="background-color:#F2B155;"><?php echo $review_total; ?></span> &nbsp;<?php echo $text_review; ?></a></li>
    <?php } ?>
    <?php if ($allow_affiliate && $notification_affiliate) { ?>
      <li><a href="<?php echo $affiliate; ?>" style="font-weight:bold; font-size:14px;"><?php echo ($icons) ? '<i class="fa fa-street-view"></i>' : ''; ?><?php echo $text_affiliate; ?></a></li>
      <li><a href="<?php echo $affiliate_approval; ?>"><span class="admin-notify-li" style="background-color:#DE5954;"><?php echo $affiliate_total; ?></span> &nbsp;<?php echo $text_approval; ?></a></li>
    <?php } ?>
    </ul>
  </li>
<?php } ?>