<?php
static $registry = null;

// Error Handler
function error_handler_for_export_import($errno, $errstr, $errfile, $errline) {
	global $registry;

	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$errors = "Notice";
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$errors = "Warning";
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$errors = "Fatal Error";
			break;
		default:
			$errors = "Unknown";
			break;
	}

	$url = $registry->get('url');
	$config = $registry->get('config');
	$request = $registry->get('request');
	$session = $registry->get('session');
	$log = $registry->get('log');

	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $errors . ': ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	if (($errors == 'Warning') || ($errors == 'Unknown')) {
		return true;
	}

	if (($errors != "Fatal Error") && isset($request->get['route']) && ($request->get['route'] != 'tool/export_import/download')) {
		if ($config->get('config_error_display')) {
			echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
		}

	} else {
		$session->data['export_import_error'] = array('errstr' => $errstr, 'errno' => $errno, 'errfile' => $errfile, 'errline' => $errline);

		$token = $request->get['token'];

		$link = $url->link('tool/export_import', 'token=' . $token, 'SSL');

		header('Status: ' . 302);
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $link));
		exit();
	}

	return true;
}

function fatal_error_shutdown_handler_for_export_import() {
	$last_error = error_get_last();

	if ($last_error['type'] === E_ERROR) {
		error_handler_for_export_import(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
	}
}

class ModelToolExportImport extends Model {
	protected $null_array = array();

	protected function clean(&$str, $allowBlanks = false) {
		$result = "";

		$n = strlen($str);

		for ($m = 0; $m < $n; $m++) {
			$ch = mb_substr($str, $m, 1, 'UTF-8');

			if (($ch == " ") && (!$allowBlanks) || ($ch == "\n") || ($ch == "\r") || ($ch == "\t") || ($ch == "\0") || ($ch == "\x0B")) {
				continue;
			}

			$result .= $ch;
		}

		return $result;
	}

	protected function multiquery($sql) {
		foreach (explode(";\n", $sql) as $sql) {
			$sql = trim($sql);

			if ($sql) {
				$this->db->query($sql);
			}
		}
	}

	protected function startsWith($haystack, $needle) {
		if (strlen($haystack) < strlen($needle)) {
			return false;
		}

		return (mb_substr($haystack, 0, strlen($needle), 'UTF-8') == $needle);
	}

	protected function endsWith($haystack, $needle) {
		if (strlen($haystack) < strlen($needle)) {
			return false;
		}

		return (mb_substr($haystack, strlen($haystack)-strlen($needle), strlen($needle), 'UTF-8') == $needle);
	}

	public function getDefaultLanguageId() {
		$query = $this->db->query("SELECT DISTINCT language_id FROM `" . DB_PREFIX . "language` WHERE code = '" . $this->config->get('config_admin_language') . "'");

		if ($query->row['language_id']) {
			$language_id = $query->row['language_id'];
		} else {
			$language_id = 1;
		}

		return $language_id;
	}

	protected function getLanguages() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE status = '1' ORDER BY `code` ASC");

		return $query->rows;
	}

	protected function getDefaultWeightUnit() {
		$weight_class_id = $this->config->get( 'config_weight_class_id' );

		$language_id = $this->getDefaultLanguageId();

		$sql = "SELECT unit FROM `" . DB_PREFIX . "weight_class_description` WHERE language_id = '" . (int)$language_id . "'";

		$query = $this->db->query($sql);

		if ($query->num_rows > 0) {
			return $query->row['unit'];
		}

		$en_sql = "SELECT language_id FROM `" . DB_PREFIX . "language` WHERE code = 'en'";

		$en_query = $this->db->query($en_sql);

		if ($en_query->num_rows > 0) {
			$language_id = $en_query->row['language_id'];

			$sql = "SELECT unit FROM `" . DB_PREFIX . "weight_class_description` WHERE language_id = '" . (int)$language_id . "'";

			$query = $this->db->query($sql);

			if ($query->num_rows > 0) {
				return $query->row['unit'];
			}
		}

		return 'kg';
	}

	protected function getDefaultMeasurementUnit() {
		$length_class_id = $this->config->get('config_length_class_id');

		$language_id = $this->getDefaultLanguageId();

		$sql = "SELECT unit FROM `".DB_PREFIX."length_class_description` WHERE language_id = '" . (int)$language_id . "'";

		$query = $this->db->query($sql);

		if ($query->num_rows > 0) {
			return $query->row['unit'];
		}

		$en_sql = "SELECT language_id FROM `" . DB_PREFIX . "language` WHERE code = 'en'";

		$en_query = $this->db->query($en_sql);

		if ($en_query->num_rows > 0) {
			$language_id = $en_query->row['language_id'];

			$sql = "SELECT unit FROM `" . DB_PREFIX . "length_class_description` WHERE language_id = '" . (int)$language_id . "'";

			$query = $this->db->query($sql);

			if ($query->num_rows > 0) {
				return $query->row['unit'];
			}
		}

		return 'cm';
	}

	// Find all customer ids
	protected function getCustomerIds() {
		$query = $this->db->query("SELECT customer_id FROM `" . DB_PREFIX . "customer`;");

		if ($query->num_rows > 0) {
			return $query->rows['customer_id'];
		} else {
			return 0;
		}
	}

	// Find all category ids
	protected function getCategoryIds() {
		$query = $this->db->query("SELECT category_id FROM `" . DB_PREFIX . "category`;");

		if ($query->num_rows > 0) {
			return $query->rows['category_id'];
		} else {
			return 0;
		}
	}

	// Find all product ids
	protected function getProductIds() {
		$query = $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "product`;");

		if ($query->num_rows > 0) {
			return $query->rows['product_id'];
		} else {
			return 0;
		}
	}

	// Find all manufacturers already stored in the database
	protected function getManufacturers() {
		$default_language_id = $this->getDefaultLanguageId();

		$manufacturers = array();

		$sql = "SELECT m2s.manufacturer_id, m2s.store_id, md.name AS `name` FROM `" . DB_PREFIX . "manufacturer` m";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "manufacturer_to_store` m2s ON (m2s.manufacturer_id = m.manufacturer_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "manufacturer_description` md ON (md.manufacturer_id = m.manufacturer_id)";
		$sql .= " WHERE md.language_id = '" . (int)$default_language_id . "'";

		$result = $this->db->query($sql);

		foreach ($result->rows as $row) {
			$manufacturer_id = $row['manufacturer_id'];
			$store_id = $row['store_id'];
			$manufacturer_name = $row['name'];

			if (!isset($manufacturers[$manufacturer_name])) {
				$manufacturers[$manufacturer_name] = array();
			}

			if (!isset($manufacturers[$manufacturer_name]['manufacturer_id'])) {
				$manufacturers[$manufacturer_name]['manufacturer_id'] = $manufacturer_id;
			}

			if (!isset($manufacturers[$manufacturer_name]['store_ids'])) {
				$manufacturers[$manufacturer_name]['store_ids'] = array();
			}

			if (!in_array($store_id, $manufacturers[$manufacturer_name]['store_ids'])) {
				$manufacturers[$manufacturer_name]['store_ids'][] = $store_id;
			}
		}

		return $manufacturers;
	}

	protected function storeManufacturerIntoDatabase(&$manufacturers, &$manufacturer_name, &$store_ids, &$available_store_ids) {
		$language_ids = $this->getLanguages();

		foreach ($store_ids as $store_id) {
			if (!in_array($store_id, $available_store_ids)) {
				continue;
			}

			if (!isset($manufacturers[$manufacturer_name]['manufacturer_id'])) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "manufacturer` SET `image` = '', sort_order = '0', status = '1'");

				$manufacturer_id = $this->db->getLastId();

				foreach ($language_ids as $language_id) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "manufacturer_description` SET manufacturer_id = '" . (int)$manufacturer_id . "', language_id = '" . (int)$language_id . "', `name` = '" . $this->db->escape($manufacturer_name) . "', description = '" . $this->db->escape($description) . "'");
				}

				if (!isset($manufacturers[$manufacturer_name])) {
					$manufacturers[$manufacturer_name] = array();
				}

				$manufacturers[$manufacturer_name]['manufacturer_id'] = $manufacturer_id;
			}

			if (!isset($manufacturers[$manufacturer_name]['store_ids'])) {
				$manufacturers[$manufacturer_name]['store_ids'] = array();
			}

			if (!in_array($store_id, $manufacturers[$manufacturer_name]['store_ids'])) {
				$manufacturer_id = $manufacturers[$manufacturer_name]['manufacturer_id'];

				$this->db->query("INSERT INTO `" . DB_PREFIX . "manufacturer_to_store` SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");

				$manufacturers[$manufacturer_name]['store_ids'][] = $store_id;
			}
		}
	}

	// Find all weight classes already stored in the database
	protected function getWeightClassIds() {
		$language_id = $this->getDefaultLanguageId();

		$weight_class_ids = array();

		$result = $this->db->query("SELECT weight_class_id, `unit` FROM `" . DB_PREFIX . "weight_class_description` WHERE language_id = '" . (int)$language_id . "'");

		if ($result->rows) {
			foreach ($result->rows as $row) {
				$weight_class_id = $row['weight_class_id'];
				$unit = $row['unit'];

				if (!isset($weight_class_ids[$unit])) {
					$weight_class_ids[$unit] = $weight_class_id;
				}
			}
		}

		return $weight_class_ids;
	}

	// Find all length classes already stored in the database
	protected function getLengthClassIds() {
		$language_id = $this->getDefaultLanguageId();

		$length_class_ids = array();

		$result = $this->db->query("SELECT length_class_id, `unit` FROM `" . DB_PREFIX . "length_class_description` WHERE language_id = '" . (int)$language_id . "'");

		if ($result->rows) {
			foreach ($result->rows as $row) {
				$length_class_id = $row['length_class_id'];
				$unit = $row['unit'];

				if (!isset($length_class_ids[$unit])) {
					$length_class_ids[$unit] = $length_class_id;
				}
			}
		}

		return $length_class_ids;
	}

	// Find all layout ids
	protected function getLayoutIds() {
		$layout_ids = array();

		$result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "layout`;");

		foreach ($result->rows as $row) {
			$layout_ids[$row['name']] = $row['layout_id'];
		}

		return $layout_ids;
	}

	// Find all customer group ids
	protected function getCustomerGroupIds() {
		$language_id = $this->getDefaultLanguageId();

		$customer_group_ids = array();

		$result = $this->db->query("SELECT customer_group_id, `name` FROM `" . DB_PREFIX . "customer_group_description` WHERE language_id = '" . (int)$language_id . "' ORDER BY customer_group_id ASC");

		foreach ($result->rows as $row) {
			$customer_group_id = $row['customer_group_id'];
			$name = $row['name'];

			$customer_group_ids[$name] = $customer_group_id;
		}

		return $customer_group_ids;
	}

	// Find all video product ids
	protected function getExistingVideoProductIds() {
		$product_ids = array(0);

		$result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_youtube`;");

		foreach ($result->rows as $row) {
			if (!in_array((int)$row['product_id'], $product_ids)) {
				$product_ids[] = (int)$row['product_id'];
			}
		}

		return $product_ids;
	}

	// Find all product tax local rate ids
	protected function getExistingProductTaxLocalRateIds() {
		$product_ids = array(0);

		$result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_tax_local_rate`;");

		foreach ($result->rows as $row) {
			if (!in_array((int)$row['product_id'], $product_ids)) {
				$product_ids[] = (int)$row['product_id'];
			}
		}

		return $product_ids;
	}

	// Find all available store ids
	protected function getAvailableStoreIds() {
		$store_ids = array(0);

		$result = $this->db->query("SELECT store_id FROM `" . DB_PREFIX . "store`;");

		foreach ($result->rows as $row) {
			if (!in_array((int)$row['store_id'], $store_ids)) {
				$store_ids[] = (int)$row['store_id'];
			}
		}

		return $store_ids;
	}

	// Find all available product ids
	protected function getAvailableProductIds(&$data) {
		$available_product_ids = array();

		$k = $data->getHighestRow();

		for ($i = 1; $i < $k; $i += 1) {
			$j = 1;

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == "") {
				continue;
			}

			$available_product_ids[$product_id] = $product_id;
		}

		return $available_product_ids;
	}

	// Find available category ids
	protected function getAvailableCategoryIds() {
		$category_ids = array();

		$result = $this->db->query("SELECT category_id FROM `" . DB_PREFIX . "category`;");

		foreach ($result->rows as $row) {
			$category_ids[$row['category_id']] = (int)$row['category_id'];
		}

		return $category_ids;
	}

	// Find all available customer ids
	protected function getAvailableCustomerIds() {
		$customer_ids = array();

		$result = $this->db->query("SELECT `customer_id` FROM `" . DB_PREFIX . "customer`;");

		foreach ($result->rows as $row) {
			$customer_ids[$row['customer_id']] = (int)$row['customer_id'];
		}

		return $customer_ids;
	}

	// Find all available address ids
	protected function getAvailableAddressIds() {
		$address_ids = array();

		$result = $this->db->query("SELECT address_id FROM `" . DB_PREFIX . "address`;");

		foreach ($result->rows as $row) {
			$address_ids[$row['address_id']] = (int)$row['address_id'];
		}

		return $address_ids;
	}

	// Customers
	protected function getCustomerAddressIds() {
		$address_ids = array();

		$result = $this->db->query("SELECT address_id, customer_id FROM `" . DB_PREFIX . "address`;");

		foreach ($result->rows as $row) {
			$address_id = $row['address_id'];
			$customer_id = $row['customer_id'];
			$address_ids[$customer_id] = $address_id;
		}

		return $address_ids;
	}

	// Extract and Insert the Customer details
	protected function storeCustomerIntoDatabase(&$customer, &$available_customer_ids, &$customer_group_ids) {
		$customer_id = $customer['customer_id'];
		$name = $customer['customer_group'];
		$customer_group_id = isset($customer_group_ids[$name]) ? $customer_group_ids[$name] : $this->config->get('config_customer_group_id');
		$store_id = $customer['store_id'];
		$firstname = $this->db->escape($customer['firstname']);
		$lastname = $this->db->escape($customer['lastname']);
		$email = $this->db->escape($customer['email']);
		$telephone = $customer['telephone'];
		$fax = $customer['fax'];
		$gender = $customer['gender'];
		$date_of_birth = $customer['date_of_birth'];
		$password = $customer['password'];
		$salt = $customer['salt'];
		$cart = $customer['cart'];
		$wishlist = $customer['wishlist'];
		$wishlist = ((strtoupper($wishlist) == "TRUE") || (strtoupper($wishlist) == "YES") || (strtoupper($wishlist) == "ENABLED")) ? 1 : 0;
		$newsletter = $customer['newsletter'];
		$newsletter = ((strtoupper($newsletter) == "TRUE") || (strtoupper($newsletter) == "YES") || (strtoupper($newsletter) == "ENABLED")) ? 1 : 0;
		$address_id = ($customer['address_id']) ? $customer['address_id'] : '0';
		$ip = $customer['ip'];
		$status = $customer['status'];
		$status = ((strtoupper($status) == "TRUE") || (strtoupper($status) == "YES") || (strtoupper($status) == "ENABLED")) ? 1 : 0;
		$approved = $customer['approved'];
		$approved = ((strtoupper($approved) == "TRUE") || (strtoupper($approved) == "YES") || (strtoupper($approved) == "ENABLED")) ? 1 : 0;
		$token = $this->db->escape($customer['token']);
		$date_added = $customer['date_added'];

		// Generate and execute SQL for inserting the customers
		$sql = "INSERT INTO `" . DB_PREFIX . "customer` (`customer_id`,`customer_group_id`,`store_id`,`firstname`,`lastname`,`email`,`telephone`,`fax`,`gender`,`date_of_birth`,`password`,`salt`,`cart`,`wishlist`,`newsletter`,`address_id`,`ip`,`status`,`approved`,`token`,`date_added`) VALUES";
		$sql .= " ( $customer_id, $customer_group_id, $store_id, '$firstname', '$lastname', '$email', '$telephone', '$fax', '$gender', '$date_of_birth', '$password', '$salt', '$cart', $wishlist, $newsletter, $address_id, '$ip', $status, $approved, '$token', '$date_added');";

		$this->db->query($sql);
	}

	protected function deleteCustomer($customer_id) {
		$sql = "DELETE FROM `" . DB_PREFIX . "customer` WHERE customer_id = '" . (int)$customer_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "customer_history` WHERE customer_id = '" . (int)$customer_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "customer_online` WHERE customer_id = '" . (int)$customer_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "customer_reward` WHERE customer_id = '" . (int)$customer_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "customer_transaction` WHERE customer_id = '" . (int)$customer_id . "';\n";

		$this->multiquery($sql);

		$query = $this->db->query("SHOW TABLES LIKE \"" . DB_PREFIX . "address\"");

		if ($query->num_rows) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "address` WHERE customer_id = '" . (int)$customer_id . "'");
		}
	}

	protected function deleteCustomers() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "customer`");
	}

	// Function for reading additional cells in class extensions
	protected function moreCustomerCells($i, &$j, &$worksheet, &$customer) {
		return;
	}

	protected function uploadCustomers(&$reader, $incremental, &$available_customer_ids = array()) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Customers');

		if ($data == null) {
			return;
		}

		// Get customer_group ids indexed by customer group names
		$customer_group_ids = $this->getCustomerGroupIds();

		// If incremental, then find current customer ids, else delete all old customers
		$available_customer_ids = array();

		if ($incremental) {
			$available_customer_ids = $this->getAvailableCustomerIds();
		} else {
			$this->deleteCustomers();
		}

		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$customer_id = trim($this->getCell($data, $i, $j++));

			if ($customer_id == "") {
				continue;
			}

			$customer_group = trim($this->getCell($data, $i, $j++));
			$customer_group_id = isset($customer_group_ids[$customer_group]) ? $customer_group_ids[$customer_group] : '0';
			$store_id = $this->getCell($data, $i, $j++, '0');
			$firstname = $this->getCell($data, $i, $j++);
			$lastname = $this->getCell($data, $i, $j++);
			$email = $this->getCell($data, $i, $j++);
			$telephone = $this->getCell($data, $i, $j++);
			$telephone = (is_string($telephone) && utf8_strlen($telephone) > 0) ? $telephone : '000';
			$fax = trim($this->getCell($data, $i, $j++));
			$fax = (is_string($fax) && utf8_strlen($fax) > 0) ? $fax : '000';
			$gender = $this->getCell($data, $i, $j++);
			$gender = ($gender) ? '1' : '0';
			$date_of_birth = trim($this->getCell($data, $i, $j++));
			$date_of_birth = (is_string($date_of_birth) && utf8_strlen($date_of_birth) > 0) ? $date_of_birth : '0000-00-00';
			$password = trim($this->getCell($data, $i, $j++));
			$password = (is_string($password) && utf8_strlen($password) > 0) ? $password : '';
			$salt = trim($this->getCell($data, $i, $j++));
			if ($password == '') {
				// Generate a default password 'overclock'
				if ($salt == '') {
					$salt = substr(md5(uniqid(rand(), true)), 0, 9);
				}
				$password = sha1($salt . sha1($salt . sha1('overclock')));
			} else {
				$password = md5('overclock');
			}
			$cart = $this->getCell($data, $i, $j++);
			$wishlist = $this->getCell($data, $i, $j++);
			$newsletter = trim($this->getCell($data, $i, $j++));
			$address_id = $this->getCell($data, $i, $j++);
			$ip = $this->getCell($data, $i, $j++);
			$ip = (is_string($ip)) ? $ip : '127.0.0.1';
			$status = $this->getCell($data, $i, $j++);
			$approved = $this->getCell($data, $i, $j++);
			$token = $this->getCell($data, $i, $j++);
			$date_added = trim($this->getCell($data, $i, $j++));
			$date_added = (is_string($date_added) && utf8_strlen($date_added) > 0) ? $date_added : date('Y-m-d');

			$customer = array();

			$customer['customer_id'] = $customer_id;
			$customer['customer_group'] = $customer_group;
			$customer['store_id'] = $store_id;
			$customer['firstname'] = $firstname;
			$customer['lastname'] = $lastname;
			$customer['email'] = $email;
			$customer['telephone'] = $telephone;
			$customer['fax'] = $fax;
			$customer['gender'] = $gender;
			$customer['date_of_birth'] = $date_of_birth;
			$customer['password'] = $password;
			$customer['salt'] = $salt;
			$customer['cart'] = $cart;
			$customer['wishlist'] = $wishlist;
			$customer['newsletter'] = $newsletter;
			$customer['address_id'] = $address_id;
			$customer['ip'] = $ip;
			$customer['status'] = $status;
			$customer['approved'] = $approved;
			$customer['token'] = $token;
			$customer['date_added'] = $date_added;

			if ($incremental) {
				if ($available_customer_ids) {
					if (in_array((int)$customer_id, $available_customer_ids)) {
						$this->deleteCustomer($customer_id);
					}
				}
			}

			$this->moreCustomerCells($i, $j, $data, $customer);

			$this->storeCustomerIntoDatabase($customer, $available_customer_ids, $customer_group_ids);
		}
	}

	// Addresses
	protected function getAvailableCountryIds() {
		$language_id = $this->getDefaultLanguageId();

		$country_ids = array();

		$sql = "SELECT c.country_id AS country_id, cd.name AS country_name FROM `" . DB_PREFIX . "country` c LEFT JOIN `" . DB_PREFIX . "country_description` cd ON (c.country_id = cd.country_id)";
		$sql .= " WHERE cd.language_id = '" . (int)$language_id . "'";
		$sql .= " GROUP BY c.country_id";
		$sql .= " ORDER BY cd.name ASC";

		$query = $this->db->query($sql);

		foreach ($query->rows as $row) {
			$country_id = $row['country_id'];
			$country = $row['country_name'];
			$country_ids[$country] = $country_id;
		}

		return $country_ids;
	}

	protected function getAvailableZoneIds() {
		$language_id = $this->getDefaultLanguageId();

		$zone_ids = array();

		$sql = "SELECT c.country_id, z.zone_id, cd.name AS country_name, z.name AS zone_name FROM `" . DB_PREFIX . "country` c";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "country_description` cd ON (c.country_id = cd.country_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "zone` z ON (z.country_id = c.country_id)";
		$sql .= " WHERE cd.language_id = '" . (int)$language_id . "'";

		$query = $this->db->query( $sql );

		foreach ($query->rows as $row) {
			$country_id = $row['country_id'];
			$country = $row['country_name'];
			$zone_id = ($row['zone_id']) ? $row['zone_id'] : 0;
			$zone = ($row['zone_name']) ? $row['zone_name'] : '';
			$zone_ids[$country][$zone] = $zone_id;
		}

		return $zone_ids;
	}

	protected function storeAddressIntoDatabase(&$address) {
		$customer_id = $address['customer_id'];
		$firstname = $address['firstname'];
		$lastname = $address['lastname'];
		$company = $address['company'];
		$company_id = $address['company_id'];
		$tax_id = $address['tax_id'];
		$address_1 = $address['address_1'];
		$address_2 = $address['address_2'];
		$city = $address['city'];
		$postcode = $address['postcode'];
		$country_id = $address['country_id'];
		$zone_id = $address['zone_id'];
		$default = $address['default'];
		$default = ((strtoupper($default) == "TRUE") || (strtoupper($default) == "YES") || (strtoupper($default) == "ENABLED")) ? 1 : 0;

		$sql = "INSERT INTO `" . DB_PREFIX . "address`";
		$sql .= " (`customer_id`,`firstname`,`lastname`,`company`,`company_id`,`tax_id`,`address_1`,`address_2`,`city`,`postcode`,`country_id`,`zone_id`)";
		$sql .= " VALUES ($customer_id,";
		$sql .= " '" . $this->db->escape($firstname) . "',";
		$sql .= " '" . $this->db->escape($lastname) . "',";
		$sql .= " '" . $this->db->escape($company) . "',";
		$sql .= " '" . $this->db->escape($company_id) . "',";
		$sql .= " '" . $this->db->escape($tax_id) . "',";
		$sql .= " '" . $this->db->escape($address_1) . "',";
		$sql .= " '" . $this->db->escape($address_2) . "',";
		$sql .= " '" . $this->db->escape($city) . "',";
		$sql .= " '" . $this->db->escape($postcode) . "',";
		$sql .= " $country_id, $zone_id";
		$sql .= ");";

		$this->db->query($sql);

		if ($default) {
			$address_id = $this->db->getLastId();

			$this->db->query("UPDATE `" . DB_PREFIX . "customer` SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
		}
	}

	protected function deleteAddresses() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "address`");
	}

	protected function deleteAddress($customer_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "address` WHERE customer_id = '" . (int)$customer_id . "'");
	}

	protected function deleteUnlistedAddresses(&$unlisted_customer_ids) {
		foreach ($unlisted_customer_ids as $customer_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "address` WHERE customer_id = '" . (int)$customer_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreAddressCells($i, &$j, &$worksheet, &$option) {
		return;
	}

	protected function uploadAddresses(&$reader, $incremental, &$available_customer_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Addresses');

		if ($data == null) {
			return;
		}

		// Find the available country_ids indexed by country names
		$available_country_ids = $this->getAvailableCountryIds();

		// Find the available zone_ids indexed by country names and zone names
		$available_zone_ids = $this->getAvailableZoneIds();

		// If incremental then find current customer IDs else delete all old addresses
		if ($incremental) {
			$unlisted_customer_ids = $available_customer_ids;
		} else {
			$this->deleteAddresses();
		}

		// Load the worksheet cells and store them to the database
		$previous_customer_id = 0;

		$first_row = array();

		$i = 0;

		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$customer_id = trim($this->getCell($data, $i, $j++));

			if ($customer_id == '') {
				continue;
			}

			$firstname = $this->getCell($data, $i, $j++, '');
			$lastname = $this->getCell($data, $i, $j++, '');
			$company = $this->getCell($data, $i, $j++, '');
			$company_id = $this->getCell($data, $i, $j++, '');
			$tax_id = $this->getCell($data, $i, $j++, '');
			$address_1 = $this->getCell($data, $i, $j++, '');
			$address_2 = $this->getCell($data, $i, $j++, '');
			$city = $this->getCell($data, $i, $j++, '');
			$postcode = $this->getCell($data, $i, $j++, '');
			$zone = $this->getCell($data, $i, $j++, '');
			$country = $this->getCell($data, $i, $j++, '');

			if (!isset($available_country_ids[$country])) {
				$country = html_entity_decode($country, ENT_QUOTES, 'UTF-8');
			}

			$country_id = isset($available_country_ids[$country]) ? $available_country_ids[$country] : 0;

			if (!isset($available_zone_ids[$country][$zone])) {
				$zone = html_entity_decode($zone, ENT_QUOTES, 'UTF-8');
			}

			if (!isset($available_zone_ids[$country][$zone])) {
				$zone = htmlentities($zone, ENT_NOQUOTES, 'UTF-8');
			}

			if (!isset($available_zone_ids[$country][$zone])) {
				$zone = html_entity_decode($zone, ENT_QUOTES, 'UTF-8');
				$zone = htmlentities($zone, ENT_QUOTES, 'UTF-8');
			}

			if (!isset($available_zone_ids[$country][$zone])) {
				$zone = html_entity_decode($zone, ENT_QUOTES, 'UTF-8');
				$zone = htmlentities($zone, ENT_NOQUOTES, 'UTF-8');
				$zone = str_replace("'", "&#39;", $zone);
			}

			$zone_id = isset($available_zone_ids[$country][$zone]) ? $available_zone_ids[$country][$zone] : 0;

			$default = $this->getCell($data, $i, $j++, 'no');

			$address = array();

			$address['customer_id'] = $customer_id;
			$address['firstname'] = $firstname;
			$address['lastname'] = $lastname;
			$address['company'] = $company;
			$address['company_id'] = $company_id;
			$address['tax_id'] = $tax_id;
			$address['address_1'] = $address_1;
			$address['address_2'] = $address_2;
			$address['city'] = $city;
			$address['postcode'] = $postcode;
			$address['country_id'] = $country_id;
			$address['zone_id'] = $zone_id;
			$address['default'] = $default;

			if (($incremental) && ($customer_id != $previous_customer_id)) {
				$this->deleteAddress( $customer_id );

				if (isset($unlisted_customer_ids[$customer_id])) {
					unset($unlisted_customer_ids[$customer_id]);
				}
			}

			$this->moreAddressCells($i, $j, $data, $address);

			$this->storeAddressIntoDatabase($address);

			$previous_customer_id = $customer_id;
		}

		if ($incremental) {
			$this->deleteUnlistedAddresses($unlisted_customer_ids);
		}
	}

	// Categories
	protected function getCategoryUrlAliasIds() {
		$url_alias_ids = array();

		$query = $this->db->query("SELECT url_alias_id, SUBSTRING(query, CHAR_LENGTH('category_id=')+1) AS category_id FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'category_id=%'");

		foreach ($query->rows as $row) {
			$url_alias_id = $row['url_alias_id'];
			$category_id = $row['category_id'];

			$url_alias_ids[$category_id] = $url_alias_id;
		}

		return $url_alias_ids;
	}

	// Extract and Insert the Category details
	protected function storeCategoryIntoDatabase(&$category, $languages, &$layout_ids, &$available_store_ids, &$url_alias_ids) {
		$category_id = $category['category_id'];
		$parent_id = $category['parent_id'];
		$top = 0; // Not required
		$columns = 0; // Not required
		$names = $category['names'];
		$descriptions = $category['descriptions'];
		$meta_descriptions = $category['meta_descriptions'];
		$meta_keywords = $category['meta_keywords'];
		$sort_order = $category['sort_order'];
		$image_name = $this->db->escape($category['image']);
		$date_added = $category['date_added'];
		$date_modified = $category['date_modified'];
		$seo_keyword = $category['seo_keyword'];
		$store_ids = $category['store_ids'];
		$layout = $category['layout'];
		$status = $category['status'];
		$status = ((strtoupper($status) == "TRUE") || (strtoupper($status) == "YES") || (strtoupper($status) == "ENABLED")) ? 1 : 0;

		// Generate and execute SQL for inserting the category
		$sql = "INSERT INTO `" . DB_PREFIX . "category` (`category_id`,`image`,`parent_id`,`top`,`column`,`sort_order`,`date_added`,`date_modified`,`status`) VALUES";
		$sql .= " ( $category_id, '$image_name', $parent_id, $top, $columns, $sort_order,";
		$sql .= ($date_added == 'NOW()') ? " '$date_added'," : " '$date_added',";
		$sql .= ($date_modified == 'NOW()') ? " '$date_modified'," : " '$date_modified',";
		$sql .= " $status);";

		$this->db->query($sql);

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$name = isset($names[$language_code]) ? $this->db->escape($names[$language_code]) : '';
			$description = isset($descriptions[$language_code]) ? $this->db->escape($descriptions[$language_code]) : '';
			$meta_description = isset($meta_descriptions[$language_code]) ? $this->db->escape($meta_descriptions[$language_code]) : '';
			$meta_keyword = isset($meta_keywords[$language_code]) ? $this->db->escape($meta_keywords[$language_code]) : '';

			$sql = "INSERT INTO `" . DB_PREFIX . "category_description` (`category_id`,`language_id`,`name`,`description`,`meta_description`,`meta_keyword`) VALUES";
			$sql .= " ( $category_id, $language_id, '$name', '$description', '$meta_description', '$meta_keyword');";

			$this->db->query($sql);
		}

		if ($seo_keyword) {
			if (isset($url_alias_ids[$category_id])) {
				$url_alias_id = $url_alias_ids[$category_id];

				$sql = "INSERT INTO `" . DB_PREFIX . "url_alias` (`url_alias_id`,`query`,`keyword`) VALUES ( $url_alias_id, 'category_id=$category_id', '$seo_keyword');";

				unset($url_alias_ids[$category_id]);
			} else {
				$sql = "INSERT INTO `" . DB_PREFIX . "url_alias` (`query`,`keyword`) VALUES ('category_id=$category_id', '$seo_keyword');";
			}

			$this->db->query($sql);
		}

		foreach ($store_ids as $store_id) {
			if (in_array((int)$store_id, $available_store_ids)) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_to_store` (`category_id`,`store_id`) VALUES ( $category_id, $store_id);");
			}
		}

		$layouts = array();

		foreach ($layout as $layout_part) {
			$next_layout = explode(':', $layout_part);

			if ($next_layout === false) {
				$next_layout = array(0, $layout_part);
			} elseif (count($next_layout) == 1) {
				$next_layout = array(0, $layout_part);
			}

			if ((count($next_layout) == 2) && (in_array((int)$next_layout[0], $available_store_ids)) && (is_string($next_layout[1]))) {
				$store_id = (int)$next_layout[0];
				$layout_name = $next_layout[1];

				if (isset($layout_ids[$layout_name])) {
					$layout_id = (int)$layout_ids[$layout_name];

					if (!isset($layouts[$store_id])) {
						$layouts[$store_id] = $layout_id;
					}
				}
			}
		}

		foreach ($layouts as $store_id => $layout_id) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_to_layout` (`category_id`,`store_id`,`layout_id`) VALUES ( $category_id, $store_id, $layout_id);");
		}
	}

	protected function deleteCategory($category_id) {
		$sql = "DELETE FROM `" . DB_PREFIX . "category` WHERE category_id = '" . (int)$category_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "category_description` WHERE category_id = '" . (int)$category_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "category_to_store` WHERE category_id = '" . (int)$category_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "category_to_layout` WHERE category_id = '" . (int)$category_id . "';\n";

		$sql .= "DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'category_id=" . (int)$category_id . "';\n";

		$this->multiquery($sql);

		$query = $this->db->query("SHOW TABLES LIKE \"" . DB_PREFIX . "category_path\"");

		if ($query->num_rows) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_id . "'");
		}
	}

	protected function deleteCategories(&$url_alias_ids) {
		$sql = "TRUNCATE TABLE `" . DB_PREFIX . "category`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "category_description`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "category_to_store`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "category_to_layout`;\n";

		$sql .= "DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'category_id=%';\n";

		$this->multiquery($sql);

		$query = $this->db->query("SHOW TABLES LIKE \"" . DB_PREFIX . "category_path\"");

		if ($query->num_rows) {
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "category_path`");
		}

		$alias_query = $this->db->query("SELECT (MAX(url_alias_id)+1) AS next_url_alias_id FROM `" . DB_PREFIX . "url_alias`");

		$next_url_alias_id = $alias_query->row['next_url_alias_id'];

		$this->db->query("ALTER TABLE `" . DB_PREFIX . "url_alias` AUTO_INCREMENT = " . (int)$next_url_alias_id);

		$remove = array();

		foreach ($url_alias_ids as $category_id => $url_alias_id) {
			if ($url_alias_id >= $next_url_alias_id) {
				$remove[$category_id] = $url_alias_id;
			}
		}

		foreach ($remove as $category_id => $url_alias_id) {
			unset($url_alias_ids[$category_id]);
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreCategoryCells($i, $j, $worksheet, &$category) {
		return;
	}

	protected function uploadCategories($reader, $incremental, &$available_category_ids = array()) {
		// Get worksheet if present
		$data = $reader->getSheetByName('Categories');

		if ($data == null) {
			return;
		}

		// Get old url_alias_ids
		$url_alias_ids = $this->getCategoryUrlAliasIds();

		// If incremental, then find current category ids, else delete all old categories
		$available_category_ids = array();

		if ($incremental) {
			$available_category_ids = $this->getAvailableCategoryIds();
		} else {
			$this->deleteCategories($url_alias_ids);
		}

		// Get layouts
		$layout_ids = $this->getLayoutIds();

		// Get store_ids
		$available_store_ids = $this->getAvailableStoreIds();

		// Get languages
		$languages = $this->getLanguages();

		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$category_id = trim($this->getCell($data, $i, $j++));

			if ($category_id == "") {
				continue;
			}

			$parent_id = $this->getCell($data, $i, $j++, '0');

			$names = array();

			while ($this->startsWith($first_row[$j-1], "name(")) {
				$language_code = substr($first_row[$j-1], strlen("name("), strlen($first_row[$j-1])-strlen("name(")-1);
				$name = $this->getCell($data, $i, $j++);
				$name = htmlspecialchars($name);
				$names[$language_code] = $name;
			}

			$descriptions = array();

			while ($this->startsWith($first_row[$j-1], "description(")) {
				$language_code = substr($first_row[$j-1], strlen("description("), strlen($first_row[$j-1])-strlen("description(")-1);
				$description = $this->getCell($data, $i, $j++);
				$description = htmlspecialchars($description);
				$descriptions[$language_code] = $description;
			}

			$meta_descriptions = array();

			while ($this->startsWith($first_row[$j-1], "meta_description(")) {
				$language_code = substr($first_row[$j-1], strlen("meta_description("), strlen($first_row[$j-1])-strlen("meta_description(")-1);
				$meta_description = $this->getCell($data, $i, $j++);
				$meta_description = htmlspecialchars($meta_description);
				$meta_descriptions[$language_code] = $meta_description;
			}

			$meta_keywords = array();

			while ($this->startsWith($first_row[$j-1], "meta_keywords(")) {
				$language_code = substr($first_row[$j-1], strlen("meta_keywords("), strlen($first_row[$j-1])-strlen("meta_keywords(")-1);
				$meta_keyword = $this->getCell($data, $i, $j++);
				$meta_keyword = htmlspecialchars($meta_keyword);
				$meta_keywords[$language_code] = $meta_keyword;
			}

			$sort_order = $this->getCell($data, $i, $j++, '0');
			$image_name = $this->getCell($data, $i, $j++);
			$date_added = trim($this->getCell($data, $i, $j++));
			$date_added = ((is_string($date_added)) && (strlen($date_added) > 0)) ? $date_added : "NOW()";
			$date_modified = trim($this->getCell($data, $i, $j++));
			$date_modified = ((is_string($date_modified)) && (strlen($date_modified) > 0)) ? $date_modified : "NOW()";
			$seo_keyword = $this->getCell($data, $i, $j++);
			$store_ids = $this->getCell($data, $i, $j++);
			$layout = $this->getCell($data, $i, $j++, '');
			$status = $this->getCell($data, $i, $j++, 'true');

			$category = array();

			$category['category_id'] = $category_id;
			$category['parent_id'] = $parent_id;
			$category['names'] = $names;
			$category['descriptions'] = $descriptions;
			$category['meta_descriptions'] = $meta_descriptions;
			$category['meta_keywords'] = $meta_keywords;
			$category['sort_order'] = $sort_order;
			$category['image'] = $image_name;
			$category['date_added'] = $date_added;
			$category['date_modified'] = $date_modified;
			$category['seo_keyword'] = $seo_keyword;

			$store_ids = trim($this->clean($store_ids, false));

			$category['store_ids'] = ($store_ids == "") ? array() : explode(",", $store_ids);
			if ($category['store_ids'] === false) {
				$category['store_ids'] = array();
			}

			$category['layout'] = ($layout == "") ? array() : explode(",", $layout);
			if ($category['layout'] === false) {
				$category['layout'] = array();
			}

			$category['status'] = $status;

			if ($incremental) {
				if ($available_category_ids) {
					if (in_array((int)$category_id, $available_category_ids)) {
						$this->deleteCategory($category_id);
					}
				}
			}

			$this->moreCategoryCells($i, $j, $data, $category);

			$this->storeCategoryIntoDatabase($category, $languages, $layout_ids, $available_store_ids, $url_alias_ids);
		}

		// Restore Category paths (Repair)
		$this->load->model('catalog/category');

		if (method_exists($this->model_catalog_category, 'repairCategories')) {
			$this->model_catalog_category->repairCategories(0);
		}
	}

	protected function storeCategoryFilterIntoDatabase(&$category_filter, $languages) {
		$category_id = $category_filter['category_id'];
		$filter_id = $category_filter['filter_id'];

		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_filter` (`category_id`,`filter_id`) VALUES ( $category_id, $filter_id);");
	}

	protected function deleteCategoryFilters() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "category_filter`");
	}

	protected function deleteCategoryFilter($category_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "category_filter` WHERE category_id = '" . (int)$category_id . "'");
	}

	protected function deleteUnlistedCategoryFilters($unlisted_category_ids) {
		foreach ($unlisted_category_ids as $category_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_filter` WHERE category_id = '" . (int)$category_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreCategoryFilterCells($i, $j, $worksheet, &$category_filter) {
		return;
	}

	protected function uploadCategoryFilters($reader, $incremental, &$available_category_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('CategoryFilters');

		if ($data == null) {
			return;
		}

		// If incremental then find current category IDs else delete all old category filters
		if ($incremental) {
			$unlisted_category_ids = $available_category_ids;
		} else {
			$this->deleteCategoryFilters();
		}

		if (!$this->config->get('export_import_settings_use_filter_group_id')) {
			$filter_group_ids = $this->getFilterGroupIds();
		}

		if (!$this->config->get('export_import_settings_use_filter_id')) {
			$filter_ids = $this->getFilterIds();
		}

		// Load the worksheet cells and store them to the database
		$languages = $this->getLanguages();
		$previous_category_id = 0;

		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$category_id = trim($this->getCell($data, $i, $j++));

			if ($category_id == '') {
				continue;
			}

			if ($this->config->get('export_import_settings_use_filter_group_id')) {
				$filter_group_id = $this->getCell($data, $i, $j++, '');
			} else {
				$filter_group_name = $this->getCell($data, $i, $j++);
				$filter_group_id = isset($filter_group_ids[$filter_group_name]) ? $filter_group_ids[$filter_group_name] : '';
			}

			if ($filter_group_id == '') {
				continue;
			}

			if ($this->config->get('export_import_settings_use_filter_id')) {
				$filter_id = $this->getCell($data, $i, $j++, '');
			} else {
				$filter_name = $this->getCell($data, $i, $j++);
				$filter_id = isset($filter_ids[$filter_group_id][$filter_name]) ? $filter_ids[$filter_group_id][$filter_name] : '';
			}

			if ($filter_id == '') {
				continue;
			}

			$category_filter = array();

			$category_filter['category_id'] = $category_id;
			$category_filter['filter_group_id'] = $filter_group_id;
			$category_filter['filter_id'] = $filter_id;

			if (($incremental) && ($category_id != $previous_category_id)) {
				$this->deleteCategoryFilter($category_id);

				if (isset($unlisted_category_ids[$category_id])) {
					unset($unlisted_category_ids[$category_id]);
				}
			}

			$this->moreCategoryFilterCells($i, $j, $data, $category_filter);

			$this->storeCategoryFilterIntoDatabase($category_filter, $languages);

			$previous_category_id = $category_id;
		}

		if ($incremental) {
			$this->deleteUnlistedCategoryFilters($unlisted_category_ids);
		}
	}

	protected function getProductViewCounts() {
		$view_counts = array();

		$query = $this->db->query("SELECT product_id, viewed FROM `" . DB_PREFIX . "product`;");

		foreach ($query->rows as $row) {
			$product_id = $row['product_id'];
			$viewed = $row['viewed'];
			$view_counts[$product_id] = $viewed;
		}

		return $view_counts;
	}

	protected function getProductUrlAliasIds() {
		$url_alias_ids = array();

		$query = $this->db->query("SELECT url_alias_id, SUBSTRING(query, CHAR_LENGTH('product_id=')+1 ) AS product_id FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'product_id=%'");

		foreach ($query->rows as $row) {
			$url_alias_id = $row['url_alias_id'];
			$product_id = $row['product_id'];
			$url_alias_ids[$product_id] = $url_alias_id;
		}

		return $url_alias_ids;
	}

	// Extract and Insert the product details
	protected function storeProductIntoDatabase(&$product, $languages, &$layout_ids, &$available_store_ids, &$manufacturers, &$weight_class_ids, &$length_class_ids, &$url_alias_ids) {
		$product_id = $product['product_id'];
		$names = $product['names'];
		$categories = $product['categories'];
		$quantity = $product['quantity'];
		$model = $this->db->escape($product['model']);
		$manufacturer_name = $this->db->escape($product['manufacturer_name']);
		$image = $this->db->escape($product['image']);
		$label = $this->db->escape($product['label']);
		$shipping = $product['shipping'];
		$shipping = ((strtoupper($shipping) == "YES") || (strtoupper($shipping) == "Y") || (strtoupper($shipping) == "TRUE")) ? 1 : 0;
		$price = trim($product['price']);
		$cost = trim($product['cost']);
		$quote = $product['quote'];
		$quote = ((strtoupper($quote) == "TRUE") || (strtoupper($quote) == "YES") || (strtoupper($quote) == "ENABLED")) ? 1 : 0;
		$age_minimum = $product['age_minimum'];
		$points = $product['points'];
		$date_added = $product['date_added'];
		$date_modified = $product['date_modified'];
		$date_available = $product['date_available'];
		$palette_id = $product['palette_id'];
		$weight = ($product['weight'] == "") ? 0 : $product['weight'];
		$weight_unit = $product['weight_unit'];
		$weight_class_id = (isset($weight_class_ids[$weight_unit])) ? $weight_class_ids[$weight_unit] : 0;
		$status = $product['status'];
		$status = ((strtoupper($status) == "TRUE") || (strtoupper($status) == "YES") || (strtoupper($status) == "ENABLED")) ? 1 : 0;
		$tax_class_id = $product['tax_class_id'];
		$descriptions = $product['descriptions'];
		$stock_status_id = $product['stock_status_id'];
		$meta_descriptions = $product['meta_descriptions'];
		$length = $product['length'];
		$width = $product['width'];
		$height = $product['height'];
		$keyword = $this->db->escape($product['seo_keyword']);
		$length_unit = $product['measurement_unit'];
		$length_class_id = (isset($length_class_ids[$length_unit])) ? $length_class_ids[$length_unit] : 0;
		$sku = $this->db->escape($product['sku']);
		$upc = $this->db->escape($product['upc']);
		$ean = $this->db->escape($product['ean']);
		$jan = $this->db->escape($product['jan']);
		$isbn = $this->db->escape($product['isbn']);
		$mpn = $this->db->escape($product['mpn']);
		$location = $this->db->escape($product['location']);
		$store_ids = $product['store_ids'];
		$layout = $product['layout'];
		$related_ids = $product['related_ids'];
		$location_ids = $product['location_ids'];
		$subtract = $product['subtract'];
		$subtract = ((strtoupper($subtract) == "TRUE") || (strtoupper($subtract) == "YES") || (strtoupper($subtract) == "ENABLED")) ? 1 : 0;
		$minimum = $product['minimum'];
		$meta_keywords = $product['meta_keywords'];
		$tags = $product['tags'];
		$sort_order = $product['sort_order'];
		$viewed = $product['viewed'];

		if ($manufacturer_name) {
			$this->storeManufacturerIntoDatabase($manufacturers, $manufacturer_name, $store_ids, $available_store_ids);

			$manufacturer_id = $manufacturers[$manufacturer_name]['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}

		// Generate and execute SQL for inserting the product
		$sql = "INSERT INTO `" . DB_PREFIX . "product` (`product_id`,`quantity`,`sku`,`upc`,`ean`,`jan`,`isbn`,`mpn`,";
		$sql .= "`location`,`stock_status_id`,`model`,`manufacturer_id`,`image`,`label`,`shipping`,`price`,`cost`,`quote`,`age_minimum`,`points`,`date_added`,`date_modified`,`date_available`,`palette_id`,`weight`,`weight_class_id`,`status`,";
		$sql .= "`tax_class_id`,`length`,`width`,`height`,`length_class_id`,`sort_order`,`subtract`,`minimum`,`viewed`) VALUES";
		$sql .= " ( $product_id, $quantity, '$sku', '$upc', '$ean', '$jan', '$isbn', '$mpn',";
		$sql .= " '$location', $stock_status_id, '$model', $manufacturer_id, '$image', '$label', $shipping, $price, $cost, '$quote', $age_minimum, $points,";
		$sql .= ($date_added == 'NOW()') ? " '$date_added'," : " '$date_added',";
		$sql .= ($date_modified == 'NOW()') ? " '$date_modified'," : " '$date_modified',";
		$sql .= ($date_available == 'NOW()') ? " '$date_available'," : " '$date_available',";
		$sql .= " $palette_id, $weight, $weight_class_id, $status,";
		$sql .= " $tax_class_id, $length, $width, $height, '$length_class_id', '$sort_order', '$subtract', '$minimum', $viewed);";

		$this->db->query($sql);

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$name = isset($names[$language_code]) ? $this->db->escape($names[$language_code]) : '';
			$description = isset($descriptions[$language_code]) ? $this->db->escape($descriptions[$language_code]) : '';
			$meta_description = isset($meta_descriptions[$language_code]) ? $this->db->escape($meta_descriptions[$language_code]) : '';
			$meta_keyword = isset($meta_keywords[$language_code]) ? $this->db->escape($meta_keywords[$language_code]) : '';
			$tag = isset($tags[$language_code]) ? $this->db->escape($tags[$language_code]) : '';

			$descriptions_sql = "INSERT INTO `" . DB_PREFIX . "product_description` (`product_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`, `tag`) VALUES";
			$descriptions_sql .= " ( $product_id, $language_id, '$name', '$description', '$meta_description', '$meta_keyword', '$tag');";

			$this->db->query($descriptions_sql);

			$tags_sql = "INSERT INTO `" . DB_PREFIX . "product_tag` (`product_id`,`language_id`,`tag`) VALUES  ( $product_id, $language_id, '$tag');";

			$this->db->query($tags_sql);
		}

		if (count($categories) > 0) {
			$categories_sql = "INSERT INTO `" . DB_PREFIX . "product_to_category` (`product_id`,`category_id`) VALUES";

			$first = true;

			foreach ($categories as $category_id) {
				$categories_sql .= ($first) ? "\n" : ",\n";

				$first = false;

				$categories_sql .= " ( $product_id, $category_id)";
			}

			$categories_sql .= ";";

			$this->db->query($categories_sql);
		}

		if ($product['video_code']) {
			$product_id = $product['product_id'];
			$video_code = $product['video_code'];

			$product_ids = $this->getExistingVideoProductIds();

			if (!in_array((int)$product_id, $product_ids)) {
				$video_code_sql = "INSERT INTO `" . DB_PREFIX . "product_youtube` (`product_id`,`video_code`) VALUES ( $product_id, '$video_code');";
			} else {
				$video_code_sql = "UPDATE `" . DB_PREFIX . "product_youtube` SET video_code = '" . $this->db->escape($video_code) . "' WHERE product_id = '" . (int)$product_id . "'";
			}

			$this->db->query($video_code_sql);
		}

		if ($product['tax_local_rate_id']) {
			$product_id = $product['product_id'];
			$tax_local_rate_id = $product['tax_local_rate_id'];

			$product_ids = $this->getExistingProductTaxLocalRateIds();

			if (!in_array((int)$product_id, $product_ids)) {
				$tax_local_rate_sql = "INSERT INTO `" . DB_PREFIX . "product_tax_local_rate` (`product_id`,`tax_local_rate_id`) VALUES ( $product_id, '$tax_local_rate_id');";
			} else {
				$tax_local_rate_sql = "UPDATE `" . DB_PREFIX . "product_tax_local_rate` SET tax_local_rate_id = '" . (int)$tax_local_rate_id . "' WHERE product_id = '" . (int)$product_id . "'";
			}

			$this->db->query($tax_local_rate_sql);
		}

		if ($keyword) {
			if (isset($url_alias_ids[$product_id])) {
				$url_alias_id = $url_alias_ids[$product_id];

				$url_alias_sql = "INSERT INTO `" . DB_PREFIX . "url_alias` (`url_alias_id`,`query`,`keyword`) VALUES ( $url_alias_id, 'product_id=$product_id', '$keyword');";

				unset($url_alias_ids[$product_id]);
			} else {
				$url_alias_sql = "INSERT INTO `" . DB_PREFIX . "url_alias` (`query`,`keyword`) VALUES ( 'product_id=$product_id', '$keyword');";
			}

			$this->db->query($url_alias_sql);
		}

		foreach ($store_ids as $store_id) {
			if (in_array((int)$store_id, $available_store_ids)) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_to_store` (`product_id`,`store_id`) VALUES ( $product_id, $store_id);");
			}
		}

		$layouts = array();

		foreach ($layout as $layout_part) {
			$next_layout = explode(':', $layout_part);

			if ($next_layout === false) {
				$next_layout = array(0, $layout_part);
			} elseif (count($next_layout) == 1) {
				$next_layout = array(0, $layout_part);
			}

			if ((count($next_layout) == 2) && (in_array((int)$next_layout[0], $available_store_ids)) && (is_string($next_layout[1]))) {
				$store_id = (int)$next_layout[0];
				$layout_name = $next_layout[1];

				if (isset($layout_ids[$layout_name])) {
					$layout_id = (int)$layout_ids[$layout_name];

					if (!isset($layouts[$store_id])) {
						$layouts[$store_id] = $layout_id;
					}
				}
			}
		}

		foreach ($layouts as $store_id => $layout_id) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "product_to_layout` (`product_id`,`store_id`,`layout_id`) VALUES ( $product_id, $store_id, $layout_id);");
		}

		if (count($related_ids) > 0) {
			$related_sql = "INSERT INTO `" . DB_PREFIX . "product_related` (`product_id`,`related_id`) VALUES";

			$first = true;

			foreach ($related_ids as $related_id) {
				$related_sql .= ($first) ? "\n" : ",\n";

				$first = false;

				$related_sql .= " ( $product_id, $related_id)";
			}

			$related_sql .= ";";

			$this->db->query($related_sql);
		}

		if (count($location_ids) > 0) {
			$location_sql = "INSERT INTO `" . DB_PREFIX . "product_to_location` (`product_id`,`location_id`) VALUES";

			$first = true;

			foreach ($location_ids as $location_id) {
				$location_sql .= ($first) ? "\n" : ",\n";

				$first = false;

				$location_sql .= " ( $product_id, $location_id)";
			}

			$location_sql .= ";";

			$this->db->query($location_sql);
		}
	}

	protected function deleteProducts(&$url_alias_ids) {
		$sql = "TRUNCATE TABLE `" . DB_PREFIX . "product`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "product_color`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "product_description`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "product_to_category`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "product_to_store`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "product_related`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "product_to_layout`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "product_to_location`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "product_tax_local_rate`;\n";
		$sql .= "TRUNCATE TABLE `" . DB_PREFIX . "product_tag`;\n";

		$sql .= "DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'product_id=%';\n";

		$this->multiquery($sql);

		$alias_query = $this->db->query("SELECT (MAX(url_alias_id)+1) AS next_url_alias_id FROM `" . DB_PREFIX . "url_alias`");

		$next_url_alias_id = $alias_query->row['next_url_alias_id'];

		$this->db->query("ALTER TABLE `" . DB_PREFIX . "url_alias` AUTO_INCREMENT = " . (int)$next_url_alias_id);

		$remove = array();

		foreach ($url_alias_ids as $product_id => $url_alias_id) {
			if ($url_alias_id >= $next_url_alias_id) {
				$remove[$product_id] = $url_alias_id;
			}
		}

		foreach ($remove as $product_id => $url_alias_id) {
			unset($url_alias_ids[$product_id]);
		}
	}

	protected function deleteProduct(&$product_id) {
		$sql = "DELETE FROM `" . DB_PREFIX . "product` WHERE product_id = '" . (int)$product_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "product_color` WHERE product_id = '" . (int)$product_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "product_description` WHERE product_id = '" . (int)$product_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "product_to_category` WHERE product_id = '" . (int)$product_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "product_to_store` WHERE product_id = '" . (int)$product_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "product_related` WHERE product_id = '" . (int)$product_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "product_to_layout` WHERE product_id = '" . (int)$product_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "product_to_location` WHERE product_id = '" . (int)$product_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "product_tax_local_rate` WHERE product_id = '" . (int)$product_id . "';\n";
		$sql .= "DELETE FROM `" . DB_PREFIX . "product_tag` WHERE product_id = '" . (int)$product_id . "';\n";

		$sql .= "DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'product_id=" . (int)$product_id . "';\n";

		$this->multiquery($sql);
	}

	// Function for reading additional cells in class extensions
	protected function moreProductCells($i, $j, $worksheet, &$product) {
		return;
	}

	protected function uploadProducts($reader, $incremental, &$available_product_ids = array()) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Products');

		if ($data == null) {
			return;
		}

		// Save product view counts
		$view_counts = $this->getProductViewCounts();

		// Save old url_alias_ids
		$url_alias_ids = $this->getProductUrlAliasIds();

		// If incremental then find current product IDs else delete all old products
		$available_product_ids = array();

		if ($incremental) {
			$available_product_ids = $this->getAvailableProductIds($data);
		} else {
			$this->deleteProducts($url_alias_ids);
		}

		// Get pre-defined layouts
		$layout_ids = $this->getLayoutIds();

		// Get pre-defined store_ids
		$available_store_ids = $this->getAvailableStoreIds();

		// Get installed languages
		$languages = $this->getLanguages();

		// Get default units
		$default_weight_unit = $this->getDefaultWeightUnit();
		$default_measurement_unit = $this->getDefaultMeasurementUnit();
		$default_stock_status_id = $this->config->get('config_stock_status_id');

		// Get manufacturers, only newly specified manufacturers will be added
		$manufacturers = $this->getManufacturers();

		// Get weight classes
		$weight_class_ids = $this->getWeightClassIds();

		// Get length classes
		$length_class_ids = $this->getLengthClassIds();

		// Load the worksheet cells and store them to the database
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == "") {
				continue;
			}

			$names = array();

			while ($this->startsWith($first_row[$j-1], "name(")) {
				$language_code = substr($first_row[$j-1], strlen("name("), strlen($first_row[$j-1])-strlen("name(")-1);
				$name = $this->getCell($data, $i, $j++);
				$name = htmlspecialchars($name);
				$names[$language_code] = $name;
			}

			$categories = $this->getCell($data, $i, $j++);
			$sku = $this->getCell($data, $i, $j++, '');
			$upc = $this->getCell($data, $i, $j++, '');
			$ean = $this->getCell($data, $i, $j++, '');
			$jan = $this->getCell($data, $i, $j++, '');
			$isbn = $this->getCell($data, $i, $j++, '');
			$mpn = $this->getCell($data, $i, $j++, '');
			$location = $this->getCell($data, $i, $j++, '');
			$quantity = $this->getCell($data, $i, $j++, '0');
			$model = $this->getCell($data, $i, $j++, '   ');
			$manufacturer_name = $this->getCell($data, $i, $j++);
			$image_name = $this->getCell($data, $i, $j++);
			$label_name = $this->getCell($data, $i, $j++);
			$video_code = $this->getCell($data, $i, $j++);
			$shipping = $this->getCell($data, $i, $j++, 'Yes');
			$price = $this->getCell($data, $i, $j++, '0.00');
			$cost = $this->getCell($data, $i, $j++, '0.00');
			$quote = $this->getCell($data, $i, $j++, 'false');
			$age_minimum = $this->getCell($data, $i, $j++, '');
			$points = $this->getCell($data, $i, $j++, '0');
			$date_added = $this->getCell($data, $i, $j++);
			$date_added = ((is_string($date_added)) && (strlen($date_added) > 0)) ? $date_added : "NOW()";
			$date_modified = $this->getCell($data, $i, $j++);
			$date_modified = ((is_string($date_modified)) && (strlen($date_modified) > 0)) ? $date_modified : "NOW()";
			$date_available = $this->getCell($data, $i, $j++);
			$date_available = ((is_string($date_available)) && (strlen($date_available) > 0)) ? $date_available : "NOW()";
			$palette_id = $this->getCell($data, $i, $j++, '0');
			$weight = $this->getCell($data, $i, $j++, '0');
			$weight_unit = $this->getCell($data, $i, $j++, $default_weight_unit);
			$length = $this->getCell($data, $i, $j++, '0');
			$width = $this->getCell($data, $i, $j++, '0');
			$height = $this->getCell($data, $i, $j++, '0');
			$measurement_unit = $this->getCell($data, $i, $j++, $default_measurement_unit);
			$status = $this->getCell($data, $i, $j++, 'true');
			$tax_class_id = $this->getCell($data, $i, $j++, '0');
			$tax_local_rate_id = $this->getCell($data, $i, $j++, '0');
			$keyword = $this->getCell($data, $i, $j++);

			$descriptions = array();

			while ($this->startsWith($first_row[$j-1], "description(")) {
				$language_code = substr($first_row[$j-1], strlen("description("), strlen($first_row[$j-1])-strlen("description(")-1);
				$description = $this->getCell($data, $i, $j++);
				$description = htmlspecialchars($description);
				$descriptions[$language_code] = $description;
			}

			$meta_descriptions = array();

			while ($this->startsWith($first_row[$j-1], "meta_description(")) {
				$language_code = substr($first_row[$j-1], strlen("meta_description("), strlen($first_row[$j-1])-strlen("meta_description(")-1);
				$meta_description = $this->getCell($data, $i, $j++);
				$meta_description = htmlspecialchars($meta_description);
				$meta_descriptions[$language_code] = $meta_description;
			}

			$meta_keywords = array();

			while ($this->startsWith($first_row[$j-1], "meta_keywords(")) {
				$language_code = substr($first_row[$j-1], strlen("meta_keywords("), strlen($first_row[$j-1])-strlen("meta_keywords(")-1);
				$meta_keyword = $this->getCell($data, $i, $j++);
				$meta_keyword = htmlspecialchars($meta_keyword);
				$meta_keywords[$language_code] = $meta_keyword;
			}

			$stock_status_id = $this->getCell($data, $i, $j++, $default_stock_status_id);
			$store_ids = $this->getCell($data, $i, $j++);
			$layout = $this->getCell($data, $i, $j++);
			$related = $this->getCell($data, $i, $j++);
			$location = $this->getCell($data, $i, $j++);

			$tags = array();

			while ($this->startsWith($first_row[$j-1], "tags(")) {
				$language_code = substr($first_row[$j-1], strlen("tags("), strlen($first_row[$j-1])-strlen("tags(")-1);
				$tag = $this->getCell($data, $i, $j++);
				$tag = htmlspecialchars($tag);
				$tags[$language_code] = $tag;
			}

			$sort_order = $this->getCell($data, $i, $j++, '0');
			$subtract = $this->getCell($data, $i, $j++, 'true');
			$minimum = $this->getCell($data, $i, $j++, '1');

			$product = array();

			$product['product_id'] = $product_id;
			$product['names'] = $names;

			$categories = trim($this->clean($categories, false));
			$product['categories'] = ($categories == "") ? array() : explode(",", $categories);

			$product['quantity'] = $quantity;
			$product['model'] = $model;
			$product['manufacturer_name'] = $manufacturer_name;
			$product['image'] = $image_name;
			$product['label'] = $label_name;
			$product['video_code'] = $video_code;
			$product['shipping'] = $shipping;
			$product['price'] = $price;
			$product['cost'] = $cost;
			$product['quote'] = $quote;
			$product['age_minimum'] = $age_minimum;
			$product['points'] = $points;
			$product['date_added'] = $date_added;
			$product['date_modified'] = $date_modified;
			$product['date_available'] = $date_available;
			$product['palette_id'] = $palette_id;
			$product['weight'] = $weight;
			$product['weight_unit'] = $weight_unit;
			$product['status'] = $status;
			$product['tax_class_id'] = $tax_class_id;
			$product['tax_local_rate_id'] = $tax_local_rate_id;
			$product['viewed'] = isset($view_counts[$product_id]) ? $view_counts[$product_id] : 0;
			$product['descriptions'] = $descriptions;
			$product['stock_status_id'] = $stock_status_id;
			$product['meta_descriptions'] = $meta_descriptions;
			$product['length'] = $length;
			$product['width'] = $width;
			$product['height'] = $height;
			$product['seo_keyword'] = $keyword;
			$product['measurement_unit'] = $measurement_unit;
			$product['sku'] = $sku;
			$product['upc'] = $upc;
			$product['ean'] = $ean;
			$product['jan'] = $jan;
			$product['isbn'] = $isbn;
			$product['mpn'] = $mpn;
			$product['location'] = $location;
			$store_ids = trim($this->clean($store_ids, false));
			$product['store_ids'] = ($store_ids == "") ? array() : explode(",", $store_ids);
			if ($product['store_ids'] === false) {
				$product['store_ids'] = array();
			}
			$product['related_ids'] = ($related == "") ? array() : explode(",", $related);
			if ($product['related_ids'] === false) {
				$product['related_ids'] = array();
			}
			$product['location_ids'] = ($location == "") ? array() : explode(",", $location);
			if ($product['location_ids'] === false) {
				$product['location_ids'] = array();
			}
			$product['layout'] = ($layout == "") ? array() : explode(",", $layout);
			if ($product['layout'] === false) {
				$product['layout'] = array();
			}
			$product['subtract'] = $subtract;
			$product['minimum'] = $minimum;
			$product['meta_keywords'] = $meta_keywords;
			$product['tags'] = $tags;
			$product['sort_order'] = $sort_order;

			if ($incremental) {
				$this->deleteProduct($product_id);
			}

			$this->moreProductCells($i, $j, $data, $product);

			$this->storeProductIntoDatabase($product, $languages, $layout_ids, $available_store_ids, $manufacturers, $weight_class_ids, $length_class_ids, $url_alias_ids);
		}
	}

	// Write Product Additional Images
	protected function storeAdditionalImageIntoDatabase(&$image, &$old_product_image_ids) {
		$product_id = $image['product_id'];
		$image_name = $image['image_name'];
		$palette_color_id = $image['palette_color_id'];
		$sort_order = $image['sort_order'];

		if (isset($old_product_image_ids[$product_id][$image_name])) {
			$product_image_id = $old_product_image_ids[$product_id][$image_name];

			$sql = "INSERT INTO `" . DB_PREFIX . "product_image` (`product_image_id`,`product_id`,`image`,`palette_color_id`,`sort_order`) VALUES";
			$sql .= " ( $product_image_id, $product_id, '" . $this->db->escape($image_name) . "', $palette_color_id, $sort_order);";

			$this->db->query($sql);

			unset($old_product_image_ids[$product_id][$image_name]);

		} else {
			$sql = "INSERT INTO `" . DB_PREFIX . "product_image` (`product_id`,`image`,`palette_color_id`,`sort_order`) VALUES";
			$sql .= " ( $product_id, '" . $this->db->escape($image_name) . "', $palette_color_id, $sort_order);";

			$this->db->query($sql);
		}
	}

	protected function deleteAdditionalImages() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_image`");
	}

	protected function deleteAdditionalImage(&$product_id) {
		$old_product_image_ids = array();

		$query = $this->db->query("SELECT product_image_id, product_id, `image` FROM `" . DB_PREFIX . "product_image` WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $row) {
			$product_image_id = $row['product_image_id'];
			$product_id = $row['product_id'];
			$image_name = $row['image'];

			$old_product_image_ids[$product_id][$image_name] = $product_image_id;
		}

		if ($old_product_image_ids) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_image` WHERE product_id = '" . (int)$product_id . "'");
		}

		return $old_product_image_ids;
	}

	protected function deleteUnlistedAdditionalImages(&$unlisted_product_ids) {
		foreach ($unlisted_product_ids as $product_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_image` WHERE product_id = '" . (int)$product_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreAdditionalImageCells($i, $j, $worksheet, &$image) {
		return;
	}

	protected function uploadAdditionalImages($reader, $incremental, &$available_product_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('AdditionalImages');

		if ($data == null) {
			return;
		}

		// If incremental then find current product IDs else delete all old additional images
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteAdditionalImages();
		}

		// Load the worksheet cells and store them to the database
		$old_product_image_ids = array();
		$previous_product_id = 0;

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			$j = 1;

			if ($i == 0) {
				continue;
			}

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == "") {
				continue;
			}

			$image_name = $this->getCell($data, $i, $j++, '');
			$palette_color_id = $this->getCell($data, $i, $j++);
			$sort_order = $this->getCell($data, $i, $j++, '0');

			$image = array();

			$image['product_id'] = $product_id;
			$image['image_name'] = $image_name;
			$image['palette_color_id'] = $palette_color_id;
			$image['sort_order'] = $sort_order;

			if (($incremental) && ($product_id != $previous_product_id)) {
				$old_product_image_ids = $this->deleteAdditionalImage($product_id);

				if (isset($unlisted_product_ids[$product_id])) {
					unset($unlisted_product_ids[$product_id]);
				}
			}

			$this->moreAdditionalImageCells($i, $j, $data, $image);

			$this->storeAdditionalImageIntoDatabase($image, $old_product_image_ids);

			$previous_product_id = $product_id;
		}

		if ($incremental) {
			$this->deleteUnlistedAdditionalImages($unlisted_product_ids);
		}
	}

	// Product Special
	protected function storeSpecialIntoDatabase(&$special, &$old_product_special_ids, &$customer_group_ids) {
		$product_id = $special['product_id'];
		$name = $special['customer_group'];
		$customer_group_id = isset($customer_group_ids[$name]) ? $customer_group_ids[$name] : $this->config->get('config_customer_group_id');
		$priority = $special['priority'];
		$price = $special['price'];
		$date_start = $special['date_start'];
		$date_end = $special['date_end'];

		if (isset($old_product_special_ids[$product_id][$customer_group_id])) {
			$product_special_id = $old_product_special_ids[$product_id][$customer_group_id];

			$sql = "INSERT INTO `" . DB_PREFIX . "product_special` (`product_special_id`,`product_id`,`customer_group_id`,`priority`,`price`,`date_start`,`date_end`) VALUES";
			$sql .= " ( $product_special_id, $product_id, $customer_group_id, $priority, $price, '$date_start', '$date_end');";

			$this->db->query($sql);

			unset($old_product_special_ids[$product_id][$customer_group_id]);

		} else {
			$sql = "INSERT INTO `" . DB_PREFIX . "product_special` (`product_id`,`customer_group_id`,`priority`,`price`,`date_start`,`date_end`) VALUES";
			$sql .= " ( $product_id, $customer_group_id, $priority, $price, '$date_start', '$date_end');";

			$this->db->query($sql);
		}
	}

	protected function deleteSpecials() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_special`");
	}

	protected function deleteSpecial(&$product_id) {
		$old_product_special_ids = array();

		$query = $this->db->query("SELECT product_special_id, product_id, customer_group_id FROM `" . DB_PREFIX . "product_special` WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $row) {
			$product_special_id = $row['product_special_id'];
			$product_id = $row['product_id'];
			$customer_group_id = $row['customer_group_id'];

			$old_product_special_ids[$product_id][$customer_group_id] = $product_special_id;
		}

		if ($old_product_special_ids) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_special` WHERE product_id = '" . (int)$product_id . "'");
		}

		return $old_product_special_ids;
	}

	protected function deleteUnlistedSpecials(&$unlisted_product_ids) {
		foreach ($unlisted_product_ids as $product_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_special` WHERE product_id = '" . (int)$product_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreSpecialCells($i, $j, $worksheet, &$special) {
		return;
	}

	protected function uploadSpecials($reader, $incremental, &$available_product_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Specials');

		if ($data == null) {
			return;
		}

		// If incremental then find current product IDs else delete all old specials
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteSpecials();
		}

		// Get existing customer groups
		$customer_group_ids = $this->getCustomerGroupIds();

		// Load the worksheet cells and store them to the database
		$old_product_special_ids = array();
		$previous_product_id = 0;

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			$j = 1;

			if ($i == 0) {
				continue;
			}

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == "") {
				continue;
			}

			$customer_group = trim($this->getCell($data, $i, $j++));

			if ($customer_group == "") {
				continue;
			}

			$priority = $this->getCell($data, $i, $j++, '0');
			$price = $this->getCell($data, $i, $j++, '0');
			$date_start = $this->getCell($data, $i, $j++, '0000-00-00');
			$date_end = $this->getCell($data, $i, $j++, '0000-00-00');

			$special = array();

			$special['product_id'] = $product_id;
			$special['customer_group'] = $customer_group;
			$special['priority'] = $priority;
			$special['price'] = $price;
			$special['date_start'] = $date_start;
			$special['date_end'] = $date_end;

			if (($incremental) && ($product_id != $previous_product_id)) {
				$old_product_special_ids = $this->deleteSpecial($product_id);

				if (isset($unlisted_product_ids[$product_id])) {
					unset($unlisted_product_ids[$product_id]);
				}
			}

			$this->moreSpecialCells($i, $j, $data, $special);

			$this->storeSpecialIntoDatabase($special, $old_product_special_ids, $customer_group_ids);

			$previous_product_id = $product_id;
		}

		if ($incremental) {
			$this->deleteUnlistedSpecials($unlisted_product_ids);
		}
	}

	// Product Discount
	protected function storeDiscountIntoDatabase(&$discount, &$old_product_discount_ids, &$customer_group_ids) {
		$product_id = $discount['product_id'];
		$name = $discount['customer_group'];
		$customer_group_id = isset($customer_group_ids[$name]) ? $customer_group_ids[$name] : $this->config->get('config_customer_group_id');
		$quantity = $discount['quantity'];
		$priority = $discount['priority'];
		$price = $discount['price'];
		$date_start = $discount['date_start'];
		$date_end = $discount['date_end'];

		if (isset($old_product_discount_ids[$product_id][$customer_group_id][$quantity])) {
			$product_discount_id = $old_product_discount_ids[$product_id][$customer_group_id][$quantity];

			$sql = "INSERT INTO `" . DB_PREFIX . "product_discount` (`product_discount_id`,`product_id`,`customer_group_id`,`quantity`,`priority`,`price`,`date_start`,`date_end`) VALUES";
			$sql .= " ( $product_discount_id, $product_id, $customer_group_id, $quantity, $priority, $price, '$date_start', '$date_end');";

			$this->db->query($sql);

			unset($old_product_discount_ids[$product_id][$customer_group_id][$quantity]);

		} else {
			$sql = "INSERT INTO `" . DB_PREFIX . "product_discount` (`product_id`,`customer_group_id`,`quantity`,`priority`,`price`,`date_start`,`date_end`) VALUES";
			$sql .= " ( $product_id, $customer_group_id, $quantity, $priority, $price, '$date_start', '$date_end');";

			$this->db->query($sql);
		}
	}

	protected function deleteDiscounts() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_discount`");
	}

	protected function deleteDiscount(&$product_id) {
		$old_product_discount_ids = array();

		$sql = "SELECT product_discount_id, product_id, customer_group_id, quantity FROM `" . DB_PREFIX . "product_discount`";
		$sql .= " WHERE product_id = '" . (int)$product_id . "'";
		$sql .= " ORDER BY product_id ASC, customer_group_id ASC, quantity ASC";

		$query = $this->db->query($sql);

		foreach ($query->rows as $row) {
			$product_discount_id = $row['product_discount_id'];
			$product_id = $row['product_id'];
			$customer_group_id = $row['customer_group_id'];
			$quantity = $row['quantity'];

			$old_product_discount_ids[$product_id][$customer_group_id][$quantity] = $product_discount_id;
		}

		if ($old_product_discount_ids) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_discount` WHERE product_id = '" . (int)$product_id . "'");
		}

		return $old_product_discount_ids;
	}

	protected function deleteUnlistedDiscounts(&$unlisted_product_ids) {
		foreach ($unlisted_product_ids as $product_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_discount` WHERE product_id = '" . (int)$product_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreDiscountCells($i, $j, $worksheet, &$discount) {
		return;
	}

	protected function uploadDiscounts($reader, $incremental, &$available_product_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Discounts');

		if ($data == null) {
			return;
		}

		// If incremental then find current product IDs else delete all old discounts
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteDiscounts();
		}

		// Get existing customer groups
		$customer_group_ids = $this->getCustomerGroupIds();

		// Load the worksheet cells and store them to the database
		$old_product_discount_ids = array();
		$previous_product_id = 0;

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			$j = 1;

			if ($i == 0) {
				continue;
			}

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == "") {
				continue;
			}

			$customer_group = trim($this->getCell($data, $i, $j++));

			if ($customer_group == "") {
				continue;
			}

			$quantity = $this->getCell($data, $i, $j++, '0');
			$priority = $this->getCell($data, $i, $j++, '0');
			$price = $this->getCell($data, $i, $j++, '0');
			$date_start = $this->getCell($data, $i, $j++, '0000-00-00');
			$date_end = $this->getCell($data, $i, $j++, '0000-00-00');

			$discount = array();

			$discount['product_id'] = $product_id;
			$discount['customer_group'] = $customer_group;
			$discount['quantity'] = $quantity;
			$discount['priority'] = $priority;
			$discount['price'] = $price;
			$discount['date_start'] = $date_start;
			$discount['date_end'] = $date_end;

			if (($incremental) && ($product_id != $previous_product_id)) {
				$old_product_discount_ids = $this->deleteDiscount($product_id);

				if (isset($unlisted_product_ids[$product_id])) {
					unset($unlisted_product_ids[$product_id]);
				}
			}

			$this->moreDiscountCells($i, $j, $data, $discount);

			$this->storeDiscountIntoDatabase($discount, $old_product_discount_ids, $customer_group_ids);

			$previous_product_id = $product_id;
		}

		if ($incremental) {
			$this->deleteUnlistedDiscounts($unlisted_product_ids);
		}
	}

	// Product Reward
	protected function storeRewardIntoDatabase(&$reward, &$old_product_reward_ids, &$customer_group_ids) {
		$product_id = $reward['product_id'];
		$name = $reward['customer_group'];
		$customer_group_id = isset($customer_group_ids[$name]) ? $customer_group_ids[$name] : $this->config->get('config_customer_group_id');
		$points = $reward['points'];

		if (isset($old_product_reward_ids[$product_id][$customer_group_id])) {
			$product_reward_id = $old_product_reward_ids[$product_id][$customer_group_id];

			$sql = "INSERT INTO `" . DB_PREFIX . "product_reward` (`product_reward_id`,`product_id`,`customer_group_id`,`points`) VALUES";
			$sql .= " ( $product_reward_id, $product_id, $customer_group_id, $points);";

			$this->db->query($sql);

			unset($old_product_reward_ids[$product_id][$customer_group_id]);

		} else {
			$sql = "INSERT INTO `" . DB_PREFIX . "product_reward` (`product_id`,`customer_group_id`,`points`) VALUES";
			$sql .= " ( $product_id, $customer_group_id, $points);";

			$this->db->query($sql);
		}
	}

	protected function deleteRewards() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_reward`");
	}

	protected function deleteReward(&$product_id) {
		$old_product_reward_ids = array();

		$query = $this->db->query("SELECT product_reward_id, product_id, customer_group_id FROM `" . DB_PREFIX . "product_reward` WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $row) {
			$product_reward_id = $row['product_reward_id'];
			$product_id = $row['product_id'];
			$customer_group_id = $row['customer_group_id'];

			$old_product_reward_ids[$product_id][$customer_group_id] = $product_reward_id;
		}

		if ($old_product_reward_ids) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_reward` WHERE product_id = '" . (int)$product_id . "'");
		}

		return $old_product_reward_ids;
	}

	protected function deleteUnlistedRewards(&$unlisted_product_ids) {
		foreach ($unlisted_product_ids as $product_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_reward` WHERE product_id = '" . (int)$product_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreRewardCells($i, $j, $worksheet, &$reward) {
		return;
	}

	protected function uploadRewards($reader, $incremental, &$available_product_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Rewards');

		if ($data == null) {
			return;
		}

		// If incremental then find current product IDs else delete all old rewards
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteRewards();
		}

		// Get existing customer groups
		$customer_group_ids = $this->getCustomerGroupIds();

		// Load the worksheet cells and store them to the database
		$old_product_reward_ids = array();
		$previous_product_id = 0;

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			$j = 1;

			if ($i == 0) {
				continue;
			}

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == "") {
				continue;
			}

			$customer_group = trim($this->getCell($data, $i, $j++));

			if ($customer_group == "") {
				continue;
			}

			$points = $this->getCell($data, $i, $j++, '0');

			$reward = array();

			$reward['product_id'] = $product_id;
			$reward['customer_group'] = $customer_group;
			$reward['points'] = $points;

			if (($incremental) && ($product_id != $previous_product_id)) {
				$old_product_reward_ids = $this->deleteReward($product_id);

				if (isset($unlisted_product_ids[$product_id])) {
					unset($unlisted_product_ids[$product_id]);
				}
			}

			$this->moreRewardCells($i, $j, $data, $reward);

			$this->storeRewardIntoDatabase($reward, $old_product_reward_ids, $customer_group_ids);

			$previous_product_id = $product_id;
		}

		if ($incremental) {
			$this->deleteUnlistedRewards($unlisted_product_ids);
		}
	}

	// Product Option Ids
	protected function getOptionIds() {
		$language_id = $this->getDefaultLanguageId();

		$query = $this->db->query("SELECT option_id, name FROM `" . DB_PREFIX . "option_description` WHERE language_id = '" . (int)$language_id . "'");

		$option_ids = array();

		foreach ($query->rows as $row) {
			$option_id = $row['option_id'];
			$name = htmlspecialchars_decode($row['name']);

			$option_ids[$name] = $option_id;
		}

		return $option_ids;
	}

	protected function storeProductOptionIntoDatabase(&$product_option, &$old_product_option_ids) {
		// Database query for storing the product option
		$product_id = $product_option['product_id'];
		$option_id = $product_option['option_id'];
		$option_value = $product_option['option_value'];
		$required = $product_option['required'];
		$required = ((strtoupper($required) == "TRUE") || (strtoupper($required) == "YES") || (strtoupper($required) == "ENABLED")) ? 1 : 0;

		if (isset($old_product_option_ids[$product_id][$option_id])) {
			$product_option_id = $old_product_option_ids[$product_id][$option_id];

			$sql = "INSERT INTO `" . DB_PREFIX . "product_option` (`product_option_id`,`product_id`,`option_id`,`option_value`,`required`) VALUES";
			$sql .= " ( $product_option_id, $product_id, $option_id, '" . $this->db->escape($option_value) . "', '$required');";

			$this->db->query($sql);

			unset($old_product_option_ids[$product_id][$option_id]);

		} else {
			$sql = "INSERT INTO `" . DB_PREFIX . "product_option` (`product_id`,`option_id`,`option_value`,`required`) VALUES";
			$sql .= " ( $product_id, $option_id, '" . $this->db->escape($option_value) . "', '$required');";

			$this->db->query($sql);
		}
	}

	protected function deleteProductOptions() {
		$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "product_option");
	}

	protected function deleteProductOption(&$product_id) {
		$old_product_option_ids = array();

		$query = $this->db->query("SELECT product_option_id, product_id, option_id FROM `" . DB_PREFIX . "product_option` WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $row) {
			$product_option_id = $row['product_option_id'];
			$product_id = $row['product_id'];
			$option_id = $row['option_id'];

			$old_product_option_ids[$product_id][$option_id] = $product_option_id;
		}

		if ($old_product_option_ids) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_option` WHERE product_id = '" . (int)$product_id . "'");
		}

		return $old_product_option_ids;
	}

	protected function deleteUnlistedProductOptions(&$unlisted_product_ids) {
		foreach ($unlisted_product_ids as $product_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_option` WHERE product_id = '" . (int)$product_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreProductOptionCells($i, $j, $worksheet, &$product_option) {
		return;
	}

	protected function uploadProductOptions($reader, $incremental, &$available_product_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('ProductOptions');

		if ($data == null) {
			return;
		}

		// If incremental then find current product IDs else delete all old product options
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteProductOptions();
		}

		if (!$this->config->get('export_import_settings_use_option_id')) {
			$option_ids = $this->getOptionIds();
		}

		// Load the worksheet cells and store them to the database
		$old_product_option_ids = array();
		$previous_product_id = 0;

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			$j = 1;

			if ($i == 0) {
				continue;
			}

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == '') {
				continue;
			}

			if ($this->config->get('export_import_settings_use_option_id')) {
				$option_id = $this->getCell($data, $i, $j++, '');
			} else {
				$option_name = $this->getCell($data, $i, $j++);

				$option_id = isset($option_ids[$option_name]) ? $option_ids[$option_name] : '';
			}

			if ($option_id == '') {
				continue;
			}

			$option_value = $this->getCell($data, $i, $j++, '');
			$required = $this->getCell($data, $i, $j++, '0');

			$product_option = array();

			$product_option['product_id'] = $product_id;
			$product_option['option_id'] = $option_id;
			$product_option['option_value'] = $option_value;
			$product_option['required'] = $required;

			if (($incremental) && ($product_id != $previous_product_id)) {
				$old_product_option_ids = $this->deleteProductOption($product_id);

				if (isset($unlisted_product_ids[$product_id])) {
					unset($unlisted_product_ids[$product_id]);
				}
			}

			$this->moreProductOptionCells($i, $j, $data, $product_option);

			$this->storeProductOptionIntoDatabase($product_option, $old_product_option_ids);

			$previous_product_id = $product_id;
		}

		if ($incremental) {
			$this->deleteUnlistedProductOptions($unlisted_product_ids);
		}
	}

	protected function getOptionValueIds() {
		$language_id = $this->getDefaultLanguageId();

		$option_value_ids = array();

		$query = $this->db->query("SELECT option_id, option_value_id, `name` FROM `" . DB_PREFIX . "option_value_description` WHERE language_id = '" . (int)$language_id . "'");

		foreach ($query->rows as $row) {
			$option_id = $row['option_id'];
			$option_value_id = $row['option_value_id'];
			$name = htmlspecialchars_decode($row['name']);

			$option_value_ids[$option_id][$name] = $option_value_id;
		}

		return $option_value_ids;
	}

	protected function getProductOptionIds(&$product_id) {
		$product_option_ids = array();

		$query = $this->db->query("SELECT product_option_id, option_id FROM `" . DB_PREFIX . "product_option` WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $row) {
			$product_option_id = $row['product_option_id'];
			$option_id = $row['option_id'];

			$product_option_ids[$option_id] = $product_option_id;
		}

		return $product_option_ids;
	}

	// Product Option Values
	protected function storeProductOptionValueIntoDatabase(&$product_option_value, &$old_product_option_value_ids) {
		$product_id = $product_option_value['product_id'];
		$option_id = $product_option_value['option_id'];
		$option_value_id = $product_option_value['option_value_id'];
		$quantity = $product_option_value['quantity'];
		$subtract = $product_option_value['subtract'];
		$subtract = ((strtoupper($subtract) == "TRUE") || (strtoupper($subtract) == "YES") || (strtoupper($subtract) == "ENABLED")) ? 1 : 0;
		$price = $product_option_value['price'];
		$price_prefix = $product_option_value['price_prefix'];
		$points = $product_option_value['points'];
		$points_prefix = $product_option_value['points_prefix'];
		$weight = $product_option_value['weight'];
		$weight_prefix = $product_option_value['weight_prefix'];
		$product_option_id = $product_option_value['product_option_id'];

		if (isset($old_product_option_value_ids[$product_id][$option_id][$option_value_id])) {
			$product_option_value_id = $old_product_option_value_ids[$product_id][$option_id][$option_value_id];

			$sql = "INSERT INTO `" . DB_PREFIX . "product_option_value`";
			$sql .= " (`product_option_value_id`,`product_option_id`,`product_id`,`option_id`,`option_value_id`,`quantity`,`subtract`,`price`,`price_prefix`,`points`,`points_prefix`,`weight`,`weight_prefix`) VALUES";
			$sql .= " ( $product_option_value_id, $product_option_id, $product_id, $option_id, $option_value_id, $quantity, $subtract, $price, '$price_prefix', $points, '$points_prefix', $weight, '$weight_prefix');";

			$this->db->query($sql);

			unset($old_product_option_value_ids[$product_id][$option_id][$option_value_id]);

		} else {
			$sql = "INSERT INTO `" . DB_PREFIX . "product_option_value`";
			$sql .= " (`product_option_id`,`product_id`,`option_id`,`option_value_id`,`quantity`,`subtract`,`price`,`price_prefix`,`points`,`points_prefix`,`weight`,`weight_prefix`) VALUES";
			$sql .= " ( $product_option_id, $product_id, $option_id, $option_value_id, $quantity, $subtract, $price, '$price_prefix', $points, '$points_prefix', $weight, '$weight_prefix');";

			$this->db->query($sql);
		}
	}

	protected function deleteProductOptionValues() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_option_value`");
	}

	protected function deleteProductOptionValue(&$product_id) {
		$old_product_option_value_ids = array();

		$query = $this->db->query("SELECT product_option_value_id, product_id, option_id, option_value_id FROM `" . DB_PREFIX . "product_option_value` WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $row) {
			$product_option_value_id = $row['product_option_value_id'];
			$product_id = $row['product_id'];
			$option_id = $row['option_id'];
			$option_value_id = $row['option_value_id'];

			$old_product_option_value_ids[$product_id][$option_id][$option_value_id] = $product_option_value_id;
		}

		if ($old_product_option_value_ids) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_value` WHERE product_id = '" . (int)$product_id . "'");
		}

		return $old_product_option_value_ids;
	}

	protected function deleteUnlistedProductOptionValues(&$unlisted_product_ids) {
		foreach ($unlisted_product_ids as $product_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_value` WHERE product_id = '" . (int)$product_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreProductOptionValueCells($i, $j, $worksheet, &$product_option_value) {
		return;
	}

	protected function uploadProductOptionValues($reader, $incremental, &$available_product_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('ProductOptionValues');

		if ($data == null) {
			return;
		}

		// If incremental then find current product IDs else delete all old product option values
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteProductOptionValues();
		}

		if (!$this->config->get('export_import_settings_use_option_id')) {
			$option_ids = $this->getOptionIds();
		}

		if (!$this->config->get('export_import_settings_use_option_value_id')) {
			$option_value_ids = $this->getOptionValueIds();
		}

		// Load the worksheet cells and store them to the database
		$old_product_option_ids = array();
		$previous_product_id = 0;
		$product_option_id = 0;

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			$j = 1;

			if ($i == 0) {
				continue;
			}

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == '') {
				continue;
			}

			if ($this->config->get('export_import_settings_use_option_id')) {
				$option_id = $this->getCell($data, $i, $j++, '');
			} else {
				$option_name = $this->getCell($data, $i, $j++);

				$option_id = isset($option_ids[$option_name]) ? $option_ids[$option_name] : '';
			}

			if ($option_id == '') {
				continue;
			}

			if ($this->config->get('export_import_settings_use_option_value_id')) {
				$option_value_id = $this->getCell($data, $i, $j++, '');
			} else {
				$option_value_name = $this->getCell($data, $i, $j++);

				$option_value_id = isset($option_value_ids[$option_id][$option_value_name]) ? $option_value_ids[$option_id][$option_value_name] : '';
			}

			if ($option_value_id == '') {
				continue;
			}

			$quantity = $this->getCell($data, $i, $j++, '0');
			$subtract = $this->getCell($data, $i, $j++, 'false');
			$price = $this->getCell($data, $i, $j++, '0');
			$price_prefix = $this->getCell($data, $i, $j++, '+');
			$points = $this->getCell($data, $i, $j++, '0');
			$points_prefix = $this->getCell($data, $i, $j++, '+');
			$weight = $this->getCell($data, $i, $j++, '0.00');
			$weight_prefix = $this->getCell($data, $i, $j++, '+');

			if ($product_id != $previous_product_id) {
				$product_option_ids = $this->getProductOptionIds($product_id);
			}

			$product_option_value = array();

			$product_option_value['product_id'] = $product_id;
			$product_option_value['option_id'] = $option_id;
			$product_option_value['option_value_id'] = $option_value_id;
			$product_option_value['quantity'] = $quantity;
			$product_option_value['subtract'] = $subtract;
			$product_option_value['price'] = $price;
			$product_option_value['price_prefix'] = $price_prefix;
			$product_option_value['points'] = $points;
			$product_option_value['points_prefix'] = $points_prefix;
			$product_option_value['weight'] = $weight;
			$product_option_value['weight_prefix'] = $weight_prefix;
			$product_option_value['product_option_id'] = isset($product_option_ids[$option_id]) ? $product_option_ids[$option_id] : 0;

			if (($incremental) && ($product_id != $previous_product_id)) {
				$old_product_option_value_ids = $this->deleteProductOptionValue($product_id);

				if (isset($unlisted_product_ids[$product_id])) {
					unset($unlisted_product_ids[$product_id]);
				}
			}

			$this->moreProductOptionValueCells($i, $j, $data, $product_option_value);

			$this->storeProductOptionValueIntoDatabase($product_option_value, $old_product_option_value_ids);

			$previous_product_id = $product_id;
		}

		if ($incremental) {
			$this->deleteUnlistedProductOptionValues($unlisted_product_ids);
		}
	}

	// Product palette
	protected function storeProductColorIntoDatabase(&$product_color) {
		$product_id = $product_color['product_id'];
		$product_color_id = $product_color['product_color_id'];
		$palette_color_id = $product_color['palette_color_id'];

		$this->db->query("INSERT INTO `" . DB_PREFIX . "product_color` (`product_color_id`,`product_id`,`palette_color_id`) VALUES ( $product_color_id, $product_id, $palette_color_id);");
	}

	protected function deleteProductColors() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_color`");
	}

	protected function deleteProductColor(&$product_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_color` WHERE product_id = '" . (int)$product_id . "'");
	}

	protected function deleteUnlistedProductColors(&$unlisted_product_ids) {
		foreach ($unlisted_product_ids as $product_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_color` WHERE product_id = '" . (int)$product_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreProductColorCells($i, $j, $worksheet, &$product_color) {
		return;
	}

	protected function uploadProductColors($reader, $incremental, &$available_product_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('ProductColors');

		if ($data == null) {
			return;
		}

		// If incremental then find current product IDs else delete all old product attributes
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteProductColors();
		}

		// Load the worksheet cells and store them to the database
		$previous_product_id = 0;

		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == '') {
				continue;
			}

			$product_color_id = trim($this->getCell($data, $i, $j++));

			if ($product_color_id == '') {
				continue;
			}

			$palette_color_id = trim($this->getCell($data, $i, $j++));

			if ($palette_color_id == '') {
				continue;
			}

			$product_color = array();

			$product_color['product_id'] = $product_id;
			$product_color['product_color_id'] = $product_color_id;
			$product_color['palette_color_id'] = $palette_color_id;

			if (($incremental) && ($product_id != $previous_product_id)) {
				$this->deleteProductColor($product_id);

				if (isset($unlisted_product_ids[$product_id])) {
					unset($unlisted_product_ids[$product_id]);
				}
			}

			$this->moreProductColorCells($i, $j, $data, $product_color);

			$this->storeProductColorIntoDatabase($product_color);

			$previous_product_id = $product_id;
		}

		if ($incremental) {
			$this->deleteUnlistedProductColors($unlisted_product_ids);
		}
	}

	// Product field
	protected function getFieldIds() {
		$language_id = $this->getDefaultLanguageId();

		$field_ids = array();

		$sql = "SELECT f.field_id, fd.* FROM `" . DB_PREFIX . "field_description` fd";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "field` f ON (f.field_id = fd.field_id)";
		$sql .= " WHERE fd.language_id = '" . (int)$language_id . "'";
		$sql .= " ORDER BY f.field_id ASC";

		$query = $this->db->query($sql);

		foreach ($query->rows as $row) {
			$field_id = $row['field_id'];
			$title = $row['title'];

			$field_ids[$field_id][$title] = $field_id;
		}

		return $field_ids;
	}

	protected function storeProductFieldIntoDatabase(&$product_field, $languages) {
		$product_id = $product_field['product_id'];
		$field_id = $product_field['field_id'];
		$texts = $product_field['texts'];

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$text = isset($texts[$language_code]) ? $this->db->escape($texts[$language_code]) : '';

			$this->db->query("INSERT INTO `" . DB_PREFIX . "product_field` (`product_id`,`field_id`,`language_id`,`text`) VALUES ( $product_id, $field_id, $language_id, '$text');");
		}
	}

	protected function deleteProductFields() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_field`");
	}

	protected function deleteProductField(&$product_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_field` WHERE product_id = '" . (int)$product_id . "'");
	}

	protected function deleteUnlistedProductFields(&$unlisted_product_ids) {
		foreach ($unlisted_product_ids as $product_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_field` WHERE product_id = '" . (int)$product_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreProductFieldCells($i, $j, $worksheet, &$product_field) {
		return;
	}

	protected function uploadProductFields($reader, $incremental, &$available_product_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('ProductFields');

		if ($data == null) {
			return;
		}

		// If incremental then find current product IDs else delete all old product attributes
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteProductFields();
		}

		$field_ids = $this->getFieldIds();

		// Load the worksheet cells and store them to the database
		$languages = $this->getLanguages();

		$previous_product_id = 0;
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == '') {
				continue;
			}

			$field_id = trim($this->getCell($data, $i, $j++));

			if ($field_id == '') {
				continue;
			}

			$texts = array();

			while (($j <= $max_col) && $this->startsWith($first_row[$j-1], "text(")) {
				$language_code = substr($first_row[$j-1], strlen("text("), strlen($first_row[$j-1])-strlen("text(")-1);
				$text = $this->getCell($data, $i, $j++);
				$text = htmlspecialchars($text);
				$texts[$language_code] = $text;
			}

			$product_field = array();

			$product_field['product_id'] = $product_id;
			$product_field['field_id'] = $field_id;
			$product_field['texts'] = $texts;

			if (($incremental) && ($product_id != $previous_product_id)) {
				$this->deleteProductField($product_id);

				if (isset($unlisted_product_ids[$product_id])) {
					unset($unlisted_product_ids[$product_id]);
				}
			}

			$this->moreProductFieldCells($i, $j, $data, $product_field);

			$this->storeProductFieldIntoDatabase($product_field, $languages);

			$previous_product_id = $product_id;
		}

		if ($incremental) {
			$this->deleteUnlistedProductFields($unlisted_product_ids);
		}
	}

	// Product Attribute
	protected function getAttributeGroupIds() {
		$language_id = $this->getDefaultLanguageId();

		$attribute_group_ids = array();

		$query = $this->db->query("SELECT attribute_group_id, name FROM `" . DB_PREFIX . "attribute_group_description` WHERE language_id = '" . (int)$language_id . "'");

		foreach ($query->rows as $row) {
			$attribute_group_id = $row['attribute_group_id'];
			$name = $row['name'];

			$attribute_group_ids[$name] = $attribute_group_id;
		}

		return $attribute_group_ids;
	}

	protected function getAttributeIds() {
		$language_id = $this->getDefaultLanguageId();

		$attribute_ids = array();

		$sql = "SELECT a.attribute_group_id, ad.attribute_id, ad.name FROM `" . DB_PREFIX . "attribute_description` ad";
		$sql .= " INNER JOIN `" . DB_PREFIX . "attribute` a ON (a.attribute_id = ad.attribute_id)";
		$sql .= " WHERE ad.language_id = '" . (int)$language_id . "'";

		$query = $this->db->query($sql);

		foreach ($query->rows as $row) {
			$attribute_group_id = $row['attribute_group_id'];
			$attribute_id = $row['attribute_id'];
			$name = $row['name'];

			$attribute_ids[$attribute_group_id][$name] = $attribute_id;
		}

		return $attribute_ids;
	}

	protected function storeProductAttributeIntoDatabase(&$product_attribute, $languages) {
		$product_id = $product_attribute['product_id'];
		$attribute_id = $product_attribute['attribute_id'];
		$texts = $product_attribute['texts'];

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$text = isset($texts[$language_code]) ? $this->db->escape($texts[$language_code]) : '';

			$this->db->query("INSERT INTO `" . DB_PREFIX . "product_attribute` (`product_id`,`attribute_id`,`language_id`,`text`) VALUES ( $product_id, $attribute_id, $language_id, '$text');");
		}
	}

	protected function deleteProductAttributes() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_attribute`");
	}

	protected function deleteProductAttribute(&$product_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_attribute` WHERE product_id = '" . (int)$product_id . "'");
	}

	protected function deleteUnlistedProductAttributes(&$unlisted_product_ids) {
		foreach ($unlisted_product_ids as $product_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_attribute` WHERE product_id = '" . (int)$product_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreProductAttributeCells($i, $j, $worksheet, &$product_attribute) {
		return;
	}

	protected function uploadProductAttributes($reader, $incremental, &$available_product_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('ProductAttributes');

		if ($data == null) {
			return;
		}

		// If incremental then find current product IDs else delete all old product attributes
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteProductAttributes();
		}

		if (!$this->config->get('export_import_settings_use_attribute_group_id')) {
			$attribute_group_ids = $this->getAttributeGroupIds();
		}

		if (!$this->config->get('export_import_settings_use_attribute_id')) {
			$attribute_ids = $this->getAttributeIds();
		}

		// Load the worksheet cells and store them to the database
		$languages = $this->getLanguages();

		$previous_product_id = 0;
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == '') {
				continue;
			}

			if ($this->config->get('export_import_settings_use_attribute_group_id')) {
				$attribute_group_id = $this->getCell($data, $i, $j++, '');
			} else {
				$attribute_group_name = $this->getCell($data, $i, $j++);
				$attribute_group_id = isset($attribute_group_ids[$attribute_group_name]) ? $attribute_group_ids[$attribute_group_name] : '';
			}

			if ($attribute_group_id == '') {
				continue;
			}

			if ($this->config->get('export_import_settings_use_attribute_id')) {
				$attribute_id = $this->getCell($data, $i, $j++, '');
			} else {
				$attribute_name = $this->getCell($data, $i, $j++);
				$attribute_id = isset($attribute_ids[$attribute_group_id][$attribute_name]) ? $attribute_ids[$attribute_group_id][$attribute_name] : '';
			}

			if ($attribute_id == '') {
				continue;
			}

			$texts = array();

			while (($j <= $max_col) && $this->startsWith($first_row[$j-1], "text(")) {
				$language_code = substr($first_row[$j-1], strlen("text("), strlen($first_row[$j-1])-strlen("text(")-1);
				$text = $this->getCell($data, $i, $j++);
				$text = htmlspecialchars($text);
				$texts[$language_code] = $text;
			}

			$product_attribute = array();

			$product_attribute['product_id'] = $product_id;
			$product_attribute['attribute_group_id'] = $attribute_group_id;
			$product_attribute['attribute_id'] = $attribute_id;
			$product_attribute['texts'] = $texts;

			if (($incremental) && ($product_id != $previous_product_id)) {
				$this->deleteProductAttribute($product_id);

				if (isset($unlisted_product_ids[$product_id])) {
					unset($unlisted_product_ids[$product_id]);
				}
			}

			$this->moreProductAttributeCells($i, $j, $data, $product_attribute);

			$this->storeProductAttributeIntoDatabase($product_attribute, $languages);

			$previous_product_id = $product_id;
		}

		if ($incremental) {
			$this->deleteUnlistedProductAttributes($unlisted_product_ids);
		}
	}

	// Product Filter
	protected function getFilterGroupIds() {
		$language_id = $this->getDefaultLanguageId();

		$filter_group_ids = array();

		$query = $this->db->query("SELECT filter_group_id, `name` FROM `" . DB_PREFIX . "filter_group_description` WHERE language_id = '" . (int)$language_id . "'");

		foreach ($query->rows as $row) {
			$filter_group_id = $row['filter_group_id'];
			$name = $row['name'];
			$filter_group_ids[$name] = $filter_group_id;
		}

		return $filter_group_ids;
	}

	protected function getFilterIds() {
		$language_id = $this->getDefaultLanguageId();

		$filter_ids = array();

		$sql = "SELECT f.filter_group_id, fd.filter_id, fd.`name` FROM `" . DB_PREFIX . "filter_description` fd";
		$sql .= " INNER JOIN `" . DB_PREFIX . "filter` f ON (f.filter_id = fd.filter_id)";
		$sql .= " WHERE fd.language_id = '" . (int)$language_id . "'";

		$query = $this->db->query($sql);

		foreach ($query->rows as $row) {
			$filter_group_id = $row['filter_group_id'];
			$filter_id = $row['filter_id'];
			$name = $row['name'];

			$filter_ids[$filter_group_id][$name] = $filter_id;
		}

		return $filter_ids;
	}

	protected function storeProductFilterIntoDatabase(&$product_filter, $languages) {
		$product_id = $product_filter['product_id'];
		$filter_id = $product_filter['filter_id'];

		$this->db->query("INSERT INTO `" . DB_PREFIX . "product_filter` (`product_id`,`filter_id`) VALUES ( $product_id, $filter_id);");
	}

	protected function deleteProductFilters() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "product_filter`");
	}

	protected function deleteProductFilter(&$product_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_filter` WHERE product_id = '" . (int)$product_id . "'");
	}

	protected function deleteUnlistedProductFilters(&$unlisted_product_ids) {
		foreach ($unlisted_product_ids as $product_id) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_filter` WHERE product_id = '" . (int)$product_id . "'");
		}
	}

	// Function for reading additional cells in class extensions
	protected function moreProductFilterCells($i, $j, $worksheet, &$product_filter) {
		return;
	}

	protected function uploadProductFilters($reader, $incremental, &$available_product_ids) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('ProductFilters');

		if ($data == null) {
			return;
		}

		// If incremental then find current product IDs else delete all old product filters
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteProductFilters();
		}

		if (!$this->config->get('export_import_settings_use_filter_group_id')) {
			$filter_group_ids = $this->getFilterGroupIds();
		}

		if (!$this->config->get('export_import_settings_use_filter_id')) {
			$filter_ids = $this->getFilterIds();
		}

		// Load the worksheet cells and store them to the database
		$languages = $this->getLanguages();

		$previous_product_id = 0;
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$product_id = trim($this->getCell($data, $i, $j++));

			if ($product_id == '') {
				continue;
			}

			if ($this->config->get('export_import_settings_use_filter_group_id')) {
				$filter_group_id = $this->getCell($data, $i, $j++, '');
			} else {
				$filter_group_name = $this->getCell($data, $i, $j++);
				$filter_group_id = isset($filter_group_ids[$filter_group_name]) ? $filter_group_ids[$filter_group_name] : '';
			}

			if ($filter_group_id == '') {
				continue;
			}

			if ($this->config->get('export_import_settings_use_filter_id')) {
				$filter_id = $this->getCell($data, $i, $j++, '');
			} else {
				$filter_name = $this->getCell($data, $i, $j++);
				$filter_id = isset($filter_ids[$filter_group_id][$filter_name]) ? $filter_ids[$filter_group_id][$filter_name] : '';
			}

			if ($filter_id == '') {
				continue;
			}

			$product_filter = array();

			$product_filter['product_id'] = $product_id;
			$product_filter['filter_group_id'] = $filter_group_id;
			$product_filter['filter_id'] = $filter_id;

			if (($incremental) && ($product_id != $previous_product_id)) {
				$this->deleteProductFilter($product_id);

				if (isset($unlisted_product_ids[$product_id])) {
					unset($unlisted_product_ids[$product_id]);
				}
			}

			$this->moreProductFilterCells($i, $j, $data, $product_filter);

			$this->storeProductFilterIntoDatabase($product_filter, $languages);

			$previous_product_id = $product_id;
		}

		if ($incremental) {
			$this->deleteUnlistedProductFilters($unlisted_product_ids);
		}
	}

	protected function storeOptionIntoDatabase(&$option, $languages) {
		$option_id = $option['option_id'];
		$type = $option['type'];
		$sort_order = $option['sort_order'];
		$names = $option['names'];

		$this->db->query("INSERT INTO `" . DB_PREFIX . "option` (`option_id`,`type`,`sort_order`) VALUES ( $option_id, '" . $this->db->escape($type) . "', $sort_order);");

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$name = isset($names[$language_code]) ? $this->db->escape($names[$language_code]) : '';

			$this->db->query("INSERT INTO `" . DB_PREFIX . "option_description` (`option_id`,`language_id`,`name`) VALUES ( $option_id, $language_id, '$name');");
		}
	}

	protected function deleteOptions() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "option`");
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "option_description`");
	}

	protected function deleteOption(&$option_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "option` WHERE option_id = '" . (int)$option_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "option_description` WHERE option_id = '" . (int)$option_id . "'");
	}

	// Function for reading additional cells in class extensions
	protected function moreOptionCells($i, $j, $worksheet, &$option) {
		return;
	}

	protected function uploadOptions($reader, $incremental) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Options');

		if ($data == null) {
			return;
		}

		// Find the installed languages
		$languages = $this->getLanguages();

		// if not incremental then delete all old options
		if (!$incremental) {
			$this->deleteOptions();
		}

		// Load the worksheet cells and store them to the database
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$option_id = trim($this->getCell($data, $i, $j++));

			if ($option_id == '') {
				continue;
			}

			$type = $this->getCell($data, $i, $j++, '');
			$sort_order = $this->getCell($data, $i, $j++, '0');

			$names = array();

			while (($j <= $max_col) && $this->startsWith($first_row[$j-1], "name(")) {
				$language_code = substr($first_row[$j-1], strlen("name("), strlen($first_row[$j-1])-strlen("name(")-1);
				$name = $this->getCell($data, $i, $j++);
				$name = htmlspecialchars($name);
				$names[$language_code] = $name;
			}

			$option = array();

			$option['option_id'] = $option_id;
			$option['type'] = $type;
			$option['sort_order'] = $sort_order;
			$option['names'] = $names;

			if ($incremental) {
				$this->deleteOption($option_id);
			}

			$this->moreOptionCells($i, $j, $data, $option);

			$this->storeOptionIntoDatabase($option, $languages);
		}
	}

	protected function storeOptionValueIntoDatabase(&$option_value, $languages, $exist_image = true) {
		$option_value_id = $option_value['option_value_id'];
		$option_id = $option_value['option_id'];

		if ($exist_image) {
			$image = $option_value['image'];
		}

		$sort_order = $option_value['sort_order'];
		$names = $option_value['names'];

		if ($exist_image) {
			$sql = "INSERT INTO `" . DB_PREFIX . "option_value` (`option_value_id`,`option_id`,`image`,`sort_order`) VALUES ( $option_value_id, $option_id, '" . $this->db->escape($image) . "', $sort_order);";
		} else {
			$sql = "INSERT INTO `" . DB_PREFIX . "option_value` (`option_value_id`,`option_id`,`sort_order`) VALUES ( $option_value_id, $option_id, $sort_order);";
		}

		$this->db->query($sql);

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$name = isset($names[$language_code]) ? $this->db->escape($names[$language_code]) : '';

			$this->db->query("INSERT INTO `" . DB_PREFIX . "option_value_description` (`option_value_id`,`language_id`,`option_id`,`name`) VALUES ( $option_value_id, $language_id, $option_id, '$name');");
		}
	}

	protected function deleteOptionValues() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "option_value`");
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "option_value_description`");
	}

	protected function deleteOptionValue(&$option_value_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "option_value` WHERE option_value_id = '" . (int)$option_value_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "option_value_description` WHERE option_value_id = '" . (int)$option_value_id . "'");
	}

	// Function for reading additional cells in class extensions
	protected function moreOptionValueCells($i, $j, $worksheet, &$option) {
		return;
	}

	protected function uploadOptionValues($reader, $incremental) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('OptionValues');

		if ($data == null) {
			return;
		}

		// Get option_value.image field
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "option_value` LIKE 'image'");

		$exist_image = ($query->num_rows > 0) ? true : false;

		// Get installed languages
		$languages = $this->getLanguages();

		// If not incremental then delete all old option values
		if (!$incremental) {
			$this->deleteOptionValues();
		}

		// Load the worksheet cells and store them to the database
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$option_value_id = trim($this->getCell($data, $i, $j++));

			if ($option_value_id == '') {
				continue;
			}

			$option_id = trim($this->getCell($data, $i, $j++));

			if ($option_id == '') {
				continue;
			}

			if ($exist_image) {
				$image = $this->getCell($data, $i, $j++, '');
			}

			$sort_order = $this->getCell($data, $i, $j++, '0');

			$names = array();

			while (($j <= $max_col) && $this->startsWith($first_row[$j-1], "name(")) {
				$language_code = substr($first_row[$j-1], strlen("name("), strlen($first_row[$j-1])-strlen("name(")-1);
				$name = $this->getCell($data, $i, $j++);
				$name = htmlspecialchars($name);
				$names[$language_code] = $name;
			}

			$option_value = array();

			$option_value['option_value_id'] = $option_value_id;
			$option_value['option_id'] = $option_id;

			if ($exist_image) {
				$option_value['image'] = $image;
			}

			$option_value['sort_order'] = $sort_order;
			$option_value['names'] = $names;

			if ($incremental) {
				$this->deleteOptionValue($option_value_id);
			}

			$this->moreOptionValueCells($i, $j, $data, $option_value);

			$this->storeOptionValueIntoDatabase($option_value, $languages, $exist_image);
		}
	}

	// Attribute Groups
	protected function storeAttributeGroupIntoDatabase(&$attribute_group, $languages) {
		$attribute_group_id = $attribute_group['attribute_group_id'];
		$sort_order = $attribute_group['sort_order'];
		$names = $attribute_group['names'];

		$this->db->query("INSERT INTO `" . DB_PREFIX . "attribute_group` (`attribute_group_id`,`sort_order`) VALUES ( $attribute_group_id, $sort_order);");

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$name = isset($names[$language_code]) ? $this->db->escape($names[$language_code]) : '';

			$this->db->query("INSERT INTO `" . DB_PREFIX . "attribute_group_description` (`attribute_group_id`,`language_id`,`name`) VALUES ( $attribute_group_id, $language_id, '$name');");
		}
	}

	protected function deleteAttributeGroups() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "attribute_group`");
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "attribute_group_description`");
	}

	protected function deleteAttributeGroup(&$attribute_group_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "attribute_group` WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "attribute_group_description` WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
	}

	// Function for reading additional cells in class extensions
	protected function moreAttributeGroupCells($i, $j, $worksheet, &$attribute_group) {
		return;
	}

	protected function uploadAttributeGroups($reader, $incremental) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('AttributeGroups');

		if ($data == null) {
			return;
		}

		// Get installed languages
		$languages = $this->getLanguages();

		// If not incremental then delete all old attribute groups
		if (!$incremental) {
			$this->deleteAttributeGroups();
		}

		// Load the worksheet cells and store them to the database
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$attribute_group_id = trim($this->getCell($data, $i, $j++));

			if ($attribute_group_id == '') {
				continue;
			}

			$sort_order = $this->getCell($data, $i, $j++, '0');

			$names = array();

			while (($j <= $max_col) && $this->startsWith($first_row[$j-1], "name(")) {
				$language_code = substr($first_row[$j-1], strlen("name("), strlen($first_row[$j-1])-strlen("name(")-1);
				$name = $this->getCell($data, $i, $j++);
				$name = htmlspecialchars($name);
				$names[$language_code] = $name;
			}

			$attribute_group = array();

			$attribute_group['attribute_group_id'] = $attribute_group_id;
			$attribute_group['sort_order'] = $sort_order;
			$attribute_group['names'] = $names;

			if ($incremental) {
				$this->deleteAttributeGroup($attribute_group_id);
			}

			$this->moreAttributeGroupCells($i, $j, $data, $attribute_group);

			$this->storeAttributeGroupIntoDatabase($attribute_group, $languages);
		}
	}

	// Attributes
	protected function storeAttributeIntoDatabase(&$attribute, $languages) {
		$attribute_id = $attribute['attribute_id'];
		$attribute_group_id = $attribute['attribute_group_id'];
		$sort_order = $attribute['sort_order'];
		$names = $attribute['names'];

		$this->db->query("INSERT INTO `" . DB_PREFIX . "attribute` (`attribute_id`,`attribute_group_id`,`sort_order`) VALUES ( $attribute_id, $attribute_group_id, $sort_order);");

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$name = isset($names[$language_code]) ? $this->db->escape($names[$language_code]) : '';

			$this->db->query("INSERT INTO `" . DB_PREFIX . "attribute_description` (`attribute_id`,`language_id`,`name`) VALUES ( $attribute_id, $language_id, '$name');");
		}
	}

	protected function deleteAttributes() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "attribute`");
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "attribute_description`");
	}

	protected function deleteAttribute(&$attribute_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "attribute` WHERE attribute_id = '" . (int)$attribute_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "attribute_description` WHERE attribute_id = '" . (int)$attribute_id . "'");
	}

	// Function for reading additional cells in class extensions
	protected function moreAttributeCells($i, $j, $worksheet, &$attribute) {
		return;
	}

	protected function uploadAttributes($reader, $incremental) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Attributes');

		if ($data == null) {
			return;
		}

		// Get installed languages
		$languages = $this->getLanguages();

		// If not incremental then delete all old attributes
		if (!$incremental) {
			$this->deleteAttributes();
		}

		// Load the worksheet cells and store them to the database
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$attribute_id = trim($this->getCell($data, $i, $j++));

			if ($attribute_id == '') {
				continue;
			}

			$attribute_group_id = trim($this->getCell($data, $i, $j++));

			if ($attribute_group_id == '') {
				continue;
			}

			$sort_order = $this->getCell($data, $i, $j++, '0');

			$names = array();

			while (($j <= $max_col) && $this->startsWith($first_row[$j-1], "name(")) {
				$language_code = substr($first_row[$j-1], strlen("name("), strlen($first_row[$j-1])-strlen("name(")-1);
				$name = $this->getCell($data, $i, $j++);
				$name = htmlspecialchars($name);
				$names[$language_code] = $name;
			}

			$attribute = array();

			$attribute['attribute_id'] = $attribute_id;
			$attribute['attribute_group_id'] = $attribute_group_id;
			$attribute['sort_order'] = $sort_order;
			$attribute['names'] = $names;

			if ($incremental) {
				$this->deleteAttribute($attribute_id);
			}

			$this->moreAttributeCells($i, $j, $data, $attribute);

			$this->storeAttributeIntoDatabase($attribute, $languages);
		}
	}

	// Filter Groups
	protected function storeFilterGroupIntoDatabase(&$filter_group, $languages) {
		$filter_group_id = $filter_group['filter_group_id'];
		$sort_order = $filter_group['sort_order'];
		$names = $filter_group['names'];

		$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_group` (`filter_group_id`,`sort_order`) VALUES ( $filter_group_id, $sort_order);");

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$name = isset($names[$language_code]) ? $this->db->escape($names[$language_code]) : '';

			$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_group_description` (`filter_group_id`,`language_id`,`name`) VALUES ( $filter_group_id, $language_id, '$name');");
		}
	}

	protected function deleteFilterGroups() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "filter_group`");
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "filter_group_description`");
	}

	protected function deleteFilterGroup(&$filter_group_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filter_group` WHERE filter_group_id = '" . (int)$filter_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filter_group_description` WHERE filter_group_id = '" . (int)$filter_group_id . "'");
	}

	// Function for reading additional cells in class extensions
	protected function moreFilterGroupCells($i, $j, $worksheet, &$filter_group) {
		return;
	}

	protected function uploadFilterGroups($reader, $incremental) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('FilterGroups');

		if ($data == null) {
			return;
		}

		// Get installed languages
		$languages = $this->getLanguages();

		// If not incremental then delete all old filter groups
		if (!$incremental) {
			$this->deleteFilterGroups();
		}

		// Load the worksheet cells and store them to the database
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$filter_group_id = trim($this->getCell($data, $i, $j++));

			if ($filter_group_id == '') {
				continue;
			}

			$sort_order = $this->getCell($data, $i, $j++, '0');

			$names = array();

			while (($j <= $max_col) && $this->startsWith($first_row[$j-1], "name(")) {
				$language_code = substr($first_row[$j-1], strlen("name("), strlen($first_row[$j-1])-strlen("name(")-1);
				$name = $this->getCell($data, $i, $j++);
				$name = htmlspecialchars($name);
				$names[$language_code] = $name;
			}

			$filter_group = array();

			$filter_group['filter_group_id'] = $filter_group_id;
			$filter_group['sort_order'] = $sort_order;
			$filter_group['names'] = $names;

			if ($incremental) {
				$this->deleteFilterGroup($filter_group_id);
			}

			$this->moreFilterGroupCells($i, $j, $data, $filter_group);

			$this->storeFilterGroupIntoDatabase($filter_group, $languages);
		}
	}

	// Filters
	protected function storeFilterIntoDatabase(&$filter, $languages) {
		$filter_id = $filter['filter_id'];
		$filter_group_id = $filter['filter_group_id'];
		$sort_order = $filter['sort_order'];
		$names = $filter['names'];

		$this->db->query("INSERT INTO `" . DB_PREFIX . "filter` (`filter_id`,`filter_group_id`,`sort_order`) VALUES ( $filter_id, $filter_group_id, $sort_order);");

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$name = isset($names[$language_code]) ? $this->db->escape($names[$language_code]) : '';

			$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description` (`filter_id`,`language_id`,`filter_group_id`,`name`) VALUES ( $filter_id, $language_id, $filter_group_id, '$name');");
		}
	}

	protected function deleteFilters() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "filter`");
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "filter_description`");
	}

	protected function deleteFilter($filter_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filter` WHERE filter_id = '" . (int)$filter_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filter_description` WHERE filter_id = '" . (int)$filter_id . "'");
	}

	// Function for reading additional cells in class extensions
	protected function moreFilterCells($i, $j, $worksheet, &$filter) {
		return;
	}

	protected function uploadFilters($reader, $incremental) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Filters');

		if ($data == null) {
			return;
		}

		// Get installed languages
		$languages = $this->getLanguages();

		// If not incremental then delete all old filters
		if (!$incremental) {
			$this->deleteFilters();
		}

		// Load the worksheet cells and store them to the database
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$filter_id = trim($this->getCell($data, $i, $j++));

			if ($filter_id == '') {
				continue;
			}

			$filter_group_id = trim($this->getCell($data, $i, $j++));

			if ($filter_group_id == '') {
				continue;
			}

			$sort_order = $this->getCell($data, $i, $j++, '0');

			$names = array();

			while (($j <= $max_col) && $this->startsWith($first_row[$j-1], "name(")) {
				$language_code = substr($first_row[$j-1], strlen("name("), strlen($first_row[$j-1])-strlen("name(")-1);
				$name = $this->getCell($data, $i, $j++);
				$name = htmlspecialchars($name);
				$names[$language_code] = $name;
			}

			$filter = array();

			$filter['filter_id'] = $filter_id;
			$filter['filter_group_id'] = $filter_group_id;
			$filter['sort_order'] = $sort_order;
			$filter['names'] = $names;

			if ($incremental) {
				$this->deleteFilter($filter_id);
			}

			$this->moreFilterCells($i, $j, $data, $filter);

			$this->storeFilterIntoDatabase($filter, $languages);
		}
	}

	// Fields
	protected function storeFieldIntoDatabase(&$field, $languages) {
		$field_id = $field['field_id'];
		$sort_order = $field['sort_order'];
		$status = $field['status'];

		$titles = $field['titles'];
		$descriptions = $field['descriptions'];

		$this->db->query("INSERT INTO `" . DB_PREFIX . "field` (`field_id`,`sort_order`,`status`) VALUES ( $field_id, $sort_order, $status);");

		foreach ($languages as $language) {
			$language_code = $language['code'];
			$language_id = $language['language_id'];

			$title = isset($titles[$language_code]) ? $this->db->escape($titles[$language_code]) : '';
			$description = isset($descriptions[$language_code]) ? $this->db->escape($descriptions[$language_code]) : '';

			$this->db->query("INSERT INTO `" . DB_PREFIX . "field_description` (`field_id`,`language_id`,`title`, `description`) VALUES ( $field_id, $language_id, '$title', '$description');");
		}
	}

	protected function deleteFields() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "field`");
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "field_description`");
	}

	protected function deleteField($field_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "field` WHERE field_id = '" . (int)$field_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "field_description` WHERE field_id = '" . (int)$field_id . "'");
	}

	// Function for reading additional cells in class extensions
	protected function moreFieldCells($i, $j, $worksheet, &$field) {
		return;
	}

	protected function uploadFields($reader, $incremental) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Fields');

		if ($data == null) {
			return;
		}

		// Get installed languages
		$languages = $this->getLanguages();

		// If not incremental then delete all old fields
		if (!$incremental) {
			$this->deleteFields();
		}

		// Load the worksheet cells and store them to the database
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$field_id = trim($this->getCell($data, $i, $j++));

			if ($field_id == '') {
				continue;
			}

			$sort_order = $this->getCell($data, $i, $j++);
			$status = $this->getCell($data, $i, $j++);

			$titles = array();

			while ($this->startsWith($first_row[$j-1], "title(")) {
				$language_code = substr($first_row[$j-1], strlen("title("), strlen($first_row[$j-1])-strlen("title(")-1);
				$title = $this->getCell($data, $i, $j++);
				$title = htmlspecialchars($title);
				$titles[$language_code] = $title;
			}

			$descriptions = array();

			while (($j <= $max_col) && $this->startsWith($first_row[$j-1], "description(")) {
				$language_code = substr($first_row[$j-1], strlen("description("), strlen($first_row[$j-1])-strlen("description(")-1);
				$description = $this->getCell($data, $i, $j++);
				$description = htmlspecialchars($description);
				$descriptions[$language_code] = $description;
			}

			$field = array();

			$field['field_id'] = $field_id;
			$field['sort_order'] = $sort_order;
			$field['status'] = $status;
			$field['titles'] = $titles;
			$field['descriptions'] = $descriptions;

			if ($incremental) {
				$this->deleteField($field_id);
			}

			$this->moreFieldCells($i, $j, $data, $field);

			$this->storeFieldIntoDatabase($field, $languages);
		}
	}

	// Palettes
	protected function getPaletteColorIds() {
		$palette_color_ids = array();

		$palette_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "palette_color`;");

		if ($palette_query->rows) {
			$palette_color_ids = $palette_query->rows;
		}

		return $palette_color_ids;
	}

	protected function getAvailablePaletteIds() {
		$palette_ids = array();

		$palette_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "palette`;");

		if ($palette_query->rows) {
			$palette_ids = $palette_query->rows;
		}

		return $palette_ids;
	}

	protected function storePaletteIntoDatabase(&$palette, $languages) {
		$palette_color_id = $palette['palette_color_id'];
		$palette_id = $palette['palette_id'];
		$name = $palette['name'];
		$color = $palette['color'];
		$skin = $palette['skin'];
		$titles = $palette['titles'];

		$palette_color_ids = $this->getPaletteColorIds();

		if (in_array($palette_color_id, $palette_color_ids)) {
			$this->db->query("UPDATE `" . DB_PREFIX . "palette_color` SET palette_id = '" . (int)$palette_id . "', `color` = '" . $this->db->escape($color) . "', skin = '" . $this->db->escape($skin) . "' WHERE palette_color_id = '" . (int)$palette_color_id . "'");

			foreach ($languages as $language) {
				$language_code = $language['code'];
				$language_id = $language['language_id'];

				$title = isset($titles[$language_code]) ? $this->db->escape($titles[$language_code]) : '';

				$this->db->query("UPDATE `" . DB_PREFIX . "palette_color_description` SET language_id = '" . (int)$language_id . "', palette_id = '" . (int)$palette_id . "', `title` = '" . $this->db->escape($title) . "' WHERE palette_color_id = '" . (int)$palette_color_id . "'");
			}

		} else {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "palette_color` SET palette_color_id = '" . (int)$palette_color_id . "', palette_id = '" . (int)$palette_id . "', `color` = '" . $this->db->escape($color) . "', skin = '" . $this->db->escape($skin) . "'");

			foreach ($languages as $language) {
				$language_code = $language['code'];
				$language_id = $language['language_id'];

				$title = isset($titles[$language_code]) ? $this->db->escape($titles[$language_code]) : '';

				$this->db->query("INSERT INTO `" . DB_PREFIX . "palette_color_description` SET palette_color_id = '" . (int)$palette_color_id . "', language_id = '" . (int)$language_id . "', palette_id = '" . (int)$palette_id . "',  `title` = '" . $title . "'");
			}
		}

		$palette_ids = $this->getAvailablePaletteIds();

		if (in_array($palette_id, $palette_ids)) {
			$this->db->query("UPDATE `" . DB_PREFIX . "palette` SET `name` = '" . $this->db->escape($name) . "' WHERE palette_id = '" . (int)$palette_id . "'");
		} else {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "palette` WHERE palette_id = '" . (int)$palette_id . "'");

			$this->db->query("INSERT INTO `" . DB_PREFIX . "palette` (`palette_id`,`name`) VALUES ( $palette_id, '$name');");
		}
	}

	protected function deletePalettes() {
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "palette_color`");
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "palette_color_description`");
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "palette`");
	}

	protected function deletePalette($palette_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "palette_color` WHERE palette_id = '" . (int)$palette_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "palette_color_description` WHERE palette_id = '" . (int)$palette_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "palette` WHERE palette_id = '" . (int)$palette_id . "'");
	}

	// Function for reading additional cells in class extensions
	protected function morePaletteCells($i, $j, $worksheet, &$palette) {
		return;
	}

	protected function uploadPalettes($reader, $incremental) {
		// Get worksheet, if not there return immediately
		$data = $reader->getSheetByName('Palettes');

		if ($data == null) {
			return;
		}

		// Get installed languages
		$languages = $this->getLanguages();

		// Not incremental at this time, delete old palettes
		$incremental = false;

		if (!$incremental) {
			$this->deletePalettes();
		}

		// Load the worksheet cells and store them to the database
		$first_row = array();

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 0; $i < $k; $i += 1) {
			if ($i == 0) {
				$max_col = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

				for ($j = 1; $j <= $max_col; $j += 1) {
					$first_row[] = $this->getCell($data, $i, $j);
				}

				continue;
			}

			$j = 1;

			$palette_color_id = trim($this->getCell($data, $i, $j++));

			if ($palette_color_id == '') {
				continue;
			}

			$palette_id = trim($this->getCell($data, $i, $j++));

			if ($palette_id == '') {
				continue;
			}

			$name = $this->getCell($data, $i, $j++);
			$color = $this->getCell($data, $i, $j++);
			$skin = $this->getCell($data, $i, $j++);

			$titles = array();

			while (($j <= $max_col) && $this->startsWith($first_row[$j-1], "title(")) {
				$language_code = substr($first_row[$j-1], strlen("title("), strlen($first_row[$j-1])-strlen("title(")-1);
				$title = $this->getCell($data, $i, $j++);
				$title = htmlspecialchars($title);
				$titles[$language_code] = $title;
			}

			$palette = array();

			$palette['palette_color_id'] = $palette_color_id;
			$palette['palette_id'] = $palette_id;
			$palette['name'] = $name;
			$palette['color'] = $color;
			$palette['skin'] = $skin;
			$palette['titles'] = $titles;

			// Not incremental at this time, so this has no effect.
			if ($incremental) {
				$this->deletePalette($palette_id);
			}

			$this->morePaletteCells($i, $j, $data, $palette);

			$this->storePaletteIntoDatabase($palette, $languages);
		}
	}

	// PHPExcel
	protected function getCell($worksheet, $row, $col, $default_val = '') {
		$col -= 1; // We use 1-based, PHPExcel uses 0-based column index
		$row += 1; // We use 0-based, PHPExcel uses 1-based row index

		$val = ($worksheet->cellExistsByColumnAndRow($col, $row)) ? $worksheet->getCellByColumnAndRow($col, $row)->getValue() : $default_val;

		if ($val === null) {
			$val = $default_val;
		}

		return $val;
	}

	protected function validateHeading(&$data, &$expected, &$multilingual) {
		$default_language_code = $this->config->get('config_admin_language');

		$heading = array();

		$k = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

		$i = 0;

		for ($j = 1; $j <= $k; $j += 1) {
			$entry = $this->getCell($data, $i, $j);

			$bracket_start = strripos($entry, '(', 0);

			if ($bracket_start === false) {
				if (in_array($entry, $multilingual)) {
					return false;
				}

				$heading[] = strtolower($entry);

			} else {
				$name = strtolower(substr($entry, 0, $bracket_start));

				if (!in_array($name, $multilingual)) {
					return false;
				}

				$bracket_end = strripos($entry, ')', $bracket_start);

				if ($bracket_end <= $bracket_start) {
					return false;
				}

				if ($bracket_end+1 != strlen($entry)) {
					return false;
				}

				$language_code = strtolower(substr($entry, $bracket_start+1, $bracket_end-$bracket_start-1));

				if (count($heading) <= 0) {
					return false;
				}

				if ($heading[count($heading)-1] != $name) {
					$heading[] = $name;
				}
			}
		}

		for ($i = 0; $i < count($expected); $i += 1) {
			if (!isset($heading[$i])) {
				return false;
			}

			if ($heading[$i] != $expected[$i]) {
				return false;
			}
		}

		return true;
	}

	protected function validateCustomers(&$reader) {
		$data = $reader->getSheetByName('Customers');

		if ($data == null) {
			return true;
		}

		$expected_heading = array(
			"customer_id", "customer_group", "store_id", "firstname", "lastname", "email", "telephone", "fax", "gender", "date_of_birth", "password", "salt", "cart", "wishlist", "newsletter", "address_id", "ip", "status", "approved", "token", "date_added"
		);

		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateAddresses(&$reader) {
		$data = $reader->getSheetByName('Addresses');

		if ($data == null) {
			return true;
		}

		$expected_heading = array(
			"customer_id", "firstname", "lastname", "company", "company_id", "tax_id", "address_1", "address_2", "city", "postcode", "zone", "country", "default"
		);

		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateCategories(&$reader) {
		$data = $reader->getSheetByName('Categories');

		if ($data == null) {
			return true;
		}

		$expected_heading = array(
			"category_id", "parent_id", "name", "description", "meta_description", "meta_keywords", "sort_order", "image_name", "date_added", "date_modified", "seo_keyword", "store_ids", "layout", "status"
		);

		$expected_multilingual = array("name", "description", "meta_description", "meta_keywords");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateCategoryFilters(&$reader) {
		$data = $reader->getSheetByName('CategoryFilters');

		if ($data == null) {
			return true;
		}

		if (!$this->existFilter()) {
			throw new Exception($this->language->get('error_filter_not_supported'));
		}

		if ($this->config->get('export_import_settings_use_filter_group_id')) {
			if ($this->config->get('export_import_settings_use_filter_id')) {
				$expected_heading = array("category_id", "filter_group_id", "filter_id");
			} else {
				$expected_heading = array("category_id", "filter_group_id", "filter");
			}
		} else {
			if ($this->config->get('export_import_settings_use_filter_id')) {
				$expected_heading = array("category_id", "filter_group", "filter_id");
			} else {
				$expected_heading = array("category_id", "filter_group", "filter");
			}
		}

		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateProducts(&$reader) {
		$data = $reader->getSheetByName('Products');

		if ($data == null) {
			return true;
		}

		$expected_heading = array("product_id", "name", "categories", "sku", "upc", "ean", "jan", "isbn", "mpn");

		$expected_heading = array_merge($expected_heading, array("location", "quantity", "model", "manufacturer_name", "image_name", "label_name", "video_code", "shipping", "price", "cost", "quote", "age_minimum", "points", "date_added"));
		$expected_heading = array_merge($expected_heading, array("date_modified", "date_available", "palette_id", "weight", "weight_unit", "length", "width", "height", "length_unit", "status", "tax_class_id", "tax_local_rate_id", "seo_keyword"));
		$expected_heading = array_merge($expected_heading, array("description", "meta_description", "meta_keywords", "stock_status_id", "store_ids", "layout", "related_ids", "location_ids", "tags", "sort_order", "subtract", "minimum", "viewed"));

		$expected_multilingual = array("name", "description", "meta_description", "meta_keywords", "tags");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateAdditionalImages(&$reader) {
		$data = $reader->getSheetByName('AdditionalImages');

		if ($data == null) {
			return true;
		}

		$expected_heading = array("product_id", "image", "palette_color_id", "sort_order");
		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateSpecials(&$reader) {
		$data = $reader->getSheetByName('Specials');

		if ($data == null) {
			return true;
		}

		$expected_heading = array("product_id", "customer_group", "priority", "price", "date_start", "date_end");
		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateDiscounts(&$reader) {
		$data = $reader->getSheetByName('Discounts');

		if ($data == null) {
			return true;
		}

		$expected_heading = array("product_id", "customer_group", "quantity", "priority", "price", "date_start", "date_end");
		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateRewards(&$reader) {
		$data = $reader->getSheetByName('Rewards');

		if ($data == null) {
			return true;
		}

		$expected_heading = array("product_id", "customer_group", "points");
		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateProductOptions(&$reader) {
		$data = $reader->getSheetByName('ProductOptions');

		if ($data == null) {
			return true;
		}

		if ($this->config->get('export_import_settings_use_option_id')) {
			$expected_heading = array("product_id", "option_id", "default_option_value", "required");
		} else {
			$expected_heading = array("product_id", "option", "default_option_value", "required");
		}

		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateProductOptionValues(&$reader) {
		$data = $reader->getSheetByName('ProductOptionValues');

		if ($data == null) {
			return true;
		}

		if ($this->config->get('export_import_settings_use_option_id')) {
			if ($this->config->get('export_import_settings_use_option_value_id')) {
				$expected_heading = array("product_id", "option_id", "option_value_id", "quantity", "subtract", "price", "price_prefix", "points", "points_prefix", "weight", "weight_prefix");
			} else {
				$expected_heading = array("product_id", "option_id", "option_value", "quantity", "subtract", "price", "price_prefix", "points", "points_prefix", "weight", "weight_prefix");
			}
		} else {
			if ($this->config->get('export_import_settings_use_option_value_id')) {
				$expected_heading = array("product_id", "option", "option_value_id", "quantity", "subtract", "price", "price_prefix", "points", "points_prefix", "weight", "weight_prefix");
			} else {
				$expected_heading = array("product_id", "option", "option_value", "quantity", "subtract", "price", "price_prefix", "points", "points_prefix", "weight", "weight_prefix");
			}
		}

		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateProductColors(&$reader) {
		$data = $reader->getSheetByName('ProductColors');

		if ($data == null) {
			return true;
		}

		$expected_heading = array("product_id", "product_color_id", "palette_color_id");
		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateProductFields(&$reader) {
		$data = $reader->getSheetByName('ProductFields');

		if ($data == null) {
			return true;
		}

		if (!$this->existField()) {
			throw new Exception($this->language->get('error_field_not_supported'));
		}

		$expected_heading = array("product_id", "field_id", "text");
		$expected_multilingual = array("text");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateProductAttributes(&$reader) {
		$data = $reader->getSheetByName('ProductAttributes');

		if ($data == null) {
			return true;
		}

		if ($this->config->get('export_import_settings_use_attribute_group_id')) {
			if ($this->config->get('export_import_settings_use_attribute_id')) {
				$expected_heading = array("product_id", "attribute_group_id", "attribute_id", "text");
			} else {
				$expected_heading = array("product_id", "attribute_group_id", "attribute", "text");
			}
		} else {
			if ($this->config->get('export_import_settings_use_attribute_id')) {
				$expected_heading = array("product_id", "attribute_group", "attribute_id", "text");
			} else {
				$expected_heading = array("product_id", "attribute_group", "attribute", "text");
			}
		}

		$expected_multilingual = array("text");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateProductFilters(&$reader) {
		$data = $reader->getSheetByName('ProductFilters');

		if ($data == null) {
			return true;
		}

		if (!$this->existFilter()) {
			throw new Exception($this->language->get('error_filter_not_supported'));
		}

		if ($this->config->get('export_import_settings_use_filter_group_id')) {
			if ($this->config->get('export_import_settings_use_filter_id')) {
				$expected_heading = array("product_id", "filter_group_id", "filter_id");
			} else {
				$expected_heading = array("product_id", "filter_group_id", "filter");
			}
		} else {
			if ($this->config->get('export_import_settings_use_filter_id')) {
				$expected_heading = array("product_id", "filter_group", "filter_id");
			} else {
				$expected_heading = array("product_id", "filter_group", "filter");
			}
		}

		$expected_multilingual = array();

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateOptions(&$reader) {
		$data = $reader->getSheetByName('Options');

		if ($data == null) {
			return true;
		}

		$expected_heading = array("option_id", "type", "sort_order", "name");
		$expected_multilingual = array("name");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateOptionValues(&$reader) {
		$data = $reader->getSheetByName('OptionValues');

		if ($data == null) {
			return true;
		}

		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "option_value` LIKE 'image'");

		$exist_image = ($query->num_rows > 0) ? true : false;

		if ($exist_image) {
			$expected_heading = array("option_value_id", "option_id", "image", "sort_order", "name");
		} else {
			$expected_heading = array("option_value_id", "option_id", "sort_order", "name");
		}

		$expected_multilingual = array("name");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateAttributeGroups(&$reader) {
		$data = $reader->getSheetByName('AttributeGroups');

		if ($data == null) {
			return true;
		}

		$expected_heading = array("attribute_group_id", "sort_order", "name");
		$expected_multilingual = array("name");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateAttributes(&$reader) {
		$data = $reader->getSheetByName('Attributes');

		if ($data == null) {
			return true;
		}

		$expected_heading = array("attribute_id", "attribute_group_id", "sort_order", "name");
		$expected_multilingual = array("name");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateFilterGroups($reader) {
		$data = $reader->getSheetByName('FilterGroups');

		if ($data == null) {
			return true;
		}

		if (!$this->existFilter()) {
			throw new Exception($this->language->get('error_filter_not_supported'));
		}

		$expected_heading = array("filter_group_id", "sort_order", "name");
		$expected_multilingual = array("name");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateFilters(&$reader) {
		$data = $reader->getSheetByName('Filters');

		if ($data == null) {
			return true;
		}

		if (!$this->existFilter()) {
			throw new Exception($this->language->get('error_filter_not_supported'));
		}

		$expected_heading = array("filter_id", "filter_group_id", "sort_order", "name");
		$expected_multilingual = array("name");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateFields(&$reader) {
		$data = $reader->getSheetByName('Fields');

		if ($data == null) {
			return true;
		}

		if (!$this->existField()) {
			throw new Exception($this->language->get('error_field_not_supported'));
		}

		$expected_heading = array("field_id", "sort_order", "status", "title", "description");
		$expected_multilingual = array("title", "description");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validatePalettes(&$reader) {
		$data = $reader->getSheetByName('Palettes');

		if ($data == null) {
			return true;
		}

		$expected_heading = array("palette_color_id", "palette_id", "name", "color", "skin", "title");
		$expected_multilingual = array("title");

		return $this->validateHeading($data, $expected_heading, $expected_multilingual);
	}

	protected function validateCategoryIdColumns(&$reader) {
		$data = $reader->getSheetByName('Categories');

		if ($data == null) {
			return true;
		}

		$ok = true;

		// Only unique numeric category_ids can be used, in ascending order, in worksheet 'Categories'
		$previous_category_id = 0;

		$has_missing_category_ids = false;

		$category_ids = array();

		$k = $data->getHighestRow();

		for ($i = 1; $i < $k; $i += 1) {
			$category_id = $this->getCell($data, $i, 1);

			if ($category_id == "") {
				if (!$has_missing_category_ids) {
					$msg = str_replace( '%1', 'Categories', $this->language->get( 'error_missing_category_id' ) );
					$this->log->write( $msg );
					$has_missing_category_ids = true;
				}
				$ok = false;
				continue;
			}

			if (!$this->isInteger($category_id)) {
				$msg = str_replace( '%2', $category_id, str_replace( '%1', 'Categories', $this->language->get( 'error_invalid_category_id' ) ) );
				$this->log->write( $msg );
				$ok = false;
				continue;
			}

			if (in_array( $category_id, $category_ids )) {
				$msg = str_replace( '%2', $category_id, str_replace( '%1', 'Categories', $this->language->get( 'error_duplicate_category_id' ) ) );
				$this->log->write( $msg );
				$ok = false;
			}

			$category_ids[] = $category_id;

			if ($category_id < $previous_category_id) {
				$msg = str_replace( '%2', $category_id, str_replace( '%1', 'Categories', $this->language->get( 'error_wrong_order_category_id' ) ) );
				$this->log->write( $msg );
				$ok = false;
			}

			$previous_category_id = $category_id;
		}

		// Make sure category_ids are numeric entries and are also mentioned in worksheet 'Categories'
		$worksheets = array('CategoryFilters');

		foreach ($worksheets as $worksheet) {
			$data = $reader->getSheetByName($worksheet);

			if ($data == null) {
				continue;
			}

			$previous_category_id = 0;

			$has_missing_category_ids = false;

			$unlisted_category_ids = array();

			$k = $data->getHighestRow();

			for ($i = 1; $i < $k; $i += 1) {
				$category_id = $this->getCell($data, $i, 1);

				if ($category_id == "") {
					if (!$has_missing_category_ids) {
						$msg = str_replace( '%1', $worksheet, $this->language->get( 'error_missing_category_id' ) );
						$this->log->write( $msg );
						$has_missing_category_ids = true;
					}
					$ok = false;
					continue;
				}

				if (!$this->isInteger($category_id)) {
					$msg = str_replace( '%2', $category_id, str_replace( '%1', $worksheet, $this->language->get( 'error_invalid_category_id' ) ) );
					$this->log->write( $msg );
					$ok = false;
					continue;
				}

				if (!in_array( $category_id, $category_ids )) {
					if (!in_array( $category_id, $unlisted_category_ids )) {
						$unlisted_category_ids[] = $category_id;
						$msg = str_replace( '%2', $category_id, str_replace( '%1', $worksheet, $this->language->get( 'error_unlisted_category_id' ) ) );
						$this->log->write( $msg );
						$ok = false;
					}
				}

				if ($category_id < $previous_category_id) {
					$msg = str_replace( '%2', $category_id, str_replace( '%1', $worksheet, $this->language->get( 'error_wrong_order_category_id' ) ) );
					$this->log->write( $msg );
					$ok = false;
				}

				$previous_category_id = $category_id;
			}
		}

		return $ok;
	}

	protected function validateProductIdColumns(&$reader) {
		$data = $reader->getSheetByName('Products');

		if ($data == null) {
			return true;
		}

		$ok = true;

		// Only unique numeric product_ids can be used in worksheet 'Products'
		$has_missing_product_ids = false;

		$product_ids = array();

		$k = $data->getHighestRow();

		for ($i = 1; $i < $k; $i += 1) {
			$product_id = trim($this->getCell($data, $i, 1));

			if ($product_id == "") {
				if (!$has_missing_product_ids) {
					$msg = str_replace('%1', 'Products', $this->language->get('error_missing_product_id'));
					$this->log->write($msg);

					$has_missing_product_ids = true;
				}

				$ok = false;
				continue;
			}

			if (!ctype_digit($product_id)) {
				$msg = str_replace('%2', $product_id, str_replace('%1', 'Products', $this->language->get('error_invalid_product_id')));
				$this->log->write($msg);

				$ok = false;
				continue;
			}

			if (in_array($product_id, $product_ids)) {
				$msg = str_replace('%2', $product_id, str_replace('%1', 'Products', $this->language->get('error_duplicate_product_id')));
				$this->log->write( $msg );

				$ok = false;
				continue;
			}

			$product_ids[] = $product_id;
		}

		// Make sure product_ids are numeric entries and are also mentioned in worksheet 'Products'
		$worksheets = array('AdditionalImages', 'Specials', 'Discounts', 'Rewards', 'ProductOptions', 'ProductOptionValues', 'ProductColors',  'ProductFields', 'ProductAttributes');

		foreach ($worksheets as $worksheet) {
			$data = $reader->getSheetByName($worksheet);

			if ($data == null) {
				continue;
			}

			$has_missing_product_ids = false;

			$unlisted_product_ids = array();

			$k = $data->getHighestRow();

			for ($i = 1; $i < $k; $i += 1) {
				$product_id = trim($this->getCell($data, $i, 1));

				if ($product_id == "") {
					if (!$has_missing_product_ids) {
						$msg = str_replace('%1', $worksheet, $this->language->get('error_missing_product_id'));
						$this->log->write($msg);

						$has_missing_product_ids = true;
					}

					$ok = false;
					continue;
				}

				if (!ctype_digit($product_id)) {
					$msg = str_replace('%2', $product_id, str_replace('%1', $worksheet, $this->language->get('error_invalid_product_id')));
					$this->log->write($msg);

					$ok = false;
					continue;
				}

				if (!in_array($product_id, $product_ids)) {
					if (!in_array($product_id, $unlisted_product_ids)) {
						$unlisted_product_ids[] = $product_id;

						$msg = str_replace('%2', $product_id, str_replace('%1', $worksheet, $this->language->get('error_unlisted_product_id')));
						$this->log->write( $msg );

						$ok = false;
						continue;
					}
				}
			}
		}

		return $ok;
	}

	protected function validateCustomerIdColumns(&$reader) {
		$data = $reader->getSheetByName('Customers');

		if ($data == null) {
			return true;
		}

		$ok = true;

		// Only unique numeric customer_ids can be used, in ascending order, in worksheet 'Customers'
		$previous_customer_id = 0;

		$has_missing_customer_ids = false;

		$customer_ids = array();

		$k = $data->getHighestRow();

		for ($i = 1; $i < $k; $i += 1) {
			$customer_id = $this->getCell($data, $i, 1);

			if ($customer_id == "") {
				if (!$has_missing_customer_ids) {
					$msg = str_replace('%1', 'Customers', $this->language->get('error_missing_customer_id'));
					$this->log->write( $msg );
					$has_missing_customer_ids = true;
				}
				$ok = false;
				continue;
			}

			if (!$this->isInteger($customer_id)) {
				$msg = str_replace( '%2', $customer_id, str_replace('%1', 'Customers', $this->language->get('error_invalid_customer_id')));
				$this->log->write( $msg );
				$ok = false;
				continue;
			}

			if (in_array( $customer_id, $customer_ids )) {
				$msg = str_replace( '%2', $customer_id, str_replace('%1', 'Customers', $this->language->get('error_duplicate_customer_id')));
				$this->log->write( $msg );
				$ok = false;
			}

			$customer_ids[] = $customer_id;

			if ($customer_id < $previous_customer_id) {
				$msg = str_replace( '%2', $customer_id, str_replace('%1', 'Customers', $this->language->get('error_wrong_order_customer_id')));
				$this->log->write( $msg );
				$ok = false;
			}

			$previous_customer_id = $customer_id;
		}

		// Make sure customer_ids are numeric entries and are also mentioned in worksheet 'Customers'
		$worksheets = array('Addresses');

		foreach ($worksheets as $worksheet) {
			$data = $reader->getSheetByName($worksheet);

			if ($data == null) {
				continue;
			}

			$previous_customer_id = 0;

			$has_missing_customer_ids = false;

			$unlisted_customer_ids = array();

			$k = $data->getHighestRow();

			for ($i = 1; $i < $k; $i += 1) {
				$customer_id = $this->getCell($data, $i, 1);

				if ($customer_id == "") {
					if (!$has_missing_customer_ids) {
						$msg = str_replace( '%1', $worksheet, $this->language->get('error_missing_customer_id'));
						$this->log->write( $msg );
						$has_missing_customer_ids = true;
					}
					$ok = false;
					continue;
				}

				if (!$this->isInteger($customer_id)) {
					$msg = str_replace('%2', $customer_id, str_replace('%1', $worksheet, $this->language->get('error_invalid_customer_id')));
					$this->log->write( $msg );
					$ok = false;
					continue;
				}

				if (!in_array( $customer_id, $customer_ids )) {
					if (!in_array( $customer_id, $unlisted_customer_ids )) {
						$unlisted_customer_ids[] = $customer_id;
						$msg = str_replace('%2', $customer_id, str_replace('%1', $worksheet, $this->language->get('error_unlisted_customer_id')));
						$this->log->write( $msg );
					}
					$ok = false;
				}

				if ($customer_id < $previous_customer_id) {
					$msg = str_replace('%2', $customer_id, str_replace('%1', $worksheet, $this->language->get('error_wrong_order_customer_id')));
					$this->log->write( $msg );
					$ok = false;
				}

				$previous_customer_id = $customer_id;
			}
		}

		return $ok;
	}

	protected function validateAddressCountriesAndZones(&$reader) {
		$data = $reader->getSheetByName('Addresses');

		if ($data == null) {
			return true;
		}

		$ok = true;

		$country_col = 0;
		$zone_col = 0;

		$k = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());

		$i = 0;

		for ($j = 1; $j <= $k; $j += 1) {
			$entry = $this->getCell($data, $i, $j);

			if ($entry == 'country') {
				$country_col = $j;
			} else if ($entry == 'zone') {
				$zone_col = $j;
			}
		}

		if ($country_col == 0) {
			$msg = $this->language->get('error_missing_country_col');
			$msg = str_replace('%1', 'Addresses', $msg);
			$this->log->write( $msg );
			$ok = false;
		}

		if ($zone_col == 0) {
			$msg = $this->language->get('error_missing_zone_col');
			$msg = str_replace('%1', 'Addresses', $msg);
			$this->log->write( $msg );
			$ok = false;
		}

		if (!$ok) {
			return false;
		}

		$available_country_ids = $this->getAvailableCountryIds();
		$available_zone_ids = $this->getAvailableZoneIds();

		$undefined_countries = array();
		$undefined_zones = array();

		$k = $data->getHighestRow();

		for ($i = 1; $i < $k; $i += 1) {
			$country = $this->getCell($data, $i, $country_col);
			$zone = $this->getCell($data, $i, $zone_col);

			if (!isset($available_country_ids[$country])) {
				$country = html_entity_decode($country, ENT_QUOTES, 'UTF-8');

				if (!isset($available_country_ids[$country])) {
					if (!in_array( $country, $undefined_countries )) {
						$undefined_countries[] = $country;

						$msg = $this->language->get('error_undefined_country');
						$msg = str_replace('%1', $country, $msg);
						$msg = str_replace('%2', 'Addresses', $msg);
						$this->log->write($msg);
						$ok = false;
					}
					continue;
				}
			}

			if ($zone != '') {
				if (!isset($available_zone_ids[$country][$zone])) {
					$zone = html_entity_decode($zone, ENT_QUOTES, 'UTF-8');

					if (!isset($available_zone_ids[$country][$zone])) {
						$zone = htmlentities($zone, ENT_NOQUOTES, 'UTF-8');

						if (!isset($available_zone_ids[$country][$zone])) {
							$zone = html_entity_decode($zone, ENT_QUOTES, 'UTF-8');
							$zone = htmlentities($zone, ENT_QUOTES, 'UTF-8');

							if (!isset($available_zone_ids[$country][$zone])) {
								$zone = html_entity_decode($zone, ENT_QUOTES, 'UTF-8');
								$zone = htmlentities($zone, ENT_NOQUOTES, 'UTF-8');
								$zone = str_replace("'", "&#39;", $zone);

								if (!isset($available_zone_ids[$country][$zone])) {
									if (!isset($undefined_zones[$country])) {
										$undefined_zones[$country] = array();
									}

									if (!in_array($zone, $undefined_zones[$country])) {
										$undefined_zones[$country][] = $zone;
										$msg = $this->language->get('error_undefined_zone');
										$msg = str_replace('%1', $country, $msg);
										$msg = str_replace('%2', $zone, $msg);
										$msg = str_replace('%3', 'Addresses', $msg);
										$this->log->write($msg);
										$ok = false;
									}
									continue;
								}
							}
						}
					}
				}
			}
		}

		return $ok;
	}

	protected function validateCustomerGroupColumns(&$reader) {
		// All customer_groups mentioned in the worksheets must be defined
		$worksheets = array('Specials', 'Discounts', 'Rewards', 'Customers');

		$ok = true;

		$customer_groups = array();

		$customer_group_ids = $this->getCustomerGroupIds();

		foreach ($worksheets as $worksheet) {
			$data = $reader->getSheetByName($worksheet);

			if ($data == null) {
				continue;
			}

			$has_missing_customer_groups = false;

			$k = $data->getHighestRow();

			for ($i = 1; $i < $k; $i += 1) {
				$customer_group = trim($this->getCell($data, $i, 2));

				if ($customer_group == "") {
					if (!$has_missing_customer_groups) {
						$msg = $this->language->get('error_missing_customer_group');
						$msg = str_replace('%1', $worksheet, $msg);
						$this->log->write($msg);

						$has_missing_customer_groups = true;
					}

					$ok = false;
					continue;
				}

				if (!in_array($customer_group, $customer_groups)) {
					if (!isset($customer_group_ids[$customer_group])) {
						$msg = $this->language->get('error_invalid_customer_group');
						$msg = str_replace('%1', $worksheet, str_replace('%2', $customer_group, $msg));
						$this->log->write($msg);

						$ok = false;
						continue;
					}

					$customer_groups[] = $customer_group;
				}
			}
		}

		return $ok;
	}

	protected function validateOptionColumns(&$reader) {
		// Get all existing options and option values
		$ok = true;

		$export_import_settings_use_option_id = $this->config->get('export_import_settings_use_option_id');
		$export_import_settings_use_option_value_id = $this->config->get('export_import_settings_use_option_value_id');

		$language_id = $this->getDefaultLanguageId();

		$sql = "SELECT od.option_id, od.name AS option_name, ovd.option_value_id, ovd.name AS option_value_name";
		$sql .= " FROM `" . DB_PREFIX . "option_description` od";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "option_value_description` ovd ON (ovd.option_id = od.option_id) AND ovd.language_id = '" . (int)$language_id . "'";
		$sql .= " WHERE od.language_id = '" . (int)$language_id . "'";

		$query = $this->db->query($sql);

		$options = array();

		foreach ($query->rows as $row) {
			if ($export_import_settings_use_option_id) {
				$option_id = $row['option_id'];

				if (!isset($options[$option_id])) {
					$options[$option_id] = array();
				}

				if ($export_import_settings_use_option_value_id) {
					$option_value_id = $row['option_value_id'];

					if (!is_null($option_value_id)) {
						$options[$option_id][$option_value_id] = true;
					}

				} else {
					$option_value_name = htmlspecialchars_decode($row['option_value_name']);

					if (!is_null($option_value_name)) {
						$options[$option_id][$option_value_name] = true;
					}
				}

			} else {
				$option_name = htmlspecialchars_decode($row['option_name']);

				if (!isset($options[$option_name])) {
					$options[$option_name] = array();
				}

				if ($export_import_settings_use_option_value_id) {
					$option_value_id = $row['option_value_id'];

					if (!is_null($option_value_id)) {
						$options[$option_name][$option_value_id] = true;
					}

				} else {
					$option_value_name = htmlspecialchars_decode($row['option_value_name']);

					if (!is_null($option_value_name)) {
						$options[$option_name][$option_value_name] = true;
					}
				}
			}
		}

		// Only existing options can be used in 'ProductOptions' worksheet
		$product_options = array();

		$data = $reader->getSheetByName('ProductOptions');

		if ($data == null) {
			return $ok;
		}

		$has_missing_options = false;

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 1; $i < $k; $i += 1) {
			$product_id = trim($this->getCell($data, $i, 1));

			if ($product_id == "") {
				continue;
			}

			if ($export_import_settings_use_option_id) {
				$option_id = trim($this->getCell($data, $i, 2));

				if ($option_id == "") {
					if (!$has_missing_options) {
						$msg = str_replace('%1', 'ProductOptions', $this->language->get('error_missing_option_id'));
						$this->log->write($msg);

						$has_missing_options = true;
					}

					$ok = false;
					continue;
				}

				if (!isset($options[$option_id])) {
					$msg = $this->language->get('error_invalid_option_id');
					$msg = str_replace('%1', 'ProductOptions', $msg);
					$msg = str_replace('%2', $option_id, $msg);
					$this->log->write($msg);

					$ok = false;
					continue;
				}

				$product_options[$product_id][$option_id] = true;

			} else {
				$option_name = trim($this->getCell($data, $i, 2));

				if ($option_name == "") {
					if (!$has_missing_options) {
						$msg = str_replace('%1', 'ProductOptions', $this->language->get('error_missing_option_name'));
						$this->log->write($msg);

						$has_missing_options = true;
					}

					$ok = false;
					continue;
				}

				if (!isset($options[$option_name])) {
					$msg = $this->language->get('error_invalid_option_name');
					$msg = str_replace('%1', 'ProductOptions', $msg);
					$msg = str_replace('%2', $option_name, $msg);
					$this->log->write($msg);

					$ok= false;
					continue;
				}

				$product_options[$product_id][$option_name] = true;
			}
		}

		// Only existing options and option values can be used in 'ProductOptionValues' worksheet
		$data = $reader->getSheetByName('ProductOptionValues');

		if ($data == null) {
			return $ok;
		}

		$has_missing_options = false;
		$has_missing_option_values = false;

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 1; $i < $k; $i += 1) {
			$product_id = trim($this->getCell($data, $i, 1));

			if ($product_id == "") {
				continue;
			}

			if ($export_import_settings_use_option_id) {
				$option_id = trim($this->getCell($data, $i, 2));

				if ($option_id == "") {
					if (!$has_missing_options) {
						$msg = str_replace('%1', 'ProductOptionValues', $this->language->get('error_missing_option_id'));
						$this->log->write($msg);

						$has_missing_options = true;
					}

					$ok = false;
					continue;
				}

				if (!isset($options[$option_id])) {
					$msg = $this->language->get('error_invalid_option_id');
					$msg = str_replace('%1', 'ProductOptionValues', $msg);
					$msg = str_replace('%2', $option_id, $msg);
					$this->log->write($msg);

					$ok = false;
					continue;
				}

				if (!isset($product_options[$product_id][$option_id])) {
					$msg = $this->language->get('error_invalid_product_id_option_id');
					$msg = str_replace('%1', 'ProductOptionValues', $msg);
					$msg = str_replace('%2', $product_id, $msg);
					$msg = str_replace('%3', $option_id, $msg);
					$msg = str_replace('%4', 'ProductOptions', $msg);
					$this->log->write($msg);

					$ok = false;
					continue;
				}

				if ($export_import_settings_use_option_value_id) {
					$option_value_id = trim($this->getCell($data, $i, 3));

					if ($option_value_id == "") {
						if (!$has_missing_option_values) {
							$msg = str_replace('%1', 'ProductOptionValues', $this->language->get('error_missing_option_value_id'));
							$this->log->write($msg);

							$has_missing_option_values = true;
						}

						$ok = false;
						continue;
					}

					if (!isset($options[$option_id][$option_value_id])) {
						$msg = $this->language->get('error_invalid_option_id_option_value_id');
						$msg = str_replace('%1', 'ProductOptionValues', $msg);
						$msg = str_replace('%2', $option_id, $msg);
						$msg = str_replace('%3', $option_value_id, $msg);
						$this->log->write($msg);

						$ok = false;
						continue;
					}

				} else {
					$option_value_name = trim($this->getCell($data, $i, 3));

					if ($option_value_name == "") {
						if (!$has_missing_option_values) {
							$msg = str_replace('%1', 'ProductOptionValues', $this->language->get('error_missing_option_value_name'));
							$this->log->write($msg);

							$has_missing_option_values = true;
						}

						$ok = false;
						continue;
					}

					if (!isset($options[$option_id][$option_value_name])) {
						$msg = $this->language->get('error_invalid_option_id_option_value_name');
						$msg = str_replace('%1', 'ProductOptionValues', $msg);
						$msg = str_replace('%2', $option_id, $msg);
						$msg = str_replace('%3', $option_value_name, $msg);
						$this->log->write($msg);

						$ok = false;
						continue;
					}
				}

			} else {
				$option_name = trim($this->getCell($data, $i, 2));

				if ($option_name == "") {
					if (!$has_missing_options) {
						$msg = str_replace('%1', 'ProductOptionValues', $this->language->get('error_missing_option_name'));
						$this->log->write($msg);

						$has_missing_options = true;
					}

					$ok = false;
					continue;
				}

				if (!isset($options[$option_name])) {
					$msg = $this->language->get('error_invalid_option_name');
					$msg = str_replace('%1', 'ProductOptionValues', $msg);
					$msg = str_replace('%2', $option_name, $msg);
					$this->log->write($msg);

					$ok= false;
					continue;
				}

				if (!isset($product_options[$product_id][$option_name])) {
					$msg = $this->language->get('error_invalid_product_id_option_name');
					$msg = str_replace('%1', 'ProductOptionValues', $msg);
					$msg = str_replace('%2', $product_id, $msg);
					$msg = str_replace('%3', $option_name, $msg);
					$msg = str_replace('%4', 'ProductOptions', $msg);
					$this->log->write($msg);

					$ok = false;
					continue;
				}

				if ($export_import_settings_use_option_value_id) {
					$option_value_id = trim($this->getCell($data, $i, 3));

					if ($option_value_id == "") {
						if (!$has_missing_option_values) {
							$msg = str_replace('%1', 'ProductOptionValues', $this->language->get('error_missing_option_value_id'));
							$this->log->write($msg);

							$has_missing_option_values = true;
						}

						$ok = false;
						continue;
					}

					if (!isset($options[$option_name][$option_value_id])) {
						$msg = $this->language->get('error_invalid_option_name_option_value_id');
						$msg = str_replace('%1', 'ProductOptionValues', $msg);
						$msg = str_replace('%2', $option_name, $msg);
						$msg = str_replace('%3', $option_value_id, $msg);
						$this->log->write($msg);

						$ok = false;
						continue;
					}

				} else {
					$option_value_name = trim($this->getCell($data, $i, 3));

					if ($option_value_name == "") {
						if (!$has_missing_option_values) {
							$msg = str_replace('%1', 'ProductOptionValues', $this->language->get('error_missing_option_value_name'));
							$this->log->write($msg);

							$has_missing_option_values = true;
						}

						$ok = false;
						continue;
					}

					if (!isset($options[$option_name][$option_value_name])) {
						$msg = $this->language->get('error_invalid_option_name_option_value_name');
						$msg = str_replace('%1', 'ProductOptionValues', $msg);
						$msg = str_replace('%2', $option_name, $msg);
						$msg = str_replace('%3', $option_value_name, $msg);
						$this->log->write($msg);

						$ok = false;
						continue;
					}
				}
			}
		}

		return $ok;
	}

	// Get all existing attribute_groups and attributes
	protected function validateAttributeColumns(&$reader) {
		$ok = true;

		$export_import_settings_use_attribute_group_id = $this->config->get('export_import_settings_use_attribute_group_id');
		$export_import_settings_use_attribute_id = $this->config->get('export_import_settings_use_attribute_id');

		$language_id = $this->getDefaultLanguageId();

		$sql = "SELECT agd.attribute_group_id, agd.name AS attribute_group_name, ad.attribute_id, ad.name AS attribute_name";
		$sql .= " FROM `" . DB_PREFIX . "attribute_group_description` agd";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "attribute` a ON (a.attribute_group_id = agd.attribute_group_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "attribute_description` ad ON (ad.attribute_id = a.attribute_id)";
		$sql .= " WHERE ad.language_id = '" . (int)$language_id . "'";
		$sql .= " AND agd.language_id = '" . (int)$language_id . "'";

		$query = $this->db->query($sql);

		$attribute_groups = array();

		foreach ($query->rows as $row) {
			if ($export_import_settings_use_attribute_group_id) {
				$attribute_group_id = $row['attribute_group_id'];

				if (!isset($attribute_groups[$attribute_group_id])) {
					$attribute_groups[$attribute_group_id] = array();
				}

				if ($export_import_settings_use_attribute_id) {
					$attribute_id = $row['attribute_id'];

					if (!is_null($attribute_id)) {
						$attribute_groups[$attribute_group_id][$attribute_id] = true;
					}

				} else {
					$attribute_name = htmlspecialchars_decode($row['attribute_name']);

					if (!is_null($attribute_name)) {
						$attribute_groups[$attribute_group_id][$attribute_name] = true;
					}
				}

			} else {
				$attribute_group_name = htmlspecialchars_decode($row['attribute_group_name']);

				if (!isset($attribute_groups[$attribute_group_name])) {
					$attribute_groups[$attribute_group_name] = array();
				}

				if ($export_import_settings_use_attribute_id) {
					$attribute_id = $row['attribute_id'];

					if (!is_null($attribute_id)) {
						$attribute_groups[$attribute_group_name][$attribute_id] = true;
					}

				} else {
					$attribute_name = htmlspecialchars_decode($row['attribute_name']);

					if (!is_null($attribute_name)) {
						$attribute_groups[$attribute_group_name][$attribute_name] = true;
					}
				}
			}
		}

		// Only existing attribute_groups and attributes can be used in 'ProductAttributes' worksheet
		$data = $reader->getSheetByName('ProductAttributes');

		if ($data == null) {
			return $ok;
		}

		$has_missing_attribute_groups = false;
		$has_missing_attributes = false;

		$i = 0;
		$k = $data->getHighestRow();

		for ($i = 1; $i < $k; $i += 1) {
			$product_id = trim($this->getCell($data, $i, 1));

			if ($product_id == "") {
				continue;
			}

			if ($export_import_settings_use_attribute_group_id) {
				$attribute_group_id = trim($this->getCell($data, $i, 2));

				if ($attribute_group_id == "") {
					if (!$has_missing_attribute_groups) {
						$msg = str_replace('%1', 'ProductAttributes', $this->language->get('error_missing_attribute_group_id'));
						$this->log->write($msg);

						$has_missing_attribute_groups = true;
					}

					$ok = false;
					continue;
				}

				if (!isset($attribute_groups[$attribute_group_id])) {
					$msg = $this->language->get('error_invalid_attribute_group_id');
					$msg = str_replace('%1', 'ProductAttributes', $msg);
					$msg = str_replace('%2', $attribute_group_id, $msg);
					$this->log->write($msg);

					$ok = false;
					continue;
				}

				if ($export_import_settings_use_attribute_id) {
					$attribute_id = trim($this->getCell($data, $i, 3));

					if ($attribute_id == "") {
						if (!$has_missing_attributes) {
							$msg = str_replace('%1', 'ProductAttributes', $this->language->get('error_missing_attribute_id'));
							$this->log->write($msg);

							$has_missing_attributes = true;
						}

						$ok = false;
						continue;
					}

					if (!isset($attribute_groups[$attribute_group_id][$attribute_id])) {
						$msg = $this->language->get('error_invalid_attribute_group_id_attribute_id');
						$msg = str_replace('%1', 'ProductAttributes', $msg);
						$msg = str_replace('%2', $attribute_group_id, $msg);
						$msg = str_replace('%3', $attribute_id, $msg);
						$this->log->write($msg);

						$ok = false;
						continue;
					}

				} else {
					$attribute_name = trim($this->getCell($data, $i, 3));

					if ($attribute_name == "") {
						if (!$has_missing_attributes) {
							$msg = str_replace('%1', 'ProductAttributes', $this->language->get('error_missing_attribute_name'));
							$this->log->write($msg);

							$has_missing_attributes = true;
						}

						$ok = false;
						continue;
					}

					if (!isset($attribute_groups[$attribute_group_id][$attribute_name])) {
						$msg = $this->language->get('error_invalid_attribute_group_id_attribute_name');
						$msg = str_replace('%1', 'ProductAttributes', $msg);
						$msg = str_replace('%2', $attribute_group_id, $msg);
						$msg = str_replace('%3', $attribute_name, $msg);
						$this->log->write($msg);

						$ok = false;
						continue;
					}
				}

			} else {
				$attribute_group_name = trim($this->getCell($data, $i, 2));

				if ($attribute_group_name == "") {
					if (!$has_missing_attribute_groups) {
						$msg = str_replace('%1', 'ProductAttributes', $this->language->get('error_missing_attribute_group_name'));
						$this->log->write($msg);

						$has_missing_attribute_groups = true;
					}

					$ok = false;
					continue;
				}

				if (!isset($attribute_groups[$attribute_group_name])) {
					$msg = $this->language->get('error_invalid_attribute_group_name');
					$msg = str_replace('%1', 'ProductAttributes', $msg);
					$msg = str_replace('%2', $attribute_group_name, $msg);
					$this->log->write($msg);

					$ok = false;
					continue;
				}

				if ($export_import_settings_use_attribute_id) {
					$attribute_id = trim($this->getCell($data, $i, 3));

					if ($attribute_id == "") {
						if (!$has_missing_attributes) {
							$msg = str_replace('%1', 'ProductAttributes', $this->language->get('error_missing_attribute_id'));
							$this->log->write($msg);

							$has_missing_attributes = true;
						}

						$ok = false;
						continue;
					}

					if (!isset($attribute_groups[$attribute_group_name][$attribute_id])) {
						$msg = $this->language->get('error_invalid_attribute_group_name_attribute_id');
						$msg = str_replace('%1', 'ProductAttributes', $msg);
						$msg = str_replace('%2', $attribute_group_name, $msg);
						$msg = str_replace('%3', $attribute_id, $msg);
						$this->log->write($msg);

						$ok = false;
						continue;
					}

				} else {
					$attribute_name = trim($this->getCell($data, $i, 3));

					if ($attribute_name == "") {
						if (!$has_missing_attributes) {
							$msg = str_replace('%1', 'ProductAttributes', $this->language->get('error_missing_attribute_name'));
							$this->log->write($msg);

							$has_missing_attributes = true;
						}

						$ok = false;
						continue;
					}

					if (!isset($attribute_groups[$attribute_group_name][$attribute_name])) {
						$msg = $this->language->get('error_invalid_attribute_group_name_attribute_name');
						$msg = str_replace('%1', 'ProductAttributes', $msg);
						$msg = str_replace('%2', $attribute_group_name, $msg);
						$msg = str_replace('%3', $attribute_name, $msg);
						$this->log->write($msg);

						$ok = false;
						continue;
					}
				}
			}
		}

		return $ok;
	}

	// Get all existing filter_groups and filters
	protected function validateFilterColumns(&$reader) {
		$ok = true;

		$export_import_settings_use_filter_group_id = $this->config->get('export_import_settings_use_filter_group_id');
		$export_import_settings_use_filter_id = $this->config->get('export_import_settings_use_filter_id');

		$language_id = $this->getDefaultLanguageId();

		$sql = "SELECT fgd.filter_group_id, fgd.name AS filter_group_name, fd.filter_id, fd.name AS filter_name";
		$sql .= " FROM `" . DB_PREFIX . "filter_group_description` fgd";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "filter` f ON (f.filter_group_id = fgd.filter_group_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "filter_description` fd ON (fd.filter_id = f.filter_id)";
		$sql .= " WHERE fd.language_id = '" . (int)$language_id . "'";
		$sql .= " AND fgd.language_id = '" . (int)$language_id . "'";

		$query = $this->db->query($sql);

		$filter_groups = array();

		foreach ($query->rows as $row) {
			if ($export_import_settings_use_filter_group_id) {
				$filter_group_id = $row['filter_group_id'];

				if (!isset($filter_groups[$filter_group_id])) {
					$filter_groups[$filter_group_id] = array();
				}

				if ($export_import_settings_use_filter_id) {
					$filter_id = $row['filter_id'];

					if (!is_null($filter_id)) {
						$filter_groups[$filter_group_id][$filter_id] = true;
					}

				} else {
					$filter_name = htmlspecialchars_decode($row['filter_name']);

					if (!is_null($filter_name)) {
						$filter_groups[$filter_group_id][$filter_name] = true;
					}
				}

			} else {
				$filter_group_name = htmlspecialchars_decode($row['filter_group_name']);

				if (!isset($filter_groups[$filter_group_name])) {
					$filter_groups[$filter_group_name] = array();
				}

				if ($export_import_settings_use_filter_id) {
					$filter_id = $row['filter_id'];

					if (!is_null($filter_id)) {
						$filter_groups[$filter_group_name][$filter_id] = true;
					}

				} else {
					$filter_name = htmlspecialchars_decode($row['filter_name']);

					if (!is_null($filter_name)) {
						$filter_groups[$filter_group_name][$filter_name] = true;
					}
				}
			}
		}

		// Only existing filter_groups and filters can be used in the 'ProductFilters' and 'CategoryFilters' worksheets
		$worksheet_names = array('ProductFilters', 'CategoryFilters');

		foreach ($worksheet_names as $worksheet_name) {
			$data = $reader->getSheetByName('ProductFilters');

			if ($data == null) {
				return $ok;
			}

			$has_missing_filter_groups = false;
			$has_missing_filters = false;

			$i = 0;
			$k = $data->getHighestRow();

			for ($i = 1; $i < $k; $i += 1) {
				$id = trim($this->getCell($data, $i, 1));

				if ($id == "") {
					continue;
				}

				if ($export_import_settings_use_filter_group_id) {
					$filter_group_id = trim($this->getCell($data, $i, 2));

					if ($filter_group_id == "") {
						if (!$has_missing_filter_groups) {
							$msg = str_replace('%1', $worksheet_name, $this->language->get('error_missing_filter_group_id'));
							$this->log->write($msg);

							$has_missing_filter_groups = true;
						}

						$ok = false;
						continue;
					}

					if (!isset($filter_groups[$filter_group_id])) {
						$msg = $this->language->get('error_invalid_filter_group_id');
						$msg = str_replace('%1', $worksheet_name, $msg);
						$msg = str_replace('%2', $filter_group_id, $msg);
						$this->log->write($msg);

						$ok = false;
						continue;
					}

					if ($export_import_settings_use_filter_id) {
						$filter_id = trim($this->getCell($data, $i, 3));

						if ($filter_id == "") {
							if (!$has_missing_filters) {
								$msg = str_replace('%1', $worksheet_name, $this->language->get('error_missing_filter_id'));
								$this->log->write($msg);

								$has_missing_filters = true;
							}

							$ok = false;
							continue;
						}

						if (!isset($filter_groups[$filter_group_id][$filter_id])) {
							$msg = $this->language->get('error_invalid_filter_group_id_filter_id');
							$msg = str_replace('%1', $worksheet_name, $msg);
							$msg = str_replace('%2', $filter_group_id, $msg);
							$msg = str_replace('%3', $filter_id, $msg);
							$this->log->write($msg);

							$ok = false;
							continue;
						}

					} else {
						$filter_name = trim($this->getCell($data, $i, 3));

						if ($filter_name == "") {
							if (!$has_missing_filters) {
								$msg = str_replace('%1', $worksheet_name, $this->language->get('error_missing_filter_name'));
								$this->log->write($msg);

								$has_missing_filters = true;
							}

							$ok = false;
							continue;
						}

						if (!isset($filter_groups[$filter_group_id][$filter_name])) {
							$msg = $this->language->get('error_invalid_filter_group_id_filter_name');
							$msg = str_replace('%1', $worksheet_name, $msg);
							$msg = str_replace('%2', $filter_group_id, $msg);
							$msg = str_replace('%3', $filter_name, $msg);
							$this->log->write($msg);

							$ok = false;
							continue;
						}
					}

				} else {
					$filter_group_name = trim($this->getCell($data, $i, 2));

					if ($filter_group_name == "") {
						if (!$has_missing_filter_groups) {
							$msg = str_replace('%1', $worksheet_name, $this->language->get('error_missing_filter_group_name'));
							$this->log->write($msg);

							$has_missing_filter_groups = true;
						}

						$ok = false;
						continue;
					}

					if (!isset($filter_groups[$filter_group_name])) {
						$msg = $this->language->get('error_invalid_filter_group_name');
						$msg = str_replace('%1', $worksheet_name, $msg);
						$msg = str_replace('%2', $filter_group_name, $msg);
						$this->log->write($msg);

						$ok = false;
						continue;
					}

					if ($export_import_settings_use_filter_id) {
						$filter_id = trim($this->getCell($data, $i, 3));

						if ($filter_id == "") {
							if (!$has_missing_filters) {
								$msg = str_replace('%1', $worksheet_name, $this->language->get('error_missing_filter_id'));
								$this->log->write($msg);

								$has_missing_filters = true;
							}

							$ok = false;
							continue;
						}

						if (!isset($filter_groups[$filter_group_name][$filter_id])) {
							$msg = $this->language->get('error_invalid_filter_group_name_filter_id');
							$msg = str_replace('%1', $worksheet_name, $msg);
							$msg = str_replace('%2', $filter_group_name, $msg);
							$msg = str_replace('%3', $filter_id, $msg);
							$this->log->write($msg);

							$ok = false;
							continue;
						}

					} else {
						$filter_name = trim($this->getCell($data, $i, 3));

						if ($filter_name == "") {
							if (!$has_missing_filters) {
								$msg = str_replace('%1', $worksheet_name, $this->language->get('error_missing_filter_name'));
								$this->log->write($msg);

								$has_missing_filters = true;
							}

							$ok = false;
							continue;
						}

						if (!isset($filter_groups[$filter_group_name][$filter_name])) {
							$msg = $this->language->get('error_invalid_filter_group_name_filter_name');
							$msg = str_replace('%1', $worksheet_name, $msg);
							$msg = str_replace('%2', $filter_group_name, $msg);
							$msg = str_replace('%3', $filter_name, $msg);
							$this->log->write($msg);

							$ok = false;
							continue;
						}
					}
				}
			}
		}

		return $ok;
	}

	// Get all existing fields
	protected function validateFieldColumns(&$reader) {
		$ok = true;

		$language_id = $this->getDefaultLanguageId();

		$sql = "SELECT *, fd.field_id AS field_id FROM `" . DB_PREFIX . "field` f LEFT JOIN `" . DB_PREFIX . "field_description` fd ON (f.field_id = fd.field_id) WHERE fd.language_id = '" . (int)$language_id . "'";

		$query = $this->db->query($sql);

		$fields = array();

		foreach ($query->rows as $row) {
			$field_id = $row['field_id'];

			if (!isset($fields[$field_id])) {
				$fields[$field_id] = array();
			}
		}

		// Only existing fields can be used in the 'Fields' worksheets
		$worksheet_names = array('ProductFields');

		foreach ($worksheet_names as $worksheet_name) {
			$data = $reader->getSheetByName('ProductFields');

			if ($data == null) {
				return $ok;
			}

			$has_missing_fields = false;

			$i = 0;
			$k = $data->getHighestRow();

			for ($i = 1; $i < $k; $i += 1) {
				$field_id = trim($this->getCell($data, $i, 1));

				if ($field_id == "") {
					if (!$has_missing_fields) {
						$msg = str_replace('%1', $worksheet_name, $this->language->get('error_missing_field_id'));
						$this->log->write($msg);

						$has_missing_fields = true;
					}

					$ok = false;
					continue;
				}
			}
		}

		return $ok;
	}

	// Get all existing palettes
	protected function validatePaletteColumns(&$reader) {
		$ok = true;

		$language_id = $this->getDefaultLanguageId();

		$sql = "SELECT *, pcd.palette_id AS palette_id FROM `" . DB_PREFIX . "palette` p LEFT JOIN `" . DB_PREFIX . "palette_color` pc ON (p.palette_id = pc.palette_id) LEFT JOIN `" . DB_PREFIX . "palette_color_description` pcd ON (p.palette_id = pcd.palette_id) WHERE pcd.language_id = '" . (int)$language_id . "'";

		$query = $this->db->query($sql);

		$palettes = array();

		foreach ($query->rows as $row) {
			$palette_color_id = $row['palette_color_id'];

			if (!isset($palettes[$palette_color_id])) {
				$palettes[$palette_color_id] = array();
			}
		}

		// Only existing palettes can be used in the 'Palettes' worksheets
		$worksheet_names = array('Palettes');

		foreach ($worksheet_names as $worksheet_name) {
			$data = $reader->getSheetByName('Palettes');

			if ($data == null) {
				return $ok;
			}

			$has_missing_palettes = false;

			$i = 0;
			$k = $data->getHighestRow();

			for ($i = 1; $i < $k; $i += 1) {
				$palette_color_id = trim($this->getCell($data, $i, 1));

				if ($palette_color_id == "") {
					if (!$has_missing_palettes) {
						$msg = str_replace('%1', $worksheet_name, $this->language->get('error_missing_palette_id'));
						$this->log->write($msg);

						$has_missing_palettes = true;
					}

					$ok = false;
					continue;
				}
			}
		}

		return $ok;
	}

	protected function validateIncrementalOnly(&$reader, $incremental) {
		// Certain worksheets can only be imported in incremental mode for the time being
		$ok = true;

		$worksheets = array('Customers', 'Addresses');

		foreach ($worksheets as $worksheet) {
			$data = $reader->getSheetByName($worksheet);

			if ($data) {
				if (!$incremental) {
					$msg = $this->language->get('error_incremental_only');
					$msg = str_replace('%1', $worksheet, $msg);
					$this->log->write($msg);
					$ok = false;
				}
			}
		}

		return $ok;
	}

	protected function validateWorksheetNames(&$reader) {
		$allowed_worksheets = array(
			'Customers',
			'Addresses',
			'Categories',
			'CategoryFilters',
			'Products',
			'AdditionalImages',
			'Specials',
			'Discounts',
			'Rewards',
			'ProductOptions',
			'ProductOptionValues',
			'ProductColors',
			'ProductFields',
			'ProductAttributes',
			'ProductFilters',
			'Options',
			'OptionValues',
			'AttributeGroups',
			'Attributes',
			'FilterGroups',
			'Filters',
			'Fields',
			'Palettes'
		);

		$all_worksheets_ignored = true;

		$worksheets = $reader->getSheetNames();

		foreach ($worksheets as $worksheet) {
			if (in_array($worksheet, $allowed_worksheets)) {
				$all_worksheets_ignored = false;
				break;
			}
		}

		if ($all_worksheets_ignored) {
			return false;
		}

		return true;
	}

	protected function validateUpload($reader) {
		$ok = true;

		// Make sure at least one of worksheet names is valid
		if (!$this->validateWorksheetNames($reader)) {
			$this->log->write( $this->language->get('error_worksheets'));
			$ok = false;
		}

		// Worksheets must have correct heading rows
		if (!$this->validateCustomers($reader)) {
			$this->log->write($this->language->get('error_customers_header'));
			$ok = false;
		}

		if (!$this->validateAddresses($reader)) {
			$this->log->write($this->language->get('error_addresses_header'));
			$ok = false;
		}

		if (!$this->validateCategories($reader)) {
			$this->log->write($this->language->get('error_categories_header'));
			$ok = false;
		}

		if (!$this->validateCategoryFilters($reader)) {
			$this->log->write($this->language->get('error_category_filters_header'));
			$ok = false;
		}

		if (!$this->validateProducts($reader)) {
			$this->log->write($this->language->get('error_products_header'));
			$ok = false;
		}

		if (!$this->validateAdditionalImages($reader)) {
			$this->log->write($this->language->get('error_additional_images_header'));
			$ok = false;
		}

		if (!$this->validateSpecials($reader)) {
			$this->log->write($this->language->get('error_specials_header'));
			$ok = false;
		}

		if (!$this->validateDiscounts($reader)) {
			$this->log->write($this->language->get('error_discounts_header'));
			$ok = false;
		}

		if (!$this->validateRewards($reader)) {
			$this->log->write($this->language->get('error_rewards_header'));
			$ok = false;
		}

		if (!$this->validateProductOptions($reader)) {
			$this->log->write($this->language->get('error_product_options_header'));
			$ok = false;
		}

		if (!$this->validateProductOptionValues($reader)) {
			$this->log->write($this->language->get('error_product_option_values_header'));
			$ok = false;
		}

		if (!$this->validateProductColors($reader)) {
			$this->log->write($this->language->get('error_product_colors_header'));
			$ok = false;
		}

		if (!$this->validateProductFields($reader)) {
			$this->log->write($this->language->get('error_product_fields_header'));
			$ok = false;
		}

		if (!$this->validateProductAttributes($reader)) {
			$this->log->write($this->language->get('error_product_attributes_header'));
			$ok = false;
		}

		if (!$this->validateProductFilters($reader)) {
			$this->log->write($this->language->get('error_product_filters_header'));
			$ok = false;
		}

		if (!$this->validateOptions($reader)) {
			$this->log->write($this->language->get('error_options_header'));
			$ok = false;
		}

		if (!$this->validateOptionValues($reader)) {
			$this->log->write($this->language->get('error_option_values_header'));
			$ok = false;
		}

		if (!$this->validateAttributeGroups($reader)) {
			$this->log->write($this->language->get('error_attribute_groups_header'));
			$ok = false;
		}

		if (!$this->validateAttributes($reader)) {
			$this->log->write($this->language->get('error_attributes_header'));
			$ok = false;
		}

		if (!$this->validateFilterGroups($reader)) {
			$this->log->write($this->language->get('error_filter_groups_header'));
			$ok = false;
		}

		if (!$this->validateFilters($reader)) {
			$this->log->write($this->language->get('error_filters_header'));
			$ok = false;
		}

		if (!$this->validateFields($reader)) {
			$this->log->write($this->language->get('error_fields_header'));
			$ok = false;
		}

		if (!$this->validatePalettes($reader)) {
			$this->log->write($this->language->get('error_palettes_header'));
			$ok = false;
		}

		// Certain worksheets rely on the existence of other worksheets
		$names = $reader->getSheetNames();

		$exist_customers = false;
		$exist_addresses = false;
		$exist_categories = false;
		$exist_category_filters = false;
		$exist_product_options = false;
		$exist_product_option_values = false;
		$exist_products = false;
		$exist_additional_images = false;
		$exist_specials = false;
		$exist_discounts = false;
		$exist_rewards = false;
		$exist_product_colors = false;
		$exist_product_fields = false;
		$exist_product_attributes = false;
		$exist_product_filters = false;
		$exist_options = false;
		$exist_option_values = false;
		$exist_attributes = false;
		$exist_attribute_groups = false;
		$exist_filters = false;
		$exist_filter_groups = false;
		$exist_fields = false;
		$exist_palettes = false;

		foreach ($names as $name) {
			if ($name == 'Customers') {
				$exist_customers = true;
				continue;
			}

			if ($name == 'Addresses') {
				if (!$exist_customers) {
					// Missing Customers worksheet, or Customers worksheet not listed before Addresses
					$this->log->write($this->language->get('error_addresses'));
					$ok = false;
				}
				$exist_addresses = true;
				continue;
			}

			if ($name == 'Categories') {
				$exist_categories = true;
				continue;
			}

			if ($name == 'CategoryFilters') {
				if (!$exist_categories) {
					// Missing Categories worksheet, or Categories worksheet not listed before CategoryFilters
					$this->log->write($this->language->get('error_category_filters'));
					$ok = false;
				}

				$exist_category_filters = true;
				continue;
			}

			if ($name == 'Products') {
				$exist_products = true;
				continue;
			}

			if ($name == 'ProductOptions') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before ProductOptions
					$this->log->write($this->language->get('error_product_options'));
					$ok = false;
				}

				$exist_product_options = true;
				continue;
			}

			if ($name == 'ProductOptionValues') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before ProductOptionValues
					$this->log->write($this->language->get('error_product_options'));
					$ok = false;
				}

				if (!$exist_product_options) {
					// Missing ProductOptions worksheet, or ProductOptions worksheet not listed before ProductOptionValues
					$this->log->write($this->language->get('error_product_option_values_2'));
					$ok = false;
				}

				$exist_product_option_values = true;
				continue;
			}

			if ($name == 'AdditionalImages') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before AdditionalImages
					$this->log->write($this->language->get('error_additional_images'));
					$ok = false;
				}

				$exist_additional_images = true;
				continue;
			}

			if ($name == 'Specials') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before Specials
					$this->log->write($this->language->get('error_specials'));
					$ok = false;
				}

				$exist_specials = true;
				continue;
			}

			if ($name == 'Discounts') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before Discounts
					$this->log->write($this->language->get('error_discounts'));
					$ok = false;
				}

				$exist_discounts = true;
				continue;
			}

			if ($name == 'Rewards') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before Rewards
					$this->log->write($this->language->get('error_rewards'));
					$ok = false;
				}

				$exist_rewards = true;
				continue;
			}

			if ($name == 'ProductColors') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before ProductColors
					$this->log->write($this->language->get('error_product_colors'));
					$ok = false;
				}

				$exist_product_colors = true;
				continue;
			}

			if ($name == 'ProductFields') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before ProductFields
					$this->log->write($this->language->get('error_product_fields'));
					$ok = false;
				}

				$exist_product_fields = true;
				continue;
			}

			if ($name == 'ProductAttributes') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before ProductAttributes
					$this->log->write($this->language->get('error_product_attributes'));
					$ok = false;
				}

				$exist_product_attributes = true;
				continue;
			}

			if ($name == 'ProductFilters') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before ProductFilters
					$this->log->write($this->language->get('error_product_filters'));
					$ok = false;
				}

				$exist_product_filters = true;
				continue;
			}

			if ($name == 'Options') {
				$exist_options = true;
				continue;
			}

			if ($name == 'OptionValues') {
				if (!$exist_options) {
					// Missing Options worksheet, or Options worksheet not listed before OptionValues
					$this->log->write($this->language->get('error_option_values'));
					$ok = false;
				}

				$exist_option_values = true;
				continue;
			}

			if ($name == 'AttributeGroups') {
				$exist_attribute_groups = true;
				continue;
			}

			if ($name == 'Attributes') {
				if (!$exist_attribute_groups) {
					// Missing AttributeGroups worksheet, or AttributeGroups worksheet not listed before Attributes
					$this->log->write($this->language->get('error_attributes'));
					$ok = false;
				}

				$exist_attributes = true;
				continue;
			}

			if ($name == 'FilterGroups') {
				$exist_filter_groups = true;
				continue;
			}

			if ($name == 'Filters') {
				if (!$exist_filter_groups) {
					// Missing FilterGroups worksheet, or FilterGroups worksheet not listed before Filters
					$this->log->write($this->language->get('error_filters'));
					$ok = false;
				}

				$exist_filters = true;
				continue;
			}

			if ($name == 'Fields') {
				$exist_fields = true;
				continue;
			}

			if ($name == 'Palettes') {
				$exist_palettes = true;
				continue;
			}
		}

		if ($exist_customers) {
			if (!$exist_addresses) {
				// Addresses worksheet also expected after Customers worksheet
				$this->log->write($this->language->get('error_addresses_2'));
				$ok = false;
			}
		}

		if ($exist_product_options) {
			if (!$exist_product_option_values) {
				// ProductOptionValues worksheet also expected after a ProductOptions worksheet
				$this->log->write($this->language->get('error_product_option_values_3'));
				$ok = false;
			}
		}

		if ($exist_attribute_groups) {
			if (!$exist_attributes) {
				// Attributes worksheet also expected after an AttributeGroups worksheet
				$this->log->write($this->language->get('error_attributes_2'));
				$ok = false;
			}
		}

		if ($exist_filter_groups) {
			if (!$exist_filters) {
				// Filters worksheet also expected after an FilterGroups worksheet
				$this->log->write($this->language->get('error_filters_2'));
				$ok = false;
			}
		}

		if ($exist_options) {
			if (!$exist_option_values) {
				// OptionValues worksheet also expected after an Options worksheet
				$this->log->write($this->language->get('error_option_values_2'));
				$ok = false;
			}
		}

		if (!$ok) {
			return false;
		}

		if (!$this->validateCustomerIdColumns($reader)) {
			$ok = false;
		}

		if (!$this->validateCustomerGroupColumns($reader)) {
			$ok = false;
		}

		if (!$this->validateAddressCountriesAndZones($reader)) {
			$ok = false;
		}

		if (!$this->validateProductIdColumns($reader)) {
			return false;
		}

		if (!$this->validateOptionColumns($reader)) {
			$ok = false;
		}

		if (!$this->validateAttributeColumns($reader)) {
			$ok = false;
		}

		if ($this->existFilter()) {
			if (!$this->validateFilterColumns($reader)) {
				$ok = false;
			}
		}

		if ($this->existField()) {
			if (!$this->validateFieldColumns($reader)) {
				$ok = false;
			}
		}

		if (!$this->validatePaletteColumns($reader)) {
			$ok = false;
		}

		return $ok;
	}

	protected function clearCache() {
		$this->cache->delete('*');
	}

	protected function removeEntities($string_in) {
		$string_out = null;

		$stripped_string = strip_tags(html_entity_decode($string_in, ENT_COMPAT, 'UTF-8'));

		for ($i = 0; $i < utf8_strlen($stripped_string); $i++) {
			$ord = ord($stripped_string[$i]);

			if (($ord > 0 && $ord < 32) || ($ord > 59 && $ord < 63) || ($ord > 126)) {
				$string_out .= '';
			} else {
				switch ($stripped_string[$i]) {
				case '&':
					$string_out .= '&amp;';
					break;
				case '"':
					$string_out .= '&quot;';
					break;
				default:
					$string_out .= $stripped_string[$i];
				}
			}
		}

		$clean_string_out = str_replace(array('/', '&amp;nbsp;', '&amp;amp;', '&amp;ndash;', '&amp;mdash;', '&amp;trade;', '&amp;reg;', '&amp;deg;', '&amp;rsquo;', '&amp;quot;', '&amp;#39;', '&amp;acute;'), ' ', $string_out);

		return $clean_string_out;
	}

	public function upload($filename, $incremental = false) {
		// Error handler
		global $registry;

		$registry = $this->registry;

		set_error_handler('error_handler_for_export_import', E_ALL);

		register_shutdown_function('fatal_error_shutdown_handler_for_export_import');

		// PHPExcel
		try {
			$this->session->data['export_import_nochange'] = 1;

			$cwd = getcwd();

			chdir(DIR_SYSTEM . 'vendor');

			require_once('phpexcel/PHPExcel.php');

			chdir($cwd);

			// Memory Optimization
			if ($this->config->get('export_import_settings_use_import_cache')) {
				$cacheMethod = PHPExcel_CachedObjectStorageFactory::CACHETOPHPTEMP;

				$cacheSettings = array('memoryCacheSize' => '16MB');

				PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			}

			// Parse uploaded spreadsheet file
			$inputFileType = PHPExcel_IOFactory::identify($filename);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);

			$reader = $objReader->load($filename);

			// Read the various worksheets and load them to the database
			if (!$this->validateUpload($reader)) {
				return false;
			}

			$this->clearCache();

			$this->session->data['export_import_nochange'] = 0;

			$available_customer_ids = array();
			$available_product_ids = array();
			$available_category_ids = array();

			$this->uploadCustomers($reader, $incremental, $available_customer_ids);
			$this->uploadAddresses($reader, $incremental, $available_customer_ids);
			$this->uploadCategories($reader, $incremental, $available_category_ids);
			$this->uploadCategoryFilters($reader, $incremental, $available_category_ids);
			$this->uploadProducts($reader, $incremental, $available_product_ids);
			$this->uploadAdditionalImages($reader, $incremental, $available_product_ids);
			$this->uploadSpecials($reader, $incremental, $available_product_ids);
			$this->uploadDiscounts($reader, $incremental, $available_product_ids);
			$this->uploadRewards($reader, $incremental, $available_product_ids);
			$this->uploadProductOptions($reader, $incremental, $available_product_ids);
			$this->uploadProductOptionValues($reader, $incremental, $available_product_ids);
			$this->uploadProductColors($reader, $incremental, $available_product_ids);
			$this->uploadProductFields($reader, $incremental, $available_product_ids);
			$this->uploadProductAttributes($reader, $incremental, $available_product_ids);
			$this->uploadProductFilters($reader, $incremental, $available_product_ids);
			$this->uploadOptions($reader, $incremental);
			$this->uploadOptionValues($reader, $incremental);
			$this->uploadAttributeGroups($reader, $incremental);
			$this->uploadAttributes($reader, $incremental);
			$this->uploadFilterGroups($reader, $incremental);
			$this->uploadFilters($reader, $incremental);
			$this->uploadFields($reader, $incremental);
			$this->uploadPalettes($reader, $incremental);

			return true;

		} catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();

			$this->session->data['export_import_error'] = array('errstr' => $errstr, 'errno' => $errno, 'errfile' => $errfile, 'errline' => $errline);

			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get_class($e) . ': ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}

			return false;
		}
	}

	protected function setColumnStyles($worksheet, $styles, $min_row, $max_row) {
		if ($max_row < $min_row) {
			return;
		}

		foreach ($styles as $col => $style) {
			$from = PHPExcel_Cell::stringFromColumnIndex($col) . $min_row;
			$to = PHPExcel_Cell::stringFromColumnIndex($col) . $max_row;

			$range = $from . ':' . $to;

			$worksheet->getStyle($range)->applyFromArray($style, false);
		}
	}

	protected function setCellRow($worksheet, $row, $data, $default_style = null, $styles = null) {
		if (!empty($default_style)) {
			$worksheet->getStyle($row . ':' . $row)->applyFromArray($default_style, false);
		}

		if (!empty($styles)) {
			foreach ($styles as $col => $style) {
				$worksheet->getStyleByColumnAndRow($col, $row)->applyFromArray($style, false);
			}
		}

		$worksheet->fromArray($data, null, 'A' . $row, true);
	}

	protected function setCell($worksheet, $row, $col, $val, $style = null) {
		$worksheet->setCellValueByColumnAndRow($col, $row, $val);

		if (!empty($style)) {
			$worksheet->getStyleByColumnAndRow($col, $row)->applyFromArray($style, false);
		}
	}

	// Customers
	protected function getCustomers($offset = null, $rows = null, $min_id = null, $max_id = null) {
		$language_id = $this->getDefaultLanguageId();

		$sql = "SELECT c.*, cgd.name AS customer_group FROM `" . DB_PREFIX . "customer` c";
		$sql .= " INNER JOIN `" . DB_PREFIX . "customer_group_description` cgd ON (cgd.customer_group_id = c.customer_group_id)";
		$sql .= " WHERE cgd.language_id = '" . (int)$language_id . "'";
		if (isset($min_id) && isset($max_id)) {
			$sql .= " AND c.customer_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
		}
		$sql .= " GROUP BY c.customer_id";
		$sql .= " ORDER BY c.customer_id";
		if (isset($offset) && isset($rows)) {
			$sql .= " ASC LIMIT '" . (int)$offset . "','" . (int)$rows . "'";
		} else {
			$sql .= " ASC";
		}

		$results = $this->db->query($sql);

		return $results->rows;
	}

	protected function populateCustomersWorksheet($worksheet, $box_format, $text_format, $date_format, $datetime_format, $offset = null, $rows = null, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('customer_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('customer_group')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('store_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('firstname')+4, 20)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('lastname')+4, 20)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('email')+4, 25)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('telephone')+4, 16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('fax')+4, 16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('gender'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_of_birth'), 12)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('password'), 24)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('salt'), 16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('cart'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('wishlist'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('newsletter')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('address_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('ip'), 12)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('status')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('approved')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('token'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_added'), 19)+1);

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'customer_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'customer_group';
		$data[$j++] = 'store_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'firstname';
		$styles[$j] = &$text_format;
		$data[$j++] = 'lastname';
		$styles[$j] = &$text_format;
		$data[$j++] = 'email';
		$styles[$j] = &$text_format;
		$data[$j++] = 'telephone';
		$styles[$j] = &$text_format;
		$data[$j++] = 'fax';
		$data[$j++] = 'gender';
		$styles[$j] = &$date_format;
		$data[$j++] = 'date_of_birth';
		$styles[$j] = &$text_format;
		$data[$j++] = 'password';
		$styles[$j] = &$text_format;
		$data[$j++] = 'salt';
		$styles[$j] = &$text_format;
		$data[$j++] = 'cart';
		$styles[$j] = &$text_format;
		$data[$j++] = 'wishlist';
		$data[$j++] = 'newsletter';
		$data[$j++] = 'address_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'ip';
		$data[$j++] = 'status';
		$data[$j++] = 'approved';
		$styles[$j] = &$text_format;
		$data[$j++] = 'token';
		$styles[$j] = &$datetime_format;
		$data[$j++] = 'date_added';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual customers data
		$i += 1;
		$j = 0;

		$customers = $this->getCustomers($offset, $rows, $min_id, $max_id);

		$length = count($customers);

		$min_id = ($length > 0) ? $customers[0]['customer_id'] : 0;
		$max_id = ($length > 0) ? $customers[$length-1]['customer_id'] : 0;

		foreach ($customers as $row) {
			$data = array();

			$worksheet->getRowDimension($i)->setRowHeight(26);

			$data[$j++] = $row['customer_id'];
			$data[$j++] = $row['customer_group'];
			$data[$j++] = $row['store_id'];
			$data[$j++] = $row['firstname'];
			$data[$j++] = $row['lastname'];
			$data[$j++] = $row['email'];
			$data[$j++] = $row['telephone'];
			$data[$j++] = $row['fax'];
			$data[$j++] = $row['gender'];
			$data[$j++] = ($row['date_of_birth']) ? $row['date_of_birth'] : '0000-00-00';
			$data[$j++] = $row['password'];
			$data[$j++] = $row['salt'];
			$data[$j++] = $row['cart'];
			$data[$j++] = $row['wishlist'];
			$data[$j++] = ($row['newsletter'] == 0) ? 'false' : 'true';
			$data[$j++] = $row['address_id'];
			$data[$j++] = $row['ip'];
			$data[$j++] = ($row['status'] == 0) ? 'false' : 'true';
			$data[$j++] = ($row['approved'] == 0) ? 'false' : 'true';
			$data[$j++] = $row['token'];
			$data[$j++] = $row['date_added'];

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getAddresses($min_id, $max_id) {
		$language_id = $this->getDefaultLanguageId();

		// DB query for getting the addresses
		$sql = "SELECT a.*, cd.name AS country, z.name AS zone, (cu.address_id = a.address_id) AS `default` FROM `" . DB_PREFIX . "address` a";
		$sql .= " INNER JOIN `" . DB_PREFIX . "country` c ON (c.country_id = a.country_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "country_description` cd ON (c.country_id = cd.country_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "zone` z ON z.country_id = a.country_id AND z.zone_id = a.zone_id";
		$sql .= " INNER JOIN `" . DB_PREFIX . "customer` cu ON (cu.customer_id = a.customer_id)";
		$sql .= " WHERE cd.language_id = '" . (int)$language_id . "'";
		if (isset($min_id) && isset($max_id)) {
			$sql .= " AND a.customer_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
		}
		$sql .= " ORDER BY a.customer_id ASC, a.address_id ASC;";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	protected function populateAddressesWorksheet(&$worksheet, &$box_format, &$text_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('customer_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('firstname'),20)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('lastname'),20)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('company'),30)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('company_id'),10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('tax_id'),15)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('address_1'),30)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('address_2'),30)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('city'),30)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('postcode'),10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('zone'),20)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('country'),20)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('default'),5)+1);

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'customer_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'firstname';
		$styles[$j] = &$text_format;
		$data[$j++] = 'lastname';
		$styles[$j] = &$text_format;
		$data[$j++] = 'company';
		$styles[$j] = &$text_format;
		$data[$j++] = 'company_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'tax_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'address_1';
		$styles[$j] = &$text_format;
		$data[$j++] = 'address_2';
		$styles[$j] = &$text_format;
		$data[$j++] = 'city';
		$styles[$j] = &$text_format;
		$data[$j++] = 'postcode';
		$styles[$j] = &$text_format;
		$data[$j++] = 'zone';
		$styles[$j] = &$text_format;
		$data[$j++] = 'country';
		$data[$j++] = 'default';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual addresses data
		$i += 1;
		$j = 0;

		$addresses = $this->getAddresses($min_id, $max_id);

		foreach ($addresses as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['customer_id'];
			$data[$j++] = $row['firstname'];
			$data[$j++] = $row['lastname'];
			$data[$j++] = $row['company'];
			$data[$j++] = $row['company_id'];
			$data[$j++] = $row['tax_id'];
			$data[$j++] = $row['address_1'];
			$data[$j++] = $row['address_2'];
			$data[$j++] = $row['city'];
			$data[$j++] = $row['postcode'];
			$data[$j++] = html_entity_decode($row['zone'], ENT_QUOTES, 'UTF-8');
			$data[$j++] = $row['country'];
			$data[$j++] = ($row['default'] == 0) ? 'no' : 'yes';

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	// Categories
	protected function getStoreIdsForCategories() {
		$store_ids = array();

		$result = $this->db->query("SELECT category_id, store_id FROM `" . DB_PREFIX . "category_to_store`;");

		foreach ($result->rows as $row) {
			$category_id = $row['category_id'];
			$store_id = $row['store_id'];

			if (!isset($store_ids[$category_id])) {
				$store_ids[$category_id] = array();
			}

			if (!in_array($store_id, $store_ids[$category_id])) {
				$store_ids[$category_id][] = $store_id;
			}
		}

		return $store_ids;
	}

	protected function getLayoutsForCategories() {
		$layouts = array();

		$sql = "SELECT cl.*, l.`name` FROM `" . DB_PREFIX . "category_to_layout` cl";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "layout` l ON (cl.layout_id = l.layout_id)";
		$sql .= " ORDER BY cl.category_id, cl.store_id ASC";

		$result = $this->db->query($sql);

		foreach ($result->rows as $row) {
			$category_id = $row['category_id'];
			$store_id = $row['store_id'];
			$name = $row['name'];

			if (!isset($layouts[$category_id])) {
				$layouts[$category_id] = array();
			}

			$layouts[$category_id][$store_id] = $name;
		}

		return $layouts;
	}

	protected function getCategoryDescriptions($languages, $offset, $rows, $min_id, $max_id) {
		// Category description table for each language
		$category_descriptions = array();

		foreach ($languages as $language) {
			$language_id = $language['language_id'];
			$language_code = strtolower($language['code']);

			$sql = "SELECT name, description, meta_description, meta_keyword FROM `" . DB_PREFIX . "category_description`";
			$sql .= " WHERE language_id = '" . (int)$language_id . "'";
			if (isset($min_id) && isset($max_id)) {
				$sql .= " AND category_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			}
			$sql .= " ORDER BY category_id";
			if (isset($offset) && isset($rows)) {
				$sql .= " ASC LIMIT '" . (int)$offset . "','" . (int)$rows . "'";
			} else {
				$sql .= " ASC";
			}

			$category_query = $this->db->query($sql);

			$category_descriptions[$language_code] = $category_query->rows;
		}

		return $category_descriptions;
	}

	public function getCategories($languages, $offset = null, $rows = null, $min_id = null, $max_id = null) {
		$sql = "SELECT c.*, ua.keyword AS seo_keyword FROM `" . DB_PREFIX . "category` c";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "url_alias` ua ON (ua.query = CONCAT('category_id=',c.category_id))";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "category_to_store` cs ON (cs.category_id = c.category_id)";
		if (isset($min_id) && isset($max_id)) {
			$sql .= " WHERE c.category_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
		}
		$sql .= " ORDER BY c.category_id";
		if (isset($offset) && isset($rows)) {
			$sql .= " ASC LIMIT '" . (int)$offset . "','" . (int)$rows . "'";
		} else {
			$sql .= " ASC";
		}

		$results = $this->db->query($sql);

		$category_descriptions = $this->getCategoryDescriptions($languages, $offset, $rows, $min_id, $max_id);

		foreach ($languages as $language) {
			$language_code = strtolower($language['code']);

			foreach ($results->rows as $key => $row) {
				if (isset($category_descriptions[$language_code][$key]['name'])) {
					$results->rows[$key]['name'][$language_code] = $category_descriptions[$language_code][$key]['name'];
				} else {
					$results->rows[$key]['name'][$language_code] = '';
				}

				if (isset($category_descriptions[$language_code][$key]['description'])) {
					$results->rows[$key]['description'][$language_code] = $category_descriptions[$language_code][$key]['description'];
				} else {
					$results->rows[$key]['description'][$language_code] = '';
				}

				if (isset($category_descriptions[$language_code][$key]['meta_description'])) {
					$results->rows[$key]['meta_description'][$language_code] = $category_descriptions[$language_code][$key]['meta_description'];
				} else {
					$results->rows[$key]['meta_description'][$language_code] = '';
				}

				if (isset($category_descriptions[$language_code][$key]['meta_keyword'])) {
					$results->rows[$key]['meta_keyword'][$language_code] = $category_descriptions[$language_code][$key]['meta_keyword'];
				} else {
					$results->rows[$key]['meta_keyword'][$language_code] = '';
				}
			}
		}

		return $results->rows;
	}

	protected function populateCategoriesWorksheet($worksheet, $languages, $box_format, $text_format, $datetime_format, $offset = null, $rows = null, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('category_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('parent_id')+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4, 30)+1);
		}
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('description')+4, 48)+1);
		}
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('meta_description')+4, 32)+1);
		}
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('meta_keywords')+4, 24)+1);
		}
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('sort_order')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('image_name'), 30)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_added'), 19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_modified'), 19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('seo_keyword'), 16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('store_ids'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('layout'), 16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('status'), 5)+1);

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'category_id';
		$data[$j++] = 'parent_id';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'name(' . $language['code'] . ')';
		}
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'description(' . $language['code'] . ')';
		}
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'meta_description(' . $language['code'] .')';
		}
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'meta_keywords(' . $language['code'] . ')';
		}
		$data[$j++] = 'sort_order';
		$styles[$j] = &$text_format;
		$data[$j++] = 'image_name';
		$styles[$j] = &$datetime_format;
		$data[$j++] = 'date_added';
		$styles[$j] = &$datetime_format;
		$data[$j++] = 'date_modified';
		$styles[$j] = &$text_format;
		$data[$j++] = 'seo_keyword';
		$data[$j++] = 'store_ids';
		$styles[$j] = &$text_format;
		$data[$j++] = 'layout';
		$data[$j++] = 'status';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual categories data
		$i += 1;
		$j = 0;

		$store_ids = $this->getStoreIdsForCategories();
		$layouts = $this->getLayoutsForCategories();

		$keep_tags = $this->config->get('export_import_settings_use_export_tags');

		$categories = $this->getCategories($languages, $offset, $rows, $min_id, $max_id);

		$length = count($categories);

		$min_id = ($length > 0) ? $categories[0]['category_id'] : 0;
		$max_id = ($length > 0) ? $categories[$length-1]['category_id'] : 0;

		foreach ($categories as $row) {
			$data = array();

			$worksheet->getRowDimension($i)->setRowHeight(26);

			$category_id = $row['category_id'];

			$data[$j++] = $row['category_id'];
			$data[$j++] = $row['parent_id'];
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['name'][$language['code']], ENT_QUOTES, 'UTF-8');
			}
			foreach ($languages as $language) {
				$data[$j++] = (isset($keep_tags)) ? html_entity_decode($row['description'][$language['code']], ENT_QUOTES, 'UTF-8') : $this->removeEntities($row['description'][$language['code']]);
			}
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['meta_description'][$language['code']], ENT_QUOTES, 'UTF-8');
			}
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['meta_keyword'][$language['code']], ENT_QUOTES, 'UTF-8');
			}
			$data[$j++] = $row['sort_order'];
			$data[$j++] = $row['image'];
			$data[$j++] = $row['date_added'];
			$data[$j++] = $row['date_modified'];
			$data[$j++] = ($row['seo_keyword']) ? $row['seo_keyword'] : '';
			$store_id_list = '';
			if (isset($store_ids[$category_id])) {
				foreach ($store_ids[$category_id] as $store_id) {
					$store_id_list .= ($store_id_list == '') ? $store_id : ',' . $store_id;
				}
			}
			$data[$j++] = $store_id_list;
			$layout_list = '';
			if (isset($layouts[$category_id])) {
				foreach ($layouts[$category_id] as $store_id => $name) {
					$layout_list .= ($layout_list == '') ? $store_id . ':' . $name : ',' . $store_id . ':' . $name;
				}
			}
			$data[$j++] = $layout_list;
			$data[$j++] = ($row['status'] == 0) ? 'false' : 'true';

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getFilterGroupNames($language_id) {
		$filter_group_names = array();

		$sql = "SELECT filter_group_id, `name` FROM `" . DB_PREFIX . "filter_group_description` WHERE language_id = '" . (int)$language_id . "'";
		$sql .= " ORDER BY filter_group_id ASC";

		$filter_group_query = $this->db->query($sql);

		foreach ($filter_group_query->rows as $row) {
			$filter_group_id = $row['filter_group_id'];
			$name = $row['name'];

			$filter_group_names[$filter_group_id] = $name;
		}

		return $filter_group_names;
	}

	protected function getFilterNames($language_id) {
		$filter_names = array();

		$sql = "SELECT filter_id, `name` FROM `" . DB_PREFIX . "filter_description` WHERE language_id = '" . (int)$language_id . "'";
		$sql .= " ORDER BY filter_id ASC";

		$filter_query = $this->db->query($sql);

		foreach ($filter_query->rows as $row) {
			$filter_id = $row['filter_id'];
			$filter_name = $row['name'];

			$filter_names[$filter_id] = $filter_name;
		}

		return $filter_names;
	}

	protected function getCategoryFilters($min_id, $max_id) {
		$category_filters = array();

		$sql = "SELECT cf.category_id, fg.filter_group_id, cf.filter_id FROM `" . DB_PREFIX . "category_filter` cf";
		$sql .= " INNER JOIN `" . DB_PREFIX . "filter` f ON (f.filter_id = cf.filter_id)";
		$sql .= " INNER JOIN `" . DB_PREFIX . "filter_group` fg ON (fg.filter_group_id = f.filter_group_id)";
		if (isset($min_id) && isset($max_id)) {
			$sql .= " WHERE cf.category_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
		}
		$sql .= " ORDER BY cf.category_id ASC, fg.filter_group_id ASC, cf.filter_id ASC";

		$query = $this->db->query($sql);

		foreach ($query->rows as $row) {
			$category_filter = array();

			$category_filter['category_id'] = $row['category_id'];
			$category_filter['filter_group_id'] = $row['filter_group_id'];
			$category_filter['filter_id'] = $row['filter_id'];

			$category_filters[] = $category_filter;
		}

		return $category_filters;
	}

	protected function populateCategoryFiltersWorksheet($worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('category_id')+1);
		if ($this->config->get('export_import_settings_use_filter_group_id')) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('filter_group_id')+1);
		} else {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('filter_group'), 30)+1);
		}
		if ($this->config->get('export_import_settings_use_filter_id')) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('filter_id')+1);
		} else {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('filter'), 30)+1);
		}
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('text')+4, 30)+1);
		}

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'category_id';
		if ($this->config->get('export_import_settings_use_filter_group_id')) {
			$data[$j++] = 'filter_group_id';
		} else {
			$styles[$j] = $text_format;
			$data[$j++] = 'filter_group';
		}
		if ($this->config->get('export_import_settings_use_filter_id')) {
			$data[$j++] = 'filter_id';
		} else {
			$styles[$j] = $text_format;
			$data[$j++] = 'filter';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual category filters data
		if (!$this->config->get('export_import_settings_use_filter_group_id')) {
			$filter_group_names = $this->getFilterGroupNames($default_language_id);
		}

		if (!$this->config->get('export_import_settings_use_filter_id')) {
			$filter_names = $this->getFilterNames($default_language_id);
		}

		$i += 1;
		$j = 0;

		$category_filters = $this->getCategoryFilters($min_id, $max_id);

		foreach ($category_filters as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['category_id'];
			if ($this->config->get('export_import_settings_use_filter_group_id')) {
				$data[$j++] = $row['filter_group_id'];
			} else {
				$data[$j++] = html_entity_decode($filter_group_names[$row['filter_group_id']], ENT_QUOTES, 'UTF-8');
			}
			if ($this->config->get('export_import_settings_use_filter_id')) {
				$data[$j++] = $row['filter_id'];
			} else {
				$data[$j++] = html_entity_decode($filter_names[$row['filter_id']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	// Products
	protected function getStoreIdsForProducts() {
		$store_ids = array();

		$result = $this->db->query("SELECT product_id, store_id FROM `" . DB_PREFIX . "product_to_store`");

		foreach ($result->rows as $row) {
			$product_id = $row['product_id'];
			$store_id = $row['store_id'];

			if (!isset($store_ids[$product_id])) {
				$store_ids[$product_id] = array();
			}

			if (!in_array($store_id, $store_ids[$product_id])) {
				$store_ids[$product_id][] = $store_id;
			}
		}

		return $store_ids;
	}

	protected function getLayoutsForProducts() {
		$layouts = array();

		$sql = "SELECT pl.*, l.`name` FROM `" . DB_PREFIX . "product_to_layout` pl";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "layout` l ON (pl.layout_id = l.layout_id)";
		$sql .= " ORDER BY pl.product_id, pl.store_id";

		$result = $this->db->query($sql);

		foreach ($result->rows as $row) {
			$product_id = $row['product_id'];
			$store_id = $row['store_id'];
			$name = $row['name'];

			if (!isset($layouts[$product_id])) {
				$layouts[$product_id] = array();
			}

			$layouts[$product_id][$store_id] = $name;
		}

		return $layouts;
	}

	protected function getPostedCategories() {
		$posted_categories = '';

		if (isset($this->request->post['categories'])) {
			if (count($this->request->post['categories']) > 0) {
				foreach ($this->request->post['categories'] as $category_id) {
					$posted_categories .= ($posted_categories == '') ? '(' : ',';
					$posted_categories .= $category_id;
				}

				$posted_categories .= ')';
			}
		}

		return $posted_categories;
	}

	protected function getVideoCodeForProducts($product_id) {
		$query = $this->db->query("SELECT video_code AS video_code FROM `" . DB_PREFIX . "product_youtube` WHERE product_id = '" . (int)$product_id . "'");

		if (isset($query->row['video_code'])) {
			return $query->row['video_code'];
		} else {
			return 0;
		}
	}

	protected function getProductDescriptions($languages, $offset = null, $rows = null, $min_id = null, $max_id = null) {
		// Product description table for each language
		$product_descriptions = array();

		foreach ($languages as $language) {
			$language_id = $language['language_id'];
			$language_code = strtolower($language['code']);

			$sql = "SELECT p.product_id, pd.* FROM `" . DB_PREFIX . "product_description` pd";
			$sql .= " INNER JOIN `" . DB_PREFIX . "product` p ON (p.product_id = pd.product_id)";
			if ($this->posted_categories) {
				$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = p.product_id)";
			}
			$sql .= " WHERE pd.language_id = '" . (int)$language_id . "'";
			if (isset($min_id) && isset($max_id)) {
				$sql .= " AND p.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";

				if ($this->posted_categories) {
					$sql .= " AND pc.category_id IN " . $this->posted_categories;
				}
			} else if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
			$sql .= " GROUP BY p.product_id ";
			$sql .= " ORDER BY p.product_id";
			if (isset($offset) && isset($rows)) {
				$sql .= " ASC LIMIT '" . (int)$offset . "','" . (int)$rows . "'";
			} else {
				$sql .= " ASC";
			}

			$product_query = $this->db->query($sql);

			$product_descriptions[$language_code] = $product_query->rows;
		}

		if (isset($product_descriptions)) {
			return $product_descriptions;
		} else {
			return 0;
		}
	}

	public function getProducts(&$languages, $default_language_id, $offset = null, $rows = null, $min_id = null, $max_id = null) {
		$sql = "SELECT p.product_id,";
		$sql .= " GROUP_CONCAT(DISTINCT CAST(pc.category_id AS CHAR(11)) SEPARATOR \",\") AS categories,";
		$sql .= " p.sku,";
		$sql .= " p.upc,";
		$sql .= " p.ean,";
		$sql .= " p.jan,";
		$sql .= " p.isbn,";
		$sql .= " p.mpn,";
		$sql .= " p.location,";
		$sql .= " p.quantity,";
		$sql .= " p.model,";
		$sql .= " md.name AS manufacturer_name,";
		$sql .= " p.image AS image_name,";
		$sql .= " p.label AS label_name,";
		$sql .= " p.shipping,";
		$sql .= " p.price,";
		$sql .= " p.cost,";
		$sql .= " p.quote,";
		$sql .= " p.age_minimum,";
		$sql .= " p.points,";
		$sql .= " p.date_added,";
		$sql .= " p.date_modified,";
		$sql .= " p.date_available,";
		$sql .= " p.palette_id,";
		$sql .= " p.weight,";
		$sql .= " wc.unit AS weight_unit,";
		$sql .= " p.length,";
		$sql .= " p.width,";
		$sql .= " p.height,";
		$sql .= " mc.unit AS length_unit,";
		$sql .= " p.status,";
		$sql .= " p.tax_class_id,";
		$sql .= " ptlr.tax_local_rate_id,";
		$sql .= " ua.keyword,";
		$sql .= " p.stock_status_id,";
		$sql .= " p.sort_order,";
		$sql .= " p.subtract,";
		$sql .= " p.minimum,";
		$sql .= " p.viewed,";
		$sql .= " GROUP_CONCAT(DISTINCT CAST(pr.related_id AS CHAR(11)) SEPARATOR \",\") AS related,";
		$sql .= " GROUP_CONCAT(DISTINCT CAST(pl.location_id AS CHAR(11)) SEPARATOR \",\") AS location";
		$sql .= " FROM `" . DB_PREFIX . "product` p";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = p.product_id)";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc2 ON (pc2.product_id = p.product_id)";
		}
		$sql .= " LEFT JOIN `" . DB_PREFIX . "url_alias` ua ON (ua.query = CONCAT('product_id=',p.product_id))";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "manufacturer_description` md ON (md.manufacturer_id = p.manufacturer_id) AND md.language_id = '" . (int)$default_language_id . "'";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "weight_class_description` wc ON (wc.weight_class_id = p.weight_class_id) AND wc.language_id = '" . (int)$default_language_id . "'";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "length_class_description` mc ON (mc.length_class_id = p.length_class_id) AND mc.language_id = '" . (int)$default_language_id . "'";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_tax_local_rate` ptlr ON (ptlr.product_id = p.product_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_related` pr ON (pr.product_id = p.product_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_location` pl ON (pl.product_id = p.product_id)";
		if (isset($min_id) && isset($max_id)) {
			$sql .= " WHERE p.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc2.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " WHERE pc2.category_id IN " . $this->posted_categories;
		}
		$sql .= " GROUP BY p.product_id";
		$sql .= " ORDER BY p.product_id";
		if (isset($offset) && isset($rows)) {
			$sql .= " ASC LIMIT '" . (int)$offset . "','" . (int)$rows . "'";
		} else {
			$sql .= " ASC";
		}

		$results = $this->db->query($sql);

		$product_descriptions = $this->getProductDescriptions($languages, $offset, $rows, $min_id, $max_id);

		foreach ($languages as $language) {
			$language_code = strtolower($language['code']);

			foreach ($results->rows as $key => $row) {
				if (isset($product_descriptions[$language_code][$key]['name'])) {
					$results->rows[$key]['name'][$language_code] = $product_descriptions[$language_code][$key]['name'];
				} else {
					$results->rows[$key]['name'][$language_code] = '';
				}

				if (isset($product_descriptions[$language_code][$key]['description'])) {
					$results->rows[$key]['description'][$language_code] = $product_descriptions[$language_code][$key]['description'];
				} else {
					$results->rows[$key]['description'][$language_code] = '';
				}

				if (isset($product_descriptions[$language_code][$key]['meta_description'])) {
					$results->rows[$key]['meta_description'][$language_code] = $product_descriptions[$language_code][$key]['meta_description'];
				} else {
					$results->rows[$key]['meta_description'][$language_code] = '';
				}

				if (isset($product_descriptions[$language_code][$key]['meta_keyword'])) {
					$results->rows[$key]['meta_keyword'][$language_code] = $product_descriptions[$language_code][$key]['meta_keyword'];
				} else {
					$results->rows[$key]['meta_keyword'][$language_code] = '';
				}

				if (isset($product_descriptions[$language_code][$key]['tag'])) {
					$results->rows[$key]['tag'][$language_code] = $product_descriptions[$language_code][$key]['tag'];
				} else {
					$results->rows[$key]['tag'][$language_code] = '';
				}
			}
		}

		return $results->rows;
	}

	protected function populateProductsWorksheet(&$worksheet, &$languages, $default_language_id, &$box_format, &$price_format, &$weight_format, &$text_format, &$date_format, &$datetime_format, $offset = null, $rows = null, &$min_id = null, &$max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('product_id'), 4)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4, 30)+1);
		}
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('categories'), 12)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sku'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('upc'), 12)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('ean'), 14)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('jan'), 13)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('isbn'), 13)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('mpn'), 15)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('location'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('quantity'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('model'), 16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('manufacturer_name'), 16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('image_name')+4, 36)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('label_name')+4, 36)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('video_code')+4, 19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('shipping'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('cost'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('quote'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('age_minimum'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('points'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_added'), 19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_modified'), 19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_available'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('palette_id'), 3)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('weight'), 6)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('weight_unit'), 3)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('length'), 8)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('width'), 8)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('height'), 8)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('length_unit'), 3)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('status'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('tax_class_id'), 3)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('tax_local_rate_id'), 3)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('seo_keyword'), 16)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('description')+4, 48)+1);
		}
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('meta_description')+4, 32)+1);
		}
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('meta_keywords')+4, 24)+1);
		}
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('stock_status_id'), 3)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('store_ids'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('layout'), 16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('related_ids'), 16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('location_ids'), 16)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('tags')+4, 24)+1);
		}
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('subtract'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('minimum'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('viewed'), 5)+1);

		// The product headings row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'name(' . $language['code'] . ')';
		}
		$styles[$j] = &$text_format;
		$data[$j++] = 'categories';
		$styles[$j] = &$text_format;
		$data[$j++] = 'sku';
		$styles[$j] = &$text_format;
		$data[$j++] = 'upc';
		$styles[$j] = &$text_format;
		$data[$j++] = 'ean';
		$styles[$j] = &$text_format;
		$data[$j++] = 'jan';
		$styles[$j] = &$text_format;
		$data[$j++] = 'isbn';
		$styles[$j] = &$text_format;
		$data[$j++] = 'mpn';
		$styles[$j] = &$text_format;
		$data[$j++] = 'location';
		$data[$j++] = 'quantity';
		$styles[$j] = &$text_format;
		$data[$j++] = 'model';
		$styles[$j] = &$text_format;
		$data[$j++] = 'manufacturer_name';
		$styles[$j] = &$text_format;
		$data[$j++] = 'image_name';
		$styles[$j] = &$text_format;
		$data[$j++] = 'label_name';
		$styles[$j] = &$text_format;
		$data[$j++] = 'video_code';
		$data[$j++] = 'shipping';
		$styles[$j] = &$price_format;
		$data[$j++] = 'price';
		$styles[$j] = &$price_format;
		$data[$j++] = 'cost';
		$data[$j++] = 'quote';
		$data[$j++] = 'age_minimum';
		$data[$j++] = 'points';
		$styles[$j] = &$datetime_format;
		$data[$j++] = 'date_added';
		$styles[$j] = &$datetime_format;
		$data[$j++] = 'date_modified';
		$styles[$j] = &$date_format;
		$data[$j++] = 'date_available';
		$data[$j++] = 'palette_id';
		$styles[$j] = &$weight_format;
		$data[$j++] = 'weight';
		$styles[$j] = &$text_format;
		$data[$j++] = 'weight_unit';
		$data[$j++] = 'length';
		$data[$j++] = 'width';
		$data[$j++] = 'height';
		$styles[$j] = &$text_format;
		$data[$j++] = 'length_unit';
		$data[$j++] = 'status';
		$data[$j++] = 'tax_class_id';
		$data[$j++] = 'tax_local_rate_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'seo_keyword';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'description(' . $language['code'] . ')';
		}
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'meta_description(' . $language['code'] . ')';
		}
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'meta_keywords(' . $language['code'] . ')';
		}
		$data[$j++] = 'stock_status_id';
		$data[$j++] = 'store_ids';
		$styles[$j] = &$text_format;
		$data[$j++] = 'layout';
		$data[$j++] = 'related_ids';
		$data[$j++] = 'location_ids';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'tags(' . $language['code'] . ')';
		}
		$data[$j++] = 'sort_order';
		$data[$j++] = 'subtract';
		$data[$j++] = 'minimum';
		$data[$j++] = 'viewed';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual products data
		$i += 1;
		$j = 0;

		$store_ids = $this->getStoreIdsForProducts();
		$layouts = $this->getLayoutsForProducts();

		$keep_tags = $this->config->get('export_import_settings_use_export_tags');

		$products = $this->getProducts($languages, $default_language_id, $offset, $rows, $min_id, $max_id);

		$length = count($products);

		$min_id = ($length > 0) ? $products[0]['product_id'] : 0;
		$max_id = ($length > 0) ? $products[$length-1]['product_id'] : 0;

		foreach ($products as $row) {
			$data = array();

			$worksheet->getRowDimension($i)->setRowHeight(26);

			$product_id = $row['product_id'];

			$video_code = $this->getVideoCodeForProducts($product_id);

			$data[$j++] = $product_id;
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['name'][$language['code']], ENT_QUOTES, 'UTF-8');
			}
			$data[$j++] = $row['categories'];
			$data[$j++] = $row['sku'];
			$data[$j++] = $row['upc'];
			$data[$j++] = $row['ean'];
			$data[$j++] = $row['jan'];
			$data[$j++] = $row['isbn'];
			$data[$j++] = $row['mpn'];
			$data[$j++] = $row['location'];
			$data[$j++] = $row['quantity'];
			$data[$j++] = $row['model'];
			$data[$j++] = ($row['manufacturer_name']) ? $row['manufacturer_name'] : '';
			$data[$j++] = $row['image_name'];
			$data[$j++] = $row['label_name'];
			$data[$j++] = ($video_code) ? $video_code : '';
			$data[$j++] = ($row['shipping'] == 0) ? 'no' : 'yes';
			$data[$j++] = $row['price'];
			$data[$j++] = $row['cost'];
			$data[$j++] = ($row['quote'] == 0) ? 'false' : 'true';
			$data[$j++] = $row['age_minimum'];
			$data[$j++] = $row['points'];
			$data[$j++] = $row['date_added'];
			$data[$j++] = $row['date_modified'];
			$data[$j++] = $row['date_available'];
			$data[$j++] = $row['palette_id'];
			$data[$j++] = $row['weight'];
			$data[$j++] = $row['weight_unit'];
			$data[$j++] = $row['length'];
			$data[$j++] = $row['width'];
			$data[$j++] = $row['height'];
			$data[$j++] = $row['length_unit'];
			$data[$j++] = ($row['status'] == 0) ? 'false' : 'true';
			$data[$j++] = $row['tax_class_id'];
			$data[$j++] = $row['tax_local_rate_id'];
			$data[$j++] = ($row['keyword']) ? $row['keyword'] : '';
			foreach ($languages as $language) {
				$data[$j++] = (isset($keep_tags)) ? html_entity_decode($row['description'][$language['code']], ENT_QUOTES, 'UTF-8') : $this->removeEntities($row['description'][$language['code']]);
			}
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['meta_description'][$language['code']], ENT_QUOTES, 'UTF-8');
			}
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['meta_keyword'][$language['code']], ENT_QUOTES, 'UTF-8');
			}
			$data[$j++] = $row['stock_status_id'];
			$store_id_list = '';
			if (isset($store_ids[$product_id])) {
				foreach ($store_ids[$product_id] as $store_id) {
					$store_id_list .= ($store_id_list == '') ? $store_id : ',' . $store_id;
				}
			}
			$data[$j++] = $store_id_list;
			$layout_list = '';
			if (isset($layouts[$product_id])) {
				foreach ($layouts[$product_id] as $store_id => $name) {
					$layout_list .= ($layout_list == '') ? $store_id . ':' . $name : ',' . $store_id . ':' . $name;
				}
			}
			$data[$j++] = $layout_list;
			$data[$j++] = $row['related'];
			$data[$j++] = $row['location'];
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['tag'][$language['code']], ENT_QUOTES, 'UTF-8');
			}
			$data[$j++] = $row['sort_order'];
			$data[$j++] = ($row['subtract'] == 0) ? 'false' : 'true';
			$data[$j++] = $row['minimum'];
			$data[$j++] = $row['viewed'];

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getAdditionalImages($min_id = null, $max_id = null) {
		$sql = "SELECT p.product_id, pia.image, pia.palette_color_id, pia.sort_order FROM `" . DB_PREFIX . "product_image` pia";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product` p ON (p.product_id = pia.product_id)";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = pia.product_id)";
		}
		if (isset($min_id) && isset($max_id)) {
			$sql .= " WHERE p.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " WHERE pc.category_id IN " . $this->posted_categories;
		}
		$sql .= " ORDER BY p.product_id, pia.image, pia.sort_order";

		$result = $this->db->query($sql);

		return $result->rows;
	}

	protected function populateAdditionalImagesWorksheet($worksheet, $box_format, $text_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('product_id'), 4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('image')+4, 36)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('palette_color_id'), 4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'), 5)+1);

		// The additional images headings row and colum styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'image';
		$data[$j++] = 'palette_color_id';
		$data[$j++] = 'sort_order';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual additional images data
		$i += 1;
		$j = 0;

		$additional_images = $this->getAdditionalImages($min_id, $max_id);

		foreach ($additional_images as $row) {
			$data = array();

			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data[$j++] = $row['product_id'];
			$data[$j++] = $row['image'];
			$data[$j++] = $row['palette_color_id'];
			$data[$j++] = $row['sort_order'];

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getSpecials($language_id, $min_id = null, $max_id = null) {
		// Get the product specials
		$sql = "SELECT ps.*, cgd.name AS `name` FROM `" . DB_PREFIX . "product_special` ps";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "customer_group_description` cgd ON (cgd.customer_group_id = ps.customer_group_id)";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = ps.product_id)";
		}
		$sql .= " WHERE cgd.language_id = '" . (int)$language_id . "'";
		if (isset($min_id) && isset($max_id)) {
			$sql .= " AND ps.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " AND pc.category_id IN " . $this->posted_categories;
		}
		$sql .= " ORDER BY ps.product_id, cgd.`name`, ps.priority";

		$result = $this->db->query($sql);

		return $result->rows;
	}

	protected function populateSpecialsWorksheet($worksheet, $language_id, $box_format, $price_format, $text_format, $date_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('customer_group')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('priority')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_start'), 19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_end'), 19)+1);

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'customer_group';
		$data[$j++] = 'priority';
		$styles[$j] = &$price_format;
		$data[$j++] = 'price';
		$styles[$j] = &$date_format;
		$data[$j++] = 'date_start';
		$styles[$j] = &$date_format;
		$data[$j++] = 'date_end';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual product specials data
		$i += 1;
		$j = 0;

		$specials = $this->getSpecials($language_id, $min_id, $max_id);

		foreach ($specials as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['product_id'];
			$data[$j++] = $row['name'];
			$data[$j++] = $row['priority'];
			$data[$j++] = $row['price'];
			$data[$j++] = $row['date_start'];
			$data[$j++] = $row['date_end'];

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getDiscounts($language_id, $min_id = null, $max_id = null) {
		// Get the product discounts
		$sql = "SELECT pd.*, cgd.name AS `name` FROM `" . DB_PREFIX . "product_discount` pd";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "customer_group_description` cgd ON (cgd.customer_group_id = pd.customer_group_id)";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = pd.product_id)";
		}
		$sql .= " WHERE cgd.language_id = '" . (int)$language_id . "'";
		if (isset($min_id) && isset($max_id)) {
			$sql .= " AND pd.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " AND pc.category_id IN " . $this->posted_categories;
		}
		$sql .= " ORDER BY pd.product_id, cgd.`name`, pd.quantity";

		$result = $this->db->query($sql);

		return $result->rows;
	}

	protected function populateDiscountsWorksheet($worksheet, $language_id, $box_format, $price_format, $text_format, $date_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('customer_group')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('quantity')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('priority')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_start'), 19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_end'), 19)+1);

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'customer_group';
		$data[$j++] = 'quantity';
		$data[$j++] = 'priority';
		$styles[$j] = &$price_format;
		$data[$j++] = 'price';
		$styles[$j] = &$date_format;
		$data[$j++] = 'date_start';
		$styles[$j] = &$date_format;
		$data[$j++] = 'date_end';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual product discounts data
		$i += 1;
		$j = 0;

		$discounts = $this->getDiscounts($language_id, $min_id, $max_id);

		foreach ($discounts as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['product_id'];
			$data[$j++] = $row['name'];
			$data[$j++] = $row['quantity'];
			$data[$j++] = $row['priority'];
			$data[$j++] = $row['price'];
			$data[$j++] = $row['date_start'];
			$data[$j++] = $row['date_end'];

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getRewards($language_id, $min_id = null, $max_id = null) {
		// Get the product rewards
		$sql = "SELECT pr.*, cgd.`name` FROM `" . DB_PREFIX . "product_reward` pr";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "customer_group_description` cgd ON (cgd.customer_group_id = pr.customer_group_id)";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = pr.product_id)";
		}
		$sql .= " WHERE cgd.language_id = '" . $language_id . "'";
		if (isset($min_id) && isset($max_id)) {
			$sql .= " AND pr.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " AND pc.category_id IN " . $this->posted_categories;
		}
		$sql .= " ORDER BY pr.product_id";

		$result = $this->db->query($sql);

		return $result->rows;
	}

	protected function populateRewardsWorksheet($worksheet, $language_id, $box_format, $text_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('customer_group')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('points')+1);

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'customer_group';
		$data[$j++] = 'points';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual product rewards data
		$i += 1;
		$j = 0;

		$rewards = $this->getRewards($language_id, $min_id, $max_id);

		foreach ($rewards as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['product_id'];
			$data[$j++] = $row['name'];
			$data[$j++] = $row['points'];

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getProductOptions($min_id, $max_id) {
		$language_id = $this->getDefaultLanguageId();

		// Product_option.option_value check
		$po_query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_option` LIKE 'value'");

		$exist_po_value = ($po_query->num_rows > 0) ? true : false;

		// Database query for getting the product options
		if ($exist_po_value) {
			$sql = "SELECT p.product_id, po.option_id, po.value AS option_value, po.required, od.`name` AS `option` FROM";
		} else {
			$sql = "SELECT p.product_id, po.option_id, po.option_value, po.required, od.`name` AS `option` FROM";
		}
		$sql .= " (SELECT p1.product_id FROM `" . DB_PREFIX . "product` p1";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = p1.product_id)";
		}
		if (isset($min_id) && isset($max_id)) {
			$sql .= " WHERE p1.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " WHERE pc.category_id IN " . $this->posted_categories;
		}
		$sql .= " ORDER BY p1.product_id ASC) AS p";
		$sql .= " INNER JOIN `" . DB_PREFIX . "product_option` po ON (po.product_id = p.product_id)";
		$sql .= " INNER JOIN `" . DB_PREFIX . "option_description` od ON (od.option_id = po.option_id)";
		$sql .= " WHERE od.language_id = '" . (int)$language_id . "'";
		$sql .= " ORDER BY p.product_id, po.option_id";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	protected function populateProductOptionsWorksheet($worksheet, $box_format, $text_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
		if ($this->config->get('export_import_settings_use_option_id')) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('option_id')+1);
		} else {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option'), 30)+1);
		}
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('default_option_value')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('required'), 5)+1);

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		if ($this->config->get('export_import_settings_use_option_id')) {
			$data[$j++] = 'option_id';
		} else {
			$styles[$j] = &$text_format;
			$data[$j++] = 'option';
		}
		$styles[$j] = &$text_format;
		$data[$j++] = 'default_option_value';
		$data[$j++] = 'required';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual product options data
		$i += 1;
		$j = 0;

		$product_options = $this->getProductOptions($min_id, $max_id);

		foreach ($product_options as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['product_id'];
			if ($this->config->get('export_import_settings_use_option_id')) {
				$data[$j++] = $row['option_id'];
			} else {
				$data[$j++] = html_entity_decode($row['option'], ENT_QUOTES, 'UTF-8');
			}
			$data[$j++] = html_entity_decode($row['option_value'], ENT_QUOTES, 'UTF-8');
			$data[$j++] = ($row['required'] == 0) ? 'false' : 'true';

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getProductOptionValues($min_id, $max_id) {
		$language_id = $this->getDefaultLanguageId();

		$sql = "SELECT p.product_id, pov.option_id, pov.option_value_id, pov.quantity, pov.subtract, od.name AS `option`, ovd.name AS option_value,";
		$sql .= " pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix";
		$sql .= " FROM (SELECT p1.product_id FROM `" . DB_PREFIX . "product` p1";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = p1.product_id)";
		}
		if (isset($min_id) && isset($max_id)) {
			$sql .= " WHERE p1.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " WHERE pc.category_id IN " . $this->posted_categories;
		}
		$sql .= " ORDER BY p1.product_id ASC) AS p";
		$sql .= " INNER JOIN `" . DB_PREFIX . "product_option_value` pov ON (pov.product_id = p.product_id)";
		$sql .= " INNER JOIN `" . DB_PREFIX . "option_value_description` ovd ON (ovd.option_value_id = pov.option_value_id)";
		$sql .= " INNER JOIN `" . DB_PREFIX . "option_description` od ON (od.option_id = ovd.option_id)";
		$sql .= " WHERE ovd.language_id = '" . (int)$language_id . "'";
		$sql .= " AND od.language_id = '" . (int)$language_id . "'";
		$sql .= " ORDER BY p.product_id, pov.option_id, pov.option_value_id";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	protected function populateProductOptionValuesWorksheet($worksheet, $box_format, $price_format, $weight_format, $text_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
		if ($this->config->get('export_import_settings_use_option_id')) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('option_id')+1);
		} else {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option'), 30)+1);
		}
		if ($this->config->get('export_import_settings_use_option_value_id')) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('option_value_id')+1);
		} else {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option_value'), 30)+1);
		}
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('quantity'), 4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('subtract'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price_prefix'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('points'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('points_prefix'), 5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('weight'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('weight_prefix'), 5)+1);

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		if ($this->config->get('export_import_settings_use_option_id')) {
			$data[$j++] = 'option_id';
		} else {
			$styles[$j] = &$text_format;
			$data[$j++] = 'option';
		}
		if ($this->config->get('export_import_settings_use_option_value_id')) {
			$data[$j++] = 'option_value_id';
		} else {
			$styles[$j] = &$text_format;
			$data[$j++] = 'option_value';
		}
		$data[$j++] = 'quantity';
		$styles[$j] = &$text_format;
		$data[$j++] = 'subtract';
		$styles[$j] = &$price_format;
		$data[$j++] = 'price';
		$styles[$j] = &$text_format;
		$data[$j++] = 'price_prefix';
		$data[$j++] = 'points';
		$styles[$j] = &$text_format;
		$data[$j++] = 'points_prefix';
		$styles[$j] = &$weight_format;
		$data[$j++] = 'weight';
		$styles[$j] = &$text_format;
		$data[$j++] = 'weight_prefix';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual product option values data
		$i += 1;
		$j = 0;

		$product_option_values = $this->getProductOptionValues($min_id, $max_id);

		foreach ($product_option_values as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['product_id'];
			if ($this->config->get('export_import_settings_use_option_id')) {
				$data[$j++] = $row['option_id'];
			} else {
				$data[$j++] = html_entity_decode($row['option'], ENT_QUOTES, 'UTF-8');
			}
			if ($this->config->get('export_import_settings_use_option_value_id')) {
				$data[$j++] = $row['option_value_id'];
			} else {
				$data[$j++] = html_entity_decode($row['option_value'], ENT_QUOTES, 'UTF-8');
			}
			$data[$j++] = $row['quantity'];
			$data[$j++] = ($row['subtract'] == 0) ? 'false' : 'true';
			$data[$j++] = $row['price'];
			$data[$j++] = $row['price_prefix'];
			$data[$j++] = $row['points'];
			$data[$j++] = $row['points_prefix'];
			$data[$j++] = $row['weight'];
			$data[$j++] = $row['weight_prefix'];

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getProductColors($min_id, $max_id) {
		$sql = "SELECT pc1.product_id, pc1.product_color_id, pc1.palette_color_id FROM `" . DB_PREFIX . "product_color` pc1";
		$sql .= " INNER JOIN `" . DB_PREFIX . "palette_color` pc2 ON (pc2.palette_color_id = pc1.palette_color_id)";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = pc1.product_id)";
		}
		if (isset($min_id) && isset($max_id)) {
			$sql .= " WHERE pc1.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " WHERE pc.category_id IN " . $this->posted_categories;
		}
		$sql .= " ORDER BY pc1.product_id, pc1.palette_color_id";

		$query = $this->db->query($sql);

		$product_colors = array();

		foreach ($query->rows as $row) {
			$product_color = array();

			$product_color['product_id'] = $row['product_id'];
			$product_color['product_color_id'] = $row['product_color_id'];
			$product_color['palette_color_id'] = $row['palette_color_id'];

			$product_colors[] = $product_color;
		}

		return $product_colors;
	}

	protected function populateProductColorsWorksheet($worksheet, $box_format, $text_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_color_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('palette_color_id')+1);

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		$data[$j++] = 'product_color_id';
		$data[$j++] = 'palette_color_id';

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual product colors data
		$i += 1;
		$j = 0;

		$product_colors = $this->getProductColors($min_id, $max_id);

		foreach ($product_colors as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['product_id'];
			$data[$j++] = $row['product_color_id'];
			$data[$j++] = $row['palette_color_id'];

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getProductFields($languages, $min_id, $max_id) {
		$sql = "SELECT pf.product_id, pf.field_id, pf.language_id, pf.text FROM `" . DB_PREFIX . "product_field` pf";
		$sql .= " INNER JOIN `" . DB_PREFIX . "field` f ON (f.field_id = pf.field_id)";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = pf.product_id)";
		}
		if (isset($min_id) && isset($max_id)) {
			$sql .= " WHERE pf.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " WHERE pc.category_id IN " . $this->posted_categories;
		}
		$sql .= " ORDER BY pf.product_id, pf.field_id";

		$query = $this->db->query($sql);

		$texts = array();

		foreach ($query->rows as $row) {
			$product_id = $row['product_id'];
			$field_id = $row['field_id'];
			$language_id = $row['language_id'];
			$text = $row['text'];

			$texts[$product_id][$field_id][$language_id] = $text;
		}

		$product_fields = array();

		foreach ($texts as $product_id => $level1) {
			foreach ($level1 as $field_id => $text) {
				$product_field = array();

				$product_field['product_id'] = $product_id;
				$product_field['field_id'] = $field_id;

				$product_field['text'] = array();

				foreach ($languages as $language) {
					$language_id = $language['language_id'];
					$code = $language['code'];

					if (isset($text[$language_id])) {
						$product_field['text'][$code] = $text[$language_id];
					} else {
						$product_field['text'][$code] = '';
					}
				}

				$product_fields[] = $product_field;
			}
		}

		return $product_fields;
	}

	protected function populateProductFieldsWorksheet($worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('field_id')+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('text')+4, 30)+1);
		}

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		$data[$j++] = 'field_id';

		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'text(' . $language['code'] . ')';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual product fields data
		$i += 1;
		$j = 0;

		$product_fields = $this->getProductFields($languages, $min_id, $max_id);

		foreach ($product_fields as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['product_id'];
			$data[$j++] = $row['field_id'];
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['text'][$language['code']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getAttributeGroupNames($language_id) {
		$sql = "SELECT attribute_group_id, `name` FROM `" . DB_PREFIX . "attribute_group_description`";
		$sql .= " WHERE language_id = '" . (int)$language_id . "'";
		$sql .= " ORDER BY attribute_group_id ASC";

		$query = $this->db->query($sql);

		$attribute_group_names = array();

		foreach ($query->rows as $row) {
			$attribute_group_id = $row['attribute_group_id'];
			$name = $row['name'];

			$attribute_group_names[$attribute_group_id] = $name;
		}

		return $attribute_group_names;
	}

	protected function getAttributeNames($language_id) {
		$sql = "SELECT attribute_id, `name` FROM `" . DB_PREFIX . "attribute_description`";
		$sql .= " WHERE language_id = '" . (int)$language_id . "'";
		$sql .= " ORDER BY attribute_id ASC";

		$query = $this->db->query($sql);

		$attribute_names = array();

		foreach ($query->rows as $row) {
			$attribute_id = $row['attribute_id'];
			$attribute_name = $row['name'];

			$attribute_names[$attribute_id] = $attribute_name;
		}

		return $attribute_names;
	}

	protected function getProductAttributes($languages, $min_id, $max_id) {
		$sql = "SELECT pa.product_id, ag.attribute_group_id, pa.attribute_id, pa.language_id, pa.text FROM `" . DB_PREFIX . "product_attribute` pa";
		$sql .= " INNER JOIN `" . DB_PREFIX . "attribute` a ON (a.attribute_id = pa.attribute_id)";
		$sql .= " INNER JOIN `" . DB_PREFIX . "attribute_group` ag ON (ag.attribute_group_id = a.attribute_group_id)";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = pa.product_id)";
		}
		if (isset($min_id) && isset($max_id)) {
			$sql .= " WHERE pa.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " WHERE pc.category_id IN " . $this->posted_categories;
		}
		$sql .= " ORDER BY pa.product_id, ag.attribute_group_id, pa.attribute_id";

		$query = $this->db->query($sql);

		$texts = array();

		foreach ($query->rows as $row) {
			$product_id = $row['product_id'];
			$attribute_group_id = $row['attribute_group_id'];
			$attribute_id = $row['attribute_id'];
			$language_id = $row['language_id'];
			$text = $row['text'];

			$texts[$product_id][$attribute_group_id][$attribute_id][$language_id] = $text;
		}

		$product_attributes = array();

		foreach ($texts as $product_id => $level1) {
			foreach ($level1 as $attribute_group_id => $level2) {
				foreach ($level2 as $attribute_id => $text) {
					$product_attribute = array();

					$product_attribute['product_id'] = $product_id;
					$product_attribute['attribute_group_id'] = $attribute_group_id;
					$product_attribute['attribute_id'] = $attribute_id;

					$product_attribute['text'] = array();

					foreach ($languages as $language) {
						$language_id = $language['language_id'];
						$code = $language['code'];

						if (isset($text[$language_id])) {
							$product_attribute['text'][$code] = $text[$language_id];
						} else {
							$product_attribute['text'][$code] = '';
						}
					}

					$product_attributes[] = $product_attribute;
				}
			}
		}

		return $product_attributes;
	}

	protected function populateProductAttributesWorksheet($worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
		if ($this->config->get('export_import_settings_use_attribute_group_id')) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('attribute_group_id')+1);
		} else {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('attribute_group'), 30)+1);
		}
		if ($this->config->get('export_import_settings_use_attribute_id')) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('attribute_id')+1);
		} else {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('attribute'), 30)+1);
		}
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('text')+4, 30)+1);
		}

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		if ($this->config->get('export_import_settings_use_attribute_group_id')) {
			$data[$j++] = 'attribute_group_id';
		} else {
			$styles[$j] = &$text_format;
			$data[$j++] = 'attribute_group';
		}
		if ($this->config->get('export_import_settings_use_attribute_id')) {
			$data[$j++] = 'attribute_id';
		} else {
			$styles[$j] = &$text_format;
			$data[$j++] = 'attribute';
		}
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'text(' . $language['code'] . ')';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual product attributes data
		if (!$this->config->get('export_import_settings_use_attribute_group_id')) {
			$attribute_group_names = $this->getAttributeGroupNames($default_language_id);
		}

		if (!$this->config->get('export_import_settings_use_attribute_id')) {
			$attribute_names = $this->getAttributeNames($default_language_id);
		}

		$i += 1;
		$j = 0;

		$product_attributes = $this->getProductAttributes($languages, $min_id, $max_id);

		foreach ($product_attributes as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['product_id'];
			if ($this->config->get('export_import_settings_use_attribute_group_id')) {
				$data[$j++] = $row['attribute_group_id'];
			} else {
				$data[$j++] = html_entity_decode($attribute_group_names[$row['attribute_group_id']], ENT_QUOTES, 'UTF-8');
			}
			if ($this->config->get('export_import_settings_use_attribute_id')) {
				$data[$j++] = $row['attribute_id'];
			} else {
				$data[$j++] = html_entity_decode($attribute_names[$row['attribute_id']], ENT_QUOTES, 'UTF-8');
			}
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['text'][$language['code']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getProductFilters($min_id, $max_id) {
		$sql = "SELECT pf.product_id, fg.filter_group_id, pf.filter_id FROM `" . DB_PREFIX . "product_filter` pf";
		$sql .= " INNER JOIN `" . DB_PREFIX . "filter` f ON (f.filter_id = pf.filter_id)";
		$sql .= " INNER JOIN `" . DB_PREFIX . "filter_group` fg ON (fg.filter_group_id = f.filter_group_id)";
		if ($this->posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = pf.product_id)";
		}
		if (isset($min_id) && isset($max_id)) {
			$sql .= " WHERE pf.product_id BETWEEN '" . (int)$min_id . "' AND '" . (int)$max_id . "'";
			if ($this->posted_categories) {
				$sql .= " AND pc.category_id IN " . $this->posted_categories;
			}
		} else if ($this->posted_categories) {
			$sql .= " WHERE pc.category_id IN " . $this->posted_categories;
		}
		$sql .= " ORDER BY pf.product_id ASC, fg.filter_group_id ASC, pf.filter_id ASC";

		$query = $this->db->query($sql);

		$product_filters = array();

		foreach ($query->rows as $row) {
			$product_filter = array();

			$product_filter['product_id'] = $row['product_id'];
			$product_filter['filter_group_id'] = $row['filter_group_id'];
			$product_filter['filter_id'] = $row['filter_id'];

			$product_filters[] = $product_filter;
		}

		return $product_filters;
	}

	protected function populateProductFiltersWorksheet($worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id = null, $max_id = null) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
		if ($this->config->get('export_import_settings_use_filter_group_id')) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('filter_group_id')+1);
		} else {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('filter_group'), 30)+1);
		}
		if ($this->config->get('export_import_settings_use_filter_id')) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('filter_id')+1);
		} else {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('filter'), 30)+1);
		}

		// The heading row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'product_id';
		if ($this->config->get('export_import_settings_use_filter_group_id')) {
			$data[$j++] = 'filter_group_id';
		} else {
			$styles[$j] = &$text_format;
			$data[$j++] = 'filter_group';
		}
		if ($this->config->get('export_import_settings_use_filter_id')) {
			$data[$j++] = 'filter_id';
		} else {
			$styles[$j] = &$text_format;
			$data[$j++] = 'filter';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual product filters data
		if (!$this->config->get('export_import_settings_use_filter_group_id')) {
			$filter_group_names = $this->getFilterGroupNames($default_language_id);
		}

		if (!$this->config->get('export_import_settings_use_filter_id')) {
			$filter_names = $this->getFilterNames($default_language_id);
		}

		$i += 1;
		$j = 0;

		$product_filters = $this->getProductFilters($min_id, $max_id);

		foreach ($product_filters as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['product_id'];
			if ($this->config->get('export_import_settings_use_filter_group_id')) {
				$data[$j++] = $row['filter_group_id'];
			} else {
				$data[$j++] = html_entity_decode($filter_group_names[$row['filter_group_id']], ENT_QUOTES, 'UTF-8');
			}
			if ($this->config->get('export_import_settings_use_filter_id')) {
				$data[$j++] = $row['filter_id'];
			} else {
				$data[$j++] = html_entity_decode($filter_names[$row['filter_id']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getOptionDescriptions($languages) {
		$option_descriptions = array();

		foreach ($languages as $language) {
			$language_id = $language['language_id'];
			$language_code = $language['code'];

			$sql = "SELECT o.option_id, od.* FROM `" . DB_PREFIX . "option` o";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "option_description` od ON (od.option_id = o.option_id)";
			$sql .= " WHERE od.language_id = '" . (int)$language_id . "'";
			$sql .= " GROUP BY o.option_id";
			$sql .= " ORDER BY o.option_id ASC";

			$option_query = $this->db->query($sql);

			$option_descriptions[$language_code] = $option_query->rows;
		}

		return $option_descriptions;
	}

	protected function getOptions($languages) {
		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option` ORDER BY option_id ASC");

		$option_descriptions = $this->getOptionDescriptions($languages);

		foreach ($languages as $language) {
			$language_code = $language['code'];

			foreach ($results->rows as $key => $row) {
				if (isset($option_descriptions[$language_code][$key]['name'])) {
					$results->rows[$key]['name'][$language_code] = $option_descriptions[$language_code][$key]['name'];
				} else {
					$results->rows[$key]['name'][$language_code] = '';
				}
			}
		}

		return $results->rows;
	}

	protected function populateOptionsWorksheet($worksheet, $languages, $box_format, $text_format) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option_id'), 4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('type'), 10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'), 5)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4, 30)+1);
		}

		// The options headings row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'option_id';
		$data[$j++] = 'type';
		$data[$j++] = 'sort_order';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'name(' . $language['code'] . ')';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual options data
		$i += 1;
		$j = 0;

		$options = $this->getOptions($languages);

		foreach ($options as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['option_id'];
			$data[$j++] = $row['type'];
			$data[$j++] = $row['sort_order'];
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['name'][$language['code']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getOptionValueDescriptions($languages) {
		$option_value_descriptions = array();

		foreach ($languages as $language) {
			$language_id = $language['language_id'];
			$language_code = $language['code'];

			$sql = "SELECT ov.option_id, ov.option_value_id, ovd.* FROM `" . DB_PREFIX . "option_value` ov";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "option_value_description` ovd ON (ovd.option_value_id = ov.option_value_id)";
			$sql .= " WHERE ovd.language_id = '" . (int)$language_id . "'";
			$sql .= " GROUP BY ov.option_id, ov.option_value_id";
			$sql .= " ORDER BY ov.option_id ASC, ov.option_value_id ASC";

			$option_value_query = $this->db->query($sql);

			$option_value_descriptions[$language_code] = $option_value_query->rows;
		}

		return $option_value_descriptions;
	}

	protected function getOptionValues($languages) {
		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option_value` ORDER BY option_id ASC, option_value_id ASC");

		$option_value_descriptions = $this->getOptionValueDescriptions($languages);

		foreach ($languages as $language) {
			$language_code = $language['code'];

			foreach ($results->rows as $key => $row) {
				if (isset($option_value_descriptions[$language_code][$key]['name'])) {
					$results->rows[$key]['name'][$language_code] = $option_value_descriptions[$language_code][$key]['name'];
				} else {
					$results->rows[$key]['name'][$language_code] = '';
				}
			}
		}

		return $results->rows;
	}

	protected function populateOptionValuesWorksheet($worksheet, $languages, $box_format, $text_format) {
		// Check for the existence of option_value.image field
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "option_value` LIKE 'image'");

		$exist_image = ($query->num_rows > 0) ? true : false;

		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option_value_id'), 2)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('option_id'), 4)+1);
		if ($exist_image) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('image'), 12)+1);
		}
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'), 5)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4, 30)+1);
		}

		// The option values headings row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'option_value_id';
		$data[$j++] = 'option_id';
		if ($exist_image) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'image';
		}
		$data[$j++] = 'sort_order';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'name(' . $language['code'] . ')';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual option values data
		$i += 1;
		$j = 0;

		$options = $this->getOptionValues($languages);

		foreach ($options as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['option_value_id'];
			$data[$j++] = $row['option_id'];
			if ($exist_image) {
				$data[$j++] = $row['image'];
			}
			$data[$j++] = $row['sort_order'];
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['name'][$language['code']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getAttributeGroupDescriptions($languages) {
		$attribute_group_descriptions = array();

		foreach ($languages as $language) {
			$language_id = $language['language_id'];
			$language_code = $language['code'];

			$sql = "SELECT ag.attribute_group_id, agd.* FROM `" . DB_PREFIX . "attribute_group` ag";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "attribute_group_description` agd ON (agd.attribute_group_id = ag.attribute_group_id)";
			$sql .= " WHERE agd.language_id = '" . (int)$language_id . "'";
			$sql .= " GROUP BY ag.attribute_group_id";
			$sql .= " ORDER BY ag.attribute_group_id ASC";

			$attribute_group_query = $this->db->query($sql);

			$attribute_group_descriptions[$language_code] = $attribute_group_query->rows;
		}

		return $attribute_group_descriptions;
	}

	protected function getAttributeGroups($languages) {
		$attribute_group_descriptions = $this->getAttributeGroupDescriptions($languages);

		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "attribute_group` ORDER BY attribute_group_id ASC");

		foreach ($languages as $language) {
			$language_code = $language['code'];

			foreach ($results->rows as $key => $row) {
				if (isset($attribute_group_descriptions[$language_code][$key]['name'])) {
					$results->rows[$key]['name'][$language_code] = $attribute_group_descriptions[$language_code][$key]['name'];
				} else {
					$results->rows[$key]['name'][$language_code] = '';
				}
			}
		}

		return $results->rows;
	}

	protected function populateAttributeGroupsWorksheet($worksheet, $languages, $box_format, $text_format) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('attribute_group_id'), 4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'), 5)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4, 30)+1);
		}

		// The attribute groups headings row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'attribute_group_id';
		$data[$j++] = 'sort_order';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'name(' . $language['code'] . ')';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual attribute groups data
		$i += 1;
		$j = 0;

		$attributes = $this->getAttributeGroups($languages);

		foreach ($attributes as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['attribute_group_id'];
			$data[$j++] = $row['sort_order'];
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['name'][$language['code']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getAttributeDescriptions($languages) {
		$attribute_descriptions = array();

		foreach ($languages as $language) {
			$language_id = $language['language_id'];
			$language_code = $language['code'];

			$sql = "SELECT a.attribute_group_id, a.attribute_id, ad.* FROM `" . DB_PREFIX . "attribute` a";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "attribute_description` ad ON (ad.attribute_id = a.attribute_id)";
			$sql .= " WHERE ad.language_id = '" . (int)$language_id . "'";
			$sql .= " GROUP BY a.attribute_group_id, a.attribute_id";
			$sql .= " ORDER BY a.attribute_group_id ASC, a.attribute_id ASC";

			$attribute_query = $this->db->query($sql);

			$attribute_descriptions[$language_code] = $attribute_query->rows;
		}

		return $attribute_descriptions;
	}

	protected function getAttributes($languages) {
		$attribute_descriptions = $this->getAttributeDescriptions($languages);

		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "attribute` ORDER BY attribute_group_id ASC, attribute_id ASC");

		foreach ($languages as $language) {
			$language_code = $language['code'];

			foreach ($results->rows as $key => $row) {
				if (isset($attribute_descriptions[$language_code][$key]['name'])) {
					$results->rows[$key]['name'][$language_code] = $attribute_descriptions[$language_code][$key]['name'];
				} else {
					$results->rows[$key]['name'][$language_code] = '';
				}
			}
		}

		return $results->rows;
	}

	protected function populateAttributesWorksheet($worksheet, $languages, $box_format, $text_format) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('attribute_id'), 2)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('attribute_group_id'), 4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'), 5)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4, 30)+1);
		}

		// The attributes headings row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'attribute_id';
		$data[$j++] = 'attribute_group_id';
		$data[$j++] = 'sort_order';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'name(' . $language['code'] . ')';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual attributes values data
		$i += 1;
		$j = 0;

		$options = $this->getAttributes($languages);

		foreach ($options as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['attribute_id'];
			$data[$j++] = $row['attribute_group_id'];
			$data[$j++] = $row['sort_order'];
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['name'][$language['code']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getFilterGroupDescriptions($languages) {
		$filter_group_descriptions = array();

		foreach ($languages as $language) {
			$language_id = $language['language_id'];
			$language_code = $language['code'];

			$sql = "SELECT ag.filter_group_id, agd.* FROM `" . DB_PREFIX . "filter_group` ag";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "filter_group_description` agd ON (agd.filter_group_id = ag.filter_group_id)";
			$sql .= " WHERE agd.language_id = '" . (int)$language_id . "'";
			$sql .= " GROUP BY ag.filter_group_id";
			$sql .= " ORDER BY ag.filter_group_id ASC";

			$filter_group_query = $this->db->query($sql);

			$filter_group_descriptions[$language_code] = $filter_group_query->rows;
		}

		return $filter_group_descriptions;
	}

	protected function getFilterGroups($languages) {
		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "filter_group` ORDER BY filter_group_id ASC");

		$filter_group_descriptions = $this->getFilterGroupDescriptions($languages);

		foreach ($languages as $language) {
			$language_code = $language['code'];

			foreach ($results->rows as $key => $row) {
				if (isset($filter_group_descriptions[$language_code][$key])) {
					$results->rows[$key]['name'][$language_code] = $filter_group_descriptions[$language_code][$key]['name'];
				} else {
					$results->rows[$key]['name'][$language_code] = '';
				}
			}
		}

		return $results->rows;
	}

	protected function populateFilterGroupsWorksheet($worksheet, $languages, $box_format, $text_format) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('filter_group_id'), 4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'), 5)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4, 30)+1);
		}

		// The filter groups headings row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'filter_group_id';
		$data[$j++] = 'sort_order';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'name(' . $language['code'] . ')';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual filter groups data
		$i += 1;
		$j = 0;

		$filters = $this->getFilterGroups($languages);

		foreach ($filters as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['filter_group_id'];
			$data[$j++] = $row['sort_order'];
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['name'][$language['code']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getFilterDescriptions($languages) {
		$filter_descriptions = array();

		foreach ($languages as $language) {
			$language_id = $language['language_id'];
			$language_code = $language['code'];

			$sql = "SELECT a.filter_group_id, a.filter_id, ad.* FROM `" . DB_PREFIX . "filter` a";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "filter_description` ad ON (ad.filter_id = a.filter_id)";
			$sql .= " WHERE ad.language_id = '" . (int)$language_id . "'";
			$sql .= " GROUP BY a.filter_group_id, a.filter_id";
			$sql .= " ORDER BY a.filter_group_id ASC, a.filter_id ASC";

			$filter_query = $this->db->query($sql);

			$filter_descriptions[$language_code] = $filter_query->rows;
		}

		return $filter_descriptions;
	}

	protected function getFilters($languages) {
		$filter_descriptions = $this->getFilterDescriptions($languages);

		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "filter` ORDER BY filter_group_id ASC, filter_id ASC");

		foreach ($languages as $language) {
			$language_code = $language['code'];

			foreach ($results->rows as $key => $row) {
				if (isset($filter_descriptions[$language_code][$key]['name'])) {
					$results->rows[$key]['name'][$language_code] = $filter_descriptions[$language_code][$key]['name'];
				} else {
					$results->rows[$key]['name'][$language_code] = '';
				}
			}
		}

		return $results->rows;
	}

	protected function populateFiltersWorksheet($worksheet, $languages, $box_format, $text_format) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('filter_id'), 2)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('filter_group_id'), 4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'), 5)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4, 30)+1);
		}

		// The filters headings row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'filter_id';
		$data[$j++] = 'filter_group_id';
		$data[$j++] = 'sort_order';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'name(' . $language['code'] . ')';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual filters values data
		$i += 1;
		$j = 0;

		$options = $this->getFilters($languages);

		foreach ($options as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['filter_id'];
			$data[$j++] = $row['filter_group_id'];
			$data[$j++] = $row['sort_order'];
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['name'][$language['code']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getFieldDescriptions($languages) {
		$field_descriptions = array();

		foreach ($languages as $language) {
			$language_id = $language['language_id'];
			$language_code = $language['code'];

			$sql = "SELECT f.field_id, fd.* FROM `" . DB_PREFIX . "field` f";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "field_description` fd ON (fd.field_id = f.field_id)";
			$sql .= " WHERE fd.language_id = '" . (int)$language_id . "'";
			$sql .= " GROUP BY f.field_id";
			$sql .= " ORDER BY f.field_id ASC";

			$field_query = $this->db->query($sql);

			$field_descriptions[$language_code] = $field_query->rows;
		}

		return $field_descriptions;
	}

	protected function getFields($languages) {
		$field_descriptions = $this->getFieldDescriptions($languages);

		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "field` ORDER BY field_id ASC");

		foreach ($languages as $language) {
			$language_code = $language['code'];

			foreach ($results->rows as $key => $row) {
				if (isset($field_descriptions[$language_code][$key]['title'])) {
					$results->rows[$key]['title'][$language_code] = $field_descriptions[$language_code][$key]['title'];
				} else {
					$results->rows[$key]['title'][$language_code] = '';
				}

				if (isset($field_descriptions[$language_code][$key]['description'])) {
					$results->rows[$key]['description'][$language_code] = $field_descriptions[$language_code][$key]['description'];
				} else {
					$results->rows[$key]['description'][$language_code] = '';
				}
			}
		}

		return $results->rows;
	}

	protected function populateFieldsWorksheet($worksheet, $languages, $box_format, $text_format) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('field_id'), 2)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'), 2)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('status'), 2)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('title')+4, 10)+1);
		}
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('description')+4, 30)+1);
		}

		// The fields headings row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'field_id';
		$data[$j++] = 'sort_order';
		$data[$j++] = 'status';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'title(' . $language['code'] . ')';
		}
		foreach ($languages as $language) {
			$styles[$j] = $text_format;
			$data[$j++] = 'description(' . $language['code'] . ')';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual fields values data
		$i += 1;
		$j = 0;

		$options = $this->getFields($languages);

		foreach ($options as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['field_id'];
			$data[$j++] = $row['sort_order'];
			$data[$j++] = $row['status'];
			foreach ($languages as $language) {
				$styles[$j] = &$text_format;
				$data[$j++] = html_entity_decode($row['title'][$language['code']], ENT_QUOTES, 'UTF-8');
			}
			foreach ($languages as $language) {
				$styles[$j] = &$text_format;
				$data[$j++] = html_entity_decode($row['description'][$language['code']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function getPaletteDescriptions($languages) {
		$palette_descriptions = array();

		foreach ($languages as $language) {
			$language_id = $language['language_id'];
			$language_code = $language['code'];

			$sql = "SELECT p.palette_id, pc.palette_color_id, pcd.* FROM `" . DB_PREFIX . "palette` p";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "palette_color` pc ON (pc.palette_id = p.palette_id)";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "palette_color_description` pcd ON (pcd.palette_id = p.palette_id) AND pcd.palette_color_id = pc.palette_color_id";
			$sql .= " WHERE pcd.language_id = '" . (int)$language_id . "'";
			$sql .= " GROUP BY pc.palette_color_id";
			$sql .= " ORDER BY p.palette_id, pc.palette_color_id ASC";

			$palette_query = $this->db->query($sql);

			$palette_descriptions[$language_code] = $palette_query->rows;
		}

		return $palette_descriptions;
	}

	protected function getPalettes($languages) {
		$palette_descriptions = $this->getPaletteDescriptions($languages);

		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "palette` p LEFT JOIN `" . DB_PREFIX . "palette_color` pc ON (pc.palette_id = p.palette_id) ORDER BY p.palette_id, pc.palette_color_id ASC");

		foreach ($languages as $language) {
			$language_code = $language['code'];

			foreach ($results->rows as $key => $row) {
				if (isset($palette_descriptions[$language_code][$key]['title'])) {
					$results->rows[$key]['title'][$language_code] = $palette_descriptions[$language_code][$key]['title'];
				} else {
					$results->rows[$key]['title'][$language_code] = '';
				}
			}
		}

		return $results->rows;
	}

	protected function populatePalettesWorksheet($worksheet, $languages, $box_format, $text_format) {
		// Set the column widths
		$j = 0;

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('palette_color_id'), 2)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('palette_id'), 2)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4, 20)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('color')+4, 12)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('skin')+4, 12)+1);
		foreach ($languages as $language) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('title')+4, 15)+1);
		}

		// The palettes headings row and column styles
		$styles = array();
		$data = array();

		$i = 1;
		$j = 0;

		$data[$j++] = 'palette_color_id';
		$data[$j++] = 'palette_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'name';
		$styles[$j] = &$text_format;
		$data[$j++] = 'color';
		$styles[$j] = &$text_format;
		$data[$j++] = 'skin';
		foreach ($languages as $language) {
			$styles[$j] = &$text_format;
			$data[$j++] = 'title(' . $language['code'] . ')';
		}

		$worksheet->getRowDimension($i)->setRowHeight(30);

		$this->setCellRow($worksheet, $i, $data, $box_format);

		// The actual palettes values data
		$i += 1;
		$j = 0;

		$options = $this->getPalettes($languages);

		foreach ($options as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(13);

			$data = array();

			$data[$j++] = $row['palette_color_id'];
			$data[$j++] = $row['palette_id'];
			$data[$j++] = $row['name'];
			$data[$j++] = $row['color'];
			$data[$j++] = $row['skin'];
			foreach ($languages as $language) {
				$data[$j++] = html_entity_decode($row['title'][$language['code']], ENT_QUOTES, 'UTF-8');
			}

			$this->setCellRow($worksheet, $i, $data, $this->null_array, $styles);

			$i += 1;
			$j = 0;
		}
	}

	protected function clearSpreadsheetCache() {
		$files = glob(DIR_CACHE . 'Spreadsheet_Excel_Writer' . '*');

		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					@unlink($file);
					clearstatcache();
				}
			}
		}
	}

	// Customers
	public function getMaxCustomerId() {
		$cus_max_query = $this->db->query("SELECT MAX(customer_id) AS max_customer_id FROM " . DB_PREFIX . "customer");

		if (isset($cus_max_query->row['max_customer_id'])) {
			$max_id = $cus_max_query->row['max_customer_id'];
		} else {
			$max_id = 0;
		}

		return $max_id;
	}

	public function getMinCustomerId() {
		$cus_min_query = $this->db->query("SELECT MIN(customer_id) AS min_customer_id FROM " . DB_PREFIX . "customer");

		if (isset($cus_min_query->row['min_customer_id'])) {
			$min_id = $cus_min_query->row['min_customer_id'];
		} else {
			$min_id = 0;
		}

		return $min_id;
	}

	public function getCountCustomer() {
		$cus_count_query = $this->db->query("SELECT COUNT(customer_id) AS count_customer FROM " . DB_PREFIX . "customer");

		if (isset($cus_count_query->row['count_customer'])) {
			$count = $cus_count_query->row['count_customer'];
		} else {
			$count = 0;
		}

		return $count;
	}

	// Categories
	public function getMaxCategoryId() {
		$cat_max_query = $this->db->query("SELECT MAX(category_id) AS max_category_id FROM " . DB_PREFIX . "category");

		if (isset($cat_max_query->row['max_category_id'])) {
			$max_id = $cat_max_query->row['max_category_id'];
		} else {
			$max_id = 0;
		}

		return $max_id;
	}

	public function getMinCategoryId() {
		$cat_min_query = $this->db->query("SELECT MIN(category_id) AS min_category_id FROM " . DB_PREFIX . "category");

		if (isset($cat_min_query->row['min_category_id'])) {
			$min_id = $cat_min_query->row['min_category_id'];
		} else {
			$min_id = 0;
		}

		return $min_id;
	}

	public function getCountCategory() {
		$cat_count_query = $this->db->query("SELECT COUNT(category_id) AS count_category FROM " . DB_PREFIX . "category");

		if (isset($cat_count_query->row['count_category'])) {
			$count = $cat_count_query->row['count_category'];
		} else {
			$count = 0;
		}

		return $count;
	}

	// Products
	public function getMaxProductId() {
		$pro_max_query = $this->db->query("SELECT MAX(product_id) AS max_product_id FROM " . DB_PREFIX . "product");

		if (isset($pro_max_query->row['max_product_id'])) {
			$max_id = $pro_max_query->row['max_product_id'];
		} else {
			$max_id = 0;
		}

		return $max_id;
	}

	public function getMinProductId() {
		$pro_min_query = $this->db->query("SELECT MIN(product_id) AS min_product_id FROM " . DB_PREFIX . "product");

		if (isset($pro_min_query->row['min_product_id'])) {
			$min_id = $pro_min_query->row['min_product_id'];
		} else {
			$min_id = 0;
		}

		return $min_id;
	}

	public function getCountProduct() {
		$posted_categories = $this->getPostedCategories();

		$sql = "SELECT COUNT(DISTINCT p.product_id) AS count_product FROM `" . DB_PREFIX . "product` p";
		if ($posted_categories) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` pc ON (pc.product_id = p.product_id)";
			$sql .= " WHERE pc.category_id IN " . $posted_categories;
		}

		$pro_count_query = $this->db->query($sql);

		if (isset($pro_count_query->row['count_product'])) {
			$count = $pro_count_query->row['count_product'];
		} else {
			$count = 0;
		}

		return $count;
	}

	public function download($export_type, $offset = null, $rows = null, $min_id = null, $max_id = null) {
		// Error handler
		global $registry;

		$registry = $this->registry;

		set_error_handler('error_handler_for_export_import', E_ALL);

		register_shutdown_function('fatal_error_shutdown_handler_for_export_import');

		// PHPExcel
		$cwd = getcwd();

		chdir(DIR_SYSTEM . 'vendor');

		require_once('phpexcel/PHPExcel.php');

		PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_ExportImportValueBinder());

		chdir($cwd);

		// Find out whether all data is to be downloaded
		$all = !isset($offset) && !isset($rows) && !isset($min_id) && !isset($max_id);

		// Memory Optimization
		if ($this->config->get('export_import_settings_use_export_cache')) {
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::CACHETOPHPTEMP;

			$cacheSettings = array('memoryCacheSize' => '16MB');

			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		}

		// Export as ZIP (Beta)
		if ($this->config->get('export_import_settings_use_export_pclzip')) {
			PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		}

		$this->posted_categories = $this->getPostedCategories();

		try {
			// Set appropriate timeout limit
			set_time_limit(1800);

			// Create a new workbook
			$workbook = new PHPExcel();

			// Set some default styles
			$workbook->getDefaultStyle()->getFont()->setName('Arial');
			$workbook->getDefaultStyle()->getFont()->setSize(10);
			$workbook->getDefaultStyle()->getAlignment()->setWrapText(true);
			$workbook->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$workbook->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$workbook->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL);

			// Pre-define some commonly used styles
			$box_format = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('argb' => 'FFF0F0F0')
				)
			);

			$text_format = array(
				'numberformat' => array(
					'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
				)
			);

			$price_format = array(
				'numberformat' => array(
					'code' => '######0.00'
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
				)
			);

			$date_format = array(
				'numberformat' => array(
					'code' => '0000-00-00'
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				)
			);

			$datetime_format = array(
				'numberformat' => array(
					'code' => '0000-00-00 00:00:00'
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				)
			);

			$weight_format = array(
				'numberformat' => array(
					'code' => '##0.00'
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
				)
			);

			// Create the worksheets
			$worksheet_index = 0;

			$languages = $this->getLanguages();
			$default_language_id = $this->getDefaultLanguageId();

			switch ($export_type) {
				case 'm':
					// Creating the Customers worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Customers');
					$this->populateCustomersWorksheet($worksheet, $box_format, $text_format, $date_format, $datetime_format, $offset, $rows, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// creating the Addresses worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Addresses');
					$this->populateAddressesWorksheet($worksheet, $box_format, $text_format, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);
					break;

				case 'c':
					// Creating the Categories worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Categories');
					$this->populateCategoriesWorksheet($worksheet, $languages, $box_format, $text_format, $datetime_format, $offset, $rows, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the CategoryFilters worksheet
					if ($this->existFilter()) {
						$workbook->createSheet();
						$workbook->setActiveSheetIndex($worksheet_index++);
						$worksheet = $workbook->getActiveSheet();
						$worksheet->setTitle('CategoryFilters');
						$this->populateCategoryFiltersWorksheet($worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id);
						$worksheet->freezePaneByColumnAndRow(1, 2);
					}
					break;

				case 'p':
					// Creating the Products worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Products');
					$this->populateProductsWorksheet($worksheet, $languages, $default_language_id, $box_format, $price_format, $weight_format, $text_format, $date_format, $datetime_format, $offset, $rows, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the AdditionalImages worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('AdditionalImages');
					$this->populateAdditionalImagesWorksheet($worksheet, $box_format, $text_format, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the Specials worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Specials');
					$this->populateSpecialsWorksheet($worksheet, $default_language_id, $box_format, $price_format, $text_format, $date_format, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the Discounts worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Discounts');
					$this->populateDiscountsWorksheet($worksheet, $default_language_id, $box_format, $price_format, $text_format, $date_format, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the Rewards worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Rewards');
					$this->populateRewardsWorksheet($worksheet, $default_language_id, $box_format, $text_format, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the ProductOptions worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('ProductOptions');
					$this->populateProductOptionsWorksheet($worksheet, $box_format, $text_format, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the ProductOptionValues worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('ProductOptionValues');
					$this->populateProductOptionValuesWorksheet($worksheet, $box_format, $price_format, $weight_format, $text_format, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the ProductColors worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('ProductColors');
					$this->populateProductColorsWorksheet($worksheet, $box_format, $text_format, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the ProductFields worksheet
					if ($this->existField()) {
						$workbook->createSheet();
						$workbook->setActiveSheetIndex($worksheet_index++);
						$worksheet = $workbook->getActiveSheet();
						$worksheet->setTitle('ProductFields');
						$this->populateProductFieldsWorksheet($worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id);
						$worksheet->freezePaneByColumnAndRow(1, 2);
					}

					// Creating the ProductAttributes worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('ProductAttributes');
					$this->populateProductAttributesWorksheet($worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the ProductFilters worksheet
					if ($this->existFilter()) {
						$workbook->createSheet();
						$workbook->setActiveSheetIndex($worksheet_index++);
						$worksheet = $workbook->getActiveSheet();
						$worksheet->setTitle('ProductFilters');
						$this->populateProductFiltersWorksheet($worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id);
						$worksheet->freezePaneByColumnAndRow(1, 2);
					}
					break;

				case 'o':
					// Creating the Options worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Options');
					$this->populateOptionsWorksheet($worksheet, $languages, $box_format, $text_format);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the OptionValues worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('OptionValues');
					$this->populateOptionValuesWorksheet($worksheet, $languages, $box_format, $text_format);
					$worksheet->freezePaneByColumnAndRow(1, 2);
					break;

				case 'a':
					// Creating the AttributeGroups worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('AttributeGroups');
					$this->populateAttributeGroupsWorksheet($worksheet, $languages, $box_format, $text_format);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the Attributes worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Attributes');
					$this->populateAttributesWorksheet($worksheet, $languages, $box_format, $text_format);
					$worksheet->freezePaneByColumnAndRow(1, 2);
					break;

				case 'f':
					if (!$this->existFilter()) {
						throw new Exception($this->language->get('error_filter_not_supported'));
						break;
					}

					// Creating the FilterGroups worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('FilterGroups');
					$this->populateFilterGroupsWorksheet($worksheet, $languages, $box_format, $text_format);
					$worksheet->freezePaneByColumnAndRow(1, 2);

					// Creating the Filters worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Filters');
					$this->populateFiltersWorksheet($worksheet, $languages, $box_format, $text_format);
					$worksheet->freezePaneByColumnAndRow(1, 2);
					break;

				case 'e':
					if (!$this->existField()) {
						throw new Exception($this->language->get('error_field_not_supported'));
						break;
					}

					// Creating the Fields worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Fields');
					$this->populateFieldsWorksheet($worksheet, $languages, $box_format, $text_format);
					$worksheet->freezePaneByColumnAndRow(1, 2);
					break;

				case 't':
					// Creating the Palettes worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle('Palettes');
					$this->populatePalettesWorksheet($worksheet, $languages, $box_format, $text_format);
					$worksheet->freezePaneByColumnAndRow(1, 2);
					break;

				default:
					break;
			}

			$workbook->setActiveSheetIndex(0);

			// Redirect output to client browser
			$datetime = date('Y-m-d');

			switch ($export_type) {
				case 'm':
					$filename = 'customers-' . $datetime;
					if (!$all) {
						if (isset($offset)) {
							$filename .= "-offset-" . $offset;
						} elseif (isset($min_id)) {
							$filename .= "-start-" . $min_id;
						}
						if (isset($rows)) {
							$filename .= "-rows-" . $rows;
						} elseif (isset($max_id)) {
							$filename .= "-end-" . $max_id;
						}
					}
					$filename .= '.xlsx';
					break;
				case 'c':
					$filename = 'categories-' . $datetime;
					if (!$all) {
						if (isset($offset)) {
							$filename .= "-offset-" . $offset;
						} elseif (isset($min_id)) {
							$filename .= "-start-" . $min_id;
						}
						if (isset($rows)) {
							$filename .= "-rows-" . $rows;
						} elseif (isset($max_id)) {
							$filename .= "-end-" . $max_id;
						}
					}
					$filename .= '.xlsx';
					break;
				case 'p':
					$filename = 'products-' . $datetime;
					if (!$all) {
						if (isset($offset)) {
							$filename .= "-offset-" . $offset;
						} elseif (isset($min_id)) {
							$filename .= "-start-" . $min_id;
						}
						if (isset($rows)) {
							$filename .= "-rows-" . $rows;
						} elseif (isset($max_id)) {
							$filename .= "-end-" . $max_id;
						}
					}
					$filename .= '.xlsx';
					break;
				case 'o':
					$filename = 'options-' . $datetime . '.xlsx';
					break;
				case 'a':
					$filename = 'attributes-' . $datetime . '.xlsx';
					break;
				case 'f':
					if (!$this->existFilter()) {
						throw new Exception($this->language->get('error_filter_not_supported'));
						break;
					}
					$filename = 'filters-' . $datetime . '.xlsx';
					break;
				case 'e':
					if (!$this->existField()) {
						throw new Exception($this->language->get('error_field_not_supported'));
						break;
					}
					$filename = 'fields-' . $datetime . '.xlsx';
					break;
				case 't':
					$filename = 'palettes-' . $datetime . '.xlsx';
					break;
				default:
					$filename = $datetime . '.xlsx';
					break;
			}

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($workbook, 'Excel2007');
			$objWriter->setPreCalculateFormulas(false);
			$objWriter->save('php://output');

			// Clear the spreadsheet caches
			$this->clearSpreadsheetCache();
			exit();

		} catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();

			$this->session->data['export_import_error'] = array('errstr' => $errstr, 'errno' => $errno, 'errfile' => $errfile, 'errline' => $errline);

			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get_class($e) . ': ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}

			return;
		}
	}

	public function getOptionNameCounts() {
		$default_language_id = $this->getDefaultLanguageId();

		$sql = "SELECT name, COUNT(option_id) AS count FROM " . DB_PREFIX . "option_description";
		$sql .= " WHERE language_id = '" . (int)$default_language_id . "' GROUP BY name";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getOptionValueNameCounts() {
		$default_language_id = $this->getDefaultLanguageId();

		$sql = "SELECT option_id, name, COUNT(option_value_id) AS count FROM " . DB_PREFIX . "option_value_description";
		$sql .= " WHERE language_id = '" . (int)$default_language_id . "' GROUP BY option_id, name";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAttributeGroupNameCounts() {
		$default_language_id = $this->getDefaultLanguageId();

		$sql = "SELECT name, COUNT(attribute_group_id) AS count FROM " . DB_PREFIX . "attribute_group_description";
		$sql .= " WHERE language_id = '" . (int)$default_language_id . "' GROUP BY name";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAttributeNameCounts() {
		$default_language_id = $this->getDefaultLanguageId();

		$sql = "SELECT ag.attribute_group_id, ad.name, COUNT(ad.attribute_id) AS count FROM " . DB_PREFIX . "attribute_description ad";
		$sql .= " INNER JOIN " . DB_PREFIX . "attribute a ON (a.attribute_id = ad.attribute_id)";
		$sql .= " INNER JOIN " . DB_PREFIX . "attribute_group ag ON (ag.attribute_group_id = a.attribute_group_id)";
		$sql .= " WHERE ad.language_id = '" . (int)$default_language_id . "' GROUP BY ag.attribute_group_id, ad.name";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getFilterGroupNameCounts() {
		$default_language_id = $this->getDefaultLanguageId();

		$sql = "SELECT name, COUNT(filter_group_id) AS count FROM " . DB_PREFIX . "filter_group_description";
		$sql .= " WHERE language_id = '" . (int)$default_language_id . "' GROUP BY name";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getFilterNameCounts() {
		$default_language_id = $this->getDefaultLanguageId();

		$sql = "SELECT fg.filter_group_id, fd.name, COUNT(fd.filter_id) AS count FROM " . DB_PREFIX . "filter_description fd";
		$sql .= " INNER JOIN `" . DB_PREFIX . "filter` f ON (f.filter_id = fd.filter_id)";
		$sql .= " INNER JOIN " . DB_PREFIX . "filter_group fg ON (fg.filter_group_id = f.filter_group_id)";
		$sql .= " WHERE fd.language_id = '" . (int)$default_language_id . "' GROUP BY fg.filter_group_id, fd.name";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getFieldTitleCounts() {
		$default_language_id = $this->getDefaultLanguageId();

		$sql = "SELECT fd.title, COUNT(fd.field_id) AS count FROM " . DB_PREFIX . "field_description fd";
		$sql .= " INNER JOIN `" . DB_PREFIX . "field` f ON (f.field_id = fd.field_id)";
		$sql .= " WHERE fd.language_id = '" . (int)$default_language_id . "' GROUP BY fd.title";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getPaletteTitleCounts() {
		$default_language_id = $this->getDefaultLanguageId();

		$sql = "SELECT pcd.title, COUNT(pcd.palette_id) AS count FROM " . DB_PREFIX . "palette_color_description pcd";
		$sql .= " INNER JOIN `" . DB_PREFIX . "palette` p ON (p.palette_id = pcd.palette_id)";
		$sql .= " WHERE pcd.language_id = '" . (int)$default_language_id . "' GROUP BY pcd.title";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function existFilter() {
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "filter'");
		$exist_table_filter = ($query->num_rows > 0);

		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "filter_group'");
		$exist_table_filter_group = ($query->num_rows > 0);

		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_filter'");
		$exist_table_product_filter = ($query->num_rows > 0);

		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "category_filter'");
		$exist_table_category_filter = ($query->num_rows > 0);

		if (!$exist_table_filter) {
			return false;
		}

		if (!$exist_table_filter_group) {
			return false;
		}

		if (!$exist_table_product_filter) {
			return false;
		}

		if (!$exist_table_category_filter) {
			return false;
		}

		return true;
	}

	public function existField() {
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "field'");
		$exist_table_field= ($query->num_rows > 0);

		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "field_description'");
		$exist_table_field_description = ($query->num_rows > 0);

		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_field'");
		$exist_table_product_field = ($query->num_rows > 0);

		if (!$exist_table_field) {
			return false;
		}

		if (!$exist_table_field_description) {
			return false;
		}

		if (!$exist_table_product_field) {
			return false;
		}

		return true;
	}
}
