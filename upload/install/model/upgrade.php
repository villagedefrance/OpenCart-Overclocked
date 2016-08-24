<?php
// ---------------------------------
// OPENCART OCE UPGRADE SCRIPT
// Oldest version supported is 1.3.2
// ---------------------------------

class ModelUpgrade extends Model {

	public function dataTables($step1) {
		// Load the sql file
		$file = DIR_APPLICATION . 'opencart-upgrade.sql';

		if (!file_exists($file)) {
			exit('Could not load sql file: ' . $file);
		}

		clearstatcache();

		$string = '';

		$lines = file($file);

		$status = false;

		// Get only the Create statements
		foreach ($lines as $line) {
			// Set any prefix
			$line = str_replace("CREATE TABLE `oc_", "CREATE TABLE `" . DB_PREFIX, $line);

			// If line begins with Create Table, start recording
			if (substr($line, 0, 12) == 'CREATE TABLE') {
				$status = true;
			}

			if ($status) {
				$string .= $line;
			}

			// If line contains ';', stop recording
			if (preg_match('/;/', $line)) {
				$status = false;
			}
		}

		$table_new_data = array();

		// Trim any spaces
		$string = trim($string);

		// Trim any ';'
		$string = trim($string, ';');

		// Start reading each Create statement
		$statements = explode(';', $string);

		foreach ($statements as $sql) {
			// Get all fields
			$field_data = array();

			preg_match_all('#`(\w[\w\d]*)`\s+((tinyint|smallint|mediumint|bigint|int|tinytext|text|mediumtext|longtext|tinyblob|blob|mediumblob|longblob|varchar|char|datetime|date|float|double|decimal|timestamp|time|year|enum|set|binary|varbinary)(\((.*)\))?){1}\s*(collate (\w+)\s*)?(unsigned\s*)?((NOT\s*NULL\s*)|(NULL\s*))?(auto_increment\s*)?(default \'([^\']*)\'\s*)?#i', $sql, $match);

			foreach (array_keys($match[0]) as $key) {
				$field_data[] = array(
					'name'          => trim($match[1][$key]),
					'type'          => strtoupper(trim($match[3][$key])),
					'size'          => str_replace(array('(', ')'), '', trim($match[4][$key])),
					'sizeext'       => trim($match[6][$key]),
					'collation'     => trim($match[7][$key]),
					'unsigned'      => trim($match[8][$key]),
					'notnull'       => trim($match[9][$key]),
					'autoincrement' => trim($match[12][$key]),
					'default'       => trim($match[14][$key])
				);
			}

			// Get primary keys
			$primary_data = array();

			preg_match('#primary\s*key\s*\([^)]+\)#i', $sql, $match);

			if (isset($match[0])) {
				preg_match_all('#`(\w[\w\d]*)`#', $match[0], $match);
			} else {
				$match = array();
			}

			if ($match) {
				foreach ($match[1] as $primary) {
					$primary_data[] = $primary;
				}
			}

			// Get indexes
			$index_data = array();
			$indexes = array();

			preg_match_all('#key\s*`\w[\w\d]*`\s*\(.*\)#i', $sql, $match);

			foreach ($match[0] as $key) {
				preg_match_all('#`(\w[\w\d]*)`#', $key, $match);

				$indexes[] = $match;
			}

			foreach ($indexes as $index) {
				$key = '';

				foreach ($index[1] as $field) {
					if ($key == '') {
						$key = $field;
					} else {
						$index_data[$key][] = $field;
					}
				}
			}

			// Table options
			$option_data = array();

			preg_match_all('#(\w+)=(\w+)#', $sql, $option);

			foreach (array_keys($option[0]) as $key) {
				$option_data[$option[1][$key]] = $option[2][$key];
			}

			// Get Table Name
			preg_match_all('#create\s*table\s*`(\w[\w\d]*)`#i', $sql, $table);

			if (isset($table[1][0])) {
				$table_new_data[] = array(
					'sql'     => $sql,
					'name'    => $table[1][0],
					'field'   => $field_data,
					'primary' => $primary_data,
					'index'   => $index_data,
					'option'  => $option_data
				);
			}
		}

		$this->db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		// Get all current tables, fields, type, size, etc..
		$table_old_data = array();

		$table_query = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "`");

