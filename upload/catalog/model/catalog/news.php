<?php
class ModelCatalogNews extends Model {

	public function updateViewed($news_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "news` SET viewed = (viewed + 1) WHERE news_id = '" . (int)$news_id . "'");

		$this->cache->delete('news_all');
	}

	public function getNewsStory($news_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "news` n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1'");

		return $query->row;
	}

	public function getNews($data = array()) {
		$sql = "SELECT *, nd.title AS title FROM `" . DB_PREFIX . "news` n LEFT JOIN " . DB_PREFIX . "news_description nd ON (nd.news_id = n.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n2s.news_id = n.news_id) WHERE n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1'";

		$sort_data = array(
			'nd.title',
			'nd.description',
			'n.date_added',
			'n.sort_order',
			'n.viewed'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY n.date_added";
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

	public function getNewsShort($limit) {
		$news_data = $this->cache->get('news_short.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$limit);

		if (!$news_data) {
			$news_data = array();

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news` n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1'  GROUP BY n.date_added ORDER BY n.date_added DESC, n.sort_order ASC LIMIT 0," . (int)$limit);

			foreach ($query->rows as $result) {
				$news_data[$result['news_id']] = $this->getNewsStory($result['news_id']);
			}

			$this->cache->set('news_short.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$limit, $news_data);
		}

		return $news_data;
	}

	public function getNewsAll() {
		$news_data = $this->cache->get('news_all.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));

		if (!$news_data) {
			$news_data = array();

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news` n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1'  GROUP BY n.date_added ORDER BY n.date_added DESC, n.sort_order ASC");

			foreach ($query->rows as $result) {
				$news_data[$result['news_id']] = $this->getNewsStory($result['news_id']);
			}

			$this->cache->set('news_all.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $news_data);
		}

		return $news_data;
	}

	public function getTotalNews() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "news` n LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) WHERE n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1'");

		return $query->row['total'];
	}

	// Related
	public function getNewsProductRelated($news_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_product_related` WHERE news_id = '" . (int)$news_id . "'");

		return $query->rows;
	}

	// Download
	public function getDownloads() {
		$news_download_data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_download`");

		foreach ($query->rows as $result) {
			$news_download_data[] = array(
				'news_download_id' => $result['news_download_id'],
				'filename'         => $result['filename'],
				'mask'             => $result['mask'],
				'date_added'       => $result['date_added']
			);
		}

		return $news_download_data;
	}

	public function getNewsDownloads($news_id) {
		$news_downloads_data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_to_download` WHERE news_id = '" . (int)$news_id . "'");

		foreach ($query->rows as $result) {
			$news_downloads_data [] = array('news_download_id' => $result['news_download_id']);
		}

		return $news_downloads_data;
	}

	public function getNewsDownloadDescription($news_download_id) {
		$news_download_description_data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_download_description` WHERE news_download_id = '" . (int)$news_download_id . "'");

		foreach ($query->rows as $result) {
			$news_download_description_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $news_download_description_data;
	}

	public function getDownloadByDownloadId($news_download_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_download` WHERE news_download_id = '" . (int)$news_download_id . "'");

		return $query->row;
	}

	public function getTotalDownloads() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "news_download`");

		return $query->row['total'];
	}

	public function getTotalNewsDownloads() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "news_to_download`");

		return $query->row['total'];
	}
}
