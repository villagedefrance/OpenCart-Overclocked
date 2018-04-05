<?php
class ControllerAccountDelete extends Controller {
	private $error = array();

	public function index() {
		if ($this->config->get('config_secure') && !$this->request->isSecure()) {
			$this->redirect($this->url->link('account/delete', '', 'SSL'), 301);
		}

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/delete', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if (!$this->customer->isSecure() || $this->customer->loginExpired()) {
			$this->customer->logout();

			$this->session->data['redirect'] = $this->url->link('account/delete', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/delete');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			unset($this->session->data['captcha']);

			$customer_id = $this->customer->getId();

			$this->model_account_customer->addDeletedCustomer($customer_id);

			$this->customer->logout();
			$this->cart->clear();

			unset($this->session->data['wishlist']);
			unset($this->session->data['shipping_address_id']);
			unset($this->session->data['shipping_country_id']);
			unset($this->session->data['shipping_zone_id']);
			unset($this->session->data['shipping_postcode']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_address_id']);
			unset($this->session->data['payment_country_id']);
			unset($this->session->data['payment_zone_id']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);

			$orders_total = $this->model_account_customer->getTotalCustomersOrders($customer_id);

			if ($orders_total > 0) {
				$this->model_account_customer->deleteCustomerWithOrders($customer_id);
			} else {
				$this->model_account_customer->deleteCustomer($customer_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

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

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_delete'),
			'href'      => $this->url->link('account/delete', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_delete_warning'] = $this->language->get('text_delete_warning');
		$this->data['text_delete_account'] = $this->language->get('text_delete_account');

		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_captcha'] = $this->language->get('entry_captcha');

		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['captcha'])) {
			$this->data['error_captcha'] = $this->error['captcha'];
		} else {
			$this->data['error_captcha'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('account/delete', '', 'SSL');

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($this->request->post['captcha'])) {
			$this->data['captcha'] = $this->request->post['captcha'];
		} else {
			$this->data['captcha'] = '';
		}

		$this->data['captcha_image'] = $this->url->link('account/delete/captcha', '', 'SSL');

		$this->data['back'] = $this->url->link('account/edit', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/delete.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/delete.tpl';
		} else {
			$this->template = 'default/template/account/delete.tpl';
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

	public function success() {
		if ($this->config->get('config_secure') && !$this->request->isSecure()) {
			$this->redirect($this->url->link('account/delete/success', '', 'SSL'));
		}

		$this->language->load('account/delete');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/delete', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_message'] = $this->language->get('text_message');

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('common/home', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
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

	protected function validate() {
		$this->load->model('account/customer');

		if ($this->request->post['password']) {
			$password_match = $this->model_account_customer->checkCustomerPassword($this->request->post['password'], $this->customer->getId(), $this->customer->getEmail());

			if ($password_match) {
				$this->error['password'] = $this->language->get('error_password_match');
			}

			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$this->error['password'] = $this->language->get('error_password');
			}

		} else {
			$this->error['password'] = $this->language->get('error_password_required');
		}

		if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != strtolower($this->request->post['captcha']))) {
			$this->error['captcha'] = $this->language->get('error_captcha');
		}

		return empty($this->error);
	}

	public function captcha() {
		$this->load->library('captcha');

		$captcha = new Captcha();

		$this->session->data['captcha'] = $captcha->getCode();

		$captcha->showImage($this->config->get('config_captcha_font'));
	}
}
