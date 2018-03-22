<?php
class ControllerCommonFooter extends Controller {

	protected function index() {
		$this->language->load('common/footer');

		$this->data['scripts'] = $this->document->getScripts();

		// Footer
		$this->load->model('design/footer');

		$this->data['total_footers'] = $this->model_design_footer->getTotalFooters();

		$this->data['footer_routes'] = array();
		$this->data['footer_blocks'] = array();

		$this->data['max_position'] = $this->model_design_footer->getFooterMaxPosition();

		$routes = $this->model_design_footer->getFooterRoutes(0);

		if ($routes) {
			foreach ($routes as $route) {
				if ($route['external_link']) {
					$href = html_entity_decode($route['route'], ENT_QUOTES, 'UTF-8');
				} else {
					$href = $this->url->link($route['route']);
				}

				$this->data['footer_routes'][] = array(
					'footer_id' => $route['footer_id'],
					'title'     => $route['title'],
					'route'     => $href
				);

				$this->data['footer_blocks'] = array();

				$blocks = $this->model_design_footer->getFooters();

				if ($blocks) {
					foreach ($blocks as $block) {
						$this->data['footer_blocks'][] = array(
							'footer_id' => $block['footer_id'],
							'name'      => $block['name'],
							'position'  => $block['position'],
							'status'    => $block['status']
						);
					}
				}
			}

		} else {
			$this->data['footer_blocks'] = 0;
		}

		$this->data['company'] = $this->config->get('config_name');
		$this->data['address'] = nl2br($this->config->get('config_address'));
		$this->data['telephone'] = $this->config->get('config_telephone');
		$this->data['email'] = $this->config->get('config_email');

		$this->data['facebook'] = html_entity_decode($this->config->get('config_facebook'), ENT_QUOTES, 'UTF-8');
		$this->data['twitter'] = html_entity_decode($this->config->get('config_twitter'), ENT_QUOTES, 'UTF-8');
		$this->data['google'] = html_entity_decode($this->config->get('config_google'), ENT_QUOTES, 'UTF-8');
		$this->data['pinterest'] = html_entity_decode($this->config->get('config_pinterest'), ENT_QUOTES, 'UTF-8');
		$this->data['instagram'] = html_entity_decode($this->config->get('config_instagram'), ENT_QUOTES, 'UTF-8');
		$this->data['skype'] = $this->config->get('config_skype');

		$template = $this->config->get('config_template');

		$web_design = $this->config->get($template . '_web_design');

		$this->data['web_design'] = $web_design ? html_entity_decode($web_design, ENT_QUOTES, 'UTF-8') : '';

		$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Theme
		$footer_theme = $this->config->get($template . '_footer_theme');
		$footer_color = $this->config->get($template . '_footer_color');
		$footer_shape = $this->config->get($template . '_footer_shape');

		$mod_color = ($footer_color) ? $footer_color . '-skin' : 'white-skin';
		$mod_shape = ($footer_shape) ? $footer_shape : 'rounded-0';

		if ($footer_theme == 'custom') {
			$this->document->addStyle('catalog/view/theme/' . $template . '/stylesheet/footer-custom.css');

			if ($mod_color == 'white-skin' || $mod_color == 'beige-skin' || $mod_color == 'ash-skin' || $mod_color == 'silver-skin' || $mod_color == 'citrus-skin' || $mod_color == 'yellow-skin' || $mod_color == 'mist-skin' || $mod_color == 'clear-skin') {
				$footer_class = 'footer-dark';
			} else {
				$footer_class = 'footer-light';
			}

		} else {
			$this->document->addStyle('catalog/view/theme/' . $template . '/stylesheet/footer.css');

			$mod_color = '';
			$mod_shape = '';

			$footer_class = 'footer-' . $footer_theme;
		}

		$this->data['mod_color'] = $mod_color;
		$this->data['mod_shape'] = $mod_shape;

		$this->data['footer_class'] = $footer_class;

		// Matomo
		$this->data['matomo'] = html_entity_decode($this->config->get('config_matomo_analytics'), ENT_QUOTES, 'UTF-8');

		// Whos Online
		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$user_agent = $this->request->server['HTTP_USER_AGENT'];

			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if ($this->config->get('config_customer_online')) {
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

				$this->model_tool_online->whosOnline($ip, $this->customer->getId(), $url, $referer, $user_agent);
			}

			// Robot log
			if ($this->config->get('config_robots_online')) {
				$lower_agent = strtolower($this->request->server['HTTP_USER_AGENT']);

				$signatures = $this->model_tool_online->getRobotSignatures();

				foreach ($signatures as $signature) {
					$robot_signature = strtolower($signature['signature']);

					if (strpos($lower_agent, $robot_signature)) {
						$robot_name = $signature['name'];
						break;
					}
				}

				if (isset($robot_name)) {
					$this->model_tool_online->robotsOnline($ip, $robot_name, $user_agent);
				}
			}
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

	public function add() {
		$this->load->model('design/banner');

		$json = array();

		if (isset($this->request->post['banner_image_id'])) {
			$banner_image_id = $this->request->post['banner_image_id'];
		} else {
			$banner_image_id = 0;
		}

		$this->model_design_banner->updateClicked($banner_image_id);

		$json['success'] = 'clicked';

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
