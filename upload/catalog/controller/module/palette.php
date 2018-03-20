<?php
class ControllerModulePalette extends Controller {
	private $_name = 'palette';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/palette');

		$this->data['heading_title'] = $this->language->get('heading_title');

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme');
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		if (!$this->data['title']) {
			$this->data['title'] = $this->data['heading_title'];
		}

		$this->data['text_no_colors'] = $this->language->get('text_no_colors');

		$this->load->model('tool/image');
		$this->load->model('design/palette');

		$this->data['colorcloud'] = $this->model_design_palette->getPaletteColorGroups();

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
