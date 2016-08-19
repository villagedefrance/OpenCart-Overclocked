<?php
class ControllerModuleHtml extends Controller {
	private $_name = 'html';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		// Module
		for ($i = 1; $i <= 10; $i++) {
			$this->data['theme' . $i] = $this->config->get($this->_name . '_theme' . $i);

			$this->data['title' . $i] = $this->config->get($this->_name . '_title' . $i . '_' . $this->config->get('config_language_id'));

			if (!$this->data['title' . $i]) {
				$this->data['title' . $i] = $this->data['heading_title'];
			}

			$stylesheet_mode = $this->config->get('config_stylesheet');

			if (!$stylesheet_mode) {
				$header_color = $this->config->get($this->_name . '_header_color' . $i);
				$header_shape = $this->config->get($this->_name . '_header_shape' . $i);
				$content_color = $this->config->get($this->_name . '_content_color' . $i);
				$content_shape = $this->config->get($this->_name . '_content_shape' . $i);

				$this->data['header_color' . $i] = ($header_color) ? $header_color . '-skin' : 'white-skin';
				$this->data['header_shape' . $i] = ($header_shape) ? $header_shape . '-top' : 'rounded-0';
				$this->data['content_color' . $i] = ($content_color) ? $content_color . '-skin' : 'white-skin';
				$this->data['content_shape' . $i] = ($content_shape) ? $content_shape . '-bottom' : 'rounded-0';
			} else {
				$this->data['header_color' . $i] = '';
				$this->data['header_shape' . $i] = '';
				$this->data['content_color' . $i] = '';
				$this->data['content_shape' . $i] = '';
			}

			$this->data['stylesheet_mode'] = $stylesheet_mode;

			$this->data['code' . $i] = html_entity_decode($this->config->get($this->_name . '_code' . $i), ENT_QUOTES, 'UTF-8');

			$position = $setting['tab_id'];

			switch($position) {
				case "tab" . $i: 
				$this->data['code'] = $this->data['code' . $i];
				$this->data['content_shape'] = $this->data['content_shape' . $i];
				$this->data['content_color'] = $this->data['content_color' . $i];
				$this->data['header_shape'] = $this->data['header_shape' . $i];
				$this->data['header_color'] = $this->data['header_color' . $i];
				$this->data['theme'] = $this->data['theme' . $i];
				$this->data['title'] = $this->data['title' . $i];
				break;
				default: $content_shape = ''; $content_color = ''; $header_shape = ''; $header_color = '';
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