<?php
class ModelSaleSupplierProduct extends Model {

	public function addSupplierProduct($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "supplier_product SET supplier_id = '" . $this->db->escape($data['supplier_id']) . "', `name` = '" . $this->db->escape($data['name']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', model = '" . $this->db->escape($data['model']) . "', price = '" . (float)$data['price'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', unit = '" . $this->db->escape($data['unit']) . "', color = '" . $this->db->escape($data['color']) . "', `size` = '" . $this->db->escape($data['size']) . "', quantity = '" . (int)$data['quantity'] . "', `length` = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', status = '" . (int)$data['status'] . "', date_added = NOW(), date_modified = NOW()");

		$supplier_product_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_supplier_product_id'] = $supplier_product_id;

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "supplier_product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE supplier_product_id = '" . (int)$supplier_product_id . "'");
		}
	}

	public function editSupplierProduct($supplier_product_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "supplier_product SET supplier_id = '" . $this->db->escape($data['supplier_id']) . "', `name` = '" . $this->db->escape($data['name']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', model = '" . $this->db->escape($data['model']) . "', price = '" . (float)$data['price'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', unit = '" . $this->db->escape($data['unit']) . "', color = '" . $this->db->escape($data['color']) . "', `size` = '" . $this->db->escape($data['size']) . "', quantity = '" . (int)$data['quantity'] . "', `length` = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE supplier_product_id = '" . (int)$supplier_product_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "supplier_product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE supplier_product_id = '" . (int)$supplier_product_id . "'");
		}
	}

	public function editSupplierProductStatus($supplier_product_id, $status) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET status = '" . (int)$status . "', date_modified = NOW() WHERE supplier_product_id = '" . (int)$supplier_product_id . "'");
	}

	public function copySupplierProduct($supplier_product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "supplier_product WHERE supplier_product_id = '" . (int)$supplier_product_id . "'");

		if ($query->num_rows) {
			$data = array();

			$data = $query->row;

			$data['status'] = '0';

			$this->addSupplierProduct($data);
		}
	}

	public function deleteSupplierProduct($supplier_product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "supplier_product WHERE supplier_product_id = '" . (int)$supplier_product_id . "'");
	}

	public function getSupplierProduct($supplier_product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "supplier_product WHERE supplier_product_id = '" . (int)$supplier_product_id . "'");

		return $query->row;
	}

	public function getSupplierProducts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "supplier_product sp LEFT JOIN " . DB_PREFIX . "supplier s ON (s.supplier_id = sp.supplier_id)";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "sp.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$implode[] = "sp.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_supplier'])) {
			$implode[] = "s.company LIKE '" . $this->db->escape($data['filter_supplier']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$implode[] = "sp.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "sp.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($implode)) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$sql .= " GROUP BY sp.supplier_product_id";

		$sort_data = array(
			'sp.name',
			'sp.model',
			'supplier',
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

	public function getSupplierProductsBySupplierId($supplier_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "supplier_product WHERE supplier_id = '" . (int)$supplier_id . "' ORDER BY name ASC");

		return $query->rows;
	}

	public function getSupplierNameBySupplierId($supplier_id) {
		$query = $this->db->query("SELECT DISTINCT company AS name FROM " . DB_PREFIX . "supplier WHERE supplier_id = '" . (int)$supplier_id . "'");

		if (!empty($query->row['name'])) {
			return $query->row['name'];
		} else {
			return 0;
		}
	}

	public function getTaxClassIdBySupplierProduct($supplier_product_id) {
		$query = $this->db->query("SELECT DISTINCT tax_class_id AS tax FROM " . DB_PREFIX . "supplier_product WHERE supplier_product_id = '" . (int)$supplier_product_id . "'");

		return $query->row['tax'];
	}

	public function updateSupplierProductPrice($selected, $supplier_products = array(), $price) {
		if ($selected) {
			$query = $this->db->query("SELECT supplier_product_id, price FROM " . DB_PREFIX . "supplier_product WHERE supplier_product_id IN (" . implode(',', $supplier_products) . ") AND price >= '0'");
		} else {
			$query = $this->db->query("SELECT supplier_product_id, price FROM " . DB_PREFIX . "supplier_product WHERE price >= '0'");
		}

		foreach ($query->rows as $result) {
			if ($selected) {
				foreach ($products as $product_id) {
					$this->db->query("UPDATE " . DB_PREFIX . "supplier_product SET price = '" . $this->db->escape((float)$price) . "', date_modified = NOW() WHERE supplier_product_id = '" . (int)$supplier_product_id . "'");
				}
			} else {
				$this->db->query("UPDATE " . DB_PREFIX . "supplier_product SET price = '" . $this->db->escape((float)$price) . "', date_modified = NOW() WHERE supplier_product_id = '" . (int)$result['supplier_product_id'] . "'");
			}
		}
	}

	public function getTotalSupplierProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT sp.supplier_product_id) AS total FROM " . DB_PREFIX . "supplier_product sp LEFT JOIN " . DB_PREFIX . "supplier s ON (s.supplier_id = sp.supplier_id)";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "sp.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$implode[] = "sp.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_supplier'])) {
			$implode[] = "s.company LIKE '" . $this->db->escape($data['filter_supplier']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$implode[] = "sp.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "sp.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($implode)) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalSupplierProductsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier_product WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalSupplierProductsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier_product WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalSupplierProductsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier_product WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalSupplierProductsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier_product WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}
}
