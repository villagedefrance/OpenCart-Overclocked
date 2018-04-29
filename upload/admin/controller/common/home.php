<?php
class ControllerCommonHome extends Controller {

	public function index() {
		$this->language->load('common/home');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addStyle('view/javascript/jquery/jqvmap/jqvmap.min.css');
		$this->document->addStyle('view/javascript/jquery/chart/chart-donut.min.css');

		$this->document->addScript('view/javascript/jquery/jqvmap/jquery.vmap.min.js');
		$this->document->addScript('view/javascript/jquery/jqvmap/maps/jquery.vmap.world.js');

		$this->document->addScript('view/javascript/jquery/chart/jquery.chart.min.js');

		$this->document->addScript('view/javascript/jquery/flot/jquery.flot.min.js');
		$this->document->addScript('view/javascript/jquery/flot/jquery.flot.resize.min.js');

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_overview'] = $this->language->get('text_overview');
		$this->data['text_statistics'] = $this->language->get('text_statistics');
		$this->data['text_latest'] = $this->language->get('text_latest');
		$this->data['text_order_today'] = $this->language->get('text_order_today');
		$this->data['text_customer_today'] = $this->language->get('text_customer_today');
		$this->data['text_sale_today'] = $this->language->get('text_sale_today');
		$this->data['text_online'] = $this->language->get('text_online');
		$this->data['text_total_sale'] = $this->language->get('text_total_sale');
		$this->data['text_total_sale_year'] = $this->language->get('text_total_sale_year');
		$this->data['text_total_sale_month'] = $this->language->get('text_total_sale_month');
		$this->data['text_total_order'] = $this->language->get('text_total_order');
		$this->data['text_total_customer'] = $this->language->get('text_total_customer');
		$this->data['text_total_customer_approval'] = $this->language->get('text_total_customer_approval');
		$this->data['text_total_review'] = $this->language->get('text_total_review');
		$this->data['text_total_review_approval'] = $this->language->get('text_total_review_approval');
		$this->data['text_total_affiliate'] = $this->language->get('text_total_affiliate');
		$this->data['text_total_affiliate_approval'] = $this->language->get('text_total_affiliate_approval');
		$this->data['text_day'] = $this->language->get('text_day');
		$this->data['text_week'] = $this->language->get('text_week');
		$this->data['text_month'] = $this->language->get('text_month');
		$this->data['text_year'] = $this->language->get('text_year');
		$this->data['text_topseller'] = $this->language->get('text_topseller');
		$this->data['text_topview'] = $this->language->get('text_topview');
		$this->data['text_topcustomer'] = $this->language->get('text_topcustomer');
		$this->data['text_topcountry'] = $this->language->get('text_topcountry');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_deleted'] = $this->language->get('text_deleted');

		$this->data['help_mail_log'] = $this->language->get('help_mail_log');
		$this->data['help_quote_log'] = $this->language->get('help_quote_log');
		$this->data['help_error_log'] = $this->language->get('help_error_log');
		$this->data['help_seo_url'] = $this->language->get('help_seo_url');

		$this->data['tab_map'] = $this->language->get('tab_map');
		$this->data['tab_order'] = $this->language->get('tab_order');
		$this->data['tab_customer'] = $this->language->get('tab_customer');
		$this->data['tab_review'] = $this->language->get('tab_review');
		$this->data['tab_affiliate'] = $this->language->get('tab_affiliate');
		$this->data['tab_return'] = $this->language->get('tab_return');
		$this->data['tab_upload'] = $this->language->get('tab_upload');

		$this->data['column_order'] = $this->language->get('column_order');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_conversion'] = $this->language->get('column_conversion');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_firstname'] = $this->language->get('column_firstname');
		$this->data['column_lastname'] = $this->language->get('column_lastname');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_orders_passed'] = $this->language->get('column_orders_passed');
		$this->data['column_orders_missed'] = $this->language->get('column_orders_missed');
		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_author'] = $this->language->get('column_author');
		$this->data['column_rating'] = $this->language->get('column_rating');
		$this->data['column_rating_total'] = $this->language->get('column_rating_total');
		$this->data['column_affiliate'] = $this->language->get('column_affiliate');
		$this->data['column_tracking'] = $this->language->get('column_tracking');
		$this->data['column_balance'] = $this->language->get('column_balance');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_return_id'] = $this->language->get('column_return_id');
		$this->data['column_return_history'] = $this->language->get('column_return_history');
		$this->data['column_upload_id'] = $this->language->get('column_upload_id');
		$this->data['column_filename'] = $this->language->get('column_filename');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['entry_range'] = $this->language->get('entry_range');

