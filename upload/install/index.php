<?php
// Error Reporting
error_reporting(E_ALL);

// Check if SSL
if ((isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) || $_SERVER['SERVER_PORT'] == 443) {
	$protocol = 'https://';
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	$protocol = 'https://';
} else {
	$protocol = 'http://';
}

define('HTTP_SERVER', $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/');
define('HTTP_OPENCART', $protocol . $_SERVER['HTTP_HOST'] . rtrim(rtrim(dirname($_SERVER['SCRIPT_NAME']), 'install'), '/.\\') . '/');

// DIR
define('DIR_APPLICATION', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/');
define('DIR_SYSTEM', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')) . '/system/');
define('DIR_OPENCART', str_replace('\\', '/', realpath(DIR_APPLICATION . '../')) . '/');
define('DIR_DATABASE', DIR_SYSTEM . 'database/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Url
$url = new Url(HTTP_SERVER);
$registry->set('url', $url);

// Request
$request = new Request();
$registry->set('request', $request);

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=UTF-8');
$registry->set('response', $response);

// Language
$language = new Language('english');
$language->load('en-gb');
$registry->set('language', $language);

// Document
$document = new Document();
$registry->set('document', $document);

// Session
$session = new Session();
$session->start();
$registry->set('session', $session);

// Upgrade
$upgrade = false;

if (file_exists('../config.php')) {
	if (filesize('../config.php') > 0) {
		$upgrade = true;

		$subject = file_get_contents(DIR_OPENCART . 'config.php');
		$pattern = "/define\s*?\('\s*?(DB_[A-Z]+)\s*?'\s*?,\s*?'(.*)'\s*?\)\s*?;/";

		if (preg_match_all($pattern, $subject, $matches)) {
			foreach ($matches[1] as $i => $var) {
				define($var, trim($matches[2][$i]));
			}
		}
	}
}

// Front Controller
$controller = new Front($registry);

// Router
if (isset($request->get['route'])) {
	$action = new Action($request->get['route']);
} elseif ($upgrade) {
	$action = new Action('upgrade');
} else {
	$action = new Action('step_1');
}

// Dispatch
$controller->dispatch($action, new Action('not_found'));

// Output
$response->output();
