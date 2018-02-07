<?php
class ControllerCommonHeaderLogin extends Controller {

	protected function index() {
		$this->data['title'] = $this->document->getTitle();

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$this->data['base'] = HTTPS_SERVER;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');

		$this->language->load('common/header');

		$this->data['heading_title'] = $this->language->get('heading_title');

		// Stylesheet
		$admin_css = $this->config->get('config_admin_stylesheet');

		if (isset($admin_css)) {
			$this->data['admin_css'] = $admin_css;
		} else {
			$this->data['admin_css'] = 'classic';
		}

		// Display Limit
		$display_limit = $this->config->get('config_admin_width_limit');

		$this->data['resolution'] = ($display_limit) ? 'limited' : 'normal';

		// Text
		$this->data['text_confirm'] = $this->language->get('text_confirm');

		// Header
		if (!$this->user->isLogged() || !isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$this->data['logged'] = false;

			$this->data['home'] = $this->url->link('common/login', '', 'SSL');

		} else {
			$this->data['logged'] = true;

			$this->load->model('user/user');
			$this->load->model('tool/image');

			$user_info = $this->model_user_user->getUser($this->user->getId());

			if ($user_info) {
				$this->data['username'] = $user_info['username'];
				$this->data['user_id'] = $user_info['user_id'];

				if (is_file(DIR_IMAGE . $user_info['image'])) {
					$this->data['avatar'] = $this->model_tool_image->resize($user_info['image'], 26, 26);
				} else {
					$this->data['avatar'] = $this->model_tool_image->resize('no_avatar.jpg', 26, 26);
				}

				$this->data['user_profile'] = $this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $user_info['user_id'], 'SSL');
			} else {
				$this->data['username'] = '';
				$this->data['user_id'] = '';
				$this->data['avatar'] = '';
				$this->data['user_profile'] = '';
			}

			// Robots
			$this->data['track_robots'] = $this->config->get('config_robots_online');
		}

		$this->template = 'common/header_login.tpl';
		$this->render();
	}
}
