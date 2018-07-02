<?php
class ControllerModuleFeatured extends Controller {
	private $_name = 'featured';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme');
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		if (!$this->data['title']) {
			$this->data['title'] = $this->data['heading_title'];
		}

		$this->data['text_from'] = $this->language->get('text_from');
		$this->data['text_model'] = $this->language->get('text_model');
		$this->data['text_reward'] = $this->language->get('text_reward');
		$this->data['text_points'] = $this->language->get('text_points');
		$this->data['text_offer'] = $this->language->get('text_offer');

		$this->data['lang'] = $this->language->get('code');

		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_quote'] = $this->language->get('button_quote');
		$this->data['button_compare'] = $this->language->get('button_compare');
		$this->data['button_wishlist'] = $this->language->get('button_wishlist');

		$this->data['brand'] = $this->config->get($this->_name . '_brand');
		$this->data['model'] = $this->config->get($this->_name . '_model');
		$this->data['reward'] = $this->config->get($this->_name . '_reward');
		$this->data['point'] = $this->config->get($this->_name . '_point');
		$this->data['review'] = $this->config->get($this->_name . '_review');

		$this->data['viewproduct'] = $this->config->get($this->_name . '_viewproduct');
		$this->data['addproduct'] = $this->config->get($this->_name . '_addproduct');

		$this->data['stock_checkout'] = $this->config->get('config_stock_checkout');
		$this->data['price_hide'] = $this->config->get('config_price_hide') ? true : false;

		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/product');
		$this->load->model('catalog/offer');
		$this->load->model('tool/image');

		$offers = $this->model_catalog_offer->getListProductOffers(0);

		$this->data['manufacturers'] = array();

		$results = $this->model_catalog_manufacturer->getManufacturers(0);

		foreach ($results as $result) {
			$this->data['manufacturers'][] = array(
				'store_id'        => $result['store_id'],
				'manufacturer_id' => $result['manufacturer_id'],
				'name'            => $result['name'],
				'href'            => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'], 'SSL')
			);
		}

		$this->data['products'] = array();

		$get_products = explode(',', $this->config->get('featured_product'));

		$products = array_reverse($get_products, false);

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
					$label_ratio = round((($setting['image_width'] * $this->config->get('config_label_size_ratio')) / 100), 0);
				} else {
					$image = false;
					$label_ratio = 50;
				}

				if ($product_info['label']) {
					$label = $this->model_tool_image->resize($product_info['label'], round(($setting['image_width'] / 3), 0), round(($setting['image_height'] / 3), 0));
					$label_style = round(($setting['image_width'] / 3), 0);
				} else {
					$label = '';
					$label_style = '';
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					if (($product_info['price'] == '0.0000') && $this->config->get('config_price_free')) {
						$price = $this->language->get('text_free');
					} else {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					}
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special_label = $this->model_tool_image->resize($this->config->get('config_label_special'), $label_ratio, $label_ratio);
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special_label = false;
					$special = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}

				if ($product_info['manufacturer']) {
					$manufacturer = $product_info['manufacturer'];
				} else {
					$manufacturer = false;
				}

				if ($product_info['model']) {
					$model = $product_info['model'];
				} else {
					$model = false;
				}

				if ($product_info['reward']) {
					$reward = $product_info['reward'];
				} else {
					$reward = false;
				}

				if ($product_info['points']) {
					$points = $product_info['points'];
				} else {
					$points = false;
				}

				if ($product_info['quantity'] <= 0) {
					$stock_label = $this->model_tool_image->resize($this->config->get('config_label_stock'), $label_ratio, $label_ratio);
				} else {
					$stock_label = false;
				}

				if (in_array($product_info['product_id'], $offers, true)) {
					$offer_label = $this->model_tool_image->resize($this->config->get('config_label_offer'), $label_ratio, $label_ratio);
					$offer = true;
				} else {
					$offer_label = false;
					$offer = false;
				}

				if ($product_info['quote']) {
					$quote = $this->url->link('information/quote', '', 'SSL');
				} else {
					$quote = false;
				}

				$this->data['products'][] = array(
					'product_id'      => $product_info['product_id'],
					'thumb'           => $image,
					'label'           => $label,
					'label_style'     => $label_style,
					'stock_label'     => $stock_label,
					'offer_label'     => $offer_label,
					'special_label'   => $special_label,
					'offer'           => $offer,
					'name'            => $product_info['name'],
					'manufacturer'    => $manufacturer,
					'model'           => $model,
					'reward'          => $reward,
					'points'          => $points,
					'stock_status'    => $product_info['stock_status'],
					'stock_quantity'  => $product_info['quantity'],
					'stock_remaining' => ($product_info['subtract']) ? sprintf($this->language->get('text_remaining'), $product_info['quantity']) : '',
					'quote'           => $quote,
					'price'           => $price,
					'price_option'    => $this->model_catalog_product->hasOptionPriceIncrease($product_info['product_id']),
					'special'         => $special,
					'minimum'         => ($product_info['minimum'] > 0) ? $product_info['minimum'] : 1,
					'age_minimum'     => ($product_info['age_minimum'] > 0) ? $product_info['age_minimum'] : '',
					'rating'          => (int)$rating,
					'reviews'         => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'href'            => $this->url->link('product/product', 'product_id=' . $product_info['product_id'], 'SSL')
				);
			}
		}

		$this->data['module'] = $module++;

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
		} else {
			$this->template = 'default/template/module/' . $this->_name . '.tpl';
		}

		$this->render();
	}
}
