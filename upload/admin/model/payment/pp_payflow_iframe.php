<?php
class ModelPaymentPPPayflowIframe extends Model {

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "paypal_payflow_iframe_order` (
			`order_id` int(11) NOT NULL DEFAULT 0,
			`secure_token_id` varchar(255) NOT NULL,
			`complete` tinyint(1) NOT NULL DEFAULT 0,
			`currency_code` char(3) NOT NULL,
			`date_added` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
			`date_modified` datetime NOT NULL,
			PRIMARY KEY(`order_id`),
			KEY `secure_token_id` (`secure_token_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "paypal_payflow_iframe_order_transaction` (
			`order_id` int(11) NOT NULL,
			`transaction_reference` varchar(255) NOT NULL,
			`parent_transaction_reference` varchar(255) DEFAULT NULL,
			`void_transaction_reference` varchar(255) DEFAULT NULL,
			`transaction_type` char(1) NOT NULL,
			`amount` decimal(15,2) DEFAULT NULL,
			`date_added` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
			`date_modified` datetime NOT NULL,
			PRIMARY KEY (`transaction_reference`),
			KEY `order_id` (`order_id`),
			KEY `parent_transaction_reference` (`parent_transaction_reference`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "paypal_payflow_iframe_order`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "paypal_payflow_iframe_order_transaction`;");
	}

	public function getPaypalOrderByOrderId($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "paypal_payflow_iframe_order` WHERE order_id = " . (int)$order_id);

		return (($query instanceof stdClass) && isset($query->row) && is_array($query->row)) ? $query->row : false;
	}

	public function getPaypalOrderBySecureTokenId($secure_token_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "paypal_payflow_iframe_order` WHERE secure_token_id = '" . $this->db->escape($secure_token_id) . "'");

		return (($query instanceof stdClass) && isset($query->row) && is_array($query->row)) ? $query->row : false;
	}

	public function addPaypalOrder($data) {
		if (is_array($data) && !empty($data)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_payflow_iframe_order SET "
			. "order_id = " . (isset($data['order_id']) ? (int)$data['order_id'] : 0) . ", "
			. (isset($data['secure_token_id']) ? "secure_token_id = '" . $this->db->escape($data['secure_token_id']) . "', " : null)
			. (isset($data['complete']) ? "complete = " . (int)$data['complete'] . ", " : null)
			. (isset($data['currency_code']) ? "currency_code = '" . $this->db->escape($data['currency_code']) . "', " : null)
			. "date_added = NOW(), date_modified = NOW()");

			return $this->db->getLastId();
		} else {
			return false;
		}
	}

	public function editPaypalOrderByOrderId($order_id, $data) {
		if (is_array($data) && !empty($data)) {
			$result = $this->db->query("UPDATE " . DB_PREFIX . "paypal_payflow_iframe_order SET "
			. (isset($data['secure_token_id']) ? "secure_token_id = '" . $this->db->escape($data['secure_token_id']) . "', " : null)
			. (isset($data['complete']) ? "complete = " . (int)$data['complete'] . ", " : null)
			. (isset($data['currency_code']) ? "currency_code = '" . $this->db->escape($data['currency_code']) . "', " : null)
			. "date_modified = NOW()"
			. " WHERE order_id = " . (int)$order_id);

			return $result;
		} else {
			return false;
		}
	}

	public function setPaypalOrderComplete($order_id, $complete) {
		return (self::editPaypalOrderByOrderId($order_id, array('complete' => $complete)));
	}

