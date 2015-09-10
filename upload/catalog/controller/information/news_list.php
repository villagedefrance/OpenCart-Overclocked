<?php
class ControllerInformationNewsList extends Controller {

	public function index() {
		$this->language->load('information/news');

		$this->load->model('catalog/news');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'n.date_added';
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

		// Breadcrumbs
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home'),
			'separator' => false
      	);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

		$this->load->model('tool/image');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('information/news_list', $url),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_display'] = $this->language->get('text_display');
		$this->data['text_list'] = $this->language->get('text_list');
		$this->data['text_grid'] = $this->language->get('text_grid');
		$this->data['text_sort'] = $this->language->get('text_sort');
		$this->data['text_limit'] = $this->language->get('text_limit');
		$this->data['text_posted'] = $this->language->get('text_posted');
		$this->data['text_views'] = $this->language->get('text_views');

		$this->data['button_read'] = $this->language->get('button_read');
		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('common/home');

		$this->data['news_data'] = array();

		$data = array(
			'filter_name'	=> $filter_name,
			'sort' 				=> $sort,
			'order' 			=> $order,
			'start' 			=> ($page - 1) * $limit,
			'limit' 				=> $limit
		);

		$total_news = $this->model_catalog_news->getTotalNews();

		$this->data['total_news'] = $total_news;

		$news_data = $this->model_catalog_news->getNews($data);

		foreach ($news_data as $result) {
			$chars = $this->config->get('config_news_chars');

			$news_length = strlen(utf8_decode($result['description']));

			if ($news_length > $chars) {
				$description = substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $chars) . '..</p>';
			} else {
				$description = html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8');
			}

			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 80, 80);
			} else {
				$image = false;
			}

			$this->data['news_data'][] = array(
				'news_id'		=> $result['news_id'],
				'image'			=> $image,
				'title'				=> $result['title'],
				'description'  	=> $description,
				'viewed'			=> $result['viewed'],
				'date_added'	=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'href'				=> $this->url->link('information/news', 'news_id=' . $result['news_id'] . $url)
			);
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		$this->data['sorts'] = array();

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_name_asc'),
			'value' 	=> 'nd.title-ASC',
			'href'  	=> $this->url->link('information/news_list', 'sort=nd.title&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_name_desc'),
			'value' 	=> 'nd.title-DESC',
			'href'  	=> $this->url->link('information/news_list', 'sort=nd.title&order=DESC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_date_asc'),
			'value' 	=> 'n.date_added-ASC',
			'href'  	=> $this->url->link('information/news_list', 'sort=n.date_added&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_date_desc'),
			'value' 	=> 'n.date_added-DESC',
			'href'  	=> $this->url->link('information/news_list', 'sort=n.date_added&order=DESC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_view_asc'),
			'value' 	=> 'n.viewed-ASC',
			'href'  	=> $this->url->link('information/news_list', 'sort=n.viewed&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  	=> $this->language->get('text_view_desc'),
			'value' 	=> 'n.viewed-DESC',
			'href'  	=> $this->url->link('information/news_list', 'sort=n.viewed&order=DESC' . $url)
		);

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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
				'href'  	=> $this->url->link('information/news_list', $url . '&limit=' . $value)
			);
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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
		$pagination->total = $total_news;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('information/news_list', $url . '&page={page}');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['limit'] = $limit;

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/news_list.tpl';
		} else {
			$this->template = 'default/template/information/news_list.tpl';
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