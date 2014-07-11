<?php
class Captcha {
	protected $code;
	protected $width = 35;
	protected $height = 150;

	function __construct() {
		$this->length = 6; // This will change how many characters to show, Default = 6

		$this->code = null;

		// Get characters, notice we do not use 0,o,O and I, as they can be confusing.
		$char  = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
		$char .= '123456789123456789123456789';
		$char .= 'abcdefghijkmnpqrstuvwxyz';

		$i = 0;

		while ($i < $this->length) {
			$this->code .= substr($char, mt_rand(0, strlen($char)-1), 1);
			$i++;
		}

		return substr($this->code, 0);
	}

	function getCode() {
		return substr($this->code, 0);
	}

	function showImage() {
		$image = imagecreatetruecolor($this->height, $this->width);

		$width = imagesx($image);
		$height = imagesy($image);

		$black = imagecolorallocate($image, 0, 0, 0);
		$grey = imagecolorallocate($image, 180, 180, 180);
		$white = imagecolorallocate($image, 255, 255, 255);

		$red = imagecolorallocatealpha($image, 255, 0, 0, 60);
		$green = imagecolorallocatealpha($image, 0, 255, 0, 60);
		$blue = imagecolorallocatealpha($image, 0, 0, 255, 60);

		$cyan = imagecolorallocatealpha($image, 0, 255, 255, 60);
		$yellow = imagecolorallocatealpha($image, 255, 255, 0, 60);
		$magenta = imagecolorallocatealpha($image, 255, 0, 255, 60);

		imagefilledrectangle($image, 0, 0, $width, $height, $white);

		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 60, 30, $red);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 60, 30, $green);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 60, 30, $blue);

		$values1 = array(
			ceil(rand(5, 145)), ceil(rand(0, 35)),// Point 1 (x, y)
			ceil(rand(5, 145)), ceil(rand(0, 35)),// Point 2 (x, y)
			ceil(rand(5, 145)), ceil(rand(0, 35))// Point 3 (x, y)
		);

		$values2 = array(
			ceil(rand(5, 145)), ceil(rand(0, 35)),// Point 1 (x, y)
			ceil(rand(5, 145)), ceil(rand(0, 35)),// Point 2 (x, y)
			ceil(rand(5, 145)), ceil(rand(0, 35))// Point 3 (x, y)
		);

		$values3 = array(
			ceil(rand(5, 145)), ceil(rand(0, 35)),// Point 1 (x, y)
			ceil(rand(5, 145)), ceil(rand(0, 35)),// Point 2 (x, y)
			ceil(rand(5, 145)), ceil(rand(0, 35))// Point 3 (x, y)
		);

		imagefilledpolygon($image, $values1, 3, $yellow);
		imagefilledpolygon($image, $values2, 3, $cyan);
		imagefilledpolygon($image, $values3, 3, $magenta);

		imagefilledrectangle($image, 0, 0, $width, 0, $grey);
		imagefilledrectangle($image, $width - 1, 0, $width - 1, $height - 1, $grey);
		imagefilledrectangle($image, 0, 0, 0, $height - 1, $grey);
		imagefilledrectangle($image, 0, $height - 1, $width, $height - 1, $grey);

		imagestring($image, 10, intval(($width - (strlen($this->code) * 9)) / 2), intval(($height - 15) / 2), $this->code, $black);

		header('Content-type: image/jpeg');

		imagejpeg($image);

		imagedestroy($image);
	}
}
?>