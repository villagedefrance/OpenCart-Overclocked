<?php
class ModelPaymentPPProIframe extends Model {

	public function getMethod($address, $total) {
		$this->load->language('payment/pp_pro_iframe');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pp_pro_iframe_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('pp_pro_iframe_total') > 0 && $this->config->get('pp_pro_iframe_total') > $total) {
			$status = false;
		} elseif ($this->config->has('pp_pro_iframe_total_max') && $this->config->get('pp_pro_iframe_total_max') > 0 && $total > $this->config->get('pp_pro_iframe_total_max')) {
			$status = false;
		} elseif (!$this->config->get('pp_pro_iframe_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'pp_pro_iframe',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('pp_pro_iframe_sort_order')
			);
		}

		return $method_data;
	}

	public function addOrder($order_data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_iframe_order SET "
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
		. "debug_data = '" . (isset($transaction_data['debug_data']) ? $this->db->escape($transaction_data['debug_data']) : null) . "'");

		return $this->db->getLastId();
	}

	public function log($data, $title = null, $force = false) {
		if ($this->config->get('pp_pro_iframe_debug') || $force) {
			$log = new Log('pp_pro_iframe.log');
			$log->write('PayPal Pro iFrame debug (' . $title . '): ' . json_encode($data));
		}
	}
}
