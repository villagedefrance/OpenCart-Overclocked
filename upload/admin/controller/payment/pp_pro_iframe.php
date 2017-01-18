<?php
class ControllerPaymentPPProIframe extends Controller {
	const DEBUG_LOG_FILE = 'pp_pro_iframe.log';
	private $errors;

	public function index() {
		$this->errors = array();

		$this->language->load('payment/pp_pro_iframe');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('pp_pro_iframe', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/pp_pro_iframe', 'token=' . $this->session->data['token'], 'SSL'));
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

		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_signature'] = $this->language->get('entry_signature');
		$this->data['entry_sandbox_username'] = $this->language->get('entry_sandbox_username');
		$this->data['entry_sandbox_password'] = $this->language->get('entry_sandbox_password');
		$this->data['entry_sandbox_signature'] = $this->language->get('entry_sandbox_signature');
		$this->data['entry_ipn_url'] = $this->language->get('entry_ipn_url');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_transaction_method'] = $this->language->get('entry_transaction_method');
		$this->data['entry_checkout_method'] = $this->language->get('entry_checkout_method');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['entry_canceled_reversal_status'] = $this->language->get('entry_canceled_reversal_status');
		$this->data['entry_completed_status'] = $this->language->get('entry_completed_status');
		$this->data['entry_denied_status'] = $this->language->get('entry_denied_status');
		$this->data['entry_expired_status'] = $this->language->get('entry_expired_status');
		$this->data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$this->data['entry_pending_status'] = $this->language->get('entry_pending_status');
		$this->data['entry_processed_status'] = $this->language->get('entry_processed_status');
		$this->data['entry_refunded_status'] = $this->language->get('entry_refunded_status');
		$this->data['entry_reversed_status'] = $this->language->get('entry_reversed_status');
		$this->data['entry_voided_status'] = $this->language->get('entry_voided_status');

		$this->data['help_username'] = $this->language->get('help_username');
		$this->data['help_password'] = $this->language->get('help_password');
		$this->data['help_signature'] = $this->language->get('help_signature');
		$this->data['help_ipn_url'] = $this->language->get('help_ipn_url');
		$this->data['help_test'] = $this->language->get('help_test');
		$this->data['help_debug'] = $this->language->get('help_debug');
		$this->data['help_transaction_method'] = $this->language->get('help_transaction_method');
		$this->data['help_checkout_method'] = $this->language->get('help_checkout_method');
		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_total_max'] = $this->language->get('help_total_max');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_api'] = $this->language->get('tab_api');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_order_status'] = $this->language->get('tab_order_status');
		$this->data['tab_checkout_customisation'] = $this->language->get('tab_checkout_customisation');
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
			'href'      => $this->url->link('payment/pp_pro_iframe', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/pp_pro_iframe', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['pp_pro_iframe_username'])) {
			$this->data['pp_pro_iframe_username'] = $this->request->post['pp_pro_iframe_username'];
		} else {
			$this->data['pp_pro_iframe_username'] = $this->config->get('pp_pro_iframe_username');
		}

		if (isset($this->request->post['pp_pro_iframe_password'])) {
			$this->data['pp_pro_iframe_password'] = $this->request->post['pp_pro_iframe_password'];
		} else {
			$this->data['pp_pro_iframe_password'] = $this->config->get('pp_pro_iframe_password');
		}

		if (isset($this->request->post['pp_pro_iframe_signature'])) {
			$this->data['pp_pro_iframe_signature'] = $this->request->post['pp_pro_iframe_signature'];
		} else {
			$this->data['pp_pro_iframe_signature'] = $this->config->get('pp_pro_iframe_signature');
		}

		if (isset($this->request->post['pp_pro_iframe_sandbox_username'])) {
			$this->data['pp_pro_iframe_sandbox_username'] = $this->request->post['pp_pro_iframe_sandbox_username'];
		} else {
			$this->data['pp_pro_iframe_sandbox_username'] = $this->config->get('pp_pro_iframe_sandbox_username');
		}

		if (isset($this->request->post['pp_pro_iframe_sandbox_password'])) {
			$this->data['pp_pro_iframe_sandbox_password'] = $this->request->post['pp_pro_iframe_sandbox_password'];
		} else {
			$this->data['pp_pro_iframe_sandbox_password'] = $this->config->get('pp_pro_iframe_sandbox_password');
		}

		if (isset($this->request->post['pp_pro_iframe_sandbox_signature'])) {
			$this->data['pp_pro_iframe_sandbox_signature'] = $this->request->post['pp_pro_iframe_sandbox_signature'];
		} else {
			$this->data['pp_pro_iframe_sandbox_signature'] = $this->config->get('pp_pro_iframe_sandbox_signature');
		}

		if (isset($this->request->post['pp_pro_iframe_test'])) {
			$this->data['pp_pro_iframe_test'] = $this->request->post['pp_pro_iframe_test'];
		} else {
			$this->data['pp_pro_iframe_test'] = $this->config->get('pp_pro_iframe_test');
		}

		if (isset($this->request->post['pp_pro_iframe_debug'])) {
			$this->data['pp_pro_iframe_debug'] = $this->request->post['pp_pro_iframe_debug'];
		} else {
			$this->data['pp_pro_iframe_debug'] = $this->config->get('pp_pro_iframe_debug');
		}

		if (isset($this->request->post['pp_pro_iframe_transaction_method'])) {
			$this->data['pp_pro_iframe_transaction_method'] = $this->request->post['pp_pro_iframe_transaction_method'];
		} else {
			$this->data['pp_pro_iframe_transaction_method'] = $this->config->get('pp_pro_iframe_transaction_method');
		}

		if (isset($this->request->post['pp_pro_iframe_checkout_method'])) {
			$this->data['pp_pro_iframe_checkout_method'] = $this->request->post['pp_pro_iframe_checkout_method'];
		} else {
			$this->data['pp_pro_iframe_checkout_method'] = $this->config->get('pp_pro_iframe_checkout_method');
		}

		if (isset($this->request->post['pp_pro_iframe_total'])) {
			$this->data['pp_pro_iframe_total'] = $this->request->post['pp_pro_iframe_total'];
		} else {
			$this->data['pp_pro_iframe_total'] = $this->config->get('pp_pro_iframe_total');
		}

		if (isset($this->request->post['pp_pro_iframe_total_max'])) {
			$this->data['pp_pro_iframe_total_max'] = $this->request->post['pp_pro_iframe_total_max'];
		} else {
			$this->data['pp_pro_iframe_total_max'] = $this->config->get('pp_pro_iframe_total_max');
		}

		if (isset($this->request->post['pp_pro_iframe_geo_zone_id'])) {
			$this->data['pp_pro_iframe_geo_zone_id'] = $this->request->post['pp_pro_iframe_geo_zone_id'];
		} else {
			$this->data['pp_pro_iframe_geo_zone_id'] = $this->config->get('pp_pro_iframe_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['pp_pro_iframe_status'])) {
			$this->data['pp_pro_iframe_status'] = $this->request->post['pp_pro_iframe_status'];
		} else {
			$this->data['pp_pro_iframe_status'] = $this->config->get('pp_pro_iframe_status');
		}

		if (isset($this->request->post['pp_pro_iframe_sort_order'])) {
			$this->data['pp_pro_iframe_sort_order'] = $this->request->post['pp_pro_iframe_sort_order'];
		} else {
			$this->data['pp_pro_iframe_sort_order'] = $this->config->get('pp_pro_iframe_sort_order');
		}

		$this->data['ipn_url'] = HTTPS_CATALOG . 'index.php?route=payment/pp_pro_iframe/notify';

		if (isset($this->request->post['pp_pro_iframe_canceled_reversal_status_id'])) {
			$this->data['pp_pro_iframe_canceled_reversal_status_id'] = $this->request->post['pp_pro_iframe_canceled_reversal_status_id'];
		} else {
			$this->data['pp_pro_iframe_canceled_reversal_status_id'] = $this->config->get('pp_pro_iframe_canceled_reversal_status_id');
		}

		if (isset($this->request->post['pp_pro_iframe_completed_status_id'])) {
			$this->data['pp_pro_iframe_completed_status_id'] = $this->request->post['pp_pro_iframe_completed_status_id'];
		} else {
			$this->data['pp_pro_iframe_completed_status_id'] = $this->config->get('pp_pro_iframe_completed_status_id');
		}

		if (isset($this->request->post['pp_pro_iframe_denied_status_id'])) {
			$this->data['pp_pro_iframe_denied_status_id'] = $this->request->post['pp_pro_iframe_denied_status_id'];
		} else {
			$this->data['pp_pro_iframe_denied_status_id'] = $this->config->get('pp_pro_iframe_denied_status_id');
		}

		if (isset($this->request->post['pp_pro_iframe_expired_status_id'])) {
			$this->data['pp_pro_iframe_expired_status_id'] = $this->request->post['pp_pro_iframe_expired_status_id'];
		} else {
			$this->data['pp_pro_iframe_expired_status_id'] = $this->config->get('pp_pro_iframe_expired_status_id');
		}

		if (isset($this->request->post['pp_pro_iframe_failed_status_id'])) {
			$this->data['pp_pro_iframe_failed_status_id'] = $this->request->post['pp_pro_iframe_failed_status_id'];
		} else {
			$this->data['pp_pro_iframe_failed_status_id'] = $this->config->get('pp_pro_iframe_failed_status_id');
		}

		if (isset($this->request->post['pp_pro_iframe_pending_status_id'])) {
			$this->data['pp_pro_iframe_pending_status_id'] = $this->request->post['pp_pro_iframe_pending_status_id'];
		} else {
			$this->data['pp_pro_iframe_pending_status_id'] = $this->config->get('pp_pro_iframe_pending_status_id');
		}

		if (isset($this->request->post['pp_pro_iframe_processed_status_id'])) {
			$this->data['pp_pro_iframe_processed_status_id'] = $this->request->post['pp_pro_iframe_processed_status_id'];
		} else {
			$this->data['pp_pro_iframe_processed_status_id'] = $this->config->get('pp_pro_iframe_processed_status_id');
		}

		if (isset($this->request->post['pp_pro_iframe_refunded_status_id'])) {
			$this->data['pp_pro_iframe_refunded_status_id'] = $this->request->post['pp_pro_iframe_refunded_status_id'];
		} else {
			$this->data['pp_pro_iframe_refunded_status_id'] = $this->config->get('pp_pro_iframe_refunded_status_id');
		}

		if (isset($this->request->post['pp_pro_iframe_reversed_status_id'])) {
			$this->data['pp_pro_iframe_reversed_status_id'] = $this->request->post['pp_pro_iframe_reversed_status_id'];
		} else {
			$this->data['pp_pro_iframe_reversed_status_id'] = $this->config->get('pp_pro_iframe_reversed_status_id');
		}

		if (isset($this->request->post['pp_pro_iframe_voided_status_id'])) {
			$this->data['pp_pro_iframe_voided_status_id'] = $this->request->post['pp_pro_iframe_voided_status_id'];
		} else {
			$this->data['pp_pro_iframe_voided_status_id'] = $this->config->get('pp_pro_iframe_voided_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		// Debug Log
		if ($this->data['pp_pro_iframe_debug']) {
			$this->data['button_debug_clear'] = $this->language->get('button_clear');
			$this->data['button_debug_download'] = $this->language->get('button_download');

			$this->data['debug_clear'] = $this->url->link('payment/pp_pro_iframe/debug_clear', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['debug_download'] = $this->url->link('payment/pp_pro_iframe/debug_download', 'token=' . $this->session->data['token'], 'SSL');

			// Create directory if it does not exist
			if (!is_dir(DIR_SYSTEM . 'logs/')) {
				mkdir(DIR_SYSTEM . 'logs', 0777);
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

		$this->template = 'payment/pp_pro_iframe.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/pp_pro_iframe')) {
			$this->errors['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['pp_pro_iframe_test']) {
			if (empty($this->request->post['pp_pro_iframe_sandbox_username'])) {
				$this->errors['sandbox_username'] = $this->language->get('error_sandbox_username');
			}

			if (empty($this->request->post['pp_pro_iframe_sandbox_password'])) {
				$this->errors['sandbox_password'] = $this->language->get('error_sandbox_password');
			}

			if (empty($this->request->post['pp_pro_iframe_sandbox_signature'])) {
				$this->errors['sandbox_signature'] = $this->language->get('error_sandbox_signature');
			}
		} else {
			if (empty($this->request->post['pp_pro_iframe_username'])) {
				$this->errors['username'] = $this->language->get('error_username');
			}

			if (empty($this->request->post['pp_pro_iframe_password'])) {
				$this->errors['password'] = $this->language->get('error_password');
			}

			if (empty($this->request->post['pp_pro_iframe_signature'])) {
				$this->errors['signature'] = $this->language->get('error_signature');
			}
		}

		return empty($this->errors);
	}

	public function install() {
		$this->load->model('payment/pp_pro_iframe');

		$this->model_payment_pp_pro_iframe->install();
	}

	public function uninstall() {
		$this->load->model('payment/pp_pro_iframe');

		$this->model_payment_pp_pro_iframe->uninstall();
	}

	public function orderAction() {
		if ($this->config->get('pp_pro_iframe_status')) {
			$this->language->load('payment/pp_pro_iframe_order');

			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('payment/pp_pro_iframe');

			$paypal_order = $this->model_payment_pp_pro_iframe->getPaypalOrderByOrderId($order_id);

			if ($paypal_order) {
				$this->data['text_payment_info'] = $this->language->get('text_payment_info');
				$this->data['text_transactions'] = $this->language->get('text_transactions');
				$this->data['text_capture_status'] = $this->language->get('text_capture_status');
				$this->data['text_amount_authorised'] = $this->language->get('text_amount_authorised');
				$this->data['text_amount_captured'] = $this->language->get('text_amount_captured');
				$this->data['text_amount_refunded'] = $this->language->get('text_amount_refunded');
				$this->data['text_complete'] = $this->language->get('text_complete');
				$this->data['text_incomplete'] = $this->language->get('text_incomplete');
				$this->data['text_confirm_void'] = $this->language->get('text_confirm_void');
				$this->data['text_reauthorise'] = $this->language->get('text_reauthorise');
				$this->data['text_confirm_reauthorise'] = $this->language->get('text_confirm_reauthorise');
				$this->data['text_reauthorised'] = $this->language->get('text_reauthorised');

				$this->data['entry_capture_amount'] = $this->language->get('entry_capture_amount');
				$this->data['entry_capture_complete'] = $this->language->get('entry_capture_complete');

				$this->data['button_capture'] = $this->language->get('button_capture');
				$this->data['button_void'] = $this->language->get('button_void');
				$this->data['button_reauthorise'] = $this->language->get('button_reauthorise');

				$this->data['error_capture_amt'] = $this->language->get('error_capture_amt');
				$this->data['error_timeout'] = $this->language->get('error_timeout');
				$this->data['error_missing_transaction'] = $this->language->get('error_missing_transaction');

				$this->data['token'] = $this->session->data['token'];

				$this->data['order_id'] = $order_id;

				$this->data['paypal_order'] = $paypal_order;

				$captured = $this->model_payment_pp_pro_iframe->getTotalCaptured($paypal_order['paypal_iframe_order_id']);
				$refunded = $this->model_payment_pp_pro_iframe->getTotalRefunded($paypal_order['paypal_iframe_order_id']);
				$remaining = $paypal_order['total'] - $captured + $refunded;

				$this->data['paypal_order']['captured'] = number_format($captured, 2);
				$this->data['paypal_order']['refunded'] = number_format($refunded, 2);
				$this->data['paypal_order']['remaining'] = number_format($remaining, 2);

				$this->template = 'payment/pp_pro_iframe_order.tpl';

				$this->response->setOutput($this->render());
			}
		}
	}

	public function transaction() {
		$this->language->load('payment/pp_pro_iframe_order');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_transaction_id'] = $this->language->get('column_transaction_id');
		$this->data['column_amount'] = $this->language->get('column_amount');
		$this->data['column_type'] = $this->language->get('column_type');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_pending_reason'] = $this->language->get('column_pending_reason');
		$this->data['column_created'] = $this->language->get('column_created');
		$this->data['column_actions'] = $this->language->get('column_actions');

		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_refund'] = $this->language->get('button_refund');
		$this->data['button_resend'] = $this->language->get('button_resend');

		$this->data['transactions'] = array();

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$this->load->model('payment/pp_pro_iframe');

		$paypal_order = $this->model_payment_pp_pro_iframe->getPaypalOrderByOrderId($order_id);

		if ($paypal_order) {
			$results = $this->model_payment_pp_pro_iframe->getTransactions($paypal_order['paypal_iframe_order_id']);

			foreach ($results as $result) {
				$this->data['transactions'][] = array(
					'paypal_iframe_order_transaction_id' => $result['paypal_iframe_order_transaction_id'],
					'transaction_id' => $result['transaction_id'],
					'amount'         => $result['amount'],
					'payment_type'   => $result['payment_type'],
					'payment_status' => $result['payment_status'],
					'pending_reason' => $result['pending_reason'],
					'created'        => date($this->language->get('date_format_time'), strtotime($result['created'])),
					'view'           => $this->url->link('payment/pp_pro_iframe/viewTransaction', 'token=' . $this->session->data['token'] . '&transaction_id=' . $result['transaction_id'] . '&order_id=' . $order_id . '&referrer=detail', 'SSL'),
					'refund'         => $this->url->link('payment/pp_pro_iframe/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . $result['transaction_id'] . '&order_id=' . $order_id, 'SSL'),
					'resend'         => $this->url->link('payment/pp_pro_iframe/do_resend', 'token=' . $this->session->data['token'] . '&paypal_iframe_order_transaction_id=' . $result['paypal_iframe_order_transaction_id'], 'SSL')
				);
			}
		}

		$this->template = 'payment/pp_pro_iframe_transaction.tpl';

		$this->response->setOutput($this->render());
	}

	public function do_capture() {
		// Used to capture authorised payments. Capture can be full or partial amounts
		$json = array();

		$this->language->load('payment/pp_pro_iframe');

		if (isset($this->request->post['order_id']) && $this->request->post['amount'] > 0 && isset($this->request->post['complete'])) {
			$this->load->model('payment/pp_pro_iframe');

			$paypal_order = $this->model_payment_pp_pro_iframe->getPaypalOrderByOrderId($this->request->post['order_id']);

			if ($paypal_order) {
				// If this is the final amount to capture or not.
				// NOTE: If 'Complete', any remaining amount of the original authorized transaction is automatically voided
				// and all remaining open authorizations are voided by Paypal.
				if ($this->request->post['complete'] == 1) {
					$complete = 'Complete';
				} else {
					$complete = 'NotComplete';
				}

				$request = array(
					'METHOD'          => 'DoCapture',
					'AUTHORIZATIONID' => $paypal_order['authorization_id'],
					'AMT'             => number_format($this->request->post['amount'], 2),
					'CURRENCYCODE'    => $paypal_order['currency_code'],
					'COMPLETETYPE'    => $complete,
					'MSGSUBID'        => uniqid(mt_rand(), true)
				);

				$response = $this->model_payment_pp_pro_iframe->call($request);

				$transaction = array(
					'paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'],
					'transaction_id'         => '',
					'parent_transaction_id'  => $paypal_order['authorization_id'],
					'note'                   => '',
					'msgsubid'               => $request['MSGSUBID'],
					'receipt_id'             => '',
					'payment_type'           => '',
					'payment_status'         => '',
					'pending_reason'         => '',
					'transaction_entity'     => 'payment',
					'amount'                 => '',
					'debug_data'             => json_encode($response)
				);

				if ($response === false) {
					// Save for resend
					$transaction['payment_status'] = 'Failed';
					$transaction['amount'] = number_format($this->request->post['amount'], 2);

					$this->model_payment_pp_pro_iframe->addTransaction($transaction, $request);

					$json['error'] = $this->language->get('error_connection');

				} elseif (is_array($response) && isset($response['ACK']) && ($response['ACK'] != 'Failure') && ($response['ACK'] != 'FailureWithWarning')) {
					$transaction['transaction_id'] = $response['TRANSACTIONID'];
					$transaction['payment_type'] = $response['PAYMENTTYPE'];
					$transaction['payment_status'] = $response['PAYMENTSTATUS'];

					$transaction['pending_reason'] = (isset($response['PENDINGREASON']) ? $response['PENDINGREASON'] : '');
					$transaction['amount'] = $response['AMT'];

					$this->model_payment_pp_pro_iframe->addTransaction($transaction);

					unset($transaction['debug_data']);

					$transaction['created'] = date($this->language->get('date_format_time'));

					$captured = $this->model_payment_pp_pro_iframe->getTotalCaptured($paypal_order['paypal_iframe_order_id']);
					$refunded = $this->model_payment_pp_pro_iframe->getTotalRefunded($paypal_order['paypal_iframe_order_id']);
					$remaining = $paypal_order['total'] - $captured + $refunded;

					$transaction['captured'] = number_format($captured, 2);
					$transaction['refunded'] = number_format($refunded, 2);
					$transaction['remaining'] = number_format($remaining, 2);

					// Not used.
					$transaction['complete_status'] = 0;

					if ($this->request->post['complete'] == 1 || $transaction['remaining'] == '0.00') {
						$transaction['complete_status'] = 1;

						$json['capture_status'] = $this->language->get('text_complete');

						$this->model_payment_pp_pro_iframe->updatePaypalOrderStatus($this->request->post['order_id'], 'Complete');
					}

					$transaction['void'] = '';

					if ($this->request->post['complete'] == 1 && $remaining > 0) {
						// Records the void (done automatically by Paypal) on the funds remaining on the authorization.
						$transaction['void'] = array(
							'paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'],
							'transaction_id'         => '',
							'parent_transaction_id'  => $paypal_order['authorization_id'],
							'note'                   => '',
							'msgsubid'               => '',
							'receipt_id'             => '',
							'payment_type'           => '',
							'payment_status'         => 'Void',
							'pending_reason'         => '',
							'amount'                 => '',
							'debug_data'             => 'Voided after capture',
							'transaction_entity'     => 'auth'
						);

						$this->model_payment_pp_pro_iframe->addTransaction($transaction['void']);

						$transaction['void']['created'] = date($this->language->get('date_format_time'));

						// Useless, already done.
						$this->model_payment_pp_pro_iframe->updatePaypalOrderStatus($this->request->post['order_id'], 'Complete');

						$transaction['complete_status'] = 1;
					}

					// No more used.
					$json['data'] = $transaction;

					$json['success'] = $this->language->get('text_success');

				} else {
					$json['error'] = (isset($response['L_SHORTMESSAGE0']) ? $response['L_SHORTMESSAGE0'] : $this->language->get('error_general')) . (isset($response['L_LONGMESSAGE0']) ? '<br />' . $response['L_LONGMESSAGE0'] : '');
				}

			} else {
				$json['error'] = $this->language->get('error_missing_order');
			}

		} else {
			$json['error'] = $this->language->get('error_missing_data');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function refund() {
		$this->errors = array();

		$this->language->load('payment/pp_pro_iframe_refund');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_transaction_id'] = $this->language->get('entry_transaction_id');
		$this->data['entry_full_refund'] = $this->language->get('entry_full_refund');
		$this->data['entry_amount'] = $this->language->get('entry_amount');
		$this->data['entry_message'] = $this->language->get('entry_message');

		$this->data['error_transaction_id'] = $this->language->get('error_transaction_id');
		$this->data['error_partial_amt'] = $this->language->get('error_partial_amt');

		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_refund'] = $this->language->get('button_refund');

		$this->data['token'] = $this->session->data['token'];

		// Ensure parameters
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		if (isset($this->request->get['transaction_id'])) {
			$transaction_id = $this->request->get['transaction_id'];
		} else {
			$transaction_id = 0;
		}

		if (isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$this->data['error'] = '';
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
			'href'      => $this->url->link('payment/pp_pro_iframe/refund', 'token=' . $this->session->data['token'] . '&transaction_id=' . (int)$transaction_id . '&order_id=' . (int)$order_id, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/pp_pro_iframe/do_refund', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id , 'SSL');

		$this->data['transaction_id'] = $transaction_id;

		$this->load->model('payment/pp_pro_iframe');

		$response = $this->model_payment_pp_pro_iframe->requestTransactionDetails($transaction_id);

		if (is_array($response) && isset($response['ACK']) && ($response['ACK'] == 'Success')) {
			$this->data['amount_original'] = $response['AMT'];
			$this->data['currency_code'] = $response['CURRENCYCODE'];
		} else {
			// Call failed, try local infos
			$local_transaction = $this->model_payment_pp_pro_iframe->getLocalTransaction($transaction_id);

			if ($local_transaction === false) {
				$this->data['amount_original'] = 0;
				$this->data['currency_code'] = 'Error';
				$this->data['error'] = $this->language->get('error_transaction_amount');
			} else {
				$this->data['amount_original'] = $local_transaction['amount'];
				$paypal_order = $this->model_payment_pp_pro_iframe->getPaypalOrder($local_transaction['paypal_iframe_order_id']);
				$this->data['currency_code'] = (is_array($paypal_order) ? $paypal_order['currency_code'] : '???');
			}
		}

		$refunded = $this->model_payment_pp_pro_iframe->getTotalRefundedByParentId($transaction_id);

		if ($refunded != 0) {
			$refund_available = $this->data['amount_original'] + $refunded;
			$this->data['refund_available'] = number_format($refund_available, 2);
			$this->data['attention'] = $this->language->get('text_current_refunds') . ': ' . $this->data['refund_available'];
		} else {
			$this->data['refund_available'] = '';
			$this->data['attention'] = '';
		}

		$this->template = 'payment/pp_pro_iframe_refund.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	// Changed to json for calling from everywhere and return complete error messages.
	public function do_refund() {
		// Used to issue a refund for a captured payment. Refund can be full or partial
		$json = array();

		$this->language->load('payment/pp_pro_iframe_refund');

		if (isset($this->request->post['transaction_id']) && isset($this->request->post['refund_full'])) {
			$this->load->model('payment/pp_pro_iframe');

			if ($this->request->post['refund_full'] == 0 && $this->request->post['amount'] == 0) {
				$json['error'] = $this->language->get('error_partial_amt');
			} else if ($this->request->post['amount'] <= 0) {
				$json['error'] = $this->language->get('error_positive_amt');
			} else {
				$order_id = $this->model_payment_pp_pro_iframe->getOrderId($this->request->post['transaction_id']);

				if ($order_id) {
					$paypal_order = $this->model_payment_pp_pro_iframe->getPaypalOrderByOrderId($order_id);

					if ($paypal_order) {
						$request = array(
							'METHOD'        => 'RefundTransaction',
							'TRANSACTIONID' => $this->request->post['transaction_id'],
							'NOTE'          => urlencode($this->request->post['refund_message']),
							'MSGSUBID'      => uniqid(mt_rand(), true)
						);

						$current_transaction = $this->model_payment_pp_pro_iframe->getLocalTransaction($this->request->post['transaction_id']);

						if ($this->request->post['refund_full'] == 1) {
							$request['REFUNDTYPE'] = 'Full';
						} else {
							$request['REFUNDTYPE'] = 'Partial';
							$request['AMT'] = number_format($this->request->post['amount'], 2);
							$request['CURRENCYCODE'] = $this->request->post['currency_code'];
						}

						$response = $this->model_payment_pp_pro_iframe->call($request);

						$transaction = array(
							'paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'],
							'transaction_id'         => '',
							'parent_transaction_id'  => $this->request->post['transaction_id'],
							'note'                   => $this->request->post['refund_message'],
							'msgsubid'               => $request['MSGSUBID'],
							'receipt_id'             => '',
							'payment_type'           => '',
							'payment_status'         => 'Refunded',
							'transaction_entity'     => 'payment',
							'pending_reason'         => '',
							'amount'                 => '-' . (isset($request['AMT']) ? $request['AMT'] : $current_transaction['amount']),
							'debug_data'             => json_encode($response)
						);

						if ($response === false) {
							// Save for resend
							$transaction['payment_status'] = 'Failed';

							$this->model_payment_pp_pro_iframe->addTransaction($transaction, $request);

							$json['error'] = $this->language->get('error_connection');

						} elseif (is_array($response) && isset($response['ACK']) && ($response['ACK'] != 'Failure') && ($response['ACK'] != 'FailureWithWarning')) {
							$transaction['transaction_id'] = $response['REFUNDTRANSACTIONID'];
							$transaction['payment_type'] = $response['REFUNDSTATUS'];
							$transaction['pending_reason'] = $response['PENDINGREASON'];
							$transaction['amount'] = '-' . $response['GROSSREFUNDAMT'];

							$this->model_payment_pp_pro_iframe->addTransaction($transaction);

							// Update transaction to refunded status
							if ($response['TOTALREFUNDEDAMOUNT'] == $this->request->post['amount_original']) {
								$this->model_payment_pp_pro_iframe->updateTransactionStatus($this->request->post['transaction_id'], 'Refunded');
							} else {
								$this->model_payment_pp_pro_iframe->updateTransactionStatus($this->request->post['transaction_id'], 'Partially-Refunded');
							}

							$json['success'] = $this->language->get('text_success');

						} else {
							$json['error'] = (isset($response['L_SHORTMESSAGE0']) ? $response['L_SHORTMESSAGE0'] : $this->language->get('error_general')) . (isset($response['L_LONGMESSAGE0']) ? '<br />' . $response['L_LONGMESSAGE0'] : '');
						}

					} else {
						$json['error'] = $this->language->get('error_missing_order');
					}

				} else {
					$json['error'] = $this->language->get('error_loose_transaction');
				}
			}

		} else {
			$json['error'] = $this->language->get('error_missing_data');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function do_void() {
		// Used to void an authorised payment
		$json = array();

		$this->language->load('payment/pp_pro_iframe');

		if (isset($this->request->post['order_id']) && !empty($this->request->post['order_id'])) {
			$this->load->model('payment/pp_pro_iframe');

			$paypal_order = $this->model_payment_pp_pro_iframe->getPaypalOrderByOrderId($this->request->post['order_id']);

			if ($paypal_order) {
				$request = array(
					'METHOD'          => 'DoVoid',
					'AUTHORIZATIONID' => $paypal_order['authorization_id'],
					'MSGSUBID'        => uniqid(mt_rand(), true)
				);

				$response = $this->model_payment_pp_pro_iframe->call($request);

				if ($response === false) {
					$json['error'] = $this->language->get('error_connection');

				} elseif (is_array($response) && isset($response['ACK']) && ($response['ACK'] != 'Failure') && ($response['ACK'] != 'FailureWithWarning')) {
					$transaction = array(
						'paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'],
						'transaction_id'         => '',
						'parent_transaction_id'  => $paypal_order['authorization_id'],
						'note'                   => '',
						'msgsubid'               => $request['MSGSUBID'],
						'receipt_id'             => '',
						'payment_type'           => 'void',
						'payment_status'         => 'Void',
						'pending_reason'         => '',
						'transaction_entity'     => 'auth',
						'amount'                 => '',
						'debug_data'             => json_encode($response)
					);

					$this->model_payment_pp_pro_iframe->addTransaction($transaction);

					$this->model_payment_pp_pro_iframe->updatePaypalOrderStatus($this->request->post['order_id'], 'Complete');

					$json['capture_status'] = 'Complete';

					$json['success'] = $this->language->get('text_success');

				} else {
					$json['error'] = (isset($response['L_SHORTMESSAGE0']) ? $response['L_SHORTMESSAGE0'] : $this->language->get('error_general')) . (isset($response['L_LONGMESSAGE0']) ? '<br />' . $response['L_LONGMESSAGE0'] : '');
				}

			} else {
				$json['error'] = $this->language->get('error_missing_order');
			}

		} else {
			$json['error'] = $this->language->get('error_missing_data');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function viewTransaction() {
		$this->errors = array();

		$this->language->load('payment/pp_pro_iframe_view');

		$this->load->model('payment/pp_pro_iframe');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_product_lines'] = $this->language->get('text_product_lines');
		$this->data['text_ebay_txn_id'] = $this->language->get('text_ebay_txn_id');
		$this->data['text_name'] = $this->language->get('text_name');
		$this->data['text_qty'] = $this->language->get('text_qty');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_number'] = $this->language->get('text_number');
		$this->data['text_coupon_id'] = $this->language->get('text_coupon_id');
		$this->data['text_coupon_amount'] = $this->language->get('text_coupon_amount');
		$this->data['text_coupon_currency'] = $this->language->get('text_coupon_currency');
		$this->data['text_loyalty_currency'] = $this->language->get('text_loyalty_currency');
		$this->data['text_loyalty_disc_amt'] = $this->language->get('text_loyalty_disc_amt');
		$this->data['text_options_name'] = $this->language->get('text_options_name');
		$this->data['text_tax_amt'] = $this->language->get('text_tax_amt');
		$this->data['text_currency_code'] = $this->language->get('text_currency_code');
		$this->data['text_amount'] = $this->language->get('text_amount');
		$this->data['text_gift_msg'] = $this->language->get('text_gift_msg');
		$this->data['text_gift_receipt'] = $this->language->get('text_gift_receipt');
		$this->data['text_gift_wrap_name'] = $this->language->get('text_gift_wrap_name');
		$this->data['text_gift_wrap_amt'] = $this->language->get('text_gift_wrap_amt');
		$this->data['text_buyer_email_market'] = $this->language->get('text_buyer_email_market');
		$this->data['text_survey_question'] = $this->language->get('text_survey_question');
		$this->data['text_survey_chosen'] = $this->language->get('text_survey_chosen');
		$this->data['text_receiver_business'] = $this->language->get('text_receiver_business');
		$this->data['text_receiver_email'] = $this->language->get('text_receiver_email');
		$this->data['text_receiver_id'] = $this->language->get('text_receiver_id');
		$this->data['text_buyer_email'] = $this->language->get('text_buyer_email');
		$this->data['text_payer_id'] = $this->language->get('text_payer_id');
		$this->data['text_payer_status'] = $this->language->get('text_payer_status');
		$this->data['text_country_code'] = $this->language->get('text_country_code');
		$this->data['text_payer_business'] = $this->language->get('text_payer_business');
		$this->data['text_payer_salute'] = $this->language->get('text_payer_salute');
		$this->data['text_payer_firstname'] = $this->language->get('text_payer_firstname');
		$this->data['text_payer_middlename'] = $this->language->get('text_payer_middlename');
		$this->data['text_payer_lastname'] = $this->language->get('text_payer_lastname');
		$this->data['text_payer_suffix'] = $this->language->get('text_payer_suffix');
		$this->data['text_address_owner'] = $this->language->get('text_address_owner');
		$this->data['text_address_status'] = $this->language->get('text_address_status');
		$this->data['text_ship_sec_name'] = $this->language->get('text_ship_sec_name');
		$this->data['text_ship_name'] = $this->language->get('text_ship_name');
		$this->data['text_ship_street1'] = $this->language->get('text_ship_street1');
		$this->data['text_ship_street2'] = $this->language->get('text_ship_street2');
		$this->data['text_ship_city'] = $this->language->get('text_ship_city');
		$this->data['text_ship_state'] = $this->language->get('text_ship_state');
		$this->data['text_ship_zip'] = $this->language->get('text_ship_zip');
		$this->data['text_ship_country'] = $this->language->get('text_ship_country');
		$this->data['text_ship_phone'] = $this->language->get('text_ship_phone');
		$this->data['text_ship_sec_add1'] = $this->language->get('text_ship_sec_add1');
		$this->data['text_ship_sec_add2'] = $this->language->get('text_ship_sec_add2');
		$this->data['text_ship_sec_city'] = $this->language->get('text_ship_sec_city');
		$this->data['text_ship_sec_state'] = $this->language->get('text_ship_sec_state');
		$this->data['text_ship_sec_zip'] = $this->language->get('text_ship_sec_zip');
		$this->data['text_ship_sec_country'] = $this->language->get('text_ship_sec_country');
		$this->data['text_ship_sec_phone'] = $this->language->get('text_ship_sec_phone');
		$this->data['text_trans_id'] = $this->language->get('text_trans_id');
		$this->data['text_receipt_id'] = $this->language->get('text_receipt_id');
		$this->data['text_parent_trans_id'] = $this->language->get('text_parent_trans_id');
		$this->data['text_trans_type'] = $this->language->get('text_trans_type');
		$this->data['text_payment_type'] = $this->language->get('text_payment_type');
		$this->data['text_order_time'] = $this->language->get('text_order_time');
		$this->data['text_fee_amount'] = $this->language->get('text_fee_amount');
		$this->data['text_settle_amount'] = $this->language->get('text_settle_amount');
		$this->data['text_tax_amount'] = $this->language->get('text_tax_amount');
		$this->data['text_exchange'] = $this->language->get('text_exchange');
		$this->data['text_payment_status'] = $this->language->get('text_payment_status');
		$this->data['text_pending_reason'] = $this->language->get('text_pending_reason');
		$this->data['text_reason_code'] = $this->language->get('text_reason_code');
		$this->data['text_protect_elig'] = $this->language->get('text_protect_elig');
		$this->data['text_protect_elig_type'] = $this->language->get('text_protect_elig_type');
		$this->data['text_store_id'] = $this->language->get('text_store_id');
		$this->data['text_terminal_id'] = $this->language->get('text_terminal_id');
		$this->data['text_invoice_number'] = $this->language->get('text_invoice_number');
		$this->data['text_custom'] = $this->language->get('text_custom');
		$this->data['text_note'] = $this->language->get('text_note');
		$this->data['text_sales_tax'] = $this->language->get('text_sales_tax');
		$this->data['text_buyer_id'] = $this->language->get('text_buyer_id');
		$this->data['text_close_date'] = $this->language->get('text_close_date');
		$this->data['text_multi_item'] = $this->language->get('text_multi_item');
		$this->data['text_sub_amt'] = $this->language->get('text_sub_amt');
		$this->data['text_sub_period'] = $this->language->get('text_sub_period');

		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['token'] = $this->session->data['token'];

		// Ensure parameters
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		if (isset($this->request->get['transaction_id'])) {
			$transaction_id = $this->request->get['transaction_id'];
		} else {
			$transaction_id = 0;
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_pp_pro_iframe'),
			'href'      => $this->url->link('payment/pp_pro_iframe', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/pp_pro_iframe/viewTransaction', 'token=' . $this->session->data['token'] . '&transaction_id=' . $transaction_id, 'SSL'),
			'separator' => ' :: '
		);

		$response = $this->model_payment_pp_pro_iframe->requestTransactionDetails($transaction_id);

		if ($response === false) {
			$this->errors['warning'] = $this->language->get('error_connection');

		} elseif (is_array($response) && isset($response['ACK']) && ($response['ACK'] == 'Success')) {
			$this->data['lines'] = $this->formatRows($this->data['transaction']);
			$this->data['view_link'] = $this->url->link('payment/pp_pro_iframe/viewTransaction', 'token=' . $this->session->data['token'], 'SSL');

		} else {
			$this->errors['warning'] = (isset($response['L_SHORTMESSAGE0']) ? $response['L_SHORTMESSAGE0'] : $this->language->get('error_general')) . (isset($response['L_LONGMESSAGE0']) ? '<br />' . $response['L_LONGMESSAGE0'] : '');
		}

		$this->data['back'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id, 'SSL');

		$this->data['errors'] = $this->errors;

		$this->template = 'payment/pp_pro_iframe_view.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function do_resend() {
		$json = array();

		$this->language->load('payment/pp_pro_iframe');

		$this->load->model('payment/pp_pro_iframe');

		if (isset($this->request->get['paypal_iframe_order_transaction_id'])) {
			$transaction = $this->model_payment_pp_pro_iframe->getFailedTransaction($this->request->get['paypal_iframe_order_transaction_id']);

			if ($transaction) {
				$call_data = unserialize($transaction['call_data']);

				$response = $this->model_payment_pp_pro_iframe->call($call_data);

				if ($response === false) {
					$json['error'] = $this->language->get('error_connection');

				} elseif (is_array($response) && isset($response['ACK']) && ($response['ACK'] != 'Failure') && ($response['ACK'] != 'FailureWithWarning')) {
					$parent_transaction = $this->model_payment_pp_pro_iframe->getLocalTransaction($transaction['parent_transaction_id']);

					if ($parent_transaction === false) {
						$json['error'] = $this->language->get('error_missing_parent_transaction');

					} else {
						if ($parent_transaction['amount'] == abs($transaction['amount'])) {
							$this->model_payment_pp_pro_iframe->updateTransactionStatus($transaction['parent_transaction_id'], 'Refunded');
						} else {
							$this->model_payment_pp_pro_iframe->updateTransactionStatus($transaction['parent_transaction_id'], 'Partially-Refunded');
						}

						if (isset($response['REFUNDTRANSACTIONID'])) {
							$transaction['transaction_id'] = $response['REFUNDTRANSACTIONID'];
						} else {
							$transaction['transaction_id'] = $response['TRANSACTIONID'];
						}

						if (isset($response['PAYMENTTYPE'])) {
							$transaction['payment_type'] = $response['PAYMENTTYPE'];
						} else {
							$transaction['payment_type'] = $response['REFUNDSTATUS'];
						}

						if (isset($response['PAYMENTSTATUS'])) {
							$transaction['payment_status'] = $response['PAYMENTSTATUS'];
						} else {
							$transaction['payment_status'] = 'Refunded';
						}

						if (isset($response['AMT'])) {
							$transaction['amount'] = $response['AMT'];
						} else {
							$transaction['amount'] = $transaction['amount'];
						}

						$transaction['pending_reason'] = (isset($response['PENDINGREASON']) ? $response['PENDINGREASON'] : '');

						$this->model_payment_pp_pro_iframe->editTransaction($transaction);

						$json['success'] = $this->language->get('success_transaction_resent');
					}

				} else {
					$json['error'] = (isset($response['L_SHORTMESSAGE0']) ? $response['L_SHORTMESSAGE0'] : $this->language->get('error_general')) . (isset($response['L_LONGMESSAGE0']) ? '<br />' . $response['L_LONGMESSAGE0'] : '');
				}

			} else {
				$json['error'] = $this->language->get('error_missing_transaction');
			}

		} else {
			$json['error'] = $this->language->get('error_missing_data');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function do_reauthorise() {
		$this->language->load('payment/pp_pro_iframe');

		$this->load->model('payment/pp_pro_iframe');

		$json = array();

		if (isset($this->request->post['order_id'])) {
			$paypal_order = $this->model_payment_pp_pro_iframe->getPaypalOrderByOrderId($this->request->post['order_id']);

			if ($paypal_order) {
				$request = array(
					'METHOD'          => 'DoReauthorization',
					'AUTHORIZATIONID' => $paypal_order['authorization_id'],
					'AMT'             => number_format($paypal_order['total'], 2),
					'CURRENCYCODE'    => $paypal_order['currency_code']
				);

				$response = $this->model_payment_pp_pro_iframe->call($request);

				if ($response === false) {
					$json['error'] = $this->language->get('error_connection');

				} elseif (is_array($response) && isset($response['ACK']) && ($response['ACK'] != 'Failure') && ($response['ACK'] != 'FailureWithWarning')) {
					$this->model_payment_pp_pro_iframe->updateAuthorizationId($paypal_order['paypal_iframe_order_id'], $response['AUTHORIZATIONID']);

					$transaction = array(
						'paypal_iframe_order_id' => $paypal_order['paypal_iframe_order_id'],
						'transaction_id'         => '',
						'parent_transaction_id'  => $paypal_order['authorization_id'],
						'note'                   => '',
						'msgsubid'               => '',
						'receipt_id'             => '',
						'payment_type'           => 'instant',
						'payment_status'         => $response['PAYMENTSTATUS'],
						'transaction_entity'     => 'auth',
						'pending_reason'         => $response['PENDINGREASON'],
						'amount'                 => '-' . '',
						'debug_data'             => json_encode($response)
					);

					$this->model_payment_pp_pro_iframe->addTransaction($transaction);

					$transaction['created'] = date($this->language->get('date_format_time'));

					$json['data'] = $transaction;

					$json['success'] = $this->language->get('text_reauthorised');

				} elseif (is_array($response)) {
					$json['error'] = (isset($response['L_SHORTMESSAGE0']) ? $response['L_SHORTMESSAGE0'] : $this->language->get('error_general'));
				}

			} else {
				$json['error'] = $this->language->get('error_missing_order');
			}

		} else {
			$json['error'] = $this->language->get('error_missing_data');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function formatRows($data) {
		$return = array();

		foreach ($data as $k => $v) {
			$elements = preg_split("/(\d+)/", $k, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

			if (isset($elements[1]) && isset($elements[0])) {
				if ($elements[0] == 'L_TIMESTAMP') {
					$v = str_replace('T', ' ', $v);
					$v = str_replace('Z', '', $v);
				}

				$return[$elements[1]][$elements[0]] = $v;
			}
		}

		return $return;
	}

	public function debug_clear() {
		$this->language->load('payment/pp_pro_iframe');

		$file = DIR_LOGS . (self::DEBUG_LOG_FILE);

		$handle = fopen($file, 'w+');

		fclose($handle);

		clearstatcache();

		$this->session->data['success'] = $this->language->get('text_debug_clear_success');

		$this->redirect($this->url->link('payment/pp_pro_iframe', 'token=' . $this->session->data['token'], 'SSL'));
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
			$this->redirect($this->url->link('payment/pp_pro_iframe', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
}
