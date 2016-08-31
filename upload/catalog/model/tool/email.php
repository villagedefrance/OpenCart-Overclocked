<?php
class ModelToolEmail extends Model {

	public function verifyMail($email) {
		$valid = false;

		if ($this->url->isLocal()) {
			$valid = true;
		} else {
			if ($email && filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
				$domain = substr(strrchr($email, '@'), 1);

				if (checkdnsrr($domain, 'MX')) {
					$valid = true;
				}
			}
		}

		return $valid;
	}
}
