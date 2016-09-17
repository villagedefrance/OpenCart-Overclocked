<?php
class ControllerCheckoutExpressLogin extends Controller {

	public function index() {
		$this->language->load('checkout/checkout_express');

		$this->data['text_checkout_account'] = $this->language->get('text_checkout_account');
		$this->data['text_express_hello'] = $this->language->get('text_express_hello');
		$this->data['text_express_remind'] = $this->language->get('text_express_remind');

		$this->data['entry_express_email'] = $this->language->get('entry_express_email');
		$this->data['entry_express_password'] = $this->language->get('entry_express_password');

		$this->data['button_express_go'] = $this->language->get('button_express_go');

		if (isset($this->session->data['account'])) {
			$this->data['account'] = $this->session->data['account'];
		} else {
			$this->data['account'] = 'register';
		}

		$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout_express/login.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout_express/login.tpl';
		} else {
			$this->template = 'default/template/checkout_express/login.tpl';
		}

		$this->response->setOutput($this->render());
	}

	public function validate() {
		$this->language->load('checkout/checkout_express');

		$json = array();

		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout_express/checkout', '', 'SSL');
		}

		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart', '', 'SSL');
		}

		if (!$json) {
			$this->load->model('checkout/checkout_express');
			$this->load->model('checkout/checkout_tools');

			if (!$this->request->post['email'] || (utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
				$json['error']['warning'] = $this->language->get('error_email');
			}

			$customer_info = $this->model_checkout_checkout_express->getCustomerByEmail($this->request->post['email']);

			if (!isset($this->request->post['password'])) {
				$this->request->post['password'] = '';
			}

			if (!$this->request->post['password']) {
                if ($customer_info) {
					$json['name'] = $this->model_checkout_checkout_tools->getJoinName($customer_info);
				} else {
					$json['mail'] = $this->request->post['email'];
				}
            }

			if ($this->request->post['email'] && $this->request->post['password']) {
				if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
					$json['error']['warning'] = $this->language->get('error_login');
				}

				if ($customer_info && !$customer_info['approved']) {
					$json['error']['warning'] = $this->language->get('error_approved');
				}
			}
		}

		if (!$json) {
			unset($this->session->data['guest']);

			// Default Addresses
			$this->load->model('account/address');

			$address_info = $this->model_account_address->getAddress($this->customer->getAddressId());

			if ($address_info) {
				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_country_id'] = $address_info['country_id'];
					$this->session->data['shipping_zone_id'] = $address_info['zone_id'];
					$this->session->data['shipping_postcode'] = $address_info['postcode'];
				}

				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_country_id'] = $address_info['country_id'];
					$this->session->data['payment_zone_id'] = $address_info['zone_id'];
				}

			} else {
				unset($this->session->data['shipping_country_id']);
				unset($this->session->data['shipping_zone_id']);
				unset($this->session->data['shipping_postcode']);

				unset($this->session->data['payment_country_id']);
				unset($this->session->data['payment_zone_id']);
			}

			$json['redirect'] = $this->url->link('checkout_express/checkout', '', 'SSL');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
