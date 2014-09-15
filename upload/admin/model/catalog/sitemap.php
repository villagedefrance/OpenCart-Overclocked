<?php
class ModelCatalogSitemap extends Model {

	public function getAllStores($data = array()) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store");

		return $query->rows;
	}

	public function getAllCategories($parent_id = 0, $store_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$store_id . "' AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->rows;
	}

	public function getAllProducts($store_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$store_id . "' AND p.status = '1' ORDER BY LCASE(pd.name)");

		return $query->rows;
	}

	public function getAllManufacturers($store_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '" . (int)$store_id . "' ORDER BY m.sort_order, LCASE(m.name)");

		return $query->rows;
	}

	public function getAllInformations($data = array()) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->rows;
	}

	public function getInformationStores($information_id) {
		$information_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_store_data[] = $result['store_id'];
		}

		return $information_store_data;
	}

	public function getStoreUrl($store_id) {
		$query = $this->db->query("SELECT DISTINCT url FROM " . DB_PREFIX . "store WHERE store_id = '" . (int)$store_id . "'");

		return $query->row;
	}
}
?>