	public function addPaypalTransaction($data) {
		if (is_array($data) && !empty($data)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_payflow_iframe_order_transaction SET "
			. "order_id = " . (isset($data['order_id']) ? (int)$data['order_id'] : 0) . ", "
			. "transaction_reference = '" . (isset($data['transaction_reference']) ? $this->db->escape($data['transaction_reference']) : null) . "', "
			. (isset($data['parent_transaction_reference']) ? "parent_transaction_reference = '" . $this->db->escape($data['parent_transaction_reference']) . "', " : null)
			. (isset($data['void_transaction_reference']) ? "void_transaction_reference = '" . $this->db->escape($data['void_transaction_reference']) . "', " : null)
			. (isset($data['transaction_type']) ? "transaction_type = '" . $this->db->escape($data['transaction_type']) . "', " : null)
			. (isset($data['amount']) ? "amount = " . (double)$data['amount'] . ", " : null)
			. "date_added = NOW(), date_modified = NOW()");

			return $this->db->getLastId();
		} else {
			return false;
		}
	}

	public function editPaypalTransactionByReference($transaction_reference, $data) {
		if (is_array($data) && !empty($data)) {
			$result = $this->db->query("UPDATE " . DB_PREFIX . "paypal_payflow_iframe_order_transaction SET "
			. (isset($data['order_id']) ? "order_id = " . (int)$data['order_id'] . ", " : null)
			. (isset($data['parent_transaction_reference']) ? "parent_transaction_reference = '" . $this->db->escape($data['parent_transaction_reference']) . "', " : null)
			. (isset($data['void_transaction_reference']) ? "void_transaction_reference = '" . $this->db->escape($data['void_transaction_reference']) . "', " : null)
			. (isset($data['transaction_type']) ? "transaction_type = '" . $this->db->escape($data['transaction_type']) . "', " : null)
			. (isset($data['amount']) ? "amount = " . (double)$data['amount'] . ", " : null)
			. "date_modified = NOW() WHERE transaction_reference = '" . $this->db->escape($transaction_reference) . "'");

			return $result;
		} else {
			return false;
		}
	}

	public function getPaypalCapturesByParentReference($ref) {
		$captures = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE parent_transaction_reference = '" . $this->db->escape($ref) . "' AND transaction_type = 'D' ORDER BY `date_added` ASC");

		if (($query instanceof stdClass) && $query->num_rows) {
			foreach ($query->rows as $row) {
				$captures[] = $row;
			}
		}

		return $captures;
	}

	public function getPaypalRefundsByParentReference($ref) {
		$refunds = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE parent_transaction_reference = '" . $this->db->escape($ref) . "' AND transaction_type = 'C' ORDER BY `date_added` ASC");

		if (($query instanceof stdClass) && $query->num_rows) {
			foreach ($query->rows as $row) {
				$refunds[] = $row;
			}
		}

		return $refunds;
	}

	public function getPaypalTransactionsByParentReference($ref) {
		$transactions = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE parent_transaction_reference = '" . $this->db->escape($ref) . "' ORDER BY `date_added` ASC");

		if (($query instanceof stdClass) && $query->num_rows) {
			foreach ($query->rows as $row) {
				$transactions[] = $row;
			}
		}

		return $transactions;
	}

	public function getPaypalTransactionsByOrderId($order_id) {
		$transactions = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE order_id = " . (int)$order_id . " ORDER BY `date_added` ASC");

		if (($query instanceof stdClass) && $query->num_rows) {
			foreach ($query->rows as $row) {
				$transactions[] = $row;
			}
		}

		return $transactions;
	}

	public function getPaypalTransactionByReference($ref) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE transaction_reference = '" . $this->db->escape($ref) . "'");

		if (($query instanceof stdClass) && $query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getPaypalRootTransactionByOrderId($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE order_id = " . (int)$order_id . " AND (parent_transaction_reference = '' OR parent_transaction_reference IS NULL) ORDER BY `date_added` ASC");

		if (($query instanceof stdClass) && $query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getPaypalLastAuthorizationByOrderId($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE order_id = " . (int)$order_id . " AND (transaction_type = 'A' OR transaction_type = 'F') AND (void_transaction_reference = '' OR void_transaction_reference IS NULL) ORDER BY `date_added` ASC");

		if (($query instanceof stdClass) && $query->num_rows) {
			return $query->rows[$query->num_rows - 1];
		} else {
			return false;
		}
	}

	public function getTotalCaptured($order_id) {
		$total = 0;

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE order_id = " . (int)$order_id . " AND transaction_type = 'D'");

		if (($query instanceof stdClass) && $query->num_rows) {
			foreach ($query->rows as $row) {
				if (empty($row['void_transaction_reference'])) {
					$total += $row['amount'];
				}
			}
		}

		return $total;
	}

	public function getTotalRefunded($order_id) {
		$total = 0;

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_payflow_iframe_order_transaction WHERE order_id = " . (int)$order_id . " AND transaction_type = 'C'");

		if (($query instanceof stdClass) && $query->num_rows) {
			foreach ($query->rows as $row) {
				if (empty($row['void_transaction_reference'])) {
					$total += $row['amount'];
				}
			}
		}

		return $total;
	}

	public function log($data, $title = null, $force = false) {
		if ($this->config->get('pp_payflow_iframe_debug') || $force) {
			$log = new Log('pp_payflow_iframe.log');
			$log->write('PayPal Payflow iFrame debug (' . $title . '): ' . json_encode($data));
		}
	}

	public function call($data) {
		if ($this->config->get('pp_payflow_iframe_test')) {
			$host = 'pilot-payflowpro.paypal.com';
		} else {
			$host = 'payflowpro.paypal.com';
		}

		$user_parameters = array(
			'USER'         => html_entity_decode($this->config->get('pp_payflow_iframe_username'), ENT_QUOTES, 'UTF-8'),
			'VENDOR'       => html_entity_decode($this->config->get('pp_payflow_iframe_vendor'), ENT_QUOTES, 'UTF-8'),
			'PWD'          => html_entity_decode($this->config->get('pp_payflow_iframe_password'), ENT_QUOTES, 'UTF-8'),
			'PARTNER'      => html_entity_decode($this->config->get('pp_payflow_iframe_partner'), ENT_QUOTES, 'UTF-8'),
			'BUTTONSOURCE' => 'OpenCart_Cart_PFP' // (Optional) Identification code for use by third-party applications to identify transactions.
		);

		$call_parameters = array_merge($data, $user_parameters);

		$this->log($call_parameters, 'Call data');

		// NVP format with length
		$call_parameters_with_length = array();

		foreach ($call_parameters as $key => $value) {
			$call_parameters_with_length[] = $key . '[' . strlen($value) . ']=' . $value;
		}

		$post_fields = implode('&', $call_parameters_with_length);

		$timeout = $this->config->has('pp_payflow_iframe_timeout') ? $this->config->get('pp_payflow_iframe_timeout') : 30;

		// Standard HTTP Headers
		$headers = array();
		$headers[] = 'Content-Type: text/name value';
		$headers[] = 'Content-Length: ' . strlen($post_fields);
		$headers[] = 'Host: ' . $host;
		// Payflow Message Protocol Headers
		$headers[] = 'X-VPS-REQUEST-ID: ' . md5($post_fields . time());  // Unique ID to prevent duplicate requests. Append time to separate between multiple errors/requests on same shopping cart checkout attempt
		$headers[] = 'X-VPS-CLIENT-TIMEOUT: ' . $timeout;  // Should be less than cURL timeout.
		// Optional Headers
		$headers[] = 'X-VPS-VIT-INTEGRATION-PRODUCT: OpenCart Overclocked with PPPayflowIframe Extension';

		$options = array(
			CURLOPT_URL            => 'https://' . $host,
			CURLOPT_PORT           => 443,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_POST           => true,
			CURLOPT_USERAGENT      => $_SERVER['HTTP_USER_AGENT'],
			CURLOPT_HEADER         => false, // Tells curl to not include headers in response
			CURLOPT_RETURNTRANSFER => true, // Return into a variable
			CURLOPT_TIMEOUT        => $timeout + 1,
			CURLOPT_SSL_VERIFYPEER => false, // This line makes it work under https
			CURLOPT_POSTFIELDS     =>  $post_fields
		);

		$ch = curl_init();

		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);

		if (curl_errno($ch) != CURLE_OK) {
			$log_data = array(
				'curl_errno' => curl_errno($ch),
				'curl_error' => curl_error($ch)
			);

			$this->log($log_data, 'cURL failed');
			return false;
		}

		curl_close($ch);

		$response_data = $this->parse_payflow_string($response);

		$this->log($response_data, 'Response');

		return $response_data;
	}

	// Parses a response string from Payflow and returns an associative array of response parameters.
	private function parse_payflow_string($str) {
		$workstr = $str;
		$out = array();

		while (strlen($workstr) > 0) {
			$loc = strpos($workstr, '=');

			if ($loc === false) {
				// Truncate the rest of the string, it's not valid
				$workstr = '';
				continue;
			}

			$substr = substr($workstr, 0, $loc);
			$workstr = substr($workstr, $loc + 1); // "+1" because we need to get rid of the "="

			if (preg_match('/^(\w+)\[(\d+)]$/', $substr, $matches)) {
				// This one has a length tag with it. Read the number of characters specified by $matches[2].
				$count = intval($matches[2]);

				$out[$matches[1]] = substr($workstr, 0, $count);
				$workstr = substr($workstr, $count + 1); // "+1" because we need to get rid of the "&"
			} else {
				// Read up to the next "&"
				$count = strpos($workstr, '&');

				if ($count === false) { // No more "&"'s, read up to the end of the string
					$out[$substr] = $workstr;
					$workstr = '';
				} else {
					$out[$substr] = substr($workstr, 0, $count);
					$workstr = substr($workstr, $count + 1); // "+1" because we need to get rid of the "&"
				}
			}
		}

		return $out;
	}
}
