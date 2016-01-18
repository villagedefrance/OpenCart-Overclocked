<?php
class ModelDesignPalette extends Model {

	public function getPalette($palette_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "palette WHERE palette_id = '" . (int)$palette_id . "'");

		return $query->row;
	}

	public function getPalettes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "palette";

		$sort_data = array('name');

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

	public function getPaletteIds($data = array()) {
		$palette_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette");

		foreach ($query->rows as $result) {
			$palette_data[] = array('palette_id' => $result['palette_id']);
		}

		return $palette_data;
	}

	public function getPaletteColors($palette_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette_color WHERE palette_id = '" . (int)$palette_id . "' ORDER BY title ASC");

		return $query->rows;
	}

	public function getTotalPalettes() {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "palette";

		$cache_id = 'palettes.total';

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