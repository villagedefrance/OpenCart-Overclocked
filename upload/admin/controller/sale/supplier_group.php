<?php
class ControllerSaleSupplierGroup extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('sale/supplier_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_group');

		$this->getList();
	}

	public function insert() {
		$this->language->load('sale/supplier_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_supplier_group->addSupplierGroup($this->request->post);

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
				$supplier_group_id = $this->session->data['new_supplier_group_id'];

				if ($supplier_group_id) {
					unset($this->session->data['new_supplier_group_id']);

					$this->redirect($this->url->link('sale/supplier_group/update', 'token=' . $this->session->data['token'] . '&supplier_group_id=' . $supplier_group_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('sale/supplier_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_supplier_group->editSupplierGroup($this->request->get['supplier_group_id'], $this->request->post);

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
				$supplier_group_id = $this->request->get['supplier_group_id'];

				if ($supplier_group_id) {
					$this->redirect($this->url->link('sale/supplier_group/update', 'token=' . $this->session->data['token'] . '&supplier_group_id=' . $supplier_group_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('sale/supplier_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_group');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $supplier_group_id) {
				$this->model_sale_supplier_group->deleteSupplierGroup($supplier_group_id);
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

			$this->redirect($this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'sgd.name';
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
			'href'      => $this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('sale/supplier_group/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/supplier_group/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['supplier_groups'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$supplier_group_total = $this->model_sale_supplier_group->getTotalSupplierGroups();

		$results = $this->model_sale_supplier_group->getSupplierGroups($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/supplier_group/update', 'token=' . $this->session->data['token'] . '&supplier_group_id=' . $result['supplier_group_id'] . $url, 'SSL')
			);

			$this->data['supplier_groups'][] = array(
				'supplier_group_id' => $result['supplier_group_id'],
				'name'              => $result['name'] . (($result['supplier_group_id'] == $this->config->get('config_supplier_group_id')) ? $this->language->get('text_default') : null),
				'order_method'      => $this->language->get('text_order_' . $result['order_method']),
				'payment_method'    => $this->language->get('text_payment_' . $result['payment_method']),
				'sort_order'        => $result['sort_order'],
				'selected'          => isset($this->request->post['selected']) && in_array($result['supplier_group_id'], $this->request->post['selected']),
				'action'            => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_order_method'] = $this->language->get('column_order_method');
		$this->data['column_payment_method'] = $this->language->get('column_payment_method');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
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

		$this->data['sort_name'] = $this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . '&sort=sgd.name' . $url, 'SSL');
		$this->data['sort_order_method'] = $this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . '&sort=sg.order_method' . $url, 'SSL');
		$this->data['sort_payment_method'] = $this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . '&sort=sg.payment_method' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . '&sort=sg.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $supplier_group_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/supplier_group_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_order_method'] = $this->language->get('entry_order_method');
		$this->data['entry_payment_method'] = $this->language->get('entry_payment_method');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

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
			'href'      => $this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['supplier_group_id'])) {
			$this->data['action'] = $this->url->link('sale/supplier_group/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/supplier_group/update', 'token=' . $this->session->data['token'] . '&supplier_group_id=' . $this->request->get['supplier_group_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/supplier_group', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['supplier_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$supplier_group_info = $this->model_sale_supplier_group->getSupplierGroup($this->request->get['supplier_group_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['supplier_group_description'])) {
			$this->data['supplier_group_description'] = $this->request->post['supplier_group_description'];
		} elseif (isset($this->request->get['supplier_group_id'])) {
			$this->data['supplier_group_description'] = $this->model_sale_supplier_group->getSupplierGroupDescriptions($this->request->get['supplier_group_id']);
		} else {
			$this->data['supplier_group_description'] = array();
		}

		$this->data['order_options'] = array();

		$this->data['order_options'][] = array('method' => 'website', 'title' => $this->language->get('text_order_website'));
		$this->data['order_options'][] = array('method' => 'email', 'title' => $this->language->get('text_order_email'));
		$this->data['order_options'][] = array('method' => 'phone', 'title' => $this->language->get('text_order_phone'));
		$this->data['order_options'][] = array('method' => 'fax', 'title' => $this->language->get('text_order_fax'));
		$this->data['order_options'][] = array('method' => 'post', 'title' => $this->language->get('text_order_post'));
		$this->data['order_options'][] = array('method' => 'instore', 'title' => $this->language->get('text_order_instore'));
		$this->data['order_options'][] = array('method' => 'other', 'title' => $this->language->get('text_order_other'));

		if (isset($this->request->post['order_method'])) {
			$this->data['order_method'] = $this->request->post['order_method'];
		} elseif (!empty($supplier_group_info)) {
			$this->data['order_method'] = $supplier_group_info['order_method'];
		} else {
			$this->data['order_method'] = 0;
		}

		$this->data['payment_options'] = array();

		$this->data['payment_options'][] = array('method' => 'account', 'title' => $this->language->get('text_payment_account'));
		$this->data['payment_options'][] = array('method' => 'cash', 'title' => $this->language->get('text_payment_cash'));
		$this->data['payment_options'][] = array('method' => 'cheque', 'title' => $this->language->get('text_payment_cheque'));
		$this->data['payment_options'][] = array('method' => 'creditcard', 'title' => $this->language->get('text_payment_creditcard'));
		$this->data['payment_options'][] = array('method' => 'banktransfer', 'title' => $this->language->get('text_payment_banktransfer'));
		$this->data['payment_options'][] = array('method' => 'paypal', 'title' => $this->language->get('text_payment_paypal'));
		$this->data['payment_options'][] = array('method' => 'other', 'title' => $this->language->get('text_payment_other'));

		if (isset($this->request->post['payment_method'])) {
			$this->data['payment_method'] = $this->request->post['payment_method'];
		} elseif (!empty($supplier_group_info)) {
			$this->data['payment_method'] = $supplier_group_info['payment_method'];
		} else {
			$this->data['payment_method'] = 0;
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($supplier_group_info)) {
			$this->data['sort_order'] = $supplier_group_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}

		$this->template = 'sale/supplier_group_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/supplier_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['supplier_group_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 32)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/supplier_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('sale/supplier');

		foreach ($this->request->post['selected'] as $supplier_group_id) {
			if ($this->config->get('config_supplier_group_id') == $supplier_group_id) {
				$this->error['warning'] = $this->language->get('error_default');
			}

			$supplier_total = $this->model_sale_supplier->getTotalSuppliersBySupplierGroupId($supplier_group_id);

			if ($supplier_total) {
				$this->error['warning'] = sprintf($this->language->get('error_supplier'), $supplier_total);
			}
		}

		return empty($this->error);
	}
}
