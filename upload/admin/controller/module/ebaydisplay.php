<?php
class ControllerModuleEbaydisplay extends Controller {
	private $error = array();
	private $_name = 'ebaydisplay';

	public function index() {
		$this->language->load('module/ebaydisplay');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('view/javascript/openbay/faq.js');
		$this->document->addStyle('view/stylesheet/openbay.css');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->cache->delete('ebaydisplay');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_header'] = $this->language->get('text_content_header');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_content_footer'] = $this->language->get('text_content_footer');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');

		$this->data['text_introduction'] = $this->language->get('text_introduction');
		$this->data['text_settings'] = $this->language->get('text_settings');
		$this->data['text_username'] = $this->language->get('text_username');
		$this->data['text_keysearch'] = $this->language->get('text_keysearch');
		$this->data['text_include'] = $this->language->get('text_include');
		$this->data['text_limit'] = $this->language->get('text_limit');
		$this->data['text_sort'] = $this->language->get('text_sort');
		$this->data['text_start_time'] = $this->language->get('text_start_time');
		$this->data['text_random'] = $this->language->get('text_random');
		$this->data['text_display'] = $this->language->get('text_display');
		$this->data['text_site'] = $this->language->get('text_site');

		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
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
			'href'      => $this->url->link('module/ebaydisplay', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/ebaydisplay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['stylesheet_mode'] = $this->config->get('config_stylesheet');

		// Module
		$this->data['modules'] = array();

		if (isset($this->request->post['ebaydisplay_module'])) {
			$this->data['modules'] = $this->request->post['ebaydisplay_module'];
		} elseif ($this->config->get('ebaydisplay_module')) {
			$this->data['modules'] = $this->config->get('ebaydisplay_module');
		} else {
			$this->data['modules'] = array();
		}

		if (isset($this->request->post['ebaydisplay_module_username'])) {
			$this->data['ebaydisplay_module_username'] = $this->request->post['ebaydisplay_module_username'];
		} elseif ($this->config->get('ebaydisplay_module_username')) {
			$this->data['ebaydisplay_module_username'] = $this->config->get('ebaydisplay_module_username');
		} else {
			$this->data['ebaydisplay_module_username'] = '';
		}

		if (isset($this->request->post['ebaydisplay_module_keywords'])) {
			$this->data['ebaydisplay_module_keywords'] = $this->request->post['ebaydisplay_module_keywords'];
		} elseif ($this->config->get('ebaydisplay_module_keywords')) {
			$this->data['ebaydisplay_module_keywords'] = $this->config->get('ebaydisplay_module_keywords');
		} else {
			$this->data['ebaydisplay_module_keywords'] = '';
		}

		if (isset($this->request->post['ebaydisplay_module_description'])) {
			$this->data['ebaydisplay_module_description'] = $this->request->post['ebaydisplay_module_description'];
		} elseif ($this->config->get('ebaydisplay_module_description')) {
			$this->data['ebaydisplay_module_description'] = $this->config->get('ebaydisplay_module_description');
		} else {
			$this->data['ebaydisplay_module_description'] = 0;
		}

		if (isset($this->request->post['ebaydisplay_module_limit'])) {
			$this->data['ebaydisplay_module_limit'] = $this->request->post['ebaydisplay_module_limit'];
		} elseif ($this->config->get('ebaydisplay_module_limit')) {
			$this->data['ebaydisplay_module_limit'] = $this->config->get('ebaydisplay_module_limit');
		} else {
			$this->data['ebaydisplay_module_limit'] = 10;
		}

		if (isset($this->request->post['ebaydisplay_module_sort'])) {
			$this->data['ebaydisplay_module_sort'] = $this->request->post['ebaydisplay_module_sort'];
		} elseif ($this->config->get('ebaydisplay_module_sort')) {
			$this->data['ebaydisplay_module_sort'] = $this->config->get('ebaydisplay_module_sort');
		} else {
			$this->data['ebaydisplay_module_sort'] = 'StartTimeNewest';
		}

		if (isset($this->request->post['ebaydisplay_module_site'])) {
			$this->data['ebaydisplay_module_site'] = $this->request->post['ebaydisplay_module_site'];
		} elseif ($this->config->get('ebaydisplay_module_site')) {
			$this->data['ebaydisplay_module_site'] = $this->config->get('ebaydisplay_module_site');
		} else {
			$this->data['ebaydisplay_module_site'] = 3;
		}

		$this->data['ebay_sites'] = array(
			0   => 'USA',
			3   => 'UK',
			15  => 'Australia',
			2   => 'Canada (English)',
			71  => 'France',
			77  => 'Germany',
			101 => 'Italy',
			186 => 'Spain',
			205 => 'Ireland',
			16  => 'Austria',
			146 => 'Netherlands',
			23  => 'Belgium (French)',
			123 => 'Belgium (Dutch)'
		);

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/ebaydisplay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/ebaydisplay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
