<?php
class ControllerProductCategory extends Controller {

	public function index() {
		$this->language->load('product/category');

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

		if (isset($this->request->get['limit']) && ((int)$this->request->get['limit'] < 1)) {
			$this->request->get['limit'] = $this->config->get('config_catalog_limit');
		} elseif (isset($this->request->get['limit']) && ((int)$this->request->get['limit'] > 100)) {
			$this->request->get['limit'] = 100;
		}

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		if (isset($this->request->get['path']) && !is_array($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$this->data['breadcrumbs'][] = array(
						'text'      => $category_info['name'],
						'href'      => $this->url->link('product/category', 'path=' . $path . $url, 'SSL'),
						'separator' => $this->language->get('text_separator')
					);
				}
			}

		} else {
			$category_id = 0;
		}

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			if ($page > 1) {
				$this->document->setTitle($category_info['name'] . ' - Page ' . $page);
			} else {
				$this->document->setTitle($category_info['name']);
			}

			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

			$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

			$this->load->model('tool/image');

			$this->data['heading_title'] = $category_info['name'];

			$this->data['text_refine'] = $this->language->get('text_refine');
			$this->data['text_empty'] = $this->language->get('text_empty');
			$this->data['text_quantity'] = $this->language->get('text_quantity');
			$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$this->data['text_model'] = $this->language->get('text_model');
			$this->data['text_from'] = $this->language->get('text_from');
			$this->data['text_price'] = $this->language->get('text_price');
			$this->data['text_tax'] = $this->language->get('text_tax');
			$this->data['text_points'] = $this->language->get('text_points');
			$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare'])) ? count($this->session->data['compare']) : 0);
			$this->data['text_display'] = $this->language->get('text_display');
			$this->data['text_list'] = $this->language->get('text_list');
			$this->data['text_grid'] = $this->language->get('text_grid');
			$this->data['text_sort'] = $this->language->get('text_sort');
			$this->data['text_limit'] = $this->language->get('text_limit');
			$this->data['text_offer'] = $this->language->get('text_offer');

			$this->data['lang'] = $this->language->get('code');

			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_view'] = $this->language->get('button_view');
			$this->data['button_login'] = $this->language->get('button_login');
			$this->data['button_quote'] = $this->language->get('button_quote');
			$this->data['button_wishlist'] = $this->language->get('button_wishlist');
			$this->data['button_compare'] = $this->language->get('button_compare');
			$this->data['button_continue'] = $this->language->get('button_continue');

