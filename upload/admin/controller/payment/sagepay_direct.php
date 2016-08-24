<?php
class ControllerPaymentSagepayDirect extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/sagepay_direct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('sagepay_direct', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/sagepay_direct', 'token=' . $this->session->data['token'], 'SSL'));
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
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_defered'] = $this->language->get('text_defered');
		$this->data['text_authenticate'] = $this->language->get('text_authenticate');

		$this->data['entry_vendor'] = $this->language->get('entry_vendor');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_transaction'] = $this->language->get('entry_transaction');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_card'] = $this->language->get('entry_card');
		$this->data['entry_cron_job_token'] = $this->language->get('entry_cron_job_token');
		$this->data['entry_cron_job_url'] = $this->language->get('entry_cron_job_url');
		$this->data['entry_last_cron_job_run'] = $this->language->get('entry_last_cron_job_run');

		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_total_max'] = $this->language->get('help_total_max');
		$this->data['help_debug'] = $this->language->get('help_debug');
		$this->data['help_transaction'] = $this->language->get('help_transaction');
		$this->data['help_cron_job_token'] = $this->language->get('help_cron_job_token');
		$this->data['help_cron_job_url'] = $this->language->get('help_cron_job_url');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['vendor'])) {
			$this->data['error_vendor'] = $this->error['vendor'];
		} else {
			$this->data['error_vendor'] = '';
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
			'href'      => $this->url->link('payment/sagepay_direct', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/sagepay_direct', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['sagepay_direct_vendor'])) {
			$this->data['sagepay_direct_vendor'] = $this->request->post['sagepay_direct_vendor'];
		} else {
			$this->data['sagepay_direct_vendor'] = $this->config->get('sagepay_direct_vendor');
		}

		if (isset($this->request->post['sagepay_direct_password'])) {
			$this->data['sagepay_direct_password'] = $this->request->post['sagepay_direct_password'];
		} else {
			$this->data['sagepay_direct_password'] = $this->config->get('sagepay_direct_password');
		}

		if (isset($this->request->post['sagepay_direct_test'])) {
			$this->data['sagepay_direct_test'] = $this->request->post['sagepay_direct_test'];
		} else {
			$this->data['sagepay_direct_test'] = $this->config->get('sagepay_direct_test');
		}

		if (isset($this->request->post['sagepay_direct_transaction'])) {
			$this->data['sagepay_direct_transaction'] = $this->request->post['sagepay_direct_transaction'];
		} else {
			$this->data['sagepay_direct_transaction'] = $this->config->get('sagepay_direct_transaction');
		}

		if (isset($this->request->post['sagepay_direct_total'])) {
			$this->data['sagepay_direct_total'] = $this->request->post['sagepay_direct_total'];
		} else {
			$this->data['sagepay_direct_total'] = $this->config->get('sagepay_direct_total');
		}

		if (isset($this->request->post['sagepay_direct_total_max'])) {
			$this->data['sagepay_direct_total_max'] = $this->request->post['sagepay_direct_total_max'];
		} else {
			$this->data['sagepay_direct_total_max'] = $this->config->get('sagepay_direct_total_max');
		}

		if (isset($this->request->post['sagepay_direct_card'])) {
			$this->data['sagepay_direct_card'] = $this->request->post['sagepay_direct_card'];
		} else {
			$this->data['sagepay_direct_card'] = $this->config->get('sagepay_direct_card');
		}

		if (isset($this->request->post['sagepay_direct_order_status_id'])) {
			$this->data['sagepay_direct_order_status_id'] = $this->request->post['sagepay_direct_order_status_id'];
		} else {
			$this->data['sagepay_direct_order_status_id'] = $this->config->get('sagepay_direct_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['sagepay_direct_geo_zone_id'])) {
			$this->data['sagepay_direct_geo_zone_id'] = $this->request->post['sagepay_direct_geo_zone_id'];
		} else {
			$this->data['sagepay_direct_geo_zone_id'] = $this->config->get('sagepay_direct_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['sagepay_direct_status'])) {
			$this->data['sagepay_direct_status'] = $this->request->post['sagepay_direct_status'];
		} else {
			$this->data['sagepay_direct_status'] = $this->config->get('sagepay_direct_status');
		}

		if (isset($this->request->post['sagepay_direct_debug'])) {
			$this->data['sagepay_direct_debug'] = $this->request->post['sagepay_direct_debug'];
		} else {
			$this->data['sagepay_direct_debug'] = $this->config->get('sagepay_direct_debug');
		}

		if (isset($this->request->post['sagepay_direct_sort_order'])) {
			$this->data['sagepay_direct_sort_order'] = $this->request->post['sagepay_direct_sort_order'];
		} else {
			$this->data['sagepay_direct_sort_order'] = $this->config->get('sagepay_direct_sort_order');
		}

		if (isset($this->request->post['sagepay_direct_cron_job_token'])) {
			$this->data['sagepay_direct_cron_job_token'] = $this->request->post['sagepay_direct_cron_job_token'];
		} elseif ($this->config->get('sagepay_direct_cron_job_token')) {
			$this->data['sagepay_direct_cron_job_token'] = $this->config->get('sagepay_direct_cron_job_token');
		} else {
			$this->data['sagepay_direct_cron_job_token'] = sha1(uniqid(mt_rand(), 1));
		}

		$this->data['sagepay_direct_cron_job_url'] = HTTPS_CATALOG . 'index.php?route=payment/sagepay_direct/cron&token=' . $this->data['sagepay_direct_cron_job_token'];

		if ($this->config->get('sagepay_direct_last_cron_job_run')) {
			$this->data['sagepay_direct_last_cron_job_run'] = $this->config->get('sagepay_direct_last_cron_job_run');
		} else {
			$this->data['sagepay_direct_last_cron_job_run'] = '';
		}

		$this->template = 'payment/sagepay_direct.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model('payment/sagepay_direct');

		$this->model_payment_sagepay_direct->install();
	}

	public function uninstall() {
		$this->load->model('payment/sagepay_direct');

		$this->model_payment_sagepay_direct->uninstall();
	}

	public function orderAction() {
		if ($this->config->get('sagepay_direct_status')) {
			$this->load->model('payment/sagepay_direct');

			$sagepay_direct_order = $this->model_payment_sagepay_direct->getOrder($this->request->get['order_id']);

			if (!empty($sagepay_direct_order)) {
				$this->language->load('payment/sagepay_direct');

				$sagepay_direct_order['total_released'] = $this->model_payment_sagepay_direct->getTotalReleased($sagepay_direct_order['sagepay_direct_order_id']);

				$sagepay_direct_order['total_formatted'] = $this->currency->format($sagepay_direct_order['total'], $sagepay_direct_order['currency_code'], false, false);
				$sagepay_direct_order['total_released_formatted'] = $this->currency->format($sagepay_direct_order['total_released'], $sagepay_direct_order['currency_code'], false, false);

				$this->data['sagepay_direct_order'] = $sagepay_direct_order;

				$this->data['auto_settle'] = $sagepay_direct_order['settle_type'];

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

				$this->template = 'payment/sagepay_direct_order.tpl';
				$this->children = array(
					'common/header',
					'common/footer'
				);

				$this->response->setOutput($this->render());
			}
		}
	}

	public function void() {
		$this->language->load('payment/sagepay_direct');

		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
			$this->load->model('payment/sagepay_direct');

			$sagepay_direct_order = $this->model_payment_sagepay_direct->getOrder($this->request->post['order_id']);

			$void_response = $this->model_payment_sagepay_direct->void($this->request->post['order_id']);

			$this->model_payment_sagepay_direct->logger('Void result', $void_response);

			if ($void_response['Status'] == 'OK') {
				$this->model_payment_sagepay_direct->addTransaction($sagepay_direct_order['sagepay_direct_order_id'], 'void', 0.00);
				$this->model_payment_sagepay_direct->updateVoidStatus($sagepay_direct_order['sagepay_direct_order_id'], 1);

				$json['msg'] = $this->language->get('text_void_ok');

				$this->load->model('sale/order');

				$history = array();
				$history['order_status_id'] = $this->config->get('sagepay_direct_v3_order_status_void_id');
				$history['comment'] = '';
				$history['notify'] = '';

				$this->model_sale_order->addOrderHistory($this->request->post['order_id'], $history);

				$json['data'] = array();
				$json['data']['date_added'] = date("Y-m-d H:i:s");
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($void_response['StatuesDetail']) && !empty($void_response['StatuesDetail']) ? (string)$void_response['StatuesDetail'] : 'Unable to void';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function release() {
		$this->language->load('payment/sagepay_direct');

		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '' && isset($this->request->post['amount']) && $this->request->post['amount'] > 0) {
			$this->load->model('payment/sagepay_direct');

			$sagepay_direct_order = $this->model_payment_sagepay_direct->getOrder($this->request->post['order_id']);

			$release_response = $this->model_payment_sagepay_direct->release($this->request->post['order_id'], $this->request->post['amount']);

			$this->model_payment_sagepay_direct->logger('Release result', $release_response);

			if ($release_response['Status'] == 'OK') {
				$this->model_payment_sagepay_direct->addTransaction($sagepay_direct_order['sagepay_direct_order_id'], 'payment', $this->request->post['amount']);

				$total_released = $this->model_payment_sagepay_direct->getTotalReleased($sagepay_direct_order['sagepay_direct_order_id']);

				if ($total_released >= $sagepay_direct_order['total'] || $sagepay_direct_order['settle_type'] == 0) {
					$this->model_payment_sagepay_direct->updateReleaseStatus($sagepay_direct_order['sagepay_direct_order_id'], 1);
					$release_status = 1;
					$json['msg'] = $this->language->get('text_release_ok_order');

					$this->load->model('sale/order');

					$history = array();
					$history['order_status_id'] = $this->config->get('sagepay_direct_v3_order_status_success_settled_id');
					$history['comment'] = '';
					$history['notify'] = '';

					$this->model_sale_order->addOrderHistory($this->request->post['order_id'], $history);

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
				$json['msg'] = isset($release_response['StatusDetail']) && !empty($release_response['StatusDetail']) ? (string)$release_response['StatusDetail'] : 'Unable to release';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = $this->language->get('error_data_missing');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function rebate() {
		$this->language->load('payment/sagepay_direct');

		$json = array();

		if (isset($this->request->post['order_id']) && !empty($this->request->post['order_id'])) {
			$this->load->model('payment/sagepay_direct');

			$sagepay_direct_order = $this->model_payment_sagepay_direct->getOrder($this->request->post['order_id']);

			$rebate_response = $this->model_payment_sagepay_direct->rebate($this->request->post['order_id'], $this->request->post['amount']);

			$this->model_payment_sagepay_direct->logger('Rebate result', $rebate_response);

			if ($rebate_response['Status'] == 'OK') {
				$this->model_payment_sagepay_direct->addTransaction($sagepay_direct_order['sagepay_direct_order_id'], 'rebate', $this->request->post['amount'] * -1);

				$total_rebated = $this->model_payment_sagepay_direct->getTotalRebated($sagepay_direct_order['sagepay_direct_order_id']);
				$total_released = $this->model_payment_sagepay_direct->getTotalReleased($sagepay_direct_order['sagepay_direct_order_id']);

				if ($total_released <= 0 && $sagepay_direct_order['release_status'] == 1) {
					$this->model_payment_sagepay_direct->updateRebateStatus($sagepay_direct_order['sagepay_direct_order_id'], 1);

					$rebate_status = 1;

					$json['msg'] = $this->language->get('text_rebate_ok_order');

					$this->load->model('sale/order');

					$history = array();
					$history['order_status_id'] = $this->config->get('sagepay_direct_v3_order_status_rebated_id');
					$history['comment'] = '';
					$history['notify'] = '';

					$this->model_sale_order->addOrderHistory($this->request->post['order_id'], $history);
				} else {
					$rebate_status = 0;

					$json['msg'] = $this->language->get('text_rebate_ok');
				}

				$json['data'] = array();
				$json['data']['date_added'] = date("Y-m-d H:i:s");
				$json['data']['amount'] = $this->request->post['amount'] * -1;
				$json['data']['total_released'] = (double)$total_released;
				$json['data']['total_rebated'] = (double)$total_rebated;
				$json['data']['rebate_status'] = $rebate_status;

				$json['error'] = false;

			} else {
				$json['error'] = true;
				$json['msg'] = isset($rebate_response['StatusDetail']) && !empty($rebate_response['StatusDetail']) ? (string)$rebate_response['StatusDetail'] : 'Unable to rebate';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/sagepay_direct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['sagepay_direct_vendor']) {
			$this->error['vendor'] = $this->language->get('error_vendor');
		}

		return empty($this->error);
	}
}
