<?php
class ModelSaleOffer extends Model {

	// Product to Product
	public function getOfferProductProducts($data = array()) {
		$sql = "SELECT offer_product_product_id, name, `type`, discount, logged, date_end, status FROM " . DB_PREFIX . "offer_product_product";

		$sort_data = array(
			'name',
			'type',
			'discount',
			'logged',
			'date_end',
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

	public function getTotalOfferProductProduct() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "offer_product_product");

		return $query->row['total'];
	}

	// Product to Category
	public function getOfferProductCategories($data = array()) {
		$sql = "SELECT offer_product_category_id, name, `type`, discount, logged, date_end, status FROM " . DB_PREFIX . "offer_product_category";

		$sort_data = array(
			'name',
			'type',
			'discount',
			'logged',
			'date_end',
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

	public function getTotalOfferProductCategory() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "offer_product_category");

		return $query->row['total'];
	}

	// Category to Product
	public function getOfferCategoryProducts($data = array()) {
		$sql = "SELECT offer_category_product_id, name, `type`, discount, logged, date_end, status FROM " . DB_PREFIX . "offer_category_product";

		$sort_data = array(
			'name',
			'type',
			'discount',
			'logged',
			'date_end',
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

	public function getTotalOfferCategoryProduct() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "offer_category_product");

		return $query->row['total'];
	}

	// Category to Category
	public function getOfferCategoryCategories($data = array()) {
		$sql = "SELECT offer_category_category_id, name, `type`, discount, logged, date_end, status FROM " . DB_PREFIX . "offer_category_category";

		$sort_data = array(
			'name',
			'type',
			'discount',
			'logged',
			'date_end',
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

	public function getTotalOfferCategoryCategory() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "offer_category_category");

		return $query->row['total'];
	}

	// Discount Products
	public function getTotalProductDiscounts() {
		$query = $this->db->query("SELECT COUNT(DISTINCT product_id) AS total FROM " . DB_PREFIX . "product_discount WHERE (date_start = '0000-00-00' OR date_start <= CURDATE()) AND (date_end = '0000-00-00' OR date_end > CURDATE()) GROUP BY product_id");

		if (!empty($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}

	// Special Products
	public function getTotalProductSpecials() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_special WHERE (date_start = '0000-00-00' OR date_start <= CURDATE()) AND (date_end = '0000-00-00' OR date_end > CURDATE())");

		return $query->row['total'];
	}

	// Product Price
	public function getProductPrice($product_id) {
		$query = $this->db->query("SELECT DISTINCT price FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "' GROUP BY product_id");

		if (isset($query->row['price'])) {
			return $query->row['price'];
		} else {
			return false;
		}
	}

	// MIN Product Price by Category
	public function getMinProductPricebyCategory($category_id) {
		$query = $this->db->query("SELECT MIN(p.price) AS price FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p2c.category_id = '" . (int)$category_id . "'");

		return $query->row['price'];
	}
}
