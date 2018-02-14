<?php
class ControllerLocalisationTaxLocalRate extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('localisation/tax_local_rate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/tax_local_rate');

		$this->getList();
	}

	public function insert() {
		$this->language->load('localisation/tax_local_rate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/tax_local_rate');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_tax_local_rate->addTaxLocalRate($this->request->post);

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
				$tax_local_rate_id = $this->session->data['new_tax_local_rate_id'];

				if ($tax_local_rate_id) {
					unset($this->session->data['new_tax_local_rate_id']);

					$this->redirect($this->url->link('localisation/tax_local_rate/update', 'token=' . $this->session->data['token'] . '&tax_local_rate_id=' . $tax_local_rate_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('localisation/tax_local_rate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/tax_local_rate');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_tax_local_rate->editTaxLocalRate($this->request->get['tax_local_rate_id'], $this->request->post);

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
				$tax_local_rate_id = $this->request->get['tax_local_rate_id'];

				if ($tax_local_rate_id) {
					$this->redirect($this->url->link('localisation/tax_local_rate/update', 'token=' . $this->session->data['token'] . '&tax_local_rate_id=' . $tax_local_rate_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('localisation/tax_local_rate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/tax_local_rate');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $tax_local_rate_id) {
				$this->model_localisation_tax_local_rate->deleteTaxLocalRate($tax_local_rate_id);
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

			$this->redirect($this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href'      => $this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('localisation/tax_local_rate/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localisation/tax_local_rate/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['tax_local_rates'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$tax_local_rate_total = $this->model_localisation_tax_local_rate->getTotalTaxLocalRates();

		$results = $this->model_localisation_tax_local_rate->getTaxLocalRates($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('localisation/tax_local_rate/update', 'token=' . $this->session->data['token'] . '&tax_local_rate_id=' . $result['tax_local_rate_id'] . $url, 'SSL')
			);

			$this->data['tax_local_rates'][] = array(
				'tax_local_rate_id' => $result['tax_local_rate_id'],
				'name'              => $result['name'],
				'rate'              => $result['rate'],
				'status'            => $result['status'],
				'selected'          => isset($this->request->post['selected']) && in_array($result['tax_local_rate_id'], $this->request->post['selected']),
				'action'            => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_info'] = $this->language->get('text_info');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_rate'] = $this->language->get('column_rate');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_info'] = $this->language->get('button_info');

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

		$this->data['sort_name'] = $this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_rate'] = $this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'] . '&sort=rate' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $tax_local_rate_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localisation/tax_local_rate_list.tpl';
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

		$this->data['entry_name'] = $this->language->get('entry_name');
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

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->error['rate'])) {
			$this->data['error_rate'] = $this->error['rate'];
		} else {
			$this->data['error_rate'] = '';
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
			'href'      => $this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['tax_local_rate_id'])) {
			$this->data['action'] = $this->url->link('localisation/tax_local_rate/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localisation/tax_local_rate/update', 'token=' . $this->session->data['token'] . '&tax_local_rate_id=' . $this->request->get['tax_local_rate_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('localisation/tax_local_rate', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['tax_local_rate_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$tax_local_rate_info = $this->model_localisation_tax_local_rate->getTaxLocalRate($this->request->get['tax_local_rate_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($tax_local_rate_info)) {
			$this->data['name'] = $tax_local_rate_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['rate'])) {
			$this->data['rate'] = $this->request->post['rate'];
		} elseif (!empty($tax_local_rate_info)) {
			$this->data['rate'] = $tax_local_rate_info['rate'];
		} else {
			$this->data['rate'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($tax_local_rate_info)) {
			$this->data['status'] = $tax_local_rate_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		$this->template = 'localisation/tax_local_rate_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/tax_local_rate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->request->post['rate']) {
			$this->error['rate'] = $this->language->get('error_rate');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/tax_local_rate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('localisation/tax_local_rate');

		foreach ($this->request->post['selected'] as $tax_local_rate_id) {
			$tax_local_rate_total = $this->model_localisation_tax_local_rate->getTotalProductsByTaxLocalRateId($tax_local_rate_id);

			if ($tax_local_rate_total) {
				$this->error['warning'] = sprintf($this->language->get('error_tax_local_rate'), $tax_local_rate_total);
			}
		}

		return empty($this->error);
	}
}
