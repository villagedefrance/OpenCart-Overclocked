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

		$this->data['text_model'] = $this->language->get('text_model');
		$this->data['text_reward'] = $this->language->get('text_reward');
		$this->data['text_points'] = $this->language->get('text_points');
		$this->data['text_offer'] = $this->language->get('text_offer');

		$this->data['lang'] = $this->language->get('code');

		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_cart'] = $this->language->get('button_cart');

		$this->data['brand'] = $this->config->get($this->_name . '_brand');
		$this->data['model'] = $this->config->get($this->_name . '_model');
		$this->data['reward'] = $this->config->get($this->_name . '_reward');
		$this->data['point'] = $this->config->get($this->_name . '_point');
		$this->data['review'] = $this->config->get($this->_name . '_review');

		$this->data['viewproduct'] = $this->config->get($this->_name . '_viewproduct');
		$this->data['addproduct'] = $this->config->get($this->_name . '_addproduct');

		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$this->data['manufacturers'] = array();

		$results = $this->model_catalog_manufacturer->getManufacturers(0);

		foreach ($results as $result) {
			$this->data['manufacturers'][] = array(
				'store_id' 			=> $result['store_id'],
				'manufacturer_id'	=> $result['manufacturer_id'],
				'name' 				=> $result['name'],
				'href' 					=> $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
			);
		}

		$this->data['label'] = $this->config->get('config_offer_label');

		$this->load->model('catalog/offer');

		$offers = $this->model_catalog_offer->getListProductOffers(0);

		$this->data['products'] = array();

		$products = explode(',', $this->config->get('featured_product'));

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
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

				if (in_array($product_info['product_id'], $offers, true)) {
					$offer = true;
				} else {
					$offer = false;
				}

				$this->data['products'][] = array(
					'product_id'		=> $product_info['product_id'],
					'thumb'   	 	=> $image,
					'offer'       		=> $offer,
					'name'    	 	=> $product_info['name'],
					'manufacturer'	=> $product_info['manufacturer'],
					'model' 			=> $product_info['model'],
					'reward' 			=> $product_info['reward'],
					'points' 			=> $product_info['points'],
					'price'   	  		=> $price,
					'special' 	 		=> $special,
					'minimum'		=> $product_info['minimum'] > 0 ? $product_info['minimum'] : 1,
					'rating'     		=> (int)$rating,
					'reviews'    		=> sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'href'    	 		=> $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
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
?>