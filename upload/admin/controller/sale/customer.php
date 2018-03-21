<?php
class ControllerSaleCustomer extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('sale/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/customer');

		$this->getList();
	}

	public function insert() {
		$this->language->load('sale/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_customer->addCustomer($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			if (isset($this->request->post['apply'])) {
				$customer_id = $this->session->data['new_customer_id'];

				if ($customer_id) {
					unset($this->session->data['new_customer_id']);

					$this->redirect($this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $customer_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('sale/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/customer');

		$customer_deleted = $this->model_sale_customer->getDeletedByCustomerId($this->request->get['customer_id']);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$customer_deleted && $this->validateForm()) {
			$this->model_sale_customer->editCustomer($this->request->get['customer_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			if (isset($this->request->post['apply'])) {
				$customer_id = $this->request->get['customer_id'];

				if ($customer_id) {
					$this->redirect($this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $customer_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('sale/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/customer');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $customer_id) {
				$customer_deleted = $this->model_sale_customer->checkCustomersDeletedId($customer_id);

				if (!$customer_deleted) {
					$this->model_sale_customer->addDeletedCustomer($customer_id);

					$force_delete = $this->config->get('config_force_delete');

					$orders_total = $this->model_sale_customer->getTotalCustomersOrders($customer_id);

					if (!$force_delete && $orders_total > 0) {
						$this->model_sale_customer->deleteCustomerWithOrders($customer_id);
					} else {
						$this->model_sale_customer->deleteCustomer($customer_id);
					}
				}
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			$this->redirect($this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function approve() {
		$this->language->load('sale/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/customer');

		if (isset($this->request->post['selected']) && $this->validateApprove()) {
			$approved = 0;

			foreach ($this->request->post['selected'] as $customer_id) {
				$customer_info = $this->model_sale_customer->getCustomer($customer_id);

				if ($customer_info && !$customer_info['approved']) {
					$this->model_sale_customer->approve($customer_id);

					$approved++;
				}
			}

			$this->session->data['success'] = sprintf($this->language->get('text_approved'), $approved);

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			$this->redirect($this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_approved'])) {
			$filter_approved = $this->request->get['filter_approved'];
		} else {
			$filter_approved = null;
		}

		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			'href'      => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['approve'] = $this->url->link('sale/customer/approve', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert'] = $this->url->link('sale/customer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/customer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['show_dob'] = $this->config->get('config_customer_dob');

		$this->data['customers'] = array();

		$filter_data = array(
			'filter_name'              => $filter_name,
			'filter_email'             => $filter_email,
			'filter_customer_group_id' => $filter_customer_group_id,
			'filter_status'            => $filter_status,
			'filter_approved'          => $filter_approved,
			'filter_date_added'        => $filter_date_added,
			'filter_ip'                => $filter_ip,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		);

		$customer_total = $this->model_sale_customer->getTotalCustomers($filter_data);

		$results = $this->model_sale_customer->getCustomers($filter_data);

		foreach ($results as $result) {
			$action = array();

			$customer_deleted = $this->model_sale_customer->checkCustomersDeletedId($result['customer_id']);

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
			);

			if ($this->config->get('config_customer_dob')) {
				$customer_age = date_diff(date_create($result['date_of_birth']), date_create('today'))->y;
			} else {
				$customer_age = '';
			}

			$this->data['customers'][] = array(
				'customer_id'    => $result['customer_id'],
				'name'           => $result['name'],
				'email'          => $result['email'],
				'age'            => $customer_age,
				'customer_group' => $result['customer_group'],
				'status'         => (!$customer_deleted) ? $result['status'] : 2,
				'approved'       => $result['approved'],
				'ip'             => $result['ip'],
				'blocked_ip'     => $this->model_sale_customer->isBlockedIp($result['ip']) ? '<span style="color:#D80000;"><b>( ! )</b></span>' : '',
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'       => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
				'action'         => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_deleted'] = $this->language->get('text_deleted');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_default'] = $this->language->get('text_default');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_login'] = $this->language->get('column_login');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_approve'] = $this->language->get('button_approve');
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
		$this->data['sort_customer_group'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, 'SSL');
		$this->data['sort_approved'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.approved' . $url, 'SSL');
		$this->data['sort_ip'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.ip' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $customer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_approved'] = $filter_approved;
		$this->data['filter_ip'] = $filter_ip;
		$this->data['filter_date_added'] = $filter_date_added;

		$this->load->model('sale/customer_group');

		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/customer_list.tpl';
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
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_blocked_ip'] = $this->language->get('text_blocked_ip');
		$this->data['text_allowed_ip'] = $this->language->get('text_allowed_ip');
		$this->data['text_add_ban_ip'] = $this->language->get('text_add_ban_ip');
		$this->data['text_remove_ban_ip'] = $this->language->get('text_remove_ban_ip');
		$this->data['text_female'] = $this->language->get('text_female');
		$this->data['text_male'] = $this->language->get('text_male');
		$this->data['text_delete_transaction_confirm'] = $this->language->get('text_delete_transaction_confirm');
		$this->data['text_delete_reward_confirm'] = $this->language->get('text_delete_reward_confirm');
		$this->data['text_deleted_warning'] = $this->language->get('text_deleted_warning');

		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_location'] = $this->language->get('column_location');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_firewall'] = $this->language->get('column_firewall');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_gender'] = $this->language->get('entry_gender');
		$this->data['entry_date_of_birth'] = $this->language->get('entry_date_of_birth');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_confirm'] = $this->language->get('entry_confirm');
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_approved'] = $this->language->get('entry_approved');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');
		$this->data['entry_address_2'] = $this->language->get('entry_address_2');
		$this->data['entry_city'] = $this->language->get('entry_city');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_default'] = $this->language->get('entry_default');
		$this->data['entry_comment'] = $this->language->get('entry_comment');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_amount'] = $this->language->get('entry_amount');
		$this->data['entry_points'] = $this->language->get('entry_points');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_address'] = $this->language->get('button_add_address');
		$this->data['button_add_history'] = $this->language->get('button_add_history');
		$this->data['button_add_transaction'] = $this->language->get('button_add_transaction');
		$this->data['button_add_reward'] = $this->language->get('button_add_reward');
		$this->data['button_remove'] = $this->language->get('button_remove');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_address'] = $this->language->get('tab_address');
		$this->data['tab_history'] = $this->language->get('tab_history');
		$this->data['tab_purchase'] = $this->language->get('tab_purchase');
		$this->data['tab_transaction'] = $this->language->get('tab_transaction');
		$this->data['tab_reward'] = $this->language->get('tab_reward');
		$this->data['tab_ip'] = $this->language->get('tab_ip');

		// Customer deleted
		$this->data['customer_deleted'] = $this->model_sale_customer->getDeletedByCustomerId($this->request->get['customer_id']);

		$this->data['customer_warning'] = $this->language->get('customer_warning');

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

		if (isset($this->error['date_of_birth'])) {
			$this->data['error_date_of_birth'] = $this->error['date_of_birth'];
		} else {
			$this->data['error_date_of_birth'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		}

		if (isset($this->error['address_firstname'])) {
			$this->data['error_address_firstname'] = $this->error['address_firstname'];
		} else {
			$this->data['error_address_firstname'] = '';
		}

		if (isset($this->error['address_lastname'])) {
			$this->data['error_address_lastname'] = $this->error['address_lastname'];
		} else {
			$this->data['error_address_lastname'] = '';
		}

		if (isset($this->error['address_tax_id'])) {
			$this->data['error_address_tax_id'] = $this->error['address_tax_id'];
		} else {
			$this->data['error_address_tax_id'] = '';
		}

		if (isset($this->error['address_address_1'])) {
			$this->data['error_address_address_1'] = $this->error['address_address_1'];
		} else {
			$this->data['error_address_address_1'] = '';
		}

		if (isset($this->error['address_city'])) {
			$this->data['error_address_city'] = $this->error['address_city'];
		} else {
			$this->data['error_address_city'] = '';
		}

		if (isset($this->error['address_postcode'])) {
			$this->data['error_address_postcode'] = $this->error['address_postcode'];
		} else {
			$this->data['error_address_postcode'] = '';
		}

		if (isset($this->error['address_country'])) {
			$this->data['error_address_country'] = $this->error['address_country'];
		} else {
			$this->data['error_address_country'] = '';
		}

		if (isset($this->error['address_zone'])) {
			$this->data['error_address_zone'] = $this->error['address_zone'];
		} else {
			$this->data['error_address_zone'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

		if (isset($this->request->get['customer_id'])) {
			$customer_name = $this->model_sale_customer->getCustomer($this->request->get['customer_id']);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title') . ' :: ' . $customer_name['firstname'] . ' ' . $customer_name['lastname'],
				'href'      => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$total_customer_orders = $this->model_sale_customer->getTotalCustomersOrders($this->request->get['customer_id']);

			$this->data['customer_title'] = $customer_name['firstname'] . ' ' . $customer_name['lastname'] . ' (' . $total_customer_orders . ')';

		} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$this->data['customer_title'] = $this->language->get('heading_title');
		}

		if (!isset($this->request->get['customer_id'])) {
			$this->data['action'] = $this->url->link('sale/customer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['customer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$customer_info = $this->model_sale_customer->getCustomer($this->request->get['customer_id']);
		}

		if (isset($this->request->get['customer_id'])) {
			$this->data['customer_id'] = $this->request->get['customer_id'];
		} else {
			$this->data['customer_id'] = 0;
		}

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($customer_info)) {
			$this->data['firstname'] = $customer_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($customer_info)) {
			$this->data['lastname'] = $customer_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (!empty($customer_info)) {
			$this->data['email'] = $customer_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($customer_info)) {
			$this->data['telephone'] = $customer_info['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		$this->data['show_fax'] = $this->config->get('config_customer_fax');

		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif (!empty($customer_info)) {
			$this->data['fax'] = $customer_info['fax'];
		} else {
			$this->data['fax'] = '';
		}

		$this->data['show_gender'] = $this->config->get('config_customer_gender');

		if (isset($this->request->post['gender'])) {
			$this->data['gender'] = $this->request->post['gender'];
		} elseif (isset($customer_info)) {
			$this->data['gender'] = $customer_info['gender'];
		} else {
			$this->data['gender'] = '';
		}

		$this->data['show_dob'] = $this->config->get('config_customer_dob');

		if (isset($this->request->post['date_of_birth'])) {
			$this->data['date_of_birth'] = $this->request->post['date_of_birth'];
		} elseif (isset($customer_info)) {
			$this->data['date_of_birth'] = date('Y-m-d', strtotime($customer_info['date_of_birth']));
		} else {
			$this->data['date_of_birth'] = '0000-00-00';
		}

		if (isset($this->request->post['newsletter'])) {
			$this->data['newsletter'] = $this->request->post['newsletter'];
		} elseif (!empty($customer_info)) {
			$this->data['newsletter'] = $customer_info['newsletter'];
		} else {
			$this->data['newsletter'] = '';
		}

		$this->load->model('sale/customer_group');

		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		if (isset($this->request->post['customer_group_id'])) {
			$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} elseif (!empty($customer_info)) {
			$this->data['customer_group_id'] = $customer_info['customer_group_id'];
		} else {
			$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($customer_info)) {
			$this->data['status'] = $customer_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		if (isset($this->request->post['approved'])) {
			$this->data['approved'] = $this->request->post['approved'];
		} elseif (!empty($customer_info)) {
			$this->data['approved'] = $customer_info['approved'];
		} else {
			$this->data['approved'] = true;
		}

		$this->data['is_required'] = isset($this->request->get['customer_id']) ? 'advised' : 'required';

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}

		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries(0);

		if (isset($this->request->post['address'])) {
			$this->data['addresses'] = $this->request->post['address'];
		} elseif (isset($this->request->get['customer_id'])) {
			$this->data['addresses'] = $this->model_sale_customer->getAddresses($this->request->get['customer_id']);
		} else {
			$this->data['addresses'] = array();
		}

		if (isset($this->request->post['address_id'])) {
			$this->data['address_id'] = $this->request->post['address_id'];
		} elseif (!empty($customer_info)) {
			$this->data['address_id'] = $customer_info['address_id'];
		} else {
			$this->data['address_id'] = '';
		}

		$this->data['ips'] = array();

		if (!empty($customer_info)) {
			$results = $this->model_sale_customer->getIpsByCustomerId($this->request->get['customer_id']);

			foreach ($results as $result) {
				$ban_ip_total = $this->model_sale_customer->getTotalBanIpsByIp($result['ip']);

				$this->data['ips'][] = array(
					'ip'         => $result['ip'],
					'date_added' => date($this->language->get('date_format_time'), strtotime($result['date_added'])),
					'total'      => $this->model_sale_customer->getTotalCustomersByIp($result['ip']),
					'blocked_ip' => $this->model_sale_customer->isBlockedIp($result['ip']) ? '<span class="disabled">' . $this->language->get('text_blocked_ip') . '</span>' : '<span class="enabled">' . $this->language->get('text_allowed_ip') . '</span>',
					'filter_ip'  => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_ip=' . $result['ip'] . $url, 'SSL'),
					'ban_ip'     => $ban_ip_total
				);
			}
		}

		$this->template = 'sale/customer_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		$customer_info = $this->model_sale_customer->getCustomerByEmail($this->request->post['email']);

		if (!isset($this->request->get['customer_id'])) {
			if ($customer_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($customer_info && ($this->request->get['customer_id'] != $customer_info['customer_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if ($this->config->get('config_customer_dob')) {
			if (isset($this->request->post['date_of_birth']) && (utf8_strlen($this->request->post['date_of_birth']) == 10)) {
				if ($this->request->post['date_of_birth'] != date('Y-m-d', strtotime($this->request->post['date_of_birth']))) {
					$this->error['date_of_birth'] = $this->language->get('error_date_of_birth');
				}
			} else {
				$this->error['date_of_birth'] = $this->language->get('error_date_of_birth');
			}
		}

		if (!empty($this->request->post['password']) || (!isset($this->request->get['customer_id']))) {
			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$this->error['password'] = $this->language->get('error_password');
			}

			if ($this->request->post['password'] != $this->request->post['confirm']) {
				$this->error['confirm'] = $this->language->get('error_confirm');
			}
		}

		if (isset($this->request->post['address'])) {
			foreach ($this->request->post['address'] as $key => $value) {
				if ((utf8_strlen($value['firstname']) < 1) || (utf8_strlen($value['firstname']) > 32)) {
					$this->error['address_firstname'][$key] = $this->language->get('error_firstname');
				}

				if ((utf8_strlen($value['lastname']) < 1) || (utf8_strlen($value['lastname']) > 32)) {
					$this->error['address_lastname'][$key] = $this->language->get('error_lastname');
				}

				if ((utf8_strlen($value['address_1']) < 3) || (utf8_strlen($value['address_1']) > 128)) {
					$this->error['address_address_1'][$key] = $this->language->get('error_address_1');
				}

				if ((utf8_strlen($value['city']) < 2) || (utf8_strlen($value['city']) > 128)) {
					$this->error['address_city'][$key] = $this->language->get('error_city');
				}

				$this->load->model('localisation/country');

				$country_info = $this->model_localisation_country->getCountry($value['country_id']);

				if ($country_info) {
					if ($country_info['postcode_required'] && (utf8_strlen($value['postcode']) < 2) || (utf8_strlen($value['postcode']) > 10)) {
						$this->error['address_postcode'][$key] = $this->language->get('error_postcode');
					}

					// VAT Validation
					$this->load->model('sale/customer_group');

					if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
						$customer_group_id = $this->request->post['customer_group_id'];
					} else {
						$customer_group_id = $this->config->get('config_customer_group_id');
					}

					$customer_group = $this->model_sale_customer_group->getCustomerGroup($customer_group_id);

					if ($customer_group && $customer_group['tax_id_display']) {
						$this->load->helper('vat');

						if ($this->config->get('config_vat') && $value['tax_id'] != '' && (vat_validation($country_info['iso_code_2'], $value['tax_id']) == 'invalid')) {
							$this->error['address_tax_id'][$key] = $this->language->get('error_vat');
						}
					}
				}

				if (!isset($value['country_id']) || $value['country_id'] == '' || !is_numeric($value['country_id'])) {
					$this->error['address_country'][$key] = $this->language->get('error_country');
				}

				if (!isset($value['zone_id']) || $value['zone_id'] == '' || !is_numeric($value['zone_id'])) {
					$this->error['address_zone'][$key] = $this->language->get('error_zone');
				}
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	protected function validateApprove() {
		if (!$this->user->hasPermission('modify', 'sale/customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	public function login() {
		if (isset($this->request->get['customer_id'])) {
			$customer_id = $this->request->get['customer_id'];
		} else {
			$customer_id = 0;
		}

		$this->load->model('sale/customer');

		$customer_info = $this->model_sale_customer->getCustomer($customer_id);

		if ($customer_info) {
			$token = hash_rand('md5');

			$this->model_sale_customer->editToken($customer_id, $token);

			if (isset($this->request->get['store_id'])) {
				$store_id = $this->request->get['store_id'];
			} else {
				$store_id = 0;
			}

			$this->load->model('setting/store');

			$store_info = $this->model_setting_store->getStore($store_id);

			if ($store_info) {
				$this->redirect(($this->config->get('config_secure') ? $store_info['ssl'] : $store_info['url']) . 'index.php?route=account/login&token=' . $token);
			} else {
				$this->redirect(($this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG) . 'index.php?route=account/login&token=' . $token);
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

			$this->response->setOutput($this->render());
		}
	}

	public function history() {
		$this->language->load('sale/customer');

		$this->load->model('sale/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sale/customer')) {
			$this->model_sale_customer->addHistory($this->request->get['customer_id'], $this->request->post['comment']);

			$this->data['success'] = $this->language->get('text_success');
		} else {
			$this->data['success'] = '';
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sale/customer')) {
			$this->data['error_warning'] = $this->language->get('error_permission');
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_comment'] = $this->language->get('column_comment');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['histories'] = array();

		$results = $this->model_sale_customer->getHistories($this->request->get['customer_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$this->data['histories'][] = array(
				'comment'    => $result['comment'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$transaction_total = $this->model_sale_customer->getTotalHistories($this->request->get['customer_id']);

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer/history', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'sale/customer_history.tpl';

		$this->response->setOutput($this->render());
	}

	public function purchase() {
		$this->language->load('sale/customer');

		$this->load->model('sale/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sale/customer')) {
			$this->data['error_warning'] = $this->language->get('error_permission');
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->request->get['customer_id'])) {
			$customer_id = $this->request->get['customer_id'];
		} else {
			$customer_id = 0;
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

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['purchases'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$purchase_total = $this->model_sale_customer->getTotalCustomerPurchasedProducts($customer_id, $data);

		$results = $this->model_sale_customer->getCustomerPurchasedProducts($customer_id, $data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			);

			$this->data['purchases'][] = array(
				'order_id'     => $result['order_id'],
				'date_added'   => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'product_id'   => $result['product_id'],
				'product_href' => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], 'SSL'),
				'name'         => $result['name'],
				'model'        => $result['model'],
				'price'        => $this->currency->format(($result['price'] + $result['tax']), $result['currency_code'], $result['currency_value']),
				'quantity'     => $result['quantity'],
				'total'        => $this->currency->format(($result['total'] + ($result['tax'] * $result['quantity'])), $result['currency_code'], $result['currency_value']),
				'selected'     => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
				'action'       => $action
			);
		}

		$this->data['text_no_purchases'] = $this->language->get('text_no_purchases');

		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_total_price'] = $this->language->get('column_total_price');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['token'] = $this->session->data['token'];

		$this->data['customer_id'] = $customer_id;

		$pagination = new Pagination();
		$pagination->total = $purchase_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/customer_purchase.tpl';

		$this->response->setOutput($this->render());
	}

	public function transactions() {
		$this->language->load('sale/customer');

		$this->load->model('sale/customer');

		$this->listTransactions();
	}

	public function add_transaction() {
		$this->language->load('sale/customer');

		$this->load->model('sale/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateAddTransaction()) {
			$this->model_sale_customer->addTransaction($this->request->get['customer_id'], $this->request->post['description'], $this->request->post['amount']);

			$this->error['success'] = $this->language->get('text_transaction_added');
		}

		$this->listTransactions();
	}

	public function delete_transaction() {
		$this->language->load('sale/customer');

		$this->load->model('sale/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateDeleteTransaction()) {
			$this->model_sale_customer->deleteTransactionById($this->request->post['customer_transaction_id']);

			$this->error['success'] = $this->language->get('text_transaction_removed');
		}

		$this->listTransactions();
	}

	protected function listTransactions() {
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_balance'] = $this->language->get('text_balance');

		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_description'] = $this->language->get('column_description');
		$this->data['column_amount'] = $this->language->get('column_amount');

		$this->data['button_delete'] = $this->language->get('button_delete');

		// Errors
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['success'])) {
			$this->data['success'] = $this->error['success'];
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['transactions'] = array();

		$results = $this->model_sale_customer->getTransactions($this->request->get['customer_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$this->data['transactions'][] = array(
				'customer_transaction_id' => $result['customer_transaction_id'],
				'description'             => $result['description'],
				'amount'                  => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'date_added'              => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$this->data['balance'] = $this->currency->format($this->model_sale_customer->getTransactionTotal($this->request->get['customer_id']), $this->config->get('config_currency'));

		$transaction_total = $this->model_sale_customer->getTotalTransactions($this->request->get['customer_id']);

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer/transactions', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'sale/customer_transaction.tpl';

		$this->response->setOutput($this->render());
	}

	protected function validateAddTransaction() {
		if (!$this->user->hasPermission('modify', 'sale/customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->get['customer_id']) {
			$this->error['warning'] = $this->language->get('error_action');
		}

 		if (!$this->request->post['amount']) {
			$this->error['warning'] = $this->language->get('error_amount');
		}

		return empty($this->error);
	}

	protected function validateDeleteTransaction() {
		if (!$this->user->hasPermission('modify', 'sale/customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->get['customer_id']) {
			$this->error['warning'] = $this->language->get('error_action');
		}

		return empty($this->error);
	}

	public function rewards() {
		$this->language->load('sale/customer');

		$this->load->model('sale/customer');

		$this->listRewards();
	}

	public function add_reward() {
		$this->language->load('sale/customer');

		$this->load->model('sale/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateAddReward()) {
			$this->model_sale_customer->addReward($this->request->get['customer_id'], $this->request->post['description'], $this->request->post['points']);

			$this->error['success'] = $this->language->get('text_reward_added');
		}

		$this->listRewards();
	}

	public function delete_reward() {
		$this->language->load('sale/customer');

		$this->load->model('sale/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateDeleteReward()) {
			$this->model_sale_customer->deleteRewardById($this->request->post['customer_reward_id']);

			$this->error['success'] = $this->language->get('text_reward_removed');
		}

		$this->listRewards();
	}

	protected function listRewards() {
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_balance'] = $this->language->get('text_balance');

		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_description'] = $this->language->get('column_description');
		$this->data['column_points'] = $this->language->get('column_points');

		$this->data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['success'])) {
			$this->data['success'] = $this->error['success'];
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['rewards'] = array();

		$results = $this->model_sale_customer->getRewards($this->request->get['customer_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$this->data['rewards'][] = array(
				'customer_reward_id' => $result['customer_reward_id'],
				'description'        => $result['description'],
				'points'             => $result['points'],
				'date_added'         => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$this->data['balance'] = $this->currency->format($this->model_sale_customer->getRewardTotal($this->request->get['customer_id']), $this->config->get('config_currency'));

		$reward_total = $this->model_sale_customer->getTotalRewards($this->request->get['customer_id']);

		$pagination = new Pagination();
		$pagination->total = $reward_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer/rewards', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'sale/customer_reward.tpl';

		$this->response->setOutput($this->render());
	}

	protected function validateAddReward() {
		if (!$this->user->hasPermission('modify', 'sale/customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->get['customer_id']) {
			$this->error['warning'] = $this->language->get('error_action');
		}

 		if (!$this->request->post['points']) {
			$this->error['warning'] = $this->language->get('error_points');
		}

		return empty($this->error);
	}

	protected function validateDeleteReward() {
		if (!$this->user->hasPermission('modify', 'sale/customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->get['customer_id']) {
			$this->error['warning'] = $this->language->get('error_action');
		}

		return empty($this->error);
	}

	public function addBanIP() {
		$json = array();

		$this->language->load('sale/customer');

		if (isset($this->request->post['ip'])) {
			if (!$this->user->hasPermission('modify', 'sale/customer')) {
				$json['error'] = $this->language->get('error_permission');

			} else {
				$this->load->model('sale/customer');

				$this->model_sale_customer->addBanIP($this->request->post['ip']);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeBanIP() {
		$json = array();

		$this->language->load('sale/customer');

		if (isset($this->request->post['ip'])) {
			if (!$this->user->hasPermission('modify', 'sale/customer')) {
				$json['error'] = $this->language->get('error_permission');

			} else {
				$this->load->model('sale/customer');

				$this->model_sale_customer->removeBanIP($this->request->post['ip']);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('sale/customer');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_sale_customer->getCustomers($data);

			foreach ($results as $result) {
				$json[] = array(
					'customer_id'       => $result['customer_id'],
					'customer_group_id' => $result['customer_group_id'],
					'name'              => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'customer_group'    => $result['customer_group'],
					'firstname'         => $result['firstname'],
					'lastname'          => $result['lastname'],
					'email'             => $result['email'],
					'telephone'         => $result['telephone'],
					'fax'               => $result['fax'],
					'address'           => $this->model_sale_customer->getAddresses($result['customer_id'])
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function address() {
		$json = array();

		if (!empty($this->request->get['address_id'])) {
			$this->load->model('sale/customer');

			$json = $this->model_sale_customer->getAddress($this->request->get['address_id']);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
