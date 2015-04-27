<?php
final class Encryption {
	private $key;

	public function __construct($key) {
		$this->key = hash('sha256', $key, true);
	}

	public function encrypt($value) {
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);

		$php_version = phpversion();

		if ($php_version >= '5.6') {
			$iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
		} elseif ($php_version >= '5.3') {
			$iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_RANDOM);
		} else {
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		}

		$encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, hash('sha256', $this->key, true), $value, MCRYPT_MODE_CBC, $iv);

		$encoded = base64_encode($encrypted) . '|' . base64_encode($iv);

		return strtr($encoded, '+/=', '-_,');
	}

	public function decrypt($value) {
		$value = explode('|', strtr($value, '-_,', '+/=') . '|');

		$decoded = base64_decode($value[0]);

		$iv = base64_decode($value[1]);

		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);

		if (strlen($iv) !== $iv_size) {
			return false;
		}

		$decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, hash('sha256', $this->key, true), $decoded, MCRYPT_MODE_CBC, $iv));

		return $decrypted;
	}
}
?>