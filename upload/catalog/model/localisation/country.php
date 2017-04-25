<?php
class ModelLocalisationCountry extends Model {

	public function getCountry($country_id) {
		$query = $this->db->query("SELECT DISTINCT *, cd.name AS name FROM " . DB_PREFIX . "country c LEFT JOIN " . DB_PREFIX . "country_description cd ON (c.country_id = cd.country_id) WHERE c.country_id = '" . (int)$country_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status = '1'");

		return $query->row;
	}

	public function getCountries() {
		$country_data = $this->cache->get('countries.' . (int)$this->config->get('config_language_id'));

		if (!$country_data) {
			$query = $this->db->query("SELECT *, cd.name AS name FROM " . DB_PREFIX . "country c LEFT JOIN " . DB_PREFIX . "country_description cd ON (c.country_id = cd.country_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status = '1' ORDER BY cd.name ASC");

			$country_data = $query->rows;

			$this->cache->set('countries.' . (int)$this->config->get('config_language_id'), $country_data);
		}

		return $country_data;
	}
}
