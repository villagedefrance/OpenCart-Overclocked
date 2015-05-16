<?php
class ModelToolSystem extends Model {

	public function deleteDirectory($dir) {
		if (!file_exists($dir)) {
			return true;
		}

		if (!is_dir($dir) || is_link($dir)) {
			return unlink($dir);
		}

		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') {
				continue;
			}

			if (!$this->deleteDirectory($dir . "/" . $item)) {
				chmod($dir . "/" . $item, 0777);

				if (!$this->deleteDirectory($dir . "/" . $item)) {
					return false;
				}
			}
		}

		return rmdir($dir);
	}

	public function setupRewrite() {
		if (function_exists('apache_get_modules')) {
			$modules = apache_get_modules();

			$mod_rewrite = in_array('mod_rewrite', $modules);
		} else {
			$mod_rewrite = (getenv('HTTP_MOD_REWRITE') == 'On') ? true : false;
		}

		$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '0' WHERE `key` = 'config_seo_url'");

		if ($mod_rewrite && file_exists('../.htaccess.txt')) {
			$file = fopen('../.htaccess.txt', 'a');

			if ($file) {
				$path = rtrim(rtrim(dirname($_SERVER['SCRIPT_NAME']), ''), '/.\\');

				if (strlen($path) > 1) {
					$path .= '/';
				}

				if (!$path) {
					$path = '/';
				}

				fwrite($file, 'RewriteBase ' . $path);

				fclose($file);

				rename('../.htaccess.txt', '../.htaccess');

				$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '1' WHERE `key` = 'config_seo_url'");
			}
		}
	}
}
?>