<?php
class ControllerPaymentPPExpress extends Controller {

	protected function index() {
		$this->language->load('payment/pp_express');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_express_login'] = $this->language->get('button_express_login');
		$this->data['button_continue_action'] = $this->url->link('payment/pp_express/checkout', '', 'SSL');

		// If there is any other paypal session data, clear it
		unset($this->session->data['paypal']);

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_express.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/pp_express.tpl';
		} else {
			$this->template = 'default/template/payment/pp_express.tpl';
		}

		$this->render();
	}

	public function express() {
		$this->language->load('payment/pp_express');

		$this->load->model('payment/pp_express');

		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->redirect($this->url->link('checkout/cart', '', 'SSL'));
		}

		if ($this->customer->isLogged()) {
			// If the customer is already logged in
			$this->session->data['paypal']['guest'] = false;

			unset($this->session->data['guest']);

		} else {
			if ($this->config->get('config_guest_checkout') && !$this->config->get('config_customer_price') && !$this->cart->hasDownload() && !$this->cart->hasRecurringProducts()) {
				// If the guest checkout is allowed (config ok, no login for price and doesn't have downloads)
				$this->session->data['paypal']['guest'] = true;

			} else {
				// If guest checkout disabled or login is required before price or order has downloads, send them to the normal checkout flow
				unset($this->session->data['guest']);

				$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
			}
		}

		unset($this->session->data['shipping_method']);
		unset($this->session->data['shipping_methods']);
		unset($this->session->data['payment_method']);
		unset($this->session->data['payment_methods']);

		$this->load->model('tool/image');

		if ($this->cart->hasShipping()) {
			$shipping = 2;
		} else {
			$shipping = 1;
		}

		$max_amount = $this->currency->convert($this->cart->getTotal(), $this->config->get('config_currency'), 'USD');
		$max_amount = min($max_amount * 1.5, 10000);
		$max_amount = $this->currency->format($max_amount, $this->currency->getCode(), '', false);

		$request = array(
			'METHOD'             => 'SetExpressCheckout',
			'MAXAMT'             => $max_amount,
			'RETURNURL'          => $this->url->link('payment/pp_express/expressReturn', '', 'SSL'),
			'CANCELURL'          => $this->url->link('checkout/cart', '', 'SSL'),
			'REQCONFIRMSHIPPING' => 0,
			'NOSHIPPING'         => $shipping,
			'ALLOWNOTE'          => $this->config->get('pp_express_allow_note'),
			'LOCALECODE'         => 'EN',
			'LANDINGPAGE'        => 'Login',
			'HDRIMG'             => $this->model_tool_image->resize($this->config->get('pp_express_logo'), 750, 90),
			'HDRBORDERCOLOR'     => $this->config->get('pp_express_border_colour'),
			'HDRBACKCOLOR'       => $this->config->get('pp_express_header_colour'),
			'PAYFLOWCOLOR'       => $this->config->get('pp_express_page_colour'),
			'CHANNELTYPE'        => 'Merchant'
		);

		$request = array_merge($request, $this->model_payment_pp_express->paymentRequestInfo());

		$response = $this->model_payment_pp_express->call($request);

		if ($response === false) {
			$this->session->data['error'] = $this->language->get('error_connection');

		} elseif (is_array($response) && isset($response['TOKEN'])) {
			$this->session->data['paypal']['token'] = $response['TOKEN'];

			if ($this->config->get('pp_express_test') == 1) {
				header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $response['TOKEN']);
			} else {
				header('Location: https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $response['TOKEN']);
			}

		} else {
			// If a failed PayPal setup happens, handle it.
			$this->session->data['error'] = (isset($response['L_SHORTMESSAGE0']) ? $response['L_SHORTMESSAGE0'] : $this->language->get('error_general')) . (isset($response['L_LONGMESSAGE0']) ? '<br />' . $response['L_LONGMESSAGE0'] : '');
			// Unable to add error message to user as the session errors/success are not used on the cart or checkout pages - need to be added ?
			// If PayPal debug log is off, then still log error to normal error log.
			$this->model_payment_pp_express->log($response, 'Unable to create PayPal call', true);
		}

		$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
	}

	public function expressReturn() {
		// This is the url when PayPal has completed the auth.
		// It has no output, instead it sets the data and locates to checkout
		$this->load->model('payment/pp_express');

		$request = array(
			'METHOD' => 'GetExpressCheckoutDetails',
			'TOKEN'  => $this->session->data['paypal']['token']
		);

		$response = $this->model_payment_pp_express->call($request);

		$this->session->data['paypal']['payerid'] = $response['PAYERID'];
		$this->session->data['paypal']['result'] = $response;

		$this->session->data['comment'] = '';

		if (isset($response['PAYMENTREQUEST_0_NOTETEXT'])) {
			$this->session->data['comment'] = $response['PAYMENTREQUEST_0_NOTETEXT'];
		}

		if ($this->session->data['paypal']['guest'] == true) {

			$this->session->data['guest']['customer_group_id'] = $this->config->get('config_customer_group_id');
			$this->session->data['guest']['firstname'] = trim($response['FIRSTNAME']);
			$this->session->data['guest']['lastname'] = trim($response['LASTNAME']);
			$this->session->data['guest']['email'] = trim($response['EMAIL']);

			if (isset($response['PHONENUM'])) {
				$this->session->data['guest']['telephone'] = $response['PHONENUM'];
			} else {
				$this->session->data['guest']['telephone'] = '';
			}

			$this->session->data['guest']['fax'] = '';

			$this->session->data['guest']['payment']['firstname'] = trim($response['FIRSTNAME']);
			$this->session->data['guest']['payment']['lastname'] = trim($response['LASTNAME']);

			if (isset($response['BUSINESS'])) {
				$this->session->data['guest']['payment']['company'] = $response['BUSINESS'];
			} else {
				$this->session->data['guest']['payment']['company'] = '';
			}

			$this->session->data['guest']['payment']['company_id'] = '';
			$this->session->data['guest']['payment']['tax_id'] = '';

			if ($this->cart->hasShipping()) {
				$shipping_name = explode(' ', trim($response['PAYMENTREQUEST_0_SHIPTONAME']));
				$shipping_first_name = $shipping_name[0];

				unset($shipping_name[0]);

				$shipping_last_name = implode(' ', $shipping_name);

				$this->session->data['guest']['payment']['address_1'] = $response['PAYMENTREQUEST_0_SHIPTOSTREET'];

				if (isset($response['PAYMENTREQUEST_0_SHIPTOSTREET2'])) {
					$this->session->data['guest']['payment']['address_2'] = $response['PAYMENTREQUEST_0_SHIPTOSTREET2'];
				} else {
					$this->session->data['guest']['payment']['address_2'] = '';
				}

				$this->session->data['guest']['payment']['postcode'] = $response['PAYMENTREQUEST_0_SHIPTOZIP'];
				$this->session->data['guest']['payment']['city'] = $response['PAYMENTREQUEST_0_SHIPTOCITY'];

				$this->session->data['guest']['shipping']['firstname'] = $shipping_first_name;
				$this->session->data['guest']['shipping']['lastname'] = $shipping_last_name;
				$this->session->data['guest']['shipping']['company'] = '';
				$this->session->data['guest']['shipping']['address_1'] = $response['PAYMENTREQUEST_0_SHIPTOSTREET'];

				if (isset($response['PAYMENTREQUEST_0_SHIPTOSTREET2'])) {
					$this->session->data['guest']['shipping']['address_2'] = $response['PAYMENTREQUEST_0_SHIPTOSTREET2'];
				} else {
					$this->session->data['guest']['shipping']['address_2'] = '';
				}

				$this->session->data['guest']['shipping']['postcode'] = $response['PAYMENTREQUEST_0_SHIPTOZIP'];
				$this->session->data['guest']['shipping']['city'] = $response['PAYMENTREQUEST_0_SHIPTOCITY'];

				$this->session->data['shipping_postcode'] = $response['PAYMENTREQUEST_0_SHIPTOZIP'];

				$country_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE `iso_code_2` = '" . $this->db->escape($response['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE']) . "' AND `status` = '1' LIMIT 0,1")->row;

				if ($country_info) {
					$this->session->data['guest']['shipping']['country_id'] = $country_info['country_id'];
					$this->session->data['guest']['shipping']['country'] = $country_info['name'];
					$this->session->data['guest']['shipping']['iso_code_2'] = $country_info['iso_code_2'];
					$this->session->data['guest']['shipping']['iso_code_3'] = $country_info['iso_code_3'];
					$this->session->data['guest']['shipping']['address_format'] = $country_info['address_format'];
					$this->session->data['guest']['payment']['country_id'] = $country_info['country_id'];
					$this->session->data['guest']['payment']['country'] = $country_info['name'];
					$this->session->data['guest']['payment']['iso_code_2'] = $country_info['iso_code_2'];
					$this->session->data['guest']['payment']['iso_code_3'] = $country_info['iso_code_3'];
					$this->session->data['guest']['payment']['address_format'] = $country_info['address_format'];
					$this->session->data['shipping_country_id'] = $country_info['country_id'];
				} else {
					$this->session->data['guest']['shipping']['country_id'] = '';
					$this->session->data['guest']['shipping']['country'] = '';
					$this->session->data['guest']['shipping']['iso_code_2'] = '';
					$this->session->data['guest']['shipping']['iso_code_3'] = '';
					$this->session->data['guest']['shipping']['address_format'] = '';
					$this->session->data['guest']['payment']['country_id'] = '';
					$this->session->data['guest']['payment']['country'] = '';
					$this->session->data['guest']['payment']['iso_code_2'] = '';
					$this->session->data['guest']['payment']['iso_code_3'] = '';
					$this->session->data['guest']['payment']['address_format'] = '';
					$this->session->data['shipping_country_id'] = '';
				}

				if (isset($response['PAYMENTREQUEST_0_SHIPTOSTATE'])) {
					$returned_shipping_zone = $response['PAYMENTREQUEST_0_SHIPTOSTATE'];
				} else {
					$returned_shipping_zone = '';
				}

				$zone_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE (`name` = '" . $this->db->escape($returned_shipping_zone) . "' OR `code` = '" . $this->db->escape($returned_shipping_zone) . "') AND `status` = '1' AND `country_id` = '" . (int)$country_info['country_id'] . "' LIMIT 0,1")->row;

				if ($zone_info) {
					$this->session->data['guest']['shipping']['zone'] = $zone_info['name'];
					$this->session->data['guest']['shipping']['zone_code'] = $zone_info['code'];
					$this->session->data['guest']['shipping']['zone_id'] = $zone_info['zone_id'];
					$this->session->data['guest']['payment']['zone'] = $zone_info['name'];
					$this->session->data['guest']['payment']['zone_code'] = $zone_info['code'];
					$this->session->data['guest']['payment']['zone_id'] = $zone_info['zone_id'];
					$this->session->data['shipping_zone_id'] = $zone_info['zone_id'];
				} else {
					$this->session->data['guest']['shipping']['zone'] = '';
					$this->session->data['guest']['shipping']['zone_code'] = '';
					$this->session->data['guest']['shipping']['zone_id'] = '';
					$this->session->data['guest']['payment']['zone'] = '';
					$this->session->data['guest']['payment']['zone_code'] = '';
					$this->session->data['guest']['payment']['zone_id'] = '';
					$this->session->data['shipping_zone_id'] = '';
				}

				$this->session->data['guest']['shipping_address'] = true;

			} else {
				$this->session->data['guest']['payment']['address_1'] = '';
				$this->session->data['guest']['payment']['address_2'] = '';
				$this->session->data['guest']['payment']['postcode'] = '';
				$this->session->data['guest']['payment']['city'] = '';
				$this->session->data['guest']['payment']['country_id'] = '';
				$this->session->data['guest']['payment']['country'] = '';
				$this->session->data['guest']['payment']['iso_code_2'] = '';
				$this->session->data['guest']['payment']['iso_code_3'] = '';
				$this->session->data['guest']['payment']['address_format'] = '';
				$this->session->data['guest']['payment']['zone'] = '';
				$this->session->data['guest']['payment']['zone_code'] = '';
				$this->session->data['guest']['payment']['zone_id'] = '';
				$this->session->data['guest']['shipping_address'] = false;
			}

			$this->session->data['account'] = 'guest';

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);

		} else {
			unset($this->session->data['guest']);

			// If the user is logged in, add the address to the account and set the ID
			if ($this->cart->hasShipping()) {
				$this->load->model('account/address');

				$addresses = $this->model_account_address->getAddresses();

				// Compare all of the user addresses and see if there is a match
				$match = false;

				foreach ($addresses as $address) {
					if (trim(strtolower($address['address_1'])) == trim(strtolower($response['PAYMENTREQUEST_0_SHIPTOSTREET'])) && trim(strtolower($address['postcode'])) == trim(strtolower($response['PAYMENTREQUEST_0_SHIPTOZIP']))) {
						$match = true;

						$this->session->data['payment_address_id'] = $address['address_id'];
						$this->session->data['payment_country_id'] = $address['country_id'];
						$this->session->data['payment_zone_id'] = $address['zone_id'];

						$this->session->data['shipping_address_id'] = $address['address_id'];
						$this->session->data['shipping_country_id'] = $address['country_id'];
						$this->session->data['shipping_zone_id'] = $address['zone_id'];
						$this->session->data['shipping_postcode'] = $address['postcode'];

						break;
					}
				}

				// If there is no address match add the address and set the info
				if ($match == false) {
					$shipping_name = explode(' ', trim($response['PAYMENTREQUEST_0_SHIPTONAME']));
					$shipping_first_name = $shipping_name[0];

					unset($shipping_name[0]);

					$shipping_last_name = implode(' ', $shipping_name);

					$country_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE `iso_code_2` = '" . $this->db->escape($response['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE']) . "' AND `status` = '1' LIMIT 0,1")->row;
					$zone_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE (`name` = '" . $this->db->escape($response['PAYMENTREQUEST_0_SHIPTOSTATE']) . "' OR `code` = '" . $this->db->escape($response['PAYMENTREQUEST_0_SHIPTOSTATE']) . "') AND `status` = '1' AND `country_id` = '" . (int)$country_info['country_id'] . "'")->row;

					$address_data= array(
						'firstname'  => $shipping_first_name,
						'lastname'   => $shipping_last_name,
						'company'    => '',
						'company_id' => '',
						'tax_id'     => '',
						'address_1'  => $response['PAYMENTREQUEST_0_SHIPTOSTREET'],
						'address_2'  => (isset($response['PAYMENTREQUEST_0_SHIPTOSTREET2']) ? $response['PAYMENTREQUEST_0_SHIPTOSTREET2'] : ''),
						'postcode'   => $response['PAYMENTREQUEST_0_SHIPTOZIP'],
						'city'       => $response['PAYMENTREQUEST_0_SHIPTOCITY'],
						'zone_id'    => (isset($zone_info['zone_id']) ? $zone_info['zone_id'] : 0),
						'country_id' => (isset($country_info['country_id']) ? $country_info['country_id'] : 0)
					);

					$address_id = $this->model_account_address->addAddress($address_data);

					$this->session->data['payment_address_id'] = $address_id;
					$this->session->data['payment_country_id'] = $address_data['country_id'];
					$this->session->data['payment_zone_id'] = $address_data['zone_id'];

					$this->session->data['shipping_address_id'] = $address_id;
					$this->session->data['shipping_country_id'] = $address_data['country_id'];
					$this->session->data['shipping_zone_id'] = $address_data['zone_id'];
					$this->session->data['shipping_postcode'] = $address_data['postcode'];
				}

			} else {
				$this->session->data['payment_address_id'] = '';
				$this->session->data['payment_country_id'] = '';
				$this->session->data['payment_zone_id'] = '';
			}
		}

		$this->redirect($this->url->link('payment/pp_express/expressConfirm', '', 'SSL'));
	}

	public function expressConfirm() {
		$this->language->load('payment/pp_express');
		$this->language->load('checkout/cart');

		$this->load->model('tool/image');

		// Coupon
		if (isset($this->request->post['coupon']) && $this->validateCoupon()) {
			$this->session->data['coupon'] = $this->request->post['coupon'];

			$this->session->data['success'] = $this->language->get('text_coupon');

			$this->redirect($this->url->link('payment/pp_express/expressConfirm', '', 'SSL'));
		}

		// Voucher
		if (isset($this->request->post['voucher']) && $this->validateVoucher()) {
			$this->session->data['voucher'] = $this->request->post['voucher'];

			$this->session->data['success'] = $this->language->get('text_voucher');

			$this->redirect($this->url->link('payment/pp_express/expressConfirm', '', 'SSL'));
		}

		// Reward
		if (isset($this->request->post['reward']) && $this->validateReward()) {
			$this->session->data['reward'] = abs($this->request->post['reward']);

			$this->session->data['success'] = $this->language->get('text_reward');

			$this->redirect($this->url->link('payment/pp_express/expressConfirm', '', 'SSL'));
		}

		$this->document->setTitle($this->language->get('express_text_title'));

		$points = $this->customer->getRewardPoints();

		$points_total = 0;

		foreach ($this->cart->getProducts() as $product) {
			if ($product['points']) {
				$points_total += $product['points'];
			}
		}

		$this->data['text_title'] = $this->language->get('express_text_title');
		$this->data['text_next'] = $this->language->get('text_next');
		$this->data['text_next_choice'] = $this->language->get('text_next_choice');
		$this->data['text_use_voucher'] = $this->language->get('text_use_voucher');
		$this->data['text_use_coupon'] = $this->language->get('text_use_coupon');
		$this->data['text_use_reward'] = sprintf($this->language->get('text_use_reward'), $points);

		$this->data['entry_coupon'] = $this->language->get('express_entry_coupon');
		$this->data['entry_voucher'] = $this->language->get('entry_voucher');
		$this->data['entry_reward'] = sprintf($this->language->get('entry_reward'), $points_total);

		$this->data['button_coupon'] = $this->language->get('button_coupon');
		$this->data['button_voucher'] = $this->language->get('button_voucher');
		$this->data['button_reward'] = $this->language->get('button_reward');

		$this->data['text_trial'] = $this->language->get('text_trial');
		$this->data['text_recurring'] = $this->language->get('text_recurring');
		$this->data['text_length'] = $this->language->get('text_length');
		$this->data['text_recurring_item'] = $this->language->get('text_recurring_item');
		$this->data['text_payment_profile'] = $this->language->get('text_payment_profile');
		$this->data['text_until_cancelled'] = $this->language->get('text_until_cancelled');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['button_shipping'] = $this->language->get('button_express_shipping');
		$this->data['button_confirm'] = $this->language->get('button_express_confirm');

		if (isset($this->request->post['next'])) {
			$this->data['next'] = $this->request->post['next'];
		} else {
			$this->data['next'] = '';
		}

		$this->data['coupon_status'] = $this->config->get('coupon_status');

		if (isset($this->request->post['coupon'])) {
			$this->data['coupon'] = $this->request->post['coupon'];
		} elseif (isset($this->session->data['coupon'])) {
			$this->data['coupon'] = $this->session->data['coupon'];
		} else {
			$this->data['coupon'] = '';
		}

		$this->data['voucher_status'] = $this->config->get('voucher_status');

		if (isset($this->request->post['voucher'])) {
			$this->data['voucher'] = $this->request->post['voucher'];
		} elseif (isset($this->session->data['voucher'])) {
			$this->data['voucher'] = $this->session->data['voucher'];
		} else {
			$this->data['voucher'] = '';
		}

		$this->data['reward_status'] = ($points && $points_total && $this->config->get('reward_status'));

		if (isset($this->request->post['reward'])) {
			$this->data['reward'] = $this->request->post['reward'];
		} elseif (isset($this->session->data['reward'])) {
			$this->data['reward'] = $this->session->data['reward'];
		} else {
			$this->data['reward'] = '';
		}

		$this->data['action'] = $this->url->link('payment/pp_express/expressConfirm', '', 'SSL');

		$this->load->model('tool/upload');

		$frequencies = array(
			'day'        => $this->language->get('text_day'),
			'week'       => $this->language->get('text_week'),
			'semi_month' => $this->language->get('text_semi_month'),
			'month'      => $this->language->get('text_month'),
			'year'       => $this->language->get('text_year')
		);

		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$this->data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
			}

			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
			} else {
				$image = '';
			}

			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['option_value'];
				} else {
					$upload_info = $this->model_tool_upload->getUploadByCode($option['option_value']);

					if ($upload_info) {
						$value = $upload_info['name'];
					} else {
						$value = '';
					}
				}

				$option_data[] = array(
					'name' => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
				);
			}

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}

			// Display totals
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
			} else {
				$total = false;
			}

			$profile_description = '';

			if ($product['recurring']) {
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

			$this->data['products'][] = array(
				'key'                 => $product['key'],
				'thumb'               => $image,
				'name'                => $product['name'],
				'model'               => $product['model'],
				'option'              => $option_data,
				'quantity'            => $product['quantity'],
				'stock'               => ($product['stock']) ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
				'reward'              => ($product['reward']) ? sprintf($this->language->get('text_points'), $product['reward']) : '',
				'price'               => $price,
				'total'               => $total,
				'href'                => $this->url->link('product/product', 'product_id=' . $product['product_id'], 'SSL'),
				'remove'              => $this->url->link('checkout/cart', 'remove=' . $product['key'], 'SSL'),
				'recurring'           => $product['recurring'],
				'profile_name'        => $product['profile_name'],
				'profile_description' => $profile_description
			);
		}

		$this->data['vouchers'] = array();

		if ($this->cart->hasShipping()) {
			$this->data['has_shipping'] = true;

			// Shipping services
			if ($this->customer->isLogged()) {
				$this->load->model('account/address');

				$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
			} elseif (isset($this->session->data['guest'])) {
				$shipping_address = $this->session->data['guest']['shipping'];
			}

			if (!empty($shipping_address)) {
				// Shipping Methods
				$quote_data = array();

				$this->load->model('setting/extension');

				$results = $this->model_setting_extension->getExtensions('shipping');

				if (!empty($results)) {
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

					if (!empty($quote_data)) {
						$sort_order = array();

						foreach ($quote_data as $key => $value) {
							$sort_order[$key] = $value['sort_order'];
						}

						array_multisort($sort_order, SORT_ASC, $quote_data);

						$this->session->data['shipping_methods'] = $quote_data;
						$this->data['shipping_methods'] = $quote_data;

						if (!isset($this->session->data['shipping_method'])) {
							// Default the shipping to the very first option.
							$key1 = key($quote_data);
							$key2 = key($quote_data[$key1]['quote']);

							$this->session->data['shipping_method'] = $quote_data[$key1]['quote'][$key2];
						}

						$this->data['code'] = $this->session->data['shipping_method']['code'];
						$this->data['action_shipping'] = $this->url->link('payment/pp_express/shipping', '', 'SSL');

					} else {
						unset($this->session->data['shipping_methods']);
						unset($this->session->data['shipping_method']);
						$this->data['error_no_shipping'] = $this->language->get('error_no_shipping');
					}

				} else {
					unset($this->session->data['shipping_methods']);
					unset($this->session->data['shipping_method']);
					$this->data['error_no_shipping'] = $this->language->get('error_no_shipping');
				}
			}

		} else {
			$this->data['has_shipping'] = false;
		}

		// Product totals
		$this->load->model('setting/extension');

		$totals = array();
		$taxes = $this->cart->getTaxes();
		$total = 0;

		// Display prices
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			$results = $this->model_setting_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

					$this->{'model_total_' . $result['code']}->getTotal($totals, $total, $taxes);
				}

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}
		}

		$this->data['totals'] = $totals;

		// Payment methods
		if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
			$this->load->model('account/address');

			$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
		} elseif (isset($this->session->data['guest'])) {
			$payment_address = $this->session->data['guest']['payment'];
		}

		$method_data = array();

		$this->load->model('setting/extension');

		$results = $this->model_setting_extension->getExtensions('payment');

		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('payment/' . $result['code']);

				$method = $this->{'model_payment_' . $result['code']}->getMethod($payment_address, $total);

				if ($method) {
					$method_data[$result['code']] = $method;
				}
			}
		}

		$sort_order = array();

		foreach ($method_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $method_data);

		$this->session->data['payment_methods'] = $method_data;
		$this->session->data['payment_method'] = $this->session->data['payment_methods']['pp_express'];

		$this->data['action_confirm'] = $this->url->link('payment/pp_express/expressComplete', '', 'SSL');

		if (isset($this->session->data['error_warning'])) {
			$this->data['error_warning'] = $this->session->data['error_warning'];
			unset($this->session->data['error_warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['attention'])) {
			$this->data['attention'] = $this->session->data['attention'];
			unset($this->session->data['attention']);
		} else {
			$this->data['attention'] = '';
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_express_confirm.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/pp_express_confirm.tpl';
		} else {
			$this->template = 'default/template/payment/pp_express_confirm.tpl';
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

	public function expressComplete() {
		$this->language->load('payment/pp_express');
		$redirect = '';

		if ($this->cart->hasShipping()) {
			// Validate if shipping address has been set.
			$this->load->model('account/address');

			if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {
				$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
			} elseif (isset($this->session->data['guest'])) {
				$shipping_address = $this->session->data['guest']['shipping'];
			}

			if (empty($shipping_address)) {
				$redirect = $this->url->link('checkout/checkout', '', 'SSL');
			}

			// Validate if shipping method has been set.
			if (!isset($this->session->data['shipping_method'])) {
				$redirect = $this->url->link('checkout/checkout', '', 'SSL');
			}

		} else {
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}

		// Validate if payment address has been set.
		$this->load->model('account/address');

		if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
			$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
		} elseif (isset($this->session->data['guest'])) {
			$payment_address = $this->session->data['guest']['payment'];
		}

		// Validate if payment method has been set.
		if (!isset($this->session->data['payment_method'])) {
			$redirect = $this->url->link('checkout/checkout', '', 'SSL');
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$redirect = $this->url->link('checkout/cart', '', 'SSL');
		}

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
				$redirect = $this->url->link('checkout/cart', '', 'SSL');

				break;
			}
		}

		if ($redirect == '') {
			// Totals
			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

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

					$this->{'model_total_' . $result['code']}->getTotal($totals, $total, $taxes);
				}
			}

			$sort_order = array();

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $totals);

			$this->language->load('checkout/checkout');

			$data = array();

			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');

			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');
			} else {
				$data['store_url'] = HTTP_SERVER;
			}

			if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
				$data['customer_id'] = $this->customer->getId();
				$data['customer_group_id'] = $this->customer->getCustomerGroupId();
				$data['firstname'] = $this->customer->getFirstName();
				$data['lastname'] = $this->customer->getLastName();
				$data['email'] = $this->customer->getEmail();
				$data['telephone'] = $this->customer->getTelephone();
				$data['fax'] = $this->customer->getFax();

				$this->load->model('account/address');

				$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);

			} elseif (isset($this->session->data['guest'])) {
				$data['customer_id'] = 0;
				$data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
				$data['firstname'] = $this->session->data['guest']['firstname'];
				$data['lastname'] = $this->session->data['guest']['lastname'];
				$data['email'] = $this->session->data['guest']['email'];
				$data['telephone'] = $this->session->data['guest']['telephone'];
				$data['fax'] = $this->session->data['guest']['fax'];

				$payment_address = $this->session->data['guest']['payment'];
			}

			$data['payment_firstname'] = isset($payment_address['firstname']) ? $payment_address['firstname'] : '';
			$data['payment_lastname'] = isset($payment_address['lastname']) ? $payment_address['lastname'] : '';
			$data['payment_company'] = isset($payment_address['company']) ? $payment_address['company'] : '';
			$data['payment_company_id'] = isset($payment_address['company_id']) ? $payment_address['company_id'] : '';
			$data['payment_tax_id'] = isset($payment_address['tax_id']) ? $payment_address['tax_id'] : '';
			$data['payment_address_1'] = isset($payment_address['address_1']) ? $payment_address['address_1'] : '';
			$data['payment_address_2'] = isset($payment_address['address_2']) ? $payment_address['address_2'] : '';
			$data['payment_city'] = isset($payment_address['city']) ? $payment_address['city'] : '';
			$data['payment_postcode'] = isset($payment_address['postcode']) ? $payment_address['postcode'] : '';
			$data['payment_zone'] = isset($payment_address['zone']) ? $payment_address['zone'] : '';
			$data['payment_zone_id'] = isset($payment_address['zone_id']) ? $payment_address['zone_id'] : '';
			$data['payment_country'] = isset($payment_address['country']) ? $payment_address['country'] : '';
			$data['payment_country_id'] = isset($payment_address['country_id']) ? $payment_address['country_id'] : '';
			$data['payment_address_format'] = isset($payment_address['address_format']) ? $payment_address['address_format'] : '';

			$data['payment_method'] = '';

			if (isset($this->session->data['payment_method']['title'])) {
				$data['payment_method'] = $this->session->data['payment_method']['title'];
			}

			$data['payment_code'] = '';

			if (isset($this->session->data['payment_method']['code'])) {
				$data['payment_code'] = $this->session->data['payment_method']['code'];
			}

			if ($this->cart->hasShipping()) {
				if ($this->customer->isLogged()) {
					$this->load->model('account/address');

					$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
				} elseif (isset($this->session->data['guest'])) {
					$shipping_address = $this->session->data['guest']['shipping'];
				}

				$data['shipping_firstname'] = $shipping_address['firstname'];
				$data['shipping_lastname'] = $shipping_address['lastname'];
				$data['shipping_company'] = $shipping_address['company'];
				$data['shipping_address_1'] = $shipping_address['address_1'];
				$data['shipping_address_2'] = $shipping_address['address_2'];
				$data['shipping_city'] = $shipping_address['city'];
				$data['shipping_postcode'] = $shipping_address['postcode'];
				$data['shipping_zone'] = $shipping_address['zone'];
				$data['shipping_zone_id'] = $shipping_address['zone_id'];
				$data['shipping_country'] = $shipping_address['country'];
				$data['shipping_country_id'] = $shipping_address['country_id'];
				$data['shipping_address_format'] = $shipping_address['address_format'];

				$data['shipping_method'] = '';

				if (isset($this->session->data['shipping_method']['title'])) {
					$data['shipping_method'] = $this->session->data['shipping_method']['title'];
				}

				$data['shipping_code'] = '';

				if (isset($this->session->data['shipping_method']['code'])) {
					$data['shipping_code'] = $this->session->data['shipping_method']['code'];
				}

			} else {
				$data['shipping_firstname'] = '';
				$data['shipping_lastname'] = '';
				$data['shipping_company'] = '';
				$data['shipping_address_1'] = '';
				$data['shipping_address_2'] = '';
				$data['shipping_city'] = '';
				$data['shipping_postcode'] = '';
				$data['shipping_zone'] = '';
				$data['shipping_zone_id'] = '';
				$data['shipping_country'] = '';
				$data['shipping_country_id'] = '';
				$data['shipping_address_format'] = '';
				$data['shipping_method'] = '';
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
			$data['totals'] = $totals;
			$data['comment'] = $this->session->data['comment'];
			$data['total'] = $total;

			if (isset($this->request->cookie['tracking'])) {
				$data['tracking'] = $this->request->cookie['tracking'];

				$subtotal = $this->cart->getSubTotal();

				// Affiliate
				$this->load->model('affiliate/affiliate');

				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

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
				$data['tracking'] = '';
			}

			$data['language_id'] = $this->config->get('config_language_id');

			$data['currency_id'] = $this->currency->getId($this->currency->getCode());
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

			$this->load->model('checkout/order');

			$order_id = $this->model_checkout_order->addOrder($data);

			$this->session->data['order_id'] = $order_id;

			$this->load->model('payment/pp_express');

			$request = array(
				'TOKEN'                      => $this->session->data['paypal']['token'],
				'PAYERID'                    => $this->session->data['paypal']['payerid'],
				'METHOD'                     => 'DoExpressCheckoutPayment',
				'PAYMENTREQUEST_0_NOTIFYURL' => $this->url->link('payment/pp_express/ipn', '', 'SSL'),
				'RETURNFMFDETAILS'           => 1
			);

			$request = array_merge($request, $this->model_payment_pp_express->paymentRequestInfo());

			$response = $this->model_payment_pp_express->call($request);

			if ($response === false) {
				$this->session->data['error'] = $this->language->get('error_connection');

				$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));

			} elseif (is_array($response) && isset($response['ACK']) && ($response['ACK'] == 'Success')) {
				//handle order status
				switch ($response['PAYMENTINFO_0_PAYMENTSTATUS']) {
					case 'Canceled_Reversal':
						$order_status_id = $this->config->get('pp_express_canceled_reversal_status_id');
						break;
					case 'Completed':
						$order_status_id = $this->config->get('pp_express_completed_status_id');
						break;
					case 'Denied':
						$order_status_id = $this->config->get('pp_express_denied_status_id');
						break;
					case 'Expired':
						$order_status_id = $this->config->get('pp_express_expired_status_id');
						break;
					case 'Failed':
						$order_status_id = $this->config->get('pp_express_failed_status_id');
						break;
					case 'Pending':
						$order_status_id = $this->config->get('pp_express_pending_status_id');
						break;
					case 'Processed':
						$order_status_id = $this->config->get('pp_express_processed_status_id');
						break;
					case 'Refunded':
						$order_status_id = $this->config->get('pp_express_refunded_status_id');
						break;
					case 'Reversed':
						$order_status_id = $this->config->get('pp_express_reversed_status_id');
						break;
					case 'Voided':
						$order_status_id = $this->config->get('pp_express_voided_status_id');
						break;
				}

				$this->model_checkout_order->confirm($order_id, $order_status_id);

				// Add order to paypal table
				$paypal_order_data = array(
					'order_id'         => $order_id,
					'capture_status'   => ($this->config->get('pp_express_transaction_method') == 'Sale') ? 'Complete' : 'NotComplete',
					'currency_code'    => $response['PAYMENTINFO_0_CURRENCYCODE'],
					'authorization_id' => $response['PAYMENTINFO_0_TRANSACTIONID'],
					'total'            => $response['PAYMENTINFO_0_AMT']
				);

				$paypal_order_id = $this->model_payment_pp_express->addOrder($paypal_order_data);

				// Add transaction to paypal transaction table
				$paypal_transaction_data = array(
					'paypal_order_id'       => $paypal_order_id,
					'transaction_id'        => $response['PAYMENTINFO_0_TRANSACTIONID'],
					'parent_transaction_id' => '',
					'note'                  => '',
					'msgsubid'              => '',
					'receipt_id'            => (isset($response['PAYMENTINFO_0_RECEIPTID']) ? $response['PAYMENTINFO_0_RECEIPTID'] : ''),
					'payment_type'          => $response['PAYMENTINFO_0_PAYMENTTYPE'],
					'payment_status'        => $response['PAYMENTINFO_0_PAYMENTSTATUS'],
					'pending_reason'        => $response['PAYMENTINFO_0_PENDINGREASON'],
					'transaction_entity'    => ($this->config->get('pp_express_transaction_method') == 'Sale') ? 'payment' : 'auth',
					'amount'                => $response['PAYMENTINFO_0_AMT'],
					'debug_data'            => json_encode($response)
				);

				$this->model_payment_pp_express->addTransaction($paypal_transaction_data);

				$recurring_products = $this->cart->getRecurringProducts();

				// Loop through any products that are recurring items
				if (!empty($recurring_products)) {
					$this->language->load('payment/pp_express');

					$this->load->model('checkout/recurring');

					$billing_period = array(
						'day'        => 'Day',
						'week'       => 'Week',
						'semi_month' => 'SemiMonth',
						'month'      => 'Month',
						'year'       => 'Year'
					);

					foreach ($recurring_products as $item) {
						$data = array(
							'METHOD'             => 'CreateRecurringPaymentsProfile',
							'TOKEN'              => $this->session->data['paypal']['token'],
							'PROFILESTARTDATE'   => gmdate("Y-m-d\TH:i:s\Z", gmmktime(gmdate("H"), gmdate("i")+5, gmdate("s"), gmdate("m"), gmdate("d"), gmdate("y"))),
							'BILLINGPERIOD'      => $billing_period[$item['recurring_frequency']],
							'BILLINGFREQUENCY'   => $item['recurring_cycle'],
							'TOTALBILLINGCYCLES' => $item['recurring_duration'],
							'AMT'                => $this->currency->format($this->tax->calculate($item['recurring_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity'],
							'CURRENCYCODE'       => $this->currency->getCode()
						);

						// Trial information
						if ($item['recurring_trial'] == 1) {
							$data_trial = array(
								'TRIALBILLINGPERIOD'      => $billing_period[$item['recurring_trial_frequency']],
								'TRIALBILLINGFREQUENCY'   => $item['recurring_trial_cycle'],
								'TRIALTOTALBILLINGCYCLES' => $item['recurring_trial_duration'],
								'TRIALAMT'                => $this->currency->format($this->tax->calculate($item['recurring_trial_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity']
							);

							$trial_amt = $this->currency->format($this->tax->calculate($item['recurring_trial_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity'] . ' ' . $this->currency->getCode();
							$trial_text = sprintf($this->language->get('text_trial'), $trial_amt, $item['recurring_trial_cycle'], $item['recurring_trial_frequency'], $item['recurring_trial_duration']);

							$data = array_merge($data, $data_trial);

						} else {
							$trial_text = '';
						}

						$recurring_amt = $this->currency->format($this->tax->calculate($item['recurring_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity'] . ' ' . $this->currency->getCode();
						$recurring_description = $trial_text . sprintf($this->language->get('text_recurring'), $recurring_amt, $item['recurring_cycle'], $item['recurring_frequency']);

						if ($item['recurring_duration'] > 0) {
							$recurring_description .= sprintf($this->language->get('text_length'), $item['recurring_duration']);
						}

						// Create new profile and set to pending status as no payment has been made yet.
						$recurring_id = $this->model_checkout_recurring->create($item, $order_id, $recurring_description);

						$data['PROFILEREFERENCE'] = $recurring_id;
						$data['DESC'] = $recurring_description;

						$response = $this->model_payment_pp_express->call($data);

						if (isset($response['PROFILEID'])) {
							$this->model_checkout_recurring->addReference($recurring_id, $response['PROFILEID']);
						} else {
							// There was an error creating the profile, need to log and also alert admin / user
							// ???
						}
					}
				}

				$this->redirect($this->url->link('checkout/success', '', 'SSL'));

				// ??? Never pass here after a redirect. What is it for ?
				if (isset($response['REDIRECTREQUIRED']) && $response['REDIRECTREQUIRED'] == true) {
					//- handle german redirect here
					$this->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_complete-express-checkout&token=' . $this->session->data['paypal']['token']);
				}

			} else {
				if ($response['L_ERRORCODE0'] == '10486') {
					if (isset($this->session->data['paypal_redirect_count'])) {
						if ($this->session->data['paypal_redirect_count'] == 2) {
							$this->session->data['paypal_redirect_count'] = 0;
							$this->session->data['error'] = $this->language->get('error_too_many_failures');

							$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
						} else {
							$this->session->data['paypal_redirect_count']++;
						}

					} else {
						$this->session->data['paypal_redirect_count'] = 1;
					}

					if ($this->config->get('pp_express_test') == 1) {
						$this->redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->session->data['paypal']['token']);
					} else {
						$this->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->session->data['paypal']['token']);
					}
				}

				$this->session->data['error_warning'] = (isset($response['L_SHORTMESSAGE0']) ? $response['L_SHORTMESSAGE0'] : $this->language->get('error_general')) . (isset($response['L_LONGMESSAGE0']) ? '<br />' . $response['L_LONGMESSAGE0'] : '');
				$this->redirect($this->url->link('payment/pp_express/expressConfirm', '', 'SSL'));
			}

		} else {
			$this->redirect($redirect);
		}
	}

	public function checkout() {
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->redirect($this->url->link('checkout/cart'));
		}

		$this->language->load('payment/pp_express');

		$this->load->model('payment/pp_express');
		$this->load->model('tool/image');
		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$max_amount = $this->currency->convert($order_info['total'], $this->config->get('config_currency'), 'USD');
		$max_amount = min($max_amount * 1.5, 10000);
		$max_amount = $this->currency->format($max_amount, $this->currency->getCode(), '', false);

		if ($this->cart->hasShipping()) {
			$shipping = 0;

			// PayPal requires some countries to use zone code (not name) to be sent in SHIPTOSTATE
			$ship_to_state_codes = array(
				'30', // Brazil
				'38', // Canada
				'105', // Italy
				'138', // Mexico
				'223', // USA
			);

			if (in_array($order_info['shipping_country_id'], $ship_to_state_codes)) {
				$ship_to_state = $order_info['shipping_zone_code'];
			} else {
				$ship_to_state = $order_info['shipping_zone'];
			}

			$data_shipping = array(
				'PAYMENTREQUEST_0_SHIPTONAME'        => html_entity_decode($order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_0_SHIPTOSTREET'      => html_entity_decode($order_info['shipping_address_1'], ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_0_SHIPTOSTREET2'     => html_entity_decode($order_info['shipping_address_2'], ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_0_SHIPTOCITY'        => html_entity_decode($order_info['shipping_city'], ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_0_SHIPTOSTATE'       => html_entity_decode($ship_to_state, ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_0_SHIPTOZIP'         => html_entity_decode($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8'),
				'PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE' => $order_info['shipping_iso_code_2']
			);

		} else {
			$shipping = 1;
			$data_shipping = array();
		}

		$request = array(
			'METHOD'             => 'SetExpressCheckout',
			'MAXAMT'             => $max_amount,
			'RETURNURL'          => $this->url->link('payment/pp_express/checkoutReturn', '', 'SSL'),
			'CANCELURL'          => $this->url->link('checkout/checkout', '', 'SSL'),
			'REQCONFIRMSHIPPING' => 0,
			'NOSHIPPING'         => $shipping,
			'LOCALECODE'         => 'EN',
			'LANDINGPAGE'        => 'Login',
			'HDRIMG'             => $this->model_tool_image->resize($this->config->get('pp_express_logo'), 750, 90),
			'HDRBORDERCOLOR'     => $this->config->get('pp_express_border_colour'),
			'HDRBACKCOLOR'       => $this->config->get('pp_express_header_colour'),
			'PAYFLOWCOLOR'       => $this->config->get('pp_express_page_colour'),
			'CHANNELTYPE'        => 'Merchant',
			'ALLOWNOTE'          => $this->config->get('pp_express_allow_note')
		);

		$request = array_merge($request, $data_shipping);

		$request = array_merge($request, $this->model_payment_pp_express->paymentRequestInfo());

		$response = $this->model_payment_pp_express->call($request);

		if ($response === false) {
			$this->session->data['error'] = $this->language->get('error_connection');

		} elseif (is_array($response) && isset($response['TOKEN'])) {
			$this->session->data['paypal']['token'] = $response['TOKEN'];

			if ($this->config->get('pp_express_test') == 1) {
				header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $response['TOKEN'].'&useraction=commit');
			} else {
				header('Location: https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $response['TOKEN'].'&useraction=commit');
			}

		} else {
			// If a failed PayPal setup happens, handle it.
			$this->session->data['error'] = (isset($response['L_SHORTMESSAGE0']) ? $response['L_SHORTMESSAGE0'] : $this->language->get('error_general')) . (isset($response['L_LONGMESSAGE0']) ? '<br />' . $response['L_LONGMESSAGE0'] : '');
			// Unable to add error message to user as the session errors/success are not used on the cart or checkout pages - need to be added ?
			// If PayPal debug log is off, then still log error to normal error log.
			$this->model_payment_pp_express->log($response, 'Unable to create PayPal call', true);
		}

		$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
	}

	public function checkoutReturn() {
		$this->language->load('payment/pp_express');

		// Get the details
		$this->load->model('payment/pp_express');
		$this->load->model('checkout/order');

		$request = array(
			'METHOD' => 'GetExpressCheckoutDetails',
			'TOKEN'  => $this->session->data['paypal']['token']
		);

		$response = $this->model_payment_pp_express->call($request);

		if ($response === false) {
			$this->session->data['error'] = $this->language->get('error_connection');

		} elseif (is_array($response) && isset($response['ACK']) && ($response['ACK'] == 'Success')) {
			$this->session->data['paypal']['payerid'] = $response['PAYERID'];
			$this->session->data['paypal']['result'] = $response;

			$order_id = $this->session->data['order_id'];

			$paypal_request = array(
				'TOKEN'                      => $this->session->data['paypal']['token'],
				'PAYERID'                    => $this->session->data['paypal']['payerid'],
				'METHOD'                     => 'DoExpressCheckoutPayment',
				'PAYMENTREQUEST_0_NOTIFYURL' => $this->url->link('payment/pp_express/ipn', '', 'SSL'),
				'RETURNFMFDETAILS'           => 1
			);

			$paypal_request = array_merge($paypal_request, $this->model_payment_pp_express->paymentRequestInfo());

			$response = $this->model_payment_pp_express->call($paypal_request);

			if ($response === false) {
				$this->session->data['error'] = $this->language->get('error_connection');

			} elseif (is_array($response) && isset($response['ACK']) && ($response['ACK'] == 'Success')) {
				// Handle order status
				switch ($response['PAYMENTINFO_0_PAYMENTSTATUS']) {
					case 'Canceled_Reversal':
						$order_status_id = $this->config->get('pp_express_canceled_reversal_status_id');
						break;
					case 'Completed':
						$order_status_id = $this->config->get('pp_express_completed_status_id');
						break;
					case 'Denied':
						$order_status_id = $this->config->get('pp_express_denied_status_id');
						break;
					case 'Expired':
						$order_status_id = $this->config->get('pp_express_expired_status_id');
						break;
					case 'Failed':
						$order_status_id = $this->config->get('pp_express_failed_status_id');
						break;
					case 'Pending':
						$order_status_id = $this->config->get('pp_express_pending_status_id');
						break;
					case 'Processed':
						$order_status_id = $this->config->get('pp_express_processed_status_id');
						break;
					case 'Refunded':
						$order_status_id = $this->config->get('pp_express_refunded_status_id');
						break;
					case 'Reversed':
						$order_status_id = $this->config->get('pp_express_reversed_status_id');
						break;
					case 'Voided':
						$order_status_id = $this->config->get('pp_express_voided_status_id');
						break;
				}

				$this->model_checkout_order->confirm($order_id, $order_status_id);

				// Add order to paypal table
				$paypal_order_data = array(
					'order_id'         => $order_id,
					'capture_status'   => ($this->config->get('pp_express_transaction_method') == 'Sale') ? 'Complete' : 'NotComplete',
					'currency_code'    => $response['PAYMENTINFO_0_CURRENCYCODE'],
					'authorization_id' => $response['PAYMENTINFO_0_TRANSACTIONID'],
					'total'            => $response['PAYMENTINFO_0_AMT']
				);

				$paypal_order_id = $this->model_payment_pp_express->addOrder($paypal_order_data);

				// Add transaction to paypal transaction table
				$paypal_transaction_data = array(
					'paypal_order_id'       => $paypal_order_id,
					'transaction_id'        => $response['PAYMENTINFO_0_TRANSACTIONID'],
					'parent_transaction_id' => '',
					'note'                  => '',
					'msgsubid'              => '',
					'receipt_id'            => (isset($response['PAYMENTINFO_0_RECEIPTID']) ? $response['PAYMENTINFO_0_RECEIPTID'] : ''),
					'payment_type'          => $response['PAYMENTINFO_0_PAYMENTTYPE'],
					'payment_status'        => $response['PAYMENTINFO_0_PAYMENTSTATUS'],
					'pending_reason'        => $response['PAYMENTINFO_0_PENDINGREASON'],
					'transaction_entity'    => ($this->config->get('pp_express_transaction_method') == 'Sale') ? 'payment' : 'auth',
					'amount'                => $response['PAYMENTINFO_0_AMT'],
					'debug_data'            => json_encode($response)
				);

				$this->model_payment_pp_express->addTransaction($paypal_transaction_data);

				$recurring_products = $this->cart->getRecurringProducts();

				// Loop through any products that are recurring items
				if (!empty($recurring_products)) {
					$this->load->model('checkout/recurring');

					$billing_period = array(
						'day'        => 'Day',
						'week'       => 'Week',
						'semi_month' => 'SemiMonth',
						'month'      => 'Month',
						'year'       => 'Year'
					);

					foreach ($recurring_products as $item) {
						$recurring_request = array(
							'METHOD'             => 'CreateRecurringPaymentsProfile',
							'TOKEN'              => $this->session->data['paypal']['token'],
							'PROFILESTARTDATE'   => gmdate("Y-m-d\TH:i:s\Z", gmmktime(gmdate("H"), gmdate("i")+5, gmdate("s"), gmdate("m"), gmdate("d"), gmdate("y"))),
							'BILLINGPERIOD'      => $billing_period[$item['recurring_frequency']],
							'BILLINGFREQUENCY'   => $item['recurring_cycle'],
							'TOTALBILLINGCYCLES' => $item['recurring_duration'],
							'AMT'                => $this->currency->format($this->tax->calculate($item['recurring_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity'],
							'CURRENCYCODE'       => $this->currency->getCode()
						);

						// Trial information
						if ($item['recurring_trial'] == 1) {
							$recurring_request_trial = array(
								'TRIALBILLINGPERIOD'      => $billing_period[$item['recurring_trial_frequency']],
								'TRIALBILLINGFREQUENCY'   => $item['recurring_trial_cycle'],
								'TRIALTOTALBILLINGCYCLES' => $item['recurring_trial_duration'],
								'TRIALAMT'                => $this->currency->format($this->tax->calculate($item['recurring_trial_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity']
							);

							$trial_amt = $this->currency->format($this->tax->calculate($item['recurring_trial_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity'] . ' ' . $this->currency->getCode();
							$trial_text = sprintf($this->language->get('text_trial'), $trial_amt, $item['recurring_trial_cycle'], $item['recurring_trial_frequency'], $item['recurring_trial_duration']);

							$recurring_request = array_merge($recurring_request, $recurring_request_trial);
						} else {
							$trial_text = '';
						}

						$recurring_amt = $this->currency->format($this->tax->calculate($item['recurring_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity'] . ' ' . $this->currency->getCode();
						$recurring_description = $trial_text . sprintf($this->language->get('text_recurring'), $recurring_amt, $item['recurring_cycle'], $item['recurring_frequency']);

						if ($item['recurring_duration'] > 0) {
							$recurring_description .= sprintf($this->language->get('text_length'), $item['recurring_duration']);
						}

						// Create new profile and set to pending status as no payment has been made yet.
						$recurring_id = $this->model_checkout_recurring->create($item, $order_id, $recurring_description);

						$recurring_request['PROFILEREFERENCE'] = $recurring_id;
						$recurring_request['DESC'] = $recurring_description;

						$recurring_response = $this->model_payment_pp_express->call($recurring_request);

						if (isset($recurring_response['PROFILEID'])) {
							$this->model_checkout_recurring->addReference($recurring_id, $recurring_response['PROFILEID']);
						} else {
							// There was an error creating the profile, need to log and also alert admin / user
							// ???
						}
					}
				}

				if (isset($response['REDIRECTREQUIRED']) && $response['REDIRECTREQUIRED'] == true) {
					//- handle german redirect here
					if ($this->config->get('pp_express_test') == 1) {
						$this->redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_complete-express-checkout&token=' . $this->session->data['paypal']['token']);
					} else {
						$this->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_complete-express-checkout&token=' . $this->session->data['paypal']['token']);
					}
				} else {
					$this->redirect($this->url->link('checkout/success', '', 'SSL'));
				}

			} else {
				if ($response['L_ERRORCODE0'] == '10486') {
					if (isset($this->session->data['paypal_redirect_count'])) {
						if ($this->session->data['paypal_redirect_count'] == 2) {
							$this->session->data['paypal_redirect_count'] = 0;
							$this->session->data['error'] = $this->language->get('error_too_many_failures');

							$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
						} else {
							$this->session->data['paypal_redirect_count']++;
						}

					} else {
						$this->session->data['paypal_redirect_count'] = 1;
					}

					if ($this->config->get('pp_express_test') == 1) {
						$this->redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->session->data['paypal']['token']);
					} else {
						$this->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->session->data['paypal']['token']);
					}
				}
			}
		}

		$this->language->load('payment/pp_express');

		// Breadcrumbs
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

		$this->data['heading_title'] = $this->language->get('error_general');

		$this->data['text_error'] = '<div class="warning">' . $response['L_ERRORCODE0'] . ' : ' . $response['L_LONGMESSAGE0'] . '</div>';

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('checkout/cart', '', 'SSL');

		unset($this->session->data['success']);

		$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
		} else {
			$this->template = 'default/template/error/not_found.tpl';
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

	public function ipn() {
		$this->load->model('payment/pp_express');
		$this->load->model('account/recurring');

		$request = 'cmd=_notify-validate';

		foreach ($_POST as $key => $value) {
			$request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
		}

		if ($this->config->get('pp_express_test')) {
			$api_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		} else {
			$api_url = 'https://www.paypal.com/cgi-bin/webscr';
		}

		$options = array(
			CURLOPT_POST           => true,
			CURLOPT_HEADER         => false,
			CURLOPT_URL            => $api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS     => $request
		);

		$ch = curl_init();

		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);

		if (curl_errno($ch) != CURLE_OK) {
			$log_data = array(
				'curl_errno' => curl_errno($ch),
				'curl_error' => curl_error($ch)
			);

			$this->model_payment_pp_express->log($log_data, 'cURL failed');

			return false;
		}

		$this->model_payment_pp_express->log(array('request' => $request, 'response' => $response), 'IPN data');

		curl_close($ch);

		if ((string)$response == "VERIFIED") {
			if (isset($this->request->post['transaction_entity'])) {
				$this->model_payment_pp_express->log($this->request->post['transaction_entity'], 'IPN data');
			}

			if (isset($this->request->post['txn_id'])) {
				$transaction = $this->model_payment_pp_express->getTransactionRow($this->request->post['txn_id']);
			} else {
				$transaction = false;
			}

			if (isset($this->request->post['parent_txn_id'])) {
				$parent_transaction = $this->model_payment_pp_express->getTransactionRow($this->request->post['parent_txn_id']);
			} else {
				$parent_transaction = false;
			}

			if ($transaction) {
				// Transaction exists, check for cleared payment or updates etc...
				$this->model_payment_pp_express->log('Transaction exists', 'IPN data');

				// If the transaction is pending but the new status is completed
				if ($transaction['payment_status'] != $this->request->post['payment_status']) {
					$this->model_payment_pp_express->updateTransactionStatus($transaction['transaction_id'], $this->request->post['payment_status']);

				} elseif ($transaction['payment_status'] == 'Pending' && ($transaction['pending_reason'] != $this->request->post['pending_reason'])) {
					// Payment is still pending but the pending reason has changed, update it
					$this->model_payment_pp_express->updateTransactionPendingReason($transaction['transaction_id'], $this->request->post['pending_reason']);
				}

			} else {
				$this->model_payment_pp_express->log('Transaction does not exist', 'IPN data');

				if ($parent_transaction) {
					// Parent transaction exists
					$this->model_payment_pp_express->log('Parent transaction exists', 'IPN data');

					// Insert new related transaction
					$transaction = array(
						'paypal_order_id'       => $parent_transaction['paypal_order_id'],
						'transaction_id'        => $this->request->post['txn_id'],
						'parent_transaction_id' => $this->request->post['parent_txn_id'],
						'note'                  => '',
						'msgsubid'              => '',
						'receipt_id'            => (isset($this->request->post['receipt_id']) ? $this->request->post['receipt_id'] : ''),
						'payment_type'          => (isset($this->request->post['payment_type']) ? $this->request->post['payment_type'] : ''),
						'payment_status'        => (isset($this->request->post['payment_status']) ? $this->request->post['payment_status'] : ''),
						'pending_reason'        => (isset($this->request->post['pending_reason']) ? $this->request->post['pending_reason'] : ''),
						'amount'                => $this->request->post['mc_gross'],
						'debug_data'            => json_encode($this->request->post),
						'transaction_entity'    => (isset($this->request->post['transaction_entity']) ? $this->request->post['transaction_entity'] : '')
					);

					$this->model_payment_pp_express->addTransaction($transaction);

					// If there has been a refund, log this against the parent transaction.
					if (isset($this->request->post['payment_status']) && $this->request->post['payment_status'] == 'Refunded') {
						if (($this->request->post['mc_gross'] * -1) == $parent_transaction['amount']) {
							$this->model_payment_pp_express->updateTransactionStatus($parent_transaction['transaction_id'], 'Refunded');
						} else {
							$this->model_payment_pp_express->updateTransactionStatus($parent_transaction['transaction_id'], 'Partially-Refunded');
						}
					}

					// If the capture payment is now complete
					if (isset($this->request->post['auth_status']) && $this->request->post['auth_status'] == 'Completed' && $parent_transaction['payment_status'] == 'Pending') {
						$captured = $this->model_payment_pp_express->getTotalCaptured($parent_transaction['paypal_order_id']);
						$refunded = $this->model_payment_pp_express->getTotalRefunded($parent_transaction['paypal_order_id']);
						$remaining = $parent_transaction['amount'] - $captured + $refunded;

						$captured_formated = $this->currency->format($captured, false, false, false);
						$refunded_formated = $this->currency->format($refunded, false, false, false);
						$remaining_formated  = $this->currency->format($remaining, false, false, false);

						$this->model_payment_pp_express->log('Captured: ' . $captured_formated, 'IPN data');
						$this->model_payment_pp_express->log('Refunded: ' . $refunded_formated, 'IPN data');
						$this->model_payment_pp_express->log('Remaining: ' . $remaining_formated, 'IPN data');

						if ($remaining > 0) {
							$transaction = array(
								'paypal_order_id'       => $parent_transaction['paypal_order_id'],
								'transaction_id'        => '',
								'parent_transaction_id' => $this->request->post['parent_txn_id'],
								'note'                  => '',
								'msgsubid'              => '',
								'receipt_id'            => '',
								'payment_type'          => '',
								'payment_status'        => 'Void',
								'pending_reason'        => '',
								'amount'                => '',
								'debug_data'            => 'Voided after capture',
								'transaction_entity'    => 'auth'
							);

							$this->model_payment_pp_express->addTransaction($transaction);
						}

						$this->model_payment_pp_express->updateOrder('Complete', $parent_transaction['order_id']);
					}

				} else {
					// Parent transaction doesn't exists, need to investigate ?
					$this->model_payment_pp_express->log('Parent transaction not found', 'IPN data');
				}
			}

			// Subscription payments: profile ID should always exist if its a recurring payment transaction,
			// .. also the reference will match a recurring payment ID
			if (isset($this->request->post['txn_type'])) {
				$this->model_payment_pp_express->log($this->request->post['txn_type'], 'IPN data');

				// Payment
				if ($this->request->post['txn_type'] == 'recurring_payment') {
					$profile = $this->model_account_recurring->getProfileByRef($this->request->post['recurring_payment_id']);

					$this->model_payment_pp_express->log($profile, 'IPN data');

					if ($profile != false) {
						$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 1, $this->request->post['amount']);

						// As there was a payment the profile is active, ensure it is set to active (may be been suspended before)
						if ($profile['status'] != 1) {
							$this->model_account_recurring->updateOrderRecurringStatus($profile['order_recurring_id'], 2);
						}
					}
				}

				// Suspend
				if ($this->request->post['txn_type'] == 'recurring_payment_suspended') {
					$profile = $this->model_account_recurring->getProfileByRef($this->request->post['recurring_payment_id']);

					if ($profile != false) {
						$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 6);
						$this->model_account_recurring->updateOrderRecurringStatus($profile['order_recurring_id'], 3);
					}
				}

				// Suspend due to max failed
				if ($this->request->post['txn_type'] == 'recurring_payment_suspended_due_to_max_failed_payment') {
					$profile = $this->model_account_recurring->getProfileByRef($this->request->post['recurring_payment_id']);

					if ($profile != false) {
						$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 7);
						$this->model_account_recurring->updateOrderRecurringStatus($profile['order_recurring_id'], 3);
					}
				}

				// Payment failed
				if ($this->request->post['txn_type'] == 'recurring_payment_failed') {
					$profile = $this->model_account_recurring->getProfileByRef($this->request->post['recurring_payment_id']);

					if ($profile != false) {
						$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 4);
					}
				}

				// Outstanding payment failed
				if ($this->request->post['txn_type'] == 'recurring_payment_outstanding_payment_failed') {
					$profile = $this->model_account_recurring->getProfileByRef($this->request->post['recurring_payment_id']);

					if ($profile != false) {
						$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 8);
					}
				}

				// Outstanding payment
				if ($this->request->post['txn_type'] == 'recurring_payment_outstanding_payment') {
					$profile = $this->model_account_recurring->getProfileByRef($this->request->post['recurring_payment_id']);

					if ($profile != false) {
						$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 2, $this->request->post['amount']);

						// As there was a payment the profile is active, ensure it is set to active (may be been suspended before)
						if ($profile['status'] != 1) {
							$this->model_account_recurring->updateOrderRecurringStatus($profile['order_recurring_id'], 2);
						}
					}
				}

				// Created
				if ($this->request->post['txn_type'] == 'recurring_payment_profile_created') {
					$profile = $this->model_account_recurring->getProfileByRef($this->request->post['recurring_payment_id']);

					if ($profile != false) {
						$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 0);

						if ($profile['status'] != 1) {
							$this->model_account_recurring->updateOrderRecurringStatus($profile['order_recurring_id'], 2);
						}
					}
				}

				// Cancelled
				if ($this->request->post['txn_type'] == 'recurring_payment_profile_cancel') {
					$profile = $this->model_account_recurring->getProfileByRef($this->request->post['recurring_payment_id']);

					if ($profile != false && $profile['status'] != 3) {
						$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 5);
						$this->model_account_recurring->updateOrderRecurringStatus($profile['order_recurring_id'], 4);
					}
				}

				// Skipped
				if ($this->request->post['txn_type'] == 'recurring_payment_skipped') {
					$profile = $this->model_account_recurring->getProfileByRef($this->request->post['recurring_payment_id']);

					if ($profile != false) {
						$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 3);
					}
				}

				// Expired
				if ($this->request->post['txn_type'] == 'recurring_payment_expired') {
					$profile = $this->model_account_recurring->getProfileByRef($this->request->post['recurring_payment_id']);

					if ($profile != false) {
						$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 9);
						$this->model_account_recurring->updateOrderRecurringStatus($profile['order_recurring_id'], 5);
					}
				}
			}

		} elseif ((string)$response == "INVALID") {
			$this->model_payment_pp_express->log(array('IPN was invalid'), 'IPN fail');

		} else {
			$this->model_payment_pp_express->log('Response string unknown: ' . (string)$response, 'IPN data');
		}

		header("HTTP/1.1 200 Ok");
	}

	public function shipping() {
		$this->shippingValidate($this->request->post['shipping_method']);

		$this->redirect($this->url->link('payment/pp_express/expressConfirm', '', 'SSL'));
	}

	protected function shippingValidate($code) {
		$this->language->load('checkout/cart');
		$this->language->load('payment/pp_express');

		if (empty($code)) {
			$this->session->data['error_warning'] = $this->language->get('error_shipping');
			return false;
		} else {
			$shipping = explode('.', $code);

			if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
				$this->session->data['error_warning'] = $this->language->get('error_shipping');
				return false;
			} else {
				$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
				$this->session->data['success'] = $this->language->get('text_shipping_updated');
				return true;
			}
		}
	}

	protected function validateCoupon() {
		$this->load->model('checkout/coupon');

		$coupon_info = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);

		if ($coupon_info) {
			return true;
		} else {
			$this->session->data['error_warning'] = $this->language->get('error_coupon');
			return false;
		}
	}

	protected function validateVoucher() {
		$this->load->model('checkout/voucher');

		$voucher_info = $this->model_checkout_voucher->getVoucher($this->request->post['voucher']);

		if ($voucher_info) {
			return true;
		} else {
			$this->session->data['error_warning'] = $this->language->get('error_voucher');
			return false;
		}
	}

	protected function validateReward() {
		$points = $this->customer->getRewardPoints();

		$points_total = 0;

		foreach ($this->cart->getProducts() as $product) {
			if ($product['points']) {
				$points_total += $product['points'];
			}
		}

		$error = '';

		if (empty($this->request->post['reward'])) {
			$error = $this->language->get('error_reward');
		}

		if ($this->request->post['reward'] > $points) {
			$error = sprintf($this->language->get('error_points'), $this->request->post['reward']);
		}

		if ($this->request->post['reward'] > $points_total) {
			$error = sprintf($this->language->get('error_maximum'), $points_total);
		}

		if (!$error) {
			return true;
		} else {
			$this->session->data['error_warning'] = $error;
			return false;
		}
	}

	// Changed to json to be called from everywhere and return errors correctly without passing them by session.
	public function recurringCancel() {
		// Cancel an active profile. Called from the recurring info() page.
		$json = array();

		$this->language->load('account/recurring');

		if (isset($this->request->get['order_recurring_id']) && !empty($this->request->get['order_recurring_id'])) {
			$this->load->model('account/recurring');

			$profile = $this->model_account_recurring->getProfile($this->request->get['order_recurring_id']);

			if ($profile && !empty($profile['profile_reference'])) {
				$this->load->model('payment/pp_express');

				$response = $this->model_payment_pp_express->recurringCancel($profile['profile_reference']);

				if ($response === false) {
					$json['error'] = $this->language->get('error_connection');

				} elseif (is_array($response) && isset($response['PROFILEID'])) {
					$this->model_account_recurring->addOrderRecurringTransaction($profile['order_recurring_id'], 5);

					$this->model_account_recurring->updateOrderRecurringStatus($profile['order_recurring_id'], 4);

					$json['success'] = $this->language->get('success_cancelled');
				} else {
					$json['error'] = sprintf($this->language->get('error_not_cancelled'), $response['L_LONGMESSAGE0']);
				}

			} else {
				$json['error'] = $this->language->get('error_missing_profile');
			}

		} else {
			$json['error'] = $this->language->get('error_missing_data');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
