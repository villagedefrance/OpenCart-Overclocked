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
		if (file_exists('../.htaccess')) {
			return;
		} else {
			if (function_exists('apache_get_modules')) {
				$modules = apache_get_modules();

				$mod_rewrite = in_array('mod_rewrite', $modules);
			} else {
				$mod_rewrite = (getenv('HTTP_MOD_REWRITE') == 'On') ? true : false;
			}

			if ($mod_rewrite && file_exists('../.htaccess.txt')) {
				chmod('../.htaccess.txt', 0777);

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
			}
		}

		clearstatcache();
	}

	// Token generator
	public function token($length = 32) {
		$string = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._=');

		$token = '';

		for ($i = 0; $i < $length; $i++) {
			$token .= $string[mt_rand(0, strlen($string) - 1)];
		}

		return $token;
	}
}

?>