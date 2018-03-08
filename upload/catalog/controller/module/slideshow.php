<?php
class ControllerModuleSlideshow extends Controller {
	private $_name = 'slideshow';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->document->addStyle('catalog/view/javascript/jquery/slick/slick.min.css');

		$this->document->addScript('catalog/view/javascript/jquery/slick/slick.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/jquery.easing.min.js');

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme');
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		if (!$this->data['title']) {
			$this->data['title'] = $this->data['heading_title'];
		}

		$transition = $this->config->get($this->_name . '_transition');

		if ($transition == 'vertical') {
			$this->data['vertical'] = 'true';
			$this->data['fade'] = 'false';
		} elseif ($transition == 'fade') {
			$this->data['vertical'] = 'false';
			$this->data['fade'] = 'true';
		} else {
			$this->data['vertical'] = 'false';
			$this->data['fade'] = 'false';
		}

		$this->data['duration'] = ($this->config->get($this->_name . '_duration')) ? $this->config->get($this->_name . '_duration') : 3000;
		$this->data['speed'] = ($this->config->get($this->_name . '_speed')) ? $this->config->get($this->_name . '_speed') : 300;

		$this->data['dots'] = ($this->config->get($this->_name . '_dots')) ? 'true' : 'false';

		$arrows = $this->config->get($this->_name . '_arrows');

		if ($arrows) {
			$this->data['track_style'] = 'margin:0 30px 20px 30px;';
			$this->data['arrows'] = 'true';
		} else {
			$this->data['track_style'] = 'margin:0 0 20px 0;';
			$this->data['arrows'] = 'false';
		}

		// Auto
		$this->data['auto'] = $setting['auto'] ? 'true' : 'false';

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
