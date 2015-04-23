<?php
final class Encryption {
	private $key;

    public function __construct($key) {
        $this->key = hash('sha256', $key, true);
    }

    public function encrypt($value) {
        $ivsize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

        $iv = mcrypt_create_iv($ivsize, MCRYPT_DEV_RANDOM);

        $ciphervalue = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, $value, MCRYPT_MODE_CBC, $iv);

        return base64_encode($iv.$ciphervalue);
    }

    public function decrypt($value) {
        $value = base64_decode($value);

        $ivsize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

        if (strlen($value) < $ivsize) {
            throw new Exception('Missing initialization vector!');
        }

        $iv = substr($value, 0, $ivsize);
        $value = substr($value, $ivsize);

        $plainvalue = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, $value, MCRYPT_MODE_CBC, $iv);

        return rtrim($plainvalue, "\0");
    }
}
?>