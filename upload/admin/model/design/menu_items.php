<?php
class ModelDesignMenuItems extends Model {

	public function addMenuItem($menu_id, $data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item SET menu_id = '" . (int)$menu_id . "', parent_id = '" . (int)$data['parent_id'] . "', menu_item_link = '" . $this->db->escape($data['link']) . "', external_link = '" . (int)$data['external_link'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '1'");

		$menu_item_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_menu_item_id'] = $menu_item_id;

		foreach ($data['menu_item_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_description SET menu_item_id = '" . (int)$menu_item_id . "', language_id = '" . (int)$language_id . "', menu_id = '" . (int)$menu_id . "', menu_item_name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_path WHERE menu_item_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_path SET menu_item_id = '" . (int)$menu_item_id . "', path_id = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_path SET menu_item_id = '" . (int)$menu_item_id . "', path_id = '" . (int)$menu_item_id . "', `level` = '" . (int)$level . "'");

		$this->cache->delete('menu_items');
		$this->cache->delete('menu_items.total');
		$this->cache->delete('menu_items.parents.total');
	}

	public function editMenuItem($menu_item_id, $menu_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "menu_item SET menu_id = '" . (int)$menu_id . "', parent_id = '" . (int)$data['parent_id'] . "', menu_item_link = '" . $this->db->escape($data['link']) . "', external_link = '" . (int)$data['external_link'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE menu_item_id = '" . (int)$menu_item_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_description WHERE menu_item_id = '" . (int)$menu_item_id . "'");

		foreach ($data['menu_item_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_description SET menu_item_id = '" . (int)$menu_item_id . "', language_id = '" . (int)$language_id . "', menu_id = '" . (int)$menu_id . "', menu_item_name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_path WHERE path_id = '" . (int)$menu_item_id . "' ORDER BY `level` ASC");

		if ($query->rows) {
			foreach ($query->rows as $menu_item_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_path WHERE menu_item_id = '" . (int)$menu_item_path['menu_item_id'] . "' AND `level` < '" . (int)$menu_item_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_path WHERE menu_item_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_path WHERE menu_item_id = '" . (int)$menu_item_path['menu_item_id'] . "' ORDER BY `level` ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO " . DB_PREFIX . "menu_item_path SET menu_item_id = '" . (int)$menu_item_path['menu_item_id'] . "', path_id = '" . (int)$path_id . "', `level` = '" . (int)$level . "'");

					$level++;
				}
			}

		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_path WHERE menu_item_id = '" . (int)$menu_item_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_path WHERE menu_item_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_path SET menu_item_id = '" . (int)$menu_item_id . "', path_id = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO " . DB_PREFIX . "menu_item_path SET menu_item_id = '" . (int)$menu_item_id . "', path_id = '" . (int)$menu_item_id . "', `level` = '" . (int)$level . "'");
		}

		$this->cache->delete('menu_items');
	}

	public function editMenuItemStatus($menu_item_id, $status) {
        $this->db->query("UPDATE " . DB_PREFIX . "menu_item SET status = '" . (int)$status . "' WHERE menu_item_id = '" . (int)$menu_item_id . "'");

        $this->cache->delete('menu_items');
		$this->cache->delete('menu_items.total');
		$this->cache->delete('menu_items.parents.total');
    }

	public function deleteMenuItem($menu_item_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_path WHERE menu_item_id = '" . (int)$menu_item_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_path WHERE path_id = '" . (int)$menu_item_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteMenuItem($result['menu_item_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item WHERE menu_item_id = '" . (int)$menu_item_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_description WHERE menu_item_id = '" . (int)$menu_item_id . "'");

		$this->cache->delete('menu_items');
		$this->cache->delete('menu_items.total');
		$this->cache->delete('menu_items.parents.total');
	}

	// Function to repair any erroneous menu items that are not in the menu item path table.
	public function repairMenuItems($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $menu_item) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_path WHERE menu_item_id = '" . (int)$menu_item['menu_item_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_path WHERE menu_item_id = '" . (int)$parent_id . "' ORDER BY `level` ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_path SET menu_item_id = '" . (int)$menu_item['menu_item_id'] . "', path_id = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO " . DB_PREFIX . "menu_item_path SET menu_item_id = '" . (int)$menu_item['menu_item_id'] . "', path_id = '" . (int)$menu_item['menu_item_id'] . "', `level` = '" . (int)$level . "'");

			$this->repairMenuItems($menu_item['menu_item_id']);
		}

		$this->cache->delete('menu_items');
		$this->cache->delete('menu_items.total');
		$this->cache->delete('menu_items.parents.total');
	}

	public function getMenuItem($menu_item_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(mid1.menu_item_name ORDER BY level SEPARATOR ' &gt; ') FROM " . DB_PREFIX . "menu_item_path mip LEFT JOIN " . DB_PREFIX . "menu_item_description mid1 ON (mip.path_id = mid1.menu_item_id AND mip.menu_item_id != mip.path_id) WHERE mip.menu_item_id = mi.menu_item_id AND mid1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY mip.menu_item_id) AS `path`, mi.menu_item_link FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid2 ON (mi.menu_item_id = mid2.menu_item_id) WHERE mi.menu_item_id = '" . (int)$menu_item_id . "' AND mid2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getMenuItems($menu_id, $data) {
		$sql = "SELECT mip.menu_item_id AS menu_item_id, GROUP_CONCAT(mid1.menu_item_name ORDER BY mip.level SEPARATOR ' &gt; ') AS name, mi.parent_id, mi.external_link, mi.sort_order, mi.status FROM " . DB_PREFIX . "menu_item_path mip LEFT JOIN " . DB_PREFIX . "menu_item mi ON (mip.menu_item_id = mi.menu_item_id) LEFT JOIN " . DB_PREFIX . "menu_item_description mid1 ON (mip.path_id = mid1.menu_item_id) LEFT JOIN " . DB_PREFIX . "menu_item_description mid2 ON (mip.menu_item_id = mid2.menu_item_id) WHERE mid1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND mid2.language_id = '" . (int)$this->config->get('config_language_id') . "' AND mi.menu_id='" . (int)$menu_id . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND mid2.menu_item_name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY mip.menu_item_id";

		$sort_data = array(
			'name',
			'mi.sort_order',
			'mi.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name, mi.sort_order";
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

	public function getMenuItemDescription($menu_item_id) {
		$menu_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_description WHERE menu_item_id = '" . (int)$menu_item_id . "'");

		foreach ($query->rows as $result) {
			$menu_description_data[$result['language_id']] = array(
				'name'             => $result['menu_item_name'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $menu_description_data;
	}

	public function getParents($menu_id) {
		$parents_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mi.menu_id = '" . (int)$menu_id . "' AND mid.language_id = '" . $this->config->get('config_language_id') . "' AND mi.parent_id = '0' ORDER BY mi.sort_order, mid.menu_item_name ASC");

		if ($query->rows) {
			foreach ($query->rows as $result) {
				$parents_data[] = array(
					'menu_item_id' => $result['menu_item_id'],
					'name'         => $result['menu_item_name']
				);
			}

			return $parents_data;
		} else {
			return 0;
		}
	}

	public function getTotalMenuItems($menu_id, $data) {
      	$sql = "SELECT COUNT(DISTINCT mi.menu_item_id) AS total FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mi.menu_id = '" . (int)$menu_id . "'";

		$sql .= " AND mid.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND mid.menu_item_name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}
