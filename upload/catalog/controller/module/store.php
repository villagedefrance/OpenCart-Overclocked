<?php
class ControllerModuleStore extends Controller {
	private $_name = 'store';

	protected function index($setting) {
		$status = true;

		if (isset($setting['permission'])) {
			$this->load->library('user');

			$this->user = new User($this->registry);

			$status = $this->user->isLogged();
		}

		if ($status) {
			$this->language->load('module/' . $this->_name);

			$this->data['heading_title'] = $this->language->get('heading_title');

			// Module
			$this->data['theme'] = $this->config->get($this->_name . '_theme');
			$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

			if (!$this->data['title']) {
				$this->data['title'] = $this->data['heading_title'];
			}

			$this->data['text_selector'] = $this->language->get('text_selector');
			$this->data['text_default'] = $this->language->get('text_default');

			if ($this->user) {
				$this->data['username'] = $this->user->getUserName();
			} else {
				$this->data['username'] = '';
			}

			if ($this->user) {
				$this->data['userid'] = $this->user->getId();
			} else {
				$this->data['userid'] = '';
			}

			$this->data['store_id'] = $this->config->get('config_store_id');

			$this->data['stores'] = array();

			$this->data['stores'][] = array(
				'store_id' => 0,
				'name'     => $this->language->get('text_default'),
				'url'      => HTTP_SERVER . 'index.php?route=common/home&session_id=' . $this->session->getId()
			);

			$this->load->model('setting/store');

			$results = $this->model_setting_store->getStores();

			foreach ($results as $result) {
				$this->data['stores'][] = array(
					'store_id' => $result['store_id'],
					'name'     => $result['name'],
					'url'      => $result['url'] . 'index.php?route=common/home&session_id=' . $this->session->getId()
				);
			}

			if (isset($setting['access'])) {
				$this->data['access'] = 1;
			} else {
				$this->data['access'] = 0;
			}

			$this->data['button_adminlogin'] = $this->language->get('button_adminlogin');

			$this->data['adminlogin'] = HTTPS_SERVER . 'admin/index.php?route=common/login';

			// Template
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
			} else {
				$this->template = 'default/template/module/' . $this->_name . '.tpl';
			}

			$this->render();
		}
	}
}
