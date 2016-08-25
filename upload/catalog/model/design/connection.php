<?php
class ModelDesignConnection extends Model {

	public function getConnection($connection_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "connection WHERE connection_id = '" . (int)$connection_id . "'");

		return $query->row;
	}

	public function getConnections($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "connection";

		$sort_data = array(
			'name',
			'backend',
			'frontend'
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

	public function getConnectionIds($data = array()) {
		$connection_data = $this->cache->get('connection.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));

		if (!$connection_data) {
			$connection_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "connection");

			foreach ($query->rows as $result) {
				$connection_data[] = array('connection_id' => $result['connection_id']);
			}

			$this->cache->set('connection.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $connection_data);
		}

		return $connection_data;
	}

	public function getConnectionRoutes($connection_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "connection_route WHERE connection_id = '" . (int)$connection_id . "'");

		return $query->rows;
	}

	public function getConnectionName($connection_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "connection WHERE connection_id = '" . (int)$connection_id . "'");

		return $query->row['name'];
	}

	public function getTotalConnections() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "connection");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalCatalogConnections() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "connection WHERE frontend = '1'");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
}
