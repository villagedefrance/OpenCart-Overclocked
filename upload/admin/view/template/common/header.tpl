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
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/start/jquery-ui-1.11.4.custom.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="view/javascript/jquery/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.11.4.custom.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="view/javascript/common.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	// Confirm Delete
	$('#form').submit(function() {
		if ($(this).attr('action').indexOf('delete', 1) != -1) {
			if (!confirm('<?php echo $text_confirm; ?>')) {
				return false;
			}
		}
	});
	// Confirm Uninstall
	$('a').click(function() {
		if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall', 1) != -1) {
			if (!confirm('<?php echo $text_confirm; ?>')) {
				return false;
			}
		}
	});
});
//--></script>
</head>
<body>
<div id="container">
  <div id="header">
    <div class="static">
      <div class="image"><img src="view/image/logo.png" alt="" title="<?php echo $heading_title; ?>" onclick="location = '<?php echo $home; ?>'" /></div>
      <?php if ($logged) { ?>
        <div id="store-selector">
          <a onclick="window.open('<?php echo $store; ?>');" title=""><img src="view/image/dashboard/store.png" alt="<?php echo $text_front; ?>" /></a>
          <?php if ($stores) { ?>
            <div id="store-option" style="display:none;">
              <a onclick="window.open('<?php echo $store; ?>');" title=""><?php echo $text_front; ?></a>
              <?php foreach ($stores as $store) { ?>
                <?php $store_href = $store['href']; ?>
                <a onclick="window.open('<?php echo $store_href; ?>');" title=""><?php echo $store['name']; ?></a>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
        <div class="user-logout"><a href="<?php echo $logout; ?>" title=""><img src="view/image/dashboard/logout.png" alt="<?php echo $text_logout; ?>" /></a></div>
        <div class="user-status"><img src="view/image/lock.png" alt="" />&nbsp;<?php echo $logged; ?></div>
      <?php } ?>
    </div>
    <?php if ($logged) { ?>
    <div>
    <ul class="menu">
      <li id="dashboard" style="margin-left:5px;"><a href="<?php echo $home; ?>" title=""><?php echo $text_dashboard; ?></a></li>
      <li id="catalog"><a class="top"><?php echo $text_catalog; ?></a>
        <ul>
          <li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>
          <li><a href="<?php echo $product; ?>"><?php echo $text_product; ?></a></li>
          <li><a href="<?php echo $filter; ?>"><?php echo $text_filter; ?></a></li>
          <li><a href="<?php echo $profile; ?>"><?php echo $text_profile; ?></a></li>
          <li><a href="<?php echo $palette; ?>"><?php echo $text_palette; ?></a></li>
          <li><a class="arrow"><?php echo $text_attribute; ?></a>
            <ul>
              <li><a href="<?php echo $attribute; ?>"><?php echo $text_attribute; ?></a></li>
              <li><a href="<?php echo $attribute_group; ?>"><?php echo $text_attribute_group; ?></a></li>
            </ul>
          </li>
          <li><a href="<?php echo $option; ?>"><?php echo $text_option; ?></a></li>
          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
          <li><a href="<?php echo $review; ?>"><?php echo $text_review; ?></a></li>
		  <li><a href="<?php echo $news; ?>"><?php echo $text_news; ?></a></li>
          <li><a href="<?php echo $information; ?>"><?php echo $text_information; ?></a></li>
        </ul>
      </li>
      <li id="extension"><a class="top"><?php echo $text_extension; ?></a>
        <ul>
          <li><a href="<?php echo $module; ?>"><?php echo $text_module; ?></a></li>
		  <li><a href="<?php echo $modification; ?>"><?php echo $text_modification; ?></a></li>
          <li><a href="<?php echo $payment; ?>"><?php echo $text_payment; ?></a></li>
          <li><a href="<?php echo $shipping; ?>"><?php echo $text_shipping; ?></a></li>
          <li><a href="<?php echo $theme; ?>"><?php echo $text_theme; ?></a></li>
          <li><a href="<?php echo $total; ?>"><?php echo $text_total; ?></a></li>
		  <li><a href="<?php echo $fraud; ?>"><?php echo $text_fraud; ?></a></li>
          <li><a href="<?php echo $feed; ?>"><?php echo $text_feed; ?></a></li>
          <?php if ($openbay_show_menu == 1) { ?>
          <li><a class="arrow"><?php echo $text_openbay_extension; ?></a>
            <ul>
              <li><a href="<?php echo $openbay_link_extension; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
              <li><a href="<?php echo $openbay_link_orders; ?>"><?php echo $text_openbay_orders; ?></a></li>
              <li><a href="<?php echo $openbay_link_items; ?>"><?php echo $text_openbay_items; ?></a></li>
              <?php if ($openbay_markets['ebay'] == 1) { ?>
              <li><a class="arrow" href="<?php echo $openbay_link_ebay; ?>"><?php echo $text_openbay_ebay; ?></a>
                <ul>
                  <li><a href="<?php echo $openbay_link_ebay_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
                  <li><a href="<?php echo $openbay_link_ebay_links; ?>"><?php echo $text_openbay_links; ?></a></li>
                  <li><a href="<?php echo $openbay_link_ebay_orderimport; ?>"><?php echo $text_openbay_order_import; ?></a></li>
                </ul>
              </li>
              <?php } ?>
              <?php if ($openbay_markets['amazon'] == 1) { ?>
              <li><a class="arrow" href="<?php echo $openbay_link_amazon; ?>"><?php echo $text_openbay_amazon; ?></a>
                <ul>
                  <li><a href="<?php echo $openbay_link_amazon_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
                  <li><a href="<?php echo $openbay_link_amazon_links; ?>"><?php echo $text_openbay_links; ?></a></li>
                </ul>
              </li>
              <?php } ?>
              <?php if ($openbay_markets['amazonus'] == 1) { ?>
              <li><a class="arrow" href="<?php echo $openbay_link_amazonus; ?>"><?php echo $text_openbay_amazonus; ?></a>
                <ul>
                  <li><a href="<?php echo $openbay_link_amazonus_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
                  <li><a href="<?php echo $openbay_link_amazonus_links; ?>"><?php echo $text_openbay_links; ?></a></li>
                </ul>
              </li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>
        </ul>
      </li>
      <li id="sale"><a class="top"><?php echo $text_sale; ?></a>
        <ul>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
		  <?php if ($profile_exist) { ?>
          <li><a href="<?php echo $recurring_profile; ?>"><?php echo $text_recurring_profile; ?></a></li>
		  <?php } ?>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a class="arrow"><?php echo $text_customer; ?></a>
            <ul>
              <li><a href="<?php echo $customer; ?>"><?php echo $text_customer; ?></a></li>
              <li><a href="<?php echo $customer_group; ?>"><?php echo $text_customer_group; ?></a></li>
              <li><a href="<?php echo $customer_ban_ip; ?>"><?php echo $text_customer_ban_ip; ?></a></li>
            </ul>
          </li>
		  <?php if ($allow_affiliate) { ?>
          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
		  <?php } ?>
          <li><a href="<?php echo $coupon; ?>"><?php echo $text_coupon; ?></a></li>
          <li><a class="arrow"><?php echo $text_offer; ?></a>
            <ul>
              <li><a href="<?php echo $offer; ?>"><?php echo $text_offer_dashboard; ?></a></li>
              <li><a href="<?php echo $offer_product_product; ?>"><?php echo $text_offer_product_product; ?></a></li>
              <li><a href="<?php echo $offer_product_category; ?>"><?php echo $text_offer_product_category; ?></a></li>
              <li><a href="<?php echo $offer_category_product; ?>"><?php echo $text_offer_category_product; ?></a></li>
              <li><a href="<?php echo $offer_category_category; ?>"><?php echo $text_offer_category_category; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo $text_voucher; ?></a>
            <ul>
              <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
              <li><a href="<?php echo $voucher_theme; ?>"><?php echo $text_voucher_theme; ?></a></li>
            </ul>
          </li>
          <?php if ($pp_express_status) { ?>
          <li><a class="arrow" href="<?php echo $paypal_express; ?>"><?php echo $text_paypal_express; ?></a>
            <ul>
              <li><a href="<?php echo $paypal_express_search; ?>"><?php echo $text_paypal_express_search; ?></a></li>
            </ul>
          </li>
          <?php } ?>
          <li><a href="<?php echo $upload; ?>"><?php echo $text_upload; ?></a></li>
          <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
	    </ul>
      </li>
      <li id="system"><a class="top"><?php echo $text_system; ?></a>
        <ul>
          <li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li>
          <li><a class="arrow"><?php echo $text_design; ?></a>
            <ul>
              <li><a href="<?php echo $banner; ?>"><?php echo $text_banner; ?></a></li>
              <li><a href="<?php echo $connection; ?>"><?php echo $text_connection; ?></a></li>
              <li><a href="<?php echo $footer; ?>"><?php echo $text_footer; ?></a></li>
              <li><a href="<?php echo $layout; ?>"><?php echo $text_layout; ?></a></li>
              <li><a href="<?php echo $payment_image; ?>"><?php echo $text_payment_image; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo $text_users; ?></a>
            <ul>
              <li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
              <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo $text_localisation; ?></a>
            <ul>
              <li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li>
              <li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li>
              <li><a href="<?php echo $location; ?>"><?php echo $text_location; ?></a></li>
              <li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
              <li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
              <li><a class="arrow"><?php echo $text_return; ?></a>
                <ul>
                  <li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li>
                  <li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li>
                  <li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li>
                </ul>
              </li>
              <li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
              <li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
              <li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
              <li><a href="<?php echo $age_zone; ?>"><?php echo $text_age_zone; ?></a></li>
              <li><a class="arrow"><?php echo $text_tax; ?></a>
                <ul>
                  <li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li>
                  <li><a href="<?php echo $tax_rate; ?>"><?php echo $text_tax_rate; ?></a></li>
                </ul>
              </li>
              <li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li>
              <li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo $text_server; ?></a>
            <ul>
              <li><a href="<?php echo $configuration; ?>"><?php echo $text_configuration; ?></a></li>
              <li><a href="<?php echo $database; ?>"><?php echo $text_database; ?></a></li>
			  <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
              <li><a href="<?php echo $csv; ?>"><?php echo $text_csv; ?></a></li>
              <li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li>
            </ul>
          </li>
		  <li><a class="arrow"><?php echo $text_cache_manager; ?></a>
            <ul>
              <li><a href="<?php echo $cache_files; ?>"><?php echo $text_cache_files; ?></a></li>
              <li><a href="<?php echo $cache_images; ?>"><?php echo $text_cache_images; ?></a></li>
            </ul>
          </li>
          <li><a href="<?php echo $seo_url_manager; ?>"><?php echo $text_seo_url_manager; ?></a></li>
          <li><a href="<?php echo $menu_manager; ?>"><?php echo $text_menu_manager; ?></a></li>
          <li><a href="<?php echo $file_manager; ?>"><?php echo $text_file_manager; ?></a></li>
          <li><a href="<?php echo $email_log; ?>"><?php echo $text_email_log; ?></a></li>
          <li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li>
        </ul>
      </li>
      <li id="reports"><a class="top"><?php echo $text_reports; ?></a>
	    <ul>
          <li><a class="arrow"><?php echo $text_sale; ?></a>
            <ul>
              <li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li>
              <li><a href="<?php echo $report_sale_tax; ?>"><?php echo $text_report_sale_tax; ?></a></li>
              <li><a href="<?php echo $report_sale_shipping; ?>"><?php echo $text_report_sale_shipping; ?></a></li>
              <li><a href="<?php echo $report_sale_return; ?>"><?php echo $text_report_sale_return; ?></a></li>
              <li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo $text_product; ?></a>
            <ul>
              <li><a href="<?php echo $report_product_profit; ?>"><?php echo $text_report_product_profit; ?></a></li>
              <li><a href="<?php echo $report_product_viewed; ?>"><?php echo $text_report_product_viewed; ?></a></li>
              <li><a href="<?php echo $report_product_purchased; ?>"><?php echo $text_report_product_purchased; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo $text_customer; ?></a>
            <ul>
              <li><a href="<?php echo $report_customer_online; ?>"><?php echo $text_report_customer_online; ?></a></li>
              <li><a href="<?php echo $report_customer_order; ?>"><?php echo $text_report_customer_order; ?></a></li>
              <li><a href="<?php echo $report_customer_reward; ?>"><?php echo $text_report_customer_reward; ?></a></li>
              <li><a href="<?php echo $report_customer_credit; ?>"><?php echo $text_report_customer_credit; ?></a></li>
            </ul>
          </li>
          <li><a class="arrow"><?php echo $text_affiliate; ?></a>
            <ul>
              <li><a href="<?php echo $report_affiliate_commission; ?>"><?php echo $text_report_affiliate_commission; ?></a></li>
            </ul>
          </li>
        </ul>
      </li>
	  <?php if ($connection_exist) { ?>
	  <li id="connection"><a class="top"><?php echo $text_connection; ?></a>
        <ul>
        <?php foreach ($connections_ul as $connection_ul) { ?>
          <li><a class="arrow"><?php echo $connection_ul['name']; ?></a>
            <ul>
            <?php foreach ($connections_li as $connection_li) { ?>
              <?php if ($connection_li['parent_id'] == $connection_ul['connection_id']) { ?>
                <li><a onclick="window.open('<?php echo $connection_li['route']; ?>');" title=""><?php echo $connection_li['title']; ?></a></li>
              <?php } ?>
            <?php } ?>
            </ul>
          </li>
        <?php } ?>
        </ul>
      </li>
	  <?php } ?>
      <li id="help"><a class="top"><?php echo $text_help; ?></a>
        <ul>
          <li><a onclick="window.open('http://www.opencart.com');" title=""><?php echo $text_opencart; ?></a></li>
          <li><a onclick="window.open('http://villagedefrance.net');" title=""><?php echo $text_opencart_overclocked; ?></a></li>
          <li><a onclick="window.open('http://www.opencart.com/index.php?route=documentation/introduction');" title=""><?php echo $text_documentation; ?></a></li>
          <li><a onclick="window.open('http://forum.opencart.com');" title=""><?php echo $text_support; ?></a></li>
        </ul>
      </li>
	</ul>
  </div>
  <?php } ?>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#store-selector').hover(function() {
		$('#store-option').css('margin-left', '-180px').slideDown(200);
	}, function() {
		$('#store-option').css('margin-left', '-180px').slideUp(200);
	});
});
//--></script>