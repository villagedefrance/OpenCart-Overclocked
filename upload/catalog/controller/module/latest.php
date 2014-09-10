<?php
class ControllerModuleLatest extends Controller {
	private $_name = 'latest';

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

		$this->data['text_offer'] = $this->language->get('text_offer');

		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_cart'] = $this->language->get('button_cart');

		$this->data['viewproduct'] = $this->config->get($this->_name . '_viewproduct');
		$this->data['addproduct'] = $this->config->get($this->_name . '_addproduct');

		// Latest
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$this->data['label'] = $this->config->get('config_offer_label');

		$this->load->model('catalog/offer');

		$offers = $this->model_catalog_offer->getListProductOffers(0);

		$this->data['products'] = array();

		$data = array(
			'sort'  	=> 'p.date_added',
			'order' 	=> 'DESC',
			'start' 	=> 0,
			'limit' 		=> $setting['limit']
		);

		$results = $this->model_catalog_product->getProducts($data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}

			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}

			if (in_array($result['product_id'], $offers, true)) {
				$offer = true;
			} else {
				$offer = false;
			}

			$this->data['products'][] = array(
				'product_id'	=> $result['product_id'],
				'thumb'  		=> $image,
				'offer'			=> $offer,
				'name'  		=> $result['name'],
				'price'   		=> $price,
				'special' 		=> $special,
				'rating' 		=> $rating,
				'reviews' 	=> sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'   		=> $this->url->link('product/product', 'product_id=' . $result['product_id'])
			);
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