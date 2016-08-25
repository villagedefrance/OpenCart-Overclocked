<?php
class ControllerPaymentWorldpayOnline extends Controller {

	public function index() {
		$this->language->load('payment/worldpay_online');

		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_credit_card'] = $this->language->get('text_credit_card');
		$this->data['text_loading'] = $this->language->get('text_loading');
		$this->data['text_card_type'] = $this->language->get('text_card_type');
		$this->data['text_card_name'] = $this->language->get('text_card_name');
		$this->data['text_card_digits'] = $this->language->get('text_card_digits');
		$this->data['text_card_expiry'] = $this->language->get('text_card_expiry');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['entry_card'] = $this->language->get('entry_card');
		$this->data['entry_card_existing'] = $this->language->get('entry_card_existing');
		$this->data['entry_card_new'] = $this->language->get('entry_card_new');
		$this->data['entry_card_save'] = $this->language->get('entry_card_save');
		$this->data['entry_cc_cvc'] = $this->language->get('entry_cc_cvc');
		$this->data['entry_cc_choice'] = $this->language->get('entry_cc_choice');

		$this->data['button_delete_card'] = $this->language->get('button_delete_card');
		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['worldpay_online_script'] = 'https://cdn.worldpay.com/v1/worldpay.js';

		$this->data['worldpay_online_client_key'] = $this->config->get('worldpay_online_client_key');

		$this->data['form_submit'] = $this->url->link('payment/worldpay_online/send', '', 'SSL');

		if ($this->config->get('worldpay_online_card') == '1' && $this->customer->isLogged()) {
			$this->data['worldpay_online_card'] = true;
		} else {
			$this->data['worldpay_online_card'] = false;
		}

		$this->data['existing_cards'] = array();

		if ($this->customer->isLogged() && $this->data['worldpay_online_card']) {
			$this->load->model('payment/worldpay_online');

			$this->data['existing_cards'] = $this->model_payment_worldpay_online->getCards($this->customer->getId());
		}

		$recurring_products = $this->cart->getRecurringProducts();

		if (!empty($recurring_products)) {
			$this->data['recurring_products'] = true;
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/worldpay_online.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/worldpay_online.tpl';
		} else {
			$this->template = 'default/template/payment/worldpay_online.tpl';
		}

		$this->render();
	}

	public function send() {
		$this->language->load('payment/worldpay_online');

		$this->load->model('checkout/order');
		$this->load->model('localisation/country');
		$this->load->model('payment/worldpay_online');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$recurring_products = $this->cart->getRecurringProducts();

		if (empty($recurring_products)) {
			$order_type = 'ECOM';
		} else {
			$order_type = 'RECURRING';
		}

		$country_info = $this->model_localisation_country->getCountry($order_info['payment_country_id']);

		$billing_address = array(
			'address1'    => $order_info['payment_address_1'],
			'address2'    => $order_info['payment_address_2'],
			'address3'    => '',
			'postalCode'  => $order_info['payment_postcode'],
			'city'        => $order_info['payment_city'],
			'state'       => $order_info['payment_zone'],
			'countryCode' => $country_info['iso_code_2']
		);

		$order = array(
			'token'             => $this->request->post['token'],
			'orderType'         => $order_type,
			'amount'            => round($this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false) * 100),
			'currencyCode'      => $order_info['currency_code'],
			'name'              => $order_info['firstname'] . ' ' . $order_info['lastname'],
			'orderDescription'  => $order_info['store_name'] . ' - ' . date('Y-m-d H:i:s'),
			'customerOrderCode' => $order_info['order_id'],
			'billingAddress'    => $billing_address
		);

		$this->model_payment_worldpay_online->logger($order);

		$response_data = $this->model_payment_worldpay_online->sendCurl('orders', $order);

		$this->model_payment_worldpay_online->logger($response_data);

