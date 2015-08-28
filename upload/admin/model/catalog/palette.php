<?php
class ModelCatalogPalette extends Model {

	public function addPalette($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "palette SET name = '" . $this->db->escape($data['name']) . "'");

		$palette_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_palette_id'] = $palette_id;

		if (isset($data['palette_color'])) {
			foreach ($data['palette_color'] as $palette_color) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "palette_color SET palette_id = '" . (int)$palette_id . "', color = '" . $this->db->escape($palette_color['color']) . "'");

				$palette_color_id = $this->db->getLastId();

				foreach ($palette_color['palette_color_description'] as $language_id => $palette_color_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "palette_color_description SET palette_color_id = '" . (int)$palette_color_id . "', language_id = '" . (int)$language_id . "', palette_id = '" . (int)$palette_id . "', title = '" .  $this->db->escape($palette_color_description['title']) . "'");
				}
			}
		}
	}

	public function editPalette($palette_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "palette SET name = '" . $this->db->escape($data['name']) . "' WHERE palette_id = '" . (int)$palette_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "palette_color WHERE palette_id = '" . (int)$palette_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "palette_color_description WHERE palette_id = '" . (int)$palette_id . "'");

		if (isset($data['palette_color'])) {
			foreach ($data['palette_color'] as $palette_color) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "palette_color SET palette_id = '" . (int)$palette_id . "', color = '" . $this->db->escape($palette_color['color']) . "'");

				$palette_color_id = $this->db->getLastId();

				foreach ($palette_color['palette_color_description'] as $language_id => $palette_color_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "palette_color_description SET palette_color_id = '" . (int)$palette_color_id . "', language_id = '" . (int)$language_id . "', palette_id = '" . (int)$palette_id . "', title = '" .  $this->db->escape($palette_color_description['title']) . "'");
				}
			}
		}
	}

	public function deletePalette($palette_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "palette WHERE palette_id = '" . (int)$palette_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "palette_color WHERE palette_id = '" . (int)$palette_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "palette_color_description WHERE palette_id = '" . (int)$palette_id . "'");
	}

	public function getPalette($palette_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "palette p LEFT JOIN " . DB_PREFIX . "palette_color pc ON (p.palette_id = pc.palette_id) LEFT JOIN " . DB_PREFIX . "palette_color_description pcd ON (p.palette_id = pcd.palette_id) WHERE p.palette_id = '" . (int)$palette_id . "' AND pcd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

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

	public function getPaletteDescriptions($palette_id) {
		$palette_description_data = array();

		$palette_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette_color WHERE palette_id = '" . (int)$palette_id . "' ORDER BY palette_id ASC");

		foreach ($palette_description_query->rows as $palette_description) {
			$palette_color_description_data = array();

			$palette_color_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette_color_description WHERE palette_color_id = '" . (int)$palette_description['palette_color_id'] . "' AND palette_id = '" . (int)$palette_id . "'");

			foreach ($palette_color_description_query->rows as $palette_color_description) {
				$palette_color_description_data[$palette_color_description['language_id']] = array('title' => $palette_color_description['title']);
			}

			$palette_description_data[] = array(
				'palette_color_description'	=> $palette_color_description_data,
				'palette_color_id' 		=> $palette_description['palette_color_id'],
				'color'					=> $palette_description['color']
			);
		}

		return $palette_description_data;
	}

	public function getPaletteIds($data = array()) {
		$palette_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette");

		foreach ($query->rows as $result) {
			$palette_data[] = array('palette_id' => $result['palette_id']);
		}

		return $palette_data;
	}

	public function getPaletteColors($data = array()) {
		$colors_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette_color pc LEFT JOIN " . DB_PREFIX . "palette_color_description pcd ON (pc.palette_id = pcd.palette_id) WHERE pcd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY pcd.palette_color_id ORDER BY pc.palette_id, pcd.title ASC");

		foreach ($query->rows as $result) {
			$colors_data[] = array(
				'palette_color_id'	=> $result['palette_color_id'],
				'color'				=> $result['color'],
				'title'					=> $result['title']
			);
		}

		return $colors_data;
	}

	public function getPaletteColorsByPaletteId($palette_id) {
		$colors_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette p LEFT JOIN " . DB_PREFIX . "palette_color pc ON (p.palette_id = pc.palette_id) LEFT JOIN " . DB_PREFIX . "palette_color_description pcd ON (p.palette_id = pcd.palette_id) WHERE pcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pcd.palette_id = '" . (int)$palette_id . "' GROUP BY pcd.palette_color_id ORDER BY p.palette_id, pcd.title ASC");

		foreach ($query->rows as $result) {
			$colors_data[] = array(
				'palette_color_id'	=> $result['palette_color_id'],
				'color'				=> $result['color'],
				'title'					=> $result['title']
			);
		}

		return $colors_data;
	}

	public function getPaletteColorsByColorId($palette_color_id) {
		$palette_colors_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette_color pc LEFT JOIN " . DB_PREFIX . "palette_color_description pcd ON (pc.palette_color_id = pcd.palette_color_id) WHERE pcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pc.palette_color_id = '" . (int)$palette_color_id . "' GROUP BY pc.palette_color_id ORDER BY pcd.title ASC");

		foreach ($query->rows as $result) {
			$palette_colors_data[] = array(
				'palette_color_id'	=> $result['palette_color_id'],
				'color'				=> $result['color'],
				'title'					=> $result['title']
			);
		}

		return $palette_colors_data;
	}

	public function getPaletteColor($palette_color_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "palette_color WHERE palette_color_id = '" . (int)$palette_color_id . "'");

		return $query->row;
	}

	public function getPaletteName($palette_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "palette WHERE palette_id = '" . (int)$palette_id . "'");

		return $query->row['name'];
	}

	public function getTotalPalettes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "palette");

		return $query->row['total'];
	}

	public function getTotalColorsByPaletteId($palette_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "palette_color WHERE palette_id = '" . (int)$palette_id . "'");

		return $query->row['total'];
	}
}
?>