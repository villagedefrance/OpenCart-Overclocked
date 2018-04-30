<?php
class ModelPaymentFreeCheckout extends Model {

	public function getMethod($address, $total) {
		$this->language->load('payment/free_checkout');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('free_checkout_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($total <= 0.00) {
			$free_total = 0;
		} else {
			$free_total = $total;
		}

		$total_max = $this->config->get('free_checkout_total_max');

		if (($this->config->get('free_checkout_total') > 0 && $this->config->get('free_checkout_total') > $free_total) || (!empty($total_max) && $total_max > 0 && $total_max < $free_total)) {
			$status = false;
		} elseif ($this->config->has('free_checkout_total_max') && $total_max > 0 && $free_total > $total_max) {
			$status = false;
		} elseif (!$this->config->get('free_checkout_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'free_checkout',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('free_checkout_sort_order')
			);
		}

		return $method_data;
	}
}
