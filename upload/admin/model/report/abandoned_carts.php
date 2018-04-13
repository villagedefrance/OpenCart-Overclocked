<?php
class ModelReportAbandonedCarts extends Model {

	public function checkDuplicates($ip) {
		$query = $this->db->query("SELECT ip FROM `" . DB_PREFIX . "order` WHERE ip = '" . $this->db->escape($ip) . "'");

		return $query->num_rows;
	}

	public function recoverEmail($order_id) {
		$order_info = $this->getOrder($order_id);

		if ($order_info) {
			$store_name = $order_info['store_name'];
			$store_url = $order_info['store_url'];
		} else {
			$store_name = $this->config->get('config_name');
			$store_url = ($this->config->get('config_secure')) ? HTTPS_CATALOG : HTTP_CATALOG;
		}

		$this->language->load('report/abandoned_carts');

		$message = sprintf($this->language->get('failed_cart_greeting'), ucfirst($order_info['firstname'])) . "\n\n";
		$message .= $this->language->get('failed_cart_intro') . "\n\n";
		$message .= $this->language->get('failed_cart_contents') . "\n";

		$order_product_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$order_id . "'");

		foreach ($order_product_query->rows as $product) {
			$message .= $product['quantity'] . 'x ' . $product['name'] . "\n";
		}

		$message .= "\n" . $this->language->get('failed_cart_body') . "\n\n";
		$message .= $this->language->get('failed_cart_footer') . "\n\n";
		$message .= $this->language->get('failed_cart_signoff') . "\n\n";
		$message .= $this->language->get('failed_cart_signature') . "\n\n";
		$message .= $store_name . "\n";
		$message .= $store_url . "\n";

		// HTML Mail
		$template = new Template();

		$template->data['title'] = sprintf($this->language->get('text_approve_subject'), $store_name);
		$template->data['logo'] = HTTP_CATALOG . 'image/' . $this->config->get('config_logo');
		$template->data['store_name'] = $this->config->get('config_name');
		$template->data['store_url'] = HTTP_CATALOG;
		$template->data['message'] = nl2br($message);

		$html = $template->fetch('mail/default.tpl');

		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');

		$mail->setTo($order_info['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
		$mail->setSubject(html_entity_decode(sprintf($this->language->get('subject'), $store_name), ENT_QUOTES, 'UTF-8'));
		$mail->setHtml($html);
		$mail->send();

		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET abandoned = '1' WHERE order_id = '" . (int)$order_id . "'");
	}

	public function getOrders($data = array()) {
		$days = ($this->config->get('config_abandoned_cart')) ? $this->config->get('config_abandoned_cart') : 7;

		$sql = "SELECT o.*, CONCAT(o.firstname, ' ', o.lastname) AS `name` FROM `" . DB_PREFIX . "order` o WHERE o.date_added >= DATE_SUB(NOW(), INTERVAL " . $days . " DAY) AND o.order_status_id = '0'";

		if (isset($data['filter_name'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY o.order_id";

		$sort_data = array(
			'o.order_id',
			'name',
			'o.total',
			'o.date_added',
			'o.ip',
			'o.abandoned'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
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

	public function getTotalOrders($data = array()) {
		$days = ($this->config->get('config_abandoned_cart')) ? $this->config->get('config_abandoned_cart') : 7;

		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o WHERE o.date_added >= DATE_SUB(NOW(), INTERVAL " . $days . " DAY) AND o.order_status_id = '0'";

		if (isset($data['filter_name'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT store_name, store_url, firstname, lastname, email FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");

		return array(
			'store_name'    => $order_query->row['store_name'],
			'store_url'     => $order_query->row['store_url'],
			'firstname'     => $order_query->row['firstname'],
			'lastname'      => $order_query->row['lastname'],
			'email'         => $order_query->row['email']
		);
	}

	public function deleteOrder($order_id) {
		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_status_id = '0' AND order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach ($product_query->rows as $product) {
				$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");

				$option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

				foreach ($option_query->rows as $option) {
					$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
				}
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_transaction WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE `or`, ort FROM " . DB_PREFIX . "order_recurring `or`, " . DB_PREFIX . "order_recurring_transaction ort WHERE order_id = '" . (int)$order_id . "' AND ort.order_recurring_id = `or`.order_recurring_id");

		$this->cache->delete('product.bestseller');
	}
}
