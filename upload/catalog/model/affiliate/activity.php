<?php
class ModelAffiliateActivity extends Model {

	public function addActivity($affiliate_id, $key, $name) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_activity SET affiliate_id = '" . (isset($affiliate_id) ? (int)$affiliate_id : 0) . "', `key` = '" . $this->db->escape($key) . "', name = '" . $this->db->escape($name) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
	}
}
?>