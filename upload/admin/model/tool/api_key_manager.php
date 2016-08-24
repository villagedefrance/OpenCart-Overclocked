<?php
class ModelToolApiKeyManager extends Model {

	public function addApiKey($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "api_key SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', status = '" . $this->db->escape($data['status']) . "'");

		$api_key_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_api_key_id'] = $api_key_id;
	}

	public function editApiKey($api_key_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "api_key SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', status = '" . $this->db->escape($data['status']) . "' WHERE api_key_id = '" . (int)$api_key_id . "'");
	}

	public function deleteApiKey($api_key_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "api_key WHERE api_key_id = " . (int)$api_key_id);
	}

	public function getApiKey($api_key_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "api_key WHERE api_key_id = '" . (int)$api_key_id . "'");

		return $query->row;
	}

	public function getApiKeys($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "api_key";

		$sort_data = array(
			'api_key_id',
			'name',
			'code'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getTotalApiKeys() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "api_key");

		return $query->row['total'];
	}
}
