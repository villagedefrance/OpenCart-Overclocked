<?php
class Captcha {
	private  $code;
	private  $height = 172;
	private  $width = 42;

	public function __construct() {
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

	public function getCode() {
		return substr($this->code, 0);
	}

	public function showImage($font) {
		$dir = DIR_SYSTEM . 'fonts/';

		if ($font) {
			$fontfile = $font . ".ttf";
		} else {
			$fontfile = "Recaptcha.ttf";
		}

		$image = imagecreatetruecolor($this->height, $this->width);

		$color = imagecolorallocate($image, 10, 10, 10);

		$background = imagecolorallocate($image, 250, 250, 250);

		imagefilledrectangle($image, 0, 0, 262, 42, $background);

		imagettftext($image, 22, 0, 2, 28, $color, $dir.$fontfile, html_entity_decode($this->code));

		header("Content-type: image/png");

		imagepng($image);

		imagedestroy($image);
	}
}
?>