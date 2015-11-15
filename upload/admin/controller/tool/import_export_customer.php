<?php
class ControllerToolImportExportCustomer extends Controller {
	private $error = array();
	private $_name = 'import_export_customer';

	public function index() {
		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['heading_export'] = $this->language->get('heading_export');

		$this->data['text_options'] = $this->language->get('text_options');
		$this->data['text_option_fax'] = $this->language->get('text_option_fax');
		$this->data['text_option_gender'] = $this->language->get('text_option_gender');
		$this->data['text_option_dob'] = $this->language->get('text_option_dob');

		$this->data['entry_export'] = $this->language->get('entry_export');

		$this->data['help_function'] = $this->language->get('help_function');

		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

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
			'href'		=> $this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['customer_export'] = $this->url->link('tool/' . $this->_name . '/export', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['setting_fax'] = $this->config->get('config_customer_fax');
		$this->data['setting_gender'] = $this->config->get('config_customer_gender');
		$this->data['setting_dob'] = $this->config->get('config_customer_dob');

		$this->data['refresh'] = $this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'tool/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export() {
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$filename = 'customer.xlsx';

			header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');

			$header = array(
				'firstname'				=> 'string',
				'lastname'				=> 'string',
				'email'					=> 'string',
				'telephone'				=> 'string',
				'fax'						=> 'string',
				'gender' 					=> 'integer',
				'date_of_birth' 		=> 'date',
				'password'				=> 'string',
				'newsletter'				=> 'integer',
				'customer_group_id'	=> 'integer',
				'company'				=> 'string',
				'company_id'			=> 'integer',
				'tax_id'					=> 'integer',
				'address_1'				=> 'string',
				'address_2'				=> 'string',
				'city'						=> 'string',
				'postcode'				=> 'string',
				'country_id'				=> 'integer',
				'zone_id'					=> 'integer',
				'ip'							=> 'string',
				'status'					=> 'integer',
				'approved'				=> 'integer'
			);

			$this->load->model('tool/' . $this->_name);

			$customer_data = array();

			$results = $this->model_tool_import_export_customer->getCustomers($this->config->get('config_language_id'));

			foreach ($results as $result) {
				if ($result['fax'] && $this->config->get('config_customer_fax')) {
					$customer_fax = $result['fax'];
				} else {
					$customer_fax = '';
				}

				if ($result['gender'] && $this->config->get('config_customer_gender')) {
					$customer_gender = $result['gender'];
				} else {
					$customer_gender = '';
				}

				if ($result['date_of_birth'] && $this->config->get('config_customer_dob')) {
					$customer_dob = $result['date_of_birth'];
				} else {
					$customer_dob = '';
				}

				$customer_data[] = array(
					'firstname'				=> $result['firstname'] ? $result['firstname'] : '',
					'lastname'				=> $result['lastname'] ? $result['lastname'] : '',
					'email'					=> $result['email'] ? $result['email'] : '',
					'telephone'				=> $result['telephone'] ? $result['telephone'] : '',
					'fax' 						=> $customer_fax,
					'gender' 					=> $customer_gender,
					'date_of_birth' 		=> $customer_dob,
					'password'				=> $result['password'] ? $result['password'] : '',
					'newsletter'				=> $result['newsletter'] ? '1' : '0',
					'customer_group_id'	=> $result['customer_group_id'] ? $result['customer_group_id'] : '',
					'company'				=> $result['company'] ? $result['company'] : '',
					'company_id'			=> $result['company_id'] ? $result['company_id'] : '',
					'tax_id'					=> $result['tax_id'] ? $result['tax_id'] : '',
					'address_1'				=> $result['address_1'] ? $result['address_1'] : '',
					'address_2'				=> $result['address_2'] ? $result['address_2'] : '',
					'city'						=> $result['city'] ? $result['city'] : '',
					'postcode'				=> $result['postcode'] ? $result['postcode'] : '',
					'country_id'				=> $result['country_id'] ? $result['country_id'] : '00',
					'zone_id'					=> $result['zone_id'] ? $result['zone_id'] : '00',
					'ip'							=> $result['ip'] ? $result['ip'] : '',
					'status'					=> $result['status'] ? '1' : '0',
					'approved'				=> $result['approved'] ? '1' : '0',
				);
			}

			$writer = new XLSXWriter();
			$writer->setAuthor($this->config->get('config_name'));
			$writer->writeSheet($customer_data, 'Customers', $header);
			$writer->writeToStdOut();
			$writer->writeToFile(DIR_LOGS . $filename);

			$this->response->setOutput($this->model_tool_import_export_customer->download());

		} else {
			$this->language->load('tool/' . $this->_name);

			$this->session->data['error'] = $this->language->get('error_export');

			$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/' . $this->_name)) {
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