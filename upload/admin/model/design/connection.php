<?php
class ModelDesignConnection extends Model {

	public function addConnection($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "connection SET name = '" . $this->db->escape($data['name']) . "', backend = '" . (int)$data['backend'] . "', frontend = '" . (int)$data['frontend'] . "'");

		$connection_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_connection_id'] = $connection_id;

		if (isset($data['connection_route'])) {
			foreach ($data['connection_route'] as $connection_route) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "connection_route SET connection_id = '" . (int)$connection_id . "', icon = '" . $this->db->escape($connection_route['icon']) . "', title = '" . $this->db->escape($connection_route['title']) . "', route = '" . $this->db->escape($connection_route['route']) . "'");
			}
		}

		$this->cache->delete('connection');
	}

	public function editConnection($connection_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "connection SET name = '" . $this->db->escape($data['name']) . "', backend = '" . (int)$data['backend'] . "', frontend = '" . (int)$data['frontend'] . "' WHERE connection_id = '" . (int)$connection_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "connection_route WHERE connection_id = '" . (int)$connection_id . "'");

		if (isset($data['connection_route'])) {
			foreach ($data['connection_route'] as $connection_route) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "connection_route SET connection_id = '" . (int)$connection_id . "', icon = '" . $this->db->escape($connection_route['icon']) . "', title = '" . $this->db->escape($connection_route['title']) . "', route = '" . $this->db->escape($connection_route['route']) . "'");
			}
		}

		$this->cache->delete('connection');
	}

	public function deleteConnection($connection_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "connection WHERE connection_id = '" . (int)$connection_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "connection_route WHERE connection_id = '" . (int)$connection_id . "'");

		$this->cache->delete('connection');
	}

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
		$connection_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "connection");

		foreach ($query->rows as $result) {
			$connection_data[] = array('connection_id' => $result['connection_id']);
		}

		return $connection_data;
	}

	public function getConnectionName($connection_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "connection WHERE connection_id = '" . (int)$connection_id . "'");

		return $query->row['name'];
	}

	public function getConnectionRoutes($connection_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "connection_route WHERE connection_id = '" . (int)$connection_id . "'");

		return $query->rows;
	}

	public function getConnectionIcon($connection_id) {
		$query = $this->db->query("SELECT icon FROM " . DB_PREFIX . "connection_route WHERE connection_id = '" . (int)$connection_id . "'");

		return $query->row['icon'];
	}

	public function getTotalConnections() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "connection");

		return $query->row['total'];
	}

	public function getTotalAdminConnections() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "connection WHERE backend = '1'");

		return $query->row['total'];
	}

	public function getTotalCatalogConnections() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "connection WHERE frontend = '1'");

		return $query->row['total'];
	}
}
