<?php
class ModelCatalogProfile extends Model {

	public function addProfile($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "profile SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', price = '" . (double)$data['price'] . "', frequency = '" . $this->db->escape($data['frequency']) . "', duration = '" . (int)$data['duration'] . "', `cycle` = '" . (int)$data['cycle'] . "', trial_status = '" . (int)$data['trial_status'] . "', trial_price = '" . (double)$data['trial_price'] . "', trial_frequency = '" . $this->db->escape($data['trial_frequency']) . "', trial_duration = '" . (int)$data['trial_duration'] . "', trial_cycle = '" . (int)$data['trial_cycle'] . "'");

		$profile_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_profile_id'] = $profile_id;

		foreach ($data['profile_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "profile_description SET profile_id = '" . (int)$profile_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('profile');

		return $profile_id;
	}

	public function updateProfile($profile_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "profile_description WHERE profile_id = '" . (int)$profile_id . "'");

		$this->db->query("UPDATE " . DB_PREFIX . "profile SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', price = '" . (double)$data['price'] . "', frequency = '" . $this->db->escape($data['frequency']) . "', duration = '" . (int)$data['duration'] . "', `cycle` = '" . (int)$data['cycle'] . "', trial_status = '" . (int)$data['trial_status'] . "', trial_price = '" . (double)$data['trial_price'] . "', trial_frequency = '" . $this->db->escape($data['trial_frequency']) . "', trial_duration = '" . (int)$data['trial_duration'] . "', trial_cycle = '" . (int)$data['trial_cycle'] . "' WHERE profile_id = '" . (int)$profile_id . "'");

		foreach ($data['profile_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "profile_description SET profile_id = '" . (int)$profile_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('profile');
	}

	public function deleteProfile($profile_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "profile WHERE profile_id = '" . (int)$profile_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "profile_description WHERE profile_id = '" . (int)$profile_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_profile WHERE profile_id = '" . (int)$profile_id . "'");

		$this->db->query("UPDATE " . DB_PREFIX . "order_recurring SET profile_id = '0' WHERE profile_id = '" . (int)$profile_id . "'");

		$this->cache->delete('profile');
	}

	public function getFrequencies() {
		return array(
			'day'        => $this->language->get('text_day'),
			'week'       => $this->language->get('text_week'),
			'semi_month' => $this->language->get('text_semi_month'),
			'month'      => $this->language->get('text_month'),
			'year'       => $this->language->get('text_year')
		);
	}

	public function getProfiles($data = array()) {
		$sql = "SELECT pf.profile_id, pfd.name, pf.sort_order, pf.status FROM " . DB_PREFIX . "profile pf LEFT JOIN " . DB_PREFIX . "profile_description pfd ON (pf.profile_id = pfd.profile_id) WHERE pfd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'pf.profile_id',
			'pfd.name',
			'pf.sort_order',
			'pf.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pf.sort_order";
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

	public function getProfile($profile_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "profile WHERE profile_id = '" . (int)$profile_id . "'");

		return $query->row;
	}

	public function getProfileDescription($profile_id) {
		$profile_description_data = $this->cache->get('profile.' . (int)$this->config->get('config_language_id'));

		if (!$profile_description_data) {
			$profile_description_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "profile_description WHERE profile_id = '" . (int)$profile_id . "'");

			foreach ($query->rows as $result) {
				$profile_description_data[$result['language_id']] = array(
					'name' => $result['name']
				);
			}

			$this->cache->set('profile.' . (int)$this->config->get('config_language_id'), $profile_description_data);
		}

		return $profile_description_data;
	}

	public function getTotalProfiles() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "profile");

		return $query->row['total'];
	}
}
