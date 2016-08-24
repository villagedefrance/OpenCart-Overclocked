<?php
class ControllerPaymentFirstdata extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/firstdata');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('firstdata', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/firstdata', 'token=' . $this->session->data['token'], 'SSL'));
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
		$this->data['text_notification_url'] = $this->language->get('text_notification_url');
		$this->data['text_merchant_id'] = $this->language->get('text_merchant_id');
		$this->data['text_secret'] = $this->language->get('text_secret');
		$this->data['text_settle_delayed'] = $this->language->get('text_settle_delayed');
		$this->data['text_settle_auto'] = $this->language->get('text_settle_auto');

		$this->data['entry_merchant_id'] = $this->language->get('entry_merchant_id');
		$this->data['entry_secret'] = $this->language->get('entry_secret');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_live_demo'] = $this->language->get('entry_live_demo');
		$this->data['entry_auto_settle'] = $this->language->get('entry_auto_settle');
		$this->data['entry_live_url'] = $this->language->get('entry_live_url');
		$this->data['entry_demo_url'] = $this->language->get('entry_demo_url');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_enable_card_store'] = $this->language->get('entry_enable_card_store');

		$this->data['entry_status_success_settled'] = $this->language->get('entry_status_success_settled');
		$this->data['entry_status_success_unsettled'] = $this->language->get('entry_status_success_unsettled');
		$this->data['entry_status_decline'] = $this->language->get('entry_status_decline');
		$this->data['entry_status_decline_pending'] = $this->language->get('entry_status_decline_pending');
		$this->data['entry_status_decline_stolen'] = $this->language->get('entry_status_decline_stolen');
		$this->data['entry_status_decline_bank'] = $this->language->get('entry_status_decline_bank');
		$this->data['entry_status_void'] = $this->language->get('entry_status_void');

		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_total_max'] = $this->language->get('help_total_max');
		$this->data['help_debug'] = $this->language->get('help_debug');
		$this->data['help_notification'] = $this->language->get('help_notification');
		$this->data['help_settle'] = $this->language->get('help_settle');

		$this->data['tab_account'] = $this->language->get('tab_account');
		$this->data['tab_order_status'] = $this->language->get('tab_order_status');
		$this->data['tab_payment'] = $this->language->get('tab_payment');
		$this->data['tab_advanced'] = $this->language->get('tab_advanced');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['notify_url'] = HTTPS_CATALOG . 'index.php?route=payment/firstdata/notify';

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
			'href'      => $this->url->link('payment/firstdata', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/firstdata', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['firstdata_merchant_id'])) {
			$this->data['firstdata_merchant_id'] = $this->request->post['firstdata_merchant_id'];
		} else {
			$this->data['firstdata_merchant_id'] = $this->config->get('firstdata_merchant_id');
		}

		if (isset($this->request->post['firstdata_secret'])) {
			$this->data['firstdata_secret'] = $this->request->post['firstdata_secret'];
		} else {
			$this->data['firstdata_secret'] = $this->config->get('firstdata_secret');
		}

		if (isset($this->request->post['firstdata_live_demo'])) {
			$this->data['firstdata_live_demo'] = $this->request->post['firstdata_live_demo'];
		} else {
			$this->data['firstdata_live_demo'] = $this->config->get('firstdata_live_demo');
		}

		if (isset($this->request->post['firstdata_geo_zone_id'])) {
			$this->data['firstdata_geo_zone_id'] = $this->request->post['firstdata_geo_zone_id'];
		} else {
			$this->data['firstdata_geo_zone_id'] = $this->config->get('firstdata_geo_zone_id');
		}

		if (isset($this->request->post['firstdata_total'])) {
			$this->data['firstdata_total'] = $this->request->post['firstdata_total'];
		} else {
			$this->data['firstdata_total'] = $this->config->get('firstdata_total');
		}

		if (isset($this->request->post['firstdata_total_max'])) {
			$this->data['firstdata_total_max'] = $this->request->post['firstdata_total_max'];
		} else {
			$this->data['firstdata_total_max'] = $this->config->get('firstdata_total_max');
		}

		if (isset($this->request->post['firstdata_sort_order'])) {
			$this->data['firstdata_sort_order'] = $this->request->post['firstdata_sort_order'];
		} else {
			$this->data['firstdata_sort_order'] = $this->config->get('firstdata_sort_order');
		}

		if (isset($this->request->post['firstdata_status'])) {
			$this->data['firstdata_status'] = $this->request->post['firstdata_status'];
		} else {
			$this->data['firstdata_status'] = $this->config->get('firstdata_status');
		}

		if (isset($this->request->post['firstdata_debug'])) {
			$this->data['firstdata_debug'] = $this->request->post['firstdata_debug'];
		} else {
			$this->data['firstdata_debug'] = $this->config->get('firstdata_debug');
		}

		if (isset($this->request->post['firstdata_auto_settle'])) {
			$this->data['firstdata_auto_settle'] = $this->request->post['firstdata_auto_settle'];
		} elseif (!isset($this->request->post['firstdata_auto_settle']) && $this->config->get('firstdata_auto_settle') != '') {
			$this->data['firstdata_auto_settle'] = $this->config->get('firstdata_auto_settle');
		} else {
			$this->data['firstdata_auto_settle'] = 1;
		}

		if (isset($this->request->post['firstdata_order_status_success_settled_id'])) {
			$this->data['firstdata_order_status_success_settled_id'] = $this->request->post['firstdata_order_status_success_settled_id'];
		} else {
			$this->data['firstdata_order_status_success_settled_id'] = $this->config->get('firstdata_order_status_success_settled_id');
		}

		if (isset($this->request->post['firstdata_order_status_success_unsettled_id'])) {
			$this->data['firstdata_order_status_success_unsettled_id'] = $this->request->post['firstdata_order_status_success_unsettled_id'];
		} else {
			$this->data['firstdata_order_status_success_unsettled_id'] = $this->config->get('firstdata_order_status_success_unsettled_id');
		}

		if (isset($this->request->post['firstdata_order_status_decline_id'])) {
			$this->data['firstdata_order_status_decline_id'] = $this->request->post['firstdata_order_status_decline_id'];
		} else {
			$this->data['firstdata_order_status_decline_id'] = $this->config->get('firstdata_order_status_decline_id');
		}

		if (isset($this->request->post['firstdata_order_status_void_id'])) {
			$this->data['firstdata_order_status_void_id'] = $this->request->post['firstdata_order_status_void_id'];
		} else {
			$this->data['firstdata_order_status_void_id'] = $this->config->get('firstdata_order_status_void_id');
		}

		if (isset($this->request->post['firstdata_live_url'])) {
			$this->data['firstdata_live_url'] = $this->request->post['firstdata_live_url'];
		} else {
			$this->data['firstdata_live_url'] = $this->config->get('firstdata_live_url');
		}

		if (empty($this->data['firstdata_live_url'])) {
			$this->data['firstdata_live_url'] = 'https://ipg-online.com/connect/gateway/processing';
		}

		if (isset($this->request->post['firstdata_demo_url'])) {
			$this->data['firstdata_demo_url'] = $this->request->post['firstdata_demo_url'];
		} else {
			$this->data['firstdata_demo_url'] = $this->config->get('firstdata_demo_url');
		}

		if (empty($this->data['firstdata_demo_url'])) {
			$this->data['firstdata_demo_url'] = 'https://test.ipg-online.com/connect/gateway/processing';
		}

		if (isset($this->request->post['firstdata_card_storage'])) {
			$this->data['firstdata_card_storage'] = $this->request->post['firstdata_card_storage'];
		} else {
			$this->data['firstdata_card_storage'] = $this->config->get('firstdata_card_storage');
		}

		$this->template = 'payment/firstdata.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model('payment/firstdata');

		$this->model_payment_firstdata->install();
	}

	public function uninstall() {
		$this->load->model('payment/firstdata');

		$this->model_payment_firstdata->uninstall();
	}

	public function orderAction() {
		if ($this->config->get('firstdata_status')) {
			$this->load->model('payment/firstdata');

			$firstdata_order = $this->model_payment_firstdata->getOrder($this->request->get['order_id']);

			if (!empty($firstdata_order)) {
				$this->load->language('payment/firstdata');

				$firstdata_order['total_captured'] = $this->model_payment_firstdata->getTotalCaptured($firstdata_order['firstdata_order_id']);
				$firstdata_order['total_formatted'] = $this->currency->format($firstdata_order['total'], $firstdata_order['currency_code'], 1, true);
				$firstdata_order['total_captured_formatted'] = $this->currency->format($firstdata_order['total_captured'], $firstdata_order['currency_code'], 1, true);

				$this->data['firstdata_order'] = $firstdata_order;
				$this->data['merchant_id'] = $this->config->get('firstdata_merchant_id');
				$this->data['currency'] = $this->model_payment_firstdata->mapCurrency($firstdata_order['currency_code']);
				$this->data['amount'] = number_format($firstdata_order['total'], 2);

				$this->data['request_timestamp'] = date("Y:m:d-H:i:s");

				$this->data['hash'] = sha1(bin2hex($this->data['merchant_id'] . $this->data['request_timestamp'] . $this->data['amount'] . $this->data['currency'] . $this->config->get('firstdata_secret')));

				$this->data['void_url'] = $this->url->link('payment/firstdata/void', 'token=' . $this->session->data['token'], 'SSL');
				$this->data['capture_url'] = $this->url->link('payment/firstdata/capture', 'token=' . $this->session->data['token'], 'SSL');
				$this->data['notify_url'] = HTTPS_CATALOG . 'index.php?route=payment/firstdata/notify';

				if ($this->config->get('firstdata_live_demo') == 1) {
					$this->data['action_url'] = $this->config->get('firstdata_live_url');
				} else {
					$this->data['action_url'] = $this->config->get('firstdata_demo_url');
				}

				if (isset($this->session->data['void_success'])) {
					$this->data['void_success'] = $this->session->data['void_success'];

					unset($this->session->data['void_success']);
				} else {
					$this->data['void_success'] = '';
				}

				if (isset($this->session->data['void_error'])) {
					$this->data['void_error'] = $this->session->data['void_error'];

					unset($this->session->data['void_error']);
				} else {
					$this->data['void_error'] = '';
				}

				if (isset($this->session->data['capture_success'])) {
					$this->data['capture_success'] = $this->session->data['capture_success'];

					unset($this->session->data['capture_success']);
				} else {
					$this->data['capture_success'] = '';
				}

				if (isset($this->session->data['capture_error'])) {
					$this->data['capture_error'] = $this->session->data['capture_error'];

					unset($this->session->data['capture_error']);
				} else {
					$this->data['capture_error'] = '';
				}

				$this->data['text_payment_info'] = $this->language->get('text_payment_info');
				$this->data['text_order_ref'] = $this->language->get('text_order_ref');
				$this->data['text_order_total'] = $this->language->get('text_order_total');
				$this->data['text_total_captured'] = $this->language->get('text_total_captured');
				$this->data['text_capture_status'] = $this->language->get('text_capture_status');
				$this->data['text_void_status'] = $this->language->get('text_void_status');
				$this->data['text_transactions'] = $this->language->get('text_transactions');
				$this->data['text_yes'] = $this->language->get('text_yes');
				$this->data['text_no'] = $this->language->get('text_no');

				$this->data['text_column_amount'] = $this->language->get('text_column_amount');
				$this->data['text_column_type'] = $this->language->get('text_column_type');
				$this->data['text_column_date_added'] = $this->language->get('text_column_date_added');

				$this->data['button_capture'] = $this->language->get('button_capture');
				$this->data['button_void'] = $this->language->get('button_void');

				$this->data['text_confirm_void'] = $this->language->get('text_confirm_void');
				$this->data['text_confirm_capture'] = $this->language->get('text_confirm_capture');

				$this->data['order_id'] = $this->request->get['order_id'];

				$this->data['token'] = $this->request->get['token'];

				$this->template = 'payment/firstdata_order.tpl';
				$this->children = array(
					'common/header',
					'common/footer'
				);

				$this->response->setOutput($this->render());
			}
		}
	}

	public function void() {
		$this->load->language('payment/firstdata');

		if ($this->request->post['status'] == 'FAILED') {
			if (isset($this->request->post['fail_reason'])) {
				$this->session->data['void_error'] = $this->request->post['fail_reason'];
			} else {
				$this->session->data['void_error'] = $this->language->get('error_void_error');
			}
		}

		if ($this->request->post['status'] == 'DECLINED') {
			$this->session->data['void_success'] = $this->language->get('success_void');
		}

		$this->redirect($this->url->link('sale/order/info', 'order_id=' . $this->request->post['order_id'] . '&token=' . $this->session->data['token'], 'SSL'));
	}

	public function capture() {
		$this->load->language('payment/firstdata');

		if ($this->request->post['status'] == 'FAILED') {
			if (isset($this->request->post['fail_reason'])) {
				$this->session->data['capture_error'] = $this->request->post['fail_reason'];
			} else {
				$this->session->data['capture_error'] = $this->language->get('error_capture_error');
			}
		}

		if ($this->request->post['status'] == 'APPROVED') {
			$this->session->data['capture_success'] = $this->language->get('success_capture');
		}

		$this->redirect($this->url->link('sale/order/info', 'order_id=' . $this->request->post['order_id'] . '&token=' . $this->session->data['token'], 'SSL'));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/firstdata')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['firstdata_merchant_id']) {
			$this->error['error_merchant_id'] = $this->language->get('error_merchant_id');
		}

		if (!$this->request->post['firstdata_secret']) {
			$this->error['error_secret'] = $this->language->get('error_secret');
		}

		if (!$this->request->post['firstdata_live_url']) {
			$this->error['error_live_url'] = $this->language->get('error_live_url');
		}

		if (!$this->request->post['firstdata_demo_url']) {
			$this->error['error_demo_url'] = $this->language->get('error_demo_url');
		}

		return empty($this->error);
	}
}
