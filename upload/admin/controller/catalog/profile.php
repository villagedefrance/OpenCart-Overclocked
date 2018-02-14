<?php
class ControllerCatalogProfile extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('catalog/profile');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/profile');

		$this->getList();
	}

	public function insert() {
		$this->language->load('catalog/profile');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/profile');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_profile->addProfile($this->request->post);

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
				$profile_id = $this->session->data['new_profile_id'];

				if ($profile_id) {
					unset($this->session->data['new_profile_id']);

					$this->redirect($this->url->link('catalog/profile/update', 'token=' . $this->session->data['token'] . '&profile_id=' . $profile_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('catalog/profile', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('catalog/profile');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/profile');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_profile->updateProfile($this->request->get['profile_id'], $this->request->post);

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
				$profile_id = $this->request->get['profile_id'];

				if ($profile_id) {
					$this->redirect($this->url->link('catalog/profile/update', 'token=' . $this->session->data['token'] . '&profile_id=' . $profile_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('catalog/profile', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('catalog/profile');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/profile');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $profile_id) {
				$this->model_catalog_profile->deleteProfile($profile_id);
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

			$this->redirect($this->url->link('catalog/profile', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pf.sort_order';
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
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/profile', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('catalog/profile/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/profile/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['profiles'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$profile_total = $this->model_catalog_profile->getTotalProfiles();

		$results = $this->model_catalog_profile->getProfiles($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'name' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/profile/update', 'token=' . $this->session->data['token'] . '&profile_id=' . $result['profile_id'], 'SSL')
			);

			$this->data['profiles'][] = array(
				'profile_id' => $result['profile_id'],
				'name'       => $result['name'],
				'sort_order' => $result['sort_order'],
				'status'     => $result['status'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['profile_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_status'] = $this->language->get('column_status');
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

		$this->data['sort_name'] = $this->url->link('catalog/profile', 'token=' . $this->session->data['token'] . '&sort=pfd.name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/profile', 'token=' . $this->session->data['token'] . '&sort=pf.sort_order' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/profile', 'token=' . $this->session->data['token'] . '&sort=pf.status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $profile_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/profile', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/profile_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_recurring_help'] = $this->language->get('text_recurring_help');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_duration'] = $this->language->get('entry_duration');
		$this->data['entry_cycle'] = $this->language->get('entry_cycle');
		$this->data['entry_frequency'] = $this->language->get('entry_frequency');
		$this->data['entry_trial_status'] = $this->language->get('entry_trial_status');
		$this->data['entry_trial_price'] = $this->language->get('entry_trial_price');
		$this->data['entry_trial_duration'] = $this->language->get('entry_trial_duration');
		$this->data['entry_trial_cycle'] = $this->language->get('entry_trial_cycle');
		$this->data['entry_trial_frequency'] = $this->language->get('entry_trial_frequency');

		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_info'] = $this->language->get('button_info');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
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
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/profile', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->data['token'] = $this->session->data['token'];

		if (!isset($this->request->get['profile_id'])) {
			$this->data['action'] = $this->url->link('catalog/profile/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/profile/update', 'token=' . $this->session->data['token'] . '&profile_id=' . $this->request->get['profile_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/profile', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['profile_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$profile_info = $this->model_catalog_profile->getProfile($this->request->get['profile_id']);
		}

		$this->data['frequencies'] = $this->model_catalog_profile->getFrequencies();

		if (isset($this->request->post['profile_description'])) {
			$this->data['profile_description'] = $this->request->post['profile_description'];
		} elseif (isset($this->request->get['profile_id'])) {
			$this->data['profile_description'] = $this->model_catalog_profile->getProfileDescription($this->request->get['profile_id']);
		} else {
			$this->data['profile_description'] = array();
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($profile_info)) {
			$this->data['sort_order'] = $profile_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($profile_info)) {
			$this->data['status'] = $profile_info['status'];
		} else {
			$this->data['status'] = 0;
		}

		if (isset($this->request->post['price'])) {
			$this->data['price'] = $this->request->post['price'];
		} elseif (!empty($profile_info)) {
			$this->data['price'] = $profile_info['price'];
		} else {
			$this->data['price'] = 0;
		}

		if (isset($this->request->post['frequency'])) {
			$this->data['frequency'] = $this->request->post['frequency'];
		} elseif (!empty($profile_info)) {
			$this->data['frequency'] = $profile_info['frequency'];
		} else {
			$this->data['frequency'] = '';
		}

		if (isset($this->request->post['duration'])) {
			$this->data['duration'] = $this->request->post['duration'];
		} elseif (!empty($profile_info)) {
			$this->data['duration'] = $profile_info['duration'];
		} else {
			$this->data['duration'] = 0;
		}

		if (isset($this->request->post['cycle'])) {
			$this->data['cycle'] = $this->request->post['cycle'];
		} elseif (!empty($profile_info)) {
			$this->data['cycle'] = $profile_info['cycle'];
		} else {
			$this->data['cycle'] = 1;
		}

		if (isset($this->request->post['trial_status'])) {
			$this->data['trial_status'] = $this->request->post['trial_status'];
		} elseif (!empty($profile_info)) {
			$this->data['trial_status'] = $profile_info['trial_status'];
		} else {
			$this->data['trial_status'] = 0;
		}

		if (isset($this->request->post['trial_price'])) {
			$this->data['trial_price'] = $this->request->post['trial_price'];
		} elseif (!empty($profile_info)) {
			$this->data['trial_price'] = $profile_info['trial_price'];
		} else {
			$this->data['trial_price'] = 0.00;
		}

		if (isset($this->request->post['trial_frequency'])) {
			$this->data['trial_frequency'] = $this->request->post['trial_frequency'];
		} elseif (!empty($profile_info)) {
			$this->data['trial_frequency'] = $profile_info['trial_frequency'];
		} else {
			$this->data['trial_frequency'] = '';
		}

		if (isset($this->request->post['trial_duration'])) {
			$this->data['trial_duration'] = $this->request->post['trial_duration'];
		} elseif (!empty($profile_info)) {
			$this->data['trial_duration'] = $profile_info['trial_duration'];
		} else {
			$this->data['trial_duration'] = '0';
		}

		if (isset($this->request->post['trial_cycle'])) {
			$this->data['trial_cycle'] = $this->request->post['trial_cycle'];
		} elseif (!empty($profile_info)) {
			$this->data['trial_cycle'] = $profile_info['trial_cycle'];
		} else {
			$this->data['trial_cycle'] = '1';
		}

		$this->template = 'catalog/profile_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/profile')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['profile_description'] as $language_id => $profile_description) {
			if ((utf8_strlen($profile_description['name']) < 3) || (utf8_strlen($profile_description['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/profile')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
