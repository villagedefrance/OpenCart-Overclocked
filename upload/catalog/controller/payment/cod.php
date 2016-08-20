<?php
class ControllerPaymentCod extends Controller {

	public function index() {
		$this->data['text_wait'] = $this->language->get('text_wait');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['continue'] = $this->url->link('checkout/success');

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
		if ($this->session->data['payment_method']['code'] == 'cod') {
			$this->load->model('checkout/order');

			$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
		}
	}
}
?>
