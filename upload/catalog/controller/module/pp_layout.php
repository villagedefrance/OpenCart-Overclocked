<?php
class ControllerModulePPLayout extends Controller {
	private $_name = 'pp_layout';

	protected function index($setting) {
		$force_display = $this->config->get($this->_name . '_force_display');

		$status = true;

		if (!$setting['status'] && !$this->config->get('pp_express_status') && !$force_display) {
			$status = false;
		}

		$cart_status = true;

		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout')) || (!$this->customer->isLogged() && ($this->cart->hasRecurringProducts() || $this->cart->hasDownload()))) {
			$cart_status = false;
		}

		if ($cart_status || ($force_display && $cart_status)) {
			$status = true;
		} elseif ($force_display && !$cart_status) {
			$status = true;
		} else {
			$status = false;
		}

		if ($status) {
			$this->load->model('payment/pp_express');

			$this->data['is_mobile'] = $this->model_payment_pp_express->isMobile();

			if (!$force_display && $cart_status) {
				$this->data['payment_url'] = $this->url->link('payment/pp_express/express', '', 'SSL');
				$this->data['pp_ready'] = '';
			} elseif ($force_display && $cart_status) {
				$this->data['payment_url'] = $this->url->link('payment/pp_express/express', '', 'SSL');
				$this->data['pp_ready'] = 'border:2px solid #5DC15E; -webkit-border-radius:7px; -moz-border-radius:7px; -khtml-border-radius:7px; border-radius:7px;';
			} elseif ($force_display && $this->customer->isLogged()) {
				$this->data['payment_url'] = $this->url->link('common/home', '', 'SSL');
				$this->data['pp_ready'] = 'border:2px solid #F2B155; -webkit-border-radius:7px; -moz-border-radius:7px; -khtml-border-radius:7px; border-radius:7px;';
			} elseif ($force_display) {
				$this->data['payment_url'] = $this->url->link('account/login', '', 'SSL');
				$this->data['pp_ready'] = 'border:2px solid #DE5954; -webkit-border-radius:7px; -moz-border-radius:7px; -khtml-border-radius:7px; border-radius:7px;';
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/pp_layout.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/pp_layout.tpl';
			} else {
				$this->template = 'default/template/module/pp_layout.tpl';
			}

			$this->render();
		}
	}
}
