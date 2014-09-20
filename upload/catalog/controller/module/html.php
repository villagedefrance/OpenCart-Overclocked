<?php
class ControllerModuleHtml extends Controller {
	private $_name = 'html';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

      	$this->data['heading_title'] = $this->language->get('heading_title');

		// Module
		$this->data['theme1'] = $this->config->get($this->_name . '_theme1');
		$this->data['theme2'] = $this->config->get($this->_name . '_theme2');
		$this->data['theme3'] = $this->config->get($this->_name . '_theme3');
		$this->data['theme4'] = $this->config->get($this->_name . '_theme4');
		$this->data['theme5'] = $this->config->get($this->_name . '_theme5');
		$this->data['theme6'] = $this->config->get($this->_name . '_theme6');
		$this->data['theme7'] = $this->config->get($this->_name . '_theme7');
		$this->data['theme8'] = $this->config->get($this->_name . '_theme8');
		$this->data['theme9'] = $this->config->get($this->_name . '_theme9');
		$this->data['theme10'] = $this->config->get($this->_name . '_theme10');

		$this->data['title1'] = $this->config->get($this->_name . '_title1' . $this->config->get('config_language_id'));
		$this->data['title2'] = $this->config->get($this->_name . '_title2' . $this->config->get('config_language_id'));
		$this->data['title3'] = $this->config->get($this->_name . '_title3' . $this->config->get('config_language_id'));
		$this->data['title4'] = $this->config->get($this->_name . '_title4' . $this->config->get('config_language_id'));
		$this->data['title5'] = $this->config->get($this->_name . '_title5' . $this->config->get('config_language_id'));
		$this->data['title6'] = $this->config->get($this->_name . '_title6' . $this->config->get('config_language_id'));
		$this->data['title7'] = $this->config->get($this->_name . '_title7' . $this->config->get('config_language_id'));
		$this->data['title8'] = $this->config->get($this->_name . '_title8' . $this->config->get('config_language_id'));
		$this->data['title9'] = $this->config->get($this->_name . '_title9' . $this->config->get('config_language_id'));
		$this->data['title10'] = $this->config->get($this->_name . '_title10' . $this->config->get('config_language_id'));

		if (!$this->data['title1']) { $this->data['title1'] = $this->data['heading_title']; }
		if (!$this->data['title2']) { $this->data['title2'] = $this->data['heading_title']; }
		if (!$this->data['title3']) { $this->data['title3'] = $this->data['heading_title']; }
		if (!$this->data['title4']) { $this->data['title4'] = $this->data['heading_title']; }
		if (!$this->data['title5']) { $this->data['title5'] = $this->data['heading_title']; }
		if (!$this->data['title6']) { $this->data['title6'] = $this->data['heading_title']; }
		if (!$this->data['title7']) { $this->data['title7'] = $this->data['heading_title']; }
		if (!$this->data['title8']) { $this->data['title8'] = $this->data['heading_title']; }
		if (!$this->data['title9']) { $this->data['title9'] = $this->data['heading_title']; }
		if (!$this->data['title10']) { $this->data['title10'] = $this->data['heading_title']; }

		$this->data['code1'] = html_entity_decode($this->config->get($this->_name . '_code1'), ENT_QUOTES, 'UTF-8');
		$this->data['code2'] = html_entity_decode($this->config->get($this->_name . '_code2'), ENT_QUOTES, 'UTF-8');
		$this->data['code3'] = html_entity_decode($this->config->get($this->_name . '_code3'), ENT_QUOTES, 'UTF-8');
		$this->data['code4'] = html_entity_decode($this->config->get($this->_name . '_code4'), ENT_QUOTES, 'UTF-8');
		$this->data['code5'] = html_entity_decode($this->config->get($this->_name . '_code5'), ENT_QUOTES, 'UTF-8');
		$this->data['code6'] = html_entity_decode($this->config->get($this->_name . '_code6'), ENT_QUOTES, 'UTF-8');
		$this->data['code7'] = html_entity_decode($this->config->get($this->_name . '_code7'), ENT_QUOTES, 'UTF-8');
		$this->data['code8'] = html_entity_decode($this->config->get($this->_name . '_code8'), ENT_QUOTES, 'UTF-8');
		$this->data['code9'] = html_entity_decode($this->config->get($this->_name . '_code9'), ENT_QUOTES, 'UTF-8');
		$this->data['code10'] = html_entity_decode($this->config->get($this->_name . '_code10'), ENT_QUOTES, 'UTF-8');

		$position = $setting['tab_id'];

		switch($position) {
			case "tab1": $this->data['code'] = $this->data['code1']; $this->data['theme'] = $this->data['theme1']; $this->data['title'] = $this->data['title1']; break;
			case "tab2": $this->data['code'] = $this->data['code2']; $this->data['theme'] = $this->data['theme2']; $this->data['title'] = $this->data['title2']; break;
			case "tab3": $this->data['code'] = $this->data['code3']; $this->data['theme'] = $this->data['theme3']; $this->data['title'] = $this->data['title3']; break;
			case "tab4": $this->data['code'] = $this->data['code4']; $this->data['theme'] = $this->data['theme4']; $this->data['title'] = $this->data['title4']; break;
			case "tab5": $this->data['code'] = $this->data['code5']; $this->data['theme'] = $this->data['theme5']; $this->data['title'] = $this->data['title5']; break;
			case "tab6": $this->data['code'] = $this->data['code6']; $this->data['theme'] = $this->data['theme6']; $this->data['title'] = $this->data['title6']; break;
			case "tab7": $this->data['code'] = $this->data['code7']; $this->data['theme'] = $this->data['theme7']; $this->data['title'] = $this->data['title7']; break;
			case "tab8": $this->data['code'] = $this->data['code8']; $this->data['theme'] = $this->data['theme8']; $this->data['title'] = $this->data['title8']; break;
			case "tab9": $this->data['code'] = $this->data['code9']; $this->data['theme'] = $this->data['theme9']; $this->data['title'] = $this->data['title9']; break;
			case "tab10": $this->data['code'] = $this->data['code10']; $this->data['theme'] = $this->data['theme10']; $this->data['title'] = $this->data['title10']; break;
			default: $code = ''; $theme = ''; $title = '';
		}

		$this->data['module'] = $module++;

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/'.$this->_name.'.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/'.$this->_name.'.tpl';
		} else {
			$this->template = 'default/template/module/'.$this->_name.'.tpl';
		}

		$this->render();
	}
}
?>