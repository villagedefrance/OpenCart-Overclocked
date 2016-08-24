<?php
class ControllerShippingCanadaPost extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('shipping/canadapost');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('canadapost', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('shipping/canadapost', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_eng'] = $this->language->get('text_eng');
		$this->data['text_french'] = $this->language->get('text_french');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_sellonline'] = $this->language->get('text_sellonline');

		$this->data['entry_language'] = $this->language->get('entry_language');
		$this->data['entry_server'] = $this->language->get('entry_server');
		$this->data['entry_port'] = $this->language->get('entry_port');
		$this->data['entry_merchant_id'] = $this->language->get('entry_merchant_id');
		$this->data['entry_origin'] = $this->language->get('entry_origin');
		$this->data['entry_handling'] = $this->language->get('entry_handling');
		$this->data['entry_packaging'] = $this->language->get('entry_packaging');
		$this->data['entry_turnaround'] = $this->language->get('entry_turnaround');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['link_sellonline'] = $this->language->get('link_sellonline');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['credit_version'] = $this->language->get('credit_version');
		$this->data['credit_author'] = $this->language->get('credit_author');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
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
			'href'      => $this->url->link('shipping/canadapost', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('shipping/canadapost', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['canadapost_language'])) {
			$this->data['canadapost_language'] = $this->request->post['canadapost_language'];
		} else {
			$this->data['canadapost_language'] = $this->config->get('canadapost_language');
		}

		if (isset($this->request->post['canadapost_server'])) {
			$this->data['canadapost_server'] = $this->request->post['canadapost_server'];
		} else {
			$this->data['canadapost_server'] = $this->config->get('canadapost_server');
		}

		if (isset($this->request->post['canadapost_port'])) {
			$this->data['canadapost_port'] = $this->request->post['canadapost_port'];
		} else {
			$this->data['canadapost_port'] = $this->config->get('canadapost_port');
		}

		if (isset($this->request->post['canadapost_merchant_id'])) {
			$this->data['canadapost_merchant_id'] = $this->request->post['canadapost_merchant_id'];
		} else {
			$this->data['canadapost_merchant_id'] = $this->config->get('canadapost_merchant_id');
		}

		if (isset($this->request->post['canadapost_origin'])) {
			$this->data['canadapost_origin'] = $this->request->post['canadapost_origin'];
		} else {
			$this->data['canadapost_origin'] = $this->config->get('canadapost_origin');
		}

		if (isset($this->request->post['canadapost_handling'])) {
			$this->data['canadapost_handling'] = $this->request->post['canadapost_handling'];
		} else {
			$this->data['canadapost_handling'] = $this->config->get('canadapost_handling');
		}

		if (isset($this->request->post['canadapost_turnaround'])) {
			$this->data['canadapost_turnaround'] = $this->request->post['canadapost_turnaround'];
		} else {
			$this->data['canadapost_turnaround'] = $this->config->get('canadapost_turnaround');
		}

		if (isset($this->request->post['canadapost_packaging'])) {
			$this->data['canadapost_packaging'] = $this->request->post['canadapost_packaging'];
		} else {
			$this->data['canadapost_packaging'] = $this->config->get('canadapost_packaging');
		}

		if (isset($this->request->post['canadapost_tax_class_id'])) {
			$this->data['canadapost_tax_class_id'] = $this->request->post['canadapost_tax_class_id'];
		} else {
			$this->data['canadapost_tax_class_id'] = $this->config->get('canadapost_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['canadapost_geo_zone_id'])) {
			$this->data['canadapost_geo_zone_id'] = $this->request->post['canadapost_geo_zone_id'];
		} else {
			$this->data['canadapost_geo_zone_id'] = $this->config->get('canadapost_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['canadapost_status'])) {
			$this->data['canadapost_status'] = $this->request->post['canadapost_status'];
		} else {
			$this->data['canadapost_status'] = $this->config->get('canadapost_status');
		}

		if (isset($this->request->post['canadapost_sort_order'])) {
			$this->data['canadapost_sort_order'] = $this->request->post['canadapost_sort_order'];
		} else {
			$this->data['canadapost_sort_order'] = $this->config->get('canadapost_sort_order');
		}

		$this->template = 'shipping/canadapost.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/canadapost')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// Set defaults
		if ($this->request->post['canadapost_server'] == "") {
			$this->request->post['canadapost_server'] = "sellonline.canadapost.ca";
		}

		if ($this->request->post['canadapost_port'] == "") {
			$this->request->post['canadapost_port'] = "30000";
		}

		if ($this->request->post['canadapost_merchant_id'] == "") {
			$this->request->post['canadapost_merchant_id'] = "CPC_DEMO_XML";
		}

		if (!isset($this->request->post['canadapost_language']) || $this->request->post['canadapost_language'] == "") {
			$this->request->post['canadapost_language'] = "en";
		}

		if ($this->request->post['canadapost_handling'] == "") {
			$this->request->post['canadapost_handling'] = "0.00";
		}

		if ($this->request->post['canadapost_turnaround'] == "0") {
			$this->request->post['canadapost_turnaround'] = "0";
		}

		if ($this->request->post['canadapost_status'] == 1) {
			if ($this->request->post['canadapost_merchant_id'] == "") {
				$this->error['warning'] = "You must have a Canada Post Sell Online Merchant Id to use this module";
			}

			// Validate origin postcode
			if (!preg_match('/[ABCEGHJKLMNPRSTVXYabceghjklmnprstvxy][0-9][A-Za-z] *[0-9][A-Za-z][0-9]/', $this->request->post['canadapost_origin'])) {
				$this->error['warning'] = "Postal Code is invalid. Must be a valid Canadian postal code.";
			}

			// Validate handling cost
			if (!preg_match('/^[0-9]{1,2}(\.[0-9]{1,2})?$/',$this->request->post['canadapost_handling'])) {
				$this->error['warning'] = "Additional Handling Cost must be a decimal value eg. (2.00). Maximum value (99.99)";
			} else {
				$this->request->post['canadapost_handling'] = sprintf("%.2f", $this->request->post['canadapost_handling']);
			}
		}

		return empty($this->error);
	}
}
