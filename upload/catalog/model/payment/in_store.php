<?php
class ModelPaymentInStore extends Model {

	public function getMethod($address, $total) {
		$this->language->load('payment/in_store');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('in_store_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		$total_max = $this->config->get('in_store_total_max');

		if (($this->config->get('in_store_total') > 0 && $this->config->get('in_store_total') > $total) || (!empty($total_max) && $total_max > 0 && $total_max < $total)) {
			$status = false;
		} elseif ($this->config->has('in_store_total_max') && $this->config->get('in_store_total_max') > 0 && $total > $this->config->get('in_store_total_max')) {
			$status = false;
		} elseif (!$this->config->get('in_store_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'in_store',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('in_store_sort_order')
			);
		}

		return $method_data;
	}
}
