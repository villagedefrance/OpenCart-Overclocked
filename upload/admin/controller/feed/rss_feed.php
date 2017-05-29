<?php
class ControllerFeedRSSFeed extends Controller {
	private $error = array();
	private $_name = 'rss_feed';

	public function index() {
		$this->language->load('feed/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('feed/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_feed'] = $this->language->get('text_feed');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_data_feed'] = $this->language->get('entry_data_feed');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_show_price'] = $this->language->get('entry_show_price');
		$this->data['entry_include_tax'] = $this->language->get('entry_include_tax');
		$this->data['entry_show_image'] = $this->language->get('entry_show_image');
		$this->data['entry_image_size'] = $this->language->get('entry_image_size');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['limit'])) {
			$this->data['error_limit'] = $this->error['limit'];
		} else {
			$this->data['error_limit'] = '';
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

		$this->data['action'] = $this->url->link('feed/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post[$this->_name . '_status'])) {
			$this->data[$this->_name . '_status'] = $this->request->post[$this->_name . '_status'];
		} else {
			$this->data[$this->_name . '_status'] = $this->config->get($this->_name . '_status');
		}

		if (isset($this->request->post[$this->_name . '_limit'])) {
			$this->data[$this->_name . '_limit'] = $this->request->post[$this->_name . '_limit'];
		} else {
			$this->data[$this->_name . '_limit'] = $this->config->get($this->_name . '_limit');
		}

		if (isset($this->request->post[$this->_name . '_show_price'])) {
			$this->data[$this->_name . '_show_price'] = $this->request->post[$this->_name . '_show_price'];
		} else {
			$this->data[$this->_name . '_show_price'] = $this->config->get($this->_name . '_show_price');
		}

		if (isset($this->request->post[$this->_name . '_include_tax'])) {
			$this->data[$this->_name . '_include_tax'] = $this->request->post[$this->_name . '_include_tax'];
		} else {
			$this->data[$this->_name . '_include_tax'] = $this->config->get($this->_name . '_include_tax');
		}

		if (isset($this->request->post[$this->_name . '_show_image'])) {
			$this->data[$this->_name . '_show_image'] = $this->request->post[$this->_name . '_show_image'];
		} else {
			$this->data[$this->_name . '_show_image'] = $this->config->get($this->_name . '_show_image');
		}

		if (isset($this->request->post[$this->_name . '_image_width'])) {
			$this->data[$this->_name . '_image_width'] = $this->request->post[$this->_name . '_image_width'];
		} else {
			$this->data[$this->_name . '_image_width'] = $this->config->get($this->_name . '_image_width') ? $this->config->get($this->_name . '_image_width') : 100;
		}

		if (isset($this->request->post[$this->_name . '_image_height'])) {
			$this->data[$this->_name . '_image_height'] = $this->request->post[$this->_name . '_image_height'];
		} else {
			$this->data[$this->_name . '_image_height'] = $this->config->get($this->_name . '_image_height') ? $this->config->get($this->_name . '_image_height') : 100;
		}

		$this->data['data_feed'] = ($this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG) . 'index.php?route=feed/rss_feed';

		$this->template = 'feed/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'feed/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((!$this->request->post[$this->_name . '_limit']) || (!is_numeric($this->request->post[$this->_name . '_limit']))) {
			$this->error['limit'] = $this->language->get('error_integer');
		}

		return empty($this->error);
	}
}
