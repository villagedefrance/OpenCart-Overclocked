<?php
class ControllerSaleOrder extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getList();
	}

	public function insert() {
		$this->language->load('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_order->addOrder($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}

			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function recover() {
		$this->language->load('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_order->addOrder($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}

			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getFormRecover();
	}

	public function update() {
		$this->language->load('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_order->editOrder($this->request->get['order_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}

			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		if (isset($this->request->post['selected']) && ($this->validateDelete())) {
			foreach ($this->request->post['selected'] as $order_id) {
				$this->model_sale_order->deleteOrder($order_id);
				$this->openbay->deleteOrder($order_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}

			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}

		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

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
			'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('sale/order/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('sale/order/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['orders'] = array();

		$data = array(
			'filter_order_id'        => $filter_order_id,
			'filter_customer'        => $filter_customer,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_date_added'      => $filter_date_added,
			'filter_date_modified'   => $filter_date_modified,
			'filter_total'           => $filter_total,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$order_total = $this->model_sale_order->getTotalOrders($data);

		$results = $this->model_sale_order->getOrders($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);

			if (strtotime($result['date_added']) > strtotime('-' . (int)$this->config->get('config_order_edit') . ' day')) {
				$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('sale/order/update', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
				);
			}

			$this->data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'status'        => $result['status'],
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'selected'      => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
				'action'        => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_missing'] = $this->language->get('text_missing');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_date_modified'] = $this->language->get('column_date_modified');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

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

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$this->data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$this->data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');
		$this->data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_order_id'] = $filter_order_id;
		$this->data['filter_customer'] = $filter_customer;
		$this->data['filter_order_status_id'] = $filter_order_status_id;
		$this->data['filter_date_added'] = $filter_date_added;
		$this->data['filter_date_modified'] = $filter_date_modified;
		$this->data['filter_total'] = $filter_total;

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/order_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function getForm() {
		$this->load->model('sale/customer');

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_order'] = $this->language->get('text_order');

		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_customer'] = $this->language->get('entry_customer');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_comment'] = $this->language->get('entry_comment');
		$this->data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');
		$this->data['entry_address_2'] = $this->language->get('entry_address_2');
		$this->data['entry_city'] = $this->language->get('entry_city');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_zone_code'] = $this->language->get('entry_zone_code');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_to_name'] = $this->language->get('entry_to_name');
		$this->data['entry_to_email'] = $this->language->get('entry_to_email');
		$this->data['entry_from_name'] = $this->language->get('entry_from_name');
		$this->data['entry_from_email'] = $this->language->get('entry_from_email');
		$this->data['entry_theme'] = $this->language->get('entry_theme');
		$this->data['entry_message'] = $this->language->get('entry_message');
		$this->data['entry_amount'] = $this->language->get('entry_amount');
		$this->data['entry_shipping'] = $this->language->get('entry_shipping');
		$this->data['entry_payment'] = $this->language->get('entry_payment');
		$this->data['entry_voucher'] = $this->language->get('entry_voucher');
		$this->data['entry_coupon'] = $this->language->get('entry_coupon');
		$this->data['entry_reward'] = $this->language->get('entry_reward');

		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_product'] = $this->language->get('button_add_product');
		$this->data['button_add_voucher'] = $this->language->get('button_add_voucher');
		$this->data['button_update_total'] = $this->language->get('button_update_total');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_upload'] = $this->language->get('button_upload');

		$this->data['tab_order'] = $this->language->get('tab_order');
		$this->data['tab_customer'] = $this->language->get('tab_customer');
		$this->data['tab_payment'] = $this->language->get('tab_payment');
		$this->data['tab_shipping'] = $this->language->get('tab_shipping');
		$this->data['tab_product'] = $this->language->get('tab_product');
		$this->data['tab_voucher'] = $this->language->get('tab_voucher');
		$this->data['tab_total'] = $this->language->get('tab_total');

		$this->data['help_autocomplete'] = $this->language->get('help_autocomplete');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}

		if (isset($this->error['payment_firstname'])) {
			$this->data['error_payment_firstname'] = $this->error['payment_firstname'];
		} else {
			$this->data['error_payment_firstname'] = '';
		}

		if (isset($this->error['payment_lastname'])) {
			$this->data['error_payment_lastname'] = $this->error['payment_lastname'];
		} else {
			$this->data['error_payment_lastname'] = '';
		}

		if (isset($this->error['payment_address_1'])) {
			$this->data['error_payment_address_1'] = $this->error['payment_address_1'];
		} else {
			$this->data['error_payment_address_1'] = '';
		}

		if (isset($this->error['payment_city'])) {
			$this->data['error_payment_city'] = $this->error['payment_city'];
		} else {
			$this->data['error_payment_city'] = '';
		}

		if (isset($this->error['payment_postcode'])) {
			$this->data['error_payment_postcode'] = $this->error['payment_postcode'];
		} else {
			$this->data['error_payment_postcode'] = '';
		}

		if (isset($this->error['payment_tax_id'])) {
			$this->data['error_payment_tax_id'] = $this->error['payment_tax_id'];
		} else {
			$this->data['error_payment_tax_id'] = '';
		}

		if (isset($this->error['payment_country'])) {
			$this->data['error_payment_country'] = $this->error['payment_country'];
		} else {
			$this->data['error_payment_country'] = '';
		}

		if (isset($this->error['payment_zone'])) {
			$this->data['error_payment_zone'] = $this->error['payment_zone'];
		} else {
			$this->data['error_payment_zone'] = '';
		}

		if (isset($this->error['payment_method'])) {
			$this->data['error_payment_method'] = $this->error['payment_method'];
		} else {
			$this->data['error_payment_method'] = '';
		}

		if (isset($this->error['shipping_firstname'])) {
			$this->data['error_shipping_firstname'] = $this->error['shipping_firstname'];
		} else {
			$this->data['error_shipping_firstname'] = '';
		}

		if (isset($this->error['shipping_lastname'])) {
			$this->data['error_shipping_lastname'] = $this->error['shipping_lastname'];
		} else {
			$this->data['error_shipping_lastname'] = '';
		}

		if (isset($this->error['shipping_address_1'])) {
			$this->data['error_shipping_address_1'] = $this->error['shipping_address_1'];
		} else {
			$this->data['error_shipping_address_1'] = '';
		}

		if (isset($this->error['shipping_city'])) {
			$this->data['error_shipping_city'] = $this->error['shipping_city'];
		} else {
			$this->data['error_shipping_city'] = '';
		}

		if (isset($this->error['shipping_postcode'])) {
			$this->data['error_shipping_postcode'] = $this->error['shipping_postcode'];
		} else {
			$this->data['error_shipping_postcode'] = '';
		}

		if (isset($this->error['shipping_country'])) {
			$this->data['error_shipping_country'] = $this->error['shipping_country'];
		} else {
			$this->data['error_shipping_country'] = '';
		}

		if (isset($this->error['shipping_zone'])) {
			$this->data['error_shipping_zone'] = $this->error['shipping_zone'];
		} else {
			$this->data['error_shipping_zone'] = '';
		}

		if (isset($this->error['shipping_method'])) {
			$this->data['error_shipping_method'] = $this->error['shipping_method'];
		} else {
			$this->data['error_shipping_method'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

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
			'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['order_id'])) {
			$this->data['action'] = $this->url->link('sale/order/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/order/update', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['order_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['order_id'])) {
			$this->data['order_id'] = $this->request->get['order_id'];
		} else {
			$this->data['order_id'] = 0;
		}

		if (!empty($order_info)) {
			$this->data['abandoned'] = $order_info['abandoned'];
		} else {
			$this->data['abandoned'] = 0;
		}

		if (isset($this->request->post['store_id'])) {
			$this->data['store_id'] = $this->request->post['store_id'];
		} elseif (!empty($order_info)) {
			$this->data['store_id'] = $order_info['store_id'];
		} else {
			$this->data['store_id'] = '';
		}

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$this->data['store_url'] = HTTPS_CATALOG;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$this->data['store_url'] = HTTPS_CATALOG;
		} else {
			$this->data['store_url'] = HTTP_CATALOG;
		}

		if (isset($this->request->post['customer'])) {
			$this->data['customer'] = $this->request->post['customer'];
		} elseif (!empty($order_info)) {
			$this->data['customer'] = $order_info['customer'];
		} else {
			$this->data['customer'] = '';
		}

		if (isset($this->request->post['customer_id'])) {
			$this->data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($order_info)) {
			$this->data['customer_id'] = $order_info['customer_id'];
		} else {
			$this->data['customer_id'] = '';
		}

		if (isset($this->request->post['customer_group_id'])) {
			$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} elseif (!empty($order_info)) {
			$this->data['customer_group_id'] = $order_info['customer_group_id'];
		} else {
			$this->data['customer_group_id'] = '';
		}

		$this->load->model('sale/customer_group');

		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($order_info)) {
			$this->data['firstname'] = $order_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($order_info)) {
			$this->data['lastname'] = $order_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (!empty($order_info)) {
			$this->data['email'] = $order_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($order_info)) {
			$this->data['telephone'] = $order_info['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif (!empty($order_info)) {
			$this->data['fax'] = $order_info['fax'];
		} else {
			$this->data['fax'] = '';
		}

		if (isset($this->request->post['affiliate_id'])) {
			$this->data['affiliate_id'] = $this->request->post['affiliate_id'];
		} elseif (!empty($order_info)) {
			$this->data['affiliate_id'] = $order_info['affiliate_id'];
		} else {
			$this->data['affiliate_id'] = '';
		}

		if (isset($this->request->post['affiliate'])) {
			$this->data['affiliate'] = $this->request->post['affiliate'];
		} elseif (!empty($order_info)) {
			$this->data['affiliate'] = ($order_info['affiliate_id'] ? $order_info['affiliate_firstname'] . ' ' . $order_info['affiliate_lastname'] : '');
		} else {
			$this->data['affiliate'] = '';
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['order_status_id'])) {
			$this->data['order_status_id'] = $this->request->post['order_status_id'];
		} elseif (!empty($order_info)) {
			$this->data['order_status_id'] = $order_info['order_status_id'];
		} else {
			$this->data['order_status_id'] = $this->config->get('config_order_status_id');
		}

		if (isset($this->request->post['comment'])) {
			$this->data['comment'] = $this->request->post['comment'];
		} elseif (!empty($order_info)) {
			$this->data['comment'] = $order_info['comment'];
		} else {
			$this->data['comment'] = '';
		}

		$this->load->model('sale/customer');

		if (isset($this->request->post['customer_id'])) {
			$this->data['addresses'] = $this->model_sale_customer->getAddresses($this->request->post['customer_id']);
		} elseif (!empty($order_info)) {
			$this->data['addresses'] = $this->model_sale_customer->getAddresses($order_info['customer_id']);
		} else {
			$this->data['addresses'] = array();
		}

		// Payment
		if (isset($this->request->post['payment_firstname'])) {
			$this->data['payment_firstname'] = $this->request->post['payment_firstname'];
		} elseif (!empty($order_info)) {
			$this->data['payment_firstname'] = $order_info['payment_firstname'];
		} else {
			$this->data['payment_firstname'] = '';
		}

		if (isset($this->request->post['payment_lastname'])) {
			$this->data['payment_lastname'] = $this->request->post['payment_lastname'];
		} elseif (!empty($order_info)) {
			$this->data['payment_lastname'] = $order_info['payment_lastname'];
		} else {
			$this->data['payment_lastname'] = '';
		}

		if (isset($this->request->post['payment_company'])) {
			$this->data['payment_company'] = $this->request->post['payment_company'];
		} elseif (!empty($order_info)) {
			$this->data['payment_company'] = $order_info['payment_company'];
		} else {
			$this->data['payment_company'] = '';
		}

		if (isset($this->request->post['payment_company_id'])) {
			$this->data['payment_company_id'] = $this->request->post['payment_company_id'];
		} elseif (!empty($order_info)) {
			$this->data['payment_company_id'] = $order_info['payment_company_id'];
		} else {
			$this->data['payment_company_id'] = '';
		}

		if (isset($this->request->post['payment_tax_id'])) {
			$this->data['payment_tax_id'] = $this->request->post['payment_tax_id'];
		} elseif (!empty($order_info)) {
			$this->data['payment_tax_id'] = $order_info['payment_tax_id'];
		} else {
			$this->data['payment_tax_id'] = '';
		}

		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['payment_address_1'])) {
			$this->data['payment_address_1'] = $this->request->post['payment_address_1'];
		} elseif (!empty($order_info)) {
			$this->data['payment_address_1'] = $order_info['payment_address_1'];
		} else {
			$this->data['payment_address_1'] = '';
		}

		if (isset($this->request->post['payment_address_2'])) {
			$this->data['payment_address_2'] = $this->request->post['payment_address_2'];
		} elseif (!empty($order_info)) {
			$this->data['payment_address_2'] = $order_info['payment_address_2'];
		} else {
			$this->data['payment_address_2'] = '';
		}

		if (isset($this->request->post['payment_city'])) {
			$this->data['payment_city'] = $this->request->post['payment_city'];
		} elseif (!empty($order_info)) {
			$this->data['payment_city'] = $order_info['payment_city'];
		} else {
			$this->data['payment_city'] = '';
		}

		if (isset($this->request->post['payment_postcode'])) {
			$this->data['payment_postcode'] = $this->request->post['payment_postcode'];
		} elseif (!empty($order_info)) {
			$this->data['payment_postcode'] = $order_info['payment_postcode'];
		} else {
			$this->data['payment_postcode'] = '';
		}

		if (isset($this->request->post['payment_country_id'])) {
			$this->data['payment_country_id'] = $this->request->post['payment_country_id'];
		} elseif (!empty($order_info)) {
			$this->data['payment_country_id'] = $order_info['payment_country_id'];
		} else {
			$this->data['payment_country_id'] = '';
		}

		if (isset($this->request->post['payment_zone_id'])) {
			$this->data['payment_zone_id'] = $this->request->post['payment_zone_id'];
		} elseif (!empty($order_info)) {
			$this->data['payment_zone_id'] = $order_info['payment_zone_id'];
		} else {
			$this->data['payment_zone_id'] = '';
		}

		if (isset($this->request->post['payment_method'])) {
			$this->data['payment_method'] = $this->request->post['payment_method'];
		} elseif (!empty($order_info)) {
			$this->data['payment_method'] = $order_info['payment_method'];
		} else {
			$this->data['payment_method'] = '';
		}

		if (isset($this->request->post['payment_code'])) {
			$this->data['payment_code'] = $this->request->post['payment_code'];
		} elseif (!empty($order_info)) {
			$this->data['payment_code'] = $order_info['payment_code'];
		} else {
			$this->data['payment_code'] = '';
		}

		// Shipping
		if (isset($this->request->post['shipping_firstname'])) {
			$this->data['shipping_firstname'] = $this->request->post['shipping_firstname'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_firstname'] = $order_info['shipping_firstname'];
		} else {
			$this->data['shipping_firstname'] = '';
		}

		if (isset($this->request->post['shipping_lastname'])) {
			$this->data['shipping_lastname'] = $this->request->post['shipping_lastname'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_lastname'] = $order_info['shipping_lastname'];
		} else {
			$this->data['shipping_lastname'] = '';
		}

		if (isset($this->request->post['shipping_company'])) {
			$this->data['shipping_company'] = $this->request->post['shipping_company'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_company'] = $order_info['shipping_company'];
		} else {
			$this->data['shipping_company'] = '';
		}

		if (isset($this->request->post['shipping_address_1'])) {
			$this->data['shipping_address_1'] = $this->request->post['shipping_address_1'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_address_1'] = $order_info['shipping_address_1'];
		} else {
			$this->data['shipping_address_1'] = '';
		}

		if (isset($this->request->post['shipping_address_2'])) {
			$this->data['shipping_address_2'] = $this->request->post['shipping_address_2'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_address_2'] = $order_info['shipping_address_2'];
		} else {
			$this->data['shipping_address_2'] = '';
		}

		if (isset($this->request->post['shipping_city'])) {
			$this->data['shipping_city'] = $this->request->post['shipping_city'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_city'] = $order_info['shipping_city'];
		} else {
			$this->data['shipping_city'] = '';
		}

		if (isset($this->request->post['shipping_postcode'])) {
			$this->data['shipping_postcode'] = $this->request->post['shipping_postcode'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_postcode'] = $order_info['shipping_postcode'];
		} else {
			$this->data['shipping_postcode'] = '';
		}

		if (isset($this->request->post['shipping_country_id'])) {
			$this->data['shipping_country_id'] = $this->request->post['shipping_country_id'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_country_id'] = $order_info['shipping_country_id'];
		} else {
			$this->data['shipping_country_id'] = '';
		}

		if (isset($this->request->post['shipping_zone_id'])) {
			$this->data['shipping_zone_id'] = $this->request->post['shipping_zone_id'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_zone_id'] = $order_info['shipping_zone_id'];
		} else {
			$this->data['shipping_zone_id'] = '';
		}

		if (isset($this->request->post['shipping_method'])) {
			$this->data['shipping_method'] = $this->request->post['shipping_method'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_method'] = $order_info['shipping_method'];
		} else {
			$this->data['shipping_method'] = '';
		}

		if (isset($this->request->post['shipping_code'])) {
			$this->data['shipping_code'] = $this->request->post['shipping_code'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_code'] = $order_info['shipping_code'];
		} else {
			$this->data['shipping_code'] = '';
		}

		if (isset($this->request->post['order_product'])) {
			$order_products = $this->request->post['order_product'];
		} elseif (isset($this->request->get['order_id'])) {
			$order_products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);
		} else {
			$order_products = array();
		}

		$this->load->model('catalog/product');

		$this->document->addScript('view/javascript/jquery/ajaxupload.min.js');

		$this->data['order_products'] = array();

		foreach ($order_products as $order_product) {
			if (isset($order_product['order_option'])) {
				$order_option = $order_product['order_option'];
			} elseif (isset($this->request->get['order_id'])) {
				$order_option = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $order_product['order_product_id']);
			} else {
				$order_option = array();
			}

			if (isset($order_product['order_download'])) {
				$order_download = $order_product['order_download'];
			} elseif (isset($this->request->get['order_id'])) {
				$order_download = $this->model_sale_order->getOrderDownloads($this->request->get['order_id'], $order_product['order_product_id']);
			} else {
				$order_download = array();
			}

			$this->data['order_products'][] = array(
				'order_product_id' => $order_product['order_product_id'],
				'product_id'       => $order_product['product_id'],
				'name'             => $order_product['name'],
				'model'            => $order_product['model'],
				'option'           => $order_option,
				'download'         => $order_download,
				'quantity'         => $order_product['quantity'],
				'price'            => $order_product['price'],
				'total'            => $order_product['total'],
				'tax'              => $order_product['tax'],
				'reward'           => $order_product['reward']
			);
		}

		if (isset($this->request->post['order_voucher'])) {
			$this->data['order_vouchers'] = $this->request->post['order_voucher'];
		} elseif (isset($this->request->get['order_id'])) {
			$this->data['order_vouchers'] = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);
		} else {
			$this->data['order_vouchers'] = array();
		}

		$this->load->model('sale/voucher_theme');

		$this->data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		if (isset($this->request->post['order_total'])) {
			$this->data['order_totals'] = $this->request->post['order_total'];
		} elseif (isset($this->request->get['order_id'])) {
			$this->data['order_totals'] = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);
		} else {
			$this->data['order_totals'] = array();
		}

		// Check current coupon, voucher, reward and credit
		$current_coupon = '';
		$current_voucher = '';
		$current_voucher_value = 0;
		$current_reward = '';
		$current_credit = '';

		foreach ($this->data['order_totals'] as $key => $value) {
			if ($value['code'] == 'coupon') {
				$start = strpos($value['title'], '(') + 1;
				$end = strrpos($value['title'], ')');

				if ($start && $end) {
					$current_coupon = substr($value['title'], $start, $end - $start);
				}

			} elseif ($value['code'] == 'voucher') {
				$start = strpos($value['title'], '(') + 1;
				$end = strrpos($value['title'], ')');

				if ($start && $end) {
					$current_voucher = substr($value['title'], $start, $end - $start);
					$current_voucher_value = abs($value['value']);
				}

			} elseif ($value['code'] == 'reward') {
				$start = strpos($value['title'], '(') + 1;
				$end = strrpos($value['title'], ')');

				if ($start && $end) {
					$current_reward = substr($value['title'], $start, $end - $start);
				}

			} elseif ($value['code'] == 'credit') {
				$current_credit = abs($value['value']);
			}
		}

		$this->data['current_voucher'] = $current_voucher;
		$this->data['current_voucher_value'] = $current_voucher_value;
		$this->data['current_reward'] = $current_reward;
		$this->data['current_credit'] = $current_credit;

		if (isset($this->request->post['coupon'])) {
			$this->data['coupon'] = $this->request->post['coupon'];
		} else {
			$this->data['coupon'] = $current_coupon;
		}

		if (isset($this->request->post['voucher'])) {
			$this->data['voucher'] = $this->request->post['voucher'];
		} else {
			$this->data['voucher'] = $current_voucher;
		}

		if (isset($this->request->post['reward'])) {
			$this->data['reward'] = $this->request->post['reward'];
		} else {
			$this->data['reward'] = $current_reward;
		}

		$this->template = 'sale/order_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function getFormRecover() {
		$this->load->model('sale/customer');

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_order'] = $this->language->get('text_order');

		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_customer'] = $this->language->get('entry_customer');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_comment'] = $this->language->get('entry_comment');
		$this->data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');
		$this->data['entry_address_2'] = $this->language->get('entry_address_2');
		$this->data['entry_city'] = $this->language->get('entry_city');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_zone_code'] = $this->language->get('entry_zone_code');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_to_name'] = $this->language->get('entry_to_name');
		$this->data['entry_to_email'] = $this->language->get('entry_to_email');
		$this->data['entry_from_name'] = $this->language->get('entry_from_name');
		$this->data['entry_from_email'] = $this->language->get('entry_from_email');
		$this->data['entry_theme'] = $this->language->get('entry_theme');
		$this->data['entry_message'] = $this->language->get('entry_message');
		$this->data['entry_amount'] = $this->language->get('entry_amount');
		$this->data['entry_shipping'] = $this->language->get('entry_shipping');
		$this->data['entry_payment'] = $this->language->get('entry_payment');
		$this->data['entry_voucher'] = $this->language->get('entry_voucher');
		$this->data['entry_coupon'] = $this->language->get('entry_coupon');
		$this->data['entry_reward'] = $this->language->get('entry_reward');

		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_product'] = $this->language->get('button_add_product');
		$this->data['button_add_voucher'] = $this->language->get('button_add_voucher');
		$this->data['button_update_total'] = $this->language->get('button_update_total');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_upload'] = $this->language->get('button_upload');

		$this->data['tab_order'] = $this->language->get('tab_order');
		$this->data['tab_customer'] = $this->language->get('tab_customer');
		$this->data['tab_payment'] = $this->language->get('tab_payment');
		$this->data['tab_shipping'] = $this->language->get('tab_shipping');
		$this->data['tab_product'] = $this->language->get('tab_product');
		$this->data['tab_voucher'] = $this->language->get('tab_voucher');
		$this->data['tab_total'] = $this->language->get('tab_total');

		$this->data['help_autocomplete'] = $this->language->get('help_autocomplete');
		$this->data['help_confirm_select'] = $this->language->get('help_confirm_select');
		$this->data['help_do_not_edit'] = $this->language->get('help_do_not_edit');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}

		if (isset($this->error['payment_firstname'])) {
			$this->data['error_payment_firstname'] = $this->error['payment_firstname'];
		} else {
			$this->data['error_payment_firstname'] = '';
		}

		if (isset($this->error['payment_lastname'])) {
			$this->data['error_payment_lastname'] = $this->error['payment_lastname'];
		} else {
			$this->data['error_payment_lastname'] = '';
		}

		if (isset($this->error['payment_address_1'])) {
			$this->data['error_payment_address_1'] = $this->error['payment_address_1'];
		} else {
			$this->data['error_payment_address_1'] = '';
		}

		if (isset($this->error['payment_city'])) {
			$this->data['error_payment_city'] = $this->error['payment_city'];
		} else {
			$this->data['error_payment_city'] = '';
		}

		if (isset($this->error['payment_postcode'])) {
			$this->data['error_payment_postcode'] = $this->error['payment_postcode'];
		} else {
			$this->data['error_payment_postcode'] = '';
		}

		if (isset($this->error['payment_tax_id'])) {
			$this->data['error_payment_tax_id'] = $this->error['payment_tax_id'];
		} else {
			$this->data['error_payment_tax_id'] = '';
		}

		if (isset($this->error['payment_country'])) {
			$this->data['error_payment_country'] = $this->error['payment_country'];
		} else {
			$this->data['error_payment_country'] = '';
		}

		if (isset($this->error['payment_zone'])) {
			$this->data['error_payment_zone'] = $this->error['payment_zone'];
		} else {
			$this->data['error_payment_zone'] = '';
		}

		if (isset($this->error['payment_method'])) {
			$this->data['error_payment_method'] = $this->error['payment_method'];
		} else {
			$this->data['error_payment_method'] = '';
		}

		if (isset($this->error['shipping_firstname'])) {
			$this->data['error_shipping_firstname'] = $this->error['shipping_firstname'];
		} else {
			$this->data['error_shipping_firstname'] = '';
		}

		if (isset($this->error['shipping_lastname'])) {
			$this->data['error_shipping_lastname'] = $this->error['shipping_lastname'];
		} else {
			$this->data['error_shipping_lastname'] = '';
		}

		if (isset($this->error['shipping_address_1'])) {
			$this->data['error_shipping_address_1'] = $this->error['shipping_address_1'];
		} else {
			$this->data['error_shipping_address_1'] = '';
		}

		if (isset($this->error['shipping_city'])) {
			$this->data['error_shipping_city'] = $this->error['shipping_city'];
		} else {
			$this->data['error_shipping_city'] = '';
		}

		if (isset($this->error['shipping_postcode'])) {
			$this->data['error_shipping_postcode'] = $this->error['shipping_postcode'];
		} else {
			$this->data['error_shipping_postcode'] = '';
		}

		if (isset($this->error['shipping_country'])) {
			$this->data['error_shipping_country'] = $this->error['shipping_country'];
		} else {
			$this->data['error_shipping_country'] = '';
		}

		if (isset($this->error['shipping_zone'])) {
			$this->data['error_shipping_zone'] = $this->error['shipping_zone'];
		} else {
			$this->data['error_shipping_zone'] = '';
		}

		if (isset($this->error['shipping_method'])) {
			$this->data['error_shipping_method'] = $this->error['shipping_method'];
		} else {
			$this->data['error_shipping_method'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

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
			'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['order_id'])) {
			$this->data['action'] = $this->url->link('sale/order/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/order/update', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['order_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['order_id'])) {
			$this->data['order_id'] = $this->request->get['order_id'];
		} else {
			$this->data['order_id'] = 0;
		}

		if (!empty($order_info)) {
			$this->data['abandoned'] = $order_info['abandoned'];
		} else {
			$this->data['abandoned'] = 0;
		}

		if (isset($this->request->post['store_id'])) {
			$this->data['store_id'] = $this->request->post['store_id'];
		} elseif (!empty($order_info)) {
			$this->data['store_id'] = $order_info['store_id'];
		} else {
			$this->data['store_id'] = '';
		}

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$this->data['store_url'] = HTTPS_CATALOG;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$this->data['store_url'] = HTTPS_CATALOG;
		} else {
			$this->data['store_url'] = HTTP_CATALOG;
		}

		if (isset($this->request->post['customer'])) {
			$this->data['customer'] = $this->request->post['customer'];
		} elseif (!empty($order_info)) {
			$this->data['customer'] = $order_info['customer'];
		} else {
			$this->data['customer'] = '';
		}

		if (isset($this->request->post['customer_id'])) {
			$this->data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($order_info)) {
			$this->data['customer_id'] = $order_info['customer_id'];
		} else {
			$this->data['customer_id'] = '';
		}

		if (isset($this->request->post['customer_group_id'])) {
			$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} elseif (!empty($order_info)) {
			$this->data['customer_group_id'] = $order_info['customer_group_id'];
		} else {
			$this->data['customer_group_id'] = '';
		}

		$this->load->model('sale/customer_group');

		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($order_info)) {
			$this->data['firstname'] = $order_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($order_info)) {
			$this->data['lastname'] = $order_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (!empty($order_info)) {
			$this->data['email'] = $order_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($order_info)) {
			$this->data['telephone'] = $order_info['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif (!empty($order_info)) {
			$this->data['fax'] = $order_info['fax'];
		} else {
			$this->data['fax'] = '';
		}

		if (isset($this->request->post['affiliate_id'])) {
			$this->data['affiliate_id'] = $this->request->post['affiliate_id'];
		} elseif (!empty($order_info)) {
			$this->data['affiliate_id'] = $order_info['affiliate_id'];
		} else {
			$this->data['affiliate_id'] = '';
		}

		if (isset($this->request->post['affiliate'])) {
			$this->data['affiliate'] = $this->request->post['affiliate'];
		} elseif (!empty($order_info)) {
			$this->data['affiliate'] = ($order_info['affiliate_id'] ? $order_info['affiliate_firstname'] . ' ' . $order_info['affiliate_lastname'] : '');
		} else {
			$this->data['affiliate'] = '';
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['order_status_id'])) {
			$this->data['order_status_id'] = $this->request->post['order_status_id'];
		} elseif (!empty($order_info)) {
			$this->data['order_status_id'] = $order_info['order_status_id'];
		} else {
			$this->data['order_status_id'] = $this->config->get('config_order_status_id');
		}

		if (isset($this->request->post['comment'])) {
			$this->data['comment'] = $this->request->post['comment'];
		} elseif (!empty($order_info)) {
			$this->data['comment'] = $order_info['comment'];
		} else {
			$this->data['comment'] = '';
		}

		$this->load->model('sale/customer');

		if (isset($this->request->post['customer_id'])) {
			$this->data['addresses'] = $this->model_sale_customer->getAddresses($this->request->post['customer_id']);
		} elseif (!empty($order_info)) {
			$this->data['addresses'] = $this->model_sale_customer->getAddresses($order_info['customer_id']);
		} else {
			$this->data['addresses'] = array();
		}

		// Payment
		if (isset($this->request->post['payment_firstname'])) {
			$this->data['payment_firstname'] = $this->request->post['payment_firstname'];
		} elseif (!empty($order_info)) {
			$this->data['payment_firstname'] = $order_info['payment_firstname'];
		} else {
			$this->data['payment_firstname'] = '';
		}

		if (isset($this->request->post['payment_lastname'])) {
			$this->data['payment_lastname'] = $this->request->post['payment_lastname'];
		} elseif (!empty($order_info)) {
			$this->data['payment_lastname'] = $order_info['payment_lastname'];
		} else {
			$this->data['payment_lastname'] = '';
		}

		if (isset($this->request->post['payment_company'])) {
			$this->data['payment_company'] = $this->request->post['payment_company'];
		} elseif (!empty($order_info)) {
			$this->data['payment_company'] = $order_info['payment_company'];
		} else {
			$this->data['payment_company'] = '';
		}

		if (isset($this->request->post['payment_company_id'])) {
			$this->data['payment_company_id'] = $this->request->post['payment_company_id'];
		} elseif (!empty($order_info)) {
			$this->data['payment_company_id'] = $order_info['payment_company_id'];
		} else {
			$this->data['payment_company_id'] = '';
		}

		if (isset($this->request->post['payment_tax_id'])) {
			$this->data['payment_tax_id'] = $this->request->post['payment_tax_id'];
		} elseif (!empty($order_info)) {
			$this->data['payment_tax_id'] = $order_info['payment_tax_id'];
		} else {
			$this->data['payment_tax_id'] = '';
		}

		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['payment_address_1'])) {
			$this->data['payment_address_1'] = $this->request->post['payment_address_1'];
		} elseif (!empty($order_info)) {
			$this->data['payment_address_1'] = $order_info['payment_address_1'];
		} else {
			$this->data['payment_address_1'] = '';
		}

		if (isset($this->request->post['payment_address_2'])) {
			$this->data['payment_address_2'] = $this->request->post['payment_address_2'];
		} elseif (!empty($order_info)) {
			$this->data['payment_address_2'] = $order_info['payment_address_2'];
		} else {
			$this->data['payment_address_2'] = '';
		}

		if (isset($this->request->post['payment_city'])) {
			$this->data['payment_city'] = $this->request->post['payment_city'];
		} elseif (!empty($order_info)) {
			$this->data['payment_city'] = $order_info['payment_city'];
		} else {
			$this->data['payment_city'] = '';
		}

		if (isset($this->request->post['payment_postcode'])) {
			$this->data['payment_postcode'] = $this->request->post['payment_postcode'];
		} elseif (!empty($order_info)) {
			$this->data['payment_postcode'] = $order_info['payment_postcode'];
		} else {
			$this->data['payment_postcode'] = '';
		}

		if (isset($this->request->post['payment_country_id'])) {
			$this->data['payment_country_id'] = $this->request->post['payment_country_id'];
		} elseif (!empty($order_info)) {
			$this->data['payment_country_id'] = $order_info['payment_country_id'];
		} else {
			$this->data['payment_country_id'] = '';
		}

		if (isset($this->request->post['payment_zone_id'])) {
			$this->data['payment_zone_id'] = $this->request->post['payment_zone_id'];
		} elseif (!empty($order_info)) {
			$this->data['payment_zone_id'] = $order_info['payment_zone_id'];
		} else {
			$this->data['payment_zone_id'] = '';
		}

		// Recover Payment Method
		if (isset($this->request->post['payment_method'])) {
			$this->data['payment_method'] = $this->request->post['payment_method'];
		} else {
			$this->data['payment_method'] = $order_info['payment_method'];
		}

		// Recover Payment Method
		if (isset($this->request->post['payment_code'])) {
			$this->data['payment_code'] = $this->request->post['payment_code'];
		} else {
			$this->data['payment_code'] = $order_info['payment_code'];
		}

		// Shipping
		if (isset($this->request->post['shipping_firstname'])) {
			$this->data['shipping_firstname'] = $this->request->post['shipping_firstname'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_firstname'] = $order_info['shipping_firstname'];
		} else {
			$this->data['shipping_firstname'] = '';
		}

		if (isset($this->request->post['shipping_lastname'])) {
			$this->data['shipping_lastname'] = $this->request->post['shipping_lastname'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_lastname'] = $order_info['shipping_lastname'];
		} else {
			$this->data['shipping_lastname'] = '';
		}

		if (isset($this->request->post['shipping_company'])) {
			$this->data['shipping_company'] = $this->request->post['shipping_company'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_company'] = $order_info['shipping_company'];
		} else {
			$this->data['shipping_company'] = '';
		}

		if (isset($this->request->post['shipping_address_1'])) {
			$this->data['shipping_address_1'] = $this->request->post['shipping_address_1'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_address_1'] = $order_info['shipping_address_1'];
		} else {
			$this->data['shipping_address_1'] = '';
		}

		if (isset($this->request->post['shipping_address_2'])) {
			$this->data['shipping_address_2'] = $this->request->post['shipping_address_2'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_address_2'] = $order_info['shipping_address_2'];
		} else {
			$this->data['shipping_address_2'] = '';
		}

		if (isset($this->request->post['shipping_city'])) {
			$this->data['shipping_city'] = $this->request->post['shipping_city'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_city'] = $order_info['shipping_city'];
		} else {
			$this->data['shipping_city'] = '';
		}

		if (isset($this->request->post['shipping_postcode'])) {
			$this->data['shipping_postcode'] = $this->request->post['shipping_postcode'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_postcode'] = $order_info['shipping_postcode'];
		} else {
			$this->data['shipping_postcode'] = '';
		}

		if (isset($this->request->post['shipping_country_id'])) {
			$this->data['shipping_country_id'] = $this->request->post['shipping_country_id'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_country_id'] = $order_info['shipping_country_id'];
		} else {
			$this->data['shipping_country_id'] = '';
		}

		if (isset($this->request->post['shipping_zone_id'])) {
			$this->data['shipping_zone_id'] = $this->request->post['shipping_zone_id'];
		} elseif (!empty($order_info)) {
			$this->data['shipping_zone_id'] = $order_info['shipping_zone_id'];
		} else {
			$this->data['shipping_zone_id'] = '';
		}

		// Recover Shipping Method
		if (isset($this->request->post['shipping_method'])) {
			$this->data['shipping_method'] = $this->request->post['shipping_method'];
		} else {
			$this->data['shipping_method'] = $order_info['shipping_method'];
		}

		// Recover Shipping Code
		if (isset($this->request->post['shipping_code'])) {
			$this->data['shipping_code'] = $this->request->post['shipping_code'];
		} else {
			$this->data['shipping_code'] = $order_info['shipping_code'];
		}

		if (isset($this->request->post['order_product'])) {
			$order_products = $this->request->post['order_product'];
		} elseif (isset($this->request->get['order_id'])) {
			$order_products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);
		} else {
			$order_products = array();
		}

		$this->load->model('catalog/product');

		$this->document->addScript('view/javascript/jquery/ajaxupload.min.js');

		$this->data['order_products'] = array();

		foreach ($order_products as $order_product) {
			if (isset($order_product['order_option'])) {
				$order_option = $order_product['order_option'];
			} elseif (isset($this->request->get['order_id'])) {
				$order_option = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $order_product['order_product_id']);
			} else {
				$order_option = array();
			}

			if (isset($order_product['order_download'])) {
				$order_download = $order_product['order_download'];
			} elseif (isset($this->request->get['order_id'])) {
				$order_download = $this->model_sale_order->getOrderDownloads($this->request->get['order_id'], $order_product['order_product_id']);
			} else {
				$order_download = array();
			}

			$this->data['order_products'][] = array(
				'order_product_id' => $order_product['order_product_id'],
				'product_id'       => $order_product['product_id'],
				'name'             => $order_product['name'],
				'model'            => $order_product['model'],
				'option'           => $order_option,
				'download'         => $order_download,
				'quantity'         => $order_product['quantity'],
				'price'            => $order_product['price'],
				'total'            => $order_product['total'],
				'tax'              => $order_product['tax'],
				'reward'           => $order_product['reward']
			);
		}

		if (isset($this->request->post['order_voucher'])) {
			$this->data['order_vouchers'] = $this->request->post['order_voucher'];
		} elseif (isset($this->request->get['order_id'])) {
			$this->data['order_vouchers'] = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);
		} else {
			$this->data['order_vouchers'] = array();
		}

		$this->load->model('sale/voucher_theme');

		$this->data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		if (isset($this->request->post['order_total'])) {
			$this->data['order_totals'] = $this->request->post['order_total'];
		} elseif (isset($this->request->get['order_id'])) {
			$this->data['order_totals'] = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);
		} else {
			$this->data['order_totals'] = array();
		}

		// Check current coupon, voucher, reward and credit
		$current_coupon = '';
		$current_voucher = '';
		$current_voucher_value = 0;
		$current_reward = '';
		$current_credit = '';

		foreach ($this->data['order_totals'] as $key => $value) {
			if ($value['code'] == 'coupon') {
				$start = strpos($value['title'], '(') + 1;
				$end = strrpos($value['title'], ')');

				if ($start && $end) {
					$current_coupon = substr($value['title'], $start, $end - $start);
				}

			} elseif ($value['code'] == 'voucher') {
				$start = strpos($value['title'], '(') + 1;
				$end = strrpos($value['title'], ')');

				if ($start && $end) {
					$current_voucher = substr($value['title'], $start, $end - $start);
					$current_voucher_value = abs($value['value']);
				}

			} elseif ($value['code'] == 'reward') {
				$start = strpos($value['title'], '(') + 1;
				$end = strrpos($value['title'], ')');

				if ($start && $end) {
					$current_reward = substr($value['title'], $start, $end - $start);
				}

			} elseif ($value['code'] == 'credit') {
				$current_credit = abs($value['value']);
			}
		}

		$this->data['current_voucher'] = $current_voucher;
		$this->data['current_voucher_value'] = $current_voucher_value;
		$this->data['current_reward'] = $current_reward;
		$this->data['current_credit'] = $current_credit;

		if (isset($this->request->post['coupon'])) {
			$this->data['coupon'] = $this->request->post['coupon'];
		} else {
			$this->data['coupon'] = $current_coupon;
		}

		if (isset($this->request->post['voucher'])) {
			$this->data['voucher'] = $this->request->post['voucher'];
		} else {
			$this->data['voucher'] = $current_voucher;
		}

		if (isset($this->request->post['reward'])) {
			$this->data['reward'] = $this->request->post['reward'];
		} else {
			$this->data['reward'] = $current_reward;
		}

		$this->template = 'sale/order_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || (!preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email']))) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if ((utf8_strlen($this->request->post['payment_firstname']) < 1) || (utf8_strlen($this->request->post['payment_firstname']) > 32)) {
			$this->error['payment_firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['payment_lastname']) < 1) || (utf8_strlen($this->request->post['payment_lastname']) > 32)) {
			$this->error['payment_lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['payment_address_1']) < 3) || (utf8_strlen($this->request->post['payment_address_1']) > 128)) {
			$this->error['payment_address_1'] = $this->language->get('error_address_1');
		}

		if ((utf8_strlen($this->request->post['payment_city']) < 3) || (utf8_strlen($this->request->post['payment_city']) > 128)) {
			$this->error['payment_city'] = $this->language->get('error_city');
		}

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->post['payment_country_id']);

		if ($country_info) {
			if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['payment_postcode']) < 2) || (utf8_strlen($this->request->post['payment_postcode']) > 10)) {
				$this->error['payment_postcode'] = $this->language->get('error_postcode');
			}

			// VAT Validation
			$this->load->model('sale/customer_group');

			$customer_group = $this->model_sale_customer_group->getCustomerGroup($this->request->post['customer_group_id']);

			if ($customer_group && $customer_group['tax_id_display']) {
				$this->load->helper('vat');

				if ($this->config->get('config_vat') && $this->request->post['payment_tax_id'] != '' && (vat_validation($country_info['iso_code_2'], $this->request->post['payment_tax_id']) == 'invalid')) {
					$this->error['payment_tax_id'] = $this->language->get('error_vat');
				}
			}
		}

		if (!isset($this->request->post['payment_country_id']) || $this->request->post['payment_country_id'] == '') {
			$this->error['payment_country'] = $this->language->get('error_country');
		}

		if (!isset($this->request->post['payment_zone_id']) || $this->request->post['payment_zone_id'] == '') {
			$this->error['payment_zone'] = $this->language->get('error_zone');
		}

		if (!isset($this->request->post['payment_method']) || $this->request->post['payment_method'] == '') {
			$this->error['payment_method'] = $this->language->get('error_payment');
		}

		// Check if any products require shipping
		$shipping = false;

		if (isset($this->request->post['order_product'])) {
			$this->load->model('catalog/product');

			foreach ($this->request->post['order_product'] as $order_product) {
				$product_info = $this->model_catalog_product->getProduct($order_product['product_id']);

				if ($product_info && $product_info['shipping']) {
					$shipping = true;
					break;
				}
			}
		}

		if ($shipping) {
			if ((utf8_strlen($this->request->post['shipping_firstname']) < 1) || (utf8_strlen($this->request->post['shipping_firstname']) > 32)) {
				$this->error['shipping_firstname'] = $this->language->get('error_firstname');
			}

			if ((utf8_strlen($this->request->post['shipping_lastname']) < 1) || (utf8_strlen($this->request->post['shipping_lastname']) > 32)) {
				$this->error['shipping_lastname'] = $this->language->get('error_lastname');
			}

			if ((utf8_strlen($this->request->post['shipping_address_1']) < 3) || (utf8_strlen($this->request->post['shipping_address_1']) > 128)) {
				$this->error['shipping_address_1'] = $this->language->get('error_address_1');
			}

			if ((utf8_strlen($this->request->post['shipping_city']) < 3) || (utf8_strlen($this->request->post['shipping_city']) > 128)) {
				$this->error['shipping_city'] = $this->language->get('error_city');
			}

			$this->load->model('localisation/country');

			$country_info = $this->model_localisation_country->getCountry($this->request->post['shipping_country_id']);

			if ($country_info && $country_info['postcode_required'] && (utf8_strlen($this->request->post['shipping_postcode']) < 2) || (utf8_strlen($this->request->post['shipping_postcode']) > 10)) {
				$this->error['shipping_postcode'] = $this->language->get('error_postcode');
			}

			if (!isset($this->request->post['shipping_country_id']) || $this->request->post['shipping_country_id'] == '') {
				$this->error['shipping_country'] = $this->language->get('error_country');
			}

			if (!isset($this->request->post['shipping_zone_id']) || $this->request->post['shipping_zone_id'] == '') {
				$this->error['shipping_zone'] = $this->language->get('error_zone');
			}

			if (!isset($this->request->post['shipping_method']) || $this->request->post['shipping_method'] == '') {
				$this->error['shipping_method'] = $this->language->get('error_shipping');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	public function info() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->language->load('sale/order');

			$this->document->setTitle($this->language->get('heading_title'));

			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['text_amazon_order_id'] = $this->language->get('text_amazon_order_id');
			$this->data['text_name'] = $this->language->get('text_name');
			$this->data['text_order_id'] = $this->language->get('text_order_id');
			$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$this->data['text_invoice_date'] = $this->language->get('text_invoice_date');
			$this->data['text_store_name'] = $this->language->get('text_store_name');
			$this->data['text_store_url'] = $this->language->get('text_store_url');
			$this->data['text_customer'] = $this->language->get('text_customer');
			$this->data['text_customer_group'] = $this->language->get('text_customer_group');
			$this->data['text_email'] = $this->language->get('text_email');
			$this->data['text_telephone'] = $this->language->get('text_telephone');
			$this->data['text_fax'] = $this->language->get('text_fax');
			$this->data['text_total'] = $this->language->get('text_total');
			$this->data['text_reward'] = $this->language->get('text_reward');
			$this->data['text_order_status'] = $this->language->get('text_order_status');
			$this->data['text_comment'] = $this->language->get('text_comment');
			$this->data['text_affiliate'] = $this->language->get('text_affiliate');
			$this->data['text_commission'] = $this->language->get('text_commission');
			$this->data['text_ip'] = $this->language->get('text_ip');
			$this->data['text_forwarded_ip'] = $this->language->get('text_forwarded_ip');
			$this->data['text_user_agent'] = $this->language->get('text_user_agent');
			$this->data['text_accept_language'] = $this->language->get('text_accept_language');
			$this->data['text_date_added'] = $this->language->get('text_date_added');
			$this->data['text_date_modified'] = $this->language->get('text_date_modified');
			$this->data['text_abandoned'] = $this->language->get('text_abandoned');
			$this->data['text_missed'] = $this->language->get('text_missed');

			$this->data['text_firstname'] = $this->language->get('text_firstname');
			$this->data['text_lastname'] = $this->language->get('text_lastname');
			$this->data['text_company'] = $this->language->get('text_company');
			$this->data['text_company_id'] = $this->language->get('text_company_id');
			$this->data['text_tax_id'] = $this->language->get('text_tax_id');
			$this->data['text_address_1'] = $this->language->get('text_address_1');
			$this->data['text_address_2'] = $this->language->get('text_address_2');
			$this->data['text_city'] = $this->language->get('text_city');
			$this->data['text_postcode'] = $this->language->get('text_postcode');
			$this->data['text_zone'] = $this->language->get('text_zone');
			$this->data['text_zone_code'] = $this->language->get('text_zone_code');
			$this->data['text_country'] = $this->language->get('text_country');
			$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$this->data['text_payment_method'] = $this->language->get('text_payment_method');
			$this->data['text_download'] = $this->language->get('text_download');
			$this->data['text_wait'] = $this->language->get('text_wait');
			$this->data['text_generate'] = $this->language->get('text_generate');

			$this->data['text_reward_add'] = $this->language->get('text_reward_add');
			$this->data['text_reward_remove'] = $this->language->get('text_reward_remove');
			$this->data['text_commission_add'] = $this->language->get('text_commission_add');
			$this->data['text_commission_remove'] = $this->language->get('text_commission_remove');
			$this->data['text_credit_add'] = $this->language->get('text_credit_add');
			$this->data['text_credit_remove'] = $this->language->get('text_credit_remove');

			$this->data['text_print_invoice'] = $this->language->get('text_print_invoice');
			$this->data['text_print_delivery_note'] = $this->language->get('text_print_delivery_note');
			$this->data['text_print_shipping_label'] = $this->language->get('text_print_shipping_label');
			$this->data['text_print_pick_list'] = $this->language->get('text_print_pick_list');

			$this->data['column_product'] = $this->language->get('column_product');
			$this->data['column_model'] = $this->language->get('column_model');
			$this->data['column_quantity'] = $this->language->get('column_quantity');
			$this->data['column_price'] = $this->language->get('column_price');
			$this->data['column_tax_value'] = $this->language->get('column_tax_value');
			$this->data['column_tax_percent'] = $this->language->get('column_tax_percent');
			$this->data['column_total'] = $this->language->get('column_total');
			$this->data['column_download'] = $this->language->get('column_download');
			$this->data['column_filename'] = $this->language->get('column_filename');
			$this->data['column_remaining'] = $this->language->get('column_remaining');
			$this->data['column_status_picked'] = $this->language->get('column_status_picked');
			$this->data['column_status_backordered'] = $this->language->get('column_status_backordered');

			$this->data['entry_order_status'] = $this->language->get('entry_order_status');
			$this->data['entry_notify'] = $this->language->get('entry_notify');
			$this->data['entry_comment'] = $this->language->get('entry_comment');

			$this->data['button_recover'] = $this->language->get('button_recover');
			$this->data['button_pick_list'] = $this->language->get('button_pick_list');
			$this->data['button_shipping_label'] = $this->language->get('button_shipping_label');
			$this->data['button_delivery_note'] = $this->language->get('button_delivery_note');
			$this->data['button_invoice'] = $this->language->get('button_invoice');
			$this->data['button_refresh'] = $this->language->get('button_refresh');
			$this->data['button_close'] = $this->language->get('button_close');
			$this->data['button_update'] = $this->language->get('button_update');
			$this->data['button_add_history'] = $this->language->get('button_add_history');

			$this->data['tab_order'] = $this->language->get('tab_order');
			$this->data['tab_payment'] = $this->language->get('tab_payment');
			$this->data['tab_shipping'] = $this->language->get('tab_shipping');
			$this->data['tab_product'] = $this->language->get('tab_product');
			$this->data['tab_pick_list'] = $this->language->get('tab_pick_list');
			$this->data['tab_history'] = $this->language->get('tab_history');

			$this->data['token'] = $this->session->data['token'];

			$this->data['picklist_status'] = $this->config->get('config_picklist_status');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}

			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

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

			if (isset($this->request->get['order_id'])) {
				$this->data['breadcrumbs'][] = array(
					'text'      => $this->language->get('heading_title') . ' :: N&deg;' . (int)$this->request->get['order_id'],
					'href'      => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'] . $url, 'SSL'),
					'separator' => ' :: '
				);

				$this->data['order_title'] = $this->language->get('heading_title') . ' N&deg;' . (int)$this->request->get['order_id'];

			} else {
				$this->data['breadcrumbs'][] = array(
					'text'      => $this->language->get('heading_title'),
					'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
					'separator' => ' :: '
				);

				$this->data['order_title'] = $this->language->get('heading_title');
			}

			$this->data['recover'] = $this->url->link('sale/order/recover', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'] . $url, 'SSL');
			$this->data['refresh'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'] . $url, 'SSL');
			$this->data['close'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL');

			$this->data['pick_list'] = $this->url->link('sale/order/pickList', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], 'SSL');
			$this->data['shipping_label'] = $this->url->link('sale/order/shippingLabel', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], 'SSL');
			$this->data['delivery_note'] = $this->url->link('sale/order/deliveryNote', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], 'SSL');
			$this->data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], 'SSL');

			$this->data['amazon_order_id'] = $order_info['amazon_order_id'];

			$this->data['order_id'] = (int)$this->request->get['order_id'];

			if ($order_info['invoice_no']) {
				$this->data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$this->data['invoice_no'] = '';
			}

			$this->data['store_id'] = $order_info['store_id'];
			$this->data['store_name'] = $order_info['store_name'];

			if ($order_info['store_id'] == 0) {
				$this->data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			} else {
				$this->data['store_url'] = $order_info['store_url'];
			}

			$this->data['firstname'] = $order_info['firstname'];
			$this->data['lastname'] = $order_info['lastname'];

			if ($order_info['customer_id']) {
				$this->data['customer'] = $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $order_info['customer_id'], 'SSL');
			} else {
				$this->data['customer'] = '';
			}

			$this->load->model('sale/customer_group');

			$customer_group_info = $this->model_sale_customer_group->getCustomerGroup($order_info['customer_group_id']);

			if ($customer_group_info) {
				$this->data['customer_group'] = $customer_group_info['name'];
			} else {
				$this->data['customer_group'] = '';
			}

			$this->data['email'] = $order_info['email'];
			$this->data['telephone'] = $order_info['telephone'];
			$this->data['fax'] = $order_info['fax'];
			$this->data['comment'] = nl2br($order_info['comment']);
			$this->data['shipping_method'] = $order_info['shipping_method'];
			$this->data['payment_method'] = $order_info['payment_method'];

			$this->data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);

			if ($order_info['total'] > 0) {
				$this->data['credit'] = $order_info['total'];
			} else {
				$this->data['credit'] = 0;
			}

			$this->load->model('sale/customer');

			$this->data['credit_total'] = $this->model_sale_customer->getTotalTransactionsByOrderId($this->request->get['order_id']);

			$this->data['reward'] = $order_info['reward'];

			$this->data['reward_total'] = $this->model_sale_customer->getTotalCustomerRewardsByOrderId($this->request->get['order_id']);

			$this->data['affiliate_firstname'] = $order_info['affiliate_firstname'];
			$this->data['affiliate_lastname'] = $order_info['affiliate_lastname'];

			if ($order_info['affiliate_id']) {
				$this->data['affiliate'] = $this->url->link('sale/affiliate/update', 'token=' . $this->session->data['token'] . '&affiliate_id=' . $order_info['affiliate_id'], 'SSL');
			} else {
				$this->data['affiliate'] = '';
			}

			$this->data['commission'] = $this->currency->format($order_info['commission'], $order_info['currency_code'], $order_info['currency_value']);

			$this->load->model('sale/affiliate');

			$this->data['commission_total'] = $this->model_sale_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);

			if ($order_info['order_status_id']) {
				$this->data['order_status_id'] = (int)$order_info['order_status_id'];
			} else {
				$this->data['order_status_id'] = 0;
			}

			$this->load->model('localisation/order_status');

			$order_status_info = $this->model_localisation_order_status->getOrderStatus($order_info['order_status_id']);

			if ($order_status_info) {
				$this->data['order_status'] = $order_status_info['name'];
			} else {
				$this->data['order_status'] = '';
			}

			$this->data['ip'] = $order_info['ip'];
			$this->data['forwarded_ip'] = $order_info['forwarded_ip'];
			$this->data['user_agent'] = $order_info['user_agent'];
			$this->data['accept_language'] = $order_info['accept_language'];
			$this->data['date_added'] = date($this->language->get('date_format_time'), strtotime($order_info['date_added']));
			$this->data['date_modified'] = date($this->language->get('date_format_time'), strtotime($order_info['date_modified']));
			$this->data['abandoned'] = ($order_info['abandoned']) ? true : false;

			$this->data['payment_firstname'] = $order_info['payment_firstname'];
			$this->data['payment_lastname'] = $order_info['payment_lastname'];
			$this->data['payment_company'] = $order_info['payment_company'];
			$this->data['payment_company_id'] = $order_info['payment_company_id'];
			$this->data['payment_tax_id'] = $order_info['payment_tax_id'];
			$this->data['payment_address_1'] = $order_info['payment_address_1'];
			$this->data['payment_address_2'] = $order_info['payment_address_2'];
			$this->data['payment_city'] = $order_info['payment_city'];
			$this->data['payment_postcode'] = $order_info['payment_postcode'];
			$this->data['payment_zone'] = $order_info['payment_zone'];
			$this->data['payment_zone_code'] = $order_info['payment_zone_code'];
			$this->data['payment_country'] = $order_info['payment_country'];
			$this->data['shipping_firstname'] = $order_info['shipping_firstname'];
			$this->data['shipping_lastname'] = $order_info['shipping_lastname'];
			$this->data['shipping_company'] = $order_info['shipping_company'];
			$this->data['shipping_address_1'] = $order_info['shipping_address_1'];
			$this->data['shipping_address_2'] = $order_info['shipping_address_2'];
			$this->data['shipping_city'] = $order_info['shipping_city'];
			$this->data['shipping_postcode'] = $order_info['shipping_postcode'];
			$this->data['shipping_zone'] = $order_info['shipping_zone'];
			$this->data['shipping_zone_code'] = $order_info['shipping_zone_code'];
			$this->data['shipping_country'] = $order_info['shipping_country'];

			$this->load->model('tool/barcode');

			$admin_barcode = $this->config->get('config_admin_barcode');
			$barcode_type = $this->config->get('config_barcode_type');

			$this->data['products'] = array();

			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $option['value'],
							'type'  => $option['type']
						);

					} else {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.')),
							'type'  => $option['type'],
							'href'  => $this->url->link('sale/order/download', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&order_option_id=' . $option['order_option_id'], 'SSL')
						);
					}
				}

				$this->data['products'][] = array(
					'order_product_id' => $product['order_product_id'],
					'product_id'       => $product['product_id'],
					'name'             => $product['name'],
					'barcode'          => ($admin_barcode) ? $this->model_tool_barcode->getBarcode($product['model'], strtoupper($barcode_type), 1, 20) : '',
					'model'            => $product['model'],
					'option'           => $option_data,
					'quantity'         => $product['quantity'],
					'price'            => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'tax_value'        => $this->currency->format(($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'tax_percent'      => number_format(((($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0) * 100) / (($product['price'] > 0) ? ($product['price'] * $product['quantity']) : $product['quantity'])), 2, '.', ''),
					'total'            => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'picked'           => $product['picked'],
					'backordered'      => $product['backordered'],
					'href_picked'      => $this->url->link('sale/order/picked', 'token=' . $this->session->data['token'] . '&order_product_id=' . $product['order_product_id'], 'SSL'),
					'href_backordered' => $this->url->link('sale/order/backordered', 'token=' . $this->session->data['token'] . '&order_product_id=' . $product['order_product_id'], 'SSL'),
					'href'             => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], 'SSL')
				);
			}

			$this->data['vouchers'] = array();

			$vouchers = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$this->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
					'href'        => $this->url->link('sale/voucher/update', 'token=' . $this->session->data['token'] . '&voucher_id=' . $voucher['voucher_id'], 'SSL')
				);
			}

			$this->data['totals'] = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

			$this->data['downloads'] = array();

			foreach ($products as $product) {
				$results = $this->model_sale_order->getOrderDownloads($this->request->get['order_id'], $product['order_product_id']);

				foreach ($results as $result) {
					$this->data['downloads'][] = array(
						'name'      => $result['name'],
						'filename'  => $result['mask'],
						'remaining' => $result['remaining']
					);
				}
			}

			$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

			$this->data['order_status_id'] = $order_info['order_status_id'];

			// Anti-Fraud Tabs
			$this->data['tabs'] = array();

			$this->load->model('setting/extension');

			$extensions = $this->model_setting_extension->getExtensions('fraud');

			if ($extensions) {
				foreach ($extensions as $extension) {
					if ($extension['code'] && $this->config->get($extension['code'] . '_status')) {
						$this->language->load('fraud/' . $extension['code']);

						$content = $this->getChild('fraud/' . $extension['code'] . '/order');

						if ($content) {
							$this->data['tabs'][] = array(
								'code'    => $extension['code'],
								'title'   => $this->language->get('heading_title'),
								'content' => $content
							);
						}
					}
				}
			}

			if ($this->hasAction('payment/' . $order_info['payment_code'] . '/orderAction') == true) {
				$this->data['payment_action'] = $this->getChild('payment/' . $order_info['payment_code'] . '/orderAction');
			} else {
				$this->data['payment_action'] = '';
			}

			$this->template = 'sale/order_info.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);

			$this->response->setOutput($this->render());

		} else {
			$this->language->load('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['text_not_found'] = $this->language->get('text_not_found');

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			);

			$this->template = 'error/not_found.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);

			$this->response->addheader($this->request->server['SERVER_PROTOCOL'] . ' 404 not found');
			$this->response->setOutput($this->render());
		}
	}

	public function createInvoiceNo() {
		$json = array();

		$this->language->load('sale/order');

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');

		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/order');

			$invoice_no = $this->model_sale_order->createInvoiceNo($this->request->get['order_id']);

			if ($invoice_no) {
				$json['invoice_no'] = $invoice_no;
			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addCredit() {
		$json = array();

		$this->language->load('sale/order');

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');

		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

			if ($order_info && $order_info['customer_id']) {
				$this->load->model('sale/customer');

				$credit_total = $this->model_sale_customer->getTotalTransactionsByOrderId($this->request->get['order_id']);

				if (!$credit_total) {
					$this->model_sale_customer->addTransaction($order_info['customer_id'], $this->language->get('text_order_id') . ' #' . $this->request->get['order_id'], $order_info['total'], $this->request->get['order_id']);

					$json['success'] = $this->language->get('text_credit_added');
				} else {
					$json['error'] = $this->language->get('error_action');
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeCredit() {
		$json = array();

		$this->language->load('sale/order');

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');

		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

			if ($order_info && $order_info['customer_id']) {
				$this->load->model('sale/customer');

				$this->model_sale_customer->deleteTransaction($this->request->get['order_id']);

				$json['success'] = $this->language->get('text_credit_removed');

			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addReward() {
		$json = array();

		$this->language->load('sale/order');

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');

		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

			if ($order_info && $order_info['customer_id'] && ($order_info['reward'] > 0)) {
				$this->load->model('sale/customer');

				$reward_total = $this->model_sale_customer->getTotalCustomerRewardsByOrderId($this->request->get['order_id']);

				if (!$reward_total) {
					$this->model_sale_customer->addReward($order_info['customer_id'], $this->language->get('text_order_id') . ' #' . $this->request->get['order_id'], $order_info['reward'], $this->request->get['order_id']);

					$json['success'] = $this->language->get('text_reward_added');

				} else {
					$json['error'] = $this->language->get('error_action');
				}

			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeReward() {
		$json = array();

		$this->language->load('sale/order');

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');

		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

			if ($order_info && $order_info['customer_id']) {
				$this->load->model('sale/customer');

				$this->model_sale_customer->deleteReward($this->request->get['order_id']);

				$json['success'] = $this->language->get('text_reward_removed');

			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addCommission() {
		$json = array();

		$this->language->load('sale/order');

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');

		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

			if ($order_info && $order_info['affiliate_id']) {
				$this->load->model('sale/affiliate');

				$affiliate_total = $this->model_sale_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);

				if (!$affiliate_total) {
					$this->model_sale_affiliate->addTransaction($order_info['affiliate_id'], $this->language->get('text_order_id') . ' #' . $this->request->get['order_id'], $order_info['commission'], $this->request->get['order_id']);

					$json['success'] = $this->language->get('text_commission_added');

				} else {
					$json['error'] = $this->language->get('error_action');
				}

			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeCommission() {
		$json = array();

		$this->language->load('sale/order');

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');

		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

			if ($order_info && $order_info['affiliate_id']) {
				$this->load->model('sale/affiliate');

				$this->model_sale_affiliate->deleteTransaction($this->request->get['order_id']);

				$json['success'] = $this->language->get('text_commission_removed');

			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function history() {
		$this->language->load('sale/order');

		$this->data['error'] = '';
		$this->data['success'] = '';

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('sale/order');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'sale/order')) {
				$this->data['error'] = $this->language->get('error_permission');
			}

			if (!$this->data['error']) {
				$this->model_sale_order->addOrderHistory($this->request->get['order_id'], $this->request->post);

				$this->data['success'] = $this->language->get('text_success');

				$this->redirect = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL');
			}
		}

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_comment'] = $this->language->get('column_comment');
		$this->data['column_notify'] = $this->language->get('column_notify');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$this->data['histories'] = array();

		$results = $this->model_sale_order->getOrderHistories($this->request->get['order_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$this->data['histories'][] = array(
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'status'     => $result['status'],
				'comment'    => nl2br($result['comment']),
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no')
			);
		}

		$history_total = $this->model_sale_order->getTotalOrderHistories($this->request->get['order_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/order/history', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'sale/order_history.tpl';

		$this->response->setOutput($this->render());
	}

	public function download() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_option_id'])) {
			$order_option_id = $this->request->get['order_option_id'];
		} else {
			$order_option_id = 0;
		}

		$option_info = $this->model_sale_order->getOrderOption($this->request->get['order_id'], $order_option_id);

		if ($option_info && $option_info['type'] == 'file') {
			$file = DIR_DOWNLOAD . $option_info['value'];

			$mask = basename(utf8_substr($option_info['value'], 0, utf8_strrpos($option_info['value'], '.')));

			if (!headers_sent()) {
				if (file_exists($file) && is_file($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file);
					exit();

				} else {
					exit('Error: Could not find file ' . $file . '!');
				}

				clearstatcache();

			} else {
				exit('Error: Headers already sent out!');
			}

		} else {
			$this->language->load('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['text_not_found'] = $this->language->get('text_not_found');

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			);

			$this->template = 'error/not_found.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);

			$this->response->addheader($this->request->server['SERVER_PROTOCOL'] . ' 404 not found');
			$this->response->setOutput($this->render());
		}
	}

	public function upload() {
		$this->language->load('sale/order');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!empty($this->request->files['file']['name'])) {
				$filename = html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8');

				if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
					$json['error'] = $this->language->get('error_filename');
				}

				// Allowed file extension types
				$allowed = array();

				$filetypes = explode("\n", str_replace(array("\r\n", "\r"), "\n", $this->config->get('config_file_extension_allowed')));

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Allowed file mime types
				$allowed = array();

				$filetypes = explode("\n", str_replace(array("\r\n", "\r"), "\n", $this->config->get('config_file_mime_allowed')));

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array($this->request->files['file']['type'], $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Check to see if any PHP files are trying to be uploaded
				$content = file_get_contents($this->request->files['file']['tmp_name']);

				if (preg_match('/\<\?php/i', $content)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}

			} else {
				$json['error'] = $this->language->get('error_upload');
			}

			if (!isset($json['error'])) {
				if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
					$file = basename($filename) . '.' . hash_rand('md5');

					$json['file'] = $file;

					move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
				}

				$json['success'] = $this->language->get('text_upload');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function picked() {
		$this->language->load('sale/order');

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!isset($json['error']) && isset($this->request->get['order_product_id'])) {
			$product_id = $this->request->get['order_product_id'];

			$this->load->model('sale/order');

			if ($this->request->get['pick'] === 'true') {
				$this->model_sale_order->setPicked($product_id, true);
			} elseif ($this->request->get['pick'] === 'false') {
				$this->model_sale_order->setPicked($product_id, false);
			}

			$json['success'] = $this->language->get('text_order_picked');
		} else {
			$json['error'] = $this->language->get('error_action');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function backordered() {
		$this->language->load('sale/order');

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!isset($json['error']) && isset($this->request->get['order_product_id'])) {
			$product_id = $this->request->get['order_product_id'];

			$backorder = isset($this->request->get['backorder']) ? $this->request->get['backorder'] : '';

			$this->load->model('sale/order');

			$this->model_sale_order->setBackOrdered($product_id, $backorder);

			$json['success'] = $this->language->get('text_order_backordered');
		} else {
			$json['error'] = $this->language->get('error_action');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function shippingLabel() {
		$this->language->load('sale/order');

		$this->data['title'] = $this->language->get('heading_title');

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$this->data['base'] = HTTPS_SERVER;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['direction'] = $this->language->get('direction');
		$this->data['language'] = $this->language->get('code');

		$this->data['text_shipping_label'] = $this->language->get('text_shipping_label');

		$this->data['text_deliver_to'] = $this->language->get('text_deliver_to');
		$this->data['text_email'] = $this->language->get('text_email');
		$this->data['text_telephone'] = $this->language->get('text_telephone');

		$this->data['column_comment'] = $this->language->get('column_comment');

		$this->load->model('sale/order');
		$this->load->model('setting/setting');

		$pdf = false;

		$this->data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
			$pdf = (isset($this->request->get['pdf'])) ? true : false;
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
			$pdf = (isset($this->request->get['pdf'])) ? true : false;
		}

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG . 'image/' . $this->config->get('config_logo') : HTTP_CATALOG . 'image/' . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->data['orders'][] = array(
					'order_id'         => $order_id,
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'telephone'        => $order_info['telephone'],
					'shipping_address' => $shipping_address,
					'shipping_method'  => $order_info['shipping_method'],
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}

		$this->template = 'sale/order_shipping_label.tpl';

		if ($pdf) {
			$document_type = $this->language->get('text_shipping_label');

			$this->response->setOutput(pdf($this->render(), $document_type, $this->request->get['order_id']));
		} else {
			$this->response->setOutput($this->render());
		}
	}

	public function pickList() {
		$this->language->load('sale/order');

		$this->data['title'] = $this->language->get('heading_title');

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$this->data['base'] = HTTPS_SERVER;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['direction'] = $this->language->get('direction');
		$this->data['language'] = $this->language->get('code');

		$this->data['text_pick_list'] = $this->language->get('text_pick_list');

		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$this->data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_copyrights'] = $this->language->get('text_copyrights');
		$this->data['text_to'] = $this->language->get('text_to');
		$this->data['text_ship_to'] = $this->language->get('text_ship_to');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');

		$this->data['text_shipping_collection'] = $this->language->get('text_shipping_collection');
		$this->data['text_customer_reception'] = $this->language->get('text_customer_reception');
		$this->data['text_collection_reference'] = $this->language->get('text_collection_reference');
		$this->data['text_collection_date'] = $this->language->get('text_collection_date');
		$this->data['text_collection_time'] = $this->language->get('text_collection_time');
		$this->data['text_collection_name'] = $this->language->get('text_collection_name');
		$this->data['text_collection_sign'] = $this->language->get('text_collection_sign');
		$this->data['text_reception_name'] = $this->language->get('text_reception_name');
		$this->data['text_reception_sign'] = $this->language->get('text_reception_sign');
		$this->data['text_reception_date'] = $this->language->get('text_reception_date');
		$this->data['text_reception_condition'] = $this->language->get('text_reception_condition');

		$this->data['column_location'] = $this->language->get('column_location');
		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_status_picked'] = $this->language->get('column_status_picked');
		$this->data['column_status_backordered'] = $this->language->get('column_status_backordered');
		$this->data['column_comment'] = $this->language->get('column_comment');

		$this->load->model('sale/order');
		$this->load->model('setting/setting');
		$this->load->model('tool/barcode');

		$admin_barcode = $this->config->get('config_admin_barcode');
		$barcode_type = $this->config->get('config_barcode_type');

		$pdf = false;

		$this->data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
			$pdf = (isset($this->request->get['pdf'])) ? true : false;
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
			$pdf = (isset($this->request->get['pdf'])) ? true : false;
		}

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG . 'image/' . $this->config->get('config_logo') : HTTP_CATALOG . 'image/' . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				$store_company_id = $this->config->get('config_company_id') ? $this->config->get('config_company_id') : '';
				$store_company_tax_id = $this->config->get('config_company_tax_id') ? $this->config->get('config_company_tax_id') : '';

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if (!empty($payment_address)) {
					$similar_address = similar_text(strtoupper($payment_address), strtoupper($shipping_address), $similarity);

					if ($similar_address && number_format($similarity, 0) > 95) {
						$same_address = true;
					} else {
						$same_address = false;
					}

				} else {
					$same_address = true;
				}

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);
					}

					$bin_location = $this->model_sale_order->getOrderProductLocation($product['product_id']);

					$product_data[] = array(
						'name'     => $product['name'],
						'barcode'  => ($admin_barcode) ? $this->model_tool_barcode->getBarcode($product['model'], strtoupper($barcode_type), 1, 20) : '',
						'location' => ($bin_location) ? $bin_location : false,
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity']
					);
				}

				$this->data['orders'][] = array(
					'order_id'             => $order_id,
					'invoice_no'           => $invoice_no,
					'date_added'           => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'           => $this->config->get('config_name'),
					'store_address'        => nl2br($store_address),
					'store_email'          => $store_email,
					'store_telephone'      => $store_telephone,
					'store_fax'            => $store_fax,
					'store_url'            => rtrim($order_info['store_url'], '/'),
					'store_company_id'     => $store_company_id,
					'store_company_tax_id' => $store_company_tax_id,
					'telephone'            => $order_info['telephone'],
					'shipping_address'     => ($same_address) ? '' : $shipping_address,
					'shipping_method'      => $order_info['shipping_method'],
					'payment_address'      => ($same_address) ? $shipping_address : $payment_address,
					'payment_company'      => $order_info['payment_company'],
					'payment_company_id'   => $order_info['payment_company_id'],
					'payment_method'       => $order_info['payment_method'],
					'product'              => $product_data,
					'comment'              => nl2br($order_info['comment'])
				);
			}
		}

		$this->template = 'sale/order_pick_list.tpl';

		if ($pdf) {
			$document_type = $this->language->get('text_pick_list');

			$this->response->setOutput(pdf($this->render(), $document_type, $this->request->get['order_id']));
		} else {
			$this->response->setOutput($this->render());
		}
	}

	public function deliveryNote() {
		$this->language->load('sale/order');

		$this->data['title'] = $this->language->get('heading_title');

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$this->data['base'] = HTTPS_SERVER;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['direction'] = $this->language->get('direction');
		$this->data['language'] = $this->language->get('code');

		$this->data['text_delivery_note'] = $this->language->get('text_delivery_note');

		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$this->data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_damages'] = $this->language->get('text_damages');
		$this->data['text_bank_name'] = $this->language->get('text_bank_name');
		$this->data['text_bank_account'] = $this->language->get('text_bank_account');
		$this->data['text_copyrights'] = $this->language->get('text_copyrights');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_payment_address'] = $this->language->get('text_payment_address');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');

		$this->data['text_shipping_collection'] = $this->language->get('text_shipping_collection');
		$this->data['text_customer_reception'] = $this->language->get('text_customer_reception');
		$this->data['text_collection_reference'] = $this->language->get('text_collection_reference');
		$this->data['text_collection_date'] = $this->language->get('text_collection_date');
		$this->data['text_collection_time'] = $this->language->get('text_collection_time');
		$this->data['text_collection_name'] = $this->language->get('text_collection_name');
		$this->data['text_collection_sign'] = $this->language->get('text_collection_sign');
		$this->data['text_reception_name'] = $this->language->get('text_reception_name');
		$this->data['text_reception_sign'] = $this->language->get('text_reception_sign');
		$this->data['text_reception_date'] = $this->language->get('text_reception_date');
		$this->data['text_reception_condition'] = $this->language->get('text_reception_condition');

		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_comment'] = $this->language->get('column_comment');

		$this->load->model('sale/order');
		$this->load->model('setting/setting');
		$this->load->model('tool/barcode');

		$admin_barcode = $this->config->get('config_admin_barcode');
		$barcode_type = $this->config->get('config_barcode_type');

		$pdf = false;

		$this->data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
			$pdf = (isset($this->request->get['pdf'])) ? true : false;
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
			$pdf = (isset($this->request->get['pdf'])) ? true : false;
		}

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG . 'image/' . $this->config->get('config_logo') : HTTP_CATALOG . 'image/' . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}

		$this->data['bank_name'] = $this->config->get('config_bank_name') ? $this->config->get('config_bank_name') : '';
		$this->data['bank_sort_code'] = $this->config->get('config_bank_sort_code') ? $this->config->get('config_bank_sort_code') : '';
		$this->data['bank_account'] = $this->config->get('config_bank_account') ? $this->config->get('config_bank_account') : '';

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				$store_company_id = $this->config->get('config_company_id') ? $this->config->get('config_company_id') : '';
				$store_company_tax_id = $this->config->get('config_company_tax_id') ? $this->config->get('config_company_tax_id') : '';

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);
					}

					$product_data[] = array(
						'name'     => $product['name'],
						'barcode'  => ($admin_barcode) ? $this->model_tool_barcode->getBarcode($product['model'], strtoupper($barcode_type), 1, 20) : '',
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity']
					);
				}

				$this->data['orders'][] = array(
					'order_id'             => $order_id,
					'invoice_no'           => $invoice_no,
					'date_added'           => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'           => $this->config->get('config_name'),
					'store_address'        => nl2br($store_address),
					'store_email'          => $store_email,
					'store_telephone'      => $store_telephone,
					'store_fax'            => $store_fax,
					'store_url'            => rtrim($order_info['store_url'], '/'),
					'store_company_id'     => $store_company_id,
					'store_company_tax_id' => $store_company_tax_id,
					'telephone'            => $order_info['telephone'],
					'shipping_address'     => $shipping_address,
					'shipping_method'      => $order_info['shipping_method'],
					'payment_address'      => $payment_address,
					'payment_company'      => $order_info['payment_company'],
					'payment_company_id'   => $order_info['payment_company_id'],
					'payment_method'       => $order_info['payment_method'],
					'product'              => $product_data,
					'comment'              => nl2br($order_info['comment'])
				);
			}
		}

		$this->template = 'sale/order_delivery_note.tpl';

		if ($pdf) {
			$document_type = $this->language->get('text_delivery_note');

			$this->response->setOutput(pdf($this->render(), $document_type, $this->request->get['order_id']));
		} else {
			$this->response->setOutput($this->render());
		}
	}

	public function invoice() {
		$this->language->load('sale/order');

		$this->data['title'] = $this->language->get('heading_title');

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$this->data['base'] = HTTPS_SERVER;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['direction'] = $this->language->get('direction');
		$this->data['language'] = $this->language->get('code');

		$this->data['text_invoice'] = $this->language->get('text_invoice');

		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$this->data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_damages'] = $this->language->get('text_damages');
		$this->data['text_bank_name'] = $this->language->get('text_bank_name');
		$this->data['text_bank_account'] = $this->language->get('text_bank_account');
		$this->data['text_copyrights'] = $this->language->get('text_copyrights');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_payment_address'] = $this->language->get('text_payment_address');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');

		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_tax_value'] = $this->language->get('column_tax_value');
		$this->data['column_tax_percent'] = $this->language->get('column_tax_percent');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_comment'] = $this->language->get('column_comment');

		// Get tax breakdown
		if ($this->config->get('config_tax_breakdown')) {
			$this->data['tax_breakdown'] = true;
			$this->data['tax_colspan'] = 6;
		} else {
			$this->data['tax_breakdown'] = false;
			$this->data['tax_colspan'] = 4;
		}

		$this->load->model('sale/order');
		$this->load->model('setting/setting');

		$pdf = false;

		$this->data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
			$pdf = (isset($this->request->get['pdf'])) ? true : false;
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
			$pdf = (isset($this->request->get['pdf'])) ? true : false;
		}

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG . 'image/' . $this->config->get('config_logo') : HTTP_CATALOG . 'image/' . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}

		$this->data['bank_name'] = $this->config->get('config_bank_name') ? $this->config->get('config_bank_name') : '';
		$this->data['bank_sort_code'] = $this->config->get('config_bank_sort_code') ? $this->config->get('config_bank_sort_code') : '';
		$this->data['bank_account'] = $this->config->get('config_bank_account') ? $this->config->get('config_bank_account') : '';

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				$store_company_id = $this->config->get('config_company_id') ? $this->config->get('config_company_id') : '';
				$store_company_tax_id = $this->config->get('config_company_tax_id') ? $this->config->get('config_company_tax_id') : '';

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);
					}

					$product_data[] = array(
						'name'        => $product['name'],
						'model'       => $product['model'],
						'option'      => $option_data,
						'quantity'    => $product['quantity'],
						'price'       => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'tax_value'   => $this->currency->format(($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
						'tax_percent' => number_format(((($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0) * 100) / (($product['price'] > 0) ? ($product['price'] * $product['quantity']) : $product['quantity'])), 2, '.', ''),
						'total'       => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$voucher_data = array();

				$vouchers = $this->model_sale_order->getOrderVouchers($order_id);

				foreach ($vouchers as $voucher) {
					$voucher_data[] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$total_data = $this->model_sale_order->getOrderTotals($order_id);

				$this->data['orders'][] = array(
					'order_id'             => $order_id,
					'invoice_no'           => $invoice_no,
					'date_added'           => date($this->language->get('date_format_time'), strtotime($order_info['date_added'])),
					'store_name'           => $this->config->get('config_name'),
					'store_address'        => nl2br($store_address),
					'store_email'          => $store_email,
					'store_telephone'      => $store_telephone,
					'store_fax'            => $store_fax,
					'store_url'            => rtrim($order_info['store_url'], '/'),
					'store_company_id'     => $store_company_id,
					'store_company_tax_id' => $store_company_tax_id,
					'email'                => $order_info['email'],
					'telephone'            => $order_info['telephone'],
					'shipping_address'     => $shipping_address,
					'shipping_method'      => $order_info['shipping_method'],
					'payment_address'      => $payment_address,
					'payment_company'      => $order_info['payment_company'],
					'payment_company_id'   => $order_info['payment_company_id'],
					'payment_method'       => $order_info['payment_method'],
					'product'              => $product_data,
					'voucher'              => $voucher_data,
					'total'                => $total_data,
					'comment'              => nl2br($order_info['comment'])
				);
			}
		}

		$this->template = 'sale/order_invoice.tpl';

		if ($pdf) {
			$document_type = $this->language->get('text_invoice');

			$this->response->setOutput(pdf($this->render(), $document_type, $this->request->get['order_id']));
		} else {
			$this->response->setOutput($this->render());
		}
	}
}
