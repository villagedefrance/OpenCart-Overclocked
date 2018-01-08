<?php
class ControllerToolQuoteLog extends Controller {

	public function index() {
		$this->language->load('tool/quote_log');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_clear'] = $this->language->get('button_clear');
		$this->data['button_download'] = $this->language->get('button_download');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/quote_log', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['clear'] = $this->url->link('tool/quote_log/clear', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['download'] = $this->url->link('tool/quote_log/download', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		// Create directory if it does not exist
		$directory = DIR_SYSTEM . 'logs/';

		if (!is_dir($directory)) {
			mkdir(DIR_SYSTEM . 'logs', 0777);
		}

		// Create file if it does not exist
		$quote_file = DIR_LOGS . $this->config->get('config_quote_filename');

		if (!file_exists($quote_file)) {
			$handle = fopen($quote_file, 'w+');

			fclose($handle);
		}

		if (file_exists($quote_file)) {
			$this->data['quote_log'] = file_get_contents($quote_file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['quote_log'] = '';
		}

		clearstatcache();

		$this->template = 'tool/quote_log.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function download() {
		$file = DIR_LOGS . $this->config->get('config_quote_filename');

		clearstatcache();

		if (file_exists($file) && is_file($file)) {
			if (!headers_sent()) {
				if (filesize($file) > 0) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename=' . str_replace(' ', '_', $this->config->get('config_name')) . '_' . date('Y-m-d_H-i-s', time()) . '_quote.log');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file);
					exit();
				}

			} else {
				exit('Error: Headers already sent out!');
			}

		} else {
			$this->redirect($this->url->link('tool/quote_log', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function clear() {
		$this->language->load('tool/quote_log');

		$file = DIR_LOGS . $this->config->get('config_quote_filename');

		$handle = fopen($file, 'w+');

		fclose($handle);

		clearstatcache();

		$this->session->data['success'] = $this->language->get('text_success');

		$this->redirect($this->url->link('tool/quote_log', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
