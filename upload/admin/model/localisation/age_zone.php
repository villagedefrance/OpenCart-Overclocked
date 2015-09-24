<?php
class ModelLocalisationAgeZone extends Model {

	public function addAgeZone($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "age_zone SET name = '" . $this->db->escape($data['name']) . "', age = '" . $this->db->escape($data['age']) . "', date_added = NOW()");

		$age_zone_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_age_zone_id'] = $age_zone_id;

		if (isset($data['zone_to_age_zone'])) {
			foreach ($data['zone_to_age_zone'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "zone_to_age_zone SET country_id = '" . (int)$value['country_id'] . "', zone_id = '" . (int)$value['zone_id'] . "', age_zone_id = '" . (int)$age_zone_id . "', date_added = NOW()");
			}
		}

		$this->cache->delete('age_zone');
	}

	public function editAgeZone($age_zone_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "age_zone SET name = '" . $this->db->escape($data['name']) . "', age = '" . $this->db->escape($data['age']) . "', date_modified = NOW() WHERE age_zone_id = '" . (int)$age_zone_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "zone_to_age_zone WHERE age_zone_id = '" . (int)$age_zone_id . "'");

		if (isset($data['zone_to_age_zone'])) {
			foreach ($data['zone_to_age_zone'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "zone_to_age_zone SET country_id = '" . (int)$value['country_id'] . "', zone_id = '" . (int)$value['zone_id'] . "', age_zone_id = '" . (int)$age_zone_id . "', date_added = NOW()");
			}
		}

		$this->cache->delete('age_zone');
	}

	public function deleteAgeZone($age_zone_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "age_zone WHERE age_zone_id = '" . (int)$age_zone_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "zone_to_age_zone WHERE age_zone_id = '" . (int)$age_zone_id . "'");

		$this->cache->delete('age_zone');
	}

	public function getAgeZone($age_zone_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "age_zone WHERE age_zone_id = '" . (int)$age_zone_id . "'");

		return $query->row;
	}

	public function getAgeZones($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "age_zone";

			$sort_data = array(
				'name',
				'age'
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

		} else {
			$age_zone_data = $this->cache->get('age_zone');

			if (!$age_zone_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "age_zone ORDER BY name ASC");

				$age_zone_data = $query->rows;

				$this->cache->set('age_zone', $age_zone_data);
			}

			return $age_zone_data;
		}
	}

	public function getTotalAgeZones() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "age_zone");

		return $query->row['total'];
	}

	public function getZoneToAgeZones($age_zone_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_age_zone WHERE age_zone_id = '" . (int)$age_zone_id . "'");

		return $query->rows;
	}

	public function getTotalZoneToAgeZoneByAgeZoneId($age_zone_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "zone_to_age_zone WHERE age_zone_id = '" . (int)$age_zone_id . "'");

		return $query->row['total'];
	}

	public function getTotalZoneToAgeZoneByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "zone_to_age_zone WHERE country_id = '" . (int)$country_id . "'");

		return $query->row['total'];
	}

	public function getTotalZoneToAgeZoneByZoneId($zone_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "zone_to_age_zone WHERE zone_id = '" . (int)$zone_id . "'");

		return $query->row['total'];
	}
}
?>