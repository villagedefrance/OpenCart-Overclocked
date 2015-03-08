<?php
class Captcha {
	protected $code;
	protected $height = 172;
	protected $width = 42;

	function __construct() {
		$this->code = null;

		$word_1 = '';
		$word_2 = '';

		for ($i = 0; $i < 4; $i++) {
			$word_1 .= chr(rand(97, 122));
		}

		for ($i = 0; $i < 4; $i++) {
			$word_2 .= chr(rand(97, 122));
		}

		$this->code .= $word_1 . ' ' . $word_2;

		return substr($this->code, 0);
	}

	function getCode() {
		return substr($this->code, 0);
	}

	function showImage($font) {
		$dir = DIR_SYSTEM . 'library/fonts/';

		if ($font) {
			$fontfile = $font . ".ttf";
		} else {
			$fontfile = "Recaptcha.ttf";
		}

		$image = imagecreatetruecolor($this->height, $this->width);

		$color = imagecolorallocate($image, 10, 10, 10);

		$background = imagecolorallocate($image, 250, 250, 250);

		imagefilledrectangle($image, 0, 0, 262, 42, $background);

		imagettftext($image, 22, 0, 2, 30, $color, $dir.$fontfile, $this->code);

		header("Content-type: image/png");

		imagepng($image);

		imagedestroy($image);
	}
}
?>