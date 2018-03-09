<?php
class ControllerModuleMenuHorizontal extends Controller {
	private $error = array();
	private $_name = 'menu_horizontal';

	public function index() {
		$this->language->load('module/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_light'] = $this->language->get('text_light');
		$this->data['text_dark'] = $this->language->get('text_dark');
		$this->data['text_custom'] = $this->language->get('text_custom');
		$this->data['text_ltr'] = $this->language->get('text_ltr');
		$this->data['text_rtl'] = $this->language->get('text_rtl');
		$this->data['text_icon'] = $this->language->get('text_icon');
		$this->data['text_manage_menu'] = $this->language->get('text_manage_menu');
		$this->data['text_content_header'] = $this->language->get('text_content_header');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_content_footer'] = $this->language->get('text_content_footer');
		$this->data['text_no_menu'] = $this->language->get('text_no_menu');
		$this->data['text_menus'] = $this->language->get('text_menus');

		$this->data['entry_theme'] = $this->language->get('entry_theme');
		$this->data['entry_header_color'] = $this->language->get('entry_header_color');
		$this->data['entry_header_shape'] = $this->language->get('entry_header_shape');
		$this->data['entry_column_limit'] = $this->language->get('entry_column_limit');
		$this->data['entry_column_number'] = $this->language->get('entry_column_number');

		$this->data['entry_menu'] = $this->language->get('entry_menu');
		$this->data['entry_home'] = $this->language->get('entry_home');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_direction'] = $this->language->get('entry_direction');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_manager'] = $this->language->get('button_manager');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['menu'])) {
			$this->data['error_menu'] = $this->error['menu'];
		} else {
			$this->data['error_menu'] = array();
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		// Manager
		$this->data['manager'] = $this->url->link('design/menu', 'token=' . $this->session->data['token'], 'SSL');

		// Module
		if (isset($this->request->post[$this->_name . '_theme'])) {
			$this->data[$this->_name . '_theme'] = $this->request->post[$this->_name . '_theme'];
		} else {
			$this->data[$this->_name . '_theme'] = $this->config->get($this->_name . '_theme');
		}

		$this->data['skins'] = $this->model_setting_setting->getColors();

		if (isset($this->request->post[$this->_name . '_header_color'])) {
			$this->data[$this->_name . '_header_color'] = $this->request->post[$this->_name . '_header_color'];
		} else {
			$this->data[$this->_name . '_header_color'] = $this->config->get($this->_name . '_header_color');
		}

		$this->data['shapes'] = $this->model_setting_setting->getShapes();

		if (isset($this->request->post[$this->_name . '_header_shape'])) {
			$this->data[$this->_name . '_header_shape'] = $this->request->post[$this->_name . '_header_shape'];
		} else {
			$this->data[$this->_name . '_header_shape'] = $this->config->get($this->_name . '_header_shape');
		}

		if (isset($this->request->post[$this->_name . '_column_limit'])) {
			$this->data[$this->_name . '_column_limit'] = $this->request->post[$this->_name . '_column_limit'];
		} else {
			$this->data[$this->_name . '_column_limit'] = $this->config->get($this->_name . '_column_limit');
		}

		if (isset($this->request->post[$this->_name . '_column_number'])) {
			$this->data[$this->_name . '_column_number'] = $this->request->post[$this->_name . '_column_number'];
		} else {
			$this->data[$this->_name . '_column_number'] = $this->config->get($this->_name . '_column_number');
		}

		$this->data['modules'] = array();

		if (isset($this->request->post[$this->_name . '_module'])) {
			$this->data['modules'] = $this->request->post[$this->_name . '_module'];
		} elseif ($this->config->get($this->_name . '_module')) {
			$this->data['modules'] = $this->config->get($this->_name . '_module');
		}

		$this->load->model('design/menu');

		$this->data['menus'] = $this->model_design_menu->getMenus();

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post[$this->_name . '_module'])) {
			foreach ($this->request->post[$this->_name . '_module'] as $key => $value) {
				if (!$value['menu_id']) {
					$this->error['menu'][$key] = $this->language->get('error_menu');
				}
			}
		}

		return empty($this->error);
	}
}
