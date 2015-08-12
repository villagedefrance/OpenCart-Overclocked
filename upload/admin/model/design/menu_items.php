<?php
class ModelDesignMenuItems extends Model {

	public function addMenuItem($menu_id, $data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item SET menu_id = '" . (int)$menu_id . "', parent_id = '" . (int)$data['parent_id'] . "', menu_item_link = '" . $this->db->escape(html_entity_decode($data['link'], ENT_QUOTES, 'UTF-8')) . "', external_link = '" . (int)$data['external_link'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '1'");

		$menu_item_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_menu_item_id'] = $menu_item_id;

		foreach ($data['menu_item_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_description SET menu_item_id = '" . (int)$menu_item_id . "', language_id = '" . (int)$language_id . "', menu_id = '" . (int)$menu_id . "', menu_item_name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		} 

		$this->cache->delete('menu_items');
	} 

	public function editMenuItem($menu_item_id, $menu_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "menu_item SET menu_id = '" . (int)$menu_id . "', parent_id = '" . (int)$data['parent_id'] . "', menu_item_link = '" . $this->db->escape(html_entity_decode($data['link'], ENT_QUOTES, 'UTF-8')) . "', external_link = '" . (int)$data['external_link'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE menu_item_id = '" . (int)$menu_item_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_description WHERE menu_item_id = '" . (int)$menu_item_id . "'");

		foreach ($data['menu_item_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_description SET menu_item_id = '" . (int)$menu_item_id . "', language_id = '" . (int)$language_id . "', menu_id = '" . (int)$menu_id . "', menu_item_name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->cache->delete('menu_items');
	}

	public function deleteMenuItem($menu_item_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item WHERE menu_item_id = '" . (int)$menu_item_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_description WHERE menu_item_id = '" . (int)$menu_item_id . "'");

		$query = $this->db->query("SELECT menu_item_id FROM " . DB_PREFIX . "menu_item WHERE parent_id = '" . (int)$menu_item_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteMenuItem($result['menu_item_id']);
		} 

		$this->cache->delete('menu_items');
	}

	public function getMenuItem($menu_item_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "menu_item WHERE menu_item_id = '" . (int)$menu_item_id . "'");

		return $query->row;
	}

	public function getMenuItems($parent_id = 0, $menu_id, $data) {
		$menu_item_data = array();

		$sql = "SELECT *, mid.menu_item_name AS name FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mi.parent_id = '" . (int)$parent_id . "'AND mi.menu_id='" . (int)$menu_id . "' AND mid.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND mid.menu_item_name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY mi.menu_item_id";

		$sort_data = array(
			'name',
			'mi.sort_order',
			'mi.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY mi.sort_order, mid.menu_item_name";
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
				$data['limit'] = 200;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$menu_item_data[] = array(
				'menu_item_id'	=> $result['menu_item_id'],
				'name'        	=> $this->getPath($result['menu_item_id'], $this->config->get('config_language_id')),
				'menu_id'  	  	=> $result['menu_id'],
				'external'  	  	=> $result['external_link'],
				'sort_order'  	=> $result['sort_order'],
				'status'  	  	=> $result['status']
			);

			$menu_item_data = array_merge($menu_item_data, $this->getMenuItems($result['menu_item_id'], $menu_id, $data));
		}

		return $menu_item_data;
	}

	public function getPath($menu_item_id, $language) {
		$query = $this->db->query("SELECT menu_item_name, parent_id FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mi.menu_item_id = '" . (int)$menu_item_id . "' AND mid.language_id = '" . (int)$language . "' ORDER BY mi.sort_order, mid.menu_item_name ASC");

		if ($query->row['parent_id']) {
			return $this->getPath($query->row['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $query->row['menu_item_name'];
		} else {
			return $query->row['menu_item_name'];
		}
	}

	public function getMenuItemDescription($menu_item_id) {
		$menu_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_description WHERE menu_item_id = '" . (int)$menu_item_id . "'");

		foreach ($query->rows as $result) {
			$menu_description_data[$result['language_id']] = array(
				'name'        			=> $result['menu_item_name'],
				'meta_description'	=> $result['meta_description'],
				'meta_keyword'		=> $result['meta_keyword']
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
					'menu_item_id'	=> $result['menu_item_id'],
					'name'			=> $result['menu_item_name']
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
?>