<?php
class ModelPaymentPPPayflowIFrame extends Model {

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "paypal_payflow_iframe_order` (
			`order_id` int(11) DEFAULT NULL,
			`secure_token_id` varchar(255) NOT NULL,
			`transaction_reference` varchar(255) DEFAULT NULL,
			`transaction_type` varchar(1) DEFAULT NULL,
			`complete` tinyint(4) NOT NULL DEFAULT '0',
			PRIMARY KEY(`order_id`),
			KEY `secure_token_id` (`secure_token_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "paypal_payflow_iframe_order_transaction` (
			`order_id` int(11) NOT NULL,
			`transaction_reference` varchar(255) NOT NULL,
			`transaction_type` char(1) NOT NULL,
			`time` datetime NOT NULL,
			`amount` decimal(10,4) DEFAULT NULL,
			PRIMARY KEY (`transaction_reference`),
			KEY `order_id` (`order_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "paypal_payflow_iframe_order`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "paypal_payflow_iframe_order_transaction`;");
	}

	public function getOrder($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order WHERE order_id = " . (int)$order_id);

		if ($query->num_rows) {
			$order = $query->row;
			return $order;
		} else {
			return false;
		}
	}

	public function updateOrderStatus($order_id, $status) {
		$this->db->query("UPDATE " . DB_PREFIX .  "paypal_payflow_iframe_order SET complete = " . (int)$status . " WHERE order_id = '" . (int)$order_id . "'");
	}

	public function addTransaction($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_payflow_iframe_order_transaction SET order_id = " . (int)$data['order_id'] . ", transaction_reference = '" . $this->db->escape($data['transaction_reference']) . "', transaction_type = '" . $this->db->escape($data['type']) . "', `time` = NOW(), amount = '" . $this->db->escape($data['amount']) . "'");
	}

	public function getTransactions($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE order_id = " . (int)$order_id . " ORDER BY `time` ASC");

		if ($query->num_rows) {
			$transactions = $query->rows;
			return $transactions;
		} else {
			return false;
		}
	}

	public function getTransaction($transaction_reference) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE transaction_reference = '" . $this->db->escape($transaction_reference) . "'");

		if ($query->num_rows) {
			$transaction = $query->row;
			return $transaction;
		} else {
			return false;
		}
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
			'PARTNER'      => $this->config->get('pp_payflow_iframe_partner'),
			'PWD'          => $this->config->get('pp_payflow_iframe_password'),
			'BUTTONSOURCE' => 'OpenCart_Cart_PFP'
		);

		$call_parameters = array_merge($data, $default_parameters);

		$this->log($call_parameters, 'Call data');

		$options = array(
			CURLOPT_POST           => true,
			CURLOPT_HEADER         => false,
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS     => http_build_query($call_parameters, '', '&')
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

	public function log($data, $title = null) {
		if ($this->config->get('pp_payflow_iframe_debug')) {
			$log = new Log('pp_payflow_iframe.log');
			$log->write('PayPal Payflow iFrame debug (' . $title . '): ' . json_encode($data));
		}
	}
}
