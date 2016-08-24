<?php
class ModelSaleSupplierGroup extends Model {

	public function addSupplierGroup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "supplier_group SET order_method = '" . $this->db->escape($data['order_method']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$supplier_group_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_supplier_group_id'] = $supplier_group_id;

		foreach ($data['supplier_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "supplier_group_description SET supplier_group_id = '" . (int)$supplier_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->cache->delete('supplier_group');
	}

	public function editSupplierGroup($supplier_group_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "supplier_group SET order_method = '" . $this->db->escape($data['order_method']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE supplier_group_id = '" . (int)$supplier_group_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "supplier_group_description WHERE supplier_group_id = '" . (int)$supplier_group_id . "'");

		foreach ($data['supplier_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "supplier_group_description SET supplier_group_id = '" . (int)$supplier_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->cache->delete('supplier_group');
	}

	public function deleteSupplierGroup($supplier_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "supplier_group WHERE supplier_group_id = '" . (int)$supplier_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "supplier_group_description WHERE supplier_group_id = '" . (int)$supplier_group_id . "'");

		$this->cache->delete('supplier_group');
	}

	public function getSupplierGroup($supplier_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "supplier_group sg LEFT JOIN " . DB_PREFIX . "supplier_group_description sgd ON (sg.supplier_group_id = sgd.supplier_group_id) WHERE sg.supplier_group_id = '" . (int)$supplier_group_id . "' AND sgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getSupplierGroups($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "supplier_group sg LEFT JOIN " . DB_PREFIX . "supplier_group_description sgd ON (sg.supplier_group_id = sgd.supplier_group_id) WHERE sgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'sgd.name',
				'sg.order_method',
				'sg.payment_method',
				'sg.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY sgd.name";
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
			$supplier_group_data = $this->cache->get('supplier_group.' . (int)$this->config->get('config_language_id'));

			if (!$supplier_group_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "supplier_group sg LEFT JOIN " . DB_PREFIX . "supplier_group_description sgd ON (sg.supplier_group_id = sgd.supplier_group_id) WHERE sgd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY sgd.name");

				$supplier_group_data = $query->rows;

				$this->cache->set('supplier_group.' . (int)$this->config->get('config_language_id'), $supplier_group_data);
			}

			return $supplier_group_data;
		}
	}

	public function getSupplierGroupDescriptions($supplier_group_id) {
		$supplier_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "supplier_group_description WHERE supplier_group_id = '" . (int)$supplier_group_id . "'");

		foreach ($query->rows as $result) {
			$supplier_group_data[$result['language_id']] = array(
				'name'        => $result['name'],
				'description' => $result['description']
			);
		}

		return $supplier_group_data;
	}

	public function getPaymentMethodBySupplierGroupId($supplier_group_id) {
		$query = $this->db->query("SELECT DISTINCT payment_method FROM " . DB_PREFIX . "supplier_group WHERE supplier_group_id = '" . (int)$supplier_group_id . "'");

		return $query->row['payment_method'];
	}

	public function getTotalSupplierGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier_group");

		return $query->row['total'];
	}
}
