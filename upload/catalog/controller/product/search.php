<?php
class ControllerProductSearch extends Controller {

	public function index() {
		$this->language->load('product/search');

		if (isset($this->request->get['limit']) && ((int)$this->request->get['limit'] < 1)) {
			$this->request->get['limit'] = $this->config->get('config_catalog_limit');
		} elseif (isset($this->request->get['limit']) && ((int)$this->request->get['limit'] > 100)) {
			$this->request->get['limit'] = 100;
		}

		if (isset($this->request->get['search'])) {
			$search = $this->request->get['search'];
		} else {
			$search = '';
		}

		if (isset($this->request->get['tag'])) {
			$tag = $this->request->get['tag'];
		} elseif (isset($this->request->get['search'])) {
			$tag = $this->request->get['search'];
		} else {
			$tag = '';
		}

		if (isset($this->request->get['color'])) {
			$color = $this->request->get['color'];
		} elseif (isset($this->request->get['search'])) {
			$color = $this->request->get['search'];
		} else {
			$color = '';
		}

		if (isset($this->request->get['description'])) {
			$description = $this->request->get['description'];
		} else {
			$description = '';
		}

		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}

		if (isset($this->request->get['sub_category'])) {
			$sub_category = $this->request->get['sub_category'];
		} else {
			$sub_category = '';
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

		if (isset($this->request->get['search'])) {
			$this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->request->get['search']);
		} else {
			if (isset($this->request->get['tag'])) {
				$this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->request->get['tag']);
			} else {
				$this->document->setTitle($this->language->get('heading_title'));
			}
		}

		$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$url = '';

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['tag'])) {
			$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['color'])) {
			$url .= '&color=' . urlencode(html_entity_decode($this->request->get['color'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['description'])) {
			$url .= '&description=' . $this->request->get['description'];
		}

		if (isset($this->request->get['category_id'])) {
			$url .= '&category_id=' . $this->request->get['category_id'];
		}

		if (isset($this->request->get['sub_category'])) {
			$url .= '&sub_category=' . $this->request->get['sub_category'];
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
			'href'      => $this->url->link('product/search', $url, 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		if (isset($this->request->get['search'])) {
			$this->data['heading_title'] = $this->language->get('heading_title') . ' - ' . $this->request->get['search'];
		} else {
			if (isset($this->request->get['tag'])) {
				$this->data['heading_title'] = $this->language->get('heading_title') . ' - ' . $this->request->get['tag'];
			} else {
				$this->data['heading_title'] = $this->language->get('heading_title');
			}
		}

		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_keyword'] = $this->language->get('text_keyword');
		$this->data['text_category'] = $this->language->get('text_category');
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

		$this->data['entry_search'] = $this->language->get('entry_search');
		$this->data['entry_search_in'] = $this->language->get('entry_search_in');

		$this->data['lang'] = $this->language->get('code');

		$this->data['button_search'] = $this->language->get('button_search');
		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_login'] = $this->language->get('button_login');
		$this->data['button_quote'] = $this->language->get('button_quote');
		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');

		$this->data['compare'] = $this->url->link('product/compare', '', 'SSL');
		$this->data['login_register'] = $this->url->link('account/login', '', 'SSL');

		$this->data['dob'] = $this->config->get('config_customer_dob');
		$this->data['stock_checkout'] = $this->config->get('config_stock_checkout');
		$this->data['price_hide'] = $this->config->get('config_price_hide') ? true : false;

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('catalog/offer');
		$this->load->model('tool/image');
		$this->load->model('account/customer');

		$offers = $this->model_catalog_offer->getListProductOffers(0);

		$empty_category = $this->config->get('config_empty_category');

		$this->data['categories'] = array();

		$categories_1 = $this->model_catalog_category->getCategories(0);

		foreach ($categories_1 as $category_1) {
			$level_2_data = array();

			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

			foreach ($categories_2 as $category_2) {
				$level_3_data = array();

				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

				foreach ($categories_3 as $category_3) {
					$data = array(
						'filter_category_id'  => $category_3['category_id'],
						'filter_sub_category' => true
					);

					if (!$empty_category) {
						$product_total = $this->model_catalog_product->getTotalProducts($data);
					} else {
						$product_total = 0;
					}

					if ($empty_category || $product_total > 0) {
						$level_3_data[] = array(
							'category_id' => $category_3['category_id'],
							'name'        => $category_3['name']
						);
					}
				}

				$level_2_data[] = array(
					'category_id' => $category_2['category_id'],
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);
			}

			$this->data['categories'][] = array(
				'category_id' => $category_1['category_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}

		$this->data['products'] = array();

		if (isset($this->request->get['search']) || isset($this->request->get['tag']) || isset($this->request->get['color'])) {
			$data = array(
				'filter_name'         => $search,
				'filter_tag'          => $tag,
				'filter_color'        => $color,
				'filter_description'  => $description,
				'filter_category_id'  => $category_id,
				'filter_sub_category' => $sub_category,
				'sort'                => $sort,
				'order'               => $order,
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
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
					'palette_id'      => ($result['palette_id']) ? (int)$result['palette_id'] : '',
					'quote'           => $quote,
					'price'           => $price,
					'price_option'    => $this->model_catalog_product->hasOptionPriceIncrease($result['product_id']),
					'special'         => $special,
					'tax'             => $tax,
					'rating'          => $rating,
					'reviews'         => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'            => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url, 'SSL')
				);
			}

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['color'])) {
				$url .= '&color=' . urlencode(html_entity_decode($this->request->get['color'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href' => $this->url->link('product/search', 'sort=p.sort_order&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href' => $this->url->link('product/search', 'sort=pd.name&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href' => $this->url->link('product/search', 'sort=pd.name&order=DESC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href' => $this->url->link('product/search', 'sort=p.price&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href' => $this->url->link('product/search', 'sort=p.price&order=DESC' . $url, 'SSL')
			);

			if ($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href' => $this->url->link('product/search', 'sort=rating&order=DESC' . $url, 'SSL')
				);

				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href' => $this->url->link('product/search', 'sort=rating&order=ASC' . $url, 'SSL')
				);
			}

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href' => $this->url->link('product/search', 'sort=p.model&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href' => $this->url->link('product/search', 'sort=p.model&order=DESC' . $url, 'SSL')
			);

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['color'])) {
				$url .= '&color=' . urlencode(html_entity_decode($this->request->get['color'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
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
					'href'  => $this->url->link('product/search', $url . '&limit=' . $value, 'SSL')
				);
			}

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['color'])) {
				$url .= '&color=' . urlencode(html_entity_decode($this->request->get['color'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
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
			$pagination->url = $this->url->link('product/search', $url . '&page={page}', 'SSL');

			$this->data['pagination'] = $pagination->render();
		}

		$this->data['search'] = $search;
		$this->data['description'] = $description;
		$this->data['category_id'] = $category_id;
		$this->data['sub_category'] = $sub_category;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['limit'] = $limit;

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/search.tpl';
		} else {
			$this->template = 'default/template/product/search.tpl';
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

	public function livesearch() {
		$data = array();

		$template = $this->config->get('config_template');

		if (isset($this->request->get['keyword']) && $this->config->get($template . '_livesearch')) {
			$keywords = strtolower($this->request->get['keyword']);

			if (strlen($keywords) >= 2) {
				if ($this->customer->isLogged()) {
					$customer_group_id = $this->customer->getCustomerGroupId();
				} else {
					$customer_group_id = $this->config->get('config_customer_group_id');
				}

				$search_limit = $this->config->get($template . '_livesearch_limit');

				if ($search_limit && is_numeric($search_limit) && $search_limit > 0) {
					$limit = (int)$search_limit;
				} else {
					$limit = 10;
				}

				$parts = explode(' ', $keywords);

				$add = '';

				foreach ($parts as $part) {
					$add .= ' AND (LOWER(pd.name) LIKE "%' . $this->db->escape($part) . '%"';
					$add .= ' OR LOWER(md.name) LIKE "%' . $this->db->escape($part) . '%"';
					$add .= ' OR LOWER(pd.tag) LIKE "%' . $this->db->escape($part) . '%"';
					$add .= ' OR LOWER(p.model) LIKE "%' . $this->db->escape($part) . '%")';
				}

				$add = substr($add, 4);

				$sql = 'SELECT p.product_id, p.image, p.price, p.tax_class_id,';
				$sql .= ' (SELECT price FROM ' . DB_PREFIX . 'product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = "' . (int)$customer_group_id . '" AND ((ps.date_start = "0000-00-00" OR ps.date_start < NOW()) AND (ps.date_end = "0000-00-00" OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 0,1) AS special,';
				$sql .= ' p.model AS model, pd.name AS name FROM ' . DB_PREFIX . 'product p';
				$sql .= ' LEFT OUTER JOIN ' . DB_PREFIX . 'manufacturer_description md ON (p.manufacturer_id = md.manufacturer_id)';
				$sql .= ' LEFT JOIN ' . DB_PREFIX . 'product_description pd ON (p.product_id = pd.product_id)';
				$sql .= ' LEFT JOIN ' . DB_PREFIX . 'product_to_store p2s ON (p.product_id = p2s.product_id)';
				$sql .= ' WHERE ' . $add . ' AND p.status = 1';
				$sql .= ' AND pd.language_id = ' . (int)$this->config->get('config_language_id');
				$sql .= ' AND p2s.store_id = ' . (int)$this->config->get('config_store_id');
				$sql .= ' GROUP BY p.product_id';
				$sql .= ' ORDER BY LOWER(pd.name) ASC, LOWER(md.name) ASC, LOWER(pd.tag) ASC, LOWER(p.model) ASC';
				$sql .= ' LIMIT 0,' . (int)$limit;

				$result = $this->db->query($sql);

				if ($result) {
					$data = (isset($result->rows)) ? $result->rows : $result->row;

					$this->load->model('tool/image');

					foreach ($data as $key => $values) {
						if ($values['image']) {
							$image = $this->model_tool_image->resize($values['image'], 32, 32);
						} else {
							$image = $this->model_tool_image->resize('no_image.jpg', 32, 32);
						}

						if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
							if (($values['price'] == '0.0000') && $this->config->get('config_price_free')) {
								$price = $this->language->get('text_free');
							} else {
								$price = $this->currency->format($this->tax->calculate($values['price'], $values['tax_class_id'], $this->config->get('config_tax')));
							}
						} else {
							$price = false;
						}

						if ((float)$values['special']) {
							$special = $this->currency->format($this->tax->calculate($values['special'], $values['tax_class_id'], $this->config->get('config_tax')));
						} else {
							$special = false;
						}

						$product_id = (int)$values['product_id'];

						if ($this->config->get('config_price_hide')) {
							$product_price = '';
						} else {
							$product_price = ($special) ? $special : $price;
						}

						$data[$key] = array(
							'name'  => html_entity_decode($values['name'] . ' ' . $product_price, ENT_QUOTES, 'UTF-8'),
							'image' => $image,
							'alt'   => $values['name'],
							'href'  => $this->url->link('product/product&product_id=' . $product_id, '', 'SSL')
						);
					}
				}
			}
		} else {
			return;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}
}
