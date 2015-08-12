<?php
class ControllerProductCategoryList extends Controller {
	private $_name = 'category_list';

	public function index() {
		$this->language->load('product/category_list');

		$this->document->setTitle($this->language->get('heading_title'));

		// Breadcrumbs
		$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home'),
			'separator' => false
      	);

      	$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('product/category_list'),
			'separator' => $this->language->get('text_separator')
      	);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_continue'] = $this->language->get('button_continue');

		if (isset($this->request->get['filter_name'])) {
			$this->data['filter_name'] = $this->request->get['filter_name'];
		} else {
			$this->data['filter_name'] = '';
		}

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

		$this->data['categories_1'] = array();

		$this->data['ccount'] = 0;

		$categories_1 = $this->model_catalog_category->getCategories(0);

		foreach ($categories_1 as $category_1) {
			$level_2_data = array();

			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

			foreach ($categories_2 as $category_2) {
				$level_3_data = array();

				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'name'	=> $category_3['name'],
						'href'		=> $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id'])
					);
				}

				$level_2_data[] = array(
					'name'	=> $category_2['name'],
					'children'	=> $level_3_data,
					'href'		=> $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'])
				);
			}

			$this->data['categories'][] = array(
				'name'	=> $category_1['name'],
				'children'	=> $level_2_data,
				'href'		=> $this->url->link('product/category', 'path=' . $category_1['category_id']),
				'count'	=> $this->data['ccount']
			);

			$this->data['ccount'] = $this->data['ccount'] + 1;
		}

		$this->data['cattotal'] = $this->data['ccount'];

		$this->data['cattotal1'] = round($this->data['cattotal'] / 3);
		$this->data['cattotal2'] = $this->data['cattotal1'] * 2;

		$this->data['continue'] = $this->url->link('common/home');

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
	}
}
?>