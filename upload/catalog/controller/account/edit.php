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
			'href'      => $this->url->link('common/home', '', 'SSL'),
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

		$this->data['heading_gdpr'] = $this->language->get('heading_gdpr');
		$this->data['heading_copying'] = $this->language->get('heading_copying');
		$this->data['heading_closing'] = $this->language->get('heading_closing');

		$this->data['text_your_details'] = $this->language->get('text_your_details');
		$this->data['text_female'] = $this->language->get('text_female');
		$this->data['text_male'] = $this->language->get('text_male');
		$this->data['text_print_data'] = $this->language->get('text_print_data');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_gender'] = $this->language->get('entry_gender');
		$this->data['entry_date_of_birth'] = $this->language->get('entry_date_of_birth');

		$this->data['gdpr_firstname'] = $this->language->get('gdpr_firstname');
		$this->data['gdpr_lastname'] = $this->language->get('gdpr_lastname');
		$this->data['gdpr_address'] = $this->language->get('gdpr_address');
		$this->data['gdpr_email'] = $this->language->get('gdpr_email');
		$this->data['gdpr_telephone'] = $this->language->get('gdpr_telephone');
		$this->data['gdpr_fax'] = $this->language->get('gdpr_fax');
		$this->data['gdpr_gender'] = $this->language->get('gdpr_gender');
		$this->data['gdpr_date_of_birth'] = $this->language->get('gdpr_date_of_birth');
		$this->data['gdpr_password'] = $this->language->get('gdpr_password');
		$this->data['gdpr_ip'] = $this->language->get('gdpr_ip');
		$this->data['gdpr_user_agent'] = $this->language->get('gdpr_user_agent');

		$this->data['help_gdpr'] = $this->language->get('help_gdpr');
		$this->data['help_copying'] = $this->language->get('help_copying');
		$this->data['help_closing'] = $this->language->get('help_closing');

		$this->data['dialog_gender'] = $this->language->get('dialog_gender');
		$this->data['dialog_date_of_birth'] = $this->language->get('dialog_date_of_birth');

		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_print'] = $this->language->get('button_print');
		$this->data['button_download'] = $this->language->get('button_download');
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_delete'] = $this->language->get('button_delete');
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

		$this->data['close_account'] = $this->url->link('account/delete', '', 'SSL');
		$this->data['customer_data'] = $this->url->link('account/edit/personal', '', 'SSL');

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

		$this->data['track_online'] = $this->config->get('config_customer_online');

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

		return empty($this->error);
	}

	public function personal() {
		$this->language->load('account/edit');

		$this->data['title'] = $this->language->get('heading_title');

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$this->data['base'] = HTTPS_SERVER;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['direction'] = $this->language->get('direction');
		$this->data['language'] = $this->language->get('code');

		$this->data['text_customer_data'] = $this->language->get('text_customer_data');

		$this->data['text_customer_id'] = $this->language->get('text_customer_id');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_email'] = $this->language->get('text_email');
		$this->data['text_telephone'] = $this->language->get('text_telephone');
		$this->data['text_fax'] = $this->language->get('text_fax');
		$this->data['text_gender'] = $this->language->get('text_gender');
		$this->data['text_date_of_birth'] = $this->language->get('text_date_of_birth');
		$this->data['text_ip'] = $this->language->get('text_ip');
		$this->data['text_user_agent'] = $this->language->get('text_user_agent');
		$this->data['text_copyrights'] = $this->language->get('text_copyrights');

		$this->data['text_firstname'] = $this->language->get('text_firstname');
		$this->data['text_lastname'] = $this->language->get('text_lastname');
		$this->data['text_company'] = $this->language->get('text_company');
		$this->data['text_company_id'] = $this->language->get('text_company_id');
		$this->data['text_tax_id'] = $this->language->get('text_tax_id');
		$this->data['text_address_1'] = $this->language->get('text_address_1');
		$this->data['text_address_2'] = $this->language->get('text_address_2');
		$this->data['text_city'] = $this->language->get('text_city');
		$this->data['text_postcode'] = $this->language->get('text_postcode');
		$this->data['text_zone'] = $this->language->get('text_zone');
		$this->data['text_zone_code'] = $this->language->get('text_zone_code');
		$this->data['text_country'] = $this->language->get('text_country');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('account/customer');
		$this->load->model('account/address');
		$this->load->model('setting/setting');

		$customer_id = $this->customer->getId();

		$pdf = (isset($this->request->get['pdf'])) ? true : false;

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $this->request->server['HTTPS'] ? HTTPS_IMAGE . $this->config->get('config_logo') : HTTP_IMAGE . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}

		$this->data['customers'] = array();
		$this->data['addresses'] = array();

		if ($customer_id) {
			$customer_info = $this->model_account_customer->getCustomer($customer_id);

			if ($customer_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $customer_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				$store_url = $this->request->server['HTTPS'] ? rtrim(HTTPS_SERVER, '/') : rtrim(HTTP_SERVER, '/');

				$store_company_id = $this->config->get('config_company_id') ? $this->config->get('config_company_id') : '';
				$store_company_tax_id = $this->config->get('config_company_tax_id') ? $this->config->get('config_company_tax_id') : '';

				$show_fax = $this->config->get('config_customer_fax');

				if ($show_fax && isset($customer_info['fax'])) {
					$customer_fax = $customer_info['fax'];
				} else {
					$customer_fax = '';
				}

				$show_gender = $this->config->get('config_customer_gender');

				if ($show_gender && isset($customer_info['gender'])) {
					$customer_gender = ($customer_info['gender']) ? $this->language->get('text_female') : $this->language->get('text_male');
				} else {
					$customer_gender = '';
				}

				$show_dob = $this->config->get('config_customer_dob');

				if ($show_dob && isset($customer_info['date_of_birth'])) {
					$customer_date_of_birth = date('Y-m-d', strtotime($customer_info['date_of_birth']));
				} else {
					$customer_date_of_birth = '';
				}

				$track_online = $this->config->get('config_customer_online');

				if ($track_online) {
					$customer_user_agent = $this->model_account_customer->getCustomerUserAgent($customer_id);
				} else {
					$customer_user_agent = '';
				}

				$this->data['customers'][] = array(
					'customer_id'          => $customer_id,
					'date_added'           => date($this->language->get('date_format_short'), strtotime($customer_info['date_added'])),
					'store_name'           => $this->config->get('config_name'),
					'store_address'        => nl2br($store_address),
					'store_email'          => $store_email,
					'store_telephone'      => $store_telephone,
					'store_fax'            => $store_fax,
					'store_url'            => $store_url,
					'store_company_id'     => $store_company_id,
					'store_company_tax_id' => $store_company_tax_id,
					'firstname'            => $customer_info['firstname'],
					'lastname'             => $customer_info['lastname'],
					'email'                => $customer_info['email'],
					'telephone'            => $customer_info['telephone'],
					'fax'                  => $customer_fax,
					'gender'               => $customer_gender,
					'date_of_birth'        => $customer_date_of_birth,
					'user_agent'           => $customer_user_agent,
					'ip'                   => $customer_info['ip']
				);

				// Addresses
				$results = $this->model_account_address->getAddresses();

				foreach ($results as $result) {
					if ($result['address_format']) {
						$format = $result['address_format'];
					} else {
						$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
					}

					$find = array(
						'{firstname}',
						'{lastname}',
						'{company}',
						'{address_1}',
						'{address_2}',
						'{city}',
						'{postcode}',
						'{zone}',
						'{zone_code}',
						'{country}'
					);

					$replace = array(
						'firstname' => $result['firstname'],
						'lastname'  => $result['lastname'],
						'company'   => $result['company'],
						'address_1' => $result['address_1'],
						'address_2' => $result['address_2'],
						'city'      => $result['city'],
						'postcode'  => $result['postcode'],
						'zone'      => $result['zone'],
						'zone_code' => $result['zone_code'],
						'country'   => $result['country']
					);

					$this->data['addresses'][] = array(
						'address_id' => $result['address_id'],
						'address'    => str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))))
					);
				}
			}
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account_data.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/account_data.tpl';
		} else {
			$this->template = 'default/template/account/account_data.tpl';
		}

		if ($pdf) {
			$document_type = $this->language->get('text_customer_data');

			$document = str_replace(' ', '-', $document_type);

			$this->response->setOutput(pdf($this->render(), $document, $this->customer->getId()));
		} else {
			$this->response->setOutput($this->render());
		}
	}
}
