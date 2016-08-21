<?php
class ModelThemeDefault extends Model {

	public function getSettings($theme = array()) {
		// Settings
		$breadcrumbs = $this->config->get('default_breadcrumbs');
		$manufacturer_name = $this->config->get('default_manufacturer_name');
		$manufacturer_image = $this->config->get('default_manufacturer_image');
		$category_menu = $this->config->get('default_category_menu');
		$default_viewer = $this->config->get('default_viewer');
		$cookie_consent = $this->config->get('default_cookie_consent');
		$cookie_privacy = $this->config->get('default_cookie_privacy');
		$back_to_top = $this->config->get('default_back_to_top');

		// Language
		$this->language->load('theme/default');

		if (isset($cookie_privacy)) {
			$privacy_link = $this->url->link('information/information', 'information_id=' . $cookie_privacy);
		} else {
			$privacy_link = $this->url->link('information/contact');
		}

		$cookie_message = sprintf($this->language->get('text_cookie_message'), $privacy_link);
		$cookie_yes = $this->language->get('text_cookie_yes');
		$cookie_no = $this->language->get('text_cookie_no');

		// Theme
		$theme = array(
			'breadcrumbs'        => $breadcrumbs,
			'manufacturer_name'  => $manufacturer_name,
			'manufacturer_image' => $manufacturer_image,
			'category_menu'      => $category_menu,
			'default_viewer'     => $default_viewer,
			'cookie_consent'     => $cookie_consent,
			'cookie_privacy'     => $cookie_privacy,
			'back_to_top'        => $back_to_top,
			'cookie_message'     => $cookie_message,
			'cookie_yes'         => $cookie_yes,
			'cookie_no'          => $cookie_no
		);

		return $theme;
	}
}
?>
