<?php
class ModelLocalisationCountry extends Model {

	public function addCountry($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "country SET iso_code_2 = '" . $this->db->escape($data['iso_code_2']) . "', iso_code_3 = '" . $this->db->escape($data['iso_code_3']) . "', address_format = '" . $this->db->escape($data['address_format']) . "', postcode_required = '" . (int)$data['postcode_required'] . "', status = '" . (int)$data['status'] . "'");

		$country_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_country_id'] = $country_id;

		foreach ($data['country_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "country_description SET country_id = '" . (int)$country_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('country');
	}

	public function editCountry($country_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "country SET iso_code_2 = '" . $this->db->escape($data['iso_code_2']) . "', iso_code_3 = '" . $this->db->escape($data['iso_code_3']) . "', address_format = '" . $this->db->escape($data['address_format']) . "', postcode_required = '" . (int)$data['postcode_required'] . "', status = '" . (int)$data['status'] . "' WHERE country_id = '" . (int)$country_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "country_description WHERE country_id = '" . (int)$country_id . "'");

		foreach ($data['country_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "country_description SET country_id = '" . (int)$country_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('country');
	}

	public function deleteCountry($country_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$country_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "country_description WHERE country_id = '" . (int)$country_id . "'");

		$this->cache->delete('country');
	}

	public function getCountry($country_id) {
		$query = $this->db->query("SELECT DISTINCT *, cd.name AS name FROM " . DB_PREFIX . "country c LEFT JOIN " . DB_PREFIX . "country_description cd ON (c.country_id = cd.country_id) WHERE c.country_id = '" . (int)$country_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCountries($data = array()) {
		if ($data) {
			$sql = "SELECT *, cd.name AS name FROM " . DB_PREFIX . "country c LEFT JOIN " . DB_PREFIX . "country_description cd ON (c.country_id = cd.country_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'name',
				'iso_code_2',
				'iso_code_3',
				'status'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY cd.name";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;

		} else {
			$country_data = $this->cache->get('country.' . (int)$this->config->get('config_language_id'));

			if (!$country_data) {
				$query = $this->db->query("SELECT *, cd.name AS name FROM " . DB_PREFIX . "country c LEFT JOIN " . DB_PREFIX . "country_description cd ON (c.country_id = cd.country_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cd.name ASC");

				$country_data = $query->rows;

				$this->cache->set('country.' . (int)$this->config->get('config_language_id'), $country_data);
			}

			return $country_data;
		}
	}

	public function getCountryDescriptions($country_id) {
		$country_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country_description WHERE country_id = '" . (int)$country_id . "'");

		foreach ($query->rows as $result) {
			$country_data[$result['language_id']] = array(
				'name'	=> $result['name']
			);
		}

		return $country_data;
	}

	public function getCountryName($country_id) {
		$query = $this->db->query("SELECT DISTINCT name FROM " . DB_PREFIX . "country_description WHERE country_id = '" . (int)$country_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function enableCountry($country_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "country SET status = '1' WHERE country_id = '" . (int)$country_id . "'");

		$this->cache->delete('country');
	}

	public function disableCountry($country_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "country SET status = '0' WHERE country_id = '" . (int)$country_id . "'");

		$this->cache->delete('country');
	}

	public function getTotalCountries() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "country");

		return $query->row['total'];
	}
}
?>