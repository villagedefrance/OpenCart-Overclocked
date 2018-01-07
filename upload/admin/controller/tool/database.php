<?php
class ControllerToolDatabase extends Controller {
	private $error = array();
	private $_name = 'database';

	public function index() {
		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['database'] = '';

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$button = $this->request->post['buttonForm'];

			switch ($button) {
				case "optimize":
				$this->data['database'] = $this->redirect($this->url->link('tool/' . $this->_name . '/optimize', 'token=' . $this->session->data['token'], 'SSL')); break;
				case "repair":
				$this->data['database'] = $this->redirect($this->url->link('tool/' . $this->_name . '/repair', 'token=' . $this->session->data['token'], 'SSL')); break;
				case "innodb":
				$this->data['database'] = $this->redirect($this->url->link('tool/' . $this->_name . '/innodb', 'token=' . $this->session->data['token'], 'SSL')); break;
				case "myisam":
				$this->data['database'] = $this->redirect($this->url->link('tool/' . $this->_name . '/myisam', 'token=' . $this->session->data['token'], 'SSL')); break;
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
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_close'] = $this->language->get('button_close');

		$this->data['refresh'] = $this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['close'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		// Optimize & Repair
		$this->load->model('tool/database');

		$this->data['tables'] = $this->model_tool_database->getTables();

		// Engines
		$engines = $this->model_tool_database->getEngines();

		foreach ($engines as $engine) {
			if ($engine == 'InnoDB') {
				$this->data['engine'] = true;
			} else {
				$this->data['engine'] = false;
			}
		}

		$this->data['text_optimize'] = $this->language->get('text_optimize');
		$this->data['text_repair'] = $this->language->get('text_repair');
		$this->data['text_engine'] = $this->language->get('text_engine');
		$this->data['text_table_engine'] = $this->language->get('text_table_engine');

		$this->data['text_help_optimize'] = $this->language->get('text_help_optimize');
		$this->data['text_help_repair'] = $this->language->get('text_help_repair');
		$this->data['text_help_innodb'] = $this->language->get('text_help_innodb');
		$this->data['text_help_myisam'] = $this->language->get('text_help_myisam');

		$this->data['button_optimize'] = $this->language->get('button_optimize');
		$this->data['button_repair'] = $this->language->get('button_repair');
		$this->data['button_innodb'] = $this->language->get('button_innodb');
		$this->data['button_myisam'] = $this->language->get('button_myisam');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->session->data['success_optimize'])) {
			$this->data['success_optimize'] = $this->session->data['success_optimize'];

			unset($this->session->data['success_optimize']);
		} else {
			$this->data['success_optimize'] = '';
		}

		if (isset($this->session->data['success_repair'])) {
			$this->data['success_repair'] = $this->session->data['success_repair'];

			unset($this->session->data['success_repair']);
		} else {
			$this->data['success_repair'] = '';
		}

		if (isset($this->session->data['success_innodb'])) {
			$this->data['success_innodb'] = $this->session->data['success_innodb'];

			unset($this->session->data['success_innodb']);
		} else {
			$this->data['success_innodb'] = '';
		}

		if (isset($this->session->data['success_myisam'])) {
			$this->data['success_myisam'] = $this->session->data['success_myisam'];

			unset($this->session->data['success_myisam']);
		} else {
			$this->data['success_myisam'] = '';
		}

		if (isset($this->session->data['output'])) {
			$this->data['output'] = $this->session->data['output'];

			unset($this->session->data['output']);
		} else {
			$this->data['output'] = '';
		}

		$this->template = 'tool/database.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	// Optimise
	public function optimize() {
		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/database');

		$this->session->data['output'] = $this->model_tool_database->tableOptimize();

		$this->session->data['success_optimize'] = $this->language->get('text_success_optimize');

		$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}

	// Repair
	public function repair() {
		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/database');

		$this->session->data['output'] = $this->model_tool_database->tableRepair();

		$this->session->data['success_repair'] = $this->language->get('text_success_repair');

		$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}

	// InnoDB
	public function innodb() {
		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/database');

		$this->session->data['output'] = $this->model_tool_database->engineInnoDB();

		$this->session->data['success_innodb'] = $this->language->get('text_success_innodb');

		$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}

	// MyISAM
	public function myisam() {
		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/database');

		$this->session->data['output'] = $this->model_tool_database->engineMyISAM();

		$this->session->data['success_myisam'] = $this->language->get('text_success_myisam');

		$this->redirect($this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'tool/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
