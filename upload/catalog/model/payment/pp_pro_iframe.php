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
		$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_iframe_order SET order_id = '" . (int)$order_data['order_id'] . "', created = NOW(), modified = NOW(), capture_status = '" . $this->db->escape($order_data['capture_status']) . "', currency_code = '" . $this->db->escape($order_data['currency_code']) . "', total = '" . (double)$order_data['total'] . "', authorization_id = '" . $this->db->escape($order_data['authorization_id']) . "'");

		return $this->db->getLastId();
	}

	public function addTransaction($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "paypal_iframe_order_transaction SET paypal_iframe_order_id = '" . (int)$data['paypal_iframe_order_id'] . "', transaction_id = '" . $this->db->escape($data['transaction_id']) . "', parent_transaction_id = '" . $this->db->escape($data['parent_transaction_id']) . "', created = NOW(), note = '" . $this->db->escape($data['note']) . "', msgsubid = '" . $this->db->escape($data['msgsubid']) . "', receipt_id = '" . $this->db->escape($data['receipt_id']) . "', payment_type = '" . $this->db->escape($data['payment_type']) . "', payment_status = '" . $this->db->escape($data['payment_status']) . "', pending_reason = '" . $this->db->escape($data['pending_reason']) . "', transaction_entity = '" . $this->db->escape($data['transaction_entity']) . "', amount = '" . (double)$data['amount'] . "', debug_data = '" . $this->db->escape($data['debug_data']) . "'");
	}

	public function log($data, $title = null) {
		if ($this->config->get('pp_pro_iframe_debug')) {
			$log = new Log('pp_pro_iframe.log');
			$log->write('PayPal Pro iFrame debug (' . $title . '): ' . json_encode($data));
		}
	}
}
