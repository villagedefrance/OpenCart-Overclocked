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

	public function model($route) {
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		$model_name = 'model_' . str_replace(array('/', '-', '.'), array('_', '', ''), $route);

		if ($this->registry->get($model_name) !== null) {
			return $this->registry->get($model_name);
		}

		$file  = DIR_APPLICATION . 'model/' . $route . '.php';

		if (!is_file($file)) {
			throw new RuntimeException('Error: Could not load model file ' . $file . '!');
		}

		require_once($file);

		$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $route);

		$model = new $class($this->registry);
		$proxy = new Proxy($model, $route, $this->registry->get('event'));

		$this->registry->set($model_name, $proxy);

		return $proxy;
	}

	public function library($route) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);

		$file = DIR_SYSTEM . 'library/' . $route . '.php';

		if (is_file($file)) {
			include_once($file);
		} else {
			throw new \Exception('Error: Could not load library ' . $route . '!');
		}
	}

	public function helper($route) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);

		$file = DIR_SYSTEM . 'helper/' . $route . '.php';

		if (is_file($file)) {
			include_once($file);
		} else {
			throw new \Exception('Error: Could not load helper ' . $route . '!');
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

	public function config($route) {
		$this->config->load($route);
	}

	public function language($route) {
		return $this->language->load($route);
	}
}
