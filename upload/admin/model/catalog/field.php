<?php
class ModelCatalogField extends Model {

	public function addField($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "field` SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "'");

		$field_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_field_id'] = $field_id;

		foreach ($data['field_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "field_description SET field_id = '" . (int)$field_id . "', language_id = '" . (int)$language_id . "', `title` = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->cache->delete('field');
	}

	public function editField($field_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "field` SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE field_id = '" . (int)$field_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "field_description WHERE field_id = '" . (int)$field_id . "'");

		foreach ($data['field_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "field_description SET field_id = '" . (int)$field_id . "', language_id = '" . (int)$language_id . "', `title` = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->cache->delete('field');
	}

	public function editFieldStatus($field_id, $status) {
        $this->db->query("UPDATE `" . DB_PREFIX . "field` SET status = '" . (int)$status . "' WHERE field_id = '" . (int)$field_id . "'");

		$this->cache->delete('field');
    }

	public function deleteField($field_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "field WHERE field_id = '" . (int)$field_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "field_description WHERE field_id = '" . (int)$field_id . "'");

		$this->cache->delete('field');
	}

	public function getField($field_id) {
		$query = $this->db->query("SELECT DISTINCT *, fd.title AS title FROM " . DB_PREFIX . "field f LEFT JOIN " . DB_PREFIX . "field_description fd ON (f.field_id = fd.field_id) WHERE f.field_id = '" . (int)$field_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getFields($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM `" . DB_PREFIX . "field` f LEFT JOIN " . DB_PREFIX . "field_description fd ON (f.field_id = fd.field_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			if (!empty($data['filter_title'])) {
				$sql .= " AND fd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
			}

			$sort_data = array(
				'fd.title',
				'f.sort_order',
				'f.status'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY fd.title";
			}

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
			$field_data = $this->cache->get('field.' . (int)$this->config->get('config_language_id'));

			if (!$field_data) {
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "field` f LEFT JOIN " . DB_PREFIX . "field_description fd ON (f.field_id = fd.field_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY fd.title");

				$field_data = $query->rows;

				$this->cache->set('field.' . (int)$this->config->get('config_language_id'), $field_data);
			}

			return $field_data;
		}
	}

	public function getFieldPages() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "field` f LEFT JOIN " . DB_PREFIX . "field_description fd ON (f.field_id = fd.field_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND f.status = '1' ORDER BY f.sort_order, LCASE(fd.title) ASC");

		return $query->rows;
	}

	public function getFieldDescriptions($field_id) {
		$field_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "field_description WHERE field_id = '" . (int)$field_id . "'");

		foreach ($query->rows as $result) {
			$field_description_data[$result['language_id']] = array(
				'title'       => $result['title'],
				'description' => $result['description']
			);
		}

		return $field_description_data;
	}

	public function getTotalFields() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "field`");

		return $query->row['total'];
	}
}
