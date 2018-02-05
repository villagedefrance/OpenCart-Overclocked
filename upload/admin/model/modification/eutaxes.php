<?php
class ModelModificationEutaxes extends Model {

	public function addEUCountries($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "eucountry SET `code` = '" . $this->db->escape($data['code']) . "', `rate` = '" . $this->db->escape($data['rate']) . "', status = '" . (int)$data['status'] . "'");

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
		$this->db->query("UPDATE " . DB_PREFIX . "eucountry SET `code` = '" . $this->db->escape($data['code']) . "', `rate` = '" . $this->db->escape($data['rate']) . "', status = '" . (int)$data['status'] . "' WHERE eucountry_id = '" . (int)$eucountry_id . "'");

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
		$query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "eucountry` ec LEFT JOIN " . DB_PREFIX . "eucountry_description ecd ON (ecd.eucountry_id = ec.eucountry_id) WHERE ec.eucountry_id = '" . (int)$eucountry_id . "' AND ecd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getEUCountries($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM `" . DB_PREFIX . "eucountry` ec LEFT JOIN " . DB_PREFIX . "eucountry_description ecd ON (ecd.eucountry_id = ec.eucountry_id) WHERE ecd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "eucountry` ec LEFT JOIN " . DB_PREFIX . "eucountry_description ecd ON (ec.eucountry_id = ecd.eucountry_id) WHERE ecd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ecd.eucountry");

				$eucountry_data = $query->rows;

				$this->cache->set('eucountry.' . (int)$this->config->get('config_language_id'), $eucountry_data);
			}

			return $eucountry_data;
		}
	}

	public function getEUCountryDescriptions($eucountry_id) {
		$eucountry_description_data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "eucountry_description` WHERE eucountry_id = '" . (int)$eucountry_id . "'");

		foreach ($query->rows as $result) {
			$eucountry_description_data[$result['language_id']] = array(
				'eucountry'   => $result['eucountry'],
				'description' => $result['description']
			);
		}

