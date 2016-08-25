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

		// Force accounts logout if logged in
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

		if ($this->affiliate->isLogged()) {
			$this->affiliate->logout();
		}

		// Show site if logged in as admin
		$this->load->library('user');

		$this->user = new User($this->registry);

		if (!$this->user->isLogged()) {
			$ban_page = $this->config->get('config_ban_page');

			if ($ban_page == 'search') {
				$end_page = 'search';
			} else {
				$end_page = 'firewall';
			}

			$this->session->destroy();

			header('Location: ../security/' . $end_page . '.html');
			exit();
		}
	}
}
