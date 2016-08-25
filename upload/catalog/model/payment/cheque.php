<?php
class ModelPaymentCheque extends Model {

	public function getMethod($address, $total) {
		$this->language->load('payment/cheque');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cheque_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		$total_max = $this->config->get('cheque_total_max');

		if (($this->config->get('cheque_total') > 0 && $this->config->get('cheque_total') > $total) || (!empty($total_max) && $total_max > 0 && $total_max < $total)) {
			$status = false;
		} elseif (!$this->config->get('cheque_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'cheque',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('cheque_sort_order')
			);
		}

		return $method_data;
	}
}