		foreach ($table_query->rows as $table) {
			if (utf8_substr($table['Tables_in_' . DB_DATABASE], 0, strlen(DB_PREFIX)) == DB_PREFIX) {
				$field_data = array();

				$field_query = $this->db->query("SHOW COLUMNS FROM `" . $table['Tables_in_' . DB_DATABASE] . "`");

				foreach ($field_query->rows as $field) {
					$field_data[] = $field['Field'];
				}

				$table_old_data[$table['Tables_in_' . DB_DATABASE]] = $field_data;
			}
		}

		foreach ($table_new_data as $table) {
			// If Table is not found create it
			if (!isset($table_old_data[$table['name']])) {
				$this->db->query($table['sql']);
			} else {
				// DB Engine
				if (isset($table['option']['ENGINE'])) {
					$this->db->query("ALTER TABLE `" . $table['name'] . "` ENGINE = " . $table['option']['ENGINE'] . "");
				}

				// Charset
				if (isset($table['option']['CHARSET']) && isset($table['option']['COLLATE'])) {
 					$this->db->query("ALTER TABLE `" . $table['name'] . "` DEFAULT CHARACTER SET " . $table['option']['CHARSET'] . " COLLATE " . $table['option']['COLLATE'] . "");
				}

				set_time_limit(60);

				$i = 0;

				foreach ($table['field'] as $field) {
					// If Field is not found create it
					if (!in_array($field['name'], $table_old_data[$table['name']])) {
						$sql = "ALTER TABLE `" . $table['name'] . "` ADD `" . $field['name'] . "` " . $field['type'] . "";

						if ($field['size']) {
							$sql .= "(" . $field['size'] . ")";
						}

						if ($field['collation']) {
							$sql .= " " . $field['collation'];
						}

						if ($field['notnull']) {
							$sql .= " " . $field['notnull'];
						}

						if ($field['default']) {
							$sql .= " DEFAULT '" . $field['default'] . "'";
						}

						if (isset($table['field'][$i - 1])) {
							$sql .= " AFTER `" . $table['field'][$i - 1]['name'] . "`";
						} else {
							$sql .= " FIRST";
						}

						$this->db->query($sql);
					}

					$i++;
				}

				foreach ($table['field'] as $field) {
					// Remove auto-increment from all fields
					if (in_array($field['name'], $table_old_data[$table['name']])) {
						$sql = "ALTER TABLE `" . $table['name'] . "` CHANGE `" . $field['name'] . "` `" . $field['name'] . "` " . strtoupper($field['type']) . "";

						if ($field['size']) {
							$sql .= "(" . $field['size'] . ")";
						}

						if ($field['collation']) {
							$sql .= " " . $field['collation'];
						}

						if ($field['notnull']) {
							$sql .= " " . $field['notnull'];
						}

						if ($field['default']) {
							$sql .= " DEFAULT '" . $field['default'] . "'";
						}

						if (isset($table['field'][$i - 1])) {
							$sql .= " AFTER `" . $table['field'][$i - 1]['name'] . "`";
						} else {
							$sql .= " FIRST";
						}

						$this->db->query($sql);
					}

					$i++;
				}

				$status = false;

				// Drop primary keys and indexes
				$query = $this->db->query("SHOW INDEXES FROM `" . $table['name'] . "`");

				foreach ($query->rows as $result) {
					if ($result['Key_name'] != 'PRIMARY') {
						$this->db->query("ALTER TABLE `" . $table['name'] . "` DROP INDEX `" . $result['Key_name'] . "`");
					} else {
						$status = true;
					}
				}

				if ($status) {
					$this->db->query("ALTER TABLE `" . $table['name'] . "` DROP PRIMARY KEY");
				}

				// Add a new primary key
				$primary_data = array();

				foreach ($table['primary'] as $primary) {
					$primary_data[] = "`" . $primary . "`";
				}

				if ($primary_data) {
					$this->db->query("ALTER TABLE `" . $table['name'] . "` ADD PRIMARY KEY(" . implode(',', $primary_data) . ")");
				}

				// Add the new indexes
				foreach ($table['index'] as $index) {
					$index_data = array();

					foreach ($index as $key) {
						$index_data[] = "`" . $key . "`";
					}

					if ($index_data) {
						$this->db->query("ALTER TABLE `" . $table['name'] . "` ADD INDEX (" . implode(',', $index_data) . ")");
					}
				}

				// Add auto-increment to primary keys again
				foreach ($table['field'] as $field) {
					if ($field['autoincrement']) {
						$sql = "ALTER TABLE `" . $table['name'] . "` CHANGE `" . $field['name'] . "` `" . $field['name'] . "` " . strtoupper($field['type']) . "";

						if ($field['size']) {
							$sql .= "(" . $field['size'] . ")";
						}

						if ($field['collation']) {
							$sql .= " " . $field['collation'];
						}

						if ($field['notnull']) {
							$sql .= " " . $field['notnull'];
						}

						if ($field['default']) {
							$sql .= " DEFAULT '" . $field['default'] . "'";
						}

						if ($field['autoincrement']) {
							$sql .= " AUTO_INCREMENT";
						}

						$this->db->query($sql);
					}
				}

				flush();
			}
		}

