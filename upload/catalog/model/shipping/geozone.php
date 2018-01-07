<?php
class ModelShippingGeoZone extends Model {

	public function getQuote($address) {
		$this->language->load('shipping/geozone');

		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

		if ($this->config->get('geozone_method') == 'item') {
			$method = $this->cart->hasProducts();
		} elseif ($this->config->get('geozone_method') == 'price') {
			$method = $this->cart->getTotal();
		} elseif ($this->config->get('geozone_method') == 'weight') {
			$method = $this->cart->getWeight();
		} else {
			$method = 0;
		}

		$weight = $this->cart->getWeight();

		$zone_status = false;
		$all_zone_status = false;

		$cost = '';

		if ($query->num_rows) {
			foreach ($query->rows as $result) {
				if ($this->config->get('geozone_' . $result['geo_zone_id'] . '_status')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $result['geo_zone_id'] . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

					foreach ($query->rows as $zoneresult) {
						$zone_id = $zoneresult['zone_id'];
					}

					if ($query->num_rows) {
						$status = true;
					} else {
						$status = false;
					}

				} else {
					$status = false;
				}

				if ($status) {
					$rates = explode(',', $this->config->get('geozone_' . $result['geo_zone_id'] . '_rate'));

					foreach ($rates as $rate) {
						$data = explode(':', $rate);

						if ($data[0] >= $method) {
							if (isset($data[1])) {
								$cost = $data[1];
							}
							break;
						}
					}

					if ((float)$cost && ($zone_id == $address['zone_id']) || $zone_id == 0) {
						$zone_status = true;

						$quote_data['geozone_' . $result['geo_zone_id']] = array(
							'code'         => 'geozone.geozone_' . $result['geo_zone_id'],
							'title'        => $result['name'] . ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
							'cost'         => $cost,
							'tax_class_id' => $this->config->get('geozone_tax_class_id'),
							'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('geozone_tax_class_id'), $this->config->get('config_tax')))
						);
					}
				}
			}

			if ((float)$cost && $zone_id == 0 && !$zone_status) {
				$quote_data = array();

				$all_zone_status = true;

				$quote_data['geozone_' . $result['geo_zone_id']] = array(
					'code'         => 'geozone.geozone_' . $result['geo_zone_id'],
					'title'        => $result['name'] . ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
					'cost'         => $cost,
					'tax_class_id' => $this->config->get('geozone_tax_class_id'),
					'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('geozone_tax_class_id'), $this->config->get('config_tax')))
				);
			}
		}

		if ($this->config->get('geozone_00_status') && !$all_zone_status && !$zone_status) {
			$rates = explode(',', $this->config->get('geozone_00_rate'));

			foreach ($rates as $rate) {
				$data = explode(':', $rate);

				if ($data[0] >= $method) {
					if (isset($data[1])) {
						$cost = $data[1];
					}
					break;
				}
			}

			if ((float)$cost) {
				$quote_data['geozone_00'] = array(
					'code'         => 'geozone.geozone_00',
					'title'        => $address['country'] . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
					'cost'         => $cost,
					'tax_class_id' => $this->config->get('geozone_tax_class_id'),
					'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('geozone_tax_class_id'), $this->config->get('config_tax')))
				);
			}
		}

		$method_data = array();

		if ($quote_data) {
			$method_data = array(
				'code'       => 'geozone',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('geozone_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}
