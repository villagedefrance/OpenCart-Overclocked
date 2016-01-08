<?php
class ControllerModificationEutaxes extends Controller {
	private $error = array();
	private $_name = 'eutaxes';

	public function index() {
		$this->language->load('modification/' . $this->_name);

		$this->load->model('modification/' . $this->_name);

		$this->model_modification_eutaxes->checkEUCountries();

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getModification();
	}

	public function insert() {
		$this->language->load('modification/' . $this->_name);

		$this->load->model('modification/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

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

		$this->load->model('modification/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

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

		$this->load->model('modification/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

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

	public function getModification() {
		$this->language->load('modification/' . $this->_name);

		$this->load->model('modification/' . $this->_name);

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
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_modification'),
			'href'		=> $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('modification/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		// Geo_zone Status
		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = array();

		$geo_zone_results = $this->model_localisation_geo_zone->getGeoZones(0);

		foreach ($geo_zone_results as $geo_zone_result) {
			$this->data['geo_zones'][] = array(
				'geo_zone_id' 	=> $geo_zone_result['geo_zone_id'],
				'name'        	=> $geo_zone_result['name']
			);
		}

		$this->data['text_status_geo_zone'] = $this->language->get('text_status_geo_zone');

		// Tax_rate Status
		$this->load->model('localisation/tax_rate');

		$this->data['tax_rates'] = array();

		$tax_rates_results = $this->model_localisation_tax_rate->getTaxRates(0);

		foreach ($tax_rates_results as $tax_rates_result) {
			$this->data['tax_rates'][] = array(
				'tax_rate_id'	=> $tax_rates_result['tax_rate_id'],
				'name'			=> $tax_rates_result['name'],
				'geo_zone'		=> $tax_rates_result['geo_zone']
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
				'tax_class_id' 	=> $tax_classes_result['tax_class_id'],
				'title'        		=> $tax_classes_result['title'],
				'tax_rules' 		=> $tax_rule
			);
		}

		$this->data['text_status_tax_class'] = $this->language->get('text_status_tax_class');
		$this->data['text_status_tax_rule'] = $this->language->get('text_status_tax_rule');

		// Actions
		$this->data['eucountries'] = $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL');

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

	public function getList() {
		$this->language->load('modification/' . $this->_name);

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
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_modification'),
			'href'		=> $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('modification/eutaxes/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('modification/eutaxes/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['cancel'] = $this->url->link('modification/eutaxes', 'token=' . $this->session->data['token'], 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('modification/eutaxes');

		$this->data['eucountries'] = array();

		$data = array(
			'sort'  	=> $sort,
			'order' 	=> $order,
			'start' 	=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' 		=> $this->config->get('config_admin_limit')
		);

		$eucountries_total = $this->model_modification_eutaxes->getTotalEUCountries();

		$this->data['totaleucountries'] = $eucountries_total;

		$results = $this->model_modification_eutaxes->getEUCountries($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text'	=> $this->language->get('text_edit'),
				'href'	=> $this->url->link('modification/eutaxes/update', 'token=' . $this->session->data['token'] . '&eucountry_id=' . $result['eucountry_id'], 'SSL')
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
				'eucountry_id'	=> $result['eucountry_id'],
				'flag'				=> $flagcode,
				'eucountry'		=> $result['eucountry'],
				'code'			=> $result['code'],
				'rate'				=> $result['rate'],
				'status'			=> $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'selected'		=> isset($this->request->post['selected']) && in_array($result['eucountry_id'], $this->request->post['selected']),
				'action'			=> $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_flag'] = $this->language->get('column_flag');
		$this->data['column_eucountry'] = $this->language->get('column_eucountry');
		$this->data['column_code'] = $this->language->get('column_code');
		$this->data['column_rate'] = $this->language->get('column_rate');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

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

	public function getForm() {
		$this->language->load('modification/' . $this->_name);

		$this->load->model('modification/' . $this->_name);

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
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_modification'),
			'href'		=> $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['eucountry_id'])) {
			$this->data['action'] = $this->url->link('modification/eutaxes/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('modification/eutaxes/update', 'token=' . $this->session->data['token'] . '&eucountry_id=' . $this->request->get['eucountry_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('modification/eutaxes/listing', 'token=' . $this->session->data['token'] . $url, 'SSL');

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

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'modification/eutaxes')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
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

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'modification/eutaxes')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function install() {
		// Create eucountry table
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "eucountry`");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "eucountry` (`eucountry_id` int(11) NOT NULL AUTO_INCREMENT, `code` varchar(2) DEFAULT NULL, `rate` decimal(15,4) NOT NULL DEFAULT '0.0000', `status` tinyint(1) NOT NULL, PRIMARY KEY (`eucountry_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		// Create eucountry description table
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "eucountry_description`");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "eucountry_description` (`eucountry_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `eucountry` varchar(128) NOT NULL, `description` text CHARACTER SET utf8 NOT NULL, PRIMARY KEY (`eucountry_id`,`language_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		// Create eucountry store table
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "eucountry_to_store`");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "eucountry_to_store` (`eucountry_id` int(11) NOT NULL, `store_id` int(11) NOT NULL DEFAULT '0', PRIMARY KEY (`eucountry_id`,`store_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

		// Add eucountry data
		$this->db->query("INSERT INTO `" . DB_PREFIX . "eucountry` (`eucountry_id`, `code`, `rate`, `status`) VALUES
			(1, 'AT', '20.0000', '1'),
			(2, 'BE', '21.0000', '1'),
			(3, 'BG', '20.0000', '1'),
			(4, 'CY', '19.0000', '1'),
			(5, 'CZ', '21.0000', '1'),
			(6, 'DE', '19.0000', '1'),
			(7, 'DK', '25.0000', '1'),
			(8, 'EE', '20.0000', '1'),
			(9, 'ES', '21.0000', '1'),
			(10, 'FI', '24.0000', '1'),
			(11, 'FR', '20.0000', '1'),
			(12, 'GB', '20.0000', '1'),
			(13, 'GR', '23.0000', '1'),
			(14, 'HR', '25.0000', '1'),
			(15, 'HU', '27.0000', '1'),
			(16, 'IE', '23.0000', '1'),
			(17, 'IT', '22.0000', '1'),
			(18, 'LV', '21.0000', '1'),
			(19, 'LT', '21.0000', '1'),
			(20, 'LU', '17.0000', '1'),
			(21, 'MT', '18.0000', '1'),
			(22, 'NL', '21.0000', '1'),
			(23, 'PL', '23.0000', '1'),
			(24, 'PT', '23.0000', '1'),
			(25, 'RO', '24.0000', '1'),
			(26, 'SE', '25.0000', '1'),
			(27, 'SI', '22.0000', '1'),
			(28, 'SK', '20.0000', '1');
		");

		// Add eucountry description data
		$this->db->query("INSERT INTO `" . DB_PREFIX . "eucountry_description` (`eucountry_id`, `language_id`, `eucountry`, `description`) VALUES
			(1, 1, 'Austria', 'VAT Rate AT'),
			(2, 1, 'Belgium', 'VAT Rate BE'),
			(3, 1, 'Bulgaria', 'VAT Rate BG'),
			(4, 1, 'Cyprus', 'VAT Rate CY'),
			(5, 1, 'Czech Republic', 'VAT Rate CZ'),
			(6, 1, 'Germany', 'VAT Rate DE'),
			(7, 1, 'Denmark', 'VAT Rate DK'),
			(8, 1, 'Estonia', 'VAT Rate EE'),
			(9, 1, 'Spain', 'VAT Rate ES'),
			(10, 1, 'Finland', 'VAT Rate FI'),
			(11, 1, 'France', 'VAT Rate FR'),
			(12, 1, 'United Kingdom', 'VAT Rate GB'),
			(13, 1, 'Greece', 'VAT Rate GR'),
			(14, 1, 'Croatia', 'VAT Rate HR'),
			(15, 1, 'Hungary', 'VAT Rate HU'),
			(16, 1, 'Ireland', 'VAT Rate IE'),
			(17, 1, 'Italy', 'VAT Rate IT'),
			(18, 1, 'Latvia', 'VAT Rate LV'),
			(19, 1, 'Lithuania', 'VAT Rate LT'),
			(20, 1, 'Luxembourg', 'VAT Rate LU'),
			(21, 1, 'Malta', 'VAT Rate MT'),
			(22, 1, 'Netherlands', 'VAT Rate NL'),
			(23, 1, 'Poland', 'VAT Rate PL'),
			(24, 1, 'Portugal', 'VAT Rate PT'),
			(25, 1, 'Romania', 'VAT Rate RO'),
			(26, 1, 'Sweden', 'VAT Rate SE'),
			(27, 1, 'Slovenia', 'VAT Rate SI'),
			(28, 1, 'Slovakia', 'VAT Rate SK')
		");

		// Add eucountry to store data
		$this->db->query("INSERT INTO `" . DB_PREFIX . "eucountry_to_store` (`eucountry_id`, `store_id`) VALUES
			(1, '0'),
			(2, '0'),
			(3, '0'),
			(4, '0'),
			(5, '0'),
			(6, '0'),
			(7, '0'),
			(8, '0'),
			(9, '0'),
			(10, '0'),
			(11, '0'),
			(12, '0'),
			(13, '0'),
			(14, '0'),
			(15, '0'),
			(16, '0'),
			(17, '0'),
			(18, '0'),
			(19, '0'),
			(20, '0'),
			(21, '0'),
			(22, '0'),
			(23, '0'),
			(24, '0'),
			(25, '0'),
			(26, '0'),
			(27, '0'),
			(28, '0');
		");
	}

	public function uninstall() {
		$this->cache->delete('eucountry');

		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "eucountry`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "eucountry_description`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "eucountry_to_store`");
    }
}
?>