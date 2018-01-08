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

			$this->data['code' . $i] = html_entity_decode($this->config->get($this->_name . '_code' . $i), ENT_QUOTES, 'UTF-8');

			$position = $setting['tab_id'];

			switch ($position) {
				case "tab" . $i:
				$this->data['code'] = $this->data['code' . $i];
				$this->data['theme'] = $this->data['theme' . $i];
				$this->data['title'] = $this->data['title' . $i];
				break;
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
