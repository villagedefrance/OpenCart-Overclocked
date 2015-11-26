<?php
class ControllerToolExportImportCustomer extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('tool/export_import_customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/export_import_customer');

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['heading_export'] = $this->language->get('heading_export');
		$this->data['heading_parameter'] = $this->language->get('heading_parameter');

		$this->data['text_spreadsheet'] = $this->language->get('text_spreadsheet');
		$this->data['text_charset'] = $this->language->get('text_charset');
		$this->data['text_delimiter'] = $this->language->get('text_delimiter');
		$this->data['text_enclosure'] = $this->language->get('text_enclosure');
		$this->data['text_escaped'] = $this->language->get('text_escaped');
		$this->data['text_ending'] = $this->language->get('text_ending');

		$this->data['entry_export'] = $this->language->get('entry_export');

		$this->data['help_function'] = $this->language->get('help_function');

		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_close'] = $this->language->get('button_close');

		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

  		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('tool/export_import_customer', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['csv_export'] = $this->url->link('tool/export_import_customer/export', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['refresh'] = $this->url->link('tool/export_import_customer', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['close'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$data = array(
			'store_id',
			'firstname',
			'lastname',
			'email',
			'telephone',
			'fax',
			'gender',
			'date_of_birth',
			'password',
			'newsletter',
			'address_id',
			'customer_group_id',
			'ip',
			'status',
			'approved',
			'date_added'
		);

		$customer_info = $this->model_tool_export_import_customer->getCustomers($data);

		$this->data['headers'] = $data;

		if (isset($this->request->post['header']['export'])) {
			$this->data['export'] = $this->request->post['header']['export'];
		} elseif (isset($customer_info['header']['export'])) {
			$this->data['export'] = $customer_info['header']['export'];
		} else {
			$this->data['export'] = array();
		}

		$this->template = 'tool/export_import_customer.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export() {
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate() && isset($this->request->post['header']['export'])) {
			$filename = 'Customers.csv';

			$ReflectionResponse = new ReflectionClass($this->response);

			if ($ReflectionResponse->getMethod('addheader')->getNumberOfParameters() == 2) {
				$this->response->addheader('Pragma', 'public');
				$this->response->addheader('Expires', '0');
				$this->response->addheader('Content-Description', 'File Transfer');
				$this->response->addheader('Content-type', 'text/csv; charset=utf-8');
				$this->response->addheader('Content-Disposition', 'attachment; filename=' . $filename);
				$this->response->addheader('Content-Transfer-Encoding', 'binary');
				$this->response->addheader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
			} else {
				$this->response->addheader('Pragma: public');
				$this->response->addheader('Expires: 0');
				$this->response->addheader('Content-Description: File Transfer');
				$this->response->addheader('Content-type: text/csv; charset=utf-8');
				$this->response->addheader('Content-Disposition: attachment; filename=' . $filename);
				$this->response->addheader('Content-Transfer-Encoding: binary');
				$this->response->addheader('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			}

			$headers = $this->request->post['header']['export'];

			$this->load->model('tool/export_import_customer');

			$this->response->setOutput($this->model_tool_export_import_customer->csvExportCustomer($headers));

		} else {
			$this->language->load('tool/export_import_customer');

			$this->session->data['error'] = $this->language->get('error_export');

			$this->redirect($this->url->link('tool/export_import_customer', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/export_import_customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>