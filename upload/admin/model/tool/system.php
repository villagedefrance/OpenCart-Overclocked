<?php
class ModelToolSystem extends Model {

	public function deleteDirectory($dir) {
		if (!file_exists($dir)) {
			return true;
		}

		if (!is_dir($dir) || is_link($dir)) {
			return unlink($dir);
		}

		clearstatcache();

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

	public function setupSeo() {
		if (!file_exists('../.htaccess')) {
			if (file_exists('../.htaccess.txt') && is_writable('../.htaccess.txt')) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `key` = 'config_seo_url'");

				$file = fopen('../.htaccess.txt', 'a');

				$data = file_get_contents('../.htaccess.txt');

				$root = rtrim(HTTP_SERVER, '/');

				$folder = substr(strrchr($root, '/'), 1);

				$path = rtrim(rtrim(dirname($_SERVER['SCRIPT_NAME']), ''), '/' . $folder . '.\\');

				if (strlen($path) > 1) {
					$path .= '/';
				}

				if (!$path) {
					$path = '/';
				}

				$data = str_replace('RewriteBase /', 'RewriteBase ' . $path, $data);

				file_put_contents('../.htaccess.txt', $data);

				fclose($file);

				clearstatcache();

				rename('../.htaccess.txt', '../.htaccess');

				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `group` = 'config', `key` = 'config_seo_url', `value` = '1'");
			}
		}

		$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '1' WHERE `key` = 'config_seo_url'");
	}

	// Token generator
	public function token($length = 32) {
		$string = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-.+_=');

		$token = '';

		for ($i = 0; $i < $length; $i++) {
			$token .= $string[mt_rand(0, strlen($string) - 1)];
		}

		return $token;
	}
}
?>
