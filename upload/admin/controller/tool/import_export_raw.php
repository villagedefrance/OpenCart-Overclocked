<?php
class ControllerToolImportExportRaw extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('tool/import_export_raw');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addStyle('view/javascript/jquery/sfi/css/jquery.simplefileinput.css');

		$this->load->model('tool/import_export_raw');

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			if (is_uploaded_file($this->request->files['csv_import']['tmp_name'])) {
				$content = file_get_contents($this->request->files['csv_import']['tmp_name']);

				$filename = $this->request->files['csv_import']['tmp_name'];
			} else {
				$content = false;
			}

			if ($content) {
				$this->model_tool_import_export_raw->csvImportRaw($filename);

				$this->session->data['success'] = $this->language->get('text_success');

				$this->redirect($this->url->link('tool/import_export_raw', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->error['warning'] = $this->language->get('error_empty');
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['heading_import'] = $this->language->get('heading_import');
		$this->data['heading_export'] = $this->language->get('heading_export');
		$this->data['heading_csv'] = $this->language->get('heading_csv');

		$this->data['text_import'] = $this->language->get('text_import');
		$this->data['text_spreadsheet'] = $this->language->get('text_spreadsheet');
		$this->data['text_charset'] = $this->language->get('text_charset');
		$this->data['text_separator'] = $this->language->get('text_separator');
		$this->data['text_delimiter'] = $this->language->get('text_delimiter');
		$this->data['text_escaped'] = $this->language->get('text_escaped');
		$this->data['text_ending'] = $this->language->get('text_ending');

		$this->data['entry_import'] = $this->language->get('entry_import');
		$this->data['entry_export'] = $this->language->get('entry_export');

		$this->data['help_function'] = $this->language->get('help_function');
		$this->data['help_caution'] = $this->language->get('help_caution');
		$this->data['help_warning'] = $this->language->get('help_warning');

		$this->data['button_import'] = $this->language->get('button_import');
		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

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
			'href'		=> $this->url->link('tool/import_export_raw', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['csv_import'] = $this->url->link('tool/import_export_raw', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['csv_export'] = $this->url->link('tool/import_export_raw/export', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['refresh'] = $this->url->link('tool/import_export_raw', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['tables'] = $this->model_tool_import_export_raw->getTables();

		$this->template = 'tool/export_advanced.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export() {
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate() && isset($this->request->post['csv_export'])) {
			$ReflectionResponse = new ReflectionClass($this->response);

			if ($ReflectionResponse->getMethod('addheader')->getNumberOfParameters() == 2) {
				$this->response->addheader('Pragma', 'public');
				$this->response->addheader('Expires', '0');
				$this->response->addheader('Content-Description', 'File Transfer');
				$this->response->addheader('Content-type', 'text/octect-stream');
				$this->response->addheader('Content-Disposition', 'attachment;filename="' . $this->request->post['csv_export'] . '".csv');
				$this->response->addheader('Content-Transfer-Encoding', 'binary');
				$this->response->addheader('Cache-Control', 'must-revalidate, post-check=0,pre-check=0');
			} else {
				$this->response->addheader('Pragma: public');
				$this->response->addheader('Expires: 0');
				$this->response->addheader('Content-Description: File Transfer');
				$this->response->addheader('Content-type:text/octect-stream');
				$this->response->addheader('Content-Disposition:attachment;filename="' . $this->request->post['csv_export'] . '".csv');
				$this->response->addheader('Content-Transfer-Encoding: binary');
				$this->response->addheader('Cache-Control: must-revalidate, post-check=0,pre-check=0');
			}

			$this->load->model('tool/import_export_raw');

			$this->response->setOutput($this->model_tool_import_export_raw->csvExportRaw($this->request->post['csv_export']));

		} else {
			$this->language->load('tool/import_export_raw');

			$this->session->data['error'] = $this->language->get('error_export');

			$this->redirect($this->url->link('tool/import_export_raw', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/import_export_raw')) {
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