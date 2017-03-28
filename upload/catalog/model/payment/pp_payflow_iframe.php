<?php
class ModelPaymentPPPayflowIframe extends Model {

	public function getMethod($address, $total) {
		$this->language->load('payment/pp_payflow_iframe');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pp_payflow_iframe_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('pp_payflow_iframe_total') > 0 && $this->config->get('pp_payflow_iframe_total') > $total) {
			$status = false;
		} elseif ($this->config->has('pp_payflow_iframe_total_max') && $this->config->get('pp_payflow_iframe_total_max') > 0 && $total > $this->config->get('pp_payflow_iframe_total_max')) {
			$status = false;
		} elseif (!$this->config->get('pp_payflow_iframe_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'pp_payflow_iframe',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('pp_payflow_iframe_sort_order')
			);
		}

		return $method_data;
	}

	public function getOrderId($secure_token_id) {
		$query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "paypal_payflow_iframe_order WHERE secure_token_id = '" . $this->db->escape($secure_token_id) . "'");

		if ($query->num_rows) {
			$order_id = $query->row['order_id'];
			return $order_id;
		} else {
			return false;
		}
	}

	public function addOrder($order_id, $secure_token_id) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_payflow_iframe_order SET order_id = '" . (int)$order_id . "', secure_token_id = '" . $this->db->escape($secure_token_id) . "'");
	}

	public function updateOrder($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "paypal_payflow_iframe_order SET transaction_reference = '" . $this->db->escape($data['transaction_reference']) . "', transaction_type = '" . $this->db->escape($data['transaction_type']) . "', complete = " . (int)$data['complete'] . " WHERE secure_token_id = '" . $this->db->escape($data['secure_token_id']) . "'");
	}

	public function call($data) {
		if ($this->config->get('pp_payflow_iframe_test')) {
			$url = 'https://pilot-payflowpro.paypal.com';
		} else {
			$url = 'https://payflowpro.paypal.com';
		}

		$default_parameters = array(
			'USER'         => $this->config->get('pp_payflow_iframe_user'),
			'VENDOR'       => $this->config->get('pp_payflow_iframe_vendor'),
			'PWD'          => $this->config->get('pp_payflow_iframe_password'),
			'PARTNER'      => $this->config->get('pp_payflow_iframe_partner'),
			'BUTTONSOURCE' => 'OpenCart_Cart_PFP'
		);

		$call_parameters = array_merge($data, $default_parameters);

		$this->log($call_parameters, 'Call data');

		$options = array(
			CURLOPT_POST => true,
			CURLOPT_HEADER => false,
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS => http_build_query($call_parameters, '', "&")
		);

		$ch = curl_init();

		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);

		if (curl_errno($ch) != CURLE_OK) {
			$log_data = array(
				'curl_errno' => curl_errno($ch),
				'curl_error' => curl_error($ch)
			);

			$this->log($log_data, 'CURL failed');

			return false;
		}

		$this->log($response, 'Response');

		curl_close($ch);

		$response_params = array();

		parse_str($response, $response_params);

		return $response_params;
	}

	public function addTransaction($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_payflow_iframe_order_transaction SET order_id = " . (int)$data['order_id'] . ", transaction_reference = '" . $this->db->escape($data['transaction_reference']) . "', transaction_type = '" . $this->db->escape($data['type']) . "', `time` = NOW(), amount = '" . $this->db->escape($data['amount']) . "'");
	}

	public function log($data, $title = null) {
		if ($this->config->get('pp_payflow_iframe_debug')) {
			$log = new Log('pp_payflow_iframe.log');
			$log->write('PayPal Payflow iFrame debug (' . $title . '): ' . json_encode($data));
		}
	}
}
