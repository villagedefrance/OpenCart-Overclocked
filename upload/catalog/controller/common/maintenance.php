<?php
class ControllerCommonMaintenance extends Controller {

	public function index() {
		if ($this->config->get('config_maintenance')) {
			$route = '';

			if (isset($this->request->get['route'])) {
				$part = explode('/', $this->request->get['route']);

				if (isset($part[0])) {
					$route .= $part[0];
				}
			}

			// Show site if logged in as admin
			$this->load->library('user');

			$this->user = new User($this->registry);

			if (($route != 'payment') && !$this->user->isLogged()) {
				return $this->forward('common/maintenance/info');
			}
		}
	}

	public function info() {
		$this->language->load('common/maintenance');

		$this->document->setTitle($this->language->get('heading_title'));

		if ($this->request->server['SERVER_PROTOCOL'] == 'HTTP/1.1') {
			$this->response->addHeader('HTTP/1.1 503 Service Unavailable');
		} else {
			$this->response->addHeader('HTTP/1.0 503 Service Unavailable');
		}

		$this->response->addHeader('Retry-After: 3600');

		// Breadcrumbs
		$this->data['hidecrumbs'] = $this->config->get('config_breadcrumbs');

		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'text'		=> $this->language->get('text_maintenance'),
			'href'		=> $this->url->link('common/maintenance'),
			'separator' => false
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['message'] = $this->language->get('text_message');

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/maintenance.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/maintenance.tpl';
		} else {
			$this->template = 'default/template/common/maintenance.tpl';
		}

		$this->children = array(
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}
}
?>