		$step1 = true;

		return $step1;
	}

	// -----------------------------------
	// Function to update additional tables
	// -----------------------------------
	public function additionalTables($step2) {
		set_time_limit(30);

		// Add serialized to Setting
		$setting_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '0' ORDER BY store_id ASC");

		foreach ($setting_query->rows as $setting) {
			if (!$setting['serialized']) {
				$settings[$setting['key']] = $setting['value'];
			} else {
				$settings[$setting['key']] = unserialize($setting['value']);
			}
		}

		// Set defaults for new voucher min/max fields if not set
		if (empty($settings['config_voucher_min'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `value` = '1', `key` = 'config_voucher_min', `group` = 'config', store_id = '0'");
		}

		if (empty($settings['config_voucher_max'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `value` = '1000', `key` = 'config_voucher_max', `group` = 'config', store_id = '0'");
		}

		// Update the country table
		if (isset($table_old_data[DB_PREFIX . 'country']) && in_array('name', $table_old_data[DB_PREFIX . 'country'])) {
			// Country 'name' field moved to new country_description table. Need to loop through and move over
			$country_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country");

			foreach ($country_query->rows as $country) {
				$language_query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language`");

				foreach ($language_query->rows as $language) {
					$this->db->query("REPLACE INTO " . DB_PREFIX . "country_description SET country_id = '" . (int)$country['country_id'] . "', language_id = '" . (int)$language['language_id'] . "', name = '" . $this->db->escape($country['name']) . "'");
				}
			}

			$this->db->query("ALTER TABLE " . DB_PREFIX . "country DROP name");
		}

		// Update the customer group table
		if (isset($table_old_data[DB_PREFIX . 'customer_group']) && in_array('name', $table_old_data[DB_PREFIX . 'customer_group'])) {
			// Customer Group 'name' field moved to new customer_group_description table. Need to loop through and move over
			$customer_group_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group");

			foreach ($customer_group_query->rows as $customer_group) {
				$language_query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language`");

				foreach ($language_query->rows as $language) {
					$this->db->query("REPLACE INTO " . DB_PREFIX . "customer_group_description SET customer_group_id = '" . (int)$customer_group['customer_group_id'] . "', language_id = '" . (int)$language['language_id'] . "', name = '" . $this->db->escape($customer_group['name']) . "'");
				}
			}

			$this->db->query("ALTER TABLE " . DB_PREFIX . "customer_group DROP name");
		}

		// Update the manufacturer table
		if (isset($table_old_data[DB_PREFIX . 'manufacturer']) && in_array('name', $table_old_data[DB_PREFIX . 'manufacturer'])) {
			// Manufacturer 'name' field moved to new manufacturer_description table. Need to loop through and move over
			$manufacturer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer");

			foreach ($manufacturer_query->rows as $manufacturer) {
				$language_query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language`");

				foreach ($language_query->rows as $language) {
					$this->db->query("REPLACE INTO " . DB_PREFIX . "manufacturer_description SET manufacturer_id = '" . (int)$manufacturer['manufacturer_id'] . "', language_id = '" . (int)$language['language_id'] . "', name = '" . $this->db->escape($manufacturer['name']) . "', description = '" . $this->db->escape($manufacturer['description']) . "'");
				}
			}

			$this->db->query("ALTER TABLE " . DB_PREFIX . "manufacturer DROP name");
		}

		// Move blacklisted ip to ban ip table
		$ip_query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "customer_ip_blacklist'");

		if ($ip_query->num_rows) {
			$blacklist_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip_blacklist");

			foreach ($blacklist_query->rows as $result) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "customer_ban_ip SET ip = '" . $this->db->escape($result['ip']) . "'");
			}

			// Drop unused tables
			$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "customer_ip_blacklist");
		}

		// Product tag table to product description tag
		if (isset($table_old_data[DB_PREFIX . 'product_tag']) && !in_array('tag', $table_old_data[DB_PREFIX . 'product_description'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_description pd SET tag = (SELECT GROUP_CONCAT(DISTINCT pt.tag ORDER BY pt.product_tag_id) FROM " . DB_PREFIX . "product_tag pt WHERE pd.product_id = pt.product_id AND pd.language_id = pt.language_id GROUP BY pt.product_id, pt.language_id)");
		}

		// Delete unused order_fraud table
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "order_fraud");

		clearstatcache();

		flush();

		$step2 = true;

		return $step2;
	}

	// --------------------------------------------------------------------------------
	// Function to repair any erroneous categories that are not in the category path table
	// --------------------------------------------------------------------------------
	public function repairCategories($parent_id = 0, $step3) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$category['category_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$level_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$parent_id . "' ORDER BY `level` ASC");

			foreach ($level_query->rows as $result) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_path SET category_id = '" . (int)$category['category_id'] . "', path_id = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO " . DB_PREFIX . "category_path SET category_id = '" . (int)$category['category_id'] . "', path_id = '" . (int)$category['category_id'] . "', `level` = '" . (int)$level . "'");

			$this->repairCategories($category['category_id']);
		}

		// Create system/upload directory
		$upload_directory = DIR_SYSTEM . 'upload/';

		if (!is_dir($upload_directory)) {
			mkdir(DIR_SYSTEM . 'upload', 0777);
		}

		$step3 = true;

		return $step3;
	}

	// -----------------------------------------------
	// Function to update the existing "config.php" files
	// -----------------------------------------------
	public function updateConfig($step4) {
		set_time_limit(30);

		$upload = 'define(\'DIR_DOWNLOAD\', \'' . DIR_OPENCART . 'download/\');';
		$vqmod = 'define(\'DIR_LOGS\', \'' . DIR_OPENCART . 'system/logs/\');';
		$port = 'define(\'DB_PREFIX\', \'' . DB_PREFIX . '\');';

		$check_upload = 'define(\'DIR_UPLOAD\', \'' . DIR_OPENCART . 'system/upload/\');';
		$check_vqmod = 'define(\'DIR_VQMOD\', \'' . DIR_OPENCART . 'vqmod/\');';
		$check_port = 'define(\'DB_PORT\', \'3306\');';

		$output_upload = '
define(\'DIR_DOWNLOAD\', \'' . DIR_OPENCART . 'download/\');
define(\'DIR_UPLOAD\', \'' . DIR_OPENCART . 'system/upload/\');';

		$output_vqmod = '
define(\'DIR_LOGS\', \'' . DIR_OPENCART . 'system/logs/\');
define(\'DIR_VQMOD\', \'' . DIR_OPENCART . 'vqmod/\');';

		$output_port = '
define(\'DB_PORT\', \'3306\');
define(\'DB_PREFIX\', \'' . DB_PREFIX . '\');';

		// Catalog
		if (file_exists('../config.php') && filesize('../config.php') > 0) {
			$catalog = '../config.php';

			$catalog_data = file_get_contents($catalog);

			$catalog_string = implode('', file($catalog));

			$fh1 = fopen($catalog, 'w+');

			if (strpos($catalog_data, $check_upload) == false) {
				$catalog_string .= str_replace($upload, $output_upload, $catalog_string);
			}

			if (strpos($catalog_data, $check_vqmod) == false) {
				$catalog_string .= str_replace($vqmod, $output_vqmod, $catalog_string);
			}

			if (strpos($catalog_data, $check_port) == false) {
				$catalog_string .= str_replace($port, $output_port, $catalog_string);
			}

			fwrite($fh1, $catalog_string, strlen($catalog_string));

			fclose($fh1);
		}

		// Admin
		if (file_exists('../admin/config.php') && filesize('../admin/config.php') > 0) {
			$admin = '../admin/config.php';

			$admin_data = file_get_contents($admin);

			$admin_string = implode('', file($admin));

			$fh2 = fopen($admin, 'w+');

			if (strpos($admin_data, $check_upload) == false) {
				$admin_string .= str_replace($upload, $output_upload, $admin_string);
			}

			if (strpos($admin_data, $check_vqmod) == false) {
				$admin_string .= str_replace($vqmod, $output_vqmod, $admin_string);
			}

			if (strpos($admin_data, $check_port) == false) {
				$admin_string .= str_replace($port, $output_port, $admin_string);
			}

			fwrite($fh2, $admin_string, strlen($admin_string));

			fclose($fh2);
		}

		clearstatcache();

		flush();

		$step4 = true;

		return $step4;
	}

	// ------------------------------------
	// Function to update the layout routes
	// ------------------------------------
	public function updateLayouts($step5) {
		// Get stores
		$stores = array(0);

		$sql = "SELECT store_id FROM " . DB_PREFIX . "store";

		$query_store = $this->db->query($sql);

		foreach ($query_store->rows as $store) {
			$stores[] = $store['store_id'];
		}

		// Create News layout
		$sql = "SELECT layout_id FROM " . DB_PREFIX . "layout WHERE name LIKE 'News' LIMIT 0,1";

		$query_name = $this->db->query($sql);

		if ($query_name->num_rows == 0) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name = 'News'");
		}

		// Add News routes
		$news_routes = array('information/news', 'information/news_list');

		foreach ($stores as $store_id) {
			foreach ($news_routes as $news_route) {
				$sql = "SELECT layout_id FROM " . DB_PREFIX . "layout_route WHERE store_id = '" . (int)$store_id . "' AND route LIKE '" . $news_route . "' LIMIT 0,1";

				$query = $this->db->query($sql);

				if ($query->num_rows == 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = (SELECT DISTINCT layout_id FROM " . DB_PREFIX . "layout WHERE name = 'News'), store_id = '" . (int)$store_id . "', route = '" . $news_route . "'");
				}
			}
		}

		// Create Special layout
		$sql = "SELECT layout_id FROM " . DB_PREFIX . "layout WHERE name LIKE 'Special' LIMIT 1";

		$query_name = $this->db->query($sql);

		if ($query_name->num_rows == 0) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name = 'Special'");
		}

		// Add Special routes
		$special_routes = array('product/special');

		foreach ($stores as $store_id) {
			foreach ($special_routes as $special_route) {
				$sql = "SELECT layout_id FROM " . DB_PREFIX . "layout_route WHERE store_id = '" . (int)$store_id . "' AND route LIKE '" . $special_route . "' LIMIT 0,1";

				$query = $this->db->query($sql);

				if ($query->num_rows == 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = (SELECT DISTINCT layout_id FROM " . DB_PREFIX . "layout WHERE name = 'Special'), store_id = '" . (int)$store_id . "', route = '" . $special_route . "'");
				}
			}
		}

		$step5 = true;

		return $step5;
	}

	// ------------------------------------
	// Function to insert required Geo data
	// ------------------------------------
	public function updateGeoData($file) {
		ini_set('max_execution_time', 3600);

		$handle = fopen($file, 'r');

		if (!$handle) {
			die('Cannot open uploaded CSV file.');
		}

		// Get Table name and Columns from header row
		$columns = array();

		$data = fgetcsv($handle, 1000, ";");

		// If the first line is blank, try the next line
		if (!$data[0]) {
			$data = fgetcsv($handle, 1000, ";");
		}

		foreach ($data as $d) {
			if (strpos($d, '.') !== false) {
				$tmp = explode('.', $d);
				$table =  DB_PREFIX . $tmp[0];
				$columns[] = $tmp[1];
			} else {
				$columns[] = $d;
			}
		}

		if (!$table) {
			exit('Cannot find SQL table.');
		}

		$row_count = 0;

		$sql_query_array = array();

		// Read the file as csv
		while (($data = fgetcsv($handle, 10000, ";")) !== false) {
			if (count($data) > count($columns)) {
				$data = array_slice($data, 0, count($columns));
			}

			$row_count++;

			$pattern = '/\A\d{1,2}\/\d{1,2}\/\d{4}/';
			$pattern2 = '/\A\d{1,2}\-\d{1,2}\-\d{4}/';

			foreach ($data as $key => $value) {
				$matches = '';

				$test = preg_match_all($pattern, $value, $matches);
				$test2 = preg_match_all($pattern2, $value, $matches);

				if ($test || $test2) {
					if ($value == date('Y-m-d H:i:s', strtotime($value))) {
						$new_value = date('Y-m-d H:i:s', strtotime($value));
						$data[$key] = "DATETIME('" . $this->db->escape($new_value) . "')";
					} elseif ($value == date('Y-m-d', strtotime($value))) {
						$new_value = date('Y-m-d', strtotime($value));
						$data[$key] = "DATE('" . $this->db->escape($new_value) . "')";
					} else {
						$value = date("Y-m-d", strtotime($value));
						$data[$key] = "DATE('" . $this->db->escape($value) . "')";
					}

				} else {
					$data[$key] = "'" . $this->db->escape($value) . "'";
				}
			}

			// Try to prevent last missing columns sql error
			if (count($data) < count($columns)) {
				while (count($data) < count($columns)) {
					$key++;
					$data[$key] = "''";
				}
			}

			$columns = $this->checkReserved($columns);

			// Handle line in one by one query
			$sql_query_array[] = "INSERT INTO " . $table . " (" . implode(',', $columns) . ") VALUES (" . htmlentities(implode(",", $data)) . ")";
		}

		fclose($handle);

		if (count($sql_query_array)) {
			$this->db->query("TRUNCATE TABLE " . $table);

			foreach ($sql_query_array as $sql_query) {
				$this->db->query($sql_query);
			}
		}

		return $row_count;
	}

	// Check SQL reserved keywords
	public function checkReserved($columns = array()) {
		$checked_columns = array();

		$reserved = array (
			'ACCESSIBLE', 'ACTION', 'ADD', 'AFTER', 'AGAINST', 'AGGREGATE', 'ALGORITHM', 'ALL', 'ALTER', 'ANALYZE', 'AND', 'ANY', 'AS', 'ASC',	'ASCII', 'ASENSITIVE', 'AT', 'AUTHORS',
			'AUTOEXTEND_SIZE', 'AUTO_INCREMENT', 'AVG', 'AVG_ROW_LENGTH', 'BACKUP', 'BEFORE', 'BEGIN', 'BETWEEN', 'BIGINT', 'BINARY', 'BINLOG', 'BIT', 'BLOB', 'BLOCK', 'BOOL',
			'BOOLEAN', 'BOTH', 'BTREE', 'BY', 'BYTE', 'CACHE', 'CALL', 'CASCADE', 'CASCADED', 'CASE', 'CATALOG_NAME', 'CHAIN', 'CHANGE', 'CHANGED', 'CHAR', 'CHARACTER', 'CHARSET',
			'CHECK', 'CHECKSUM', 'CIPHER', 'CLASS_ORIGIN', 'CLIENT', 'CLOSE', 'COALESCE', 'CODE', 'COLLATE', 'COLLATION', 'COLUMN', 'COLUMNS', 'COLUMN_NAME', 'COMMENT',
			'COMMIT', 'COMMITTED', 'COMPACT', 'COMPLETION', 'COMPRESSED', 'CONCURRENT', 'CONDITION', 'CONNECTION', 'CONSISTENT', 'CONSTRAINT', 'CONSTRAINT_CATALOG',
			'CONSTRAINT_NAME', 'CONSTRAINT_SCHEMA', 'CONTAINS', 'CONTEXT', 'CONTINUE', 'CONTRIBUTORS', 'CONVERT', 'CPU', 'CREATE', 'CROSS', 'CUBE', 'CURRENT_DATE',
			'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR', 'CURSOR_NAME', 'DATA', 'DATABASE', 'DATABASES', 'DATAFILE', 'DATE', 'DATETIME', 'DAY', 'DAY_HOUR',
			'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEALLOCATE', 'DEC', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DEFINER', 'DELAYED', 'DELAY_KEY_WRITE', 'DELETE', 'DESC',
			'DESCRIBE', 'DES_KEY_FILE', 'DETERMINISTIC', 'DIRECTORY', 'DISABLE', 'DISCARD', 'DISK', 'DISTINCT', 'DISTINCTROW', 'DIV', 'DO', 'DOUBLE', 'DROP', 'DUAL', 'DUMPFILE',
			'DUPLICATE', 'DYNAMIC', 'EACH', 'ELSE', 'ELSEIF', 'ENABLE', 'ENCLOSED', 'END', 'ENDS', 'ENGINE', 'ENGINES', 'ENUM', 'ERROR', 'ERRORS', 'ESCAPE', 'ESCAPED', 'EVENT', 'EVENTS',
			'EVERY', 'EXECUTE', 'EXISTS', 'EXIT', 'EXPANSION', 'EXPLAIN', 'EXTENDED', 'EXTENT_SIZE', 'FALSE', 'FAST', 'FAULTS', 'FETCH', 'FIELDS', 'FILE', 'FIRST', 'FIXED', 'FLOAT',
			'FLOAT4', 'FLOAT8', 'FLUSH', 'FOR', 'FORCE', 'FOREIGN', 'FOUND', 'FRAC_SECOND', 'FROM', 'FULL', 'FULLTEXT', 'FUNCTION 	GENERAL', 'GEOMETRY', 'GEOMETRYCOLLECTION',
			'GET_FORMAT', 'GLOBAL', 'GRANT', 'GRANTS', 'GROUP', 'HANDLER', 'HASH', 'HAVING', 'HELP', 'HIGH_PRIORITY', 'HOST', 'HOSTS', 'HOUR', 'HOUR_MICROSECOND',
			'HOUR_MINUTE', 'HOUR_SECOND', 'IDENTIFIED', 'IF', 'IGNORE', 'IGNORE_SERVER_IDS', 'IMPORT', 'IN', 'INDEX', 'INDEXES', 'INFILE', 'INITIAL_SIZE', 'INNER', 'INNOBASE', 'INNODB',
			'INOUT', 'INSENSITIVE', 'INSERT', 'INSERT_METHOD', 'INSTALL', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTERVAL', 'INTO', 'INVOKER', 'IO', 'IO_THREAD', 'IPC',
			'IS', 'ISOLATION', 'ISSUER', 'ITERATE', 'JOIN', 'KEY', 'KEYS', 'KEY_BLOCK_SIZE', 'KILL', 'LANGUAGE', 'LAST', 'LEADING', 'LEAVE', 'LEAVES', 'LEFT', 'LESS', 'LEVEL', 'LIKE', 'LIMIT',
			'LINEAR', 'LINES', 'LINESTRING', 'LIST', 'LOAD', 'LOCAL', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK', 'LOCKS', 'LOGFILE', 'LOGS', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP',
			'LOW_PRIORITY', 'MASTER', 'MASTER_CONNECT_RETRY', 'MASTER_HEARTBEAT_PERIOD', 'MASTER_HOST', 'MASTER_LOG_FILE', 'MASTER_LOG_POS', 'MASTER_PASSWORD',
			'MASTER_PORT', 'MASTER_SERVER_ID', 'MASTER_SSL', 'MASTER_SSL_CA', 'MASTER_SSL_CAPATH', 'MASTER_SSL_CERT', 'MASTER_SSL_CIPHER', 'MASTER_SSL_KEY',
			'MASTER_SSL_VERIFY_SERVER_CERT', 'MASTER_USER', 'MATCH', 'MAXVALUE', 'MAX_CONNECTIONS_PER_HOUR', 'MAX_QUERIES_PER_HOUR', 'MAX_ROWS', 'MAX_SIZE',
			'MAX_UPDATES_PER_HOUR', 'MAX_USER_CONNECTIONS', 'MEDIUM', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MEMORY', 'MERGE', 'MESSAGE_TEXT', 'MICROSECOND',
			'MIDDLEINT', 'MIGRATE', 'MINUTE', 'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MIN_ROWS', 'MOD', 'MODE', 'MODIFIES', 'MODIFY', 'MONTH', 'MULTILINESTRING',
			'MULTIPOINT', 'MULTIPOLYGON', 'MUTEX', 'MYSQL_ERRNO', 'NAME', 'NAMES', 'NATIONAL', 'NATURAL', 'NCHAR', 'NDB', 'NDBCLUSTER', 'NEW', 'NEXT', 'NO', 'NODEGROUP',
			'NONE', 'NOT', 'NO_WAIT', 'NO_WRITE_TO_BINLOG', 'NULL', 'NUMERIC', 'NVARCHAR', 'OFFSET', 'OLD_PASSWORD', 'ON', 'ONE', 'ONE_SHOT', 'OPEN', 'OPTIMIZE', 'OPTION',
			'OPTIONALLY', 'OPTIONS', 'OR', 'ORDER', 'OUT', 'OUTER', 'OUTFILE', 'OWNER', 'PACK_KEYS', 'PAGE', 'PARSER', 'PARTIAL', 'PARTITION', 'PARTITIONING', 'PARTITIONS',
			'PASSWORD', 'PHASE', 'PLUGIN', 'PLUGINS', 'POINT', 'POLYGON', 'PORT', 'PRECISION', 'PREPARE', 'PRESERVE', 'PREV', 'PRIMARY', 'PRIVILEGES', 'PROCEDURE', 'PROCESSLIST',
			'PROFILE', 'PROFILES', 'PROXY', 'PURGE', 'QUARTER', 'QUERY', 'QUICK', 'RANGE', 'READ', 'READS', 'READ_ONLY', 'READ_WRITE', 'REAL', 'REBUILD', 'RECOVER', 'REDOFILE',
			'REDO_BUFFER_SIZE', 'REDUNDANT', 'REFERENCES', 'REGEXP', 'RELAY', 'RELAYLOG', 'RELAY_LOG_FILE', 'RELAY_LOG_POS', 'RELAY_THREAD', 'RELEASE', 'RELOAD', 'REMOVE',
			'RENAME', 'REORGANIZE', 'REPAIR', 'REPEAT', 'REPEATABLE', 'REPLACE', 'REPLICATION', 'REQUIRE', 'RESET', 'RESIGNAL', 'RESTORE', 'RESTRICT', 'RESUME', 'RETURN', 'RETURNS',
			'REVOKE', 'RIGHT', 'RLIKE', 'ROLLBACK', 'ROLLUP', 'ROUTINE', 'ROW 	ROWS', 'ROW_FORMAT', 'RTREE', 'SAVEPOINT', 'SCHEDULE', 'SCHEMA', 'SCHEMAS', 'SCHEMA_NAME',
			'SECOND', 'SECOND_MICROSECOND', 'SECURITY', 'SELECT', 'SENSITIVE', 'SEPARATOR', 'SERIAL', 'SERIALIZABLE', 'SERVER', 'SESSION', 'SET', 'SHARE', 'SHOW', 'SHUTDOWN',
			'SIGNAL', 'SIGNED', 'SIMPLE', 'SLAVE', 'SLOW', 'SMALLINT', 'SNAPSHOT', 'SOCKET', 'SOME', 'SONAME', 'SOUNDS', 'SOURCE', 'SPATIAL', 'SPECIFIC', 'SQL', 'SQLEXCEPTION',
			'SQLSTATE', 'SQLWARNING', 'SQL_BIG_RESULT', 'SQL_BUFFER_RESULT', 'SQL_CACHE', 'SQL_CALC_FOUND_ROWS', 'SQL_NO_CACHE', 'SQL_SMALL_RESULT', 'SQL_THREAD',
			'SQL_TSI_DAY', 'SQL_TSI_FRAC_SECOND', 'SQL_TSI_HOUR', 'SQL_TSI_MINUTE', 'SQL_TSI_MONTH', 'SQL_TSI_QUARTER', 'SQL_TSI_SECOND', 'SQL_TSI_WEEK', 'SQL_TSI_YEAR',
			'SSL', 'START', 'STARTING', 'STARTS', 'STATUS', 'STOP', 'STORAGE', 'STRAIGHT_JOIN', 'STRING', 'SUBCLASS_ORIGIN', 'SUBJECT', 'SUBPARTITION', 'SUBPARTITIONS', 'SUPER',
			'SUSPEND', 'SWAPS', 'SWITCHES', 'TABLE', 'TABLES', 'TABLESPACE', 'TABLE_CHECKSUM', 'TABLE_NAME', 'TEMPORARY', 'TEMPTABLE', 'TERMINATED', 'TEXT', 'THAN', 'THEN', 'TIME',
			'TIMESTAMP', 'TIMESTAMPADD', 'TIMESTAMPDIFF', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TO', 'TRAILING', 'TRANSACTION', 'TRIGGER', 'TRIGGERS', 'TRUE', 'TRUNCATE', 'TYPE',
			'TYPES', 'UNCOMMITTED', 'UNDEFINED', 'UNDO', 'UNDOFILE', 'UNDO_BUFFER_SIZE', 'UNICODE', 'UNINSTALL', 'UNION', 'UNIQUE', 'UNKNOWN', 'UNLOCK', 'UNSIGNED', 'UNTIL',
			'UPDATE', 'UPGRADE', 'USAGE', 'USE', 'USER', 'USER_RESOURCES', 'USE_FRM', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALUE', 'VALUES', 'VARBINARY', 'VARCHAR',
			'VARCHARACTER', 'VARIABLES', 'VARYING', 'VIEW', 'WAIT', 'WARNINGS', 'WEEK', 'WHEN', 'WHERE', 'WHILE', 'WITH', 'WORK', 'WRAPPER', 'WRITE', 'X509', 'XA', 'XML', 'XOR', 'YEAR',
			'YEAR_MONTH', 'ZEROFILL'
		);

		foreach ($columns as $column) {
			$upcase_column = strtoupper($column);

			if (in_array($upcase_column, $reserved)) {
				$checked_columns[] = '`' . $column . '`';
			} else {
				$checked_columns[] = $column;
			}
		}

		return $checked_columns;
	}
}
