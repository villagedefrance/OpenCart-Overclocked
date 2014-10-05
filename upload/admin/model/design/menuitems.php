<?php
class ModelDesignMenuItems extends Model {

	public function addMenuItem($menu_id, $data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item SET menu_id = '" . (int)$menu_id . "', parent_id = '" . (int)$data['parent_id'] . "', menu_item_link = '" . $data['link'] . "', external_link = '" . (int)$data['external_link'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '1'");

		$menu_item_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_menu_item_id'] = $menu_item_id;

		foreach ($data['menu_item_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_description SET menu_item_id = '" . (int)$menu_item_id . "', language_id = '" . (int)$language_id . "', menu_id = '" . (int)$menu_id . "', menu_item_name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		} 

		$this->cache->delete('menu_items');
	} 

	public function editMenuItem($menu_item_id, $menu_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "menu_item SET menu_id = '" . (int)$menu_id . "', parent_id = '" . (int)$data['parent_id'] . "', menu_item_link = '" . $data['link'] . "', external_link = '" . (int)$data['external_link'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE menu_item_id = '" . (int)$menu_item_id . "'");

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

	public function getMenuItems($parent_id = 0, $menu_id) {
		$menu_item_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mi.parent_id = '" . (int)$parent_id . "'AND mi.menu_id='" . (int)$menu_id . "' AND mid.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY mi.sort_order, mid.menu_item_name ASC");

		foreach ($query->rows as $result) {
			$menu_item_data[] = array(
				'menu_item_id'	=> $result['menu_item_id'],
				'name'        	=> $this->getPath($result['menu_item_id'], $this->config->get('config_language_id')),
				'menu_id'  	  	=> $result['menu_id'],
				'external'  	  	=> $result['external_link'],
				'sort_order'  	=> $result['sort_order'],
				'status'  	  	=> $result['status']
			);

			$menu_item_data = array_merge($menu_item_data, $this->getMenuItems($result['menu_item_id'], $menu_id));
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

	public function getTotalMenuItems($menu_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu_item WHERE menu_id='" . $menu_id . "'");

		return $query->row['total'];
	}
}
?>