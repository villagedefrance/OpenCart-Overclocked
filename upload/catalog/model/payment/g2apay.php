<?php
class ModelPaymentG2APay extends Model {

	public function getMethod($address, $total) {
		$this->language->load('payment/g2apay');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('g2apay_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('g2apay_total') > 0 && $this->config->get('g2apay_total') > $total) {
			$status = false;
		} elseif ($this->config->has('g2apay_total_max') && $this->config->get('g2apay_total_max') > 0 && $total > $this->config->get('g2apay_total_max')) {
			$status = false;
		} elseif (!$this->config->get('g2apay_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'g2apay',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('g2apay_sort_order')
			);
		}

		return $method_data;
	}

	public function addG2aOrder($order_info) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "g2apay_order SET order_id = '" . (int)$order_info['order_id'] . "', date_added = NOW(), modified = NOW(), currency_code = '" . $this->db->escape($order_info['currency_code']) . "', total = '" . $this->currency->format($order_info['total'], $order_info['currency_code'], false, false) . "'");

		return $this->db->getLastId();
	}

	public function updateOrder($g2apay_order_id, $g2apay_transaction_id, $type, $order_info) {
		$this->db->query("UPDATE " . DB_PREFIX . "g2apay_order SET g2apay_transaction_id = '" . $this->db->escape($g2apay_transaction_id) . "', modified = NOW() WHERE order_id = '" . (int)$order_info['order_id'] . "'");

		$this->addTransaction($g2apay_order_id, $type, $order_info);
	}

	public function addTransaction($g2apay_order_id, $type, $order_info) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "g2apay_order_transaction SET g2apay_order_id = '" . (int)$g2apay_order_id . "', date_added = NOW(), `type` = '" . $this->db->escape($type) . "', amount = '" . $this->currency->format($order_info['total'], $order_info['currency_code'], false, false) . "'");
	}

	public function getG2aOrder($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "g2apay_order WHERE order_id = '" . (int)$order_id . "' LIMIT 0,1");

		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function sendCurl($url, $fields) {
		$curl = curl_init($url);

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);

		$response = curl_exec($curl);

		curl_close($curl);

		return json_decode($response);
	}

	public function logger($message) {
		if ($this->config->get('g2apay_debug') == 1) {
			$log = new Log('g2apay.log');

			$backtrace = debug_backtrace();

			$log->write('Origin: ' . $backtrace[6]['class'] . '::' . $backtrace[6]['function']);
			$log->write(print_r($message, 1));
		}
	}
}
