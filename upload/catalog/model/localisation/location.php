<?php
class ModelLocalisationLocation extends Model {

	public function getLocation($location_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "location WHERE location_id = '" . (int)$location_id . "'");

		return $query->row;
	}

	public function getLocations($limit) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "location ORDER BY name DESC LIMIT " . (int)$limit);

		return $query->rows;
	}

	public function getTotalLocations() {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "location";

		$cache_id = 'locations.total';

		$total = $this->cache->get($cache_id);

		if (!$total || $total === null) {
			$query = $this->db->query($sql);

			$total = $query->row['total'];

			$this->cache->set($cache_id, $total);
		}

		return $total;
	}
}
?>