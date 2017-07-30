<?php
class ControllerModuleFilter extends Controller {
	private $_name = 'filter';

	protected function index($setting) {
		if (isset($this->request->get['path']) && !is_array($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		$category_id = end($parts);

		$this->load->model('catalog/category');

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			$this->language->load('module/' . $this->_name);

			$this->data['heading_title'] = $this->language->get('heading_title');

			// Module
			$this->data['theme'] = $this->config->get($this->_name . '_theme');
			$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

			if (!$this->data['title']) {
				$this->data['title'] = $this->data['heading_title'];
			}

			$this->data['button_filter'] = $this->language->get('button_filter');

			// Filters
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['action'] = str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url, 'SSL'));

			if (isset($this->request->get['filter'])) {
				$this->data['filter_category'] = explode(',', $this->request->get['filter']);
			} else {
				$this->data['filter_category'] = array();
			}

			$this->load->model('catalog/product');

			$this->data['filter_groups'] = array();

			$filter_groups = $this->model_catalog_category->getCategoryFilters($category_id);

			if ($filter_groups) {
				foreach ($filter_groups as $filter_group) {
					$filter_data = array();

					foreach ($filter_group['filter'] as $filter) {
						$data = array(
							'filter_category_id' => $category_id,
							'filter_filter'      => $filter['filter_id']
						);

						$filter_data[] = array(
							'filter_id' => $filter['filter_id'],
							'name'      => $filter['name'] . ($this->config->get('config_product_count')) ? ' (' . $this->model_catalog_product->getTotalProducts($data) . ')' : ''
						);
					}

					$this->data['filter_groups'][] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'filter'          => $filter_data
					);
				}

				// Template
				$this->data['template'] = $this->config->get('config_template');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
				} else {
					$this->template = 'default/template/module/' . $this->_name . '.tpl';
				}

				$this->render();
			}
		}
  	}
}
