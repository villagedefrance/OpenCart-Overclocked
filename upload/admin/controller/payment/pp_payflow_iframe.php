<?php
class ControllerPaymentPPPayflowIframe extends Controller {
	const DEBUG_LOG_FILE = 'pp_payflow_iframe.log';
	private $errors;

	public function index() {
		$this->errors = array();

		$this->language->load('payment/pp_payflow_iframe');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('pp_payflow_iframe', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/pp_payflow_iframe', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}

		} else {
			$this->data['errors'] = $this->errors;
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_iframe'] = $this->language->get('text_iframe');
		$this->data['text_redirect'] = $this->language->get('text_redirect');

		$this->data['entry_partner'] = $this->language->get('entry_partner');
		$this->data['entry_vendor'] = $this->language->get('entry_vendor');
		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_cancel_url'] = $this->language->get('entry_cancel_url');
		$this->data['entry_error_url'] = $this->language->get('entry_error_url');
		$this->data['entry_return_url'] = $this->language->get('entry_return_url');
		$this->data['entry_silent_post_url'] = $this->language->get('entry_silent_post_url');

		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_transaction_method'] = $this->language->get('entry_transaction_method');
		$this->data['entry_checkout_method'] = $this->language->get('entry_checkout_method');
		$this->data['entry_timeout'] = $this->language->get('entry_timeout');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['help_partner'] = $this->language->get('help_partner');
		$this->data['help_vendor'] = $this->language->get('help_vendor');
		$this->data['help_username'] = $this->language->get('help_username');
		$this->data['help_password'] = $this->language->get('help_password');
		$this->data['help_test'] = $this->language->get('help_test');
		$this->data['help_debug'] = $this->language->get('help_debug');
		$this->data['help_transaction_method'] = $this->language->get('help_transaction_method');
		$this->data['help_checkout_method'] = $this->language->get('help_checkout_method');
		$this->data['help_timeout'] = $this->language->get('help_timeout');
		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_total_max'] = $this->language->get('help_total_max');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_pp_manager'] = $this->language->get('button_pp_manager');

		$this->data['tab_api'] = $this->language->get('tab_api');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_debug_log'] = $this->language->get('tab_debug_log');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/pp_payflow_iframe', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/pp_payflow_iframe', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['pp_payflow_iframe_vendor'])) {
			$this->data['pp_payflow_iframe_vendor'] = $this->request->post['pp_payflow_iframe_vendor'];
		} else {
			$this->data['pp_payflow_iframe_vendor'] = $this->config->get('pp_payflow_iframe_vendor');
		}

		if (isset($this->request->post['pp_payflow_iframe_username'])) {
			$this->data['pp_payflow_iframe_username'] = $this->request->post['pp_payflow_iframe_username'];
		} else {
			$this->data['pp_payflow_iframe_username'] = $this->config->get('pp_payflow_iframe_username');
		}

		if (isset($this->request->post['pp_payflow_iframe_password'])) {
			$this->data['pp_payflow_iframe_password'] = $this->request->post['pp_payflow_iframe_password'];
		} else {
			$this->data['pp_payflow_iframe_password'] = $this->config->get('pp_payflow_iframe_password');
		}

		if (isset($this->request->post['pp_payflow_iframe_partner'])) {
			$this->data['pp_payflow_iframe_partner'] = $this->request->post['pp_payflow_iframe_partner'];
		} else if ($this->config->has('pp_payflow_iframe_partner')) {
			$this->data['pp_payflow_iframe_partner'] = $this->config->get('pp_payflow_iframe_partner');
		} else {
			$this->data['pp_payflow_iframe_partner'] = 'paypal';
		}

		if (isset($this->request->post['pp_payflow_iframe_test'])) {
			$this->data['pp_payflow_iframe_test'] = $this->request->post['pp_payflow_iframe_test'];
		} else {
			$this->data['pp_payflow_iframe_test'] = $this->config->get('pp_payflow_iframe_test');
		}

		if (isset($this->request->post['pp_payflow_iframe_debug'])) {
			$this->data['pp_payflow_iframe_debug'] = $this->request->post['pp_payflow_iframe_debug'];
		} else {
			$this->data['pp_payflow_iframe_debug'] = $this->config->get('pp_payflow_iframe_debug');
		}

		if (isset($this->request->post['pp_payflow_iframe_transaction_method'])) {
			$this->data['pp_payflow_iframe_transaction_method'] = $this->request->post['pp_payflow_iframe_transaction_method'];
		} else {
			$this->data['pp_payflow_iframe_transaction_method'] = $this->config->get('pp_payflow_iframe_transaction_method');
		}

		if (isset($this->request->post['pp_payflow_iframe_checkout_method'])) {
			$this->data['pp_payflow_iframe_checkout_method'] = $this->request->post['pp_payflow_iframe_checkout_method'];
		} else {
			$this->data['pp_payflow_iframe_checkout_method'] = $this->config->get('pp_payflow_iframe_checkout_method');
		}

