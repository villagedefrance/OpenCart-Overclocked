<?php
class ControllerCheckoutCheckoutOnePage extends Controller {
	private $error = array();

	public function index() {
		// Express checkout redirect
		if ($this->config->get('config_express_checkout')) {
			$this->redirect($this->url->link('checkout_express/checkout', '', 'SSL'));
		}

		if ($this->config->get('config_secure') && !$this->request->isSecure()) {
			$this->redirect($this->url->link('checkout/checkout_one_page', '', 'SSL'));
		}

		// Validate cart has products and has stock
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->redirect($this->url->link('checkout/cart', '', 'SSL'));
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
				$this->redirect($this->url->link('checkout/cart', '', 'SSL'));
			}

			// Validate minimum age
			if ($this->config->get('config_customer_dob') && ($product['age_minimum'] > 0)) {
				if (!$this->customer->isLogged() || !$this->customer->isSecure()) {
					$this->redirect($this->url->link('account/login', '', 'SSL'));
				}
			}
		}

		if (!isset($this->request->get['payment'])) {
			unset($this->session->data['order_id']);
			unset($this->session->data['check_shipping_address']);
		}

		if (isset($this->session->data['check_shipping_address'])) {
			$this->data['check_shipping_address'] = $this->session->data['check_shipping_address'];
		} else {
			$this->data['check_shipping_address'] = 1;
		}

		$this->language->load('checkout/checkout_one_page');
		$this->language->load('total/gift_wrapping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.min.css');
		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');

		// Coupon session
		if (isset($this->request->post['coupon']) && $this->validateCoupon()) {
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);

			$this->session->data['check_shipping_address'] = (isset($this->session->data['check_shipping_address'])) ? 1 : 0;

			$this->session->data['coupon'] = $this->request->post['coupon'];
			$this->session->data['success'] = $this->language->get('text_coupon');

			$this->redirect($this->url->link('checkout/checkout_one_page', '', 'SSL'));
		}

		// Voucher session
		if (!isset($this->session->data['vouchers'])) {
			$this->session->data['vouchers'] = array();
		}

		if (isset($this->request->post['voucher']) && $this->validateVoucher()) {
			unset($this->session->data['order_id']);
			unset($this->session->data['voucher']);

			$this->session->data['check_shipping_address'] = (isset($this->session->data['check_shipping_address'])) ? 1 : 0;

			$this->session->data['voucher'] = $this->request->post['voucher'];
			$this->session->data['success'] = $this->language->get('text_voucher');

			$this->redirect($this->url->link('checkout/checkout_one_page', '', 'SSL'));
		}

		// Reward session
		if (isset($this->request->post['reward']) && $this->validateReward()) {
			unset($this->session->data['order_id']);
			unset($this->session->data['reward']);

			$this->session->data['check_shipping_address'] = (isset($this->session->data['check_shipping_address'])) ? 1 : 0;

			$this->session->data['reward'] = abs($this->request->post['reward']);
			$this->session->data['success'] = $this->language->get('text_reward');

			$this->redirect($this->url->link('checkout/checkout_one_page', '', 'SSL'));
		}

		// Add Wrapping
		if (isset($this->request->post['add_wrapping'])) {
			unset($this->session->data['order_id']);

			$this->session->data['check_shipping_address'] = (isset($this->session->data['check_shipping_address'])) ? 1 : 0;

			$this->session->data['wrapping'] = $this->request->post['add_wrapping'];
			$this->session->data['success'] = $this->language->get('text_add_wrapping');

			$this->redirect($this->url->link('checkout/checkout_one_page', '', 'SSL'));
		}

		// Remove Wrapping
		if (isset($this->request->post['remove_wrapping'])) {
			unset($this->session->data['order_id']);
			unset($this->session->data['wrapping']);

			$this->session->data['check_shipping_address'] = (isset($this->session->data['check_shipping_address'])) ? 1 : 0;

			$this->session->data['success'] = $this->language->get('text_remove_wrapping');

			$this->redirect($this->url->link('checkout/checkout_one_page', '', 'SSL'));
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_cart'),
			'href'      => $this->url->link('checkout/cart', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('checkout/checkout_one_page', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];

			unset($this->session->data['order_id']);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('checkout/checkout_one_page', '', 'SSL');

		// Coupon
		$this->data['coupon_status'] = $this->config->get('coupon_status');

		if (isset($this->request->post['coupon'])) {
			$this->data['coupon'] = $this->request->post['coupon'];
		} elseif (isset($this->session->data['coupon'])) {
			$this->data['coupon'] = $this->session->data['coupon'];
		} else {
			$this->data['coupon'] = '';
		}

		// Gift Voucher
		$this->data['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$this->data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount']),
					'remove'      => $this->url->link('checkout/checkout_one_page', 'remove=' . $key, 'SSL')
				);
			}
		}

		$this->data['voucher_status'] = $this->config->get('voucher_status');

		if (isset($this->request->post['voucher'])) {
			$this->data['voucher'] = $this->request->post['voucher'];
		} elseif (isset($this->session->data['voucher'])) {
			$this->data['voucher'] = $this->session->data['voucher'];
		} else {
			$this->data['voucher'] = '';
		}

		// Reward
		$points_rate = $this->config->get('config_reward_rate') ? $this->config->get('config_reward_rate') : 1;

		$points = $this->customer->getRewardPoints();

		$points_total = 0;

		foreach ($this->cart->getProducts() as $product) {
			if ($product['points']) {
				$points_total += $product['points'];
			}
		}

		$max_points = min($points / $points_rate, $points_total);

		$sub_total = $this->cart->getSubTotal();

		if ($points && $max_points > $sub_total) {
			$reward_points = $sub_total;
		} else {
			$reward_points = $max_points;
		}

		if ($points && $points_total && $this->config->get('reward_status')) {
			$this->data['reward_point'] = true;
		} else {
			$this->data['reward_point'] = false;
		}

		if ($this->config->get('config_one_page_point') == 2) {
			$this->data['show_point'] = false;

			if ($points && $this->config->get('reward_status')) {
				$this->session->data['reward'] = $reward_points;
			}
		} elseif ($this->config->get('config_one_page_point') == 1) {
			$this->data['show_point'] = true;
		} else {
			$this->data['show_point'] = false;
		}

		if ($points && isset($this->session->data['reward'])) {
			$available_points = ($reward_points * $points_rate) - $this->session->data['reward'];
		} else {
			$available_points = ($reward_points * $points_rate);
		}

		if (isset($this->request->post['reward'])) {
			$this->data['reward'] = $this->request->post['reward'];
		} elseif (isset($this->session->data['reward'])) {
			$this->data['reward'] = $this->session->data['reward'];
		} else {
			$this->data['reward'] = '';
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_checkout_payment_address'] = $this->language->get('text_checkout_payment_address');
		$this->data['text_checkout_shipping_address'] = $this->language->get('text_checkout_shipping_address');
		$this->data['text_one_page_coupon'] = $this->language->get('text_one_page_coupon');
		$this->data['text_one_page_voucher'] = $this->language->get('text_one_page_voucher');
		$this->data['text_one_page_reward'] = sprintf($this->language->get('text_one_page_reward'), $available_points);

		$this->data['entry_coupon'] = $this->language->get('entry_coupon');
		$this->data['entry_voucher'] = $this->language->get('entry_voucher');
		$this->data['entry_reward'] = sprintf($this->language->get('entry_reward'), $available_points);

		$this->data['button_wrapping_add'] = $this->language->get('button_wrapping_add');
		$this->data['button_wrapping_remove'] = $this->language->get('button_wrapping_remove');
		$this->data['button_coupon'] = $this->language->get('button_coupon');
		$this->data['button_voucher'] = $this->language->get('button_voucher');
		$this->data['button_reward'] = $this->language->get('button_reward');

		$this->data['logged'] = $this->customer->isLogged();

		$this->data['shipping_required'] = $this->cart->hasShipping();

		$this->data['one_page_cart'] = $this->url->link('checkout/cart', '', 'SSL');

		$this->load->model('checkout/order');
		$this->load->model('account/address');
		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');

		// Insert order
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$customer_info = $this->request->post;

			if (!$this->customer->isLogged()) {
				$this->load->model('account/customer');
				$this->load->model('checkout/checkout_tools');

				if ($this->config->get('config_one_page_newsletter') == 1) {
					$newsletter = 1;
				} else {
					$newsletter = 0;
				}

				$customer_data = array();

				$customer_data['customer_group_id'] = $customer_info['customer_group_id'];
				$customer_data['firstname'] = $customer_info['firstname'];
				$customer_data['lastname'] = $customer_info['lastname'];
				$customer_data['email'] = $customer_info['email'];
				$customer_data['telephone'] = isset($customer_info['telephone']) ? $customer_info['telephone'] : '000';
				$customer_data['fax'] = isset($customer_info['fax']) ? $customer_info['fax'] : '000';
				$customer_data['gender'] = isset($customer_info['gender']) ? $customer_info['gender'] : 1;
				$customer_data['date_of_birth'] = isset($customer_info['date_of_birth']) ? $customer_info['date_of_birth'] : '0000-00-00';
				$customer_data['password'] = $this->model_checkout_checkout_tools->generatePassword();
				$customer_data['newsletter'] = $newsletter;
				$customer_data['company'] = $customer_info['company'];
				$customer_data['company_id'] = $customer_info['company_id'];
				$customer_data['tax_id'] = $customer_info['tax_id'];
				$customer_data['address_1'] = $customer_info['address_1'];
				$customer_data['address_2'] = $customer_info['address_2'];
				$customer_data['postcode'] = $customer_info['postcode'];
				$customer_data['city'] = $customer_info['city'];
				$customer_data['zone_id'] = $customer_info['zone_id'];
				$customer_data['country_id'] = $customer_info['country_id'];

				$this->model_account_customer->addCustomer($customer_data);

				$customer_status = $this->model_account_customer->getCustomerByEmail($customer_info['email']);

				if ($customer_status && !$customer_status['approved']) {
					$this->redirect($this->url->link('checkout/cart', '', 'SSL'));
				} else {
					$this->customer->login($customer_data['email'], $customer_data['password']);
				}
			}

			$data = array();

			if ($this->customer->isLogged()) {
				$data['customer_id'] = $this->customer->getId();
				$data['customer_group_id'] = $this->customer->getCustomerGroupId();
				$data['firstname'] = $this->customer->getFirstName();
				$data['lastname'] = $this->customer->getLastName();
				$data['email'] = $this->customer->getEmail();
				$data['telephone'] = $this->customer->getTelephone();
				$data['fax'] = $this->customer->getFax();
				$data['gender'] = $this->customer->getGender();
				$data['date_of_birth'] = $this->customer->getDateOfBirth();

				// Check address
				$default_address_id = $this->model_account_address->getDefaultAddressId($this->customer->getId());

				if ($default_address_id) {
					$customer_address = $this->model_account_address->getAddress($default_address_id);
				} else {
					$customer_address = array();

					$customer_address['customer_id'] = $this->customer->getId();
					$customer_address['firstname'] = $customer_info['firstname'];
					$customer_address['lastname'] = $customer_info['lastname'];
					$customer_address['company'] = $customer_info['company'];
					$customer_address['company_id'] = $customer_info['company_id'];
					$customer_address['tax_id'] = $customer_info['tax_id'];
					$customer_address['address_1'] = $customer_info['address_1'];
					$customer_address['address_2'] = $customer_info['address_2'];
					$customer_address['postcode'] = $customer_info['postcode'];
					$customer_address['city'] = $customer_info['city'];
					$customer_address['zone_id'] = $customer_info['zone_id'];
					$customer_address['country_id'] = $customer_info['country_id'];
					$customer_address['default'] = 1;

					$this->model_account_address->addAddress($customer_address);
				}
			}

			// Get country name
			$country_name_array = $this->model_localisation_country->getCountry($customer_info['country_id']);

			if ($country_name_array) {
				$country_name = $country_name_array['name'];
			} else {
				$country_name = '';
			}

			// Get zone name
			$zone_name_array = $this->model_localisation_zone->getZone($customer_info['zone_id']);

			if ($zone_name_array) {
				$zone_name = $zone_name_array['name'];
			} else {
				$zone_name = '';
			}

			$data['payment_firstname'] = $customer_info['firstname'];
			$data['payment_lastname'] = $customer_info['lastname'];
			$data['payment_company'] = $customer_info['company'];
			$data['payment_company_id'] = $customer_info['company_id'];
			$data['payment_tax_id'] = $customer_info['tax_id'];
			$data['payment_address_1'] = $customer_info['address_1'];
			$data['payment_address_2'] = $customer_info['address_2'];
			$data['payment_city'] = $customer_info['city'];
			$data['payment_postcode'] = $customer_info['postcode'];
			$data['payment_zone'] = $zone_name;
			$data['payment_zone_id'] = $customer_info['zone_id'];
			$data['payment_country'] = $country_name;
			$data['payment_country_id'] = $customer_info['country_id'];
			$data['payment_address_format'] = '';

			if (isset($this->session->data['payment_methods'])) {
				$data['payment_methods'] = $this->session->data['payment_methods'];
			} else {
				$data['payment_methods'] = array();
			}

			if (isset($this->session->data['payment_method']['title'])) {
				$data['payment_method'] = $this->session->data['payment_method']['title'];
			} elseif (isset($customer_info['payment_method'])) {
				$data['payment_method'] = $customer_info['payment_method'];
			} else {
				$data['payment_method'] = '';
			}

			if (isset($this->session->data['payment_method']['code'])) {
				$data['payment_code'] = $this->session->data['payment_method']['code'];
			} elseif (isset($customer_info['code'])) {
				$data['payment_code'] = $customer_info['code'];
			} else {
				$data['payment_code'] = '';
			}

			// Shipping
			if (isset($customer_info['check_shipping_address'])) {
				$data['shipping_firstname'] = $customer_info['firstname'];
				$data['shipping_lastname'] = $customer_info['lastname'];
				$data['shipping_company'] = $customer_info['company'];
				$data['shipping_address_1'] = $customer_info['address_1'];
				$data['shipping_address_2'] = $customer_info['address_2'];
				$data['shipping_city'] = $customer_info['city'];
				$data['shipping_postcode'] = $customer_info['postcode'];
				$data['shipping_zone'] = $zone_name;
				$data['shipping_zone_id'] = $customer_info['zone_id'];
				$data['shipping_country'] = $country_name;
				$data['shipping_country_id'] = $customer_info['country_id'];
				$data['shipping_address_format'] = '';

				$this->session->data['check_shipping_address'] = 1;

			} else {
				// Get shipping country name
				$shipping_country_name_array = $this->model_localisation_country->getCountry((int)$customer_info['shipping_country_id']);

				if ($shipping_country_name_array) {
					$shipping_country_name = $shipping_country_name_array['name'];
				} else {
					$shipping_country_name = '';
				}

				// Get shipping zone name
				$shipping_zone_name_array = $this->model_localisation_zone->getZone((int)$customer_info['shipping_zone_id']);

				if ($shipping_zone_name_array) {
					$shipping_zone_name = $shipping_zone_name_array['name'];
				} else {
					$shipping_zone_name = '';
				}

				$data['shipping_firstname'] = $customer_info['shipping_firstname'];
				$data['shipping_lastname'] = $customer_info['shipping_lastname'];
				$data['shipping_company'] = $customer_info['shipping_company'];
				$data['shipping_address_1'] = $customer_info['shipping_address_1'];
				$data['shipping_address_2'] = $customer_info['shipping_address_2'];
				$data['shipping_city'] = $customer_info['shipping_city'];
				$data['shipping_postcode'] = $customer_info['shipping_postcode'];
				$data['shipping_zone'] = $shipping_zone_name;
				$data['shipping_zone_id'] = $customer_info['shipping_zone_id'];
				$data['shipping_country'] = $shipping_country_name;
				$data['shipping_country_id'] = $customer_info['shipping_country_id'];
				$data['shipping_address_format'] = '';

				$this->session->data['check_shipping_address'] = 0;
			}

			if (isset($this->session->data['shipping_methods'])) {
				$data['shipping_methods'] = $this->session->data['shipping_methods'];
			} else {
				$data['shipping_methods'] = array();
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

			// Validate minimum quantity requirements.
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
			$data['comment'] = $customer_info['comment'];
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

			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');

			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');
			} else {
				$data['store_url'] = HTTP_SERVER;
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

			if (isset($this->session->data['order_id'])) {
				unset($this->session->data['order_id']);
			}

			$this->session->data['order_id'] = $this->model_checkout_order->addOrder($data);

			$this->redirect($this->url->link('checkout/checkout_one_page', 'payment=1', 'SSL'));
		}

		// Guest
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_female'] = $this->language->get('text_female');
		$this->data['text_male'] = $this->language->get('text_male');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_comments'] = $this->language->get('text_comments');

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
		$this->data['entry_shipping'] = $this->language->get('entry_shipping');

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['gender'] = 0;

		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		if (isset($this->error['exists'])) {
			$this->data['error_email'] = $this->error['exists'];
		} else {
			$this->data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}

		if (isset($this->error['date_of_birth'])) {
			$this->data['error_date_of_birth'] = $this->error['date_of_birth'];
		} else {
			$this->data['error_date_of_birth'] = '';
		}

		if (isset($this->error['company_id'])) {
			$this->data['error_company_id'] = $this->error['company_id'];
		} else {
			$this->data['error_company_id'] = '';
		}

		if (isset($this->error['tax_id'])) {
			$this->data['error_tax_id'] = $this->error['tax_id'];
		} else {
			$this->data['error_tax_id'] = '';
		}

		if (isset($this->error['address_1'])) {
			$this->data['error_address_1'] = $this->error['address_1'];
		} else {
			$this->data['error_address_1'] = '';
		}

		if (isset($this->error['city'])) {
			$this->data['error_city'] = $this->error['city'];
		} else {
			$this->data['error_city'] = '';
		}

		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$this->data['error_country'] = $this->error['country'];
		} else {
			$this->data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$this->data['error_zone'] = $this->error['zone'];
		} else {
			$this->data['error_zone'] = '';
		}

		// Shipping errors
		if (isset($this->error['shipping_firstname'])) {
			$this->data['error_shipping_firstname'] = $this->error['shipping_firstname'];
		} else {
			$this->data['error_shipping_firstname'] = '';
		}

		if (isset($this->error['shipping_lastname'])) {
			$this->data['error_shipping_lastname'] = $this->error['shipping_lastname'];
		} else {
			$this->data['error_shipping_lastname'] = '';
		}

		if (isset($this->error['shipping_address_1'])) {
			$this->data['error_shipping_address_1'] = $this->error['shipping_address_1'];
		} else {
			$this->data['error_shipping_address_1'] = '';
		}

		if (isset($this->error['shipping_city'])) {
			$this->data['error_shipping_city'] = $this->error['shipping_city'];
		} else {
			$this->data['error_shipping_city'] = '';
		}

		if (isset($this->error['shipping_postcode'])) {
			$this->data['error_shipping_postcode'] = $this->error['shipping_postcode'];
		} else {
			$this->data['error_shipping_postcode'] = '';
		}

		if (isset($this->error['shipping_country'])) {
			$this->data['error_shipping_country'] = $this->error['shipping_country'];
		} else {
			$this->data['error_shipping_country'] = '';
		}

		if (isset($this->error['shipping_zone'])) {
			$this->data['error_shipping_zone'] = $this->error['shipping_zone'];
		} else {
			$this->data['error_shipping_zone'] = '';
		}

		// Shipping options
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->data['check_shipping_address'] = isset($this->request->post['check_shipping_address']) ? 1 : 0;
		} elseif (isset($this->session->data['check_shipping_address'])) {
			$this->data['check_shipping_address'] = $this->session->data['check_shipping_address'];
		} else {
			$this->data['check_shipping_address'] = 1;
		}

		if (isset($this->error['shipping_method'])) {
			$this->data['error_shipping_method'] = $this->error['shipping_method'];
		} else {
			$this->data['error_shipping_method'] = '';
		}

		if (isset($this->error['payment_method'])) {
			$this->data['error_payment_method'] = $this->error['payment_method'];
		} else {
			$this->data['error_payment_method'] = '';
		}

		if (isset($this->error['agree'])) {
			$this->data['error_agree'] = $this->error['agree'];
		} else {
			$this->data['error_agree'] = '';
		}

		// Customer options
		if ($this->customer->isLogged() && $this->customer->isSecure()) {
			$default_address_id = $this->model_account_address->getDefaultAddressId($this->customer->getId());

			if ($default_address_id) {
				$customer_address = $this->model_account_address->getAddress($default_address_id);
			} else {
				$customer_address = 0;
			}
		}

		if (isset($this->session->data['order_id'])) {
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		}

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif ($this->customer->isLogged()) {
			$this->data['firstname'] = $this->customer->getFirstName();
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif ($this->customer->isLogged()) {
			$this->data['lastname'] = $this->customer->getLastName();
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif ($this->customer->isLogged()) {
			$this->data['email'] = $this->customer->getEmail();
		} else {
			$this->data['email'] = '';
		}

		$this->data['one_page_phone'] = $this->config->get('config_one_page_phone');

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} elseif ($this->customer->isLogged()) {
			$this->data['telephone'] = $this->customer->getTelephone();
		} else {
			$this->data['telephone'] = '';
		}

		$this->data['one_page_fax'] = $this->config->get('config_customer_fax');

		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif ($this->customer->isLogged()) {
			$this->data['fax'] = $this->customer->getFax();
		} else {
			$this->data['fax'] = '';
		}

		$this->data['one_page_gender'] = $this->config->get('config_customer_gender');

		if (isset($this->request->post['gender'])) {
			$this->data['gender'] = $this->request->post['gender'];
		} elseif ($this->customer->isLogged()) {
			$this->data['gender'] = $this->customer->getGender();
		} else {
			$this->data['gender'] = 0;
		}

		$this->data['one_page_dob'] = $this->config->get('config_customer_dob');

		if (isset($this->request->post['date_of_birth'])) {
			$this->data['date_of_birth'] = $this->request->post['date_of_birth'];
		} elseif ($this->customer->isLogged()) {
			$this->data['date_of_birth'] = $this->customer->getDateOfBirth();
		} else {
			$this->data['date_of_birth'] = '';
		}

		if (isset($this->request->post['company'])) {
			$this->data['company'] = $this->request->post['company'];
		} elseif (isset($customer_address) && $customer_address['company']) {
			$this->data['company'] = $customer_address['company'];
		} else {
			$this->data['company'] = '';
		}

		$this->load->model('account/customer_group');

		$this->data['customer_groups'] = array();

		if (is_array($this->config->get('config_customer_group_display'))) {
			$customer_groups = $this->model_account_customer_group->getCustomerGroups();

			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$this->data['customer_groups'][] = $customer_group;
				}
			}
		}

		if (isset($this->request->post['customer_group_id'])) {
			$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} elseif ($this->customer->isLogged()) {
			$this->data['customer_group_id'] = $this->customer->getCustomerGroupId();
		} else {
			$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}

		// Company ID
		if (isset($this->request->post['company_id'])) {
			$this->data['company_id'] = $this->request->post['company_id'];
		} elseif (isset($customer_address) && $customer_address['company_id']) {
			$this->data['company_id'] = $customer_address['company_id'];
		} else {
			$this->data['company_id'] = '';
		}

		// Tax ID
		if (isset($this->request->post['tax_id'])) {
			$this->data['tax_id'] = $this->request->post['tax_id'];
		} elseif (isset($customer_address) && $customer_address['tax_id']) {
			$this->data['tax_id'] = $customer_address['tax_id'];
		} else {
			$this->data['tax_id'] = '';
		}

		// Address
		if (isset($this->request->post['address_1'])) {
			$this->data['address_1'] = $this->request->post['address_1'];
		} elseif (isset($customer_address) && $customer_address['address_1']) {
			$this->data['address_1'] = $customer_address['address_1'];
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$this->data['address_2'] = $this->request->post['address_2'];
		} elseif (isset($customer_address) && $customer_address['address_2']) {
			$this->data['address_2'] = $customer_address['address_2'];
		} else {
			$this->data['address_2'] = '';
		}

		if (isset($this->request->post['city'])) {
			$this->data['city'] = $this->request->post['city'];
		} elseif (isset($customer_address) && $customer_address['city']) {
			$this->data['city'] = $customer_address['city'];
		} else {
			$this->data['city'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$this->data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($customer_address) && $customer_address['postcode']) {
			$this->data['postcode'] = $customer_address['postcode'];
		} else {
			$this->data['postcode'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$this->data['country_id'] = $this->request->post['country_id'];
		} elseif (isset($customer_address) && $customer_address['country_id']) {
			$this->data['country_id'] = $customer_address['country_id'];
		} else {
			$this->data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['zone_id'])) {
			$this->data['zone_id'] = $this->request->post['zone_id'];
		} elseif (isset($customer_address) && $customer_address['zone_id']) {
			$this->data['zone_id'] = $customer_address['zone_id'];
		} else {
			$this->data['zone_id'] = '';
		}

		// Get country name
		$country_name_array = $this->model_localisation_country->getCountry((int)$this->data['country_id']);

		if ($country_name_array) {
			$this->data['country_name'] = $country_name_array['name'];
		} else {
			$this->data['country_name'] = '';
		}

		// Get zone name
		$zone_name_array = $this->model_localisation_zone->getZone((int)$this->data['zone_id']);

		if ($zone_name_array) {
			$this->data['zone_name'] = $zone_name_array['name'];
		} else {
			$this->data['zone_name'] = '';
		}

		// Check shipping address
		if (isset($this->request->post['shipping_firstname'])) {
			$this->data['shipping_firstname'] = $this->request->post['shipping_firstname'];
		} elseif (isset($order_info) && $order_info['shipping_firstname']) {
			$this->data['shipping_firstname'] = $order_info['shipping_firstname'];
		} else {
			$this->data['shipping_firstname'] = '';
		}

		if (isset($this->request->post['shipping_lastname'])) {
			$this->data['shipping_lastname'] = $this->request->post['shipping_lastname'];
		} elseif (isset($order_info) && $order_info['shipping_lastname']) {
			$this->data['shipping_lastname'] = $order_info['shipping_lastname'];
		} else {
			$this->data['shipping_lastname'] = '';
		}

		if (isset($this->request->post['shipping_company'])) {
			$this->data['shipping_company'] = $this->request->post['shipping_company'];
		} elseif (isset($order_info) && $order_info['shipping_company']) {
			$this->data['shipping_company'] = $order_info['shipping_company'];
		} else {
			$this->data['shipping_company'] = '';
		}

		if (isset($this->request->post['shipping_address_1'])) {
			$this->data['shipping_address_1'] = $this->request->post['shipping_address_1'];
		} elseif (isset($order_info) && $order_info['shipping_address_1']) {
			$this->data['shipping_address_1'] = $order_info['shipping_address_1'];
		} else {
			$this->data['shipping_address_1'] = '';
		}

		if (isset($this->request->post['shipping_address_2'])) {
			$this->data['shipping_address_2'] = $this->request->post['shipping_address_2'];
		} elseif (isset($order_info) && $order_info['shipping_address_2']) {
			$this->data['shipping_address_2'] = $order_info['shipping_address_2'];
		} else {
			$this->data['shipping_address_2'] = '';
		}

		if (isset($this->request->post['shipping_city'])) {
			$this->data['shipping_city'] = $this->request->post['shipping_city'];
		} elseif (isset($order_info) && $order_info['shipping_city']) {
			$this->data['shipping_city'] = $order_info['shipping_city'];
		} else {
			$this->data['shipping_city'] = '';
		}

		if (isset($this->request->post['shipping_postcode'])) {
			$this->data['shipping_postcode'] = $this->request->post['shipping_postcode'];
		} elseif (isset($order_info) && $order_info['shipping_postcode']) {
			$this->data['shipping_postcode'] = $order_info['shipping_postcode'];
		} else {
			$this->data['shipping_postcode'] = '';
		}

		if (isset($this->request->post['shipping_country_id'])) {
			$this->data['shipping_country_id'] = $this->request->post['shipping_country_id'];
		} elseif (isset($order_info) && $order_info['shipping_country_id']) {
			$this->data['shipping_country_id'] = $order_info['shipping_country_id'];
		} else {
			$this->data['shipping_country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['shipping_zone_id'])) {
			$this->data['shipping_zone_id'] = $this->request->post['shipping_zone_id'];
		} elseif (isset($order_info) && $order_info['shipping_zone_id']) {
			$this->data['shipping_zone_id'] = $order_info['shipping_zone_id'];
		} else {
			$this->data['shipping_zone_id'] = '';
		}

		// Get shipping country name
		$shipping_country_name_array = $this->model_localisation_country->getCountry((int)$this->data['shipping_country_id']);

		if ($shipping_country_name_array) {
			$this->data['shipping_country_name'] = $shipping_country_name_array['name'];
		} else {
			$this->data['shipping_country_name'] = '';
		}

		// Get shipping zone name
		$shipping_zone_name_array = $this->model_localisation_zone->getZone((int)$this->data['shipping_zone_id']);

		if ($shipping_zone_name_array) {
			$this->data['shipping_zone_name'] = $shipping_zone_name_array['name'];
		} else {
			$this->data['shipping_zone_name'] = '';
		}

		// Comment
		if (isset($this->request->post['comment'])) {
			$this->data['comment'] = $this->request->post['comment'];
		} elseif (isset($order_info) && $order_info['comment']) {
			$this->data['comment'] = $order_info['comment'];
		} else {
			$this->data['comment'] = '';
		}

		// Terms and Conditions
		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_checkout_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}

		} else {
			$this->data['text_agree'] = '';
		}

		if (isset($this->request->post['agree']) && $this->config->get('config_checkout_id')) {
			$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = '';
		}

		$this->data['countries'] = $this->model_localisation_country->getCountries();

		$this->data['shipping_required'] = $this->cart->hasShipping();

		// Shipping data
		$data = array();

		$data['firstname'] = $this->data['firstname'];
		$data['lastname'] = $this->data['lastname'];
		$data['company'] = $this->data['company'];
		$data['company_id'] = $this->data['company_id'];
		$data['tax_id'] = $this->data['tax_id'];
		$data['address_1'] = $this->data['address_1'];
		$data['address_2'] = $this->data['address_2'];
		$data['city'] = $this->data['city'];
		$data['postcode'] = $this->data['postcode'];
		$data['zone'] = $this->data['zone_name'];
		$data['zone_id'] = $this->data['zone_id'];
		$data['country'] = $this->data['country_name'];
		$data['country_id'] = $this->data['country_id'];

		$payment_address = $data;

		if (isset($this->request->post['check_shipping_address'])) {
			$data_shipping = array();

			$data_shipping['firstname'] = $this->data['firstname'];
			$data_shipping['lastname'] = $this->data['lastname'];
			$data_shipping['company'] = $this->data['company'];
			$data_shipping['address_1'] = $this->data['address_1'];
			$data_shipping['address_2'] = $this->data['address_2'];
			$data_shipping['city'] = $this->data['city'];
			$data_shipping['postcode'] = $this->data['postcode'];
			$data_shipping['zone'] = $this->data['zone_name'];
			$data_shipping['zone_id'] = $this->data['zone_id'];
			$data_shipping['country'] = $this->data['country_name'];
			$data_shipping['country_id'] = $this->data['country_id'];
			$data_shipping['address_format'] = '';

			$shipping_address = $data_shipping;

		} else {
			$data_shipping = array();

			$data_shipping['firstname'] = $this->data['shipping_firstname'];
			$data_shipping['lastname'] = $this->data['shipping_lastname'];
			$data_shipping['company'] = $this->data['shipping_company'];
			$data_shipping['address_1'] = $this->data['shipping_address_1'];
			$data_shipping['address_2'] = $this->data['shipping_address_2'];
			$data_shipping['city'] = $this->data['shipping_city'];
			$data_shipping['postcode'] = $this->data['shipping_postcode'];
			$data_shipping['zone'] = $this->data['shipping_zone_name'];
			$data_shipping['zone_id'] = $this->data['shipping_zone_id'];
			$data_shipping['country'] = $this->data['shipping_country_name'];
			$data_shipping['country_id'] = $this->data['shipping_country_id'];
			$data_shipping['address_format'] = '';

			$shipping_address = $data_shipping;
		}

		// Shipping methods
		$quote_data = array();

		$this->load->model('setting/extension');

		$results = $this->model_setting_extension->getExtensions('shipping');

		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('shipping/' . $result['code']);

				$quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address);

				if ($quote) {
					$quote_data[$result['code']] = array(
						'title'      => $quote['title'],
						'quote'      => $quote['quote'],
						'sort_order' => $quote['sort_order'],
						'error'      => $quote['error']
					);
				}
			}
		}

		$sort_order = array();

		foreach ($quote_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $quote_data);

		$this->data['shipping_methods'] = $quote_data;

		$this->session->data['shipping_methods'] = $this->data['shipping_methods'];

		if (isset($this->session->data['shipping_method']) && $this->session->data['shipping_method']) {
			$this->data['shipping_method_code'] = $this->session->data['shipping_method']['code'];
		} else {
			$this->data['shipping_method_code'] = '';
		}

		// Payment methods
		if (!empty($payment_address)) {
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

			$method_data = array();

			$results = $this->model_setting_extension->getExtensions('payment');

			$cart_has_recurring = $this->cart->hasRecurringProducts();

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('payment/' . $result['code']);

					$method = $this->{'model_payment_' . $result['code']}->getMethod($payment_address, $total);

					if ($method) {
						if ($cart_has_recurring > 0) {
							if (method_exists($this->{'model_payment_' . $result['code']}, 'recurringPayments')) {
								if ($this->{'model_payment_' . $result['code']}->recurringPayments() == true) {
									$method_data[$result['code']] = $method;
								}
							}
						} else {
							$method_data[$result['code']] = $method;
						}
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);

			$this->data['payment_methods'] = $method_data;

			$this->session->data['payment_methods'] = $this->data['payment_methods'];
		}

		// Image
		$this->load->model('design/payment');
		$this->load->model('tool/image');

		$this->data['payment_images'] = array();

		$image_results = $this->model_design_payment->getPaymentImages(0);

		if ($image_results) {
			foreach ($image_results as $image_result) {
				if ($image_result['image'] && file_exists(DIR_IMAGE . $image_result['image'])) {
					$method_image = $this->model_tool_image->resize($image_result['image'], 140, 35);
				} else {
					$method_image = '';
				}

				$this->data['payment_images'][] = array(
					'payment' => strtolower($image_result['payment']),
					'image'   => $method_image,
					'status'  => $image_result['status']
				);
			}
		}

		// Paypal Fee
		$paypal_fee = 0;
		$paypal_fee_total = $this->config->get('paypal_fee_total');

		if (empty($paypal_fee_total) || ($this->cart->getTotal() < $paypal_fee_total)) {
			if ($this->config->get('paypal_fee_fee_type') == 'F') {
				$paypal_fee = $this->config->get('paypal_fee_fee');
			} else {
				$paypal_fee = ($this->cart->getTotal() * $this->config->get('paypal_fee_fee')) / 100;

				$min = $this->config->get('paypal_fee_fee_min');
				$max = $this->config->get('paypal_fee_fee_max');

				if (!empty($min) && ($paypal_fee < $min)) {
					$paypal_fee = $min;
				}

				if (!empty($max) && ($paypal_fee > $max)) {
					$paypal_fee = $max;
				}
			}
		}

		$this->data['paypal_fee'] = ($paypal_fee > 0) ? $this->currency->format($paypal_fee) : false;

		if (isset($this->session->data['payment_method'])) {
			$this->data['payment_method_code'] = $this->session->data['payment_method']['code'];
		} else {
			$this->data['payment_method_code'] = '';
		}

		// Gift Wrapping
		if ($this->config->get('gift_wrapping_status')) {
			$this->data['wrapping_status'] = $this->config->get('gift_wrapping_status');
		} else {
			$this->data['wrapping_status'] = 0;
		}

		if (isset($this->request->post['wrapping'])) {
			$this->data['wrapping'] = $this->request->post['wrapping'];
		} elseif (isset($this->session->data['wrapping'])) {
			$this->data['wrapping'] = $this->session->data['wrapping'];
		} else {
			$this->data['wrapping'] = '';
		}

		if (isset($this->request->get['quickconfirm'])) {
			$this->data['quickconfirm'] = $this->request->get['quickconfirm'];
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout_one_page.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout_one_page.tpl';
		} else {
			$this->template = 'default/template/checkout/checkout_one_page.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_header',
			'common/content_top',
			'common/content_bottom',
			'common/content_footer',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}

	public function validate() {
		if (isset($this->request->post['coupon']) || isset($this->request->post['voucher']) || isset($this->request->post['reward']) || isset($this->request->post['wrapping']) || isset($this->request->post['refresh'])) {
			return;
		}

		$this->language->load('checkout/checkout_one_page');

		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if (isset($this->request->post['email'])) {
			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
				$this->error['email'] = $this->language->get('error_email');
			}

			// Email exists check
			if (!$this->customer->isLogged()) {
				$this->load->model('account/customer');

				if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
					$this->error['exists'] = $this->language->get('error_exists');
				}
			}

			// Email MX Record check
			$this->load->model('tool/email');

			$email_valid = $this->model_tool_email->verifyMail($this->request->post['email']);

			if (!$email_valid) {
				$this->error['email'] = $this->language->get('error_email');
			}
		}

		if ($this->config->get('config_one_page_phone')) {
			if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
				$this->error['telephone'] = $this->language->get('error_telephone');
			}
		}

		if ($this->config->get('config_customer_dob')) {
			if (isset($this->request->post['date_of_birth']) && (utf8_strlen($this->request->post['date_of_birth']) == 10)) {
				if ($this->request->post['date_of_birth'] != date('Y-m-d', strtotime($this->request->post['date_of_birth']))) {
					$this->error['date_of_birth'] = $this->language->get('error_date_of_birth');
				}
			} else {
				$this->error['date_of_birth'] = $this->language->get('error_date_of_birth');
			}
		}

		// Customer Group
		$this->load->model('account/customer_group');

		if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

		if ($customer_group) {
			// Company ID
			if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && empty($this->request->post['company_id'])) {
				$this->error['company_id'] = $this->language->get('error_company_id');
			}

			// Tax ID
			if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && empty($this->request->post['tax_id'])) {
				$this->error['tax_id'] = $this->language->get('error_tax_id');
			}
		}

		if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

		if ($country_info) {
			if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
				$this->error['postcode'] = $this->language->get('error_postcode');
			}

			// VAT Validation
			if ($customer_group && $customer_group['tax_id_display']) {
				$this->load->helper('vat');

				if ($this->config->get('config_vat') && $this->request->post['tax_id'] != '' && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
					$this->error['tax_id'] = $this->language->get('error_vat');
				}
			}
		}

		if (!isset($this->request->post['country_id']) || $this->request->post['country_id'] == '') {
			$this->error['country'] = $this->language->get('error_country');
		}

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
			$this->error['zone'] = $this->language->get('error_zone');
		}

		if (!isset($this->request->post['check_shipping_address'])) {
			if ((utf8_strlen($this->request->post['shipping_firstname']) < 1) || (utf8_strlen($this->request->post['shipping_firstname']) > 32)) {
				$this->error['shipping_firstname'] = $this->language->get('error_firstname');
			}

			if ((utf8_strlen($this->request->post['shipping_lastname']) < 1) || (utf8_strlen($this->request->post['shipping_lastname']) > 32)) {
				$this->error['shipping_lastname'] = $this->language->get('error_lastname');
			}

			if ((utf8_strlen($this->request->post['shipping_address_1']) < 3) || (utf8_strlen($this->request->post['shipping_address_1']) > 128)) {
				$this->error['shipping_address_1'] = $this->language->get('error_address_1');
			}

			if ((utf8_strlen($this->request->post['shipping_city']) < 2) || (utf8_strlen($this->request->post['shipping_city']) > 128)) {
				$this->error['shipping_city'] = $this->language->get('error_city');
			}

			if ($this->request->post['shipping_country_id'] == '') {
				$this->error['shipping_country'] = $this->language->get('error_country');
			}

			if (!isset($this->request->post['shipping_zone_id']) || $this->request->post['shipping_zone_id'] == '') {
				$this->error['shipping_zone'] = $this->language->get('error_zone');
			}
		}

		if (!isset($this->session->data['shipping_method']) || empty($this->session->data['shipping_method'])) {
			$this->error['shipping_method'] = $this->language->get('error_shipping');
		}

		if (!isset($this->session->data['payment_method']) || empty($this->session->data['payment_method'])) {
			$this->error['payment_method'] = $this->language->get('error_payment');
		}

		if (!isset($this->request->post['agree']) && $this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ($information_info) {
				$this->error['agree'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			} else {
				$this->error['agree'] = sprintf($this->language->get('error_agree'), '');
			}
		}

		return empty($this->error);
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function shippingMethod() {
		$json = array();

		if (isset($this->request->post['shipping_method'])) {
			$shipping = explode('.', $this->request->post['shipping_method']);

			$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
		} else {
			$this->session->data['shipping_method'] = '';
		}

		$json['code'] = $this->session->data['shipping_method']['title'];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function paymentMethod() {
		$json = array();

		if (isset($this->request->post['payment_method'])) {
			$payment = $this->request->post['payment_method'];

			$this->session->data['payment_method'] = $this->session->data['payment_methods'][$payment];
		} else {
			$this->session->data['payment_method'] = '';
		}

		$json['code'] = $this->session->data['payment_method']['title'];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function checkoutSubmit() {
		$json = array();

		if (isset($this->session->data['payment_method']['code']) && isset($this->session->data['order_id'])) {
			$json['payment'] = $this->getChild('payment/' . $this->session->data['payment_method']['code']);
		} else {
			$json['payment'] = '';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validateCoupon() {
		$this->load->model('checkout/coupon');

		$coupon_info = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);

		if (!$coupon_info) {
			$this->error['warning'] = $this->language->get('error_coupon');
		}

		return empty($this->error);
	}

	protected function validateVoucher() {
		$this->load->model('checkout/voucher');

		$voucher_info = $this->model_checkout_voucher->getVoucher($this->request->post['voucher']);

		if (!$voucher_info) {
			$this->error['warning'] = $this->language->get('error_voucher');
		}

		return empty($this->error);
	}

	protected function validateReward() {
		$points_rate = $this->config->get('config_reward_rate');

		$points = $this->customer->getRewardPoints();

		$points_total = 0;

		foreach ($this->cart->getProducts() as $product) {
			if ($product['points']) {
				$points_total += $product['points'];
			}
		}

		$max_points = min($points / $points_rate, $points_total);

		$sub_total = $this->cart->getSubTotal();

		if ($points && $max_points > $sub_total) {
			$reward_points = $sub_total;
		} else {
			$reward_points = $max_points;
		}

		if (empty($this->request->post['reward'])) {
			$this->error['warning'] = $this->language->get('error_reward');
		}

		if ($this->request->post['reward'] > $points) {
			$this->error['warning'] = sprintf($this->language->get('error_points'), $this->request->post['reward']);
		}

		if ($this->request->post['reward'] > ($reward_points * $points_rate)) {
			$this->error['warning'] = sprintf($this->language->get('error_maximum'), $reward_points * $points_rate);
		}

		return empty($this->error);
	}
}
