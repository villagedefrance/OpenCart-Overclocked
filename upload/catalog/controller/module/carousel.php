<?php
class ControllerModuleCarousel extends Controller {
	private $_name = 'carousel';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->document->addStyle('catalog/view/javascript/jquery/slick/slick.css');

		$this->document->addScript('catalog/view/javascript/jquery/slick/slick.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/jquery.easing.min.js');

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme');
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		if (!$this->data['title']) {
			$this->data['title'] = $this->data['heading_title'];
		}

		$this->data['slick_theme'] = $this->config->get($this->_name . '_skin');

		// Responsive
		$show_max = $setting['show'] ? round($setting['show']) : 4;
		$show_min = 1;

		$show_960 = round($show_max / 2);
		$show_640 = round($show_max / 3);

		$this->data['show_1280'] = $show_max;

		if ($show_960 > $show_640 && $show_960 > $show_min) {
			$this->data['show_960'] = $show_960;
		} else {
			$this->data['show_960'] = $show_max - 1;
		}

		if ($show_640 < $show_960 && $show_640 > $show_min) {
			$this->data['show_640'] = $show_640;
		} else {
			$this->data['show_640'] = $show_min + 1;
		}

		$this->data['show_320'] = $show_min;

		// Auto
		$this->data['auto'] = $setting['auto'] ? 'true' : 'false';

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (file_exists(DIR_IMAGE . $result['image'])) {
				$this->data['banners'][] = array(
					'title' 		=> $result['title'],
					'link'  		=> $result['link'],
					'image'	=> $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
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
?>