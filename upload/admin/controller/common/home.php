<?php
class ControllerCommonHome extends Controller {

	public function index() {
		$this->language->load('common/home');

		$this->document->setTitle($this->language->get('heading_title'));

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
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['tab_order'] = $this->language->get('tab_order');
		$this->data['tab_customer'] = $this->language->get('tab_customer');
		$this->data['tab_review'] = $this->language->get('tab_review');
		$this->data['tab_affiliate'] = $this->language->get('tab_affiliate');

		$this->data['column_order'] = $this->language->get('column_order');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_firstname'] = $this->language->get('column_firstname');
		$this->data['column_lastname'] = $this->language->get('column_lastname');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_author'] = $this->language->get('column_author');
		$this->data['column_rating'] = $this->language->get('column_rating');
		$this->data['column_affiliate'] = $this->language->get('column_affiliate');
		$this->data['column_newsletter'] = $this->language->get('column_newsletter');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['entry_range'] = $this->language->get('entry_range');

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$this->data['error_install'] = $this->language->get('error_install');
		} else {
			$this->data['error_install'] = '';
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

		$error_log_file = DIR_LOGS . $this->config->get('config_error_filename');

		if (file_exists($error_log_file)) {
			$this->data['error_log_status'] = file_get_contents($error_log_file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['error_log_status'] = '';
		}

		$this->data['open_error_log'] = $this->url->link('tool/error_log', 'token=' . $this->session->data['token'], 'SSL');

		// Email log
		$email_log_file = DIR_SYSTEM . 'mails/mails.txt';

		if (file_exists($email_log_file)) {
			$this->data['mail_log_status'] = file_get_contents($email_log_file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['mail_log_status'] = '';
		}

		$this->data['open_mail_log'] = $this->url->link('tool/mail_log', 'token=' . $this->session->data['token'], 'SSL');

		// Breadcrumbs
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['token'] = $this->session->data['token'];

		// Overview
		$this->load->model('sale/order');

		$this->data['total_sale'] = $this->currency->format($this->model_sale_order->getTotalSales(), $this->config->get('config_currency'));
		$this->data['total_sale_year'] = $this->currency->format($this->model_sale_order->getTotalSalesByYear(date('Y')), $this->config->get('config_currency'));
		$this->data['total_sale_month'] = $this->currency->format($this->model_sale_order->getTotalSalesByMonth(date('m')), $this->config->get('config_currency'));

		$this->load->model('sale/customer');

		$this->data['total_customer'] = $this->model_sale_customer->getTotalCustomers();
		$this->data['total_customer_approval'] = $this->model_sale_customer->getTotalCustomersAwaitingApproval();

		$this->load->model('catalog/review');

		$this->data['total_review'] = $this->model_catalog_review->getTotalReviews();
		$this->data['total_review_approval'] = $this->model_catalog_review->getTotalReviewsAwaitingApproval();

		$this->load->model('sale/affiliate');

		$this->data['total_affiliate'] = $this->model_sale_affiliate->getTotalAffiliates();
		$this->data['total_affiliate_approval'] = $this->model_sale_affiliate->getTotalAffiliatesAwaitingApproval();

		if ($this->config->get('config_affiliate_disable')) {
			$this->data['allow_affiliate'] = false;
		} else {
			$this->data['allow_affiliate'] = true;
		}

		// Overview Links
		$this->data['view_reviews'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['view_affiliates'] = $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL');

		// Today
		$this->data['total_order'] = $this->model_sale_order->getTotalOrders();

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

		$this->data['total_online'] = $this->model_report_online->getTotalCustomersOnline();

		$this->data['view_online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');

		// Tab Orders
		$this->data['orders'] = array();

		$data = array(
			'sort'  	=> 'o.date_added',
			'order' 	=> 'DESC',
			'start' 	=> 0,
			'limit' 		=> 10
		);

		$results = $this->model_sale_order->getOrders($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text'	=> $this->language->get('text_view'),
				'href'	=> $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			);

			$this->data['orders'][] = array(
				'order_id'   		=> $result['order_id'],
				'customer'   	=> $result['customer'],
				'date_added' 	=> date($this->language->get('date_format_time'), strtotime($result['date_added'])),
				'status'     		=> $result['status'],
				'total'      		=> $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'action'     		=> $action
			);
		}

		// Tab Customers
		$this->data['customers'] = array();
		
		$data = array(
			'sort'  	=> 'c.date_added',
			'order' 	=> 'DESC',
			'start' 	=> 0,
			'limit' 		=> 10
		);

		$customer_results = $this->model_sale_customer->getCustomers($data);

		foreach ($customer_results as $customer_result) {
			$action = array();

			$action[] = array(
				'text'	=> $this->language->get('text_edit'),
				'href'	=> $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $customer_result['customer_id'], 'SSL')
			);
			
			$this->data['customers'][] = array(
				'customer_id' 		=> $customer_result['customer_id'],
				'name'           		=> $customer_result['name'],
				'email'          		=> $customer_result['email'],
				'customer_group' 	=> $customer_result['customer_group'],
				'status'         		=> $customer_result['status'],
				'approved'       	=> $customer_result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'newsletter'     	=> $customer_result['newsletter'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'date_added'     	=> date($this->language->get('date_format_short'), strtotime($customer_result['date_added'])),
				'action'         		=> $action
			);
		}

		// Tab Reviews
		$this->data['reviews'] = array();

		$data = array(
			'sort'  	=> 'r.date_added',
			'order' 	=> 'DESC',
			'start' 	=> 0,
			'limit' 		=> 10
		);

		$review_results = $this->model_catalog_review->getReviews($data);

		foreach ($review_results as $review_result) {
			$action = array();

			$action[] = array(
				'text'	=> $this->language->get('text_edit'),
				'href'	=> $this->url->link('catalog/review/update', 'token=' . $this->session->data['token'] . '&review_id=' . $review_result['review_id'], 'SSL')
			);

			$this->data['reviews'][] = array(
				'review_id'  	=> $review_result['review_id'],
				'name'       		=> $review_result['name'],
				'author'     		=> $review_result['author'],
				'rating'     		=> $review_result['rating'],
				'status'     		=> $review_result['status'],
				'date_added' 	=> date($this->language->get('date_format_time'), strtotime($review_result['date_added'])),
				'selected'   		=> isset($this->request->post['selected']) && in_array($review_result['review_id'], $this->request->post['selected']),
				'action'     		=> $action
			);
		}

		// Tab Affiliates
		$this->data['affiliates'] = array();

		$data = array(
			'sort'  	=> 'a.date_added',
			'order' 	=> 'DESC',
			'start' 	=> 0,
			'limit' 		=> 10
		);

		$affiliate_results = $this->model_sale_affiliate->getAffiliates($data);

		foreach ($affiliate_results as $affiliate_result) {
			$action = array();

			$action[] = array(
				'text'	=> $this->language->get('text_edit'),
				'href'	=> $this->url->link('sale/affiliate/update', 'token=' . $this->session->data['token'] . '&affiliate_id=' . $affiliate_result['affiliate_id'], 'SSL')
			);

			$this->data['affiliates'][] = array(
				'affiliate_id' 	=> $affiliate_result['affiliate_id'],
				'name'         	=> $affiliate_result['name'],
				'email'        	=> $affiliate_result['email'],
				'balance'      	=> $this->currency->format($affiliate_result['balance'], $this->config->get('config_currency')),
				'status'       	=> $affiliate_result['status'],
				'approved'     	=> $affiliate_result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'date_added' 	=> date($this->language->get('date_format_short'), strtotime($affiliate_result['date_added'])),
				'selected'     	=> isset($this->request->post['selected']) && in_array($affiliate_result['affiliate_id'], $this->request->post['selected']),
				'action'       	=> $action
			);
		}

		// Currency auto-update
		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency');

			$this->model_localisation_currency->updateCurrencies();
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

		$data['order'] = array();
		$data['customer'] = array();
		$data['xaxis'] = array();

		$data['order']['label'] = $this->language->get('text_order');
		$data['customer']['label'] = $this->language->get('text_customer');

		$data['order']['data'] = array();
		$data['customer']['data'] = array();

		if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'month';
		}

		switch ($range) {
			case 'day':
				for ($i = 0; $i < 24; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id >= '" . (int)$this->config->get('config_complete_status_id') . "' AND (DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "') GROUP BY HOUR(date_added) ORDER BY date_added ASC");

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
			case 'week':
				$date_start = strtotime('-' . date('w') . ' days');

				for ($i = 0; $i < 7; $i++) {
					$date = date('Y-m-d', $date_start + ($i * 86400));

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id >= '" . (int)$this->config->get('config_complete_status_id') . "' AND DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");

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

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id >= '" . (int)$this->config->get('config_complete_status_id') . "' AND (DATE(date_added) = '" . $this->db->escape($date) . "') GROUP BY DAY(date_added)");

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
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id >= '" . (int)$this->config->get('config_complete_status_id') . "' AND YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");

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
			default:
		}

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
				'common/home',
				'common/login',
				'common/logout',
				'common/forgotten',
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
?>