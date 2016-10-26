<?php
class ControllerModuleLinks extends Controller {
	private $_name = 'links';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->document->addStyle('catalog/view/javascript/awesome/css/font-awesome.min.css');

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme');
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		if (!$this->data['title']) {
			$this->data['title'] = $this->data['heading_title'];
		}

		// Stylesheet mode
		$template = $this->config->get('config_template');

		$stylesheet_mode = $this->config->get($template . '_stylesheet');

		if (!$stylesheet_mode) {
			$header_color = $this->config->get($this->_name . '_header_color');
			$header_shape = $this->config->get($this->_name . '_header_shape');
			$content_color = $this->config->get($this->_name . '_content_color');
			$content_shape = $this->config->get($this->_name . '_content_shape');

			$this->data['header_color'] = ($header_color) ? $header_color . '-skin' : 'white-skin';
			$this->data['header_shape'] = ($header_shape) ? $header_shape . '-top' : 'rounded-0';
			$this->data['content_color'] = ($content_color) ? $content_color . '-skin' : 'white-skin';
			$this->data['content_shape'] = ($content_shape) ? $content_shape . '-bottom' : 'rounded-0';
		} else {
			$this->data['header_color'] = '';
			$this->data['header_shape'] = '';
			$this->data['content_color'] = '';
			$this->data['content_shape'] = '';
		}

		$this->data['stylesheet_mode'] = $stylesheet_mode;

		// Connections
		$this->load->model('design/connection');

		$connection_total = $this->model_design_connection->getTotalCatalogConnections();

		if ($connection_total > 0) {
			$this->data['connections_li'] = array();

			$connections = $this->model_design_connection->getConnections(0);

			foreach ($connections as $connection) {
				if ($connection['frontend']) {
					$connection_routes = $this->model_design_connection->getConnectionRoutes($connection['connection_id']);

					foreach ($connection_routes as $connection_route) {
						$this->data['connections_li'][] = array(
							'icon' => $connection_route['icon'],
							'title' => $connection_route['title'],
							'route' => html_entity_decode($connection_route['route'], ENT_QUOTES, 'UTF-8')
						);
					}
				}
			}

			$this->data['connection_exist'] = true;
		} else {
			$this->data['connection_exist'] = false;
		}

		$this->data['module'] = $module++;

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
