<?php
class ControllerReportProductMarkup extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('report/product_markup');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

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

		$data = array(
			'start'	=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' 		=> $this->config->get('config_admin_limit')
		);

		$products_total = $this->model_report_product->getTotalProducts();

		// Products
		$this->data['products'] = array();

		$products = $this->model_report_product->getProducts($data);

		foreach ($products as $product) {
			if ($product['price'] > 0) {
				$price = $product['price'];
			} else {
				$price = 1; // to prevent division by zero
			}

			if ($product['cost'] > 0) {
				$cost = $product['cost'];
			} else {
				$cost = 0;
			}

			$this->data['products'][] = array(
				'product_id'			=> $product['product_id'],
				'name'				=> $product['name'],
				'price_formatted'	=> $this->currency->format($product['price'], $this->config->get('config_currency')),
				'cost_formatted'	=> $this->currency->format($product['cost'], $this->config->get('config_currency')),
				'price'				=> $price,
				'cost'					=> $cost
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_product_id'] = $this->language->get('column_product_id');
		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_cost'] = $this->language->get('column_cost');
		$this->data['column_ratio'] = $this->language->get('column_ratio');
		$this->data['column_graph'] = $this->language->get('column_graph');

		$this->data['button_exit'] = $this->language->get('button_exit');

		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$pagination = new Pagination();
		$pagination->total = $products_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/product_markup', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'report/product_markup.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>