<?php
class ControllerModuleCart extends Controller {

	public function index() {
		$this->language->load('module/cart');

		if (isset($this->request->get['remove'])) {
			$this->cart->remove($this->request->get['remove']);

			unset($this->session->data['vouchers'][$this->request->get['remove']]);
		}

		// Totals
		$this->load->model('setting/extension');

		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

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

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}
		}

		$price_hide = $this->config->get('config_price_hide') ? true : false;

		$this->data['totals'] = $total_data;

		$this->data['heading_title'] = $this->language->get('heading_title');

		if (!$price_hide) {
			$this->data['text_items'] = sprintf($this->language->get('text_items_price'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
		} else {
			$this->data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0));
		}

		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		$this->data['text_payment_profile'] = $this->language->get('text_payment_profile');

		$this->data['button_remove'] = $this->language->get('button_remove');

		$this->data['lang'] = $this->language->get('code');

		$this->load->model('catalog/offer');
		$this->load->model('tool/image');

		$offers = $this->model_catalog_offer->getListProductOffers(0);

		$this->data['products'] = array();

		foreach ($this->cart->getProducts() as $product) {
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				$label_ratio = round((($this->config->get('config_image_cart_width') * $this->config->get('config_label_size_ratio')) / 100), 0);
			} else {
				$image = '';
				$label_ratio = 30;
			}

			if ((float)$product['special']) {
				$special_label = $this->model_tool_image->resize($this->config->get('config_label_special'), $label_ratio, $label_ratio);
				$special = true;
			} else {
				$special_label = false;
				$special = false;
			}

			if ($product['quantity'] <= 0) {
				$stock_label = $this->model_tool_image->resize($this->config->get('config_label_stock'), $label_ratio, $label_ratio);
			} else {
				$stock_label = false;
			}

			if (in_array($product['product_id'], $offers, true)) {
				$offer_label = $this->model_tool_image->resize($this->config->get('config_label_offer'), $label_ratio, $label_ratio);
				$offer = true;
			} else {
				$offer_label = false;
				$offer = false;
			}

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
					'value' => (utf8_strlen($value) > 20) ? utf8_substr($value, 0, 20) . '..' : $value,
					'type'  => $option['type']
				);
			}

			// Display price
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}

			// Display total
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
			} else {
				$total = false;
			}

			$this->data['products'][] = array(
				'key'           => $product['key'],
				'thumb'         => $image,
				'stock_label'   => $stock_label,
				'offer_label'   => $offer_label,
				'special_label' => $special_label,
				'offer'         => $offer,
				'name'          => $product['name'],
				'model'         => $product['model'],
				'option'        => $option_data,
				'quantity'      => $product['quantity'],
				'price'         => $price,
				'special'       => $special,
				'total'         => $total,
				'recurring'     => $product['recurring'],
				'profile'       => $product['profile_name'],
				'href'          => $this->url->link('product/product', 'product_id=' . $product['product_id'], 'SSL')
			);
		}

		// Gift Voucher
		$this->data['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$this->data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'])
				);
			}
		}

		$this->data['cart'] = $this->url->link('checkout/cart', '', 'SSL');
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cart.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/cart.tpl';
		} else {
			$this->template = 'default/template/module/cart.tpl';
		}

		$this->response->setOutput($this->render());
	}
}
