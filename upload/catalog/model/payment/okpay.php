<?php
class ModelPaymentOkpay extends Model {

  	public function getMethod($address) {
		$this->language->load('payment/okpay');

		if ($this->config->get('okpay_status')) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('okpay_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

			if (!$this->config->get('okpay_geo_zone_id')) {
				$status = true;
			} elseif ($query->num_rows) {
				$status = true;
			} else {
				$status = false;
			}
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'		=> 'okpay',
				'title'			=> $this->language->get('text_title'),
				'sort_order'	=> $this->config->get('okpay_sort_order')
			);
		}

		return $method_data;
	}
}
?>