<?php
class ControllerModuleCarousel extends Controller {
	private $_name = 'carousel';

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

		$this->data['duration'] = ($this->config->get($this->_name . '_duration')) ? $this->config->get($this->_name . '_duration') : 3000;
		$this->data['speed'] = ($this->config->get($this->_name . '_speed')) ? $this->config->get($this->_name . '_speed') : 300;

		$this->data['track_style'] = 'margin:0 30px 20px 30px;';

		// Responsive
		$show_max = round($setting['show'], 0);

		$show_1440 = ($show_max > 6) ? ($show_max - 1) : $show_max;
		$show_1280 = ($show_1440 > 5) ? ($show_max - 1) : $show_1440;
		$show_960 = ($show_1280 > 4) ? ($show_1280 - 1) : $show_1280;
		$show_640 = ($show_960 > 3) ? ($show_960 - 1) : $show_960;
		$show_480 = ($show_640 > 2) ? ($show_640 - 1) : $show_640;
		$show_320 = ($show_480 > 1) ? ($show_480 - 1) : $show_480;

		$this->data['show_1440'] = $show_1440;
		$this->data['show_1280'] = $show_1280;
		$this->data['show_960'] = $show_960;
		$this->data['show_640'] = $show_640;
		$this->data['show_480'] = $show_480;
		$this->data['show_320'] = $show_320;

		// Auto
		$this->data['auto'] = $setting['auto'] ? 'true' : 'false';

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
					'banner_image_id'  => $result['banner_image_id'],
					'title'            => $result['title'],
					'link'             => $image_link,
					'image'            => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
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
