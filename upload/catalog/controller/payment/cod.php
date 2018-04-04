<?php
class ControllerPaymentCod extends Controller {

	protected function index() {
		$this->language->load('payment/cod');

		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_instruction'] = $this->language->get('text_instruction');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['continue'] = $this->url->link('checkout/success', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/cod.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/cod.tpl';
		} else {
			$this->template = 'default/template/payment/cod.tpl';
		}

		$this->render();
	}

	public function confirm() {
		// Helps prevent cod direct access exploit.
		if (strtolower($this->session->data['payment_method']['code']) != 'cod') {
			return;
		}

		if ($this->session->data['payment_method']['code'] == 'cod') {
			$this->language->load('payment/cod');

			$this->load->model('checkout/order');

			$comment = $this->language->get('text_instruction') . "\n\n";

			$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cod_order_status_id'), $comment, true);
		}
	}
}
