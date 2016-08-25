<?php
class ModelDesignFooter extends Model {

	public function getFooter($footer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "footer f LEFT JOIN " . DB_PREFIX . "footer_description fd ON (f.footer_id = fd.footer_id) LEFT JOIN " . DB_PREFIX . "footer_to_store f2s ON (f.footer_id = f2s.footer_id) WHERE f.footer_id = '" . (int)$footer_id . "' AND fd.footer_id = '" . (int)$this->config->get('config_language_id') . "' AND f2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND f.status = '1'");

		return $query->row;
	}

	public function getFooters() {
		$footer_data = $this->cache->get('footer.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));

		if (!$footer_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer f LEFT JOIN " . DB_PREFIX . "footer_description fd ON (f.footer_id = fd.footer_id) LEFT JOIN " . DB_PREFIX . "footer_to_store f2s ON (f.footer_id = f2s.footer_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND f2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND f.status = '1' ORDER BY f.position, LCASE(fd.name) ASC");

			$footer_data = $query->rows;

			$this->cache->set('footer.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $footer_data);
		}

		return $footer_data;
	}

	public function getFooterRoutes() {
		$footer_route_data = $this->cache->get('footer.route.' . (int)$this->config->get('config_language_id'));

		if (!$footer_route_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "footer_route fr LEFT JOIN " . DB_PREFIX . "footer_route_description frd ON (fr.footer_route_id = frd.footer_route_id) WHERE frd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY fr.sort_order ASC");

			$footer_route_data = $query->rows;

			$this->cache->set('footer.route.' . (int)$this->config->get('config_language_id'), $footer_route_data);
		}

		return $footer_route_data;
	}

	public function getTotalFooters() {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "footer WHERE status = '1'";

		$cache_id = 'footer.total';

		$total = $this->cache->get($cache_id);

		if (!$total || $total === null) {
			$query = $this->db->query($sql);

			$total = $query->row['total'];

			$this->cache->set($cache_id, $total);
		}

		return $total;
	}

	public function getFooterMaxPosition() {
		$query = $this->db->query("SELECT MAX(position) AS position FROM " . DB_PREFIX . "footer WHERE status = '1'");

		return $query->row['position'];
	}
}
