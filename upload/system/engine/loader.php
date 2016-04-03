<?php
final class Loader {
	protected $registry;

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

	public function model($model) {
		// Sanitize the call
		$model = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$model);

		$file = DIR_APPLICATION . 'model/' . $model . '.php';

		$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);

		if (is_file($file)) {
			include_once($file);
			$this->registry->set('model_' . str_replace('/', '_', $model), new $class($this->registry));
		} else {
			throw new \Exception('Error: Could not load model ' . $model . '!');
		}
	}

	public function library($library) {
		// Sanitize the call
		$library = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$library);

		$file = DIR_SYSTEM . 'library/' . $library . '.php';

		if (is_file($file)) {
			include_once($file);
		} else {
			throw new \Exception('Error: Could not load library ' . $library . '!');
		}
	}

	public function helper($helper) {
		// Sanitize the call
		$helper = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$helper);

		$file = DIR_SYSTEM . 'helper/' . $helper . '.php';

		if (is_file($file)) {
			include_once($file);
		} else {
			throw new \Exception('Error: Could not load helper ' . $helper . '!');
		}
	}

	public function database($driver, $hostname, $username, $password, $database, $port = null) {
		// Sanitize the call
		$driver = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$driver);

		$file = DIR_SYSTEM . 'database/' . $driver . '.php';

		$class = 'Database' . preg_replace('/[^a-zA-Z0-9]/', '', $driver);

		if (is_file($file)) {
			include_once($file);
			$this->registry->set(str_replace('/', '_', $driver), new $class($hostname, $username, $password, $database, $port));
		} else {
			throw new \Exception('Error: Could not load database ' . $driver . '!');
		}
	}

	public function config($config) {
		$this->config->load($config);
	}

	public function language($language) {
		return $this->language->load($language);
	}
}
?>