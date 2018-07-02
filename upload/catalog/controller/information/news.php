<?php
class ControllerInformationNews extends Controller {

	public function index() {
		$this->language->load('information/news');

		$this->load->model('catalog/news');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		if (isset($this->request->get['news_id'])) {
			$news_id = $this->request->get['news_id'];
		} else {
			$news_id = 0;
		}

		$news_info = $this->model_catalog_news->getNewsStory($news_id);

		if ($news_info) {
			$this->document->setTitle($news_info['title']);
			$this->document->setDescription($news_info['meta_description']);

			$this->model_catalog_news->updateViewed($news_id);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('information/news_list', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $news_info['title'],
				'href'      => $this->url->link('information/news', 'news_id=' . $news_id, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['news_info'] = $news_info;

			$this->data['heading_title'] = $news_info['title'];

			$this->data['text_no_results'] = $this->language->get('text_no_results');
			$this->data['text_related_download'] = $this->language->get('text_related_download');
			$this->data['text_related_product'] = $this->language->get('text_related_product');
			$this->data['text_from'] = $this->language->get('text_from');

			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_view'] = $this->language->get('button_view');
			$this->data['button_quote'] = $this->language->get('button_quote');
			$this->data['button_wishlist'] = $this->language->get('button_wishlist');
			$this->data['button_news'] = $this->language->get('button_news');
			$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['button_download'] = $this->language->get('button_download');

			$this->data['description'] = html_entity_decode($news_info['description'], ENT_QUOTES, 'UTF-8');
			$this->data['viewed'] = sprintf($this->language->get('text_viewed'), $news_info['viewed']);

			$this->data['news'] = $this->url->link('information/news_list', '', 'SSL');
			$this->data['continue'] = $this->url->link('common/home', '', 'SSL');

			$this->data['stock_checkout'] = $this->config->get('config_stock_checkout');

			// Image
			$this->load->model('tool/image');

			if ($news_info['lightbox'] == 'viewbox') {
				$this->document->addStyle('catalog/view/javascript/jquery/viewbox/viewbox.min.css');
				$this->document->addScript('catalog/view/javascript/jquery/viewbox/jquery.viewbox.min.js');

				if ($news_info['image']) {
					$this->data['thumb'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('config_image_newsthumb_width'), $this->config->get('config_image_newsthumb_height'));
				} else {
					$this->data['thumb'] = '';
				}

				$this->data['lightbox'] = 'viewbox';

			} elseif ($news_info['lightbox'] == 'magnific') {
				$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific.css');
				$this->document->addScript('catalog/view/javascript/jquery/magnific/magnific.min.js');

				if ($news_info['image']) {
					$this->data['thumb'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('config_image_newsthumb_width'), $this->config->get('config_image_newsthumb_height'));
				} else {
					$this->data['thumb'] = '';
				}

				$this->data['lightbox'] = 'magnific';

			} elseif ($news_info['lightbox'] == 'fancybox') {
				$this->document->addStyle('catalog/view/javascript/jquery/fancybox-plus/css/jquery.fancybox-plus.css');
				$this->document->addScript('catalog/view/javascript/jquery/fancybox-plus/js/jquery.fancybox-plus.min.js');

				if ($news_info['image']) {
					$this->data['thumb'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('config_image_newsthumb_width'), $this->config->get('config_image_newsthumb_height'));
				} else {
					$this->data['thumb'] = '';
				}

				$this->data['lightbox'] = 'fancybox';

			} else {
				$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
				$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');

				if ($news_info['image']) {
					$this->data['thumb'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('config_image_newsthumb_width'), $this->config->get('config_image_newsthumb_height'));
				} else {
					$this->data['thumb'] = '';
				}

				$this->data['lightbox'] = 'colorbox';
			}

			if ($news_info['image']) {
				$this->data['popup'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('config_image_newspopup_width'), $this->config->get('config_image_newspopup_height'));
			} else {
				$this->data['popup'] = '';
			}

			// AddThis
			if ($this->config->get('config_addthis')) {
				$this->data['addthis'] = $this->config->get('config_addthis');
			} else {
				$this->data['addthis'] = false;
			}

			if ($this->config->get('config_news_addthis')) {
				$this->data['news_addthis'] = $this->config->get('config_news_addthis');
			} else {
				$this->data['news_addthis'] = false;
			}

			// Downloads
			$this->data['downloads'] = array();

			$download_results = $this->model_catalog_news->getNewsDownloads($news_id);

			if ($download_results) {
				$this->data['download_files'] = array();

				$files = $this->model_catalog_news->getDownloads();

				foreach ($files as $file) {
					$this->data['download_files'][] = array(
						'news_download_id' => $file['news_download_id'],
						'filename'         => $file['filename'],
						'mask'             => $file['mask'],
						'date_added'       => $file['date_added']
					);

					foreach ($download_results as $result) {
						if ($file['news_download_id'] == $result['news_download_id']) {
							if (file_exists(DIR_DOWNLOAD . $file['filename']) && is_file(DIR_DOWNLOAD . $file['filename'])) {
								$size = filesize(DIR_DOWNLOAD . $file['filename']);

								$i = 0;

								$suffix = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');

								while (($size / 1024) > 1) {
									$size = $size / 1024; $i++;
								}
							}

							$this->data['downloads'][] = array(
								'news_download_id' => $file['news_download_id'],
								'name'             => $file['mask'],
								'size'             => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
								'date_added'       => date($this->language->get('date_format_short'), strtotime($file['date_added'])),
								'href'             => $this->url->link('information/news/download', 'news_download_id=' . (int)$file['news_download_id'], 'SSL')
							);
						}
					}
				}

			} else {
				$this->data['downloads'] = '';
			}

			// Related products
			$this->load->model('catalog/product');
			$this->load->model('catalog/offer');
			$this->load->model('account/customer');

			$offers = $this->model_catalog_offer->getListProductOffers(0);

			$related_product = $this->model_catalog_news->getNewsProductRelated($news_id);

			$this->data['products'] = array();

			foreach ($related_product as $product) {
				$product_info = $this->model_catalog_product->getProduct($product['product_id']);

				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], 100, 100);
				} else {
					$image = false;
				}

				if ($product_info['manufacturer']) {
					$manufacturer = $product_info['manufacturer'];
				} else {
					$manufacturer = false;
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
					$special_label = $this->model_tool_image->resize($this->config->get('config_label_special'), 50, 50);
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special_label = false;
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$product_info['rating'];
				} else {
					$rating = false;
				}

				if ($product_info['quantity'] <= 0) {
					$stock_label = $this->model_tool_image->resize($this->config->get('config_label_stock'), 50, 50);
				} else {
					$stock_label = false;
				}

				if (in_array($product_info['product_id'], $offers, true)) {
					$offer_label = $this->model_tool_image->resize($this->config->get('config_label_offer'), 50, 50);
					$offer = true;
				} else {
					$offer_label = false;
					$offer = false;
				}

				$age_logged = false;
				$age_checked = false;

				if ($this->config->get('config_customer_dob') && ($product_info['age_minimum'] > 0)) {
					if ($this->customer->isLogged() && $this->customer->isSecure()) {
						$age_logged = true;

						$date_of_birth = $this->model_account_customer->getCustomerDateOfBirth($this->customer->getId());

						if ($date_of_birth && ($date_of_birth != '0000-00-00')) {
							$customer_age = date_diff(date_create($date_of_birth), date_create('today'))->y;

							if ($customer_age >= $product_info['age_minimum']) {
								$age_checked = true;
							}
						}
					}
				}

				if ($product_info['quote']) {
					$quote = $this->url->link('information/quote', '', 'SSL');
				} else {
					$quote = false;
				}

				$this->data['products'][] = array(
					'product_id'      => $product_info['product_id'],
					'thumb'           => $image,
					'stock_label'     => $stock_label,
					'offer_label'     => $offer_label,
					'special_label'   => $special_label,
					'offer'           => $offer,
					'manufacturer'    => $manufacturer,
					'name'            => $product_info['name'],
					'age_minimum'     => ($product_info['age_minimum'] > 0) ? (int)$product_info['age_minimum'] : '',
					'age_logged'      => $age_logged,
					'age_checked'     => $age_checked,
					'stock_status'    => $product_info['stock_status'],
					'stock_quantity'  => $product_info['quantity'],
					'stock_remaining' => ($product_info['subtract']) ? sprintf($this->language->get('text_remaining'), $product_info['quantity']) : '',
					'quote'           => $quote,
					'price'           => $price,
					'price_option'    => $this->model_catalog_product->hasOptionPriceIncrease($product_info['product_id']),
					'special'         => $special,
					'tax'             => $tax,
					'rating'          => $rating,
					'reviews'         => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'href'            => $this->url->link('product/product', 'product_id=' . $product_info['product_id'], 'SSL')
				);
			}

			// Theme
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/information/news.tpl';
			} else {
				$this->template = 'default/template/information/news.tpl';
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

		} else {
			$this->document->setTitle($this->language->get('text_error'));

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('information/news', 'news_id=' . $news_id, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['heading_title'] = $this->language->get('text_error');

			$this->data['text_error'] = $this->language->get('text_error');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('common/home', '', 'SSL');

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

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$this->response->setOutput($this->render());
		}
	}

	public function download() {
		$this->load->model('catalog/news');

		if (isset($this->request->get['news_download_id'])) {
			$news_download_id = $this->request->get['news_download_id'];
		} else {
			$news_download_id = 0;
		}

		$download_info = $this->model_catalog_news->getDownloadByDownloadId($news_download_id);

		if ($download_info) {
			$file = DIR_DOWNLOAD . $download_info['filename'];
			$mask = basename($download_info['mask']);

			if (!headers_sent()) {
				if (file_exists($file) && is_file($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file, 'rb');
					exit();

				} else {
					exit('Error: Could not find file ' . $file . '!');
				}

				clearstatcache();

			} else {
				exit('Error: Headers already sent out!');
			}

		} else {
			$this->redirect($this->url->link('information/news', '', 'SSL'));
		}
	}
}
