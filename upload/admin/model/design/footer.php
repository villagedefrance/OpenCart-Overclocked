<?php
class ModelDesignFooter extends Model {

	public function addFooter($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "footer SET position = '" . (int)$data['position'] . "', status = '1'");

		$footer_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_footer_id'] = $footer_id;

		foreach ($data['footer_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "footer_description SET footer_id = '" . (int)$footer_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['footer_store'])) {
			foreach ($data['footer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "footer_to_store SET footer_id = '" . (int)$footer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['footer_route'])) {
			foreach ($data['footer_route'] as $footer_route) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "footer_route SET footer_id = '" . (int)$footer_id . "', route = '" . $this->db->escape($footer_route['route']) . "', external_link = '" . (int)$footer_route['external_link'] . "', sort_order = '" . $this->db->escape($footer_route['sort_order']) . "'");

				$footer_route_id = $this->db->getLastId();

				foreach ($footer_route['footer_route_description'] as $language_id => $footer_route_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "footer_route_description SET footer_route_id = '" . (int)$footer_route_id . "', language_id = '" . (int)$language_id . "', footer_id = '" . (int)$footer_id . "', title = '" .  $this->db->escape($footer_route_description['title']) . "'");
				}
			}
		}

		$this->cache->delete('footer.total');
		$this->cache->delete('footer');
		$this->cache->delete('store');
	}

	public function editFooter($footer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "footer SET position = '" . (int)$data['position'] . "', status = '" . (int)$data['status'] . "' WHERE footer_id = '" . (int)$footer_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "footer_description WHERE footer_id = '" . (int)$footer_id . "'");

		foreach ($data['footer_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "footer_description SET footer_id = '" . (int)$footer_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "footer_to_store WHERE footer_id = '" . (int)$footer_id . "'");

		if (isset($data['footer_store'])) {
			foreach ($data['footer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "footer_to_store SET footer_id = '" . (int)$footer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "footer_route WHERE footer_id = '" . (int)$footer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "footer_route_description WHERE footer_id = '" . (int)$footer_id . "'");

		if (isset($data['footer_route'])) {
			foreach ($data['footer_route'] as $footer_route) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "footer_route SET footer_id = '" . (int)$footer_id . "', route = '" .  $this->db->escape($footer_route['route']) . "', external_link = '" . (int)$footer_route['external_link'] . "', sort_order = '" .  $this->db->escape($footer_route['sort_order']) . "'");

				$footer_route_id = $this->db->getLastId();

				foreach ($footer_route['footer_route_description'] as $language_id => $footer_route_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "footer_route_description SET footer_route_id = '" . (int)$footer_route_id . "', language_id = '" . (int)$language_id . "', footer_id = '" . (int)$footer_id . "', title = '" .  $this->db->escape($footer_route_description['title']) . "'");
				}
			}
		}

		$this->cache->delete('footer');
		$this->cache->delete('store');
	}

	public function deleteFooter($footer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "footer WHERE footer_id = '" . (int)$footer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "footer_description WHERE footer_id = '" . (int)$footer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "footer_route WHERE footer_id = '" . (int)$footer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "footer_route_description WHERE footer_id = '" . (int)$footer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "footer_to_store WHERE footer_id = '" . (int)$footer_id . "'");

		$this->cache->delete('footer.total');
		$this->cache->delete('footer');
		$this->cache->delete('store');
	}

	public function getFooter($footer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "footer WHERE footer_id = '" . (int)$footer_id . "'");

		return $query->row;
	}

	public function getFooters($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "footer f LEFT JOIN " . DB_PREFIX . "footer_description fd ON (f.footer_id = fd.footer_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'fd.name',
				'f.position',
				'f.status'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY fd.name";
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
			$footer_data = $this->cache->get('footer.' . (int)$this->config->get('config_language_id'));

			if (!$footer_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer f LEFT JOIN " . DB_PREFIX . "footer_description fd ON (f.footer_id = fd.footer_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY fd.name");

				$footer_data = $query->rows;

				$this->cache->set('footer.' . (int)$this->config->get('config_language_id'), $footer_data);
			}

			return $footer_data;
		}
	}

	public function getFooterDescriptions($footer_id) {
		$footer_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_description WHERE footer_id = '" . (int)$footer_id . "'");

		foreach ($query->rows as $result) {
			$footer_description_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $footer_description_data;
	}

	public function getFooterName($footer_id) {
		$query = $this->db->query("SELECT DISTINCT fd.name AS name FROM " . DB_PREFIX . "footer_description fd LEFT JOIN " . DB_PREFIX . "footer f ON (fd.footer_id = f.footer_id) WHERE f.footer_id = '" . (int)$footer_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY f.footer_id");

		return $query->row['name'];
	}

	public function getFooterRoutes($footer_id) {
		$footer_route_data = array();

		$footer_route_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_route WHERE footer_id = '" . (int)$footer_id . "' ORDER BY sort_order ASC");

		foreach ($footer_route_query->rows as $footer_route) {
			$footer_route_description_data = array();

			$footer_route_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_route_description WHERE footer_route_id = '" . (int)$footer_route['footer_route_id'] . "' AND footer_id = '" . (int)$footer_id . "'");

			foreach ($footer_route_description_query->rows as $footer_route_description) {
				$footer_route_description_data[$footer_route_description['language_id']] = array('title' => $footer_route_description['title']);
			}

			$footer_route_data[] = array(
				'footer_route_description' => $footer_route_description_data,
				'route'                    => $footer_route['route'],
				'external_link'            => $footer_route['external_link'],
				'sort_order'               => $footer_route['sort_order']
			);
		}

		return $footer_route_data;
	}

	public function getFooterStores($footer_id) {
		$footer_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_to_store WHERE footer_id = '" . (int)$footer_id . "'");

		foreach ($query->rows as $result) {
			$footer_store_data[] = $result['store_id'];
		}

		return $footer_store_data;
	}

	public function getFooterIds($data = array()) {
		$footer_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer");

		foreach ($query->rows as $result) {
			$footer_data[] = array('footer_id' => $result['footer_id']);
		}

		return $footer_data;
	}

	public function getTotalFooters() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "footer");

		return $query->row['total'];
	}
}
