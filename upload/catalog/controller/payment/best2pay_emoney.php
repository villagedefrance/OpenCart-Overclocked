<?php
class ControllerPaymentBest2payEmoney extends Controller {

	public function index() {
		$this->language->load('payment/best2pay_emoney');

    	$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if (!$this->config->get('best2pay_test')) {
			$this->data['action'] = 'https://pay.best2pay.net/webapi/';
		} else {
			$this->data['action'] = 'https://test.best2pay.net/webapi/';
		}

		$currency = array('RUB' => 643, 'USD' => 840, 'EUR' => 978);

		$products = $this->cart->getProducts();

		$product_names = array();

		foreach ($products as $product) {
			$product_names[] = $product['name'] . ' (' . $product['quantity'] . ')';
		}

		$description = $product_names ? implode(', ', $product_names) : '';

		$currency_code = $this->config->get('best2pay_emoney_currency');

		$total = $this->currency->convert($order_info['total'], $order_info['currency_code'], $currency_code);

		$commission = ($this->config->get('best2pay_emoney_commission_pay') == 1 && $this->config->get('best2pay_emoney_commission') && floatval($this->config->get('best2pay_emoney_commission'))) ? floatval($this->config->get('best2pay_emoney_commission')) : 0;

		$commission_amount = $total / 100 * $commission;

		$register_data['amount'] = $this->currency->format($total + $commission_amount, $currency_code, $order_info['currency_value'], false) * 100;
		$register_data['currency'] = isset($currency[$currency_code]) ? $currency[$currency_code] : 0;

		$register_data['reference'] = $order_info['order_id'];

		$register_data['description'] = substr($description, 0, 1000);
		$register_data['sector'] = $this->config->get('best2pay_emoney_sector');
		$register_data['url'] = HTTP_SERVER . 'index.php?route=payment/best2pay_emoney/request';
		$register_data['email'] = $order_info['email'];
		$register_data['phone'] = $order_info['telephone'];
		$register_data['mode'] = 1;
		$register_data['signature'] = base64_encode(md5($register_data['sector'] . $register_data['amount'] . $register_data['currency'] . $this->config->get('best2pay_emoney_password')));
		$register_data['address'] = $order_info['payment_address_1'] . ($order_info['payment_address_2'] ? ', ' . $order_info['payment_address_2'] : '');
		$register_data['city'] = $order_info['payment_city'];
		$register_data['region'] = $order_info['payment_zone'];
		$register_data['post_code'] = $order_info['payment_postcode'];
		$register_data['country'] = $order_info['payment_iso_code_2'];

		// REGISTER
		$order_id = 0;

		$options = array(
			'http' => array(
				 'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				 'method'  => 'POST',
				 'content' => http_build_query($register_data)
			),
		);

		$context = stream_context_create($options);

		$register = file_get_contents($this->data['action'] . 'Register', false, $context);

		if (is_numeric($register)) {
			$order_id = (int) $register;
		} else {
			$this->data['error'] = $this->language->get('text_error');
		}

		if ($order_id) {
			$this->data['action'] .= 'Epayment';

			$this->data['sector'] = $register_data['sector'];
			$this->data['id'] = $order_id;
			$this->data['firstname'] = $order_info['payment_firstname'];
			$this->data['lastname'] = $order_info['payment_lastname'];
			$this->data['email'] = $order_info['email'];
			$this->data['signature'] = base64_encode(md5($register_data['sector'] . $order_id . $this->config->get('best2pay_emoney_password')));

			$this->data['commission_text'] = $commission ? sprintf($this->language->get('text_commission'), $commission, '%') : '';

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/best2pay_emoney.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/best2pay_emoney.tpl';
			} else {
				$this->template = 'default/template/payment/best2pay_emoney.tpl';
			}

		} else {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/best2pay_error.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/best2pay_error.tpl';
			} else {
				$this->template = 'default/template/payment/best2pay_error.tpl';
			}
		}

		$this->render();
	}

	public function request() {
		$this->language->load('payment/best2pay');

		$this->data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = $this->config->get('config_url');
		} else {
			$this->data['base'] = $this->config->get('config_ssl');
		}

		$this->data['language'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');

		$this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

		$this->data['text_success'] = $this->language->get('text_success');
		$this->data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success', '', 'SSL'));

		$this->data['text_failure'] = $this->language->get('text_failure');
		$this->data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/cart', '', 'SSL'));

		$error = false;

		if (isset($this->request->get['operation']) && $this->request->get['operation'] && isset($this->request->get['id']) && $this->request->get['id']) {
			// OPERATION
			if (!$this->config->get('best2pay_test')) {
				$action = 'https://pay.best2pay.net/webapi/';
			} else {
				$action = 'https://test.best2pay.net/webapi/';
			}

			$operation_data['sector'] = $this->config->get('best2pay_sector');
			$operation_data['id'] = $this->request->get['id'];
			$operation_data['operation'] = $this->request->get['operation'];
			$operation_data['signature'] = base64_encode(md5($operation_data['sector'] . $operation_data['id'] . $operation_data['operation'] . $this->config->get('best2pay_password')));

			$options = array(
				'http' => array(
					 'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					 'method'  => 'POST',
					 'content' => http_build_query($operation_data)
				)
			);

			$context = stream_context_create($options);

			$operation = file_get_contents($action . 'Operation', false, $context);

			if ($operation) {
				$result = new SimpleXMLElement($operation);

				if (isset($result->reason_code) && $result->reason_code == 1) {
					$this->load->model('checkout/order');

					$this->model_checkout_order->confirm($this->request->get['reference'], $this->config->get('best2pay_order_status_id'));

					$message = '';

					if (isset($result->order_id)) {
						$message .= 'order_id: ' . $result->order_id . "\n";
					}

					if (isset($result->order_state)) {
						$message .= 'order_state: ' . $result->order_state . "\n";
					}

					if (isset($result->reference)) {
						$message .= 'reference: ' . $result->reference . "\n";
					}

					if (isset($result->id)) {
						$message .= 'id: ' . $result->id . "\n";
					}

					if (isset($result->date)) {
						$message .= 'date: ' . $result->date . "\n";
					}

					if (isset($result->type)) {
						$message .= 'type: ' . $result->type . "\n";
					}

					if (isset($result->state)) {
						$message .= 'state: ' . $result->state . "\n";
					}

					if (isset($result->reason_code)) {
						$message .= 'reason_code: ' . $result->reason_code . "\n";
					}

					if (isset($result->message)) {
						$message .= 'message: ' . $result->message . "\n";
					}

					if (isset($result->name)) {
						$message .= 'name: ' . $result->name . "\n";
					}

					if (isset($result->pan)) {
						$message .= 'pan: ' . $result->pan . "\n";
					}

					if (isset($result->email)) {
						$message .= 'email: ' . $result->email . "\n";
					}

					if (isset($result->amount)) {
						$message .= 'amount: ' . $result->amount . "\n";
					}

					if (isset($result->approval_code)) {
						$message .= 'approval_code: ' . $result->approval_code . "\n";
					}

					$this->model_checkout_order->update($this->request->get['reference'], $this->config->get('best2pay_order_status_id'), $message, false);

					$this->data['continue'] = $this->url->link('checkout/success', '', 'SSL');

					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/best2pay_success.tpl')) {
						$this->template = $this->config->get('config_template') . '/template/payment/best2pay_success.tpl';
					} else {
						$this->template = 'default/template/payment/best2pay_success.tpl';
					}

					$this->response->setOutput($this->render());

				} elseif (isset($result->reason_code)) {
					$error = true;

					if (isset($result->reason_code)) {
						$this->data['text_failure'] .= '<br />' . $this->language->get('text_reason_' . (int)$result->reason_code);
					}

				} else {
					$error = true;

					$this->data['text_failure'] .= '<br />' . sprintf($this->language->get('text_error_code'), isset($result->code) ? $result->code : '');
				}

			} else {
				$error = true;
			}

		} else {
			$error = true;
		}

		if ($error) {
			$this->data['continue'] = $this->url->link('checkout/cart', '', 'SSL');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/best2pay_failure.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/best2pay_failure.tpl';
			} else {
				$this->template = 'default/template/payment/best2pay_failure.tpl';
			}

			$this->response->setOutput($this->render());
		}
	}
}
