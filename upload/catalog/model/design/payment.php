<?php
class ModelDesignPayment extends Model {

	public function getPaymentImages($data = array()) {
		$payment_image_data = array();

		$payment_images_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "payment_image WHERE status = '1' ORDER BY payment");

		foreach ($payment_images_query->rows as $payment_image) {
			$payment_image_data[] = array(
				'payment_image_id'	=> $payment_image['payment_image_id'],
				'payment'				=> $payment_image['payment'],
				'image'					=> $payment_image['image']
			);
		}

		return $payment_image_data;
	}
}
?>