<?php
class ControllerModuleAffiliate extends Controller {
	private $_name = 'affiliate';

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

		$this->data['mode'] = $this->config->get($this->_name . '_mode');

		$this->data['text_register'] = $this->language->get('text_register');
		$this->data['text_login'] = $this->language->get('text_login');
		$this->data['text_logout'] = $this->language->get('text_logout');
		$this->data['text_forgotten'] = $this->language->get('text_forgotten');

		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_password'] = $this->language->get('text_password');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_tracking'] = $this->language->get('text_tracking');
		$this->data['text_transaction'] = $this->language->get('text_transaction');
		$this->data['text_code'] = $this->language->get('text_code');
		$this->data['text_balance'] = $this->language->get('text_balance');

		$this->data['entry_email_address'] = $this->language->get('entry_email_address');
		$this->data['entry_password'] = $this->language->get('entry_password');

		$this->data['logged'] = $this->affiliate->isLogged();
		$this->data['register'] = $this->url->link($this->_name . '/register', '', 'SSL');
		$this->data['login'] = $this->url->link($this->_name . '/login', '', 'SSL');
		$this->data['logout'] = $this->url->link($this->_name . '/logout', '', 'SSL');
		$this->data['forgotten'] = $this->url->link($this->_name . '/forgotten', '', 'SSL');
		$this->data['account'] = $this->url->link($this->_name . '/account', '', 'SSL');
		$this->data['edit'] = $this->url->link($this->_name . '/edit', '', 'SSL');
		$this->data['password'] = $this->url->link($this->_name . '/password', '', 'SSL');
		$this->data['payment'] = $this->url->link($this->_name . '/payment', '', 'SSL');
		$this->data['product'] = $this->url->link($this->_name . '/product', '', 'SSL');
		$this->data['tracking'] = $this->url->link($this->_name . '/tracking', '', 'SSL');
		$this->data['transaction'] = $this->url->link($this->_name . '/transaction', '', 'SSL');

		$this->data['button_login'] = $this->language->get('button_login');
		$this->data['button_logout'] = $this->language->get('button_logout');

		$this->data['action'] = $this->url->link($this->_name . '/login', '', 'SSL');
		$this->data['logout'] = $this->url->link('affiliate/logout', '', 'SSL');

		$this->data['module'] = $module++;

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (!$this->affiliate->isLogged() || ($this->affiliate->isLogged() && $this->config->get($this->_name . '_mode') > 0)) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
			} else {
				$this->template = 'default/template/module/' . $this->_name . '.tpl';
			}

			$this->render();
		}
	}
}
