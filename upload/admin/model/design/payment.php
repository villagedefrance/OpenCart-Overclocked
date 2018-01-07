<?php
class ModelDesignPayment extends Model {

	public function addPaymentImage($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "payment_image SET `name` = '" . $this->db->escape($data['name']) . "', payment = '" . $this->db->escape($data['payment']) . "', image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "', status = '" . (int)$data['status'] . "'");

		$payment_image_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_payment_image_id'] = $payment_image_id;

		return $payment_image_id;
	}

	public function editPaymentImage($payment_image_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "payment_image SET `name` = '" . $this->db->escape($data['name']) . "', payment = '" . $this->db->escape($data['payment']) . "', image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "', status = '" . (int)$data['status'] . "' WHERE payment_image_id = '" . (int)$payment_image_id . "'");
	}

	public function deletePaymentImage($payment_image_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "payment_image WHERE payment_image_id = '" . (int)$payment_image_id . "'");
	}

	public function getPaymentImage($payment_image_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "payment_image WHERE payment_image_id = '" . (int)$payment_image_id . "'");

		return $query->row;
	}

	public function getPaymentImages($data = array()) {
		$sql = "SELECT payment_image_id, name, payment, image, status FROM " . DB_PREFIX . "payment_image";

		$sort_data = array(
			'payment_image_id',
			'name',
			'payment',
			'image',
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

	public function getPaymentImageImage($payment_image_id) {
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "payment_image WHERE payment_image_id = '" . (int)$payment_image_id . "'");

		return $query->row['image'];
	}

	public function getTotalPaymentImages() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "payment_image");

		return $query->row['total'];
	}

	public function getExtensions($type) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "' ORDER BY code");

		return $query->rows;
	}
}
