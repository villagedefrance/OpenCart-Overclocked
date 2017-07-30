<?php
class ControllerModuleAccount extends Controller {
	private $_name = 'account';

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

		$this->data['code'] = $this->customer->getId();

		$this->data['text_register'] = $this->language->get('text_register');
		$this->data['text_login'] = $this->language->get('text_login');
		$this->data['text_logout'] = $this->language->get('text_logout');
		$this->data['text_forgotten'] = $this->language->get('text_forgotten');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_password'] = $this->language->get('text_password');
		$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_reward'] = $this->language->get('text_reward');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_addreturn'] = $this->language->get('text_addreturn');
		$this->data['text_transaction'] = $this->language->get('text_transaction');
		$this->data['text_recurring'] = $this->language->get('text_recurring');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_code'] = $this->language->get('text_code');
		$this->data['text_credit'] = $this->language->get('text_credit');

		$this->data['entry_email_address'] = $this->language->get('entry_email_address');
		$this->data['entry_password'] = $this->language->get('entry_password');

		$this->data['logged'] = $this->customer->isLogged();
		$this->data['register'] = $this->url->link($this->_name . '/register', '', 'SSL');
		$this->data['login'] = $this->url->link($this->_name . '/login', '', 'SSL');
		$this->data['logout'] = $this->url->link($this->_name . '/logout', '', 'SSL');
		$this->data['forgotten'] = $this->url->link($this->_name . '/forgotten', '', 'SSL');
		$this->data['account'] = $this->url->link($this->_name . '/account', '', 'SSL');
		$this->data['edit'] = $this->url->link($this->_name . '/edit', '', 'SSL');
		$this->data['password'] = $this->url->link($this->_name . '/password', '', 'SSL');
		$this->data['address'] = $this->url->link($this->_name . '/address', '', 'SSL');
		$this->data['wishlist'] = $this->url->link($this->_name . '/wishlist', '', 'SSL');
		$this->data['order'] = $this->url->link($this->_name . '/order', '', 'SSL');
		$this->data['download'] = $this->url->link($this->_name . '/download', '', 'SSL');
		$this->data['return'] = $this->url->link($this->_name . '/return', '', 'SSL');
		$this->data['addreturn'] = $this->url->link($this->_name . '/return/insert', '', 'SSL');
		$this->data['transaction'] = $this->url->link($this->_name . '/transaction', '', 'SSL');
		$this->data['recurring'] = $this->url->link($this->_name . '/recurring', '', 'SSL');
		$this->data['newsletter'] = $this->url->link($this->_name . '/newsletter', '', 'SSL');

		$this->data['button_login'] = $this->language->get('button_login');
		$this->data['button_logout'] = $this->language->get('button_logout');

		$this->data['action'] = $this->url->link($this->_name . '/login', '', 'SSL');
		$this->data['logout'] = $this->url->link('account/logout', '', 'SSL');

		// Reward
		if ($this->config->get('reward_status')) {
			$this->data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$this->data['reward'] = '';
		}

		// Returns
		if ($this->config->get('config_return_disable')) {
			$this->data['allow_return'] = false;
		} else {
			$this->data['allow_return'] = true;
		}

		// Profiles
		$this->load->model('account/recurring');

		$recurring_total = $this->model_account_recurring->getTotalRecurring();

		if ($recurring_total > 0) {
			$this->data['profile_exist'] = true;
		} else {
			$this->data['profile_exist'] = false;
		}

		$this->data['module'] = $module++;

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (!$this->customer->isLogged() || ($this->customer->isLogged() && $this->config->get($this->_name . '_mode') > 0)) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
			} else {
				$this->template = 'default/template/module/' . $this->_name . '.tpl';
			}

			$this->render();
		}
	}
}
