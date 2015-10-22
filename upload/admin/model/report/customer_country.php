<?php
class ModelReportCustomerCountry extends Model {

	public function getCountries() {
		$sql = "SELECT c.customer_id, co.country_id, cd.name AS country FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "address a ON (a.address_id = c.address_id) LEFT JOIN " . DB_PREFIX . "country co ON (co.country_id = a.country_id) LEFT JOIN " . DB_PREFIX . "country_description cd ON (cd.country_id = co.country_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY co.country_id ORDER BY cd.name ASC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalCustomersByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE country_id = '" . (int)$country_id . "'");

		return $query->row['total'];
	}
}
?>