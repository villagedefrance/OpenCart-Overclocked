<?php
class ControllerUpgrade extends Controller {
	private $error = array();

	public function index() {
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('upgrade');

			$this->model_upgrade->mysql();

			$this->redirect($this->url->link('upgrade/success'));
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['action'] = $this->url->link('upgrade');

		$this->template = 'upgrade.tpl';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->setOutput($this->render());
	}

	public function success() {
		$this->template = 'success.tpl';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (DB_DRIVER == 'mysql') {
			if (!$connection = @mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)) {
				$this->error['warning'] = 'Error: Could not connect to the database please make sure the database server, username and password is correct in the config.php file!';
			} else {
				if (!mysql_select_db(DB_DATABASE, $connection)) {
					$this->error['warning'] = 'Error: Database "'. DB_DATABASE . '" does not exist!';
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

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>