<?php
class ControllerPaymentGlobalpay extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/globalpay');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('globalpay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/globalpay', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_live'] = $this->language->get('text_live');
		$this->data['text_demo'] = $this->language->get('text_demo');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_card_type'] = $this->language->get('text_card_type');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_use_default'] = $this->language->get('text_use_default');
		$this->data['text_merchant_id'] = $this->language->get('text_merchant_id');
		$this->data['text_subaccount'] = $this->language->get('text_subaccount');
		$this->data['text_secret'] = $this->language->get('text_secret');
		$this->data['text_card_visa'] = $this->language->get('text_card_visa');
		$this->data['text_card_master'] = $this->language->get('text_card_master');
		$this->data['text_card_amex'] = $this->language->get('text_card_amex');
		$this->data['text_card_switch'] = $this->language->get('text_card_switch');
		$this->data['text_card_laser'] = $this->language->get('text_card_laser');
		$this->data['text_card_diners'] = $this->language->get('text_card_diners');
		$this->data['text_settle_delayed'] = $this->language->get('text_settle_delayed');
		$this->data['text_settle_auto'] = $this->language->get('text_settle_auto');
		$this->data['text_settle_multi'] = $this->language->get('text_settle_multi');
		$this->data['text_url_message'] = $this->language->get('text_url_message');

		$this->data['entry_merchant_id'] = $this->language->get('entry_merchant_id');
		$this->data['entry_secret'] = $this->language->get('entry_secret');
		$this->data['entry_rebate_password'] = $this->language->get('entry_rebate_password');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_live_demo'] = $this->language->get('entry_live_demo');
		$this->data['entry_auto_settle'] = $this->language->get('entry_auto_settle');
		$this->data['entry_card_select'] = $this->language->get('entry_card_select');
		$this->data['entry_tss_check'] = $this->language->get('entry_tss_check');
		$this->data['entry_live_url'] = $this->language->get('entry_live_url');
		$this->data['entry_demo_url'] = $this->language->get('entry_demo_url');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['entry_status_success_settled'] = $this->language->get('entry_status_success_settled');
		$this->data['entry_status_success_unsettled'] = $this->language->get('entry_status_success_unsettled');
		$this->data['entry_status_decline'] = $this->language->get('entry_status_decline');
		$this->data['entry_status_decline_pending'] = $this->language->get('entry_status_decline_pending');
		$this->data['entry_status_decline_stolen'] = $this->language->get('entry_status_decline_stolen');
		$this->data['entry_status_decline_bank'] = $this->language->get('entry_status_decline_bank');
		$this->data['entry_status_void'] = $this->language->get('entry_status_void');
		$this->data['entry_status_rebate'] = $this->language->get('entry_status_rebate');
		$this->data['entry_notification_url'] = $this->language->get('entry_notification_url');

		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_total_max'] = $this->language->get('help_total_max');
		$this->data['help_card_select'] = $this->language->get('help_card_select');
		$this->data['help_debug'] = $this->language->get('help_debug');
		$this->data['help_dcc_settle'] = $this->language->get('help_dcc_settle');
		$this->data['help_notification'] = $this->language->get('help_notification');

		$this->data['tab_api'] = $this->language->get('tab_api');
		$this->data['tab_account'] = $this->language->get('tab_account');
		$this->data['tab_order_status'] = $this->language->get('tab_order_status');
		$this->data['tab_payment'] = $this->language->get('tab_payment');
		$this->data['tab_advanced'] = $this->language->get('tab_advanced');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['error_use_select_card'] = $this->language->get('error_use_select_card');

		$this->data['notify_url'] = HTTPS_CATALOG . 'index.php?route=payment/globalpay/notify';

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

		if (isset($this->error['error_secret'])) {
			$this->data['error_secret'] = $this->error['error_secret'];
		} else {
			$this->data['error_secret'] = '';
		}

		if (isset($this->error['error_live_url'])) {
			$this->data['error_live_url'] = $this->error['error_live_url'];
		} else {
			$this->data['error_live_url'] = '';
		}

		if (isset($this->error['error_demo_url'])) {
			$this->data['error_demo_url'] = $this->error['error_demo_url'];
		} else {
			$this->data['error_demo_url'] = '';
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
			'href'      => $this->url->link('payment/globalpay', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/globalpay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['globalpay_merchant_id'])) {
			$this->data['globalpay_merchant_id'] = $this->request->post['globalpay_merchant_id'];
		} else {
			$this->data['globalpay_merchant_id'] = $this->config->get('globalpay_merchant_id');
		}

		if (isset($this->request->post['globalpay_secret'])) {
			$this->data['globalpay_secret'] = $this->request->post['globalpay_secret'];
		} else {
			$this->data['globalpay_secret'] = $this->config->get('globalpay_secret');
		}

		if (isset($this->request->post['globalpay_rebate_password'])) {
			$this->data['globalpay_rebate_password'] = $this->request->post['globalpay_rebate_password'];
		} else {
			$this->data['globalpay_rebate_password'] = $this->config->get('globalpay_rebate_password');
		}

		if (isset($this->request->post['globalpay_live_demo'])) {
			$this->data['globalpay_live_demo'] = $this->request->post['globalpay_live_demo'];
		} else {
			$this->data['globalpay_live_demo'] = $this->config->get('globalpay_live_demo');
		}

		if (isset($this->request->post['globalpay_geo_zone_id'])) {
			$this->data['globalpay_geo_zone_id'] = $this->request->post['globalpay_geo_zone_id'];
		} else {
			$this->data['globalpay_geo_zone_id'] = $this->config->get('globalpay_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['globalpay_total'])) {
			$this->data['globalpay_total'] = $this->request->post['globalpay_total'];
		} else {
			$this->data['globalpay_total'] = $this->config->get('globalpay_total');
		}

		if (isset($this->request->post['globalpay_total_max'])) {
			$this->data['globalpay_total_max'] = $this->request->post['globalpay_total_max'];
		} else {
			$this->data['globalpay_total_max'] = $this->config->get('globalpay_total_max');
		}

		if (isset($this->request->post['globalpay_sort_order'])) {
			$this->data['globalpay_sort_order'] = $this->request->post['globalpay_sort_order'];
		} else {
			$this->data['globalpay_sort_order'] = $this->config->get('globalpay_sort_order');
		}

		if (isset($this->request->post['globalpay_status'])) {
			$this->data['globalpay_status'] = $this->request->post['globalpay_status'];
		} else {
			$this->data['globalpay_status'] = $this->config->get('globalpay_status');
		}

		if (isset($this->request->post['globalpay_debug'])) {
			$this->data['globalpay_debug'] = $this->request->post['globalpay_debug'];
		} else {
			$this->data['globalpay_debug'] = $this->config->get('globalpay_debug');
		}

		if (isset($this->request->post['globalpay_account'])) {
			$this->data['globalpay_account'] = $this->request->post['globalpay_account'];
		} else {
			$this->data['globalpay_account'] = $this->config->get('globalpay_account');
		}

		if (isset($this->request->post['globalpay_auto_settle'])) {
			$this->data['globalpay_auto_settle'] = $this->request->post['globalpay_auto_settle'];
		} else {
			$this->data['globalpay_auto_settle'] = $this->config->get('globalpay_auto_settle');
		}

		if (isset($this->request->post['globalpay_card_select'])) {
			$this->data['globalpay_card_select'] = $this->request->post['globalpay_card_select'];
		} else {
			$this->data['globalpay_card_select'] = $this->config->get('globalpay_card_select');
		}

		if (isset($this->request->post['globalpay_tss_check'])) {
			$this->data['globalpay_tss_check'] = $this->request->post['globalpay_tss_check'];
		} else {
			$this->data['globalpay_tss_check'] = $this->config->get('globalpay_tss_check');
		}

		if (isset($this->request->post['globalpay_order_status_success_settled_id'])) {
			$this->data['globalpay_order_status_success_settled_id'] = $this->request->post['globalpay_order_status_success_settled_id'];
		} else {
			$this->data['globalpay_order_status_success_settled_id'] = $this->config->get('globalpay_order_status_success_settled_id');
		}

		if (isset($this->request->post['globalpay_order_status_success_unsettled_id'])) {
			$this->data['globalpay_order_status_success_unsettled_id'] = $this->request->post['globalpay_order_status_success_unsettled_id'];
		} else {
			$this->data['globalpay_order_status_success_unsettled_id'] = $this->config->get('globalpay_order_status_success_unsettled_id');
		}

		if (isset($this->request->post['globalpay_order_status_decline_id'])) {
			$this->data['globalpay_order_status_decline_id'] = $this->request->post['globalpay_order_status_decline_id'];
		} else {
			$this->data['globalpay_order_status_decline_id'] = $this->config->get('globalpay_order_status_decline_id');
		}

		if (isset($this->request->post['globalpay_order_status_decline_pending_id'])) {
			$this->data['globalpay_order_status_decline_pending_id'] = $this->request->post['globalpay_order_status_decline_pending_id'];
		} else {
			$this->data['globalpay_order_status_decline_pending_id'] = $this->config->get('globalpay_order_status_decline_pending_id');
		}

		if (isset($this->request->post['globalpay_order_status_decline_stolen_id'])) {
			$this->data['globalpay_order_status_decline_stolen_id'] = $this->request->post['globalpay_order_status_decline_stolen_id'];
		} else {
			$this->data['globalpay_order_status_decline_stolen_id'] = $this->config->get('globalpay_order_status_decline_stolen_id');
		}

		if (isset($this->request->post['globalpay_order_status_decline_bank_id'])) {
			$this->data['globalpay_order_status_decline_bank_id'] = $this->request->post['globalpay_order_status_decline_bank_id'];
		} else {
			$this->data['globalpay_order_status_decline_bank_id'] = $this->config->get('globalpay_order_status_decline_bank_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['globalpay_live_url'])) {
			$this->data['globalpay_live_url'] = $this->request->post['globalpay_live_url'];
		} else {
			$this->data['globalpay_live_url'] = $this->config->get('globalpay_live_url');
		}

		if (empty($this->data['globalpay_live_url'])) {
			$this->data['globalpay_live_url'] = 'https://hpp.globaliris.com/pay';
		}

		if (isset($this->request->post['globalpay_demo_url'])) {
			$this->data['globalpay_demo_url'] = $this->request->post['globalpay_demo_url'];
		} else {
			$this->data['globalpay_demo_url'] = $this->config->get('globalpay_demo_url');
		}

		if (empty($this->data['globalpay_demo_url'])) {
			$this->data['globalpay_demo_url'] = 'https://hpp.sandbox.globaliris.com/pay';
		}

		$this->template = 'payment/globalpay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model('payment/globalpay');

		$this->model_payment_globalpay->install();
	}

	public function uninstall() {
		$this->load->model('payment/globalpay');

		$this->model_payment_globalpay->uninstall();
	}

	public function orderAction() {
		if ($this->config->get('globalpay_status')) {
			$this->load->model('payment/globalpay');

			$globalpay_order = $this->model_payment_globalpay->getOrder($this->request->get['order_id']);

			if (!empty($globalpay_order)) {
				$this->language->load('payment/globalpay');

				$globalpay_order['total_captured'] = $this->model_payment_globalpay->getTotalCaptured($globalpay_order['globalpay_order_id']);

				$globalpay_order['total_formatted'] = $this->currency->format($globalpay_order['total'], $globalpay_order['currency_code'], 1, true);
				$globalpay_order['total_captured_formatted'] = $this->currency->format($globalpay_order['total_captured'], $globalpay_order['currency_code'], 1, true);

				$this->data['globalpay_order'] = $globalpay_order;

				$this->data['auto_settle'] = $globalpay_order['settle_type'];

				$this->data['text_payment_info'] = $this->language->get('text_payment_info');
				$this->data['text_order_ref'] = $this->language->get('text_order_ref');
				$this->data['text_order_total'] = $this->language->get('text_order_total');
				$this->data['text_total_captured'] = $this->language->get('text_total_captured');
				$this->data['text_capture_status'] = $this->language->get('text_capture_status');
				$this->data['text_void_status'] = $this->language->get('text_void_status');
				$this->data['text_rebate_status'] = $this->language->get('text_rebate_status');
				$this->data['text_transactions'] = $this->language->get('text_transactions');
				$this->data['text_yes'] = $this->language->get('text_yes');
				$this->data['text_no'] = $this->language->get('text_no');

				$this->data['text_column_amount'] = $this->language->get('text_column_amount');
				$this->data['text_column_type'] = $this->language->get('text_column_type');
				$this->data['text_column_date_added'] = $this->language->get('text_column_date_added');

				$this->data['button_capture'] = $this->language->get('button_capture');
				$this->data['button_rebate'] = $this->language->get('button_rebate');
				$this->data['button_void'] = $this->language->get('button_void');

				$this->data['text_confirm_void'] = $this->language->get('text_confirm_void');
				$this->data['text_confirm_capture'] = $this->language->get('text_confirm_capture');
				$this->data['text_confirm_rebate'] = $this->language->get('text_confirm_rebate');

				$this->data['order_id'] = $this->request->get['order_id'];

				$this->data['token'] = $this->request->get['token'];

				$this->template = 'payment/globalpay_order.tpl';
				$this->children = array(
					'common/header',
					'common/footer'
				);

				$this->response->setOutput($this->render());
			}
		}
	}

	public function void() {
		$this->language->load('payment/globalpay');

		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
			$this->load->model('payment/globalpay');

			$globalpay_order = $this->model_payment_globalpay->getOrder($this->request->post['order_id']);

			$void_response = $this->model_payment_globalpay->void($this->request->post['order_id']);

			$this->model_payment_globalpay->logger('Void result:\r\n' . print_r($void_response, 1));

			if (isset($void_response->result) && $void_response->result == '00') {
				$this->model_payment_globalpay->addTransaction($globalpay_order['globalpay_order_id'], 'void', 0.00);
				$this->model_payment_globalpay->updateVoidStatus($globalpay_order['globalpay_order_id'], 1);

				$json['msg'] = $this->language->get('text_void_ok');
				$json['data'] = array();
				$json['data']['date_added'] = date("Y-m-d H:i:s");
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($void_response->message) && !empty($void_response->message) ? (string)$void_response->message : 'Unable to void';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function capture() {
		$this->language->load('payment/globalpay');

		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '' && isset($this->request->post['amount']) && $this->request->post['amount'] > 0) {
			$this->load->model('payment/globalpay');

			$globalpay_order = $this->model_payment_globalpay->getOrder($this->request->post['order_id']);

			$capture_response = $this->model_payment_globalpay->capture($this->request->post['order_id'], $this->request->post['amount']);

			$this->model_payment_globalpay->logger('Settle result:\r\n' . print_r($capture_response, 1));

			if (isset($capture_response->result) && $capture_response->result == '00') {
				$this->model_payment_globalpay->addTransaction($globalpay_order['globalpay_order_id'], 'payment', $this->request->post['amount']);

				$total_captured = $this->model_payment_globalpay->getTotalCaptured($globalpay_order['globalpay_order_id']);

				if ($total_captured >= $globalpay_order['total'] || $globalpay_order['settle_type'] == 0) {
					$this->model_payment_globalpay->updateCaptureStatus($globalpay_order['globalpay_order_id'], 1);

					$capture_status = 1;
					$json['msg'] = $this->language->get('text_capture_ok_order');
				} else {
					$capture_status = 0;
					$json['msg'] = $this->language->get('text_capture_ok');
				}

				$this->model_payment_globalpay->updateForRebate($globalpay_order['globalpay_order_id'], $capture_response->pasref, $capture_response->orderid);

				$json['data'] = array();
				$json['data']['date_added'] = date("Y-m-d H:i:s");
				$json['data']['amount'] = $this->request->post['amount'];
				$json['data']['capture_status'] = $capture_status;
				$json['data']['total'] = (double)$total_captured;
				$json['data']['total_formatted'] = $this->currency->format($total_captured, $globalpay_order['currency_code'], 1, true);
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($capture_response->message) && !empty($capture_response->message) ? (string)$capture_response->message : 'Unable to capture';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = $this->language->get('error_data_missing');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function rebate() {
		$this->language->load('payment/globalpay');

		$json = array();

		if (isset($this->request->post['order_id']) && !empty($this->request->post['order_id'])) {
			$this->load->model('payment/globalpay');

			$globalpay_order = $this->model_payment_globalpay->getOrder($this->request->post['order_id']);

			$rebate_response = $this->model_payment_globalpay->rebate($this->request->post['order_id'], $this->request->post['amount']);

			$this->model_payment_globalpay->logger('Rebate result:\r\n' . print_r($rebate_response, 1));

			if (isset($rebate_response->result) && $rebate_response->result == '00') {
				$this->model_payment_globalpay->addTransaction($globalpay_order['globalpay_order_id'], 'rebate', $this->request->post['amount'] * -1);

				$total_rebated = $this->model_payment_globalpay->getTotalRebated($globalpay_order['globalpay_order_id']);
				$total_captured = $this->model_payment_globalpay->getTotalCaptured($globalpay_order['globalpay_order_id']);

				if ($total_captured <= 0 && $globalpay_order['capture_status'] == 1) {
					$this->model_payment_globalpay->updateRebateStatus($globalpay_order['globalpay_order_id'], 1);

					$rebate_status = 1;
					$json['msg'] = $this->language->get('text_rebate_ok_order');
				} else {
					$rebate_status = 0;
					$json['msg'] = $this->language->get('text_rebate_ok');
				}

				$json['data'] = array();
				$json['data']['date_added'] = date("Y-m-d H:i:s");
				$json['data']['amount'] = $this->request->post['amount'] * -1;
				$json['data']['total_captured'] = (double)$total_captured;
				$json['data']['total_rebated'] = (double)$total_rebated;
				$json['data']['rebate_status'] = $rebate_status;

				$json['error'] = false;

			} else {
				$json['error'] = true;
				$json['msg'] = isset($rebate_response->message) && !empty($rebate_response->message) ? (string)$rebate_response->message : 'Unable to rebate';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/globalpay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['globalpay_merchant_id']) {
			$this->error['error_merchant_id'] = $this->language->get('error_merchant_id');
		}

		if (!$this->request->post['globalpay_secret']) {
			$this->error['error_secret'] = $this->language->get('error_secret');
		}

		if (!$this->request->post['globalpay_live_url']) {
			$this->error['error_live_url'] = $this->language->get('error_live_url');
		}

		if (!$this->request->post['globalpay_demo_url']) {
			$this->error['error_demo_url'] = $this->language->get('error_demo_url');
		}

		return empty($this->error);
	}
}
