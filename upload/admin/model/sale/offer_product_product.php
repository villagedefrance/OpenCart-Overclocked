<?php
class ModelSaleOfferProductProduct extends Model {

	public function addOfferProductProduct($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "offer_product_product SET name = '" . $this->db->escape($data['name']) . "', `type` = '" . $this->db->escape($data['type']) . "', discount = '" . (float)$data['discount'] . "', logged = '" . (int)$data['logged'] . "', product_one = '" . $this->db->escape($data['product_one']) . "', product_two = '" . $this->db->escape($data['product_two']) . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$offer_product_product_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_offer_product_product_id'] = $offer_product_product_id;
	}

	public function editOfferProductProduct($offer_product_product_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "offer_product_product SET name = '" . $this->db->escape($data['name']) . "', `type` = '" . $this->db->escape($data['type']) . "', discount = '" . (float)$data['discount'] . "', logged = '" . (int)$data['logged'] . "', product_one = '" . $this->db->escape($data['product_one']) . "', product_two = '" . $this->db->escape($data['product_two']) . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', status = '" . (int)$data['status'] . "' WHERE offer_product_product_id = '" . (int)$offer_product_product_id . "'");
	}

	public function deleteOfferProductProduct($offer_product_product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "offer_product_product WHERE offer_product_product_id = '" . (int)$offer_product_product_id . "'");
	}

	public function getOfferProductProduct($offer_product_product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "offer_product_product WHERE offer_product_product_id = '" . (int)$offer_product_product_id . "'");

		return $query->row;
	}

	public function getOfferProductProducts($data = array()) {
		$sql = "SELECT offer_product_product_id, name, discount, `type`, logged, date_start, date_end, status FROM " . DB_PREFIX . "offer_product_product";

		$sort_data = array(
			'name',
			'type',
			'discount',
			'logged',
			'date_start',
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

	public function getOfferProductProductOnes($offer_product_product_id) {
		$offer_product_one_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "offer_product_product WHERE offer_product_product_id = '" . (int)$offer_product_product_id . "'");

		foreach ($query->rows as $result) {
			$offer_product_one_data[] = $result['product_one'];
		}

		return $offer_product_one_data;
	}

	public function getOfferProductProductTwos($offer_product_product_id) {
		$offer_product_two_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "offer_product_product WHERE offer_product_product_id = '" . (int)$offer_product_product_id . "'");

		foreach ($query->rows as $result) {
			$offer_product_two_data[] = $result['product_two'];
		}

		return $offer_product_two_data;
	}

	public function getTotalOfferProductProduct() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "offer_product_product");

		return $query->row['total'];
	}
}
