<?php
class ControllerModuleSlideshow extends Controller {
	private $_name = 'slideshow';

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

		$this->data['dots'] = ($this->config->get($this->_name . '_dots')) ? 'true' : 'false';
		$this->data['arrows'] = ($this->config->get($this->_name . '_arrows') && !$this->browser->checkMobile()) ? 'true' : 'false';

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->data['banners'] = array();

		if (isset($setting['banner_id'])) {
			$results = $this->model_design_banner->getBanner($setting['banner_id']);

			foreach ($results as $result) {
				if (!empty($result['link'])) {
					if ($result['external_link']) {
						$image_link = html_entity_decode($result['link'], ENT_QUOTES, 'UTF-8');
					} else {
						$image_link = $this->url->link($result['link'], '', 'SSL');
					}
				} else {
					$image_link = '';
				}

				if (file_exists(DIR_IMAGE . $result['image'])) {
					$this->data['banners'][] = array(
						'banner_image_id' => $result['banner_image_id'],
						'title'           => $result['title'],
						'link'            => $image_link,
						'image'           => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
					);
				}
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

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/slideshow.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/slideshow.tpl';
		} else {
			$this->template = 'default/template/module/slideshow.tpl';
		}

		$this->render();
	}
}
