<?php
class Captcha {
	private $code = null;
	private $width = 186;
	private $height = 42;

	public function __construct() {
		$word_1 = '';
		$word_2 = '';

		for ($i = 0; $i < 4; $i++) {
			$word_1 .= chr(rand(97, 122));
		}

		for ($i = 0; $i < 4; $i++) {
			$word_2 .= chr(rand(97, 122));
		}

		$this->code = $word_1 . ' ' . $word_2;

		return $this->code;
	}

	public function getCode() {
		return $this->code;
	}

	public function showImage($font) {
		if ($font) {
			$file = DIR_SYSTEM . 'fonts/' . $font . '.ttf';
		} else {
			$file = DIR_SYSTEM . 'fonts/Recaptcha.ttf';
		}

		$image = imagecreatetruecolor($this->width, $this->height);

		$color = imagecolorallocate($image, 10, 10, 10);

		$background = imagecolorallocate($image, 250, 250, 250);

		imagefilledrectangle($image, 0, 0, 262, 42, $background);

		imagettftext($image, 22, 0, 2, 28, $color, $file, $this->code);

		header('Content-Disposition: Attachment;filename=image.png');
		header('Content-type: image/png');

		imagepng($image, null, 9);

		imagedestroy($image);
	}
}
