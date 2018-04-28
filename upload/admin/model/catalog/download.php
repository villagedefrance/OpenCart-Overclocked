<?php
class ModelCatalogDownload extends Model {

	public function addDownload($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', remaining = '" . (int)$data['remaining'] . "', date_added = NOW()");

		$download_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_download_id'] = $download_id;

		foreach ($data['download_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id . "', language_id = '" . (int)$language_id . "', `name` = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('download');
	}

	public function editDownload($download_id, $data) {
		if (!empty($data['update'])) {
			$download_info = $this->getDownload($download_id);

			if ($download_info) {
				$this->db->query("UPDATE " . DB_PREFIX . "order_download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', remaining = '" . (int)$data['remaining'] . "' WHERE filename = '" . $this->db->escape($download_info['filename']) . "'");
			}
		}

		$this->db->query("UPDATE " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', remaining = '" . (int)$data['remaining'] . "' WHERE download_id = '" . (int)$download_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");

		foreach ($data['download_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id . "', language_id = '" . (int)$language_id . "', `name` = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('download');
	}

	public function deleteDownload($download_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");

		$this->cache->delete('download');
	}

	public function getDownload($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id = '" . (int)$download_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getDownloads($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'dd.name',
			'd.remaining'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY dd.name";
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
	}

	public function getDownloadDescriptions($download_id) {
		$download_description_data = $this->cache->get('download.' . (int)$this->config->get('config_language_id'));

		if (!$download_description_data) {
			$download_description_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");

			foreach ($query->rows as $result) {
				$download_description_data[$result['language_id']] = array('name' => $result['name']);
			}

			$this->cache->set('download.' . (int)$this->config->get('config_language_id'), $download_description_data);
		}

		return $download_description_data;
	}

	public function getDownloadName($download_id) {
		$query = $this->db->query("SELECT DISTINCT dd.name AS `name` FROM " . DB_PREFIX . "download_description dd LEFT JOIN " . DB_PREFIX . "download d ON (d.download_id = dd.download_id) WHERE dd.download_id = '" . (int)$download_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['name'];
	}

	public function getDownloadImage($download_id) {
		$query = $this->db->query("SELECT filename FROM " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "'");

		$filename = $query->row['filename'];

		$ext = utf8_substr(strrchr($filename, '.'), 1);

		$available_mimes = array('zip', 'pdf', 'swf', 'flv', 'mp3', 'mp4', 'oga', 'ogv', 'ogg', 'webm', 'm4a', 'm4v', 'wav', 'wmv', 'wma');

		if (in_array(strtolower($ext), $available_mimes)) {
			$image = strtolower($ext) . '.png';
		} else {
			$image = 'no_file.jpg';
		}

		return $image;
	}

	public function getTotalDownloads($data = array()) {
		$sql = "SELECT COUNT(DISTINCT d.download_id) AS total FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id)";

		$sql .= " WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}
