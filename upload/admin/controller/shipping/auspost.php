<?php
class ControllerShippingAusPost extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('shipping/auspost');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('auspost', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('shipping/auspost', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');

		$this->data['entry_api'] = $this->language->get('entry_api');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
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

		if (isset($this->error['api'])) {
			$this->data['error_api'] = $this->error['api'];
		} else {
			$this->data['error_api'] = '';
		}

		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
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
			'href'      => $this->url->link('shipping/auspost', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('shipping/auspost', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['auspost_api'])) {
			$this->data['auspost_api'] = $this->request->post['auspost_api'];
		} else {
			$this->data['auspost_api'] = $this->config->get('auspost_api');
		}

		if (isset($this->request->post['auspost_postcode'])) {
			$this->data['auspost_postcode'] = $this->request->post['auspost_postcode'];
		} else {
			$this->data['auspost_postcode'] = $this->config->get('auspost_postcode');
		}

		if (isset($this->request->post['auspost_weight_class_id'])) {
			$this->data['auspost_weight_class_id'] = $this->request->post['auspost_weight_class_id'];
		} else {
			$this->data['auspost_weight_class_id'] = $this->config->get('auspost_weight_class_id');
		}

		$this->load->model('localisation/weight_class');

		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['auspost_tax_class_id'])) {
			$this->data['auspost_tax_class_id'] = $this->request->post['auspost_tax_class_id'];
		} else {
			$this->data['auspost_tax_class_id'] = $this->config->get('auspost_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['auspost_geo_zone_id'])) {
			$this->data['auspost_geo_zone_id'] = $this->request->post['auspost_geo_zone_id'];
		} else {
			$this->data['auspost_geo_zone_id'] = $this->config->get('auspost_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['auspost_status'])) {
			$this->data['auspost_status'] = $this->request->post['auspost_status'];
		} else {
			$this->data['auspost_status'] = $this->config->get('auspost_status');
		}

		if (isset($this->request->post['auspost_sort_order'])) {
			$this->data['auspost_sort_order'] = $this->request->post['auspost_sort_order'];
		} else {
			$this->data['auspost_sort_order'] = $this->config->get('auspost_sort_order');
		}

		$this->template = 'shipping/auspost.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/auspost')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['auspost_api'])) {
			$this->error['api'] = $this->language->get('error_api');
		}

		if (!preg_match('/^[0-9]{4}$/', $this->request->post['auspost_postcode'])) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}

		return empty($this->error);
	}
}
