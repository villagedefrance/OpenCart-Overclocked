<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <div class="sitemap-info">
    <div class="left">
    <?php if ($categories) { ?>
      <ul>
      <?php foreach ($categories as $category_1) { ?>
        <li><a href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></a>
        <?php if ($category_1['children']) { ?>
          <ul>
          <?php foreach ($category_1['children'] as $category_2) { ?>
            <li><a href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?></a>
            <?php if ($category_2['children']) { ?>
              <ul>
              <?php foreach ($category_2['children'] as $category_3) { ?>
                <li><a href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?></a></li>
              <?php } ?>
              </ul>
            <?php } ?>
            </li>
          <?php } ?>
          </ul>
        <?php } ?>
        </li>
      <?php } ?>
      </ul>
    <?php } ?>
    </div>
    <div class="right">
      <ul>
        <li><a href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a></li>
        <li class="last-line"><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
        <li><a href="<?php echo $product_list; ?>"><?php echo $text_product_list; ?></a></li>
        <li><a href="<?php echo $product_wall; ?>"><?php echo $text_product_wall; ?></a></li>
        <li><a href="<?php echo $category_list; ?>"><?php echo $text_category_list; ?></a></li>
        <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
        <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
        <li><a href="<?php echo $review_list; ?>"><?php echo $text_review_list; ?></a></li>
        <li class="last-line"><a href="<?php echo $search; ?>"><?php echo $text_search; ?></a></li>
        <li class="last-line"><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
        <?php if ($sitemap_links) { ?>
          <ul>
            <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
            <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
            <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
            <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
            <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
            <li><a href="<?php echo $history; ?>"><?php echo $text_history; ?></a></li>
            <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
            <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
            <?php if ($allow_return) { ?>
            <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
            <li><a href="<?php echo $addreturn; ?>"><?php echo $text_addreturn; ?></a></li>
            <?php } ?>
            <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
            <li><a href="<?php echo $giftvoucher; ?>"><?php echo $text_giftvoucher; ?></a></li>
            <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
          </ul>
        <?php } ?>
        </li>
        <?php if ($allow_affiliate) { ?>
        <li class="last-line"><a href="<?php echo $affiliate_account; ?>"><?php echo $text_affiliate_account; ?></a>
        <?php if ($sitemap_links) { ?>
          <ul>
            <li><a href="<?php echo $affiliate_login; ?>"><?php echo $text_affiliate_login; ?></a></li>
            <li><a href="<?php echo $affiliate_edit; ?>"><?php echo $text_affiliate_edit; ?></a></li>
            <li><a href="<?php echo $affiliate_password; ?>"><?php echo $text_affiliate_password; ?></a></li>
            <li><a href="<?php echo $affiliate_payment; ?>"><?php echo $text_affiliate_payment; ?></a></li>
            <li><a href="<?php echo $affiliate_product; ?>"><?php echo $text_affiliate_product; ?></a></li>
            <li><a href="<?php echo $affiliate_tracking; ?>"><?php echo $text_affiliate_tracking; ?></a></li>
            <li><a href="<?php echo $affiliate_transaction; ?>"><?php echo $text_affiliate_transaction; ?></a></li>
          </ul>
        <?php } ?>
        </li>
        <?php } ?>
        <li class="last-line"><a href="<?php echo $sitemap; ?>"><?php echo $text_information; ?></a>
        <?php if ($informations) { ?>
          <ul>
          <?php foreach ($informations as $information) { ?>
            <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
          </ul>
        <?php } ?>
        </li>
        <li class="last-line"><a href="<?php echo $news; ?>"><?php echo $text_news; ?></a></li>
        <li class="last-line"><a href="<?php echo $quote; ?>"><?php echo $text_quote; ?></a></li>
        <li class="last-line"><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
      </ul>
    </div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>
<?php echo $footer; ?>