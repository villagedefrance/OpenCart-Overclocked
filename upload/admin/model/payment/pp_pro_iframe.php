<?php
class ModelPaymentPPProIframe extends Model {

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "paypal_iframe_order` (
			`paypal_iframe_order_id` int(11) NOT NULL AUTO_INCREMENT,
			`order_id` int(11) NOT NULL,
			`created` DATETIME NOT NULL,
			`modified` DATETIME NOT NULL,
			`capture_status` ENUM('Complete', 'NotComplete') DEFAULT NULL,
			`currency_code` CHAR(3) NOT NULL,
			`authorization_id` VARCHAR(30) NOT NULL,
			`total` DECIMAL(10, 2) NOT NULL,
			PRIMARY KEY (`paypal_iframe_order_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "paypal_iframe_order_transaction` (
			`paypal_iframe_order_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
			`paypal_iframe_order_id` int(11) NOT NULL,
			`transaction_id` CHAR(20) NOT NULL,
			`parent_transaction_id` CHAR(20) NOT NULL,
			`created` DATETIME NOT NULL,
			`note` VARCHAR(255) NOT NULL,
			`msgsubid` CHAR(38) NOT NULL,
			`receipt_id` CHAR(20) NOT NULL,
			`payment_type` ENUM('none', 'echeck', 'instant', 'refund', 'void') DEFAULT NULL,
			`payment_status` CHAR(20) NOT NULL,
			`pending_reason` CHAR(50) NOT NULL,
			`transaction_entity` CHAR(50) NOT NULL,
			`amount` DECIMAL(10,2) NOT NULL,
			`debug_data` TEXT NOT NULL,
			`call_data` TEXT NOT NULL,
			PRIMARY KEY (`paypal_iframe_order_transaction_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "paypal_iframe_order_transaction`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "paypal_iframe_order`;");
	}

	public function getPaypalOrder($paypal_iframe_order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "paypal_iframe_order` WHERE `paypal_iframe_order_id` = " . (int)$paypal_iframe_order_id);

		return (($query instanceof stdClass) && isset($query->row) && is_array($query->row)) ? $query->row : false;
	}

	public function getPaypalOrderByOrderId($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "paypal_iframe_order` WHERE `order_id` = " . (int)$order_id);

		return (($query instanceof stdClass) && isset($query->row) && is_array($query->row)) ? $query->row : false;
	}

	public function updatePaypalOrderStatus($order_id, $capture_status) {
		$this->db->query("UPDATE `" . DB_PREFIX . "paypal_iframe_order` SET `capture_status` = '" . $this->db->escape($capture_status) . "', `modified` = NOW() WHERE `order_id` = " . (int)$order_id);
	}

