<?php
class ModelUserUser extends Model {

	public function addUser($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "user` SET username = '" . $this->db->escape($data['username']) . "', salt = '" . $this->db->escape($salt = substr(hash_rand('md5'), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', user_group_id = '" . (int)$data['user_group_id'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$user_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_user_id'] = $user_id;

		if (isset($data['image'])) {
			$this->db->query("UPDATE `" . DB_PREFIX . "user` SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE user_id = '" . (int)$user_id . "'");
		}
	}

	public function editUser($user_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET username = '" . $this->db->escape($data['username']) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', user_group_id = '" . (int)$data['user_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE user_id = '" . (int)$user_id . "'");

		if ($data['password']) {
			$this->db->query("UPDATE `" . DB_PREFIX . "user` SET salt = '" . $this->db->escape($salt = substr(hash_rand('md5'), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE user_id = '" . (int)$user_id . "'");
		}

		if (isset($data['image'])) {
			$this->db->query("UPDATE `" . DB_PREFIX . "user` SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE user_id = '" . (int)$user_id . "'");
		}
	}

	public function editPassword($user_id, $password) {
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET salt = '" . $this->db->escape($salt = substr(hash_rand('md5'), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', `code` = '' WHERE user_id = '" . (int)$user_id . "'");
	}

	public function editCode($email, $code) {
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET `code` = '" . $this->db->escape($code) . "' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}

	public function deleteUser($user_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'");
	}

	public function getUser($user_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'");

		return $query->row;
	}

	public function getUserName($user_id) {
		$query = $this->db->query("SELECT DISTINCT username FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'");

		return $query->row['username'];
	}

	public function getUsers($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "user`";

		if (isset($data['filter_name'])) {
			$sql .= " WHERE username LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY user_id";

		$sort_data = array(
			'user_id',
			'username',
			'user_group_id',
			'email',
			'date_added',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY username";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getUserByUsername($username) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE username = '" . $this->db->escape($username) . "'");

		return $query->row;
	}

	public function getUserByEmail($email) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getUserByCode($code) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE `code` = '" . $this->db->escape($code) . "' AND `code` != ''");

		return $query->row;
	}

	public function getUserGroup($user_id, $user_group_id) {
		$query = $this->db->query("SELECT ug.name AS name FROM " . DB_PREFIX . "user_group ug LEFT JOIN `" . DB_PREFIX . "user` u ON (ug.user_group_id = u.user_group_id) WHERE ug.user_group_id = '" . (int)$user_group_id . "' AND u.user_id = '" . (int)$user_id . "'");

		return $query->row['name'];
	}

	// Checks
	public function checkUserPassword($password, $user_id, $username) {
		$query = $this->db->query("SELECT CASE WHEN (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "')))))) THEN 0 ELSE 1 END AS result FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "' AND username = '" . $this->db->escape($username) . "' AND status = '1'");

		if ($query->row['result']) {
			return $query->row['result'];
		} else {
			return false;
		}
	}

	// Totals
	public function getTotalUsers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user`");

		return $query->row['total'];
	}

	public function getTotalUsersByGroupId($user_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user` WHERE user_group_id = '" . (int)$user_group_id . "'");

		return $query->row['total'];
	}

	public function getTotalUsersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row['total'];
	}
}
