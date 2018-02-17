<?php
class User {
	private $user_id;
	private $username;
	private $user_group_id;
	private $permission = array();

	protected $registry;

    public function __construct(Registry $registry) {
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

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['user_id']);

		$this->user_id = '';
		$this->username = '';
		$this->user_group_id = '';

		session_destroy();
	}

	public function hasPermission($key, $value) {
		if (isset($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
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

		// Strips HTML and PHP tags
		$check_name = strip_tags($username);
		// Removes any # from string
		$check_name = str_replace('#', '', $check_name);
		// Trims default ASCII characters
		$check_name = trim($check_name);

		if ($username === $check_name) {
			return true;
		} else {
			return false;
		}
	}
}
