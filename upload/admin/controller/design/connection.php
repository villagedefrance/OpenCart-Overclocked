<?php
class ControllerDesignConnection extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('design/connection');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/connection');

		$this->getList();
	}

	public function insert() {
		$this->language->load('design/connection');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/connection');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_connection->addConnection($this->request->post);

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
				$connection_id = $this->session->data['new_connection_id'];

				if ($connection_id) {
					unset($this->session->data['new_connection_id']);

					$this->redirect($this->url->link('design/connection/update', 'token=' . $this->session->data['token'] . '&connection_id=' . $connection_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/connection', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('design/connection');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/connection');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_connection->editConnection($this->request->get['connection_id'], $this->request->post);

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
				$connection_id = $this->request->get['connection_id'];

				if ($connection_id) {
					$this->redirect($this->url->link('design/connection/update', 'token=' . $this->session->data['token'] . '&connection_id=' . $connection_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/connection', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('design/connection');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/connection');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $connection_id) {
				$this->model_design_connection->deleteConnection($connection_id);
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

			$this->redirect($this->url->link('design/connection', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href'      => $this->url->link('design/connection', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['module_links'] = $this->url->link('module/links', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['insert'] = $this->url->link('design/connection/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('design/connection/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['connections'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$connection_total = $this->model_design_connection->getTotalConnections();

		$results = $this->model_design_connection->getConnections($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('design/connection/update', 'token=' . $this->session->data['token'] . '&connection_id=' . $result['connection_id'] . $url, 'SSL')
			);

			$this->data['connections'][] = array(
				'connection_id' => $result['connection_id'],
				'icon'          => $this->model_design_connection->getConnectionIcon($result['connection_id']),
				'name'          => $result['name'],
				'backend'       => $result['backend'],
				'frontend'      => $result['frontend'],
				'selected'      => isset($this->request->post['selected']) && in_array($result['connection_id'], $this->request->post['selected']),
				'action'        => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_backend'] = $this->language->get('column_backend');
		$this->data['column_frontend'] = $this->language->get('column_frontend');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_module'] = $this->language->get('button_module');
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

		$this->data['sort_name'] = $this->url->link('design/connection', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_backend'] = $this->url->link('design/connection', 'token=' . $this->session->data['token'] . '&sort=backend' . $url, 'SSL');
		$this->data['sort_frontend'] = $this->url->link('design/connection', 'token=' . $this->session->data['token'] . '&sort=frontend' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $connection_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('design/connection', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'design/connection_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_backend'] = $this->language->get('entry_backend');
		$this->data['entry_frontend'] = $this->language->get('entry_frontend');
		$this->data['entry_icon'] = $this->language->get('entry_icon');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_route'] = $this->language->get('entry_route');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_route'] = $this->language->get('button_add_route');
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
			'href'      => $this->url->link('design/connection', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['connection_id'])) {
			$this->data['action'] = $this->url->link('design/connection/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('design/connection/update', 'token=' . $this->session->data['token'] . '&connection_id=' . $this->request->get['connection_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('design/connection', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['connection_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$connection_info = $this->model_design_connection->getConnection($this->request->get['connection_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($connection_info)) {
			$this->data['name'] = $connection_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['backend'])) {
			$this->data['backend'] = $this->request->post['backend'];
		} elseif (!empty($connection_info)) {
			$this->data['backend'] = $connection_info['backend'];
		} else {
			$this->data['backend'] = '';
		}

		if (isset($this->request->post['frontend'])) {
			$this->data['frontend'] = $this->request->post['frontend'];
		} elseif (!empty($connection_info)) {
			$this->data['frontend'] = $connection_info['frontend'];
		} else {
			$this->data['frontend'] = '';
		}

		$this->load->model('tool/font_awesome');

		$this->data['fonts'] = $this->model_tool_font_awesome->getFonts();

		if (isset($this->request->post['connection_route'])) {
			$connection_routes = $this->request->post['connection_route'];
		} elseif (isset($this->request->get['connection_id'])) {
			$connection_routes = $this->model_design_connection->getConnectionRoutes($this->request->get['connection_id']);
		} else {
			$connection_routes = array();
		}

		$this->data['connection_routes'] = array();

		foreach ($connection_routes as $connection_route) {
			$this->data['connection_routes'][] = array(
				'route_id' => $connection_route['connection_route_id'],
				'icon'     => $connection_route['icon'],
				'title'    => $connection_route['title'],
				'route'    => $connection_route['route']
			);
		}

		$this->template = 'design/connection_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/connection')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/connection')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
