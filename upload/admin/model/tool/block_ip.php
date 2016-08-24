<?php
class ModelToolBlockIp extends Model {

	public function addBlockIp($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "block_ip SET from_ip = '" . $this->db->escape($data['from_ip']) . "', to_ip = '" . $this->db->escape($data['to_ip']) . "'");

		$block_ip_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_block_ip_id'] = $block_ip_id;

		$this->cache->delete('block_ip');
	}

	public function editBlockIp($block_ip_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "block_ip SET from_ip = '" . $this->db->escape($data['from_ip']) . "', to_ip = '" . $this->db->escape($data['to_ip']) . "' WHERE block_ip_id = '" . (int)$block_ip_id . "'");

		$this->cache->delete('block_ip');
	}

	public function deleteBlockIp($block_ip_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "block_ip WHERE block_ip_id = '" . (int)$block_ip_id . "'");

		$this->cache->delete('block_ip');
	}

	public function getBlockIp($block_ip_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "block_ip WHERE block_ip_id = '" . (int)$block_ip_id . "'");

		return $query->row;
	}

	public function getBlockIps($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "block_ip";

			$sort_data = array(
				'from_ip',
				'to_ip'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'] ;
			} else {
				$sql .= " ORDER BY from_ip";
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
			$block_ip_data = $this->cache->get('block_ip');

			if (!$block_ip_data) {
				$block_ip_data = array();

				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "block_ip ORDER BY from_ip ASC");

				$block_ip_data = $query->rows;

				$this->cache->set('ban_ip', $block_ip_data);
			}

			return $block_ip_data;
		}
	}

	public function getTotalBlockIps($data = array()) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "block_ip");

		return $query->row['total'];
	}
}
