<?php
class ModelReportOnline extends Model {

	public function getCustomersOnline($data = array()) {
		$sql = "SELECT co.ip, co.customer_id, co.url, co.referer, co.user_agent, co.date_added FROM " . DB_PREFIX . "customer_online co LEFT JOIN " . DB_PREFIX . "customer c ON (co.customer_id = c.customer_id) WHERE co.date_added > DATE_SUB(NOW(), INTERVAL 15 MINUTE)";

		$implode = array();

		if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
			$implode[] = "co.ip LIKE '" . $this->db->escape($data['filter_ip']) . "'";
		}

		if (isset($data['filter_customer']) && !is_null($data['filter_customer'])) {
			$implode[] = "co.customer_id > '0' AND CONCAT(c.firstname, ' ', c.lastname) LIKE '" . $this->db->escape($data['filter_customer']) . "'";
		}

		if (!empty($implode)) {
			$sql .= implode(" AND ", $implode);
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

	public function getTotalCustomersOnline($data = array()) {
		$sql = "SELECT COUNT(*) AS `total` FROM `" . DB_PREFIX . "customer_online` co LEFT JOIN " . DB_PREFIX . "customer c ON (co.customer_id = c.customer_id) WHERE co.date_added > DATE_SUB(NOW(), INTERVAL 15 MINUTE)";

		$implode = array();

		if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
			$implode[] = "co.ip LIKE '" . $this->db->escape($data['filter_ip']) . "'";
		}

		if (isset($data['filter_customer']) && !is_null($data['filter_customer'])) {
			$implode[] = "co.customer_id > 0 AND CONCAT(c.firstname, ' ', c.lastname) LIKE '" . $this->db->escape($data['filter_customer']) . "'";
		}

		if (!empty($implode)) {
			$sql .= implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	// Robots
	public function getRobotsOnline($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "robot_online";

		$implode = array();

		if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
			$implode[] = "ip LIKE '" . $this->db->escape($data['filter_ip']) . "'";
		}

		if (isset($data['filter_robot']) && !is_null($data['filter_robot'])) {
			$implode[] = "robot LIKE '" . $this->db->escape($data['filter_robot']) . "'";
		}

		if (!empty($implode)) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$sql .= " ORDER BY date_added DESC";

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

	public function getTotalRobotsOnline($data = array()) {
		$sql = "SELECT COUNT(*) AS `total` FROM " . DB_PREFIX . "robot_online";

		$implode = array();

		if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
			$implode[] = "ip LIKE '" . $this->db->escape($data['filter_ip']) . "'";
		}

		if (isset($data['filter_robot']) && !is_null($data['filter_robot'])) {
			$implode[] = "robot LIKE '" . $this->db->escape($data['filter_robot']) . "'";
		}

		if (!empty($implode)) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}
