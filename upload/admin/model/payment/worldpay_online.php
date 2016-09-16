<?php
class ModelPaymentWorldpayOnline extends Model {

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "worldpay_online_order` (
				`worldpay_online_order_id` int(11) NOT NULL AUTO_INCREMENT,
				`order_id` int(11) NOT NULL,
				`order_code` varchar(50),
				`date_added` datetime NOT NULL,
				`date_modified` datetime NOT NULL,
				`refund_status` int(1) DEFAULT NULL,
				`currency_code` varchar(3) NOT NULL,
				`total` decimal(10, 2) NOT NULL,
				PRIMARY KEY (`worldpay_online_order_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "worldpay_online_order_transaction` (
				`worldpay_online_order_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
				`worldpay_online_order_id` int(11) NOT NULL,
				`date_added` datetime NOT NULL,
				`type` enum('payment', 'refund') DEFAULT NULL,
				`amount` decimal(10, 2) NOT NULL,
				PRIMARY KEY (`worldpay_online_order_transaction_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "worldpay_online_order_recurring` (
				`worldpay_online_order_recurring_id` int(11) NOT NULL AUTO_INCREMENT,
				`order_id` int(11) NOT NULL,
				`order_recurring_id` int(11) NOT NULL,
				`order_code` varchar(50),
				`token` varchar(50),
				`date_added` datetime NOT NULL,
				`date_modified` datetime NOT NULL,
				`next_payment` datetime NOT NULL,
				`trial_end` datetime DEFAULT NULL,
				`subscription_end` datetime DEFAULT NULL,
				`currency_code` varchar(3) NOT NULL,
				`total` decimal(10, 2) NOT NULL,
				PRIMARY KEY (`worldpay_online_order_recurring_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "worldpay_online_card` (
				`card_id` int(11) NOT NULL AUTO_INCREMENT,
				`customer_id` int(11) NOT NULL,
				`order_id` int(11) NOT NULL,
				`token` varchar(50) NOT NULL,
				`digits` varchar(22) NOT NULL,
				`expiry` varchar(5) NOT NULL,
				`type` varchar(50) NOT NULL,
				PRIMARY KEY (`card_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "worldpay_online_order`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "worldpay_online_order_transaction`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "worldpay_online_order_recurring`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "worldpay_online_card`;");
	}

	public function refund($order_id, $amount) {
		$worldpay_online_order = $this->getOrder($order_id);

		if (!empty($worldpay_online_order) && $worldpay_online_order['refund_status'] != 1) {
			$order['refundAmount'] = (int)($amount * 100);

			$url = $worldpay_online_order['order_code'] . '/refund';

			$response_data = $this->sendCurl($url, $order);

			return $response_data;
		} else {
			return false;
		}
	}

	public function updateRefundStatus($worldpay_online_order_id, $status) {
		$this->db->query("UPDATE " . DB_PREFIX . "worldpay_online_order SET refund_status = '" . (int)$status . "' WHERE worldpay_online_order_id = '" . (int)$worldpay_online_order_id . "'");
	}

	public function getOrder($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "worldpay_online_order WHERE order_id = '" . (int)$order_id . "' LIMIT 0,1");

		if ($query->num_rows) {
			$order = $query->row;
			$order['transactions'] = $this->getTransactions($order['worldpay_online_order_id'], $query->row['currency_code']);

			return $order;
		} else {
			return false;
		}
	}

	protected function getTransactions($worldpay_online_order_id, $currency_code) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "worldpay_online_order_transaction WHERE worldpay_online_order_id = '" . (int)$worldpay_online_order_id . "'");

		$transactions = array();

		if ($query->num_rows) {
			foreach ($query->rows as $row) {
				$row['amount'] = $this->currency->format($row['amount'], $currency_code, false);
				$transactions[] = $row;
			}
			return $transactions;
		} else {
			return false;
		}
	}

	public function addTransaction($worldpay_online_order_id, $type, $total) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "worldpay_online_order_transaction SET worldpay_online_order_id = '" . (int)$worldpay_online_order_id . "', date_added = NOW(), `type` = '" . $this->db->escape($type) . "', amount = '" . (double)$total . "'");
	}

	public function getTotalReleased($worldpay_online_order_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "worldpay_online_order_transaction WHERE worldpay_online_order_id = '" . (int)$worldpay_online_order_id . "' AND (`type` = 'payment' OR `type` = 'refund')");

		return (double)$query->row['total'];
	}

	public function getTotalRefunded($worldpay_online_order_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "worldpay_online_order_transaction WHERE worldpay_online_order_id = '" . (int)$worldpay_online_order_id . "' AND 'refund'");

		return (double)$query->row['total'];
	}

	public function sendCurl($url, $order) {
		$json = json_encode($order);

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, 'https://api.worldpay.com/v1/orders/' . $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: " . $this->config->get('worldpay_online_service_key'), "Content-Type: application/json", "Content-Length: " . strlen($json)));

		$result = json_decode(curl_exec($curl));

		curl_close($curl);

		$response = array();

		if (is_object($result)) {
			$response['status'] = $result->httpStatusCode;
			$response['message'] = $result->message;
			$response['full_details'] = $result;
		} else {
			$response['status'] = 'success';
		}

		return $response;
	}

	public function logger($message) {
		if ($this->config->get('worldpay_online_debug') == 1) {
			$log = new Log('worldpay_online.log');
			$log->write($message);
		}
	}
}
