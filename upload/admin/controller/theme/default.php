<?php
class ControllerThemeDefault extends Controller {
	private $error = array();
	private $_name = 'default';

	public function index() {
		$this->language->load('theme/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('theme/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/theme', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_theme'] = $this->language->get('text_theme');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_light'] = $this->language->get('text_light');
		$this->data['text_dark'] = $this->language->get('text_dark');
		$this->data['text_custom'] = $this->language->get('text_custom');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_active'] = $this->language->get('text_active');
		$this->data['text_not_active'] = $this->language->get('text_not_active');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_footer'] = $this->language->get('tab_footer');
		$this->data['tab_options'] = $this->language->get('tab_options');
		$this->data['tab_setup'] = $this->language->get('tab_setup');
		$this->data['tab_credits'] = $this->language->get('tab_credits');

		$this->data['entry_widescreen'] = $this->language->get('entry_widescreen');
		$this->data['entry_breadcrumbs'] = $this->language->get('entry_breadcrumbs');
		$this->data['entry_back_to_top'] = $this->language->get('entry_back_to_top');
		$this->data['entry_right_click'] = $this->language->get('entry_right_click');
		$this->data['entry_web_design'] = $this->language->get('entry_web_design');
		$this->data['entry_powered_by'] = $this->language->get('entry_powered_by');
		$this->data['entry_footer_theme'] = $this->language->get('entry_footer_theme');
		$this->data['entry_footer_color'] = $this->language->get('entry_footer_color');
		$this->data['entry_footer_shape'] = $this->language->get('entry_footer_shape');
		$this->data['entry_footer_big_column'] = $this->language->get('entry_footer_big_column');
		$this->data['entry_footer_location'] = $this->language->get('entry_footer_location');
		$this->data['entry_footer_phone'] = $this->language->get('entry_footer_phone');
		$this->data['entry_footer_email'] = $this->language->get('entry_footer_email');
		$this->data['entry_footer_facebook'] = $this->language->get('entry_footer_facebook');
		$this->data['entry_footer_twitter'] = $this->language->get('entry_footer_twitter');
		$this->data['entry_footer_google'] = $this->language->get('entry_footer_google');
		$this->data['entry_footer_pinterest'] = $this->language->get('entry_footer_pinterest');
		$this->data['entry_footer_instagram'] = $this->language->get('entry_footer_instagram');
		$this->data['entry_footer_skype'] = $this->language->get('entry_footer_skype');
		$this->data['entry_livesearch'] = $this->language->get('entry_livesearch');
		$this->data['entry_livesearch_limit'] = $this->language->get('entry_livesearch_limit');
		$this->data['entry_product_stock_low'] = $this->language->get('entry_product_stock_low');
		$this->data['entry_product_stock_limit'] = $this->language->get('entry_product_stock_limit');
		$this->data['entry_manufacturer_name'] = $this->language->get('entry_manufacturer_name');
		$this->data['entry_manufacturer_image'] = $this->language->get('entry_manufacturer_image');

		$this->data['setup_system'] = $this->language->get('setup_system');
		$this->data['setup_theme'] = $this->language->get('setup_theme');
		$this->data['setup_module'] = $this->language->get('setup_module');

		$this->data['info_theme'] = $this->language->get('info_theme');
		$this->data['info_author'] = $this->language->get('info_author');
		$this->data['info_license'] = $this->language->get('info_license');
		$this->data['info_support'] = $this->language->get('info_support');
		$this->data['info_preview'] = $this->language->get('info_preview');

		$this->data['text_info_theme'] = $this->language->get('text_info_theme');
		$this->data['text_info_author'] = $this->language->get('text_info_author');
		$this->data['text_info_license'] = $this->language->get('text_info_license');
		$this->data['text_info_support'] = $this->language->get('text_info_support');

		$this->data['button_settings'] = $this->language->get('button_settings');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_theme'),
			'href'      => $this->url->link('extension/theme', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('theme/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['settings'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['action'] = $this->url->link('theme/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/theme', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['stylesheet_mode'] = $this->config->get('config_stylesheet');

		// Check active template
		$template = $this->config->get('config_template');

		if ($template == $this->_name) {
			$this->data['active'] = true;
		} else {
			$this->data['active'] = false;
		}

		// Get template preview
		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$server = HTTPS_CATALOG;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$server = HTTPS_CATALOG;
		} else {
			$server = HTTP_CATALOG;
		}

		if (file_exists(DIR_IMAGE . 'templates/' . $this->_name . '.png')) {
			$image = $server . 'image/templates/' . $this->_name . '.png';
		} else {
			$image = $server . 'image/no_image.jpg';
		}

		$this->data['image_preview'] = '<img src="' . $image . '" alt="" style="border:1px solid #EEE;" />';

		// General
		$this->data['display_sizes'] = array();

		$this->data['display_sizes'][] = array('format' => 'normal', 'title' => 'Normal');
		$this->data['display_sizes'][] = array('format' => 'wide', 'title' => 'Widescreen');
		$this->data['display_sizes'][] = array('format' => 'full', 'title' => 'Fullscreen');

		if (isset($this->request->post[$this->_name . '_widescreen'])) {
			$this->data[$this->_name . '_widescreen'] = $this->request->post[$this->_name . '_widescreen'];
		} elseif ($this->config->get($this->_name . '_widescreen')) {
			$this->data[$this->_name . '_widescreen'] = $this->config->get($this->_name . '_widescreen');
		} else {
			$this->data[$this->_name . '_widescreen'] = 'normal';
		}

		if (isset($this->request->post[$this->_name . '_breadcrumbs'])) {
			$this->data[$this->_name . '_breadcrumbs'] = $this->request->post[$this->_name . '_breadcrumbs'];
		} else {
			$this->data[$this->_name . '_breadcrumbs'] = $this->config->get($this->_name . '_breadcrumbs');
		}

		if (isset($this->request->post[$this->_name . '_back_to_top'])) {
			$this->data[$this->_name . '_back_to_top'] = $this->request->post[$this->_name . '_back_to_top'];
		} else {
			$this->data[$this->_name . '_back_to_top'] = $this->config->get($this->_name . '_back_to_top');
		}

		if (isset($this->request->post[$this->_name . '_right_click'])) {
			$this->data[$this->_name . '_right_click'] = $this->request->post[$this->_name . '_right_click'];
		} else {
			$this->data[$this->_name . '_right_click'] = $this->config->get($this->_name . '_right_click');
		}

		if (isset($this->request->post[$this->_name . '_web_design'])) {
			$this->data[$this->_name . '_web_design'] = $this->request->post[$this->_name . '_web_design'];
		} else {
			$this->data[$this->_name . '_web_design'] = $this->config->get($this->_name . '_web_design');
		}

		if (isset($this->request->post[$this->_name . '_powered_by'])) {
			$this->data[$this->_name . '_powered_by'] = $this->request->post[$this->_name . '_powered_by'];
		} else {
			$this->data[$this->_name . '_powered_by'] = $this->config->get($this->_name . '_powered_by');
		}

		// Footer
		if (isset($this->request->post[$this->_name . '_footer_theme'])) {
			$this->data[$this->_name . '_footer_theme'] = $this->request->post[$this->_name . '_footer_theme'];
		} else {
			$this->data[$this->_name . '_footer_theme'] = $this->config->get($this->_name . '_footer_theme');
		}

		$this->data['skins'] = $this->model_setting_setting->getColors();

		if (isset($this->request->post[$this->_name . '_footer_color'])) {
			$this->data[$this->_name . '_footer_color'] = $this->request->post[$this->_name . '_footer_color'];
		} else {
			$this->data[$this->_name . '_footer_color'] = $this->config->get($this->_name . '_footer_color');
		}

		$this->data['shapes'] = $this->model_setting_setting->getShapes();

		if (isset($this->request->post[$this->_name . '_footer_shape'])) {
			$this->data[$this->_name . '_footer_shape'] = $this->request->post[$this->_name . '_footer_shape'];
		} else {
			$this->data[$this->_name . '_footer_shape'] = $this->config->get($this->_name . '_footer_shape');
		}

		if (isset($this->request->post[$this->_name . '_footer_big_column'])) {
			$this->data[$this->_name . '_footer_big_column'] = $this->request->post[$this->_name . '_footer_big_column'];
		} else {
			$this->data[$this->_name . '_footer_big_column'] = $this->config->get($this->_name . '_footer_big_column');
		}

		if (isset($this->request->post[$this->_name . '_footer_location'])) {
			$this->data[$this->_name . '_footer_location'] = $this->request->post[$this->_name . '_footer_location'];
		} else {
			$this->data[$this->_name . '_footer_location'] = $this->config->get($this->_name . '_footer_location');
		}

		if (isset($this->request->post[$this->_name . '_footer_phone'])) {
			$this->data[$this->_name . '_footer_phone'] = $this->request->post[$this->_name . '_footer_phone'];
		} else {
			$this->data[$this->_name . '_footer_phone'] = $this->config->get($this->_name . '_footer_phone');
		}

		if (isset($this->request->post[$this->_name . '_footer_email'])) {
			$this->data[$this->_name . '_footer_email'] = $this->request->post[$this->_name . '_footer_email'];
		} else {
			$this->data[$this->_name . '_footer_email'] = $this->config->get($this->_name . '_footer_email');
		}

		if (isset($this->request->post[$this->_name . '_footer_facebook'])) {
			$this->data[$this->_name . '_footer_facebook'] = $this->request->post[$this->_name . '_footer_facebook'];
		} else {
			$this->data[$this->_name . '_footer_facebook'] = $this->config->get($this->_name . '_footer_facebook');
		}

		if (isset($this->request->post[$this->_name . '_footer_twitter'])) {
			$this->data[$this->_name . '_footer_twitter'] = $this->request->post[$this->_name . '_footer_twitter'];
		} else {
			$this->data[$this->_name . '_footer_twitter'] = $this->config->get($this->_name . '_footer_twitter');
		}

		if (isset($this->request->post[$this->_name . '_footer_google'])) {
			$this->data[$this->_name . '_footer_google'] = $this->request->post[$this->_name . '_footer_google'];
		} else {
			$this->data[$this->_name . '_footer_google'] = $this->config->get($this->_name . '_footer_google');
		}

		if (isset($this->request->post[$this->_name . '_footer_pinterest'])) {
			$this->data[$this->_name . '_footer_pinterest'] = $this->request->post[$this->_name . '_footer_pinterest'];
		} else {
			$this->data[$this->_name . '_footer_pinterest'] = $this->config->get($this->_name . '_footer_pinterest');
		}

		if (isset($this->request->post[$this->_name . '_footer_instagram'])) {
			$this->data[$this->_name . '_footer_instagram'] = $this->request->post[$this->_name . '_footer_instagram'];
		} else {
			$this->data[$this->_name . '_footer_instagram'] = $this->config->get($this->_name . '_footer_instagram');
		}

		if (isset($this->request->post[$this->_name . '_footer_skype'])) {
			$this->data[$this->_name . '_footer_skype'] = $this->request->post[$this->_name . '_footer_skype'];
		} else {
			$this->data[$this->_name . '_footer_skype'] = $this->config->get($this->_name . '_footer_skype');
		}

		// Options
		if (isset($this->request->post[$this->_name . '_livesearch'])) {
			$this->data[$this->_name . '_livesearch'] = $this->request->post[$this->_name . '_livesearch'];
		} else {
			$this->data[$this->_name . '_livesearch'] = $this->config->get($this->_name . '_livesearch');
		}

		if (isset($this->request->post[$this->_name . '_livesearch_limit'])) {
			$this->data[$this->_name . '_livesearch_limit'] = $this->request->post[$this->_name . '_livesearch_limit'];
		} else {
			$this->data[$this->_name . '_livesearch_limit'] = $this->config->get($this->_name . '_livesearch_limit');
		}

		if (isset($this->request->post[$this->_name . '_product_stock_low'])) {
			$this->data[$this->_name . '_product_stock_low'] = $this->request->post[$this->_name . '_product_stock_low'];
		} else {
			$this->data[$this->_name . '_product_stock_low'] = $this->config->get($this->_name . '_product_stock_low');
		}

		$this->data['stock_limits'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '12', '15', '20', '50', '100');

		if (isset($this->request->post[$this->_name . '_product_stock_limit'])) {
			$this->data[$this->_name . '_product_stock_limit'] = $this->request->post[$this->_name . '_product_stock_limit'];
		} else {
			$this->data[$this->_name . '_product_stock_limit'] = $this->config->get($this->_name . '_product_stock_limit');
		}

		if (isset($this->request->post[$this->_name . '_manufacturer_name'])) {
			$this->data[$this->_name . '_manufacturer_name'] = $this->request->post[$this->_name . '_manufacturer_name'];
		} else {
			$this->data[$this->_name . '_manufacturer_name'] = $this->config->get($this->_name . '_manufacturer_name');
		}

		if (isset($this->request->post[$this->_name . '_manufacturer_image'])) {
			$this->data[$this->_name . '_manufacturer_image'] = $this->request->post[$this->_name . '_manufacturer_image'];
		} else {
			$this->data[$this->_name . '_manufacturer_image'] = $this->config->get($this->_name . '_manufacturer_image');
		}

		// Stylesheet override (required by modules): theme CSS only = 1, theme CSS with CSS Modifiers = 0 (default)
		if (isset($this->request->post[$this->_name . '_stylesheet'])) {
			$this->data[$this->_name . '_stylesheet'] = $this->request->post[$this->_name . '_stylesheet'];
		} else {
			$this->data[$this->_name . '_stylesheet'] = 0;
		}

		$this->template = 'theme/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'theme/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return empty($this->error);
	}
}
