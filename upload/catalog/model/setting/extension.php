<?php
class ModelSettingExtension extends Model {

	public function getExtensions($type) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "' ORDER BY code");

		return $query->rows;
	}
}
