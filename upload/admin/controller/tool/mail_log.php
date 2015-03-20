<?php 
class ControllerToolMailLog extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('tool/mail_log');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_clear'] = $this->language->get('button_clear');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('tool/mail_log', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['clear'] = $this->url->link('tool/mail_log/clear', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$directory = DIR_SYSTEM . 'mails/';

		// Create directory if it does not exist.
		if (!is_dir($directory)) {
			mkdir(DIR_SYSTEM . 'mails', 0777);
		}

		$mail_file = DIR_SYSTEM . 'mails/mails.txt';

		// Create file if it does not exist.
		if (!file_exists($mail_file)) {
			$handle = fopen($mail_file, 'w+');

			fclose($handle);
		}

		if (file_exists($mail_file)) {
			$this->data['mail_log'] = file_get_contents($mail_file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['mail_log'] = '';
		}

		$this->template = 'tool/mail_log.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function clear() {
		$this->language->load('tool/mail_log');

		$file = DIR_SYSTEM . 'mails/mails.txt';

		$handle = fopen($file, 'w+');

		fclose($handle);

		$this->session->data['success'] = $this->language->get('text_success');

		$this->redirect($this->url->link('tool/mail_log', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
?>