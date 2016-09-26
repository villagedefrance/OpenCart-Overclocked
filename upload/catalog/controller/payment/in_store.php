<?php
class ControllerPaymentInStore extends Controller {

	protected function index() {
		$this->language->load('payment/in_store');

		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_instruction'] = $this->language->get('text_instruction');

    	$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['continue'] = $this->url->link('checkout/success', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/in_store.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/in_store.tpl';
		} else {
			$this->template = 'default/template/payment/in_store.tpl';
		}

		$this->render();
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'in_store') {
			$this->language->load('payment/in_store');

			$this->load->model('checkout/order');

			$comment = $this->language->get('text_instruction') . "\n\n";

			$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('in_store_order_status_id'), $comment, true);
		}
	}
}
