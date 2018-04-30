<?php
class ControllerToolSitemap extends Controller {
	private $error = array();
	private $_name = 'sitemap';

	public function index() {
		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_sitemaps'] = $this->language->get('text_sitemaps');
		$this->data['text_submit'] = $this->language->get('text_submit');

		$this->data['text_success_text'] = $this->language->get('text_success_text');
		$this->data['text_success_xml'] = $this->language->get('text_success_xml');
		$this->data['text_success_gzip'] = $this->language->get('text_success_gzip');

		$this->data['text_head_type'] = $this->language->get('text_head_type');
		$this->data['text_head_name'] = $this->language->get('text_head_name');
		$this->data['text_head_size'] = $this->language->get('text_head_size');
		$this->data['text_head_date'] = $this->language->get('text_head_date');
		$this->data['text_head_action'] = $this->language->get('text_head_action');

		$this->data['button_check'] = $this->language->get('button_check');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_close'] = $this->language->get('button_close');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		// Master Text
		if (isset($this->session->data['success_text'])) {
			$this->data['success_text'] = $this->session->data['success_text'];

			unset($this->session->data['success_text']);
		} else {
			$this->data['success_text'] = '';
		}

		// Master XML
		if (isset($this->session->data['success_xml'])) {
			$this->data['success_xml'] = $this->session->data['success_xml'];

			unset($this->session->data['success_xml']);
		} else {
			$this->data['success_xml'] = '';
		}

		// Master XML GZ
		if (isset($this->session->data['success_gzip'])) {
			$this->data['success_gzip'] = $this->session->data['success_gzip'];

			unset($this->session->data['success_gzip']);
		} else {
			$this->data['success_gzip'] = '';
		}

		if (isset($this->session->data['output'])) {
			$this->data['output'] = $this->session->data['output'];

			unset($this->session->data['output']);
		} else {
			$this->data['output'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['refresh'] = $this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['close'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['generate'] = $this->language->get('text_generate');
		$this->data['download'] = $this->language->get('text_download');

		$this->data['sitemap'] = '';

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$button = $this->request->post['buttonForm'];

			switch ($button) {
				case "gentext": $this->data['sitemap'] = $this->redirect($this->url->link('tool/' . $this->_name . '/generateText', 'token=' . $this->session->data['token'], 'SSL')); break;
				case "genxml": $this->data['sitemap'] = $this->redirect($this->url->link('tool/' . $this->_name . '/generateXml', 'token=' . $this->session->data['token'], 'SSL')); break;
				case "gengzip": $this->data['sitemap'] = $this->redirect($this->url->link('tool/' . $this->_name . '/generateGzip', 'token=' . $this->session->data['token'], 'SSL')); break;
				case "loadtext": $this->data['sitemap'] = $this->redirect($this->url->link('tool/' . $this->_name . '/downloadText', 'token=' . $this->session->data['token'], 'SSL')); break;
				case "loadxml": $this->data['sitemap'] = $this->redirect($this->url->link('tool/' . $this->_name . '/downloadXml', 'token=' . $this->session->data['token'], 'SSL')); break;
				case "loadgzip": $this->data['sitemap'] = $this->redirect($this->url->link('tool/' . $this->_name . '/downloadGzip', 'token=' . $this->session->data['token'], 'SSL')); break;
			}
		}

		$this->data['googleweb'] = 'https://www.google.com/webmasters/tools/home';
		$this->data['bingweb'] = 'https://ssl.bing.com/webmaster/home/mysites';
		$this->data['yandexweb'] = 'http://webmaster.yandex.com/sites/';
		$this->data['baiduweb'] = 'http://zhanzhang.baidu.com/sitemap/index';

		$this->data['text_create'] = $this->language->get('text_create');
		$this->data['text_publish'] = $this->language->get('text_publish');

		$hostcheck = $this->request->server['HTTP_HOST'];

		if ($hostcheck == 'localhost') {
			$this->data['localhost'] = true;
		} else {
			$this->data['localhost'] = false;
		}

		// Master Text Sitemap
		if (file_exists("../sitemap.txt") && is_file("../sitemap.txt")) {
			$getsitemaptext = file_get_contents("../sitemap.txt");

			$this->data['sitemaptext'] = $getsitemaptext;

			$filetext = "../sitemap.txt";

			$size = filesize($filetext);

			$i = 0;

			$suffix = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');

			while (($size / 1024) > 1) {
				$size = $size / 1024;
				$i++;
			}

			$this->data['text_text'] = $this->language->get('text_text');
			$this->data['text_nametext'] = $this->language->get('text_nametext');
			$this->data['text_sizetext'] = round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i];
			$this->data['text_datetext'] = sprintf($this->language->get('text_datetext'), date("d-m-Y H:i:s", filemtime($filetext)));
			$this->data['checktext'] = HTTP_CATALOG . "sitemap.txt";
		} else {
			$this->data['sitemaptext'] = '';
			$this->data['text_text'] = $this->language->get('text_text');
			$this->data['text_notext'] = $this->language->get('text_notext');
		}

		// Master XML Sitemap
		if (file_exists("../sitemap.xml") && is_file("../sitemap.xml")) {
			$getsitemapxml = file_get_contents("../sitemap.xml");

			$this->data['sitemapxml'] = $getsitemapxml;

			$filexml = "../sitemap.xml";

			$size = filesize($filexml);

			$i = 0;

			$suffix = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

			while (($size / 1024) > 1) {
				$size = $size / 1024;
				$i++;
			}

			$this->data['text_xml'] = $this->language->get('text_xml');
			$this->data['text_namexml'] = $this->language->get('text_namexml');
			$this->data['text_sizexml'] = round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i];
			$this->data['text_datexml'] = sprintf($this->language->get('text_datexml'), date("d-m-Y H:i:s", filemtime($filexml)));
		} else {
			$this->data['sitemapxml'] = '';
			$this->data['text_xml'] = $this->language->get('text_xml');
			$this->data['text_noxml'] = $this->language->get('text_noxml');
		}

		// Master XML GZ Sitemap
		if (file_exists("../sitemap.xml.gz") && is_file("../sitemap.xml.gz")) {
			$getsitemapgzip = file_get_contents("../sitemap.xml.gz");

			$this->data['sitemapgzip'] = $getsitemapgzip;

			$FileRead = "../sitemap.xml.gz";
			$HandleRead = gzopen($FileRead, "rb");
			gzclose($HandleRead);

			$size = filesize("../sitemap.xml.gz");

			$i = 0;

			$suffix = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

			while (($size / 1024) > 1) {
				$size = $size / 1024;
				$i++;
			}

			$this->data['text_gzip'] = $this->language->get('text_gzip');
			$this->data['text_namegzip'] = $this->language->get('text_namegzip');
			$this->data['text_sizegzip'] = round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i];
			$this->data['text_dategzip'] = sprintf($this->language->get('text_dategzip'), date("d-m-Y H:i:s", filemtime($FileRead)));
		} else {
			$this->data['sitemapgzip'] = '';
			$this->data['text_gzip'] = $this->language->get('text_gzip');
			$this->data['text_nogzip'] = $this->language->get('text_nogzip');
		}

