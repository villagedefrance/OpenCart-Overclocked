<?php
class ModelDesignMenu extends Model {

	public function addMenu($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "menu SET title = '" . $this->db->escape($data['title']) . "', status = '1'");

		$menu_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_menu_id'] = $menu_id;

		if (isset($data['menu_store'])) {
			foreach ($data['menu_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "menu_to_store SET menu_id = '" . (int)$menu_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->cache->delete('store');

		return $menu_id;
	}

	public function editMenu($menu_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "menu SET title = '" . $this->db->escape($data['title']) . "', status = '" . (int)$data['status'] . "' WHERE menu_id = '" . (int)$menu_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_to_store WHERE menu_id = '" . (int)$menu_id . "'");

		if (isset($data['menu_store'])) {
			foreach ($data['menu_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "menu_to_store SET menu_id = '" . (int)$menu_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->cache->delete('store');
	}

	public function deleteMenu($menu_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu WHERE menu_id = '" . (int)$menu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item WHERE menu_id = '" . (int)$menu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_description WHERE menu_id = '" . (int)$menu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_to_store WHERE menu_id = '" . (int)$menu_id . "'");

		$this->cache->delete('store');
	}

	public function getMenu($menu_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "menu WHERE menu_id = '" . (int)$menu_id . "'");

		return $query->row;
	}

	public function getMenuTitle($menu_id) {
		$query = $this->db->query("SELECT title FROM " . DB_PREFIX . "menu WHERE menu_id = '" . (int)$menu_id . "'");

		return $query->row['title'];
	}

	public function getMenus($data = array()) {
		$menu_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu ORDER BY menu_id ASC");

		foreach ($query->rows as $result) {
			$menu_data[] = array(
				'menu_id' => $result['menu_id'],
				'title'   => $result['title'],
				'status'  => $result['status']
			);
		}

		if ($menu_data) {
			return $menu_data;
		} else {
			return false;
		}
	}

	public function getMenuStores($menu_id) {
		$menu_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_to_store WHERE menu_id = '" . (int)$menu_id . "'");

		foreach ($query->rows as $result) {
			$menu_store_data[] = $result['store_id'];
		}

		return $menu_store_data;
	}

	public function getTotalMenus() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu");

		return $query->row['total'];
	}
}
