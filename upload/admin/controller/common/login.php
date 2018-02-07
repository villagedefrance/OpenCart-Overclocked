<?php
class ControllerCommonLogin extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('common/login');

		$this->document->setTitle($this->language->get('heading_title'));

		// Delete install directory if exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$this->load->model('tool/system');

			$this->model_tool_system->deleteDirectory('../install');
		}

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['username']) && isset($this->request->post['password']) && $this->validate()) {
			$this->session->data['token'] = hash_rand('md5');

			// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
			if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) === 0 || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) === 0)) {
				$this->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
			} else {
				$this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_forgotten'] = $this->language->get('text_forgotten');

		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');

		$this->data['button_login'] = $this->language->get('button_login');

		// Stylesheet
		$this->load->model('design/administration');

		$this->model_design_administration->checkAdministrations();

		$admin_css = $this->config->get('config_admin_stylesheet');

		if (isset($admin_css)) {
			$this->data['admin_css'] = $admin_css;
		} else {
			$this->data['admin_css'] = 'classic';
		}

		if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
			$this->error['warning'] = $this->language->get('error_token');
		}

		if (isset($this->request->post['redirect'])) {
			$this->data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
			$this->data['redirect'] = $this->session->data['redirect'];

			unset($this->session->data['redirect']);
		} else {
			$this->data['redirect'] = '';
		}

		if (isset($this->error['warning'])) {
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

		$this->data['action'] = $this->url->link('common/login', '', 'SSL');

		if (isset($this->request->post['username'])) {
			$this->data['username'] = $this->request->post['username'];
		} else {
			$this->data['username'] = '';
		}

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if ($this->config->get('config_password')) {
			$this->data['forgotten'] = $this->url->link('common/forgotten', '', 'SSL');
		} else {
			$this->data['forgotten'] = '';
		}

		$this->template = 'common/login.tpl';
		$this->children = array(
			'common/header_login',
			'common/footer_login'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->login($this->request->post['username'], $this->request->post['password'])) {
			$this->error['warning'] = $this->language->get('error_login');
		}

		return empty($this->error);
	}
}
