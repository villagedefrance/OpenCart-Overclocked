<?php
class ModelModificationEutaxes extends Model {

	public function addEUCountries($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "eucountry SET code = '" . $this->db->escape($data['code']) . "', rate = '" . $this->db->escape($data['rate']) . "', status = '" . (int)$data['status'] . "'");

		$eucountry_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_eucountry_id'] = $eucountry_id;

		foreach ($data['eucountry_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "eucountry_description SET eucountry_id = '" . (int)$eucountry_id . "', language_id = '" . (int)$language_id . "', eucountry = '" . $this->db->escape($value['eucountry']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		if (isset($data['eucountry_store'])) {
			foreach ($data['eucountry_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eucountry_to_store SET eucountry_id = '" . (int)$eucountry_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->cache->delete('eucountry');
		$this->cache->delete('store');
	}

	public function editEUCountries($eucountry_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "eucountry SET code = '" . $this->db->escape($data['code']) . "', rate = '" . $this->db->escape($data['rate']) . "', status = '" . (int)$data['status'] . "' WHERE eucountry_id = '" . (int)$eucountry_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "eucountry_description WHERE eucountry_id = '" . (int)$eucountry_id . "'");

		foreach ($data['eucountry_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "eucountry_description SET eucountry_id = '" . (int)$eucountry_id . "', language_id = '" . (int)$language_id . "', eucountry = '" . $this->db->escape($value['eucountry']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "eucountry_to_store WHERE eucountry_id = '" . (int)$eucountry_id . "'");

		if (isset($data['eucountry_store'])) {
			foreach ($data['eucountry_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eucountry_to_store SET eucountry_id = '" . (int)$eucountry_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->cache->delete('eucountry');
		$this->cache->delete('store');
	}

	public function deleteEUCountries($eucountry_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "eucountry WHERE eucountry_id = '" . (int)$eucountry_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "eucountry_description WHERE eucountry_id = '" . (int)$eucountry_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "eucountry_to_store WHERE eucountry_id = '" . (int)$eucountry_id . "'");

		$this->cache->delete('eucountry');
		$this->cache->delete('store');
	}

	public function getEUCountryStory($eucountry_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "eucountry ec LEFT JOIN " . DB_PREFIX . "eucountry_description ecd ON (ecd.eucountry_id = ec.eucountry_id) WHERE ec.eucountry_id = '" . (int)$eucountry_id . "' AND ecd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getEUCountries($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "eucountry ec LEFT JOIN " . DB_PREFIX . "eucountry_description ecd ON (ecd.eucountry_id = ec.eucountry_id) WHERE ecd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'ecd.eucountry',
				'ec.code',
				'ec.rate',
				'ec.status'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY ecd.eucountry";
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
			$eucountry_data = $this->cache->get('eucountry.' . (int)$this->config->get('config_language_id'));

			if (!$eucountry_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eucountry ec LEFT JOIN " . DB_PREFIX . "eucountry_description ecd ON (ec.eucountry_id = ecd.eucountry_id) WHERE ecd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ecd.eucountry");

				$eucountry_data = $query->rows;

				$this->cache->set('eucountry.' . (int)$this->config->get('config_language_id'), $eucountry_data);
			}

			return $eucountry_data;
		}
	}

	public function getEUCountryDescriptions($eucountry_id) {
		$eucountry_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eucountry_description WHERE eucountry_id = '" . (int)$eucountry_id . "'");

		foreach ($query->rows as $result) {
			$eucountry_description_data[$result['language_id']] = array(
				'eucountry'		=> $result['eucountry'],
				'description'	=> $result['description']
			);
		}

		return $eucountry_description_data;
	}

	public function getEUCountryStores($eucountry_id) {
		$eucountry_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eucountry_to_store WHERE eucountry_id = '" . (int)$eucountry_id . "'");

		foreach ($query->rows as $result) {
			$eucountry_store_data[] = $result['store_id'];
		}

		return $eucountry_store_data;
	}

	public function getTotalEUCountries() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eucountry");

		return $query->row['total'];
	}

	public function checkEUCountries() {
		// check eucountry table
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "eucountry` (`eucountry_id` int(11) NOT NULL AUTO_INCREMENT, `code` varchar(3) DEFAULT NULL, `rate` decimal(15,4) NOT NULL DEFAULT '0.0000', `status` tinyint(1) NOT NULL, PRIMARY KEY (`eucountry_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		// check eucountry description table
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "eucountry_description` (`eucountry_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `eucountry` varchar(128) NOT NULL, `description` text CHARACTER SET utf8 NOT NULL, PRIMARY KEY (`eucountry_id`,`language_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		// check eucountry store table
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "eucountry_to_store` (`eucountry_id` int(11) NOT NULL, `store_id` int(11) NOT NULL, PRIMARY KEY (`eucountry_id`,`store_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
	}
}
?>