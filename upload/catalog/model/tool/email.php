<?php
class ModelToolEmail extends Model {

	function verifyMail($email) {
		$valid = false;

		if ($email && filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
			$domain = substr(strrchr($email, '@'), 1);

			if (checkdnsrr($domain, 'MX')) {
				$valid = true;
			}
		}

		return $valid;
	}
}
?>
