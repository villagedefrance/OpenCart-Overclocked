<?php
class ControllerModuleLocation extends Controller {
	private $_name = 'location';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

      	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_telephone'] = $this->language->get('text_telephone');
		$this->data['text_latitude'] = $this->language->get('text_latitude');
		$this->data['text_longitude'] = $this->language->get('text_longitude');

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme');
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		if (!$this->data['title']) {
			$this->data['title'] = $this->data['heading_title'];
		}

		$this->load->model('localisation/location');
		$this->load->model('tool/image');

		$this->data['locations'] = array();

		$results = $this->model_localisation_location->getLocations($setting['limit']);

		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
				} else {
					$image = false;
				}

				if ($result['open']) {
					$open = $result['open'];
				} else {
					$open = false;
				}

				if ($result['comment']) {
					$comment = $result['comment'];
				} else {
					$comment = false;
				}

				$this->data['locations'][] = array(
					'location_id'		=> $result['location_id'],
					'thumb'			=> $image,
					'name'			=> $result['name'],
					'address'   	 	=> nl2br($result['address']),
					'telephone' 		=> $result['telephone'],
					'open'			=> nl2br($open),
					'comment'		=> nl2br($comment),
					'latitude'     	=> $result['latitude'],
					'longitude'    	=> $result['longitude']
				);
			}

			$this->data['store_locations'] = true;

		} else {
			$this->data['store_locations'] = false;
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
?>