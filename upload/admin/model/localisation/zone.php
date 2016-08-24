<?php
class ModelLocalisationZone extends Model {

	public function addZone($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "zone` SET country_id = '" . (int)$data['country_id'] . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', status = '" . (int)$data['status'] . "'");

		$zone_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_zone_id'] = $zone_id;

		$this->cache->delete('zone');
	}

	public function editZone($zone_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "zone` SET country_id = '" . (int)$data['country_id'] . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', status = '" . (int)$data['status'] . "' WHERE zone_id = '" . (int)$zone_id . "'");

		$this->cache->delete('zone');
	}

	public function deleteZone($zone_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$zone_id . "'");

		$this->cache->delete('zone');
	}

	public function getZone($zone_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$zone_id . "'");

		return $query->row;
	}

	public function getZones($data = array()) {
		$sql = "SELECT *, z.name, cd.name AS country FROM `" . DB_PREFIX . "zone` z LEFT JOIN " . DB_PREFIX . "country c ON (z.country_id = c.country_id) LEFT JOIN " . DB_PREFIX . "country_description cd ON (z.country_id = cd.country_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (isset($data['filter_name'])) {
			$sql .= " AND cd.name = '" . $data['filter_name'] . "'";
		}

		$sort_data = array(
			'cd.name',
			'z.name',
			'z.code',
			'z.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY cd.name";
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

	public function getZonesByCountryId($country_id) {
		$zone_data = $this->cache->get('zone.' . (int)$country_id);

		if (!$zone_data) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE country_id = '" . (int)$country_id . "' AND status = '1' ORDER BY name");

			$zone_data = $query->rows;

			$this->cache->set('zone.' . (int)$country_id, $zone_data);
		}

		return $zone_data;
	}

	public function getTotalZones() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "zone`");

		return $query->row['total'];
	}

	public function getTotalZonesByCountryNames($data = array()) {
		$sql = "SELECT COUNT(DISTINCT z.name) AS total FROM `" . DB_PREFIX . "zone` z";
		$sql .= " LEFT JOIN " . DB_PREFIX . "country c ON (z.country_id = c.country_id)";
		$sql .= " LEFT JOIN " . DB_PREFIX . "country_description cd ON (z.country_id = cd.country_id)";
		$sql .= " WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalZonesByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "zone` WHERE country_id = '" . (int)$country_id . "'");

		return $query->row['total'];
	}
}
