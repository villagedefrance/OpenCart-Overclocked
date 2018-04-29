<?php
class ControllerAccountAccount extends Controller {

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if (!$this->customer->isSecure() || $this->customer->loginExpired()) {
			$this->customer->logout();

			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		// Breadcrumbs
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_my_account'] = $this->language->get('text_my_account');
		$this->data['text_my_orders'] = $this->language->get('text_my_orders');
		$this->data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_password'] = $this->language->get('text_password');
		$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_no_address'] = $this->language->get('text_no_address');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_reward'] = $this->language->get('text_reward');
		$this->data['text_transaction'] = $this->language->get('text_transaction');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_addreturn'] = $this->language->get('text_addreturn');
		$this->data['text_recurring'] = $this->language->get('text_recurring');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');

		$this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
		$this->data['password'] = $this->url->link('account/password', '', 'SSL');
		$this->data['address'] = $this->url->link('account/address', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['download'] = $this->url->link('account/download', '', 'SSL');
		$this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$this->data['return'] = $this->url->link('account/return', '', 'SSL');
		$this->data['addreturn'] = $this->url->link('account/return/insert', '', 'SSL');
		$this->data['recurring'] = $this->url->link('account/recurring', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$this->data['button_my_cart'] = $this->language->get('button_my_cart');
		$this->data['button_logout'] = $this->language->get('button_logout');

		$this->data['my_cart'] = $this->url->link('checkout/cart', '', 'SSL');
		$this->data['logout'] = $this->url->link('account/logout', '', 'SSL');

		// Check Cart
		if ($this->cart->hasProducts()) {
			$this->data['cart_exist'] = true;
		} else {
			$this->data['cart_exist'] = false;
		}

		// Check Addresses
		$this->load->model('account/address');

		$this->data['addresses'] = $this->model_account_address->getTotalAddresses();

		// Rewards
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

		// Account Header
		if ($this->customer->isLogged()) {
			$this->data['firstname'] = $this->customer->getFirstName();
			$this->data['lastname'] = $this->customer->getLastName();
			$this->data['email'] = $this->customer->getEmail();

			$this->load->model('tool/image');
			$this->load->model('account/customer_group');

			$customer_group_id = $this->customer->getCustomerGroupId();

			$customer_group_image = $this->model_account_customer_group->getCustomerGroupImage($customer_group_id);

			if (!empty($customer_group_image['image'])) {
				$this->data['thumb'] = $this->model_tool_image->resize($customer_group_image['image'], 150, 50);
			} else {
				$this->data['thumb'] = '';
			}

		} else {
			$this->data['firstname'] = '';
			$this->data['lastname'] = '';
			$this->data['email'] = '';
			$this->data['thumb'] = '';
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/account.tpl';
		} else {
			$this->template = 'default/template/account/account.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_header',
			'common/content_top',
			'common/content_bottom',
			'common/content_footer',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}
}
