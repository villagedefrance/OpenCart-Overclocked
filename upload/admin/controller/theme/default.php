<?php
class ControllerThemeDefault extends Controller {
	private $error = array();
	private $_name = 'default';

	public function index() {
		$this->language->load('theme/default');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('default', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('theme/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/theme', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_theme'] = $this->language->get('text_theme');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_active'] = $this->language->get('text_active');
		$this->data['text_not_active'] = $this->language->get('text_not_active');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_options'] = $this->language->get('tab_options');
		$this->data['tab_credits'] = $this->language->get('tab_credits');

		$this->data['entry_category_menu'] = $this->language->get('entry_category_menu');
		$this->data['entry_breadcrumbs'] = $this->language->get('entry_breadcrumbs');
		$this->data['entry_cookie_consent'] = $this->language->get('entry_cookie_consent');
		$this->data['entry_cookie_privacy'] = $this->language->get('entry_cookie_privacy');
		$this->data['entry_back_to_top'] = $this->language->get('entry_back_to_top');
		$this->data['entry_manufacturer_name'] = $this->language->get('entry_manufacturer_name');
		$this->data['entry_manufacturer_image'] = $this->language->get('entry_manufacturer_image');

		$this->data['info_theme'] = $this->language->get('info_theme');
		$this->data['info_author'] = $this->language->get('info_author');
		$this->data['info_license'] = $this->language->get('info_license');
		$this->data['info_support'] = $this->language->get('info_support');

		$this->data['text_info_theme'] = $this->language->get('text_info_theme');
		$this->data['text_info_author'] = $this->language->get('text_info_author');
		$this->data['text_info_license'] = $this->language->get('text_info_license');
		$this->data['text_info_support'] = $this->language->get('text_info_support');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text' 	=> $this->language->get('text_home'),
			'href' 		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'   	=> $this->language->get('text_theme'),
			'href'   	=> $this->url->link('extension/theme', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'  	=> $this->language->get('heading_title'),
			'href'  	=> $this->url->link('theme/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('theme/default', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/theme', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		// Check Template
		$template = $this->config->get('config_template');

		if ($template = $this->_name) {
			$this->data['active'] = true;
		} else {
			$this->data['active'] = false;
		}

		// Settings
		if (isset($this->request->post['default_category_menu'])) {
			$this->data['default_category_menu'] = $this->request->post['default_category_menu'];
		} else {
			$this->data['default_category_menu'] = $this->config->get('default_category_menu');
		}

		if (isset($this->request->post['default_breadcrumbs'])) {
			$this->data['default_breadcrumbs'] = $this->request->post['default_breadcrumbs'];
		} else {
			$this->data['default_breadcrumbs'] = $this->config->get('default_breadcrumbs');
		}

		if (isset($this->request->post['default_cookie_consent'])) {
			$this->data['default_cookie_consent'] = $this->request->post['default_cookie_consent'];
		} else {
			$this->data['default_cookie_consent'] = $this->config->get('default_cookie_consent');
		}

		$this->load->model('catalog/information');

		$this->data['informations'] = $this->model_catalog_information->getInformationPages();

		if (isset($this->request->post['default_cookie_privacy'])) {
			$this->data['default_cookie_privacy'] = $this->request->post['default_cookie_privacy'];
		} else {
			$this->data['default_cookie_privacy'] = $this->config->get('default_cookie_privacy');
		}

		if (isset($this->request->post['default_back_to_top'])) {
			$this->data['default_back_to_top'] = $this->request->post['default_back_to_top'];
		} else {
			$this->data['default_back_to_top'] = $this->config->get('default_back_to_top');
		}

		if (isset($this->request->post['default_manufacturer_name'])) {
			$this->data['default_manufacturer_name'] = $this->request->post['default_manufacturer_name'];
		} else {
			$this->data['default_manufacturer_name'] = $this->config->get('default_manufacturer_name');
		}

		if (isset($this->request->post['default_manufacturer_image'])) {
			$this->data['default_manufacturer_image'] = $this->request->post['default_manufacturer_image'];
		} else {
			$this->data['default_manufacturer_image'] = $this->config->get('default_manufacturer_image');
		}

		$this->template = 'theme/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'theme/default')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>