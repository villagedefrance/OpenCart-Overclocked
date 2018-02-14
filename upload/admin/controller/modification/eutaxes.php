<?php
class ControllerModificationEutaxes extends Controller {
	private $error = array();
	private $_name = 'eutaxes';

	public function index() {
		$this->language->load('modification/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('modification/' . $this->_name);

		$this->model_modification_eutaxes->checkEUCountries();

		$this->getModification();
	}

	public function insert() {
		$this->language->load('modification/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('modification/' . $this->_name);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) {
			$this->model_modification_eutaxes->addEUCountries($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->post['apply'])) {
				$eucountry_id = $this->session->data['new_eucountry_id'];

				if ($eucountry_id) {
					unset($this->session->data['new_eucountry_id']);

					$this->redirect($this->url->link('modification/eutaxes/update', 'token=' . $this->session->data['token'] . '&eucountry_id=' . $eucountry_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('modification/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('modification/' . $this->_name);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) {
			$this->model_modification_eutaxes->editEUCountries($this->request->get['eucountry_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->post['apply'])) {
				$eucountry_id = $this->request->get['eucountry_id'];

				if ($eucountry_id) {
					$this->redirect($this->url->link('modification/eutaxes/update', 'token=' . $this->session->data['token'] . '&eucountry_id=' . $eucountry_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('modification/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('modification/' . $this->_name);

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $eucountry_id) {
				$this->model_modification_eutaxes->deleteEUCountries($eucountry_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function listing() {
		$this->language->load('modification/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	protected function getModification() {
		$this->language->load('modification/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['tab_configuration'] = $this->language->get('tab_configuration');
		$this->data['tab_status'] = $this->language->get('tab_status');

		$this->data['column_setting'] = $this->language->get('column_setting');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['help_manager'] = $this->language->get('help_manager');
		$this->data['help_geo_zone'] = $this->language->get('help_geo_zone');
		$this->data['help_tax_class'] = $this->language->get('help_tax_class');
		$this->data['help_tax_rate'] = $this->language->get('help_tax_rate');
		$this->data['help_tax_rule'] = $this->language->get('help_tax_rule');
		$this->data['help_troubleshoot'] = $this->language->get('help_troubleshoot');

		$this->data['button_eucountry'] = $this->language->get('button_eucountry');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_edit'] = $this->language->get('button_edit');

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
			'text'      => $this->language->get('text_modification'),
			'href'      => $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('modification/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		// Geo_zone Status
		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = array();

		$geo_zone_results = $this->model_localisation_geo_zone->getGeoZones(0);

		foreach ($geo_zone_results as $geo_zone_result) {
			$this->data['geo_zones'][] = array(
				'geo_zone_id' => $geo_zone_result['geo_zone_id'],
				'name'        => $geo_zone_result['name']
			);
		}

		$this->data['text_status_geo_zone'] = $this->language->get('text_status_geo_zone');

		// Tax_rate Status
		$this->load->model('localisation/tax_rate');

		$this->data['tax_rates'] = array();

		$tax_rates_results = $this->model_localisation_tax_rate->getTaxRates(0);

		foreach ($tax_rates_results as $tax_rates_result) {
			$this->data['tax_rates'][] = array(
				'tax_rate_id' => $tax_rates_result['tax_rate_id'],
				'name'        => $tax_rates_result['name'],
				'geo_zone'    => $tax_rates_result['geo_zone']
			);
		}

		$this->data['text_status_tax_rate'] = $this->language->get('text_status_tax_rate');

		// Tax_class & Tax_rule Status
		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = array();

		$tax_classes_results = $this->model_localisation_tax_class->getTaxClasses(0);

		foreach ($tax_classes_results as $tax_classes_result) {
			if ($tax_classes_result['tax_class_id'] && $tax_classes_result['title'] == 'EU E-medias') {
				$tax_rule = $this->model_localisation_tax_class->getTaxRules($tax_classes_result['tax_class_id']);
			} else {
				$tax_rule = false;
			}

			$this->data['tax_classes'][] = array(
				'tax_class_id' => $tax_classes_result['tax_class_id'],
				'title'        => $tax_classes_result['title'],
				'tax_rules'    => $tax_rule
			);
		}

		$this->data['text_status_tax_class'] = $this->language->get('text_status_tax_class');
		$this->data['text_status_tax_rule'] = $this->language->get('text_status_tax_rule');

		// Links
		$this->data['eucountries'] = $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL');

		// Actions
		$this->data['action_geo_zone'] = $this->url->link('localisation/geo_zone', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_tax_rate'] = $this->url->link('localisation/tax_rate', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_tax_class'] = $this->url->link('localisation/tax_class', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_tax_rule'] = $this->url->link('localisation/tax_class', 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'modification/eutaxes.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ecd.eucountry';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_modification'),
			'href'      => $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('modification/eutaxes/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('modification/eutaxes/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['close'] = $this->url->link('modification/eutaxes', 'token=' . $this->session->data['token'], 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('modification/eutaxes');

		$this->data['eucountries'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$eucountries_total = $this->model_modification_eutaxes->getTotalEUCountries();

		$this->data['totaleucountries'] = $eucountries_total;

		$results = $this->model_modification_eutaxes->getEUCountries($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('modification/eutaxes/update', 'token=' . $this->session->data['token'] . '&eucountry_id=' . $result['eucountry_id'], 'SSL')
			);

			if ($result['code'] && file_exists(DIR_APPLICATION . 'view/image/flags/' . strtolower($result['code']) . '.png')) {
				$flagcode = strtolower($result['code']);
			} elseif (($result['code'] == 'EL') && file_exists(DIR_APPLICATION . 'view/image/flags/gr.png')) {
				$flagcode = 'gr';
			} elseif (($result['code'] == 'UK') && file_exists(DIR_APPLICATION . 'view/image/flags/gb.png')) {
				$flagcode = 'gb';
			} else {
				$flagcode = '';
			}

			$this->data['eucountries'][] = array(
				'eucountry_id' => $result['eucountry_id'],
				'flag'         => $flagcode,
				'eucountry'    => $result['eucountry'],
				'code'         => $result['code'],
				'rate'         => $result['rate'],
				'status'       => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'selected'     => isset($this->request->post['selected']) && in_array($result['eucountry_id'], $this->request->post['selected']),
				'action'       => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_flag'] = $this->language->get('column_flag');
		$this->data['column_eucountry'] = $this->language->get('column_eucountry');
		$this->data['column_code'] = $this->language->get('column_code');
		$this->data['column_rate'] = $this->language->get('column_rate');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_close'] = $this->language->get('button_close');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_eucountry'] = $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . '&sort=ecd.eucountry' . $url, 'SSL');
		$this->data['sort_code'] = $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . '&sort=ec.code' . $url, 'SSL');
		$this->data['sort_rate'] = $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . '&sort=ec.rate' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . '&sort=ec.status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $eucountries_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'modification/eutaxes_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_default'] = $this->language->get('text_default');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_setting'] = $this->language->get('tab_setting');

		$this->data['entry_eucountry'] = $this->language->get('entry_eucountry');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_code'] = $this->language->get('entry_code');
		$this->data['entry_rate'] = $this->language->get('entry_rate');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['eucountry'])) {
			$this->data['error_eucountry'] = $this->error['eucountry'];
		} else {
			$this->data['error_eucountry'] = '';
		}

		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_modification'),
			'href'      => $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['eucountry_id'])) {
			$this->data['action'] = $this->url->link('modification/eutaxes/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('modification/eutaxes/update', 'token=' . $this->session->data['token'] . '&eucountry_id=' . $this->request->get['eucountry_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->load->model('modification/' . $this->_name);

		if ((isset($this->request->get['eucountry_id'])) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$eucountry_info = $this->model_modification_eutaxes->getEUCountryStory($this->request->get['eucountry_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['eucountry_description'])) {
			$this->data['eucountry_description'] = $this->request->post['eucountry_description'];
		} elseif (isset($this->request->get['eucountry_id'])) {
			$this->data['eucountry_description'] = $this->model_modification_eutaxes->getEUCountryDescriptions($this->request->get['eucountry_id']);
		} else {
			$this->data['eucountry_description'] = array();
		}

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['eucountry_store'])) {
			$this->data['eucountry_store'] = $this->request->post['eucountry_store'];
		} elseif (isset($eucountry_info)) {
			$this->data['eucountry_store'] = $this->model_modification_eutaxes->getEUCountryStores($this->request->get['eucountry_id']);
		} else {
			$this->data['eucountry_store'] = array(0);
		}

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (isset($eucountry_info)) {
			$this->data['code'] = $eucountry_info['code'];
		} else {
			$this->data['code'] = '';
		}

		if (isset($this->request->post['rate'])) {
			$this->data['rate'] = $this->request->post['rate'];
		} elseif (isset($eucountry_info)) {
			$this->data['rate'] = $eucountry_info['rate'];
		} else {
			$this->data['rate'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($eucountry_info)) {
			$this->data['status'] = $eucountry_info['status'];
		} else {
			$this->data['status'] = '';
		}

		$this->template = 'modification/eutaxes_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'modification/eutaxes')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['eucountry_description'] as $language_id => $value) {
			if ((strlen($value['eucountry']) < 3) || (strlen($value['eucountry']) > 128)) {
				$this->error['eucountry'][$language_id] = $this->language->get('error_eucountry');
			}

			if (strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'modification/eutaxes')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'modification/eutaxes')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	public function uninstall() {
		$this->cache->delete('eucountry');
	}
}
