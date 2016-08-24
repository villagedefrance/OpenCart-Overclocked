<?php
class ControllerReportSaleProfit extends Controller {

	public function index() {
		$this->language->load('report/sale_profit');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-01-01', time());
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d', time());
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
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
			'href'      => $this->url->link('report/sale_profit', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('report/product');

		$this->data['products'] = array();

		$data = array(
			'filter_date_start'      => $filter_date_start,
			'filter_date_end'        => $filter_date_end,
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$price = 0;
		$cost = 0;
		$profit = 0;

		$product_total = $this->model_report_product->getTotalProfit($data);

		$results = $this->model_report_product->getProfit($data);

		foreach ($results as $result) {
			$this->data['products'][] = array(
				'year'           => $result['year'],
				'month'          => $result['month'],
				'price'          => $this->currency->format($result['price'], $this->config->get('config_currency')),
				'cost'           => $this->currency->format($result['cost'], $this->config->get('config_currency')),
				'percent_profit' => ($result['cost'] > 0) ? number_format(($result['profit'] * 100) / $result['cost'], 2) . '%' : '100%',
				'profit'         => $this->currency->format($result['profit'], $this->config->get('config_currency'))
			);

			$price += $result['price'];
			$cost += $result['cost'];
			$profit += $result['profit'];
		}

		$this->data['total_price'] = $this->currency->format($price, $this->config->get('config_currency'));
		$this->data['total_cost'] = $this->currency->format($cost, $this->config->get('config_currency'));
		$this->data['total_percent_profit'] = ($cost > 0) ? number_format(($profit * 100) / $cost, 2) . '%' : '100%';
		$this->data['total_profit'] = $this->currency->format($profit, $this->config->get('config_currency'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');

		$this->data['column_year'] = $this->language->get('column_year');
		$this->data['column_month'] = $this->language->get('column_month');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_cost'] = $this->language->get('column_cost');
		$this->data['column_profit'] = $this->language->get('column_profit');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_close'] = $this->language->get('button_close');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['close'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/sale_profit', 'token=' . $this->session->data['token'] . $url . '&page={page}');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
		$this->data['filter_order_status_id'] = $filter_order_status_id;

		$this->template = 'report/sale_profit.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
