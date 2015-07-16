<?php
class Session {
	public $data = array();

	public function __construct() {
		if (!session_id()) {
			ini_set('session.use_only_cookies', 'On');
			ini_set('session.use_cookies', 'On');
			ini_set('session.use_trans_sid', 'Off');
			ini_set('session.cookie_httponly', 'On');

			session_set_cookie_params(0, '/');
			session_start();
		}

		$this->data =& $_SESSION;
	}

	public function getId($session_id = '') {
		if ($session_id) {
			return session_id($session_id);
		} else {
			return session_id();
		}
	}

	public function regenerateId($delete = false) {
		return session_regenerate_id($delete);
	}
}
?>