	public function updateAuthorizationId($paypal_iframe_order_id, $authorization_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "paypal_iframe_order SET authorization_id = '" . $this->db->escape($authorization_id) . "' WHERE paypal_iframe_order_id = " . (int)$paypal_iframe_order_id);
	}

	public function addTransaction($transaction_data, $request_data = array()) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_iframe_order_transaction SET "
		. "paypal_iframe_order_id = " . (isset($transaction_data['paypal_iframe_order_id']) ? (int)$transaction_data['paypal_iframe_order_id'] : 0) . ", "
		. "transaction_id = '" . (isset($transaction_data['transaction_id']) ? $this->db->escape($transaction_data['transaction_id']) : null) . "', "
		. "parent_transaction_id = '" . (isset($transaction_data['parent_transaction_id']) ? $this->db->escape($transaction_data['parent_transaction_id']) : null) . "', "
		. "created = NOW(), "
		. "note = '" . (isset($transaction_data['note']) ? $this->db->escape($transaction_data['note']) : null) . "', "
		. "msgsubid = '" . (isset($transaction_data['msgsubid']) ? $this->db->escape($transaction_data['msgsubid']) : null) . "', "
		. "receipt_id = '" . (isset($transaction_data['receipt_id']) ? $this->db->escape($transaction_data['receipt_id']) : null) . "', "
		. "payment_type = '" . (isset($transaction_data['payment_type']) ? $this->db->escape($transaction_data['payment_type']) : null) . "', "
		. "payment_status = '" . (isset($transaction_data['payment_status']) ? $this->db->escape($transaction_data['payment_status']) : null) . "', "
		. "pending_reason = '" . (isset($transaction_data['pending_reason']) ? $this->db->escape($transaction_data['pending_reason']) : null) . "', "
		. "transaction_entity = '" . (isset($transaction_data['transaction_entity']) ? $this->db->escape($transaction_data['transaction_entity']) : null) . "', "
		. "amount = " . (isset($transaction_data['amount']) ? (double)$transaction_data['amount'] : 0.0) . ", "
		. "debug_data = '" . (isset($transaction_data['debug_data']) ? $this->db->escape($transaction_data['debug_data']) : null) . "'"
		. (!empty($request_data) ? ", call_data = '" . $this->db->escape(serialize($request_data)) . "'" : null));

		$paypal_iframe_order_transaction_id = $this->db->getLastId();

		return $paypal_iframe_order_transaction_id;
	}

	public function editTransaction($transaction) {
		$this->db->query("UPDATE " . DB_PREFIX . "paypal_iframe_order_transaction SET "
		. "paypal_iframe_order_id = " . (isset($transaction['paypal_iframe_order_id']) ? (int)$transaction['paypal_iframe_order_id'] : 0) . ", "
		. "transaction_id = '" . (isset($transaction['transaction_id']) ? $this->db->escape($transaction['transaction_id']) : null) . "', "
		. "parent_transaction_id = '" . (isset($transaction['parent_transaction_id']) ? $this->db->escape($transaction['parent_transaction_id']) : null) . "', "
		. "created = '" . (isset($transaction['created']) ? $this->db->escape($transaction['created']) : null) . "', "
		. "note = '" . (isset($transaction['note']) ? $this->db->escape($transaction['note']) : null) . "', "
		. "msgsubid = '" . (isset($transaction['msgsubid']) ? $this->db->escape($transaction['msgsubid']) : null) . "', "
		. "receipt_id = '" . (isset($transaction['receipt_id']) ? $this->db->escape($transaction['receipt_id']) : null) . "', "
		. "payment_type = '" . (isset($transaction['payment_type']) ? $this->db->escape($transaction['payment_type']) : null) . "', "
		. "payment_status = '" . (isset($transaction['payment_status']) ? $this->db->escape($transaction['payment_status']) : null) . "', "
		. "pending_reason = '" . (isset($transaction['pending_reason']) ? $this->db->escape($transaction['pending_reason']) : null) . "', "
		. "transaction_entity = '" . (isset($transaction['transaction_entity']) ? $this->db->escape($transaction['transaction_entity']) : null) . "', "
		. "amount = " . (isset($transaction['amount']) ? (double)$transaction['amount'] : 0.0) . ", "
		. "debug_data = '" . (isset($transaction['debug_data']) ? $this->db->escape($transaction['debug_data']) : null) . "', "
		. "call_data = '" . (isset($transaction['call_data']) ? $this->db->escape($transaction['call_data']) : null) . "' "
		. "WHERE paypal_iframe_order_transaction_id = " . (int)$transaction['paypal_iframe_order_transaction_id']);
	}

	public function getPaypalOrderByTransactionId($transaction_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_iframe_order o LEFT JOIN " . DB_PREFIX . "paypal_iframe_order_transaction ot ON (o.paypal_iframe_order_id = ot.paypal_iframe_order_id) WHERE ot.transaction_id = '" . $this->db->escape($transaction_id) . "' LIMIT 1");

		return $query->rows;
	}

	public function getFailedTransaction($paypal_iframe_order_transaction_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_iframe_order_transaction WHERE paypal_iframe_order_transaction_id = " . (int)$paypal_iframe_order_transaction_id . " AND payment_status = 'Failed'");

		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getLocalTransaction($transaction_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_iframe_order_transaction WHERE transaction_id = '" . $this->db->escape($transaction_id) . "'");

		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function requestTransactionDetails($transaction_id) {
		$call_data = array(
			'METHOD'        => 'GetTransactionDetails',
			'TRANSACTIONID' => $transaction_id
		);

		return $this->call($call_data);
	}

	public function updateTransactionStatus($transaction_id, $transaction_status) {
		$this->db->query("UPDATE " . DB_PREFIX . "paypal_iframe_order_transaction SET payment_status = '" . $this->db->escape($transaction_status) . "' WHERE transaction_id = '" . $this->db->escape($transaction_id) . "' LIMIT 1");
	}

	public function getTotalCaptured($paypal_iframe_order_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "paypal_iframe_order_transaction WHERE paypal_iframe_order_id = " . (int)$paypal_iframe_order_id . " AND pending_reason != 'authorization' AND (payment_status = 'Partially-Refunded' OR payment_status = 'Completed' OR payment_status = 'Pending') AND transaction_entity = 'payment'");

		return $query->row['total'];
	}

	public function getTotalRefunded($paypal_iframe_order_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "paypal_iframe_order_transaction WHERE paypal_iframe_order_id = " . (int)$paypal_iframe_order_id . " AND payment_status = 'Refunded'");

		return $query->row['total'];
	}

	public function getTotalRefundedByParentId($parent_transaction_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "paypal_iframe_order_transaction WHERE parent_transaction_id = '" . $this->db->escape($parent_transaction_id) . "' AND payment_type = 'refund'");

		return $query->row['total'];
	}

	protected function cleanReturn($data) {
		$data = explode('&', $data);

		$arr = array();

		foreach ($data as $k => $v) {
			$tmp = explode('=', $v);
			$arr[$tmp[0]] = (isset($tmp[1]) ? urldecode($tmp[1]) : '');
		}

		return $arr;
	}

	public function log($data, $title = null, $force = false) {
		if ($this->config->get('pp_pro_iframe_debug') || $force) {
			$log = new Log('pp_pro_iframe.log');
			$log->write('PayPal Pro iFrame debug (' . $title . '): ' . json_encode($data));
		}
	}

	public function getOrder($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_iframe_order WHERE order_id = " . (int)$order_id . " LIMIT 1");

		if ($query->num_rows) {
			$order = $query->row;

			$order['transactions'] = $this->getTransactions($order['paypal_iframe_order_id']);
			$order['captured'] = $this->getTotalCaptured($order['paypal_iframe_order_id']);

			return $order;
		} else {
			return false;
		}
	}

	public function getOrderId($transaction_id) {
		$query = $this->db->query("SELECT o.order_id FROM " . DB_PREFIX . "paypal_iframe_order_transaction ot LEFT JOIN " . DB_PREFIX . "paypal_iframe_order o ON (o.paypal_iframe_order_id = ot.paypal_iframe_order_id) WHERE ot.transaction_id = '" . $this->db->escape($transaction_id) . "' LIMIT 1");

		if ($query->num_rows) {
			return $query->row['order_id'];
		} else {
			return false;
		}
	}

	public function getTransactions($paypal_iframe_order_id) {
		$transactions = array();
		// children unused
		$query = $this->db->query("SELECT ot.*, (SELECT COUNT(ot2.paypal_iframe_order_id) FROM " . DB_PREFIX . "paypal_iframe_order_transaction ot2 WHERE ot2.parent_transaction_id = ot.transaction_id) AS children FROM " . DB_PREFIX . "paypal_iframe_order_transaction ot WHERE paypal_iframe_order_id = " . (int)$paypal_iframe_order_id . " ORDER BY paypal_iframe_order_transaction_id ASC");

		if ($query->num_rows) {
			foreach ($query->rows as $result) {
				$transactions[] = $result;
			}
		}

		return $transactions;
	}

	public function call($data) {
		if ($this->config->get('pp_pro_iframe_test') == 1) {
			$api_endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
			$user = $this->config->get('pp_pro_iframe_sandbox_username');
			$password = $this->config->get('pp_pro_iframe_sandbox_password');
			$signature = $this->config->get('pp_pro_iframe_sandbox_signature');
		} else {
			$api_endpoint = 'https://api-3t.paypal.com/nvp';
			$user = $this->config->get('pp_pro_iframe_username');
			$password = $this->config->get('pp_pro_iframe_password');
			$signature = $this->config->get('pp_pro_iframe_signature');
		}

		$default_parameters = array(
			'USER'         => $user,
			'PWD'          => $password,
			'SIGNATURE'    => $signature,
			'VERSION'      => '84',
			'BUTTONSOURCE' => 'WM_PRO_OPENCART_UK_' . VERSION
		);

		$call_parameters = array_merge($data, $default_parameters);

		$this->log($call_parameters, 'Call data');

		$options = array(
			CURLOPT_POST            => true,
			CURLOPT_HEADER          => false,
			CURLOPT_URL             => $api_endpoint,
			CURLOPT_USERAGENT       => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1",
			CURLOPT_FRESH_CONNECT   => true,
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_FORBID_REUSE    => true,
			CURLOPT_TIMEOUT         => 0,
			CURLOPT_SSL_VERIFYPEER  => false,
			CURLOPT_SSL_VERIFYHOST  => false,
			CURLOPT_POSTFIELDS      => http_build_query($call_parameters, '', '&')
		);

		$ch = curl_init();

		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);

		if (curl_errno($ch) != CURLE_OK) {
			$log_data = array(
				'curl_error' => curl_error($ch),
				'curl_errno' => curl_errno($ch)
			);

			$this->log($log_data, 'cURL failed');
			return false;
		}

		curl_close($ch);

		$response = $this->cleanReturn($response);

		$this->log($response, 'Response');

		return $response;
	}
}
