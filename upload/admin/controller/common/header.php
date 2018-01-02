<?php
class ControllerCommonHeader extends Controller {

	protected function index() {
		$this->data['title'] = $this->document->getTitle();

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$this->data['base'] = HTTPS_SERVER;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');

		$this->language->load('common/header');

		$this->data['heading_title'] = $this->language->get('heading_title');

		// Stylesheet
		$admin_css = $this->config->get('config_admin_stylesheet');

		if (isset($admin_css)) {
			$this->data['admin_css'] = $admin_css;
		} else {
			$this->data['admin_css'] = 'classic';
		}

		// Display Limit
		$display_limit = $this->config->get('config_admin_width_limit');

		$this->data['resolution'] = ($display_limit) ? 'limited' : 'normal';

		// User Agent
		$agent_platform = $this->browser->getPlatform();
		$agent_browser = $this->browser->getBrowser();
		$agent_version = $this->browser->getBrowserVersion();

		$this->data['agent_platform'] = $agent_platform ? $agent_platform : '';
		$this->data['agent_browser'] = $agent_browser ? $agent_browser : '';
		$this->data['agent_version'] = $agent_version ? $agent_version : '';

		$medium = $this->browser->getMedium();

		if (!$agent_platform && $medium == 'mobile') {
			$this->data['device'] = 'phone';
		} elseif ($medium == 'pad') {
			$this->data['device'] = 'tablet';
		} else {
			$this->data['device'] = 'desktop';
		}

		// Date & Time
		$date = $this->config->get('config_date_format');

		if ($date && $date == "long") {
			$this->data['date_format'] = date($this->language->get('date_format_long')) . "\n";
		} elseif ($date && $date == "short") {
			$this->data['date_format'] = date($this->language->get('date_format_short')) . "\n";
		} else {
			$this->data['date_format'] = date('d-m-Y') . "\n";
		}

		$time = $this->config->get('config_time_offset');

		$this->data['time_offset'] = ($time) ? $time : '0';

		// Text
		$this->data['text_administration'] = $this->language->get('text_administration');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_api_key_manager'] = $this->language->get('text_api_key_manager');
		$this->data['text_attribute'] = $this->language->get('text_attribute');
		$this->data['text_attribute_group'] = $this->language->get('text_attribute_group');
		$this->data['text_backup'] = $this->language->get('text_backup');
		$this->data['text_banner'] = $this->language->get('text_banner');
		$this->data['text_block_ip'] = $this->language->get('text_block_ip');
		$this->data['text_cache_manager'] = $this->language->get('text_cache_manager');
		$this->data['text_cache_files'] = $this->language->get('text_cache_files');
		$this->data['text_cache_images'] = $this->language->get('text_cache_images');
		$this->data['text_catalog'] = $this->language->get('text_catalog');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_configuration'] = $this->language->get('text_configuration');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_connection'] = $this->language->get('text_connection');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_country'] = $this->language->get('text_country');
		$this->data['text_coupon'] = $this->language->get('text_coupon');
		$this->data['text_currency'] = $this->language->get('text_currency');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_customer_group'] = $this->language->get('text_customer_group');
		$this->data['text_customer_ban_ip'] = $this->language->get('text_customer_ban_ip');
		$this->data['text_dashboard'] = $this->language->get('text_dashboard');
		$this->data['text_database'] = $this->language->get('text_database');
		$this->data['text_design'] = $this->language->get('text_design');
		$this->data['text_documentation'] = $this->language->get('text_documentation');
		$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_email_log'] = $this->language->get('text_email_log');
		$this->data['text_error_log'] = $this->language->get('text_error_log');
		$this->data['text_export_import'] = $this->language->get('text_export_import');
		$this->data['text_export_import_raw'] = $this->language->get('text_export_import_raw');
		$this->data['text_export_import_tool'] = $this->language->get('text_export_import_tool');
		$this->data['text_extension'] = $this->language->get('text_extension');
		$this->data['text_feed'] = $this->language->get('text_feed');
		$this->data['text_field'] = $this->language->get('text_field');
		$this->data['text_file_manager'] = $this->language->get('text_file_manager');
		$this->data['text_filter'] = $this->language->get('text_filter');
		$this->data['text_footer'] = $this->language->get('text_footer');
		$this->data['text_forum'] = $this->language->get('text_forum');
		$this->data['text_fraud'] = $this->language->get('text_fraud');
		$this->data['text_front'] = $this->language->get('text_front');
		$this->data['text_geo_zone'] = $this->language->get('text_geo_zone');
		$this->data['text_help'] = $this->language->get('text_help');
		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_language'] = $this->language->get('text_language');
		$this->data['text_layout'] = $this->language->get('text_layout');
		$this->data['text_length_class'] = $this->language->get('text_length_class');
		$this->data['text_localisation'] = $this->language->get('text_localisation');
		$this->data['text_location'] = $this->language->get('text_location');
		$this->data['text_logout'] = $this->language->get('text_logout');
		$this->data['text_logs'] = $this->language->get('text_logs');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_media'] = $this->language->get('text_media');
		$this->data['text_menu_manager'] = $this->language->get('text_menu_manager');
		$this->data['text_modification'] = $this->language->get('text_modification');
		$this->data['text_module'] = $this->language->get('text_module');
		$this->data['text_news'] = $this->language->get('text_news');
		$this->data['text_option'] = $this->language->get('text_option');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_order_status'] = $this->language->get('text_order_status');
		$this->data['text_opencart'] = $this->language->get('text_opencart');
		$this->data['text_opencart_overclocked'] = $this->language->get('text_opencart_overclocked');
		$this->data['text_palette'] = $this->language->get('text_palette');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_payment_image'] = $this->language->get('text_payment_image');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_profile'] = $this->language->get('text_profile');
		$this->data['text_quote_log'] = $this->language->get('text_quote_log');
		$this->data['text_recurring_profile'] = $this->language->get('text_recurring_profile');
		$this->data['text_reports'] = $this->language->get('text_reports');
		$this->data['text_report_sale_order'] = $this->language->get('text_report_sale_order');
		$this->data['text_report_sale_tax'] = $this->language->get('text_report_sale_tax');
		$this->data['text_report_sale_shipping'] = $this->language->get('text_report_sale_shipping');
		$this->data['text_report_sale_return'] = $this->language->get('text_report_sale_return');
		$this->data['text_report_sale_coupon'] = $this->language->get('text_report_sale_coupon');
		$this->data['text_report_sale_profit'] = $this->language->get('text_report_sale_profit');
		$this->data['text_report_product_label'] = $this->language->get('text_report_product_label');
		$this->data['text_report_product_markup'] = $this->language->get('text_report_product_markup');
		$this->data['text_report_product_viewed'] = $this->language->get('text_report_product_viewed');
		$this->data['text_report_product_quantity'] = $this->language->get('text_report_product_quantity');
		$this->data['text_report_product_purchased'] = $this->language->get('text_report_product_purchased');
		$this->data['text_report_customer_order'] = $this->language->get('text_report_customer_order');
		$this->data['text_report_customer_reward'] = $this->language->get('text_report_customer_reward');
		$this->data['text_report_customer_credit'] = $this->language->get('text_report_customer_credit');
		$this->data['text_report_customer_country'] = $this->language->get('text_report_customer_country');
		$this->data['text_report_customer_online'] = $this->language->get('text_report_customer_online');
		$this->data['text_report_affiliate_activity'] = $this->language->get('text_report_affiliate_activity');
		$this->data['text_report_affiliate_commission'] = $this->language->get('text_report_affiliate_commission');
		$this->data['text_report_sale_return'] = $this->language->get('text_report_sale_return');
		$this->data['text_report_product_viewed'] = $this->language->get('text_report_product_viewed');
		$this->data['text_report_customer_order'] = $this->language->get('text_report_customer_order');
		$this->data['text_report_robot_online'] = $this->language->get('text_report_robot_online');
		$this->data['text_review'] = $this->language->get('text_review');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_return_action'] = $this->language->get('text_return_action');
		$this->data['text_return_reason'] = $this->language->get('text_return_reason');
		$this->data['text_return_status'] = $this->language->get('text_return_status');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_seo_url_manager'] = $this->language->get('text_seo_url_manager');
		$this->data['text_server'] = $this->language->get('text_server');
		$this->data['text_setting'] = $this->language->get('text_setting');
		$this->data['text_shipping'] = $this->language->get('text_shipping');
		$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_stock_status'] = $this->language->get('text_stock_status');
		$this->data['text_supplier'] = $this->language->get('text_supplier');
		$this->data['text_supplier_group'] = $this->language->get('text_supplier_group');
		$this->data['text_supplier_product'] = $this->language->get('text_supplier_product');
		$this->data['text_support'] = $this->language->get('text_support');
		$this->data['text_system'] = $this->language->get('text_system');
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_tax_class'] = $this->language->get('text_tax_class');
		$this->data['text_tax_local_rate'] = $this->language->get('text_tax_local_rate');
		$this->data['text_tax_rate'] = $this->language->get('text_tax_rate');
		$this->data['text_theme'] = $this->language->get('text_theme');
		$this->data['text_tool'] = $this->language->get('text_tool');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_upload'] = $this->language->get('text_upload');
		$this->data['text_user'] = $this->language->get('text_user');
		$this->data['text_user_group'] = $this->language->get('text_user_group');
		$this->data['text_users'] = $this->language->get('text_users');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_voucher_theme'] = $this->language->get('text_voucher_theme');
		$this->data['text_weight_class'] = $this->language->get('text_weight_class');
		$this->data['text_zone'] = $this->language->get('text_zone');

		$this->data['text_openbay_extension'] = $this->language->get('text_openbay_extension');
		$this->data['text_openbay_dashboard'] = $this->language->get('text_openbay_dashboard');
		$this->data['text_openbay_orders'] = $this->language->get('text_openbay_orders');
		$this->data['text_openbay_items'] = $this->language->get('text_openbay_items');
		$this->data['text_openbay_ebay'] = $this->language->get('text_openbay_ebay');
		$this->data['text_openbay_amazon'] = $this->language->get('text_openbay_amazon');
		$this->data['text_openbay_amazonus'] = $this->language->get('text_openbay_amazonus');
		$this->data['text_openbay_settings'] = $this->language->get('text_openbay_settings');
		$this->data['text_openbay_links'] = $this->language->get('text_openbay_links');
		$this->data['text_openbay_report_price'] = $this->language->get('text_openbay_report_price');
		$this->data['text_openbay_order_import'] = $this->language->get('text_openbay_order_import');

		$this->data['text_paypal_express'] = $this->language->get('text_paypal_manage');
		$this->data['text_paypal_express_search'] = $this->language->get('text_paypal_search');

		// Header
		if (!$this->user->isLogged() || !isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$this->data['logged'] = false;

			$this->data['home'] = $this->url->link('common/login', '', 'SSL');

		} else {
			$this->data['logged'] = true;

			$this->load->model('user/user');
			$this->load->model('tool/image');

			$user_info = $this->model_user_user->getUser($this->user->getId());

			if ($user_info) {
				$this->data['username'] = $user_info['username'];
				$this->data['user_id'] = $user_info['user_id'];
	
				if (is_file(DIR_IMAGE . $user_info['image'])) {
					$this->data['avatar'] = $this->model_tool_image->resize($user_info['image'], 26, 26);
				} else {
					$this->data['avatar'] = $this->model_tool_image->resize('no_avatar.jpg', 26, 26);
				}

				$this->data['user_profile'] = $this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $user_info['user_id'], 'SSL');
			} else {
				$this->data['username'] = '';
				$this->data['user_id'] = '';
				$this->data['avatar'] = '';
				$this->data['user_profile'] = '';
			}

			$this->data['administration'] = $this->url->link('design/administration', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['affiliate'] = $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['api_key_manager'] = $this->url->link('tool/api_key_manager', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute_group'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['backup'] = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['banner'] = $this->url->link('design/banner', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['block_ip'] = $this->url->link('tool/block_ip', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['cache_files'] = $this->url->link('tool/cache_files', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['cache_images'] = $this->url->link('tool/cache_images', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['category'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['configuration'] = $this->url->link('tool/configuration', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['connection'] = $this->url->link('design/connection', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['contact'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['country'] = $this->url->link('localisation/country', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['coupon'] = $this->url->link('sale/coupon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['currency'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_group'] = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_ban_ip'] = $this->url->link('sale/customer_ban_ip', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['database'] = $this->url->link('tool/database', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['download'] = $this->url->link('catalog/download', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['email_log'] = $this->url->link('tool/mail_log', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['error_log'] = $this->url->link('tool/error_log', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['export_import_raw'] = $this->url->link('tool/export_import_raw', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['export_import_tool'] = $this->url->link('tool/export_import', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['feed'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['field'] = $this->url->link('catalog/field', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['file_manager'] = $this->url->link('common/filemanager_full', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['filter'] = $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['fraud'] = $this->url->link('extension/fraud', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['footer'] = $this->url->link('design/footer', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['geo_zone'] = $this->url->link('localisation/geo_zone', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['home'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['information'] = $this->url->link('catalog/information', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['language'] = $this->url->link('localisation/language', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['layout'] = $this->url->link('design/layout', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['length_class'] = $this->url->link('localisation/length_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['location'] = $this->url->link('localisation/location', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['manufacturer'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['media'] = $this->url->link('design/media', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['menu_manager'] = $this->url->link('design/menu', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['modification'] = $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['module'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['news'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['option'] = $this->url->link('catalog/option', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order_status'] = $this->url->link('localisation/order_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['palette'] = $this->url->link('catalog/palette', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['payment'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['payment_image'] = $this->url->link('design/payment', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['profile'] = $this->url->link('catalog/profile', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['quote_log'] = $this->url->link('tool/quote_log', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['recurring_profile'] = $this->url->link('sale/recurring', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_order'] = $this->url->link('report/sale_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_tax'] = $this->url->link('report/sale_tax', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_shipping'] = $this->url->link('report/sale_shipping', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_return'] = $this->url->link('report/sale_return', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_coupon'] = $this->url->link('report/sale_coupon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_profit'] = $this->url->link('report/sale_profit', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_label'] = $this->url->link('report/product_label', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_markup'] = $this->url->link('report/product_markup', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_viewed'] = $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_quantity'] = $this->url->link('report/product_quantity', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_purchased'] = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_order'] = $this->url->link('report/customer_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_reward'] = $this->url->link('report/customer_reward', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_credit'] = $this->url->link('report/customer_credit', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_country'] = $this->url->link('report/customer_country', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_affiliate_activity'] = $this->url->link('report/affiliate_activity', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_affiliate_commission'] = $this->url->link('report/affiliate_commission', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_robot_online'] = $this->url->link('report/robot_online', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['review'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return'] = $this->url->link('sale/return', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_action'] = $this->url->link('localisation/return_action', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_reason'] = $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_status'] = $this->url->link('localisation/return_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['seo_url_manager'] = $this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['setting'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['shipping'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['sitemap'] = $this->url->link('tool/sitemap', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['store'] = HTTP_CATALOG . 'index.php';
			$this->data['stock_status'] = $this->url->link('localisation/stock_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['purchase_order'] = $this->url->link('sale/purchase_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['supplier'] = $this->url->link('sale/supplier', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['supplier_group'] = $this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['supplier_product'] = $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['tax_class'] = $this->url->link('localisation/tax_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['tax_local_rate'] = $this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['tax_rate'] = $this->url->link('localisation/tax_rate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['theme'] = $this->url->link('extension/theme', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['total'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['upload'] = $this->url->link('tool/upload', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['voucher'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['voucher_theme'] = $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['weight_class'] = $this->url->link('localisation/weight_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['zone'] = $this->url->link('localisation/zone', 'token=' . $this->session->data['token'], 'SSL');

			// Openbay
			$this->data['openbay_show_menu'] = $this->config->get('openbaymanager_show_menu');

			$this->data['openbay_link_extension'] = $this->url->link('extension/openbay', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_orders'] = $this->url->link('extension/openbay/orderList', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_items'] = $this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay'] = $this->url->link('openbay/openbay', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay_settings'] = $this->url->link('openbay/openbay/settings', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay_links'] = $this->url->link('openbay/openbay/viewItemLinks', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay_orderimport'] = $this->url->link('openbay/openbay/viewOrderImport', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazon'] = $this->url->link('openbay/amazon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazon_settings'] = $this->url->link('openbay/amazon/settings', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazon_links'] = $this->url->link('openbay/amazon/itemLinks', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazonus'] = $this->url->link('openbay/amazonus', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazonus_settings'] = $this->url->link('openbay/amazonus/settings', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazonus_links'] = $this->url->link('openbay/amazonus/itemLinks', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['openbay_markets'] = array(
				'ebay'     => $this->config->get('openbay_status'),
				'amazon'   => $this->config->get('amazon_status'),
				'amazonus' => $this->config->get('amazonus_status')
			);

			// Paypal Express
			$this->data['pp_express_status'] = $this->config->get('pp_express_status');

			$this->data['paypal_express'] = $this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['paypal_express_search'] = $this->url->link('payment/pp_express/search', 'token=' . $this->session->data['token'], 'SSL');

			// Profiles
			$this->load->model('catalog/profile');

			$profile_total = $this->model_catalog_profile->getTotalProfiles();

			if ($profile_total > 0) {
				$this->data['profile_exist'] = true;
			} else {
				$this->data['profile_exist'] = false;
			}

			// Menu Icons
			$this->data['icons'] = $this->config->get('config_admin_menu_icons');

			// Connections
			$this->load->model('design/connection');

			$connection_total = $this->model_design_connection->getTotalAdminConnections();

			if ($connection_total > 0) {
				$this->data['connections_ul'] = array();
				$this->data['connections_li'] = array();

				$connections = $this->model_design_connection->getConnections(0);

				foreach ($connections as $connection) {
					if ($connection['backend']) {
						$this->data['connections_ul'][] = array(
							'connection_id' => $connection['connection_id'],
							'name'          => $connection['name']
						);

						$connection_routes = $this->model_design_connection->getConnectionRoutes($connection['connection_id']);

						foreach ($connection_routes as $connection_route) {
							$this->data['connections_li'][] = array(
								'parent_id' => $connection_route['connection_id'],
								'icon'      => $connection_route['icon'],
								'title'     => $connection_route['title'],
								'route'     => html_entity_decode($connection_route['route'], ENT_QUOTES, 'UTF-8')
							);
						}
					}
				}

				$this->data['connection_exist'] = true;
			} else {
				$this->data['connection_exist'] = false;
			}

			// Affiliates
			if ($this->config->get('config_affiliate_disable')) {
				$this->data['allow_affiliate'] = false;
			} else {
				$this->data['allow_affiliate'] = true;
			}

			// Store
			$this->data['stores'] = array();

			$this->load->model('setting/store');

			$results = $this->model_setting_store->getAllStores();

			foreach ($results as $result) {
				$this->data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}

			// Robots
			$this->data['track_robots'] = $this->config->get('config_robots_online');
		}

		$this->template = 'common/header.tpl';
		$this->render();
	}
}
