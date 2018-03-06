<?php
class ModelPaymentPPExpress extends Model {

	public function getMethod($address, $total) {
		$this->language->load('payment/pp_express');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pp_express_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('pp_express_total') > 0 && $this->config->get('pp_express_total') > $total) {
			$status = false;
		} elseif ($this->config->has('pp_express_total_max') && $this->config->get('pp_express_total_max') > 0 && $total > $this->config->get('pp_express_total_max')) {
			$status = false;
		} elseif (!$this->config->get('pp_express_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'pp_express',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('pp_express_sort_order')
			);
		}

		return $method_data;
	}

	public function addOrder($order_data) {
		// 1 to 1 relationship with order table (extends order info)
		$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_order SET "
		. "order_id = " . (isset($order_data['order_id']) ? (int)$order_data['order_id'] : 0) . ", "
		. "created = NOW(), "
		. "modified = NOW(), "
		. "capture_status = '" . (isset($order_data['capture_status']) ? $this->db->escape($order_data['capture_status']) : null) . "', "
		. "currency_code = '" . (isset($order_data['currency_code']) ? $this->db->escape($order_data['currency_code']) : null) . "', "
		. "total = " . (isset($order_data['total']) ? (double)$order_data['total'] : 0.0) . ", "
		. "authorization_id = '" . (isset($order_data['authorization_id']) ? $this->db->escape($order_data['authorization_id']) : null) . "'");

		return $this->db->getLastId();
	}

	public function addTransaction($transaction_data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_order_transaction SET "
		. "paypal_order_id = " . (isset($transaction_data['paypal_order_id']) ? (int)$transaction_data['paypal_order_id'] : 0) . ", "
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
		. "debug_data = '" . (isset($transaction_data['debug_data']) ? $this->db->escape($transaction_data['debug_data']) : null) . "'");
	}

	public function paymentRequestInfo() {
		$data['PAYMENTREQUEST_0_SHIPPINGAMT'] = '';
		$data['PAYMENTREQUEST_0_CURRENCYCODE'] = $this->currency->getCode();
		$data['PAYMENTREQUEST_0_PAYMENTACTION'] = $this->config->get('pp_express_transaction_method');

		$i = 0;
		$item_total = 0;

		foreach ($this->cart->getProducts() as $item) {
			$data['L_PAYMENTREQUEST_0_DESC' . $i] = '';

			$option_count = 0;

			foreach ($item['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['option_value'];
				} else {
					$filename = $this->encryption->decrypt($option['option_value']);
					$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
				}

				$data['L_PAYMENTREQUEST_0_DESC' . $i] .= ($option_count > 0 ? ', ' : '') . $option['name'] . ':' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value);

				$option_count++;
			}

			$data['L_PAYMENTREQUEST_0_DESC' . $i] = substr($data['L_PAYMENTREQUEST_0_DESC' . $i], 0, 126);

			$item_price = $this->currency->format($item['price'], false, false, false);

			$data['L_PAYMENTREQUEST_0_NAME' . $i] = $item['name'];
			$data['L_PAYMENTREQUEST_0_NUMBER' . $i] = $item['model'];
			$data['L_PAYMENTREQUEST_0_AMT' . $i] = $item_price;

			$item_total += number_format($item_price * $item['quantity'], 2, '.', '');

			$data['L_PAYMENTREQUEST_0_QTY' . $i] = $item['quantity'];
			$data['L_PAYMENTREQUEST_0_ITEMURL' . $i] = $this->url->link('product/product', 'product_id=' . $item['product_id'], 'SSL');

			if ($this->config->get('config_cart_weight')) {
				$weight = $this->weight->convert($item['weight'], $item['weight_class_id'], $this->config->get('config_weight_class_id'));

				$data['L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE' . $i] = number_format($weight / $item['quantity'], 2, '.', '');
				$data['L_PAYMENTREQUEST_0_ITEMWEIGHTUNIT' . $i] = $this->weight->getUnit($this->config->get('config_weight_class_id'));
			}

			if ($item['length'] > 0 || $item['width'] > 0 || $item['height'] > 0) {
				$unit = $this->length->getUnit($item['length_class_id']);

				$data['L_PAYMENTREQUEST_0_ITEMLENGTHVALUE' . $i] = $item['length'];
				$data['L_PAYMENTREQUEST_0_ITEMLENGTHUNIT' . $i] = $unit;
				$data['L_PAYMENTREQUEST_0_ITEMWIDTHVALUE' . $i] = $item['width'];
				$data['L_PAYMENTREQUEST_0_ITEMWIDTHUNIT' . $i] = $unit;
				$data['L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE' . $i] = $item['height'];
				$data['L_PAYMENTREQUEST_0_ITEMHEIGHTUNIT' . $i] = $unit;
			}

			$i++;
		}

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$item_total += $this->currency->format($voucher['amount'], false, false, false);

				$data['L_PAYMENTREQUEST_0_DESC' . $i] = '';
				$data['L_PAYMENTREQUEST_0_NAME' . $i] = $voucher['description'];
				$data['L_PAYMENTREQUEST_0_NUMBER' . $i] = 'VOUCHER';
				$data['L_PAYMENTREQUEST_0_QTY' . $i] = 1;
				$data['L_PAYMENTREQUEST_0_AMT' . $i] = $this->currency->format($voucher['amount'], false, false, false);

				$i++;
			}
		}

		// Totals
		$this->load->model('setting/extension');

		$total_data = array();
		$taxes = $this->cart->getTaxes();
		$total = 0;

		// Display prices
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			$results = $this->model_setting_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}
		}

		foreach ($total_data as $total_row) {
			if (!in_array($total_row['code'], array('total', 'sub_total'))) {
				if ($total_row['value'] != 0) {
					$item_price = $this->currency->format($total_row['value'], false, false, false);

					$data['L_PAYMENTREQUEST_0_NUMBER' . $i] = $total_row['code'];
					$data['L_PAYMENTREQUEST_0_NAME' . $i] = $total_row['title'];
					$data['L_PAYMENTREQUEST_0_AMT' . $i] = $this->currency->format($total_row['value'], false, false, false);
					$data['L_PAYMENTREQUEST_0_QTY' . $i] = 1;

					$item_total = $item_total + $item_price;
					$i++;
				}
			}
		}

		$data['PAYMENTREQUEST_0_ITEMAMT'] = number_format($item_total, 2, '.', '');
		$data['PAYMENTREQUEST_0_AMT'] = number_format($item_total, 2, '.', '');

		$z = 0;

		$recurring_products = $this->cart->getRecurringProducts();

		if (!empty($recurring_products)) {
			$this->language->load('payment/pp_express');

			foreach ($recurring_products as $item) {
				$data['L_BILLINGTYPE' . $z] = 'RecurringPayments';

				if ($item['recurring_trial'] == 1) {
					$trial_amt = $this->currency->format($this->tax->calculate($item['recurring_trial_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity'] . ' ' . $this->currency->getCode();

					$trial_text =  sprintf($this->language->get('text_trial'), $trial_amt, $item['recurring_trial_cycle'], $item['recurring_trial_frequency'], $item['recurring_trial_duration']);
				} else {
					$trial_text = '';
				}

				$recurring_amt = $this->currency->format($this->tax->calculate($item['recurring_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false)  * $item['quantity'] . ' ' . $this->currency->getCode();

				$recurring_description = $trial_text . sprintf($this->language->get('text_recurring'), $recurring_amt, $item['recurring_cycle'], $item['recurring_frequency']);

				if ($item['recurring_duration'] > 0) {
					$recurring_description .= sprintf($this->language->get('text_length'), $item['recurring_duration']);
				}

				$data['L_BILLINGAGREEMENTDESCRIPTION' . $z] = $recurring_description;

				$z++;
			}
		}

		return $data;
	}

	public function getTotalCaptured($paypal_order_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "paypal_order_transaction WHERE paypal_order_id = '" . (int)$paypal_order_id . "' AND pending_reason != 'authorization' AND pending_reason != 'paymentreview' AND (payment_status = 'Partially-Refunded' OR payment_status = 'Completed' OR payment_status = 'Pending') AND transaction_entity = 'payment'");

		return $query->row['total'];
	}

	public function getTotalRefunded($paypal_order_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "paypal_order_transaction WHERE paypal_order_id = '" . (int)$paypal_order_id . "' AND payment_status = 'Refunded'");

		return $query->row['total'];
	}

	public function getTransactionRow($transaction_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paypal_order_transaction pt LEFT JOIN " . DB_PREFIX . "paypal_order po ON (pt.paypal_order_id = po.paypal_order_id) WHERE pt.transaction_id = '" . $this->db->escape($transaction_id) . "' LIMIT 0,1");

		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateTransactionStatus($transaction_id, $transaction_status) {
		$this->db->query("UPDATE " . DB_PREFIX . "paypal_order_transaction SET payment_status = '" . $this->db->escape($transaction_status) . "' WHERE transaction_id = '" . $this->db->escape($transaction_id) . "' LIMIT 0,1");
	}

	public function updateTransactionPendingReason($transaction_id, $pending_reason) {
		$this->db->query("UPDATE " . DB_PREFIX . "paypal_order_transaction SET pending_reason = '" . $this->db->escape($pending_reason) . "' WHERE transaction_id = '" . $this->db->escape($transaction_id) . "' LIMIT 0,1");
	}

	public function updateOrder($capture_status, $order_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "paypal_order SET modified = NOW(), capture_status = '" . $this->db->escape($capture_status) . "' WHERE order_id = '" . (int)$order_id . "'");
	}

	public function call($data) {
		if ($this->config->get('pp_express_test') == 1) {
			$api_endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
			$user = $this->config->get('pp_express_sandbox_username');
			$password = $this->config->get('pp_express_sandbox_password');
			$signature = $this->config->get('pp_express_sandbox_signature');
		} else {
			$api_endpoint = 'https://api-3t.paypal.com/nvp';
			$user = $this->config->get('pp_express_username');
			$password = $this->config->get('pp_express_password');
			$signature = $this->config->get('pp_express_signature');
		}

		$default_parameters = array(
			'USER'         => $user,
			'PWD'          => $password,
			'SIGNATURE'    => $signature,
			'VERSION'      => '109.0',
			'BUTTONSOURCE' => 'OpenCart_Cart_EC'
		);

		$call_parameters = array_merge($data, $default_parameters);

		$this->log($call_parameters, 'Call data');

		$options = array(
			CURLOPT_POST           => true,
			CURLOPT_HEADER         => false,
			CURLOPT_URL            => $api_endpoint,
			CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1",
			CURLOPT_FRESH_CONNECT  => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FORBID_REUSE   => true,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_POSTFIELDS     => http_build_query($call_parameters, '', '&')
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

	public function recurringPayments() {
		/*
		 * Used by the checkout to state the module
		 * supports recurring recurrings.
		 */
		return true;
	}

	public function createToken($len = 32) {
		$base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
		$max = strlen($base)-1;
		$activate_code = '';
		mt_srand((double)microtime() * 1000000);

		while (strlen($activate_code) < $len + 1) {
			$activate_code .= $base{mt_rand(0, $max)};
		}

		return $activate_code;
	}

	public function log($data, $title = null, $force = false) {
		if ($this->config->get('pp_express_debug') || $force) {
			$this->log->write('PayPal Express debug (' . $title . '): ' . json_encode($data));
		}
	}

	public function cleanReturn($data) {
		$data = explode('&', $data);

		$arr = array();

		foreach ($data as $k => $v) {
			$tmp = explode('=', $v);
			$arr[$tmp[0]] = isset($tmp[1]) ? urldecode($tmp[1]) : '';
		}

		return $arr;
	}

	public function recurringCancel($reference) {
		$data = array(
			'METHOD'    => 'ManageRecurringPaymentsProfileStatus',
			'PROFILEID' => $reference,
			'ACTION'    => 'Cancel'
		);

		return $this->call($data);
	}

	public function isMobile() {
		// This will check the user agent and "try" to match if it is a mobile device
		if (preg_match("/Mobile|Android|BlackBerry|iPhone|Windows Phone/", $this->request->server['HTTP_USER_AGENT'])) {
			return true;
		} else {
			return false;
		}
	}
}
