<?php
class ControllerFeedRSSFeed extends Controller {

	public function index() {
		if ($this->config->get('rss_feed_status')) {
			$output = '<?xml version="1.0" encoding="UTF-8" ?>';
			$output .= '<rss version="2.0">';
			$output .= '<channel>';
			$output .= '<title><![CDATA[' . $this->config->get('config_name') . ']]></title>';
			$output .= '<description><![CDATA[' . $this->config->get('config_meta_description') . ']]></description>';
			$output .= '<language><![CDATA[' . $this->language->get('code') . ']]></language>';
			$output .= '<link><![CDATA[' . HTTP_SERVER . ']]></link>';

			$show_price = $this->config->get('rss_feed_show_price');
			$include_tax = $this->config->get('rss_feed_include_tax');

			$limit = ($this->config->get('rss_feed_limit')) ? $this->config->get('rss_feed_limit') : 100;

			if ($this->config->get('rss_feed_show_image')) {
				$show_image = true;
			} else {
				$show_image = false;
			}

			$this->load->model('tool/image');

			$image_width = ($this->config->get('rss_feed_image_width')) ? $this->config->get('rss_feed_image_width') : 100;
			$image_height = ($this->config->get('rss_feed_image_height')) ? $this->config->get('rss_feed_image_height') : 100;

			if (isset($this->request->get['currency'])) {
				$currency = $this->request->get['currency'];
			} else {
				$currency = $this->currency->getCode();
			}

			$this->load->model('catalog/product');

			$products = $this->model_catalog_product->getLatestProducts($limit);

			foreach ($products as $product) {
				if ($product['image'] && file_exists(DIR_IMAGE . $product['image'])) {
					$image = $this->model_tool_image->resize($product['image'], $image_width, $image_height);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				}

				if ($product['description']) {
					$title = html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8');

					// Redirects to All products (SEO Url is ON)
					$link = $this->url->link('product/product_list', '', 'SSL');

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

						$description .= '<p><strong>' . $price . ' </strong></p>';
					}

					if ($show_image) {
						$description .= '<p><a href="' . $link . '" title=""><img src="' . $image . '" alt="' . $title . '"></a></p>';
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
