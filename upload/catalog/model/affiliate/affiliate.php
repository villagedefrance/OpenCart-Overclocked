<?php
class ModelAffiliateAffiliate extends Model {

	public function addAffiliate($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . (isset($data['fax']) ? (int)$data['fax'] : 0) . "', salt = '" . $this->db->escape($salt = substr(hash_rand('md5'), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', company = '" . $this->db->escape($data['company']) . "', website = '" . $this->db->escape($data['website']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', code = '" . $this->db->escape(uniqid()) . "', commission = '" . (float)$this->config->get('config_affiliate_commission') . "', tax = '" . $this->db->escape($data['tax']) . "', payment = '" . $this->db->escape($data['payment']) . "', cheque = '" . $this->db->escape($data['cheque']) . "', paypal = '" . $this->db->escape($data['paypal']) . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', bank_branch_number = '" . $this->db->escape($data['bank_branch_number']) . "', bank_swift_code = '" . $this->db->escape($data['bank_swift_code']) . "', bank_account_name = '" . $this->db->escape($data['bank_account_name']) . "', bank_account_number = '" . $this->db->escape($data['bank_account_number']) . "', status = '1', date_added = NOW()");

		$affiliate_id = $this->db->getLastId();

		// Add to activity log
		if ($this->config->get('config_affiliate_activity')) {
			$firstname = (isset($data['firstname'])) ? trim($data['firstname']) : 'no firstname';
			$lastname = (isset($data['lastname'])) ? trim($data['lastname']) : 'no lastname';

			$affiliate_name = $firstname . ' ' . $lastname;

			$this->addActivity($affiliate_id, 'register', $affiliate_name);
		}

		// Send new affiliate email
		$this->language->load('mail/affiliate');

		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

		$message = sprintf($this->language->get('text_welcome'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";

		if (!$this->config->get('config_affiliate_approval')) {
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}

		$message .= $this->url->link('affiliate/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');

		$mail->setTo($this->request->post['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject($subject);
		$mail->setText($message);
		$mail->send();

		// Send to main admin email if new affiliate email is enabled
		if ($this->config->get('config_affiliate_mail')) {
			$message = $this->language->get('text_signup') . "\n\n";
			$message .= $this->language->get('text_store') . ' ' . html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8') . "\n";
			$message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
			$message .= $this->language->get('text_lastname') . ' ' . $data['lastname'] . "\n";

			if ($data['website']) {
				$message .= $this->language->get('text_website') . ' ' . $data['website'] . "\n";
			}

			if ($data['company']) {
				$message .= $this->language->get('text_company') . ' '  . $data['company'] . "\n";
			}

			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";

			$mail->setTo($this->config->get('config_email'));
			$mail->setSubject(html_entity_decode($this->language->get('text_new_affiliate'), ENT_QUOTES, 'UTF-8'));
			$mail->setText($message);
			$mail->send();

			// Send to additional alert emails if new affiliate email is enabled
			$emails = explode(',', $this->config->get('config_mail_alert'));

			foreach ($emails as $email) {
				if (utf8_strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}

		return $affiliate_id;
	}

	public function addActivity($affiliate_id, $key, $affiliate_name) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_activity SET affiliate_id = '" . (int)$affiliate_id . "', `key` = '" . $this->db->escape($key) . "', name = '" . $this->db->escape($affiliate_name) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
	}

	public function editAffiliate($data) {
		$affiliate_id = $this->affiliate->getId();

		$this->db->query("UPDATE " . DB_PREFIX . "affiliate SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . (isset($data['fax']) ? (int)$data['fax'] : 0) . "', company = '" . $this->db->escape($data['company']) . "', website = '" . $this->db->escape($data['website']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
	}

	public function editPayment($data) {
		$affiliate_id = $this->affiliate->getId();

		$this->db->query("UPDATE " . DB_PREFIX . "affiliate SET tax = '" . $this->db->escape($data['tax']) . "', payment = '" . $this->db->escape($data['payment']) . "', cheque = '" . $this->db->escape($data['cheque']) . "', paypal = '" . $this->db->escape($data['paypal']) . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', bank_branch_number = '" . $this->db->escape($data['bank_branch_number']) . "', bank_swift_code = '" . $this->db->escape($data['bank_swift_code']) . "', bank_account_name = '" . $this->db->escape($data['bank_account_name']) . "', bank_account_number = '" . $this->db->escape($data['bank_account_number']) . "' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
	}

	public function editPassword($email, $password) {
		$this->db->query("UPDATE " . DB_PREFIX . "affiliate SET salt = '" . $this->db->escape($salt = substr(hash_rand('md5'), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}

	public function checkAffiliatePassword($password, $affiliate_id, $email) {
		$query = $this->db->query("SELECT CASE WHEN (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') THEN 0 ELSE 1 END AS result FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$affiliate_id . "' AND LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1' AND approved = '1'");

		if ($query->row['result']) {
			return $query->row['result'];
		} else {
			return false;
		}
	}

	public function getAffiliate($affiliate_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$affiliate_id . "'");

		return $query->row;
	}

	public function getAffiliateByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getAffiliateByCode($code) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE code = '" . $this->db->escape($code) . "'");

		return $query->row;
	}

	public function getTotalAffiliatesByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row['total'];
	}

	// Product
	public function addAffiliateProduct($data) {
		$affiliate_id = $this->affiliate->getId();

		if (!empty($data['product_id'])) {
			$code = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $data['product_id'] . '&tracking=' . $this->affiliate->getCode(), 'SSL'));
		} else {
			$code = $this->affiliate->getCode();
		}

		$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_product SET affiliate_id = '" . (int)$affiliate_id . "', product_id = '" . (int)$data['product_id'] . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($code) . "', date_added = NOW()");
	}

	public function editAffiliateProduct($affiliate_product_id, $data) {
		$affiliate_id = $this->affiliate->getId();

		if (!empty($data['product_id'])) {
			$code = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $data['product_id'] . '&tracking=' . $this->affiliate->getCode(), 'SSL'));
		} else {
			$code = $this->affiliate->getCode();
		}

		$this->db->query("UPDATE " . DB_PREFIX . "affiliate_product SET affiliate_id = '" . (int)$affiliate_id . "', product_id = '" . (int)$data['product_id'] . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($code) . "' WHERE affiliate_product_id = '" . (int)$affiliate_product_id . "'");
	}

	public function deleteAffiliateProduct($affiliate_product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_product WHERE affiliate_product_id = '" . (int)$affiliate_product_id . "'");
	}

	public function getAffiliateProducts($affiliate_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate_product WHERE affiliate_id = '" . (int)$affiliate_id . "'");

		return $query->rows;
	}

	public function getAffiliateProduct($affiliate_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate_product WHERE affiliate_product_id = '" . (int)$affiliate_product_id . "'");

		return $query->row;
	}

	public function getTotalAffiliateProducts($affiliate_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate_product WHERE affiliate_id = '" . (int)$affiliate_id . "'");

		return $query->row['total'];
	}

	// Transaction
	public function addTransaction($affiliate_id, $amount = '', $order_id = 0) {
		$affiliate_info = $this->getAffiliate($affiliate_id);

		if ($affiliate_info) {
			$this->language->load('mail/affiliate');

			$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_transaction SET affiliate_id = '" . (int)$affiliate_id . "', order_id = '" . (float)$order_id . "', description = '" . $this->db->escape($this->language->get('text_order_id') . ' #' . $order_id) . "', amount = '" . (float)$amount . "', date_added = NOW()");

			$affiliate_transaction_id = $this->db->getLastId();

			$message = sprintf($this->language->get('text_transaction_received'), $this->currency->format($amount, $this->config->get('config_currency'))) . "\n\n";
			$message .= sprintf($this->language->get('text_transaction_total'), $this->currency->format($this->getTransactionTotal($affiliate_id), $this->config->get('config_currency')));

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');

			$mail->setTo($affiliate_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(sprintf($this->language->get('text_transaction_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')));
			$mail->setText($message);
			$mail->send();

			return $affiliate_transaction_id;
		}
	}

	public function deleteTransaction($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_transaction WHERE order_id = '" . (int)$order_id . "'");
	}

	public function getTransactionTotal($affiliate_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "affiliate_transaction WHERE affiliate_id = '" . (int)$affiliate_id . "'");

		return $query->row['total'];
	}

	public function getTotalTransactionsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate_transaction WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	// Login
	public function getLoginAttempts($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate_login WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function addLoginAttempt($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate_login WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

		if (!$query->num_rows) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_login SET email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "affiliate_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE affiliate_login_id = '" . (int)$query->row['affiliate_login_id'] . "'");
		}
	}

	public function deleteLoginAttempts($email) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_login WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}
}
