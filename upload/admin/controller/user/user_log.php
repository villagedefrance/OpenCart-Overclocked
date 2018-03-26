<?php
class ControllerUserUserLog extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('user/user_log');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user_log');

		$this->getForm();
	}

	public function settings() {
		$this->language->load('user/user_log');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user_log');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSettings()) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('user_log', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_settings');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('user/user_log', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function clear() {
		$this->language->load('user/user_log');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user_log');

		if (isset($this->request->post['selected']) && $this->validateClear()) {
			foreach ($this->request->post['selected'] as $log_id) {
				$this->model_user_user_log->deleteEntry($log_id);
			}

			$this->model_user_user_log->deleteEntryLog($this->user->getId(), $this->user->getUserName(), count($this->request->post['selected']));

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('user/user_log', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function erase() {
		$this->language->load('user/user_log');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user_log');

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token']) && $this->validateClear()) {
			$this->model_user_user_log->clearDataLog($this->user->getId(), $this->user->getUserName());

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('user/user_log', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	protected function getForm() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('user/user_log', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['entries'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('user_log_display'),
			'limit' => $this->config->get('user_log_display')
		);

		$entries_total = $this->model_user_user_log->getTotalDataLog($data);

		$entries = $this->model_user_user_log->getDataLog($data);

		foreach ($entries as $entry) {
			$entry_url = preg_replace("/&token=[a-z0-9]+/", "", htmlspecialchars_decode($entry['url']));

			$this->data['entries'][] = array(
				'log_id'       => $entry['log_id'],
				'user'         => $this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $entry['user_id'], 'SSL'),
				'username'     => $entry['username'],
				'action'       => $entry['action'],
				'allowed'      => $entry['allowed'],
				'url_link'     => $entry_url . '&token=' . $this->session->data['token'],
				'url'          => $entry_url,
				'ip'           => $entry['ip'],
				'date'         => date('d.m.Y H:i:s', strtotime($entry['date'])),
				'selected'     => isset($this->request->post['selected']) && in_array($entry['log_id'], $this->request->post['selected'])
			);
		}

		$this->data['heading_total'] = ' (' . $entries_total . ')';

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_help'] = $this->language->get('heading_help');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_description'] = $this->language->get('text_description');

		$this->data['tab_log'] = $this->language->get('tab_log');
		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_help'] = $this->language->get('tab_help');

		$this->data['column_user'] = $this->language->get('column_user');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_allowed'] = $this->language->get('column_allowed');
		$this->data['column_url'] = $this->language->get('column_url');
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_date'] = $this->language->get('column_date');

		$this->data['button_settings'] = $this->language->get('button_settings');
		$this->data['button_erase'] = $this->language->get('button_erase');
		$this->data['button_clear'] = $this->language->get('button_clear');
		$this->data['button_close'] = $this->language->get('button_close');

		$this->data['close'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['settings'] = $this->url->link('user/user_log/settings', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['erase'] = $this->url->link('user/user_log/erase', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['clear'] = $this->url->link('user/user_log/clear', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['action'] = $this->url->link('user/user_log', 'token=' . $this->session->data['token'] . $url, 'SSL');

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

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$pagination = new Pagination();
		$pagination->total = $entries_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('user_log_display');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('user/user_log', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		// Settings
		$this->data['entry_user_log_enable'] = $this->language->get('entry_user_log_enable');
		$this->data['entry_user_log_login'] = $this->language->get('entry_user_log_login');
		$this->data['entry_user_log_logout'] = $this->language->get('entry_user_log_logout');
		$this->data['entry_user_log_hacklog'] = $this->language->get('entry_user_log_hacklog');
		$this->data['entry_user_log_access'] = $this->language->get('entry_user_log_access');
		$this->data['entry_user_log_modify'] = $this->language->get('entry_user_log_modify');
		$this->data['entry_user_log_allowed'] = $this->language->get('entry_user_log_allowed');
		$this->data['entry_user_log_display'] = $this->language->get('entry_user_log_display');

		$this->data['help_user_log_enable'] = $this->language->get('help_user_log_enable');
		$this->data['help_user_log_hacklog'] = $this->language->get('help_user_log_hacklog');
		$this->data['help_user_log_access'] = $this->language->get('help_user_log_access');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['text_denied'] = $this->language->get('text_denied');
		$this->data['text_allowed'] = $this->language->get('text_allowed');
		$this->data['text_all'] = $this->language->get('text_all');

		if (isset($this->request->post['user_log_enable'])) {
			$this->data['user_log_enable'] = $this->request->post['user_log_enable'];
		} elseif ($this->config->get('user_log_enable')) {
			$this->data['user_log_enable'] = $this->config->get('user_log_enable');
		} else {
			$this->data['user_log_enable'] = 0;
		}

		if (isset($this->request->post['user_log_login'])) {
			$this->data['user_log_login'] = $this->request->post['user_log_login'];
		} elseif ($this->config->get('user_log_login')) {
			$this->data['user_log_login'] = $this->config->get('user_log_login');
		} else {
			$this->data['user_log_login'] = 0;
		}

		if (isset($this->request->post['user_log_logout'])) {
			$this->data['user_log_logout'] = $this->request->post['user_log_logout'];
		} elseif ($this->config->get('user_log_logout')) {
			$this->data['user_log_logout'] = $this->config->get('user_log_logout');
		} else {
			$this->data['user_log_logout'] = 0;
		}

		if (isset($this->request->post['user_log_hacklog'])) {
			$this->data['user_log_hacklog'] = $this->request->post['user_log_hacklog'];
		} elseif ($this->config->get('user_log_hacklog')) {
			$this->data['user_log_hacklog'] = $this->config->get('user_log_hacklog');
		} else {
			$this->data['user_log_hacklog'] = 0;
		}

		if (isset($this->request->post['user_log_access'])) {
			$this->data['user_log_access'] = $this->request->post['user_log_access'];
		} elseif ($this->config->get('user_log_access')) {
			$this->data['user_log_access'] = $this->config->get('user_log_access');
		} else {
			$this->data['user_log_access'] = 0;
		}

		if (isset($this->request->post['user_log_modify'])) {
			$this->data['user_log_modify'] = $this->request->post['user_log_modify'];
		} elseif ($this->config->get('user_log_modify')) {
			$this->data['user_log_modify'] = $this->config->get('user_log_modify');
		} else {
			$this->data['user_log_modify'] = 0;
		}

		if (isset($this->request->post['user_log_allowed'])) {
			$this->data['user_log_allowed'] = $this->request->post['user_log_allowed'];
		} elseif ($this->config->get('user_log_allowed')) {
			$this->data['user_log_allowed'] = $this->config->get('user_log_allowed');
		} else {
			$this->data['user_log_allowed'] = 0;
		}

		if (isset($this->request->post['user_log_display'])) {
			$this->data['user_log_display'] = $this->request->post['user_log_display'];
		} elseif ($this->config->get('user_log_display')) {
			$this->data['user_log_display'] = $this->config->get('user_log_display');
		} else {
			$this->data['user_log_display'] = 50;
		}

		$this->template = 'user/user_log.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateClear() {
		if (!$this->user->hasPermission('modify', 'user/user_log')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	protected function validateSettings() {
		if (!$this->user->hasPermission('modify', 'user/user_log')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
