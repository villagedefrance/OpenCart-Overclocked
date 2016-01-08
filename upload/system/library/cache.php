<?php
class Cache {
	public function get($key) {
		$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

		if ($files) {
			$file_handle = fopen($files[0], 'r');

			flock($file_handle, LOCK_SH);
			$data = fread($file_handle, filesize($files[0]));
			flock($file_handle, LOCK_UN);
			fclose($file_handle);

			return unserialize($data);
		}

		return false;
	}

	public function set($key, $value) {
		$file = DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + 3600);

		$file_handle = fopen($file, 'w');

		flock($file_handle, LOCK_EX);
		fwrite($file_handle, serialize($value));
		fflush($file_handle);
		flock($file_handle, LOCK_UN);
		fclose($file_handle);
	}

	public function delete($key) {
		$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					unlink($file);
				}
			}
		}
	}
}
?>