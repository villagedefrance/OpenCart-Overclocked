<?php
class ControllerPaymentPayhub extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/payhub');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payhub', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/payhub', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_test'] = $this->language->get('text_test');
		$this->data['text_live'] = $this->language->get('text_live');
		$this->data['text_default_cards_accepted'] = $this->language->get('text_default_cards_accepted');

		$this->data['entry_org_id'] = $this->language->get('entry_org_id');
		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_terminal_id'] = $this->language->get('entry_terminal_id');
		$this->data['entry_hash'] = $this->language->get('entry_hash');
		$this->data['entry_mode'] = $this->language->get('entry_mode');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_cards_accepted'] = $this->language->get('entry_cards_accepted');
		$this->data['entry_invoice_prefix'] = $this->language->get('entry_invoice_prefix');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['org_id'])) {
			$this->data['error_org_id'] = $this->error['org_id'];
		} else {
			$this->data['error_org_id'] = '';
		}

 		if (isset($this->error['username'])) {
			$this->data['error_username'] = $this->error['username'];
		} else {
			$this->data['error_username'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['terminal_id'])) {
			$this->data['error_terminal_id'] = $this->error['terminal_id'];
		} else {
			$this->data['error_terminal_id'] = '';
		}

		if (isset($this->error['invoice_prefix'])) {
			$this->data['error_invoice_prefix'] = $this->error['invoice_prefix'];
		} else {
			$this->data['error_invoice_prefix'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/payhub', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/payhub', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['payhub_org_id'])) {
			$this->data['payhub_org_id'] = $this->request->post['payhub_org_id'];
		} else {
			$this->data['payhub_org_id'] = $this->config->get('payhub_org_id');
		}

		if (isset($this->request->post['payhub_username'])) {
			$this->data['payhub_username'] = $this->request->post['payhub_username'];
		} else {
			$this->data['payhub_username'] = $this->config->get('payhub_username');
		}

		if (isset($this->request->post['payhub_password'])) {
			$this->data['payhub_password'] = $this->request->post['payhub_password'];
		} else {
			$this->data['payhub_password'] = $this->config->get('payhub_password');
		}

		if (isset($this->request->post['payhub_terminal_id'])) {
			$this->data['payhub_terminal_id'] = $this->request->post['payhub_terminal_id'];
		} else {
			$this->data['payhub_terminal_id'] = $this->config->get('payhub_terminal_id');
		}

		if (isset($this->request->post['payhub_server'])) {
			$this->data['payhub_server'] = $this->request->post['payhub_server'];
		} else {
			$this->data['payhub_server'] = $this->config->get('payhub_server');
		}

		if (isset($this->request->post['payhub_mode'])) {
			$this->data['payhub_mode'] = $this->request->post['payhub_mode'];
		} else {
			$this->data['payhub_mode'] = $this->config->get('payhub_mode');
		}

		if (isset($this->request->post['payhub_cards_accepted'])) {
			$this->data['payhub_cards_accepted'] = $this->request->post['payhub_cards_accepted'];
		} else {
			$this->data['payhub_cards_accepted'] = ($this->config->get('payhub_cards_accepted')) ? $this->config->get('payhub_cards_accepted') : $this->language->get('text_default_cards_accepted');
		}

		if (isset($this->request->post['payhub_invoice_prefix'])) {
			$this->data['payhub_invoice_prefix'] = $this->request->post['payhub_invoice_prefix'];
		} else {
			$this->data['payhub_invoice_prefix'] = $this->config->get('payhub_invoice_prefix');
		}

		if (isset($this->request->post['payhub_method'])) {
			$this->data['payhub_method'] = $this->request->post['payhub_method'];
		} else {
			$this->data['payhub_method'] = $this->config->get('payhub_method');
		}

		if (isset($this->request->post['payhub_total'])) {
			$this->data['payhub_total'] = $this->request->post['payhub_total'];
		} else {
			$this->data['payhub_total'] = $this->config->get('payhub_total');
		}

		if (isset($this->request->post['payhub_total_max'])) {
			$this->data['payhub_total_max'] = $this->request->post['payhub_total_max'];
		} else {
			$this->data['payhub_total_max'] = $this->config->get('payhub_total_max');
		}

		if (isset($this->request->post['payhub_order_status_id'])) {
			$this->data['payhub_order_status_id'] = $this->request->post['payhub_order_status_id'];
		} else {
			$this->data['payhub_order_status_id'] = $this->config->get('payhub_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['payhub_geo_zone_id'])) {
			$this->data['payhub_geo_zone_id'] = $this->request->post['payhub_geo_zone_id'];
		} else {
			$this->data['payhub_geo_zone_id'] = $this->config->get('payhub_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['payhub_status'])) {
			$this->data['payhub_status'] = $this->request->post['payhub_status'];
		} else {
			$this->data['payhub_status'] = $this->config->get('payhub_status');
		}

		if (isset($this->request->post['payhub_sort_order'])) {
			$this->data['payhub_sort_order'] = $this->request->post['payhub_sort_order'];
		} else {
			$this->data['payhub_sort_order'] = $this->config->get('payhub_sort_order');
		}

		$this->template = 'payment/payhub.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/payhub')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['payhub_org_id']) {
			$this->error['org_id'] = $this->language->get('error_org_id');
		}

		if (!$this->request->post['payhub_username']) {
			$this->error['username'] = $this->language->get('error_username');
		}

		if (!$this->request->post['payhub_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!$this->request->post['payhub_terminal_id']) {
			$this->error['terminal_id'] = $this->language->get('error_terminal_id');
		}

		if (preg_match('/[^0-9a-zA-Z-]/', $this->request->post['payhub_invoice_prefix'])) {
			$this->error['invoice_prefix'] = $this->language->get('error_invoice_prefix');
		}

		return empty($this->error);
	}
}