		if (isset($this->request->post['pp_payflow_iframe_timeout'])) {
			$this->data['pp_payflow_iframe_timeout'] = $this->request->post['pp_payflow_iframe_timeout'];
		} else if ($this->config->has('pp_payflow_iframe_timeout')) {
			$this->data['pp_payflow_iframe_timeout'] = $this->config->get('pp_payflow_iframe_timeout');
		} else {
			$this->data['pp_payflow_iframe_timeout'] = 30;
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['pp_payflow_iframe_order_status_id'])) {
			$this->data['pp_payflow_iframe_order_status_id'] = $this->request->post['pp_payflow_iframe_order_status_id'];
		} else {
			$this->data['pp_payflow_iframe_order_status_id'] = $this->config->get('pp_payflow_iframe_order_status_id');
		}

		if (isset($this->request->post['pp_payflow_iframe_total'])) {
			$this->data['pp_payflow_iframe_total'] = $this->request->post['pp_payflow_iframe_total'];
		} else {
			$this->data['pp_payflow_iframe_total'] = $this->config->get('pp_payflow_iframe_total');
		}

		if (isset($this->request->post['pp_payflow_iframe_total_max'])) {
			$this->data['pp_payflow_iframe_total_max'] = $this->request->post['pp_payflow_iframe_total_max'];
		} else {
			$this->data['pp_payflow_iframe_total_max'] = $this->config->get('pp_payflow_iframe_total_max');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['pp_payflow_iframe_geo_zone_id'])) {
			$this->data['pp_payflow_iframe_geo_zone_id'] = $this->request->post['pp_payflow_iframe_geo_zone_id'];
		} else {
			$this->data['pp_payflow_iframe_geo_zone_id'] = $this->config->get('pp_payflow_iframe_geo_zone_id');
		}

		if (isset($this->request->post['pp_payflow_iframe_status'])) {
			$this->data['pp_payflow_iframe_status'] = $this->request->post['pp_payflow_iframe_status'];
		} else {
			$this->data['pp_payflow_iframe_status'] = $this->config->get('pp_payflow_iframe_status');
		}

		if (isset($this->request->post['pp_payflow_iframe_sort_order'])) {
			$this->data['pp_payflow_iframe_sort_order'] = $this->request->post['pp_payflow_iframe_sort_order'];
		} else {
			$this->data['pp_payflow_iframe_sort_order'] = $this->config->get('pp_payflow_iframe_sort_order');
		}

		$this->data['cancel_url'] = ($this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG) . 'index.php?route=payment/pp_payflow_iframe/pf_cancel';
		$this->data['error_url'] = ($this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG) . 'index.php?route=payment/pp_payflow_iframe/pf_error';
		$this->data['return_url'] = ($this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG) . 'index.php?route=payment/pp_payflow_iframe/pf_return';
		$this->data['silent_post_url'] = ($this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG) . 'index.php?route=payment/pp_payflow_iframe/pf_silent_post';

		// Debug Log
		if ($this->data['pp_payflow_iframe_debug']) {
			$this->data['button_debug_clear'] = $this->language->get('button_clear');
			$this->data['button_debug_download'] = $this->language->get('button_download');

			$this->data['debug_clear'] = $this->url->link('payment/pp_payflow_iframe/debug_clear', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['debug_download'] = $this->url->link('payment/pp_payflow_iframe/debug_download', 'token=' . $this->session->data['token'], 'SSL');

			// Create directory if it does not exist
			if (!is_dir(DIR_LOGS)) {
				mkdir(DIR_LOGS, 0777);
			}

			// Create file if it does not exist
			$debug_file = DIR_LOGS . (self::DEBUG_LOG_FILE);

			if (file_exists($debug_file)) {
				$this->data['debug_log'] = file_get_contents($debug_file, FILE_USE_INCLUDE_PATH, null);
			} else {
				$this->data['debug_log'] = '';
			}

			clearstatcache();
		}

		$this->template = 'payment/pp_payflow_iframe.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/pp_payflow_iframe')) {
			$this->errors['warning'] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['pp_payflow_iframe_vendor'])) {
			$this->errors['vendor'] = $this->language->get('error_vendor');
		}

		if (empty($this->request->post['pp_payflow_iframe_username'])) {
			$this->errors['username'] = $this->language->get('error_username');
		}

		if (empty($this->request->post['pp_payflow_iframe_password'])) {
			$this->errors['password'] = $this->language->get('error_password');
		}

		if (empty($this->request->post['pp_payflow_iframe_partner'])) {
			$this->errors['partner'] = $this->language->get('error_partner');
		}

		return empty($this->errors);
	}

	public function install() {
		$this->load->model('payment/pp_payflow_iframe');

		$this->model_payment_pp_payflow_iframe->install();
	}

	public function uninstall() {
		$this->load->model('payment/pp_payflow_iframe');

		$this->model_payment_pp_payflow_iframe->uninstall();
	}

	public function orderAction() {
		if ($this->config->get('pp_payflow_iframe_status')) {
			$this->language->load('payment/pp_payflow_iframe_order');

			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('payment/pp_payflow_iframe');

			$paypal_order = $this->model_payment_pp_payflow_iframe->getPaypalOrderByOrderId($order_id);

			if ($paypal_order) {
				$this->data['text_payment_info'] = $this->language->get('text_payment_info');
				$this->data['text_transactions'] = $this->language->get('text_transactions');
				$this->data['text_payment_status'] = $this->language->get('text_payment_status');
				$this->data['text_complete'] = $this->language->get('text_complete');
				$this->data['text_incomplete'] = $this->language->get('text_incomplete');
				$this->data['text_amount_captured'] = $this->language->get('text_amount_captured');
				$this->data['text_amount_refunded'] = $this->language->get('text_amount_refunded');
				$this->data['text_amount_remaining'] = $this->language->get('text_amount_remaining');

				$this->data['entry_capture_amount'] = $this->language->get('entry_capture_amount');
				$this->data['entry_capture_complete'] = $this->language->get('entry_capture_complete');
				$this->data['entry_reauthorize_amount'] = $this->language->get('entry_reauthorize_amount');

				$this->data['button_capture'] = $this->language->get('button_capture');
				$this->data['button_reauthorize'] = $this->language->get('button_reauthorize');

				$this->data['msg_void_confirm'] = $this->language->get('msg_void_confirm');
				$this->data['msg_reauthorize_confirm'] = $this->language->get('msg_reauthorize_confirm');

				$this->data['error_capture_amount'] = $this->language->get('error_capture_amount');
				$this->data['error_reauthorize_amount'] = $this->language->get('error_reauthorize_amount');
				$this->data['error_missing_transaction'] = $this->language->get('error_missing_transaction');

				$this->data['token'] = $this->session->data['token'];

				$this->data['order_id'] = $order_id;

				$this->data['paypal_order'] = $paypal_order;

				// Updating display
				$captured = $refunded = $remaining = 0;
				$root_transaction = $this->model_payment_pp_payflow_iframe->getPaypalRootTransactionByOrderId($paypal_order['order_id']);

				if ($root_transaction) {
					switch ($root_transaction['transaction_type']) {
						case 'S': // Sale
							$captured = $root_transaction['amount'];
							$refunded = $this->model_payment_pp_payflow_iframe->getTotalRefunded($paypal_order['order_id']);
							break;
						case 'A': // Authorization
							$captured = $this->model_payment_pp_payflow_iframe->getTotalCaptured($paypal_order['order_id']);
							$refunded = $this->model_payment_pp_payflow_iframe->getTotalRefunded($paypal_order['order_id']);
							break;
						default:
							break;
					}
					$remaining = $root_transaction['amount'] - $captured + $refunded;
				}

				$this->data['paypal_order']['captured'] = $this->currency->format($captured, strtoupper($paypal_order['currency_code']),1 ,true);
				$this->data['paypal_order']['refunded'] = $this->currency->format($refunded, strtoupper($paypal_order['currency_code']),1 ,true);
				$this->data['paypal_order']['remaining'] = $this->currency->format($remaining, strtoupper($paypal_order['currency_code']),1 ,true);
				$this->data['paypal_order']['remaining_raw'] = number_format($remaining, 2, '.', '');

				$this->template = 'payment/pp_payflow_iframe_order.tpl';

				$this->response->setOutput($this->render());
			}
		}
	}

	public function transaction() {
		$this->load->language('payment/pp_payflow_iframe_order');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_transaction_reference'] = $this->language->get('column_transaction_reference');
		$this->data['column_parent_transaction_reference'] = $this->language->get('column_parent_transaction_reference');
		$this->data['column_type'] = $this->language->get('column_type');
		$this->data['column_amount'] = $this->language->get('column_amount');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_actions'] = $this->language->get('column_actions');

		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_void'] = $this->language->get('button_void');
		$this->data['button_refund'] = $this->language->get('button_refund');

		$this->data['transactions'] = array();

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$this->load->model('payment/pp_payflow_iframe');

		$paypal_order = $this->model_payment_pp_payflow_iframe->getPaypalOrderByOrderId($order_id);

		if ($paypal_order) {
			$void_expiration = strtotime('-3 day');
			$refund_expiration = strtotime('-1 month');

			$transactions = $this->model_payment_pp_payflow_iframe->getPaypalTransactionsByOrderId($paypal_order['order_id']);

			foreach ($transactions as $transaction) {
				$actions = array();

				$void_enabled = (empty($paypal_order['complete']) && empty($transaction['void_transaction_reference']) && (strtotime($transaction['date_added']) >= $void_expiration)) ? true : false;
				$refund_enabled = (empty($transaction['void_transaction_reference']) && (strtotime($transaction['date_added']) >= $refund_expiration)) ? true : false;

				switch ($transaction['transaction_type']) {
					case 'V': // Void
						$text_transaction_type = $this->language->get('text_void');
						break;
					case 'S': // Sale
						$text_transaction_type = $this->language->get('text_sale');
						if ($void_enabled) {
							$actions[] = array(
								'title' => $this->language->get('button_void'),
								'id'    => 'button-void-'.$transaction['transaction_reference'],
								'name'  => 'button-void[]',
								'class' => 'button-repair',
								'href'  => 'javascript:doVoid(\'' . $transaction['transaction_reference'] . '\'); void 0;'
							);
						};
						if ($refund_enabled) {
							$actions[] = array(
								'title' => $this->language->get('button_refund'),
								'id'    => 'button-refund-'.$transaction['transaction_reference'],
								'name'  => 'button-refund[]',
								'class' => 'button-delete',
								'href'  => $this->url->link('payment/pp_payflow_iframe/refund', 'transaction_reference=' . $transaction['transaction_reference'] . '&order_id=' . $order_id . '&token=' . $this->session->data['token'], 'SSL')
							);
						};
						break;
					case 'D': // Delayed Capture
						$text_transaction_type = $this->language->get('text_capture');
						if ($void_enabled) {
							$actions[] = array(
								'title' => $this->language->get('button_void'),
								'id'    => 'button-void-'.$transaction['transaction_reference'],
								'name'  => 'button-void[]',
								'class' => 'button-repair',
								'href'  => 'javascript:doVoid(\'' . $transaction['transaction_reference'] . '\'); void 0;'
							);
						};
						if ($refund_enabled) {
							$actions[] = array(
								'title' => $this->language->get('button_refund'),
								'id'    => 'button-refund-'.$transaction['transaction_reference'],
								'name'  => 'button-refund[]',
								'class' => 'button-delete',
								'href'  => $this->url->link('payment/pp_payflow_iframe/refund', 'transaction_reference=' . $transaction['transaction_reference'] . '&order_id=' . $order_id . '&token=' . $this->session->data['token'], 'SSL')
							);
						};
						break;
					case 'A': // Authorization
					case 'F': // Voice authorization
						$text_transaction_type = (empty($transaction['parent_transaction_reference']) ? $this->language->get('text_authorization') : $this->language->get('text_reauthorization'));
						if ($void_enabled) {
							$actions[] = array(
								'title' => $this->language->get('button_void'),
								'id'    => 'button-void-'.$transaction['transaction_reference'],
								'name'  => 'button-void[]',
								'class' => 'button-repair',
								'href'  => 'javascript:doVoid(\'' . $transaction['transaction_reference'] . '\'); void 0;'
							);
						};
						if ($refund_enabled && $transaction['transaction_type'] == 'F') {
							$actions[] = array(
								'title' => $this->language->get('button_refund'),
								'id'    => 'button-refund-'.$transaction['transaction_reference'],
								'name'  => 'button-refund[]',
								'class' => 'button-delete',
								'href'  => $this->url->link('payment/pp_payflow_iframe/refund', 'transaction_reference=' . $transaction['transaction_reference'] . '&order_id=' . $order_id . '&token=' . $this->session->data['token'], 'SSL')
							);
						};
						break;
					case 'C': // Credit (Refund)
						$text_transaction_type = $this->language->get('text_refund');
						if ($void_enabled) {
							$actions[] = array(
								'title' => $this->language->get('button_void'),
								'id'    => 'button-void-'.$transaction['transaction_reference'],
								'name'  => 'button-void[]',
								'class' => 'button-repair',
								'href'  => 'javascript:doVoid(\'' . $transaction['transaction_reference'] . '\'); void 0;'
							);
						};
						break;
					default:
						$text_transaction_type = '';
						break;
				}

				$this->data['transactions'][] = array(
					'transaction_reference'        => $transaction['transaction_reference'],
					'parent_transaction_reference' => $transaction['parent_transaction_reference'],
					'transaction_type'             => $text_transaction_type,
					'void_transaction_reference'   => $transaction['void_transaction_reference'],
					'amount'                       => (!empty($transaction['void_transaction_reference']) ? '<s>' : null) . (!empty($transaction['amount']) ? number_format($transaction['amount'], 2, '.', '') : '') . (!empty($transaction['void_transaction_reference']) ? '</s>' : null),
					'date_added'                   => date($this->language->get('date_format_time'), strtotime($transaction['date_added'])),
					'date_modified'                => date($this->language->get('date_format_time'), strtotime($transaction['date_modified'])),
					'actions'                      => $actions
				);
			}
		}

		$this->template = 'payment/pp_payflow_iframe_transaction.tpl';

		$this->response->setOutput($this->render());
	}

	/*
		NOTE: The "Payflow Gateway Developer Guide and Reference" says "You are allowed to perform ONE delayed capture transaction per authorization transaction".
		The problem is that the merchant has no flexibility with only ONE capture, even if it is the case in test mode.
		And why having a 'CAPTURECOMPLETE' flag if only ONE capture is allowed ?
		All of the changes from Verisign Payflow to Paypal Payments Pro has caused lots of confusion over the years.
		It seems they are now pushing everybody back into the old PayFlow API gateway rather than have also the DoDirectPayment API gateway of PayPal Payments Pro 2.0.
		So the approach taken is: program all as if multiple captures, reauthorizations, refunds were allowed and let Payflow return an error if not.
	*/

	public function do_capture() {
		// Used to capture a previously authorized (A or F) transaction. Capture can be full or partial amounts.
		$json = array();

		$this->language->load('payment/pp_payflow_iframe_order');

		if (isset($this->request->post['order_id']) && ($this->request->post['order_id'] != '') && isset($this->request->post['amount'])) {
			$order_id = $this->request->post['order_id'];
			$amount = (double)$this->request->post['amount'];

			// If this is the final amount to capture or not.
			$complete = (isset($this->request->post['complete']) && $this->request->post['complete']) ?  true : false;

			$this->load->model('payment/pp_payflow_iframe');

			$paypal_order = $this->model_payment_pp_payflow_iframe->getPaypalOrderByOrderId($order_id);

			if ($paypal_order) {
				if (empty($paypal_order['complete'])) {
					$authorization = $this->model_payment_pp_payflow_iframe->getPaypalLastAuthorizationByOrderId($order_id);

					if ($authorization) {
						if (empty($authorization['void_transaction_reference'])) {
							// Ensure the capture amount is within the allowed limit for this (re)authorization.
							$already_captured = 0;
							// An authorization has M captures
							$captures = $this->model_payment_pp_payflow_iframe->getPaypalCapturesByParentReference($authorization['transaction_reference']);

							foreach ($captures as $capture) {
								if (empty($capture['void_transaction_reference'])) {
									// A capture has N refunds
									$already_refunded = 0;
									$refunds = $this->model_payment_pp_payflow_iframe->getPaypalRefundsByParentReference($capture['transaction_reference']);

									foreach ($refunds as $refund) {
										if (empty($refund['void_transaction_reference'])) {
											$already_refunded += $refund['amount'];
										}
									}
									$already_captured += $capture['amount'] - $already_refunded;
								}
							}

							// Limitation to 115%
							if ($amount <= ($authorization['amount'] * 1.15) - $already_captured) {

								$request = array(
									'TENDER'          => 'C',  // Credit Card
									'TRXTYPE'         => 'D',  // Delayed Capture
									'ORIGID'          => $authorization['transaction_reference'],
									'AMT'             => number_format($amount, 2, '.', ''),
									'CAPTURECOMPLETE'	=> ($complete ? 'Y' : 'N')
								);

								$response = $this->model_payment_pp_payflow_iframe->call($request);

								if ($response === false) {
									$json['error'] = $this->language->get('error_connection');

								} elseif (is_array($response) && isset($response['RESULT'])) {
									if (intval($response['RESULT']) == 0) {
										$data = array(
											'order_id'                     => $order_id,
											'transaction_type'             => $request['TRXTYPE'],
											'transaction_reference'        => $response['PNREF'],
											'parent_transaction_reference' => $request['ORIGID'],
											'amount'                       => $amount,
										);

										$this->model_payment_pp_payflow_iframe->addPaypalTransaction($data);

										// Updating display
										$captured = $refunded = $remaining = 0;
										$root_transaction = $this->model_payment_pp_payflow_iframe->getPaypalRootTransactionByOrderId($order_id);

										if ($root_transaction) {
											switch ($root_transaction['transaction_type']) {
												case 'S': // Sale
													$captured = $root_transaction['amount'];
													$refunded = $this->model_payment_pp_payflow_iframe->getTotalRefunded($order_id);
													break;
												case 'A': // Authorization
													$captured = $this->model_payment_pp_payflow_iframe->getTotalCaptured($order_id);
													$refunded = $this->model_payment_pp_payflow_iframe->getTotalRefunded($order_id);
													break;
												default:
													break;
											}
											$remaining = $root_transaction['amount'] - $captured + $refunded;
										}

										$json['to_display'] = array(
											'captured'   => $this->currency->format($captured, strtoupper($paypal_order['currency_code']), 1, true),
											'refunded'   => $this->currency->format($refunded, strtoupper($paypal_order['currency_code']), 1, true),
											'remaining'   => $this->currency->format($remaining, strtoupper($paypal_order['currency_code']), 1, true),
											'remaining_raw'  => number_format($remaining, 2, '.', ''),
										);

										if ($complete || ($remaining <= 0)) {
											$this->model_payment_pp_payflow_iframe->setPaypalOrderComplete($order_id, 1);

											$json['complete'] = $this->language->get('text_complete');
										}

										$json['success'] = $this->language->get('msg_capture_success');

									} elseif (intval($response['RESULT']) < 0) {
										$json['error'] = sprintf($this->language->get('error_failed_communication'), $response['RESULT'], $response['RESPMSG']);
									} else {
										$json['error'] = sprintf($this->language->get('error_declined_transaction'), $response['RESULT'], $response['RESPMSG']);
									}

								} else {
									$json['error'] = $this->language->get('error_response');
								}

							} else {
								$json['error'] = $this->language->get('error_capture_over_limit');
							}

						} else {
							$json['error'] = sprintf($this->language->get('error_voided_transaction'), $authorization['transaction_reference']);
						}

					} else {
						$json['error'] = $this->language->get('error_missing_authorization');
					}

				} else {
					$json['error'] = $this->language->get('error_complete_paypal_order');
				}

			} else {
				$json['error'] = $this->language->get('error_missing_paypal_order');
			}

		} else {
			$json['error'] = $this->language->get('error_missing_data');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function do_void() {
		// Used to void delayed capture, sale, credit, authorization, and voice authorization transactions.
		// Once a void is processed, it can't be reversed. You must issue a new authorization or sale by using a "New Reference Transaction."
		$json = array();

		$this->language->load('payment/pp_payflow_iframe_order');

		if (isset($this->request->post['order_id']) && ($this->request->post['order_id'] != '') && isset($this->request->post['pnref']) && $this->request->post['pnref'] != '') {
			$order_id = $this->request->post['order_id'];
			$pnref = $this->request->post['pnref'];

			$this->load->model('payment/pp_payflow_iframe');

			$paypal_order = $this->model_payment_pp_payflow_iframe->getPaypalOrderByOrderId($order_id);

			if ($paypal_order) {
				if (empty($paypal_order['complete'])) {
					$transaction = $this->model_payment_pp_payflow_iframe->getPaypalTransactionByReference($pnref);

					if ($transaction) {
						if (in_array($transaction['transaction_type'], array('S', 'A', 'F', 'D', 'C'))) {
							$is_authorization = ($transaction['transaction_type'] == 'A' || $transaction['transaction_type'] == 'F') ? true : false;

							// You cannot void an already voided transaction, an authorization having capture(s), a capture having refund(s).
							if (empty($transaction['void_transaction_reference'])) {
								$void_possible = true;

								switch ($transaction['transaction_type']) {
									case 'S': // Sale
									case 'C': // Credit (Refund)
										break;
									case 'A': // Authorization
									case 'F': // Voice authorization
									case 'D': // Delayed Capture
										$children = $this->model_payment_pp_payflow_iframe->getPaypalTransactionsByParentReference($transaction['transaction_reference']);

										foreach ($children as $child) {
											if (empty($child['void_transaction_reference'])) {
												$void_possible = false;
												$json['error'] = sprintf($this->language->get('error_transaction_has_children'), $transaction['transaction_reference']);
												break;
											}
										}
										break;
									default:
										$void_possible = false;
										break;
								}

								if ($void_possible) {
									$request = array(
										'TENDER'  => 'C',
										'TRXTYPE' => 'V',
										'ORIGID'  => $pnref
									);

									$response = $this->model_payment_pp_payflow_iframe->call($request);

									if ($response === false) {
										$json['error'] = $this->language->get('error_connection');

									} elseif (is_array($response) && isset($response['RESULT'])) {
										if (intval($response['RESULT']) == 0) {
											// Records the void
											$void_data = array(
												'order_id'                     => $order_id,
												'transaction_reference'        => $response['PNREF'],
												'parent_transaction_reference' => $request['ORIGID'],
												'transaction_type'             => $request['TRXTYPE'],
											);
											$this->model_payment_pp_payflow_iframe->addPaypalTransaction($void_data);

											// Voids the transaction
											$update_data = array(
												'void_transaction_reference' => $response['PNREF'],
											);
											$this->model_payment_pp_payflow_iframe->editPaypalTransactionByReference($transaction['transaction_reference'], $update_data);

											// If original authorization, set status to complete
											if ($is_authorization && empty($transaction['parent_transaction_reference'])) {
												$this->model_payment_pp_payflow_iframe->setPaypalOrderComplete($order_id, 1);
												$json['complete'] = $this->language->get('text_complete');
											}

											// Updating display
											$captured = $refunded = $remaining = 0;
											$root_transaction = $this->model_payment_pp_payflow_iframe->getPaypalRootTransactionByOrderId($order_id);

											if ($root_transaction) {
												switch ($root_transaction['transaction_type']) {
													case 'S': // Sale
														$captured = $root_transaction['amount'];
														$refunded = $this->model_payment_pp_payflow_iframe->getTotalRefunded($order_id);
														break;
													case 'A': // Authorization
														$captured = $this->model_payment_pp_payflow_iframe->getTotalCaptured($order_id);
														$refunded = $this->model_payment_pp_payflow_iframe->getTotalRefunded($order_id);
														break;
													default:
														break;
												}
												$remaining = $root_transaction['amount'] - $captured + $refunded;
											}

											$json['to_display'] = array(
												'captured'  => $this->currency->format($captured, strtoupper($paypal_order['currency_code']), 1, true),
												'refunded'  => $this->currency->format($refunded, strtoupper($paypal_order['currency_code']), 1, true),
												'remaining'  => $this->currency->format($remaining, strtoupper($paypal_order['currency_code']), 1, true),
												'remaining_raw' => number_format($remaining, 2, '.', ''),
											);

											$json['success'] = sprintf($this->language->get('msg_void_success'), $transaction['transaction_reference']);

										} elseif (intval($response['RESULT']) < 0) {
											$json['error'] = sprintf($this->language->get('error_failed_communication'), $response['RESULT'], $response['RESPMSG']);
										} else {
											$json['error'] = sprintf($this->language->get('error_declined_transaction'), $response['RESULT'], $response['RESPMSG']);
										}

									} else {
										$json['error'] = $this->language->get('error_response');
									}
								}

							} else {
								$json['error'] = sprintf($this->language->get('error_voided_transaction'), $transaction['transaction_reference']);
							}

						} else {
							$json['error'] = sprintf($this->language->get('error_void_transaction_type'), $transaction['transaction_type']);
						}

					} else {
						$json['error'] = $this->language->get('error_missing_transaction');
					}

				} else {
					$json['error'] = $this->language->get('error_complete_paypal_order');
				}

			} else {
				$json['error'] = $this->language->get('error_missing_paypal_order');
			}

		} else {
			$json['error'] = $this->language->get('error_missing_data');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function refund() {
		$this->errors = array();

		$this->language->load('payment/pp_payflow_iframe_refund');

		$this->load->model('payment/pp_payflow_iframe');
		$this->load->model('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_transaction_reference'] = $this->language->get('entry_transaction_reference');
		$this->data['entry_transaction_amount'] = $this->language->get('entry_transaction_amount');
		$this->data['entry_transaction_already_refunded'] = $this->language->get('entry_transaction_already_refunded');
		$this->data['entry_refund_amount'] = $this->language->get('entry_refund_amount');

		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_refund'] = $this->language->get('button_refund');

		$this->data['error_positive_amount'] = $this->language->get('error_positive_amount');

		// Ensure parameters
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		if (isset($this->request->get['transaction_reference'])) {
			$transaction_reference = $this->request->get['transaction_reference'];
		} else {
			$transaction_reference = 0;
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_order') . ' N&deg;' . (int)$order_id,
			'href'      => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$order_id, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/pp_payflow_iframe/refund', 'token=' . $this->session->data['token'] . '&transaction_reference=' . $this->request->get['transaction_reference'] . '&order_id=' . (int)$order_id, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['cancel'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$order_id, 'SSL');

		$this->data['token'] = $this->session->data['token'];

		$this->data['order_id'] = $order_id;

		$paypal_order = $this->model_payment_pp_payflow_iframe->getPaypalOrderByOrderId($order_id);

		if ($paypal_order) {
			$transaction = $this->model_payment_pp_payflow_iframe->getPaypalTransactionByReference($transaction_reference);

			if ($transaction) {
				$already_refunded = 0;
				$refunds = $this->model_payment_pp_payflow_iframe->getPaypalRefundsByParentReference($transaction['transaction_reference']);

				foreach ($refunds as $refund) {
					if (empty($refund['void_transaction_reference'])) {
						$already_refunded += $refund['amount'];
					}
				}

				$this->data['transaction_reference'] = $transaction['transaction_reference'];
				$this->data['transaction_amount'] = $this->currency->format($transaction['amount'], strtoupper($paypal_order['currency_code']), 1, true);
				$this->data['transaction_already_refunded'] = $this->currency->format($already_refunded, strtoupper($paypal_order['currency_code']), 1, true);

				$this->template = 'payment/pp_payflow_iframe_refund.tpl';
				$this->children = array(
					'common/header',
					'common/footer'
				);

				$this->response->setOutput($this->render());

			} else {
				return $this->forward('error/not_found');
			}

		} else {
			return $this->forward('error/not_found');
		}
	}

	public function do_refund() {
		// Used to issue a refund for a captured payment. Refund can be full or partial.
		$json = array();

		$this->language->load('payment/pp_payflow_iframe_refund');

		if (isset($this->request->post['order_id']) && ($this->request->post['order_id'] != '') && isset($this->request->post['transaction_reference']) && isset($this->request->post['amount'])) {
			$order_id = $this->request->post['order_id'];
			$reference = $this->request->post['transaction_reference'];
			$amount = (double)$this->request->post['amount'];

			$this->load->model('payment/pp_payflow_iframe');

			$paypal_order = $this->model_payment_pp_payflow_iframe->getPaypalOrderByOrderId($order_id);

			if ($paypal_order) {
				$transaction = $this->model_payment_pp_payflow_iframe->getPaypalTransactionByReference($reference);

				if ($transaction) {
					// To issue a referenced credit, the original transaction can only be one of the following: a Sale (TRXTYPE=S), Delayed Capture (TRXTYPE=D) or Voice Authorization (TRXTYPE=F).
					if (in_array($transaction['transaction_type'], array('S', 'D', 'F'))) {
						$already_refunded = 0;
						$refunds = $this->model_payment_pp_payflow_iframe->getPaypalRefundsByParentReference($transaction['transaction_reference']);

						foreach ($refunds as $refund) {
							if (empty($refund['void_transaction_reference'])) {
								$already_refunded += $refund['amount'];
							}
						}

						// Limitation to 115%
						if ($amount <= ($transaction['amount'] * 1.15) - $already_refunded) {
							$request = array(
								'TRXTYPE' => 'C',
								'TENDER'  => 'C',
								'ORIGID'  => $transaction['transaction_reference'],
								'AMT'     => number_format($amount, 2, '.', '')
							);

							$response = $this->model_payment_pp_payflow_iframe->call($request);

							if ($response === false) {
								$json['error'] = $this->language->get('error_connection');

							} elseif (is_array($response) && isset($response['RESULT'])) {
								if (intval($response['RESULT']) == 0) {
									$refund_data = array(
										'order_id'                     => $transaction['order_id'],
										'transaction_type'             => $request['TRXTYPE'],
										'transaction_reference'        => $response['PNREF'],
										'parent_transaction_reference' => $request['ORIGID'],
										'amount'                       => $amount
									);

									$this->model_payment_pp_payflow_iframe->addPaypalTransaction($refund_data);

									$json['success'] = sprintf($this->language->get('msg_refund_success'), $transaction['transaction_reference']);

								} elseif (intval($response['RESULT']) < 0) {
									$json['error'] = sprintf($this->language->get('error_failed_communication'), $response['RESULT'], $response['RESPMSG']);
								} else {
									$json['error'] = sprintf($this->language->get('error_declined_transaction'), $response['RESULT'], $response['RESPMSG']);
								}

							} else {
								$json['error'] = $this->language->get('error_response');
							}

						} else {
							$json['error'] = $this->language->get('error_refund_over_limit');
						}

					} else {
						$json['error'] = sprintf($this->language->get('error_refund_transaction_type'), $transaction['transaction_type']);
					}

				} else {
					$json['error'] = $this->language->get('error_missing_transaction');
				}

			} else {
				$json['error'] = $this->language->get('error_missing_paypal_order');
			}

		} else {
			$json['error'] = $this->language->get('error_missing_data');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function do_reauthorize() {
		/*
			*** FOR FUTURE USE ***
			Reauthorize an Authorization for an additional three-day honor period.
			A DoReauthorization can be used at most once during the 29-day authorization period.

			NOTE: The Payflow Developer Guide doesnt mention any reauthorization call, only an error code 200 (Reauth).
			But if multiple captures were possible, a reauthorization call on an authorization should exist too.
			For future use, I program here the function but let it unused the time Payflow online documentation becomes more clear on that point.
		*/
		$json = array();

		$this->language->load('payment/pp_payflow_iframe_order');

		if (isset($this->request->post['order_id']) && ($this->request->post['order_id'] != '') && isset($this->request->post['amount'])) {
			$order_id = $this->request->post['order_id'];
			$amount = (double)$this->request->post['amount'];

			$this->load->model('payment/pp_payflow_iframe');

			$paypal_order = $this->model_payment_pp_payflow_iframe->getPaypalOrderByOrderId($order_id);

			if ($paypal_order) {
				if (empty($paypal_order['complete'])) {
					$root_transaction = $this->model_payment_pp_payflow_iframe->getPaypalRootTransactionByOrderId($paypal_order['order_id']);

					if ($root_transaction) {
						if (in_array($root_transaction['transaction_type'], array('A', 'F'))) {
							if (empty($root_transaction['void_transaction_reference'])) {
								$captured = $this->model_payment_pp_payflow_iframe->getTotalCaptured($paypal_order['order_id']);
								$refunded = $this->model_payment_pp_payflow_iframe->getTotalRefunded($paypal_order['order_id']);

								$remaining = $root_transaction['amount'] - $captured + $refunded;

								if ($amount <= $remaining) {
									$request = array(
										'TRXTYPE'           => 'A',
										'TENDER'            => 'C',
										'ORIGID'            => $root_transaction['transaction_reference'],
										'DOREAUTHORIZATION' => 1,
										'AMT'               => number_format($amount, 2, '.', ''),
									);

									$response = $this->model_payment_pp_payflow_iframe->call($request);

									if ($response === false) {
										$json['error'] = $this->language->get('error_connection');

									} elseif (is_array($response) && isset($response['RESULT'])) {
										if (intval($response['RESULT']) == 0) {
											$data = array(
												'order_id'                     => $order_id,
												'transaction_reference'        => $response['PNREF'],
												'parent_transaction_reference' => $request['ORIGID'],
												'transaction_type'             => $request['TRXTYPE'],
												'amount'                       => $amount,
											);

											$this->model_payment_pp_payflow_iframe->addPaypalTransaction($data);

											$json['success'] = sprintf($this->language->get('msg_reauthorize_success'), $root_transaction['transaction_reference']);

										} elseif (intval($response['RESULT']) < 0) {
											$json['error'] = sprintf($this->language->get('error_failed_communication'), $response['RESULT'], $response['RESPMSG']);
										} else {
											$json['error'] = sprintf($this->language->get('error_declined_transaction'), $response['RESULT'], $response['RESPMSG']);
										}

									} else {
										$json['error'] = $this->language->get('error_response');
									}

								} else {
									$json['error'] = $this->language->get('error_reauthorize_over_limit');
								}

							} else {
								$json['error'] = sprintf($this->language->get('error_voided_transaction'), $root_transaction['transaction_reference']);
							}

						} else {
							$json['error'] = $this->language->get('error_missing_authorization');
						}

					} else {
						$json['error'] = $this->language->get('error_missing_transaction');
					}

				} else {
					$json['error'] = $this->language->get('error_complete_paypal_order');
				}

			} else {
				$json['error'] = $this->language->get('error_missing_paypal_order');
			}

		} else {
			$json['error'] = $this->language->get('error_missing_data');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function debug_clear() {
		$this->language->load('payment/pp_payflow_iframe');

		$file = DIR_LOGS . (self::DEBUG_LOG_FILE);

		$handle = fopen($file, 'w+');

		fclose($handle);

		clearstatcache();

		$this->session->data['success'] = $this->language->get('text_debug_clear_success');

		$this->redirect($this->url->link('payment/pp_payflow_iframe', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function debug_download() {
		$file = DIR_LOGS . (self::DEBUG_LOG_FILE);

		clearstatcache();

		if (file_exists($file) && is_file($file)) {
			if (!headers_sent()) {
				if (filesize($file) > 0) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename=' . str_replace(' ', '_', $this->config->get('config_name')) . '_' . date('Y-m-d_H-i-s', time()) . '_' . (self::DEBUG_LOG_FILE));
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file, 'rb');
					exit();
				}

			} else {
				exit('Error: Headers already sent out!');
			}

		} else {
			$this->redirect($this->url->link('payment/pp_payflow_iframe', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
}
