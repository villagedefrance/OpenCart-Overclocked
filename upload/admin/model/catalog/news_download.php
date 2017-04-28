<?php
class ModelCatalogNewsDownload extends Model {

	public function addDownload($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news_download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', date_added = NOW()");

		$news_download_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_news_download_id'] = $news_download_id;

		foreach ($data['news_download_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_download_description SET news_download_id = '" . (int)$news_download_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
	}

	public function editDownload($news_download_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "news_download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "' WHERE news_download_id = '" . (int)$news_download_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_download_description WHERE news_download_id = '" . (int)$news_download_id . "'");

		foreach ($data['news_download_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_download_description SET news_download_id = '" . (int)$news_download_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
	}

	public function deleteDownload($news_download_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_download WHERE news_download_id = '" . (int)$news_download_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_download_description WHERE news_download_id = '" . (int)$news_download_id . "'");
	}

	public function getDownload($news_download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news_download WHERE news_download_id = '" . (int)$news_download_id . "'");

		return $query->row;
	}

	public function getDownloads($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news_download nd LEFT JOIN " . DB_PREFIX . "news_download_description ndd ON (nd.news_download_id = ndd.news_download_id) WHERE ndd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'ndd.name'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY ndd.name";
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

	public function getDownloadDescriptions($news_download_id) {
		$news_download_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_download_description WHERE news_download_id = '" . (int)$news_download_id . "'");

		foreach ($query->rows as $result) {
			$news_download_description_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $news_download_description_data;
	}

	public function getTotalDownloads() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_download");

		return $query->row['total'];
	}

	public function getNewsDownloads($news_download_id) {
		$news_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_download WHERE news_download_id = '" . (int)$news_download_id . "'");

		foreach ($query->rows as $result) {
			$news_download_data[] = $result['news_id'];
		}

		return $news_download_data;
	}
}
