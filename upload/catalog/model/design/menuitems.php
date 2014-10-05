<?php
class ModelDesignMenuItems extends Model {

	public function getMenuItem($menu_item_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "menu_item WHERE menu_item_id = '" . (int)$menu_item_id . "' AND status = '1'");

		return $query->row;
	}

	public function getMenuItems($parent_id = 0, $menu_id) {
		$menu_item_data = array();

		$query = $this->db->query("SELECT mi.*, mid.menu_item_name FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mi.parent_id = '" . (int)$parent_id . "' AND mi.menu_id='" . (int)$menu_id . "' AND mid.language_id = '" . (int)$this->config->get('config_language_id') . "' AND mi.status = '1' ORDER BY mi.sort_order, mid.menu_item_name ASC");

		foreach ($query->rows as $result) {
			$menu_item_data[] = array(
				'menu_item_id'		=> $result['menu_item_id'],
				'menu_name'		=> $result['menu_item_name'],
				'menu_link'			=> $result['menu_item_link'],
				'menu_external'	=> $result['external_link'],
				'children'  			=> $this->getMenuItems($result['menu_item_id'], $menu_id),
				'sort_order'  		=> $result['sort_order'],
				'status'  	  		=> $result['status']
			);
		}

		return $menu_item_data;
	}

	public function getTotalMenuItems($menu_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu_item WHERE menu_id='" . (int)$menu_id . "' AND status = '1'");

		return $query->row['total'];
	}
}
?>