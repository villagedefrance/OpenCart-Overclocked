<?php
class ControllerModuleBanner extends Controller {
	private $_name = 'banner';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->document->addStyle('catalog/view/javascript/jquery/flexslider/flexslider.min.css');

		$this->document->addScript('catalog/view/javascript/jquery/flexslider/jquery.flexslider-min.js');

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme');
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		if (!$this->data['title']) {
			$this->data['title'] = $this->data['heading_title'];
		}

		$animation = $this->config->get($this->_name . '_transition');

		if ($animation == 'fade') {
			$this->data['animation'] = 'fade';
		} else {
			$this->data['animation'] = 'slide';
		}

		if ($animation == 'horizontal') {
			$this->data['direction'] = 'horizontal';
		} else {
			$this->data['direction'] = 'vertical';
		}

		$this->data['duration'] = ($this->config->get($this->_name . '_duration')) ? $this->config->get($this->_name . '_duration') : 3000;
		$this->data['speed'] = ($this->config->get($this->_name . '_speed')) ? $this->config->get($this->_name . '_speed') : 300;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (file_exists(DIR_IMAGE . $result['image'])) {
				if (!empty($result['link'])) {
					if ($result['external_link']) {
						$image_link = html_entity_decode($result['link'], ENT_QUOTES, 'UTF-8');
					} else {
						$image_link = $this->url->link($result['link'], '', 'SSL');
					}
				} else {
					$image_link = '';
				}

				$this->data['banners'][] = array(
					'banner_image_id' => $result['banner_image_id'],
					'title'           => $result['title'],
					'link'            => $image_link,
					'image'           => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		// Shuffle
		$random = $this->config->get($this->_name . '_random');

		if ($random) {
			shuffle($this->data['banners']);
		}

		$this->data['module'] = $module++;

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
		} else {
			$this->template = 'default/template/module/' . $this->_name . '.tpl';
		}

		$this->render();
	}
}
