<?php
class ControllerInformationNews extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('information/news');

		$this->load->model('catalog/news');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home'),
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
			$this->document->setKeywords($news_info['keyword']);

			$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
			$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');

			$this->data['breadcrumbs'][] = array(
				'text'		=> $this->language->get('heading_title'),
				'href'		=> $this->url->link('information/news'),
				'separator' 	=> $this->language->get('text_separator')
			);

			$this->data['breadcrumbs'][] = array(
				'text'		=> $news_info['title'],
				'href'		=> $this->url->link('information/news', 'news_id=' . $this->request->get['news_id']),
				'separator' 	=> $this->language->get('text_separator')
			);

     		$this->data['news_info'] = $news_info;

     		$this->data['heading_title'] = $news_info['title'];

			$this->data['text_no_results'] = $this->language->get('text_no_results');

			$this->data['description'] = html_entity_decode($news_info['description'], ENT_QUOTES, 'UTF-8');
			$this->data['viewed'] = sprintf($this->language->get('text_viewed'), $news_info['viewed']);

			// Overclocked
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

			$this->load->model('tool/image');

			if ($news_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('config_image_newsthumb_width'), $this->config->get('config_image_newsthumb_height'));
				$this->data['popup'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('config_image_newspopup_width'), $this->config->get('config_image_newspopup_height'));

				$this->data['image'] = true;
			} else {
				$this->data['thumb'] = false;
				$this->data['popup'] = false;

				$this->data['image'] = false;
			}

     		$this->data['button_news'] = $this->language->get('button_news');
			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['news'] = $this->url->link('information/news_list');
			$this->data['continue'] = $this->url->link('common/home');

			$this->model_catalog_news->updateViewed($this->request->get['news_id']);

			// Template
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/information/news.tpl';
			} else {
				$this->template = 'default/template/information/news.tpl';
			}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());

	  	} else {
		  	$this->document->setTitle($this->language->get('text_error'));

	     	$this->data['breadcrumbs'][] = array(
				'text'		=> $this->language->get('text_error'),
				'href'		=> $this->url->link('information/news'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['heading_title'] = $this->language->get('text_error');

			$this->data['text_error'] = $this->language->get('text_error');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/ 404 Not Found');

			// Template
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());
		}
	}
}
?>