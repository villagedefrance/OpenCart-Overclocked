<?php
class ControllerProductCategoryList extends Controller {
	private $_name = 'category_list';

	public function index() {
		$this->language->load('product/' . $this->_name);

		$this->load->model('catalog/category');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
      	);

		$categories_list = $this->model_catalog_category->getCategories(0);

		if ($categories_list) {
			$this->document->setTitle($this->language->get('heading_title'));

			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['text_empty'] = $this->language->get('text_empty');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('product/category_list', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->load->model('catalog/product');

			$empty_category = $this->config->get('config_empty_category');

			$this->data['categories'] = array();

			$this->data['ccount'] = 0;

			foreach ($categories_list as $category_1) {
				$level_2_data = array();

				$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

				foreach ($categories_2 as $category_2) {
					$level_3_data = array();

					$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

					foreach ($categories_3 as $category_3) {
						$data = array(
							'filter_category_id'  => $category_3['category_id'],
							'filter_sub_category' => true
						);

						if (!$empty_category) {
							$product_total = $this->model_catalog_product->getTotalProducts($data);
						} else {
							$product_total = 0;
						}

						if ($empty_category || $product_total > 0) {
							$level_3_data[] = array(
								'name' => $category_3['name'],
								'href' => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id'], 'SSL')
							);
						}
					}

					$level_2_data[] = array(
						'name'     => $category_2['name'],
						'children' => $level_3_data,
						'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'], 'SSL')
					);
				}

				$this->data['categories'][] = array(
					'name'     => $category_1['name'],
					'children' => $level_2_data,
					'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'], 'SSL'),
					'count'    => $this->data['ccount']
				);

				$this->data['ccount'] = $this->data['ccount'] + 1;
			}

			$this->data['cattotal'] = $this->data['ccount'];

			$this->data['cattotal1'] = round($this->data['cattotal'] / 3);
			$this->data['cattotal2'] = $this->data['cattotal1'] * 2;

			$this->data['continue'] = $this->url->link('common/home', '', 'SSL');

			// Theme
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/' . $this->_name . '.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/' . $this->_name . '.tpl';
			} else {
				$this->template = 'default/template/product/' . $this->_name . '.tpl';
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

		} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('product/category_list', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['heading_title'] = $this->language->get('text_error');

			$this->data['text_error'] = $this->language->get('text_error');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('common/home', '', 'SSL');

			// Theme
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
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

			$this->response->addheader($this->request->server['SERVER_PROTOCOL'] . ' 404 not found');
			$this->response->setOutput($this->render());
		}
	}
}
