<?php
class ModelDesignPalette extends Model {

	public function addPalette($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "palette SET name = '" . $this->db->escape($data['name']) . "'");

		$palette_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_palette_id'] = $palette_id;

		if (isset($data['palette_color'])) {
			foreach ($data['palette_color'] as $palette_color) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "palette_color SET palette_id = '" . (int)$palette_id . "', title = '" . $this->db->escape($palette_color['title']) . "', color = '" . $this->db->escape($palette_color['color']) . "'");
			}
		}
	}

	public function editPalette($palette_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "palette SET name = '" . $this->db->escape($data['name']) . "' WHERE palette_id = '" . (int)$palette_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "palette_color WHERE palette_id = '" . (int)$palette_id . "'");

		if (isset($data['palette_color'])) {
			foreach ($data['palette_color'] as $palette_color) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "palette_color SET palette_id = '" . (int)$palette_id . "', title = '" . $this->db->escape($palette_color['title']) . "', color = '" . $this->db->escape($palette_color['color']) . "'");
			}
		}
	}

	public function deletePalette($palette_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "palette WHERE palette_id = '" . (int)$palette_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "palette_color WHERE palette_id = '" . (int)$palette_id . "'");
	}

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

	public function getPaletteName($palette_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "palette WHERE palette_id = '" . (int)$palette_id . "'");

		return $query->row['name'];
	}

	public function getTotalPalettes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "palette");

		return $query->row['total'];
	}
}
?>