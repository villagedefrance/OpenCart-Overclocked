<?php
class DB {
	private $driver;

	public function __construct($driver, $hostname, $username, $password, $database, $port = null) {
		$file = DIR_DATABASE . $driver . '.php';

		if (file_exists($file)) {
			require_once($file);

			$class = 'DB' . $driver;

			$this->driver = new $class($hostname, $username, $password, $database, $port);
		} else {
			throw new \Exception('Error: Could not load database driver ' . $driver . '!');
		}
	}

	public function query($sql, $params = array()) {
		return $this->driver->query($sql, $params);
	}

	public function escape($value) {
		return $this->driver->escape($value);
	}

	public function countAffected() {
		return $this->driver->countAffected();
	}

	public function getLastId() {
		return $this->driver->getLastId();
	}

	public function connected() {
		return $this->driver->isConnected();
	}
}
