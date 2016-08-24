<?php
class ControllerPaymentEway extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/eway');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('eway', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/eway', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_authorisation'] = $this->language->get('text_authorisation');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_transparent'] = $this->language->get('text_transparent');
		$this->data['text_iframe'] = $this->language->get('text_iframe');

		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_paymode'] = $this->language->get('entry_paymode');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_payment_type'] = $this->language->get('entry_payment_type');
		$this->data['entry_transaction'] = $this->language->get('entry_transaction');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_order_status_refund'] = $this->language->get('entry_order_status_refund');
		$this->data['entry_order_status_auth'] = $this->language->get('entry_order_status_auth');
		$this->data['entry_order_status_fraud'] = $this->language->get('entry_order_status_fraud');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_transaction_method'] = $this->language->get('entry_transaction_method');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_total_max'] = $this->language->get('help_total_max');
		$this->data['help_testmode'] = $this->language->get('help_testmode');
		$this->data['help_username'] = $this->language->get('help_username');
		$this->data['help_password'] = $this->language->get('help_password');
		$this->data['help_transaction_method'] = $this->language->get('help_transaction_method');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['username'])) {
			$this->data['error_username'] = $this->error['username'];
		} else {
			$this->data['error_username'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['payment_type'])) {
			$this->data['error_payment_type'] = $this->error['payment_type'];
		} else {
			$this->data['error_payment_type'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      =>  $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/eway', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/eway', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['eway_total'])) {
			$this->data['eway_total'] = $this->request->post['eway_total'];
		} else {
			$this->data['eway_total'] = $this->config->get('eway_total');
		}

		if (isset($this->request->post['eway_total_max'])) {
			$this->data['eway_total_max'] = $this->request->post['eway_total_max'];
		} else {
			$this->data['eway_total_max'] = $this->config->get('eway_total_max');
		}

		if (isset($this->request->post['eway_payment_gateway'])) {
			$this->data['eway_payment_gateway'] = $this->request->post['eway_payment_gateway'];
		} else {
			$this->data['eway_payment_gateway'] = $this->config->get('eway_payment_gateway');
		}

		if (isset($this->request->post['eway_paymode'])) {
			$this->data['eway_paymode'] = $this->request->post['eway_paymode'];
		} else {
			$this->data['eway_paymode'] = $this->config->get('eway_paymode');
		}

		if (isset($this->request->post['eway_test'])) {
			$this->data['eway_test'] = $this->request->post['eway_test'];
		} else {
			$this->data['eway_test'] = $this->config->get('eway_test');
		}

		if (isset($this->request->post['eway_payment_type'])) {
			$this->data['eway_payment_type'] = $this->request->post['eway_payment_type'];
		} else {
			$this->data['eway_payment_type'] = $this->config->get('eway_payment_type');
		}

		if (isset($this->request->post['eway_transaction'])) {
			$this->data['eway_transaction'] = $this->request->post['eway_transaction'];
		} else {
			$this->data['eway_transaction'] = $this->config->get('eway_transaction');
		}

		if (isset($this->request->post['eway_standard_geo_zone_id'])) {
			$this->data['eway_standard_geo_zone_id'] = $this->request->post['eway_standard_geo_zone_id'];
		} else {
			$this->data['eway_standard_geo_zone_id'] = $this->config->get('eway_standard_geo_zone_id');
		}

		if (isset($this->request->post['eway_order_status_id'])) {
			$this->data['eway_order_status_id'] = $this->request->post['eway_order_status_id'];
		} else {
			$this->data['eway_order_status_id'] = $this->config->get('eway_order_status_id');
		}

		if (isset($this->request->post['eway_order_status_refunded_id'])) {
			$this->data['eway_order_status_refunded_id'] = $this->request->post['eway_order_status_refunded_id'];
		} else {
			$this->data['eway_order_status_refunded_id'] = $this->config->get('eway_order_status_refunded_id');
		}

		if (isset($this->request->post['eway_order_status_auth_id'])) {
			$this->data['eway_order_status_auth_id'] = $this->request->post['eway_order_status_auth_id'];
		} else {
			$this->data['eway_order_status_auth_id'] = $this->config->get('eway_order_status_auth_id');
		}

		if (isset($this->request->post['eway_order_status_fraud_id'])) {
			$this->data['eway_order_status_fraud_id'] = $this->request->post['eway_order_status_fraud_id'];
		} else {
			$this->data['eway_order_status_fraud_id'] = $this->config->get('eway_order_status_fraud_id');
		}

		if (isset($this->request->post['eway_transaction_method'])) {
			$this->data['eway_transaction_method'] = $this->request->post['eway_transaction_method'];
		} else {
			$this->data['eway_transaction_method'] = $this->config->get('eway_transaction_method');
		}

		if (isset($this->request->post['eway_username'])) {
			$this->data['eway_username'] = $this->request->post['eway_username'];
		} else {
			$this->data['eway_username'] = $this->config->get('eway_username');
		}

		if (isset($this->request->post['eway_password'])) {
			$this->data['eway_password'] = $this->request->post['eway_password'];
		} else {
			$this->data['eway_password'] = $this->config->get('eway_password');
		}

		if (isset($this->request->post['eway_status'])) {
			$this->data['eway_status'] = $this->request->post['eway_status'];
		} else {
			$this->data['eway_status'] = $this->config->get('eway_status');
		}

		if (isset($this->request->post['eway_sort_order'])) {
			$this->data['eway_sort_order'] = $this->request->post['eway_sort_order'];
		} else {
			$this->data['eway_sort_order'] = $this->config->get('eway_sort_order');
		}

		$this->template = 'payment/eway.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model('payment/eway');

		$this->model_payment_eway->install();
	}

	public function uninstall() {
		$this->load->model('payment/eway');

		$this->model_payment_eway->uninstall();
	}

	public function orderAction() {
		if ($this->config->get('eway_status')) {
			$this->load->model('payment/eway');

			$eway_order = $this->model_payment_eway->getOrder($this->request->get['order_id']);

			if (!empty($eway_order)) {
				$this->language->load('payment/eway');

				$eway_order['total'] = $eway_order['amount'];
				$eway_order['total_formatted'] = $this->currency->format($eway_order['amount'], $eway_order['currency_code'], 1, true);

				$eway_order['total_captured'] = $this->model_payment_eway->getTotalCaptured($eway_order['eway_order_id']);
				$eway_order['total_captured_formatted'] = $this->currency->format($eway_order['total_captured'], $eway_order['currency_code'], 1, true);

				$eway_order['uncaptured'] = $eway_order['total'] - $eway_order['total_captured'];

				$eway_order['total_refunded'] = $this->model_payment_eway->getTotalRefunded($eway_order['eway_order_id']);
				$eway_order['total_refunded_formatted'] = $this->currency->format($eway_order['total_refunded'], $eway_order['currency_code'], 1, true);

				$eway_order['unrefunded'] = $eway_order['total_captured'] - $eway_order['total_refunded'];

				$this->data['text_payment_info'] = $this->language->get('text_payment_info');
				$this->data['text_order_total'] = $this->language->get('text_order_total');
				$this->data['text_void_status'] = $this->language->get('text_void_status');
				$this->data['text_transactions'] = $this->language->get('text_transactions');
				$this->data['text_column_amount'] = $this->language->get('text_column_amount');
				$this->data['text_column_type'] = $this->language->get('text_column_type');
				$this->data['text_column_created'] = $this->language->get('text_column_created');
				$this->data['text_column_transactionid'] = $this->language->get('text_column_transactionid');
				$this->data['text_confirm_refund'] = $this->language->get('text_confirm_refund');
				$this->data['text_confirm_capture'] = $this->language->get('text_confirm_capture');
				$this->data['text_total_captured'] = $this->language->get('text_total_captured');
				$this->data['text_total_refunded'] = $this->language->get('text_total_refunded');
				$this->data['text_capture_status'] = $this->language->get('text_capture_status');
				$this->data['text_refund_status'] = $this->language->get('text_refund_status');
				$this->data['text_empty_refund'] = $this->language->get('text_empty_refund');
				$this->data['text_empty_capture'] = $this->language->get('text_empty_capture');

				$this->data['btn_refund'] = $this->language->get('btn_refund');
				$this->data['btn_capture'] = $this->language->get('btn_capture');

				$this->data['eway_order'] = $eway_order;

				$this->data['token'] = $this->request->get['token'];

				$this->data['order_id'] = $this->request->get['order_id'];

				$this->template = 'payment/eway_order.tpl';
				$this->children = array(
					'common/header',
					'common/footer'
				);

				$this->response->setOutput($this->render());
			}
		}
	}

	public function refund() {
		$this->language->load('payment/eway');

		$order_id = $this->request->post['order_id'];

		$refund_amount = (double)$this->request->post['refund_amount'];

		if ($order_id && $refund_amount > 0) {
			$this->load->model('payment/eway');

			$result = $this->model_payment_eway->refund($order_id, $refund_amount);

			// Check if any error returns
			if (isset($result->Errors) || $result === false) {
				$json['error'] = true;

				$reason = '';

				if ($result === false) {
					$reason = $this->language->get('text_unknown_failure');
				} else {
					$errors = explode(",", $result->Errors);

					foreach ($errors as $error) {
						$lbl_error = $this->language->get('text_card_message_' . $error);
						$reason .= $lbl_error . ", ";
					}
				}

				$json['message'] = $this->language->get('text_refund_failed') . $reason;

			} else {
				$eway_order = $this->model_payment_eway->getOrder($order_id);

				$this->model_payment_eway->addTransaction($eway_order['eway_order_id'], $result->Refund->TransactionID, 'refund', $result->Refund->TotalAmount / 100, $eway_order['currency_code']);

				$total_captured = $this->model_payment_eway->getTotalCaptured($eway_order['eway_order_id']);
				$total_refunded = $this->model_payment_eway->getTotalRefunded($eway_order['eway_order_id']);

				$refund_status = 0;

				if ($total_captured == $total_refunded) {
					$refund_status = 1;

					$this->model_payment_eway->updateRefundStatus($eway_order['eway_order_id'], $refund_status);
				}

				$json['data'] = array();
				$json['data']['transactionid'] = $result->TransactionID;
				$json['data']['created'] = date("Y-m-d H:i:s");
				$json['data']['amount'] = number_format($refund_amount, 2, '.', '');
				$json['data']['total_refunded_formatted'] = $this->currency->format($total_refunded, $eway_order['currency_code'], 1, true);
				$json['data']['refund_status'] = $refund_status;
				$json['data']['remaining'] = $total_captured - $total_refunded;
				$json['message'] = $this->language->get('text_refund_success');
				$json['error'] = false;
			}

		} else {
			$json['error'] = true;
			$json['message'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function capture() {
		$this->language->load('payment/eway');

		$order_id = $this->request->post['order_id'];

		$capture_amount = (double)$this->request->post['capture_amount'];

		if ($order_id && $capture_amount > 0) {
			$this->load->model('payment/eway');

			$eway_order = $this->model_payment_eway->getOrder($order_id);

			$result = $this->model_payment_eway->capture($order_id, $capture_amount, $eway_order['currency_code']);

			// Check if any error returns
			if (isset($result->Errors) || $result === false) {
				$json['error'] = true;

				$reason = '';

				if ($result === false) {
					$reason = $this->language->get('text_unknown_failure');
				} else {
					$errors = explode(",", $result->Errors);
					foreach ($errors as $error) {
						$lbl_error = $this->language->get('text_card_message_' . $error);
						$reason .= $lbl_error . ", ";
					}
				}

				$json['message'] = $this->language->get('text_capture_failed') . $reason;

			} else {
				$this->model_payment_eway->addTransaction($eway_order['eway_order_id'], $result->TransactionID, 'payment', $capture_amount, $eway_order['currency_code']);

				$total_captured = $this->model_payment_eway->getTotalCaptured($eway_order['eway_order_id']);

				$remaining = $eway_order['amount'] - $capture_amount;

				if ($remaining <= 0) {
					$remaining = 0;
				}

				$this->model_payment_eway->updateCaptureStatus($eway_order['eway_order_id'], 1);
				$this->model_payment_eway->updateTransactionId($eway_order['eway_order_id'], $result->TransactionID);

				$json['data'] = array();
				$json['data']['transactionid'] = $result->TransactionID;
				$json['data']['created'] = date("Y-m-d H:i:s");
				$json['data']['amount'] = number_format($capture_amount, 2, '.', '');
				$json['data']['total_captured_formatted'] = $this->currency->format($total_captured, $eway_order['currency_code'], 1, true);
				$json['data']['capture_status'] = 1;
				$json['data']['remaining'] = $remaining;

				$json['message'] = $this->language->get('text_capture_success');

				$json['error'] = false;
			}

		} else {
			$json['error'] = true;
			$json['message'] = 'Missing data';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/eway')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['eway_username']) {
			$this->error['username'] = $this->language->get('error_username');
		}

		if (!$this->request->post['eway_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!isset($this->request->post['eway_payment_type'])) {
			$this->error['payment_type'] = $this->language->get('error_payment_type');
		}

		return empty($this->error);
	}
}
