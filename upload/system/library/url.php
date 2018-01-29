<?php
class Url {
	private $url;
	private $ssl;
	private $rewrite = array();

	public function __construct($url, $ssl = '') {
		$this->url = $url;
		$this->ssl = $ssl;
	}

	public function addRewrite($rewrite) {
		$this->rewrite[] = $rewrite;
	}

	public function link($route, $args = '', $connection = 'NONSSL') {
		if ($connection == 'NONSSL') {
			$url = $this->url . 'index.php?route=' . $route;
		} else {
			$url = $this->ssl . 'index.php?route=' . $route;
		}

		if ($args) {
			if (is_array($args)) {
				$url .= '&amp;' . http_build_query($args, '', '&amp;');
			} else {
				$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
			}
		}

		foreach ($this->rewrite as $rewrite) {
			$url = $rewrite->rewrite($url);
		}

		return $url;
	}

	public function getHttpResponseCode($url) {
		$headers = get_headers($url);

		if ($headers) {
			return substr($headers[0], 9, 3);
		} else {
			return '404';
		}
	}

	public function isLocal() {
		$local_address = false;
		$local_name = false;
		$local_host = false;

		if (isset($_SERVER['SERVER_ADDR'])) {
			$local_address = ($_SERVER['SERVER_ADDR'] == '::1' || $_SERVER['SERVER_ADDR'] == '127.0.0.1') ? true : false;
		}

		if (isset($_SERVER['SERVER_NAME'])) {
			$local_name = ($_SERVER['SERVER_NAME'] == 'localhost') ? true : false;
		}

		if (isset($_SERVER['HTTP_HOST'])) {
			$local_host = ($_SERVER['HTTP_HOST'] == 'localhost') ? true : false;
		}

		if ($local_address || $local_name || $local_host) {
			return true;
		} else {
			return false;
		}
	}
}
