<?php
class ModelInstall extends Model {

	public function database($data) {
		$db = new DB($data['db_driver'], $data['db_hostname'], $data['db_username'], $data['db_password'], $data['db_database']);

		if (isset($data['demo_data'])) {
			$file = DIR_APPLICATION . 'opencart-clean.sql';

			if (!file_exists($file)) {
				exit('Could not load sql file: ' . $file);
			}
		} else {
			$file = DIR_APPLICATION . 'opencart.sql';

			if (!file_exists($file)) {
				exit('Could not load sql file: ' . $file);
			}
		}

		clearstatcache();

		$lines = file($file);

		if ($lines) {
			$sql = '';

			foreach ($lines as $line) {
				if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
					$sql .= $line;

					if (preg_match('/;\s*$/', $line)) {
						$sql = str_replace("DROP TABLE IF EXISTS `oc_", "DROP TABLE IF EXISTS `" . $data['db_prefix'], $sql);
						$sql = str_replace("CREATE TABLE `oc_", "CREATE TABLE `" . $data['db_prefix'], $sql);
						$sql = str_replace("INSERT INTO `oc_", "INSERT INTO `" . $data['db_prefix'], $sql);

						$db->query($sql);

						$sql = '';
					}
				}
			}

			$db->query("SET CHARACTER SET utf8");

			$db->query("SET @@session.sql_mode = 'MYSQL40'");

			$db->query("DELETE FROM `" . $data['db_prefix'] . "user` WHERE user_id = '1'");
			$db->query("INSERT INTO `" . $data['db_prefix'] . "user` SET user_id = '1', user_group_id = '1', username = '" . $db->escape($data['username']) . "', salt = '" . $db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', status = '1', email = '" . $db->escape($data['email']) . "', date_added = NOW()");

			$db->query("DELETE FROM " . $data['db_prefix'] . "setting WHERE `key` = 'config_email'");
			$db->query("INSERT INTO " . $data['db_prefix'] . "setting SET `group` = 'config', `key` = 'config_email', `value` = '" . $db->escape($data['email']) . "'");

			$db->query("DELETE FROM " . $data['db_prefix'] . "setting WHERE `key` = 'config_url'");
			$db->query("INSERT INTO " . $data['db_prefix'] . "setting SET `group` = 'config', `key` = 'config_url', `value` = '" . $db->escape(HTTP_OPENCART) . "'");

			$db->query("DELETE FROM " . $data['db_prefix'] . "setting WHERE `key` = 'config_encryption'");
			$db->query("INSERT INTO " . $data['db_prefix'] . "setting SET `group` = 'config', `key` = 'config_encryption', `value` = '" . $db->escape(hash_rand('md5')) . "'");

			$db->query("DELETE FROM " . $data['db_prefix'] . "setting WHERE `key` = 'config_maintenance'");
			$db->query("INSERT INTO " . $data['db_prefix'] . "setting SET `group` = 'config', `key` = 'config_maintenance', `value` = '" . (isset($data['maintenance']) ? 1 : 0) . "'");

			$db->query("UPDATE " . $data['db_prefix'] . "product SET viewed = '0'");
		}

		if (isset($data['rewrite'])) {
			if (function_exists('apache_get_modules')) {
				$modules = apache_get_modules();

				$mod_rewrite = in_array('mod_rewrite', $modules);
			} else {
				$mod_rewrite = (getenv('HTTP_MOD_REWRITE') == 'On') ? true : false;
			}

			if ($mod_rewrite && file_exists('../.htaccess.txt') && is_writable('../.htaccess.txt')) {
				$file = fopen('../.htaccess.txt', 'a');

				$document = file_get_contents('../.htaccess.txt');

				$root = rtrim(HTTP_SERVER, '/');

				$folder = substr(strrchr($root, '/'), 1);

				$path = rtrim(rtrim(dirname($_SERVER['SCRIPT_NAME']), ''), '/' . $folder . '.\\');

				if (strlen($path) > 1) {
					$path .= '/';
				}

				if (!$path) {
					$path = '/';
				}

				$document = str_replace('RewriteBase /', 'RewriteBase ' . $path, $document);

				file_put_contents('../.htaccess.txt', $document);

				fflush($file);

				fclose($file);

				rename('../.htaccess.txt', '../.htaccess');

				$db->query("UPDATE " . $data['db_prefix'] . "setting SET `value` = '" . (isset($data['rewrite']) ? 1 : 0) . "' WHERE `group` = 'config' AND `key` = 'config_seo_url'");

				clearstatcache();
			}
		}
	}
}
?>