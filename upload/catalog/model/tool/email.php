<?php
class ModelToolEmail extends Model {

	public function verifyMail($email) {
		$valid = false;

		$connected = $this->checkConnection();

		if ($connected) {
			if ($email && filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
				$domain = substr(strrchr($email, '@'), 1);

				if (checkdnsrr($domain, 'MX')) {
					$valid = true;
				}
			}

		} else {
			$valid = true;
		}

		return $valid;
	}

	protected function checkConnection() {
		$connection = true;

		$local_address = false;
		$local_name = false;
		$local_host = false;

		if (isset($_SERVER['SERVER_ADDR'])) {
			$local_address = ($_SERVER['SERVER_ADDR'] == '::1' || $_SERVER['SERVER_ADDR'] == '127.0.0.1') ? true : false;
		}

		if (isset($_SERVER['SERVER_NAME'])) {
			$local_name = ($_SERVER['SERVER_NAME'] == 'localhost') ? true : false;
		}

		if (isset($_SERVER['HTTP_HOST'])) {
			$local_host = ($_SERVER['HTTP_HOST'] == 'localhost') ? true : false;
		}

		if ($local_address || $local_name || $local_host) {
			$connection = false;
		} else {
			$connection = true;
		}

		return $connection;
	}
}
