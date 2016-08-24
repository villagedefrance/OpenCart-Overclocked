<?php
class ControllerFraudMaxMind extends Controller {
	private $error = array();
	private $_name = 'maxmind';

	public function index() {
		$this->language->load('fraud/maxmind');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('maxmind', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('fraud/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/fraud', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_signup'] = $this->language->get('text_signup');

		$this->data['entry_key'] = $this->language->get('entry_key');
		$this->data['entry_score'] = $this->language->get('entry_score');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['key'])) {
			$this->data['error_key'] = $this->error['key'];
		} else {
			$this->data['error_key'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_fraud'),
			'href'      => $this->url->link('extension/fraud', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('fraud/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('fraud/maxmind', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/fraud', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['maxmind_key'])) {
			$this->data['maxmind_key'] = $this->request->post['maxmind_key'];
		} else {
			$this->data['maxmind_key'] = $this->config->get('maxmind_key');
		}

		if (isset($this->request->post['maxmind_score'])) {
			$this->data['maxmind_score'] = $this->request->post['maxmind_score'];
		} elseif ($this->config->get('maxmind_score')) {
			$this->data['maxmind_score'] = $this->config->get('maxmind_score');
		} else {
			$this->data['maxmind_score'] = '80';
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['maxmind_order_status_id'])) {
			$this->data['maxmind_order_status_id'] = $this->request->post['maxmind_order_status_id'];
		} else {
			$this->data['maxmind_order_status_id'] = $this->config->get('maxmind_order_status_id');
		}

		if (isset($this->request->post['maxmind_status'])) {
			$this->data['maxmind_status'] = $this->request->post['maxmind_status'];
		} else {
			$this->data['maxmind_status'] = $this->config->get('maxmind_status');
		}

		$this->template = 'fraud/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model('fraud/maxmind');

		$this->model_fraud_maxmind->install();
	}

	public function uninstall() {
		$this->load->model('fraud/maxmind');

		$this->model_fraud_maxmind->uninstall();
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'fraud/maxmind')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['maxmind_key']) {
			$this->error['key'] = $this->language->get('error_key');
		}