		return $eucountry_description_data;
	}

	public function getEUCountryStores($eucountry_id) {
		$eucountry_store_data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "eucountry_to_store` WHERE eucountry_id = '" . (int)$eucountry_id . "'");

		foreach ($query->rows as $result) {
			$eucountry_store_data[] = $result['store_id'];
		}

		return $eucountry_store_data;
	}

	public function getTotalEUCountries() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "eucountry`");

		return $query->row['total'];
	}

	public function checkEUCountries() {
		// check eucountry table
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "eucountry` (`eucountry_id` int(11) NOT NULL AUTO_INCREMENT, `code` varchar(3) DEFAULT NULL, `rate` decimal(15,4) NOT NULL DEFAULT '0.0000', `status` tinyint(1) NOT NULL, PRIMARY KEY (`eucountry_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		// check eucountry description table
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "eucountry_description` (`eucountry_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `eucountry` varchar(128) NOT NULL, `description` text CHARACTER SET utf8 NOT NULL, PRIMARY KEY (`eucountry_id`,`language_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		// check eucountry store table
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "eucountry_to_store` (`eucountry_id` int(11) NOT NULL, `store_id` int(11) NOT NULL, PRIMARY KEY (`eucountry_id`,`store_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

		$this->addEUGeoZone();
		$this->addEUTaxRate();
		$this->addEUTaxClass();
	}

	// Get
	public function getEUGeoZoneId() {
		$this->load->model('localisation/geo_zone');

		$geo_zones = $this->model_localisation_geo_zone->getGeoZones(0);

		foreach ($geo_zones as $geo_zone) {
			$geo_zone_name[] = $geo_zone['name'];
		}

		if (in_array('EU VAT Zone', $geo_zone_name)) {
			$query = $this->db->query("SELECT DISTINCT geo_zone_id AS geo_zone_id FROM " . DB_PREFIX . "geo_zone WHERE `name` LIKE 'EU VAT Zone'");

			return $query->row['geo_zone_id'];
		} else {
			// Fallback
			$geo_zone_total = $this->model_localisation_geo_zone->getTotalGeoZones();

			return $geo_zone_total + 1;
		}
	}

	public function getEUTaxRateId() {
		$this->load->model('localisation/tax_rate');

		$tax_rates = $this->model_localisation_tax_rate->getTaxRates(0);

		foreach ($tax_rates as $tax_rate) {
			$tax_rate_name[] = $tax_rate['name'];
		}

		if (in_array('EU Members VAT', $tax_rate_name)) {
			$query = $this->db->query("SELECT DISTINCT tax_rate_id AS tax_rate_id FROM " . DB_PREFIX . "tax_rate WHERE `name` LIKE 'EU Members VAT'");

			return $query->row['tax_rate_id'];
		} else {
			// Fallback
			$tax_rate_total = $this->model_localisation_tax_rate->getTotalTaxRates();

			return $tax_rate_total + 1;
		}
	}

	// Add
	public function addEUGeoZone() {
		$this->load->model('localisation/geo_zone');

		$geo_zones = $this->model_localisation_geo_zone->getGeoZones(0);

		foreach ($geo_zones as $geo_zone) {
			$geo_zone_name[] = $geo_zone['name'];
		}

		if (in_array('EU VAT Zone', $geo_zone_name)) {
			return;
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "geo_zone SET `name` = 'EU VAT Zone', description = 'EU VAT Zone', date_added = NOW(), date_modified = NOW()");

			$geo_zone_id = $this->db->getLastId();

			// Zone-to-geo-zones
			$zone_to_geo_zone = array('81','14','21','33','55','53','57','195','67','72','74','84','97','103','105','117','123','124','132','150','170','171','56','175','222','189','190','203');

			foreach ($zone_to_geo_zone as $country_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "zone_to_geo_zone SET country_id = '" . (int)$country_id . "', zone_id = '0', geo_zone_id = '" . (int)$geo_zone_id . "', date_added = NOW(), date_modified = NOW()");
			}
		}

		$this->cache->delete('geo_zone');
		$this->cache->delete('zone');
	}

	public function addEUTaxClass() {
		$this->load->model('localisation/tax_class');

		$tax_classes = $this->model_localisation_tax_class->getTaxClasses(0);

		foreach ($tax_classes as $tax_class) {
			$tax_class_title[] = $tax_class['title'];
		}

		if (in_array('EU E-medias', $tax_class_title)) {
			return;
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "tax_class SET title = 'EU E-medias', description = 'EU E-medias', date_added = NOW(), date_modified = NOW()");

			$tax_class_id = $this->db->getLastId();
			$tax_rate_id = $this->getEUTaxRateId();

			$this->db->query("INSERT INTO " . DB_PREFIX . "tax_rule SET tax_class_id = '" . (int)$tax_class_id . "', tax_rate_id = '" . (int)$tax_rate_id . "', based = 'shipping', priority = '1'");
		}

		$this->cache->delete('tax_class');
	}

	public function addEUTaxRate() {
		$this->load->model('localisation/tax_rate');

		$tax_rates = $this->model_localisation_tax_rate->getTaxRates(0);

		foreach ($tax_rates as $tax_rate) {
			$tax_rate_name[] = $tax_rate['name'];
		}

		if (in_array('EU Members VAT', $tax_rate_name)) {
			return;
		} else {
			$geo_zone_id = $this->getEUGeoZoneId();

			$this->db->query("INSERT INTO " . DB_PREFIX . "tax_rate SET geo_zone_id = '" . $geo_zone_id . "', `name` = 'EU Members VAT', `rate` = '20', `type` = 'P', date_added = NOW(), date_modified = NOW()");

			$tax_rate_id = $this->db->getLastId();

			$this->load->model('sale/customer_group');

			$tax_rate_customer_group = $this->model_sale_customer_group->getCustomerGroups(0);

			foreach ($tax_rate_customer_group as $customer_group) {
				$customer_group_ids[] = $customer_group['customer_group_id'];
			}

			foreach ($customer_group_ids as $customer_group_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tax_rate_to_customer_group SET tax_rate_id = '" . (int)$tax_rate_id . "', customer_group_id = '" . (int)$customer_group_id . "'");
			}
		}
	}
}
