<?php
class ModelToolOnline extends Model {

	public function whosonline($ip, $customer_id, $url, $referer, $user_agent) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_online WHERE date_added < '" . date('Y-m-d H:i:s', strtotime('-1 hour')) . "'");

		$this->db->query("REPLACE INTO " . DB_PREFIX . "customer_online SET ip = '" . $ip . "', customer_id = '" . (int)$customer_id . "', url = '" . $this->db->escape($url) . "', referer = '" . $this->db->escape($referer) . "', user_agent = '" . $this->db->escape($user_agent) . "', date_added = NOW()");
	}

	// Ban
	public function isBlockedIp($ip) {
		$status = false;

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "block_ip WHERE INET_ATON('" . $ip . "') BETWEEN INET_ATON(from_ip) AND INET_ATON(to_ip)");

		if ($query->num_rows) {
			$status = true;
		}

		return $status;
	}
}
?>
