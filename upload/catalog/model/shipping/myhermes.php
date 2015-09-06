<?php
class ModelShippingMyHermes extends Model {

	function getQuote($address) {
		$this->language->load('shipping/myhermes');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('myhermes_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->config->get('myhermes_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$cost = 0;
			$weight = $this->cart->getWeight();

			$rates = explode(',', $this->config->get('myhermes_rate'));

			foreach ($rates as $rate) {
  				$data = explode(':', $rate);

				if ($data[0] >= $weight) {
					if (isset($data[1])) {
    					$cost = $data[1];
					}

   					break;
  				}
			}

			$quote_data = array();

			if ((float)$cost) {
				$quote_data['myhermes'] = array(
        			'code'			=> 'myhermes.myhermes',
        			'title'				=> $this->language->get('text_description') . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
        			'cost'				=> $cost,
        			'tax_class_id'	=> $this->config->get('myhermes_tax_class_id'),
					'text'				=> $this->currency->format($this->tax->calculate($cost, $this->config->get('myhermes_tax_class_id'), $this->config->get('config_tax')))
      			);

      			$method_data = array(
        			'code'			=> 'myhermes',
        			'title'				=> $this->language->get('text_title'),
        			'quote'			=> $quote_data,
					'sort_order'		=> $this->config->get('myhermes_sort_order'),
        			'error'				=> false
      			);
			}
		}

		return $method_data;
	}
}
?>