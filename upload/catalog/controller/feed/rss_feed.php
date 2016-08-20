<?php
class ControllerFeedRSSFeed extends Controller {
	private $_name = 'rss_feed';

	public function index() {
		if ($this->config->get('rss_feed_status')) {
			$output = '<?xml version="1.0" encoding="UTF-8" ?>';
			$output .= '<rss version="2.0">';
			$output .= '<channel>';
			$output .= '<title><![CDATA[' . $this->config->get('config_name') . ']]></title>';
			$output .= '<description><![CDATA[' . $this->config->get('config_meta_description') . ']]></description>';
			$output .= '<language><![CDATA[' . $this->language->get('code') . ']]></language>';
			$output .= '<link><![CDATA[' . HTTP_SERVER . ']]></link>';

			$this->load->model('catalog/product');
			$this->load->model('localisation/currency');
			$this->load->model('tool/image');

			$limit = $this->config->get($this->_name . '_limit') ? $this->config->get($this->_name . '_limit') : 100;

			$show_price = $this->config->get($this->_name . '_show_price');
			$include_tax = $this->config->get($this->_name . '_include_tax');
			$show_image = $this->config->get($this->_name . '_show_image');

			if ($show_image) {
				$image_width = $this->config->get($this->_name . '_image_width') ? $this->config->get($this->_name . '_image_width') : 100;
				$image_height = $this->config->get($this->_name . '_image_height') ? $this->config->get($this->_name . '_image_height') : 100;
			}

			$products = $this->model_catalog_product->getLatestProducts($limit);

			if (isset($this->request->get['currency'])) {
				$currency = $this->request->get['currency'];
			} else {
				$currency = $this->currency->getCode();
			}

			foreach ($products as $product) {
				if ($product['description']) {
					$title = $product['name'];

					// Redirects to All products (SEO Url is ON)
					$link = $this->url->link('product/product_list');

					$description = "";

					if ($show_price) {
						if ($include_tax) {
							if ((float)$product['special']) {
								$price = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id']), $currency, false, true);
							} else {
								$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id']), $currency, false, true);
							}
						} else {
							if ((float)$product['special']) {
								$price = $this->currency->format($product['special'], $currency, false, true);
							} else {
								$price = $this->currency->format($product['price'], $currency, false, true);
							}
						}

						$description .= '<p><strong>' . $price . '</strong></p>';
					}

					if ($show_image) {
						$image_url = $this->model_tool_image->resize($product['image'], $image_width, $image_height);
						$description .= '<p><a href="' . $link . '"><img src="' . $image_url . '"></a></p>';
					}

					$description .= html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8');

					$output .= '<item>';
					$output .= '<title><![CDATA[' . $title . ']]></title>';
					$output .= '<link><![CDATA[' . $link . ']]></link>';
					$output .= '<description><![CDATA[' . $description . ']]></description>';
					$output .= '<guid isPermaLink="false"><![CDATA[' . $link . '-' . $product['product_id'] . ']]></guid>';
					$output .= '<pubDate><![CDATA[' . date(DATE_RFC822, strtotime($product['date_added'])) . ']]></pubDate>';
					$output .= '</item>';
				}
			}

			$output .= '</channel>';
			$output .= '</rss>';

			$this->response->addHeader('Content-Type: application/rss+xml');
			$this->response->setOutput($output);
		}
	}
}
?>
