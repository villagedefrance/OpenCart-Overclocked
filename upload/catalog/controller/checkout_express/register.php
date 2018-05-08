<?php
class ControllerCheckoutExpressRegister extends Controller {

	public function index() {
		$this->language->load('checkout/checkout_express');

		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.min.css');
		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');

		$this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('checkout_express/checkout', '', 'SSL'));

		$this->data['text_your_details'] = $this->language->get('text_your_details');
		$this->data['text_your_address'] = $this->language->get('text_your_address');
		$this->data['text_your_password'] = $this->language->get('text_your_password');
		$this->data['text_female'] = $this->language->get('text_female');
		$this->data['text_male'] = $this->language->get('text_male');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_gender'] = $this->language->get('entry_gender');
		$this->data['entry_date_of_birth'] = $this->language->get('entry_date_of_birth');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');
		$this->data['entry_address_2'] = $this->language->get('entry_address_2');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_city'] = $this->language->get('entry_city');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_confirm'] = $this->language->get('entry_confirm');
		$this->data['entry_shipping'] = $this->language->get('entry_shipping');
		$this->data['entry_express_newsletter'] = $this->language->get('entry_express_newsletter');

		$this->data['text_express_full_name'] = $this->language->get('text_express_full_name');
		$this->data['text_express_address'] = $this->language->get('text_express_address');
		$this->data['text_express_billing_address'] = $this->language->get('text_express_billing_address');
		$this->data['text_express_shipping_address'] = $this->language->get('text_express_shipping_address');
		$this->data['text_express_generated'] = $this->language->get('text_express_generated');
		$this->data['text_express_company_info'] = $this->language->get('text_express_company_info');

		$this->data['button_express_go'] = $this->language->get('button_express_go');

		$this->data['email'] = $this->request->get['mail'];

		if (isset($this->session->data['firstname'])) {
			$this->data['firstname'] = $this->session->data['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->session->data['lastname'])) {
			$this->data['lastname'] = $this->session->data['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		$this->data['gender'] = 0;

		if ($this->config->get('config_express_password')) {
			$this->load->model('checkout/checkout_tools');

			$this->data['password'] = $this->model_checkout_checkout_tools->generatePassword();
		} else {
			$this->data['password'] = '';
		}

		$this->data['customer_groups'] = array();

		if (is_array($this->config->get('config_customer_group_display'))) {
			$this->load->model('account/customer_group');

			$customer_groups = $this->model_account_customer_group->getCustomerGroups();

			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$this->data['customer_groups'][] = $customer_group;
				}
			}
		}

		$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');

		if (isset($this->session->data['shipping_postcode'])) {
			$this->data['postcode'] = $this->session->data['shipping_postcode'];
		} else {
			$this->data['postcode'] = '';
		}

		if (isset($this->session->data['shipping_country_id'])) {
			$this->data['country_id'] = $this->session->data['shipping_country_id'];
		} else {
			$this->data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->session->data['shipping_zone_id'])) {
			$this->data['zone_id'] = $this->session->data['shipping_zone_id'];
		} else {
			$this->data['zone_id'] = '';
		}

		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();

		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}

		} else {
			$this->data['text_agree'] = '';
		}

		$this->data['shipping_required'] = $this->cart->hasShipping();

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout_express/register.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout_express/register.tpl';
		} else {
			$this->template = 'default/template/checkout_express/register.tpl';
		}

		$this->response->setOutput($this->render());
	}

	public function validate() {
		$this->language->load('checkout/checkout_express');

		$json = array();

		// Validate if customer is already logged in
		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		// Validate cart has products and has stock
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart', '', 'SSL');
		}

		// Validate minimum quantity requirements
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart', '', 'SSL');
				break;
			}
		}

		$this->request->post['address_2'] = '';

		if ($this->config->get('config_express_newsletter') != 2) {
			$this->request->post['newsletter'] = $this->config->get('config_express_newsletter');
		}

		$this->request->post['fax'] = '';

		if (!$json) {
			if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
				$json['error']['firstname'] = $this->language->get('error_firstname');
			}

			if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
				$json['error']['lastname'] = $this->language->get('error_lastname');
			}

			if ($this->config->get('config_express_phone') == 2) {
				if ((utf8_strlen($this->request->post['telephone']) < 1) || (utf8_strlen($this->request->post['telephone']) > 32)) {
					$json['error']['telephone'] = $this->language->get('error_telephone');
				}
			}

			if ($this->config->get('config_customer_dob')) {
				if (isset($this->request->post['date_of_birth']) && (utf8_strlen($this->request->post['date_of_birth']) == 10)) {
					if ($this->request->post['date_of_birth'] != date('Y-m-d', strtotime($this->request->post['date_of_birth']))) {
						$json['error']['date_of_birth'] = $this->language->get('error_date_of_birth');
					}
				} else {
					$json['error']['date_of_birth'] = $this->language->get('error_date_of_birth');
				}
			}

			if (isset($this->request->post['email'])) {
				if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
					$json['error']['email'] = $this->language->get('error_email');
				}

				// Email exists check
				$this->load->model('checkout/checkout_express');

				if ($this->model_checkout_checkout_express->getTotalCustomersByEmail($this->request->post['email'])) {
					$json['error']['warning'] = $this->language->get('error_exists');
				}

				// Email MX Record check
				$this->load->model('tool/email');

				$email_valid = $this->model_tool_email->verifyMail($this->request->post['email']);

				if (!$email_valid) {
					$json['error']['email'] = $this->language->get('error_email');
				}
			}

			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$json['error']['password'] = $this->language->get('error_password');
			}

			// Customer Group
			$this->load->model('account/customer_group');

			if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
				$customer_group_id = $this->request->post['customer_group_id'];
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}

			$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

			if ($this->config->get('config_express_billing')) {
				if ($customer_group) {
					// Company ID
					if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && empty($this->request->post['company_id'])) {
						$json['error']['company_id'] = $this->language->get('error_company_id');
					}

					// Tax ID
					if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && empty($this->request->post['tax_id'])) {
						$json['error']['tax_id'] = $this->language->get('error_tax_id');
					}
				}

				if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
					$json['error']['address_1'] = $this->language->get('error_address_1');
				}

				if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
					$json['error']['city'] = $this->language->get('error_city');
				}

				$this->load->model('localisation/country');

				$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

				if ($country_info) {
					if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
						$json['error']['postcode'] = $this->language->get('error_postcode');
					}

					// VAT Validation
					if ($customer_group && $customer_group['tax_id_display']) {
						$this->load->helper('vat');

						if ($this->config->get('config_vat') && $this->request->post['tax_id'] != '' && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
							$json['error']['tax_id'] = $this->language->get('error_vat');
						}
					}
				}

				if (!isset($this->request->post['country_id']) || $this->request->post['country_id'] == '') {
					$json['error']['country'] = $this->language->get('error_country');
				}

				if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
					$json['error']['zone'] = $this->language->get('error_zone');
				}
			}

			if ($this->config->get('config_account_id')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

				if ($information_info && !isset($this->request->post['agree'])) {
					$json['error']['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
				}
			}

		} else {
			$json = array();
		}

		if (!$json) {
			$this->load->model('checkout/checkout_express');

			$this->model_checkout_checkout_express->addCustomer($this->request->post);

			$this->session->data['account'] = 'register';

			$this->load->model('account/customer_group');

			$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

			if (!isset($customer_group)) {
				$customer_group = 0;
			}

			// Always approved
			if ($customer_group['approval'] || $customer_group['approval'] != 0) {
				$customer_group['approval'] = 0;
			}

			if (!$customer_group['approval']) {
				$this->customer->login($this->request->post['email'], $this->request->post['password']);

				$this->session->data['payment_firstname'] = $this->request->post['firstname'];
				$this->session->data['payment_lastname'] = $this->request->post['lastname'];
				$this->session->data['payment_address_id'] = $this->customer->getAddressId();
				$this->session->data['payment_country_id'] = $this->request->post['country_id'];
				$this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
				$this->session->data['payment_postcode'] = $this->request->post['postcode'];

				if (!empty($this->request->post['shipping_address'])) {
					$this->session->data['shipping_firstname'] = $this->request->post['firstname'];
					$this->session->data['shipping_lastname'] = $this->request->post['lastname'];
					$this->session->data['shipping_address_id'] = $this->customer->getAddressId();
					$this->session->data['shipping_country_id'] = $this->request->post['country_id'];
					$this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
					$this->session->data['shipping_postcode'] = $this->request->post['postcode'];
				}

			} else {
				$json['redirect'] = $this->url->link('account/success', '', 'SSL');
			}

			unset($this->session->data['guest']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
