<?php
class ControllerModuleManufacturer extends Controller {
	private $_name = 'manufacturer';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/manufacturer');

		$this->data['heading_title'] = $this->language->get('heading_title');

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme');
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		if (!$this->data['title']) {
			$this->data['title'] = $this->data['heading_title'];
		}

		$this->load->model('tool/image');
		$this->load->model('catalog/manufacturer');

		$this->data['manufacturers'] = array();

		$data = array(
			'order' => 'ASC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_catalog_manufacturer->getManufacturers($data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 48, 48);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 48, 48);
			}

			$this->data['manufacturers'][] = array(
				'manufacturer_id' => $result['manufacturer_id'],
				'image'           => $image,
				'name'            => $result['name'],
				'href'            => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'], 'SSL')
			);
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
