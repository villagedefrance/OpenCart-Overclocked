<?php
class ControllerPaymentInStore extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/in_store');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('in_store', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/in_store', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');

		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

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
			'href'      => $this->url->link('payment/in_store', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/in_store', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['in_store_total'])) {
			$this->data['in_store_total'] = $this->request->post['in_store_total'];
		} else {
			$this->data['in_store_total'] = $this->config->get('in_store_total');
		}

		if (isset($this->request->post['in_store_total_max'])) {
			$this->data['in_store_total_max'] = $this->request->post['in_store_total_max'];
		} else {
			$this->data['in_store_total_max'] = $this->config->get('in_store_total_max');
		}

		if (isset($this->request->post['in_store_order_status_id'])) {
			$this->data['in_store_order_status_id'] = $this->request->post['in_store_order_status_id'];
		} else {
			$this->data['in_store_order_status_id'] = $this->config->get('in_store_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['in_store_geo_zone_id'])) {
			$this->data['in_store_geo_zone_id'] = $this->request->post['in_store_geo_zone_id'];
		} else {
			$this->data['in_store_geo_zone_id'] = $this->config->get('in_store_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['in_store_status'])) {
			$this->data['in_store_status'] = $this->request->post['in_store_status'];
		} else {
			$this->data['in_store_status'] = $this->config->get('in_store_status');
		}

		if (isset($this->request->post['in_store_sort_order'])) {
			$this->data['in_store_sort_order'] = $this->request->post['in_store_sort_order'];
		} else {
			$this->data['in_store_sort_order'] = $this->config->get('in_store_sort_order');
		}

		$this->template = 'payment/in_store.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/in_store')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