		return empty($this->error);
	}

	public function order() {
		$this->language->load('fraud/maxmind');

		$this->load->model('fraud/maxmind');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$fraud_info = $this->model_fraud_maxmind->getOrder($order_id);

		if ($fraud_info) {
			$this->data['text_country_match'] = $this->language->get('text_country_match');
			$this->data['text_country_code'] = $this->language->get('text_country_code');
			$this->data['text_high_risk_country'] = $this->language->get('text_high_risk_country');
			$this->data['text_distance'] = $this->language->get('text_distance');
			$this->data['text_ip_region'] = $this->language->get('text_ip_region');
			$this->data['text_ip_city'] = $this->language->get('text_ip_city');
			$this->data['text_ip_latitude'] = $this->language->get('text_ip_latitude');
			$this->data['text_ip_longitude'] = $this->language->get('text_ip_longitude');
			$this->data['text_ip_isp'] = $this->language->get('text_ip_isp');
			$this->data['text_ip_org'] = $this->language->get('text_ip_org');
			$this->data['text_ip_asnum'] = $this->language->get('text_ip_asnum');
			$this->data['text_ip_user_type'] = $this->language->get('text_ip_user_type');
			$this->data['text_ip_country_confidence'] = $this->language->get('text_ip_country_confidence');
			$this->data['text_ip_region_confidence'] = $this->language->get('text_ip_region_confidence');
			$this->data['text_ip_city_confidence'] = $this->language->get('text_ip_city_confidence');
			$this->data['text_ip_postal_confidence'] = $this->language->get('text_ip_postal_confidence');
			$this->data['text_ip_postal_code'] = $this->language->get('text_ip_postal_code');
			$this->data['text_ip_accuracy_radius'] = $this->language->get('text_ip_accuracy_radius');
			$this->data['text_ip_net_speed_cell'] = $this->language->get('text_ip_net_speed_cell');
			$this->data['text_ip_metro_code'] = $this->language->get('text_ip_metro_code');
			$this->data['text_ip_area_code'] = $this->language->get('text_ip_area_code');
			$this->data['text_ip_time_zone'] = $this->language->get('text_ip_time_zone');
			$this->data['text_ip_region_name'] = $this->language->get('text_ip_region_name');
			$this->data['text_ip_domain'] = $this->language->get('text_ip_domain');
			$this->data['text_ip_country_name'] = $this->language->get('text_ip_country_name');
			$this->data['text_ip_continent_code'] = $this->language->get('text_ip_continent_code');
			$this->data['text_ip_corporate_proxy'] = $this->language->get('text_ip_corporate_proxy');
			$this->data['text_anonymous_proxy'] = $this->language->get('text_anonymous_proxy');
			$this->data['text_proxy_score'] = $this->language->get('text_proxy_score');
			$this->data['text_is_trans_proxy'] = $this->language->get('text_is_trans_proxy');
			$this->data['text_free_mail'] = $this->language->get('text_free_mail');
			$this->data['text_carder_email'] = $this->language->get('text_carder_email');
			$this->data['text_high_risk_username'] = $this->language->get('text_high_risk_username');
			$this->data['text_high_risk_password'] = $this->language->get('text_high_risk_password');
			$this->data['text_bin_match'] = $this->language->get('text_bin_match');
			$this->data['text_bin_country'] = $this->language->get('text_bin_country');
			$this->data['text_bin_name_match'] = $this->language->get('text_bin_name_match');
			$this->data['text_bin_name'] = $this->language->get('text_bin_name');
			$this->data['text_bin_phone_match'] = $this->language->get('text_bin_phone_match');
			$this->data['text_bin_phone'] = $this->language->get('text_bin_phone');
			$this->data['text_customer_phone_in_billing_location'] = $this->language->get('text_customer_phone_in_billing_location');
			$this->data['text_ship_forward'] = $this->language->get('text_ship_forward');
			$this->data['text_city_postal_match'] = $this->language->get('text_city_postal_match');
			$this->data['text_ship_city_postal_match'] = $this->language->get('text_ship_city_postal_match');
			$this->data['text_score'] = $this->language->get('text_score');
			$this->data['text_explanation'] = $this->language->get('text_explanation');
			$this->data['text_risk_score'] = $this->language->get('text_risk_score');
			$this->data['text_queries_remaining'] = $this->language->get('text_queries_remaining');
			$this->data['text_maxmind_id'] = $this->language->get('text_maxmind_id');
			$this->data['text_error'] = $this->language->get('text_error');

			$this->data['help_country_match'] = $this->language->get('help_country_match');
			$this->data['help_country_code'] = $this->language->get('help_country_code');
			$this->data['help_high_risk_country'] = $this->language->get('help_high_risk_country');
			$this->data['help_distance'] = $this->language->get('help_distance');
			$this->data['help_ip_region'] = $this->language->get('help_ip_region');
			$this->data['help_ip_city'] = $this->language->get('help_ip_city');
			$this->data['help_ip_latitude'] = $this->language->get('help_ip_latitude');
			$this->data['help_ip_longitude'] = $this->language->get('help_ip_longitude');
			$this->data['help_ip_isp'] = $this->language->get('help_ip_isp');
			$this->data['help_ip_org'] = $this->language->get('help_ip_org');
			$this->data['help_ip_asnum'] = $this->language->get('help_ip_asnum');
			$this->data['help_ip_user_type'] = $this->language->get('help_ip_user_type');
			$this->data['help_ip_country_confidence'] = $this->language->get('help_ip_country_confidence');
			$this->data['help_ip_region_confidence'] = $this->language->get('help_ip_region_confidence');
			$this->data['help_ip_city_confidence'] = $this->language->get('help_ip_city_confidence');
			$this->data['help_ip_postal_confidence'] = $this->language->get('help_ip_postal_confidence');
			$this->data['help_ip_postal_code'] = $this->language->get('help_ip_postal_code');
			$this->data['help_ip_accuracy_radius'] = $this->language->get('help_ip_accuracy_radius');
			$this->data['help_ip_net_speed_cell'] = $this->language->get('help_ip_net_speed_cell');
			$this->data['help_ip_metro_code'] = $this->language->get('help_ip_metro_code');
			$this->data['help_ip_area_code'] = $this->language->get('help_ip_area_code');
			$this->data['help_ip_time_zone'] = $this->language->get('help_ip_time_zone');
			$this->data['help_ip_region_name'] = $this->language->get('help_ip_region_name');
			$this->data['help_ip_domain'] = $this->language->get('help_ip_domain');
			$this->data['help_ip_country_name'] = $this->language->get('help_ip_country_name');
			$this->data['help_ip_continent_code'] = $this->language->get('help_ip_continent_code');
			$this->data['help_ip_corporate_proxy'] = $this->language->get('help_ip_corporate_proxy');
			$this->data['help_anonymous_proxy'] = $this->language->get('help_anonymous_proxy');
			$this->data['help_proxy_score'] = $this->language->get('help_proxy_score');
			$this->data['help_is_trans_proxy'] = $this->language->get('help_is_trans_proxy');
			$this->data['help_free_mail'] = $this->language->get('help_free_mail');
			$this->data['help_carder_email'] = $this->language->get('help_carder_email');
			$this->data['help_high_risk_username'] = $this->language->get('help_high_risk_username');
			$this->data['help_high_risk_password'] = $this->language->get('help_high_risk_password');
			$this->data['help_bin_match'] = $this->language->get('help_bin_match');
			$this->data['help_bin_country'] = $this->language->get('help_bin_country');
			$this->data['help_bin_name_match'] = $this->language->get('help_bin_name_match');
			$this->data['help_bin_name'] = $this->language->get('help_bin_name');
			$this->data['help_bin_phone_match'] = $this->language->get('help_bin_phone_match');
			$this->data['help_bin_phone'] = $this->language->get('help_bin_phone');
			$this->data['help_customer_phone_in_billing_location'] = $this->language->get('help_customer_phone_in_billing_location');
			$this->data['help_ship_forward'] = $this->language->get('help_ship_forward');
			$this->data['help_city_postal_match'] = $this->language->get('help_city_postal_match');
			$this->data['help_ship_city_postal_match'] = $this->language->get('help_ship_city_postal_match');
			$this->data['help_score'] = $this->language->get('help_score');
			$this->data['help_explanation'] = $this->language->get('help_explanation');
			$this->data['help_risk_score'] = $this->language->get('help_risk_score');
			$this->data['help_queries_remaining'] = $this->language->get('help_queries_remaining');
			$this->data['help_maxmind_id'] = $this->language->get('help_maxmind_id');
			$this->data['help_error'] = $this->language->get('help_error');

			$this->data['country_match'] = $fraud_info['country_match'];

			if ($fraud_info['country_code']) {
				$this->data['country_code'] = $fraud_info['country_code'];
			} else {
				$this->data['country_code'] = '';
			}

			$this->data['high_risk_country'] = $fraud_info['high_risk_country'];
			$this->data['distance'] = $fraud_info['distance'];

			if ($fraud_info['ip_region']) {
				$this->data['ip_region'] = $fraud_info['ip_region'];
			} else {
				$this->data['ip_region'] = '';
			}

			if ($fraud_info['ip_city']) {
				$this->data['ip_city'] = $fraud_info['ip_city'];
			} else {
				$this->data['ip_city'] = '';
			}

			$this->data['ip_latitude'] = $fraud_info['ip_latitude'];
			$this->data['ip_longitude'] = $fraud_info['ip_longitude'];

			if ($fraud_info['ip_isp']) {
				$this->data['ip_isp'] = $fraud_info['ip_isp'];
			} else {
				$this->data['ip_isp'] = '';
			}

			if ($fraud_info['ip_org']) {
				$this->data['ip_org'] = $fraud_info['ip_org'];
			} else {
				$this->data['ip_org'] = '';
			}

			$this->data['ip_asnum'] = $fraud_info['ip_asnum'];

			if ($fraud_info['ip_user_type']) {
				$this->data['ip_user_type'] = $fraud_info['ip_user_type'];
			} else {
				$this->data['ip_user_type'] = '';
			}

			if ($fraud_info['ip_country_confidence']) {
				$this->data['ip_country_confidence'] = $fraud_info['ip_country_confidence'];
			} else {
				$this->data['ip_country_confidence'] = '';
			}

			if ($fraud_info['ip_region_confidence']) {
				$this->data['ip_region_confidence'] = $fraud_info['ip_region_confidence'];
			} else {
				$this->data['ip_region_confidence'] = '';
			}

			if ($fraud_info['ip_city_confidence']) {
				$this->data['ip_city_confidence'] = $fraud_info['ip_city_confidence'];
			} else {
				$this->data['ip_city_confidence'] = '';
			}

			if ($fraud_info['ip_postal_confidence']) {
				$this->data['ip_postal_confidence'] = $fraud_info['ip_postal_confidence'];
			} else {
				$this->data['ip_postal_confidence'] = '';
			}

			if ($fraud_info['ip_postal_code']) {
				$this->data['ip_postal_code'] = $fraud_info['ip_postal_code'];
			} else {
				$this->data['ip_postal_code'] = '';
			}

			$this->data['ip_accuracy_radius'] = $fraud_info['ip_accuracy_radius'];

			if ($fraud_info['ip_net_speed_cell']) {
				$this->data['ip_net_speed_cell'] = $fraud_info['ip_net_speed_cell'];
			} else {
				$this->data['ip_net_speed_cell'] = '';
			}

			$this->data['ip_metro_code'] = $fraud_info['ip_metro_code'];
			$this->data['ip_area_code'] = $fraud_info['ip_area_code'];

			if ($fraud_info['ip_time_zone']) {
				$this->data['ip_time_zone'] = $fraud_info['ip_time_zone'];
			} else {
				$this->data['ip_time_zone'] = '';
			}

			if ($fraud_info['ip_region_name']) {
				$this->data['ip_region_name'] = $fraud_info['ip_region_name'];
			} else {
				$this->data['ip_region_name'] = '';
			}

			if ($fraud_info['ip_domain']) {
				$this->data['ip_domain'] = $fraud_info['ip_domain'];
			} else {
				$this->data['ip_domain'] = '';
			}

			if ($fraud_info['ip_country_name']) {
				$this->data['ip_country_name'] = $fraud_info['ip_country_name'];
			} else {
				$this->data['ip_country_name'] = '';
			}

			if ($fraud_info['ip_continent_code']) {
				$this->data['ip_continent_code'] = $fraud_info['ip_continent_code'];
			} else {
				$this->data['ip_continent_code'] = '';
			}

			if ($fraud_info['ip_corporate_proxy']) {
				$this->data['ip_corporate_proxy'] = $fraud_info['ip_corporate_proxy'];
			} else {
				$this->data['ip_corporate_proxy'] = '';
			}

			$this->data['anonymous_proxy'] = $fraud_info['anonymous_proxy'];
			$this->data['proxy_score'] = $fraud_info['proxy_score'];

			if ($fraud_info['is_trans_proxy']) {
				$this->data['is_trans_proxy'] = $fraud_info['is_trans_proxy'];
			} else {
				$this->data['is_trans_proxy'] = '';
			}

			$this->data['free_mail'] = $fraud_info['free_mail'];
			$this->data['carder_email'] = $fraud_info['carder_email'];

			if ($fraud_info['high_risk_username']) {
				$this->data['high_risk_username'] = $fraud_info['high_risk_username'];
			} else {
				$this->data['high_risk_username'] = '';
			}

			if ($fraud_info['high_risk_password']) {
				$this->data['high_risk_password'] = $fraud_info['high_risk_password'];
			} else {
				$this->data['high_risk_password'] = '';
			}

			$this->data['bin_match'] = $fraud_info['bin_match'];

			if ($fraud_info['bin_country']) {
				$this->data['bin_country'] = $fraud_info['bin_country'];
			} else {
				$this->data['bin_country'] = '';
			}

			$this->data['bin_name_match'] = $fraud_info['bin_name_match'];

			if ($fraud_info['bin_name']) {
				$this->data['bin_name'] = $fraud_info['bin_name'];
			} else {
				$this->data['bin_name'] = '';
			}

			$this->data['bin_phone_match'] = $fraud_info['bin_phone_match'];

			if ($fraud_info['bin_phone']) {
				$this->data['bin_phone'] = $fraud_info['bin_phone'];
			} else {
				$this->data['bin_phone'] = '';
			}

			if ($fraud_info['customer_phone_in_billing_location']) {
				$this->data['customer_phone_in_billing_location'] = $fraud_info['customer_phone_in_billing_location'];
			} else {
				$this->data['customer_phone_in_billing_location'] = '';
			}

			$this->data['ship_forward'] = $fraud_info['ship_forward'];

			if ($fraud_info['city_postal_match']) {
				$this->data['city_postal_match'] = $fraud_info['city_postal_match'];
			} else {
				$this->data['city_postal_match'] = '';
			}

			if ($fraud_info['ship_city_postal_match']) {
				$this->data['ship_city_postal_match'] = $fraud_info['ship_city_postal_match'];
			} else {
				$this->data['ship_city_postal_match'] = '';
			}

			$this->data['score'] = $fraud_info['score'];
			$this->data['explanation'] = $fraud_info['explanation'];
			$this->data['risk_score'] = $fraud_info['risk_score'];
			$this->data['queries_remaining'] = $fraud_info['queries_remaining'];
			$this->data['maxmind_id'] = $fraud_info['maxmind_id'];
			$this->data['error'] = $fraud_info['error'];

			$this->template = 'fraud/maxmind_info.tpl';

			$this->response->setOutput($this->render());
		}
	}
}
