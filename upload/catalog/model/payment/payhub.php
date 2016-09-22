<?php
class ModelPaymentPayhub extends Model {

	public function getMethod($address, $total) {
		$this->language->load('payment/payhub');

		if ($this->config->get('payhub_status')) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('payhub_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

			if ($this->config->get('payhub_total') > 0 && $this->config->get('payhub_total') > $total) {
				$status = false;
			} elseif ($this->config->has('payhub_total_max') && $this->config->get('payhub_total_max') > 0 && $total > $this->config->get('payhub_total_max')) {
				$status = false;
			} elseif (!$this->config->get('payhub_geo_zone_id')) {
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
				'code'       => 'payhub',
				'title'      => $this->language->get('text_title') . " (" . $this->config->get('payhub_cards_accepted') . ")",
				'terms'      => '',
				'sort_order' => $this->config->get('payhub_sort_order')
			);
		}

		return $method_data;
	}
}
