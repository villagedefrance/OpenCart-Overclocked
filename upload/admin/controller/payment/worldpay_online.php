<?php
class ControllerPaymentWorldpayOnline extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/worldpay_online');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('worldpay_online', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/worldpay_online', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_test'] = $this->language->get('text_test');
		$this->data['text_live'] = $this->language->get('text_live');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_authenticate'] = $this->language->get('text_authenticate');

		$this->data['entry_service_key'] = $this->language->get('entry_service_key');
		$this->data['entry_client_key'] = $this->language->get('entry_client_key');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_card'] = $this->language->get('entry_card');
		$this->data['entry_secret_token'] = $this->language->get('entry_secret_token');
		$this->data['entry_webhook_url'] = $this->language->get('entry_webhook_url');
		$this->data['entry_cron_job_url'] = $this->language->get('entry_cron_job_url');
		$this->data['entry_last_cron_job_run'] = $this->language->get('entry_last_cron_job_run');

		$this->data['entry_success_status'] = $this->language->get('entry_success_status');
		$this->data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$this->data['entry_settled_status'] = $this->language->get('entry_settled_status');
		$this->data['entry_refunded_status'] = $this->language->get('entry_refunded_status');
		$this->data['entry_partially_refunded_status'] = $this->language->get('entry_partially_refunded_status');
		$this->data['entry_charged_back_status'] = $this->language->get('entry_charged_back_status');
		$this->data['entry_information_requested_status'] = $this->language->get('entry_information_requested_status');
		$this->data['entry_information_supplied_status'] = $this->language->get('entry_information_supplied_status');
		$this->data['entry_chargeback_reversed_status'] = $this->language->get('entry_chargeback_reversed_status');

		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_total_max'] = $this->language->get('help_total_max');
		$this->data['help_debug'] = $this->language->get('help_debug');
		$this->data['help_secret_token'] = $this->language->get('help_secret_token');
		$this->data['help_webhook_url'] = $this->language->get('help_webhook_url');
		$this->data['help_cron_job_url'] = $this->language->get('help_cron_job_url');

		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_order_status'] = $this->language->get('tab_order_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['error_service_key'])) {
			$this->data['error_service_key'] = $this->error['error_service_key'];
		} else {
			$this->data['error_service_key'] = '';
		}

		if (isset($this->error['error_client_key'])) {
			$this->data['error_client_key'] = $this->error['error_client_key'];
		} else {
			$this->data['error_client_key'] = '';
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
			'href'      => $this->url->link('payment/worldpay_online', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/worldpay_online', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['worldpay_online_service_key'])) {
			$this->data['worldpay_online_service_key'] = $this->request->post['worldpay_online_service_key'];
		} else {
			$this->data['worldpay_online_service_key'] = $this->config->get('worldpay_online_service_key');
		}

		if (isset($this->request->post['worldpay_online_client_key'])) {
			$this->data['worldpay_online_client_key'] = $this->request->post['worldpay_online_client_key'];
		} else {
			$this->data['worldpay_online_client_key'] = $this->config->get('worldpay_online_client_key');
		}

		if (isset($this->request->post['worldpay_online_total'])) {
			$this->data['worldpay_online_total'] = $this->request->post['worldpay_online_total'];
		} else {
			$this->data['worldpay_online_total'] = $this->config->get('worldpay_online_total');
		}

		if (isset($this->request->post['worldpay_online_total_max'])) {
			$this->data['worldpay_online_total_max'] = $this->request->post['worldpay_online_total_max'];
		} else {
			$this->data['worldpay_online_total_max'] = $this->config->get('worldpay_online_total_max');
		}

		if (isset($this->request->post['worldpay_online_card'])) {
			$this->data['worldpay_online_card'] = $this->request->post['worldpay_online_card'];
		} else {
			$this->data['worldpay_online_card'] = $this->config->get('worldpay_online_card');
		}

		if (isset($this->request->post['worldpay_online_order_status_id'])) {
			$this->data['worldpay_online_order_status_id'] = $this->request->post['worldpay_online_order_status_id'];
		} else {
			$this->data['worldpay_online_order_status_id'] = $this->config->get('worldpay_online_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['worldpay_online_geo_zone_id'])) {
			$this->data['worldpay_online_geo_zone_id'] = $this->request->post['worldpay_online_geo_zone_id'];
		} else {
			$this->data['worldpay_online_geo_zone_id'] = $this->config->get('worldpay_online_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['worldpay_online_status'])) {
			$this->data['worldpay_online_status'] = $this->request->post['worldpay_online_status'];
		} else {
			$this->data['worldpay_online_status'] = $this->config->get('worldpay_online_status');
		}

		if (isset($this->request->post['worldpay_online_debug'])) {
			$this->data['worldpay_online_debug'] = $this->request->post['worldpay_online_debug'];
		} else {
			$this->data['worldpay_online_debug'] = $this->config->get('worldpay_online_debug');
		}

		if (isset($this->request->post['worldpay_online_sort_order'])) {
			$this->data['worldpay_online_sort_order'] = $this->request->post['worldpay_online_sort_order'];
		} else {
			$this->data['worldpay_online_sort_order'] = $this->config->get('worldpay_online_sort_order');
		}

		if (isset($this->request->post['worldpay_online_secret_token'])) {
			$this->data['worldpay_online_secret_token'] = $this->request->post['worldpay_online_secret_token'];
		} elseif ($this->config->get('worldpay_online_secret_token')) {
			$this->data['worldpay_online_secret_token'] = $this->config->get('worldpay_online_secret_token');
		} else {
			$this->data['worldpay_online_secret_token'] = sha1(uniqid(mt_rand(), 1));
		}

		$this->data['worldpay_online_webhook_url'] = HTTPS_CATALOG . 'index.php?route=payment/worldpay_online/webhook&token=' . $this->data['worldpay_online_secret_token'];

		$this->data['worldpay_online_cron_job_url'] = HTTPS_CATALOG . 'index.php?route=payment/worldpay_online/cron&token=' . $this->data['worldpay_online_secret_token'];

		if ($this->config->get('worldpay_online_last_cron_job_run')) {
			$this->data['worldpay_online_last_cron_job_run'] = $this->config->get('worldpay_online_last_cron_job_run');
		} else {
			$this->data['worldpay_online_last_cron_job_run'] = '';
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['worldpay_online_entry_success_status_id'])) {
			$this->data['worldpay_online_entry_success_status_id'] = $this->request->post['worldpay_online_entry_success_status_id'];
		} else {
			$this->data['worldpay_online_entry_success_status_id'] = $this->config->get('worldpay_online_entry_success_status_id');
		}

		if (isset($this->request->post['worldpay_online_entry_failed_status_id'])) {
			$this->data['worldpay_online_entry_failed_status_id'] = $this->request->post['worldpay_online_entry_failed_status_id'];
		} else {
			$this->data['worldpay_online_entry_failed_status_id'] = $this->config->get('worldpay_online_entry_failed_status_id');
		}

		if (isset($this->request->post['worldpay_online_entry_settled_status_id'])) {
			$this->data['worldpay_online_entry_settled_status_id'] = $this->request->post['worldpay_online_entry_settled_status_id'];
		} else {
			$this->data['worldpay_online_entry_settled_status_id'] = $this->config->get('worldpay_online_entry_settled_status_id');
		}

		if (isset($this->request->post['worldpay_online_refunded_status_id'])) {
			$this->data['worldpay_online_refunded_status_id'] = $this->request->post['worldpay_online_refunded_status_id'];
		} else {
			$this->data['worldpay_online_refunded_status_id'] = $this->config->get('worldpay_online_refunded_status_id');
		}

		if (isset($this->request->post['worldpay_online_entry_partially_refunded_status_id'])) {
			$this->data['worldpay_online_entry_partially_refunded_status_id'] = $this->request->post['worldpay_online_entry_partially_refunded_status_id'];
		} else {
			$this->data['worldpay_online_entry_partially_refunded_status_id'] = $this->config->get('worldpay_online_entry_partially_refunded_status_id');
		}

		if (isset($this->request->post['worldpay_online_entry_charged_back_status_id'])) {
			$this->data['worldpay_online_entry_charged_back_status_id'] = $this->request->post['worldpay_online_entry_charged_back_status_id'];
		} else {
			$this->data['worldpay_online_entry_charged_back_status_id'] = $this->config->get('worldpay_online_entry_charged_back_status_id');
		}

		if (isset($this->request->post['worldpay_online_entry_information_requested_status_id'])) {
			$this->data['worldpay_online_entry_information_requested_status_id'] = $this->request->post['worldpay_online_entry_information_requested_status_id'];
		} else {
			$this->data['worldpay_online_entry_information_requested_status_id'] = $this->config->get('worldpay_online_entry_information_requested_status_id');
		}

		if (isset($this->request->post['worldpay_online_entry_information_supplied_status_id'])) {
			$this->data['worldpay_online_entry_information_supplied_status_id'] = $this->request->post['worldpay_online_entry_information_supplied_status_id'];
		} else {
			$this->data['worldpay_online_entry_information_supplied_status_id'] = $this->config->get('worldpay_online_entry_information_supplied_status_id');
		}

		if (isset($this->request->post['worldpay_online_entry_chargeback_reversed_status_id'])) {
			$this->data['worldpay_online_entry_chargeback_reversed_status_id'] = $this->request->post['worldpay_online_entry_chargeback_reversed_status_id'];
		} else {
			$this->data['worldpay_online_entry_chargeback_reversed_status_id'] = $this->config->get('worldpay_online_entry_chargeback_reversed_status_id');
		}

		$this->template = 'payment/worldpay_online.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model('payment/worldpay_online');

		$this->model_payment_worldpay_online->install();
	}

	public function uninstall() {
		$this->load->model('payment/worldpay_online');

		$this->model_payment_worldpay_online->uninstall();
	}

	public function orderAction() {
		if ($this->config->get('worldpay_online_status')) {
			$this->load->model('payment/worldpay_online');

			$worldpay_online_order = $this->model_payment_worldpay_online->getOrder($this->request->get['order_id']);

			if (!empty($worldpay_online_order)) {
				$this->language->load('payment/worldpay_online');

				$worldpay_online_order['total_released'] = $this->model_payment_worldpay_online->getTotalReleased($worldpay_online_order['worldpay_online_order_id']);

				$worldpay_online_order['total_formatted'] = $this->currency->format($worldpay_online_order['total'], $worldpay_online_order['currency_code'], false);
				$worldpay_online_order['total_released_formatted'] = $this->currency->format($worldpay_online_order['total_released'], $worldpay_online_order['currency_code'], false);

				$this->data['worldpay_online_order'] = $worldpay_online_order;

				$this->data['text_payment_info'] = $this->language->get('text_payment_info');
				$this->data['text_order_ref'] = $this->language->get('text_order_ref');
				$this->data['text_order_total'] = $this->language->get('text_order_total');
				$this->data['text_total_released'] = $this->language->get('text_total_released');
				$this->data['text_release_status'] = $this->language->get('text_release_status');
				$this->data['text_void_status'] = $this->language->get('text_void_status');
				$this->data['text_refund_status'] = $this->language->get('text_refund_status');
				$this->data['text_transactions'] = $this->language->get('text_transactions');
				$this->data['text_yes'] = $this->language->get('text_yes');
				$this->data['text_no'] = $this->language->get('text_no');
				$this->data['text_no_results'] = $this->language->get('text_no_results');

				$this->data['text_column_amount'] = $this->language->get('text_column_amount');
				$this->data['text_column_type'] = $this->language->get('text_column_type');
				$this->data['text_column_date_added'] = $this->language->get('text_column_date_added');

				$this->data['button_release'] = $this->language->get('button_release');
				$this->data['button_refund'] = $this->language->get('button_refund');
				$this->data['button_void'] = $this->language->get('button_void');

				$this->data['text_confirm_void'] = $this->language->get('text_confirm_void');
				$this->data['text_confirm_release'] = $this->language->get('text_confirm_release');
				$this->data['text_confirm_refund'] = $this->language->get('text_confirm_refund');

				$this->data['order_id'] = $this->request->get['order_id'];

				$this->data['token'] = $this->request->get['token'];

				$this->template = 'payment/worldpay_online_order.tpl';
				$this->children = array(
					'common/header',
					'common/footer'
				);

				$this->response->setOutput($this->render());
			}
		}
	}

	public function refund() {
		$this->language->load('payment/worldpay_online');

		$json = array();

		if (isset($this->request->post['order_id']) && !empty($this->request->post['order_id'])) {
			$this->load->model('payment/worldpay_online');

			$worldpay_online_order = $this->model_payment_worldpay_online->getOrder($this->request->post['order_id']);

			$refund_response = $this->model_payment_worldpay_online->refund($this->request->post['order_id'], $this->request->post['amount']);

			$this->model_payment_worldpay_online->logger('Refund result: ' . print_r($refund_response, 1));

			if ($refund_response['status'] == 'success') {
				$this->model_payment_worldpay_online->addTransaction($worldpay_online_order['worldpay_online_order_id'], 'refund', $this->request->post['amount'] * -1);

				$total_refunded = $this->model_payment_worldpay_online->getTotalRefunded($worldpay_online_order['worldpay_online_order_id']);
				$total_released = $this->model_payment_worldpay_online->getTotalReleased($worldpay_online_order['worldpay_online_order_id']);

				$this->model_payment_worldpay_online->updateRefundStatus($worldpay_online_order['worldpay_online_order_id'], 1);

				$json['msg'] = $this->language->get('text_refund_ok_order');

				$json['data'] = array();
				$json['data']['created'] = date("Y-m-d H:i:s");
				$json['data']['amount'] = $this->currency->format(($this->request->post['amount'] * -1), $worldpay_online_order['currency_code'], false);
				$json['data']['total_released'] = $this->currency->format($total_released, $worldpay_online_order['currency_code'], false);
				$json['data']['total_refund'] = $this->currency->format($total_refunded, $worldpay_online_order['currency_code'], false);
				$json['data']['refund_status'] = 1;

				$json['error'] = false;

			} else {
				$json['error'] = true;
				$json['msg'] = isset($refund_response['message']) && !empty($refund_response['message']) ? (string)$refund_response['message'] : 'Unable to refund';
			}

		} else {
			$json['error'] = true;
			$json['msg'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/worldpay_online')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['worldpay_online_service_key']) {
			$this->error['error_service_key'] = $this->language->get('error_service_key');
		}

		if (!$this->request->post['worldpay_online_client_key']) {
			$this->error['error_client_key'] = $this->language->get('error_client_key');
		}

		return empty($this->error);
	}
}
