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
		$setting_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE store_id = '0' ORDER BY store_id ASC");

		foreach ($setting_query->rows as $setting) {
			if (!$setting['serialized']) {
				$settings[$setting['key']] = $setting['value'];
			} else {
				$settings[$setting['key']] = unserialize($setting['value']);
			}
		}

		// Set defaults for new voucher min/max fields if not set
		if (empty($settings['config_voucher_min'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `serialized` = '0', `value` = '1', `key` = 'config_voucher_min', `group` = 'config', store_id = '0'");
		}

		if (empty($settings['config_voucher_max'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `serialized` = '0', `value` = '1000', `key` = 'config_voucher_max', `group` = 'config', store_id = '0'");
		}

		// Update the country table
		if (isset($table_old_data[DB_PREFIX . 'country']) && in_array('name', $table_old_data[DB_PREFIX . 'country'])) {
			// Country 'name' field moved to new country_description table. Need to loop through and move over
			$country_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country");

			foreach ($country_query->rows as $country) {
				$language_query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language`");

				foreach ($language_query->rows as $language) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "country_description` SET country_id = '" . (int)$country['country_id'] . "', language_id = '" . (int)$language['language_id'] . "', `name` = '" . $this->db->escape($country['name']) . "'");
				}
			}

			$this->db->query("ALTER TABLE `" . DB_PREFIX . "country` DROP `name`");
		}

		// Update the customer group table
		if (isset($table_old_data[DB_PREFIX . 'customer_group']) && in_array('name', $table_old_data[DB_PREFIX . 'customer_group'])) {
			// Customer Group 'name' field moved to new customer_group_description table. Need to loop through and move over
			$customer_group_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group");

			foreach ($customer_group_query->rows as $customer_group) {
				$language_query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language`");

				foreach ($language_query->rows as $language) {
					$this->db->query("REPLACE INTO " . DB_PREFIX . "customer_group_description SET customer_group_id = '" . (int)$customer_group['customer_group_id'] . "', language_id = '" . (int)$language['language_id'] . "', `name` = '" . $this->db->escape($customer_group['name']) . "'");
				}
			}

			$this->db->query("ALTER TABLE " . DB_PREFIX . "customer_group DROP `name`");
		}

		// Update the manufacturer table
		if (isset($table_old_data[DB_PREFIX . 'manufacturer']) && in_array('name', $table_old_data[DB_PREFIX . 'manufacturer'])) {
			// Manufacturer 'name' field moved to new manufacturer_description table. Need to loop through and move over
			$manufacturer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer");

			foreach ($manufacturer_query->rows as $manufacturer) {
				$language_query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language`");

				foreach ($language_query->rows as $language) {
					$this->db->query("REPLACE INTO " . DB_PREFIX . "manufacturer_description SET manufacturer_id = '" . (int)$manufacturer['manufacturer_id'] . "', language_id = '" . (int)$language['language_id'] . "', `name` = '" . $this->db->escape($manufacturer['name']) . "', description = '" . $this->db->escape($manufacturer['description']) . "'");
				}
			}

			$this->db->query("ALTER TABLE " . DB_PREFIX . "manufacturer DROP `name`");
		}

		// Update the news description table. News 'keyword' field is redundant.
		if (isset($table_old_data[DB_PREFIX . 'news_description']) && in_array('keyword', $table_old_data[DB_PREFIX . 'news_description'])) {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "news_description DROP keyword");
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

			$fh1 = fopen($catalog, 'r+');

			$catalog_data = file_get_contents($catalog);

			$catalog_string = implode('', file($catalog));

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

			$fh2 = fopen($admin, 'r+');

			$admin_data = file_get_contents($admin);

			$admin_string = implode('', file($admin));

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
	public function updateLayouts() {
		// Get stores
		$stores = array(0);

		$sql = "SELECT store_id FROM " . DB_PREFIX . "store";

		$query_store = $this->db->query($sql);

		foreach ($query_store->rows as $store) {
			$stores[] = $store['store_id'];
		}

		// Create News layout
		$sql = "SELECT layout_id FROM " . DB_PREFIX . "layout WHERE `name` LIKE 'News' LIMIT 0,1";

		$query_name = $this->db->query($sql);

		if ($query_name->num_rows == 0) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET `name` = 'News'");
		}

		// Add News routes
		$news_routes = array('information/news', 'information/news_list');

		foreach ($stores as $store_id) {
			foreach ($news_routes as $news_route) {
				$sql = "SELECT layout_id FROM " . DB_PREFIX . "layout_route WHERE store_id = '" . (int)$store_id . "' AND `route` LIKE '" . $news_route . "' LIMIT 0,1";

				$query = $this->db->query($sql);

				if ($query->num_rows == 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = (SELECT DISTINCT layout_id FROM " . DB_PREFIX . "layout WHERE `name` = 'News'), store_id = '" . (int)$store_id . "', `route` = '" . $news_route . "'");
				}
			}
		}

		// Create Special layout
		$sql = "SELECT layout_id FROM " . DB_PREFIX . "layout WHERE `name` LIKE 'Special' LIMIT 0,1";

		$query_name = $this->db->query($sql);

		if ($query_name->num_rows == 0) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET `name` = 'Special'");
		}

		// Add Special routes
		$special_routes = array('product/special');

		foreach ($stores as $store_id) {
			foreach ($special_routes as $special_route) {
				$sql = "SELECT layout_id FROM " . DB_PREFIX . "layout_route WHERE store_id = '" . (int)$store_id . "' AND `route` LIKE '" . $special_route . "' LIMIT 0,1";

				$query = $this->db->query($sql);

				if ($query->num_rows == 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = (SELECT DISTINCT layout_id FROM " . DB_PREFIX . "layout WHERE `name` = 'Special'), store_id = '" . (int)$store_id . "', `route` = '" . $special_route . "'");
				}
			}
		}
	}
}
