<?php
final class Action {
	protected $route;
	protected $file;
	protected $class;
	protected $method;
	protected $args = array();

	public function __construct($route, $args = array()) {
		$path = '';

		$this->route = str_replace('../', '', (string) $route);

		$parts = explode('/', $this->route);

		foreach ($parts as $part) {
			$path .= $part;

			if (is_dir(DIR_APPLICATION . 'controller/' . $path)) {
				$path .= '/';
				array_shift($parts);
				continue;
			}

			$file = DIR_APPLICATION . 'controller/' . str_replace(array('../', '..\\', '..'), '', $path) . '.php';

			if (is_file($file)) {
				$this->file = $file;
				$this->class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $path);
				array_shift($parts);
				break;
			}
		}

		if ($args) {
			$this->args = $args;
		}

		$method = array_shift($parts);

		if ($method) {
			$this->method = $method;
		} else {
			$this->method = 'index';
		}
	}

	public function getRoute() {
		return $this->route;
	}

	public function getFile() {
		return $this->file;
	}

	public function getClass() {
		return $this->class;
	}

	public function getMethod() {
		return $this->method;
	}

	public function getArgs() {
		return $this->args;
	}
}
