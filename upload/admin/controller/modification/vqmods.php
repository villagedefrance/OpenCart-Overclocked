<?php
class ControllerModificationVQmods extends Controller {

	public function __construct($registry) {
		parent::__construct($registry);

		// Paths and Files
		$this->base_dir = substr_replace(DIR_SYSTEM, '/', -8);
		$this->vqmod_dir = substr_replace(DIR_SYSTEM, '/vqmod/', -8);
		$this->vqmod_script_dir = substr_replace(DIR_SYSTEM, '/vqmod/xml/', -8);
		$this->vqcache_dir = substr_replace(DIR_SYSTEM, '/vqmod/vqcache/', -8);
		$this->vqcache_files = substr_replace(DIR_SYSTEM, '/vqmod/vqcache/vq*', -8);
		$this->vqmod_log = substr_replace(DIR_SYSTEM, '/vqmod/vqmod.log', -8); // Deprecated VQMod 2.2.0
		$this->vqmod_logs_dir = substr_replace(DIR_SYSTEM, '/vqmod/logs/', -8);
		$this->vqmod_logs = substr_replace(DIR_SYSTEM, '/vqmod/logs/*.log', -8);
		$this->vqmod_modcache = substr_replace(DIR_SYSTEM, '/vqmod/mods.cache', -8); // VQMod 2.2.0
		$this->vqmod_opencart_script = substr_replace(DIR_SYSTEM, '/vqmod/xml/vqmod_opencart.xml', -8);
		$this->vqmod_path_replaces = substr_replace(DIR_SYSTEM, '/vqmod/pathReplaces.php', -8); // VQMod 2.3.0

		clearstatcache();
	}

