<?php
class ModelDesignFooter extends Model {

	public function addFooter($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "footer SET name = '" . $this->db->escape($data['name']) . "', position = '" . (int)$data['position'] . "', status = '1'");

		$footer_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_footer_id'] = $footer_id;

		if (isset($data['footer_route'])) {
			foreach ($data['footer_route'] as $footer_route) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "footer_route SET footer_id = '" . (int)$footer_id . "', title = '" . $this->db->escape($footer_route['title']) . "', route = '" . $this->db->escape($footer_route['route']) . "', sort_order = '" . (int)$footer_route['sort_order'] . "'");
			}
		}
	}

	public function editFooter($footer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "footer SET name = '" . $this->db->escape($data['name']) . "', position = '" . (int)$data['position'] . "', status = '" . (int)$data['status'] . "' WHERE footer_id = '" . (int)$footer_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "footer_route WHERE footer_id = '" . (int)$footer_id . "'");

		if (isset($data['footer_route'])) {
			foreach ($data['footer_route'] as $footer_route) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "footer_route SET footer_id = '" . (int)$footer_id . "', title = '" . $this->db->escape($footer_route['title']) . "', route = '" . $this->db->escape($footer_route['route']) . "', sort_order = '" . (int)$footer_route['sort_order'] . "'");
			}
		}
	}

	public function deleteFooter($footer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "footer WHERE footer_id = '" . (int)$footer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "footer_route WHERE footer_id = '" . (int)$footer_id . "'");
	}

	public function getFooter($footer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "footer WHERE footer_id = '" . (int)$footer_id . "'");

		return $query->row;
	}

	public function getFooters($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "footer";

		$sort_data = array(
			'name',
			'position',
			'status'
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

	public function getFooterIds($data = array()) {
		$footer_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer");

		foreach ($query->rows as $result) {
			$footer_data[] = array('footer_id' => $result['footer_id']);
		}

		return $footer_data;
	}

	public function getFooterRoutes($footer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_route WHERE footer_id = '" . (int)$footer_id . "'");

		return $query->rows;
	}

	public function getFooterName($footer_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "footer WHERE footer_id = '" . (int)$footer_id . "'");

		return $query->row['name'];
	}

	public function getTotalFooters() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "footer");

		return $query->row['total'];
	}
}
?>