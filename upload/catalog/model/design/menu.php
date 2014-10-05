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
}
?>