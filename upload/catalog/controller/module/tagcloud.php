<?php
class ControllerModuleTagCloud extends Controller {
	private $_name = 'tagcloud';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme');
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		if (!$this->data['title']) {
			$this->data['title'] = $this->data['heading_title'];
		}

		$header_color = $this->config->get($this->_name . '_header_color');
		$header_shape = $this->config->get($this->_name . '_header_shape');
		$content_color = $this->config->get($this->_name . '_content_color');
		$content_shape = $this->config->get($this->_name . '_content_shape');

		$this->data['header_color'] = ($header_color) ? $header_color : 'white';
		$this->data['header_shape'] = ($header_shape) ? $header_shape : 'rounded-3';
		$this->data['content_color'] = ($content_color) ? $content_color : 'white';
		$this->data['content_shape'] = ($content_shape) ? $content_shape : 'rounded-3';

		$this->data['text_notags'] = $this->language->get('text_notags');

		$this->load->model('catalog/tagcloud');

		$this->data['tagcloud'] = $this->model_catalog_tagcloud->getRandomTags($setting['limit'], $setting['min_font_size'], $setting['max_font_size'], $setting['font_weight'], $setting['random']);

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