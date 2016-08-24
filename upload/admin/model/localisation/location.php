<?php
class ModelLocalisationLocation extends Model {

	public function addLocation($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "location SET name = '" . $this->db->escape($data['name']) . "', address = '" . $this->db->escape($data['address']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', image = '" . $this->db->escape($data['image']) . "', latitude = '" . $this->db->escape($data['latitude']) . "', longitude = '" . $this->db->escape($data['longitude']) . "', `open` = '" . $this->db->escape($data['open']) . "', `comment` = '" . $this->db->escape($data['comment']) . "'");

		$location_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_location_id'] = $location_id;
	}

	public function editLocation($location_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "location SET name = '" . $this->db->escape($data['name']) . "', address = '" . $this->db->escape($data['address']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', image = '" . $this->db->escape($data['image']) . "', latitude = '" . $this->db->escape($data['latitude']) . "', longitude = '" . $this->db->escape($data['longitude']) . "', `open` = '" . $this->db->escape($data['open']) . "', `comment` = '" . $this->db->escape($data['comment']) . "' WHERE location_id = '" . (int)$location_id . "'");
	}

	public function deleteLocation($location_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "location WHERE location_id = " . (int)$location_id);
	}

	public function getLocation($location_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "location WHERE location_id = '" . (int)$location_id . "'");

		return $query->row;
	}

	public function getLocations($data = array()) {
		$sql = "SELECT location_id, image, name, address, telephone, latitude, longitude FROM " . DB_PREFIX . "location";

		$sort_data = array(
			'image',
			'name',
			'address',
			'telephone',
			'latitude',
			'longitude'
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

	public function getTotalLocations() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "location");

		return $query->row['total'];
	}
}
