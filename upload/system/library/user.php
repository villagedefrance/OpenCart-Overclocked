<?php
class User {
	private $config;
	private $user_id;
	private $username;
	private $user_group_id;
	private $permission = array();

	protected $registry;

    public function __construct(Registry $registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['user_id'])) {
			$user_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$this->session->data['user_id'] . "' AND status = '1'");

			if ($user_query->num_rows) {
				$this->user_id = $user_query->row['user_id'];
				$this->username = $user_query->row['username'];
				$this->user_group_id = $user_query->row['user_group_id'];

				$this->db->query("UPDATE `" . DB_PREFIX . "user` SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

				$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

				$permissions = unserialize($user_group_query->row['permission']);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
	  				}
				}

			} else {
				$this->logout();
			}
		}
	}

	public function login($username, $password) {
		$username = $this->sanitize($username);

		$url = $this->request->server['REQUEST_URI'];
		$ip = $this->request->server['REMOTE_ADDR'];

		$user_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");

		if ($user_query->num_rows) {
			$this->session->data['user_id'] = $user_query->row['user_id'];

			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];
			$this->user_group_id = $user_query->row['user_group_id'];

			$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

			$permissions = unserialize($user_group_query->row['permission']);

			if (is_array($permissions)) {
				foreach ($permissions as $key => $value) {
					$this->permission[$key] = $value;
				}
			}

			// User Log
			if ($this->config->get('user_log_enable') && $this->config->get('user_log_login')) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "user_log` SET user_id = '" . (int)$this->user_id . "', username = '" . $this->username . "', `action` = 'login', `allowed` = '1', `url` = '" . $this->db->escape($url) . "', `ip` = '" . $this->db->escape($ip) . "', `date` = NOW()");
			}

			return true;

		} else {
			// User Log
			if ($this->config->get('user_log_enable') && $this->config->get('user_log_hacklog')) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "user_log` SET user_id = '" . (int)$this->user_id . "', username = '" . $this->db->escape($username) . "', `action` = 'login', `allowed` = '0', `url` = '" . $this->db->escape($url) . "', `ip` = '" . $this->db->escape($ip) . "', `date` = NOW()");
			}

			return false;
		}
	}

	public function logout() {
		// User Log
		if ($this->config->get('user_log_enable') && $this->config->get('user_log_logout')) {
			$url = $this->request->server['REQUEST_URI'];
			$ip = $this->request->server['REMOTE_ADDR'];

			$this->db->query("INSERT INTO `" . DB_PREFIX . "user_log` SET user_id = '" . (int)$this->user_id . "', username = '" . $this->username . "', `action` = 'logout', `allowed` = '1', `url` = '" . $this->db->escape($url) . "', `ip` = '" . $this->db->escape($ip) . "', `date` = NOW()");
		}

		unset($this->session->data['user_id']);

		$this->user_id = '';
		$this->username = '';
		$this->user_group_id = '';

		session_destroy();
	}

	public function hasPermission($key, $value) {
		$url = $this->request->server['REQUEST_URI'];
		$ip = $this->request->server['REMOTE_ADDR'];

		if (isset($this->permission[$key])) {
			// User Log
			if ($this->config->get('user_log_enable')) {
				if ((($this->config->get('user_log_allowed') == 1 || $this->config->get('user_log_allowed') == 2) && (in_array($value, $this->permission[$key]))) || (($this->config->get('user_log_allowed') == 0 || $this->config->get('user_log_allowed') == 2) && !(in_array($value, $this->permission[$key])))) {
					if (($this->config->get('user_log_access') && $key == "access") || ($this->config->get('user_log_modify') && $key == "modify")) {
						$this->db->query("INSERT INTO `" . DB_PREFIX . "user_log` SET user_id = '" . (int)$this->user_id . "', username = '" . $this->username . "', `action` = '" . $key . "', `allowed` = '" . in_array($value, $this->permission[$key]) . "', `url` = '" . $this->db->escape($url) . "', `ip` = '" . $this->db->escape($ip) . "', `date` = NOW()");
					}
				}
			}

			return in_array($value, $this->permission[$key]);

		} else {
			// User Log
			if ($this->config->get('user_log_enable') && ($this->config->get('user_log_allowed') == 0 || $this->config->get('user_log_allowed') == 2)) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "user_log` SET user_id = '" . (int)$this->user_id . "', username = '" . $this->username . "', `action` = '" . $key . "', `allowed` = '0', `url` = '" . $this->db->escape($url) . "', `ip` = '" . $this->db->escape($ip) . "', `date` = NOW()");
			}

			return false;
		}
	}

	public function isLogged() {
		return $this->user_id;
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUserName() {
		return $this->username;
	}

	public function getUserGroupId() {
		return $this->user_group_id;
	}

	// Security functions
	public function sanitize($string) {
		// Strips HTML and PHP tags
		$string = strip_tags($string);
		// Removes any # from string
		$string = str_replace('#', '', $string);
		// Trims default ASCII characters
		$string = trim($string);

		return $string;
	}

	public function checkUsername($username) {
		$username = strtolower($username);

		$check_name = $this->sanitize($username);

		if ($username === $check_name) {
			return true;
		} else {
			return false;
		}
	}
}
