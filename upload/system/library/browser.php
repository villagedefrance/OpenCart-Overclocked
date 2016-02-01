<?php
class Browser {
	var $agent = null;

	var $is_robot = false;
	var $is_browser = false;
	var $is_pad = false;
	var $is_mobile = false;

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
			if ($this->_load_agent_file()) {
				$this->_compile_data();
			}
		}
	}

	// Compile the User Agent data
	private function _load_agent_file() {
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
	private function _compile_data() {
		$this->_set_platform();

		foreach (array('_set_robot', '_set_browser', '_set_pad', '_set_mobile') as $function) {
			if ($this->$function() === true) {
				break;
			}
		}
	}

	// Set the Platform
	private function _set_platform() {
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
	private function _set_robot() {
		if (is_array($this->robots) && count($this->robots) > 0) {
			foreach ($this->robots as $key => $val) {
				if (preg_match("|" . preg_quote($key) . "|i", $this->agent)) {
					$this->is_robot = true;

					$this->robot = $val;

					return true;
				}
			}
		}

		return false;
	}

	// Set the Browser
	private function _set_browser() {
		if (is_array($this->browsers) && count($this->browsers) > 0) {
			foreach ($this->browsers as $key => $val) {
				if (preg_match("|" . preg_quote($key) . ".*?([0-9\.]+)|i", $this->agent, $match)) {
					$this->is_browser = true;

					$this->browser_version = (isset($match[1]) ? $match[1] : '');

					$this->browser = $val;

					if ($this->_set_pad() == false) {
					    $this->_set_mobile();
					}

					return true;
				}
			}
		}

		return false;
	}

	// Set the Pad Device
	private function _set_pad() {
		if (is_array($this->pads) && count($this->pads) > 0) {
			foreach ($this->pads as $key => $val) {
				if (strpos(strtolower($this->agent), $key) !== false) {
					$this->is_pad = true;

					$this->pad = $val;

					return true;
				}
			}
		}

		return false;
	}

	// Set the Mobile Device
	private function _set_mobile() {
		if (is_array($this->mobiles) && count($this->mobiles) > 0) {
			foreach ($this->mobiles as $key => $val) {
				if (strpos(strtolower($this->agent), $key) !== false) {
					$this->is_mobile = true;

					$this->mobile = $val;

					return true;
				}
			}
		}

		return false;
	}

	// Set the accepted languages
	private function _set_languages() {
		if ((count($this->accept_languages) == 0) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE'] != '') {
			$languages = preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE'])));

			$this->accept_languages = explode(',', $languages);
		}

		if (count($this->accept_languages) == 0) {
			$this->accept_languages = array('Undefined');
		}
	}

	// Set the accepted character sets
	private function _set_charsets() {
		if ((count($this->accept_charsets) == 0) && isset($_SERVER['HTTP_ACCEPT_CHARSET']) && $_SERVER['HTTP_ACCEPT_CHARSET'] != '') {
			$charsets = preg_replace('/(;q=.+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_CHARSET'])));

			$this->accept_charsets = explode(',', $charsets);
		}

		if (count($this->accept_charsets) == 0) {
			$this->accept_charsets = array('Undefined');
		}
	}

	// Is Robot
	public function is_robot($key = null) {
		if (!$this->is_robot) {
			return false;
		}

		if ($key === null) {
			return true;
		}

		return array_key_exists($key, $this->robots) && $this->robot === $this->robots[$key];
	}

	// Is Browser
	public function is_browser($key = null) {
		if (!$this->is_browser) {
			return false;
		}

		if ($key === null) {
			return true;
		}

		return array_key_exists($key, $this->browsers) && $this->browser === $this->browsers[$key];
	}

	// Is Pad
	public function is_pad($key = null) {
		if (!$this->is_pad) {
			return false;
		}

		if ($key === null) {
			return true;
		}

		return array_key_exists($key, $this->pads) && $this->pad === $this->pads[$key];
	}

	// Is Mobile
	public function is_mobile($key = null) {
		if (!$this->is_mobile) {
			return false;
		}

		if ($key === null) {
			return true;
		}

		return array_key_exists($key, $this->mobiles) && $this->mobile === $this->mobiles[$key];
	}

	// Get Medium: robot, pad, mobile, web
	public function getMedium() {
		if ($this->is_robot) {
			return 'robot';
		} elseif ($this->is_pad) {
			return 'pad';
		} elseif ($this->is_mobile) {
			return 'mobile';
		} else {
			return 'web';
		}
	}

	// Is this a referral from another site?
	public function is_referral() {
		if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == '') {
			return false;
		}

		return true;
	}

	// Agent String
	public function agent_string() {
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
		return (isset($this->browser_version)) ? $this->browser_version : '000';
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
			$this->_set_languages();
		}

		return $this->accept_languages;
	}

	// Get the accepted Character Sets
	public function getAcceptCharsets() {
		if (count($this->charsets) == 0) {
			$this->_set_charsets();
		}

		return $this->accept_charsets;
	}

	// Test for a particular language
	public function accept_lang($lang = 'en') {
		return (in_array(strtolower($lang), $this->languages(), true));
	}

	// Test for a particular character set
	public function accept_charset($charset = 'utf-8') {
		return (in_array(strtolower($charset), $this->charsets(), true));
	}
}
?>