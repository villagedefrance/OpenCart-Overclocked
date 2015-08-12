<?php
class ControllerProductReviewList extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('product/review_list');

		$this->load->model('catalog/product');
		$this->load->model('catalog/review');
		$this->load->model('tool/image');

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

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}

		if (isset($this->request->get['filter_name'])) {
			$this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->request->get['filter_name']);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

		// Breadcrumbs
		$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home'),
			'separator' => false
      	);

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

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('product/review_list', $url),
			'separator' => $this->language->get('text_separator')
		);

		if (isset($this->request->get['filter_name'])) {
			$this->data['heading_title'] = $this->language->get('heading_title') . ' - ' . $this->request->get['filter_name'];
		} else {
			$this->data['heading_title'] = $this->language->get('heading_title');
		}

		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare'])) ? count($this->session->data['compare']) : 0);
		$this->data['text_display'] = $this->language->get('text_display');
		$this->data['text_list'] = $this->language->get('text_list');
		$this->data['text_grid'] = $this->language->get('text_grid');
		$this->data['text_sort'] = $this->language->get('text_sort');
		$this->data['text_limit'] = $this->language->get('text_limit');
		$this->data['text_offer'] = $this->language->get('text_offer');

		$this->data['lang'] = $this->language->get('code');

		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_quote'] = $this->language->get('button_quote');
		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');
		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['compare'] = $this->url->link('product/compare');

		$this->data['label'] = $this->config->get('config_offer_label');

		$this->load->model('catalog/offer');

		$offers = $this->model_catalog_offer->getListProductOffers(0);

		$this->data['continue'] = $this->url->link('common/home');

		$this->data['reviews'] = array();

		$data = array(
			'filter_name'      	=> $filter_name,
			'filter_description'	=> $filter_description,
			'sort'  				=> $sort,
			'order' 				=> $order,
			'start' 				=> ($page - 1) * $limit,
			'limit' 					=> $limit
		);

		$review_total = $this->model_catalog_review->getTotalReviews();

		$results = $this->model_catalog_review->getReviews($data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

			if (in_array($result['product_id'], $offers, true)) {
				$offer = true;
			} else {
				$offer = false;
			}

			if ($result['quote']) {
				$quote = $this->url->link('information/contact');
			} else {
				$quote = false;
			}

			$review_total_product = $this->model_catalog_review->getTotalReviewsByProductId($result['product_id']);

			$this->data['reviews'][] = array(
				'product_id'		=> $result['product_id'],
				'thumb'			=> $image,
				'offer'       		=> $offer,
				'name'			=> $result['name'],
				'text'				=> substr(strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
				'quote'			=> $quote,
				'rating'			=> $rating,
				'author'			=> $result['author'],
				'date_added'	=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'reviews'			=> sprintf($this->language->get('text_reviews'), $review_total_product),
				'href'				=> $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url)
			);
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_description'])) {
			$url .= '&filter_description=' . $this->request->get['filter_description'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$this->data['sorts'] = array();

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_default'),
			'value' 	=> 'p.sort_order-DESC',
			'href'  	=> $this->url->link('product/review_list', 'sort=p.sort_order&order=DESC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_name_asc'),
			'value' 	=> 'pd.name-ASC',
			'href'  	=> $this->url->link('product/review_list', 'sort=pd.name&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_name_desc'),
			'value' 	=> 'pd.name-DESC',
			'href'  	=> $this->url->link('product/review_list', 'sort=pd.name&order=DESC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_price_asc'),
			'value' 	=> 'p.price-ASC',
			'href'  	=> $this->url->link('product/review_list', 'sort=p.price&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_price_desc'),
			'value' 	=> 'p.price-DESC',
			'href'  	=> $this->url->link('product/review_list', 'sort=p.price&order=DESC' . $url)
		);

		if ($this->config->get('config_review_status')) { 
			$this->data['sorts'][] = array(
				'text'  	=> $this->language->get('text_rating_desc'),
				'value' 	=> 'r.rating-DESC',
				'href'  	=> $this->url->link('product/review_list', 'sort=r.rating&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  	=> $this->language->get('text_rating_asc'),
				'value' 	=> 'r.rating-ASC',
				'href'  	=> $this->url->link('product/review_list', 'sort=r.rating&order=ASC' . $url)
			);
		}

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_date_asc'),
			'value' 	=> 'r.date_added-ASC',
			'href'  	=> $this->url->link('product/review_list', 'sort=r.date_added&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_date_desc'),
			'value' 	=> 'r.date_added-DESC',
			'href'  	=> $this->url->link('product/review_list', 'sort=r.date_added&order=DESC' . $url)
		);

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
				'text'  	=> $value,
				'value' 	=> $value,
				'href'  	=> $this->url->link('product/review_list', $url . '&limit=' . $value)
			);
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('product/review_list&sort=pd.name' . $url);
		$this->data['sort_price'] = $this->url->link('product/review_list&sort=p.price' . $url);
		$this->data['sort_rating'] = $this->url->link('product/review_list&sort=r.rating' . $url);
		$this->data['sort_date'] = $this->url->link('product/review_list&sort=r.date_added' . $url);

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
		$pagination->url = $this->url->link('product/review_list', $url . '&page={page}');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_description'] = $filter_description;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['limit'] = $limit;

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
	}
}
?>