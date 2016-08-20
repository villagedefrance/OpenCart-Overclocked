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
				$url .= '&amp;' . http_build_query($args);
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
}

?>