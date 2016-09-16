<?php
class ControllerPaymentInStore extends Controller {

	protected function index() {
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
		$this->load->model('checkout/order');

		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('in_store_order_status_id'));
	}
}
