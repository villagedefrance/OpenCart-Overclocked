<?php
class ModelDesignAdministration extends Model {

	public function addAdministration($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "administration SET name = '" . $this->db->escape($data['name']) . "', contrast = '" . $this->db->escape($data['contrast']) . "', date_added = NOW(), date_modified = NOW()");

		$administration_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_administration_id'] = $administration_id;

		$this->cache->delete('administration');
	}

	public function editAdministration($administration_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "administration SET name = '" . $this->db->escape($data['name']) . "', contrast = '" . $this->db->escape($data['contrast']) . "', date_modified = NOW() WHERE administration_id = '" . (int)$administration_id . "'");

		$this->cache->delete('administration');
	}

	public function deleteAdministration($administration_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "administration WHERE administration_id = '" . (int)$administration_id . "'");

		$this->cache->delete('administration');
	}

	public function getAdministration($administration_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "administration WHERE administration_id = '" . (int)$administration_id . "'");

		return $query->row;
	}

	public function getAdministrations($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "administration";

			$sql .= " ORDER BY name";

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;

		} else {
			$administration_data = $this->cache->get('administration');

			if (!$administration_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "administration ORDER BY name ASC");

				$administration_data = $query->rows;

				$this->cache->set('administration', $administration_data);
			}

			return $administration_data;
		}
	}

	public function getAdministrationContrastByName($name) {
		$query = $this->db->query("SELECT LCASE(contrast) AS contrast FROM " . DB_PREFIX . "administration WHERE `name` LIKE '%" . $this->db->escape($name) . "%'");

		return $query->row['contrast'];
	}

	public function getTotalAdministrations() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "administration");

		return $query->row['total'];
	}

	// Set default values if administration table is empty
	public function checkAdministrations() {
		$stylesheet_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "administration");

		if (!$stylesheet_query->rows) {
			$stylesheets = array('classic','overclock');

			foreach ($stylesheets as $stylesheet) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "administration` SET name = '" . $this->db->escape($stylesheet) . "', contrast = 'light', date_added = NOW(), date_modified = NOW()");
			}
		}
	}
}
