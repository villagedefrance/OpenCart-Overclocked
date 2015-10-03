<?php
class ControllerStep3 extends Controller {
	private $error = array();

	public function index() {
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('install');

			$this->model_install->database($this->request->post);

			$output  = '<?php' . "\n";
			$output .= '// HTTP' . "\n";
			$output .= 'define(\'HTTP_SERVER\', \'' . HTTP_OPENCART . '\');' . "\n";
			$output .= 'define(\'HTTP_IMAGE\', \'' . HTTP_OPENCART . 'image/\');' . "\n\n";

			$output .= '// HTTPS' . "\n";
			$output .= 'define(\'HTTPS_SERVER\', \'' . HTTP_OPENCART . '\');' . "\n";
			$output .= 'define(\'HTTPS_IMAGE\', \'' . HTTP_OPENCART . 'image/\');' . "\n\n";

			$output .= '// DIR' . "\n";
			$output .= 'define(\'DIR_APPLICATION\', \'' . DIR_OPENCART . 'catalog/\');' . "\n";
			$output .= 'define(\'DIR_SYSTEM\', \'' . DIR_OPENCART. 'system/\');' . "\n";
			$output .= 'define(\'DIR_DATABASE\', \'' . DIR_OPENCART . 'system/database/\');' . "\n";
			$output .= 'define(\'DIR_LANGUAGE\', \'' . DIR_OPENCART . 'catalog/language/\');' . "\n";
			$output .= 'define(\'DIR_TEMPLATE\', \'' . DIR_OPENCART . 'catalog/view/theme/\');' . "\n";
			$output .= 'define(\'DIR_CONFIG\', \'' . DIR_OPENCART . 'system/config/\');' . "\n";
			$output .= 'define(\'DIR_IMAGE\', \'' . DIR_OPENCART . 'image/\');' . "\n";
			$output .= 'define(\'DIR_CACHE\', \'' . DIR_OPENCART . 'system/cache/\');' . "\n";
			$output .= 'define(\'DIR_UPLOAD\', \'' . DIR_OPENCART . 'system/upload/\');' . "\n";
			$output .= 'define(\'DIR_DOWNLOAD\', \'' . DIR_OPENCART . 'download/\');' . "\n";
			$output .= 'define(\'DIR_VQMOD\', \'' . DIR_OPENCART . 'vqmod/\');' . "\n";
			$output .= 'define(\'DIR_LOGS\', \'' . DIR_OPENCART . 'system/logs/\');' . "\n\n";

			$output .= '// DB' . "\n";
			$output .= 'define(\'DB_DRIVER\', \'' . addslashes($this->request->post['db_driver']) . '\');' . "\n";
			$output .= 'define(\'DB_HOSTNAME\', \'' . addslashes($this->request->post['db_hostname']) . '\');' . "\n";
			$output .= 'define(\'DB_USERNAME\', \'' . addslashes($this->request->post['db_username']) . '\');' . "\n";
			$output .= 'define(\'DB_PASSWORD\', \'' . addslashes(html_entity_decode($this->request->post['db_password'], ENT_QUOTES, 'UTF-8')) . '\');' . "\n";
			$output .= 'define(\'DB_DATABASE\', \'' . addslashes($this->request->post['db_database']) . '\');' . "\n";
			$output .= 'define(\'DB_PORT\', \'' . addslashes($this->request->post['db_port']) . '\');' . "\n";
			$output .= 'define(\'DB_PREFIX\', \'' . addslashes($this->request->post['db_prefix']) . '\');' . "\n";
			$output .= '?>';

			$file = fopen(DIR_OPENCART . 'config.php', 'w');

			fwrite($file, $output);

			fclose($file);

			$output  = '<?php' . "\n";
			$output .= '// HTTP' . "\n";
			$output .= 'define(\'HTTP_SERVER\', \'' . HTTP_OPENCART . 'admin/\');' . "\n";
			$output .= 'define(\'HTTP_IMAGE\', \'' . HTTP_OPENCART . 'image/\');' . "\n";
			$output .= 'define(\'HTTP_CATALOG\', \'' . HTTP_OPENCART . '\');' . "\n\n";

			$output .= '// HTTPS' . "\n";
			$output .= 'define(\'HTTPS_SERVER\', \'' . HTTP_OPENCART . 'admin/\');' . "\n";
			$output .= 'define(\'HTTPS_IMAGE\', \'' . HTTP_OPENCART . 'image/\');' . "\n";
			$output .= 'define(\'HTTPS_CATALOG\', \'' . HTTP_OPENCART . '\');' . "\n\n";

			$output .= '// DIR' . "\n";
			$output .= 'define(\'DIR_APPLICATION\', \'' . DIR_OPENCART . 'admin/\');' . "\n";
			$output .= 'define(\'DIR_SYSTEM\', \'' . DIR_OPENCART . 'system/\');' . "\n";
			$output .= 'define(\'DIR_DATABASE\', \'' . DIR_OPENCART . 'system/database/\');' . "\n";
			$output .= 'define(\'DIR_LANGUAGE\', \'' . DIR_OPENCART . 'admin/language/\');' . "\n";
			$output .= 'define(\'DIR_TEMPLATE\', \'' . DIR_OPENCART . 'admin/view/template/\');' . "\n";
			$output .= 'define(\'DIR_CONFIG\', \'' . DIR_OPENCART . 'system/config/\');' . "\n";
			$output .= 'define(\'DIR_IMAGE\', \'' . DIR_OPENCART . 'image/\');' . "\n";
			$output .= 'define(\'DIR_CACHE\', \'' . DIR_OPENCART . 'system/cache/\');' . "\n";
			$output .= 'define(\'DIR_UPLOAD\', \'' . DIR_OPENCART . 'system/upload/\');' . "\n";
			$output .= 'define(\'DIR_DOWNLOAD\', \'' . DIR_OPENCART . 'download/\');' . "\n";
			$output .= 'define(\'DIR_VQMOD\', \'' . DIR_OPENCART . 'vqmod/\');' . "\n";
			$output .= 'define(\'DIR_LOGS\', \'' . DIR_OPENCART . 'system/logs/\');' . "\n";
			$output .= 'define(\'DIR_CATALOG\', \'' . DIR_OPENCART . 'catalog/\');' . "\n\n";

			$output .= '// DB' . "\n";
			$output .= 'define(\'DB_DRIVER\', \'' . addslashes($this->request->post['db_driver']) . '\');' . "\n";
			$output .= 'define(\'DB_HOSTNAME\', \'' . addslashes($this->request->post['db_hostname']) . '\');' . "\n";
			$output .= 'define(\'DB_USERNAME\', \'' . addslashes($this->request->post['db_username']) . '\');' . "\n";
			$output .= 'define(\'DB_PASSWORD\', \'' . addslashes(html_entity_decode($this->request->post['db_password'], ENT_QUOTES, 'UTF-8')) . '\');' . "\n";
			$output .= 'define(\'DB_DATABASE\', \'' . addslashes($this->request->post['db_database']) . '\');' . "\n";
			$output .= 'define(\'DB_PORT\', \'' . addslashes($this->request->post['db_port']) . '\');' . "\n";
			$output .= 'define(\'DB_PREFIX\', \'' . addslashes($this->request->post['db_prefix']) . '\');' . "\n";
			$output .= '?>';

			$file = fopen(DIR_OPENCART . 'admin/config.php', 'w');

			fwrite($file, $output);

			fclose($file);

			$this->response->redirect($this->url->link('step_4'));
		}

