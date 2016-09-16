<?php
class ControllerPaymentCardPay extends Controller {

	protected function index() {
		$this->language->load('payment/cardpay');

		$this->load->model('checkout/order');

		$this->data['action'] = $this->config->get('cardpay_url_production_server');

		$this->data['status_url'] = HTTPS_SERVER . 'index.php?route=payment/cardpay/callback';

		$this->data['language'] = $this->session->data['language'];
		$this->data['logo'] = $this->config->get('config_logo');

		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$order_id = $this->session->data['order_id'];

		$order_info = $this->model_checkout_order->getOrder($order_id);

		$products = $this->cart->getProducts();

		$order_items = "";

		foreach ($products as $product) {
			$order_items .= "<order_item
			 name='" . preg_replace("/(')|(\")/", "", $product['model']) . "'
			 count='" . $product['quantity'] . "'
			 price='" . $this->currency->format($product['price'], 'USD', '', false) . "'
			 description='" . preg_replace("/(')|(\")/", "", $product['name']) ."' />";
		}

		$taxes = $shipping = '';

		if ($this->cart->hasShipping()) {
			$country = $order_info['shipping_iso_code_3'];
			$state = $order_info['shipping_zone'];
			$zip = $order_info['shipping_postcode'];
			$city = $order_info['shipping_city'];
			$street = $order_info['shipping_address_1'];
		} else {
			$country = $order_info['payment_iso_code_3'];
			$state = $order_info['payment_zone'];
			$zip = $order_info['payment_postcode'];
			$city = $order_info['payment_city'];
			$street = $order_info['payment_address_1'];
		}

		$phone = $order_info['telephone'];

		$address = "<address country='" . $country . "' state='" . $state . "' city='" . $city . "' zip='" . $zip . "' street='" . $street . "' phone='" . $phone . "'/>";

		// Build Order
		$shop_id = $this->config->get('cardpay_shop_id');
		$hold_only = $this->config->get('cardpay_hold_only');
		$secret_word = $this->config->get('cardpay_secret_key');

		$amount = round($order_info['total'], 2);
		$currency = $order_info['currency_code'];

		$email = $order_info['email'];
		$user_comment = $order_info['comment'];

		$orderXML = "<order wallet_id='" . $shop_id . "' amount='" . $amount . "' currency='" . $currency . "' order_number='" . $order_id . "' email='" . $email . "' is_two_phase='" . $hold_only . "' description='" . $user_comment . "'>";
		$orderXML .= $order_items . $taxes . $shipping . $address . "</order>";

		$sha512 = hash('sha512', $orderXML.$secret_word);

		$this->data['sha512'] = $sha512;

		// Encode order
		$orderXML = base64_encode($orderXML);

		$this->data['orderXML'] = $orderXML;

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/cardpay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/cardpay.tpl';
		} else {
			$this->template = 'default/template/payment/cardpay.tpl';
		}

		$this->render();
	}

	public function callback() {
		if (!isset($_REQUEST["orderXML"]) || !isset($_REQUEST["sha512"])) {
			$this->url->link('common/home', '', 'SSL');
		}

		$request_orderXML = $_REQUEST["orderXML"];
		$request_sha512 = $_REQUEST["sha512"];

		if (!empty($request_orderXML) && !empty($request_sha512)) {
			$orderXML = base64_decode($request_orderXML);

			$sha512 = hash('sha512', $orderXML . $this->config->get('cardpay_secret_key'));

			/* If both hashes are the same, the post should come from CardPay Inc */
			if ($sha512 == $request_sha512) {
				$orderDoc = simplexml_load_string($orderXML);

				$order_id = (string)$orderDoc['number'];
				$order_status = strtoupper((string)$orderDoc['status']);

				$this->load->model('checkout/order');

				$this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id'));

				if ($order_status == 'APPROVED' || $order_status == 'PENDING') {
					$this->model_checkout_order->update($order_id, 2, 'CardPay payment was confirmed.', true);
				} elseif ($order_status == 'DECLINED') {
					$this->model_checkout_order->update($order_id, 10, 'CardPay payment was declined.', true);
				}
			}
		}
	}
}
