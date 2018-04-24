<?php
class ControllerProductProductList extends Controller {

	public function index() {
		$this->language->load('product/product_list');

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

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
			$this->data['text_total_categories'] = $this->language->get('text_total_categories');
			$this->data['text_total_products'] = $this->language->get('text_total_products');
			$this->data['text_title_product'] = $this->language->get('text_title_product');
			$this->data['text_to'] = $this->language->get('text_to');
			$this->data['text_in'] = $this->language->get('text_in');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('product/product_list', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['categories'] = array();

			$this->data['ctotal'] = 0;
			$this->data['ctotal1'] = 0;
			$this->data['ctotal2'] = 0;
			$this->data['ctotal3'] = 0;

			foreach ($categories_list as $category_1) {
				$level_2_data = array();

				$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

				foreach ($categories_2 as $category_2) {
					$level_3_data = array();

					$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

					foreach ($categories_3 as $category_3) {
						$level_3_data[] = array(
							'name' => $category_3['name'],
							'href' => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id'], 'SSL')
						);

						$this->data['ctotal3'] = $this->data['ctotal3'] + 1;
					}

					$level_2_data[] = array(
						'name'     => $category_2['name'],
						'children' => $level_3_data,
						'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'], 'SSL')
					);

					$this->data['ctotal2'] = $this->data['ctotal2'] + 1;
				}

				$this->data['categories'][] = array(
					'name'     => $category_1['name'],
					'children' => $level_2_data,
					'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'], 'SSL')
				);

				$this->data['ctotal1'] = $this->data['ctotal1'] + 1;

				$this->data['ctotal'] = $this->data['ctotal1'] + $this->data['ctotal2'] + $this->data['ctotal3'];
			}

			$this->data['products'] = array();

			$this->data['ptotal'] = 0;
			$this->data['pcount'] = 1;

			$results = $this->model_catalog_product->getProducts(0);

			if ($results) {
				foreach ($results as $result) {
					$this->data['products'][] = array(
						'product_id' => $result['product_id'],
						'name'       => $result['name'],
						'href'       => $this->url->link('product/product', 'product_id=' . $result['product_id'], 'SSL'),
						'count'      => $this->data['pcount']
					);

					$this->data['pcount'] = $this->data['pcount'] + 1;
					$this->data['ptotal'] = $this->data['ptotal'] + 1;
				}
			}

			$this->data['tritotal1'] = round(($this->data['ptotal'] / 3) + 1);
			$this->data['tritotal2'] = $this->data['tritotal1'] * 2;

			$this->data['continue'] = $this->url->link('common/home', '', 'SSL');

			// Theme
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/product_list.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/product_list.tpl';
			} else {
				$this->template = 'default/template/product/product_list.tpl';
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
				'href'      => $this->url->link('product/product_list', '', 'SSL'),
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
