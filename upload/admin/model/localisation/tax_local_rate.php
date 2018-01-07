<?php
class ModelLocalisationTaxLocalRate extends Model {

	public function addTaxLocalRate($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "tax_local_rate SET name = '" . $this->db->escape($data['name']) . "', rate = '" . (float)$data['rate'] . "', status = '" . (int)$data['status'] . "'");

		$tax_local_rate_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_tax_local_rate_id'] = $tax_local_rate_id;
	}

	public function editTaxLocalRate($tax_local_rate_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "tax_local_rate SET name = '" . $this->db->escape($data['name']) . "', rate = '" . (float)$data['rate'] . "', status = '" . (int)$data['status'] . "' WHERE tax_local_rate_id = '" . (int)$tax_local_rate_id . "'");
	}

	public function deleteTaxLocalRate($tax_local_rate_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tax_local_rate WHERE tax_local_rate_id = '" . (int)$tax_local_rate_id . "'");
	}

	public function getTaxLocalRate($tax_local_rate_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tax_local_rate WHERE tax_local_rate_id = '" . (int)$tax_local_rate_id . "'");

		return $query->row;
	}

	public function getTaxLocalRates($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "tax_local_rate";

		$sort_data = array(
			'name',
			'rate',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getTotalTaxLocalRates() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tax_local_rate");

		return $query->row['total'];
	}

	public function getTotalProductsByTaxLocalRateId($tax_local_rate_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_tax_local_rate WHERE tax_local_rate_id = '" . (int)$tax_local_rate_id . "'");

		return $query->row['total'];
	}
}
