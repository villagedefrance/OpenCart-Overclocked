<?php
class ControllerPaymentFirstdataRemote extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/firstdata_remote');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('firstdata_remote', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/firstdata_remote', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_notification_url'] = $this->language->get('text_notification_url');
		$this->data['text_card_type'] = $this->language->get('text_card_type');
		$this->data['text_merchant_id'] = $this->language->get('text_merchant_id');
		$this->data['text_subaccount'] = $this->language->get('text_subaccount');
		$this->data['text_secret'] = $this->language->get('text_secret');
		$this->data['text_settle_delayed'] = $this->language->get('text_settle_delayed');
		$this->data['text_settle_auto'] = $this->language->get('text_settle_auto');

		$this->data['entry_certificate_path'] = $this->language->get('entry_certificate_path');
		$this->data['entry_certificate_key_path'] = $this->language->get('entry_certificate_key_path');
		$this->data['entry_certificate_key_pw'] = $this->language->get('entry_certificate_key_pw');
		$this->data['entry_certificate_ca_path'] = $this->language->get('entry_certificate_ca_path');
		$this->data['entry_merchant_id'] = $this->language->get('entry_merchant_id');
		$this->data['entry_user_id'] = $this->language->get('entry_user_id');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_auto_settle'] = $this->language->get('entry_auto_settle');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_enable_card_store'] = $this->language->get('entry_enable_card_store');
		$this->data['entry_cards_accepted'] = $this->language->get('entry_cards_accepted');
		$this->data['entry_status_success_settled'] = $this->language->get('entry_status_success_settled');
		$this->data['entry_status_success_unsettled'] = $this->language->get('entry_status_success_unsettled');
		$this->data['entry_status_decline'] = $this->language->get('entry_status_decline');
		$this->data['entry_status_void'] = $this->language->get('entry_status_void');
		$this->data['entry_status_refund'] = $this->language->get('entry_status_refund');

		$this->data['help_certificate'] = $this->language->get('help_certificate');
		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_total_max'] = $this->language->get('help_total_max');
		$this->data['help_card_select'] = $this->language->get('help_card_select');
		$this->data['help_debug'] = $this->language->get('help_debug');
		$this->data['help_settle'] = $this->language->get('help_settle');
		$this->data['help_notification'] = $this->language->get('help_notification');

		$this->data['tab_account'] = $this->language->get('tab_account');
		$this->data['tab_order_status'] = $this->language->get('tab_order_status');
		$this->data['tab_payment'] = $this->language->get('tab_payment');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['error_merchant_id'])) {
			$this->data['error_merchant_id'] = $this->error['error_merchant_id'];
		} else {
			$this->data['error_merchant_id'] = '';
		}

		if (isset($this->error['error_user_id'])) {
			$this->data['error_user_id'] = $this->error['error_user_id'];
		} else {
			$this->data['error_user_id'] = '';
		}

		if (isset($this->error['error_password'])) {
			$this->data['error_password'] = $this->error['error_password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['error_certificate'])) {
			$this->data['error_certificate'] = $this->error['error_certificate'];
		} else {
			$this->data['error_certificate'] = '';
		}

		if (isset($this->error['error_key'])) {
			$this->data['error_key'] = $this->error['error_key'];
		} else {
			$this->data['error_key'] = '';
		}

		if (isset($this->error['error_key_pw'])) {
			$this->data['error_key_pw'] = $this->error['error_key_pw'];
		} else {
			$this->data['error_key_pw'] = '';
		}

		if (isset($this->error['error_ca'])) {
			$this->data['error_ca'] = $this->error['error_ca'];
		} else {
			$this->data['error_ca'] = '';
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
			'href'      => $this->url->link('payment/firstdata_remote', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/firstdata_remote', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['firstdata_remote_merchant_id'])) {
			$this->data['firstdata_remote_merchant_id'] = $this->request->post['firstdata_remote_merchant_id'];
		} else {
			$this->data['firstdata_remote_merchant_id'] = $this->config->get('firstdata_remote_merchant_id');
		}

		if (isset($this->request->post['firstdata_remote_user_id'])) {
			$this->data['firstdata_remote_user_id'] = $this->request->post['firstdata_remote_user_id'];
		} else {
			$this->data['firstdata_remote_user_id'] = $this->config->get('firstdata_remote_user_id');
		}

		if (isset($this->request->post['firstdata_remote_password'])) {
			$this->data['firstdata_remote_password'] = $this->request->post['firstdata_remote_password'];
		} else {
			$this->data['firstdata_remote_password'] = $this->config->get('firstdata_remote_password');
		}

		if (isset($this->request->post['firstdata_remote_certificate'])) {
			$this->data['firstdata_remote_certificate'] = $this->request->post['firstdata_remote_certificate'];
		} else {
			$this->data['firstdata_remote_certificate'] = $this->config->get('firstdata_remote_certificate');
		}

		if (isset($this->request->post['firstdata_remote_key'])) {
			$this->data['firstdata_remote_key'] = $this->request->post['firstdata_remote_key'];
		} else {
			$this->data['firstdata_remote_key'] = $this->config->get('firstdata_remote_key');
		}

		if (isset($this->request->post['firstdata_remote_key_pw'])) {
			$this->data['firstdata_remote_key_pw'] = $this->request->post['firstdata_remote_key_pw'];
		} else {
			$this->data['firstdata_remote_key_pw'] = $this->config->get('firstdata_remote_key_pw');
		}

		if (isset($this->request->post['firstdata_remote_ca'])) {
			$this->data['firstdata_remote_ca'] = $this->request->post['firstdata_remote_ca'];
		} else {
			$this->data['firstdata_remote_ca'] = $this->config->get('firstdata_remote_ca');
		}

		if (isset($this->request->post['firstdata_remote_geo_zone_id'])) {
			$this->data['firstdata_remote_geo_zone_id'] = $this->request->post['firstdata_remote_geo_zone_id'];
		} else {
			$this->data['firstdata_remote_geo_zone_id'] = $this->config->get('firstdata_remote_geo_zone_id');
		}

		if (isset($this->request->post['firstdata_remote_total'])) {
			$this->data['firstdata_remote_total'] = $this->request->post['firstdata_remote_total'];
		} else {
			$this->data['firstdata_remote_total'] = $this->config->get('firstdata_remote_total');
		}

		if (isset($this->request->post['firstdata_remote_total_max'])) {
			$this->data['firstdata_remote_total_max'] = $this->request->post['firstdata_remote_total_max'];
		} else {
			$this->data['firstdata_remote_total_max'] = $this->config->get('firstdata_remote_total_max');
		}

		if (isset($this->request->post['firstdata_remote_sort_order'])) {
			$this->data['firstdata_remote_sort_order'] = $this->request->post['firstdata_remote_sort_order'];
		} else {
			$this->data['firstdata_remote_sort_order'] = $this->config->get('firstdata_remote_sort_order');
		}

		if (isset($this->request->post['firstdata_remote_status'])) {
			$this->data['firstdata_remote_status'] = $this->request->post['firstdata_remote_status'];
		} else {
			$this->data['firstdata_remote_status'] = $this->config->get('firstdata_remote_status');
		}

		if (isset($this->request->post['firstdata_remote_debug'])) {
			$this->data['firstdata_remote_debug'] = $this->request->post['firstdata_remote_debug'];
		} else {
			$this->data['firstdata_remote_debug'] = $this->config->get('firstdata_remote_debug');
		}

		if (isset($this->request->post['firstdata_remote_auto_settle'])) {
			$this->data['firstdata_remote_auto_settle'] = $this->request->post['firstdata_remote_auto_settle'];
		} elseif (!isset($this->request->post['firstdata_auto_settle']) && $this->config->get('firstdata_remote_auto_settle') != '') {
			$this->data['firstdata_remote_auto_settle'] = $this->config->get('firstdata_remote_auto_settle');
		} else {
			$this->data['firstdata_remote_auto_settle'] = 1;
		}

		if (isset($this->request->post['firstdata_remote_3d'])) {
			$this->data['firstdata_remote_3d'] = $this->request->post['firstdata_remote_3d'];
		} else {
			$this->data['firstdata_remote_3d'] = $this->config->get('firstdata_remote_3d');
		}

		if (isset($this->request->post['firstdata_remote_liability'])) {
			$this->data['firstdata_remote_liability'] = $this->request->post['firstdata_remote_liability'];
		} else {
			$this->data['firstdata_remote_liability'] = $this->config->get('firstdata_remote_liability');
		}

		if (isset($this->request->post['firstdata_remote_order_status_success_settled_id'])) {
			$this->data['firstdata_remote_order_status_success_settled_id'] = $this->request->post['firstdata_remote_order_status_success_settled_id'];
		} else {
			$this->data['firstdata_remote_order_status_success_settled_id'] = $this->config->get('firstdata_remote_order_status_success_settled_id');
		}

		if (isset($this->request->post['firstdata_remote_order_status_success_unsettled_id'])) {
			$this->data['firstdata_remote_order_status_success_unsettled_id'] = $this->request->post['firstdata_remote_order_status_success_unsettled_id'];
		} else {
			$this->data['firstdata_remote_order_status_success_unsettled_id'] = $this->config->get('firstdata_remote_order_status_success_unsettled_id');
		}

		if (isset($this->request->post['firstdata_remote_order_status_decline_id'])) {
			$this->data['firstdata_remote_order_status_decline_id'] = $this->request->post['firstdata_remote_order_status_decline_id'];
		} else {
			$this->data['firstdata_remote_order_status_decline_id'] = $this->config->get('firstdata_remote_order_status_decline_id');
		}

		if (isset($this->request->post['firstdata_remote_order_status_void_id'])) {
			$this->data['firstdata_remote_order_status_void_id'] = $this->request->post['firstdata_remote_order_status_void_id'];
		} else {
			$this->data['firstdata_remote_order_status_void_id'] = $this->config->get('firstdata_remote_order_status_void_id');
		}

		if (isset($this->request->post['firstdata_remote_order_status_refunded_id'])) {
			$this->data['firstdata_remote_order_status_refunded_id'] = $this->request->post['firstdata_remote_order_status_refunded_id'];
		} else {
			$this->data['firstdata_remote_order_status_refunded_id'] = $this->config->get('firstdata_remote_order_status_refunded_id');
		}

		if (isset($this->request->post['firstdata_remote_card_storage'])) {
			$this->data['firstdata_remote_card_storage'] = $this->request->post['firstdata_remote_card_storage'];
		} else {
			$this->data['firstdata_remote_card_storage'] = $this->config->get('firstdata_remote_card_storage');
		}

		$this->data['cards'] = array();

		$this->data['cards'][] = array(
			'text'  => $this->language->get('text_mastercard'),
			'value' => 'mastercard'
		);

		$this->data['cards'][] = array(
			'text'  => $this->language->get('text_visa'),
			'value' => 'visa'
		);

		$this->data['cards'][] = array(
			'text'  => $this->language->get('text_diners'),
			'value' => 'diners'
		);

		$this->data['cards'][] = array(
			'text'  => $this->language->get('text_amex'),
			'value' => 'amex'
		);

		$this->data['cards'][] = array(
			'text'  => $this->language->get('text_maestro'),
			'value' => 'maestro'
		);

		if (isset($this->request->post['firstdata_remote_cards_accepted'])) {
			$this->data['firstdata_remote_cards_accepted'] = $this->request->post['firstdata_remote_cards_accepted'];
		} elseif ($this->config->get('firstdata_remote_cards_accepted')) {
			$this->data['firstdata_remote_cards_accepted'] = $this->config->get('firstdata_remote_cards_accepted');
		} else {
			$this->data['firstdata_remote_cards_accepted'] = array();
		}

		$this->template = 'payment/firstdata_remote.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model('payment/firstdata_remote');

		$this->model_payment_firstdata_remote->install();
	}

	public function uninstall() {
		$this->load->model('payment/firstdata_remote');

		$this->model_payment_firstdata_remote->uninstall();
	}

	public function orderAction() {
		if ($this->config->get('firstdata_remote_status')) {
			$this->load->model('payment/firstdata_remote');

			$firstdata_order = $this->model_payment_firstdata_remote->getOrder($this->request->get['order_id']);

			if (!empty($firstdata_order)) {
				$this->load->language('payment/firstdata_remote');

				$firstdata_order['total_captured'] = $this->model_payment_firstdata_remote->getTotalCaptured($firstdata_order['firstdata_remote_order_id']);

				$firstdata_order['total_formatted'] = $this->currency->format($firstdata_order['total'], $firstdata_order['currency_code'], 1, true);
				$firstdata_order['total_captured_formatted'] = $this->currency->format($firstdata_order['total_captured'], $firstdata_order['currency_code'], 1, true);

				$this->data['firstdata_order'] = $firstdata_order;

				$this->data['text_payment_info'] = $this->language->get('text_payment_info');
				$this->data['text_order_ref'] = $this->language->get('text_order_ref');
				$this->data['text_order_total'] = $this->language->get('text_order_total');
				$this->data['text_total_captured'] = $this->language->get('text_total_captured');
				$this->data['text_capture_status'] = $this->language->get('text_capture_status');
				$this->data['text_void_status'] = $this->language->get('text_void_status');
				$this->data['text_refund_status'] = $this->language->get('text_refund_status');
				$this->data['text_transactions'] = $this->language->get('text_transactions');
				$this->data['text_yes'] = $this->language->get('text_yes');
				$this->data['text_no'] = $this->language->get('text_no');

				$this->data['text_column_amount'] = $this->language->get('text_column_amount');
				$this->data['text_column_type'] = $this->language->get('text_column_type');
				$this->data['text_column_date_added'] = $this->language->get('text_column_date_added');

				$this->data['button_capture'] = $this->language->get('button_capture');
				$this->data['button_refund'] = $this->language->get('button_refund');
				$this->data['button_void'] = $this->language->get('button_void');

				$this->data['text_confirm_void'] = $this->language->get('text_confirm_void');
				$this->data['text_confirm_capture'] = $this->language->get('text_confirm_capture');
				$this->data['text_confirm_refund'] = $this->language->get('text_confirm_refund');

				$this->data['order_id'] = $this->request->get['order_id'];

				$this->data['token'] = $this->request->get['token'];

				$this->template = 'payment/firstdata_remote_order.tpl';
				$this->children = array(
					'common/header',
					'common/footer'
				);

				$this->response->setOutput($this->render());
			}
		}
	}

	public function void() {
		$this->language->load('payment/firstdata_remote');

		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
			$this->load->model('payment/firstdata_remote');

			$firstdata_order = $this->model_payment_firstdata_remote->getOrder($this->request->post['order_id']);

			$void_response = $this->model_payment_firstdata_remote->void($firstdata_order['order_ref'], $firstdata_order['tdate']);

			$this->model_payment_firstdata_remote->logger('Void result:\r\n' . print_r($void_response, 1));

			if (strtoupper($void_response['transaction_result']) == 'APPROVED') {
				$this->model_payment_firstdata_remote->addTransaction($firstdata_order['firstdata_remote_order_id'], 'void', 0.00);
				$this->model_payment_firstdata_remote->updateVoidStatus($firstdata_order['firstdata_remote_order_id'], 1);

				$json['msg'] = $this->language->get('text_void_ok');
				$json['data'] = array();
				$json['data']['column_date_added'] = date('Y-m-d H:i:s');
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($void_response['error']) && !empty($void_response['error']) ? (string)$void_response['error'] : 'Unable to void';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function capture() {
		$this->language->load('payment/firstdata');

		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
			$this->load->model('payment/firstdata_remote');

			$firstdata_order = $this->model_payment_firstdata_remote->getOrder($this->request->post['order_id']);

			$capture_response = $this->model_payment_firstdata_remote->capture($firstdata_order['order_ref'], $firstdata_order['total'], $firstdata_order['currency_code']);

			$this->model_payment_firstdata_remote->logger('Settle result:\r\n' . print_r($capture_response, 1));

			if (strtoupper($capture_response['transaction_result']) == 'APPROVED') {
				$this->model_payment_firstdata_remote->addTransaction($firstdata_order['firstdata_remote_order_id'], 'payment', $firstdata_order['total']);

				$total_captured = $this->model_payment_firstdata_remote->getTotalCaptured($firstdata_order['firstdata_remote_order_id']);

				$this->model_payment_firstdata_remote->updateCaptureStatus($firstdata_order['firstdata_remote_order_id'], 1);

				$capture_status = 1;

				$json['msg'] = $this->language->get('text_capture_ok_order');
				$json['data'] = array();
				$json['data']['column_date_added'] = date("Y-m-d H:i:s");
				$json['data']['amount'] = (float)$firstdata_order['total'];
				$json['data']['capture_status'] = $capture_status;
				$json['data']['total'] = (float)$total_captured;
				$json['data']['total_formatted'] = $this->currency->format($total_captured, $firstdata_order['currency_code'], 1, true);
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($capture_response['error']) && !empty($capture_response['error']) ? (string)$capture_response['error'] : 'Unable to capture';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function refund() {
		$this->language->load('payment/firstdata_remote');

		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
			$this->load->model('payment/firstdata_remote');

			$firstdata_order = $this->model_payment_firstdata_remote->getOrder($this->request->post['order_id']);

			$refund_response = $this->model_payment_firstdata_remote->refund($firstdata_order['order_ref'], $firstdata_order['total'], $firstdata_order['currency_code']);

			$this->model_payment_firstdata_remote->logger('Refund result:\r\n' . print_r($refund_response, 1));

			if (strtoupper($refund_response['transaction_result']) == 'APPROVED') {
				$this->model_payment_firstdata_remote->addTransaction($firstdata_order['firstdata_remote_order_id'], 'refund', $firstdata_order['total'] * -1);

				$total_refunded = $this->model_payment_firstdata_remote->getTotalRefunded($firstdata_order['firstdata_remote_order_id']);
				$total_captured = $this->model_payment_firstdata_remote->getTotalCaptured($firstdata_order['firstdata_remote_order_id']);

				if ($total_captured <= 0 && $firstdata_order['capture_status'] == 1) {
					$this->model_payment_firstdata_remote->updateRefundStatus($firstdata_order['firstdata_remote_order_id'], 1);

					$refund_status = 1;
					$json['msg'] = $this->language->get('text_refund_ok_order');
				} else {
					$refund_status = 0;
					$json['msg'] = $this->language->get('text_refund_ok');
				}

				$json['data'] = array();
				$json['data']['column_date_added'] = date("Y-m-d H:i:s");
				$json['data']['amount'] = $firstdata_order['total'] * -1;
				$json['data']['total_captured'] = (float)$total_captured;
				$json['data']['total_refunded'] = (float)$total_refunded;
				$json['data']['refund_status'] = $refund_status;
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($refund_response['error']) && !empty($refund_response['error']) ? (string)$refund_response['error'] : 'Unable to refund';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/firstdata_remote')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['firstdata_remote_merchant_id']) {
			$this->error['error_merchant_id'] = $this->language->get('error_merchant_id');
		}

		if (!$this->request->post['firstdata_remote_user_id']) {
			$this->error['error_user_id'] = $this->language->get('error_user_id');
		}

		if (!$this->request->post['firstdata_remote_password']) {
			$this->error['error_password'] = $this->language->get('error_password');
		}

		if (!$this->request->post['firstdata_remote_certificate']) {
			$this->error['error_certificate'] = $this->language->get('error_certificate');
		}

		if (!$this->request->post['firstdata_remote_key']) {
			$this->error['error_key'] = $this->language->get('error_key');
		}

		if (!$this->request->post['firstdata_remote_key_pw']) {
			$this->error['error_key_pw'] = $this->language->get('error_key_pw');
		}

		if (!$this->request->post['firstdata_remote_ca']) {
			$this->error['error_ca'] = $this->language->get('error_ca');
		}

		return empty($this->error);
	}
}
