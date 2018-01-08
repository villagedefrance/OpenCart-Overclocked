<?php
class ControllerShippingGeoZone extends Controller {
	private $error = array();
	private $_name = 'geozone';

	public function index() {
		$this->language->load('shipping/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('shipping/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_item'] = $this->language->get('text_item');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_weight'] = $this->language->get('text_weight');

		$this->data['entry_rate'] = $this->language->get('entry_rate');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_method'] = $this->language->get('entry_method');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

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
			'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('shipping/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/geo_zone');

		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();

		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post[$this->_name . '_' . $geo_zone['geo_zone_id'] . '_rate'])) {
				$this->data[$this->_name . '_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post[$this->_name . '_' . $geo_zone['geo_zone_id'] . '_rate'];
			} else {
				$this->data[$this->_name . '_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->config->get($this->_name . '_' . $geo_zone['geo_zone_id'] . '_rate');
			}

			if (isset($this->request->post[$this->_name . '_' . $geo_zone['geo_zone_id'] . '_status'])) {
				$this->data[$this->_name . '_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post[$this->_name . '_' . $geo_zone['geo_zone_id'] . '_status'];
			} else {
				$this->data[$this->_name . '_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get($this->_name . '_' . $geo_zone['geo_zone_id'] . '_status');
			}
		}

		if (isset($this->request->post[$this->_name . '_00_rate'])) {
			$this->data[$this->_name . '_00_rate'] = $this->request->post[$this->_name . '_00_rate'];
		} else {
			$this->data[$this->_name . '_00_rate'] = $this->config->get($this->_name . '_00_rate');
		}

		if (isset($this->request->post[$this->_name . '_00_status'])) {
			$this->data[$this->_name . '_00_status'] = $this->request->post[$this->_name . '_00_status'];
		} else {
			$this->data[$this->_name . '_00_status'] = $this->config->get($this->_name . '_00_status');
		}

		$other_zones[] = array(
			'geo_zone_id' => '00',
			'name'        => 'Other Zone(s)',
			'description' => 'Other Zone(s)'
		);

		$this->data['geo_zones'] = array_merge($geo_zones, $other_zones);

		if (isset($this->request->post[$this->_name . '_tax_class_id'])) {
			$this->data[$this->_name . '_tax_class_id'] = $this->request->post[$this->_name . '_tax_class_id'];
		} else {
			$this->data[$this->_name . '_tax_class_id'] = $this->config->get($this->_name . '_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post[$this->_name . '_status'])) {
			$this->data[$this->_name . '_status'] = $this->request->post[$this->_name . '_status'];
		} else {
			$this->data[$this->_name . '_status'] = $this->config->get($this->_name . '_status');
		}

		if (isset($this->request->post[$this->_name . '_method'])) {
			$this->data[$this->_name . '_method'] = $this->request->post[$this->_name . '_method'];
		} else {
			$this->data[$this->_name . '_method'] = $this->config->get($this->_name . '_method');
		}

		if (isset($this->request->post[$this->_name . '_sort_order'])) {
			$this->data[$this->_name . '_sort_order'] = $this->request->post[$this->_name . '_sort_order'];
		} else {
			$this->data[$this->_name . '_sort_order'] = $this->config->get($this->_name . '_sort_order');
		}

		$this->template = 'shipping/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
