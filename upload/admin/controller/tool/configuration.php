<?php
class ControllerToolConfiguration extends Controller {
	private $error = array();
	private $_name = 'configuration';

	public function index() {
		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_on'] = $this->language->get('text_on');
		$this->data['text_off'] = $this->language->get('text_off');
		$this->data['text_system_core'] = $this->language->get('text_system_core');
		$this->data['text_version'] = sprintf($this->language->get('text_version'), VERSION);
		$this->data['text_system_name'] = $this->language->get('text_system_name');
		$this->data['text_revision'] = sprintf($this->language->get('text_revision'), REVISION);
		$this->data['text_theme'] = $this->language->get('text_theme');
		$this->data['text_timezone'] = $this->language->get('text_timezone');
		$this->data['text_phptime'] = $this->language->get('text_phptime');
		$this->data['text_dbtime'] = $this->language->get('text_dbtime');
		$this->data['text_storeinfo'] = $this->language->get('text_storeinfo');
		$this->data['text_serverinfo'] = $this->language->get('text_serverinfo');

		$this->data['column_php'] = $this->language->get('column_php');
		$this->data['column_extension'] = $this->language->get('column_extension');
		$this->data['column_directories'] = $this->language->get('column_directories');
		$this->data['column_required'] = $this->language->get('column_required');
		$this->data['column_current'] = $this->language->get('column_current');
		$this->data['column_status'] = $this->language->get('column_status');

		$this->data['text_phpversion'] = $this->language->get('text_phpversion');
		$this->data['text_registerglobals'] = $this->language->get('text_registerglobals');
		$this->data['text_magicquotes'] = $this->language->get('text_magicquotes');
		$this->data['text_fileuploads'] = $this->language->get('text_fileuploads');
		$this->data['text_autostart'] = $this->language->get('text_autostart');

		$this->data['text_mysql'] = $this->language->get('text_mysql');
		$this->data['text_gd'] = $this->language->get('text_gd');
		$this->data['text_curl'] = $this->language->get('text_curl');
		$this->data['text_mcrypt'] = $this->language->get('text_mcrypt');
		$this->data['text_zlib'] = $this->language->get('text_zlib');
		$this->data['text_zip'] = $this->language->get('text_zip');
		$this->data['text_mbstring'] = $this->language->get('text_mbstring');
		$this->data['text_mbstring_note'] = $this->language->get('text_mbstring_note');

		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];

		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$date_timezone = ini_get('date.timezone');
		$default_timezone = date_default_timezone_get();

		if ($date_timezone) {
			$this->data['server_zone'] = $date_timezone;
		} elseif ($default_timezone) {
			$this->data['server_zone'] = $default_timezone;
		} else {
			$this->data['server_zone'] = $this->language->get('text_no_timezone');
		}

		$this->data['server_time'] = date('Y-m-d H:i:s');
		$this->data['database_time'] = $this->db->query("SELECT NOW() AS now")->row['now'];

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$this->data['error_install'] = $this->language->get('error_install');
		} else {
			$this->data['error_install'] = '';
		}

		// Check write permissions
		$this->data['cache'] = DIR_SYSTEM . 'cache';
		$this->data['logs'] = DIR_SYSTEM . 'logs';
		$this->data['download'] = DIR_DOWNLOAD;
		$this->data['image'] = DIR_IMAGE;
		$this->data['image_cache'] = DIR_IMAGE . 'cache';
		$this->data['image_data'] = DIR_IMAGE . 'data';

		// VQMod folders
		$this->data['vqmod'] = DIR_VQMOD;
		$this->data['vqcache'] = DIR_VQMOD . 'vqcache';
		$this->data['vqmod_xml'] = DIR_VQMOD . 'xml';

		// Template
		$this->data['templates'] = array();

		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);

		foreach ($directories as $directory) {
			$this->data['templates'][] = basename($directory);
		}

		if (isset($this->request->post['config_template'])) {
			$this->data['config_template'] = $this->request->post['config_template'];
		} else {
			$this->data['config_template'] = $this->config->get('config_template');
		}

		$this->template = 'tool/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>