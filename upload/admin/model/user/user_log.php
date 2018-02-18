<?php
class ModelUserUserLog extends Model {

	public function getDataLog($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "user_log";

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY `date`";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " ASC";
			} else {
				$sql .= " DESC";
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
		} else {
			return false;
		}
	}

	public function getTotalDataLog($data = array()) {
		$query = $this->db->query("SELECT COUNT(log_id) AS total FROM " . DB_PREFIX . "user_log");

		return $query->row['total'];
	}

	public function clearDataLog($id, $username) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "user_log");

		$url = $this->request->server['REQUEST_URI'];
		$ip = $this->request->server['REMOTE_ADDR'];

		$this->db->query("INSERT INTO " . DB_PREFIX . "user_log SET user_id = '" . (int)$id . "', username = '" . $this->db->escape($username) . "', `action` = 'clear log', `allowed` = '1', `url` = '" . $this->db->escape($url) . "', ip = '" . $this->db->escape($ip) . "', `date` = NOW()");
	}

	public function deleteEntry($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "user_log WHERE log_id = " . (int)$id);
	}

	public function deleteEntryLog($id, $username, $amount) {
		$url = $this->request->server['REQUEST_URI'];
		$ip = $this->request->server['REMOTE_ADDR'];

		$this->db->query("INSERT INTO " . DB_PREFIX . "user_log SET user_id = '" . (int)$id . "', username = '" . $this->db->escape($username) . "', `action` = 'clear " . $this->db->escape($amount) . " entries', `allowed` = '1', `url` = '" . $this->db->escape($url) . "', ip = '" . $this->db->escape($ip) . "', `date` = NOW()");
	}
}
