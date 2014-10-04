<?php
class ModelDesignFooter extends Model {

	public function getFooter($footer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "footer f LEFT JOIN " . DB_PREFIX . "footer_description fd ON (f.footer_id = fd.footer_id) LEFT JOIN " . DB_PREFIX . "footer_to_store f2s ON (f.footer_id = f2s.footer_id) WHERE f.footer_id = '" . (int)$footer_id . "' AND fd.footer_id = '" . (int)$this->config->get('config_language_id') . "' AND f2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND f.status = '1'");

		return $query->row;
	}

	public function getFooters() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer f LEFT JOIN " . DB_PREFIX . "footer_description fd ON (f.footer_id = fd.footer_id) LEFT JOIN " . DB_PREFIX . "footer_to_store f2s ON (f.footer_id = f2s.footer_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND f2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND f.status = '1' ORDER BY f.position, LCASE(fd.name) ASC");

		return $query->rows;
	}

	public function getFooterRoutes() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_route fr LEFT JOIN " . DB_PREFIX . "footer_route_description frd ON (fr.footer_route_id = frd.footer_route_id) WHERE frd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY fr.sort_order ASC");

		return $query->rows;
	}

	public function getTotalFooters() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "footer WHERE status = '1'");

		return $query->row['total'];
	}
}
?>