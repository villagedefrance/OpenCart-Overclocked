<?php
class Dbmemory {
	private $db;

	private static $results = array();
	private static $escaped = array();

	public function __construct($db) {
		$this->db = $db;
	}

	public function query($sql) {
		$h = md5($sql);

		if (!isset(self::$results[$h])) {
			self::$results[$h] = $this->db->query($sql);
		}

		return self::$results[$h];
	}

	public function escape($string) {
		if (!isset(self::$escaped[$string])) {
			self::$escaped[$string] = $this->db->escape($string);
		}

		return self::$escaped[$string];
	}

	public function countAffected() {
		return $this->db->countAffected();
	}

	public function getLastId() {
		return $this->db->getLastId();
	}
}
