<?php
class ControllerReportCustomerWishlist extends Controller {

	public function index() {
		$this->language->load('report/customer_wishlist');

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
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/customer_wishlist', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('report/customer');

		$this->data['products'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$wishlist_total = $this->model_report_customer->getTotalWishlist($data);

		$results = $this->model_report_customer->getWishlist($data);

		foreach ($results as $result) {
			if ($result['total_wishlisted']) {
				$percent = round($result['total_wishlisted'] / $wishlist_total * 100, 2);
			} else {
				$percent = 0;
			}

			$this->data['products'][] = array(
				'name'        => $result['name'],
				'model'       => $result['model'],
				'wishlisted'  => $result['total_wishlisted'],
				'percent'     => $percent . '%'
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_wishlisted'] = $this->language->get('column_wishlisted');
		$this->data['column_percent'] = $this->language->get('column_percent');

		$this->data['button_close'] = $this->language->get('button_close');

		$this->data['close'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		$url = '';

		$pagination = new Pagination();
		$pagination->total = $wishlist_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/customer_wishlist', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'report/customer_wishlist.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
