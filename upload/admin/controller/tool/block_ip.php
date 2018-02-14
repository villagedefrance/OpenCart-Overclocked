<?php
class ControllerToolBlockIp extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('tool/block_ip');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/block_ip');

		$this->getList();
	}

	public function insert() {
		$this->language->load('tool/block_ip');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/block_ip');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_tool_block_ip->addBlockIp($this->request->post);

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
				$block_ip_id = $this->session->data['new_block_ip_id'];

				if ($block_ip_id) {
					unset($this->session->data['new_block_ip_id']);

					$this->redirect($this->url->link('tool/block_ip/update', 'token=' . $this->session->data['token'] . '&block_ip_id=' . $block_ip_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('tool/block_ip', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('tool/block_ip');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/block_ip');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_tool_block_ip->editBlockIp($this->request->get['block_ip_id'], $this->request->post);

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
				$block_ip_id = $this->request->get['block_ip_id'];

				if ($block_ip_id) {
					$this->redirect($this->url->link('tool/block_ip/update', 'token=' . $this->session->data['token'] . '&block_ip_id=' . $block_ip_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('tool/block_ip', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('tool/block_ip');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/block_ip');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $block_ip_id) {
				$this->model_tool_block_ip->deleteBlockIp($block_ip_id);
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

			$this->redirect($this->url->link('tool/block_ip', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'from_ip';
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
			'href'      => $this->url->link('tool/block_ip', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('tool/block_ip/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('tool/block_ip/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['block_ips'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$block_ip_total = $this->model_tool_block_ip->getTotalBlockIps($data);

		$results = $this->model_tool_block_ip->getBlockIps($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('tool/block_ip/update', 'token=' . $this->session->data['token'] . '&block_ip_id=' . $result['block_ip_id'] . $url, 'SSL')
			);

      		$this->data['block_ips'][] = array(
				'block_ip_id' => $result['block_ip_id'],
				'from_ip'     => $result['from_ip'],
				'to_ip'       => $result['to_ip'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['block_ip_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_info'] = $this->language->get('text_info');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_from_ip'] = $this->language->get('column_from_ip');
		$this->data['column_to_ip'] = $this->language->get('column_to_ip');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_info'] = $this->language->get('button_info');

		$this->data['token'] = $this->session->data['token'];

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

		$this->data['sort_from_ip'] = $this->url->link('tool/block_ip', 'token=' . $this->session->data['token'] . '&sort=from_ip' . $url, 'SSL');
		$this->data['sort_to_ip'] = $this->url->link('tool/block_ip', 'token=' . $this->session->data['token'] . '&sort=to_ip' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $block_ip_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('tool/block_ip', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'tool/block_ip_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_range'] = $this->language->get('heading_range');

		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_range'] = $this->language->get('text_range');

		$this->data['entry_from_ip'] = $this->language->get('entry_from_ip');
		$this->data['entry_to_ip'] = $this->language->get('entry_to_ip');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_info'] = $this->language->get('button_info');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['from_ip'])) {
			$this->data['error_from_ip'] = $this->error['from_ip'];
		} else {
			$this->data['error_from_ip'] = '';
		}

		if (isset($this->error['to_ip'])) {
			$this->data['error_to_ip'] = $this->error['to_ip'];
		} else {
			$this->data['error_to_ip'] = '';
		}

		if (isset($this->error['range'])) {
			$this->data['error_range'] = $this->error['range'];
		} else {
			$this->data['error_range'] = '';
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
			'href'      => $this->url->link('tool/block_ip', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['block_ip_id'])) {
			$this->data['action'] = $this->url->link('tool/block_ip/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('tool/block_ip/update', 'token=' . $this->session->data['token'] . '&block_ip_id=' . $this->request->get['block_ip_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('tool/block_ip', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['block_ip_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$block_ip_info = $this->model_tool_block_ip->getBlockIp($this->request->get['block_ip_id']);
		}

		if (isset($this->request->post['from_ip'])) {
			$this->data['from_ip'] = $this->request->post['from_ip'];
		} elseif (isset($block_ip_info)) {
			$this->data['from_ip'] = $block_ip_info['from_ip'];
		} else {
			$this->data['from_ip'] = '';
		}

		if (isset($this->request->post['to_ip'])) {
			$this->data['to_ip'] = $this->request->post['to_ip'];
		} elseif (isset($block_ip_info)) {
			$this->data['to_ip'] = $block_ip_info['to_ip'];
		} else {
			$this->data['to_ip'] = '';
		}

		$this->template = 'tool/block_ip_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'tool/block_ip')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['from_ip'] || strlen($this->request->post['from_ip']) < 7 || !preg_match('/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/ ', $this->request->post['from_ip'])) {
			$this->error['from_ip'] = $this->language->get('error_from_ip');
		}

		if (!$this->request->post['to_ip'] || strlen($this->request->post['to_ip']) < 7 || !preg_match('/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/ ', $this->request->post['to_ip'])) {
			$this->error['to_ip'] = $this->language->get('error_to_ip');
		}

		if (isset($this->request->post['from_ip']) && isset($this->request->post['to_ip']) && (strlen($this->request->post['from_ip']) > strlen($this->request->post['to_ip']))) {
			$this->error['range'] = $this->language->get('error_range');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'tool/block_ip')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
