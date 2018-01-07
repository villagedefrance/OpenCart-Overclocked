<?php
class ControllerFeedStoreya extends Controller {
	private $error = array();
	private $_name = 'storeya';

	public function index() {
		$this->language->load('feed/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('storeya', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('feed/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_link'] = $this->language->get('text_link');

		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_limits'] = $this->language->get('entry_limits');
		$this->data['entry_currency'] = $this->language->get('entry_currency');
		$this->data['entry_language'] = $this->language->get('entry_language');
		$this->data['entry_data_feed'] = $this->language->get('entry_data_feed');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['storeya_link'] = html_entity_decode('http://www.storeya.com/partners/opencart', ENT_QUOTES, 'UTF-8');

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
			'text'      => $this->language->get('text_feed'),
			'href'      => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('feed/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('feed/storeya', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['storeya_status'])) {
			$this->data['storeya_status'] = $this->request->post['storeya_status'];
			$this->data['fromcount'] = $this->request->post['fromcount'];
			$this->data['tocount'] = $this->request->post['tocount'];
			$this->data['currency'] = $this->request->post['currency'];
			$this->data['language'] = $this->request->post['language'];
		} else {
			$this->data['storeya_status'] = $this->config->get('storeya_status');
			$this->data['fromcount'] = $this->config->get('fromcount');
			$this->data['tocount'] = $this->config->get('tocount');
			$this->data['currency'] = $this->config->get('currency');
			$this->data['language'] = $this->config->get('language');
		}

		$this->load->model('localisation/currency');

		$data = array();

		$currencies = $this->model_localisation_currency->getCurrencies($data);

		foreach ($currencies as $result) {
			$this->data['currencies'][] = array(
				'currency_id' => $result['currency_id'],
				'title'       => $result['title'],
				'code'        => $result['code'],
				'value'       => $result['value']
			);
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages($data);

		foreach ($languages as $result) {
			$this->data['languages'][] = array(
				'language_id' => $result['language_id'],
				'name'        => $result['name'],
				'code'        => $result['code']
			);
		}

		$this->data['data_feed'] = HTTP_CATALOG . 'index.php?route=feed/storeya';

		$this->template = 'feed/storeya.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'feed/storeya')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
