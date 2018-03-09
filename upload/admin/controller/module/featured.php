<?php
class ControllerModuleFeatured extends Controller {
	private $error = array();
	private $_name = 'featured';

	public function index() {
		$this->language->load('module/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_content_header'] = $this->language->get('text_content_header');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_content_footer'] = $this->language->get('text_content_footer');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_options'] = $this->language->get('tab_options');

		$this->data['entry_theme'] = $this->language->get('entry_theme');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_product'] = $this->language->get('entry_product');

		$this->data['entry_brand'] = $this->language->get('entry_brand');
		$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['entry_reward'] = $this->language->get('entry_reward');
		$this->data['entry_point'] = $this->language->get('entry_point');
		$this->data['entry_review'] = $this->language->get('entry_review');

		$this->data['entry_viewproduct'] = $this->language->get('entry_viewproduct');
		$this->data['entry_addproduct'] = $this->language->get('entry_addproduct');

		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		// Module
		if (isset($this->request->post[$this->_name . '_theme'])) {
			$this->data[$this->_name . '_theme'] = $this->request->post[$this->_name . '_theme'];
		} else {
			$this->data[$this->_name . '_theme'] = $this->config->get($this->_name . '_theme');
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (isset($this->request->post[$this->_name . '_title' . $language['language_id']])) {
				$this->data[$this->_name . '_title' . $language['language_id']] = $this->request->post[$this->_name . '_title' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title' . $language['language_id']] = $this->config->get($this->_name . '_title' . $language['language_id']);
			}
		}

		$this->data['languages'] = $languages;

		if (isset($this->request->post[$this->_name . '_title'])) {
			$this->data[$this->_name . '_title'] = $this->request->post[$this->_name . '_title'];
		} else {
			$this->data[$this->_name . '_title'] = $this->config->get($this->_name . '_title');
		}

		if (isset($this->request->post[$this->_name . '_product'])) {
			$this->data[$this->_name . '_product'] = $this->request->post[$this->_name . '_product'];
		} else {
			$this->data[$this->_name . '_product'] = $this->config->get($this->_name . '_product');
		}

		$this->load->model('catalog/product');

		if (isset($this->request->post[$this->_name . '_product'])) {
			$products = explode(',', $this->request->post[$this->_name . '_product']);
		} else {
			$products = explode(',', $this->config->get($this->_name . '_product'));
		}

		$this->data['products'] = array();

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$this->data['products'][] = array(
					'product_id'	=> $product_info['product_id'],
					'name'       	=> $product_info['name']
				);
			}
		}

		if (isset($this->request->post[$this->_name . '_brand'])) {
			$this->data[$this->_name . '_brand'] = $this->request->post[$this->_name . '_brand'];
		} else {
			$this->data[$this->_name . '_brand'] = $this->config->get($this->_name . '_brand');
		}

		if (isset($this->request->post[$this->_name . '_model'])) {
			$this->data[$this->_name . '_model'] = $this->request->post[$this->_name . '_model'];
		} else {
			$this->data[$this->_name . '_model'] = $this->config->get($this->_name . '_model');
		}

		if (isset($this->request->post[$this->_name . '_reward'])) {
			$this->data[$this->_name . '_reward'] = $this->request->post[$this->_name . '_reward'];
		} else {
			$this->data[$this->_name . '_reward'] = $this->config->get($this->_name . '_reward');
		}

		if (isset($this->request->post[$this->_name . '_point'])) {
			$this->data[$this->_name . '_point'] = $this->request->post[$this->_name . '_point'];
		} else {
			$this->data[$this->_name . '_point'] = $this->config->get($this->_name . '_point');
		}

		if (isset($this->request->post[$this->_name . '_review'])) {
			$this->data[$this->_name . '_review'] = $this->request->post[$this->_name . '_review'];
		} else {
			$this->data[$this->_name . '_review'] = $this->config->get($this->_name . '_review');
		}

		if (isset($this->request->post[$this->_name . '_viewproduct'])) {
			$this->data[$this->_name . '_viewproduct'] = $this->request->post[$this->_name . '_viewproduct'];
		} else {
			$this->data[$this->_name . '_viewproduct'] = $this->config->get($this->_name . '_viewproduct');
		}

		if (isset($this->request->post[$this->_name . '_addproduct'])) {
			$this->data[$this->_name . '_addproduct'] = $this->request->post[$this->_name . '_addproduct'];
		} else {
			$this->data[$this->_name . '_addproduct'] = $this->config->get($this->_name . '_addproduct');
		}

		$this->data['modules'] = array();

		if (isset($this->request->post[$this->_name . '_module'])) {
			$this->data['modules'] = $this->request->post[$this->_name . '_module'];
		} elseif ($this->config->get($this->_name . '_module')) {
			$this->data['modules'] = $this->config->get($this->_name . '_module');
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post[$this->_name . '_module'])) {
			foreach ($this->request->post[$this->_name . '_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}

		return empty($this->error);
	}
}
