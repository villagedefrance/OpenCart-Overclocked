<?php
class ControllerCheckoutExpressPaymentMethod extends Controller {

	public function index() {
		$this->language->load('checkout/checkout_express');

		if ($this->config->get('config_express_reward') == 2) {
			$points = $this->customer->getRewardPoints();

			$points_total = 0;

			foreach ($this->cart->getProducts() as $product) {
				if ($product['points']) {
					$points_total += $product['points'];
				}
			}

			$points = min ($points, $points_total);

			if ($points && $this->config->get('reward_status') && $this->config->get('buy_reward')) {
				$this->session->data['reward'] = $points;
			}
		}

		$this->load->model('account/address');

		if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
			$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
		} elseif (isset($this->session->data['guest'])) {
			$payment_address = $this->session->data['guest']['payment'];
		}

		if (empty($payment_address) && !$this->config->get('config_express_billing')) {
			if (isset($this->session->data['shipping_country_id'])) {
				$payment_address['country_id'] = $this->session->data['shipping_country_id'];
			} else {
				$payment_address['country_id'] = $this->config->get('config_country_id');
			}

			if (isset($this->session->data['shipping_zone_id'])) {
				$payment_address['zone_id'] = $this->session->data['shipping_zone_id'];
			} else {
				$payment_address['zone_id'] = '';
			}
		}

		if (!empty($payment_address)) {
			// Totals
			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			$this->load->model('setting/extension');

			$sort_order = array();

			$total_results = $this->model_setting_extension->getExtensions('total');

			foreach ($total_results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $total_results);

			foreach ($total_results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}

			// Payment Methods
			$method_data = array();

			$payment_results = $this->model_setting_extension->getExtensions('payment');

			$cart_has_recurring = $this->cart->hasRecurringProducts();

			foreach ($payment_results as $result) {
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

			$this->session->data['payment_methods'] = $method_data;
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

		$this->data['paypal_fee_fee'] = $this->currency->format($paypal_fee);

		// Language
		$this->data['text_checkout_payment_method'] = $this->language->get('text_checkout_payment_method');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_comments'] = $this->language->get('text_comments');

		$this->data['button_express_go'] = $this->language->get('button_express_go');

		$this->data['express_comment'] = $this->config->get('config_express_comment');

		if (empty($this->session->data['payment_methods'])) {
			$this->data['error_warning'] = sprintf($this->language->get('error_no_payment'), $this->url->link('information/contact', '', 'SSL'));
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['payment_methods'])) {
			$this->data['payment_methods'] = $this->session->data['payment_methods'];
		} else {
			$this->data['payment_methods'] = array();
		}

		if (isset($this->session->data['payment_method']['code'])) {
			$this->data['code'] = $this->session->data['payment_method']['code'];
		} else {
			$this->data['code'] = '';
		}

		if (isset($this->session->data['comment'])) {
			$this->data['comment'] = $this->session->data['comment'];
		} else {
			$this->data['comment'] = '';
		}

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

		if (isset($this->session->data['agree'])) {
			$this->data['agree'] = $this->session->data['agree'];
		} else {
			$this->data['agree'] = '';
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout_express/payment_method.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout_express/payment_method.tpl';
		} else {
			$this->template = 'default/template/checkout_express/payment_method.tpl';
		}

		$this->response->setOutput($this->render());
	}

	public function validate() {
		$this->language->load('checkout/checkout_express');

		$json = array();

		// Validate if payment address has been set
		$this->load->model('account/address');

		if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
			$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
		} elseif (isset($this->session->data['guest'])) {
			$payment_address = $this->session->data['guest']['payment'];
		}

		if (empty($payment_address) && !$this->config->get('config_express_billing')) {
			if (isset($this->session->data['shipping_country_id'])) {
				$payment_address['country_id'] = $this->session->data['shipping_country_id'];
			} else {
				$payment_address['country_id'] = $this->config->get('config_country_id');
			}

			if (isset($this->session->data['shipping_zone_id'])) {
				$payment_address['zone_id'] = $this->session->data['shipping_zone_id'];
			} else {
				$payment_address['zone_id'] = '';
			}
        }

		if (empty($payment_address)) {
			$json['redirect'] = $this->url->link('checkout_express/checkout', '', 'SSL');
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

		if (!$json) {
			if (!isset($this->request->post['payment_method'])) {
				$json['error']['warning'] = $this->language->get('error_payment');
			} else {
				if (!isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
					$json['error']['warning'] = $this->language->get('error_payment');
				}
			}

			if ($this->config->get('config_checkout_id')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

				if ($information_info && !isset($this->request->post['agree'])) {
					$json['error']['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
				}
			}

			if (!$json) {
				$this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];

				$this->session->data['comment'] = strip_tags($this->request->post['comment']);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