		// Delete install directory
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$this->load->model('tool/system');

			$this->model_tool_system->deleteDirectory('../install');

			clearstatcache();
		}

		// Check image directory is writeable
		$file = DIR_IMAGE . 'test';
		$handle = fopen($file, 'a+');
		fwrite($handle, '');
		fclose($handle);

		if (!file_exists($file)) {
			$this->data['error_image'] = sprintf($this->language->get('error_image'), DIR_IMAGE);
		} else {
			$this->data['error_image'] = '';

			unlink($file);
		}

		// Check image cache directory is writeable
		$file = DIR_IMAGE . 'cache/test';
		$handle = fopen($file, 'a+');
		fwrite($handle, '');
		fclose($handle);

		if (!file_exists($file)) {
			$this->data['error_image_cache'] = sprintf($this->language->get('error_image_cache'), DIR_IMAGE . 'cache/');
		} else {
			$this->data['error_image_cache'] = '';

			unlink($file);
		}

		// Check cache directory is writeable
		$file = DIR_CACHE . 'test';
		$handle = fopen($file, 'a+');
		fwrite($handle, '');
		fclose($handle);

		if (!file_exists($file)) {
			$this->data['error_cache'] = sprintf($this->language->get('error_cache'), DIR_CACHE);
		} else {
			$this->data['error_cache'] = '';

			unlink($file);
		}

		// Check download directory is writeable
		$file = DIR_DOWNLOAD . 'test';
		$handle = fopen($file, 'a+');
		fwrite($handle, '');
		fclose($handle);

		if (!file_exists($file)) {
			$this->data['error_download'] = sprintf($this->language->get('error_download'), DIR_DOWNLOAD);
		} else {
			$this->data['error_download'] = '';

			unlink($file);
		}

		// Check upload directory is writeable
		$file = DIR_UPLOAD . 'test';
		$handle = fopen($file, 'a+');
		fwrite($handle, '');
		fclose($handle);

		if (!file_exists($file)) {
			$this->data['error_upload'] = sprintf($this->language->get('error_upload'), DIR_UPLOAD);
		} else {
			$this->data['error_upload'] = '';

			unlink($file);
		}

		// Check logs directory is writeable
		$file = DIR_LOGS . 'test';
		$handle = fopen($file, 'a+');
		fwrite($handle, '');
		fclose($handle);

		if (!file_exists($file)) {
			$this->data['error_logs'] = sprintf($this->language->get('error_logs'), DIR_LOGS);
		} else {
			$this->data['error_logs'] = '';

			unlink($file);
		}

		// Check user log number of entries
		$this->load->model('user/user_log');

		$this->data['text_user_log'] = $this->language->get('text_user_log');

		$entries_total = $this->model_user_user_log->getTotalDataLog(0);

		if ($entries_total > 499) {
			$this->data['error_user_log'] = sprintf($this->language->get('error_user_log'), (int)$entries_total);
			$this->data['view_user_log'] = $this->url->link('user/user_log', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['error_user_log'] = '';
			$this->data['view_user_log'] = '';
		}

		// Error log
		$error_filename = $this->config->get('config_error_filename');

		$error_log_file = DIR_LOGS . $error_filename;

		if (!empty($error_filename) && preg_match('/\.txt$/i', $error_filename) && file_exists($error_log_file)) {
			$this->data['error_log_status'] = file_get_contents($error_log_file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['error_log_status'] = '';
		}

		$this->data['open_error_log'] = $this->url->link('tool/error_log', 'token=' . $this->session->data['token'], 'SSL');

		// Quote log
		$quote_filename = $this->config->get('config_quote_filename');

		$quote_log_file = DIR_LOGS . $quote_filename;

		if (!empty($quote_filename) && preg_match('/\.txt$/i', $quote_filename) && file_exists($quote_log_file)) {
			$this->data['quote_log_status'] = file_get_contents($quote_log_file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['quote_log_status'] = '';
		}

		$this->data['open_quote_log'] = $this->url->link('tool/quote_log', 'token=' . $this->session->data['token'], 'SSL');

		// Email log
		$mail_filename = $this->config->get('config_mail_filename');

		$mail_log_file = DIR_LOGS . $mail_filename;

		if (!empty($mail_filename) && preg_match('/\.txt$/i', $mail_filename) && file_exists($mail_log_file)) {
			$this->data['mail_log_status'] = file_get_contents($mail_log_file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['mail_log_status'] = '';
		}

		$this->data['open_mail_log'] = $this->url->link('tool/mail_log', 'token=' . $this->session->data['token'], 'SSL');

		clearstatcache();

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['token'] = $this->session->data['token'];

		// Seo urls
		$seo_url_status = $this->config->get('config_seo_url');
		$seo_url_ratio = 0;

		if ($seo_url_status) {
			$this->load->model('tool/seo_url_manager');

			$seo_url_total = $this->model_tool_seo_url_manager->getTotalUrls();
			$keyword_total = $this->model_tool_seo_url_manager->getTotalUniqueKeywords();

			$seo_url_variance = $seo_url_total - $keyword_total;

			if ($seo_url_total == $keyword_total) {
				$seo_url_ratio = 1;
			} elseif ($seo_url_variance <= 5) {
				$seo_url_ratio = 2;
			} else {
				$seo_url_ratio = 3;
			}
		}

		$this->data['seo_url_status'] = $seo_url_status;
		$this->data['seo_url_ratio'] = $seo_url_ratio;

		$this->data['open_seo_url'] = $this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'], 'SSL');

		// Stylesheet
		$admin_css = $this->config->get('config_admin_stylesheet');

		$this->load->model('design/administration');

		$contrast = $this->model_design_administration->getAdministrationContrastByName($admin_css);

		if ($contrast == 'dark') {
			$this->data['chart_background'] = '#6D7582';
			$this->data['chart_border'] = '#999999';
			$this->data['chart_colour'] = '#E5E5E5';
		} elseif ($contrast == 'light') {
			$this->data['chart_background'] = '#FFFFFF';
			$this->data['chart_border'] = '#AAAAAA';
			$this->data['chart_colour'] = '#333333';
		} else {
			$this->data['chart_background'] = '#FFFFFF';
			$this->data['chart_border'] = '#AAAAAA';
			$this->data['chart_colour'] = '#333333';
		}

		$this->data['admin_css'] = $admin_css;

		// Overview
		$this->load->model('sale/order');

		$this->data['total_sale'] = $this->currency->format($this->model_sale_order->getTotalSales(), $this->config->get('config_currency'));
		$this->data['total_sale_year'] = $this->currency->format($this->model_sale_order->getTotalSalesByYear(date('Y')), $this->config->get('config_currency'));
		$this->data['total_sale_month'] = $this->currency->format($this->model_sale_order->getTotalSalesByMonth(date('m')), $this->config->get('config_currency'));

		$this->load->model('sale/customer');

		$this->data['total_customer'] = $this->model_sale_customer->getTotalCustomers(0);
		$this->data['total_customer_approval'] = $this->model_sale_customer->getTotalCustomersAwaitingApproval();

		$this->load->model('catalog/review');

		$this->data['total_review'] = $this->model_catalog_review->getTotalReviews();
		$this->data['total_review_approval'] = $this->model_catalog_review->getTotalReviewsAwaitingApproval();

		$this->load->model('sale/affiliate');

		$this->data['total_affiliate'] = $this->model_sale_affiliate->getTotalAffiliates(0);
		$this->data['total_affiliate_approval'] = $this->model_sale_affiliate->getTotalAffiliatesAwaitingApproval();

		if ($this->config->get('config_affiliate_disable')) {
			$this->data['allow_affiliate'] = false;
		} else {
			$this->data['allow_affiliate'] = true;
		}

		$this->load->model('sale/return');

		$this->data['total_return'] = $this->model_sale_return->getTotalReturns(0);

		if ($this->config->get('config_return_disable')) {
			$this->data['allow_return'] = false;
		} else {
			$this->data['allow_return'] = true;
		}

		$this->load->model('tool/upload');

		$this->data['total_upload'] = $this->model_tool_upload->getTotalUploads(0);

		// Overview Links
		$config_order_status_id = $this->config->get('config_order_status_id');
		$config_complete_status_id = $this->config->get('config_complete_status_id');

		if ($config_order_status_id != $config_complete_status_id) {
			$this->data['total_pending_orders'] = $this->model_sale_order->getTotalOrdersByOrderStatusId($config_order_status_id);
		} else {
			$this->data['total_pending_orders'] = 0;
		}

		$this->data['view_reviews'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['view_affiliates'] = $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL');

		// Today
		$this->data['total_order'] = $this->model_sale_order->getTotalOrders(0);

		$order_today = $this->model_sale_order->getTotalOrders(array('filter_date_added' => date('Y-m-d')));

		if ($order_today > 0) {
			$this->data['total_order_today'] = $order_today;
		} else {
			$this->data['total_order_today'] = 0;
		}

		$this->data['view_orders'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL');

		$customer_today = $this->model_sale_customer->getTotalCustomers(array('filter_date_added' => date('Y-m-d')));

		if ($customer_today > 0) {
			$this->data['total_customer_today'] = $customer_today;
		} else {
			$this->data['total_customer_today'] = 0;
		}

		$this->data['view_customers'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('report/sale');

		$this->data['total_sale_today'] = $this->currency->format($this->model_report_sale->getTotalSales(array('filter_date_added' => date('Y-m-d'))), $this->config->get('config_currency'));

		$this->data['view_sales'] = $this->url->link('report/sale_order', 'token=' . $this->session->data['token'] . '&filter_date_start=' . date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01')) . '&filter_date_end=' . date('Y-m-d') . '&filter_group=day', 'SSL');

		$this->load->model('report/online');

		$this->data['total_online'] = $this->model_report_online->getTotalCustomersOnline(0);

		$this->data['view_online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['show_dob'] = $this->config->get('config_customer_dob');

		// Tab Map
		$this->load->model('report/sale');

		$this->data['top_countries'] = array();

		$total_sales = $this->model_report_sale->getTotalSales(0);

		$flag = '';
		$limit = 1;

		$top_countries = $this->model_report_sale->getTopOrdersByCountry($limit);

		foreach ($top_countries as $top_country) {
			if ($total_sales > 0) {
				$sale_amount = round((float)$top_country['amount'], 2);
				$sale_total = round((float)$total_sales, 2);

				$flag = ($top_country['iso_code_2']) ? 'view/image/flags/' . strtolower($top_country['iso_code_2']) . '.png' : '';
				$circle_percent = $sale_amount / $sale_total;
			} else {
				$flag = '';
				$circle_percent = 1;
			}

			$this->data['top_countries'][] = array(
				'amount' => $circle_percent,
				'country' => ($top_country['iso_code_2']) ? $top_country['iso_code_2'] : '00'
			);
		}

		$this->data['top_flag'] = $flag;

		// Tab Orders
		$this->data['orders'] = array();

		$data = array(
			'sort'  => 'o.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 10
		);

		$results = $this->model_sale_order->getOrders($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			);

			$customer_group = $this->model_sale_customer->getOrdersCustomersGroup($result['customer_id']);

			$orders_total = $this->model_sale_customer->getTotalCustomersOrders($result['customer_id']);
			$orders_missed = $this->model_sale_customer->getTotalCustomersOrdersMissed($result['customer_id']);

			$orders_passed = $orders_total - $orders_missed;
			$orders_conversion = ($orders_passed * 100) / $orders_total;

			$this->data['orders'][] = array(
				'order_id'       => $result['order_id'],
				'customer'       => $result['customer'],
				'customer_group' => $result['customer_id'] ? $customer_group : $this->language->get('text_guest'),
				'passed'         => ((int)$orders_passed > 0) ? '<span class="passed">' . (int)$orders_passed . '</span>' : '<span class="disabled">' . (int)$orders_passed . '</span>',
				'missed'         => ((int)$orders_missed > 0) ? '<span class="missed">' . (int)$orders_missed . '</span>' : '<span class="disabled">' . (int)$orders_missed . '</span>',
				'conversion'     => round($orders_conversion, 2) . '%',
				'date_added'     => date($this->language->get('date_format_time'), strtotime($result['date_added'])),
				'status'         => $result['status'],
				'total'          => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'action'         => $action
			);
		}

		// Tab Customers
		$this->data['customers'] = array();

		$data = array(
			'sort'  => 'c.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 10
		);

		$customer_results = $this->model_sale_customer->getCustomers($data);

		foreach ($customer_results as $customer_result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $customer_result['customer_id'], 'SSL')
			);

			$action_passed = array();

			$action_passed[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_email=' . $customer_result['email'] . '&filter_customer=' . $customer_result['name'], 'SSL')
			);

			$action_missed = array();

			$action_missed[] = array(
				'text' => $this->language->get('text_view'),
                'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_email=' . $customer_result['email'] . '&filter_order_status_id=0', 'SSL')
			);

			if ($this->config->get('config_customer_dob')) {
				$customer_age = date_diff(date_create($customer_result['date_of_birth']), date_create('today'))->y;
			} else {
				$customer_age = '';
			}

			$customer_deleted = $this->model_sale_customer->checkCustomersDeletedId($customer_result['customer_id']);

			$this->data['customers'][] = array(
				'customer_id'    => $customer_result['customer_id'],
				'name'           => $customer_result['name'],
				'age'            => $customer_age,
				'email'          => $customer_result['email'],
				'customer_group' => $customer_result['customer_group'] ? $customer_result['customer_group'] : $this->language->get('text_guest'),
				'approved'       => $customer_result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'         => (!$customer_deleted) ? $customer_result['status'] : 2,
				'date_added'     => date($this->language->get('date_format_short'), strtotime($customer_result['date_added'])),
				'orders_passed'  => $this->model_sale_customer->getTotalCustomersOrders($customer_result['customer_id']),
				'orders_missed'  => $this->model_sale_customer->getTotalCustomersOrdersMissed($customer_result['customer_id']),
				'action_passed'  => $action_passed,
				'action_missed'  => $action_missed,
				'action'         => $action
			);
		}

		// Tab Reviews
		$this->data['reviews'] = array();

		$data = array(
			'sort'  => 'r.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 10
		);

		$review_results = $this->model_catalog_review->getReviews($data);

		foreach ($review_results as $review_result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/review/update', 'token=' . $this->session->data['token'] . '&review_id=' . $review_result['review_id'], 'SSL')
			);

			$action_rated = array();

			$action_rated[] = array(
				'text' => $this->language->get('text_view'),
                'href' => $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . '&filter_review=' . $review_result['review_id'] . '&filter_order_status_id=0', 'SSL')
			);

			$this->data['reviews'][] = array(
				'review_id'    => $review_result['review_id'],
				'name'         => $review_result['name'],
				'author'       => $review_result['author'],
				'rating'       => $review_result['rating'],
				'status'       => $review_result['status'],
				'date_added'   => date($this->language->get('date_format_time'), strtotime($review_result['date_added'])),
				'rating_total' => $this->model_catalog_review->getTotalProductReviews($review_result['product_id']),
				'action_rated' => $action_rated,
				'action'       => $action
			);
		}

		// Tab Affiliates
		$this->data['affiliates'] = array();

		$data = array(
			'sort'  => 'a.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 10
		);

		$affiliate_results = $this->model_sale_affiliate->getAffiliates($data);

		foreach ($affiliate_results as $affiliate_result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/affiliate/update', 'token=' . $this->session->data['token'] . '&affiliate_id=' . $affiliate_result['affiliate_id'], 'SSL')
			);

			$this->data['affiliates'][] = array(
				'affiliate_id' => $affiliate_result['affiliate_id'],
				'name'         => $affiliate_result['name'],
				'email'        => $affiliate_result['email'],
				'code'         => $affiliate_result['code'],
				'balance'      => $this->currency->format($affiliate_result['balance'], $this->config->get('config_currency')),
				'status'       => $affiliate_result['status'],
				'approved'     => $affiliate_result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'date_added'   => date($this->language->get('date_format_short'), strtotime($affiliate_result['date_added'])),
				'action'       => $action
			);
		}

		// Tab Returns
		$this->data['returns'] = array();

		$data = array(
			'sort'  => 'r.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 10
		);

		$return_results = $this->model_sale_return->getReturns($data);

    	foreach ($return_results as $return_result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/return/info', 'token=' . $this->session->data['token'] . '&return_id=' . $return_result['return_id'], 'SSL')
			);

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/return/update', 'token=' . $this->session->data['token'] . '&return_id=' . $return_result['return_id'], 'SSL')
			);

			$action_return = array();

			$action_return[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/return', 'token=' . $this->session->data['token'] . '&filter_email=' . $return_result['email'], 'SSL')
			);

			$this->data['returns'][] = array(
				'return_id'      => $return_result['return_id'],
				'order_id'       => $return_result['order_id'],
				'customer'       => $return_result['customer'],
				'product'        => $return_result['product'],
				'status'         => $return_result['status'],
				'date_added'     => date($this->language->get('date_format_time'), strtotime($return_result['date_added'])),
                'return_history' => $this->model_sale_customer->getTotalCustomersReturns($return_result['customer_id']),
				'action_return'  => $action_return,
				'action'         => $action
			);
		}

		// Tab Uploads
		$this->data['uploads'] = array();

		$data = array(
			'sort'  => 'date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 10
		);

		$upload_results = $this->model_tool_upload->getUploads($data);

		foreach ($upload_results as $upload_result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_download'),
				'href' => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_result['code'], 'SSL')
			);

			$this->data['uploads'][] = array(
				'upload_id'  => $upload_result['upload_id'],
				'name'       => $upload_result['name'],
				'filename'   => $upload_result['filename'],
				'date_added' => date($this->language->get('date_format_time'), strtotime($upload_result['date_added'])),
				'action'     => $action
			);
		}

		// Top 5 Data report
		$data_reports = array(
			'order' => 'DESC',
			'start' => 0,
			'limit' => 5
		);

		// Best Seller report
		$this->language->load('report/product_purchased');

		$this->load->model('report/product');

		$this->data['sellers'] = array();

		$purchased_results = $this->model_report_product->getPurchased($data_reports);

		foreach ($purchased_results as $purchased_result) {
			$product_purchased_length = strlen(utf8_decode($purchased_result['name']));

			if ($product_purchased_length > 24) {
				$product_purchased = substr(strip_tags($purchased_result['name']), 0, 24) . '..';
			} else {
				$product_purchased = $purchased_result['name'];
			}

			$model_purchased_length = strlen(utf8_decode($purchased_result['model']));

			if ($model_purchased_length > 12) {
				$model_purchased = substr(strip_tags($purchased_result['model']), 0, 12) . '..';
			} else {
				$model_purchased = $purchased_result['model'];
			}

			$this->data['sellers'][] = array(
				'name'     => $product_purchased,
				'model'    => $model_purchased,
				'quantity' => $purchased_result['quantity'],
				'total'    => $this->currency->format($purchased_result['total'], $this->config->get('config_currency')),
				'href'     => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $purchased_result['product_id'], 'SSL')
			);
		}

		// Most Viewed report
		$this->language->load('report/product_viewed');

		$this->load->model('report/product');

		$this->data['views'] = array();

		$product_views_total = $this->model_report_product->getTotalProductViews();

		$viewed_results = $this->model_report_product->getProductsViewed($data_reports);

		foreach ($viewed_results as $viewed_result) {
			$product_viewed_length = strlen(utf8_decode($viewed_result['name']));

			if ($product_viewed_length > 24) {
				$product_viewed = substr(strip_tags($viewed_result['name']), 0, 24) . '..';
			} else {
				$product_viewed = $viewed_result['name'];
			}

			$model_viewed_length = strlen(utf8_decode($viewed_result['model']));

			if ($model_viewed_length > 12) {
				$model_viewed = substr(strip_tags($viewed_result['model']), 0, 12) . '..';
			} else {
				$model_viewed = $viewed_result['model'];
			}

			if ($viewed_result['viewed']) {
				$percent = round($viewed_result['viewed'] / (int)$product_views_total * 100, 2);
			} else {
				$percent = 0;
			}

			$this->data['views'][] = array(
				'name'    => $product_viewed,
				'model'   => $model_viewed,
				'viewed'  => $viewed_result['viewed'],
				'percent' => $percent . '%',
				'href'    => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $viewed_result['product_id'], 'SSL')
			);
		}

		// Best Customer report
		$this->language->load('report/customer_order');

		$this->load->model('report/customer');

		$this->data['clients'] = array();

		$client_results = $this->model_report_customer->getOrders($data_reports);

		foreach ($client_results as $client_result) {
			$client_length = strlen(utf8_decode($client_result['customer']));

			if ($client_length > 24) {
				$client = substr(strip_tags($client_result['customer']), 0, 24) . '..';
			} else {
				$client = $client_result['customer'];
			}

			$this->data['clients'][] = array(
				'customer' => $client,
				'orders'   => $client_result['orders'],
				'products' => $client_result['products'],
				'total'    => $this->currency->format($client_result['total'], $this->config->get('config_currency')),
				'href'     => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $client_result['customer_id'], 'SSL')
			);
		}

		// Currency auto-update
		if ($this->config->get('config_currency_auto') && extension_loaded('curl')) {
			$this->load->model('localisation/currency');

			if ($this->config->get('config_alpha_vantage')) {
				$this->model_localisation_currency->updateAlphaVantageCurrencies();
			} else {
				$this->model_localisation_currency->updateCurrencies();
			}
		}

		$this->template = 'common/home.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function chart() {
		$this->language->load('common/home');

		$data = array();

		$data['cart'] = array();
		$data['order'] = array();
		$data['customer'] = array();
		$data['xaxis'] = array();

		$data['cart']['label'] = $this->language->get('text_cart');
		$data['order']['label'] = $this->language->get('text_order');
		$data['customer']['label'] = $this->language->get('text_customer');

		$data['cart']['data'] = array();
		$data['order']['data'] = array();
		$data['customer']['data'] = array();

		if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'month';
		}

		$complete_status_id = $this->config->get('config_complete_status_id');

		switch ($range) {
			case 'day':
				for ($i = 0; $i < 24; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id <> '" . (int)$complete_status_id . "' AND (DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "') GROUP BY HOUR(date_added) ORDER BY date_added ASC");

					if ($query->num_rows) {
						$data['cart']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['cart']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$complete_status_id . "' AND (DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "') GROUP BY HOUR(date_added) ORDER BY date_added ASC");

					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "' GROUP BY HOUR(date_added) ORDER BY date_added ASC");

					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}

					$data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
				}
				break;
				default:
			case 'week':
				$date_start = strtotime('-' . date('w') . ' days');

				for ($i = 0; $i < 7; $i++) {
					$date = date('Y-m-d', $date_start + ($i * 86400));

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id <> '" . (int)$complete_status_id . "' AND DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");

					if ($query->num_rows) {
						$data['cart']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['cart']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$complete_status_id . "' AND DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");

					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");

					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}

					$data['xaxis'][] = array($i, date('D', strtotime($date)));
				}
				break;
			case 'month':
				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id <> '" . (int)$complete_status_id . "' AND (DATE(date_added) = '" . $this->db->escape($date) . "') GROUP BY DAY(date_added)");

					if ($query->num_rows) {
						$data['cart']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['cart']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$complete_status_id . "' AND (DATE(date_added) = '" . $this->db->escape($date) . "') GROUP BY DAY(date_added)");

					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DAY(date_added)");

					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}

					$data['xaxis'][] = array($i, date('j', strtotime($date)));
				}
				break;
			case 'year':
				for ($i = 1; $i <= 12; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id <> '" . (int)$complete_status_id . "' AND YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");

					if ($query->num_rows) {
						$data['cart']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['cart']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$complete_status_id . "' AND YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");

					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");

					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}

					$data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
				}
				break;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	public function login() {
		if ($this->config->get('config_secure') && !$this->request->isSecure() && strpos(HTTPS_SERVER, 'https') === 0) {
			$this->user->logout();

			return $this->redirect($this->url->link('common/login', '', 'SSL'));
		}

		$route = '';

		if (isset($this->request->get['route'])) {
			$part = explode('/', $this->request->get['route']);

			if (isset($part[0])) {
				$route .= $part[0];
			}

			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}
		}

		$ignore = array(
			'common/login',
			'common/forgotten',
			'common/reset'
		);

		if (!$this->user->isLogged() && !in_array($route, $ignore)) {
			return $this->forward('common/login');
		}

		if (isset($this->request->get['route'])) {
			$ignore = array(
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/reset',
				'error/not_found',
				'error/permission'
			);

			$config_ignore = array();

			if ($this->config->get('config_token_ignore')) {
				$config_ignore = unserialize($this->config->get('config_token_ignore'));
			}

			$ignore = array_merge($ignore, $config_ignore);

			if (!in_array($route, $ignore) && (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token']))) {
				return $this->forward('common/login');
			}

		} else {
			if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
				return $this->forward('common/login');
			}
		}
	}

	public function map() {
		$json = array();

		$this->language->load('common/home');

		$this->load->model('report/sale');

		$results = $this->model_report_sale->getTotalOrdersByCountry();

		foreach ($results as $result) {
			$json[strtolower($result['iso_code_2'])] = array(
				'orders' => $this->language->get('text_total_order'),
				'total'  => $result['total'],
				'sales'  => $this->language->get('text_total_sale'),
				'amount' => $this->currency->format($result['amount'], $this->config->get('config_currency'))
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function permission() {
		if (isset($this->request->get['route'])) {
			$route = '';

			$part = explode('/', $this->request->get['route']);

			if (isset($part[0])) {
				$route .= $part[0];
			}

			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}

			$ignore = array(
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/notification',
				'common/reset',
				'error/not_found',
				'error/permission'
			);

			if (!in_array($route, $ignore) && !$this->user->hasPermission('access', $route)) {
				return $this->forward('error/permission');
			}
		}
	}
}
