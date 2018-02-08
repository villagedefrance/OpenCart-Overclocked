<?php
class ControllerInformationNewsList extends Controller {

	public function index() {
		$this->language->load('information/news');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/panels/panels.min.js');

		$this->load->model('catalog/news');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/news_list', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_posted'] = $this->language->get('text_posted');
		$this->data['text_views'] = $this->language->get('text_views');

		$this->data['button_read'] = $this->language->get('button_read');
		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('common/home', '', 'SSL');

		$total_news = $this->model_catalog_news->getTotalNews();

		$this->data['total_news'] = $total_news;

		$this->data['news_data'] = array();

		$news_data = $this->model_catalog_news->getNewsAll();

		if ($news_data) {
			$this->load->model('tool/image');

			$news_chars = $this->config->get('config_news_chars');

			foreach ($news_data as $result) {
				$news_length = strlen(utf8_decode($result['description']));

				if ($news_length > (int)$news_chars) {
					$description = '<p>' . substr(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'), 0, (int)$news_chars) . ' ...</p>';
				} else {
					$description = '<p>' . html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8') . '</p>';
				}

				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 90, 90);
				} else {
					$image = false;
				}

				$this->data['news_data'][] = array(
					'news_id'     => $result['news_id'],
					'image'       => $image,
					'title'       => $result['title'],
					'description' => $description,
					'viewed'      => $result['viewed'],
					'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'href'        => $this->url->link('information/news', 'news_id=' . $result['news_id'], 'SSL')
				);
			}

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

		} else {
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
