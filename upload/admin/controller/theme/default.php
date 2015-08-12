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
		$this->data['text_light'] = $this->language->get('text_light');
		$this->data['text_dark'] = $this->language->get('text_dark');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_active'] = $this->language->get('text_active');
		$this->data['text_not_active'] = $this->language->get('text_not_active');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_footer'] = $this->language->get('tab_footer');
		$this->data['tab_options'] = $this->language->get('tab_options');
		$this->data['tab_credits'] = $this->language->get('tab_credits');

		$this->data['entry_breadcrumbs'] = $this->language->get('entry_breadcrumbs');
		$this->data['entry_cookie_consent'] = $this->language->get('entry_cookie_consent');
		$this->data['entry_cookie_privacy'] = $this->language->get('entry_cookie_privacy');
		$this->data['entry_back_to_top'] = $this->language->get('entry_back_to_top');
		$this->data['entry_footer_theme'] = $this->language->get('entry_footer_theme');
		$this->data['entry_footer_location'] = $this->language->get('entry_footer_location');
		$this->data['entry_footer_phone'] = $this->language->get('entry_footer_phone');
		$this->data['entry_footer_email'] = $this->language->get('entry_footer_email');
		$this->data['entry_footer_facebook'] = $this->language->get('entry_footer_facebook');
		$this->data['entry_footer_twitter'] = $this->language->get('entry_footer_twitter');
		$this->data['entry_footer_google'] = $this->language->get('entry_footer_google');
		$this->data['entry_footer_pinterest'] = $this->language->get('entry_footer_pinterest');
		$this->data['entry_footer_skype'] = $this->language->get('entry_footer_skype');
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

		// General
		if (isset($this->request->post[$this->_name . '_breadcrumbs'])) {
			$this->data[$this->_name . '_breadcrumbs'] = $this->request->post[$this->_name . '_breadcrumbs'];
		} else {
			$this->data[$this->_name . '_breadcrumbs'] = $this->config->get($this->_name . '_breadcrumbs');
		}

		if (isset($this->request->post[$this->_name . '_cookie_consent'])) {
			$this->data[$this->_name . '_cookie_consent'] = $this->request->post[$this->_name . '_cookie_consent'];
		} else {
			$this->data[$this->_name . '_cookie_consent'] = $this->config->get($this->_name . '_cookie_consent');
		}

		$this->load->model('catalog/information');

		$this->data['informations'] = $this->model_catalog_information->getInformationPages();

		if (isset($this->request->post[$this->_name . '_cookie_privacy'])) {
			$this->data[$this->_name . '_cookie_privacy'] = $this->request->post[$this->_name . '_cookie_privacy'];
		} else {
			$this->data[$this->_name . '_cookie_privacy'] = $this->config->get($this->_name . '_cookie_privacy');
		}

		if (isset($this->request->post[$this->_name . '_back_to_top'])) {
			$this->data[$this->_name . '_back_to_top'] = $this->request->post[$this->_name . '_back_to_top'];
		} else {
			$this->data[$this->_name . '_back_to_top'] = $this->config->get($this->_name . '_back_to_top');
		}

		// Footer
		if (isset($this->request->post[$this->_name . '_footer_theme'])) {
			$this->data[$this->_name . '_footer_theme'] = $this->request->post[$this->_name . '_footer_theme'];
		} else {
			$this->data[$this->_name . '_footer_theme'] = $this->config->get($this->_name . '_footer_theme');
		}

		if (isset($this->request->post[$this->_name . '_footer_location'])) {
			$this->data[$this->_name . '_footer_location'] = $this->request->post[$this->_name . '_footer_location'];
		} else {
			$this->data[$this->_name . '_footer_location'] = $this->config->get($this->_name . '_footer_location');
		}

		if (isset($this->request->post[$this->_name . '_footer_phone'])) {
			$this->data[$this->_name . '_footer_phone'] = $this->request->post[$this->_name . '_footer_phone'];
		} else {
			$this->data[$this->_name . '_footer_phone'] = $this->config->get($this->_name . '_footer_phone');
		}

		if (isset($this->request->post[$this->_name . '_footer_email'])) {
			$this->data[$this->_name . '_footer_email'] = $this->request->post[$this->_name . '_footer_email'];
		} else {
			$this->data[$this->_name . '_footer_email'] = $this->config->get($this->_name . '_footer_email');
		}

		if (isset($this->request->post[$this->_name . '_footer_facebook'])) {
			$this->data[$this->_name . '_footer_facebook'] = $this->request->post[$this->_name . '_footer_facebook'];
		} else {
			$this->data[$this->_name . '_footer_facebook'] = $this->config->get($this->_name . '_footer_facebook');
		}

		if (isset($this->request->post[$this->_name . '_footer_twitter'])) {
			$this->data[$this->_name . '_footer_twitter'] = $this->request->post[$this->_name . '_footer_twitter'];
		} else {
			$this->data[$this->_name . '_footer_twitter'] = $this->config->get($this->_name . '_footer_twitter');
		}

		if (isset($this->request->post[$this->_name . '_footer_google'])) {
			$this->data[$this->_name . '_footer_google'] = $this->request->post[$this->_name . '_footer_google'];
		} else {
			$this->data[$this->_name . '_footer_google'] = $this->config->get($this->_name . '_footer_google');
		}

		if (isset($this->request->post[$this->_name . '_footer_pinterest'])) {
			$this->data[$this->_name . '_footer_pinterest'] = $this->request->post[$this->_name . '_footer_pinterest'];
		} else {
			$this->data[$this->_name . '_footer_pinterest'] = $this->config->get($this->_name . '_footer_pinterest');
		}

		if (isset($this->request->post[$this->_name . '_footer_skype'])) {
			$this->data[$this->_name . '_footer_skype'] = $this->request->post[$this->_name . '_footer_skype'];
		} else {
			$this->data[$this->_name . '_footer_skype'] = $this->config->get($this->_name . '_footer_skype');
		}

		// Options
		if (isset($this->request->post[$this->_name . '_manufacturer_name'])) {
			$this->data[$this->_name . '_manufacturer_name'] = $this->request->post[$this->_name . '_manufacturer_name'];
		} else {
			$this->data[$this->_name . '_manufacturer_name'] = $this->config->get($this->_name . '_manufacturer_name');
		}

		if (isset($this->request->post[$this->_name . '_manufacturer_image'])) {
			$this->data[$this->_name . '_manufacturer_image'] = $this->request->post[$this->_name . '_manufacturer_image'];
		} else {
			$this->data[$this->_name . '_manufacturer_image'] = $this->config->get($this->_name . '_manufacturer_image');
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