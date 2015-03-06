<?php
class Captcha {
	protected $code;
	protected $height = 150;
	protected $width = 40;

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

	function showImage() {
		$dir = DIR_SYSTEM . 'library/fonts/';

		$font = "recaptchaFont.ttf";

		$image = imagecreatetruecolor($this->height, $this->width);

		$color = imagecolorallocate($image, 20, 20, 20);

		$background = imagecolorallocate($image, 250, 250, 250); // #FAFAFA

		imagefilledrectangle($image, 0, 0, 450, 99, $background);

		imagettftext($image, 22, 0, 1, 30, $color, $dir.$font, $this->code);

		header("Content-type: image/png");

		imagepng($image);

		imagedestroy($image);
	}
}
?>