<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="icon" type="image/png" href="favicon.png" />
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet_<?php echo $admin_css; ?>.css" />
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/start/jquery-ui-1.12.1.min.css" />
<link rel="stylesheet" type="text/css" href="view/javascript/awesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/confirm/jquery-confirm.min.css" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/animate-custom.min.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="view/javascript/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery-migrate-1.4.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery-migrate-3.0.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.12.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/minified/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/tabs.min.js"></script>
<script type="text/javascript" src="view/javascript/common.min.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if lt IE 9]>
<script type="text/javascript" src="view/javascript/html5shiv.min.js"></script>
<![endif]-->
</head>
<body>
<div id="container-<?php echo $resolution; ?>">
  <div id="header">
    <div class="static">
      <div class="image"><img src="view/image/theme-<?php echo $admin_css; ?>/logo.png" alt="" title="<?php echo $heading_title; ?>" onclick="location = '<?php echo $home; ?>'" /></div>
      <?php if ($logged) { ?>
        <div class="user-logout"><a href="<?php echo $logout; ?>" title="<?php echo $text_logout; ?>"><i class="fa fa-power-off"></i></a></div>
      <?php } ?>
      <div id="user-device"><a title=""><i class="<?php echo $device; ?>"></i></a>
        <div id="show-device" style="display:none;">
          <div class="device">
            <?php echo $agent_platform; ?><br />
            <?php echo $agent_browser; ?> &nbsp; <?php echo $agent_version; ?><br />
            <span id="screen-width"></span> x <span id="screen-height"></span><br />
          </div>
        </div>
      </div>
      <div id="date-time"><a title=""><i class="fa fa-calendar-check-o"></i></a>
        <div id="show-time" style="display:none;">
          <div class="sysdate"><?php echo $date_format; ?></div><br />
          <div class="systime"><span id="hour"></span> : <span id="minute"></span> : <span id="second"></span></div>
        </div>
      </div>
      <?php if ($logged) { ?>
        <div id="store-selector">
          <a onclick="window.open('<?php echo $store; ?>');" title="<?php echo $text_front; ?>"><i class="fa fa-opencart"></i></a>
          <?php if ($stores) { ?>
            <div id="show-store" style="display:none;">
              <a onclick="window.open('<?php echo $store; ?>');" title=""><?php echo $text_front; ?></a>
              <?php foreach ($stores as $store) { ?>
                <?php $store_href = $store['href']; ?>
                <a onclick="window.open('<?php echo $store_href; ?>');" title=""><?php echo $store['name']; ?></a>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
        <div class="user-status"><a href="<?php echo $user_profile; ?>" title="<?php echo $username; ?>"><img src="<?php echo $avatar; ?>" alt="<?php echo $username; ?>" /></a></div>
      <?php } ?>
    </div>
    <?php if ($logged) { ?>
    <div>
    <ul class="menu">
      <li id="dashboard" style="margin-left:5px;"><a href="<?php echo $home; ?>" title=""><?php echo $text_dashboard; ?></a></li>
      <li id="catalog"><a class="top"><?php echo $text_catalog; ?></a>
        <ul>
          <li><a href="<?php echo $category; ?>"><?php echo ($icons) ? '<i class="fa fa-sitemap"></i>' : ''; ?><?php echo $text_category; ?></a></li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-cubes"></i>' : ''; ?><?php echo $text_product; ?></a>
            <ul>
              <li><a href="<?php echo $product; ?>"><?php echo ($icons) ? '<i class="fa fa-cube"></i>' : ''; ?><?php echo $text_product; ?></a></li>
              <li><a href="<?php echo $manufacturer; ?>"><?php echo ($icons) ? '<i class="fa fa-gear"></i>' : ''; ?><?php echo $text_manufacturer; ?></a></li>
              <li><a href="<?php echo $download; ?>"><?php echo ($icons) ? '<i class="fa fa-download"></i>' : ''; ?><?php echo $text_download; ?></a></li>
              <li><a href="<?php echo $review; ?>"><?php echo ($icons) ? '<i class="fa fa-comments"></i>' : ''; ?><?php echo $text_review; ?></a></li>
              <li><a href="<?php echo $field; ?>"><?php echo ($icons) ? '<i class="fa fa-list-ul"></i>' : ''; ?><?php echo $text_field; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-columns"></i>' : ''; ?><?php echo $text_attribute; ?></a>
            <ul>
              <li><a href="<?php echo $attribute; ?>"><?php echo ($icons) ? '<i class="fa fa-columns"></i>' : ''; ?><?php echo $text_attribute; ?></a></li>
              <li><a href="<?php echo $attribute_group; ?>"><?php echo ($icons) ? '<i class="fa fa-wrench"></i>' : ''; ?><?php echo $text_attribute_group; ?></a></li>
            </ul>
          </li>
          <li><a href="<?php echo $option; ?>"><?php echo ($icons) ? '<i class="fa fa-clone"></i>' : ''; ?><?php echo $text_option; ?></a></li>
          <li><a href="<?php echo $filter; ?>"><?php echo ($icons) ? '<i class="fa fa-filter"></i>' : ''; ?><?php echo $text_filter; ?></a></li>
          <li><a href="<?php echo $profile; ?>"><?php echo ($icons) ? '<i class="fa fa-exchange"></i>' : ''; ?><?php echo $text_profile; ?></a></li>
          <li><a href="<?php echo $palette; ?>"><?php echo ($icons) ? '<i class="fa fa-paint-brush"></i>' : ''; ?><?php echo $text_palette; ?></a></li>
          <li><a href="<?php echo $news; ?>"><?php echo ($icons) ? '<i class="fa fa-pencil"></i>' : ''; ?><?php echo $text_news; ?></a></li>
          <li><a href="<?php echo $information; ?>"><?php echo ($icons) ? '<i class="fa fa-info-circle"></i>' : ''; ?><?php echo $text_information; ?></a></li>
        </ul>
      </li>
      <li id="sale"><a class="top"><?php echo $text_sale; ?></a>
        <ul>
          <li><a href="<?php echo $order; ?>"><?php echo ($icons) ? '<i class="fa fa-shopping-cart"></i>' : ''; ?><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo ($icons) ? '<i class="fa fa-history"></i>' : ''; ?><?php echo $text_return; ?></a></li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-user"></i>' : ''; ?><?php echo $text_customer; ?></a>
            <ul>
              <li><a href="<?php echo $customer; ?>"><?php echo ($icons) ? '<i class="fa fa-user"></i>' : ''; ?><?php echo $text_customer; ?></a></li>
              <li><a href="<?php echo $customer_group; ?>"><?php echo ($icons) ? '<i class="fa fa-group"></i>' : ''; ?><?php echo $text_customer_group; ?></a></li>
              <li><a href="<?php echo $customer_ban_ip; ?>"><?php echo ($icons) ? '<i class="fa fa-ban"></i>' : ''; ?><?php echo $text_customer_ban_ip; ?></a></li>
            </ul>
          </li>
          <?php if ($profile_exist) { ?>
          <li><a href="<?php echo $recurring_profile; ?>"><?php echo ($icons) ? '<i class="fa fa-refresh"></i>' : ''; ?><?php echo $text_recurring_profile; ?></a></li>
          <?php } ?>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-gear"></i>' : ''; ?><?php echo $text_supplier; ?></a>
            <ul>
              <li><a href="<?php echo $supplier; ?>"><?php echo ($icons) ? '<i class="fa fa-gear"></i>' : ''; ?><?php echo $text_supplier; ?></a></li>
              <li><a href="<?php echo $supplier_group; ?>"><?php echo ($icons) ? '<i class="fa fa-gears"></i>' : ''; ?><?php echo $text_supplier_group; ?></a></li>
              <li><a href="<?php echo $supplier_product; ?>"><?php echo ($icons) ? '<i class="fa fa-cubes"></i>' : ''; ?><?php echo $text_supplier_product; ?></a></li>
            </ul>
          </li>
          <?php if ($allow_affiliate) { ?>
          <li><a href="<?php echo $affiliate; ?>"><?php echo ($icons) ? '<i class="fa fa-street-view"></i>' : ''; ?><?php echo $text_affiliate; ?></a></li>
          <?php } ?>
          <li><a href="<?php echo $coupon; ?>"><?php echo ($icons) ? '<i class="fa fa-tags"></i>' : ''; ?><?php echo $text_coupon; ?></a></li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-percent"></i>' : ''; ?><?php echo $text_offer; ?></a>
            <ul>
              <li><a href="<?php echo $offer; ?>"><?php echo ($icons) ? '<i class="fa fa-percent"></i>' : ''; ?><?php echo $text_offer_dashboard; ?></a></li>
              <li><a href="<?php echo $offer_product_product; ?>"><?php echo ($icons) ? '<i class="fa fa-dot-circle-o"></i>' : ''; ?><?php echo $text_offer_product_product; ?></a></li>
              <li><a href="<?php echo $offer_product_category; ?>"><?php echo ($icons) ? '<i class="fa fa-dot-circle-o"></i>' : ''; ?><?php echo $text_offer_product_category; ?></a></li>
              <li><a href="<?php echo $offer_category_product; ?>"><?php echo ($icons) ? '<i class="fa fa-dot-circle-o"></i>' : ''; ?><?php echo $text_offer_category_product; ?></a></li>
              <li><a href="<?php echo $offer_category_category; ?>"><?php echo ($icons) ? '<i class="fa fa-dot-circle-o"></i>' : ''; ?><?php echo $text_offer_category_category; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-ticket"></i>' : ''; ?><?php echo $text_voucher; ?></a>
            <ul>
              <li><a href="<?php echo $voucher; ?>"><?php echo ($icons) ? '<i class="fa fa-ticket"></i>' : ''; ?><?php echo $text_voucher; ?></a></li>
              <li><a href="<?php echo $voucher_theme; ?>"><?php echo ($icons) ? '<i class="fa fa-image"></i>' : ''; ?><?php echo $text_voucher_theme; ?></a></li>
            </ul>
          </li>
          <?php if ($pp_express_status) { ?>
          <li><a class="arrow" href="<?php echo $paypal_express; ?>"><?php echo ($icons) ? '<i class="fa fa-paypal"></i>' : ''; ?><?php echo $text_paypal_express; ?></a>
            <ul>
              <li><a href="<?php echo $paypal_express_search; ?>"><?php echo ($icons) ? '<i class="fa fa-search"></i>' : ''; ?><?php echo $text_paypal_express_search; ?></a></li>
            </ul>
          </li>
          <?php } ?>
          <li><a href="<?php echo $upload; ?>"><?php echo ($icons) ? '<i class="fa fa-upload"></i>' : ''; ?><?php echo $text_upload; ?></a></li>
        </ul>
      </li>
      <li id="reports"><a class="top"><?php echo $text_reports; ?></a>
        <ul>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-shopping-cart"></i>' : ''; ?><?php echo $text_sale; ?></a>
            <ul>
              <li><a href="<?php echo $report_sale_order; ?>"><?php echo ($icons) ? '<i class="fa fa-shopping-basket"></i>' : ''; ?><?php echo $text_report_sale_order; ?></a></li>
              <li><a href="<?php echo $report_sale_profit; ?>"><?php echo ($icons) ? '<i class="fa fa-line-chart"></i>' : ''; ?><?php echo $text_report_sale_profit; ?></a></li>
              <li><a href="<?php echo $report_sale_tax; ?>"><?php echo ($icons) ? '<i class="fa fa-briefcase"></i>' : ''; ?><?php echo $text_report_sale_tax; ?></a></li>
              <li><a href="<?php echo $report_sale_shipping; ?>"><?php echo ($icons) ? '<i class="fa fa-truck"></i>' : ''; ?><?php echo $text_report_sale_shipping; ?></a></li>
              <li><a href="<?php echo $report_sale_return; ?>"><?php echo ($icons) ? '<i class="fa fa-history"></i>' : ''; ?><?php echo $text_report_sale_return; ?></a></li>
              <li><a href="<?php echo $report_sale_coupon; ?>"><?php echo ($icons) ? '<i class="fa fa-tags"></i>' : ''; ?><?php echo $text_report_sale_coupon; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-cube"></i>' : ''; ?><?php echo $text_product; ?></a>
            <ul>
              <li><a href="<?php echo $report_product_viewed; ?>"><?php echo ($icons) ? '<i class="fa fa-eye"></i>' : ''; ?><?php echo $text_report_product_viewed; ?></a></li>
              <li><a href="<?php echo $report_product_label; ?>"><?php echo ($icons) ? '<i class="fa fa-leaf"></i>' : ''; ?><?php echo $text_report_product_label; ?></a></li>
              <li><a href="<?php echo $report_product_quantity; ?>"><?php echo ($icons) ? '<i class="fa fa-cubes"></i>' : ''; ?><?php echo $text_report_product_quantity; ?></a></li>
              <li><a href="<?php echo $report_product_markup; ?>"><?php echo ($icons) ? '<i class="fa fa-bar-chart"></i>' : ''; ?><?php echo $text_report_product_markup; ?></a></li>
              <li><a href="<?php echo $report_product_purchased; ?>"><?php echo ($icons) ? '<i class="fa fa-dollar"></i>' : ''; ?><?php echo $text_report_product_purchased; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-user"></i>' : ''; ?><?php echo $text_customer; ?></a>
            <ul>
              <li><a href="<?php echo $report_customer_order; ?>"><?php echo ($icons) ? '<i class="fa fa-shopping-bag"></i>' : ''; ?><?php echo $text_report_customer_order; ?></a></li>
              <li><a href="<?php echo $report_customer_reward; ?>"><?php echo ($icons) ? '<i class="fa fa-gift"></i>' : ''; ?><?php echo $text_report_customer_reward; ?></a></li>
              <li><a href="<?php echo $report_customer_credit; ?>"><?php echo ($icons) ? '<i class="fa fa-money"></i>' : ''; ?><?php echo $text_report_customer_credit; ?></a></li>
              <li><a href="<?php echo $report_customer_country; ?>"><?php echo ($icons) ? '<i class="fa fa-globe"></i>' : ''; ?><?php echo $text_report_customer_country; ?></a></li>
              <li><a href="<?php echo $report_customer_deleted; ?>"><?php echo ($icons) ? '<i class="fa fa-eraser"></i>' : ''; ?><?php echo $text_report_customer_deleted; ?></a></li>
              <li><a href="<?php echo $report_customer_online; ?>"><?php echo ($icons) ? '<i class="fa fa-feed"></i>' : ''; ?><?php echo $text_report_customer_online; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-street-view"></i>' : ''; ?><?php echo $text_affiliate; ?></a>
            <ul>
              <li><a href="<?php echo $report_affiliate_activity; ?>"><?php echo ($icons) ? '<i class="fa fa-spinner"></i>' : ''; ?><?php echo $text_report_affiliate_activity; ?></a></li>
              <li><a href="<?php echo $report_affiliate_commission; ?>"><?php echo ($icons) ? '<i class="fa fa-percent"></i>' : ''; ?><?php echo $text_report_affiliate_commission; ?></a></li>
            </ul>
          </li>
        <?php if ($track_robots) { ?>
          <li><a href="<?php echo $report_robot_online; ?>"><?php echo ($icons) ? '<i class="fa fa-wifi"></i>' : ''; ?><?php echo $text_report_robot_online; ?></a></li>
        <?php } ?>
        </ul>
      </li>
      <li id="tools"><a class="top"><?php echo $text_tool; ?></a>
        <ul>
          <?php if ($openbay_show_menu == 1) { ?>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-desktop"></i>' : ''; ?><?php echo $text_openbay_extension; ?></a>
            <ul>
              <li><a href="<?php echo $openbay_link_extension; ?>"><?php echo ($icons) ? '<i class="fa fa-dashboard"></i>' : ''; ?><?php echo $text_openbay_dashboard; ?></a></li>
              <li><a href="<?php echo $openbay_link_orders; ?>"><?php echo ($icons) ? '<i class="fa fa-first-order"></i>' : ''; ?><?php echo $text_openbay_orders; ?></a></li>
              <li><a href="<?php echo $openbay_link_items; ?>"><?php echo ($icons) ? '<i class="fa fa-folder"></i>' : ''; ?><?php echo $text_openbay_items; ?></a></li>
              <?php if ($openbay_markets['ebay'] == 1) { ?>
              <li><a class="arrow" href="<?php echo $openbay_link_ebay; ?>"><?php echo ($icons) ? '<i class="fa fa-folder-open"></i>' : ''; ?><?php echo $text_openbay_ebay; ?></a>
                <ul>
                  <li><a href="<?php echo $openbay_link_ebay_settings; ?>"><?php echo ($icons) ? '<i class="fa fa-gears"></i>' : ''; ?><?php echo $text_openbay_settings; ?></a></li>
                  <li><a href="<?php echo $openbay_link_ebay_links; ?>"><?php echo ($icons) ? '<i class="fa fa-chain"></i>' : ''; ?><?php echo $text_openbay_links; ?></a></li>
                  <li><a href="<?php echo $openbay_link_ebay_orderimport; ?>"><?php echo ($icons) ? '<i class="fa fa-upload"></i>' : ''; ?><?php echo $text_openbay_order_import; ?></a></li>
                </ul>
              </li>
              <?php } ?>
              <?php if ($openbay_markets['amazon'] == 1) { ?>
              <li><a class="arrow" href="<?php echo $openbay_link_amazon; ?>"><?php echo ($icons) ? '<i class="fa fa-amazon"></i>' : ''; ?><?php echo $text_openbay_amazon; ?></a>
                <ul>
                  <li><a href="<?php echo $openbay_link_amazon_settings; ?>"><?php echo ($icons) ? '<i class="fa fa-gears"></i>' : ''; ?><?php echo $text_openbay_settings; ?></a></li>
                  <li><a href="<?php echo $openbay_link_amazon_links; ?>"><?php echo ($icons) ? '<i class="fa fa-chain"></i>' : ''; ?><?php echo $text_openbay_links; ?></a></li>
                </ul>
              </li>
              <?php } ?>
              <?php if ($openbay_markets['amazonus'] == 1) { ?>
              <li><a class="arrow" href="<?php echo $openbay_link_amazonus; ?>"><?php echo ($icons) ? '<i class="fa fa-amazon"></i>' : ''; ?><?php echo $text_openbay_amazonus; ?></a>
                <ul>
                  <li><a href="<?php echo $openbay_link_amazonus_settings; ?>"><?php echo ($icons) ? '<i class="fa fa-gears"></i>' : ''; ?><?php echo $text_openbay_settings; ?></a></li>
                  <li><a href="<?php echo $openbay_link_amazonus_links; ?>"><?php echo ($icons) ? '<i class="fa fa-chain"></i>' : ''; ?><?php echo $text_openbay_links; ?></a></li>
                </ul>
              </li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-compress"></i>' : ''; ?><?php echo $text_export_import; ?></a>
            <ul>
              <li><a href="<?php echo $export_import_tool; ?>"><?php echo ($icons) ? '<i class="fa fa-file-excel-o"></i>' : ''; ?><?php echo $text_export_import_tool; ?></a></li>
              <li><a href="<?php echo $export_import_raw; ?>"><?php echo ($icons) ? '<i class="fa fa-file-code-o"></i>' : ''; ?><?php echo $text_export_import_raw; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-files-o"></i>' : ''; ?><?php echo $text_cache_manager; ?></a>
            <ul>
              <li><a href="<?php echo $cache_files; ?>"><?php echo ($icons) ? '<i class="fa fa-file-text-o"></i>' : ''; ?><?php echo $text_cache_files; ?></a></li>
              <li><a href="<?php echo $cache_images; ?>"><?php echo ($icons) ? '<i class="fa fa-file-photo-o"></i>' : ''; ?><?php echo $text_cache_images; ?></a></li>
            </ul>
          </li>
          <li><a href="<?php echo $seo_url_manager; ?>"><?php echo ($icons) ? '<i class="fa fa-tint"></i>' : ''; ?><?php echo $text_seo_url_manager; ?></a></li>
          <li><a href="<?php echo $api_key_manager; ?>"><?php echo ($icons) ? '<i class="fa fa-key"></i>' : ''; ?><?php echo $text_api_key_manager; ?></a></li>
          <li><a href="<?php echo $file_manager; ?>"><?php echo ($icons) ? '<i class="fa fa-image"></i>' : ''; ?><?php echo $text_file_manager; ?></a></li>
          <li><a href="<?php echo $contact; ?>"><?php echo ($icons) ? '<i class="fa fa-mail-forward"></i>' : ''; ?><?php echo $text_contact; ?></a></li>
        </ul>
      </li>
      <li id="extension"><a class="top"><?php echo $text_extension; ?></a>
        <ul>
          <li><a href="<?php echo $module; ?>"><?php echo ($icons) ? '<i class="fa fa-puzzle-piece"></i>' : ''; ?><?php echo $text_module; ?></a></li>
          <li><a href="<?php echo $modification; ?>"><?php echo ($icons) ? '<i class="fa fa-terminal"></i>' : ''; ?><?php echo $text_modification; ?></a></li>
          <li><a href="<?php echo $payment; ?>"><?php echo ($icons) ? '<i class="fa fa-credit-card"></i>' : ''; ?><?php echo $text_payment; ?></a></li>
          <li><a href="<?php echo $shipping; ?>"><?php echo ($icons) ? '<i class="fa fa-truck"></i>' : ''; ?><?php echo $text_shipping; ?></a></li>
          <li><a href="<?php echo $theme; ?>"><?php echo ($icons) ? '<i class="fa fa-magic"></i>' : ''; ?><?php echo $text_theme; ?></a></li>
          <li><a href="<?php echo $total; ?>"><?php echo ($icons) ? '<i class="fa fa-calculator"></i>' : ''; ?><?php echo $text_total; ?></a></li>
          <li><a href="<?php echo $fraud; ?>"><?php echo ($icons) ? '<i class="fa fa-shield"></i>' : ''; ?><?php echo $text_fraud; ?></a></li>
          <li><a href="<?php echo $feed; ?>"><?php echo ($icons) ? '<i class="fa fa-feed"></i>' : ''; ?><?php echo $text_feed; ?></a></li>
        </ul>
      </li>
      <li id="system"><a class="top"><?php echo $text_system; ?></a>
        <ul>
          <li><a href="<?php echo $setting; ?>"><?php echo ($icons) ? '<i class="fa fa-gears"></i>' : ''; ?><?php echo $text_setting; ?></a></li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-paint-brush"></i>' : ''; ?><?php echo $text_design; ?></a>
            <ul>
              <li><a href="<?php echo $administration; ?>"><?php echo ($icons) ? '<i class="fa fa-magic"></i>' : ''; ?><?php echo $text_administration; ?></a></li>
              <li><a href="<?php echo $banner; ?>"><?php echo ($icons) ? '<i class="fa fa-photo"></i>' : ''; ?><?php echo $text_banner; ?></a></li>
              <li><a href="<?php echo $media; ?>"><?php echo ($icons) ? '<i class="fa fa-video-camera"></i>' : ''; ?><?php echo $text_media; ?></a></li>
              <li><a href="<?php echo $footer; ?>"><?php echo ($icons) ? '<i class="fa fa-hashtag"></i>' : ''; ?><?php echo $text_footer; ?></a></li>
              <li><a href="<?php echo $layout; ?>"><?php echo ($icons) ? '<i class="fa fa-tasks"></i>' : ''; ?><?php echo $text_layout; ?></a></li>
              <li><a href="<?php echo $connection; ?>"><?php echo ($icons) ? '<i class="fa fa-chain"></i>' : ''; ?><?php echo $text_connection; ?></a></li>
              <li><a href="<?php echo $menu_manager; ?>"><?php echo ($icons) ? '<i class="fa fa-reorder"></i>' : ''; ?><?php echo $text_menu_manager; ?></a></li>
              <li><a href="<?php echo $payment_image; ?>"><?php echo ($icons) ? '<i class="fa fa-money"></i>' : ''; ?><?php echo $text_payment_image; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-user"></i>' : ''; ?><?php echo $text_users; ?></a>
            <ul>
              <li><a href="<?php echo $user; ?>"><?php echo ($icons) ? '<i class="fa fa-user"></i>' : ''; ?><?php echo $text_user; ?></a></li>
              <li><a href="<?php echo $user_group; ?>"><?php echo ($icons) ? '<i class="fa fa-group"></i>' : ''; ?><?php echo $text_user_group; ?></a></li>
              <li><a href="<?php echo $user_log; ?>"><?php echo ($icons) ? '<i class="fa fa-user-secret"></i>' : ''; ?><?php echo $text_user_log; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-map-marker"></i>' : ''; ?><?php echo $text_localisation; ?></a>
            <ul>
              <li><a href="<?php echo $language; ?>"><?php echo ($icons) ? '<i class="fa fa-language"></i>' : ''; ?><?php echo $text_language; ?></a></li>
              <li><a href="<?php echo $currency; ?>"><?php echo ($icons) ? '<i class="fa fa-money"></i>' : ''; ?><?php echo $text_currency; ?></a></li>
              <li><a href="<?php echo $location; ?>"><?php echo ($icons) ? '<i class="fa fa-map-marker"></i>' : ''; ?><?php echo $text_location; ?></a></li>
              <li><a href="<?php echo $stock_status; ?>"><?php echo ($icons) ? '<i class="fa fa-adjust"></i>' : ''; ?><?php echo $text_stock_status; ?></a></li>
              <li><a href="<?php echo $order_status; ?>"><?php echo ($icons) ? '<i class="fa fa-random"></i>' : ''; ?><?php echo $text_order_status; ?></a></li>
              <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-history"></i>' : ''; ?><?php echo $text_return; ?></a>
                <ul>
                  <li><a href="<?php echo $return_status; ?>"><?php echo ($icons) ? '<i class="fa fa-history"></i>' : ''; ?><?php echo $text_return_status; ?></a></li>
                  <li><a href="<?php echo $return_action; ?>"><?php echo ($icons) ? '<i class="fa fa-play"></i>' : ''; ?><?php echo $text_return_action; ?></a></li>
                  <li><a href="<?php echo $return_reason; ?>"><?php echo ($icons) ? '<i class="fa fa-question-circle"></i>' : ''; ?><?php echo $text_return_reason; ?></a></li>
                </ul>
              </li>
              <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-briefcase"></i>' : ''; ?><?php echo $text_tax; ?></a>
                <ul>
                  <li><a href="<?php echo $tax_class; ?>"><?php echo ($icons) ? '<i class="fa fa-briefcase"></i>' : ''; ?><?php echo $text_tax_class; ?></a></li>
                  <li><a href="<?php echo $tax_rate; ?>"><?php echo ($icons) ? '<i class="fa fa-percent"></i>' : ''; ?><?php echo $text_tax_rate; ?></a></li>
                  <li><a href="<?php echo $tax_local_rate; ?>"><?php echo ($icons) ? '<i class="fa fa-home"></i>' : ''; ?><?php echo $text_tax_local_rate; ?></a></li>
                </ul>
              </li>
              <li><a href="<?php echo $country; ?>"><?php echo ($icons) ? '<i class="fa fa-globe"></i>' : ''; ?><?php echo $text_country; ?></a></li>
              <li><a href="<?php echo $zone; ?>"><?php echo ($icons) ? '<i class="fa fa-map-pin"></i>' : ''; ?><?php echo $text_zone; ?></a></li>
              <li><a href="<?php echo $geo_zone; ?>"><?php echo ($icons) ? '<i class="fa fa-map-signs"></i>' : ''; ?><?php echo $text_geo_zone; ?></a></li>
              <li><a href="<?php echo $length_class; ?>"><?php echo ($icons) ? '<i class="fa fa-road"></i>' : ''; ?><?php echo $text_length_class; ?></a></li>
              <li><a href="<?php echo $weight_class; ?>"><?php echo ($icons) ? '<i class="fa fa-balance-scale"></i>' : ''; ?><?php echo $text_weight_class; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-server"></i>' : ''; ?><?php echo $text_server; ?></a>
            <ul>
              <li><a href="<?php echo $configuration; ?>"><?php echo ($icons) ? '<i class="fa fa-sliders"></i>' : ''; ?><?php echo $text_configuration; ?></a></li>
              <li><a href="<?php echo $database; ?>"><?php echo ($icons) ? '<i class="fa fa-database"></i>' : ''; ?><?php echo $text_database; ?></a></li>
              <li><a href="<?php echo $sitemap; ?>"><?php echo ($icons) ? '<i class="fa fa-sitemap"></i>' : ''; ?><?php echo $text_sitemap; ?></a></li>
              <li><a href="<?php echo $block_ip; ?>"><?php echo ($icons) ? '<i class="fa fa-ban"></i>' : ''; ?><?php echo $text_block_ip; ?></a></li>
              <li><a href="<?php echo $backup; ?>"><?php echo ($icons) ? '<i class="fa fa-hdd-o"></i>' : ''; ?><?php echo $text_backup; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-exclamation-circle"></i>' : ''; ?><?php echo $text_logs; ?></a>
            <ul>
              <li><a href="<?php echo $error_log; ?>"><?php echo ($icons) ? '<i class="fa fa-warning"></i>' : ''; ?><?php echo $text_error_log; ?></a></li>
              <li><a href="<?php echo $email_log; ?>"><?php echo ($icons) ? '<i class="fa fa-envelope"></i>' : ''; ?><?php echo $text_email_log; ?></a></li>
              <li><a href="<?php echo $quote_log; ?>"><?php echo ($icons) ? '<i class="fa fa-quote-left"></i>' : ''; ?><?php echo $text_quote_log; ?></a></li>
              <li><a href="<?php echo $user_log; ?>"><?php echo ($icons) ? '<i class="fa fa-user-secret"></i>' : ''; ?><?php echo $text_user_log; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-support"></i>' : ''; ?><?php echo $text_help; ?></a>
            <ul>
              <li><a onclick="window.open('https://villagedefrance.net');" title=""><?php echo ($icons) ? '<i class="fa fa-home"></i>' : ''; ?><?php echo $text_opencart_overclocked; ?></a></li>
              <li><a onclick="window.open('http://forum.villagedefrance.net');" title=""><?php echo ($icons) ? '<i class="fa fa-heart"></i>' : ''; ?><?php echo $text_forum; ?></a></li>
              <li><a onclick="window.open('https://www.opencart.com');" title=""><?php echo ($icons) ? '<i class="fa fa-opencart"></i>' : ''; ?><?php echo $text_opencart; ?></a></li>
              <li><a onclick="window.open('https://forum.opencart.com');" title=""><?php echo ($icons) ? '<i class="fa fa-support"></i>' : ''; ?><?php echo $text_support; ?></a></li>
              <li><a onclick="window.open('http://docs.opencart.com/');" title=""><?php echo ($icons) ? '<i class="fa fa-book"></i>' : ''; ?><?php echo $text_documentation; ?></a></li>
            </ul>
          </li>
        </ul>
      </li>
      <?php if ($connection_exist) { ?>
      <li id="connection"><a class="top"><?php echo $text_connection; ?></a>
        <ul>
        <?php foreach ($connections_ul as $connection_ul) { ?>
          <li><a class="arrow"><?php echo ($icons) ? '<i class="fa fa-arrow-right"></i>' : ''; ?><?php echo $connection_ul['name']; ?></a>
            <ul>
            <?php foreach ($connections_li as $connection_li) { ?>
              <?php if ($connection_li['parent_id'] == $connection_ul['connection_id']) { ?>
                <?php if ($connection_li['route']) { ?>
                  <?php if ($icons && isset($connection_li['icon'])) { ?>
                    <li><a onclick="window.open('<?php echo $connection_li['route']; ?>');" title=""><i class="fa <?php echo $connection_li['icon']; ?>"></i><?php echo $connection_li['title']; ?></a></li>
                  <?php } else { ?>
                    <li><a onclick="window.open('<?php echo $connection_li['route']; ?>');" title=""><?php echo $connection_li['title']; ?></a></li>
                  <?php } ?>
                <?php } else { ?>
                  <?php if ($icons && isset($connection_li['icon'])) { ?>
                    <li><a title=""><i class="fa <?php echo $connection_li['icon']; ?>"></i><?php echo $connection_li['title']; ?></a></li>
                  <?php } else { ?>
                    <li><a title=""><?php echo $connection_li['title']; ?></a></li>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
            <?php } ?>
            </ul>
          </li>
        <?php } ?>
        </ul>
      </li>
      <?php } ?>
      <?php if ($logged && $notifications) { ?>
        <?php echo $notification; ?>
      <?php } ?>
    </ul>
  </div>
  <?php } ?>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#store-selector').hover(function() {
		$('#show-store').show(150);
	}, function() {
		$('#show-store').hide(150);
	});

	$('#date-time').hover(function() {
		$('#show-time').show(150);
	}, function() {
		$('#show-time').hide(150);
	});

	$('#user-device').hover(function() {
		$('#show-device').show(150);
	}, function() {
		$('#show-device').hide(150);
	});
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	if (typeof(document.documentElement.clientWidth) != 'undefined') {
		var $w = document.getElementById('screen-width');
		var $h = document.getElementById('screen-height');

		$w.innerHTML = document.documentElement.clientWidth;
		$h.innerHTML = document.documentElement.clientHeight;

		window.onresize = function(event) {
			$w.innerHTML = document.documentElement.clientWidth;
			$h.innerHTML = document.documentElement.clientHeight;
		};
	}
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	function time() {
		var now = new Date();
		var offset = <?php echo $time_offset; ?>;

		var outHour = now.getHours()+offset;
		if (outHour < 10) { 
			document.getElementById('hour').innerHTML = "0"+outHour;
		} else {
			document.getElementById('hour').innerHTML = outHour;
		}

		var outMin = now.getMinutes();
		if (outMin < 10) {
			document.getElementById('minute').innerHTML = "0"+outMin;
		} else {
			document.getElementById('minute').innerHTML = outMin;
		}

		var outSec = now.getSeconds();
		if (outSec < 10) {
			document.getElementById('second').innerHTML = "0"+outSec;
		} else {
			document.getElementById('second').innerHTML = outSec;
		}
	}
	time();
	setInterval(function() {time();}, 1000);
});
//--></script>