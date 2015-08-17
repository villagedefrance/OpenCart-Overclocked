<?php
class ControllerCommonFooter extends Controller {

	protected function index() {
		$this->language->load('common/footer');

		// Footer
		$this->load->model('design/footer');

		$this->data['total_footers'] = $this->model_design_footer->getTotalFooters();

		$this->data['footer_routes'] = array();
		$this->data['footer_blocks'] = array();

		$max_position = $this->model_design_footer->getFooterMaxPosition();

		if ($max_position == 4) {
			$this->data['column_width'] = '18%';
		} elseif ($max_position == 3) {
			$this->data['column_width'] = '24%';
		} elseif ($max_position == 2) {
			$this->data['column_width'] = '36%';
		} else {
			$this->data['column_width'] = '72%';
		}

		$routes = $this->model_design_footer->getFooterRoutes(0);

		if ($routes) {
			foreach ($routes as $route) {
				if ($route['external_link']) {
					$href = html_entity_decode($route['route'], ENT_QUOTES, 'UTF-8');
				} else {
					$href = $this->url->link($route['route']);
				}

				$this->data['footer_routes'][] = array(
					'footer_id'	=> $route['footer_id'],
					'title'			=> $route['title'],
					'route'		=> $href
				);

				$this->data['footer_blocks'] = array();

				$blocks = $this->model_design_footer->getFooters();

				if ($blocks) {
					foreach ($blocks as $block) {
						$this->data['footer_blocks'][] = array(
							'footer_id'	=> $block['footer_id'],
							'name'		=> $block['name'],
							'position'		=> $block['position'],
							'status'		=> $block['status']
						);
					}
				}
			}
		} else {
			$this->data['footer_blocks'] = 0;
		}

		$this->data['company'] = $this->config->get('config_title');
		$this->data['address'] = $this->config->get('config_address');
		$this->data['telephone'] = $this->config->get('config_telephone');
		$this->data['email'] = $this->config->get('config_email');

		$this->data['facebook'] = html_entity_decode($this->config->get('config_facebook'), ENT_QUOTES, 'UTF-8');
		$this->data['twitter'] = html_entity_decode($this->config->get('config_twitter'), ENT_QUOTES, 'UTF-8');
		$this->data['google'] = html_entity_decode($this->config->get('config_google'), ENT_QUOTES, 'UTF-8');
		$this->data['pinterest'] = html_entity_decode($this->config->get('config_pinterest'), ENT_QUOTES, 'UTF-8');
		$this->data['skype'] = $this->config->get('config_skype');

		$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}

		$this->render();
	}
}
?>