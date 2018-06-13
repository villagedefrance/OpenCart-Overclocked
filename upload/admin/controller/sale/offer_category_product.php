<?php
class ControllerSaleOfferCategoryProduct extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('sale/offer_category_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/offer_category_product');

		$this->getList();
	}

	public function insert() {
		$this->language->load('sale/offer_category_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/offer_category_product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_offer_category_product->addOfferCategoryProduct($this->request->post);

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
				$offer_category_product_id = $this->session->data['new_offer_category_product_id'];

				if ($offer_category_product_id) {
					unset($this->session->data['new_offer_category_product_id']);

					$this->redirect($this->url->link('sale/offer_category_product/update', 'token=' . $this->session->data['token'] . '&offer_category_product_id=' . $offer_category_product_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('sale/offer_category_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/offer_category_product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_offer_category_product->editOfferCategoryProduct($this->request->get['offer_category_product_id'], $this->request->post);

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
				$offer_category_product_id = $this->request->get['offer_category_product_id'];

				if ($offer_category_product_id) {
					$this->redirect($this->url->link('sale/offer_category_product/update', 'token=' . $this->session->data['token'] . '&offer_category_product_id=' . $offer_category_product_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('sale/offer_category_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/offer_category_product');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $offer_category_product_id) {
				$this->model_sale_offer_category_product->deleteOfferCategoryProduct($offer_category_product_id);
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

			$this->redirect($this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href'      => $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('sale/offer_category_product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/offer_category_product/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['offer_category_products'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$offer_category_product_total = $this->model_sale_offer_category_product->getTotalOfferCategoryProduct();

		$results = $this->model_sale_offer_category_product->getOfferCategoryProducts($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/offer_category_product/update', 'token=' . $this->session->data['token'] . '&offer_category_product_id=' . $result['offer_category_product_id'] . $url, 'SSL')
			);

			$this->data['offer_category_products'][] = array(
				'offer_category_product_id' => $result['offer_category_product_id'],
				'name'                      => $result['name'],
				'discount'                  => $result['discount'],
				'type'                      => $result['type'],
				'logged'                    => $result['logged'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'date_start'                => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
				'date_end'                  => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
				'status'                    => $result['status'],
				'selected'                  => isset($this->request->post['selected']) && in_array($result['offer_category_product_id'], $this->request->post['selected']),
				'action'                    => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_discount'] = $this->language->get('column_discount');
		$this->data['column_type'] = $this->language->get('column_type');
		$this->data['column_logged'] = $this->language->get('column_logged');
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_dashboard'] = $this->language->get('button_dashboard');

		$this->data['dashboard'] = $this->url->link('sale/offer', 'token=' . $this->session->data['token'], 'SSL');

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

		$this->data['sort_name'] = $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_discount'] = $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . '&sort=discount' . $url, 'SSL');
		$this->data['sort_type'] = $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . '&sort=type' . $url, 'SSL');
		$this->data['sort_logged'] = $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . '&sort=logged' . $url, 'SSL');
		$this->data['sort_date_start'] = $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . '&sort=date_start' . $url, 'SSL');
		$this->data['sort_date_end'] = $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . '&sort=date_end' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $offer_category_product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/offer_category_product_list.tpl';
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
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_fixed'] = $this->language->get('text_fixed');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_autocomplete'] = $this->language->get('text_autocomplete');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_discount'] = $this->language->get('entry_discount');
		$this->data['entry_logged'] = $this->language->get('entry_logged');
		$this->data['entry_category_one'] = $this->language->get('entry_category_one');
		$this->data['entry_product_two'] = $this->language->get('entry_product_two');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];

		// Call jQuery Migrate 1.4.1 for compatibility
		$this->document->addScript('view/javascript/jquery/jquery-migrate-1.4.1.min.js');

		if (isset($this->request->get['offer_category_product_id'])) {
			$this->data['offer_category_product_id'] = $this->request->get['offer_category_product_id'];
		} else {
			$this->data['offer_category_product_id'] = 0;
		}

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

		if (isset($this->error['percent'])) {
			$this->data['error_percent'] = $this->error['percent'];
		} else {
			$this->data['error_percent'] = '';
		}

		if (isset($this->error['price'])) {
			$this->data['error_price'] = $this->error['price'];
		} else {
			$this->data['error_price'] = '';
		}

		if (isset($this->error['category'])) {
			$this->data['error_category'] = $this->error['category'];
		} else {
			$this->data['error_category'] = '';
		}

		if (isset($this->error['product'])) {
			$this->data['error_product'] = $this->error['product'];
		} else {
			$this->data['error_product'] = '';
		}

		if (isset($this->error['date_start'])) {
			$this->data['error_date_start'] = $this->error['date_start'];
		} else {
			$this->data['error_date_start'] = '';
		}

		if (isset($this->error['date_end'])) {
			$this->data['error_date_end'] = $this->error['date_end'];
		} else {
			$this->data['error_date_end'] = '';
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['offer_category_product_id'])) {
			$this->data['action'] = $this->url->link('sale/offer_category_product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/offer_category_product/update', 'token=' . $this->session->data['token'] . '&offer_category_product_id=' . $this->request->get['offer_category_product_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Auto-complete
		$this->data['autocomplete_off'] = $this->config->get('config_autocomplete_offer');

		if (isset($this->request->get['offer_category_product_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
			$offer_category_product_info = $this->model_sale_offer_category_product->getOfferCategoryProduct($this->request->get['offer_category_product_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($offer_category_product_info)) {
			$this->data['name'] = $offer_category_product_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['type'])) {
			$this->data['type'] = $this->request->post['type'];
		} elseif (!empty($offer_category_product_info)) {
			$this->data['type'] = $offer_category_product_info['type'];
		} else {
			$this->data['type'] = '';
		}

		if (isset($this->request->post['discount'])) {
			$this->data['discount'] = $this->request->post['discount'];
		} elseif (!empty($offer_category_product_info)) {
			$this->data['discount'] = $offer_category_product_info['discount'];
		} else {
			$this->data['discount'] = '';
		}

		if (isset($this->request->post['logged'])) {
			$this->data['logged'] = $this->request->post['logged'];
		} elseif (!empty($offer_category_product_info)) {
			$this->data['logged'] = $offer_category_product_info['logged'];
		} else {
			$this->data['logged'] = '';
		}

		$this->load->model('catalog/category');

		$this->data['categories'] = $this->model_catalog_category->getCategories(0);

		// Category One
		if (isset($this->request->post['category_one'])) {
			$this->data['category_one'] = $this->request->post['category_one'];
			$this->data['category_one_name'] = $this->language->get('text_none');
		} elseif (!empty($offer_category_product_info)) {
			$this->data['category_one'] = $offer_category_product_info['category_one'];
			$this->data['category_one_name'] = $this->model_catalog_category->getCategoryName($offer_category_product_info['category_one']);
		} else {
			$this->data['category_one'] = 0;
			$this->data['category_one_name'] = '';
		}

		$this->load->model('catalog/product');

		$this->data['products'] = $this->model_catalog_product->getProducts(0);

		// Product Two
		if (isset($this->request->post['product_two'])) {
			$this->data['product_two'] = $this->request->post['product_two'];
			$this->data['product_two_name'] = $this->language->get('text_none');
		} elseif (!empty($offer_category_product_info)) {
			$this->data['product_two'] = $offer_category_product_info['product_two'];
			$this->data['product_two_name'] = $this->model_catalog_product->getProductName($offer_category_product_info['product_two']);
		} else {
			$this->data['product_two'] = 0;
			$this->data['product_two_name'] = '';
		}

		if (isset($this->request->post['date_start'])) {
			$this->data['date_start'] = $this->request->post['date_start'];
		} elseif (!empty($offer_category_product_info)) {
			$this->data['date_start'] = date('Y-m-d', strtotime($offer_category_product_info['date_start']));
		} else {
			$this->data['date_start'] = date('Y-m-d', time());
		}

		if (isset($this->request->post['date_end'])) {
			$this->data['date_end'] = $this->request->post['date_end'];
		} elseif (!empty($offer_category_product_info)) {
			$this->data['date_end'] = date('Y-m-d', strtotime($offer_category_product_info['date_end']));
		} else {
			$this->data['date_end'] = date('Y-m-d', time());
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($offer_category_product_info)) {
			$this->data['status'] = $offer_category_product_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		$this->template = 'sale/offer_category_product_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/offer_category_product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (($this->request->post['type'] == 'P') && ($this->request->post['discount'] > '100')) {
			$this->error['percent'] = $this->language->get('error_percent');
		}

		$this->load->model('sale/offer');

		$product_price = $this->model_sale_offer->getProductPrice($this->request->post['product_two']);

		if (($this->request->post['type'] == 'F') && ($this->request->post['discount'] > $product_price)) {
			$this->error['price'] = $this->language->get('error_price');

			$this->data['gross_price'] = $product_price;
		}

		if (empty($this->request->post['category_one']) || !is_numeric($this->request->post['category_one'])) {
			$this->error['category'] = $this->language->get('error_category');
		}

		if (empty($this->request->post['product_two']) || !is_numeric($this->request->post['product_two'])) {
			$this->error['product'] = $this->language->get('error_product');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/offer_category_product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	public function autocompleteCat() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_category->getListCategories($data);

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
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

	public function autocompletePro() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/product');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_product->getProducts($data);

			foreach ($results as $result) {
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
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
}
