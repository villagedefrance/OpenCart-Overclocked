<?php
class ControllerProductReviewList extends Controller {

	public function index() {
		$this->language->load('product/review_list');

		$this->load->model('catalog/product');
		$this->load->model('catalog/review');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_description'])) {
			$filter_description = $this->request->get['filter_description'];
		} else {
			$filter_description = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
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

		$this->data['reviews'] = array();

		$data = array(
			'filter_name'        => $filter_name,
			'filter_description' => $filter_description,
			'sort'               => $sort,
			'order'              => $order,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit
		);

		$review_total = $this->model_catalog_review->getTotalReviews();

		$review_results = $this->model_catalog_review->getReviews($data);

		if ($review_results) {
			$title_page = ($page > 1) ? ' - Page ' . $page : '';

			if (isset($this->request->get['filter_name'])) {
				$this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->request->get['filter_name'] . $title_page);
			} else {
				$this->document->setTitle($this->language->get('heading_title') . $title_page);
			}

			$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
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
				'href'      => $this->url->link('product/review_list', $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			if (isset($this->request->get['filter_name'])) {
				$this->data['heading_title'] = $this->language->get('heading_title') . ' - ' . $this->request->get['filter_name'];
			} else {
				$this->data['heading_title'] = $this->language->get('heading_title');
			}

			$this->data['text_empty'] = $this->language->get('text_empty');
			$this->data['text_from'] = $this->language->get('text_from');
			$this->data['text_price'] = $this->language->get('text_price');
			$this->data['text_tax'] = $this->language->get('text_tax');
			$this->data['text_display'] = $this->language->get('text_display');
			$this->data['text_list'] = $this->language->get('text_list');
			$this->data['text_grid'] = $this->language->get('text_grid');
			$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare'])) ? count($this->session->data['compare']) : 0);
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

			$this->data['continue'] = $this->url->link('common/home', '', 'SSL');
			$this->data['compare'] = $this->url->link('product/compare', '', 'SSL');
			$this->data['login_register'] = $this->url->link('account/login', '', 'SSL');

			$this->data['dob'] = $this->config->get('config_customer_dob');
			$this->data['stock_checkout'] = $this->config->get('config_stock_checkout');
			$this->data['price_hide'] = $this->config->get('config_price_hide') ? true : false;

			$this->load->model('tool/image');
			$this->load->model('catalog/offer');
			$this->load->model('catalog/product');
			$this->load->model('account/customer');

			$offers = $this->model_catalog_offer->getListProductOffers(0);

			foreach ($review_results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					$label_ratio = round((($this->config->get('config_image_product_width') * $this->config->get('config_label_size_ratio')) / 100), 0);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					$label_ratio = 50;
				}

				if ($result['label']) {
					$label = $this->model_tool_image->resize($result['label'], round(($this->config->get('config_image_product_width') / 3), 0), round(($this->config->get('config_image_product_height') / 3), 0));
					$label_style = round(($this->config->get('config_image_product_width') / 3), 0);
				} else {
					$label = '';
					$label_style = '';
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

				$review_total_product = $this->model_catalog_review->getTotalReviewsByProductId($result['product_id']);

				$this->data['reviews'][] = array(
					'product_id'      => $result['product_id'],
					'thumb'           => $image,
					'label'           => $label,
					'label_style'     => $label_style,
					'stock_label'     => $stock_label,
					'offer_label'     => $offer_label,
					'special_label'   => $special_label,
					'offer'           => $offer,
					'name'            => $result['name'],
					'text'            => substr(strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8')), 0, 300) . '..',
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
					'author'          => $result['author'],
					'date_added'      => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'reviews'         => sprintf($this->language->get('text_reviews'), $review_total_product),
					'href'            => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url, 'SSL')
				);
			}

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}

			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_default'),
				'value' => 'p.sort_order-DESC',
				'href' => $this->url->link('product/review_list', 'sort=p.sort_order&order=DESC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href' => $this->url->link('product/review_list', 'sort=pd.name&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href' => $this->url->link('product/review_list', 'sort=pd.name&order=DESC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href' => $this->url->link('product/review_list', 'sort=p.price&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href' => $this->url->link('product/review_list', 'sort=p.price&order=DESC' . $url, 'SSL')
			);

			if ($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_rating_desc'),
					'value' => 'r.rating-DESC',
					'href' => $this->url->link('product/review_list', 'sort=r.rating&order=DESC' . $url, 'SSL')
				);

				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_rating_asc'),
					'value' => 'r.rating-ASC',
					'href' => $this->url->link('product/review_list', 'sort=r.rating&order=ASC' . $url, 'SSL')
				);
			}

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_date_asc'),
				'value' => 'r.date_added-ASC',
				'href' => $this->url->link('product/review_list', 'sort=r.date_added&order=ASC' . $url, 'SSL')
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_date_desc'),
				'value' => 'r.date_added-DESC',
				'href' => $this->url->link('product/review_list', 'sort=r.date_added&order=DESC' . $url, 'SSL')
			);

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
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
					'href'  => $this->url->link('product/review_list', $url . '&limit=' . $value, 'SSL')
				);
			}

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
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
			$pagination->total = $review_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('product/review_list', $url . '&page={page}', 'SSL');

			$this->data['pagination'] = $pagination->render();

			$this->data['filter_name'] = $filter_name;
			$this->data['filter_description'] = $filter_description;

			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;

			$page_trigger = $review_total - $limit;
			$page_last = ceil($review_total / $limit);

			if (($page == 1) && ($page_trigger < 1)) {
				$this->document->addLink($this->url->link('product/review_list'), 'canonical');
			} elseif (($page == 1) && ($page_trigger > 0)) {
				$this->document->addLink($this->url->link('product/review_list'), 'canonical');
				$this->document->addLink($this->url->link('product/review_list', 'page=' . ($page + 1) . $url, 'SSL'), 'next');
			} elseif ($page == $page_last) {
				$this->document->addLink($this->url->link('product/review_list', 'page=' . $page), 'canonical');
				$this->document->addLink($this->url->link('product/review_list', 'page=' . ($page - 1) . $url, 'SSL'), 'prev');
			} elseif ($this->request->get['page'] > $page_last) {
				$this->document->addLink($this->url->link('product/review_list', 'page=' . $page), 'canonical');
				$this->document->addLink($this->url->link('product/review_list', 'page=' . $page_last . $url, 'SSL'), 'prev');
			} elseif (($page > 1) && ($page < $page_last)) {
				$this->document->addLink($this->url->link('product/review_list', 'page=' . $page), 'canonical');
				$this->document->addLink($this->url->link('product/review_list', 'page=' . ($page - 1) . $url, 'SSL'), 'prev');
				$this->document->addLink($this->url->link('product/review_list', 'page=' . ($page + 1) . $url, 'SSL'), 'next');
			}

			// Theme
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/review_list.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/review_list.tpl';
			} else {
				$this->template = 'default/template/product/review_list.tpl';
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

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
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
				'href'      => $this->url->link('product/review_list', $url, 'SSL'),
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
