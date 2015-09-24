<?php
class ControllerLocalisationAgeZone extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('localisation/age_zone');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/age_zone');

		$this->getList();
	}

	public function insert() {
		$this->language->load('localisation/age_zone');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/age_zone');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_age_zone->addAgeZone($this->request->post);

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
				$age_zone_id = $this->session->data['new_age_zone_id'];

				if ($age_zone_id) {
					unset($this->session->data['new_age_zone_id']);

					$this->redirect($this->url->link('localisation/age_zone/update', 'token=' . $this->session->data['token'] . '&age_zone_id=' . $age_zone_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('localisation/age_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('localisation/age_zone');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/age_zone');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_age_zone->editAgeZone($this->request->get['age_zone_id'], $this->request->post);

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
				$age_zone_id = $this->request->get['age_zone_id'];

				if ($age_zone_id) {
					$this->redirect($this->url->link('localisation/age_zone/update', 'token=' . $this->session->data['token'] . '&age_zone_id=' . $age_zone_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('localisation/age_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('localisation/age_zone');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/age_zone');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $age_zone_id) {
				$this->model_localisation_age_zone->deleteAgeZone($age_zone_id);
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

			$this->redirect($this->url->link('localisation/age_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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
			'text' 	=> $this->language->get('text_home'),
			'href'   	=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text' 	=> $this->language->get('heading_title'),
			'href'   	=> $this->url->link('localisation/age_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('localisation/age_zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localisation/age_zone/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['age_zones'] = array();

		$data = array(
			'sort'  	=> $sort,
			'order' 	=> $order,
			'start' 	=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' 		=> $this->config->get('config_admin_limit')
		);

		$age_zone_total = $this->model_localisation_age_zone->getTotalAgeZones();

		$results = $this->model_localisation_age_zone->getAgeZones($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('localisation/age_zone/update', 'token=' . $this->session->data['token'] . '&age_zone_id=' . $result['age_zone_id'] . $url, 'SSL')
			);

			$this->data['age_zones'][] = array(
				'age_zone_id' 	=> $result['age_zone_id'],
				'name'        	=> $result['name'],
				'age' 				=> $result['age'],
				'selected'    	=> isset($this->request->post['selected']) && in_array($result['age_zone_id'], $this->request->post['selected']),
				'action'      		=> $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_age'] = $this->language->get('column_age');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');

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

		$this->data['sort_name'] = $this->url->link('localisation/age_zone', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_age'] = $this->url->link('localisation/age_zone', 'token=' . $this->session->data['token'] . '&sort=age' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $age_zone_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('localisation/age_zone', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localisation/age_zone_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_age'] = $this->language->get('entry_age');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_zone'] = $this->language->get('entry_zone');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_age_zone'] = $this->language->get('button_add_age_zone');
		$this->data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->error['age'])) {
			$this->data['error_age'] = $this->error['age'];
		} else {
			$this->data['error_age'] = '';
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
			'text' 	=> $this->language->get('text_home'),
			'href'   	=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text' 	=> $this->language->get('heading_title'),
			'href'  	=> $this->url->link('localisation/age_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['age_zone_id'])) {
			$this->data['action'] = $this->url->link('localisation/age_zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localisation/age_zone/update', 'token=' . $this->session->data['token'] . '&age_zone_id=' . $this->request->get['age_zone_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('localisation/age_zone', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['age_zone_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$age_zone_info = $this->model_localisation_age_zone->getAgeZone($this->request->get['age_zone_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($age_zone_info)) {
			$this->data['name'] = $age_zone_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['age'])) {
			$this->data['age'] = $this->request->post['age'];
		} elseif (!empty($age_zone_info)) {
			$this->data['age'] = $age_zone_info['age'];
		} else {
			$this->data['age'] = '';
		}

		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['zone_to_age_zone'])) {
			$this->data['zone_to_age_zones'] = $this->request->post['zone_to_age_zone'];
		} elseif (isset($this->request->get['age_zone_id'])) {
			$this->data['zone_to_age_zones'] = $this->model_localisation_age_zone->getZoneToAgeZones($this->request->get['age_zone_id']);
		} else {
			$this->data['zone_to_age_zones'] = array();
		}

		$this->template = 'localisation/age_zone_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/age_zone')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (empty($this->request->post['age']) || is_int($this->request->post['age']) || ($this->request->post['age'] < 3) || ($this->request->post['age'] > 99)) {
			$this->error['age'] = $this->language->get('error_age');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/age_zone')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function zone() {
		$output = '<option value="0">' . $this->language->get('text_all_zones') . '</option>';

		$this->load->model('localisation/zone');

		$results = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);

		foreach ($results as $result) {
			$output .= '<option value="' . $result['zone_id'] . '"';

			if ($this->request->get['zone_id'] == $result['zone_id']) {
				$output .= ' selected="selected"';
			}

			$output .= '>' . $result['name'] . '</option>';
		}

		$this->response->setOutput($output);
	}
}
?>