		$this->document->setTitle($this->language->get('heading_step_3'));

		$this->data['heading_step_3'] = $this->language->get('heading_step_3');

		$this->data['text_license'] = $this->language->get('text_license');
		$this->data['text_installation'] = $this->language->get('text_installation');
		$this->data['text_configuration'] = $this->language->get('text_configuration');
		$this->data['text_finished'] = $this->language->get('text_finished');
		$this->data['text_db_connection'] = $this->language->get('text_db_connection');
		$this->data['text_db_administration'] = $this->language->get('text_db_administration');
		$this->data['text_db_option'] = $this->language->get('text_db_option');
		$this->data['text_mysqli'] = $this->language->get('text_mysqli');
		$this->data['text_mysql'] = $this->language->get('text_mysql');
		$this->data['text_mpdo'] = $this->language->get('text_mpdo');
		$this->data['text_pgsql'] = $this->language->get('text_pgsql');
		$this->data['text_activate'] = $this->language->get('text_activate');
		$this->data['text_remove'] = $this->language->get('text_remove');

		$this->data['entry_db_driver'] = $this->language->get('entry_db_driver');
		$this->data['entry_db_hostname'] = $this->language->get('entry_db_hostname');
		$this->data['entry_db_username'] = $this->language->get('entry_db_username');
		$this->data['entry_db_password'] = $this->language->get('entry_db_password');
		$this->data['entry_db_database'] = $this->language->get('entry_db_database');
		$this->data['entry_db_port'] = $this->language->get('entry_db_port');
		$this->data['entry_db_prefix'] = $this->language->get('entry_db_prefix');
		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_rewrite'] = $this->language->get('entry_rewrite');
		$this->data['entry_maintenance'] = $this->language->get('entry_maintenance');
		$this->data['entry_demo_data'] = $this->language->get('entry_demo_data');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['db_driver'])) {
			$this->data['error_db_driver'] = $this->error['db_driver'];
		} else {
			$this->data['error_db_driver'] = '';
		}

		if (isset($this->error['db_hostname'])) {
			$this->data['error_db_hostname'] = $this->error['db_hostname'];
		} else {
			$this->data['error_db_hostname'] = '';
		}

		if (isset($this->error['db_username'])) {
			$this->data['error_db_username'] = $this->error['db_username'];
		} else {
			$this->data['error_db_username'] = '';
		}

		if (isset($this->error['db_database'])) {
			$this->data['error_db_database'] = $this->error['db_database'];
		} else {
			$this->data['error_db_database'] = '';
		}

		if (isset($this->error['db_port'])) {
			$this->data['error_db_port'] = $this->error['db_port'];
		} else {
			$this->data['error_db_port'] = '';
		}

		if (isset($this->error['db_prefix'])) {
			$this->data['error_db_prefix'] = $this->error['db_prefix'];
		} else {
			$this->data['error_db_prefix'] = '';
		}

		if (isset($this->error['username'])) {
			$this->data['error_username'] = $this->error['username'];
		} else {
			$this->data['error_username'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		$this->data['action'] = $this->url->link('step_3');

		if (isset($this->request->post['db_driver'])) {
			$this->data['db_driver'] = $this->request->post['db_driver'];
		} else {
			$this->data['db_driver'] = 'mysqli';
		}

		if (isset($this->request->post['db_hostname'])) {
			$this->data['db_hostname'] = $this->request->post['db_hostname'];
		} else {
			$this->data['db_hostname'] = 'localhost';
		}

		if (isset($this->request->post['db_username'])) {
			$this->data['db_username'] = html_entity_decode($this->request->post['db_username']);
		} else {
			$this->data['db_username'] = '';
		}

		if (isset($this->request->post['db_password'])) {
			$this->data['db_password'] = html_entity_decode($this->request->post['db_password']);
		} else {
			$this->data['db_password'] = '';
		}

		if (isset($this->request->post['db_database'])) {
			$this->data['db_database'] = html_entity_decode($this->request->post['db_database']);
		} else {
			$this->data['db_database'] = '';
		}

		if (isset($this->request->post['db_port'])) {
			$this->data['db_port'] = $this->request->post['db_port'];
		} else {
			$this->data['db_port'] = 3306;
		}

		if (isset($this->request->post['db_prefix'])) {
			$this->data['db_prefix'] = html_entity_decode($this->request->post['db_prefix']);
		} else {
			$this->data['db_prefix'] = 'oc_';
		}

		if (isset($this->request->post['username'])) {
			$this->data['username'] = $this->request->post['username'];
		} else {
			$this->data['username'] = 'admin';
		}

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}

		$this->data['mysqli'] = extension_loaded('mysqli');
		$this->data['mysql'] = extension_loaded('mysql');
		$this->data['pdo'] = extension_loaded('pdo');
		$this->data['pgsql'] = extension_loaded('pgsql');

		// Advanced Options
		if (file_exists('../.htaccess.txt') && is_writable('../.htaccess.txt')) {
			$this->data['htaccess'] = true;
		} else {
			$this->data['htaccess'] = false;
		}

		clearstatcache();

		if (isset($this->request->post['rewrite'])) {
			$this->data['rewrite'] = $this->request->post['rewrite'];
		} else {
			$this->data['rewrite'] = '0';
		}

		if (isset($this->request->post['maintenance'])) {
			$this->data['maintenance'] = $this->request->post['maintenance'];
		} else {
			$this->data['maintenance'] = '';
		}

		if (isset($this->request->post['demo_data'])) {
			$this->data['demo_data'] = $this->request->post['demo_data'];
		} else {
			$this->data['demo_data'] = '';
		}

		$this->data['back'] = $this->url->link('step_2');

		$this->template = 'step_3.tpl';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->request->post['db_hostname']) {
			$this->error['db_hostname'] = $this->language->get('error_db_hostname');
		}

		if (!$this->request->post['db_username']) {
			$this->error['db_username'] = $this->language->get('error_db_username');
		}

		if (!$this->request->post['db_database']) {
			$this->error['db_database'] = $this->language->get('error_db_database');
		}

		if (!$this->request->post['db_port']) {
			$this->error['db_port'] = $this->language->get('error_db_port');
		}

		if ($this->request->post['db_prefix'] && preg_match('/[^a-z0-9_]/', $this->request->post['db_prefix'])) {
			$this->error['db_prefix'] = $this->language->get('error_db_prefix');
		}

		if ($this->request->post['db_driver'] == 'mysql') {
			if (function_exists('mysql_connect')) {
				if (!$connection = @mysql_connect($this->request->post['db_hostname'], $this->request->post['db_username'], html_entity_decode($this->request->post['db_password'], ENT_QUOTES, 'UTF-8'))) {
					$this->error['warning'] = $this->language->get('error_db_connect');
				} else {
					if (!@mysql_select_db($this->request->post['db_database'], $connection)) {
						$this->error['warning'] = $this->language->get('error_db_not_exist');
					}

					mysql_close($connection);
				}

			} else {
				$this->error['db_driver'] = $this->language->get('error_db_mysql');
			}
		}

		if ($this->request->post['db_driver'] == 'mysqli') {
			if (function_exists('mysqli_connect')) {
				$connection = new mysqli($this->request->post['db_hostname'], $this->request->post['db_username'], html_entity_decode($this->request->post['db_password'], ENT_QUOTES, 'UTF-8'), $this->request->post['db_database'], $this->request->post['db_port']);

				if (mysqli_connect_error()) {
					$this->error['warning'] = $this->language->get('error_db_connect');
				} else {
					$connection->close();
				}

			} else {
				$this->error['db_driver'] = $this->language->get('error_db_mysqli');
			}
		}

		if ($this->request->post['db_driver'] == 'mpdo') {
			try {
				new mPDO($this->request->post['db_hostname'], $this->request->post['db_username'], $this->request->post['db_password'], $this->request->post['db_database'], $this->request->post['db_port']);
			} catch(Exception $e) {
				$this->error['warning'] = $e->getMessage();
			}
		}

		if (!$this->request->post['username']) {
			$this->error['username'] = $this->language->get('error_username');
		}

		if (!$this->request->post['password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (!is_writable(DIR_OPENCART . 'config.php')) {
			$this->error['warning'] = $this->language->get('error_config') . DIR_OPENCART . 'config.php!';
		}

		if (!is_writable(DIR_OPENCART . 'admin/config.php')) {
			$this->error['warning'] = $this->language->get('error_config') . DIR_OPENCART . 'admin/config.php!';
		}

		clearstatcache();

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>