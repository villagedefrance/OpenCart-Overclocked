<?php
class ControllerReportProductMarkup extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('report/product_markup');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
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
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('report/product_markup', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('report/product');
		$this->load->model('catalog/product');

		$data = array(
			'filter_name'	  	=> $filter_name,
			'sort'            		=> $sort,
			'order'           		=> $order,
			'start'           		=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           		=> $this->config->get('config_admin_limit')
		);

		$products_total = $this->model_report_product->getTotalProducts($data);

		// Products
		$this->data['products'] = array();

		$products = $this->model_report_product->getProducts($data);

		foreach ($products as $product) {
			$has_special = false;
			$special = false;
			$price = false;
			$cost = false;
			$ratio = false;
			$graph = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($product['product_id']);

			foreach ($product_specials as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] <= date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
					$special = $product_special['price'];
					break;
				}
			}

			if ($special && $special > 0) {
				$has_special = true;
				$price = $special;
			} elseif ($product['price'] > 0) {
				$price = $product['price'];
			} else {
				$price = 1; // prevents division by zero
			}

			if ($product['cost'] > 0) {
				$cost = $product['cost'];
			} else {
				$cost = 0;
			}

			if ($price >= $cost) {
				$ratio = number_format((($price - $cost) / $price) * 100, 2);
				$graph = (($price - $cost) / $price) * 300;
				$graph_type = 0;
			} else {
				$ratio = number_format((($cost - $price) / $cost) * 100, 2);
				$graph = (($cost - $price) / $cost) * 300;
				$graph_type = 1;
			}

			$this->data['products'][] = array(
				'product_id'			=> $product['product_id'],
				'product_href'		=> $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], 'SSL'),
				'name'				=> $product['name'],
				'price_formatted'	=> $this->currency->format($price, $this->config->get('config_currency')),
				'cost_formatted'	=> $this->currency->format($cost, $this->config->get('config_currency')),
				'ratio'					=> $ratio,
				'graph'				=> $graph,
				'graph_type'		=> (int)$graph_type,
				'has_special'		=> $has_special,
				'price'				=> $price,
				'cost'					=> $cost
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_free_products'] = $this->language->get('text_free_products');

		$this->data['column_product_id'] = $this->language->get('column_product_id');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_cost'] = $this->language->get('column_cost');
		$this->data['column_ratio'] = $this->language->get('column_ratio');
		$this->data['column_graph'] = $this->language->get('column_graph');

		$this->data['button_close'] = $this->language->get('button_close');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['close'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('report/product_markup', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$this->data['sort_price'] = $this->url->link('report/product_markup', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
		$this->data['sort_cost'] = $this->url->link('report/product_markup', 'token=' . $this->session->data['token'] . '&sort=p.cost' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $products_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/product_markup', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'report/product_markup.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/product');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}

			$data = array(
				'filter_name'	=> $filter_name,
				'start'			=> 0,
				'limit'				=> $limit
			);

			$results = $this->model_catalog_product->getProducts($data);

			foreach ($results as $result) {
				$json[] = array(
					'product_id'	=> $result['product_id'],
					'name'       	=> strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'price'   		=> $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>