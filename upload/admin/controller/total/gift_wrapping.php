<?php
class ControllerTotalGiftWrapping extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('total/gift_wrapping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('gift_wrapping', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('total/gift_wrapping', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');

		$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['price'])) {
			$this->data['error_price'] = $this->error['price'];
		} else {
			$this->data['error_price'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_total'),
			'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('total/gift_wrapping', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('total/gift_wrapping', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['gift_wrapping_price'])) {
			$this->data['gift_wrapping_price'] = $this->request->post['gift_wrapping_price'];
		} else {
			$this->data['gift_wrapping_price'] = $this->config->get('gift_wrapping_price');
		}

		if (isset($this->request->post['gift_wrapping_status'])) {
			$this->data['gift_wrapping_status'] = $this->request->post['gift_wrapping_status'];
		} else {
			$this->data['gift_wrapping_status'] = $this->config->get('gift_wrapping_status');
		}

		if (isset($this->request->post['gift_wrapping_sort_order'])) {
			$this->data['gift_wrapping_sort_order'] = $this->request->post['gift_wrapping_sort_order'];
		} else {
			$this->data['gift_wrapping_sort_order'] = $this->config->get('gift_wrapping_sort_order');
		}

		$this->template = 'total/gift_wrapping.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/gift_wrapping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['gift_wrapping_price'] || !is_numeric($this->request->post['gift_wrapping_price']) || $this->request->post['gift_wrapping_price'] < 0) {
			$this->error['price'] = $this->language->get('error_price');
		}

		return empty($this->error);
	}
}