		clearstatcache();

		$this->template = 'tool/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	// Master Text Sitemap
	public function generateText() {
		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/' . $this->_name);

		$this->session->data['output'] = $this->model_tool_sitemap->generateText();

		$this->session->data['success_text'] = $this->language->get('text_success_text');

		$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}

	// Master XML Sitemap
	public function generateXml() {

		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/' . $this->_name);

		$this->session->data['output'] = $this->model_tool_sitemap->generateXml();

		$this->session->data['success_xml'] = $this->language->get('text_success_xml');

		$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}

	// Master XML GZ Sitemap
	public function generateGzip() {
		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/' . $this->_name);

		$this->session->data['output'] = $this->model_tool_sitemap->generateGzip();

		$this->session->data['success_gzip'] = $this->language->get('text_success_gzip');

		$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}

	// Master Text Sitemap
	public function downloadText() {
		if (file_exists("../sitemap.txt") && is_file("../sitemap.txt")) {
			$file = "../sitemap.txt";

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename=sitemap.txt');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file, 'rb');
					exit();

				} else {
					exit('Error: Could not find file ' . $file . '!');
				}

			} else {
				exit('Error: Headers already sent out!');
			}

			clearstatcache();
		} else {
			$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	// Master XML Sitemap
	public function downloadXml() {
		if (file_exists("../sitemap.xml") && is_file("../sitemap.xml")) {
			$file = "../sitemap.xml";

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename=sitemap.xml');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file, 'rb');
					exit();

				} else {
					exit('Error: Could not find file ' . $file . '!');
				}

				clearstatcache();
			} else {
				exit('Error: Headers already sent out!');
			}

		} else {
			$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	// Master XML GZ Sitemap
	public function downloadGzip() {
		if (file_exists("../sitemap.xml.gz") && is_file("../sitemap.xml.gz")) {
			$file = "../sitemap.xml.gz";

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename=sitemap.xml.gz');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file, 'rb');
					exit();

				} else {
					exit('Error: Could not find file ' . $file . '!');
				}

				clearstatcache();
			} else {
				exit('Error: Headers already sent out!');
			}

		} else {
			$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'tool/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