			// Set the last category breadcrumb
			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->data['breadcrumbs'][] = array(
				'text'      => $category_info['name'],
				'href'      => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			if ($category_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			} else {
				$this->data['thumb'] = '';
			}

			$this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');

			$this->data['compare'] = $this->url->link('product/compare', '', 'SSL');
			$this->data['login_register'] = $this->url->link('account/login', '', 'SSL');

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['dob'] = $this->config->get('config_customer_dob');
			$this->data['stock_checkout'] = $this->config->get('config_stock_checkout');
			$this->data['price_hide'] = $this->config->get('config_price_hide') ? true : false;

			$this->load->model('catalog/offer');
			$this->load->model('account/customer');

			$offers = $this->model_catalog_offer->getListProductOffers(0);

			$empty_category = $this->config->get('config_empty_category');
			$product_count = $this->config->get('config_product_count');

			$this->data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($category_id);

			foreach ($results as $result) {
				$refine_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

				if (!$empty_category || $product_count) {
					$product_total = $this->model_catalog_product->getTotalProducts($refine_data);
				} else {
					$product_total = 0;
				}

				if ($empty_category || $product_total > 0) {
					$this->data['categories'][] = array(
						'name' => $result['name'] . ($product_count ? ' (' . $product_total . ')' : ''),
						'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url, 'SSL')
					);
				}
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->data['products'] = array();

			$data = array(
				'filter_category_id' => $category_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);

			$product_total = $this->model_catalog_product->getTotalProducts($data);

			$results = $this->model_catalog_product->getProducts($data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					$label_ratio = round((($this->config->get('config_image_product_width') * $this->config->get('config_label_size_ratio')) / 100), 0);
				} else {
					$image = false;
					$label_ratio = 50;
				}

				if ($result['label']) {
					$label = $this->model_tool_image->resize($result['label'], round(($this->config->get('config_image_product_width') / 3), 0), round(($this->config->get('config_image_product_height') / 3), 0));
					$label_style = round(($this->config->get('config_image_product_width') / 3), 0);
				} else {
					$label = '';
					$label_style = '';
				}

				if ($result['manufacturer']) {
					$manufacturer = $result['manufacturer'];
				} else {
					$manufacturer = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					if (($result['price'] == '0.0000') && $this->config->get('config_price_free')) {
						$price = $this->language->get('text_free');
					} else {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					}
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special_label = $this->model_tool_image->resize($this->config->get('config_label_special'), $label_ratio, $label_ratio);
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special_label = false;
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				if ($result['quantity'] <= 0) {
					$stock_label = $this->model_tool_image->resize($this->config->get('config_label_stock'), $label_ratio, $label_ratio);
				} else {
					$stock_label = false;
				}

				if (in_array($result['product_id'], $offers, true)) {
					$offer_label = $this->model_tool_image->resize($this->config->get('config_label_offer'), $label_ratio, $label_ratio);
					$offer = true;
				} else {
					$offer_label = false;
					$offer = false;
				}

				$age_logged = false;
				$age_checked = false;

				if ($this->config->get('config_customer_dob') && ($result['age_minimum'] > 0)) {
					if ($this->customer->isLogged() && $this->customer->isSecure()) {
						$age_logged = true;

						$date_of_birth = $this->model_account_customer->getCustomerDateOfBirth($this->customer->getId());

						if ($date_of_birth && ($date_of_birth != '0000-00-00')) {
							$customer_age = date_diff(date_create($date_of_birth), date_create('today'))->y;

							if ($customer_age >= $result['age_minimum']) {
								$age_checked = true;
							}
						}
					}
				}

				if ($result['quote']) {
					$quote = $this->url->link('information/quote', '', 'SSL');
				} else {
					$quote = false;
				}

				$this->data['products'][] = array(
					'product_id'      => $result['product_id'],
					'thumb'           => $image,
					'label'           => $label,
					'label_style'     => $label_style,
					'stock_label'     => $stock_label,
					'offer_label'     => $offer_label,
					'special_label'   => $special_label,
					'offer'           => $offer,
					'manufacturer'    => $manufacturer,
					'name'            => $result['name'],
					'description'     => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 300) . '..',
					'age_minimum'     => ($result['age_minimum'] > 0) ? (int)$result['age_minimum'] : '',
					'age_logged'      => $age_logged,
					'age_checked'     => $age_checked,
					'stock_status'    => $result['stock_status'],
					'stock_quantity'  => $result['quantity'],
					'stock_remaining' => ($result['subtract']) ? sprintf($this->language->get('text_remaining'), $result['quantity']) : '',
					'quote'           => $quote,
					'price'           => $price,
					'price_option'    => $this->model_catalog_product->hasOptionPriceIncrease($result['product_id']),
					'special'         => $special,
					'tax'             => $tax,
					'rating'          => $rating,
					'reviews'         => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'            => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url, 'SSL')
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url, 'SSL')
			);

			if ($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url, 'SSL')
				);

				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url, 'SSL')
				);
			}

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url, 'SSL')
			);

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$this->data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

			sort ($limits);

			foreach ($limits as $value) {
				$this->data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value, 'SSL')
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}', 'SSL');

			$this->data['pagination'] = $pagination->render();

			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;

			$page_trigger = $product_total - $limit;
			$page_last = ceil($product_total / $limit);

			if (($page == 1) && ($page_trigger < 1)) {
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_id), 'canonical');
			} elseif (($page == 1) && ($page_trigger > 0)) {
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_id), 'canonical');
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_id . '&page=' . ($page + 1) . $url, 'SSL'), 'next');
			} elseif (($page > 0) && ($page == $page_last)) {
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_id . '&page=' . $page), 'canonical');
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_id . '&page=' . ($page - 1) . $url, 'SSL'), 'prev');
			} elseif ($page && ($this->request->get['page'] > $page_last)) {
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_id . '&page=' . $page), 'canonical');
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_id . '&page=' . $page_last . $url, 'SSL'), 'prev');
			} elseif (($page > 1) && ($page < $page_last)) {
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_id . '&page=' . $page), 'canonical');
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_id . '&page=' . ($page - 1) . $url, 'SSL'), 'prev');
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_id . '&page=' . ($page + 1) . $url, 'SSL'), 'next');
			}

			$this->data['continue'] = $this->url->link('common/home', '', 'SSL');

			// Theme
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/category.tpl';
			} else {
				$this->template = 'default/template/product/category.tpl';
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
			$url = '';

			if (isset($this->request->get['path']) && !is_array($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('product/category', $url, 'SSL'),
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

			$this->response->addheader($this->request->server['SERVER_PROTOCOL'] . ' 404 not found');
			$this->response->setOutput($this->render());
		}
	}
}
