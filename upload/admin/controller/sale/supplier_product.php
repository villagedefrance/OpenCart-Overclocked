<?php
class ControllerSaleSupplierProduct extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('sale/supplier_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_product');

		$this->getList();
	}

	public function insert() {
		$this->language->load('sale/supplier_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_supplier_product->addSupplierProduct($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_supplier'])) {
				$url .= '&filter_supplier=' . urlencode(html_entity_decode($this->request->get['filter_supplier'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
				$supplier_product_id = $this->session->data['new_supplier_product_id'];

				if ($supplier_product_id) {
					unset($this->session->data['new_supplier_product_id']);

					$this->redirect($this->url->link('sale/supplier_product/update', 'token=' . $this->session->data['token'] . '&supplier_product_id=' . $supplier_product_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('sale/supplier_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_supplier_product->editSupplierProduct($this->request->get['supplier_product_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_supplier'])) {
				$url .= '&filter_supplier=' . urlencode(html_entity_decode($this->request->get['filter_supplier'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
				$supplier_product_id = $this->request->get['supplier_product_id'];

				if ($supplier_product_id) {
					$this->redirect($this->url->link('sale/supplier_product/update', 'token=' . $this->session->data['token'] . '&supplier_product_id=' . $supplier_product_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('sale/supplier_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_product');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $supplier_product_id) {
				$this->model_sale_supplier_product->deleteSupplierProduct($supplier_product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_supplier'])) {
				$url .= '&filter_supplier=' . urlencode(html_entity_decode($this->request->get['filter_supplier'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->redirect($this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function copy() {
		$this->language->load('sale/supplier_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_product');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $supplier_product_id) {
				$this->model_sale_supplier_product->copyProduct($supplier_product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_supplier'])) {
				$url .= '&filter_supplier=' . urlencode(html_entity_decode($this->request->get['filter_supplier'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->redirect($this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_supplier'])) {
			$filter_supplier = $this->request->get['filter_supplier'];
		} else {
			$filter_supplier = null;
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
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

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_supplier'])) {
			$url .= '&filter_supplier=' . urlencode(html_entity_decode($this->request->get['filter_supplier'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			'href'      => $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['enabled'] = $this->url->link('sale/supplier_product/enable', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['disabled'] = $this->url->link('sale/supplier_product/disable', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert'] = $this->url->link('sale/supplier_product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy'] = $this->url->link('sale/supplier_product/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/supplier_product/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['refresh'] = $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['supplier_products'] = array();

		$data = array(
			'filter_name'     => $filter_name,
			'filter_model'    => $filter_model,
			'filter_supplier' => $filter_supplier,
			'filter_price'    => $filter_price,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);

		$this->load->model('tool/image');
		$this->load->model('tool/barcode');

		$admin_barcode = $this->config->get('config_admin_barcode');
		$barcode_type = $this->config->get('config_barcode_type');

		$supplier_product_total = $this->model_sale_supplier_product->getTotalSupplierProducts($data);

		$results = $this->model_sale_supplier_product->getSupplierProducts($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/supplier_product/update', 'token=' . $this->session->data['token'] . '&supplier_product_id=' . $result['supplier_product_id'] . $url, 'SSL')
			);

			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

			if ($result['supplier_id']) {
				$supplier = $this->model_sale_supplier_product->getSupplierNameBySupplierId($result['supplier_id']);
			} else {
				$supplier = false;
			}

			$this->data['supplier_products'][] = array(
				'supplier_product_id' => $result['supplier_product_id'],
				'image'               => $image,
				'name'                => $result['name'],
				'barcode'             => ($admin_barcode) ? $this->model_tool_barcode->getBarcode($result['model'], strtoupper($barcode_type), 1, 20) : '',
				'model'               => $result['model'],
				'supplier'            => ($supplier) ? $supplier : '',
				'price'               => $result['price'],
				'status'              => $result['status'],
				'selected'            => isset($this->request->post['selected']) && in_array($result['supplier_product_id'], $this->request->post['selected']),
				'action'              => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_price_title'] = $this->language->get('text_price_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_id'] = $this->language->get('column_id');
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_supplier'] = $this->language->get('column_supplier');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_enable'] = $this->language->get('button_enable');
        $this->data['button_disable'] = $this->language->get('button_disable');
		$this->data['button_copy'] = $this->language->get('button_copy');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_update_price'] = $this->language->get('button_update_price');
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

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_supplier'])) {
			$url .= '&filter_supplier=' . urlencode(html_entity_decode($this->request->get['filter_supplier'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . '&sort=sp.name' . $url, 'SSL');
		$this->data['sort_model'] = $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . '&sort=sp.model' . $url, 'SSL');
		$this->data['sort_supplier'] = $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . '&sort=s.company' . $url, 'SSL');
		$this->data['sort_price'] = $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . '&sort=sp.price' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . '&sort=sp.status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_supplier'])) {
			$url .= '&filter_supplier=' . urlencode(html_entity_decode($this->request->get['filter_supplier'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $supplier_product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_model'] = $filter_model;
		$this->data['filter_supplier'] = $filter_supplier;
		$this->data['filter_price'] = $filter_price;
		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/supplier_product_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_dimension'] = $this->language->get('heading_dimension');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_autocomplete'] = $this->language->get('text_autocomplete');

		$this->data['column_text'] = $this->language->get('column_text');
		$this->data['column_weight'] = $this->language->get('column_weight');
		$this->data['column_supplier_group'] = $this->language->get('column_supplier_group');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_status'] = $this->language->get('column_status');

		$this->data['entry_supplier'] = $this->language->get('entry_supplier');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_unit'] = $this->language->get('entry_unit');
		$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_color'] = $this->language->get('entry_color');
		$this->data['entry_size'] = $this->language->get('entry_size');
		$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_dimension'] = $this->language->get('entry_dimension');
		$this->data['entry_length'] = $this->language->get('entry_length');
		$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$this->data['entry_weight'] = $this->language->get('entry_weight');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_new_supplier'] = $this->language->get('button_new_supplier');
		$this->data['button_new_manufacturer'] = $this->language->get('button_new_manufacturer');

		$this->data['token'] = $this->session->data['token'];

		// Call jQuery Migrate 1.4.1 for compatibility
		$this->document->addScript('view/javascript/jquery/jquery-migrate-1.4.1.min.js');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['supplier_id'])) {
			$this->data['error_supplier_id'] = $this->error['supplier_id'];
		} else {
			$this->data['error_supplier_id'] = array();
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

		if (isset($this->error['model'])) {
			$this->data['error_model'] = $this->error['model'];
		} else {
			$this->data['error_model'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_supplier'])) {
			$url .= '&filter_supplier=' . urlencode(html_entity_decode($this->request->get['filter_supplier'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		if (isset($this->request->get['supplier_product_id'])) {
			$supplier_product_name = $this->model_sale_supplier_product->getSupplierProduct($this->request->get['supplier_product_id']);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title') . ' :: ' . $supplier_product_name['name'],
				'href'      => $this->url->link('sale/supplier_product/update', 'token=' . $this->session->data['token'] . '&supplier_product_id=' . $this->request->get['supplier_product_id'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$this->data['product_title'] = $supplier_product_name['name'];
			$this->data['new_entry'] = false;

		} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$this->data['product_title'] = $this->language->get('heading_title');
			$this->data['new_entry'] = true;
		}

		if (!isset($this->request->get['supplier_product_id'])) {
			$this->data['action'] = $this->url->link('sale/supplier_product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/supplier_product/update', 'token=' . $this->session->data['token'] . '&supplier_product_id=' . $this->request->get['supplier_product_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['new_supplier'] = $this->url->link('sale/supplier/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['new_manufacturer'] = $this->url->link('catalog/manufacturer/insert', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['supplier_product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$product_info = $this->model_sale_supplier_product->getSupplierProduct($this->request->get['supplier_product_id']);
		}

		$this->load->model('sale/supplier');

		$this->data['suppliers'] = $this->model_sale_supplier->getSuppliers();

		if (isset($this->request->post['supplier_id'])) {
			$this->data['supplier_id'] = $this->request->post['supplier_id'];
		} elseif (!empty($product_info)) {
			$this->data['supplier_id'] = $product_info['supplier_id'];
		} else {
			$this->data['supplier_id'] = 0;
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($product_info)) {
			$this->data['name'] = $product_info['name'];
		} else {
			$this->data['name'] = '';
		}

		// Manufacturer
		$this->load->model('catalog/manufacturer');

		$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

		if (isset($this->request->post['manufacturer_id'])) {
			$this->data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($product_info)) {
			$this->data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
			$this->data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$this->data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($product_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);

			if ($manufacturer_info) {
				$this->data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$this->data['manufacturer'] = '';
			}

		} else {
			$this->data['manufacturer'] = '';
		}

		if (isset($this->request->post['model'])) {
			$this->data['model'] = $this->request->post['model'];
		} elseif (!empty($product_info)) {
			$this->data['model'] = $product_info['model'];
		} else {
			$this->data['model'] = '';
		}

		// Barcode
		$admin_barcode = $this->config->get('config_admin_barcode');
		$barcode_type = $this->config->get('config_barcode_type');

		if ($admin_barcode && !empty($product_info) && $product_info['model']) {
			$this->load->model('tool/barcode');

			$this->data['barcode'] = $this->model_tool_barcode->getBarcode($product_info['model'], strtoupper($barcode_type), 1.2, 24);
		} else {
			$this->data['barcode'] = '';
		}

		// Images
		$this->load->model('tool/image');

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($product_info)) {
			$this->data['image'] = $product_info['image'];
		} else {
			$this->data['image'] = '';
		}

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($product_info) && $product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['price'])) {
			$this->data['price'] = $this->request->post['price'];
		} elseif (!empty($product_info)) {
			$this->data['price'] = $product_info['price'];
		} else {
			$this->data['price'] = '';
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['tax_class_id'])) {
			$this->data['tax_class_id'] = $this->request->post['tax_class_id'];
		} elseif (!empty($product_info)) {
			$this->data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
			$this->data['tax_class_id'] = 0;
		}

		if (isset($this->request->post['unit'])) {
			$this->data['unit'] = $this->request->post['unit'];
		} elseif (!empty($product_info)) {
			$this->data['unit'] = $product_info['unit'];
		} else {
			$this->data['unit'] = 1;
		}

		if (isset($this->request->post['color'])) {
			$this->data['color'] = $this->request->post['color'];
		} elseif (!empty($product_info)) {
			$this->data['color'] = $product_info['color'];
		} else {
			$this->data['color'] = '';
		}

		if (isset($this->request->post['size'])) {
			$this->data['size'] = $this->request->post['size'];
		} elseif (!empty($product_info)) {
			$this->data['size'] = $product_info['size'];
		} else {
			$this->data['size'] = '';
		}

		if (isset($this->request->post['quantity'])) {
			$this->data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($product_info)) {
			$this->data['quantity'] = $product_info['quantity'];
		} else {
			$this->data['quantity'] = 1;
		}

		// Dimensions
		if (isset($this->request->post['length'])) {
			$this->data['length'] = $this->request->post['length'];
		} elseif (!empty($product_info)) {
			$this->data['length'] = $product_info['length'];
		} else {
			$this->data['length'] = '';
		}

		if (isset($this->request->post['width'])) {
			$this->data['width'] = $this->request->post['width'];
		} elseif (!empty($product_info)) {
			$this->data['width'] = $product_info['width'];
		} else {
			$this->data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$this->data['height'] = $this->request->post['height'];
		} elseif (!empty($product_info)) {
			$this->data['height'] = $product_info['height'];
		} else {
			$this->data['height'] = '';
		}

		$this->load->model('localisation/length_class');

		$this->data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['length_class_id'])) {
			$this->data['length_class_id'] = $this->request->post['length_class_id'];
		} elseif (!empty($product_info)) {
			$this->data['length_class_id'] = $product_info['length_class_id'];
		} else {
			$this->data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		if (isset($this->request->post['weight'])) {
			$this->data['weight'] = $this->request->post['weight'];
		} elseif (!empty($product_info)) {
			$this->data['weight'] = $product_info['weight'];
		} else {
			$this->data['weight'] = '';
		}

		$this->load->model('localisation/weight_class');

		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['weight_class_id'])) {
			$this->data['weight_class_id'] = $this->request->post['weight_class_id'];
		} elseif (!empty($product_info)) {
			$this->data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
			$this->data['weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		// Status
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($product_info)) {
			$this->data['status'] = $product_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		$this->template = 'sale/supplier_product_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function updatePrice() {
		$json = array();

		$this->language->load('sale/supplier_product');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$selected = false;
			$supplier_products = array();

			if (isset($this->request->post['px_selected'])) {
				$selected = (int)$this->request->post['px_selected'] > 0;

				if ($selected) {
					if (isset($this->request->post['selected']) && is_array($this->request->post['selected'])) {
						foreach ($this->request->post['selected'] as $supplier_product_id) {
							if ((int)$supplier_product_id > 0) {
								$supplier_products[] = (int)$supplier_product_id;
							}
						}
					}
				}
			}

			if (isset($this->request->post['px_price'])) {
				$price = $this->request->post['px_price'];
			} else {
				$price = '0.0000';
			}

			if ($this->validatePriceUpdate($selected, $supplier_products)) {
				$this->load->model('sale/supplier_product');

				$this->model_sale_supplier_product->updateSupplierProductPrice($selected, $supplier_products, $price);

				$json['success'] = $this->language->get('text_price_success');
			}

			$json['error'] = $this->error;

		} else {
			$this->data['text_select_all'] = $this->language->get('text_select_all');
			$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
			$this->data['text_selected_yes'] = $this->language->get('text_selected_yes');
			$this->data['text_selected_no'] = $this->language->get('text_selected_no');

			$this->data['entry_px_selected'] = $this->language->get('entry_px_selected');
			$this->data['entry_px_price'] = $this->language->get('entry_px_price');

			$this->data['button_update_price'] = $this->language->get('button_update_price');
			$this->data['button_submit'] = $this->language->get('button_submit');

			$this->data['token'] = $this->session->data['token'];

			$this->template = 'sale/supplier_product_price_form.tpl';

			$json['html'] = $this->render();
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/supplier_product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!isset($this->request->post['supplier_id'])) {
			$this->error['supplier_id'] = $this->language->get('error_supplier_id');
		}

		if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 255)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/supplier_product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'sale/supplier_product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	protected function validatePriceUpdate($selected, $supplier_products = array()) {
		if (!$this->user->hasPermission('modify', 'sale/supplier_product')) {
			$this->error[] = $this->language->get('error_permission');
		}

		if ($selected && empty($supplier_products)) {
			$this->error[] = $this->language->get('error_selected');
		}

		if (empty($this->request->post['px_price']) || $this->request->post['px_price'] < 0) {
			$this->error[] = $this->language->get('error_price');
		}

		return empty($this->error);
	}

	public function enable() {
		$this->language->load('sale/supplier_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_product');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $supplier_product_id) {
				$this->model_sale_supplier_product->editSupplierProductStatus($supplier_product_id, 1);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_supplier'])) {
				$url .= '&filter_supplier=' . urlencode(html_entity_decode($this->request->get['filter_supplier'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->redirect($this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function disable() {
		$this->language->load('sale/supplier_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/supplier_product');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $supplier_product_id) {
				$this->model_sale_supplier_product->editSupplierProductStatus($supplier_product_id, 0);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_supplier'])) {
				$url .= '&filter_supplier=' . urlencode(html_entity_decode($this->request->get['filter_supplier'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->redirect($this->url->link('sale/supplier_product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_supplier'])) {
			$this->load->model('sale/supplier_product');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['filter_supplier'])) {
				$filter_supplier = $this->request->get['filter_supplier'];
			} else {
				$filter_supplier = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}

			$data = array(
				'filter_name'     => $filter_name,
				'filter_model'    => $filter_model,
				'filter_supplier' => $filter_supplier,
				'start'           => 0,
				'limit'           => $limit
			);

			$results = $this->model_sale_supplier_product->getSupplierProducts($data);

			foreach ($results as $result) {
				$json[] = array(
					'supplier_product_id' => $result['supplier_product_id'],
					'supplier_id'         => $result['supplier_id'],
					'supplier'            => $this->model_sale_supplier_product->getSupplierNameBySupplierId($result['supplier_id']),
					'name'                => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'               => $result['model'],
					'unit'                => $result['unit'],
					'color'               => $result['color'],
					'size'                => $result['size'],
					'price'               => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
