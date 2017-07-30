<?php
class ControllerModuleLocation extends Controller {
	private $_name = 'location';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');

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

				$this->data['locations'][] = array(
					'location_id' => $result['location_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'address'     => nl2br($result['address']),
					'details'     => sprintf($this->language->get('text_details'), $this->url->link('module/location/info', 'location_id=' . $result['location_id'], 'SSL'), $result['name'])
				);

				$this->data['location_id'] = $result['location_id'];
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

	public function info() {
		$this->load->model('localisation/location');

		$template = $this->config->get('config_template');

		$location_info = $this->model_localisation_location->getLocation($this->request->get['location_id']);

		if ($location_info) {
			$output = '<html dir="ltr" lang="en">' . "\n";
			$output .= '<head>' . "\n";
			$output .= '  <title>' . $location_info['name'] . '</title>' . "\n";
			$output .= '  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
			$output .= '  <meta name="robots" content="noindex">' . "\n";
			$output .= '</head>' . "\n";
			$output .= '<body>' . "\n";
			$output .= '  <h1>' . $location_info['name'] . '</h1>' . "\n";
			$output .= '  <p style="margin-left:20px;"><img src="catalog/view/theme/' . $template . '/image/location/address.png" alt="" />&nbsp;&nbsp;' . html_entity_decode(nl2br($location_info['address']), ENT_QUOTES, 'UTF-8') . '</p>' . "\n";
			if ($location_info['telephone']) {
				$output .= '  <p style="margin-left:20px;"><img src="catalog/view/theme/' . $template . '/image/location/phone.png" alt="" />&nbsp;&nbsp;<b>' . html_entity_decode($location_info['telephone'], ENT_QUOTES, 'UTF-8') . '</b></p>' . "\n";
			}
			if ($location_info['open']) {
				$output .= '  <p style="margin-left:20px;"><img src="catalog/view/theme/' . $template . '/image/location/time.png" alt="" />&nbsp;&nbsp;' . html_entity_decode(nl2br($location_info['open']), ENT_QUOTES, 'UTF-8') . '</p>' . "\n";
			}
			if ($location_info['comment']) {
				$output .= '  <p style="margin-left:20px;"><img src="catalog/view/theme/' . $template . '/image/location/infos.png" alt="" />&nbsp;&nbsp;' . html_entity_decode(nl2br($location_info['comment']), ENT_QUOTES, 'UTF-8') . '</p>' . "\n";
			}
			if ($location_info['latitude'] && $location_info['longitude']) {
				$output .= '  <p style="margin-left:20px;"><img src="catalog/view/theme/' . $template . '/image/location/global.png" alt="" />&nbsp;&nbsp; ' . html_entity_decode($location_info['latitude'], ENT_QUOTES, 'UTF-8') . '&deg; N &nbsp;&nbsp;<b>|</b>&nbsp;&nbsp; ' . html_entity_decode($location_info['longitude'], ENT_QUOTES, 'UTF-8') . '&deg; E</p>' . "\n";
			}
			$output .= '  </body>' . "\n";
			$output .= '</html>' . "\n";

			$this->response->setOutput($output);
		}
	}
}
