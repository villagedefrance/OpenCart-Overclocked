<?php
class ControllerPaymentPayhub extends Controller {

	protected function index() {
		$this->language->load('payment/payhub');

		$this->data['text_credit_card'] = $this->language->get('text_credit_card');
		$this->data['text_wait'] = $this->language->get('text_wait');

		$this->data['entry_cc_owner'] = $this->language->get('entry_cc_owner');
		$this->data['entry_cc_number'] = $this->language->get('entry_cc_number');
		$this->data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
		$this->data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['months'] = array();

		for ($i = 1; $i <= 12; $i++) {
			$this->data['months'][] = array(
				'text'  => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)),
				'value' => sprintf('%02d', $i)
			);
		}

		$today = getdate();

		$this->data['year_expire'] = array();

		for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
			$this->data['year_expire'][] = array(
				'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
				'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
			);
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/payhub.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/payhub.tpl';
		} else {
			$this->template = 'default/template/payment/payhub.tpl';
		}

		$this->render();
	}

	public function send() {
		$data = array();

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		// Using PayHub Checkout transaction API
		$url = 'https://checkout.payhub.com/transaction/api';

		if ($this->config->get('payhub_mode') == 'live') {
			$data['mode'] = "live";
		} elseif ($this->config->get('payhub_mode') == 'test') {
			$data['mode'] = "demo";
		}

		$data['orgid'] = $this->config->get('payhub_org_id');
		$data['username'] = $this->config->get('payhub_username');
		$data['password'] = $this->config->get('payhub_password');
		$data['tid'] = $this->config->get('payhub_terminal_id');

		$data['trans_type'] = "sale";
		$data['cc'] = str_replace(' ', '', $this->request->post['cc_number']);
		$data['month'] = $this->request->post['cc_expire_date_month'];
		$data['year'] = $this->request->post['cc_expire_date_year'];
		$data['cvv'] = $this->request->post['cc_cvv2'];

		$data['first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
		$data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
		$data['address1'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
		$data['city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
		$data['state'] = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');
		$data['zip'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
		$data['phone'] = $order_info['telephone'];
		$data['email'] = $order_info['email'];
		$data['note'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

		$data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], 1.00000, false);
		$data['invoice'] = $this->config->get('payhub_invoice_prefix') . $this->session->data['order_id'];

		/* Customer Shipping Address */
		$data['ship_to_name'] = html_entity_decode($order_info['shipping_firstname'], ENT_QUOTES, 'UTF-8') . html_entity_decode($order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8');
		$data['ship_address1'] = html_entity_decode($order_info['shipping_address_1'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['shipping_address_2'], ENT_QUOTES, 'UTF-8');
		$data['ship_city'] = html_entity_decode($order_info['shipping_city'], ENT_QUOTES, 'UTF-8');
		$data['ship_state'] = html_entity_decode($order_info['shipping_zone'], ENT_QUOTES, 'UTF-8');
		$data['ship_zip'] = html_entity_decode($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8');

		$data_in_json = json_encode($data);

		$curl = curl_init($url);

		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_in_json);

		$response = curl_exec($curl);

		$json = array();

		if (curl_error($curl)) {
			$this->log->write('PAYHUB CURL ERROR: ' . curl_errno($curl) . '::' . curl_error($curl));

			$json['error'] = 'CURL ERROR: ' . curl_errno($curl) . '::' . curl_error($curl);

		} elseif ($response) {
			$response_obj = json_decode($response);

			if ($response_obj->RESPONSE_CODE == '00') {
				$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('config_order_status_id'));

				// This message shows up in the admin portal in the order's History section.
				$message = $this->language->get('text_history_header') . "\n\n";

				$message .= 'Authorization Code: ' . $response_obj->APPROVAL_CODE . "\n";
				$message .= 'AVS Response: ' . $response_obj->AVS_RESULT_CODE . "\n";
				$message .= 'Transaction ID: ' . $response_obj->TRANSACTION_ID . "\n";
				$message .= 'CVV Response: ' . $response_obj->VERIFICATION_RESULT_CODE . "\n";

				$this->model_checkout_order->update($this->session->data['order_id'], $this->config->get('payhub_order_status_id'), $message, false);

				$json['success'] = $this->url->link('checkout/success', '', 'SSL');

			} else {
				$error_message = "The transaction failed to process for the following reason:\n";
				$error_message .= $response_obj->RESPONSE_TEXT . " (" . $response_obj->RESPONSE_CODE . ")";

				$json['error'] = $error_message;
			}

		} else {
			$this->log->write('PAYHUB CURL ERROR: Empty Gateway Response');

			$json['error'] = 'Empty Gateway Response';
		}

		curl_close($curl);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