		if (isset($response_data->paymentStatus) && $response_data->paymentStatus == 'SUCCESS') {
			$this->model_checkout_order->confirm($order_info['order_id'], $this->config->get('config_order_status_id'));

			$worldpay_online_order_id = $this->model_payment_worldpay_online->addOrder($order_info, $response_data->orderCode);

			$this->model_payment_worldpay_online->addTransaction($worldpay_online_order_id, 'payment', $order_info);

			if (isset($this->request->post['save-card'])) {
				$response = $this->model_payment_worldpay_online->sendCurl('tokens/' . $this->request->post['token']);

				$this->model_payment_worldpay_online->logger($response);

				$expiry_date = mktime(0, 0, 0, 0, (string)$response->paymentMethod->expiryMonth, (string)$response->paymentMethod->expiryYear);

				if (isset($response->paymentMethod)) {
					$card_data = array();

					$card_data['customer_id'] = $this->customer->getId();
					$card_data['Token'] = $response->token;
					$card_data['Last4Digits'] = (string)$response->paymentMethod->maskedCardNumber;
					$card_data['ExpiryDate'] = date("m/y", $expiry_date);
					$card_data['CardType'] = (string)$response->paymentMethod->cardType;

					$this->model_payment_worldpay_online->addCard($this->session->data['order_id'], $card_data);
				}
			}

			// loop through any products that are recurring items
			foreach ($recurring_products as $item) {
				$this->model_payment_worldpay_online->recurringPayment($item, $this->session->data['order_id'] . rand(), $this->request->post['token']);
			}

			$this->response->redirect($this->url->link('checkout/success', '', 'SSL'));

		} else {
			$this->session->data['error'] = $this->language->get('error_process_order');

			$this->response->redirect($this->url->link('checkout/checkout', '', 'SSL'));
		}
	}

	public function deleteCard() {
		$this->language->load('payment/worldpay_online');

		$this->load->model('payment/worldpay_online');

		if (isset($this->request->post['token'])) {
			if ($this->model_payment_worldpay_online->deleteCard($this->request->post['token'])) {
				$json['success'] = $this->language->get('text_card_success');
			} else {
				$json['error'] = $this->language->get('text_card_error');
			}

			if (count($this->model_payment_worldpay_online->getCards($this->customer->getId()))) {
				$json['existing_cards'] = true;
			}

		} else {
			$json['error'] = $this->language->get('text_error');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function webhook() {
		if (isset($this->request->get['token']) && hash_equals($this->config->get('worldpay_online_secret_token'), $this->request->get['token'])) {
			$this->load->model('payment/worldpay_online');

			$message = json_decode(file_get_contents('php://input'), 'SSL');

			if (isset($message['orderCode'])) {
				$order = $this->model_payment_worldpay_online->getWorldpayOrder($message['orderCode']);

				$this->model_payment_worldpay_online->logger($order);

				switch ($message['paymentStatus']) {
					case 'SUCCESS':
						$order_status_id = $this->config->get('worldpay_online_entry_success_status_id');
						break;
					case 'FAILED':
						$order_status_id = $this->config->get('worldpay_online_entry_failed_status_id');
						break;
					case 'SETTLED':
						$order_status_id = $this->config->get('worldpay_online_entry_settled_status_id');
						break;
					case 'REFUNDED':
						$order_status_id = $this->config->get('worldpay_online_refunded_status_id');
						break;
					case 'PARTIALLY_REFUNDED':
						$order_status_id = $this->config->get('worldpay_online_entry_partially_refunded_status_id');
						break;
					case 'CHARGED_BACK':
						$order_status_id = $this->config->get('worldpay_online_entry_charged_back_status_id');
						break;
					case 'INFORMATION_REQUESTED':
						$order_status_id = $this->config->get('worldpay_online_entry_information_requested_status_id');
						break;
					case 'INFORMATION_SUPPLIED':
						$order_status_id = $this->config->get('worldpay_online_entry_information_supplied_status_id');
						break;
					case 'CHARGEBACK_REVERSED':
						$order_status_id = $this->config->get('worldpay_online_entry_chargeback_reversed_status_id');
						break;
				}

				$this->model_payment_worldpay_online->logger($order_status_id);

				if (isset($order['order_id'])) {
					$this->load->model('checkout/order');

					$this->model_checkout_order->update($order['order_id'], $order_status_id);
				}
			}
		}

		$this->response->addHeader('HTTP/1.1 200 OK');
		$this->response->addHeader('Content-Type: application/json');
	}

	public function cron() {
		if ($this->request->get['token'] == $this->config->get('worldpay_online_cron_job_token')) {
			$this->load->model('payment/worldpay_online');

			$orders = $this->model_payment_worldpay_online->cronPayment();

			$this->model_payment_worldpay_online->updateCronJobRunTime();

			$this->model_payment_worldpay_online->logger($orders);
		}
	}
}
