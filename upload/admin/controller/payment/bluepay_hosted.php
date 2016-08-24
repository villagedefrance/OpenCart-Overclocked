<?php
class ControllerPaymentBluePayHosted extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/bluepay_hosted');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bluepay_hosted', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/bluepay_hosted', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_sim'] = $this->language->get('text_sim');
		$this->data['text_test'] = $this->language->get('text_test');
		$this->data['text_live'] = $this->language->get('text_live');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_authenticate'] = $this->language->get('text_authenticate');
		$this->data['text_amex'] = $this->language->get('text_amex');
		$this->data['text_discover'] = $this->language->get('text_discover');

		$this->data['entry_account_name'] = $this->language->get('entry_account_name');
		$this->data['entry_account_id'] = $this->language->get('entry_account_id');
		$this->data['entry_secret_key'] = $this->language->get('entry_secret_key');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_transaction'] = $this->language->get('entry_transaction');
		$this->data['entry_card_amex'] = $this->language->get('entry_card_amex');
		$this->data['entry_card_discover'] = $this->language->get('entry_card_discover');

		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_card'] = $this->language->get('entry_card');

		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_total_max'] = $this->language->get('help_total_max');
		$this->data['help_debug'] = $this->language->get('help_debug');
		$this->data['help_transaction'] = $this->language->get('help_transaction');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['account_name'])) {
			$this->data['error_account_name'] = $this->error['account_name'];
		} else {
			$this->data['error_account_name'] = '';
		}

		if (isset($this->error['account_id'])) {
			$this->data['error_account_id'] = $this->error['account_id'];
		} else {
			$this->data['error_account_id'] = '';
		}

		if (isset($this->error['secret_key'])) {
			$this->data['error_secret_key'] = $this->error['secret_key'];
		} else {
			$this->data['error_secret_key'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/bluepay_hosted', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/bluepay_hosted', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['bluepay_hosted_account_name'])) {
			$this->data['bluepay_hosted_account_name'] = $this->request->post['bluepay_hosted_account_name'];
		} else {
			$this->data['bluepay_hosted_account_name'] = $this->config->get('bluepay_hosted_account_name');
		}

		if (isset($this->request->post['bluepay_hosted_account_id'])) {
			$this->data['bluepay_hosted_account_id'] = $this->request->post['bluepay_hosted_account_id'];
		} else {
			$this->data['bluepay_hosted_account_id'] = $this->config->get('bluepay_hosted_account_id');
		}

		if (isset($this->request->post['bluepay_hosted_secret_key'])) {
			$this->data['bluepay_hosted_secret_key'] = $this->request->post['bluepay_hosted_secret_key'];
		} else {
			$this->data['bluepay_hosted_secret_key'] = $this->config->get('bluepay_hosted_secret_key');
		}

		if (isset($this->request->post['bluepay_hosted_test'])) {
			$this->data['bluepay_hosted_test'] = $this->request->post['bluepay_hosted_test'];
		} else {
			$this->data['bluepay_hosted_test'] = $this->config->get('bluepay_hosted_test');
		}

		if (isset($this->request->post['bluepay_hosted_transaction'])) {
			$this->data['bluepay_hosted_transaction'] = $this->request->post['bluepay_hosted_transaction'];
		} else {
			$this->data['bluepay_hosted_transaction'] = $this->config->get('bluepay_hosted_transaction');
		}

		if (isset($this->request->post['bluepay_hosted_amex'])) {
			$this->data['bluepay_hosted_amex'] = $this->request->post['bluepay_hosted_amex'];
		} else {
			$this->data['bluepay_hosted_amex'] = $this->config->get('bluepay_hosted_amex');
		}

		if (isset($this->request->post['bluepay_hosted_discover'])) {
			$this->data['bluepay_hosted_discover'] = $this->request->post['bluepay_hosted_discover'];
		} else {
			$this->data['bluepay_hosted_discover'] = $this->config->get('bluepay_hosted_discover');
		}

		if (isset($this->request->post['bluepay_hosted_total'])) {
			$this->data['bluepay_hosted_total'] = $this->request->post['bluepay_hosted_total'];
		} else {
			$this->data['bluepay_hosted_total'] = $this->config->get('bluepay_hosted_total');
		}

		if (isset($this->request->post['bluepay_hosted_total_max'])) {
			$this->data['bluepay_hosted_total_max'] = $this->request->post['bluepay_hosted_total_max'];
		} else {
			$this->data['bluepay_hosted_total_max'] = $this->config->get('bluepay_hosted_total_max');
		}

		if (isset($this->request->post['bluepay_hosted_order_status_id'])) {
			$this->data['bluepay_hosted_order_status_id'] = $this->request->post['bluepay_hosted_order_status_id'];
		} elseif ($this->config->get('bluepay_hosted_order_status_id')) {
			$this->data['bluepay_hosted_order_status_id'] = $this->config->get('bluepay_hosted_order_status_id');
		} else {
			$this->data['bluepay_hosted_order_status_id'] = 2;
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['bluepay_hosted_geo_zone_id'])) {
			$this->data['bluepay_hosted_geo_zone_id'] = $this->request->post['bluepay_hosted_geo_zone_id'];
		} else {
			$this->data['bluepay_hosted_geo_zone_id'] = $this->config->get('bluepay_hosted_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['bluepay_hosted_status'])) {
			$this->data['bluepay_hosted_status'] = $this->request->post['bluepay_hosted_status'];
		} else {
			$this->data['bluepay_hosted_status'] = $this->config->get('bluepay_hosted_status');
		}

		if (isset($this->request->post['bluepay_hosted_debug'])) {
			$this->data['bluepay_hosted_debug'] = $this->request->post['bluepay_hosted_debug'];
		} else {
			$this->data['bluepay_hosted_debug'] = $this->config->get('bluepay_hosted_debug');
		}

		if (isset($this->request->post['bluepay_hosted_sort_order'])) {
			$this->data['bluepay_hosted_sort_order'] = $this->request->post['bluepay_hosted_sort_order'];
		} else {
			$this->data['bluepay_hosted_sort_order'] = $this->config->get('bluepay_hosted_sort_order');
		}

		$this->template = 'payment/bluepay_hosted.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model('payment/bluepay_hosted');

		$this->model_payment_bluepay_hosted->install();
	}

	public function uninstall() {
		$this->load->model('payment/bluepay_hosted');

		$this->model_payment_bluepay_hosted->uninstall();
	}

	public function orderAction() {
		if ($this->config->get('bluepay_hosted_status')) {
			$this->load->model('payment/bluepay_hosted');

			$bluepay_hosted_order = $this->model_payment_bluepay_hosted->getOrder($this->request->get['order_id']);

			if (!empty($bluepay_hosted_order)) {
				$this->language->load('payment/bluepay_hosted');

				$bluepay_hosted_order['total_released'] = $this->model_payment_bluepay_hosted->getTotalReleased($bluepay_hosted_order['bluepay_hosted_order_id']);

				$bluepay_hosted_order['total_formatted'] = $this->currency->format($bluepay_hosted_order['total'], $bluepay_hosted_order['currency_code'], false, false);
				$bluepay_hosted_order['total_released_formatted'] = $this->currency->format($bluepay_hosted_order['total_released'], $bluepay_hosted_order['currency_code'], false, false);

				$this->data['bluepay_hosted_order'] = $bluepay_hosted_order;

				$this->data['text_payment_info'] = $this->language->get('text_payment_info');
				$this->data['text_order_ref'] = $this->language->get('text_order_ref');
				$this->data['text_order_total'] = $this->language->get('text_order_total');
				$this->data['text_total_released'] = $this->language->get('text_total_released');
				$this->data['text_release_status'] = $this->language->get('text_release_status');
				$this->data['text_void_status'] = $this->language->get('text_void_status');
				$this->data['text_rebate_status'] = $this->language->get('text_rebate_status');
				$this->data['text_transactions'] = $this->language->get('text_transactions');
				$this->data['text_yes'] = $this->language->get('text_yes');
				$this->data['text_no'] = $this->language->get('text_no');

				$this->data['text_column_amount'] = $this->language->get('text_column_amount');
				$this->data['text_column_type'] = $this->language->get('text_column_type');
				$this->data['text_column_date_added'] = $this->language->get('text_column_date_added');

				$this->data['button_release'] = $this->language->get('button_release');
				$this->data['button_rebate'] = $this->language->get('button_rebate');
				$this->data['button_void'] = $this->language->get('button_void');

				$this->data['text_confirm_void'] = $this->language->get('text_confirm_void');
				$this->data['text_confirm_release'] = $this->language->get('text_confirm_release');
				$this->data['text_confirm_rebate'] = $this->language->get('text_confirm_rebate');

				$this->data['order_id'] = $this->request->get['order_id'];
				$this->data['token'] = $this->request->get['token'];

				$this->template = 'payment/bluepay_hosted_order.tpl';
				$this->children = array(
					'common/header',
					'common/footer'
				);

				$this->response->setOutput($this->render());
			}
		}
	}

	public function void() {
		$this->language->load('payment/bluepay_hosted');

		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
			$this->load->model('payment/bluepay_hosted');

			$bluepay_hosted_order = $this->model_payment_bluepay_hosted->getOrder($this->request->post['order_id']);

			$void_response = $this->model_payment_bluepay_hosted->void($this->request->post['order_id']);

			$this->model_payment_bluepay_hosted->logger('Void result:\r\n' . print_r($void_response, 1));

			if ($void_response['Result'] == 'APPROVED') {
				$this->model_payment_bluepay_hosted->addTransaction($bluepay_hosted_order['bluepay_hosted_order_id'], 'void', $bluepay_hosted_order['total']);
				$this->model_payment_bluepay_hosted->updateVoidStatus($bluepay_hosted_order['bluepay_hosted_order_id'], 1);

				$json['msg'] = $this->language->get('text_void_ok');
				$json['data'] = array();
				$json['data']['date_added'] = date("Y-m-d H:i:s");
				$json['data']['total'] = $bluepay_hosted_order['total'];
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($void_response['MESSAGE']) && !empty($void_response['MESSAGE']) ? (string)$void_response['MESSAGE'] : 'Unable to void';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function release() {
		$this->language->load('payment/bluepay_hosted');

		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '' && isset($this->request->post['amount']) && $this->request->post['amount'] > 0) {
			$this->load->model('payment/bluepay_hosted');

			$bluepay_hosted_order = $this->model_payment_bluepay_hosted->getOrder($this->request->post['order_id']);

			$release_response = $this->model_payment_bluepay_hosted->release($this->request->post['order_id'], $this->request->post['amount']);

			$this->model_payment_bluepay_hosted->logger('Release result:\r\n' . print_r($release_response, 1));

			if ($release_response['Result'] == 'APPROVED') {
				$this->model_payment_bluepay_hosted->addTransaction($bluepay_hosted_order['bluepay_hosted_order_id'], 'payment', $this->request->post['amount']);
				$this->model_payment_bluepay_hosted->updateTransactionId($bluepay_hosted_order['bluepay_hosted_order_id'], $release_response['RRNO']);

				$total_released = $this->model_payment_bluepay_hosted->getTotalReleased($bluepay_hosted_order['bluepay_hosted_order_id']);

				if ($total_released >= $bluepay_hosted_order['total']) {
					$this->model_payment_bluepay_hosted->updateReleaseStatus($bluepay_hosted_order['bluepay_hosted_order_id'], 1);

					$release_status = 1;
					$json['msg'] = $this->language->get('text_release_ok_order');
				} else {
					$release_status = 0;
					$json['msg'] = $this->language->get('text_release_ok');
				}

				$json['data'] = array();
				$json['data']['date_added'] = date("Y-m-d H:i:s");
				$json['data']['amount'] = $this->request->post['amount'];
				$json['data']['release_status'] = $release_status;
				$json['data']['total'] = (float)$total_released;
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($release_response['MESSAGE']) && !empty($release_response['MESSAGE']) ? (string)$release_response['MESSAGE'] : 'Unable to release';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = $this->language->get('error_data_missing');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function rebate() {
		$this->language->load('payment/bluepay_hosted');

		$json = array();

		if (isset($this->request->post['order_id']) && !empty($this->request->post['order_id'])) {
			$this->load->model('payment/bluepay_hosted');

			$bluepay_hosted_order = $this->model_payment_bluepay_hosted->getOrder($this->request->post['order_id']);

			$rebate_response = $this->model_payment_bluepay_hosted->rebate($this->request->post['order_id'], $this->request->post['amount']);

			$this->model_payment_bluepay_hosted->logger('Rebate result:\r\n' . print_r($rebate_response, 1));

			if ($rebate_response['Result'] == 'APPROVED') {
				$this->model_payment_bluepay_hosted->addTransaction($bluepay_hosted_order['bluepay_hosted_order_id'], 'rebate', $this->request->post['amount'] * -1);

				$total_rebated = $this->model_payment_bluepay_hosted->getTotalRebated($bluepay_hosted_order['bluepay_hosted_order_id']);
				$total_released = $this->model_payment_bluepay_hosted->getTotalReleased($bluepay_hosted_order['bluepay_hosted_order_id']);

				if ($total_released <= 0 && $bluepay_hosted_order['release_status'] == 1) {
					$this->model_payment_bluepay_hosted->updateRebateStatus($bluepay_hosted_order['bluepay_hosted_order_id'], 1);

					$rebate_status = 1;
					$json['msg'] = $this->language->get('text_rebate_ok_order');
				} else {
					$rebate_status = 0;
					$json['msg'] = $this->language->get('text_rebate_ok');
				}

				$json['data'] = array();
				$json['data']['date_added'] = date("Y-m-d H:i:s");
				$json['data']['amount'] = $this->request->post['amount'] * -1;
				$json['data']['total_released'] = (float)$total_released;
				$json['data']['total_rebated'] = (float)$total_rebated;
				$json['data']['rebate_status'] = $rebate_status;
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($rebate_response['MESSAGE']) && !empty($rebate_response['MESSAGE']) ? (string)$rebate_response['MESSAGE'] : 'Unable to rebate';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/bluepay_hosted')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['bluepay_hosted_account_name']) {
			$this->error['account_name'] = $this->language->get('error_account_name');
		}

		if (!$this->request->post['bluepay_hosted_account_id']) {
			$this->error['account_id'] = $this->language->get('error_account_id');
		}

		if (!$this->request->post['bluepay_hosted_secret_key']) {
			$this->error['secret_key'] = $this->language->get('error_secret_key');
		}

		return empty($this->error);
	}

	public function callback() {
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($this->request->get));
	}
}
