<?php
class ModelSaleSupplier extends Model {

	public function addSupplier($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "supplier SET reference = '" . $this->db->escape($data['reference']) . "', company = '" . $this->db->escape($data['company']) . "', account = '" . $this->db->escape($data['account']) . "', description = '" . $this->db->escape($data['description']) . "', contact = '" . $this->db->escape($data['contact']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . (isset($data['telephone']) ? $data['telephone'] : 0) . "', fax = '" . (isset($data['fax']) ? $data['fax'] : 0) . "', supplier_group_id = '" . (int)$data['supplier_group_id'] . "', status = '" . (int)$data['status'] . "', date_added = NOW(), date_modified = NOW()");

		$supplier_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_supplier_id'] = $supplier_id;

		if (isset($data['address'])) {
			foreach ($data['address'] as $address) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "supplier_address SET supplier_id = '" . (int)$supplier_id . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "'");

				if (isset($address['default'])) {
					$address_id = $this->db->getLastId();

					$this->db->query("UPDATE " . DB_PREFIX . "supplier SET address_id = '" . (int)$address_id . "' WHERE supplier_id = '" . (int)$supplier_id . "'");
				}
			}
		}
	}

	public function editSupplier($supplier_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "supplier SET reference = '" . $this->db->escape($data['reference']) . "', company = '" . $this->db->escape($data['company']) . "', account = '" . $this->db->escape($data['account']) . "', description = '" . $this->db->escape($data['description']) . "', contact = '" . $this->db->escape($data['contact']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . (isset($data['telephone']) ? $data['telephone'] : 0) . "', fax = '" . (isset($data['fax']) ? $data['fax'] : 0) . "', supplier_group_id = '" . (int)$data['supplier_group_id'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE supplier_id = '" . (int)$supplier_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "supplier_address WHERE supplier_id = '" . (int)$supplier_id . "'");

		if (isset($data['address'])) {
			foreach ($data['address'] as $address) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "supplier_address SET address_id = '" . (int)$address['address_id'] . "', supplier_id = '" . (int)$supplier_id . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "'");

				if (isset($address['default'])) {
					$address_id = $this->db->getLastId();

					$this->db->query("UPDATE " . DB_PREFIX . "supplier SET address_id = '" . (int)$address_id . "' WHERE supplier_id = '" . (int)$supplier_id . "'");
				}
			}
		}
	}

	public function deleteSupplier($supplier_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "supplier WHERE supplier_id = '" . (int)$supplier_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "supplier_address WHERE supplier_id = '" . (int)$supplier_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "supplier_history WHERE supplier_id = '" . (int)$supplier_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "supplier_product WHERE supplier_id = '" . (int)$supplier_id . "'");
	}

	public function getSupplier($supplier_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "supplier WHERE supplier_id = '" . (int)$supplier_id . "'");

		return $query->row;
	}

	public function getSupplierByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "supplier WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getSuppliers($data = array()) {
		$sql = "SELECT *, sgd.name AS supplier_group FROM " . DB_PREFIX . "supplier s LEFT JOIN " . DB_PREFIX . "supplier_group_description sgd ON (s.supplier_group_id = sgd.supplier_group_id) WHERE sgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$implode = array();

		if (!empty($data['filter_reference'])) {
			$implode[] = "s.reference LIKE '%" . $this->db->escape($data['filter_reference']) . "%'";
		}

		if (!empty($data['filter_company'])) {
			$implode[] = "s.company LIKE '%" . $this->db->escape($data['filter_company']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "s.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_supplier_group_id'])) {
			$implode[] = "s.supplier_group_id = '" . (int)$data['filter_supplier_group_id'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "s.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(s.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($implode)) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			's.reference',
			's.company',
			's.email',
			'supplier_group',
			's.status',
			's.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY s.reference";
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
	}

	public function getAddress($address_id) {
		$address_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "supplier_address WHERE address_id = '" . (int)$address_id . "'");

		if ($address_query->num_rows) {
			$country_query = $this->db->query("SELECT DISTINCT *, cd.name AS name FROM " . DB_PREFIX . "country c LEFT JOIN " . DB_PREFIX . "country_description cd ON (c.country_id = cd.country_id) WHERE c.country_id = '" . (int)$address_query->row['country_id'] . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}

			return array(
				'address_id'     => $address_query->row['address_id'],
				'supplier_id'    => $address_query->row['supplier_id'],
				'company'        => $address_query->row['company'],
				'address_1'      => $address_query->row['address_1'],
				'address_2'      => $address_query->row['address_2'],
				'postcode'       => $address_query->row['postcode'],
				'city'           => $address_query->row['city'],
				'zone_id'        => $address_query->row['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => $address_query->row['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format
			);
		}
	}

	public function getAddresses($supplier_id) {
		$address_data = array();

		$query = $this->db->query("SELECT address_id FROM " . DB_PREFIX . "supplier_address WHERE supplier_id = '" . (int)$supplier_id . "'");

		foreach ($query->rows as $result) {
			$address_info = $this->getAddress($result['address_id']);

			if ($address_info) {
				$address_data[$result['address_id']] = $address_info;
			}
		}

		return $address_data;
	}

	public function getTotalSuppliers($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier";

		$implode = array();

		if (!empty($data['filter_reference'])) {
			$implode[] = "reference LIKE '%" . $this->db->escape($data['filter_reference']) . "%'";
		}

		if (!empty($data['filter_company'])) {
			$implode[] = "company LIKE '%" . $this->db->escape($data['filter_company']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_supplier_group_id'])) {
			$implode[] = "supplier_group_id = '" . (int)$data['filter_supplier_group_id'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($implode)) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalAddressesBySupplierId($supplier_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier_address WHERE supplier_id = '" . (int)$supplier_id . "'");

		return $query->row['total'];
	}

	public function getTotalAddressesByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier_address WHERE country_id = '" . (int)$country_id . "'");

		return $query->row['total'];
	}

	public function getTotalAddressesByZoneId($zone_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier_address WHERE zone_id = '" . (int)$zone_id . "'");

		return $query->row['total'];
	}

	public function getTotalSuppliersBySupplierGroupId($supplier_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier WHERE supplier_group_id = '" . (int)$supplier_group_id . "'");

		return $query->row['total'];
	}

	// History
	public function addHistory($supplier_id, $comment) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "supplier_history SET supplier_id = '" . (int)$supplier_id . "', `comment` = '" . $this->db->escape(strip_tags($comment)) . "', date_added = NOW()");
	}

	public function getHistories($supplier_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT comment, date_added FROM " . DB_PREFIX . "supplier_history WHERE supplier_id = '" . (int)$supplier_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalHistories($supplier_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier_history WHERE supplier_id = '" . (int)$supplier_id . "'");

		return $query->row['total'];
	}

	// Products
	public function getSupplierProductsBySupplierId($supplier_id, $data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "supplier_product sp LEFT JOIN " . DB_PREFIX . "supplier s ON (s.supplier_id = sp.supplier_id) WHERE sp.supplier_id = '" . (int)$supplier_id . "'";

		$sort_data = array(
			'sp.name',
			'sp.model',
			'sp.price',
			'sp.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sp.name";
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
	}

	public function getTotalSupplierProductsBySupplierId($supplier_id, $data = array()) {
		$query = $this->db->query("SELECT COUNT(DISTINCT supplier_product_id) AS total FROM " . DB_PREFIX . "supplier_product WHERE supplier_id = '" . (int)$supplier_id . "'");

		return $query->row['total'];
	}
}