	public function index() {
		$this->language->load('modification/vqmods');

		$this->document->setTitle($this->language->get('heading_title'));

		// Stylesheet
		$this->document->addStyle('view/stylesheet/vqmods.css');
		$this->document->addStyle('view/javascript/jquery/sfi/css/jquery.simplefileinput.css');

		$this->load->model('setting/setting');

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['upload'])) {
			$this->vqmodUpload();
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['header_add'] = $this->language->get('header_add');
		$this->data['header_cache'] = $this->language->get('header_cache');
		$this->data['header_backup'] = $this->language->get('header_backup');
		$this->data['header_settings'] = $this->language->get('header_settings');
		$this->data['header_error'] = $this->language->get('header_error');
		$this->data['header_credits'] = $this->language->get('header_credits');
		$this->data['header_vqmod'] = $this->language->get('header_vqmod');

		$this->data['tab_script_list'] = $this->language->get('tab_script_list');
		$this->data['tab_script_add'] = $this->language->get('tab_script_add');
		$this->data['tab_maintain'] = $this->language->get('tab_maintain');
		$this->data['tab_error_log'] = $this->language->get('tab_error_log');
		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_about'] = $this->language->get('tab_about');

		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_author'] = $this->language->get('column_author');
		$this->data['column_delete'] = $this->language->get('column_delete');
		$this->data['column_file_name'] = $this->language->get('column_file_name');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_version'] = $this->language->get('column_version');
		$this->data['column_vqmver'] = $this->language->get('column_vqmver');

		$this->data['entry_backup'] = $this->language->get('entry_backup');
		$this->data['entry_vqcache'] = $this->language->get('entry_vqcache');
		$this->data['entry_vqmod_path'] = $this->language->get('entry_vqmod_path');

		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_close'] = $this->language->get('button_close');
		$this->data['button_backup'] = $this->language->get('button_backup');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_clear'] = $this->language->get('button_clear');
		$this->data['button_download_log'] = $this->language->get('button_download_log');
		$this->data['button_vqcache_dump'] = $this->language->get('button_vqcache_dump');

		$this->data['error_error_log_write'] = $this->language->get('error_error_log_write');
		$this->data['error_error_logs_write'] = $this->language->get('error_error_logs_write');
		$this->data['error_opencart_version'] = $this->language->get('error_opencart_version');
		$this->data['error_opencart_xml'] = $this->language->get('error_opencart_xml');
		$this->data['error_opencart_xml_disabled'] = $this->language->get('error_opencart_xml_disabled');
		$this->data['error_opencart_xml_version'] = $this->language->get('error_opencart_xml_version');
		$this->data['error_vqcache_dir'] = $this->language->get('error_vqcache_dir');
		$this->data['error_vqcache_install_link'] = $this->language->get('error_vqcache_install_link');
		$this->data['error_vqcache_write'] = $this->language->get('error_vqcache_write');
		$this->data['error_vqcache_files_missing'] = $this->language->get('error_vqcache_files_missing');
		$this->data['error_vqmod_core'] = $this->language->get('error_vqmod_core');
		$this->data['error_vqmod_dir'] = $this->language->get('error_vqmod_dir');
		$this->data['error_vqmod_install_link'] = $this->language->get('error_vqmod_install_link');
		$this->data['error_vqmod_opencart_integration'] = $this->language->get('error_vqmod_opencart_integration');
		$this->data['error_vqmod_script_dir'] = $this->language->get('error_vqmod_script_dir');
		$this->data['error_vqmod_script_write'] = $this->language->get('error_vqmod_script_write');

		$this->data['error_simplexml'] = $this->language->get('error_simplexml');
		$this->data['error_ziparchive'] = $this->language->get('error_ziparchive');

		$this->data['error_mod_aborted'] = $this->language->get('Mod Aborted');
		$this->data['error_mod_skipped'] = $this->language->get('Operation Skipped');

		$this->data['success_clear_vqcache'] = $this->language->get('success_clear_vqcache');
		$this->data['success_clear_log'] = $this->language->get('success_clear_log');
		$this->data['success_delete'] = $this->language->get('success_delete');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_autodetect'] = $this->language->get('text_autodetect');
		$this->data['text_autodetect_fail'] = $this->language->get('text_autodetect_fail');
		$this->data['text_cachetime'] = $this->language->get('text_cachetime');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['text_first_install'] = $this->language->get('text_first_install');
		$this->data['text_getxml'] = $this->language->get('text_getxml');
		$this->data['text_modification'] = $this->language->get('text_modification');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_success'] = $this->language->get('text_success');
		$this->data['text_upload'] = $this->language->get('text_upload');
		$this->data['text_upload_help'] = $this->language->get('text_upload_help');
		$this->data['text_usecache_help'] = $this->language->get('text_usecache_help');
		$this->data['text_vqcache_help'] = $this->language->get('text_vqcache_help');

		// About
		$this->data['text_vqm_version'] = $this->language->get('text_vqm_version');
		$this->data['text_vqm_author'] = $this->language->get('text_vqm_author');
		$this->data['text_vqm_website'] = $this->language->get('text_vqm_website');
		$this->data['text_vqm_support'] = $this->language->get('text_vqm_support');
		$this->data['text_vqm_license'] = $this->language->get('text_vqm_license');
		$this->data['text_vqmm_version'] = $this->language->get('text_vqmm_version');
		$this->data['text_vqmm_author'] = $this->language->get('text_vqmm_author');
		$this->data['text_vqmm_website'] = $this->language->get('text_vqmm_website');
		$this->data['text_vqmm_license'] = $this->language->get('text_vqmm_license');
		$this->data['text_vqmod_version'] = $this->language->get('text_vqmod_version');
		$this->data['text_vqmod_author'] = $this->language->get('text_vqmod_author');
		$this->data['text_vqmod_website'] = $this->language->get('text_vqmod_website');
		$this->data['text_vqmod_license'] = $this->language->get('text_vqmod_license');

		// Version
		$this->data['vqmods_version'] = $this->language->get('vqmods_version');
		$this->data['vqmods_author'] = $this->language->get('vqmods_author');
		$this->data['vqmods_support'] = $this->language->get('vqmods_support');
		$this->data['vqmods_license'] = $this->language->get('vqmods_license');
		$this->data['vqmods_description'] = $this->language->get('vqmods_description');
		$this->data['vqmod_manager_version'] = $this->language->get('vqmod_manager_version');
		$this->data['vqmod_manager_author'] = $this->language->get('vqmod_manager_author');
		$this->data['vqmod_manager_license'] = $this->language->get('vqmod_manager_license');
		$this->data['vqmod_version'] = $this->language->get('vqmod_version');
		$this->data['vqmod_author'] = $this->language->get('vqmod_author');
		$this->data['vqmod_license'] = $this->language->get('vqmod_license');

		// Warnings
		$this->data['warning_required_delete'] = $this->language->get('warning_required_delete');
		$this->data['warning_required_uninstall'] = $this->language->get('warning_required_uninstall');
		$this->data['warning_vqmod_delete'] = $this->language->get('warning_vqmod_delete');

		if ($this->vqmodInstallationCheck()) {
			$this->data['vqmod_is_installed'] = true;
		} else {
			$this->data['vqmod_is_installed'] = false;
		}

		if (isset($this->session->data['vqmod_installation_error'])) {
			$this->data['vqmod_installation_error'] = $this->session->data['vqmod_installation_error'];

			unset($this->session->data['vqmod_installation_error']);
		} else {
			$this->data['vqmod_installation_error'] = '';
		}

		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('text_modification'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['refresh'] = $this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['close'] = $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['clear_log'] = $this->url->link('modification/vqmods/clear_log', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['clear_vqcache'] = $this->url->link('modification/vqmods/clear_vqcache', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['download_log'] = $this->url->link('modification/vqmods/download_log', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['download_scripts'] = $this->url->link('modification/vqmods/download_vqmod_scripts', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['download_vqcache'] = $this->url->link('modification/vqmods/download_vqcache', 'token=' . $this->session->data['token'], 'SSL');

		// Check ZipArchive for use with downloads
		if (class_exists('ZipArchive')) {
			$this->data['ziparchive'] = true;
		} else {
			$this->data['ziparchive'] = false;
		}

		// Get Scripts
		$this->data['vqmods'] = array();

		$vqmod_total_scripts = $this->countVqmodScripts();

		$vqmod_scripts = $this->listVqmodScripts();

		if (!empty($vqmod_scripts)) {
			foreach ($vqmod_scripts as $vqmod_script) {
				$extension = pathinfo($vqmod_script, PATHINFO_EXTENSION);

				if ($extension == 'xml_') {
					$file = basename($vqmod_script, '.xml_');
				} else {
					$file = basename($vqmod_script, '.xml');
				}

				$action = array();

				if ($extension == 'xml_') {
					$action[] = array(
						'text' => $this->language->get('text_enable'),
						'href' => $this->url->link('modification/vqmods/vqmod_install', 'token=' . $this->session->data['token'] . '&vqmod=' . $file, 'SSL')
					);
				} else {
					$action[] = array(
						'text' => $this->language->get('text_disable'),
						'href' => $this->url->link('modification/vqmods/vqmod_uninstall', 'token=' . $this->session->data['token'] . '&vqmod=' . $file, 'SSL')
					);
				}

				libxml_use_internal_errors(true);

				$xml = simplexml_load_file($vqmod_script);

				if (libxml_get_errors()) {
					$invalid_xml = sprintf($this->language->get('highlight'), $this->language->get('error_invalid_xml'));
					libxml_clear_errors();
				} else {
					$invalid_xml = '';
				}

				$this->data['vqmods'][] = array(
					'file_name'   => basename($vqmod_script, ''),
					'id'          => isset($xml->id) ? $xml->id : $this->language->get('text_unavailable'),
					'version'     => isset($xml->version) ? $xml->version : $this->language->get('text_unavailable'),
					'vqmver'      => isset($xml->vqmver) ? $xml->vqmver : $this->language->get('text_unavailable'),
					'author'      => isset($xml->author) ? $xml->author : $this->language->get('text_unavailable'),
					'status'      => ($extension == 'xml_') ? sprintf($this->language->get('highlight'), $this->language->get('text_disabled')) : $this->language->get('text_enabled'),
					'delete'      => $this->url->link('modification/vqmods/vqmod_delete', 'token=' . $this->session->data['token'] . '&vqmod=' . basename($vqmod_script), 'SSL'),
					'action'      => $action,
					'extension'   => $extension,
					'invalid_xml' => $invalid_xml
				);
			}

			$this->data['total_scripts'] = $vqmod_total_scripts;
		}

		// VQCache Files
		$this->data['vqcache'] = array();

		if (is_dir($this->vqcache_dir)) {
			$this->data['vqcache'] = array_diff(scandir($this->vqcache_dir), array('.', '..'));
		}

		// VQMod Error Log
		$this->data['log'] = '';

		if (is_dir($this->vqmod_logs_dir) && is_readable($this->vqmod_logs_dir)) {
			// VQMod 2.2.0 and later logs
			$vqmod_logs = glob($this->vqmod_logs);

			$vqmod_logs_size = 0;

			if (!empty($vqmod_logs)) {
				foreach ($vqmod_logs as $vqmod_log) {
					$vqmod_logs_size += filesize($vqmod_log);
				}

				// Error if log files are larger than 6MB combined
				if ($vqmod_logs_size > 6291456) {
					$this->data['error_warning'] = sprintf($this->language->get('error_log_size'), round(($vqmod_logs_size / 1048576), 2));

					$this->data['log'] = sprintf($this->language->get('error_log_size'), round(($vqmod_logs_size / 1048576), 2));
				} else {
					foreach ($vqmod_logs as $vqmod_log) {
						$this->data['log'] .= str_pad(basename($vqmod_log), 70, '*', STR_PAD_BOTH) . "\n";
						$this->data['log'] .= file_get_contents($vqmod_log, FILE_USE_INCLUDE_PATH, null);
					}
				}
			}

		} elseif (is_file($this->vqmod_log) && filesize($this->vqmod_log) > 0) {
			// VQMod 2.1.7 and earlier log
			if (filesize($this->vqmod_log) > 6291456) {
				// Error if log file is larger than 6MB
				$this->data['error_warning'] = sprintf($this->language->get('error_log_size'), round((filesize($this->vqmod_log) / 1048576), 2));

				$this->data['log'] = sprintf($this->language->get('error_log_size'), round((filesize($this->vqmod_log) / 1048576), 2));
			} else {
				// Regular log
				$this->data['log'] = file_get_contents($this->vqmod_log, FILE_USE_INCLUDE_PATH, null);
			}
		}

		// Highlight Error Log tab
		if ($this->data['log']) {
			$this->data['tab_error_log'] = sprintf($this->language->get('highlight'), $this->language->get('tab_error_log'));
		}

		// VQMod Path
		if (is_dir($this->vqmod_dir)) {
			$this->data['vqmod_path'] = $this->vqmod_dir;
		} else {
			$this->data['vqmod_path'] = '';
		}

		// VQMod Class variables
		$vqmod_vars = get_class_vars('VQMod');

		$this->data['vqmod_vars'] = array();

		if ($vqmod_vars) {
			foreach ($vqmod_vars as $setting => $value) {
				// Deprecated VQMod 2.1.7
				if ($setting == 'useCache') {
					$this->data['vqmod_vars'][] = array(
						'setting' => $this->language->get('setting_usecache'),
						'value'   => ($value === true) ? $this->language->get('text_enabled') : $this->language->get('text_disabled')
					);
				}

				if ($setting == 'logging') {
					$this->data['vqmod_vars'][] = array(
						'setting' => $this->language->get('setting_logging'),
						'value'   => ($value === true) ? $this->language->get('text_enabled') : $this->language->get('text_disabled')
					);
				}

				// Deprecated VQMod 2.2.0
				if ($setting == 'cacheTime') {
					$this->data['vqmod_vars'][] = array(
						'setting' => $this->language->get('setting_cachetime'),
						'value'   => sprintf($this->language->get('text_cachetime'), $value)
					);
				}

				if ($setting == 'protectedFilelist' && is_file($this->base_dir . $value)) {
					$protected_files = file_get_contents($this->base_dir . $value);

					if (!empty($protected_files)) {
						$protected_files = preg_replace('~\r?\n~', "\n", $protected_files);

						$paths = explode("\n", $protected_files);

						$this->data['vqmod_vars'][] = array(
							'setting' => $this->language->get('setting_protected_files'),
							'value'   => implode('<br />', $paths)
						);
					}
				}

				if ($setting == 'directorySeparator' && !empty($value)) {
					$this->data['vqmod_vars'][] = array(
						'setting' => $this->language->get('setting_dir_separator'),
						'value'   => htmlentities($value, ENT_QUOTES, 'UTF-8')
					);
				}
			}
		}

		// Path Replacements - VQMod 2.3.0
		if (is_file($this->vqmod_path_replaces)) {
			if (!in_array('pathReplaces.php', get_included_files())) {
				include_once($this->vqmod_path_replaces);
			}

			if (!empty($replaces)) {
				$replacement_values = array();

				foreach ($replaces as $key => $value) {
					$replacement_values[] = $value[0] . $this->language->get('text_separator') . $value[1];
				}

				$this->data['vqmod_vars'][] = array(
					'setting' => $this->language->get('setting_path_replaces'),
					'value'   => implode('<br />', $replacement_values)
				);
			}
		}

		$this->template = 'modification/vqmods.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function vqmod_install() {
		if ($this->userPermission()) {
			$this->language->load('modification/vqmods');

			$vqmod_script = $this->request->get['vqmod'];

			if (is_file($this->vqmod_script_dir . $vqmod_script . '.xml_')) {
				rename($this->vqmod_script_dir . $vqmod_script . '.xml_', $this->vqmod_script_dir . $vqmod_script . '.xml');

				$this->clear_vqcache(true);

				$this->session->data['success'] = $this->language->get('success_install');
			} else {
				$this->session->data['error'] = $this->language->get('error_install');
			}
		}

		$this->redirect($this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function vqmod_uninstall() {
		if ($this->userPermission()) {
			$this->language->load('modification/vqmods');

			$vqmod_script = $this->request->get['vqmod'];

			if (is_file($this->vqmod_script_dir . $vqmod_script . '.xml')) {
				rename($this->vqmod_script_dir . $vqmod_script . '.xml', $this->vqmod_script_dir . $vqmod_script . '.xml_');

				$this->clear_vqcache(true);

				$this->session->data['success'] = $this->language->get('success_uninstall');
			} else {
				$this->session->data['error'] = $this->language->get('error_uninstall');
			}
		}

		$this->redirect($this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function vqmodUpload() {
		$this->language->load('modification/vqmods');

		if ($this->userPermission()) {
			$file = $this->request->files['vqmod_file']['tmp_name'];
			$file_name = $this->request->files['vqmod_file']['name'];

			if ($this->request->files['vqmod_file']['error'] > 0) {
				switch($this->request->files['vqmod_file']['error']) {
					case 1: $this->session->data['error'] = $this->language->get('error_ini_max_file_size'); break;
					case 2: $this->session->data['error'] = $this->language->get('error_form_max_file_size'); break;
					case 3: $this->session->data['error'] = $this->language->get('error_partial_upload'); break;
					case 4: $this->session->data['error'] = $this->language->get('error_no_upload'); break;
					case 6: $this->session->data['error'] = $this->language->get('error_no_temp_dir'); break;
					case 7: $this->session->data['error'] = $this->language->get('error_write_fail'); break;
					case 8: $this->session->data['error'] = $this->language->get('error_php_conflict'); break;
					default: $this->session->data['error'] = $this->language->get('error_unknown');
				}

			} else {
				if ($this->request->files['vqmod_file']['type'] != 'text/xml') {
					$this->session->data['error'] = $this->language->get('error_filetype');
				} else {
					libxml_use_internal_errors(true);

					simplexml_load_file($file);

					if (libxml_get_errors()) {
						$this->session->data['error'] = $this->language->get('error_invalid_xml');
						libxml_clear_errors();
					} elseif (move_uploaded_file($file, $this->vqmod_script_dir . $file_name) === false) {
						$this->session->data['error'] = $this->language->get('error_move');
					} else {
						$this->clear_vqcache(true);

						$this->session->data['success'] = $this->language->get('success_upload');
					}
				}
			}
		}

		$this->redirect($this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function vqmod_delete() {
		if ($this->userPermission()) {
			$vqmod_script = $this->request->get['vqmod'];

			if (is_file($this->vqmod_script_dir . $vqmod_script)) {
				if (unlink($this->vqmod_script_dir . $vqmod_script)) {
					$this->clear_vqcache(true);

					$this->session->data['success'] = $this->language->get('success_delete');
				} else {
					$this->session->data['error'] = $this->language->get('error_delete');
				}
			}
		}

		$this->redirect($this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function clear_vqcache($return = false) {
		if ($this->userPermission()) {
			$files = glob($this->vqcache_files);

			if ($files) {
				foreach ($files as $file) {
					if (is_file($file)) {
						unlink($file);
					}
				}
			}

			if (is_file($this->vqmod_modcache)) {
				unlink($this->vqmod_modcache);
			}

			if ($return) {
				return;
			}

			$this->session->data['success'] = $this->language->get('success_clear_vqcache');
		}

		$this->redirect($this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function clear_log() {
		if ($this->userPermission()) {
			if (is_dir($this->vqmod_logs_dir)) {
				// VQMod 2.2.0 and later
				$files = glob($this->vqmod_logs);

				if ($files) {
					foreach ($files as $file) {
						unlink($file);
					}
				}

			} else {
				// VQMod 2.1.7 and earlier
				$file = $this->vqmod_log;

				$handle = fopen($file, 'w+');

				fclose($handle);

				$this->session->data['success'] = $this->language->get('success_clear_log');
			}
		}

		$this->redirect($this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'));
	}

	protected function listVqmodScripts() {
		$vqmod_scripts = array();

		if ($this->userPermission('access')) {
			$enabled_vqmod_scripts = glob($this->vqmod_script_dir . '*.xml');
			$disabled_vqmod_scripts = glob($this->vqmod_script_dir . '*.xml_');

			if (!empty($enabled_vqmod_scripts)) {
				$vqmod_scripts = array_merge($vqmod_scripts, $enabled_vqmod_scripts);
			}

			if (!empty($disabled_vqmod_scripts)) {
				$vqmod_scripts = array_merge($vqmod_scripts, $disabled_vqmod_scripts);
			}
		}

		return $vqmod_scripts;
	}

	protected function countVqmodScripts() {
		$total_scripts = 0;

		if ($this->userPermission('access')) {
			$enabled_vqmod_scripts = glob($this->vqmod_script_dir . '*.xml');
			$disabled_vqmod_scripts = glob($this->vqmod_script_dir . '*.xml_');

			if (!empty($enabled_vqmod_scripts)) {
				$total_enabled = count(glob($this->vqmod_script_dir . '*.xml'));
			} else {
				$total_enabled = 0;
			}

			if (!empty($disabled_vqmod_scripts)) {
				$total_disabled = count(glob($this->vqmod_script_dir . '*.xml_'));
			} else {
				$total_disabled = 0;
			}

			$total_scripts = $total_enabled + $total_disabled;
		}

		return $total_scripts;
	}

	public function download_vqmod_scripts() {
		if ($this->userPermission()) {
			$targets = $this->listVqmodScripts();

			$this->zipSend($targets, 'vqmod_scripts_backup');
		} else {
			$this->redirect($this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function download_vqcache() {
		if ($this->userPermission()) {
			$targets = glob($this->vqcache_files);

			if (is_file($this->vqmod_modcache)) {
				$targets[] = $this->vqmod_modcache;
			}

			$this->zipSend($targets, 'vqcache_dump');
		} else {
			$this->redirect($this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function download_log() {
		if ($this->userPermission()) {
			if (is_dir($this->vqmod_logs_dir) && count(array_diff(scandir($this->vqmod_logs_dir), array('.', '..'))) > 0) {
				// VQMod 2.2.0 and later
				$targets = glob($this->vqmod_logs);

				$this->zipSend($targets, 'vqmod_logs');
			} elseif (is_file($this->vqmod_log)) {
				// VQMod 2.1.7 and earlier
				$targets = array($this->vqmod_log);

				$this->zipSend($targets, 'vqmod_log');
			} else {
				// No log available for download error
				$this->language->load('modification/vqmods');

				$this->session->data['error'] = $this->language->get('error_log_download');

				$this->redirect($this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'));
			}

		} else {
			$this->redirect($this->url->link('modification/vqmods', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	protected function zipSend($targets, $filename = 'download') {
		$temp = tempnam('tmp', 'zip');

		$zip = new ZipArchive();
		$zip->open($temp, ZipArchive::OVERWRITE);

		foreach ($targets as $target) {
			if (is_file($target)) {
				$zip->addFile($target, basename($target));
			}
		}

		$zip->close();

		header('Pragma: public');
		header('Expires: 0');
		header('Content-Description: File Transfer');
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename=' . $filename . '_' . date('Y-m-d_H-i') . '.zip');
		header('Content-Transfer-Encoding: binary');

		readfile($temp);

		unlink($temp);
	}

	protected function vqmodInstallationCheck() {
		// Check SimpleXML for VQManager use
		if (!function_exists('simplexml_load_file')) {
			$this->session->data['vqmod_installation_error'] = $this->language->get('error_simplexml');
			return false;
		}

		// Check if /vqmod directory exists
		if (!is_dir($this->vqmod_dir)) {
			$this->session->data['vqmod_installation_error'] = $this->language->get('error_vqmod_dir');
			return false;
		}

		// Check if vqmod.php exists
		if (!is_file($this->vqmod_dir . 'vqmod.php')) {
			$this->session->data['vqmod_installation_error'] = $this->language->get('error_vqmod_core');
			return false;
		}

		// Check if /vqmod/xml directory exists
		if (!is_dir($this->vqmod_script_dir)) {
			$this->session->data['vqmod_installation_error'] = $this->language->get('error_vqmod_script_dir');
			return false;
		}

		// Check if /vqmod/vqcache directory exists
		if (!is_dir($this->vqcache_dir)) {
			if (is_file($this->vqmod_dir . 'install/index.php') && is_file($this->vqmod_dir . 'install/ugrsr.class.php')) {
				$this->session->data['vqmod_installation_error'] = sprintf($this->language->get('error_vqcache_install_link'), HTTP_CATALOG . 'vqmod/install');
			} else {
				$this->session->data['vqmod_installation_error'] = $this->language->get('error_vqcache_dir');
			}
			return false;
		}

		// Check that vqmod_opencart.xml exists
		if (!is_file($this->vqmod_opencart_script)) {
			if (is_file($this->vqmod_opencart_script . '_')) {
				$this->session->data['error'] = $this->language->get('error_opencart_xml_disabled');
			} else {
				$this->session->data['vqmod_installation_error'] = $this->language->get('error_opencart_xml');
				return false;
			}
		}

		// Check that OpenCart 1.5.x is being used - other errors will appear on the page if they're using 1.4.x but at least the user will be told what the issue is
		if (!defined('VERSION') || version_compare(VERSION, '1.5.0', '<')) {
			$this->session->data['vqmod_installation_error'] = $this->language->get('error_opencart_version');
			return false;
		}

		// If OpenCart 1.5.4+ check that vqmod_opencart.xml 2.1.7 or later is being used
		if (version_compare(VERSION, '1.5.4', '>=')) {
			libxml_use_internal_errors(true);

			$xml = simplexml_load_file($this->vqmod_opencart_script);

			libxml_clear_errors();

			// In VQMod 2.3.0 'vqmver' is set as '2.X'
			if ((isset($xml->vqmver)) && (strtolower($xml->vqmver) != '2.x') && (version_compare($xml->vqmver, '2.1.7', '<'))) {
				$this->session->data['vqmod_installation_error'] = $this->language->get('error_opencart_xml_version');
				return false;
			}
		}

		// Check if VQMod class is added to OpenCart
		if (!class_exists('VQMod')) {
			if (is_file($this->vqmod_dir . 'install/index.php') && is_file($this->vqmod_dir . 'install/ugrsr.class.php')) {
				$this->session->data['vqmod_installation_error'] = sprintf($this->language->get('error_vqmod_install_link'), HTTP_CATALOG . 'vqmod/install');
			} else {
				$this->session->data['vqmod_installation_error'] = $this->language->get('error_vqmod_opencart_integration');
			}
			return false;
		}

		// Check VQMod Error Log Writing
		if ((is_dir($this->vqmod_logs_dir) && !is_writable($this->vqmod_logs_dir)) || (!is_writable($this->vqmod_dir))) {
			$this->session->data['vqmod_installation_error'] = $this->language->get('error_error_log_write');
			return false;
		}

		// Check VQMod Script Writing
		if (!is_writable($this->vqmod_script_dir)) {
			$this->session->data['vqmod_installation_error'] = $this->language->get('error_vqmod_script_write');
			return false;
		}

		// Check VQCache Writing
		if (!is_writable($this->vqcache_dir)) {
			$this->session->data['vqmod_installation_error'] = $this->language->get('error_vqcache_write');
			return false;
		}

		// Check if vqcache files from vqmod_opencart.xml have been generated
		$vqcache_files = array(
			'vq2-system_engine_controller.php',
			'vq2-system_engine_front.php',
			'vq2-system_engine_loader.php',
			'vq2-system_library_language.php',
			'vq2-system_library_template.php',
			'vq2-system_startup.php'
		);

		foreach ($vqcache_files as $vqcache_file) {
			// Only return false if vqmod_opencart.xml_ isn't present (in case the user has disabled it) so they aren't locked out of VQMM
			if (!is_file($this->vqcache_dir . $vqcache_file) && !is_file($this->vqmod_opencart_script . '_')) {
				$this->session->data['vqmod_installation_error'] = $this->language->get('error_vqcache_files_missing');
				return false;
			}
		}
		clearstatcache();
		return true;
	}

	protected function userPermission($permission = 'modify') {
		$this->language->load('modification/vqmods');

		if (!$this->user->hasPermission($permission, 'modification/vqmods')) {
			$this->session->data['error'] = $this->language->get('error_permission');
			return false;
		} else {
			return true;
		}
	}
}
