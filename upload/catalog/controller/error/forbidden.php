<?php
class ControllerErrorForbidden extends Controller {

	public function index() {
		$route = '';

		if (isset($this->request->get['route'])) {
			$part = explode('/', $this->request->get['route']);

			if (isset($part[0])) {
				$route .= $part[0];
			}
		}

		if ($this->customer->isLogged()) {
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
		}

		// Show site if logged in as admin
		$this->load->library('user');

		$this->user = new User($this->registry);

		if (!$this->user->isLogged()) {
			return $this->forward('error/forbidden/info');
		}
	}

	public function info() {
		$this->language->load('error/forbidden');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['message'] = $this->language->get('text_message');

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/forbidden.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/error/forbidden.tpl';
		} else {
			$this->template = 'default/template/error/forbidden.tpl';
		}

		$this->children = array(
			'common/footer',
			'common/header'
		);

		if ($this->request->server['SERVER_PROTOCOL'] == 'HTTP/1.1') {
			$this->response->addHeader('HTTP/1.1 403 Forbidden');
		} else {
			$this->response->addHeader('HTTP/1.0 403 Forbidden');
		}

		$this->response->setOutput($this->render());
	}
}
?>