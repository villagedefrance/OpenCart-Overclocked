<?php
class Browser {
	var $agent = null;

	var $isRobot = false;
	var $isBrowser = false;
	var $isPad = false;
	var $isMobile = false;

	var $languages = array();
	var $charsets = array();

	var $platforms = array();
	var $robots = array();
	var $browsers = array();
	var $pads = array();
	var $mobiles = array();

	var $platform = '';
	var $robot = '';
	var $browser = '';
	var $version = '';
	var $pad = '';
	var $mobile = '';

	public function __construct() {
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$this->agent = trim($_SERVER['HTTP_USER_AGENT']);
		} else {
			return;
		}

		if (!is_null($this->agent)) {
			if ($this->loadAgentFile()) {
				$this->compileData();
			}
		}
	}

	// Compile the User Agent data
	protected function loadAgentFile() {
		if (file_exists(DIR_SYSTEM . 'helper/agent.php') && is_file(DIR_SYSTEM . 'helper/agent.php')) {
			include(DIR_SYSTEM . 'helper/agent.php');
		} else {
			return false;
		}

		$return = false;

		if (isset($platforms)) {
			$this->platforms = $platforms;
			unset($platforms);
			$return = true;
		}

		if (isset($robots)) {
			$this->robots = $robots;
			unset($robots);
			$return = true;
		}

		if (isset($browsers)) {
			$this->browsers = $browsers;
			unset($browsers);
			$return = true;
		}

		if (isset($pads)) {
			$this->pads = $pads;
			unset($pads);
			$return = true;
		}

		if (isset($mobiles)) {
			$this->mobiles = $mobiles;
			unset($mobiles);
			$return = true;
		}

		return $return;
	}

	// Compile the User Agent data
	protected function compileData() {
		$this->setPlatform();

		foreach (array('setRobot', 'setBrowser', 'setPad', 'setMobile') as $function) {
			if ($this->$function() === true) {
				break;
			}
		}
	}

	// Set the Platform
	protected function setPlatform() {
		if (is_array($this->platforms) && count($this->platforms) > 0) {
			foreach ($this->platforms as $key => $val) {
				if (preg_match("|" . preg_quote($key) . "|i", $this->agent)) {
					$this->platform = $val;

					return true;
				}
			}
		}

		$this->platform = 'Unknown Platform';
	}

	// Set the Robot
	protected function setRobot() {
		if (is_array($this->robots) && count($this->robots) > 0) {
			foreach ($this->robots as $key => $val) {
				if (preg_match("|" . preg_quote($key) . "|i", $this->agent)) {
					$this->isRobot = true;

					$this->robot = $val;

					return true;
				}
			}
		}

		return false;
	}

	// Set the Browser
	protected function setBrowser() {
		if (is_array($this->browsers) && count($this->browsers) > 0) {
			foreach ($this->browsers as $key => $val) {
				if (preg_match("|" . preg_quote($key) . ".*?([0-9\.]+)|i", $this->agent, $match)) {
					$this->isBrowser = true;

					$this->browserVersion = (isset($match[1]) ? $match[1] : '');

					$this->browser = $val;

					if ($this->setPad() == false) {
					    $this->setMobile();
					}

					return true;
				}
			}
		}

		return false;
	}

	// Set the Pad Device
	protected function setPad() {
		if (is_array($this->pads) && count($this->pads) > 0) {
			foreach ($this->pads as $key => $val) {
				if (strpos(strtolower($this->agent), $key) !== false) {
					$this->isPad = true;

					$this->pad = $val;

					return true;
				}
			}
		}

		return false;
	}

	// Set the Mobile Device
	protected function setMobile() {
		if (is_array($this->mobiles) && count($this->mobiles) > 0) {
			foreach ($this->mobiles as $key => $val) {
				if (strpos(strtolower($this->agent), $key) !== false) {
					$this->isMobile = true;

					$this->mobile = $val;

					return true;
				}
			}
		}

		return false;
	}

	// Set the accepted languages
	protected function setLanguages() {
		if ((count($this->acceptLanguages) == 0) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE'] != '') {
			$languages = preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE'])));

			$this->acceptLanguages = explode(',', $languages);
		}

		if (count($this->acceptLanguages) == 0) {
			$this->acceptLanguages = array('Undefined');
		}
	}

	// Set the accepted character sets
	protected function setCharsets() {
		if ((count($this->acceptCharsets) == 0) && isset($_SERVER['HTTP_ACCEPT_CHARSET']) && $_SERVER['HTTP_ACCEPT_CHARSET'] != '') {
			$charsets = preg_replace('/(;q=.+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_CHARSET'])));

			$this->acceptCharsets = explode(',', $charsets);
		}

		if (count($this->acceptCharsets) == 0) {
			$this->acceptCharsets = array('Undefined');
		}
	}

	// Is Robot
	public function isRobot($key = null) {
		if (!$this->isRobot) {
			return false;
		}

		if ($key === null) {
			return true;
		}

		return array_key_exists($key, $this->robots) && $this->robot === $this->robots[$key];
	}

	// Is Browser
	public function isBrowser($key = null) {
		if (!$this->isBrowser) {
			return false;
		}

		if ($key === null) {
			return true;
		}

		return array_key_exists($key, $this->browsers) && $this->browser === $this->browsers[$key];
	}

	// Is Pad
	public function isPad($key = null) {
		if (!$this->isPad) {
			return false;
		}

		if ($key === null) {
			return true;
		}

		return array_key_exists($key, $this->pads) && $this->pad === $this->pads[$key];
	}

	// Is Mobile
	public function isMobile($key = null) {
		if (!$this->isMobile) {
			return false;
		}

		if ($key === null) {
			return true;
		}

		return array_key_exists($key, $this->mobiles) && $this->mobile === $this->mobiles[$key];
	}

	// Get Medium: robot, pad, mobile, web
	public function getMedium() {
		if ($this->isRobot) {
			return 'robot';
		} elseif ($this->isPad) {
			return 'pad';
		} elseif ($this->isMobile) {
			return 'mobile';
		} else {
			return 'web';
		}
	}

	// Check if Mobile
	public function checkMobile() {
		if ($this->isRobot) {
			return false;
		} elseif ($this->isPad) {
			return true;
		} elseif ($this->isMobile) {
			return true;
		} else {
			return false;
		}
	}

	// Is this a referral from another site?
	public function isReferral() {
		if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == '') {
			return false;
		}

		return true;
	}

	// Agent String
	public function agentString() {
		return $this->agent;
	}

	// Get Platform
	public function getPlatform() {
		return $this->platform;
	}

	// Get The Robot Name
	public function getRobot() {
		return $this->robot;
	}

	// Get Browser Name
	public function getBrowser() {
		return $this->browser;
	}

	// Get the Browser Version
	public function getBrowserVersion() {
		return (isset($this->browserVersion)) ? $this->browserVersion : '000';
	}

	// Get the Tablet Device
	public function getPad() {
		return $this->pad;
	}

	// Get the Mobile Device
	public function getMobile() {
		return $this->mobile;
	}

	// Get the referrer
	public function referrer() {
		return (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == '') ? '' : trim($_SERVER['HTTP_REFERER']);
	}

	// Get the accepted languages
	public function getAcceptLanguages() {
		if (count($this->languages) == 0) {
			$this->setLanguages();
		}

		return $this->acceptLanguages;
	}

	// Get the accepted Character Sets
	public function getAcceptCharsets() {
		if (count($this->charsets) == 0) {
			$this->setCharsets();
		}

		return $this->acceptCharsets;
	}

	// Test for a particular language
	public function acceptLang($lang = 'en') {
		return (in_array(strtolower($lang), $this->languages(), true));
	}

	// Test for a particular character set
	public function acceptCharset($charset = 'utf-8') {
		return (in_array(strtolower($charset), $this->charsets(), true));
	}
}
