<?php
class ControllerExtensionManager extends Controller {
	private $error = array();
	private $_name = 'manager';

	public function index() {
		$this->language->load('extension/manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['update'] = '';

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$button = $this->request->post['buttonForm'];

			switch($button) {
				case "download":
				$this->data['update'] = $this->redirect($this->url->link('extension/' . $this->_name . '/download', 'token=' . $this->session->data['token'], 'SSL'));
				break;
				case "install":
				$this->data['update'] = $this->redirect($this->url->link('extension/' . $this->_name . '/install', 'token=' . $this->session->data['token'], 'SSL'));
				break;
			}
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'  	=> $this->language->get('text_home'),
			'href' 		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text' 	=> $this->language->get('heading_title'),
			'href' 		=> $this->url->link('extension/manager', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['current_version'] = sprintf($this->language->get('text_version'), VERSION);
		$this->data['current_revision'] = sprintf($this->language->get('text_revision'), REVISION);

		$this->data['text_no_file'] = $this->language->get('text_no_file');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_update'] = $this->language->get('text_update');

		$this->data['button_download'] = $this->language->get('button_download');
		$this->data['button_install'] = $this->language->get('button_install');

		$checkurl = 'http://villagedefrance.net/updater/overclocked/revisions.txt';

		$checkhandler = curl_init($checkurl);
		curl_setopt($checkhandler, CURLOPT_RETURNTRANSFER, true);
		$resp = curl_exec($checkhandler);
		$check = curl_getinfo($checkhandler, CURLINFO_HTTP_CODE);

		if ($check == '200') { 
			$getRevisions = file_get_contents($checkurl);
		} else {
			$getRevisions = '';
		}

		if ($getRevisions !== '') {
			$revisionList = explode("\n", $getRevisions);

			foreach ($revisionList as $revision) {
				$version = substr($revision, 0, 5);
				$subversion = substr($revision, -8);

				if ($version > VERSION) {
					$this->data['version'] = sprintf($this->language->get('text_v_update'), $version);
					$this->data['ver_update'] = true;

					$this->data['revision'] = $this->language->get('text_no_revision');
				} else {
					$this->data['version'] = sprintf($this->language->get('text_v_no_update'), $version);
					$this->data['ver_update'] = false;

					if ($subversion > REVISION) {
						$this->data['revision'] = sprintf($this->language->get('text_r_update'), $subversion);
						$this->data['rev_update'] = true;
					} else {
						$this->data['revision'] = sprintf($this->language->get('text_r_no_update'), $subversion);
						$this->data['rev_update'] = false;
					}
				}

				$ver = max(array($version));
				$rev = max(array($subversion));
			}

		} else {
			$this->data['version'] = '';
			$this->data['revision'] = '';
			$this->data['ver_update'] = false;
			$this->data['rev_update'] = false;
			$ver = VERSION;
			$rev = REVISION;
		}

		curl_close($checkhandler);

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->session->data['success_download'])) {
			$this->data['success_download'] = $this->session->data['success_download'];

			unset($this->session->data['success_download']);
		} else {
			$this->data['success_download'] = '';
		}

		if (isset($this->session->data['success_install'])) {
			$this->data['success_install'] = $this->session->data['success_install'];

			unset($this->session->data['success_install']);
		} else {
			$this->data['success_install'] = '';
		}

		$zipfile = DIR_DOWNLOAD . 'updates/update-' . $ver . '-' . $rev . '.zip';

		if (file_exists($zipfile) && is_file($zipfile)) {
			$this->data['ready'] = true;
		} else {
			$this->data['ready'] = false;
		}

		$this->data['button_refresh'] = $this->language->get('button_refresh');

		$this->data['refresh'] = $this->url->link('extension/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'extension/manager.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	public function download() {
		$this->language->load('extension/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		// Check File
		$checkurl = 'http://villagedefrance.net/updater/overclocked/revisions.txt';

		$checkhandler = curl_init($checkurl);
		curl_setopt($checkhandler, CURLOPT_RETURNTRANSFER, true);
		$resp = curl_exec($checkhandler);
		$check = curl_getinfo($checkhandler, CURLINFO_HTTP_CODE);

		if ($check == '200') { 
			$getRevisions = file_get_contents($checkurl);
		} else {
			$getRevisions = '';
		}

		if ($getRevisions !== '') {
			$revisionList = explode("\n", $getRevisions);

			foreach ($revisionList as $revision) {
				$version = substr($revision, 0, 5);
				$subversion = substr($revision, -8);

				$ver = max(array($version));
				$rev = max(array($subversion));
			}
		}

		curl_close($checkhandler);

		// Download File
		$url = 'http://villagedefrance.net/updater/overclocked/update-' . $ver . '-' . $rev . '.zip';

		if (!is_dir(DIR_DOWNLOAD . 'updates/')) {
			mkdir(DIR_DOWNLOAD . 'updates/', 0777);
		}

		$zipfile = DIR_DOWNLOAD . 'updates/update-' . $ver . '-' . $rev . '.zip';

		$zipsource = fopen($zipfile, 'w');

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_UPLOAD, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_FILE, $zipsource);

		$response = curl_exec($ch);

		if ($response) {
			curl_close($ch);

			$this->session->data['success_download'] = $this->language->get('success_download');

			$this->redirect($this->url->link('extension/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));

		} else {
			$this->error['warning'] = $this->language->get('error_install') . curl_error($ch);

			curl_close($ch);

			$this->redirect($this->url->link('extension/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function install() {
		$this->language->load('extension/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		// Check File
		$checkurl = 'http://villagedefrance.net/updater/overclocked/revisions.txt';

		$checkhandler = curl_init($checkurl);
		curl_setopt($checkhandler, CURLOPT_RETURNTRANSFER, true);
		$resp = curl_exec($checkhandler);
		$check = curl_getinfo($checkhandler, CURLINFO_HTTP_CODE);

		if ($check == '200') { 
			$getRevisions = file_get_contents($checkurl);
		} else {
			$getRevisions = '';
		}

		if ($getRevisions !== '') {
			$revisionList = explode("\n", $getRevisions);

			foreach ($revisionList as $revision) {
				$version = substr($revision, 0, 5);
				$subversion = substr($revision, -8);

				$ver = max(array($version));
				$rev = max(array($subversion));
			}
		}

		curl_close($checkhandler);

		// Install File
		$zip = new ZipArchive;

		if (file_exists(DIR_DOWNLOAD . 'updates/update-' . $ver . '-' . $rev . '.zip') && is_file(DIR_DOWNLOAD . 'updates/update-' . $ver . '-' . $rev . '.zip')) {
			$zipfile = DIR_DOWNLOAD . 'updates/update-' . $ver . '-' . $rev . '.zip';

			$open = $zip->open($zipfile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

			if ($open === true) {
				$path_files = '../';

				$zip->extractTo($path_files);
				$zip->close();

				$this->session->data['success_install'] = $this->language->get('success_install');

				$this->redirect($this->url->link('extension/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));

			} else {
				$this->error['warning'] = $this->language->get('error_install');
		
				$this->redirect($this->url->link('extension/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			}

		} else {
			$zipfile = '';

			$this->error['warning'] = $this->language->get('error_install');
		
			$this->redirect($this->url->link('extension/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>