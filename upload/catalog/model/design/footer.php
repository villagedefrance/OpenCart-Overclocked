<?php
class ModelDesignFooter extends Model {

	public function getFooter($footer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "footer WHERE footer_id = '" . (int)$footer_id . "' AND status = '1'");

		return $query->row;
	}

	public function getFooters($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "footer WHERE status = '1'";

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

	public function getFooterList($data = array()) {
		$footer_data = $this->cache->get('footer.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));

		if (!$footer_data) {
			$footer_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer ORDER BY footer_id ASC");

			foreach ($query->rows as $result) {
				$footer_data[] = array(
					'footer_id'	=> $result['footer_id'],
					'name'		=> $result['name'],
					'position'		=> $result['position'],
					'status'		=> $result['status']
				);
			}

			$this->cache->set('footer.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $footer_data);
		}

		return $footer_data;
	}

	public function getFooterRouteList($data = array()) {
		$route_list = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_route ORDER BY sort_order ASC");

		foreach ($query->rows as $result) {
			$route_list[] = array(
				'footer_id'	=> $result['footer_id'],
				'title'			=> $result['title'],
				'route'		=> $result['route']
			);
		}

		return $route_list;
	}

	public function getFooterRoutes($footer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_route WHERE footer_id = '" . (int)$footer_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getFooterName($footer_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "footer WHERE footer_id = '" . (int)$footer_id . "'");

		return $query->row['name'];
	}

	public function getTotalFooters() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "footer WHERE status = '1'");

		return $query->row['total'];
	}
}
?>