<?php
class ControllerPaymentG2APay extends Controller {

	public function index() {
		$this->language->load('payment/g2apay');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['action'] = $this->url->link('payment/g2apay/checkout', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/g2apay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/g2apay.tpl';
		} else {
			$this->template = 'default/template/payment/g2apay.tpl';
		}

		$this->render();
	}

	public function checkout() {
		$this->load->model('checkout/order');
		$this->load->model('account/order');
		$this->load->model('payment/g2apay');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$this->load->model('setting/extension');

		$results = $this->model_setting_extension->getExtensions('total');

		$order_data = array();

		$total = 0;

		$items = array();

		$taxes = $this->cart->getTaxes();

		$i = 0;

		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);

				$this->{'model_total_' . $result['code']}->getTotal($order_data['totals'], $total, $taxes);

				if (isset($order_data['totals'][$i])) {
					if (strstr(strtolower($order_data['totals'][$i]['code']), 'total') === false) {
						$item = new stdClass();

						$item->sku = $order_data['totals'][$i]['code'];
						$item->name = $order_data['totals'][$i]['title'];
						$item->amount = number_format($order_data['totals'][$i]['value'], 2);
						$item->qty = 1;
						$item->id = $order_data['totals'][$i]['code'];
						$item->price = $order_data['totals'][$i]['value'];
						$item->url = $this->url->link('common/home', '', 'SSL');

						$items[] = $item;
					}

					$i++;
				}
			}
		}

		$ordered_products = $this->model_account_order->getOrderProducts($this->session->data['order_id']);

		foreach ($ordered_products as $product) {
			$item = new stdClass();

			$item->sku = $product['product_id'];
			$item->name = $product['name'];
			$item->amount = $product['price'] * $product['quantity'];
			$item->qty = $product['quantity'];
			$item->id = $product['product_id'];
			$item->price = $product['price'];
			$item->url = $this->url->link('product/product', 'product_id=' . $product['product_id'], 'SSL');

			$items[] = $item;
		}

		if ($this->config->get('g2apay_environment') == 1) {
			$url = 'https://checkout.pay.g2a.com/index/createQuote';
		} else {
			$url = 'https://checkout.test.pay.g2a.com/index/createQuote';
		}

		$order_total = number_format($order_info['total'], 2);

		$string = $this->session->data['order_id'] . $order_total . $order_info['currency_code'] . html_entity_decode($this->config->get('g2apay_secret'), ENT_QUOTES, 'UTF-8');

		$fields = array(
			'api_hash'    => $this->config->get('g2apay_api_hash'),
			'hash'        => hash('sha256', $string),
			'order_id'    => $this->session->data['order_id'],
			'amount'      => $order_total,
			'currency'    => $order_info['currency_code'],
			'email'       => $order_info['email'],
			'url_failure' => $this->url->link('checkout/failure', '', 'SSL'),
			'url_ok'      => $this->url->link('payment/g2apay/success', '', 'SSL'),
			'items'       => json_encode($items)
		);

		$response_data = $this->model_payment_g2apay->sendCurl($url, $fields);

		$this->model_payment_g2apay->logger($order_total);
		$this->model_payment_g2apay->logger($items);
		$this->model_payment_g2apay->logger($fields);

		if ($response_data === false) {
			$this->redirect($this->url->link('payment/failure', '', 'SSL'));
		}

		if (strtolower($response_data->status) != 'ok') {
			$this->redirect($this->url->link('payment/failure', '', 'SSL'));
		}

		$this->model_payment_g2apay->addG2aOrder($order_info);

		if ($this->config->get('g2apay_environment') == 1) {
			$this->redirect('https://checkout.pay.g2a.com/index/gateway?token=' . $response_data->token);
		} else {
			$this->redirect('https://checkout.test.pay.g2a.com/index/gateway?token=' . $response_data->token);
		}
	}

	public function success() {
		$order_id = $this->session->data['order_id'];

		if (isset($this->request->post['transaction_id'])) {
			$g2apay_transaction_id = $this->request->post['transaction_id'];
		} elseif (isset($this->request->get['transaction_id'])) {
			$g2apay_transaction_id = $this->request->get['transaction_id'];
		} else {
			$g2apay_transaction_id = '';
		}

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($order_id);

		if ($order_info) {
			$this->load->model('payment/g2apay');

			$g2apay_order_info = $this->model_payment_g2apay->getG2aOrder($order_id);

			$this->model_payment_g2apay->updateOrder($g2apay_order_info['g2apay_order_id'], $g2apay_transaction_id, 'payment', $order_info);

			$this->model_checkout_order->update($order_id, $this->config->get('g2apay_order_status_id'));
		}

		$this->redirect($this->url->link('checkout/success', '', 'SSL'));
	}

	public function ipn() {
		$this->load->model('payment/g2apay');

		$this->model_payment_g2apay->logger('ipn');

		if (isset($this->request->get['token']) && hash_equals($this->config->get('g2apay_secret_token'), $this->request->get['token'])) {
			$this->model_payment_g2apay->logger('token success');

			if (isset($this->request->post['userOrderId'])) {
				$g2apay_order = $this->model_payment_g2apay->getG2aOrder($this->request->post['userOrderId']);

				$string = $g2apay_order['g2apay_transaction_id'] . $g2apay_order['order_id'] . round($g2apay_order['total'], 2) . html_entity_decode($this->config->get('g2apay_secret'), ENT_QUOTES, 'UTF-8');

				$hash = hash('sha256', $string);

				if ($hash != $this->request->post['hash']) {
					$this->model_payment_g2apay->logger('Hashes do not match, possible tampering!');
					return;
				}

				switch ($this->request->post['status']) {
					case 'complete':
						$order_status_id = $this->config->get('g2apay_complete_status_id');
						break;
					case 'rejected':
						$order_status_id = $this->config->get('g2apay_rejected_status_id');
						break;
					case 'canceled':
						$order_status_id = $this->config->get('g2apay_cancelled_status_id');
						break;
					case 'pending':
						$order_status_id = $this->config->get('g2apay_pending_status_id');
						break;
					case 'partial_refunded':
						$order_status_id = $this->config->get('g2apay_partially_refunded_status_id');
						break;
					case 'refunded':
						$order_status_id = $this->config->get('g2apay_refunded_status_id');
						break;
				}

				$this->load->model('checkout/order');

				$this->model_checkout_order->update($this->request->post['userOrderId'], $order_status_id);
			}
		}
	}
}
