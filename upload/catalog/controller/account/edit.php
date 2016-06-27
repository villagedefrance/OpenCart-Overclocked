<?php
class ControllerAccountEdit extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if (!$this->customer->isSecure() || $this->customer->loginExpired()) {
			$this->customer->logout();

			$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/edit');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/customer');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!isset($this->request->get['customer_token']) || !isset($this->session->data['customer_token']) || $this->request->get['customer_token'] != $this->session->data['customer_token']) {
				$this->customer->logout();

				$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

				$this->redirect($this->url->link('account/login', '', 'SSL'));
			}

			$this->customer->setToken();

			if ($this->validate()) {
				$this->model_account_customer->editCustomer($this->request->post);

				$this->session->data['success'] = $this->language->get('text_success');

				$this->redirect($this->url->link('account/account', '', 'SSL'));
			}
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_edit'),
			'href'      => $this->url->link('account/edit', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_your_details'] = $this->language->get('text_your_details');
		$this->data['text_female'] = $this->language->get('text_female');
		$this->data['text_male'] = $this->language->get('text_male');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_gender'] = $this->language->get('entry_gender');
		$this->data['entry_date_of_birth'] = $this->language->get('entry_date_of_birth');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}

		if (isset($this->error['date_of_birth'])) {
			$this->data['error_date_of_birth'] = $this->error['date_of_birth'];
		} else {
			$this->data['error_date_of_birth'] = '';
		}

		$this->data['action'] = $this->url->link('account/edit', 'customer_token=' . $this->session->data['customer_token'], 'SSL');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		}

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (isset($customer_info)) {
			$this->data['firstname'] = $customer_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (isset($customer_info)) {
			$this->data['lastname'] = $customer_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (isset($customer_info)) {
			$this->data['email'] = $customer_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} elseif (isset($customer_info)) {
			$this->data['telephone'] = $customer_info['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		$this->data['show_fax'] = $this->config->get('config_customer_fax');

		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif (isset($customer_info)) {
			$this->data['fax'] = $customer_info['fax'];
		} else {
			$this->data['fax'] = '';
		}

		$this->data['show_gender'] = $this->config->get('config_customer_gender');

		if (isset($this->request->post['gender'])) {
			$this->data['gender'] = $this->request->post['gender'];
		} elseif (isset($customer_info)) {
			$this->data['gender'] = $customer_info['gender'];
		} else {
			$this->data['gender'] = '';
		}

		$this->data['show_dob'] = $this->config->get('config_customer_dob');

		if (isset($this->request->post['date_of_birth'])) {
			$this->data['date_of_birth'] = $this->request->post['date_of_birth'];
		} elseif (isset($customer_info)) {
			$this->data['date_of_birth'] = date('Y-m-d', strtotime($customer_info['date_of_birth']));
		} else {
			$this->data['date_of_birth'] = '0000-00-00';
		}

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/edit.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/edit.tpl';
		} else {
			$this->template = 'default/template/account/edit.tpl';
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

	protected function validate() {
		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if ($this->config->get('config_customer_dob')) {
			if (isset($this->request->post['date_of_birth']) && (utf8_strlen($this->request->post['date_of_birth']) == 10)) {
				if ($this->request->post['date_of_birth'] != date('Y-m-d', strtotime($this->request->post['date_of_birth']))) {
					$this->error['date_of_birth'] = $this->language->get('error_date_of_birth');
				}
			} else {
				$this->error['date_of_birth'] = $this->language->get('error_date_of_birth');
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>