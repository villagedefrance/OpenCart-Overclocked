<?php
class ControllerProductCompare extends Controller {

	public function index() {
		$this->language->load('product/compare');

		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}

		if (isset($this->request->get['remove'])) {
			$key = array_search($this->request->get['remove'], $this->session->data['compare']);

			if ($key !== false) {
				unset($this->session->data['compare'][$key]);
			}

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->redirect($this->url->link('product/compare', '', 'SSL'));
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('product/compare', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_name'] = $this->language->get('text_name');
		$this->data['text_image'] = $this->language->get('text_image');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_model'] = $this->language->get('text_model');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_availability'] = $this->language->get('text_availability');
		$this->data['text_rating'] = $this->language->get('text_rating');
		$this->data['text_summary'] = $this->language->get('text_summary');
		$this->data['text_weight'] = $this->language->get('text_weight');
		$this->data['text_dimension'] = $this->language->get('text_dimension');
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_offer'] = $this->language->get('text_offer');
		$this->data['text_no_offer'] = $this->language->get('text_no_offer');

		$this->data['lang'] = $this->language->get('code');

		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_quote'] = $this->language->get('button_quote');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_continue'] = $this->language->get('button_continue');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['stock_checkout'] = $this->config->get('config_stock_checkout');
		$this->data['review_status'] = $this->config->get('config_review_status');
		$this->data['price_hide'] = $this->config->get('config_price_hide') ? true : false;

		$this->load->model('catalog/offer');

		$offers = $this->model_catalog_offer->getListProductOffers(0);

		$this->data['products'] = array();

		$this->data['attribute_groups'] = array();

		foreach ($this->session->data['compare'] as $key => $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_compare_width'), $this->config->get('config_image_compare_height'));
					$label_ratio = round((($this->config->get('config_image_compare_width') * $this->config->get('config_label_size_ratio')) / 100), 0);
				} else {
					$image = false;
					$label_ratio = 50;
				}

				if ($product_info['label']) {
					$label = $this->model_tool_image->resize($product_info['label'], round(($this->config->get('config_image_compare_width') / 3), 0), round(($this->config->get('config_image_compare_height') / 3), 0));
					$label_style = round(($this->config->get('config_image_compare_width') / 3), 0);
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

				if ($product_info['quantity'] <= 0) {
					$availability = $product_info['stock_status'];
					$stock_label = $this->model_tool_image->resize($this->config->get('config_label_stock'), $label_ratio, $label_ratio);
				} elseif ($this->config->get('config_stock_display')) {
					$availability = $product_info['quantity'];
					$stock_label = '';
				} else {
					$availability = $this->language->get('text_instock');
					$stock_label = '';
				}

				$attribute_data = array();

				$attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);

				foreach ($attribute_groups as $attribute_group) {
					foreach ($attribute_group['attribute'] as $attribute) {
						$attribute_data[$attribute['attribute_id']] = $attribute['text'];
					}
				}

				// Offers
				if (in_array($product_info['product_id'], $offers, true)) {
					$offer_label = $this->model_tool_image->resize($this->config->get('config_label_offer'), $label_ratio, $label_ratio);
					$offer = true;
				} else {
					$offer_label = '';
					$offer = false;
				}

				$product_offers = $this->model_catalog_offer->getOfferProducts($product_info['product_id']);

				if ($product_offers) {
					foreach ($product_offers as $product_offer) {
						if ($product_offer['one'] == $product_info['product_id']) {
							$offer_name = $this->model_catalog_offer->getOfferProductName($product_offer['two']);
							$offer_mirror_name = $this->model_catalog_offer->getOfferProductName($product_offer['one']);
							$offer_product = $product_offer['two'];
						} elseif ($product_offer['two'] == $product_info['product_id']) {
							$offer_name = $this->model_catalog_offer->getOfferProductName($product_offer['one']);
							$offer_mirror_name = $this->model_catalog_offer->getOfferProductName($product_offer['two']);
							$offer_product = $product_offer['one'];
						} else {
							$offer_name = '';
							$offer_mirror_name = '';
							$offer_product = '';
						}

						if ($product_offer['group'] == 'G241') {
							$offer_description = sprintf($this->language->get('text_G241'), $product_offer['type']);
						} elseif ($product_offer['group'] == 'G241D') {
							$offer_description = sprintf($this->language->get('text_G241D'), $offer_mirror_name, $offer_name, $product_offer['type']);
						} elseif ($product_offer['group'] == 'G242D') {
							$offer_description = sprintf($this->language->get('text_G242D'), $offer_mirror_name, $offer_name, $product_offer['type']);
						} elseif ($product_offer['group'] == 'G142D') {
							$offer_description = sprintf($this->language->get('text_G142D'), $product_offer['type'], $offer_mirror_name, $offer_name);
						} else {
							$offer_description = '';
						}
					}

				} else {
					$offer_product = '';
					$offer_description = '';
				}

				if ($product_info['quote']) {
					$quote = $this->url->link('information/quote', '', 'SSL');
				} else {
					$quote = false;
				}

				$this->data['products'][$product_id] = array(
					'product_id'        => $product_info['product_id'],
					'name'              => $product_info['name'],
					'thumb'             => $image,
					'label'             => $label,
					'label_style'       => $label_style,
					'stock_label'       => $stock_label,
					'offer_label'       => $offer_label,
					'special_label'     => $special_label,
					'offer'             => $offer,
					'quote'             => $quote,
					'price'             => $price,
					'special'           => $special,
					'description'       => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 300) . '..',
					'model'             => $product_info['model'],
					'manufacturer'      => $product_info['manufacturer'],
					'availability'      => $availability,
					'stock_status'      => $product_info['stock_status'],
					'stock_quantity'    => $product_info['quantity'],
					'stock_remaining'   => ($product_info['subtract']) ? sprintf($this->language->get('text_remaining'), $product_info['quantity']) : '',
					'offer_href'        => $this->url->link('product/product', 'product_id=' . $offer_product, 'SSL'),
					'offer_description' => $offer_description,
					'rating'            => (int)$product_info['rating'],
					'reviews'           => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'weight'            => $this->weight->format($product_info['weight'], $product_info['weight_class_id']),
					'length'            => $this->length->format($product_info['length'], $product_info['length_class_id']),
					'width'             => $this->length->format($product_info['width'], $product_info['length_class_id']),
					'height'            => $this->length->format($product_info['height'], $product_info['length_class_id']),
					'attribute'         => $attribute_data,
					'href'              => $this->url->link('product/product', 'product_id=' . $product_id, 'SSL'),
					'remove'            => $this->url->link('product/compare', 'remove=' . $product_id, 'SSL')
				);

				foreach ($attribute_groups as $attribute_group) {
					$this->data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];

					foreach ($attribute_group['attribute'] as $attribute) {
						$this->data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
					}
				}

			} else {
				unset($this->session->data['compare'][$key]);
			}
		}

		$this->data['continue'] = $this->url->link('common/home', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/compare.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/compare.tpl';
		} else {
			$this->template = 'default/template/product/compare.tpl';
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

	public function add() {
		$this->language->load('product/compare');

		$json = array();

		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (!in_array($this->request->post['product_id'], $this->session->data['compare'])) {
				if (count($this->session->data['compare']) >= 4) {
					array_shift($this->session->data['compare']);
				}

				$this->session->data['compare'][] = $this->request->post['product_id'];
			}

			$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id'], 'SSL'), $product_info['name'], $this->url->link('product/compare', '', 'SSL'));

			$json['total'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare'])) ? count($this->session->data['compare']) : 0);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
