<?php
class ControllerUpgrade extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle($this->language->get('heading_upgrade'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->initialize($this->request->post);

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
			$this->data['text_update'] = $this->language->get('text_update');
			$this->data['text_be_patient'] = $this->language->get('text_be_patient');

			$this->data['entry_geo_data'] = $this->language->get('entry_geo_data');

			$this->data['button_upgrade'] = $this->language->get('button_upgrade');

			$this->data['action'] = $this->url->link('upgrade');

			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} else {
				$this->data['error_warning'] = '';
			}

			if (isset($this->request->post['geo_data'])) {
				$this->data['geo_data'] = $this->request->post['geo_data'];
			} else {
				$this->data['geo_data'] = '';
			}

			$this->template = 'upgrade.tpl';
			$this->children = array(
				'header',
				'footer'
			);

			$this->response->setOutput($this->render());
		}
	}

	public function initialize($data) {
		$status = false;

		// Check if the sql file exists
		$file = DIR_APPLICATION . 'opencart-upgrade.sql';

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

			if ($step5 && isset($data['geo_data'])) {
				$file_1 = DIR_SYSTEM . 'reset/oc_zone.csv';

				if (file_exists($file_1)) {
					$content_1 = file_get_contents($file_1);

					if ($content_1) {
						$this->model_upgrade->updateGeoData($file_1);
					}
				}

				$file_2 = DIR_SYSTEM . 'reset/oc_country.csv';
				$file_3 = DIR_SYSTEM . 'reset/oc_country_description.csv';

				if (file_exists($file_2) && file_exists($file_3)) {
					$content_2 = file_get_contents($file_2);
					$content_3 = file_get_contents($file_3);

					if ($content_2 && $content_3) {
						$step_two = true;
						$step_three = false;

						if ($step_two) {
							$this->model_upgrade->updateGeoData($file_2);
							$step_three = true;
						}

						if ($step_three) {
							$this->model_upgrade->updateGeoData($file_3);
						}
					}
				}

				$file_4 = DIR_SYSTEM . 'reset/oc_eucountry.csv';
				$file_5 = DIR_SYSTEM . 'reset/oc_eucountry_description.csv';
				$file_6 = DIR_SYSTEM . 'reset/oc_eucountry_to_store.csv';

				if (file_exists($file_4) && file_exists($file_5) && file_exists($file_6)) {
					$content_4 = file_get_contents($file_4);
					$content_5 = file_get_contents($file_5);
					$content_6 = file_get_contents($file_6);

					if ($content_4 && $content_5 && $content_6) {
						$step_four = true;
						$step_five = false;
						$step_six = false;

						if ($step_four) {
							$this->model_upgrade->updateGeoData($file_4);
							$step_five = true;
						}

						if ($step_five) {
							$this->model_upgrade->updateGeoData($file_5);
							$step_six = true;
						}

						if ($step_six) {
							$this->model_upgrade->updateGeoData($file_6);
						}
					}
				}

				$file_7 = DIR_SYSTEM . 'reset/oc_supplier_group.csv';
				$file_8 = DIR_SYSTEM . 'reset/oc_supplier_group_description.csv';

				if (file_exists($file_7) && file_exists($file_8)) {
					$content_7 = file_get_contents($file_7);
					$content_8 = file_get_contents($file_8);

					if ($content_7 && $content_8) {
						$step_seven = true;
						$step_eight = false;

						if ($step_seven) {
							$this->model_upgrade->updateGeoData($file_7);
							$step_eight = true;
						}

						if ($step_eight) {
							$this->model_upgrade->updateGeoData($file_8);
						}
					}
				}

				clearstatcache();
			}

		} else {
			return;
		}
	}

	protected function validate() {
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
			$connection = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

			if (mysqli_connect_errno()) {
				$this->error['warning'] = 'Error database connect: "' . mysqli_connect_error() . '"';
				exit();
			}

			if (!mysqli_ping($connection)) {
				$this->error['warning'] = 'Error database server: "' . mysqli_error($connection) . '"';
			}

			mysqli_close($connection);
		}

		if (DB_DRIVER == 'mpdo') {
			try {
				new \PDO("mysql:host=" . DB_HOSTNAME . ";port=" . DB_PORT . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD, array(\PDO::ATTR_PERSISTENT => true));
			} catch(Exception $e) {
				$this->error['warning'] = $e->getMessage();
			}
		}

		return empty($this->error);
	}
}
