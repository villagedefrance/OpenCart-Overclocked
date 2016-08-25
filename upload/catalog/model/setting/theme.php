<?php
class ModelSettingTheme extends Model {

	public function getTheme() {
		$template = $this->config->get('config_template');

		$theme_file = DIR_APPLICATION . 'model/theme/' . $template . '.php';

		if (file_exists($theme_file)) {
			$theme_data = array();

			$this->load->model('theme/' . $template);

			$theme_data = $this->{'model_theme_' . $template}->getSettings(0);

			return $theme_data;
		}
	}
}
