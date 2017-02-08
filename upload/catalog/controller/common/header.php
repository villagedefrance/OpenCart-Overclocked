<?php
class ControllerCommonHeader extends Controller {

	protected function index() {
		$this->data['title'] = $this->document->getTitle();

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$server = $this->config->get('config_ssl');
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$metas = false;

		if ($this->config->get('config_meta_google')) {
			$this->document->addMeta('google-site-verification', $this->config->get('config_meta_google'));
			$metas = true;
		}

		if ($this->config->get('config_meta_bing')) {
			$this->document->addMeta('msvalidate.01', $this->config->get('config_meta_bing'));
			$metas = true;
		}

		if ($this->config->get('config_meta_yandex')) {
			$this->document->addMeta('yandex-verification', $this->config->get('config_meta_yandex'));
			$metas = true;
		}

		if ($this->config->get('config_meta_baidu')) {
			$this->document->addMeta('baidu-site-verification', $this->config->get('config_meta_baidu'));
			$metas = true;
		}

		if ($this->config->get('config_meta_alexa')) {
			$this->document->addMeta('alexaVerifyID', $this->config->get('config_meta_alexa'));
			$metas = true;
		}

		$page_keywords = $this->document->getKeywords();
		$default_keywords = $this->config->get('config_meta_keyword');

		$this->language->load('common/header');

		$this->data['base'] = $server;
		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = ($page_keywords) ? $page_keywords : $default_keywords;
		$this->data['metas'] = ($metas) ? $this->document->getMetas() : null;
		$this->data['links'] = $this->document->getLinks();
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['name'] = $this->config->get('config_name');
		$this->data['version'] = VERSION;

		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$this->data['icon'] = '';
		}

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}

		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist'])) ? count($this->session->data['wishlist']) : 0);
		$this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
		$this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName() . ' ' . $this->customer->getLastName(), $this->url->link('account/logout', '', 'SSL'));
		$this->data['text_signin'] = $this->language->get('text_signin');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_checkout'] = $this->language->get('text_checkout');

		$this->data['home'] = $this->url->link('common/home', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['shopping_cart'] = $this->url->link('checkout/cart', '', 'SSL');
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$this->data['alexa_analytics'] = html_entity_decode($this->config->get('config_alexa_analytics'), ENT_QUOTES, 'UTF-8');

		// Robot detector
		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;
					break;
				}
			}
		}

		// Ip Blocking
		$this->load->model('tool/online');

		if (isset($this->request->server['REMOTE_ADDR'])) {
			$is_blocked = $this->model_tool_online->isBlockedIp($this->request->server['REMOTE_ADDR']);

			if ($is_blocked) {
				$this->redirect($this->url->link('error/forbidden', '', 'SSL'));
			}
		}

		// Multi-store cookie
		$this->load->model('setting/store');

		$this->data['stores'] = array();

		if ($this->config->get('config_shared') && $status) {
			$this->data['stores'][] = $server . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();

			$stores = $this->model_setting_store->getStores();

			foreach ($stores as $store) {
				$this->data['stores'][] = $store['url'] . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
			}
		}

		// Search
		if (isset($this->request->get['search'])) {
			$this->data['search'] = $this->request->get['search'];
		} else {
			$this->data['search'] = '';
		}

		// Rss
		$this->data['rss'] = $this->config->get('rss_feed_status');

		$rss_currency = $this->currency->getCode();

		$this->data['rss_href'] = $this->url->link('feed/rss_feed&amp;currency=' . $rss_currency, '', 'SSL');

		// Cookie Consent
		$this->data['text_message'] = $this->language->get('text_message');
		$this->data['text_policy'] = $this->language->get('text_policy');
		$this->data['text_accept'] = $this->language->get('text_accept');

		$this->data['cookie_consent'] = $this->config->get('config_cookie_consent');
		$this->data['cookie_theme'] = $this->config->get('config_cookie_theme');
		$this->data['cookie_position'] = $this->config->get('config_cookie_position');

		$cookie_privacy = $this->config->get('config_cookie_privacy');

		$this->data['cookie_privacy'] = $this->url->link('information/information&information_id=' . $cookie_privacy, '', 'SSL');

		$cookie_age = $this->config->get('config_cookie_age');

		$this->data['cookie_age'] = ($cookie_age) ? $cookie_age : 365;

		// Theme
		$template = $this->config->get('config_template');

		$display_size = $this->config->get($template . '_widescreen');

		if ($display_size == 'full') {
			$this->data['display_size'] = 'full';
		} elseif ($display_size == 'wide') {
			$this->data['display_size'] = 'wide';
		} elseif ($display_size == 'normal') {
			$this->data['display_size'] = 'normal';
		} else {
			$this->data['display_size'] = 'normal';
		}

		$body_color = $this->config->get($template . '_body_color');
		$container_color = $this->config->get($template . '_container_color');

		$this->data['body_color'] = ($body_color) ? $body_color : '#FFF';
		$this->data['container_color'] = ($container_color) ? $container_color : '#FFF';

		// Template
		$this->data['template'] = $this->config->get('config_template');

		$this->children = array(
			'module/language',
			'module/currency',
			'module/cart'
		);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/header.tpl';
		} else {
			$this->template = 'default/template/common/header.tpl';
		}

		$this->render();
	}
}
