<?php
class ControllerAffiliateProduct extends Controller {
	private $error = array();

	public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/account', '', 'SSL');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		if (!$this->affiliate->isSecure()) {
			$this->affiliate->logout();

			$this->session->data['redirect'] = $this->url->link('affiliate/account', '', 'SSL');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->language->load('affiliate/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('affiliate/affiliate');

		$this->getList();
	}

	public function insert() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/account', '', 'SSL');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->language->load('affiliate/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('affiliate/affiliate');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!isset($this->request->get['affiliate_token']) || !isset($this->session->data['affiliate_token']) || $this->request->get['affiliate_token'] != $this->session->data['affiliate_token']) {
				$this->affiliate->logout();

				$this->session->data['redirect'] = $this->url->link('affiliate/product', '', 'SSL');

				$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
			}

			$this->affiliate->setToken();

			if ($this->validateForm()) {
				$this->model_affiliate_affiliate->addAffiliateProduct($this->request->post);

				$this->session->data['success'] = $this->language->get('text_insert');

				$this->redirect($this->url->link('affiliate/product', '', 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/account', '', 'SSL');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->language->load('affiliate/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('affiliate/affiliate');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!isset($this->request->get['affiliate_token']) || !isset($this->session->data['affiliate_token']) || $this->request->get['affiliate_token'] != $this->session->data['affiliate_token']) {
				$this->affiliate->logout();

				$this->session->data['redirect'] = $this->url->link('affiliate/product', '', 'SSL');

				$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
			}

			$this->affiliate->setToken();

			if ($this->validateForm()) {
				$this->model_affiliate_affiliate->editAffiliateProduct($this->request->get['affiliate_product_id'], $this->request->post);

				$this->session->data['success'] = $this->language->get('text_update');

				$this->redirect($this->url->link('affiliate/product', '', 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/account', '', 'SSL');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->language->load('affiliate/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('affiliate/affiliate');

		if (isset($this->request->get['affiliate_product_id'])) {
			if (!isset($this->request->get['affiliate_token']) || !isset($this->session->data['affiliate_token']) || $this->request->get['affiliate_token'] != $this->session->data['affiliate_token']) {
				$this->affiliate->logout();

				$this->session->data['redirect'] = $this->url->link('affiliate/product', '', 'SSL');

				$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
			}

			$this->affiliate->setToken();

			$this->model_affiliate_affiliate->deleteAffiliateProduct($this->request->get['affiliate_product_id']);

			$this->session->data['success'] = $this->language->get('text_delete');

			$this->redirect($this->url->link('affiliate/product', '', 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('affiliate/affiliate', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('affiliate/product', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_portfolio'] = $this->language->get('text_portfolio');
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['button_new_product'] = $this->language->get('button_new_product');
		$this->data['button_edit'] = $this->language->get('button_edit');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_back'] = $this->language->get('button_back');

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

		$this->data['products'] = array();

		$results = $this->model_affiliate_affiliate->getAffiliateProducts($this->affiliate->getId());

		foreach ($results as $result) {
			$this->data['products'][] = array(
				'affiliate_product_id' => $result['affiliate_product_id'],
				'product_id'           => $result['product_id'],
				'name'                 => $result['name'],
				'code'                 => $result['code'],
				'date_added'           => $result['date_added'],
				'update'               => $this->url->link('affiliate/product/update', 'affiliate_product_id=' . $result['affiliate_product_id'] . '&affiliate_token=' . $this->session->data['affiliate_token'], 'SSL'),
				'delete'               => $this->url->link('affiliate/product/delete', 'affiliate_product_id=' . $result['affiliate_product_id'] . '&affiliate_token=' . $this->session->data['affiliate_token'], 'SSL')
			);
		}

		$this->data['insert'] = $this->url->link('affiliate/product/insert', '', 'SSL');
		$this->data['back'] = $this->url->link('affiliate/account', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/product_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/product_list.tpl';
		} else {
			$this->template = 'default/template/affiliate/product_list.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_header',
			'common/content_top',
			'common/content_bottom',
			'common/content_footer',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('affiliate/affiliate', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('affiliate/product', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		if (!isset($this->request->get['affiliate_product_id'])) {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_edit_product'),
				'href'      => $this->url->link('affiliate/product/insert', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

		} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_edit_product'),
				'href'      => $this->url->link('affiliate/product/update', 'affiliate_product_id=' . $this->request->get['affiliate_product_id'], 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_edit_product'] = $this->language->get('text_edit_product');

		$this->data['entry_product'] = $this->language->get('entry_product');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['product'])) {
			$this->data['error_product'] = $this->error['product'];
		} else {
			$this->data['error_product'] = '';
		}

		if (!isset($this->request->get['affiliate_product_id'])) {
			$this->data['action'] = $this->url->link('affiliate/product/insert', 'affiliate_token=' . $this->session->data['affiliate_token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('affiliate/product/update', 'affiliate_product_id=' . $this->request->get['affiliate_product_id'] . '&affiliate_token=' . $this->session->data['affiliate_token'], 'SSL');
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['affiliate_product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$product_info = $this->model_affiliate_affiliate->getAffiliateProduct($this->request->get['affiliate_product_id']);
		}

		if (isset($this->request->post['product_id'])) {
			$this->data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($product_info)) {
			$this->data['product_id'] = $product_info['product_id'];
		} else {
			$this->data['product_id'] = '';
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($product_info)) {
			$this->data['name'] = $product_info['name'];
		} else {
			$this->data['name'] = '';
		}

		$this->data['back'] = $this->url->link('affiliate/product', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/product_form.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/product_form.tpl';
		} else {
			$this->template = 'default/template/affiliate/product_form.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_header',
			'common/content_top',
			'common/content_bottom',
			'common/content_footer',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!isset($this->request->post['product_id']) || $this->request->post['product_id'] == '' || !is_numeric($this->request->post['product_id'])) {
			$this->error['product'] = $this->language->get('error_product');
		}

		return empty($this->error);
	}

	public function autocomplete() {
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
