<?php
class ControllerCheckoutCheckoutOneCart extends Controller {

	public function index() {
		$this->language->load('checkout/checkout_one_page');

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$this->redirect($this->url->link('checkout/cart', '', 'SSL'));
				break;
			}
		}

		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		$this->load->model('setting/extension');

		$sort_order = array();

		$results = $this->model_setting_extension->getExtensions('total');

		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}

		array_multisort($sort_order, SORT_ASC, $results);

		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);

				$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
			}
		}

		$sort_order = array();

		foreach ($total_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $total_data);

		$data = array();

		$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
		$data['store_id'] = $this->config->get('config_store_id');
		$data['store_name'] = $this->config->get('config_name');

		if ($data['store_id']) {
			$data['store_url'] = $this->config->get('config_url');
		} else {
			$data['store_url'] = HTTP_SERVER;
		}

		if (isset($this->session->data['payment_method']['title'])) {
			$data['payment_method'] = $this->session->data['payment_method']['title'];
		} else {
			$data['payment_method'] = '';
		}

		if (isset($this->session->data['payment_method']['code'])) {
			$data['payment_code'] = $this->session->data['payment_method']['code'];
		} else {
			$data['payment_code'] = '';
		}

		if (isset($this->session->data['shipping_method']['title'])) {
			$data['shipping_method'] = $this->session->data['shipping_method']['title'];
		} else {
			$data['shipping_method'] = '';
		}

		if (isset($this->session->data['shipping_method']['code'])) {
			$data['shipping_code'] = $this->session->data['shipping_method']['code'];
		} else {
			$data['shipping_code'] = '';
		}

		$product_data = array();

		foreach ($this->cart->getProducts() as $product) {
			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['option_value'];
				} else {
					$value = $this->encryption->decrypt($option['option_value']);
				}

				$option_data[] = array(
					'product_option_id'       => $option['product_option_id'],
					'product_option_value_id' => $option['product_option_value_id'],
					'option_id'               => $option['option_id'],
					'option_value_id'         => $option['option_value_id'],
					'name'                    => $option['name'],
					'value'                   => $value,
					'type'                    => $option['type']
				);
			}

			$product_data[] = array(
				'product_id' => $product['product_id'],
				'name'       => $product['name'],
				'model'      => $product['model'],
				'option'     => $option_data,
				'download'   => $product['download'],
				'quantity'   => $product['quantity'],
				'subtract'   => $product['subtract'],
				'price'      => $product['price'],
				'cost'       => $product['cost'],
				'total'      => $product['total'],
				'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
				'reward'     => $product['reward']
			);
		}

		// Gift Voucher
		$voucher_data = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$voucher_data[] = array(
					'description'      => $voucher['description'],
					'code'             => substr(md5(mt_rand()), 0, 10),
					'to_name'          => $voucher['to_name'],
					'to_email'         => $voucher['to_email'],
					'from_name'        => $voucher['from_name'],
					'from_email'       => $voucher['from_email'],
					'voucher_theme_id' => $voucher['voucher_theme_id'],
					'message'          => $voucher['message'],
					'amount'           => $voucher['amount']
				);
			}
		}

		$data['products'] = $product_data;
		$data['vouchers'] = $voucher_data;
		$data['totals'] = $total_data;

		if (isset($this->session->data['comment'])) {
			$data['comment'] = $this->session->data['comment'];
		} else {
			$data['comment'] = '';
		}

		$data['total'] = $total;

		if (isset($this->request->cookie['tracking'])) {
			$this->load->model('affiliate/affiliate');

			$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

			$subtotal = $this->cart->getSubTotal();

			if ($affiliate_info) {
				$data['affiliate_id'] = $affiliate_info['affiliate_id'];
				$data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
			} else {
				$data['affiliate_id'] = 0;
				$data['commission'] = 0;
			}

		} else {
			$data['affiliate_id'] = 0;
			$data['commission'] = 0;
		}

		$data['language_id'] = $this->config->get('config_language_id');

		$data['currency_id'] = $this->currency->getId();
		$data['currency_code'] = $this->currency->getCode();
		$data['currency_value'] = $this->currency->getValue($this->currency->getCode());

		$data['ip'] = $this->request->server['REMOTE_ADDR'];

		if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
			$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
		} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
			$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
		} else {
			$data['forwarded_ip'] = '';
		}

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
		} else {
			$data['user_agent'] = '';
		}

		if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
			$data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
		} else {
			$data['accept_language'] = '';
		}

		// Get tax breakdown
		if ($this->config->get('config_tax_breakdown')) {
			$this->data['tax_breakdown'] = true;
			$this->data['tax_colspan'] = 6;
		} else {
			$this->data['tax_breakdown'] = false;
			$this->data['tax_colspan'] = 4;
		}

		$this->load->model('checkout/order');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_tax_value'] = $this->language->get('column_tax_value');
		$this->data['column_tax_percent'] = $this->language->get('column_tax_percent');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['text_recurring_item'] = $this->language->get('text_recurring_item');
		$this->data['text_payment_profile'] = $this->language->get('text_payment_profile');

		$this->data['products'] = array();

		foreach ($this->cart->getProducts() as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$this->data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
			}

			// Option
			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['option_value'];
				} else {
					$filename = $this->encryption->decrypt($option['option_value']);

					$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
				}

				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
				);
			}

			// Display prices & totals
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
			} else {
				$price = false;
				$total = false;
			}

			$profile_description = '';

			if ($product['recurring']) {
				$frequencies = array(
					'day'        => $this->language->get('text_day'),
					'week'       => $this->language->get('text_week'),
					'semi_month' => $this->language->get('text_semi_month'),
					'month'      => $this->language->get('text_month'),
					'year'       => $this->language->get('text_year')
				);

				if ($product['recurring_trial']) {
					$recurring_price = $this->currency->format($this->tax->calculate($product['recurring_trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')));

					$profile_description = sprintf($this->language->get('text_trial_description'), $recurring_price, $product['recurring_trial_cycle'], $frequencies[$product['recurring_trial_frequency']], $product['recurring_trial_duration']) . ' ';
				}

				$recurring_price = $this->currency->format($this->tax->calculate($product['recurring_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')));

				if ($product['recurring_duration']) {
					$profile_description .= sprintf($this->language->get('text_payment_description'), $recurring_price, $product['recurring_cycle'], $frequencies[$product['recurring_frequency']], $product['recurring_duration']);
				} else {
					$profile_description .= sprintf($this->language->get('text_payment_until_canceled_description'), $recurring_price, $product['recurring_cycle'], $frequencies[$product['recurring_frequency']], $product['recurring_duration']);
				}
			}

			// Check minimum age
			$age_minimum = $product['age_minimum'];
			$age_logged = false;
			$age_checked = false;

			if ($this->config->get('config_customer_dob') && ($product['age_minimum'] > 0)) {
				if ($this->customer->isLogged() && $this->customer->isSecure()) {
					$age_logged = true;

					$this->load->model('account/customer');

					$date_of_birth = $this->model_account_customer->getCustomerDateOfBirth($this->customer->getId());

					if ($date_of_birth && ($date_of_birth != '0000-00-00')) {
						$customer_age = date_diff(date_create($date_of_birth), date_create('today'))->y;

						if ($customer_age >= $product['age_minimum']) {
							$age_checked = true;
						}
					}
				}
			}

			$product_tax_value = ($this->tax->calculate(($product['price'] * $product['quantity']), $product['tax_class_id'], $this->config->get('config_tax')) - ($product['price'] * $product['quantity']));

			$this->data['products'][] = array(
				'product_id'          => $product['product_id'],
				'key'                 => $product['key'],
				'name'                => $product['name'],
				'model'               => $product['model'],
				'option'              => $option_data,
				'download'            => $product['download'],
				'quantity'            => $product['quantity'],
				'stock'               => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
				'subtract'            => $product['subtract'],
				'price'               => $price,
				'cost'                => $product['cost'],
				'tax_value'           => $this->currency->format($product_tax_value),
				'tax_percent'         => number_format((($product_tax_value * 100) / (($product['price'] > 0) ? ($product['price'] * $product['quantity']) : $product['quantity'])), 2, '.', ''),
				'age_minimum'         => ($age_checked) ? '<span style="color:#007200;"> (' . $product['age_minimum'] . '+)</span>' : '',
				'recurring'           => $product['recurring'],
				'profile_name'        => $product['profile_name'],
				'profile_description' => $profile_description,
				'total'               => $total,
				'href'                => $this->url->link('product/product', 'product_id=' . $product['product_id'], 'SSL')
			);
		}

		$this->data['products_recurring'] = array();

		$this->data['age_minimum'] = ($age_minimum) ? (int)$age_minimum : 0;
		$this->data['age_logged'] = $age_logged;
		$this->data['age_checked'] = $age_checked;

		// Gift Voucher
		$this->data['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$this->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'])
				);
			}
		}

		$this->data['totals'] = $total_data;

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout_one_cart.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout_one_cart.tpl';
		} else {
			$this->template = 'default/template/checkout/checkout_one_cart.tpl';
		}

		$this->response->setOutput($this->render());
	}
}
