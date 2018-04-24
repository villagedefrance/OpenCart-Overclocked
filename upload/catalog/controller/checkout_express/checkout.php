<?php
class ControllerCheckoutExpressCheckout extends Controller {
	private $error = array();

	public function index() {
		if ($this->config->get('config_one_page_checkout')) {
			$this->redirect($this->url->link('checkout/checkout_one_page', '', 'SSL'));
		}

		if ($this->config->get('config_secure') && !$this->request->isSecure()) {
			$this->redirect($this->url->link('checkout/checkout_express', '', 'SSL'));
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->redirect($this->url->link('checkout/cart', '', 'SSL'));
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
				$this->redirect($this->url->link('checkout/cart', '', 'SSL'));
				break;
			}

			// Validate minimum age
			if ($this->config->get('config_customer_dob') && ($product['age_minimum'] > 0)) {
				if (!$this->customer->isLogged() || !$this->customer->isSecure()) {
					$this->redirect($this->url->link('checkout/login', '', 'SSL'));
				}
			}
		}

		$this->language->load('checkout/checkout_express');
		$this->language->load('total/gift_wrapping');

		$this->document->setTitle($this->language->get('heading_express'));

		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');

		// Coupon session
		if (isset($this->request->post['coupon']) && $this->validateCoupon()) {
			unset($this->session->data['coupon']);

			$this->session->data['coupon'] = $this->request->post['coupon'];
			$this->session->data['success'] = $this->language->get('text_coupon');

			$this->redirect($this->url->link('checkout_express/checkout', '', 'SSL'));
		}

		// Voucher session
		if (!isset($this->session->data['vouchers'])) {
			$this->session->data['vouchers'] = array();
		}

		if (isset($this->request->post['voucher']) && $this->validateVoucher()) {
			unset($this->session->data['voucher']);

			$this->session->data['voucher'] = $this->request->post['voucher'];
			$this->session->data['success'] = $this->language->get('text_voucher');

			$this->redirect($this->url->link('checkout_express/checkout', '', 'SSL'));
		}

		// Reward session
		if (isset($this->request->post['reward']) && $this->validateReward()) {
			unset($this->session->data['reward']);

			$this->session->data['reward'] = abs($this->request->post['reward']);
			$this->session->data['success'] = $this->language->get('text_reward');

			$this->redirect($this->url->link('checkout_express/checkout', '', 'SSL'));
		}

		// Add Wrapping
		if (isset($this->request->post['add_wrapping'])) {
			unset($this->session->data['order_id']);

			$this->session->data['wrapping'] = $this->request->post['add_wrapping'];
			$this->session->data['success'] = $this->language->get('text_add_wrapping');

			$this->redirect($this->url->link('checkout/checkout_one_page', '', 'SSL'));
		}

		// Remove Wrapping
		if (isset($this->request->post['remove_wrapping'])) {
			unset($this->session->data['order_id']);
			unset($this->session->data['wrapping']);

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
			'text'      => $this->language->get('heading_express'),
			'href'      => $this->url->link('checkout_express/checkout', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} elseif (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
			$this->data['error_warning'] = $this->language->get('error_stock');
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('checkout_express/checkout', '', 'SSL');

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
					'remove'      => $this->url->link('checkout_express/checkout', 'remove=' . $key, 'SSL')
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

		if ($points && $points_total && $this->config->get('reward_status')) {
			$this->data['reward_point'] = true;
		} else {
			$this->data['reward_point'] = false;
		}

		if ($this->config->get('config_express_point') == 2) {
			$this->data['show_point'] = false;

			if ($points && $this->config->get('reward_status')) {
				$this->session->data['reward'] = $reward_points * $points_rate;
			}
		} elseif ($this->config->get('config_express_point') == 1) {
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

		$this->data['heading_title'] = $this->language->get('heading_express');

		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_your_address'] = $this->language->get('text_your_address');
		$this->data['text_checkout_option'] = $this->language->get('text_checkout_option');
		$this->data['text_checkout_account'] = $this->language->get('text_checkout_account');
		$this->data['text_checkout_payment_address'] = $this->language->get('text_checkout_payment_address');
		$this->data['text_checkout_shipping_address'] = $this->language->get('text_checkout_shipping_address');
		$this->data['text_checkout_shipping_method'] = $this->language->get('text_checkout_shipping_method');
		$this->data['text_checkout_payment_method'] = $this->language->get('text_checkout_payment_method');
		$this->data['text_checkout_confirm'] = $this->language->get('text_checkout_confirm');
		$this->data['text_express_coupon'] = $this->language->get('text_express_coupon');
		$this->data['text_express_voucher'] = $this->language->get('text_express_voucher');
		$this->data['text_express_reward'] = sprintf($this->language->get('text_express_reward'), $available_points);
		$this->data['text_wait'] = $this->language->get('text_wait');

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

		$this->data['express_billing'] = $this->config->get('config_express_billing');

		$this->data['express_address'] = $this->url->link('checkout_express/checkout', '', 'SSL');
		$this->data['express_cart'] = $this->url->link('checkout/cart', '', 'SSL');

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

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout_express/checkout.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout_express/checkout.tpl';
		} else {
			$this->template = 'default/template/checkout_express/checkout.tpl';
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
