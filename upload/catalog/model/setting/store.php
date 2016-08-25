<?php
class ModelSettingStore extends Model {

	public function getStores($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "store";

			$sort_data = array(
				'name',
				'url'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY url";
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
			$store_data = $this->cache->get('store');

			if (!$store_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store ORDER BY url");

				$store_data = $query->rows;

				$this->cache->set('store', $store_data);
			}

			return $store_data;
		}
	}

	public function getTotalStores() {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "store";

		$cache_id = 'stores.total';

		$total = $this->cache->get($cache_id);

		if (!$total || $total === null) {
			$query = $this->db->query($sql);

			$total = $query->row['total'];

			$this->cache->set($cache_id, $total);
		}

		return $total;
	}
}
