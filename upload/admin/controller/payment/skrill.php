<?php
class ControllerPaymentSkrill extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/skrill');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('skrill', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/skrill', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');

		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_secret'] = $this->language->get('entry_secret');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total_max'] = $this->language->get('entry_total_max');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_pending_status'] = $this->language->get('entry_pending_status');
		$this->data['entry_canceled_status'] = $this->language->get('entry_canceled_status');
		$this->data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$this->data['entry_chargeback_status'] = $this->language->get('entry_chargeback_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_custnote'] = $this->language->get('entry_custnote');

		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_total_max'] = $this->language->get('help_total_max');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/skrill', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/skrill', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['skrill_email'])) {
			$this->data['skrill_email'] = $this->request->post['skrill_email'];
		} else {
			$this->data['skrill_email'] = $this->config->get('skrill_email');
		}

		if (isset($this->request->post['skrill_secret'])) {
			$this->data['skrill_secret'] = $this->request->post['skrill_secret'];
		} else {
			$this->data['skrill_secret'] = $this->config->get('skrill_secret');
		}

		if (isset($this->request->post['skrill_total'])) {
			$this->data['skrill_total'] = $this->request->post['skrill_total'];
		} else {
			$this->data['skrill_total'] = $this->config->get('skrill_total');
		}

		if (isset($this->request->post['skrill_total_max'])) {
			$this->data['skrill_total_max'] = $this->request->post['skrill_total_max'];
		} else {
			$this->data['skrill_total_max'] = $this->config->get('skrill_total_max');
		}

		if (isset($this->request->post['skrill_order_status_id'])) {
			$this->data['skrill_order_status_id'] = $this->request->post['skrill_order_status_id'];
		} else {
			$this->data['skrill_order_status_id'] = $this->config->get('skrill_order_status_id');
		}

		if (isset($this->request->post['skrill_pending_status_id'])) {
			$this->data['skrill_pending_status_id'] = $this->request->post['skrill_pending_status_id'];
		} else {
			$this->data['skrill_pending_status_id'] = $this->config->get('skrill_pending_status_id');
		}

		if (isset($this->request->post['skrill_canceled_status_id'])) {
			$this->data['skrill_canceled_status_id'] = $this->request->post['skrill_canceled_status_id'];
		} else {
			$this->data['skrill_canceled_status_id'] = $this->config->get('skrill_canceled_status_id');
		}

		if (isset($this->request->post['skrill_failed_status_id'])) {
			$this->data['skrill_failed_status_id'] = $this->request->post['skrill_failed_status_id'];
		} else {
			$this->data['skrill_failed_status_id'] = $this->config->get('skrill_failed_status_id');
		}

		if (isset($this->request->post['skrill_chargeback_status_id'])) {
			$this->data['skrill_chargeback_status_id'] = $this->request->post['skrill_chargeback_status_id'];
		} else {
			$this->data['skrill_chargeback_status_id'] = $this->config->get('skrill_chargeback_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['skrill_geo_zone_id'])) {
			$this->data['skrill_geo_zone_id'] = $this->request->post['skrill_geo_zone_id'];
		} else {
			$this->data['skrill_geo_zone_id'] = $this->config->get('skrill_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['skrill_status'])) {
			$this->data['skrill_status'] = $this->request->post['skrill_status'];
		} else {
			$this->data['skrill_status'] = $this->config->get('skrill_status');
		}

		if (isset($this->request->post['skrill_sort_order'])) {
			$this->data['skrill_sort_order'] = $this->request->post['skrill_sort_order'];
		} else {
			$this->data['skrill_sort_order'] = $this->config->get('skrill_sort_order');
		}

		if (isset($this->request->post['skrill_custnote'])) {
			$this->data['skrill_custnote'] = $this->request->post['skrill_custnote'];
		} else {
			$this->data['skrill_custnote'] = $this->config->get('skrill_custnote');
		}

		$this->template = 'payment/skrill.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/skrill')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['skrill_email']) {
			// Email MX Record check
			$this->load->model('tool/email');

			$email_valid = $this->model_tool_email->verifyMail($this->request->post['skrill_email']);

			if (!preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['skrill_email']) || !$email_valid) {
				$this->error['email'] = $this->language->get('error_email');
			}

		} else {
			$this->error['email'] = $this->language->get('error_email');
		}

		return empty($this->error);
	}
}
