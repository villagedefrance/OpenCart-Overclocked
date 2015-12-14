<?php
class ControllerUpgrade extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle($this->language->get('heading_upgrade'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->initialize();

			$this->data['heading_success'] = $this->language->get('heading_success');

			$this->data['text_finished'] = $this->language->get('text_finished');
			$this->data['text_upgrade'] = $this->language->get('text_upgrade');
			$this->data['text_success'] = $this->language->get('text_congratulation');
			$this->data['text_forget'] = $this->language->get('text_forget');
			$this->data['text_shop'] = $this->language->get('text_shop');
			$this->data['text_login'] = $this->language->get('text_login');

			$this->template = 'success.tpl';
			$this->children = array(
				'header',
				'footer'
			);

			$this->response->setOutput($this->render());

		} else {
			$this->data['heading_upgrade'] = $this->language->get('heading_upgrade');

			$this->data['text_finished'] = $this->language->get('text_finished');
			$this->data['text_upgrade'] = $this->language->get('text_upgrade');
			$this->data['text_follow_steps'] = $this->language->get('text_follow_steps');
			$this->data['text_clear_cookie'] = $this->language->get('text_clear_cookie');
			$this->data['text_admin_page'] = $this->language->get('text_admin_page');
			$this->data['text_admin_user'] = $this->language->get('text_admin_user');
			$this->data['text_admin_setting'] = $this->language->get('text_admin_setting');
			$this->data['text_store_front'] = $this->language->get('text_store_front');
			$this->data['text_be_patient'] = $this->language->get('text_be_patient');

			$this->data['button_upgrade'] = $this->language->get('button_upgrade');

			$this->data['action'] = $this->url->link('upgrade');

			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} else {
				$this->data['error_warning'] = '';
			}

			$this->template = 'upgrade.tpl';
			$this->children = array(
				'header',
				'footer'
			);

			$this->response->setOutput($this->render());
		}
	}

	public function initialize() {
		$status = false;

		// Check if the sql file exists
		$file = DIR_APPLICATION . 'opencart-clean.sql';

		if (!file_exists($file)) {
			exit('Could not load sql file: ' . $file);
		} else {
			$status = true;
		}

		clearstatcache();

		$this->load->model('upgrade');

		if ($status) {
			$step1 = false;
			$step2 = false;
			$step3 = false;
			$step4 = false;
			$step5 = false;

			$this->model_upgrade->dataTables($step1);

			if ($step1) {
				$this->model_upgrade->additionalTables($step2);
			}

			if ($step2) {
				$this->model_upgrade->repairCategories(0, $step3);
			}

			if ($step3) {
				$this->model_upgrade->updateConfig($step4);
			}

			if ($step4) {
				$this->model_upgrade->updateLayouts($step5);
			}

		} else {
			return;
		}
	}

	private function validate() {
		if (DB_DRIVER == 'mysql') {
			if (!$connection = @mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)) {
				$this->error['warning'] = $this->language->get('error_db_connect');
			} else {
				if (!mysql_select_db(DB_DATABASE, $connection)) {
					$this->error['warning'] = 'Error: Database "' . DB_DATABASE . '" does not exist!';
				}

				mysql_close($connection);
			}
		}

		if (DB_DRIVER == 'mysqli') {
			$link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

			if (mysqli_connect_errno()) {
				$this->error['warning'] = 'Error database connect: "' . mysqli_connect_error() . '"';
				exit();
			}

			if (!mysqli_ping($link)) {
				$this->error['warning'] = 'Error database server: "' . mysqli_error($link) . '"';
			}

			mysqli_close($link);
		}

		if (DB_DRIVER == 'mpdo') {
			try {
				new \PDO("mysql:host=" . DB_HOSTNAME . ";port=" . DB_PORT . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD, array(\PDO::ATTR_PERSISTENT => true));
			} catch(Exception $e) {
				$this->error['warning'] = $e->getMessage();
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>