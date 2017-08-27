<?php
class ControllerDesignAdministration extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('design/administration');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/administration');

		$this->model_design_administration->checkAdministrations();

		$this->getList();
	}

	public function insert() {
		$this->language->load('design/administration');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/administration');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_administration->addAdministration($this->request->post);

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
				$administration_id = $this->session->data['new_administration_id'];

				if ($administration_id) {
					unset($this->session->data['new_administration_id']);

					$this->redirect($this->url->link('design/administration/update', 'token=' . $this->session->data['token'] . '&administration_id=' . $administration_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/administration', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('design/administration');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/administration');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_administration->editAdministration($this->request->get['administration_id'], $this->request->post);

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
				$administration_id = $this->request->get['administration_id'];

				if ($administration_id) {
					$this->redirect($this->url->link('design/administration/update', 'token=' . $this->session->data['token'] . '&administration_id=' . $administration_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/administration', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('design/administration');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/administration');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $administration_id) {
				$this->model_design_administration->deleteAdministration($administration_id);
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

			$this->redirect($this->url->link('design/administration', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/administration', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['settings'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['insert'] = $this->url->link('design/administration/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['delete'] = $this->url->link('design/administration/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['administrations'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$administration_total = $this->model_design_administration->getTotalAdministrations();

		$results = $this->model_design_administration->getAdministrations($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('design/administration/update', 'token=' . $this->session->data['token'] . '&administration_id=' . $result['administration_id'] . $url, 'SSL')
			);

			$this->data['administrations'][] = array(
				'administration_id' => $result['administration_id'],
				'name'              => $result['name'],
				'status'            => $this->checkStylesheet($result['name']),
				'date_added'        => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified'     => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'selected'          => isset($this->request->post['selected']) && in_array($result['administration_id'], $this->request->post['selected']),
				'action'            => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_present'] = $this->language->get('text_present');
		$this->data['text_missing'] = $this->language->get('text_missing');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_date_modified'] = $this->language->get('column_date_modified');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_settings'] = $this->language->get('button_settings');
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

		$this->data['sort_name'] = $this->url->link('design/administration', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $administration_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('design/administration', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'design/administration_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_administration'] = $this->language->get('text_administration');
		$this->data['text_light'] = $this->language->get('text_light');
		$this->data['text_dark'] = $this->language->get('text_dark');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_contrast'] = $this->language->get('entry_contrast');

		$this->data['help_contrast'] = $this->language->get('help_contrast');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

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
			'href'      => $this->url->link('design/administration', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['administration_id'])) {
			$this->data['action'] = $this->url->link('design/administration/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('design/administration/update', 'token=' . $this->session->data['token'] . '&administration_id=' . $this->request->get['administration_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('design/administration', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['administration_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$administration_info = $this->model_design_administration->getAdministration($this->request->get['administration_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($administration_info)) {
			$this->data['name'] = $administration_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['contrast'])) {
			$this->data['contrast'] = $this->request->post['contrast'];
		} elseif (!empty($administration_info)) {
			$this->data['contrast'] = $administration_info['contrast'];
		} else {
			$this->data['contrast'] = 'light';
		}

		$this->template = 'design/administration_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/administration')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/administration')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/store');

		foreach ($this->request->post['selected'] as $administration_id) {
			$administration_info = $this->model_design_administration->getAdministration($administration_id);

			if ($administration_info) {
				if ($this->config->get('config_admin_stylesheet') == $administration_info['name']) {
					$this->error['warning'] = $this->language->get('error_default');
				}

				$store_total = $this->model_setting_store->getTotalStoresByStylesheet($administration_info['name']);

				if ($store_total) {
					$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
				}
			}
		}

		return empty($this->error);
	}

	protected function checkStylesheet($name) {
		$check = false;

		if (file_exists('view/stylesheet/stylesheet_' . trim($name) . '.css')) {
			$check = true;
		}

		clearstatcache();

		return $check;
	}
}
