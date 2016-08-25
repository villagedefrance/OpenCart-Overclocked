<?php
class ModelDesignMenu extends Model {

	public function getMenu($menu_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "menu m LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (m.menu_id = mid.menu_id) LEFT JOIN " . DB_PREFIX . "menu_to_store m2s ON (m.menu_id = m2s.menu_id) WHERE m.menu_id = '" . (int)$menu_id . "' AND mid.language_id = '" . (int)$this->config->get('config_language_id') . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND m.status = '1'");

		return $query->row;
	}

	public function getMenuTitle($menu_id) {
		$query = $this->db->query("SELECT title FROM " . DB_PREFIX . "menu WHERE menu_id='" . (int)$menu_id . "' AND status = '1'");

		if ($query->num_rows) {
			return $query->row['title'];
		} else {
			return false;
		}
	}

	public function getMenuItem($menu_item_id, $menu_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mid.menu_item_id = '" . (int)$menu_item_id . "' AND mid.language_id = '" . (int)$this->config->get('config_language_id') . "' AND mi.menu_id='" . (int)$menu_id . "' AND mi.status = '1'");

		return $query->row;
	}

	public function getMenuItems($parent_id = 0, $menu_id) {
		if ($parent_id == 0) {
			$menu_item_data = $this->cache->get('menu_items.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$parent_id);

			if (!$menu_item_data) {
				$menu_item_data = array();

				$query = $this->db->query("SELECT *, mid.menu_item_name AS name FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) LEFT JOIN " . DB_PREFIX . "menu_to_store m2s ON (mi.menu_id = m2s.menu_id) WHERE mi.parent_id = '" . (int)$parent_id . "' AND mi.menu_id='" . (int)$menu_id . "' AND mid.language_id = '" . (int)$this->config->get('config_language_id') . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND mi.status = '1' ORDER BY mi.sort_order, mid.menu_item_name ASC");

				foreach ($query->rows as $result) {
					$menu_item_data[$result['menu_item_id']] = $this->getMenuItem($result['menu_item_id'], (int)$menu_id);
				}

				$this->cache->set('menu_items.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $parent_id, $menu_item_data);
			}

			return $menu_item_data;

		} else {
			$query = $this->db->query("SELECT *, mid.menu_item_name AS name FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) LEFT JOIN " . DB_PREFIX . "menu_to_store m2s ON (mi.menu_id = m2s.menu_id) WHERE mi.parent_id = '" . (int)$parent_id . "' AND mi.menu_id='" . (int)$menu_id . "' AND mid.language_id = '" . (int)$this->config->get('config_language_id') . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND mi.status = '1' ORDER BY mi.sort_order, mid.menu_item_name ASC");

			return $query->rows;
		}
	}

	public function getTotalMenuItems($menu_id) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu_item WHERE menu_id = '" . (int)$menu_id . "' AND status = '1'";

		$cache_id = 'menu_items.total';

		$total = $this->cache->get($cache_id);

		if (!$total || $total === null) {
			$query = $this->db->query($sql);

			$total = $query->row['total'];

			$this->cache->set($cache_id, $total);
		}

		return $total;
	}

	public function getTotalMenuItemsByParentId($menu_id, $parent_id) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu_item WHERE menu_id = '" . (int)$menu_id . "' AND parent_id = '" . (int)$parent_id . "' AND status = '1'";

		$cache_id = 'menu_items.parents.total';

		$total = $this->cache->get($cache_id);

		if (!$total || $total === null) {
			$query = $this->db->query($sql);

			$total = $query->row['total'];

			$this->cache->set($cache_id, $total);
		}

		return $total;
	}
}
