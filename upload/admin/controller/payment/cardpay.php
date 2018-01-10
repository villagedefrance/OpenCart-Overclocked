<?php
class ControllerPaymentCardPay extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/cardpay');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('cardpay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('payment/cardpay', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['entry_cardpay_server'] = $this->language->get('entry_cardpay_server');
		$this->data['entry_cardpay_hold_only'] = $this->language->get('entry_cardpay_hold_only');
		$this->data['entry_cardpay_shop_id'] = $this->language->get('entry_cardpay_shop_id');
		$this->data['entry_cardpay_secret_key'] = $this->language->get('entry_cardpay_secret_key');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['help_hold_only'] = $this->language->get('help_hold_only');
		$this->data['help_shop_id'] = $this->language->get('help_shop_id');
		$this->data['help_secret_key'] = $this->language->get('help_secret_key');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
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
			'href'      => $this->url->link('payment/cardpay', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/cardpay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['cardpay_url_production_server'])) {
			$this->data['cardpay_url_production_server'] = $this->request->post['cardpay_url_production_server'];
		} elseif ($this->config->get('cardpay_url_production_server')) {
			$this->data['cardpay_url_production_server'] = $this->config->get('cardpay_url_production_server');
		} else {
			$this->data['cardpay_url_production_server'] = $this->language->get('cardpay_default_url_production_server');
		}

		if (isset($this->request->post['cardpay_hold_only'])) {
			$this->data['cardpay_hold_only'] = $this->request->post['cardpay_hold_only'];
		} else {
			$this->data['cardpay_hold_only'] = $this->config->get('cardpay_hold_only');
		}

		if (isset($this->request->post['cardpay_shop_id'])) {
			$this->data['cardpay_shop_id'] = $this->request->post['cardpay_shop_id'];
		} elseif ($this->config->get('cardpay_shop_id')) {
			$this->data['cardpay_shop_id'] = $this->config->get('cardpay_shop_id');
		} else {
			$this->data['cardpay_shop_id'] = $this->language->get('cardpay_default_shop_id');
		}

		if (isset($this->request->post['cardpay_secret_key'])) {
			$this->data['cardpay_secret_key'] = $this->request->post['cardpay_secret_key'];
		} elseif ($this->config->get('cardpay_secret_key')) {
			$this->data['cardpay_secret_key'] = $this->config->get('cardpay_secret_key');
		} else {
			$this->data['cardpay_secret_key'] = $this->language->get('cardpay_default_secret_key');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['cardpay_geo_zone_id'])) {
			$this->data['cardpay_geo_zone_id'] = $this->request->post['cardpay_geo_zone_id'];
		} else {
			$this->data['cardpay_geo_zone_id'] = $this->config->get('cardpay_geo_zone_id');
		}

		if (isset($this->request->post['cardpay_status'])) {
			$this->data['cardpay_status'] = $this->request->post['cardpay_status'];
		} else {
			$this->data['cardpay_status'] = $this->config->get('cardpay_status');
		}

		if (isset($this->request->post['cardpay_sort_order'])) {
			$this->data['cardpay_sort_order'] = $this->request->post['cardpay_sort_order'];
		} else {
			$this->data['cardpay_sort_order'] = $this->config->get('cardpay_sort_order');
		}

		$this->template = 'payment/cardpay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/cardpay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
