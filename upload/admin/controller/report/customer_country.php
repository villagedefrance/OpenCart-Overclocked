<?php
class ControllerReportCustomerCountry extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('report/customer_country');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('report/customer_country');

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

		$this->data['breadcrumbs'][] = array(
       		'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('report/customer_country', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['column_country_id'] = $this->language->get('column_country_id');
		$this->data['column_country'] = $this->language->get('column_country');
		$this->data['column_customers'] = $this->language->get('column_customers');
		$this->data['column_ratio'] = $this->language->get('column_ratio');
		$this->data['column_graph'] = $this->language->get('column_graph');

		$this->data['button_exit'] = $this->language->get('button_exit');

		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		// Countries
		$this->data['countries'] = array();

		$countries = $this->model_report_customer_country->getCountries();

		foreach ($countries as $country) {
			$this->data['countries'][] = array(
				'country_id'		=> $country['country_id'],
				'country'			=> $country['country'],
				'customers'		=> $this->model_report_customer_country->getTotalCustomersByCountryId($country['country_id'])
			);
		}

		$this->load->model('sale/customer');

		$this->data['total_store_customers'] = $this->model_sale_customer->getTotalCustomers(0);

		$this->template = 'report/customer_country.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>