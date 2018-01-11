<?php
class ControllerPaymentStripePayments extends Controller {

	protected function index() {
		$this->language->load('payment/stripe_payments');

		$this->data['text_credit_card'] = $this->language->get('text_credit_card');
		$this->data['text_wait'] = $this->language->get('text_wait');

		$this->data['entry_cc_owner'] = $this->language->get('entry_cc_owner');
		$this->data['entry_cc_number'] = $this->language->get('entry_cc_number');
		$this->data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
		$this->data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');

		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

        $this->data['stripe_payments_publish_key'] = $this->config->get('stripe_payments_publish_key');

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

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/stripe_payments.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/stripe_payments.tpl';
		} else {
			$this->template = 'default/template/payment/stripe_payments.tpl';
		}

		$this->render();
	}

	public function send() {
		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$amount = (int)($this->currency->format($order_info['total'], $order_info['currency_code'], 1.00000, false) * 100);

		// Load Stripe Library
		require_once(DIR_SYSTEM . 'vendor/stripe-php/init.php');

		$stripe = array(
			"secret_key"      => $this->config->get('stripe_payments_secret_key'),
			"publishable_key" => $this->config->get('stripe_payments_publish_key')
		);

		Stripe::setApiKey($stripe['secret_key']);

		$token = $this->session->data['stripeToken'];

		$error = null;

		try {
			$customer = Stripe_Customer::create(array('email' => $order_info['email'], 'card' => $token));

			Stripe_Charge::create(array(
				'customer'     => $customer->id,
				'amount'       => $amount,
				'currency'     => $order_info['currency_code'],
				'metadata'     => array(
					'order_id' => $this->session->data['order_id'],
					'customer' => $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'],
					'email'    => $order_info['email'],
					'phone'    => $order_info['telephone']
				),
				'description'  => 'Order ID# '. $this->session->data['order_id']
			));

		} catch (Stripe_CardError $e) {
			// Error card processing
			$error = $e->jsonBody['error'];
		}

		$json = array();

		// If successful log transaction
		if (!$error) {
			$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('stripe_payments_order_status_id'));
			$json['success'] = $this->url->link('checkout/success', '', 'SSL');
		} else {
			$json['error'] = (string)$error['message'];
            $json['details'] = $error;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
