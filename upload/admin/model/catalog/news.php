<?php
class ModelCatalogNews extends Model {

	public function addNews($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "news` SET lightbox = '" . $this->db->escape($data['lightbox']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$news_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_news_id'] = $news_id;

		if (isset($data['image'])) {
			$this->db->query("UPDATE `" . DB_PREFIX . "news` SET image = '" . $this->db->escape($data['image']) . "' WHERE news_id = '" . (int)$news_id . "'");
		}

		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "news_description` SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		if (isset($data['news_download'])) {
			foreach ($data['news_download'] as $download_id) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "news_to_download` SET news_id = '" . (int)$news_id . "', news_download_id = '" . (int)$download_id . "'");
			}
		}

		if ($data['related'] == 'category_wise') {
			if (isset($data['category_wise'])) {
				$option = array();

				$option['category_wise'] = $data['category_wise'];

				$options = serialize($option);

				$product_list = $this->getProductCategoryWise($data['category_wise']);

				foreach ($product_list as $product_id) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "news_product_related` SET news_id = '" . (int)$news_id . "', product_id = '" . (int)$product_id . "'");
				}

				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '" . $this->db->escape($options) . "' WHERE news_id = '" . (int)$news_id . "'");
			} else {
				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '' WHERE news_id = '" . (int)$news_id . "'");
			}

		} elseif ($data['related'] == 'manufacturer_wise') {
			if (isset($data['manufacturer_wise'])) {
				$option = array();

				$option['manufacturer_wise'] = $data['manufacturer_wise'];

				$options = serialize($option);

				$product_list = $this->getProductManufacturerWise($data['manufacturer_wise']);

				foreach ($product_list as $product_id) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "news_product_related` SET news_id = '" . (int)$news_id . "', product_id = '" . (int)$product_id . "'");
				}

				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '" . $this->db->escape($options) . "' WHERE news_id = '" . (int)$news_id . "'");
			} else {
				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '' WHERE news_id = '" . (int)$news_id . "'");
			}

		} else {
			if (isset($data['product_wise'])) {
				foreach ($data['product_wise'] as $product_id) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "news_product_related` SET news_id = '" . (int)$news_id . "', product_id = '" . (int)$product_id . "'");
				}

				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '' WHERE news_id = '" . (int)$news_id . "'");
			} else {
				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '' WHERE news_id = '" . (int)$news_id . "'");
			}
		}

		if (isset($data['news_store'])) {
			foreach ($data['news_store'] as $store_id) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "news_to_store` SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('seo_url_map');
		$this->cache->delete('news');
		$this->cache->delete('store');
	}

	public function editNews($news_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "news` SET lightbox = '" . $this->db->escape($data['lightbox']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE news_id = '" . (int)$news_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE `" . DB_PREFIX . "news` SET image = '" . $this->db->escape($data['image']) . "' WHERE news_id = '" . (int)$news_id . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_description` WHERE news_id = '" . (int)$news_id . "'");

		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "news_description` SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_to_download` WHERE news_id = '" . (int)$news_id . "'");

		if (isset($data['news_download'])) {
			foreach ($data['news_download'] as $download_id) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "news_to_download` SET news_id = '" . (int)$news_id . "', news_download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_product_related` WHERE news_id = '" . (int)$news_id . "'");

		if ($data['related'] == 'category_wise') {
			if (isset($data['category_wise'])) {
				$option = array();

				$option['category_wise'] = $data['category_wise'];

				$options = serialize($option);

				$product_list = $this->getProductCategoryWise($data['category_wise']);

				foreach ($product_list as $product_id) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "news_product_related` SET news_id = '" . (int)$news_id . "', product_id = '" . (int)$product_id . "'");
				}

				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '" . $this->db->escape($options) . "' WHERE news_id = '" . (int)$news_id . "'");
			} else {
				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '' WHERE news_id = '" . (int)$news_id . "'");
			}

		} elseif ($data['related'] == 'manufacturer_wise') {
			if (isset($data['manufacturer_wise'])) {
				$option = array();

				$option['manufacturer_wise'] = $data['manufacturer_wise'];

				$options = serialize($option);

				$product_list = $this->getProductManufacturerWise($data['manufacturer_wise']);

				foreach ($product_list as $product_id) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "news_product_related` SET news_id = '" . (int)$news_id . "', product_id = '" . (int)$product_id . "'");
				}

				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '" . $this->db->escape($options) . "' WHERE news_id = '" . (int)$news_id . "'");
			} else {
				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '' WHERE news_id = '" . (int)$news_id . "'");
			}

		} else {
			if (isset($data['product_wise'])) {
				foreach ($data['product_wise'] as $product_id) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "news_product_related` SET news_id = '" . (int)$news_id . "', product_id = '" . (int)$product_id . "'");
				}

				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '' WHERE news_id = '" . (int)$news_id . "'");
			} else {
				$this->db->query("UPDATE `" . DB_PREFIX . "news` SET related_method = '" . $this->db->escape($data['related']) . "', related_option = '' WHERE news_id = '" . (int)$news_id . "'");
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_to_store` WHERE news_id = '" . (int)$news_id . "'");

		if (isset($data['news_store'])) {
			foreach ($data['news_store'] as $store_id) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "news_to_store` SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'news_id=" . (int)$news_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('seo_url_map');
		$this->cache->delete('news');
		$this->cache->delete('store');
	}

	public function deleteNews($news_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "news` WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_description` WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_to_download` WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_product_related` WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_to_store` WHERE news_id = '" . (int)$news_id . "'");

		$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'news_id=" . (int)$news_id . "'");

		$this->cache->delete('seo_url_map');
		$this->cache->delete('news');
		$this->cache->delete('store');
	}

	public function resetViews($news_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "news` SET viewed = '0' WHERE news_id = '" . (int)$news_id . "'");

		$this->cache->delete('seo_url_map');
		$this->cache->delete('news');
		$this->cache->delete('store');
	}

	public function getNewsStory($news_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'news_id=" . (int)$news_id . "') AS keyword FROM `" . DB_PREFIX . "news` n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getNews($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM `" . DB_PREFIX . "news` n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'nd.title',
				'n.date_added',
				'n.sort_order',
				'n.status',
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

		} else {
			$news_data = $this->cache->get('news.' . (int)$this->config->get('config_language_id'));

			if (!$news_data) {
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news` n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY n.date_added ASC");

				$news_data = $query->rows;

				$this->cache->set('news.' . (int)$this->config->get('config_language_id'), $news_data);
			}

			return $news_data;
		}
	}

	public function getNewsDescriptions($news_id) {
		$news_description_data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_description` WHERE news_id = '" . (int)$news_id . "'");

		foreach ($query->rows as $result) {
			$news_description_data[$result['language_id']] = array(
				'title'            => $result['title'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}

		return $news_description_data;
	}

	public function getNewsDownloads($news_id) {
		$news_download_data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_to_download` WHERE news_id = '" . (int)$news_id . "'");

		foreach ($query->rows as $result) {
			$news_download_data[] = $result['news_download_id'];
		}

		return $news_download_data;
	}

	public function getNewsProduct($news_id) {
		$query = $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "news_product_related` WHERE news_id = '" . (int)$news_id . "'");

		return $query->rows;
	}

	public function getNewsStores($news_id) {
		$newspage_store_data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_to_store` WHERE news_id = '" . (int)$news_id . "'");

		foreach ($query->rows as $result) {
			$newspage_store_data[] = $result['store_id'];
		}

		return $newspage_store_data;
	}

	public function getTotalNews() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "news`");

		return $query->row['total'];
	}

	public function getTotalActiveNews() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "news` WHERE status = '1'");

		return $query->row['total'];
	}

	public function getTotalNewsDownloads() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "news_to_download`");

		return $query->row['total'];
	}

	public function getProductManufacturerWise($manufacturers) {
		$product_list = array();

		foreach ($manufacturers as $manufacturer) {
			$query = $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "product` WHERE manufacturer_id = '" . (int)$manufacturer . "'");

			foreach ($query->rows as $result) {
				if (!in_array($result['product_id'], $product_list)) {
					$product_list[] = $result['product_id'];
				}
			}

			return $product_list;
		}
	}

	public function getProductCategoryWise($categories) {
		$product_list = array();

		foreach ($categories as $category_id) {
			$query = $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "product_to_category` WHERE category_id = '" . (int)$category_id . "'");

			foreach ($query->rows as $result) {
				if (!in_array($result['product_id'], $product_list)) {
					$product_list[] = $result['product_id'];
				}
			}
		}

		return $product_list;
	}
}
